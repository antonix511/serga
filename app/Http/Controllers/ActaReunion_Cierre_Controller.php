<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Acta_reunion;
use App\Firmas;
use DB;
use App\Proyecto;
use App\Proyecto_doc_valida;
use Auth;

class ActaReunion_Cierre_Controller extends Controller
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


    public function retornarActaReunion($idproyecto, $id_actareu = 0){
        if($id_actareu > 0){
          $req=Acta_reunion::with(['documento','area'])->where('acta_reunion.idproyecto','=',$idproyecto)->where('acta_reunion.idacta_reunion','=',$id_actareu)->where('acta_reunion.iddocumento','=',12)->orderby("idacta_reunion", "desc")->where('acta_reunion.estado',1)->first();
        }else{
          $req=Acta_reunion::with(['documento','area'])->where('acta_reunion.idproyecto','=',$idproyecto)->where('acta_reunion.iddocumento','=',12)->orderby("idacta_reunion", "desc")->where('acta_reunion.estado',1)->first();
        }
        return $req;
    }
    public function retornarActaReunion_menu($idacta){
        $req=Acta_reunion::with(['documento','area'])->where('acta_reunion.idproyecto','=',0)->where('idacta_reunion',$idacta)->where('acta_reunion.iddocumento','=',12)->orderby("idacta_reunion", "desc")->first();
        return $req;
    }


    public function ActualizarActa(Request $request){

        DB::beginTransaction();
        $actareu = Acta_reunion::where('idproyecto','=',$request->idproyecto)->where('iddocumento','=',$request->iddocumento)->where('nacata', $request->nacata)->update(['tema'=>$request->tema,'fecha'=>$request->fecha,'idencargado'=>$request->idencargado,'acciones'=>$request->acciones,'fecha_requerida'=>$request->fecha_requerida,'temas'=>$request->temas,'hora'=>$request->hora]);
        DB::commit();
    }


    public function cierre_actar($id){

      $usuario=Auth::user()->usuario;
      $objComite=new Comite_controller();
      $DataUsuario=$objComite->CargarUsuario($usuario);
      $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="cierre_actar") {
          $objProyecto=new ProyectoController();
          //CODE
          $idservicio=$objProyecto->retornarIdServicioProyecto($id);
          $idcliente=$objProyecto->retronaIdClienteProyecto($id);
          $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

          $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
          // $numero=$objProyecto->AbreviaturaDocumento(6).'-'.$objProyecto->AbreviaturaCliente($idcliente).'-'.date("Y").'-'.$objProyecto->retornarAbreviaturaServicio($idservicio).'-1';
          $numero=$objProyecto->AbreviaturaDocumento(6).'-'.substr($nombreclave,4).'-1';
          $nombrepro=Proyecto::select('nombre')->where('idproyecto',$id)->first();

          $idacta = $this->idacta($id);
          // dd($idacta);

          $objActaInicio=new Acta_inicioController();
          $lista=$objActaInicio->listarFirmasPendientes($id,13,$idacta);

          $objActaReu=new ActaReu_Ejecucion_Controller();
          $trabajadores=$objActaReu->cargarTrabajadores();
          $acta=$this->retornarActaReunion($id);
          //dd($acta);

          //area
          $objArea=new Area_Controller();
          $areas=$objArea->listarAreas();

          //fin area
          $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','12')->orderby('idacta_reunion','desc')->get();

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
          ->where('firmas.iddocumento','=',13)->get();

          $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
          $doc_validados = [];
          foreach ($doc_valida as $kdoc => $vdoc) {
              $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
          }

          return view('cierre_actar',['id'=>$id,'numero'=>$numero,'gerentesYJefes'=>$gerentesYJefes,'acta'=>$acta,'trabajadores'=>$trabajadores,'lista'=>$lista,'areas'=>$areas,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'listano'=>$listano,'nombrepro'=>$nombrepro,'doc_validados'=>$doc_validados]);
        }
      }
      ?>
      <script type="text/javascript">
      alert("Usted no Tiene permitido el acceso a este modulo");
      window.location.href='/inicio';
      </script>
      <?php
    }


    public function acta_menu($id=0){

        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        $idacta = $this->idacta($id);
        // dd($idacta);

        $objActaInicio=new Acta_inicioController();
        $lista=$objActaInicio->listarFirmasPendientes($id,13,$idacta);

        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();

        $actafinal=$this->retornarActaReunion($id);

        // Reinicio de correlativo en nuevo año
        if (date('y') > date('y', strtotime($actafinal->fecha_registro))) {
          $nacta = 1;
        }else {
          $nacta = (int)substr($actafinal->nacata,8) + 1;
        }
        $numero=$objProyecto->AbreviaturaDocumento(6).'-'.date("Y").'-'.$nacta;
        $idnuevaacta = $actafinal->idacta_reunion + 1;

        $acta=null;


        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();

        //echo "el id acta es: ".$idacta;

        //fin area
        $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','12')->where('estado','1')->orderby('idacta_reunion','desc')->get();
        $ultima_acta=$this->nuevo_idacta();
        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->join('acta_reunion','acta_reunion.idproyecto','=','firmas.idproyecto')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('trabajador.estado','1')
        ->where('persona.estado','1')
        ->where('acta_reunion.estado','1')
        ->where('firmas.idproyecto','=',$id)
        ->where('firmas.idacta','=',$idacta)
        ->where('firmas.iddocumento','=',13)->distinct()->get();


        return view('reunion_gerentes',['id'=>$id,'numero'=>$numero,'gerentesYJefes'=>$gerentesYJefes,'acta'=>$acta,'trabajadores'=>$trabajadores,'lista'=>$lista,'areas'=>$areas,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'listano'=>$listano,'idacta'=>$ultima_acta]);
    }
    public function acta_menu_firmas($id){

        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto(0);
        $idcliente=$objProyecto->retronaIdClienteProyecto(0);
        $numero=$objProyecto->AbreviaturaDocumento(6).'-'.date("Y").'-1';
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

        $nombreclave=$objProyecto->retronarNombreClaveProyecto(0);

        $idacta = Acta_reunion::select('*')->where('idacta_reunion',$id)->where('estado',1)->first();
        // dd($idacta);

        $objActaInicio=new Acta_inicioController();
        $lista=$objActaInicio->listarFirmasPendientes(0,13,$idacta->idacta_reunion);

        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();

        $acta=Acta_reunion::with(['documento','area'])->where('acta_reunion.idproyecto','=',0)->where('idacta_reunion',$id)->where('acta_reunion.iddocumento','=',12)->orderby("idacta_reunion", "desc")->where('acta_reunion.estado',1)->first();

        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();

        //fin area
        $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','12')->where('estado','1')->orderby('idacta_reunion','desc')->get();
        $ultima_acta=$this->nuevo_idacta();
        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('trabajador.estado','1')
        ->where('persona.estado','1')
        ->where('ac.estado','1')
        ->where('firmas.idacta',$id)
        ->where('firmas.idproyecto','=',0)
        ->where('firmas.iddocumento','=',13)->get();

        return view('reunion_gerentes',['id'=>$id,'numero'=>$numero,'gerentesYJefes'=>$gerentesYJefes,'acta'=>$acta,'trabajadores'=>$trabajadores,'lista'=>$lista,'areas'=>$areas,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'listano'=>$listano,'idacta'=>$ultima_acta]);
    }



    public function tabla_documentos($id)
    {
      $listadoc= Acta_reunion::select('*')->where('idproyecto','=',$id)->where("iddocumento",'=','12')->orderby('idacta_reunion','desc')->get();
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

    public function id_firmas(Request $request)
    {
      $nacata =$request->nacata;
      $iddocumento = $request->iddocumento;
      if($iddocumento==13){
        $iddocumento = 12;
      }
      $id_firmas = Acta_reunion::select('idacta_reunion')->where('nacata', $nacata)->where('iddocumento', $iddocumento)->first();

      if (!empty($id_firmas)) {
        return $id_firmas->toJson();
      }else {
        return 0;
      }

    }

    public function idacta($idproyecto, $id_actareu = 0)
    {
        if($id_actareu > 0){
          $idacta = Acta_reunion::select('idacta_reunion')->where('idproyecto','=',$idproyecto)->where('idacta_reunion', $id_actareu)->where('iddocumento', '12')->orderby('idacta_reunion','desc')->first();
        }else{
          $idacta = Acta_reunion::select('idacta_reunion')->where('idproyecto','=',$idproyecto)->where('iddocumento', '12')->orderby('idacta_reunion','desc')->first();
        }

        if(empty($idacta)){
            return null;
        }else{
             return $idacta->idacta_reunion;
        }

    }
    public function nuevo_idacta()
    {
        $idacta = Acta_reunion::select('idacta_reunion')->where('iddocumento', '12')->orderby('idacta_reunion','desc')->first();

        if(empty($idacta)){
            return null;
        }else{
             return $idacta->idacta_reunion+1;
        }

    }
    public function idacta_menu($idacta)
    {
        $idacta = Acta_reunion::select('idacta_reunion')->where('idproyecto','=',0)->where('idacta_reunion',$idacta)->where('iddocumento', '12')->orderby('idacta_reunion','desc')->first();

        if(empty($idacta)){
            return null;
        }else{
             return $idacta->idacta_reunion;
        }

    }

    public function ultimi_id(Request $request)
    {

      $ultimi_id = Acta_reunion::select('nacata')->where('estado', '1')->orderby('idacta_reunion','desc')->first();
      if (!empty($ultimi_id)) {
          return $ultimi_id->toJson();
      }else{

      }

    }
    public function ultimi_id_reu()
    {
      $ultimi_id = Acta_reunion::select('nacata')->where('estado', '1')->where('idproyecto','0')->orderby('idacta_reunion','desc')->first();
      if (!empty($ultimi_id)) {
          return $ultimi_id->toJson();
      }else{

      }

    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }

    public function datos_Doc($id)
    {

        $doc = Acta_reunion::select('*')->where('idacta_reunion','=',$id)->first();
        return $doc->toJson();

    }

    public function firmas(Request $request)
    {
       $objActaInicio=new Acta_inicioController();
       $lista=$objActaInicio->firmas($request->id);

    ?>

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
                        <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>,
                        <?php echo $request->idproyecto;?>);"></a></td>
                    </tr>
                    <?php
                    $i++;
                }
            ?>
            </tbody>
        </table>
    <?php
    }

    public function ExportarWord($id){

        $str_id = explode('_', $id);
        $id = (int)@$str_id[0];
        $id_actareu = (int)@$str_id[1];

        $objProyecto=new ProyectoController();
        //CODE
        $idservicio=$objProyecto->retornarIdServicioProyecto($id);
        $idcliente=$objProyecto->retronaIdClienteProyecto($id);
        $numero=$objProyecto->AbreviaturaDocumento('6').'-'.date("Y").'-1';
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

        $nombre_pro=Proyecto::select('nombre')->where('proyecto.idproyecto','=',$id)->where('proyecto.estado','=','1')->first();


        $objActaInicio=new Acta_inicioController();
        $idacta = $this->idacta($id,$id_actareu);
        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma','firmas.idestadofirma as idestadofirma')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',$id)
        ->where('firmas.iddocumento','=',13)->get();
        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();
        $actaacu=$this->retornarActaReunion($id,$id_actareu);

        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();

