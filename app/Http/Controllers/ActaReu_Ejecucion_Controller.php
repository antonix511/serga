<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Acta_reunion;
use App\Persona;
use App\Firmas;
use App\Seguimiento_proyecto;
use App\Trabajador;
use App\Proyecto;
use App\Proyecto_doc_valida;
use App\Area;

use App\Versati;

class ActaReu_Ejecucion_Controller extends Controller
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
        $acta=Acta_reunion::create($request->all());
        $acta->save();
        DB::commit();
        $objActa=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActa->VerificarDocumentos($request->idproyecto);
        if ( ($verificar>0) && ($request->iddocumento==6) ) {
            $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
            $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }else{
            $objActaIni=new Acta_inicioController();
            $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
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
    public function retornarActaReunion($idproyecto){
        $req=Acta_reunion::with(['documento','area'])->where('acta_reunion.idproyecto','=',$idproyecto)->where('acta_reunion.iddocumento','=',6)->orderby('idacta_reunion','desc')->first();
        return $req;
    }
    public function cargarTrabajadores(){

        $trabajador = Persona::select('persona.idpersona as idpersona','persona.nombre as nombres','trabajador.apellidos as apellidos')->join('trabajador','trabajador.idpersona','=','persona.idpersona')
        ->where('persona.estado','=','1')->where('trabajador.estado','=','1')->orderBy('persona.nombre', 'asc')->get();

        return $trabajador;
    }

    public function ActualizarActa(Request $request){

         DB::beginTransaction();
        $actareu = Acta_reunion::where('idproyecto','=',$request->idproyecto)->where('iddocumento','=',$request->iddocumento)->where('nacata', $request->nacata)->update(['area_proyecto'=>$request->area_proyecto,'tema'=>$request->tema,'fecha'=>$request->fecha,'idencargado'=>$request->idencargado,'acciones'=>$request->acciones,'fecha_requerida'=>$request->fecha_requerida,'temas'=>$request->temas,'hora'=>$request->hora]);
        DB::commit();
        $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }

    }

    public function ejecucion_acta($id){
        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $cantidad=Acta_reunion::select('*')->where('idproyecto',$id)->count();
        $cantidad=($cantidad*1)+1;

        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();
        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();
        //fin area

        $nombrepro=Proyecto::select('nombre')->where('idproyecto',$id)->first();

        $acta=$this->retornarActaReunion($id);

        $trabajadores=$this->cargarTrabajadores();
        $idacta = $this->idacta('6');
        $objActaInicio=new Acta_inicioController();

        if(empty($idacta)){
            $idacta = 0;
            $lista = 0;
        }else{
            $lista=$objActaInicio->listarFirmasPendientes($id,6,$idacta);
        }

        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        // $numero=$objProyecto->AbreviaturaDocumento(6).'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-'.$cantidad;
        $numero=$objProyecto->AbreviaturaDocumento(6).'-'.substr($nombreclave,4).'-'.$cantidad;

        $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','6')->orderby('idacta_reunion','desc')->get();

        $nacata = Acta_reunion::select('nacata')->where('estado', '1')->where('iddocumento',6)->where('idproyecto', $id)->orderby('idacta_reunion','desc')->first();

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
        ->where('firmas.iddocumento','=',6)->get();

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('ejecucion_acta',['id'=>$id,'numero'=>$numero,'nacata'=>$nacata,'gerentesYJefes'=>$gerentesYJefes,'actaacu'=>$acta,'trabajadores'=>$trabajadores,'lista'=>$lista,'areas'=>$areas,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'listano'=>$listano,'nombrepro'=>$nombrepro,'doc_validados'=>$doc_validados]);
    }
    public function tabla_ejecu_acta_reu($id)
    {
      $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','6')->orderby('idacta_reunion','desc')->get();
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
           echo "<td>$row->nacata</td>";
           echo "<td class='text-center'>
         <button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc('$row->idacta_reunion')>Ver más</button>
           </td></tr>";
           $contador+=1;
         }
       }
     ?>
   </tbody>

 </table>
    <?php
    }

    public function idacta($id)
    {
      $idacta = Acta_reunion::select('*')->where('iddocumento', $id)->orderby('idacta_reunion','desc')->first();

      if(!empty($idacta)){
        return $idacta->idacta_reunion;
      }else {

      }
      // dd($idacta->idacta_reunion);
    }

    function AgregarFirmas(Request $request){
//    	echo "el id trabajador es: ".$request->idtrabajador;
  //  	    	echo "el documento es: ".$request->iddocumento;
    //	    	    	echo "el acta es: ".$request->idacta;
    	$trabajadorExiste = Firmas::where('idtrabajador', '=', $request->idtrabajador)->where('idacta', '=', $request->idacta)->where('iddocumento', '=', $request->iddocumento)->where('estado', '=', 1)->where('idproyecto', '=', $request->idproyecto)->select('idfirma')->get();
    	//echo "el numero de firmas es: ".count($trabajadorExiste);
    	//echo "el id existente es: ".$trabajadorExiste;
      // return response()->json( $trabajadorExiste );
      // return response()->json( ['1' => $request->idtrabajador, 'ds'=>$request->idacta, '20' =>$request->iddocumento]);

      if(count($trabajadorExiste) < 1){
        DB::beginTransaction();
        $firma = Firmas::create($request->all());
        $firma->save();
        DB::commit();
        }else{
        	return response()->json(['error' => 'Error msg'], 404);
        }
        $objActaInicio=new Acta_inicioController();
        $lista=$objActaInicio->listarFirmasPendientes($request->idproyecto,$request->iddocumento,$request->idacta);

        ?>

        <table id="myTable2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                foreach ($lista as $v ){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                        <td><?php echo $v['puesto'];?></td>
                        <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $request->idproyecto;?>);"></a></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
        <?php

    }
    function ActualizarFirmas(){

        ?>
        <table id="myTable2" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
            </tbody>
        </table>
        <?php
    }
    function listarFirmasNotificadas($idproyecto,$iddocumento){
        $lista = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',$idproyecto)
        ->where('firmas.iddocumento','=',$iddocumento)->get();

        return $lista;
    }
    function listarFirmasNotificadas_menu($idacta,$iddocumento){
        $lista = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',0)
        ->where('firmas.idacta','=',$idacta)
        ->where('firmas.iddocumento','=',$iddocumento)->get();

        return $lista;
    }
    function ActualizarNotificados(Request $request){


    $firmas=$this->listarFirmasNotificadas($request->idproyecto,$request->iddocumento);
    ?>

    <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Gerencia</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Correo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (count($firmas)==0){}
                            elseif(count($firmas)!=0){

                             $i=1;
                            foreach ($firmas as $eq) {  ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $eq->area;?></td>
                                    <td><?php echo $eq->nombres.' '.$eq->apellidos;?></td>
                                    <td><?php echo $eq->puesto;?></td>
                                    <td><?php echo $eq->correo;?></td>
                                    <td><?php echo $eq->estado;?></td>

                            </tr>
                            <?php $i++;
                            }

                            }
                            ?>

                            </tbody>
    <?php

    }
    function ActualizarNotificados_menu(Request $request){


    $firmas=$this->listarFirmasNotificadas_menu($request->idacta,$request->iddocumento);
    ?>

    <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Gerencia</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Correo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (count($firmas)==0){}
                            elseif(count($firmas)!=0){

                             $i=1;
                            foreach ($firmas as $eq) {  ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $eq->area;?></td>
                                    <td><?php echo $eq->nombres.' '.$eq->apellidos;?></td>
                                    <td><?php echo $eq->puesto;?></td>
                                    <td><?php echo $eq->correo;?></td>
                                    <td><?php echo $eq->estado;?></td>

                            </tr>
                            <?php $i++;
                            }

                            }
                            ?>

                            </tbody>
    <?php

    }
    function NotificarFirmas_menu(Request $request){

             session_start();
            $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
            $area=Area::select('nombre')->where('idarea',$request->idarea)->first();

            $personas=Firmas::select('persona.nombre as nombres','persona.correo as correo','persona.telefono as telefono','trabajador.apellidos as apellidos','proyecto.nombre as proyecto','firmas.idtrabajador as idtra')
            ->leftjoin('persona','persona.idpersona','=','firmas.idtrabajador')
            ->leftjoin('trabajador','trabajador.idpersona','=','persona.idpersona')
            ->leftjoin('proyecto','proyecto.idproyecto','=','firmas.idproyecto')
            ->where('persona.estado','=','1')
            ->where('trabajador.estado','1')
            ->where('firmas.idproyecto','=','0')
            ->where('firmas.idacta',$request->idacta)
            ->where('firmas.estado','=','1')
            ->where('firmas.idestadofirma','=','1')
            ->where('iddocumento','=','13')
            ->get();
            //modificamos a idestado 2, lo que tienen idestado 1 y estado 1 por el idporyecto
            DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
            $firma = Firmas::where('idproyecto','=',0)->where('idacta',$request->idacta)->where('idestadofirma','=','1')->where('estado','=','1')->where('iddocumento','=',$request->iddocumento)->update(['idestadofirma'=>'2']);
            DB::commit();

            $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
            foreach ($personas as $p) {
                $nombres= $p->nombres;
                $apellidos= $p->apellidos;
                $para= $p->correo;



                $telefono= $p->telefono;

                if (!empty($telefono)) {
                    Versati::_send_sms($telefono, 'SERGA: Acta de reunión del '.$area->nombre);
                }


                $titulo="Acta de Reunión del ".$area->nombre;


                $mensaje = '
                        <html>
                        <head>
                        <meta charset="utf-8">
                        <title>Firmas actas</title>
                        </head>
                        <body>
                         <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                        <p>Estimado(a):</p>
                        <p>Por medio del presente remite el Acta de Reunión del '.$area->nombre.', para la correspondiente aprobación.</p>
                        <p>Saludos,</p>
                         <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                        <p>'.$trabajador->puesto->nombre.'</p>
                        <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                        <p>T:'.$trabajador->persona->telefono.'</p>
                        <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                        <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                        <p>Web Site Serga: <a href="http://serga.jp-planning.com">serga.jp-planning.com</a></p>
                        </body>
                        </html>
                        ';
                    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                        // Cabeceras adicionales
                        $cabeceras .= 'To:' . "\r\n";
                        $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                // Enviarlo
                if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){

                echo 12;
                }
                else
                {
                    echo 0;
                }

                }

                ?>


                <?php

    }

    function NotificarFirmas(Request $request){



              $personas = Persona::select('persona.correo as correo','persona.telefono as telefono','persona.nombre as nombres','trabajador.apellidos as apellidos','proyecto.nombre as proyecto')
            ->join('trabajador','trabajador.idpersona','=','persona.idpersona')
            ->join('firmas','firmas.idtrabajador','=','trabajador.idpersona')
            ->join('proyecto','proyecto.idproyecto','=','firmas.idproyecto')
            ->where('persona.estado','=','1')->where('trabajador.estado','1')->where('firmas.idproyecto','=',$request->idproyecto)
            ->where('firmas.estado','=','1')->where('firmas.idestadofirma','=','1')->where('iddocumento','=',$request->iddocumento)->get();
            //modificamos a idestado 2, lo que tienen idestado 1 y estado 1 por el idporyecto
            DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
            $firma = Firmas::where('idproyecto','=',$request->idproyecto)->where('idestadofirma','=','1')->where('estado','=','1')->where('iddocumento','=',$request->iddocumento)->update(['idestadofirma'=>'2']);
            DB::commit();
            $proyectoo=Proyecto::select('nombre','centrodecosto')->where('idproyecto',$request->idproyecto)->first();
            $namepro=$proyectoo->nombre;
            session_start();
            $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
            if($request->iddocumento==7){
                    foreach ($personas as $p) {
                        $nombres= $p['nombres'];
                        $apellidos= $p['apellidos'];
                        $para= $p['correo'];
                        $telefono= $p['telefono'];
                        $proyecto= $p['proyecto'];

                        if (!empty($telefono)) {
                            Versati::_send_sms($telefono, 'SERGA: Solicitud de cambio para proyecto '.$proyecto);
                        }

                        $titulo="Solicitud de Cambio del proyecto ".$namepro;


                        $mensaje = '
                        <html>
                        <head>
                        <meta charset="utf-8">
                        <title>Firmas actas</title>
                        </head>
                        <body>
                         <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                        <p>Estimado(a): '.$nombres.' '.$apellidos.':</p>
                        <p>Por medio del presente remito la Solicitud de Cambio del proyecto '.$proyecto.', para la correspondiente aprobación.</p>
                        <p>Saludos,</p>
                        <div><p>
                        </p></div>
                        <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                        <p>'.$trabajador->puesto->nombre.'</p>
                        <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                        <p>T:'.$trabajador->persona->telefono.'</p>
                        <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                        <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                        <p>Web Site Serga: <a href="http://serga.jp-planning.com">serga.jp-planning.com</a></p>
                        </body>
                        </html>
                        ';

                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                        // Cabeceras adicionales
                        $cabeceras .= 'To:' . "\r\n";
                        $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                        /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                        $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                        // Enviarlo
                        if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){

                        echo 1;
                        }
                        else
                        {
                            echo 1;
                        }

                        }

                        ?>     <?php

                }
                if($request->iddocumento==13 || $request->iddocumento==6){
                    foreach ($personas as $p) {
                        $nombres= $p['nombres'];
                        $apellidos= $p['apellidos'];
                        $para= $p['correo'];
                        $proyecto= $p['proyecto'];

                        $telefono= $p['telefono'];

                        if (!empty($telefono)) {
                            Versati::_send_sms($telefono, 'SERGA: Acta de reunión del proyecto '.$proyecto);
                        }


                        $titulo="Acta de Reunión del proyecto ".$namepro;

                        $mensaje = '
                        <html>
                        <head>
                        <meta charset="utf-8">
                        <title>Firmas actas</title>
                        </head>
                        <body>
                        <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                        <p>Estimado(a): '.$nombres.' '.$apellidos.':</p>

                        <p>Por medio del presente remite el Acta de Reunión del proyecto '.$proyecto.' , para la correspondiente aprobación.</p>

                        <p>Saludos,</p>
                        <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                        <p>'.$trabajador->puesto->nombre.'</p>
                        <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                        <p>T:'.$trabajador->persona->telefono.'</p>
                        <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                        <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                        <p>Web Site Serga: <a href="http://serga.jp-planning.com">serga.jp-planning.com</a></p>
                        </body>
                        </html>
                        ';

                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                        // Cabeceras adicionales
                        $cabeceras .= 'To:' . "\r\n";
                        $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                        /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                        $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                        // Enviarlo
                        if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){

                        echo 1;
                        }
                        else
                        {
                            echo 1;
                        }

                        }

                        ?>     <?php

                }
                if($request->iddocumento==12){
                    foreach ($personas as $p) {
                        $nombres= $p['nombres'];
                        $apellidos= $p['apellidos'];
                        $para= $p['correo'];
                        $proyecto= $p['proyecto'];

                        $telefono= $p['telefono'];

                        if (!empty($telefono)) {
                            Versati::_send_sms($telefono, 'SERGA: Acta de cierre del proyecto '.$proyecto);
                        }


                        $titulo="Acta de Cierre del proyecto ".$namepro;

                        $mensaje = '
                        <html>
                        <head>
                        <meta charset="utf-8">
                        <title>Firmas actas</title>
                        </head>
                        <body>

                       <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                        <p>Estimado(a): '.$nombres.' '.$apellidos.':</p>

                        <p>Por medio del presente remite el Acta de Reunión del proyecto '.$proyecto.' , para la correspondiente aprobación.</p>

                        <p>Saludos,</p>
                        <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                        <p>'.$trabajador->puesto->nombre.'</p>
                        <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                        <p>T:'.$trabajador->persona->telefono.'</p>
                        <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                        <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                        <p>Web Site Serga: <a href="http://serga.jp-planning.com">serga.jp-planning.com</a></p>
                        </body>
                        </html>
                        ';

                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                        // Cabeceras adicionales
                        $cabeceras .= 'To:' . "\r\n";
                        $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                        /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                        $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                        // Enviarlo
                        if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){

                        echo 1;
                        }
                        else
                        {
                            echo 0;
                        }

                        }

                        ?>     <?php

                }

    }


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
        $numero=$objProyecto->AbreviaturaDocumento('6').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-5';
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();
        $nombre_pro=Proyecto::select('nombre')->where('proyecto.idproyecto','=',$id)->where('proyecto.estado','=','1')->first();

        //participantes
        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma','firmas.idestadofirma as idestadofirma')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',$id)
        ->where('firmas.iddocumento','=',6)->get();
        //


        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();
        //fin area

        $actaacu=$this->retornarActaReunion($id);

        $trabajadores=$this->cargarTrabajadores();
        $objActaInicio=new Acta_inicioController();
        $idacta = $this->idacta('6');

