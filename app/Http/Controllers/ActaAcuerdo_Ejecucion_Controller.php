<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Acta_acuerdo;
use App\Acta_acuerdo_detalle;
use Seguimiento_proyecto;
use App\Proyecto_doc_valida;

class ActaAcuerdo_Ejecucion_Controller extends Controller
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
        DB::beginTransaction();
        $acta=Acta_acuerdo::create($request->all());
        $acta->save();
        DB::commit();

        $verificar=$this->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }
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

    //INICIO


    public function VerificarDocumentos($id)
    {
                $objResProyecto= new ResumenProyecto_Controller();
                $actainicio=$objResProyecto->retornaActaInicioOK($id,1);
                $matrizcomu=$objResProyecto->retornaMatrizComuOK($id,2);
                $matrizrol=$objResProyecto->retornaMatrizRolOK($id,3);
                $reqlogist=$objResProyecto->retornaReqLogisOK($id,4);
                $reqcart=$objResProyecto->retornaReqCartOK($id,5);
                $matrizries=$objResProyecto->retornaMatrizRiesOK($id,15);

                $actareunion=$objResProyecto->retornaActaReuOK($id,6);
                $solcambio=$objResProyecto->retornaSolCambioOK($id,7);
                $actaacuerdo=$objResProyecto->retornaActaAcuerdoOK($id,8);
                $reportho=$objResProyecto->retornaReporteHoOK($id,9);
                $solac=$objResProyecto->retornaSolAcOK($id,9);

                $validar=$actainicio+$matrizcomu+$matrizrol+$reqlogist+$reqcart+$matrizries+$actareunion+$solcambio+$actaacuerdo+$reportho+$solac;
                if ($validar==11) {
                    return 1;
                }else{
                    return 0;
                }
    }




    public function retornarActaAcuerdo($idproyecto){
        $req=Acta_acuerdo::with(['documento'])->where('acta_acuerdo.idproyecto','=',$idproyecto)->where('estado','=',1)->orderby('idacta_acuerdo','desc')->first();
        return $req;
    }

    public function ultimo_id()
    {
        $ultimo_id = Acta_acuerdo::select('numero_acta')->where('estado','1')->orderby('idacta_acuerdo','desc')->first();

        return $ultimo_id->toJson();
    }
    public function ultimo_id_reu()
    {
        $ultimo_id = Acta_acuerdo::select('numero_acta')->where('estado','1')->where('idproyeccto','0')->orderby('idacta_acuerdo','desc')->first();

        return $ultimo_id->toJson();
    }

    public function eliminar_programacion(Request $request)
    {
         $detalle=Acta_acuerdo_detalle::where('idactaacuerdodet',$request->idactaacuerdodet)->update(['estado'=>0]);
        $id_acta_acuerdo = Acta_acuerdo::select('idacta_acuerdo')->where('numero_acta', $request->numero_acta)->first();
        $resultado=$this->retornardetalle($id_acta_acuerdo->idacta_acuerdo);
    return view('ejecucion_acuerdo_tabla',['resultado'=>$resultado]);
    }

    public function traer_programacion(Request $request)
    {
        $programacion=Acta_acuerdo_detalle::select('*')->where('idactaacuerdodet',$request->idactaacuerdodet)->first();
        return $programacion->toJson();
    }

    function actualizar_detalle(Request $request)
    {
        $actualiza=Acta_acuerdo_detalle::where('idactaacuerdodet',$request->idactaacuerdodet)->update(['fecha'=>$request->fecha,'actividad'=>$request->actividad]);
        $resultado=$this->retornardetalle($request->idacta_acuerdo);
    return view('ejecucion_acuerdo_tabla',['resultado'=>$resultado]);
    }

    public function insertar_detalle(Request $request)
    {

    $id_acta_acuerdo = Acta_acuerdo::select('idacta_acuerdo')->where('numero_acta', $request->numero_acta)->first();
    DB::beginTransaction();
    $detalle=Acta_acuerdo_detalle::create($request->all());
    $detalle->idacta_acuerdo=$id_acta_acuerdo->idacta_acuerdo;
    $detalle->save();
    DB::commit();

    $resultado=$this->retornardetalle($id_acta_acuerdo->idacta_acuerdo);
    return view('ejecucion_acuerdo_tabla',['resultado'=>$resultado]);
    }

    public function tabla_actualizada($id)
    {
         $listadoc= Acta_acuerdo::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','8')->orderby('idacta_acuerdo','desc')->get();
    ?>
        <table class="table">
                                                        <thead>
                                                            <tr>
                                                            <th>N°</th>
                                                            <th>Código del Documento</th>
                                                            <th>Ver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                if(!empty($listadoc)){
                                                                    $contador = 1;
                                                                    foreach ($listadoc as $row) {
                                                                        echo "<tr><td>$contador</td>";
                                                                        echo "<td>$row->numero_acta</td>";
                                                                        echo "<td class='text-center'>
                                                                                <button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_acta_acuerdo('$row->idacta_acuerdo')>Ver más</button>
                                                                        </td></tr>";
                                                                        $contador+=1;
                                                                    }
                                                                }
                                                            ?>
                                                        </tbody>

                                                    </table>

    <?php

    }

    public function retornardetalle($idacta_acuerdo){

        $resultado=Acta_acuerdo_detalle::with(['documento'])->where('idacta_acuerdo','=',$idacta_acuerdo)->where('estado',1)->get();

        return $resultado;
    }

    public function ActualizarActa(Request $request){

        DB::beginTransaction();
        $solcam = Acta_acuerdo::where('idproyecto','=',$request->idproyecto)->where('numero_acta', $request->numero_acta)
        ->update(['tema'=>$request->tema,'revision'=>$request->revision,'acuerdos'=>$request->acuerdos,'fecha_prox_reu'=>$request->fecha_prox_reu,'cronograma'=>$request->cronograma,'hora'=>$request->hora,'fecha_hora'=>$request->fecha_hora_fecha]);
        DB::commit();
        $verificar=$this->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }

    }

    public function ejecucion_acuerdo($id){
        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);

        $nom=$objProyecto->retronarNombreProyecto($id);
        $cli=$objProyecto->retronarClienteProyecto($id);

        $acta=$this->retornarActaAcuerdo($id);
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        // $numero=$objProyecto->AbreviaturaDocumento('8').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1';
        $numero=$objProyecto->AbreviaturaDocumento('8').'-'.substr($nombreclave,4).'-1';

        if(!empty($acta->idacta_acuerdo)){
            $resultado=$this->retornardetalle($acta->idacta_acuerdo);
        }else{
            $resultado=null;
        }

        $listadoc= Acta_acuerdo::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','8')->orderby('idacta_acuerdo','desc')->get();

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('ejecucion_acuerdo',['id'=>$id,'numero'=>$numero,'nom'=>$nom,'cli'=>$cli,'resultado'=>$resultado,'acta'=>$acta,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'doc_validados'=>$doc_validados]);
    }

    public function lista_acuerdo($idacuerdo)
    {
      $lista_acuerdo = Acta_acuerdo::select('*')->where('idacta_acuerdo', $idacuerdo)->orderby('idacta_acuerdo','desc')->first();

      return $lista_acuerdo->toJson();
    }

    public function tabladeprogramacion($idacuerdo)
    {
      $firmas = Acta_acuerdo_detalle::select('*')->where('idacta_acuerdo', $idacuerdo)->orderby('idacta_acuerdo','desc')->get();
      // dd($firmas);
    ?>
    <thead>
      <tr>
      <th>Nº</th>
      <th>Fecha</th>
      <th>Actividad</th>
      <th>Consultar</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    foreach ($firmas as $row) {
    ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row["firma"]; ?></td>
        <td><?php echo $row["actividad"]; ?></td>
        <td>
          <select >
            <option>-Opciones-</option>
            <option>Consultar</option>
            <option>Eliminar</option>
          </select>
        </td>
      </tr>

    <?php
    $i++; }
    ?>
    </tbody>
    <?php
    }

    //AJAX
    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }

    public function ExportarWord($id){

        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $ultimo_id = Acta_acuerdo::select('numero_acta')->where('estado','1')->orderby('idacta_acuerdo','desc')->first();
        $numero=$ultimo_id->numero_acta;

        $nom=$objProyecto->retronarNombreProyecto($id);
        $cli=$objProyecto->retronarClienteProyecto($id);

        $acta=$this->retornarActaAcuerdo($id);
        $resultado=$this->retornardetalle($acta->idacta_acuerdo);

        $primermes=Acta_acuerdo_detalle::select('fecha')->where('idacta_acuerdo','=',$acta->idacta_acuerdo)->where('estado',1)->orderby('fecha','asc')->first();
        $onedia=substr($primermes,18,-2);
        $ultimomes=Acta_acuerdo_detalle::select('fecha')->where('idacta_acuerdo','=',$acta->idacta_acuerdo)->where('estado',1)->orderby('fecha','desc')->first();
        $lastdia=substr($ultimomes,18,-2);
        $lastmes=substr($ultimomes,15,-5);



        switch ($lastmes) {
            case '01':$lastmes="Enero";
                break;
            case '02':$lastmes="Febrero";
                break;
            case '03':$lastmes="Marzo";
                break;
            case '04':$lastmes="Abril";
                break;
            case '05':$lastmes="Mayo";
                break;
            case '06':$lastmes="Junio";
                break;
            case '07':$lastmes="Julio";
                break;
            case '08':$lastmes="Agosto";
                break;
            case '09':$lastmes="Septiembre";
                break;
            case '10':$lastmes="Octubre";
                break;
            case '11':$lastmes="Noviembre";
                break;
            case '12':$lastmes="Diciembre";
                break;
        }

$html='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acta Acuerdo</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial;
        }
        table{
            border-spacing: 0px;
        }
    </style>
