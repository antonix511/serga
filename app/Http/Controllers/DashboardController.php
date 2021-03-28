<?php

namespace App\Http\Controllers;

use App\Seguimiento_proyecto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request, $id)
    {
        $seguimiento = Seguimiento_proyecto::find($id);
        $codeProyecto = $seguimiento->proyecto->code;

        $historiales = $seguimiento->historial;
        $intervalos = count($historiales);

        $i = 0;
        foreach ($historiales as $historial) {
            $i++;
            if ($seguimiento->vc == $historial->vc && $seguimiento->vs == $historial->vs) {
                break;
            }
        }

        $historial = $historiales[$i - 1];
        $primerHistorial = $historiales[0];

        $pvTotal = explode(",", $seguimiento->pv_total);
        $mejorCaso = $historial->ac + (end($pvTotal) - $historial->ev);
        $varMejor = end($pvTotal) - $mejorCaso;

        $peorCaso = round($primerHistorial->ac + (((end($pvTotal) - $primerHistorial->ev) * 1.0) / (($historial->idc * $historial->ids) * 1.0)), 2);
        $varPeor = end($pvTotal) - $peorCaso;

        $mejorEsc = $mejorCaso - $historial->ac;
        $peorEsc = $peorCaso - $historial->ac;

        $ev = $ac = $pv = [];

        for ($k = 0; $k < $i; $k++) {
            $ev[] = $historiales[$k]->ev;
            $ac[] = $historiales[$k]->ac;
            $pv[] = $historiales[$k]->pv;
        }

        $tt_mejor_caso = 'Si se aprende de las lecciones aprendidas, el proyecto costará ' . $mejorCaso . ' Nuevos Soles';
        $tt_var_mejor = 'Se ha generado un ahorro de ' . $varMejor . ' Nuevos Soles';
        $tt_peor_caso = 'Si continuamos con los mismos errores, el proyecto costará ' . $peorCaso . ' Nuevos Soles';
        $tt_var_peor = 'Se ha generado un sobrecosto de ' . $varPeor . ' Nuevos Soles';

        $tt_mejor_esc = 'Al final del intervalo, será necesario un gasto de ' . $mejorEsc . ' Nuevos Soles para terminar el proyecto';
        $tt_peor_esc = 'Al finalizar la semana, será necesario un gasto de ' . $peorEsc . ' Nuevos Soles para terminar el proyecto';

        $data = [
            'code_proyecto' => $codeProyecto,
            'nro_seguimiento' => $id,
            'nro_iteracion' => $i,
            'vc' => $seguimiento->vc,
            'vs' => $seguimiento->vs,
            'p_vc' => $seguimiento->p_vc,
            'p_vs' => $seguimiento->p_vs,
            'idc' => $seguimiento->idc,
            'ids' => $seguimiento->ids,
            'intervalos' => $intervalos,
            'array_ac' => implode(",", $ac),
            'array_pv' => implode(",", $pv),
            'array_ev' => implode(",", $ev),
            'mejor_caso' => $mejorCaso,
            'var_mejor' => $varMejor,
            'peor_caso' => $peorCaso,
            'var_peor' => $varPeor,
            'mejor_esc' => $mejorEsc,
            'peor_esc' => $peorEsc,
            'tt_mejor_caso' => $tt_mejor_caso,
            'tt_var_mejor' => $tt_var_mejor,
            'tt_peor_caso' => $tt_peor_caso,
            'tt_var_peor' => $tt_var_peor,
            'tt_mejor_esc' => $tt_mejor_esc,
            'tt_peor_esc' => $tt_peor_esc
        ];
        return view("dashboard", $data);
    }

    public function cargarAjax(Request $request, $nroSeguimiento, $intervalo)
    {
        $seguimiento = Seguimiento_proyecto::find($nroSeguimiento);
        $historiales = $seguimiento->historial;
        $historial = $historiales[$intervalo - 1];
//        $primerHistorial = $historiales[0];
//
//        $pvTotal = explode(",", $seguimiento->pv_total);
//        $mejorCaso = $historial->ac + (end($pvTotal) - $historial->ev);
//        $varMejor = end($pvTotal) - $mejorCaso;
//
//        $peorCaso = round($primerHistorial->ac + (((end($pvTotal) - $primerHistorial->ev) * 1.0) / ($historial->idc * $historial->ids)), 2);
//        $varPeor = end($pvTotal) - $peorCaso;
//
//        $mejorEsc = $mejorCaso - $historial->ac;
//        $peorEsc = $peorCaso - $historial->ac;

        if ($historial->vc > 0) {
            $tt_vc = 'Estamos gastando menos de lo planificado! Estamos a un ' . $historial->p_vc . '% menos del presupuesto';
        } else if ($historial->vc < 0) {
            $tt_vc = 'Estamos gastando más de lo planificado! Estamos a un ' . $historial->p_vc . '% de exceso del presupuesto';
        } else {
            $tt_vc = 'Todo marcha segun lo planificado';
        }

        if ($historial->idc > 1) {
            $tt_idc = 'El rendimiento del costo ha sido mayor al planificado, por cada 1 sol gastado hemos ganado ' . $historial->idc . ' sol';
        } else if ($historial->idc < 1) {
            $tt_idc = 'El rendimiento del costo ha sido menor al planificado, por cada 1 sol gastado hemos ganado ' . $historial->idc . ' sol';
        } else {
            $tt_idc = 'El rendimiento del costo es igual al planificado';
        }

        if ($historial->vs > 0) {
            $tt_vs = 'Estamos adelantados un ' . $historial->p_vs . '% en el cronograma!';
        } else if ($historial->vs < 0) {
            $tt_vs = 'Estamos retrasados un ' . $historial->p_vs . '% en el cronograma!';
        } else {
            $tt_vs = 'Todo marcha como estaba planificado';
        }

        if ($historial->ids > 1) {
            $tt_ids = 'El rendimiento del cronograma ha sido mayor al planificado, por cada 1 sol gastado hemos trabajado ' . $historial->ids . ' sol';
        } else if ($historial->ids < 1) {
            $tt_ids = 'El rendimiento del cronograma ha sido menor al planificado, por cada 1 sol gastado hemos trabajado ' . $historial->ids . ' sol';
        } else {
            $tt_ids = 'Estamos avanzando según lo planificado';
        }

//        $tt_mejor_caso = 'Si se aprende de las lecciones aprendidas, el proyecto costará ' . $mejorCaso . ' Nuevos Soles';
//        $tt_var_mejor = 'Se ha generado un ahorro de ' . $varMejor . ' Nuevos Soles';
//        $tt_peor_caso = 'Si continuamos con los mismos errores, el proyecto costará ' . $peorCaso . ' Nuevos Soles';
//        $tt_var_peor = 'Se ha generado un sobrecosto de ' . $varPeor . ' Nuevos Soles';
//
//        $tt_mejor_esc = 'Al final del intervalo, será necesario un gasto de ' . $mejorEsc . ' Nuevos Soles para terminar el proyecto';
//        $tt_peor_esc = 'Al finalizar la semana, será necesario un gasto de ' . $peorEsc . ' Nuevos Soles para terminar el proyecto';

        $data = [
            'vc' => $historial->vc,
            'vs' => $historial->vs,
            'tt_vc' => $tt_vc,
            'tt_vs' => $tt_vs,
            'p_vc' => $historial->p_vc,
            'p_vs' => $historial->p_vs,
            'idc' => $historial->idc,
            'tt_idc' => $tt_idc,
            'ids' => $historial->ids,
            'tt_ids' => $tt_ids,
//            'mejor_caso' => $mejorCaso,
//            'var_mejor' => $varMejor,
//            'peor_caso' => $peorCaso,
//            'var_peor' => $varPeor,
//            'mejor_esc' => $mejorEsc,
//            'peor_esc' => $peorEsc,
//            'tt_mejor_caso' => $tt_mejor_caso,
//            'tt_var_mejor' => $tt_var_mejor,
//            'tt_peor_caso' => $tt_peor_caso,
//            'tt_var_peor' => $tt_var_peor,
//            'tt_mejor_esc' => $tt_mejor_esc,
//            'tt_peor_esc' => $tt_peor_esc
        ];

        return new JsonResponse(['data' => $data], 200);
    }
}