$html='
    <title>Acta de Reunión de Inicio y Planificación</title>
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
            <td width="50%" colspan="3" style="border: 1px solid #000;font-size:15.5pt"><center><strong>Acta de Reunión</strong></center></td>
            <td width="20%" colspan="7" valign="top" style="border: 1px solid #000;font-size:10pt"><br><br>Código: SGC-FOR-21 <br> Versión: 01</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">N°</td>
            <td width="50%" colspan="10" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$actaacu->nacata.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">ÁREA/PROYECTO</td>
            <td width="50%" colspan="10" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$nombre_pro->nombre.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">TEMA DE LA REUNIÓN</td>
            <td width="50%" colspan="10" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$actaacu->tema.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">FECHA</td>
            <td width="40%" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">';
                  $date=date_create($actaacu->fecha);
                $freu=$date->format('d-m-Y');
                $html.=$freu;
$html.='</td>
            <td width="10%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">HORA</td>
            <td width="20%" colspan="8" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">';
$horas=substr($actaacu->hora,0,2);
$minutos=substr($actaacu->hora,0-2);
$cosa="";
if((int)$horas>11){
    $horas=$horas-12;
    $cosa=" a.m.";
}else{
    $cosa=" p.m.";
}
$html.=$horas.':'.$minutos.$cosa;
$html.='</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:10pt">ENCARGADO DE ÁREA/PROYECTO</td>
            <td width="50%" colspan="10" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">';