</head>
<body>
<body>';
    $html.='<table width="100%">
        <tr>
            <td width="20%"  style="padding: 15px; border: 1px solid #000"><img src="logo.png" border="0" height="50" width="150" align="middle" /></td>
            <td width="60%" colspan="4" style="border: 1px solid #000"><h2 style="text-align: center;  ">Acta de Acuerdo</h2></td>
            <td valign="top" colspan="2" style="border: 1px solid #000">Código: SGC-FOR-24 <br> Versión: 00</td>
        </tr>
        <tr>
            <td colspan="8" style="padding: 15px; border: 1px solid #000 ; border-top: none"></td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="4" style="border: 1px solid #000;text-align:center;"><center>TEMA DE LA REUNIÓN</center></td>
            <td width="10%" style="border: 1px solid #000 ; ">N° DE ACTA</td>
            <td width="2%"   style="border: none ; border-top: 1px solid;text-align:center;"> : </td>
            <td width="28%" style="border: 1px solid #000" align="center">'.$numero.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="4" rowspan="2" style="border: 1px solid #000">'.$acta->tema.'</td>
            <td width="40%"  style="border: 1px solid #000"><strong>FECHA</strong></td>
            <td width="2%"   style="border: none"  align="center"> : </td>
            <td width="28%"  style="border: 1px solid #000">';
                  $date=date_create($acta->fecha_hora);
                  $freu=$date->format('d-m-Y');
                  $html.=$freu.'</td>
        </tr>';
