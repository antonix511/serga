<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Documento_Controller;
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
use App\Firmas;
use App\Proyecto;
use App\Proyecto_doc_valida;
use DB;

class ResumenProyecto_Controller extends Controller
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
    
    function retornaActaInicioOK($idproyecto,$iddocumento){
        $acta=Acta_inicio::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
        
    }
    function retornaMatrizComuOK($idproyecto,$iddocumento){

        $acta=Matriz_comunicacion::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaMatrizRolOK($idproyecto,$iddocumento){
        $acta=Matriz_roles::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaReqLogisOK($idproyecto,$iddocumento){
        $acta=Req_logistica::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaReqCartOK($idproyecto,$iddocumento){
        $acta=Req_cartografia::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }

    function retornaSolCambioOK($idproyecto,$iddocumento){
        $acta=Solicitud_cambio::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaActaAcuerdoOK($idproyecto,$iddocumento){
        $acta=Acta_acuerdo::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaReporteHoOK($idproyecto,$iddocumento){
        $acta=Reporte_ho::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaSolAcOK($idproyecto,$iddocumento){
        $acta=Solicitud_ac::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }


    function retornaActaCierreOK($idproyecto,$iddocumento){
        $acta=Acta_cierre::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }
    function retornaActaReuOK($idproyecto,$iddocumento){
        $acta=Acta_reunion::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }

    function retornaMatrizRiesOK($idproyecto,$iddocumento){
        $acta=Matriz_Riesgos::select('*')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)->where('estado','=',1)->first();
        if(!empty($acta)){
            return 1;
        }else{
            return 0;
        }
    }

    public function TraerTipoProyect($id)
    {
        $privilegio=Proyecto::select('idtipoproyecto')->where('idproyecto','=',$id)->first();
        return $privilegio->idtipoproyecto;
    }

    public function resumenProyecto($id){
        $tipoproy=$this->TraerTipoProyect($id);
        session_start();
        $_SESSION['tipoproy']=$tipoproy;
        $_SESSION['pactainicio']=0;
        $_SESSION['pmatrizcomu']=0;
        $_SESSION['pmatrizrol']=0;
        $_SESSION['pmatrizries']=0;
        $_SESSION['preqlogist']=0;
        $_SESSION['preqcart']=0;
        $_SESSION['pactareunion']=0;
        $_SESSION['psolcambio']=0;
        $_SESSION['pactaacuerdo']=0;
        $_SESSION['preportho']=0;
        $_SESSION['psolac']=0;
        $_SESSION['pactacierre']=0;
        $_SESSION['pactareuc']=0;

        $permiso_config_docs = 0;

        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="inicio_actainicio"){$_SESSION['pactainicio']=5;}
            if ($row->modulos->ruta=="inicio_matrizcomu"){$_SESSION['pmatrizcomu']=6;}
            if ($row->modulos->ruta=="inicio_matrizrol"){$_SESSION['pmatrizrol']=7;}
            if ($row->modulos->ruta=="inicio_matrizriesgos"){$_SESSION['pmatrizries']=8;}
            if ($row->modulos->ruta=="inicio_reqlogisti"){$_SESSION['preqlogist']=9;}
            if ($row->modulos->ruta=="inicio_reqcartog"){$_SESSION['preqcart']=10;}
            if ($row->modulos->ruta=="ejecucion_acta"){$_SESSION['pactareunion']=12;}
            if ($row->modulos->ruta=="ejecucion_solicitudcam"){$_SESSION['psolcambio']=12;}
            if ($row->modulos->ruta=="ejecucion_acuerdo"){$_SESSION['pactaacuerdo']=11;}
            if ($row->modulos->ruta=="ejecucion_reporte"){$_SESSION['preportho']=12;}
            if ($row->modulos->ruta=="ejecucion_solicitudac"){$_SESSION['psolac']=21;}
            if ($row->modulos->ruta=="cierre_actac"){$_SESSION['pactacierre']=12;}
            if ($row->modulos->ruta=="cierre_actar") {$_SESSION['pactareuc']=12;}
            if ($row->modulos->ruta=="config_formato_docs") { $permiso_config_docs = 1;}
        }
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="resumen_proyecto") {

                $objProyecto= new ProyectoController();
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
                $solac=$this->retornaSolAcOK($id,9);

                $actacierre=$this->retornaActaCierreOK($id,12);
                $actareuc=$this->retornaActaReuOK($id,12);
                $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

                $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
                $doc_validados = [];
                foreach ($doc_valida as $kdoc => $vdoc) {
                    $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
                }

                return view('resumen_proyecto',['id'=>$id,'actainicio'=>$actainicio,'matrizcomu'=>$matrizcomu,'matrizrol'=>$matrizrol,
                'reqlogist'=>$reqlogist,'reqcart'=>$reqcart,'actareunion'=>$actareunion,'solcambio'=>$solcambio,
                'actaacuerdo'=>$actaacuerdo,'reportho'=>$reportho,'solac'=>$solac,
                'actacierre'=>$actacierre,'actareuc'=>$actareuc,'nombreclave'=>$nombreclave,'matrizries'=>$matrizries, 'doc_validados'=>$doc_validados, 'permiso_config_docs'=>$permiso_config_docs]);
            }
        }

         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php

    }

    public function proyecto_doc_valida(Request $request){
        $result = ['status'=>'error', 'msg'=>'No se pudo guardar la configuración de los documentos'];

        
        $result['upd'] = 0;
        $result['upd'] += Proyecto_doc_valida::where('idproyecto', '=', $request->id)->update(['valida' => 0]);

        if(is_array($request->cnf_doc) && count($request->cnf_doc)>0){
            foreach ($request->cnf_doc as $kdoc => $vdoc) {
                $result['upd'] += Proyecto_doc_valida::where('idproyecto', '=', $request->id)->where('iddocumento', '=', $kdoc)->update(['valida' => $vdoc]);
            }

        }

        if($result['upd'] > 0){
            $result['status'] = 'success';
            $result['msg'] = 'Configuración guardada';
        }else{
            $result['msg'] = 'No se han detectado cambios';
        }

        return response($result);
    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }

    public function inicio_actainicio($id){

    $tipoproy=$this->TraerTipoProyect($id);
        session_start();
        $_SESSION['tipoproy']=$tipoproy;
        $_SESSION['pactainicio']=0;
        $_SESSION['pmatrizcomu']=0;
        $_SESSION['pmatrizrol']=0;
        $_SESSION['pmatrizries']=0;
        $_SESSION['preqlogist']=0;
        $_SESSION['preqcart']=0;
        $_SESSION['pactareunion']=0;
        $_SESSION['psolcambio']=0;
        $_SESSION['pactaacuerdo']=0;
        $_SESSION['preportho']=0;
        $_SESSION['psolac']=0;
        $_SESSION['pactacierre']=0;
        $_SESSION['pactareuc']=0;



        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="inicio_actainicio"){$_SESSION['pactainicio']=5;}
            if ($row->modulos->ruta=="inicio_matrizcomu"){$_SESSION['pmatrizcomu']=6;}
            if ($row->modulos->ruta=="inicio_matrizrol"){$_SESSION['pmatrizrol']=7;}
            if ($row->modulos->ruta=="inicio_matrizriesgos"){$_SESSION['pmatrizries']=8;}
            if ($row->modulos->ruta=="inicio_reqlogisti"){$_SESSION['preqlogist']=9;}
            if ($row->modulos->ruta=="inicio_reqcartog"){$_SESSION['preqcart']=10;}
            if ($row->modulos->ruta=="ejecucion_acta"){$_SESSION['pactareunion']=12;}
            if ($row->modulos->ruta=="ejecucion_solicitudcam"){$_SESSION['psolcambio']=12;}
            if ($row->modulos->ruta=="ejecucion_acuerdo"){$_SESSION['pactaacuerdo']=11;}
            if ($row->modulos->ruta=="ejecucion_reporte"){$_SESSION['preportho']=12;}
            if ($row->modulos->ruta=="ejecucion_solicitudac"){$_SESSION['psolac']=21;}
            if ($row->modulos->ruta=="cierre_actac"){$_SESSION['pactacierre']=12;}
            if ($row->modulos->ruta=="cierre_actar") {$_SESSION['pactareuc']=12;}
        }
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="resumen_proyecto") {

                $objProyecto= new ProyectoController();
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
                $solac=$this->retornaSolAcOK($id,9);

                $actacierre=$this->retornaActaCierreOK($id,12);
                $actareuc=$this->retornaActaReuOK($id,12);
                $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);


                return view('resumen_proyecto',['id'=>$id,'actainicio'=>$actainicio,'matrizcomu'=>$matrizcomu,'matrizrol'=>$matrizrol,
                'reqlogist'=>$reqlogist,'reqcart'=>$reqcart,'actareunion'=>$actareunion,'solcambio'=>$solcambio,
                'actaacuerdo'=>$actaacuerdo,'reportho'=>$reportho,'solac'=>$solac,
                'actacierre'=>$actacierre,'actareuc'=>$actareuc,'nombreclave'=>$nombreclave,'matrizries'=>$matrizries]);
    }
}
}
}
