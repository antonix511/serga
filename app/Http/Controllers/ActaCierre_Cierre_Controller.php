<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Acta_cierre;

use DB;

use App\Entregables;

use App\Lecciones_aprendidas;

use App\Seguimiento_proyecto;

use App\Firmas;

use App\Proyecto;

use App\Trabajador;

use App\Proyecto_doc_valida;



class ActaCierre_Cierre_Controller extends Controller

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

        $acta=Acta_cierre::create($request->all());

        $acta->save();

        DB::commit();

        // lplp

        // $verificar=$this->VerificarDocumentos($request->idproyecto);

        // if ($verificar>0) {

            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);

        // }

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



    public function RetornarActaCierre($idproyecto){

        $resp=Acta_cierre::with(['documento'])->where('idproyecto','=',$idproyecto)->first();

        return $resp;

    }



    public function ActualizarActa(Request $request){



        DB::beginTransaction();



        $solcam = Acta_cierre::where('idproyecto','=',$request->idproyecto)->update(['descripcion'=>$request->descripcion,'titular'=>$request->titular,'gerente'=>$request->gerente,'jefe'=>$request->jefe,'finicio'=>$request->finicio,'fcierre'=>$request->fcierre,'fentrega'=>$request->fentrega,'resultado'=>$request->resultado,'observaciones'=>$request->observaciones]);

        DB::commit();



    }

    function AgregarEntregable(Request $request){



        DB::beginTransaction();

        $entregable=Entregables::create($request->all());

        $entregable->save();

        DB::commit();



        $entregables=$this->RetornarEntregables($request->idproyecto,12);

        ?>

<table class="table" >

        <thead>

            <tr>

                <th>Nº</th>

                <th>Nombre</th>

                <th>Consultar</th>

                <th>Eliminar</th>

            </tr>

        </thead>

        <tbody>

            <?php $i=1;

            foreach($entregables as $row){?>

            <tr>

                <td><?= $i;?></td>

                <td><?=$row->nombre?></td>

                <td>

                    <a onclick="consultar_acta_cierre('<?=$row->identregable?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                </td>

                <td>

                  <a onclick="eliminar_acta_cierre('<?=$row->identregable?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>

                </td>

            </tr>

            <?php $i++; }?>





        </tbody>

</table>

        <?php



    }

    function ActualizarEntregable(Request $request){



        $actualiza=Entregables::where('identregable',$request->identregable)->update(['nombre'=>$request->nombre]);



        $entregables=$this->RetornarEntregables($request->idproyecto,12);

        ?>

<table class="table" >

        <thead>

            <tr>

                <th>Nº</th>

                <th>Nombre</th>

                <th>Consultar</th>

                <th>Eliminar</th>

            </tr>

        </thead>

        <tbody>

            <?php $i=1;

            foreach($entregables as $row){?>

            <tr>

                <td><?= $i;?></td>

                <td><?=$row->nombre?></td>

                <td>

                    <a onclick="consultar_acta_cierre('<?=$row->identregable?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                </td>

                <td>

                  <a onclick="eliminar_acta_cierre('<?=$row->identregable?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>

                </td>

            </tr>

            <?php $i++; }?>





        </tbody>

</table>

        <?php



    }

    function consultar_acta_cierre($identregable)

    {

        $entregable=Entregables::select('*')->where('identregable',$identregable)->first();

        return $entregable->toJson();

    }



    public function eliminar_acta_cierre($identregable)

    {

        DB::beginTransaction();

        $eliminar_acta_cierre = Entregables::where('identregable',$identregable)->update(['estado'=>'0']);

        DB::commit();

        $idproyexto = Entregables::select('idproyecto')->where('identregable',$identregable)->orderby('identregable',$identregable)->first();

        $lista = Entregables::select('*')->where('estado','1')->where('idproyecto',$idproyexto->idproyecto)->orderby('identregable','desc')->get();

    ?>

    <table class="table" >

    <thead>

                                                            <tr>

                                                                <th>Nº</th>

                                                                <th>Nombre</th>

                                                                <th>Consultar</th>

                                                                <th>Eliminar</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            <?php $i=1; ?>

                                                           <?php foreach ($lista as $row ) {

                                                           ?>

                                                           <tr>

                                                                <td><?php echo $i; ?></td>

                                                                <td><?php echo $row["nombre"]; ?></td>

                                                                <td>

                                                                    <a onclick="consultar_acta_cierre('{{$row->identregable}}')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                                </td>

                                                                <td>

                                                                    <a onclick="eliminar_acta_cierre('<?php echo $row["identregable"] ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                                </td>

                                                            </tr>

                                                            <?php $i++; ?>

                                                           <?php

                                                           } ?>



                                                        </tbody>

                                                        </table>

    <?php

    }



    function RetornarEntregables($idproyecto,$iddocumento){



        $entregables = Entregables::with(['documento'])->where('idproyecto','=',$idproyecto)->where('entregables.iddocumento','=',$iddocumento)->where('estado','=',1)->get();

        return $entregables;



    }





    function AgregarLeccion(Request $request){



        DB::beginTransaction();



        $solcam = Acta_cierre::where('idproyecto','=',$request->idproyecto)->update(['descripcion2'=>$request->descripcion,'accion'=>$request->accion,'consecuencia'=>$request->consecuencia,'concepto'=>$request->concepto,'etapa'=>$request->etapa]);

        DB::commit();



    }



    function RetornarLecciones($idproyecto,$iddocumento){



        $lecciones =Lecciones_aprendidas::with(['documento'])->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->get();

        return $lecciones;



    }



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

                $actareuc=$objResProyecto->retornaActaReuOK($id,12);



                $validar=$actainicio+$matrizcomu+$matrizrol+$reqlogist+$reqcart+$matrizries+$actareunion+$solcambio+$actaacuerdo+$reportho+$solac+$actareuc;

                if ($validar==12) {

                    return 1;

                }else{

                    return 0;

                }

    }



    public function traerCorrelatio($id)

