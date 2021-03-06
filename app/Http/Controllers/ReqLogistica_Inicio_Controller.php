<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use DB;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Logistica_mantenimiento;

use App\Unidad_medida;

use App\Req_logistica;

use App\Req_logistica_detalles;

use App\Proyecto;

use App\Seguimiento_proyecto;

use App\Proyecto_doc_valida;

class ReqLogistica_Inicio_Controller extends Controller

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

    DB::table('req_logistica')->insert(['idproyecto' => $request->idproyecto,'nrequerimiento' => $request->nrequerimiento,'fecha'=>$request->fecha,'fecha_entrega'=>$request->fecha_entrega,'idjefegerente'=>$request->idjefegerente,'idsolicitante'=>$request->idsolicitante,'observacion'=>$request->observacion,'iddocumento'=>4]);

    DB::commit();

    $idreq=$this->retornarIdReqlogis($request->idproyecto);

    $objActaIni=new Acta_inicioController();

        $verificar=$objActaIni->VerificarDocumentos($request->proyecto);

        if ($verificar>0) {

            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);

        }

    return $idreq->idreqlogis;

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



    function TraerDetalle(Request $request)

    {

      $resultado=Req_logistica_detalles::with(['logistica','unidad','persona','trabajador'])->where('idreqlogisdeta','=',$request->idreqlogisdeta)->first();

        return $resultado->toJson();

    }

    public function ActualizarReqLogistica(Request $request)

    {

        DB::table('req_logistica')->where('idproyecto','=',$request->idproyecto)->where('nrequerimiento', $request->nrequerimiento)

        ->update(['fecha'=>$request->fecha,'fecha_entrega'=>$request->fecha_entrega,'idjefegerente'=>$request->idjefegerente,'idsolicitante'=>$request->idsolicitante,'observacion'=>$request->observacion,'iddocumento'=>4]);

        $objActaIni=new Acta_inicioController();

        $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);

        if ($verificar>0) {

            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);

        }

    }



    public function id_req_logistica($nrequerimiento)

    {

      $id_req_logistica = Req_logistica::select('idreqlogis')->where('nrequerimiento', $nrequerimiento)->first();

      if(!empty($id_req_logistica)){

        return $id_req_logistica->toJson();

      }else {



      }

    }





    public function insertar_detalle(Request $request)

    {

        //

    DB::beginTransaction();

    DB::table('req_logistica_detalles')->insert(['idreqlogis' => $request->idreqlogis,'idlogistica' => $request->idlogistica,'cantidad'=>$request->cantidad,'idunidad'=>$request->idunidad,'descripcion'=>$request->descripcion,'idpersona'=>$request->idpersona]);

    DB::commit();



    $resultado=$this->retornardetalle($request->idreqlogis);

    return view('inicio_reqlogisti_tabla',['resultado'=>$resultado]);

    }

    public function eliminar_detalle(Request $request)

    {

        //

    DB::beginTransaction();

    DB::table('req_logistica_detalles')->where('idreqlogisdeta','=', $request->idreqlogisdeta)->update(['estado'=>0]);

    DB::commit();



    $resultado=$this->retornardetalle($request->idreqlogis);

    return view('inicio_reqlogisti_tabla',['resultado'=>$resultado]);

    }



    public function actualizar_detalle(Request $request)

    {

        //

    DB::beginTransaction();

    DB::table('req_logistica_detalles')->where('idreqlogisdeta','=', $request->idreqlogisdeta)->update(['idreqlogis' => $request->idreqlogis,'idlogistica' => $request->idlogistica,'cantidad'=>$request->cantidad,'idunidad'=>$request->idunidad,'descripcion'=>$request->descripcion,'idpersona'=>$request->idpersona]);

    DB::commit();



    $resultado=$this->retornardetalle($request->idreqlogis);

    return view('inicio_reqlogisti_tabla',['resultado'=>$resultado]);

    }







    public function retornardetalle($idreqlogis){



        $resultado=Req_logistica_detalles::with(['logistica','unidad','persona','trabajador'])->where('idreqlogis','=',$idreqlogis)->where('estado','=',1)->get();

        return $resultado;

    }





    public function retornarIdReqlogis($idproyecto){



        $resultado = Req_logistica::select('idreqlogis')->where('idproyecto','=',$idproyecto)->first();

        return $resultado;

    }

    public function cargarLogis_Mantenimiento(){



        $resultado = Logistica_mantenimiento::select('idlogistica','nombre')->where('estado','=','1')->get();

        return $resultado;

    }

    public function cargarUnidades_medida(){



        $resultado = Unidad_medida::select('idunidad','nombre')->where('estado','=','1')->get();

        return $resultado;

    }

    public function retornarReqLogistica($idproyecto, $idreqlogis = 0){

        if($idreqlogis > 0){
          $req=Req_logistica::with(['jefe','solicitante','documento'])->where('req_logistica.idproyecto','=',$idproyecto)->where('req_logistica.idreqlogis','=',$idreqlogis)->orderby('idreqlogis','desc')->first();
        }else{
          $req=Req_logistica::with(['jefe','solicitante','documento'])->where('req_logistica.idproyecto','=',$idproyecto)->orderby('idreqlogis','desc')->first();
        }

        return $req;

    }

    public function retornardetalle_area($idlogis,$idreqlogis){



        $resultado=Req_logistica_detalles::with(['logistica','unidad','persona','trabajador'])->where('idlogistica','=',$idlogis)->where('idreqlogis','=',$idreqlogis)->where('estado','=','1')->get();

        return $resultado;

    }

    public function inicio_reqlogisti($id){

        $objProyecto=new ProyectoController();

        //CODE

        $idservicio=$objProyecto->retornarIdServicioProyecto($id);

        $idcliente=$objProyecto->retronaIdClienteProyecto($id);

        // $numero=$objProyecto->AbreviaturaDocumento('4').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1-1';

        $serv=$objProyecto->retornaServicioProyecto($id);

        $cli=$objProyecto->retronarClienteProyecto($id);

        $nom=$objProyecto->retronarNombreProyecto($id);

        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);

        $numero=$objProyecto->AbreviaturaDocumento('4').'-'.substr($nomcla,4).'-1';

        $centrodecosto=$objProyecto->retornarCentroCostos($id);

        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

        $traba=$objProyecto->cargarTodosTrabajadores();

        $traba2=$objProyecto->cargarTodosTrabajadores();

        $depa=$objProyecto->cargarDepartamento($id);

        $prov=$objProyecto->consultarProvincia($id);

        $dis=$objProyecto->consultarDistrito($id);

        $logistica=$this->cargarLogis_Mantenimiento();

        $unidades=$this->cargarUnidades_medida();



        $reqlogis=$this->retornarReqLogistica($id);

        if(!empty($reqlogis->idreqlogis)){

        $resultado=$this->retornardetalle($reqlogis->idreqlogis);

        }else{

            $resultado=null;

        }
        // dd($numero, $reqlogis->nrequerimiento);



        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);



        $listadoc= Req_logistica::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','4')->orderby('idreqlogis','desc')->get();


        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }



        return view('inicio_reqlogisti',['id'=>$id,'numero'=>$numero,'serv'=>$serv,

            'cli'=>$cli,'nom'=>$nom,'nomcla'=>$nomcla,'centrodecosto'=>$centrodecosto,

            'gerentesYJefes'=>$gerentesYJefes,'traba'=>$traba,'traba2'=>$traba2,'depa'=>$depa,'prov'=>$prov,

            'dis'=>$dis,'logistica'=>$logistica,'unidades'=>$unidades,'reqlogis'=>$reqlogis,'resultado'=>$resultado,

            'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'doc_validados'=>$doc_validados]);

    }



    public function tabla_registro_logis($id)

    {

       $listadoc = Req_logistica::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','4')->orderby('idreqlogis','desc')->get();

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

    																			echo "<td>$row->nrequerimiento</td>";

    																			echo "<td class='text-center'>

    																			<button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_req_Logistica('$row->idreqlogis')>Ver más</button>

    																			</td></tr>";

    																			$contador+=1;

    																		}

    																	}

    																?>

    															</tbody>



    														</table>

    <?php

    }



    public function tabla_req_logistica($id)

    {

      $tabla_req_logistica = Req_logistica_detalles::select('req_logistica_detalles.descripcion','req_logistica_detalles.cantidad',

      'logisitica_mantenimiento.nombre','persona.nombre as nombre_persona','trabajador.apellidos','unidad_medida.nombre as medida')

      ->join('logisitica_mantenimiento','logisitica_mantenimiento.idlogistica','=','req_logistica_detalles.idlogistica')

      ->join('persona','persona.idpersona','=','req_logistica_detalles.idpersona')

      ->join('trabajador','trabajador.idpersona','=','persona.idpersona')

      ->join('unidad_medida','unidad_medida.idunidad','=','req_logistica_detalles.idunidad')

      ->where('idreqlogis', $id)->get();

      ?>

      <thead>

        <tr>

        <th>Área de Logistica y Mantenimiento</th>

        <th>Cantidad</th>

        <th>Unidad</th>

        <th>Descripción</th>

        <th>Personal Asignado</th>



        <th>Consultar</th>

        </tr>

      </thead>

      <tbody>

        <?php foreach ($tabla_req_logistica as $row ): ?>

          <tr>

          <td><?= $row["nombre"] ?></td>

          <td><?= $row["cantidad"] ?></td>

          <td><?= $row["medida"] ?></td>

          <td><?= $row["descripcion"] ?></td>

          <td><?= $row["nombre_persona"]." ".$row["apellidos"] ?></td>



          <td>

            <select >

              <option>-Opciones-</option>

              <option>Consultar</option>

              <option>Eliminar</option>



            </select>

      </td>

          </tr>



        </tbody>

        <?php endforeach; ?>

      <?php

    }



    public function logistica($id)

    {
      // return response()->json($id);
      $logistica = Req_logistica::select('*')
                                ->where('idproyecto', $id)
                                ->where('estado', '1')
                                ->orderby('idreqlogis','desc')
                                ->first();

      if (isset($logistica)) {
        return $logistica->toJson();
      }else{
        return $logistica;
      }


    }



    public function req_logistica($id)

    {

      $req_logistica = Req_logistica::select('req_logistica.idreqlogis','req_logistica.idproyecto','req_logistica.fecha','req_logistica.observacion','req_logistica.fecha_entrega','req_logistica.nrequerimiento',

      'persona.nombre','solicitud.nombre as nombre_solicitante','trabajador.apellidos','apellidos_solicitante.apellidos as apellidos_solicitante')

      ->join('persona','persona.idpersona','=','req_logistica.idjefegerente')

      ->join('persona as solicitud','solicitud.idpersona','=','req_logistica.idsolicitante')

      ->join('trabajador','trabajador.idpersona','=','persona.idpersona')

      ->join('trabajador as apellidos_solicitante','apellidos_solicitante.idpersona','=','solicitud.idpersona')

      ->where('idreqlogis', $id)->first();



      return $req_logistica->toJson();

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
        $id_reqlogis = (int)@$str_id[1];

        $objProyecto=new ProyectoController();

        //CODE

        $idservicio=$objProyecto->retornarIdServicioProyecto($id);

        $idcliente=$objProyecto->retronaIdClienteProyecto($id);

        $numero=$objProyecto->AbreviaturaDocumento('4').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-3';

        $serv=$objProyecto->retornaServicioProyecto($id);

        $cli=$objProyecto->retronarClienteProyecto($id);

        $nom=$objProyecto->retronarNombreProyecto($id);

        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);

        $centrodecosto=$objProyecto->retornarCentroCostos($id);

        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

        $traba=$objProyecto->cargarTodosTrabajadores();

        $traba2=$objProyecto->cargarTodosTrabajadores();

        $depa=$objProyecto->cargarDepartamento($id);

        $prov=$objProyecto->consultarProvincia($id);

        $dis=$objProyecto->consultarDistrito($id);

        $logistica=$this->cargarLogis_Mantenimiento();

        $unidades=$this->cargarUnidades_medida();



        $reqlogis=$this->retornarReqLogistica($id, $id_reqlogis);

        $resultado=$this->retornardetalle($reqlogis->idreqlogis);



        $proyecto=Proyecto::with(['persona','cliente','servicio','distrito','departamento','provincia','retornar_gerente','retornar_jefe','retornar_tipProyecto','retornar_tipContrato','notificado1','notificado2'])->where('idproyecto',$id)->first();



        $reqlogist=Req_logistica::with(['jefe','solicitante','apesolicitante','apesolicitante'])->where('idproyecto',$id)->where('idreqlogis',$reqlogis->idreqlogis)->orderby('idreqlogis','desc')->first();



        $html='';

        $html.='

    <title>Requerimiento de Logística</title>

    <style>

        *{

            box-sizing: border-box;

            font-family: sans-serif;

        }

        table{

            border-spacing: 0px;

        }

    </style>


