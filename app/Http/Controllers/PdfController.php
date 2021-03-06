<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use File;
use App\Proyecto;
use App\Area;
use DB;
use Auth;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function NumProyectos()
    {
        $proyectos = DB::table('proyecto')->where('estado',1)->count();
        return $proyectos;
    }
    public function AgregarReporte()
    {
        session_start();
        $pro=DB::table('reporte_total')->insert(['usuario' => $_SESSION["usuario"] ]);
        $proyec=DB::table('reporte_total')->select('idreporte')->orderBy('idreporte','desc')->first();
        return $proyec->idreporte;
    }


    public function PDF()
    {
      $usuario=Auth::user()->usuario;
      $objComite=new Comite_controller();
      $DataUsuario=$objComite->CargarUsuario($usuario);
      $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="reportes") {

            $lista=Proyecto::select('trabajador.idarea as idarea','trabajador.abreviatura as Abreviatura','acta_inicio.carpeta AS carpeta','persona.nombre AS Cliente','tipoproyecto.nombre AS Tipo_Proyecto','proyecto.nombreclave','proyecto.nombre AS Nombre_Proyecto','servicio.nombre AS servicio','proyecto.finicio','proyecto.fentrega','cronograma.por_planificado AS Planificado','cronograma.por_anterior AS Req_14','cronograma.por_actual AS Req_15','estado_cronograma.descripcion AS Estado')
            ->leftjoin('persona','persona.idpersona','=','proyecto.idcliente')
            ->leftjoin('tipoproyecto','tipoproyecto.idtipoproyecto','=','proyecto.idtipoproyecto')
            ->leftjoin('servicio','servicio.idservicio','=','proyecto.idservicio')
            ->leftjoin('cronograma','cronograma.idproyecto','=','proyecto.idproyecto')
            ->leftjoin('estado_cronograma','estado_cronograma.idestado_cro','=','cronograma.idestado_cro')
            ->leftjoin('acta_inicio','acta_inicio.idproyecto','=','proyecto.idproyecto')
            ->leftjoin('trabajador','trabajador.idpersona','=','proyecto.gerente')

            ->where('proyecto.estado','=','1')->distinct()->get();


            $areas=Area::select('idarea','nombre')->where('estado','=',1)->get();

    $reporte=$this->AgregarReporte();
    $html='<html>';
    $html.='<title>Cuadro de control de proyectos</title>';
    $html.='<style type="text/css">
                                table{border-top:1px solid black;font-size:10px;}
                                tr td{border-bottom:1px solid black;
                                    border-left:1px solid black;}
                                tr td:last-child{
                                    border-right:1px solid black;}
                                .red{background:#974706;color:#FFF;}
                                .mostaza{background:#948A54;color:#FFF;}
                                .mayor{background:#FCD5B4;}
                                .menor{background:#B1A0C7;}
                                .mediano{background:#B7DEE8;}
                            </style>';
    $html.='<table style="text-align:center;">';
    $html.='<tr>';
    $html.='<td colspan="4"><img src="logo.png" border="0" height="50" width="140" align="middle" /></td>';
    $html.='<td colspan="8"><center> <strong> CUADRO DE CONTROL DE PROYECTOS</strong> </center></td>';
    $html.='<td colspan="3" align="left">Codigo: EJE-FOR-07<br>Versión:02<br>Fecha:12/06/2015</td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<td colspan="2">Gerencia:</td>';
    $html.='<td colspan="2">Gerencia de Calidad </td>';
    $html.='<td colspan="2">Elaborado por:</td>';
    $html.='<td colspan="2">Grace Mejia</td>';
    $html.='<td>Cargo :</td>';
    $html.='<td colspan="2">Coordinador de calidad</td>';
    $html.='<td colspan="2">N° Reporte:</td>';
    $html.='<td colspan="2">'.$reporte.'-20'.date('y').'</td>';
    $html.='</tr>';
    $numproyecto=$this->NumProyectos();
    $html.='<tr>';
    $html.='<td colspan="2">Proyectos:</td>';
    $html.='<td colspan="2">'.$numproyecto.'</td>';
    $html.='<td colspan="2">Revisado por:</td>';
    $html.='<td colspan="2">Pamela Pino</td>';
    $html.='<td>Cargo:</td>';
    $html.='<td colspan="2">Gerente de Calidad</td>';
    $html.='<td colspan="2">Fecha de Analisis:</td>';
    $html.='<td colspan="2">'.date("d/m/y").'</td>';
    $html.='</tr>';

    $html.='<tr>';
    $html.='<td colspan="15" class="red">Control y Seguimiento</td>';
    $html.='</tr>';

    $html.='<tr class="mostaza">';
    $html.='<td>Ítem</td>';
    $html.='<td>Nombre de <br> Carpeta</td>';
    $html.='<td>Cliente</td>';
    $html.='<td>Gerente/<br>Jefe de Proyecto</td>';
    $html.='<td>Tipo de <br>Proyecto</td>';
    $html.='<td>Nombre clave de<br>Proyecto</td>';
    $html.='<td>Nombre de Proyecto</td>';
    $html.='<td>Servicio</td>';
    $html.='<td>Fecha Inicio</td>';
    $html.='<td>Fecha Fin Proyecto</td>';
    $html.='<td>% Avance <br>Planificado</td>';
    $html.='<td>% Avance <br>Rep 14</td>';
    $html.='<td>% Avance <br>Rep 15</td>';
    $html.='<td colspan="2">Estado</td>';
    $html.='</tr>';
    $i=1;



    foreach ($areas as $fila) {
        $area=1;
        foreach ($lista as $row) {

            if ($fila->idarea==$row->idarea) {

                if ($area==1) {
                    $html.='<tr>';
                    $html.='<td colspan="15" class="mostaza">'.$fila->nombre.'</td>';
                    $html.='</tr>';
                    $area++;
                }
                $dateInicio=date_create($row->finicio);
                $dateFin=date_create($row->fentrega);
                $html.='<tr>';
                $html.='<td>'.$i.'</td>';$i++;
                $html.='<td>'.$row->carpeta.'</td>';
                $html.='<td>'.$row->Cliente.'</td>';
                $html.='<td>'.$row->Abreviatura.'</td>';
                    if ($row->Tipo_Proyecto=="Mayor") {
                        $html.='<td class="mayor">';
                    }elseif ($row->Tipo_Proyecto=="Menor") {
                        $html.='<td class="menor">';
                    }else{
                        $html.='<td class="mediano">';
                    }
                $html.=$row->Tipo_Proyecto.'</td>';
                $html.='<td>'.$row->nombreclave.'</td>';
                $html.='<td>'.$row->Nombre_Proyecto.'</td>';
                $html.='<td>'.$row->servicio.'</td>';
                $html.='<td>'.date_format($dateInicio,'d/m/y').'</td>';
                $html.='<td>'.date_format($dateFin,'d/m/y').'</td>';
                $html.='<td>'.$row->Planificado.'</td>';
                $html.='<td>'.$row->Req_14.'</td>';
                $html.='<td>'.$row->Req_15.'</td>';
                $html.='<td>'.$row->Estado.'</td>';
                    switch ($row->Estado) {
                            case "Aun no inicia":
                            $html.='<td> <img src="images/semaforo-rojo.png"> </td>';
                            break;
                            case "Adelantado":
                            $html.='<td> <img src="images/semaforo-verde.png"> </td>';
                            break;
                            case "A tiempo":
                            $html.='<td> <img src="images/semaforo-verde.png"> </td>';
                            break;
                            case "Demorado":
                            $html.='<td> <img src="images/semaforo-amarillo.png"> </td>';
                            break;
                            case "No presento Avance":
                            $html.='<td> <img src="images/semaforo-amarillo.png"> </td>';
                            break;
                            case "Terminados":
                            $html.='<td> <img src="images/semaforo-verde.png"> </td>';
                            break;
                            case "Terminados C/R":
                            $html.='<td> <img src="images/semaforo-rojo.png"> </td>';
                            break;
                            case "Stand By":
                            $html.='<td> <img src="images/semaforo-amarillo.png"> </td>';
                            break;
                            case "Outsourcing":
                            $html.='<td> <img src="images/semaforo-verde.png"> </td>';
                            break;

                            default:
                            $html.='<td></td>';


                    }

                $html.='</tr>';
            }

            }

    }

    $html.='</table>';
    $html.='<br>';
    $html.='<table>';
    foreach ($areas as $fila) {
        $area=1;
        $idarea=0;
        $aunnoinicia=0;
        $Adelantado=0;
        $atiempo=0;
        $demorado=0;
        $noavance=0;
        $Terminados=0;
        $terminadocr=0;
        $stand=0;
        $outsourcing=0;
        $nomarea="";
        foreach ($lista as $row) {

            if ($fila->idarea==$row->idarea) {

                if ($area==1) {
                    $idarea=$row->idarea;
                    $nomarea=$fila->nombre;
                    $area++;
                }
                    switch ($row->Estado) {
                            case "Aun no inicia":
                            $aunnoinicia++;
                            break;
                            case "Adelantado":
                            $Adelantado++;
                            break;
                            case "A tiempo":
                            $atiempo++;
                            break;
                            case "Demorado":
                            $demorado++;
                            break;
                            case "No presento Avance":
                            $noavance++;
                            break;
                            case "Terminados":
                            $Terminados++;
                            break;
                            case "Terminados C/R":
                            $terminadocr++;
                            break;
                            case "Stand By":
                            $stand++;
                            break;
                            case "Outsourcing":
                            $outsourcing++;
                            break;


                    }

            }

            }

            if ($fila->idarea==$idarea) {

                $graph = new Graph\PieGraph(500,500);
                $graph->SetShadow();
                $labels = array();
                $data = array();
                if ($aunnoinicia>0) {
                    $arrayaunnoinicialab=array("Aun no Inicia\n(%.1f%%)");
                    $labels=array_merge($labels,$arrayaunnoinicialab);

                    $arrayaunnoinicia=array($aunnoinicia);
                    $data=array_merge($data,$arrayaunnoinicia);
                }
                if ($Adelantado>0) {
                   $arrayadelantadolab=array("Adelantado\n(%.1f%%)");
                   $labels=array_merge($labels,$arrayadelantadolab);

                   $arrayadelantado=array($Adelantado);
                   $data=array_merge($data,$arrayadelantado);
                }
                if ($demorado>0) {
                    $arraydemoradolab=array("Demorado\n(%.1f%%)");
                    $labels=array_merge($labels,$arraydemoradolab);

                    $arraydemorado=array($demorado);
                    $data=array_merge($data,$arraydemorado);
                }
                if ($atiempo>0) {
                    $arrayatiempolab=array("A tiempo\n(%.1f%%)");
                    $labels=array_merge($labels,$arrayatiempolab);

                    $arrayatiempo=array($atiempo);
                    $data=array_merge($data,$arrayatiempo);
                }
                if ($noavance>0) {
                    $arraynoavancelab=array("No presento Avance\n(%.1f%%)");
                    $labels=array_merge($labels,$arraynoavancelab);

                    $arraynoavance=array($noavance);
                    $data=array_merge($data,$arraynoavance);
                }
                if ($Terminados>0) {
                    $arrayterminadoslab=array("Terminados\n(%.1f%%)");
                    $labels=array_merge($labels,$arrayterminadoslab);

                    $arrayterminados=array($Terminados);
                    $data=array_merge($data,$arrayterminados);
                }
                if ($terminadocr>0) {
                    $arrayterminadocrlab=array("Terminados C/R\n(%.1f%%)");
                    $labels=array_merge($labels,$arrayterminadocrlab);

                    $arrayterminadocr=array($terminadocr);
                    $data=array_merge($data,$arrayterminadocr);
                }
                if ($stand>0) {
                    $arraystandlab=array("Stand By\n(%.1f%%)");
                    $labels=array_merge($labels,$arraystandlab);

                    $arraystand=array($stand);
                    $data=array_merge($data,$arraystand);
                }
                if ($outsourcing>0) {
                    $arrayoutsourcinglab=array("Outsourcing\n(%.1f%%)");
                    $labels=array_merge($labels,$arrayoutsourcinglab);

                    $arrayoutsourcing=array($outsourcing);
                    $data=array_merge($data,$arrayoutsourcing);
                }


                // Title setup
                // Test 26-06-2018
                //$graph->title->Set($nomarea);
                //$graph->title->SetFont(FF_FONT1,FS_BOLD);

                // $p1 = new Plot\PiePlot($data);
                // $p1->SetSize(0.40);
                // $p1->SetCenter(0.5,0.52);
                // $p1->SetLabels($labels);

                // Setup slice labels and move them into the plot
                // $p1->value->SetFont(FF_FONT1,FS_BOLD);
                // $p1->value->SetColor("darkred");
                // $p1->SetLabelPos(0.65);
                // Explode all slices
                // $p1->ExplodeAll(15);

                // Add drop shadow
                // $p1->SetShadow();

                // Finally add the plot
                // $graph->Add($p1);
                // $grafica =$nomarea.'torta'.date('y-m-d--Hh-mm-ss').'.jpg';
                //if($grafica === 'GERENCIA DE CALIDADtorta18-06-27--0012-0606-3636.jpg'){
                    // dd($grafica);
                //}
                // $graph->Stroke($grafica);
                ////////////////////////////BAR PLOT ////////////////////////////////////////////////////////////////

                // $graph1 = new Graph\Graph(800,400);
                // $graph1->SetShadow();
                // $graph1->SetScale("textlin");

                // $datax=array("Aun no Inicia","Adelantado","A tiempo",     "Demorado","No presento Avance","Terminados","Terminados C/R","Stand By","Outsourcing");
                // $graph1->xaxis->SetTickLabels($datax);
                // Title setup

                // $graph1->title->SetFont(FF_FONT1,FS_BOLD);

                // $databary=$data;
                // $b11 = new Plot\BarPlot($databary);
                // $b11->SetLegend($nomarea);
                // $graph1->Add($b11);
                // $grafica1 = $nomarea.'barra'.date('y-m-d-Hh-mm-ss').'.jpg';
                // Finally output the  image
                // $graph1->Stroke($grafica1);

                // $html .= '<tr>
                // <td colspan="1" style="text-align:center;"><img src="'.$grafica.'" border="0" height="250" width="350" align="middle" /></td>
                // <td colspan="1" style="text-align:center;"><img src="'.$grafica1.'" border="0" height="250" width="350" align="middle" /></td>
                // </tr>';
            }

    }

            $html.='</table>';
            $pdf = \App::make('dompdf.wrapper');
            $pdf->setPaper('A3','portrait');
            $pdf->loadHTML($html);
            return @$pdf->stream('invoice');
        }
      }
      ?>
      <script type="text/javascript">
      alert("Usted no Tiene permitido el acceso a este modulo");
      window.location.href='/inicio';
      </script>
      <?php



    }
}