$html='
    <title>Acta de Reunión de Ejecución</title>
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
    $html.='<table width="100%">';
        $html.='<tr>
            <td width="50%" style="padding: 15px; border: 1px solid #000"><img src="logo.png" border="0" height="70" width="210" align="middle" /></td>
            <td width="50%" colspan="3" style="border: 1px solid #000; font-size:15.5pt"><strong><center>Acta de Reunión</center></strong></td>
            <td width="20%" colspan="3" valign="top" style="border: 1px solid #000;font-size:10pt"><br><br>Código: SGC-FOR-21 <br> Versión: 01</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>N°</strong></td>
            <td width="70%" colspan="6" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$actaacu->nacata.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>ÁREA/PROYECTO</strong></td>
            <td width="70%" colspan="6" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$nombre_pro->nombre.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>TEMA DE LA REUNIÓN</strong></td>
            <td width="70%" colspan="6" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$actaacu->tema.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>FECHA</strong></td>
            <td width="40%" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">';
                  $date=date_create($actaacu->fecha);
                $freu=$date->format('d-m-Y');
                $html.=$freu;

                $horas=substr($actaacu->hora,0,2);
                  $minutos=substr($actaacu->hora,0-2);
                  $horas=$horas*1;
                  $cosa="";
                  if($horas>11){
                    $horas=$horas-12;
                    $cosa=" a.m.";
                  }else{
                    $cosa=" p.m.";
                  }
