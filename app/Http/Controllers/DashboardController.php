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

        $ev = $ac = $pv = [];

        for ($k = 0; $k < $i; $k++) {
            $ev[] = $historiales[$k]->ev;
            $ac[] = $historiales[$k]->ac;
            $pv[] = $historiales[$k]->pv;
        }

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
            'array_ev' => implode(",", $ev)
        ];
        return view("dashboard", $data);
    }

    public function cargarAjax(Request $request, $nroSeguimiento, $intervalo)
    {
        $seguimiento = Seguimiento_proyecto::find($nroSeguimiento);
        $historiales = $seguimiento->historial;
        $historial = $historiales[$intervalo - 1];

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
            'tt_ids' => $tt_ids
        ];

        return new JsonResponse(['data' => $data], 200);
    }
}
