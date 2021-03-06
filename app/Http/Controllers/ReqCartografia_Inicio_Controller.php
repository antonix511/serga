<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Equipo_cartografia;
use App\Req_cartografia;
use App\Req_cartografia_detalles;
use App\Proyecto;
use App\Seguimiento_proyecto;
use App\Proyecto_doc_valida;

class ReqCartografia_Inicio_Controller extends Controller
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
    DB::table('req_cartografia')->insert(['idproyecto' => $request->idproyecto,'fecha'=>$request->fecha,'fecha_entrega'=>$request->fecha_entrega,'idjefegerente'=>$request->idjefegerente,'idsolicitante'=>$request->idsolicitante,'colaborador'=>$request->colaborador,'iddocumento'=>5,'numero_requerimiento'=>$request->numero_requerimiento]);
    DB::commit();
    $idreq=$this->retornarIdCarto($request->idproyecto);
    $objActaIni=new Acta_inicioController();
        $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }
    return $idreq->idcartografia;
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
    public function ActualizarReqCarto(Request $request)
    {
        DB::table('req_cartografia')->where('idproyecto','=',$request->idproyecto)->where('numero_requerimiento',$request->numero_requerimiento )
        ->update(['fecha'=>$request->fecha,'fecha_entrega'=>$request->fecha_entrega,'idjefegerente'=>$request->idjefegerente,'idsolicitante'=>$request->idsolicitante,'colaborador'=>$request->colaborador,'iddocumento'=>5]);
        $objActaIni=new Acta_inicioController();
        $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }
    }

    public function ActualizarEquipoCarto(Request $request)
    {
         DB::beginTransaction();
    DB::table('req_cartografia_detalles')->where('idreqcartodeta',$request->idreqcartodeta)->update(['cantidad' => $request->cantidad,'fecha_devolucion'=>$request->fecha_devolucion,'idequipo'=>$request->idequipo,'observaciones'=>$request->observaciones]);
    DB::commit();

    $resultado=$this->retornardetalle($request->idreqcartografia);
    return view('inicio_reqcartog_tabla',['resultado'=>$resultado]);
    }

    public function insertar_detalle(Request $request)
    {
        //
    DB::beginTransaction();
    DB::table('req_cartografia_detalles')->insert(['idreqcartografia' => $request->idreqcartografia,'cantidad' => $request->cantidad,'fecha_devolucion'=>$request->fecha_devolucion,'idequipo'=>$request->idequipo,'observaciones'=>$request->observaciones]);
    DB::commit();

    $resultado=$this->retornardetalle($request->idreqcartografia);
    return view('inicio_reqcartog_tabla',['resultado'=>$resultado]);
    }
    public function eliminar_detalle(Request $request)
    {
        //
    DB::beginTransaction();
    DB::table('req_cartografia_detalles')->where('idreqcartodeta',$request->idreqcartodeta)->update(['estado'=>0]);
    DB::commit();

    $resultado=$this->retornardetalle($request->idreqcartografia);
    return view('inicio_reqcartog_tabla',['resultado'=>$resultado]);
    }

    public function tabla_equipo_carto($id)
    {
       $tabla_equipo_carto = Req_cartografia_detalles::select('req_cartografia_detalles.observaciones','req_cartografia_detalles.fecha_devolucion','req_cartografia_detalles.cantidad','equipo_cartografia.nombre')->where('idreqcartografia',$id)
       ->join('equipo_cartografia','equipo_cartografia.idequipo','=','req_cartografia_detalles.idequipo')->orderby('idreqcartodeta','desc')->get();

    ?>
    <thead>
                                          <tr>
                                            <th>N</th>
                                            <th>Cantidad</th>
                                            <th>Descripción</th>
                                            <th>Fecha de devolución</th>
                                            <th>Observación</th>
                                            <th>Consultar</th>
                                            <th>Eliminar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($tabla_equipo_carto as $row ) {
                                                $i++;
                                        ?>
                                        <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row["cantidad"] ?></td>
                                                <td><?php echo $row["nombre"] ?></td>
                                                <td><?php echo $row["fecha_devolucion"] ?></td>
                                                <td><?php echo $row["observaciones"] ?></td>


                                                <td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarEquipCartografia('<?php echo $row["idreqcartodeta"] ?>')"></i></a></td>
                                                <td><a href="#"><i class="fa fa-trash" onclick="EliminarEquipCartografia('<?php echo $row["idreqcartodeta"] ?>')"></i></a></td>

                                                </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
    <?php
    }


    function traer_detalle(Request $request)
    {

      $resultado=Req_cartografia_detalles::with(['equipo'])->where('idreqcartodeta','=',$request->idreqcartodeta)->where('estado',1)->first();
        return $resultado->toJson();

    }

     public function cargarEquipoCartografia(){

        $resultado = Equipo_cartografia::select('idequipo','nombre')->where('estado','=','1')->get();
        return $resultado;
    }

    public function id_cartografia($id)
    {
      $id_cartografia = Req_Cartografia::select('numero_requerimiento')
                                       ->where('idproyecto', $id)
                                       ->where('estado', '1')
                                       ->orderby('idreqcartografia','desc')->first();
      if (isset($id_cartografia)) {
        return $id_cartografia->toJson();
      }else{
        return $id_cartografia;
      }
    }

    public function id_cartografia2($numero_requerimiento)
    {
      $id_cartografia2 =  Req_Cartografia::select('idreqcartografia')->where('estado', '1')->where('numero_requerimiento', $numero_requerimiento)->orderby('idreqcartografia','desc')->first();
      return  $id_cartografia2->toJson();
    }

    public function inicio_reqcartog($id){
        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $nom=$objProyecto->retronarNombreProyecto($id);
        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);
        // $numero=$objProyecto->AbreviaturaDocumento('5').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1';
        $numero=$objProyecto->AbreviaturaDocumento('5').'-'.substr($nomcla,4).'-1';
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();
        $traba=$objProyecto->cargarTodosTrabajadores();
        $equipo=$this->cargarEquipoCartografia();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        $reqcarto=$this->retornarReqCartografia($id);
        if (!empty($reqcarto)) {
            $resultado=$this->retornardetalle($reqcarto->idreqcartografia);
        }else{
            $resultado=null;
        }



        $listadoc= Req_Cartografia::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','5')->orderby('idreqcartografia' , 'desc')->get();

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }


        return view('inicio_reqcartog',['id'=>$id,'numero'=>$numero,'nom'=>$nom,'nomcla'=>$nomcla,'gerentesYJefes'=>$gerentesYJefes
            ,'traba'=>$traba,'cola'=>$traba,'equipo'=>$equipo,'resultado'=>$resultado,'reqcarto'=>$reqcarto,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'doc_validados'=>$doc_validados]);
    }

    public function tabla_requistrado_carto($id)
    {
      $listadoc= Req_Cartografia::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','5')->orderby('idreqcartografia' , 'desc')->get();
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
            echo "<td>$row->numero_requerimiento</td>";
            echo "<td class='text-center'>
            <button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_req_Cartografia('$row->idreqcartografia')>Ver más</button>
            </td></tr>";
            $contador+=1;
          }
        }
      ?>
    </tbody>

    <?php
    }


    public function req_cartografia($idreqcartografia)
    {
      $idreqcartografia = Req_Cartografia::select('req_cartografia.idreqcartografia','req_cartografia.idproyecto','req_cartografia.fecha_entrega','req_cartografia.fecha','req_cartografia.numero_requerimiento','proyecto.nombre','proyecto.nombreclave','req_cartografia.idjefegerente','req_cartografia.idsolicitante','req_cartografia.colaborador')->join('proyecto','proyecto.idproyecto','=','req_cartografia.idproyecto')->where('idreqcartografia', $idreqcartografia)->first();

      return $idreqcartografia->toJson();
    }

    public function retornardetalle($idreqcarto){

        $resultado=Req_cartografia_detalles::with(['equipo'])->where('idreqcartografia','=',$idreqcarto)->where('estado',1)->orderby('idreqcartodeta','desc')->get();
        return $resultado;
    }


    public function retornarReqCartografia($idproyecto, $idreqcartografia = 0){
        if($idreqcartografia>0){
            $req=Req_Cartografia::with(['jefe','solicitante','documento','nomcolabora','apecolabora'])->where('req_cartografia.idproyecto','=',$idproyecto)->where('req_cartografia.idreqcartografia','=',$idreqcartografia)->orderby('req_cartografia.idreqcartografia','desc')->first();
        }else{
            $req=Req_Cartografia::with(['jefe','solicitante','documento','nomcolabora','apecolabora'])->where('req_cartografia.idproyecto','=',$idproyecto)->orderby('req_cartografia.idreqcartografia','desc')->first();
        }
        return $req;
        // dd($res);
    }

    public function retornarIdCarto($idproyecto){

        $resultado = Req_Cartografia::select('idreqcartografia')->where('idproyecto','=',$idproyecto)->first();
        return $resultado;
    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }

    public function ExportarExcel($id){

        $str_id = explode('_', $id);
        $id = (int)@$str_id[0];
        $id_reqcarto = (int)@$str_id[1];

        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $numero=$objProyecto->AbreviaturaDocumento('5').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-4';
        $nom=$objProyecto->retronarNombreProyecto($id);
        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();
        $traba=$objProyecto->cargarTodosTrabajadores();
        $equipo=$this->cargarEquipoCartografia();

        $reqcarto=$this->retornarReqCartografia($id, $id_reqcarto);
        $resultado=$this->retornardetalle($reqcarto->idreqcartografia);
        // dd($reqcarto);
        $proyecto=Proyecto::with(['persona','cliente','servicio','distrito','departamento','provincia','retornar_gerente','retornar_jefe','retornar_tipProyecto','retornar_tipContrato','notificado1','notificado2'])->where('idproyecto',$id )->first();

$html='
    <title>Requerimiento de Cartografía</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: sans-serif;
        }
        table{
            border-spacing: 0px;
        }
        .negrita{
        font-weight: bold;
        }
    </style>
