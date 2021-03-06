<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProyectoController;
use App\Matriz_roles;
use App\Documento_proyecto;
use DB;
use App\Seguimiento_proyecto;
use App\Proyecto_doc_valida;

class MatrizRoles_Inicio_Controller extends Controller
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

    public function retornarIdMatrizRoles($idproyecto){
         $resultado = Matriz_roles::select('idmatrizroles','fecha','documento','archivo','descripcion')->where('idproyecto','=',$idproyecto)->get();
        //dd($resultado);
        if(count($resultado)==0){
            $valor='0';
        }else{
            $valor=$resultado;
        }
        return $valor;

    }

    //INICIO
    public function inicio_matrizrol($id){

        $objProyecto=new ProyectoController();

        $nom=$objProyecto->retronarNombreProyecto($id);
        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);

        $resultado=$this->retornarIdMatrizRoles($id);

        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);


        if($resultado=='0'){//no existe
        $idmatriz='0';
        $fecha=date("Y-m-d");
        $accion='1';
        $doc='#';
        $archivo='#';
        $descripcion="";
        $documento="";
        }else{
        $idmatriz=$resultado[0]->idmatrizroles;
        $fecha=$resultado[0]->fecha;
        $accion='2';
        $doc=$resultado[0]->documento;
        $archivo=$resultado[0]->archivo;
        $descripcion=$resultado[0]->descripcion;
        $documento=$resultado[0]->documento;
        }

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('inicio_matrizrol',['id'=>$id,'nom'=>$nom,'nomcla'=>$nomcla,'idmatriz'=>$idmatriz,
            'fecha'=>$fecha,'accion'=>$accion,'doc'=>$doc,'archivo'=>$archivo,'descripcion'=>$descripcion,'nombreclave'=>$nombreclave,'docuemnto'=>$documento, 'doc_validados'=>$doc_validados]);
    }

     public function quitar_tildes($cadena) {
        $no_permitidas = 
        array 
        ("á","é","í","ó","ú",
        "à","è","ì","ò","ù",
        "Á","É","Í","Ó","Ú",
        "À","È","Ì","Ò","Ù",
        "ñ","Ñ","À","Ã","Ì",
        "Ò","Ù","Ã™","Ã","Ã¨",
        "Ã¬","Ã²","Ã¹","ç","Ç",
        "Ã¢","ê","Ã®","Ã´","Ã»",
        "Ã‚","ÃŠ","ÃŽ","Ã”","Ã›",
        "ü","Ã¶","Ã–","Ã¯","Ã¤",
        "«","Ò","Ã","Ã„","Ã‹");
        $permitidas= 
        array 
        ("a","e","i","o","u",
        "a","e","i","o","u",
        "A","E","I","O","U",
        "A","E","I","O","U",
        "n","N","A","A","I",
        "O","U","A","A","A",
        "A","A","A","c","C",
        "A","e","A","A","A",
        "A","AS","AZ","A","A",
        "u","A","A","A","A",
        "a","O","A","A");
        $texto = str_replace($no_permitidas,$permitidas,$cadena);
        return $texto;
        }

    //AJAX

     public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();

        if($request->op=="1"){
        $idproyecto=$_REQUEST["idproyecto"];
        $accion=$_REQUEST["accion"];
        $fecha=$_REQUEST["fecha"];
        $url= $_FILES['file']['name'];
        $descripcion=$_REQUEST["descripcion"];
        $nombre=basename($url);
        $nombre1 = $this->quitar_tildes($nombre);
        $archivo=$idproyecto.'_'.$nombre1;

        if($accion=='1'){
    
        DB::beginTransaction();
        $matriz = Matriz_roles::create($request->all());
        $matriz->idproyecto=$idproyecto;   
        $matriz->iddocumento='3';
        $matriz->fecha=$fecha;
        $matriz->documento=$nombre1 ;
        $matriz->archivo=$archivo;
        $matriz->descripcion=$descripcion;
        $matriz->save();
        DB::commit();

        DB::beginTransaction();
        $documento = Documento_proyecto::create($request->all());
        $documento->idproyecto=$idproyecto;   
        $documento->iddocumento='3';
        $documento->save();
        DB::commit();

        $objActaIni=new Acta_inicioController();
        $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }

        }else if($accion=='2'){

        DB::beginTransaction();//pero antes de guardar, tenemos que editar todos los que tienen uno
        $m = Matriz_roles::where('idproyecto','=',$idproyecto)->update(['fecha'=>$fecha,'documento'=>$nombre,'archivo'=>$archivo,'descripcion'=>$descripcion]);
        DB::commit();

        $objActaIni=new Acta_inicioController();
        $verificar=$objActaIni->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actuliza=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>2]);
        }

        }

        if($url!=""){
        copy($_FILES['file']['tmp_name'], "documentos/matriz_roles/".$archivo);//copiando al servidor la imagen. "servidor/imagenes/profesor/$foto ruta,
        }
        ?>
        <div class="col-xs-12 col-sm-3">
        <a  href="../documentos/matriz_roles/<?php echo $archivo?>" download="<?php echo $nombre?>"><button type="button" class="btn btn-default" >Descargar</button> </a>
        </div>
        <?php



        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }

}