';

$html.='<body><table width="100%">';

$html.='<tr>';

$html.='<td width="20%" style="padding: 15px; border: 1px solid #000" colspan="2"><img src="logo.png" border="0" height="60" width="145" align="middle" /></td>';

$html.='<td width="50%" style="border: 1px solid #000" colspan="2"><h3 style="text-align: center;  ">Requerimiento de Logística</h3></td>';

$html.='<td width="30%" valign="top" style="border: 1px solid #000;font-size:9pt""><br>Código: IPL-FOR-04<br>Versión: 03</td>';

$html.='</tr></table><br>';



$html.='<table width="100%">';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>N° DE REQUERIMIENTO:</strong></td>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$reqlogist->nrequerimiento.'</center></td>';

$html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>FECHA:</strong></td>';

$date=date_create($proyecto->fecha);

$fec=$date->format('d-m-Y');

$html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$fec.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>SERVICIO:</strong></td>';

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$serv.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>CLIENTE:</strong></td>';

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$cli.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>NOMBRE DEL PROYECTO:</strong></td>';

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$nom.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>NOMBRE CLAVE DEL PROYECTO:</strong></td>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt">'.$nomcla.'</td>';

$html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>CENTRO DE COSTOS:</strong></td>';

$html.='<td width="20%" style="padding: 5px; border: 1px solid #000;text-align:left;font-size:9.5pt"><center>'.$centrodecosto.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>GERENTE/JEFE DE PROYECTO:</strong></td>';

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.@$reqlogist->jefe->nombre.' '.@$reqlogist->apejefe->apellidos.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>*SOLICITANTE:</strong></td>';

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.@$reqlogist->solicitante->nombre.' '.@$reqlogist->apesolicitante->apellidos.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="10%" colspan="2" rowspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>UBICACIÓN DEL PROYECTO</strong></td>';

