<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TrabajadorController;
use App\Cliente;
use App\Persona;
use App\Proyecto;
use App\Proyecto_doc_valida;
use App\Ubicacion;
use App\Tipo_contrato;
use App\Tipo_proyecto;
use App\Servicio;
use App\Trabajador;
use App\Puesto;
use App\Fase;
use App\Seguimiento_proyecto;
use App\Documento_proyecto;
use App\Equipo_trabajo;

use App\Centro_costos;
use App\Documento;
use App\Area;
use App\Firmas;
use App\Estado_firma;
use App\Moneda;
use App\Departamento;
use App\Provincia;
use App\Distrito;

use App\Versati;

use Auth;

use App\Acta_inicio;
use App\Matriz_comunicacion;
use App\Matriz_roles;
use App\Req_logistica;
use App\Req_cartografia;
use App\Acta_reunion;
use App\Solicitud_cambio;
use App\Acta_acuerdo;
use App\Reporte_ho;
use App\Solicitud_ac;
use App\Modelos;
use App\Acta_cierre;
use App\Matriz_Riesgos;

class ProyectoController extends Controller
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
        $numero=$this->traerindicefinal($request->idcliente,$request->idservicio);
        DB::beginTransaction();
        $proyecto = Proyecto::create($request->all());
        $seguimiento_proyecto = new Seguimiento_proyecto($request->all());
        $seguimiento_proyecto->idfase=1;
        $idcliente=$request->idcliente;
        $idtipoproyecto=$request->idtipoproyecto;
        $notificar=$request->notificar;
        $idservicio=$request->idservicio;
        $proyecto->notificar=$notificar;
        $proyecto->anio=date("Y");
        $proyecto->correlativo=$numero;
        $proyecto->ndocumento = $this->GenerarCodigo();
        // $code=$this->AbreviaturaDocumento('14').'-'.$this->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$this->retornarAbreviaturaServicio($idservicio).'-'.$numero;
        $code=$this->AbreviaturaDocumento('14').'-'.$this->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$this->retornarAbreviaturaServicio($idservicio).$numero;
        $proyecto->code=$code;
        $proyecto->nombreclave=$code;
        $proyecto->observacion = $request->observacion;
        $proyecto->Seguimiento_proyecto()->save($seguimiento_proyecto);
        $proyecto->save();
        DB::commit();

        $data_docvalida = [];

        if($idtipoproyecto==1){
            $data_docvalida = [
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>1, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>2, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>3, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>15, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>4, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>5, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>6, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>13, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>7, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>8, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>9, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>10, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>12, 'valida'=>1]
            ];
        }elseif($idtipoproyecto==2){
            $data_docvalida = [
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>1, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>2, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>3, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>15, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>4, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>5, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>6, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>13, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>7, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>8, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>9, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>10, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>12, 'valida'=>1]
            ];
        }elseif($idtipoproyecto==3){
            $data_docvalida = [
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>1, 'valida'=>1],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>2, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>3, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>15, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>4, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>5, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>6, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>13, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>7, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>8, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>9, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>10, 'valida'=>0],
                ['idproyecto'=>$proyecto->idproyecto, 'iddocumento'=>12, 'valida'=>1]
            ];
        }

        if(count($data_docvalida)>0){
            Proyecto_doc_valida::insert($data_docvalida);
            DB::commit();
        }



        $nomcliente=Persona::select('nombre')->where('idpersona',$request->idcliente)->where('estado',1)->first();
         session_start();
            $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();




        if(!empty($request->notificar2)){
            if (!empty($request->celular)) {
                Versati::_send_sms($request->celular, 'SERGA: Proyecto registrado para la empresa '.$nomcliente->nombre);
            }

            if (!empty($request->celular2)) {
                Versati::_send_sms($request->celular2, 'SERGA: Proyecto registrado para la empresa '.$nomcliente->nombre);
            }
        }


        if(!empty($request->notificar)){
                    if (!empty($request->correo)) {
                        $para= $request->correo;
                        $proyecto= $request->nombre;
                        $titulo=$code;


                        $mensaje = '
                        <html>
                        <head>
                        <meta charset="utf-8">
                        </head>
                        <body>
                       <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                        <p>Estimados:</p>
                        <p>Por medio del presente, comunico la información de proyecto respecto del servicio a ejecutar para la empresa '.$nomcliente->nombre.'. Cualquier consulta quedo atenta.</p>

                        <p>Atentamente.</p>
                         <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                <p>'.$trabajador->puesto->nombre.'</p>
                <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                <p>T:'.$trabajador->persona->telefono.'</p>
                <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                        </body>
                        </html>
                        ';

                        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                        // Cabeceras adicionales
                        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $cabeceras .= 'To:' . "\r\n";
                        $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                        /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                        $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                         // Enviarlo
                        if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){
                        ?><script type="text/javascript">swal("Enviados", "Correos enviados correctamente", "success");</script><?php
                        }else{
                        ?><script type="text/javascript">swal("Enviados", "Error al Envíar correos", "error");</script><?php
                        }
                    }

                    if (!empty($request->correo2)) {
                       $para= $request->correo2;
                $proyecto= $request->nombre;
                $titulo=$code;


                $mensaje = '
                <html>
                <head>
                <meta charset="utf-8">
                </head>
                <body>
                 <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                <p>Estimados:</p>
                <p>Por medio del presente, comunico la información de proyecto respecto del servicio a ejecutar para la empresa '.$nomcliente->nombre.'. Cualquier consulta quedo atenta.</p>

                <p>Atentamente.</p>
                <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                <p>'.$trabajador->puesto->nombre.'</p>
                <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                <p>T:'.$trabajador->persona->telefono.'</p>
                <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                </body>
                </html>
                ';

                // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                // Cabeceras adicionales
                // Cabeceras adicionales
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $cabeceras .= 'To:' . "\r\n";
                $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                 // Enviarlo
                if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){
                ?><script type="text/javascript">swal("Enviados", "Correos enviados correctamente", "success");</script><?php
                }else{
                ?><script type="text/javascript">swal("Enviados", "Error al Envíar correos", "error");</script><?php
                }
                    }
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
    public function traerindicefinal($idcliente,$idservicio)
    {
    	$numero=Proyecto::select('*')->where('idcliente',$idcliente)->where('idservicio',$idservicio)->where('estado',1)->count();
        return $numero+1;
    }


    public function traerindicefinalCorrecto($idproyecto)
    {

    	//echo "el proyecto es: ".$idproyecto;
        $numero=Proyecto::select('code')->where('idproyecto',$idproyecto)->where('estado',1)->get();
        //echo "el code es: ".$numero[0]['code'];
        $numeroTemporal = $numero[0]['code'];
        $numero = substr($numeroTemporal, -1);
        //echo "el numero es: ".$numero;
        return $numero;
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

    }

    public function AbreviaturaTipo($idtipoproyecto){
        $abretipo = Tipo_proyecto::select('abreviatura')->where('estado','=','1')->where('idtipoproyecto','=',$idtipoproyecto)->take(1)->get();
        if(count($abretipo)==0){
        $abrevt='';
        }else{
        $abrevt=$abretipo[0]->abreviatura;
        }
        return $abrevt;
    }
    public function AbreviaturaDocumento($iddocumento){
        $abretipo = Documento::select('abreviatura')->where('estado','=','1')->where('iddocumento','=',$iddocumento)->first();
        $abrevt=$abretipo->abreviatura;
        return $abrevt;
    }

    public function AbreviaturaCliente($idcliente){
        $abreviatura = Cliente::select('abreviatura')->where('estado','=','1')->where('idpersona','=',$idcliente)->take(1)->get();
        if(count($abreviatura)==0){
        $abrev='';
        }else{
        $abrev=$abreviatura[0]->abreviatura;
        }
        return $abrev;
    }
    function retornaActaInicioOK($idproyecto,$iddocumento){
        $acta=Acta_inicio::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;

    }
    function retornaMatrizComuOK($idproyecto,$iddocumento){

        $acta=Matriz_comunicacion::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaMatrizRolOK($idproyecto,$iddocumento){
        $acta=Matriz_roles::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaReqLogisOK($idproyecto,$iddocumento){
        $acta=Req_logistica::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaReqCartOK($idproyecto,$iddocumento){
        $acta=Req_cartografia::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }

    function retornaSolCambioOK($idproyecto,$iddocumento){
        $acta=Solicitud_cambio::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaActaAcuerdoOK($idproyecto,$iddocumento){
        $acta=Acta_acuerdo::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaReporteHoOK($idproyecto,$iddocumento){
        $acta=Reporte_ho::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaSolAcOK($idproyecto,$iddocumento){
        $acta=Solicitud_ac::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }


    function retornaActaCierreOK($idproyecto,$iddocumento){
        $acta=Acta_cierre::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }
    function retornaActaReuOK($idproyecto,$iddocumento){
        $acta=Acta_reunion::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        return $acta;
    }

    function retornaMatrizRiesOK($idproyecto,$iddocumento){
        $acta=Matriz_Riesgos::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
            return $acta;
    }

    public function ContactoCliente($idcliente){
        $contacto = Cliente::select('contacto')->where('idpersona','=',$idcliente)->where('estado','=','1')->take(1)->get();
        if(count($contacto)==0){
        $contac='';
        }else{
        $contac=$contacto[0]->contacto;
        }
        return $contac;
    }

    public function GenerarCodigo(){
        $codigo = Proyecto::select('ndocumento')->where('estado','=','1')->where('anio','=',date("Y"))->orderBy('ndocumento','desc')->take(1)->get();

        if(count($codigo)==0){
            $cod=1;
        }else{
            $cod =$codigo[0]->ndocumento + 1;
        }
        if($cod==0){
            $cod=$cod+1;
        }
        return $cod;

    }

    public function listarProyectos(){
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="seguimiento") {
                /*$fechainicio= date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) );;
                $fechafin=date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) );;
                $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q){$q->where('estado','=',1)->orderby('fecha','desc');})
                            ->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();
                foreach ($proyecto as $obj) {
                  $obj->proyecto->nombre_cliente = $this->retronarClienteProyecto($obj->idproyecto);
                  $obj->proyecto->tipo_proyecto = Tipo_proyecto::find($obj->proyecto->idtipoproyecto)->nombre;
                  $obj->proyecto->centro_costos = $this->retornarCentroCostos($obj->idproyecto);
                  // dd($obj);
                }*/
                $proyecto = [];
                return view('seguimiento', ['proyectos' => $proyecto]);
            }
        }
        ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php

    }
    public function listarProyectosBusqueda(){
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="busqueda") {
                $fechainicio= date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) );;
                $fechafin=date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) );;
                $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin){$q->where('estado','=',1);})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('estado','=','1')->orderBy('idseguimiento','desc')->get();
                $depa=$this->cargarDepartamentos();
                $cli=$this->cargarClientes();

                return view('busqueda', ['proyectos' => $proyecto,'depa'=>$depa,'cli'=>$cli]);
            }
        }
        ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php

    }
    public function RetornarIdPersonaUsuario($usuario)
    {

        $idpersona=Trabajador::select('idpersona')->where('usuario','=',$usuario)->first();
        return $idpersona->idpersona;
    }
    public function listarProyectosCentro(){

        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);

        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="listracentrocostos") {
                $idpersona=$this->RetornarIdPersonaUsuario($usuario);
                $fechainicio= date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) );;
                $fechafin=date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) );;

                $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$idpersona){$q->where('fecha', '>=', $fechainicio)->where('fecha', '<=', $fechafin)->where('estado',1)->where(
                    function ($qu) use ($idpersona){$qu->orwhere('idtrabajador','=',$idpersona)->orwhere('idtrabajador2','=',$idpersona);
                })
                ;})
                ->with(['proyecto','fase'] )->where('estado', '=', '1')->where('estado','=','1')->orderBy('idseguimiento','desc')->get();

                return view('listacentrocostos', ['proyectos' => $proyecto]);
            }
        }
         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php

    }
    public function listarProyectosFiltroCentro($fechainicio,$fechafin,$fase)
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $idpersona=$this->RetornarIdPersonaUsuario($usuario);
        if($fase==0){
            $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$idpersona){$q->where('fecha', '>=', $fechainicio)->where('fecha', '<=', $fechafin)->where(
                    function ($qu) use ($idpersona){$qu->orwhere('idtrabajador','=',$idpersona)->orwhere('idtrabajador2','=',$idpersona);
                })
                ;})
                ->with(['proyecto','fase'] )->where('estado', '=', '1')->where('estado','=','1')->orderBy('idseguimiento','desc')->get();
        }else{
            $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$idpersona){$q->where('fecha', '>=', $fechainicio)->where('fecha', '<=', $fechafin)->where(
                    function ($qu) use ($idpersona){$qu->orwhere('idtrabajador','=',$idpersona)->orwhere('idtrabajador2','=',$idpersona);
                })
                ;})
                ->with(['proyecto','fase'] )->where('estado', '=', '1')->where('estado','=','1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();
        }
        return $proyecto;

    }

    public function listarProyectosFiltro($fechainicio,$fechafin,$fase, $vs = null, $vc = null) {
        if($fase==0){
            $proyecto = Seguimiento_proyecto::with(['proyecto','Fase'])
                //->join('proyecto', 'proyecto.id', '=', 'seguimiento_proyecto.idproyecto')
                //->whereBetween('fecha_registro', [$fechainicio.' 00:00:00',$fechafin.' 23:59:59'])
                ->wherehas('proyecto', function($q) use ($fechainicio, $fechafin, $vs, $vc){
                    $q->where('proyecto.estado','1');
                    
                    if($fechainicio!='' && $fechafin!='') {
                        $q->whereBetween('fecha', [$fechainicio.' 00:00:00',$fechafin.' 23:59:59']);
                    }
                })
                ->where('seguimiento_proyecto.estado', '=', '1');
            $proyecto = $proyecto->orderBy('idseguimiento','desc')
                           ->get();
        } else {
            $proyecto = Seguimiento_proyecto::with(['proyecto','Fase'])
                //->join('proyecto', 'proyecto.id', '=', 'seguimiento_proyecto.idproyecto')
                //->whereBetween('fecha_registro', [$fechainicio.' 00:00:00',$fechafin.' 23:59:59'])
                ->wherehas('proyecto', function($q) use ($fechainicio, $fechafin) {
                    $q->where('proyecto.estado','1');
                    
                    if($fechainicio != '' && $fechafin != '') {
                        $q->whereBetween('fecha', [$fechainicio.' 00:00:00', $fechafin . ' 23:59:59']);
                    }
                })
                ->where('seguimiento_proyecto.estado', '=', '1')
                ->where('idfase', '=', $fase);
            if (!is_null($vs)) {
                $proyecto->where('vs', $vs);
            }
            if (!is_null($vc)) {
                $proyecto->where('vc', $vc);
            }

            $proyecto = $proyecto->orderBy('idseguimiento','desc')
                        ->get();
        }

        return $proyecto;


    }

    public function cargarTrabajadores(){

        $trabajador = Persona::has('trabajador.puesto')->whereHas('trabajador', function ($q) {
        $q->where('puesto.tipo', '=', '3')->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')->where('trabajador.estado','=','1');})->where('persona.estado','1')->orderBy('nombre', 'asc')->get();
        return $trabajador;
    }
    public function cargarTodosTrabajadores(){

        $trabajador = Persona::has('trabajador')->whereHas('trabajador', function ($q) {
        $q->where('trabajador.estado','=','1');})->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        return $trabajador;
    }

    //+++********PARA CENTRO DE COSTOS
    public function cargarTodosTrabajadores2(){

        $trabajador = Persona::select('persona.idpersona as idpersona','persona.nombre as nombres','trabajador.apellidos as apellidos')->join('trabajador','trabajador.idpersona','=','persona.idpersona')->where('persona.estado','=','1')->where('trabajador.estado','=','1')->orderBy('persona.nombre', 'asc')->get();
        return $trabajador;
    }


    public function cargarGerentes(){

        $gerente = Persona::has('trabajador.puesto')->whereHas('trabajador', function ($q) {
        $q->where('puesto.tipo', '=', '1')->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')->where('trabajador.estado','=','1');})->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        return $gerente;
    }

    public function cargarJefes(){

        $jefe = Persona::has('trabajador.puesto')->whereHas('trabajador', function ($q) {
        $q->where('puesto.tipo', '=', '2')->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')->where('trabajador.estado','=','1');})->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        return $jefe;
    }
     public function cargarGerentesYJefes(){

        $jefe = Persona::has('trabajador.puesto')->whereHas('trabajador', function ($q) {
        $q->where('puesto.tipo', '!=', '3')->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')->where('trabajador.estado','=','1');})->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        return $jefe;
    }

    public function cargarDepartamento($id){
        $depa = Proyecto::select('departamento.nombre as nombre')->join('departamento','departamento.iddepartamento','=','proyecto.iddepartamento')
        ->where('proyecto.idproyecto','=',$id)->where('proyecto.estado','=','1')->get();

        if(count($depa)==0){
        $depa='';
        }else{
        $depa=$depa[0]->nombre;
        }
        return $depa;


    }
    public function consultarProvincia($id){
        $prov = Proyecto::select('provincia.nombre as nombre')->join('provincia','provincia.idprovincia','=','proyecto.idprovincia')
        ->where('proyecto.idproyecto','=',$id)->where('proyecto.estado','=','1')->get();

        if(count($prov)==0){
        $prov='';
        }else{
        $prov=$prov[0]->nombre;
        }
        return $prov;


    }

    public function consultarDistrito($id){
        $dis = Proyecto::select('distrito.nombre as nombre')->join('distrito','distrito.iddistrito','=','proyecto.iddistrito')
        ->where('proyecto.idproyecto','=',$id)->where('proyecto.estado','=','1')->get();

        if(count($dis)==0){
        $dis='';
        }else{
        $dis=$dis[0]->nombre;
        }
        return $dis;


    }


    public function cargarClientes(){
        $cliente = Persona::has('cliente')->where('estado','=','1')->orderBy('nombre', 'asc')->get();
        return $cliente;
    }
    public function cargarServicio(){
        $servicio = Servicio::orderBy('nombre','asc')->where('estado','=','1')->get();
        return $servicio;
    }
    public function cargarMonedas(){
        $moneda = Moneda::orderBy('idmoneda','asc')->where('estado','=','1')->get();
        return $moneda;
    }
    public function cargarDepartamentos(){
        $depa = Departamento::orderBy('nombre','asc')->get();
        return $depa;

    }
    public function cargarProvincia($iddepartamento){
        $prov = Provincia::orderBy('nombre','asc')->where('iddepartamento','=',$iddepartamento)->get();
        return $prov;
    }
    public function cargarDistrito($idprovincia){
        $prov = Distrito::orderBy('nombre','asc')->where('idprovincia','=',$idprovincia)->get();
        return $prov;
    }

    public function CargarCombos () {
        session_start();
        $usuario = $_SESSION['usuario'];
        $objComite = new Comite_controller();
        $DataUsuario = $objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="proyectos") {

                $cod=$this->GenerarCodigo();
                $cliente=$this->cargarClientes();
                $servicio=$this->cargarServicio();
                $ubicacion = Ubicacion::all();
                $gerente=$this->cargarGerentes();
                $jefe=$this->cargarJefes();
                $tipoproyecto = Tipo_proyecto::all();
                $tipocontrato = Tipo_contrato::all();
                $trabajador=$this->cargarTodosTrabajadores();
                $moneda=$this->cargarMonedas();
                $depa=$this->cargarDepartamentos();
                $trabajador2=$this->cargarTodosTrabajadores();


                return view('proyectos', ['cliente' => $cliente,'servicio' => $servicio,'ubicacion' => $ubicacion
                    ,'gerente' => $gerente,'jefe' => $jefe,'tipoproyecto' => $tipoproyecto,'tipocontrato' => $tipocontrato
                    ,'trabajador' => $trabajador,'ndocumento' => $cod,'moneda'=>$moneda,'depa'=>$depa,'trabajador2'=>$trabajador2]);
            }
        }
        ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php


    }

    public function retronarGerente($id){

        $cliente = Proyecto::select('persona.nombre','trabajador.apellidos')->join('persona','gerente','=','persona.idpersona')->join('trabajador','persona.idpersona','=','trabajador.idpersona')
        ->where('idproyecto','=',$id)->where('persona.estado','=','1')->get();
        //dd($cliente);
        if(count($cliente)==0){
            $cli='';
        }else{
            $cli=$cliente[0]->nombre.' '.$cliente[0]->apellidos;
        }
        return $cli;
    }

    public function retornaJefe($id){

        $cliente = Proyecto::select('persona.nombre','trabajador.apellidos')->join('persona','jefe','=','persona.idpersona')->join('trabajador','persona.idpersona','=','trabajador.idpersona')
        ->where('idproyecto','=',$id)->where('persona.estado','=','1')->get();
        //dd($cliente);
        if(count($cliente)==0){
            $cli='';
        }else{
            $cli=$cliente[0]->nombre.' '.$cliente[0]->apellidos;
        }
        return $cli;
    }


    public function retronarNombreProyecto($id){
        $nombre = Proyecto::select('nombre')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($nombre)==0){
            $nom='';
        }else{
            $nom=$nombre[0]->nombre;
        }
        return $nom;
    }


    public function retronarNombreClaveProyecto($id){

        $resultado = Proyecto::select('nombreclave')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->nombreclave;
        }
        return $valor;
    }

    public function retornarDatosProyecto($idproyecto){

        $resultado = Proyecto::with(['servicio'])->where('idproyecto','=',$idproyecto)->first();
        //dd($cliente);
        if(@count($resultado)>0){
            return $resultado;
        }else{
            return null;
        }

    }
    public function retornaNumeroProyecto($id){

        $resultado = Proyecto::select('ndocumento')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->ndocumento;
        }
        return $valor;
    }
    public function retronaIdClienteProyecto($id){

        $resultado = Proyecto::select('idcliente')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->idcliente;
        }
        return $valor;
    }
    public function retornarIdServicioProyecto($id){

        $resultado = Proyecto::select('idservicio')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->idservicio;
        }
        return $valor;
    }

    public function retornarAbreviaturaServicio($id){

        $resultado = Servicio::select('abreviatura')->where('estado','=','1')->where('idservicio','=',$id)->first();
        //dd($cliente);
        if(@count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado->abreviatura;
        }
        return $valor;
    }
    public function retronarAnioProyecto($id){

        $resultado = Proyecto::select('anio')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($cliente);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->anio;
        }
        return $valor;
    }

    public function retornarCentroCostos($id){

        $resultado = Proyecto::select('centrodecosto')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        //dd($resultado);
        if(count($resultado)==0){
            $valor='';
        }else{
            $valor=$resultado[0]->centrodecosto;
        }
        return $valor;
    }
     public function retornaServicioProyecto($id){
        $proyecto = Proyecto::with(['servicio'=>function ($q){ $q->select('idservicio','nombre');}])->where('idproyecto','=',$id)->where('estado','=','1')->get();

        if(count($proyecto)==0){
        $serv='';
        }else{
        $serv=$proyecto[0]->servicio->nombre;
        }
        return $serv;
    }
     public function retronarClienteProyecto($id){

        $cliente = Proyecto::select('persona.nombre')->join('persona','idcliente','=','persona.idpersona')
        ->where('idproyecto','=',$id)->where('persona.estado','=','1')->get();
        //dd($cliente);
        if(count($cliente)==0){
            $cli='';
        }else{
            $cli=$cliente[0]->nombre;
        }
        return $cli;
    }


        public function BusquedaProyecto($fechainicio,$fechafin,$fase,$cliente,$iddepartamento,$idprovincia,$iddistrito)
        {
            if ($cliente>0) {
                if ( ($fase==0) && ($iddepartamento==0) ) {

                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente){$q->where('idcliente','=',$cliente)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();

                }elseif ( ($fase==0) && ($iddepartamento>0) && ($idprovincia==0) && ($iddistrito==0) ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();

                }elseif ( ($fase==0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito==0)  ) {

                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento,$idprovincia){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();

                }elseif ( ($fase==0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito>0)  ) {


                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento,$idprovincia,$iddistrito){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('iddistrito','=',$iddistrito)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();


                }elseif ( ($fase>0) && ($iddepartamento==0) && ($idprovincia==0) && ($iddistrito==0) ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente){$q->where('idcliente','=',$cliente)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();

                }elseif ( ($fase>0) && ($iddepartamento>0) && ($idprovincia==0) && ($iddistrito==0)  ) {

                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();


                }elseif ( ($fase>0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito==0)  ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento,$idprovincia){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();
                }elseif ( ($fase>0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito>0)  ) {

                        $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$cliente,$iddepartamento,$idprovincia,$iddistrito){$q->where('idcliente','=',$cliente)->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('iddistrito','=',$iddistrito)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();

                }
            }elseif ($fase>0) {
                if ( ($cliente==0) && ($iddepartamento==0) ) {

                     $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin){$q->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();

                }elseif ( ($cliente==0) && ($iddepartamento>0) && ($idprovincia==0) && ($iddistrito==0) ) {

                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$iddepartamento){$q->where('iddepartamento','=',$iddepartamento)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();

                }elseif ( ($cliente==0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito==0)  ) {

                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$iddepartamento,$idprovincia){$q->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();

                }elseif ( ($cliente==0) && ($iddepartamento>0) && ($idprovincia>0) && ($iddistrito>0)  ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$iddepartamento,$idprovincia,$iddistrito){$q->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('iddistrito','=',$iddistrito)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->where('idfase', '=', $fase)->orderBy('idseguimiento','desc')->get();
                }
            }elseif ($iddepartamento>0) {
                if ( ($idprovincia==0) && ($iddistrito==0) ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$iddepartamento,$idprovincia){$q->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();
                }elseif ( ($idprovincia>0) && ($iddistrito>0) ) {
                    $proyecto = Seguimiento_proyecto::wherehas('proyecto', function($q) use ($fechainicio,$fechafin,$iddepartamento,$idprovincia,$iddistrito){$q->where('iddepartamento','=',$iddepartamento)->where('idprovincia','=',$idprovincia)->where('iddistrito','=',$iddistrito)->where('proyecto.estado','1');})->with(['proyecto','fase'] )->where('estado', '=', '1')->orderBy('idseguimiento','desc')->get();
                }
            }

            return $proyecto;
        }

    public function CargarProyectos() {
        $proyectos = Proyecto::select('idproyecto','nombre')->where('estado','=',1)->get();
        return $proyectos;
    }

    public function CargarSeguimientoProyectos(Request $request) {
        $fechaInicio = $request->fechainicio;
        $fechaFin = $request->fechafin;
        $fase = $request->fase;
        $vs = $request->vs;
        $vc = $request->vc;
        
        $proyectos = $this->listarProyectosFiltro($fechaInicio, $fechaFin, $fase, $vs, $vc);

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
                        <?php if (!is_null($value->idc) && !empty((int)$value->idc)) { ?>
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
                                <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#crearSeguimiento">Iniciar</button> -->
                            <?php } else { ?>
                                <a href="/seguimiento-proyectos/<?php echo $value->idseguimiento;?>" class="btn btn-default">Actualizar</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


         <!-- <td><button class="course-submit" onClick="" type="button"><a href="/resumen_proyecto/<?php // echo $value->idproyecto ?>">CONSULTAR</a></button></td> -->
<?php
    }



    public function CargarAjax(Request $request) {
        $idcliente = $request->idcliente;
        $ObjTrabajador = new TrabajadorController();

        if($request->op == "1"){
        $cod=$this->AbreviaturaCliente($idcliente);
        return $cod;

        }else if($request->op=="2"){
        $contact=$this->ContactoCliente($idcliente);
        return $contact;

        }else if($request->op=="3"){
        $idservicio=$request->idservicio;
        $abrevt=$this->retornarAbreviaturaServicio($idservicio);
        return $abrevt;

        }else if($request->op=="4"){
        $idtrabajador=$request->idtrabajador;
        $correo=$ObjTrabajador->retornaCorreo($idtrabajador);
        $celular=$ObjTrabajador->retornaCelular($idtrabajador);
        return $correo.'||'.$celular;

        }else if($request->op=="5"){
            $fechainicio=$_REQUEST["fechainicio"];
            $fechafin=$_REQUEST["fechafin"];
            $fase=$_REQUEST["fase"];

             $proyectos=$this->listarProyectosFiltroCentro($fechainicio,$fechafin,$fase);
            ?>
            <script type="text/javascript" src="js/formato.js"></script>

            <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th class="col-md-2">Codigo</th>
                                            <th>Cliente</th>
                                            <th>Nombre del Proyecto</th>
                                            <th class="col-xs-1">Tipo de Proyecto</th>
                                            <th class="col-xs-1">Centro de costos</th>
                                            <th class="col-md-1">Fecha</th>
                                            <th>Fase actual del proyecto</th>
                                            <th>Consultar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;
                                            foreach ($proyectos as $value) {
                                            ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value->proyecto->nombreclave;?></td>
                                            <td><?php echo $value->proyecto->nombre_cliente; ?></td>
                                            <td><?php echo $value->proyecto->nombre;?></td>
                                            <td><?php echo $value->proyecto->tipo_proyecto; ?></td>
                                            <td><?php echo $value->proyecto->centro_costos; ?></td>
                                            <td><?php echo $value->proyecto->fecha;?></td>
                                            <td><?php echo $value->fase->nombre;?></td>
                                            <td><button id="btncronograma" type="button" class="btn btn-default" data-toggle="modal" data-target="#cronograma"
                                                onclick="centrocostos(<?php echo $value->idproyecto ?>)">
                                                Ver
                                                </button></td>
                                          </tr>
                                          <?php
                                          $i++;
                                            }
                                          ?>
                </tbody>
            </table>
        <?php

        }else if($request->op=="6"){


        $equipotrabajo=$_REQUEST["equipotrabajo"];
        $puesto=$ObjTrabajador->retornarPuestoTrabajador($equipotrabajo);

        ?>
        <div class="col-sm-9">
        <select name="puesto" id="puesto" class="form-control1" disabled >
        <option><?php echo $puesto;?></option>

        </select>
        </div>
        <?php

        }else if($request->op=="7"){

             $iddepartamento=$_REQUEST["iddepartamento"];
             $prov=$this->cargarProvincia($iddepartamento);
             ?>
             <script type="text/javascript">
                 $("#idprovincia").change(function() {
                      var idprovincia = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
                      $.ajax({//envio por ajax
                      type:'post',//tipo post
                      url:'/ajax/proyecto',//archivo donde llegan los datos
                      data:{op:8,idprovincia:idprovincia},//opcion 1 es para consultar grados
                      success:function(data){//si se ejecuto correctamente

                      $("#distrito").html(data);
                      }
                      });
                    });
             </script>
             <select name="idprovincia" id="idprovincia" class="form-control1" required onchange="BusquedaProyectos()">
             <option value="0">-Seleccione una Provincia-</option>
             <?php
            foreach ($prov as $t) {
            ?>
            <option value="<?php  echo $t['idprovincia'];?>"><?php  echo $t['nombre'];?></option>
            <?php
            }
            ?>
            </select>
            <?php

        }else if($request->op=="8"){

            $idprovincia=$_REQUEST["idprovincia"];
             $dis=$this->cargarDistrito($idprovincia);
             ?>
             <select name="iddistrito" id="iddistrito" class="form-control1" required onchange="BusquedaProyectos()"    >
             <option value="0">-Seleccione un Distrito-</option>
             <?php
            foreach ($dis as $t) {
            ?>
            <option value="<?php  echo $t['iddistrito'];?>"><?php  echo $t['nombre'];?></option>
            <?php
            }
            ?>
            </select>
            <?php



        }else if($request->op=="9"){
            $idtrabajador2=$request->idtrabajador2;
            $correo = $ObjTrabajador->retornaCorreo($idtrabajador2);
            $celular = $ObjTrabajador->retornaCelular($idtrabajador2);
            return $correo.'||'.$celular;
        } else if($request->op == "10" ) {
            $fechainicio = $_REQUEST["fechainicio"];
            $fechafin = $_REQUEST["fechafin"];
            $fase = $_REQUEST["fase"];

             $proyectos=$this->listarProyectosFiltro($fechainicio,$fechafin,$fase);
            ?>
            <script type="text/javascript" src="js/formato.js"></script>

            <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th class="col-md-2">Codigo</th>
                                            <th>Cliente</th>
                                            <th>Nombre del Proyecto</th>
                                            <th class="col-xs-1">Tipo de Proyecto</th>
                                            <th class="col-xs-1">Centro de costos</th>
                                            <th class="col-md-1">Fecha</th>
                                            <th>Fase actual del proyecto</th>
                                            <th>Consultar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=count($proyectos);
                                            foreach ($proyectos as $value) {
                                              $value->proyecto->nombre_cliente = $this->retronarClienteProyecto($value->idproyecto);
                                              $value->proyecto->tipo_proyecto = Tipo_proyecto::find($value->proyecto->idtipoproyecto)->nombre;
                                              $value->proyecto->centro_costos = $this->retornarCentroCostos($value->idproyecto);
                                            ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value->proyecto->nombreclave;?></td>
                                            <td><?php echo $value->proyecto->nombre_cliente; ?></td>
                                            <td><?php echo $value->proyecto->nombre;?></td>
                                            <td><?php echo $value->proyecto->tipo_proyecto; ?></td>
                                            <td><?php echo $value->proyecto->centro_costos; ?></td>
                                            <td><?php echo $value->proyecto->fecha;?></td>
                                            <td><?php echo $value->fase->nombre;?></td>
                                            <td><button class="course-submit" onClick="" type="button"><a href="/resumen_proyecto/<?php echo $value->idproyecto ?>">CONSULTAR</a></button></td>
                                          </tr>
                                          <?php
                                          $i--;
                                            }
                                          ?>
                </tbody>
            </table>
        <?php
        } else if($request->op=="11"){
            $fechainicio=$_REQUEST["fechainicio"];
            $fechafin=$_REQUEST["fechafin"];
            $fase=$_REQUEST["fase"];
            $cliente=$_REQUEST["cliente"];
            $iddepartamento=$_REQUEST["iddepartamento"];
            $idprovincia=$_REQUEST["idprovincia"];
            $iddistrito=$_REQUEST["iddistrito"];

            $proyectos=$this->BusquedaProyecto($fechainicio,$fechafin,$fase,$cliente,$iddepartamento,$idprovincia,$iddistrito);

            ?>
            <script type="text/javascript" src="js/formato.js"></script>

            <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Código</th>
                                            <th>Nombre del Proyecto</th>
                                            <th>Fecha</th>
                                            <th>Fase actual del proyecto</th>
                                            <th>Consultar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;
                                            foreach ($proyectos as $value) {
                                            ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value->proyecto->nombreclave;?></td>
                                            <td><?php echo $value->proyecto->nombre;?></td>
                                            <td><?php echo $value->proyecto->fecha;?></td>
                                            <td><?php echo $value->fase->nombre;?></td>
                                            <td><button class="course-submit" onClick="" type="button"><a href="/resumen_proyecto/<?php echo $value->idproyecto ?>">CONSULTAR</a></button></td>
                                          </tr>
                                          <?php
                                          $i++;
                                            }
                                          ?>
                </tbody>
            </table>
        <?php

        }elseif ($request->op=="12") {
            $depa=$this->cargarDepartamentos();
            $cli=$this->cargarClientes();
            ?>
            <script type="text/javascript" src="/js/sc.js"></script>
            <label class="control-label col-sm-2">Cliente :</label>

                <div class="col-sm-2">
                        <select name="idcliente" id="idcliente" class="form-control1" required onchange="BusquedaProyectos()">
                                            <option value="0">-Seleccione un cliente-</option>
                                            <?php foreach ($cli as $cliente){ ?>
                                            <option value="<?=$cliente->idpersona?>"><?=$cliente->nombre?></option>
                                            <?php }?>

                        </select>
                </div>
                <label class="control-label col-sm-2">Ubicacion :</label>

                <div class="col-sm-2">
                        <select name="iddepartamento" id="iddepartamento" class="form-control1" required onchange="BusquedaProyectos()">
                                            <option value="0">-Seleccione un Departamento-</option>
                                            <?php foreach ($depa as $depa){?>
                                            <option value="<?=$depa->iddepartamento?>"><?=$depa->nombre?></option>
                                            <?php } ?>

                        </select>
                </div>
                <div class="col-sm-2" id="provincia">
                        <select name="idprovincia" id="idprovincia" class="form-control1" required>
                            <option value="0">-Seleccione una Provincia-</option>

                        </select>
                </div>
                <div class="col-sm-2" id="distrito">
                        <select name="iddistrito" id="iddistrito" class="form-control1" required>
                            <option value="0">-Seleccione un Distrito-</option>
                        </select>
                </div>

                    <label class="col-sm-2 control-label">Filtrar por fase:</label>

                    <div class="col-sm-2">
                        <select name="fase" id="fase" class="form-control1" onchange="BusquedaProyectos()">
                            <option value="0">-Seleccione una etapa-</option>
                            <option value="1">Inicio y Planificación</option>
                            <option value="2">Ejecución</option>
                            <option value="3">Cierre</option>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Fechas:</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control1" id="fechainicio" onchange="BusquedaProyectos()" value="<?php echo date ('Y-m-d',strtotime('-10 day',strtotime (date("Y-m-d")) ) ); ?>">
                    </div>
                    <div class="col-sm-2">
                        <input type="date" class="form-control1" id="fechafin"  value="<?php echo date ('Y-m-d',strtotime('+10 day',strtotime (date("Y-m-d")) ) ); ?>"  onchange="BusquedaProyectos()" >
                    </div>
        <?php
        }elseif ($request->op=="13") {
            $proyectos=$this->CargarProyectos();
            ?>
            <label class="control-label col-sm-2">Proyecto :</label>

                <div class="col-sm-2">
                        <select name="idproyecto" id="idproyecto" class="form-control1" required onchange="BusquedaDocumentos()">
                                            <option value="0">-Seleccione un proyecto-</option>
                                            <?php foreach ($proyectos as $pro){ ?>
                                            <option value="<?=$pro->idproyecto?>"><?=$pro->nombre?></option>
                                            <?php } ?>

                        </select>
                </div>




            <?php
        }elseif ($request->op=="14") {
            $id=$_REQUEST["idproyecto"];
            $actainicio=$this->retornaActaInicioOK($id,1);
            $matrizcomu=$this->retornaMatrizComuOK($id,2);
            $matrizrol=$this->retornaMatrizRolOK($id,3);
            $reqlogist=$this->retornaReqLogisOK($id,4);
            $reqcart=$this->retornaReqCartOK($id,5);
            $matrizries=$this->retornaMatrizRiesOK($id,15);

            $actareunion=$this->retornaActaReuOK($id,6);
            $solcambio=$this->retornaSolCambioOK($id,7);
            $actaacuerdo=$this->retornaActaAcuerdoOK($id,8);
            $reportho=$this->retornaReporteHoOK($id,9);
            $solac=$this->retornaSolAcOK($id,10);

            $actacierre=$this->retornaActaCierreOK($id,12);
            $actareuc=$this->retornaActaReuOK($id,13);

            ?>
            <script type="text/javascript" src="js/formato.js"></script>
            <style type="text/css">
                .colUltimaOculta tr td:last-child{display:none;}
                .colUltimaOcultaTH tr th:last-child{display:none;}
            </style>
            <table id="myTable" class="table table-striped table-bordered colUltimaOculta colUltimaOcultaTH">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Consultar</th>
                                            <th>Concat</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=0; ?>
                                        <?php if (!empty($actainicio)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Acta Inicio</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_actainicio/<?php echo $actainicio->idproyecto; ?>" >Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $actainicio->nombre.$actainicio->descripcion.$actainicio->titular.$actainicio->ambito.$actainicio->alcance.$actainicio->metodologia;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($matrizcomu)) { ?>
                                          <tr>
                                          <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Matriz Comunicacion</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_matrizcomu/<?php echo $matrizcomu->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $matrizcomu->descripcion.$matrizcomu->documento.$matrizcomu->archivo;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($matrizrol)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Matriz de Roles</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_matrizrol/<?php echo $matrizrol->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $matrizrol->descripcion.$matrizrol->documento.$matrizrol->archivo;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($reqlogist)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Requerimiento Logistica</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_reqlogisti/<?php echo $reqlogist->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $reqlogist->observacion;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($reqcart)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Requerimiento Cartografia</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_reqcartog/<?php echo $reqcart->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $reqcart->colaborador;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($matrizries)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Matriz de Riesgos</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/inicio_matrizriesgos/<?php echo $matrizries->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $matrizries->descripcion.$matrizries->documento.$matrizries->archivo;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($actareunion)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Acta de Reunion (Ejecucion)</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/ejecucion_acta/<?php echo $actareunion->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $actareunion->tema.$actareunion->temas.$actareunion->acciones.$actareunion->fecha;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($solcambio)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Solicitud de Cambio</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/ejecucion_solicitudcam/<?php echo $solcambio->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $solcambio->medio.$solcambio->descripcion.$solcambio->nombre.$solcambio->cargo.$solcambio->fecha;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($actaacuerdo)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Acta de Acuerdo</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/ejecucion_acuerdo/<?php echo $actaacuerdo->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $actaacuerdo->tema.$actaacuerdo->revision.$actaacuerdo->acuerdos?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($reportho)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Reporte HO/SNC</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/ejecucion_reporte/<?php echo $reportho->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $reportho->nombre.$reportho->archivo;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($solac)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Solicitus AC y AP</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/ejecucion_solicitudac/<?php echo $solac->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $solac->nombre.$solac->archivo;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($actacierre)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Acta Cierre</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/cierre_actac/<?php echo $actacierre->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $actacierre->descripcion.$actacierre->titular.$actacierre->gerente.$actacierre->jefe.$actacierre->resultado;?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php if (!empty($actareuc)) { ?>
                                          <tr>
                                            <?php $i++; ?>
                                            <td><?=$i?></td>
                                            <td>Acta Reunion (Cierre)</td>
                                            <td>
                                            <button class="btn" onClick="" type="button">
                                            <a target="_blank" href="/cierre_actar/<?php echo $actareuc->idproyecto ?>">Ver</a>
                                            </button>
                                            </td>
                                            <td><?php echo $actareuc->tema.$actareuc->temas.$actareuc->acciones.$actareuc->fecha;?></td>
                                          </tr>
                                          <?php } ?>

                </tbody>
            </table>
        <?php
        }elseif ($request->op=="15") {

        }

    }


}
