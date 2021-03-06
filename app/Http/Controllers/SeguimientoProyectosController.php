<?php

namespace App\Http\Controllers;

use App\Seguimiento_proyecto;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SeguimientoProyectosController extends Controller
{
    public function index()
    {
        $proyectos = Seguimiento_proyecto::with(['proyecto', 'Fase'])
            ->whereHas('proyecto', function ($q) {
                $q->where('proyecto.estado', 1);
            })
            ->orderBy('idseguimiento', 'DESC')
            ->get();
        $data = [
            'project_seguimientos' => $proyectos
        ];
        return view('seguimiento-proyectos', $data);
    }

    public function cargarSeguimientosFilter(Request $request)
    {
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        $fase = (int)$request->fase;
        $vs = (int)$request->vs;
        $vc = (int)$request->vc;

        $proyectos = $this->listFilter($fechaInicio, $fechaFin, $fase, $vc, $vs);

        ?>
        <script type="text/javascript" src="js/formato.js"></script>

        <table id="seguimientoTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th class="col-md-2">Código</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th class="col-md-3">Nombre del Proyecto</th>
                <th>Fecha Último Seguimiento</th>
                <th>VC</th>
                <th>IDC</th>
                <th>VS</th>
                <th>IDS</th>
                <th>Estado</th>
                <th>Opción</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($proyectos as $value) {
                ?>
                <tr>
                    <td><?php echo $value->proyecto->code; ?></td>
                    <td><?php echo $value->proyecto->finicio; ?></td>
                    <td><?php echo $value->proyecto->fentrega; ?></td>
                    <td><?php echo $value->proyecto->nombre; ?></td>
                    <td><?php echo $value->fecha_seguimiento; ?></td>
                    <?php if (!is_null($value->vc) && !empty($value->vc)) { ?>
                        <td class="text-center"><?php echo ($value->vc >= 0) ? '+' : '-'; ?></td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo '' ?></td>
                    <?php } ?>
                    <?php if (!is_null($value->idc) && !empty($value->idc)) { ?>
                        <td class="text-center"><?php echo ($value->idc > 1) ? '>1' : '<1'; ?></td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo '' ?></td>
                    <?php } ?>
                    <?php if (!is_null($value->vs) && !empty($value->vs)) { ?>
                        <td class="text-center"><?php echo ($value->vs >= 0) ? '+' : '-'; ?></td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo '' ?></td>
                    <?php } ?>
                    <?php if (!is_null($value->ids) && !empty($value->ids)) { ?>
                        <td class="text-center"><?php echo ($value->ids > 1) ? '>1' : '<1'; ?></td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo '' ?></td>
                    <?php } ?>
                    <td class="text-center">
                        <?php if ($value->vs< 0) { ?>
                            <i class="fa fa-frown-o" style="color: red; font-size: 35px;"></i>
                        <?php } else if ($value->vs > 0) { ?>
                            <i class="fa fa-smile-o" style="color: green; font-size: 35px;"></i>
                        <?php } else { ?>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?php if (is_null($value->fecha_seguimiento)) { ?>
                            <a class="btn btn-default" href="/seguimiento-proyectos/<?php echo $value->idseguimiento; ?>">Iniciar</a>
                        <?php } else { ?>
                            <a href="/seguimiento-proyectos/<?php echo $value->idseguimiento;?>" class="btn btn-default">Actualizar</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
<?php
    }

    public function listFilter($fechaInicio, $fechaFin, $fase, $vc = null, $vs = null) {
        $proyecto = Seguimiento_proyecto::with(['proyecto', 'Fase'])
            ->whereHas('proyecto', function ($q) use ($fechaInicio, $fechaFin, $vs, $vc) {
                $q->where('proyecto.estado', '=', 1);

                if ($fechaInicio != '' && $fechaFin != '') {
                        $q->whereBetween('fecha', [$fechaInicio . ' 00:00:00', $fechaFin . '23:59:59']);
                }
            })
            ->where('seguimiento_proyecto.estado', '=', '1')
            ->where('idfase', '=', $fase);
        if (!is_null($vs)) {
            if ($vs == 0) {
                $proyecto->where('seguimiento_proyecto.vs', '>', '0');
            } else if ($vs == 1) {
                $proyecto->where('seguimiento_proyecto.vs', '<', '0');
            }
        }

        if (!is_null($vc)) {
            if ($vc == 0) {
                $proyecto->where('seguimiento_proyecto.vc', '>', '0');
            } else if ($vc == 1) {
                $proyecto->where('seguimiento_proyecto.vc', '<', '0');
            }
        }
        $proyecto = $proyecto->orderBy('idseguimiento', 'DESC')
                    ->get();
        return $proyecto;
    }
}
