<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proyecto;

use Auth;
use App\Matriz_comunicacion;
use App\Tipo_proyecto;
use App\Tipo_contrato;
use App\Departamento;
use App\Provincia;
use App\Distrito;




class VentasInicio_Controller extends Controller
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

    }

    public function CargarProyecto ($id) {
         session_start();
        $objProyecto=new ProyectoController();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        $cliente=$objProyecto->cargarClientes();
        $servicio=$objProyecto->cargarServicio();
        $gerente=$objProyecto->cargarGerentes();
        $jefe=$objProyecto->cargarJefes();
        $tipoproyecto = Tipo_proyecto::all();
        $departamento = Departamento::all();
        $provincia = Provincia::all();
        $distrito = Distrito::all();
        $tipo_contrato = Tipo_contrato::all();
        $trabajadores = $objProyecto->cargarTodosTrabajadores();
        //$proyecto=Proyecto::select('*')->join('persona','persona.idpersona','=','proyecto.idcliente')->where('idproyecto',$id)->first();
        $proyecto=Proyecto::with(['persona','cliente','servicio','distrito','departamento','provincia','retornar_gerente','retornar_jefe','retornar_tipProyecto','retornar_tipContrato','notificado1','notificado2'])->where('idproyecto',$id)->first();
        $editar=0;
        return view('ventas_info',['id'=>$id,'nombreclave'=>$nombreclave,'proyecto'=>$proyecto,'editar'=>$editar,'clientes'=>$cliente,'servicios'=>$servicio,'gerente'=>$gerente,'jefes'=>$jefe,'tipoproyecto'=>$tipoproyecto,'trabajadores'=>$trabajadores,'departamento'=>$departamento,'provincia'=>$provincia,'distrito'=>$distrito,'tipo_con'=>$tipo_contrato]);
    }

    public function editarproyecto($id)
    {

        session_start();

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

        $inicio=0;
        $ejecucion=0;
        $cierre=0;

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
        $_SESSION['inicio']=0;
        $_SESSION['ejecucion']=0;
        $_SESSION['cierre']=0;

        if( ($_SESSION['pactainicio']>0) || ($_SESSION['pmatrizcomu']>0) || ($_SESSION['pmatrizrol']>0) || ($_SESSION['pmatrizries']>0) || ($_SESSION['preqlogist']>0) || ($_SESSION['preqcarteq']>0) ){
            $_SESSION['inicio']=50;
        }
        if ( ($_SESSION['pactareunion']>0) || ($_SESSION['psolcambio']>0) || ($_SESSION['pactaacuerdo']>0) || ($_SESSION['preportho']>0) || ($_SESSION['psolac']>0)  ) {
            $_SESSION['ejecucion']=70;
        }
        if ( ($_SESSION['pactacierre']>0) || ($_SESSION['pactareuc']>0) ) {
            $_SESSION['cierre']=90;
        }
        $objProyecto=new ProyectoController();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        $cliente=$objProyecto->cargarClientes();
        $servicio=$objProyecto->cargarServicio();
        $gerente=$objProyecto->cargarGerentes();
        $jefe=$objProyecto->cargarJefes();
        $tipoproyecto = Tipo_proyecto::all();
        $departamento = Departamento::all();
        $provincia = Provincia::all();
        $distrito = Distrito::all();
        $tipo_contrato = Tipo_contrato::all();
        $trabajadores = $objProyecto->cargarTodosTrabajadores();
        //$proyecto=Proyecto::select('*')->join('persona','persona.idpersona','=','proyecto.idcliente')->where('idproyecto',$id)->first();
        $proyecto=Proyecto::with(['persona','cliente','servicio','distrito','departamento','provincia','retornar_gerente','retornar_jefe','retornar_tipProyecto','retornar_tipContrato','notificado1','notificado2'])->where('idproyecto',$id)->first();



        $editar=1;
        return view('ventas_info',['id'=>$id,'nombreclave'=>$nombreclave,'proyecto'=>$proyecto,'editar'=>$editar,'clientes'=>$cliente,'servicios'=>$servicio,'gerente'=>$gerente,'jefes'=>$jefe,'tipoproyecto'=>$tipoproyecto,'trabajadores'=>$trabajadores,'departamento'=>$departamento,'provincia'=>$provincia,'distrito'=>$distrito,'tipo_con'=>$tipo_contrato]);
    }
    function editar_info_proyecto(Request $request, $id){

      // dd($request->finicio, $request->fentrega);
      // if (isset($request->finicio)) {
      //   $finicio = date('Y-m-d', strtotime($request->finicio));
      // }
      // if (isset($request->fentrega)) {
      //   $fentrega = date('Y-m-d', strtotime($request->fentrega));
      // }
      // $actualizar=Proyecto::where('idproyecto','=',$request->c1)
      $actualizar=Proyecto::where('idproyecto','=',$id)
                            ->update(['contacto'=>$request->contacto,'nombre'=>$request->nombre,'idcliente'=>$request->idcliente,
                                      'idservicio'=>$request->idservicio,'gerente'=>$request->gerente,'jefe'=>$request->jefe,
                                      'idtipoproyecto'=>$request->idtipoproyecto,'iddepartamento'=>$request->iddepartamento,'idtipocontrato'=>$request->idtipocontrato,'descripcion'=>$request->descripcion,'faceptacion'=>$request->faceptacion,
                                      'idprovincia'=>$request->idprovincia,'iddistrito'=>$request->iddistrito,'idmoneda'=>$request->idmoneda,
                                      'presupuesto'=>$request->presupuesto,
                                      'centrodecosto'=>$request->centrodecosto, 'presupuestoadicional'=>$request->presupuestoadicional, 'observacion'=>$request->observacion,
                                      'nombreclave'=>$request->c1, 'code' =>$request->code,
                                      'finicio' =>$request->finicio, 'fentrega'=>$request->fentrega
                                    ]);
    }

    function ExportarExcel($id){

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
    $carpeta='\\'.$abrevcliente.'\\'.$anioproyecto.'_'.$abreviaturaservicio.$ndocumento;
    $gerente=$objProyecto->retronarGerente($id);
    $jefe=$objProyecto->retornaJefe($id);
    $centrodecosto=$objProyecto->retornarCentroCostos($id);
    $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
    //Retornar CODE
    $numero=$objProyecto->AbreviaturaDocumento('1').'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-2';


    $proyecto=Proyecto::with(['persona','cliente','servicio','distrito','departamento','provincia','retornar_gerente','retornar_jefe','retornar_gerente_apellido','retornar_jefe_apellido','retornar_tipProyecto','retornar_tipContrato','notificado1','notificado2'])->where('idproyecto',$id)->first();


    //
        //tenemos que validar si es que ya existe...

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=Informacion_Proyecto.xls");

?>
<style type="text/css">
    table{
        font-family: Arial;
    }
</style>
<meta charset="utf-8">

<table>
    <tr> <td colspan="6" style="border-bottom: 1px solid black;"></td></tr>
    <tr>
        <td rowspan="3" colspan="2" align="center" style="border:1px solid black;"> <center><img src="http://serga.jp-planning.com/logo.png" border="0" height="60" width="140" align="middle" /></center></td>
        <td rowspan="1" colspan="3"></td>
        <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>

    </tr>
    <tr>
         <td rowspan="1" colspan="3" style="font-size:20px"><strong><center>Información del Proyecto</center> </strong></td>
         <td colspan="1" style="border-left: 1px solid black;border-right: 1px solid black;font-size:12px">Código:VEN-FOR-01</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="1" style="border-left: 1px solid black;border-right: 1px solid black;font-size:12px">Versión: 01</td>
    </tr>
    <tr>
        <td colspan="6" style="border-top: 1px solid black;"></td>
    </tr>

    <tr>
        <td></td>
        <td colspan="2" ><strong>N° Documento:</strong></td>
        <td style="border:1px solid black;"> <center><?=$proyecto->ndocumento?></center></td>
        <td align="right"><strong>Fecha*:</strong></td>
        <td style="border:1px solid black;"><center><strong><?=$proyecto->fecha?></strong></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Cliente:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->persona->nombre?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Contacto con el Cliente(Facturación)</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->contacto?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Nombre del Proyecto:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->nombre?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Nombre Clave del Proyecto:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$nomcla?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Servicio:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->servicio->nombre?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Descripción:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->descripcion?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Ubicación:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?php echo $proyecto->departamento->nombre."-".$proyecto->provincia->nombre."-".$proyecto->distrito->nombre ?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Gerente:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->retornar_gerente->nombre?>  <?=$proyecto->retornar_gerente_apellido->apellidos?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Jefe de proyecto:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->retornar_jefe->nombre?>  <?=$proyecto->retornar_jefe_apellido->apellidos?></center></td>
    </tr>
    <!-- LPLP -->
    <?php if (in_array(Auth::user()->usuario, array('svera', 'jaleon', 'yvera', 'admin'))){ ?>
      <tr>
        <td colspan="6" style="height: 15px;"></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2"><strong>Presupuesto de venta:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->presupuesto?></center></td>
      </tr>
    <?php }; ?>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Tipo de proyecto:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->retornar_tipProyecto->nombre?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Tipo de Contrato:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->retornar_tipContrato->nombre?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Fecha de aceptación de la propuesta:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->faceptacion?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Fecha de inicio del proyecto:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->finicio?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 15px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><strong>Fecha de entrega:</strong></td>
        <td colspan="3" style="border:1px solid black;"><center><?=$proyecto->fentrega?></center></td>
    </tr>
    <tr>
        <td colspan="6" style="height: 25px;"></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5" bgcolor="#BDBDBD" style="border:1px solid black;"> <center> <strong>CAMPO LLENADO SOLO PARA ADENDAS/ADICIONALES</strong></center></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" bgcolor="#BDBDBD" style="border-left: 1px solid black;border-right:
        1px solid black;">N. de Centro de Costos</td>
        <td colspan="3" style="border-left: 1px solid black;border-right:
        1px solid black;" bgcolor="#BDBDBD">NO APLICA</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2" bgcolor="#BDBDBD" style="border-left: 1px solid black;border-right:
        1px solid black;">Presupuesto de Venta Adicional</td>
        <td colspan="3" bgcolor="#BDBDBD" style="border-right:1px solid black;">NO APLICA</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="5" rowspan="5" style="border:1px solid black;">
            Observaciones: <br>
            <?=$proyecto->observacion?>
        </td>
    </tr>

</table>
<label>*Fecha: debe ser llenado con la fecha en la cual se genera el formato.</label>

<?php
        //----------------
    }



}
