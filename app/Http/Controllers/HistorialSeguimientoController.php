<?php

namespace App\Http\Controllers;

use App\Cronograma;
use App\HistorialSeguimiento;
use App\Proyecto;
use App\Seguimiento_proyecto;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HistorialSeguimientoController extends Controller
{
    const URL = "documentos/historiales";
    const VP_URL = "documentos/cronogramas";

    public function listar(Request $request, $id)
    {
        $seguimiento = Seguimiento_proyecto::where('idseguimiento', $id)->first();
        $proyecto = $seguimiento->proyecto;
        $lastCronograma = Cronograma::where('idproyecto', $proyecto->idproyecto)->orderBy('fecha_registro', 'DESC')->first();
        $historialSeguimientos = HistorialSeguimiento::where('id_seguimiento', $seguimiento->idseguimiento)->get();
        $data = [
            'id' => $id,
            'ult_int' => $seguimiento->ultimo_int,
            'project_code' => $proyecto->code,
            'project_presupuesto' => $proyecto->presupuesto,
            'project_fecha_inicio' => $proyecto->finicio,
            'project_fecha_fin' => $proyecto->fentrega,
            'project_intervalos' => $lastCronograma->nro_intervalos,
            'project_nro_tareas' => $lastCronograma->nro_tareas,
            'project_historial' => $historialSeguimientos
        ];

        return view('historial_seguimiento', $data);
    }

    public function cargarAjax(Request $request, $id)
    {
        $historial = HistorialSeguimiento::find($id);
        $response['comentario'] = $historial->comentario;
        return new JsonResponse(['data' => $response], 200);
    }

    public function guardarHistorial(Request $request, $id)
    {
        $iteracion = $request->iteracion;
        $comentario = $request->comentario;
        $fileCostos = $_FILES['file_costos']['name'];
        $nombre = basename($fileCostos);
        $archivo = $iteracion . '_' . $nombre;
        $historial = HistorialSeguimiento::find($id);
        $historial->comentario = $comentario;
        $historial->costo_avance = $archivo;
        $historial->estado = "Hecho";
        $proyectoNombre = $historial->seguimiento->proyecto->nombreclave;

        if (!empty($fileCostos)) {
            if (!file_exists(self::URL . "/" . $proyectoNombre . "/")) {
                mkdir(self::URL . "/" . $proyectoNombre . "/");
            }
            copy($_FILES['file_costos']['tmp_name'], self::URL . "/" . $proyectoNombre . "/". $archivo);
        }

        $vpArchivo = ($historial->seguimiento->proyecto->cronograma->first())->vp_archivo;
        $vp = $this->getVPData($vpArchivo);
        $costos_avance = $this->getCRData($proyectoNombre, $archivo);
        $result = $this->calculateValues($vp, $costos_avance[0], $costos_avance[1], $iteracion);

        $historial->vc = $result['vc'];
        $historial->vs = $result['vs'];
        $historial->idc = $result['idc'];
        $historial->ids = $result['ids'];
        $historial->p_vc = $result['p_vc'];
        $historial->p_vs = $result['p_vs'];
        $historial->ev = $result['ev'];
        $historial->ac = $result['ac'];
        $historial->pv = $result['pv'];
        $historial->save();

        $seguimiento = $historial->seguimiento;
        $seguimiento->vs = $result['vs'];
        $seguimiento->vc = $result['vc'];
        $seguimiento->idc = $result['idc'];
        $seguimiento->ids = $result['ids'];
        $seguimiento->ultimo_int = $iteracion;
        $seguimiento->p_vc = $result['p_vc'];
        $seguimiento->p_vs = $result['p_vs'];
        $seguimiento->fecha_seguimiento = Carbon::now();
        $seguimiento->pv_total = implode(',', $result['total_pv']);
        $seguimiento->save();
        return new JsonResponse(['status' => 'OK', 'response' => $result], 200);
    }

    private function calculateValues(array $vp, array $costo, array $avance, $iteracion) {
        $pvAcumulado = $this->calculatePvAcumulado($vp);
        $acAcumulado = $this->calculateAcAcumulado($costo);
        $evAcumulado = $this->calculateEvAcumulado($vp, $avance);

        $indice = $iteracion - 1;
        $response['vc'] = $evAcumulado[$indice] - $acAcumulado[$indice];
        if (empty($evAcumulado[$indice])) {
            $response['p_vc'] = 99.99;
        } else {
            $response['p_vc'] = round((($response['vc'] * 1.0) / ($evAcumulado[$indice] * 1.0)) * 100, 2);
        }

        if (empty($acAcumulado[$indice])) {
            $response['idc'] = 99.99;
        } else {
            $response['idc'] = round(($evAcumulado[$indice] * 1.0) / ($acAcumulado[$indice] * 1.0), 2);
        }

        $response['vs'] = $evAcumulado[$indice] - $pvAcumulado[$indice];

        if (empty($pvAcumulado[$indice])) {
            $response['p_vs'] = 99.99;
        } else {
            $response['p_vs'] = round((($response['vs'] * 1.0) / ($pvAcumulado[$indice] * 1.0)) * 100, 2);
        }

        if (empty($pvAcumulado[$indice])) {
            $response['ids'] = 99.99;
        } else {
            $response['ids'] = round(($evAcumulado[$indice] * 1.0) / ($pvAcumulado[$indice] * 1.0), 2);
        }

        $response['ev'] = $evAcumulado[$indice];
        $response['ac'] = $acAcumulado[$indice];
        $response['pv'] = $pvAcumulado[$indice];
        $response['total_pv'] = $pvAcumulado;

        return $response;
    }

    private function getCRData($proyectoNombre, $nombreArchivo) {
        $tmpCosto = [];
        $tmpAvance = [];
        $excel = self::URL . "/" . $proyectoNombre . "/" . $nombreArchivo;
        $file = IOFactory::load($excel);
        $totalHojas = $file->getSheetCount();

        for ($hoja = 0; $hoja < $totalHojas; $hoja++) {
            $currentHoja = $file->getSheet($hoja);

            $maxRow = $currentHoja->getHighestRow();
            $maxColumn = $currentHoja->getHighestColumn();
            $maxColumn = Coordinate::columnIndexFromString($maxColumn);

            for ($fila = 2; $fila <= $maxRow; $fila++) {
                // Resta de 1 para ignorar columna "Total"
                for ($columna = 3; $columna <= $maxColumn - 1; $columna++) {
                    $cell = !empty($currentHoja->getCellByColumnAndRow($columna, $fila)->getValue()) ? $currentHoja->getCellByColumnAndRow($columna, $fila)->getValue(): 0;
                    if ($hoja == 0) {
                        $tmpCosto[$fila - 2][$columna - 3] = $cell;
                    } else {
                        $tmpAvance[$fila - 2][$columna - 3] = $cell;
                    }
                }
            }
        }
        $response[0] = $tmpCosto;
        $response[1] = $tmpAvance;
        return $response;
    }

    private function getVPData($nombreArchivo) {
        $tmpArray = [];
        $excel = self::VP_URL . "/" . $nombreArchivo;
        $file = IOFactory::load($excel);
        $hojaVP = $file->getSheet(0);
        $maxRow = $hojaVP->getHighestRow();
        $maxColumn = $hojaVP->getHighestColumn();
        $maxColumn = Coordinate::columnIndexFromString($maxColumn);

        for ($fila = 2; $fila <= $maxRow; $fila++) {
            // -1 Para ignorar la columna "Total"
            for ($columna = 3; $columna <= $maxColumn - 1; $columna++) {
                $cell = !empty($hojaVP->getCellByColumnAndRow($columna, $fila)->getValue()) ? $hojaVP->getCellByColumnAndRow($columna, $fila)->getValue() : 0;
                $tmpArray[$fila - 2][$columna - 3] = $cell;
            }
        }
        return $tmpArray;
    }

    private function calculatePvAcumulado(array $vp) {
        $pvAcumulado = [];
        $sumTotal = 0;
        $vpColumn = count($vp[0]);
        // Columns | Se coloca - 1 para ignorar la columna "Total"
        for ($column = 0; $column < $vpColumn; $column++) {
            $total = array_sum(array_map(function ($item) use ($column) {
                return $item[$column];
            }, $vp));
            $sumTotal += $total;
            $pvAcumulado[] = $sumTotal;
        }
        return $pvAcumulado;
    }

    private function calculateEvAcumulado(array $vp, array $avance) {
        $rows = count($vp);
        $columns = count($vp[0]);
        $totalValues = [];
        $tmpArray = [];
        $evAcumulado = [];
        $sumTotal = 0;

        for ($i = 0; $i < $rows; $i++) {
            $totalValues[] = array_sum($vp[$i]);
        }

        for ($row = 0; $row <  $rows; $row++) {
            for ($column = 0; $column < $columns; $column++) {
                $tmpArray[$row][$column] = $totalValues[$row] * $avance[$row][$column];
            }
        }

        for ($column = 0; $column < $columns; $column++) {
            $total = array_sum(array_map(function ($item) use ($column) {
                return $item[$column];
            }, $tmpArray));
            $sumTotal += $total;
            $evAcumulado[] = !empty($total) ? $sumTotal : 0;
        }
        return $evAcumulado;
    }

    private function calculateAcAcumulado(array $costo) {
        $acAcumulado = [];
        $sumTotal = 0;
        $acColumn = count($costo[0]);
        for ($column = 0; $column < $acColumn; $column++) {
            $total = array_sum(array_map(function ($item) use ($column) {
                return $item[$column];
            }, $costo));
            $sumTotal += $total;
            $acAcumulado[] = !empty($total) ? $sumTotal : 0;
        }
        return $acAcumulado;
    }

    private function getLastKey(array $ac) {
        $total = count($ac);
        for ($i = 1; $i < $total; $i++) {
            if (!empty($ac[$i-1]) && empty($ac[$i])) {
                return $i - 1;
            }
        }
        return null;
    }
}
