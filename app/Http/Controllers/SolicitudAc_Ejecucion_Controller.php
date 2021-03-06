<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Solicitud_ac;
use DB;
use App\Seguimiento_proyecto;
use App\Proyecto_doc_valida;

class SolicitudAc_Ejecucion_Controller extends Controller
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

    public function ejecucion_solicitudac($id){

        $archivo=$this->listarDocumento($id);
        $objProyecto=new ProyectoController();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        if($archivo=="demo.pdf"){
            $accion="1";
        }else{
            $accion="2";
        }
        $nombreArchivo = $this->nombreArchivo($id) ;
        $idsolicitudac = $this->idsolicitudac($id);

        $listadoc= Solicitud_ac::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','9')->get();

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('ejecucion_solicitudac',['id'=>$id,'archivo'=>$archivo,'accion'=>$accion,'nombreclave'=>$nombreclave,'nombreArchivo'=>$nombreArchivo,'idsolicitudac'=>$idsolicitudac,'listadoc'=>$listadoc,'doc_validados'=>$doc_validados]);
    }

    public function reporte_sa($idsolicitudac)
    {
      $reporte_sa = Solicitud_ac::select('*')->where('idsolicitudac', $idsolicitudac)->orderby('idsolicitudac','desc')->first();

      if (!empty($reporte_sa)) {
          return $reporte_sa->toJson();
      } else {
          return 0;
      }


    }

    public function nombreArchivo($id)
    {
    $nombreArchivo = Solicitud_ac::select('nombre')->where('idproyecto', $id)->orderby('idsolicitudac','desc')->first();
    if (!empty($nombreArchivo)) {
        return $nombreArchivo->nombre;
    } else {
        return " ";
    }

    }

    public function idsolicitudac($id)
    {
      $idsolicitudac =  Solicitud_ac::select('idsolicitudac')->where('idproyecto', $id)->orderby('idsolicitudac','desc')->first();
      if (!empty($idsolicitudac)) {
          return $idsolicitudac->idsolicitudac;
      } else {
          return 0;
      }


    }

    public function listarDocumento($idproyecto){

        $codigo = Solicitud_ac::select('archivo')->where('idproyecto','=',$idproyecto)
        ->where('estado','=','1')->orderby('idsolicitudac','desc')->get();

        if(count($codigo)==0){
            $cod='demo.pdf';
        }else{
            $cod =$codigo[0]->archivo;
        }
        return $cod;
    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){
            $idsolicitudac = $request->idsolicitudac;
            $idproyecto=$_REQUEST["idproyecto"];
            $accion=$_REQUEST["accion"];
            if($accion=="1"){
              DB::beginTransaction();
              $reporte = Solicitud_ac::create($request->all());
              $reporte->idproyecto=$idproyecto;
              $url= $_FILES['file']['name'];
              $nombre=basename($url);
              $archivo=$idproyecto.'_'.$nombre;
              $reporte->nombre=$nombre;
              $reporte->archivo=$archivo;
              $reporte->iddocumento="9";
              $reporte->save();
              DB::commit();
            }else if($accion=="2"){
              DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
              $url= $_FILES['file']['name'];
              $nombre=basename($url);
              $archivo=$idproyecto.'_'.$nombre;
              // $m = Solicitud_ac::where('idproyecto','=',$idproyecto)->update(['estado'=>'0']);
              $m = Solicitud_ac::where('idproyecto','=',$idproyecto)->where('idsolicitudac', $idsolicitudac)->update(['nombre'=>$nombre,'archivo'=>$archivo]);
              DB::commit();
            }

            $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
            $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
            if ($verificar>0) {
                $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
            }
            if($url!=""){
            copy($_FILES['file']['tmp_name'], "documentos/solicitudac/".$archivo);//copiando al servidor la imagen. "servidor/imagenes/profesor/$foto ruta,
            }
            //consultamos el ingresado
            ?>
            <embed src="../documentos/solicitudac/<?php echo $archivo;?> " width="100%" height="600">
            <?php

        }else if($request->op=="2"){

            $idproyecto=$_REQUEST["idproyecto"];
            DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
            $m = Solicitud_ac::where('idproyecto','=',$idproyecto)->update(['estado'=>'0']);
            DB::commit();

            ?>
            <embed src="../documentos/solicitudac/demo.pdf " width="100%" height="100">
            <script type="text/javascript">swal("Enviado!", "Documento correctamente eliminado", "success");</script>
            <?php

        }else if($request->op=="3"){

        }
    }
}
