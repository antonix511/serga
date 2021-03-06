<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Reporte_ho;
use DB;
use App\Seguimiento_proyecto;
use App\Proyecto_doc_valida;

class ReporteHo_Ejecucion_Controller extends Controller
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

    public function ejecucion_reporte($id){

        $archivo=$this->listarDocumento($id);
        $idreporteho = $this->idreporteho($id);
        $nombreArchivo = $this->nombreArchivo($id);
        $objProyecto=new ProyectoController();
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        if($archivo=="demo.pdf"){
            $accion="1";
        }else{
            $accion="2";
        }

        $listadoc= Reporte_ho::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','9')->get();

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('ejecucion_reporte',['id'=>$id,'archivo'=>$archivo,'accion'=>$accion,'nombreclave'=>$nombreclave,'idreporteho'=>$idreporteho,'nombreArchivo'=>$nombreArchivo,'listadoc'=>$listadoc,'doc_validados'=>$doc_validados]);
    }

    public function reporte_ho($idreporteho)
    {
      $reporte_ho = Reporte_ho::select('*')->where('idreporteho', $idreporteho)->orderby('idreporteho','desc')->first();

      return $reporte_ho->toJson();
    }

    public function nombreArchivo($id)
    {
      $nombreArchivo = Reporte_ho::select('*')->where('idproyecto', $id)->orderby('idreporteho','desc')->first();

      if(!empty($nombreArchivo)){
          return $nombreArchivo->nombre;
      }else{
        return " ";
      }

    }

    public function idreporteho($idproyecto)
    {
      $idreporteho = Reporte_ho::select('*')->where('idproyecto', $idproyecto)->orderby('idreporteho','desc')->first();

      if (!empty($idreporteho)) {
        return $idreporteho->idreporteho;
      } else {
        return " ";
      }
    }

    public function listarDocumento($idproyecto){

        $codigo = Reporte_ho::select('archivo')->where('idproyecto','=',$idproyecto)
        ->where('estado','=','1')->orderby('idreporteho','desc')->get();

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
          $idreporteho = $request->idreporteho;
            $idproyecto=$_REQUEST["idproyecto"];
            $accion=$_REQUEST["accion"];
            if($accion=="1"){
              DB::beginTransaction();
              $reporte = Reporte_ho::create($request->all());
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
              $url= $_FILES['file']['name'];
              $nombre=basename($url);
              $archivo=$idproyecto.'_'.$nombre;
              DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
              $m = Reporte_ho::where('idproyecto','=',$idproyecto)->where('idreporteho', $idreporteho)->update(['nombre'=>$nombre,'archivo'=>$archivo]);
              DB::commit();
            }

            if($url!=""){
            copy($_FILES['file']['tmp_name'], "documentos/reporteho/".$archivo);//copiando al servidor la imagen. "servidor/imagenes/profesor/$foto ruta,
            $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }
            }
            //consultamos el ingresado
            ?>
            <embed src="../documentos/reporteho/<?php echo $archivo;?> " width="100%" height="600">
            <?php

        }else if($request->op=="2"){


            $idproyecto=$_REQUEST["idproyecto"];
            DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
            $m = Reporte_ho::where('idproyecto','=',$idproyecto)->update(['estado'=>'0']);
            DB::commit();

            ?>
            <embed src="../documentos/reporteho/demo.pdf " width="100%" height="100">
            <script type="text/javascript">swal("Enviado!", "Documento correctamente eliminado", "success");</script>
            <?php

        }else if($request->op=="3"){

        }
    }
}