$html.='</td>
            <td width="10%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>HORA</strong></td>
            <td width="20%" colspan="5" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$horas.':'.$minutos.$cosa.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>ENCARGADO DE ÁREA/PROYECTO</strong></td>
            <td width="50%" colspan="6" style="border: 1px solid #000 ;font-size:10pt; padding-left: 15px">';
                    foreach ($gerentesYJefes as $gerentesYJefes) {
                        if ($actaacu->idencargado==$gerentesYJefes->idpersona) {
                            $html.= $gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos;
                        }
                    }
            $html.='</td>
        </tr>';
$html.='<tr>
            <td width="100% " class="negrita" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>PARTICIPANTES:</strong></td>
        </tr>
        <tr>
            <td width="50%" class="negrita" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>Nombre:</strong></td>
            <td width="50%" class="negrita" colspan="5" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt"><strong>Cargo:</strong></td>
        </tr>';
               foreach ($listano as $v) {
                        $html.="<tr>";
                        $html.='<td width="50%" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$v->nombres.' '.$v->apellidos.'</td>';
                        $html.='<td width="50%" colspan="5" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$v->puesto.'</td>';
                        $html.="</tr>";
                    }
$html.='<tr>
            <td width="30%" class="negrita" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>TEMAS TRATADOS:</strong></td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$actaacu->temas.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>ACCIONES:</strong></td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$actaacu->acciones.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>FECHA REQUERIDA:</strong></td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="7" style="padding: 8px; border: 1px solid #000;font-size:10pt">';
                $datee=date_create($actaacu->fecha_requerida);
                $freuu=$datee->format('d-m-Y');
                $html.= $freuu;
