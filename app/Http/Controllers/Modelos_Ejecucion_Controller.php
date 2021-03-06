<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Modelos;
use App\Tipo_modelo;
use App\Seguimiento_proyecto;

class Modelos_Ejecucion_Controller extends Controller
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
            $nombreTipo=$this->NombreTipo($request->idtipo_modelo);
       
            DB::beginTransaction();
            $reporte = Modelos::create($request->all());

            $url=$nombreTipo."/". $_FILES['file']['name'];
            $nombre=basename($url);
            $archivo=$nombre;
            $reporte->nombre=$nombre;
            $reporte->archivo=$url;
            $reporte->idtipo_modelo=$request->idtipo_modelo;
            $reporte->save();
            DB::commit();

            if($url!=""){
            copy($_FILES['file']['tmp_name'], "documentos/modelos/".$url);//copiando al servidor la imagen. "servidor/imagenes/profesor/$foto ruta,
            }
            $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }

            $modelos=Modelos::with(['documento'])->where('idtipo_modelo','=',$request->idtipo_modelo)->where('estado','=','1')->orderby('nombre','desc')->get();

        ?>
        <script type="text/javascript" src="{{asset('/js/sc.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/formato.js')}}"></script>
        <table class="table" id="TablaModelosTipo">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Tipo de documento</th>
                        
                                            <th>Opciones</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;?>
                                        <?php foreach($modelos as $row){ ?>
                                          <tr>
                                            <td><?=$i?></td>
                                            <td><?=$row->nombre?></td>
                                            <td><?=$row->documento->nombre?></td>
                                        
                                        
                                            <td>
                                                 <a href="../documentos/modelos//<?=$row->archivo?>" download="<?=$row->documento->archivo?>">
                                                 <button> Descargar</button></a>
                                    </td>
                                          </tr>
                                          <?php $i++; ?>
                                          <?php } ?>
                                          
                                        </tbody>
                                      </table>

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
    public function NombreTipo($idtipo_modelo)
    {
        $TipoModelo=Tipo_modelo::select('nombre')->where('idtipo_modelo','=',$idtipo_modelo)->first();
        return $TipoModelo->nombre;
    }

    //INICIO
    public function ejecucion_modelos($id){

        $modelos=Modelos::with(['documento'])->where('idtipo_modelo','=',1)->where('estado','=','1')->get();
        $TipoModelo=Tipo_modelo::select('*')->get();
        $objProyecto=new ProyectoController();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        return view('ejecucion_modelos',['id'=>$id,'modelos'=>$modelos,'TipoModelo'=>$TipoModelo,'nombreclave'=>$nombreclave]);
    }

    public function MostrarModelos(Request $request){

        $modelos=Modelos::with(['documento'])->where('idtipo_modelo','=',$request->idtipo_modelo)->where('estado','=','1')->get();
?>
        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Tipo de documento</th>
                        
                                            <th>Opciones</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;?>
                                        <?php  foreach($modelos as $row){ ?>
                                          <tr>
                                            <td><?=$i?></td>
                                            <td><?=$row->nombre?></td>
                                            <td><?=$row->documento->nombre?></td>
                                        
                                        
                                            <td>
                                                 <a href="../documentos/modelos/<?=$row->archivo?>" download="<?=$row->documento->archivo?>">
                                                 <button> Descargar</button></a>
                                    </td>
                                          </tr>
                                          <?php $i++; ?>
                                          <?php } ?>
                                          
                                        </tbody>
<?php
    }

    public function FormularioModelos(){

        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        $modelos=Modelos::with(['documento'])->where('idtipo_modelo','=',1)->where('estado','=','1')->orderby('nombre','desc')->get();
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="modelos") {
                $TipoModelo=Tipo_modelo::select('*')->get();
                return view('modelos',['TipoModelo'=>$TipoModelo,'modelos'=>$modelos]);
            }
        }

         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
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
}