foreach ($gerentesYJefes as $gerentesYJefes) {
    if ($actaacu->idencargado==$gerentesYJefes->idpersona) {
        $html.=$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos;
    }
}
            $html.='</td>
        </tr>';
$html.='<tr>
            <td width="100%" class="negrita" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">PARTICIPANTES :</td>
        </tr>
        <tr>
            <td width="50%" class="negrita" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:10pt">Nombre:</td>
            <td width="50%" class="negrita" colspan="9" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">Cargo:</td>
        </tr>';
               foreach ($listano as $v) {
                        $html.="<tr>";
                        $html.='<td width="50%" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$v->nombres.' '.$v->apellidos.'</td>';
                        $html.='<td width="50%" colspan="9" style="border: 1px solid #000 ; padding-left: 15px;font-size:10pt">'.$v->puesto.'</td>';
                        $html.="</tr>";
                    }
$html.='<tr>
            <td width="30%" class="negrita" class="negrita" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">TEMAS TRATADOS:</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$actaacu->temas.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">ACCIONES:</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">'.$actaacu->acciones.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">FECHA REQUERIDA:</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="11" style="padding: 8px; border: 1px solid #000;font-size:10pt">';
                $datee=date_create($actaacu->fecha_requerida);
                $freuu=$datee->format('d-m-Y');
                $html.= $freuu;