$html.='<td width="10%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong><center>Dpto.</center></strong></td>';

$html.='<td width="80%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$depa.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="10%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong><center>Prov./Distri.</center></strong></td>';

$html.='<td width="80%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$prov.'/'.$dis.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="20%" colspan="2" style="padding: 5px; border: 1px solid #00;font-size:9.5pt"><strong>FECHA DE ENTREGA:</strong></td>';

$datee=@date_create(@$reqlogis->fecha_entrega);

$fentre=@$datee->format('d-m-Y');

$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center>'.$fentre.'</center></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="100%" colspan="5" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><strong>* Gerente, Jefe de Proyecto, Coodinador o Asistente Administrativo y Logístico</strong></td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="100%" colspan="5" style="padding: 5px; border: 1px solid #000;background-color:#BDBDBD;font-size:9.5pt"><center><strong>ÁREA DE LOGÍSTICA Y MANTENIMIENTO</strong></center></td>';

$html.='</tr>';





foreach ($logistica as $row) {

    $detalle=$this->retornardetalle_area($row->idlogistica,$reqlogis->idreqlogis);

    if (!empty($detalle)) {

    $html.='<tr><td width="100%" colspan="5" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center><strong>'.$row->nombre.'</strong></center></td></tr>';



    $html.='<tr><td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt"><center><strong>N°</strong></center></td><td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center><strong>Cantidad</strong></center></td><td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center><strong>Unid. de Medida</strong></center></td><td width="40%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center><strong>Descripción</strong></center></td><td width="40%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center><strong>Personal Asignado</strong></center></td></tr>';;

    $i=1;

      foreach ($detalle as $value) {

          $html.='<tr>';

          if($i<10){

            $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>0'.$i.'</center></td>';

          }else{

            $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>'.$i.'</center></td>';

          }

          $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>'.$value->cantidad.'</center></td>';

          $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>'.$value->unidad->nombre.'</center></td>';

          $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>'.$value->descripcion.'</center></td>';

          $html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><center>'.$value->persona->nombre.' '.$value->trabajador->apellidos.'</center></td>';

          $html.='</tr>';

          $i++;

      }

    }

}





$html.='<tr>';

$html.='<td width="100%" colspan="5" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" ><strong>OBSERVACIÓN: </strong></td></tr>';
$html.='<tr>';
$html.='<td width="100%" colspan="5" style="padding: 5px; border: 1px solid #000;font-size:9.5pt" >'.$reqlogist->observacion.'</td></tr>';
$html.='</table>';



        $pdf = \App::make('dompdf.wrapper');

        $pdf->setPaper('A4','portrait');

        $pdf->loadHTML($html);

        return @$pdf->stream('Req_logistica.pdf');

    }

}