';
$html.='<table width="100%">
    <tr>
        <td width="20%" style="padding: 15px; border: 1px solid #000"><img src="logo.png" border="0" height="50" width="170" align="middle" /></td>
        <td width="50%" style="border: 1px solid #000"><h3 style="text-align: center;  ">Requerimiento de Cartografía</h3></td>
        <td valign="top" style="border: 1px solid #000;font-size:10pt"><br>Código: MCE-FOR-05 <br> Versión: 00</td>
    </tr>
</table>
<br>';
$date=date_create($reqcarto->fecha);
$fec=$date->format('d-m-Y');
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">Nº de Requerimiento*:</td>
        <td width="30%" align="center" style="border: 1px solid #000;font-size:10pt">'.$reqcarto->numero_requerimiento.'</td>
        <td width="30%" class="negrita"  align="right" style="padding-right: 5px; font-weight: bold;font-size:10pt"> Fecha:</td>

        <td width="20%" align="center" style="border: 1px solid #000;font-size:10pt">'.$fec.'</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Nombre del Proyecto:</td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">'.$proyecto->nombre.'</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Nombre clave del proyecto:</td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">'.$proyecto->nombreclave.'</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Gerente/Jefe de proyecto:</td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">';
        foreach ($gerentesYJefes as $gerentesYJefes) {
            if ($reqcarto->idjefegerente==$gerentesYJefes->idpersona) {
                $html.=$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos.'';
            }
        }