$html.='</td>
        </tr>
    </table>
    <br>';
$html.='<table width="100%">
    <tr>
        <td width="30%" class="negrita" colspan="3" style="padding: 8px; border: 1px solid #000;font-size:10pt">FIRMAS:</td>
    </tr>';

    for ($i=0; $i < count($listano) ; $i=$i+3) {
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

            $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt;text-align:center;">';
            if($listano[$i]["idestadofirma"]==3){
            $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i]["firma"] . '" alt="">';
            }
            $html .= "</td>";

            if (!empty($listano[$i + 1])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt;text-align:center;">';
                if($listano[$i+1]["idestadofirma"]==3){
                $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i + 1]["firma"] . '" alt="">';
              }
                $html .= "</td>";

            }

            if (!empty($listano[$i + 2])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;font-size:10pt;text-align:center;">';
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
        return @$pdf->stream('Acta_reunion_2.pdf');


    }
    public function ExportarWord_Menu($id){

        $objProyecto=new ProyectoController();
        //CODE
        $numero=$objProyecto->AbreviaturaDocumento('6').'-'.date("Y").'-1';
        $gerentesYJefes=$objProyecto->cargarGerentesYJefes();


        $objActaInicio=new Acta_inicioController();
        $idacta = $this->idacta_menu($id);
        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma','firmas.idestadofirma as idestadofirma')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','!=','1')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=','0')
        ->where('firmas.idacta','=',$id)
        ->where('firmas.iddocumento','=',13)->get();
        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();
            $actaacu=$this->retornarActaReunion_menu($id);

        //area
        $objArea=new Area_Controller();
        $areas=$objArea->listarAreas();

$html='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acta de Reunión</title>
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
</head>
<body>';
    $html.='<table width="100%">';
        $html.='<tr>
            <td width="20%" class="negrita" style="padding: 12px; border: 1px solid #000"><img src="/logo.png" border="0" height="70" width="165" align="middle" /></td>
            <td width="60%" colspan="2" style="border: 1px solid #000;font-size:16pt"><strong><center>Acta de Reunión</center></strong></td>
            <td width="20%" colspan="5" valign="top" style="border: 1px solid #000;font-size:10pt">Código: SGC-FOR-21 <br> Versión: 01</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt">N°</td>
            <td width="50%" colspan="7" style="border: 1px solid #000; font-size:11pt ; padding-left: 15px">'.$actaacu->nacata.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt ">ÁREA/PROYECTO</td>
            <td width="50%" colspan="7" style="border: 1px solid #000 ; padding-left: 15px; font-size:11pt">';
foreach ($areas as $row) {
    if ($actaacu->area_proyecto==$row->idarea) {
        $html.=$row->nombre;
    }
}
$html.='</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt ">TEMA DE LA REUNIÓN</td>
            <td width="50%" colspan="7" style="border: 1px solid #000;font-size:11pt ; padding-left: 15px">'.$actaacu->tema.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt">FECHA</td>
            <td width="40%" style="border: 1px solid #000 ; padding-left: 15px;font-size:11pt ">';
                  $date=date_create($actaacu->fecha);
                $freu=$date->format('d-m-Y');
                $html.=$freu;
$html.='</td>
            <td width="10%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt ">HORA</td>
            <td width="20%" colspan="5" style="border: 1px solid #000 ; padding-left: 15px;font-size:11pt ">';
