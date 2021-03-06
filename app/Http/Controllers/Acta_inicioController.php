<?php

namespace App\Http\Controllers;

use App\HistorialSeguimiento;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Acta_inicio;
use App\Trabajador;
use App\Persona;
use App\Proyecto;
use App\Proyecto_doc_valida;
use App\Firmas;
use App\Equipo_trabajo;
use Carbon\Carbon;

use App\Versati;

use Auth;
use App\Cronograma;
use App\Entregables;
use App\Documento;
use App\Cliente;
use App\Puesto;
use App\Estado_cronograma;
use App\Seguimiento_proyecto;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use File;
class Acta_inicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
        $img_cronograma = $_FILES['imgcronograma']['name'];
        $tmp=$_FILES['imgcronograma']['tmp_name'];
        if(!empty($img_cronograma)){
        copy($tmp, "documentos/trabajador/".$img_cronograma);
        }else{
          $img_cronograma="";
        }

        DB::beginTransaction();

        $acta = Acta_inicio::create($request->all());
        $idproyecto=$request->idproyecto;
        $acta->idproyecto=$idproyecto;
        $numero=$this->GenerarNumero();
        $acta->numero=$numero;
        $acta->cronograma=$img_cronograma;
        $acta->codigo= $this->retornaAbreviaturaDocumento('1').'-'.$numero.'-'.$this->retornaAbreviaturaCliente($idproyecto).'-'.date("Y");;
        //Abreviatura documento- correlativo-abreviatura proyecto-abreviaturacliente-año
        $acta->save();
        DB::commit();
        $verificar=$this->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }
        $idacta=$this->retornaIdActa($idproyecto);

        ?>
        <input type="hidden" name="idacta" id="idacta" value="<?php echo $idacta ?>">
        <input type="hidden" id="accion" value="2">

        <div class="col-sm-12">
            <label class="col-sm-3 control-label">Nº Acta</label>
            <div class="col-sm-3">
                <input type="text" class="form-control1" name="numero" disabled="" value="<?php echo $numero ?>">
            </div>
        </div>
        <?php
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
    public function VerificarDocumentos($id)
    {
        $objResProyecto= new ResumenProyecto_Controller();
        $actainicio=$objResProyecto->retornaActaInicioOK($id,1);
        $matrizcomu=$objResProyecto->retornaMatrizComuOK($id,2);
        $matrizrol=$objResProyecto->retornaMatrizRolOK($id,3);
        $reqlogist=$objResProyecto->retornaReqLogisOK($id,4);
        $reqcart=$objResProyecto->retornaReqCartOK($id,5);
        $matrizries=$objResProyecto->retornaMatrizRiesOK($id,15);

        $validar=$actainicio+$matrizcomu+$matrizrol+$reqlogist+$reqcart+$matrizries;
        if ($validar==6) {
            return 1;
        }else{
            return 0;
        }
    }

    //METODOS GENERALES

    public function ActualizarActa(Request $request){

        DB::beginTransaction();

        $img_cronograma = $_FILES['imgcronograma']['name'];
        $tmp=$_FILES['imgcronograma']['tmp_name'];
        if(!empty($img_cronograma)){
        copy($tmp, "documentos/trabajador/".$img_cronograma);
        $actualiza=Acta_inicio::where('idproyecto','=',$request->idproyecto)->update(['bono'=>$request->bono,'bono2'=>$request->bono2,'ambito'=>$request->ambito,'alcance'=>$request->alcance,'metodologia'=>$request->metodologia,'finicio'=>$request->finicio,'fentrega'=>$request->fentrega,'fcierre'=>$request->fcierre,'descripcion'=>$request->descripcion,'titular'=>$request->titular,'calidad'=>$request->calidad,'cronograma'=>$img_cronograma]);

        }else{
          $actualiza=Acta_inicio::where('idproyecto','=',$request->idproyecto)->update(['bono'=>$request->bono,'bono2'=>$request->bono2,'ambito'=>$request->ambito,'alcance'=>$request->alcance,'metodologia'=>$request->metodologia,'finicio'=>$request->finicio,'fentrega'=>$request->fentrega,'fcierre'=>$request->fcierre,'descripcion'=>$request->descripcion,'titular'=>$request->titular,'calidad'=>$request->calidad]);
        }



        DB::commit();

        $verificar=$this->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }

        $numero=$this->GenerarNumero();
        $idacta=$this->retornaIdActa($request->idproyecto);


        $objProyecto=new ProyectoController();
    $idservicio=$objProyecto->retornarIdServicioProyecto($request->idproyecto);
    $idcliente=$objProyecto->retronaIdClienteProyecto($request->idproyecto);
    //Retornar CODE
    $numero=$objProyecto->AbreviaturaDocumento('1').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-2';


        ?>
        <input type="hidden" name="idacta" id="idacta" value="<?php echo $idacta ?>">
        <input type="hidden" id="accion" value="2">

        <div class="col-sm-12">
            <label class="col-sm-3 control-label">Nº Acta</label>
            <div class="col-sm-3">
                <input type="text" class="form-control1" name="numero" disabled="" value="<?php echo $numero ?>">
            </div>
        </div>
        <?php

    }

    public function retornaAbreviaturaCliente($idproyecto){

        $resultado = Cliente::select('cliente.abreviatura as abreviatura')
        ->join('proyecto','proyecto.idcliente','=','cliente.idpersona')->where('proyecto.idproyecto','=',$idproyecto)->get();
        //dd($resultado);
        if(count($resultado)==0){
            $abre='0';
        }else{
            $abre =$resultado[0]->abreviatura;
        }
        return $abre;
    }

    public function retornaIdactaInicio($id){
        $resultado = Acta_inicio::select('*')->where('idproyecto','=',$id)->get();
        //dd($resultado);
        if(count($resultado)==0){
            $valor='0';
        }else{
            $valor=$resultado;
        }
        return $valor;
    }

    public function retornaIdActa($idproyecto){
        $codigo = Acta_inicio::select('idacta')->where('idproyecto','=',$idproyecto)->get();

        if(count($codigo)==0){
            $cod='0';
        }else{
            $cod =$codigo[0]->idacta;
        }
        return $cod;

    }

    public function retornaAbreviaturaDocumento($iddocumento){
        $codigo = Documento::select('abreviatura')->where('iddocumento','=',$iddocumento)->get();

        if(count($codigo)==0){
            $cod='0';
        }else{
            $cod =$codigo[0]->abreviatura;
        }
        return $cod;

    }

    public function GenerarNumero(){
        $codigo = Acta_inicio::select('numero')->orderBy('numero','desc')->take(1)->get();

        if(count($codigo)==0){
            $cod=1;
        }else{
            $cod =$codigo[0]->numero + 1;
        }
        return $cod;

    }

    public function firmas($idacta)
    {
        $lista = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idacta','=',$idacta)->get();

        return $lista;
    }

    public function listarFirmas($idproyecto,$iddocumento){

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

    public function listarFirmasPendientes($idproyecto,$iddocumento,$idacta){

        $lista = Firmas::select('firmas.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area','area.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','=','1')
        ->where('firmas.estado','=','1')
        ->where('trabajador.estado','1')
        ->where('persona.estado','1')
        ->where('firmas.idproyecto','=',$idproyecto)
        ->where('firmas.iddocumento','=',$iddocumento)
        ->where('firmas.idacta','=',$idacta)->get();

        return $lista;
    }
    public function listarFirmasPendientes2($idproyecto,$iddocumento){

        $lista = Firmas::select('firmas.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area','area.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',$idproyecto)
        ->where('firmas.iddocumento','=',$iddocumento)->get();

        return $lista;
    }

    public function listarCronograma($idproyecto){
        $lista = Cronograma::select('idcronograma','version','nombre','archivo', 'vp_archivo','fecha_registro')->where('idproyecto', '=', $idproyecto)
        ->where('estado','=','1')->get();

        return $lista;
    }

    public function retornarTrabajadorAsignado($idtrabajador,$idproyecto){

        $correor = Equipo_trabajo::select('idequipo')
        ->where('idproyecto','=',$idproyecto)
        ->where('idtrabajador','=',$idtrabajador)
        ->where('estado','=','1')
        ->take(1)->get();
        if(count($correor)==0){
            $correo='0';
        }else{
            $correo=$correor[0]->correo;
        }
        return $correo;
    }
    public function listarEquipo($idproyecto){

        $lista = Equipo_trabajo::select('equipo_trabajo.idequipo as idequipo','persona.nombre as persona','trabajador.apellidos as apellidos','puesto.nombre as puesto')
        ->join('persona','idtrabajador','=','persona.idpersona')
        ->join('trabajador','persona.idpersona','=','trabajador.idpersona')
        ->join('puesto','trabajador.idpuesto','=','puesto.idpuesto')
        ->where('idproyecto','=',$idproyecto)->where('equipo_trabajo.estado','=','1')->orderBy('equipo_trabajo.idequipo','asc')->get();

        return $lista;
    }

    public function listarEntregables($idproyecto,$iddocumento){

        $lista = Entregables::select('identregable','nombre')->where('idproyecto','=',$idproyecto)->where('iddocumento','=',$iddocumento)
        ->where('estado','=','1')->get();

        return $lista;
    }

    public function cargarTrabajadoresArea($idarea){

        $trabajador = Persona::select('persona.idpersona as idpersona','persona.nombre as nombres','trabajador.apellidos as apellidos')->join('trabajador','trabajador.idpersona','=','persona.idpersona')
        ->where('persona.estado','=','1')->where('trabajador.idarea','=',$idarea)->where('trabajador.estado','=','1')->orderBy('persona.nombre', 'asc')->get();

        return $trabajador;
    }

    public function CargarAjax(Request $request)
    {
        $ObjTrabajador = new TrabajadorController();
        if ($request->op == "1") {
            //primero vamos a consultar si es que ya se registro ese usuario para este proyecto
            $idequipox = $_REQUEST["idequipox"];
            $accion = $_REQUEST["accion"];
            $idtrabajador = $_REQUEST["idtrabajador"];
            $idproyecto = $_REQUEST["idproyecto"];
            $idequipo = $this->retornarTrabajadorAsignado($idtrabajador,$idproyecto);
        if ($accion=='1') {//quiere decir que se va guardar
            if($idequipo!='0') {//quiere decir que ya se registró
                ?><script type="text/javascript">swal("Error", "Este usuario ya ha sido asignado a este proyecto", "error");</script><?php
            } else {
                DB::beginTransaction();
                $equipo = Equipo_trabajo::create($request->all());
                $equipo->idproyecto=$idproyecto;
                $equipo->$idtrabajador;
                $equipo->save();
                DB::commit();
                ?><script type="text/javascript">swal("Enviado!", "Trabajador correctamente asignado", "success");</script><?php
            }
        } else if($accion=='2') {
            DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
            $m = Equipo_trabajo::where('idequipo','=',$idequipox)->update(['estado'=>'0']);
            DB::commit();
            ?><script type="text/javascript">swal("Enviado!", "Trabajador desasignado correctamente", "success");</script><?php
        }
        $lista=$this->listarEquipo($idproyecto);
        ?>

        <div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombres y Apellidos</th>
                        <th>Puesto</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;
                    foreach ($lista as $valor) { ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $valor['persona'].' '.$valor['apellidos'];?></td>
                            <td><?php echo $valor['puesto'];?></td>
                            <td> <a class="fa fa-trash"  onclick="eliminarequipo(<?php echo $valor['idequipo'];?>);"></a></td>

                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
        <?php
            } else if($request->op == "2") {
                $accion = $_REQUEST["accion"];
                $idproyecto = $_REQUEST["idproyecto"];
                $identregable = $_REQUEST["identregable"];
                if ($accion == 1) {
                    DB::beginTransaction();
                    $entregable = Entregables::create($request->all());
                    $entregable->idproyecto=$idproyecto;
                    $entregable->iddocumento=1;
                    $nombreentregable=$_REQUEST["nombreentregable"];
                    $entregable->nombre=$nombreentregable;
                    $entregable->save();
                    DB::commit();
        ?><script type="text/javascript">swal("Enviado!", "Entregable correctamente registrado", "success");</script><?php
                } else if($accion == 2) {
                    DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
                    $m = Entregables::where('identregable','=',$identregable)->update(['estado'=>'0']);
                    DB::commit();
        ?><script type="text/javascript">swal("Enviado!", "Entregable correctamente eliminado", "success");</script><?php
                }
                $lista = $this->listarEntregables($idproyecto,'1');
        ?>
        <div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombre</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1;
                    foreach ($lista as $value) {
                ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value['nombre'];?></td>
                        <td> <a class="fa fa-trash" onclick="eliminarEntregable(<?php echo $value['identregable'];?>);"></a></td>
                    </tr>
                    <?php $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
        } else if ($request->op == "3") {
            $idarea = $_REQUEST["idarea"];
            $trabajadores = $this->cargarTrabajadoresArea($idarea);
    ?>
    <script type="text/javascript" >
        $("#personaacta").change(function() {
            var idtrabajador = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
  //alert(idtrabajador);
            $.ajax({//envio por ajax
                type:'post',//tipo post
                url:'/ajax/actainicio',//archivo donde llegan los datos
                data:{op:4,idtrabajador:idtrabajador},//opcion 1 es para consultar grados
                success:function(data) {//si se ejecuto correctamente
                    $("#cargarcargo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
                }
            });
        });
    </script>
    <select name="personaacta" id="personaacta" class="form-control1" >
        <option value="0">-Seleccione una persona-</option>
        <?php
        foreach ($trabajadores as $t) {
        ?>
            <option value="<?php  echo $t['idpersona'];?>"><?php  echo $t['nombres'].' '.$t['apellidos'];?></option>
        <?php } ?>
    </select>
    <?php
        } else if ($request->op == "4") {
            $idtrabajador=$_REQUEST["idtrabajador"];
            $puesto = $ObjTrabajador->retornarPuestoTrabajador($idtrabajador);
    ?>
    <!--<script type="text/javascript" src="/js/sc.js"></script>-->
    <select name="cargo" id="cargo" class="form-control1" disabled>
        <option value="<?php echo $puesto;?>"><?php echo $puesto;?></option>
    </select>
    <?php
        } else if($request->op == "5") {
            $idproyecto = $_REQUEST["idproyecto"];
            DB::beginTransaction();
            $firma = Firmas::create($request->all());
            $firma->idproyecto=$idproyecto;
            $firma->iddocumento=1;
            $personaacta=$_REQUEST["personaacta"];
            $firma->idtrabajador=$personaacta;
            $firma->save();
            DB::commit();
            $lista=$this->listarFirmasPendientes2($idproyecto,'1');
    ?>
    <table id="myTable2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Gerencia</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $v['area'];?></td>
                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                    <td><?php echo $v['puesto'];?></td>
                    <td><?php echo $v['correo'];?></td>
                    <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $idproyecto;?>);"></a></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
            // ACTA INICIO -- Agregar Cronograma
        } else if ($request->op == "6") {
            // $idproyecto = $_REQUEST["idproyecto"];

            $idActaInicio = $_REQUEST["idproyecto"];
            $actaInicio = Acta_inicio::where('idacta', $idActaInicio)->first();
            $idproyecto = $actaInicio->idproyecto;

            $version = $_REQUEST["version"];
            $data = $request->all();
            $data['idproyecto'] = $idproyecto;
//            $data['idestado_cro'] = intval($data['idestado_cro']);
            DB::beginTransaction();
            $cronograma = Cronograma::create($data);
            $cronograma->idproyecto = $idproyecto;
            $cronograma->version = $version;
            $url = $_FILES['file']['name'];
            $nombre = basename($url);
            $archivo = $version . '_' . $nombre;
            $vpUrl = $_FILES['vp_file']['name'];
            $vpName = basename($vpUrl);
            $vpArchivo = $version . '_' . $vpName;
            $cronograma->nombre = $nombre;
            $cronograma->archivo = $archivo;
            $cronograma->vp_archivo = $vpArchivo;
            $cronograma->save();
            DB::commit();
            $seguimiento = Seguimiento_proyecto::create([
                'idfase' => 1,
                'idproyecto' => $idproyecto,
                'vs' => 0,
                'vc' => 0,
                'idc' => 0,
                'ids' => 0,
                'fecha_registro' => Carbon::now(),
                'fecha_seguimiento' => null,
                'estado' => 1
            ]);
            $nroDias = $cronograma->nro_dias;
            $nroIntervalos = $cronograma->nro_intervalos;

            $proyecto = Proyecto::where('idproyecto', $idproyecto)->first();
            $fechaInicio = Carbon::createFromFormat('Y-m-d', $proyecto->finicio);
            $fechaInicio->subDay();
            for ($i = 0; $i < $nroIntervalos; $i++) {
                $historialSeguimiento = HistorialSeguimiento::create([
                    'id_seguimiento' => $seguimiento->idseguimiento,
                    'fecha_seguimiento' => $fechaInicio->addWeekdays($nroDias), // weekDays solo dias de semana
                    'costo_avance' => null,
                    'vc' => 0.0,
                    'idc' => 0.0,
                    'vs' => 0.0,
                    'ids' => 0.0,
                    'estado' => ''
                ]);
            }
            //obteneiendo solo el nombre d ela foto.
            if($url != ""){
                copy($_FILES['file']['tmp_name'], "documentos/cronogramas/".$archivo);
            }

            if (!empty($vpUrl)) {
                copy($_FILES['vp_file']['tmp_name'], "documentos/cronogramas/".$vpArchivo);
            }
    ?>
        <div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
            <table>
                <thead>
                    <tr>
                        <th>Versión</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Descargar</th>
                        <th>Descargar VP</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cronograma = $this->listarCronograma($idproyecto);
                        $i=1;
                        foreach ($cronograma as $v) {
                                # code...
                    ?>
                        <tr>
                            <td><?php echo $v['version'];?></td>
                            <td><?php echo $v['nombre'];?></td>
                            <td><?php echo $v['fecha_registro'];?></td>
                            <td><a class="fa fa-download" href="../documentos/cronogramas/<?php echo $v['archivo']; ?>" download="<?php echo $v['archivo']; ?>"></a></td>
                            <td><a class="fa fa-download" href="../documentos/cronogramas/<?php echo $v['vp_archivo']; ?>" download="<?php echo $v['vp_archivo']; ?>">  Descargar VP</a></td>
                            <td><a class="fa fa-trash" onclick="eliminarCronograma(<?php echo $v['idcronograma'];?>);" ></a></td>
                        </tr>
                        <?php
                            $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
            } else if($request->op=="7") {
                $idproyecto=$_REQUEST["idproyecto"];
                $personas = Persona::select('persona.correo as correo','persona.telefono as telefono','persona.nombre as nombres','trabajador.apellidos as apellidos','proyecto.nombre as proyecto')
                    ->join('trabajador','trabajador.idpersona','=','persona.idpersona')
                    ->join('firmas','firmas.idtrabajador','=','trabajador.idpersona')
                    ->join('proyecto','proyecto.idproyecto','=','firmas.idproyecto')
                    ->where('persona.estado','=','1')->where('firmas.idproyecto','=',$idproyecto)
                    ->where('firmas.estado','=','1')->where('firmas.idestadofirma','=','1')->get();
                //modificamos a idestado 2, lo que tienen idestado 1 y estado 1 por el idporyecto
                DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
                $firma = Firmas::where('idproyecto','=',$idproyecto)->where('idestadofirma','=','1')->where('estado','=','1')->update(['idestadofirma'=>'2']);
                DB::commit();
                $proyectoo=Proyecto::select('nombre','centrodecosto')->where('idproyecto',$request->idproyecto)->first();
                $namepro=$proyectoo->nombre;
                session_start();
                $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
                foreach ($personas as $p) {
                    $nombres = $p['nombres'];
                    $apellidos = $p['apellidos'];
                    $para = $p['correo'];
                    $telefono = $p['telefono'];
                    $proyecto = $p['proyecto'];
                    $titulo ="Acta de Inicio del proyecto ".$namepro;

                    if (!empty($telefono)) {
                        Versati::_send_sms($telefono, 'SERGA: Requiere aprobación de acta de inicio de proyecto '.$proyecto);
                    }
                    $mensaje = '
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <title>Firmas actas</title>
                    </head>
                    <body>
                   <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                    <p>Estimado(a) '.$nombres.' '.$apellidos.':</p>
    
    
                    <p>Por medio del presente se remite el Acta de Inicio del Proyecto '.$proyecto.' , para su aprobación y firma.</p>
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
                    if (Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)) {
                        ?><script type="text/javascript">swal("Enviados", "Correos enviados correctamente", "success");</script><?php
                    } else {
                        ?><script type="text/javascript">swal("Enviados", "Error al Envíar correos", "error");</script><?php
                    }
                }
            ?>
            <?php
}else if($request->op=="8"){

  $idcrono=$_REQUEST["idcrono"];
  $idproyecto=$_REQUEST["idproyecto"];



    DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
     $crono = Cronograma::where('idcronograma','=',$idcrono)->update(['estado'=>'0']);
     DB::commit();
    ?><script type="text/javascript">swal("Enviado!", "Cronograma correctamente eliminado", "success");</script><?php



            ?>
            <div class="col-sm-12 table-responsive" style="overflow: scroll; height: 300px;">
                        <table>
                            <thead>
                                <tr>

                                    <th>Versión</th>
                                    <th>Nombre</th>
                                     <th>Fecha</th>
                                    <th>Descargar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $cronograma=$this->listarCronograma($idproyecto);

                            $i=1;
                            foreach ($cronograma as $v) {
                                # code...

                            ?>

                                <tr>

                                    <td><?php echo $v['version'];?></td>
                                    <td><?php echo $v['nombre'];?></td>
                                    <td><?php echo $v['fecha_registro'];?></td>
                                    <td><a class="fa fa-download"  href="../documentos/cronogramas/<?php echo $v['archivo'];?>" download="<?php echo $v['nombre'];?>"></a></td>
                                    <td> <a class="fa fa-trash" onclick="eliminarCronograma(<?php echo $v['idcronograma'];?>);" ></a></td>
                            </tr>
                            <?php

                            $i++;
                            }

                            ?>


                            </tbody>
                        </table>
                        </div>

            <?php



}elseif ($request->op=="9"){

    $idproyecto=$_REQUEST["idproyecto"];
    $lista=$this->listarFirmasPendientes2($idproyecto,'1');
    ?>

    <table id="myTable2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Gerencia</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $v['area'];?></td>
                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                    <td><?php echo $v['puesto'];?></td>
                    <td><?php echo $v['correo'];?></td>
                    <td><?php echo $v['estado'];?></td>
                    <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $idproyecto;?>);"></a></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php

    }elseif ($request->op=="10"){

    $idproyecto=$_REQUEST["idproyecto"];
    $firmas=$this->listarFirmas($idproyecto,'1');
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

    }elseif ($request->op=="11"){
        if ($request->idbono=="SI") {

    ?>
        <select class="form-control1" name="bono2" id="bono2">
            <option value="Mensual">Mensual</option>
            <option value="Hito">Por Hito</option>
        </select>
    <?php
        }elseif($request->idbono=="NO"){
            echo "<input type='text' disabled='' style='border:none' value='Sin Opciones' class='control-label' name='bono2' id='bono2'>";
        }else{
            echo "<textarea  placeholder='Ingresar Otros' class='form-control1' style='height:80px;' name='bono2' id='bono2'></textarea>";
        }
    }elseif ($request->op=="12") {
            }

}
public function RetornarEquipoTrabajo($idproyecto){
    $trabajadores=Equipo_trabajo::with(['nombre','apellido'])->where('idproyecto','=',$idproyecto)->where('estado','1')->orderby('idequipo','desc')->get();
    return $trabajadores;
}
public function guardar(Request $request){
    DB::beginTransaction();

        $acta = Acta_inicio::create($request->all());
        $idproyecto=$request->idproyecto;
        $acta->idproyecto=$idproyecto;
        $numero=$this->GenerarNumero();
        $acta->numero=$numero;
        $acta->codigo= $this->retornaAbreviaturaDocumento('1').'-'.$numero.'-'.$this->retornaAbreviaturaCliente($idproyecto).'-'.date("Y");;
        //Abreviatura documento- correlativo-abreviatura proyecto-abreviaturacliente-año
        $acta->save();
        DB::commit();
        $idacta=$this->retornaIdActa($idproyecto);

        ?>
        <input type="hidden" name="idacta" id="idacta" value="<?php echo $idacta ?>">
        <input type="hidden" id="accion" value="2">

        <div class="col-sm-12">
            <label class="col-sm-3 control-label">Nº Acta</label>
            <div class="col-sm-3">
                <input type="text" class="form-control1" name="numero" disabled="" value="<?php echo $numero ?>">
            </div>
        </div>
        <?php
}

public function Exportar($id){

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
    // @LPLP-number4
    // $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$ndocumento;
    $correlativo=$this->traerCorrelatio($id);
    $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$correlativo;
    // dd($carpeta);
    $gerente2=$objProyecto->retronarGerente($id);
    $jefe2=$objProyecto->retornaJefe($id);
    $centrodecosto=$objProyecto->retornarCentroCostos($id);
    $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
    //Retornar CODE
    // $numero=$objProyecto->AbreviaturaDocumento('1').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-2';
    //@LPLP-number4
    $numero=$objProyecto->AbreviaturaDocumento('1').'-'.substr($nombreclave,4).'-1';
    //
        //tenemos que validar si es que ya existe...
    $resultado=$this->retornaIdactaInicio($id);
        $equipo=$this->listarEquipo($id);//para consultar el equipo
        $entregables=$this->listarEntregables($id,'1');
        //para listar las areas:
        $areas=$objArea->listarAreas();
        //para cargar la lista de aprobados, debemos cargar de la tabla firmas... los que tienen estado 2 y 3 pero diferente de 1
        $firmas=$this->listarFirmas($id,'1');
        //dd($firmas);
        $cronograma=$this->listarCronograma($id);

        $trabajadores=$this->RetornarEquipoTrabajo($id);

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
          ->where('firmas.iddocumento','=',1)
          ->where('firmas.idtrabajador',$idpersona_gerente->idpersona)->first();
        }else {
          $gerente = null;
        }


        // $idjeje=Proyecto::select('persona.idpersona')->join('persona','jefe','=','persona.idpersona')->join('trabajador','persona.idpersona','=','trabajador.idpersona')->where('idproyecto','=',$id)->where('persona.estado','=','1')->first();
        $idjefe = Proyecto::join('persona','jefe','=','persona.idpersona')
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
        ->where('firmas.iddocumento','=',1)
        ->where('firmas.idtrabajador',$idjefe->idpersona)->first();


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
        ->where('firmas.iddocumento','=',1)
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
        ->where('firmas.iddocumento','=',1)
        ->where('firmas.idtrabajador',$idpersona_adm->idpersona)->first();
$html='<!DOCTYPE html>';
$html.='<html lang="en">';
$html.='<head>
    <meta charset="UTF-8">
    <title>Acta de Inicio</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: sans-serif;
        }
p{
font-family: sans-serif;}
td{font-family: sans-serif;}
tr{font-family: sans-serif;}
body{font-family: sans-serif !important;}
        table{
            border-spacing: 0px;
	font-family: sans-serif;
        }
    </style>

</head>';
$html.='<body>
    <table  width="100%">
        <tr>
            <td width="28%" style="padding: 15px; border: 1px solid #000"><img src="logo.png" alt="" style="width:150px; height="50px"></td>
            <td width="53%" style="border: 1px solid #000"><h3 style="text-align: center; ">Acta de Inicio del Proyecto</h3></td>
            <td valign="top" style="border: 1px solid #000; font-size:10pt">Código: IPL-FOR-01 <br> Versión: 03 <br> Fecha: 30/08/2016</td>
        </tr>
    </table>
    <br>';
    $html.='<table width="100%">';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000 ; font-size:10pt;"><strong>N° DE ACTA</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000;font-size:10pt;padding-left:5px ">'.$numero.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>SERVICIO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$serv.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>DESCRIPCIÓN</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000;padding: 8px;; padding-left:5px;border-top: none; font-size:10pt ">'.$resultado[0]->descripcion.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>CLIENTE</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$cli.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>TITULAR DEL PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$resultado[0]->titular.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>NOMBRE DEL PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$nom.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>NOMBRE CLAVE DEL PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt">'.$nomcla.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>CENTRO DE COSTOS</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$centrodecosto.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>NOMBRE DE CARPETA DEL PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$carpeta.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>GERENTE</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$gerente2.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>JEFE DE PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$jefe2.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>FECHA DE INICIO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $date=date_create($resultado[0]->finicio);
		$fini=$date->format('d-m-Y');
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$fini.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>FECHA DE ENTREGA AL CLIENTE</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $date=date_create($resultado[0]->fentrega);
		$fini1=$date->format('d-m-Y');
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$fini1.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>FECHA DE CIERRE DEL PROYECTO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $date=date_create($resultado[0]->fcierre);
		$fini2=$date->format('d-m-Y');
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$fini2.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="25%" style="padding: 8px; border: 1px solid #000;border-top: none; font-size:10pt"><strong>SUJETO A BONO</strong></td>';
            $html.='<td width="1%" style="text-align: center "><strong>:</strong></td>';
            $html.='<td width="65%" style="border: 1px solid #000; padding-left:5px;border-top: none; font-size:10pt ">'.$resultado[0]->bono.' '.$resultado[0]->bono2 .'</td>';
        $html.='</tr>';
    $html.='</table>';
    $html.='<br>';

    $html.='<table width="100%">';
        $html.='<tr>';
            $html.='<td style="; border: 1px solid #000 ; text-align: center; font-size:11pt" colspan="5"><p><strong>EQUIPO DE TRABAJO</strong></p></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td width="3%" style="; border: 1px solid #000 ; text-align: center ; border-top: none; font-size:10pt" ><strong>N°</strong></td>';
            $html.='<td colspan="3"  width="35%" style="; border: 1px solid #000 ; text-align: center ; border-top: none; font-size:10pt" ><strong>Nombres y Apellidos</strong></td>';
            $html.='<td width="35%" style=" border: 1px solid #000 ; text-align: center ; border-top: none; font-size:10pt" ><strong>Puesto</strong></td>';
        $html.='</tr>';
           if(!empty($trabajadores)){
            $i=1;
            foreach ($trabajadores as $row) {
        $html.='<tr>';
            $html.='<td style=" border: 1px solid #000 ; text-align: center ; border-top: none; font-size:10pt" ><strong>'.$i.'</strong></td>';
            $html.='<td colspan="3" style=" border: 1px solid #000 ; border-top: none; font-size:10pt" >'.$row->nombre->nombre.' '.$row->apellido->apellidos.'</td>';
            $puesto=$this->retornarPuesto($row->apellido->idpuesto);
            $html.='<td style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none; font-size:10pt" >'.$puesto.'</td>';
        $html.='</tr>';
            $i++; } }
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>AMBITO DEL PROYECTO:</strong></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">'.$resultado[0]->ambito.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>ALCANCE DEL SERVICIO:</strong></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">'.$resultado[0]->alcance.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>METODOLOGÍA PARA LA EJECUCIÓN DEL SERVICIO:</strong></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">'.$resultado[0]->metodologia.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>ENTREGABLES:</strong></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">';
                if(!empty($entregables)){
                    $i=1;
                    foreach ($entregables as $row) {
                        $html.=''.$i.')'.$row->nombre.'<br>';
                    $i++; } }
            $html.='</td>';
        $html.='</tr>';


        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>CRONOGRAMA:</strong></td>';
        $html.='</tr>';


        $html.='<tr>';
           $html.=' <td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">';
               $html.='<img align="center" src="documentos/trabajador/'.$resultado[0]->cronograma.'" width="690" height="500" >';
            $html.='</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>CONTROL DE CALIDAD:</strong></td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt">'.$resultado[0]->calidad.'</td>';
        $html.='</tr>';
        $html.='<tr>';
            $html.='<td colspan="5" style="padding: 5px; border: 1px solid #000 ; border-top: none;font-size:10pt"><strong>FIRMAS:</strong></td>';
        $html.='</tr>';
    $html.='</table>';
    $html.='<table width="100%">';
        $html.='<tr>';
            $html.='<td  style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;font-size:10pt"><p><strong>Gerencia</strong></p></td>';
            $html.='<td  style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;font-size:10pt"><p><strong>Jefe de Proyecto</strong></p></td>';
            $html.='<td  style="padding: 5px; border: 1px solid #000 ; text-align: center ; border-top: none;font-size:10pt"><p><strong>Gerencia de Calidad</strong></p></td>';
            $html.='<td  style="border: 1px solid #000 ; text-align: center ; border-top: none;font-size:10pt"><p><strong>Gerencia de Administración</strong></p></td>';
        $html.='</tr>';
        $servidor=$_SERVER['SERVER_NAME'];
        $html.='<tr>';

            $html.='<td  style="border: 1px solid #000 ; text-align: center ; border-top: none;font-size:10pt">';
            if(!empty($gerente)) {
                $html.='<img align="center" src="documentos/trabajador/'.$gerente->firma.'" width="115" height="83" hspace="10" >';
            }
            $html.='</td>';
            $html.='<td  style=" border: 1px solid #000 ; text-align: center ; border-top: none;">';
            if (!empty($jefe)) {
                $html.='<img align="center" src="documentos/trabajador/'.$jefe->firma.'" width="115" height="83" hspace="10">';
            }
            $html.='</td>';
            $html.='<td  style=" border: 1px solid #000 ; text-align: center ; border-top: none;">';
            if (!empty($calidad)) {
                $html.='<img align="center" src="documentos/trabajador/'.$calidad->firma.'" width="115" height="83" hspace="10" >';
            }
            $html.='</td>';
            $html.='<td  style=" border: 1px solid #000 ; text-align: center ; border-top: none;">';
            if (!empty($adm)) {
                $html.='<img align="center" src="documentos/trabajador/'.$adm->firma.'" width="115" height="83" hspace="10" >';
            }
            $html.='</td>';
        $html.='</tr>';
    $html.='</table>';
$html.='</body>';
$html.='</html>';
$pdf = \App::make('dompdf.wrapper');
$pdf->setPaper('A4','portrait');
$pdf->loadHTML($html);
return @$pdf->stream('Acta_Inicio.pdf');
}
public function retornarPuesto($id){
    $puesto=Puesto::select('nombre')->where('idpuesto','=',$id)->first();
    return $puesto->nombre;
}