{

    $proyecto=Proyecto::select('correlativo')->where('idproyecto',$id)->first();

    return $proyecto->correlativo;

}



    public function cierre_actac($id){

        $objProyecto=new ProyectoController();

        //CODE

        $idservicio=$objProyecto->retornarIdServicioProyecto($id);

        $idcliente=$objProyecto->retronaIdClienteProyecto($id);


        $datos=$objProyecto->retornarDatosProyecto($id);



        $objActaInicio=new Acta_inicioController();

        $lista=$objActaInicio->listarFirmasPendientes2($id,12);



        $gerente=$objProyecto->retronarGerente($id);

        $jefe=$objProyecto->retornaJefe($id);



        $centrodecosto=$objProyecto->retornarCentroCostos($id);

        $correlativo=$this->traerCorrelatio($id);

        $anioproyecto=$objProyecto->retronarAnioProyecto($id);

        $ndocumento=$objProyecto->retornaNumeroProyecto($id);

        $idservicio=$objProyecto->retornarIdServicioProyecto($id);

        $abreviaturaservicio=$objProyecto->retornarAbreviaturaServicio($idservicio);

        $idcliente=$objProyecto->retronaIdClienteProyecto($id);

        $abrevcliente=$objProyecto->AbreviaturaCliente($idcliente);

        $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$correlativo;



        $objActaReu=new ActaReu_Ejecucion_Controller();

        $trabajadores=$objActaReu->cargarTrabajadores();

        $acta=$this->RetornarActaCierre($id);

        $entregables=$this->RetornarEntregables($id,12);

        $lecciones=$this->RetornarLecciones($id,12);



        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        // $numero=$objProyecto->AbreviaturaDocumento('12').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1';
        $numero=$objProyecto->AbreviaturaDocumento('12').strstr($nombreclave,'-').'-1';
        // dd($numero);

        $verificar=$this->VerificarDocumentos($id);



        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')

        ->join('persona','persona.idpersona','=','firmas.idtrabajador')

        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')

        ->join('area as a','a.idarea','=','trabajador.idarea')

        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')

        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')

        ->where('firmas.idestadofirma','!=','1')

        ->where('firmas.estado','=','1')

        ->where('trabajador.estado','1')

        ->where('persona.estado','1')

        ->where('firmas.idproyecto','=',$id)

        ->where('firmas.iddocumento','=',12)->get();


        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('cierre_actac',['id'=>$id,'numero'=>$numero,'datos'=>$datos,'trabajadores'=>$trabajadores,'lista'=>$lista,'acta'=>$acta,'entregables'=>$entregables,'lecciones'=>$lecciones,'carpeta'=>$carpeta,'gerente'=>$gerente,'jefe'=>$jefe,'nombreclave'=>$nombreclave,'verificar'=>$verificar,'centrodecosto'=>$centrodecosto,'listano'=>$listano,'doc_validados'=>$doc_validados]);

    }



    public function CargarAjax(Request $request){

        $ObjTrabajador=new TrabajadorController();

        if($request->op=="1"){



        }else if($request->op=="2"){



        }else if($request->op=="3"){



        }

    }





    public function ExportarExcel($id){

    $objProyecto=new ProyectoController();

    $objArea=new Area_Controller();

        //primero, consultamos el servicio

    $serv=$objProyecto->retornaServicioProyecto($id);

    $cli=$objProyecto->retronarClienteProyecto($id);

    $nom=$objProyecto->retronarNombreProyecto($id);

    $nomcla=$objProyecto->retronarNombreClaveProyecto($id);

        //armamos el nombre de la carpeta

    $anioproyecto=$objProyecto->retronarAnioProyecto($id);

    $ndocumento=$objProyecto->retornaNumeroProyecto($id);

    $idservicio=$objProyecto->retornarIdServicioProyecto($id);

    $abreviaturaservicio=$objProyecto->retornarAbreviaturaServicio($idservicio);

    $idcliente=$objProyecto->retronaIdClienteProyecto($id);

    $abrevcliente=$objProyecto->AbreviaturaCliente($idcliente);

    // $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$ndocumento;
    $correlativo=$this->traerCorrelatio($id);
    $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$correlativo;

    $gerente2=$objProyecto->retronarGerente($id);

    $jefe2=$objProyecto->retornaJefe($id);

    $centrodecosto=$objProyecto->retornarCentroCostos($id);

    $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

    $gerente=$objProyecto->retronarGerente($id);

    $jefe=$objProyecto->retornaJefe($id);

    //Retornar CODE

    // $numero=$objProyecto->AbreviaturaDocumento('8').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1';
    $numero=$objProyecto->AbreviaturaDocumento('12').strstr($nombreclave,'-').'-1';

    $datos=$objProyecto->retornarDatosProyecto($id);

    $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')

        ->join('persona','persona.idpersona','=','firmas.idtrabajador')

        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')

        ->join('area as a','a.idarea','=','trabajador.idarea')

        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')

        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')

        ->where('firmas.idestadofirma','!=','1')

        ->where('firmas.estado','=','1')

        ->where('firmas.idproyecto','=',$id)

        ->where('firmas.iddocumento','=',12)->get();

    //

        //tenemos que validar si es que ya existe...

        $acta=$this->RetornarActaCierre($id);

        $entregables=$this->RetornarEntregables($id,12);

        $lecciones=$this->RetornarLecciones($id,12);

        $descripcion="";

        $consecuencia="";

        $accion="";

        $concepto="";

        $etapa="";

        foreach ($lecciones as $row) {

            $etapa.="".$row->etapa."<br>";

            $descripcion.="".$row->descripcion."<br>";

            $consecuencia.="".$row->consecuencia."<br>";

            $accion.="".$row->accion."<br>";

            $concepto.="".$row->concepto."<br>";

        }

        $entregable="";

        foreach ($entregables as $row) {

            $entregable.="".$row->nombre."<br>";

        }


        // $idpersona_gerente=Trabajador::select('idpersona')->where('idpuesto',5)->where('estado',1)->first();
        $idpersona_gerente = Proyecto::join('persona','gerente','=','persona.idpersona')
                           ->join('trabajador','persona.idpersona','=','trabajador.idpersona')
                           ->where('idproyecto','=',$id)
                           ->where('persona.estado','=','1')
                           ->select('persona.*')
                           ->first();

        if (isset($idpersona_gerente)) {
          $gerente= Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')
                          ->join('persona','persona.idpersona','=','firmas.idtrabajador')
                          ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
                          ->join('area as a','a.idarea','=','trabajador.idarea')
                          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
                          ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
                          ->where('firmas.idestadofirma','=','3')
                          ->where('firmas.estado','=','1')
                          ->where('firmas.idproyecto','=',$id)
                          ->where('firmas.iddocumento','=',12)
                          ->where('firmas.idtrabajador',$idpersona_gerente->idpersona)
                          ->first();
        }else {
          $gerente = null;
        }

        // $idjeje=Proyecto::select('persona.idpersona')->join('persona','jefe','=','persona.idpersona')->join('trabajador','persona.idpersona','=','trabajador.idpersona')->where('idproyecto','=',$id)->where('persona.estado','=','1')->first();
        $idjeje = Proyecto::join('persona','jefe','=','persona.idpersona')
                          ->join('trabajador','persona.idpersona','=','trabajador.idpersona')
                          ->where('idproyecto','=',$id)
                          ->where('persona.estado','=','1')
                          ->select('persona.*')
                          ->first();

        $jefe= Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')
                     ->join('persona','persona.idpersona','=','firmas.idtrabajador')
                     ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
                     ->join('area as a','a.idarea','=','trabajador.idarea')
                     ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
                     ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
                     ->where('firmas.idestadofirma','=','3')
                     ->where('firmas.estado','=','1')
                     ->where('firmas.idproyecto','=',$id)
                     ->where('firmas.iddocumento','=',12)
                     ->where('firmas.idtrabajador',$idjeje->idpersona)->first();


        $idpersona_calidad=Trabajador::select('idpersona')->where('idpuesto',7)->where('estado',1)->first();



        $calidad= Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')

        ->join('persona','persona.idpersona','=','firmas.idtrabajador')

        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')

        ->join('area as a','a.idarea','=','trabajador.idarea')

        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')

        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')

        ->where('firmas.idestadofirma','=','3')

        ->where('firmas.estado','=','1')

        ->where('firmas.idproyecto','=',$id)

        ->where('firmas.iddocumento','=',12)

        ->where('firmas.idtrabajador',$idpersona_calidad->idpersona)->first();



        $idpersona_adm=Trabajador::select('idpersona')->where('idpuesto',6)->where('estado',1)->first();



        $adm= Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')

        ->join('persona','persona.idpersona','=','firmas.idtrabajador')

        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')

        ->join('area as a','a.idarea','=','trabajador.idarea')

        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')

        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')

        ->where('firmas.idestadofirma','=','3')

        ->where('firmas.estado','=','1')

        ->where('firmas.idproyecto','=',$id)

        ->where('firmas.iddocumento','=',12)

        ->where('firmas.idtrabajador',$idpersona_adm->idpersona)->first();



$html='';

$html.='

    <title>Acta Cierre</title>

    <style>

        *{

            box-sizing: border-box;

            font-family: Arial;

        }

        table{

            border-spacing: 0px;

        }

    </style>';



$html.='<table width="100%">';

$html.='<tr>';

$html.='<td width="20%" style="padding: 15px; border: 1px solid #000"><img src="logo.png" border="0" height="50" width="150" align="middle" /></td>';
// $html.='<td width="20%" style="padding: 15px; border: 1px solid #000"><img src="logo.png" border="0" height="50" width="150" align="middle" /></td>';

$html.='<td width="50%" style="border: 1px solid #000" colspan="2"><h2 style="text-align: center;  ">Acta de Cierre del Proyecto</h2></td>';

$html.='<td width="30%" valign="top" style="border: 1px solid #000"">Codigo:CIE-FOR-01 <br> Version: 03 <br> Fecha: 10/03/2017</td>';

$html.='</tr></table><br>';



$html.='<table width="100%">';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000" colspan="2">N° DE ACTA</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px ">'.$numero.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2">SERVICIO</td>';

$html.=' <td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$serv.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2">DESCRIPCIÓN</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000;padding: 8px; padding-left:5px;border-top: none; ">'.$acta->descripcion.'</td>';

$html.='</tr>';


$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2">TITULAR DEL PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$acta->titular.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >NOMBRE DEL PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$nom.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >NOMBRE CLAVE DEL PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$nomcla.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >CENTRO DE COSTOS</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$centrodecosto.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >NOMBRE DE CARPETA DEL PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$carpeta.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >GERENTE</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$gerente2.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >JEFE DE PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';

$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$jefe2.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2" >FECHA DE INICIO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
$date=date_create($acta->finicio);
$fini=$date->format('d-m-Y');
$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$fini.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2">FECHA DE ENTREGA AL CLIENTE</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
$date=date_create($acta->fentrega);
$fentre=$date->format('d-m-Y');
$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$fentre.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none;" colspan="2">FECHA DE CIERRE DEL PROYECTO</td>';

$html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
$date=date_create($acta->fcierre);
$fcie=$date->format('d-m-Y');
$html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; ">'.$fcie.'</td>';

$html.='</tr>';



$html.='</table>

    <br>';



$html.='<table width="100%">

        <tr>

            <td width="100%"  style="padding:8px; border: 1px solid #000 ; text-align: center" colspan="4"><strong>1. RESULTADOS:</strong> Los resultados con los objetivos iniciales del proyecto</td>

        </tr>';



$html.='<tr>';

$html.='<td width="100%" style="border: 1px solid #000; padding-left:5px;border-top: none;text-align: left;" colspan="4" >'.$acta->resultado.'</td>';

$html.='</tr>';



$html.='<tr>

            <td width="100%"  style="padding: 8px; border: 1px solid #000 ; text-align: center" colspan="4"><strong>2. OBSERVACIONES:</strong></td>

        </tr>';

$html.='<tr>';

$html.='<td width="100%" style="padding: 5px; border: 1px solid #000 ; text-align: left; border-top: none;" colspan="4" >'.$acta->observaciones.'</td>';

$html.='</tr>';



$html.='<tr>

            <td width="100%"  style="padding: 8px; border: 1px solid #000 ; text-align: center" colspan="4"><strong>3. ENTREGABLES:</strong></td>

        </tr>';

$html.='<tr>';

$html.='<td width="100%" style="padding: 5px; border: 1px solid #000 ; text-align: left; border-top: none;" colspan="4" >'.$entregable.'</td>';

$html.='</tr>';





$html.='<tr>

            <td width="100%"  style="padding: 8px; border: 1px solid #000 ; text-align: center" colspan="4"><strong>4. LECCIONES APRENDIDAS:</strong></td>

        </tr>';





$html.='<tr>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Etapa</strong></td>';

$html.='<td width="60%" style="padding: 5px; border: 1px solid #000 ; text-align: left ; border-top: none;" colspan="3" >'.$acta->etapa.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Descripción de la situación</strong></td>';

$html.='<td width="60%" style="padding: 5px; border: 1px solid #000 ; text-align: left ; border-top: none;" colspan="3" >'.$acta->descripcion2.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Consecuencia</strong></td>';

$html.='<td width="60%" style="padding: 5px; border: 1px solid #000 ; text-align: left ; border-top: none;" colspan="3" >'.$acta->consecuencia.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Acción Implementada</strong></td>';

$html.='<td width="60%" style="padding: 5px; border: 1px solid #000 ; text-align: left ; border-top: none;" colspan="3" >'.$acta->accion.'</td>';

$html.='</tr>';



$html.='<tr>';

$html.='<td width="40%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Concepto de Mejora/Recomendación</strong></td>';

$html.='<td width="60%" style="padding: 5px; border: 1px solid #000 ; text-align: left ; border-top: none;" colspan="3" >'.$acta->concepto.'</td>';

$html.='</tr>';



$html.='<tr>

            <td width="100%" style="padding: 8px; border: 1px solid #000 ; text-align: center" colspan="4"><strong>5.  FIRMAS </strong></td>

        </tr>';



$html.='<tr>

            <td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Gerencia</strong></td>

            <td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Jefe de Proyecto</strong></td>

            <td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Gerencia de Calidad</strong></td>

            <td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" ><strong>Gerencia de Administracion</td>

        </tr>';



$servidor=$_SERVER['SERVER_NAME'];

$html.='<tr>';



$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" >';

    if(!empty($gerente)) {

$html.='<img align="center" src="documentos/trabajador/'.$gerente->firma.'" width="95" height="83">';

    }

$html.='</td>';





$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" >';

    if(!empty($jefe)) {

$html.='<img align="center" src="documentos/trabajador/'.$jefe->firma.'" width="94" height="83">';

    }

$html.='</td>';





$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" >';

    if(!empty($calidad)) {

$html.='<img align="center" src="documentos/trabajador/'.$calidad->firma.'" width="115" height="83">';

    }

$html.='</td>';



$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" >';

    if(!empty($adm)) {

$html.='<img align="center" src="documentos/trabajador/'.$adm->firma.'" width="145" height="83">';

    }

$html.='</td>';



$date=date_create($acta->fcierre);

$freu=$date->format('d-m-Y');



$html.='</tr>';



$html.='<tr>';

$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" > Fecha: '.$freu.'</td>';

$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" > Fecha: '.$freu.'</td>';

$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" > Fecha: '.$freu.'</td>';

$html.='<td width="25%" style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;" > Fecha: '.$freu.'</td>';

$html.='</tr>';



$html.='</table>';

/////////////////////////////////////////////////////////////////////////////////////





$pdf = \App::make('dompdf.wrapper');

        $pdf->setPaper('A4','portrait');

        $pdf->loadHTML($html);

        return @$pdf->stream('Acta_Cierre.pdf');

}

}