$horas=substr($actaacu->hora,0,2);
$minutos=substr($actaacu->hora,0-2);
$horas=$horas*1;
$cosa="";
if($horas>11){
    $horas=$horas-12;
    $cosa=" p.m.";
}else{
    $cosa=" a.m.";
}
$html.=$horas.':'.$minutos.$cosa;
$html.='</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" style="padding: 8px; border: 1px solid #000;font-size:11pt ">ENCARGADO DE ÁREA/PROYECTO</td>
            <td width="50%" colspan="7" style="border: 1px solid #000 ; padding-left: 15px; font-size:11pt">';
foreach ($gerentesYJefes as $gerentesYJefes) {
    if ($actaacu->idencargado==$gerentesYJefes->idpersona) {
        $html.=$gerentesYJefes->nombre.' '.$gerentesYJefes->trabajador->apellidos;
    }
}
            $html.='</td>
        </tr>';
$html.='<tr>
            <td width="100%" class="negrita" colspan="8" style="padding: 8px; border: 1px solid #000; font-size:11pt">PARTICIPANTES :</td>
        </tr>
        <tr>
            <td width="50%" class="negrita" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:11pt ">Nombre:</td>
            <td width="50%" class="negrita" colspan="6" style="border: 1px solid #000 ; padding-left: 15px;font-size:11pt ">Cargo:</td>
        </tr>';
               foreach ($listano as $v) {
                        $html.="<tr>";
                        $html.='<td width="50%" colspan="2" style="padding: 8px; border: 1px solid #000;font-size:11pt ; font-size:11pt">'.$v->nombres.' '.$v->apellidos.'</td>';
                        $html.='<td width="50%" colspan="6" style="border: 1px solid #000;font-size:11pt ; font-size: 11pt ; padding-left: 15px">'.$v->puesto.'</td>';
                        $html.="</tr>";
                    }
$html.='<tr>
            <td width="30%" class="negrita" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt">TEMAS TRATADOS:</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt ">'.$actaacu->temas.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt">ACCIONES :</td>
        </tr>';
$html.='<tr>
            <td width="30%" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt">'.$actaacu->acciones.'</td>
        </tr>';
$html.='<tr>
            <td width="30%" class="negrita" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt">FECHA REQUERIDA:</td>
        </tr>';
$html.='<tr>
            <td width="100%" colspan="8" style="padding: 8px; border: 1px solid #000;font-size:11pt">';

            if ($actaacu->fecha_requerida != '0000-00-00') {
              $datee=date_create($actaacu->fecha_requerida);
              $freuu=$datee->format('d-m-Y');
              $html.= $freuu;
            }
$html.='</td>
        </tr>
    </table>
    <br>';
$html.='<table width="100%">
    <tr>
        <td width="30%" class="negrita" colspan="3" style="padding: 8px; border: 1px solid #000;font-size:11pt">FIRMAS:</td>
    </tr>';

    for ($i=0; $i < count($listano) ; $i=$i+3) {
        $html .= "<tr>";
        if (!empty($listano[$i])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:11pt">'.$listano[$i]["puesto"].'</td>';
        }
        if (!empty($listano[$i + 1])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:11pt">'.$listano[$i+1]["puesto"].'</td>';
        }
        if (!empty($listano[$i + 2])) {
            $html .= '<td width="30%" class="negrita" align="center" style="padding: 8px; border: 1px solid #000;font-size:11pt">'.$listano[$i+2]["puesto"].'</td>';
        }
        $html .= "</tr>";
        $html .= "<tr>";
        if (!empty($listano[$i])) {

            $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;text-align:center;">';
            if($listano[$i]["idestadofirma"]==3){
            $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i]["firma"] . '" alt="">';
           }
            $html .= "</td>";

            if (!empty($listano[$i + 1])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;text-align:center;">';
                if($listano[$i+1]["idestadofirma"]==3){
                $html .= '<img style="width: 115px; height: 83px;"
             width="115" height="83"  src="documentos/trabajador/' . $listano[$i + 1]["firma"] . '" alt="">';
              }
                $html .= "</td>";

            }

            if (!empty($listano[$i + 2])) {
                $html .= '<td width="30%" style="padding: 8px; border: 1px solid #000;text-align:center;">';
                if($listano[$i+2]["idestadofirma"]==3){
                $html .= '<img style="width: 115px; height: 83px;" width="115" height="83"  src="documentos/trabajador/' . $listano[$i + 2]['firma'] . '" alt="">';
              }
                $html .= "</td>";
            }
            $html .= '</tr>';
        }
    }
$html.='</table>
</body>
</html>';
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','portrait');
        $pdf->loadHTML($html);
        return @$pdf->stream('Acta_reunion_3.pdf');


    }
}