$html.='</td>
        </tr>
    </table>
    <br>';
$html.='<table width="100%">
    <tr>
        <td width="30%" class="negrita" colspan="3" style="padding: 8px; border: 1px solid #000;font-size:10pt"><strong>FIRMAS:</strong></td>
    </tr>';

    for ($i=0; $i <count($listano) ; $i=$i+3) {
        $html .= "<tr>";
        if (!empty($listano[$i])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$listano[$i]["puesto"].'</td>';
        }
        if (!empty($listano[$i + 1])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$listano[$i+1]["puesto"].'</td>';
        }
        if (!empty($listano[$i + 2])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$listano[$i+2]["puesto"].'</td>';
        }
        $html .= "</tr>";
        $html .= "<tr>";
        if (!empty($listano[$i])) {

            $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt">';
            if($listano[$i]["idestadofirma"]==3){
            $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i]["firma"] . '" alt="">';
            }
            $html .= "</td>";

            if (!empty($listano[$i + 1])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt">';
                if($listano[$i+1]["idestadofirma"]==3){
                $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i + 1]["firma"] . '" alt="">';
                }
                $html .= "</td>";

            }

            if (!empty($listano[$i + 2])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt">';
                if($listano[$i+2]["idestadofirma"]==3){
                $html .= '<img style="width: 115px; height: 83px;" width="115" height="83"  src="documentos/trabajador/' . $listano[$i + 2]['firma'] . '" alt="">';
            }
                $html .= "</td>";
            }
            $html .= '</tr>';
        }
    }
$html.='</table>';
$pdf = \App::make('dompdf.wrapper');
$pdf->setPaper('A4','portrait');
$pdf->loadHTML($html);
return @$pdf->stream('Acta_Reunion.pdf');
    }
}