$html.='<tr>
            <td width="40%"  style="border: 1px solid #000"  ><strong>HORA</strong></td>
            <td width="2%"   style="border: none ; border-bottom: 1px solid" align="center"> : </td>
            <td width="28%"  style="border: 1px solid #000" >'.$acta->hora.'</td>
        </tr>';
$html.='<tr>
            <td width="40%"  style="border: 1px solid #000 ; border-top: none ; padding-left: 8px" ><strong>CLIENTE</strong></td>
            <td width="2%"   style="border: none ;" align="center"> : </td>
            <td width="40%" colspan="5"  style="border: 1px solid #000 ; border-top: none ; padding-left: 8px" >'.$cli.'</td>
        </tr>';
$html.='<tr>
            <td width="40%"  style="border: 1px solid #000 ; border-top: none ; padding-left: 8px" ><strong>PROYECTO</strong></td>
            <td width="2%"   style="border: none ; border-bottom: 1px solid" align="center"> : </td>
            <td width="40%" colspan="5"  style="border: 1px solid #000 ; border-top: none ; padding-left: 8px" >'.$nom.'</td>
        </tr>
    </table>
    <br>';

$html.='<h2>1. REVISIÓN DE AVANCES:</h2>';
$html.='<p>'.$acta->revision.'</p>';

$html.='<h2>2. ACUERDOS:</h2>';
$html.='<p>'.$acta->acuerdos.'</p>';

$html.='<h2>3. PROGRAMACIÓN DE LA SEMANA:</h2>';

$html.='<table width="100%">
        <tr>
            <td colspan="2" align="center" style="border: 1px solid #000 ;">'.$acta->cronograma.'</td>
        </tr>
        <tr>
            <td width="20%"  align="center" style="border: 1px solid #000 ; border-top: none">FECHA</td>
            <td width="80%"  align="center" style="border: 1px solid #000 ; border-top: none ; border-left: none">ACTIVIDAD</td>
        </tr>';
        foreach ($resultado as $row) {
                    $datef=date_create($row->fecha);
                    $feee=$datef->format('d-m-Y');
                    $html.='<tr>';
                    $html.='<td width="20%"  align="center" style="border: 1px solid #000 ; border-top: none" >'.$feee.'</td>';
                   $html.='<td width="80%"  align="center" style="border: 1px solid #000 ; border-top: none ; border-left: none" >'.$row->actividad.'</td>';
                   $html.='</tr>';
                }
   $html.='</table>
    <br>';

$daten=date_create($acta->fecha_prox_reu);
$fnext=$daten->format('d-m-Y');

$html.='<label style="font-family:Calibri;">4. FECHA PROXIMA REUNIÓN: </label> '.$fnext;

$html.='</body>
</html>';
            $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','portrait');
        $pdf->loadHTML($html);
        return @$pdf->stream('acta_acuerdo.pdf');

    }
}