public function retornarEstadoCro(){
    $estado_cro=Estado_cronograma::select('*')->where('estado','=','1')->get();
    return $estado_cro;
}
public function traerCorrelatio($id)
{
    $proyecto=Proyecto::select('correlativo')->where('idproyecto',$id)->first();
    return $proyecto->correlativo;
}

public function inicio_actainicio($id){

    session_start();
    $idcronograma=0;
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="cronograma") {

                $idcronograma=1;
            }
        }

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
    $correlativo=$this->traerCorrelatio($id);
    $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$correlativo;
    $gerente=$objProyecto->retronarGerente($id);
    $jefe=$objProyecto->retornaJefe($id);
    $centrodecosto=$objProyecto->retornarCentroCostos($id);
    $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
    $traba=$objProyecto->cargarTodosTrabajadores();
    // dd($nomcla, $nombreclave);
    // $numero=$objProyecto->AbreviaturaDocumento('1').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1-1';
           $numero=$objProyecto->AbreviaturaDocumento('1').strstr($nombreclave,'-').'-1';
          //  dd($numero);
    //Retornar CODE
    //
        $estado_cro=$this->retornarEstadoCro();
        //tenemos que validar si es que ya existe...
        $resultado = $this->retornaIdactaInicio($id);
        $equipo = $this->listarEquipo($id);//para consultar el equipo
        $entregables = $this->listarEntregables($id,'1');
        //para listar las areas:
        $areas = $objArea->listarAreas();
        //para cargar la lista de aprobados, debemos cargar de la tabla firmas... los que tienen estado 2 y 3 pero diferente de 1
        $firmas = $this->listarFirmas($id,'1');
        //dd($firmas);
        $actaInicio = Acta_inicio::where('idacta', $id)->first();
        $cronograma = $this->listarCronograma($actaInicio->idproyecto);
        DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
        $firma = Firmas::where('idproyecto','=',$id)->where('idestadofirma','=','1')->where('estado','=','1')->update(['estado'=>'0']);
        DB::commit();


        if($resultado=='0'){//quiere decir que nunca se ha registrado un acta de inicio para este proyecto
            $idacta='0';
            $accion='1';
            $finicio=date("Y-m-d");
            $fentrega=date("Y-m-d");
            $fcierre=date("Y-m-d");
            $descripcion='';
            $titular='';
            $bono='0';
            $bono2='';
            $ambito='';
            $alcance='';
            $metodologia='';
            $calidad='';



        }else{//quiere decir que ya se registro, entonces necesitamos obtener sus datos.
            $idacta=$resultado[0]->idacta;
            $descripcion=$resultado[0]->descripcion;
            $titular=$resultado[0]->titular;
            $finicio=$resultado[0]->finicio;
            $fentrega=$resultado[0]->fentrega;
            $fcierre=$resultado[0]->fcierre;
            $bono=$resultado[0]->bono;
            $bono2=$resultado[0]->bono2;
            $ambito=$resultado[0]->ambito;
            $alcance=$resultado[0]->alcance;
            $metodologia=$resultado[0]->metodologia;
            $calidad=$resultado[0]->calidad;
            $accion='2';


        }

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }


        return view('inicio_actainicio',['id'=>$id,'serv'=>$serv,'cli'=>$cli,'nom'=>$nom,'nomcla'=>$nomcla,
            'carpeta'=> $carpeta,'gerente'=>$gerente,'jefe'=>$jefe,'centrodecosto'=>$centrodecosto,
            'nombreclave'=>$numero,'idacta'=>$idacta,'accion'=>$accion,
            'descripcion'=>$descripcion,'titular'=>$titular,'finicio'=>$finicio,'fentrega'=>$fentrega,
            'fcierre'=>$fcierre,'bono'=>$bono,'bono2'=>$bono2,'ambito'=>$ambito,'alcance'=>$alcance,'metodologia'=>$metodologia,'calidad'=>$calidad,
            'traba'=>$traba,'equipo'=>$equipo,'entregables'=>$entregables,'areas'=>$areas,'firmas'=>$firmas,'cronograma'=>$cronograma,'estado_cro'=>$estado_cro,'idcronograma'=>$idcronograma,'doc_validados'=>$doc_validados]);
    }



    public function deletefirma(Request $request)
    {
        $idproyecto=$request->idproyecto;
      // dd($request->all());
        $firma = Firmas::where('idfirma',$request->id)->update(['estado'=>'0']);
        $lista=$this->listarFirmasPendientes($idproyecto,$request->iddocumento,$request->idacta);
        if(count($lista)<=0){
            $lista=$this->listarFirmasPendientes2($idproyecto,$request->iddocumento);
        }
      if($request->iddocumento==1) {
    ?>

    <table id="myTable2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Gerencia</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $v['area'];?></td>
                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                    <td><?php echo $v['puesto'];?></td>
                    <td><?php echo $v['correo'];?></td>
                    <td><?php echo $v['estado'];?></td>
                    <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>);"></a></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
    }else{ ?>
        <table class="table">
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
                                            <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $idproyecto;?>);"></a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
<?php
    }
    }


}