$html.='</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Solicitante**:</td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">';
foreach ($traba as $traba) {
    if ($reqcarto->idsolicitante==$traba->idpersona) {
        $html.=$traba->nombre.' '.$traba->trabajador->apellidos;
    }
}
$html.='</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Colaborador designado:</td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">'.$reqcarto->nomcolabora->nombre.' '.$reqcarto->apecolabora->apellidos.'</td>
    </tr>
</table>
<br>';
$datee=date_create($reqcarto->fecha_entrega);
$fentre=$datee->format('d-m-Y');
$html.='<table width="100%">
    <tr>
        <td width="32%" class="negrita"  style="padding: 8px; border: 1px solid #000;font-size:10pt">Fecha de entrega: </td>
        <td width="80%" align="center" style="border: 1px solid #000;font-size:10pt">'.$fentre.'</td>
    </tr>
</table>
<br>';
$html.='<table width="100%">
    <tr>
        <td colspan="5" width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt">*Asignado por el área de Cartografía <br>
            **Gerentes, Jefe de Proyecto, Coodinador o Asistente Administrativo y Logístico </td>
    </tr>
    <tr>
        <td colspan="5" width="30%" style="padding: 8px; border: 1px solid #000; border-top: none;font-size:10pt" align="center"><strong>
            EQUIPOS DE CARTOGRAFÍA</strong></td>
    </tr>
    <tr>
        <td  width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">
            <strong>N°</strong>
        </td>
        <td  width="15%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">
            <strong>Cantidad</strong>
        </td>
        <td  width="50%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">
            <strong>Descripción</strong>
        </td>
        <td  width="10%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">
            <strong>Fecha de devolución</strong>
        </td>
        <td  width="20%" style="padding: 8px; border: 1px solid #000; border-top: none;font-size:10pt" align="center">
            <strong>Observación</strong>
        </td>
    </tr>';
$i=1;
foreach ($resultado as $row) {
    $html.='<tr>';
    if($i<10){
        $html.='<td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">0'.$i.'</td>';
    }else{
        $html.='<td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">'.$i.'</td>';
    }
    $html.='<td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">'.$row->cantidad.'</td>
                <td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">'.$row->equipo->nombre.'</td>
                <td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none ; border-right: none;font-size:10pt" align="center">'.$row->fecha_devolucion.'</td>
                <td width="5%" style="padding: 8px; border: 1px solid #000; border-top: none;font-size:10pt; " align="center">'.$row->observaciones.'</td>';
   $html.='</tr>';

             $i++; }


$html.='</table>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','portrait');
        $pdf->loadHTML($html);
        return @$pdf->stream('Requerimiento_Cartografia.pdf');
    }
}
