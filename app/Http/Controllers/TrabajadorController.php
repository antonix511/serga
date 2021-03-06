<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

use DB;
use Crypt;
use App\Area;
use App\Puesto;
use App\Persona;
use App\Privilegio;
use App\Trabajador;
use App\Modulo;
use App\Privilegio_modulo;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //$trabajadores = Trabajador::all();
        //return $trabajadores->toJson();
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

      DB::beginTransaction();
        $privilegio = Privilegio::create($request->all());;
        $privilegio->save();
        DB::commit();
        $idprivilegio=$this->RetornarIdPrivilegio($request->nombre);
        if(!empty($request->p1)){
            DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 1]);
        }
        if(!empty($request->p2)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 2]);
        }
        if(!empty($request->p3)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 3]);
        }
        if(!empty($request->p4)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 4]);
        }
        if(!empty($request->p5)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 5]);
        }
        if(!empty($request->p6)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 6]);
        }
        if(!empty($request->p7)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 7]);
        }
        if(!empty($request->p8)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 8]);
        }
        if(!empty($request->p9)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 9]);
        }
        if(!empty($request->p10)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 10]);
        }
        if(!empty($request->p11)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 11]);
        }
        if(!empty($request->p12)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 12]);
        }
        if(!empty($request->p13)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 13]);
        }
        if(!empty($request->p14)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 14]);
        }
        if(!empty($request->p15)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 15]);
        }
        if(!empty($request->p16)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 16]);
        }
        if(!empty($request->p17)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 17]);
        }
        if(!empty($request->p18)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 18]);
        }
        if(!empty($request->p19)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 19]);
        }
        if(!empty($request->p20)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 20]);
        }
        if(!empty($request->p21)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 21]);
        }
        if(!empty($request->p22)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 22]);
        }
        if(!empty($request->p23)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 23]);
        }
        if(!empty($request->p24)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 24]);
        }
        if(!empty($request->p25)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 25]);
        }
        if(!empty($request->p26)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 26]);
        }
        if(!empty($request->p27)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 27]);
        }
        if(!empty($request->p28)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 28]);
        }
        if(!empty($request->p29)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 29]);
        }
        if(!empty($request->p30)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 30]);
        }
        if(!empty($request->p31)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 31]);
        }
        if(!empty($request->p32)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 32]);
        }
        if(!empty($request->p33)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 33]);
        }
        if(!empty($request->p34)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 34]);
        }
        if(!empty($request->p35)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 35]);
        }

        DB::beginTransaction();
        $persona = Persona::create($request->all());
        $trabajador= new Trabajador($request->all());
        // dd($request->);
        $nombre_doc =  $_FILES['foto']['name'];
        $temporal_doc = $_FILES['foto']['tmp_name'];
        if(!empty($nombre_doc)){
        $ruta = $request->dni."_".$nombre_doc;
        copy($temporal_doc, "documentos/trabajador/".$ruta);
        }else{
          $ruta="";
        }

        $nombre_doc2 =  $_FILES['firma']['name'];
        $temporal_doc2 = $_FILES['firma']['tmp_name'];


        if(!empty($nombre_doc2)){
        $ruta2 = "2"."_".$request->dni."_".$nombre_doc;
        copy($temporal_doc2, "documentos/trabajador/".$ruta2);
        }else{
          $ruta2="";
        }

        $trabajador->clave =$request->clave;
        $trabajador->foto = $ruta;
        $trabajador->firma = $ruta2;
        $persona->trabajador()->save($trabajador);



        DB::commit();


        $trabajadores = Trabajador::where('persona.estado',1)->join('persona','persona.idpersona','=','trabajador.idpersona')->orderBy('persona.nombre','asc')->get();
        ?>
        <script type="text/javascript" src="{{asset('/js/sc.js')}}"></script>
        <table id="tabletrabajadores" class="table table-striped table-bordered">
        <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Area</th>
                                    <th>Puesto</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                            <?php foreach ($trabajadores as $trabajador){ ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$trabajador->persona->nombre?></td>
                                    <td><?=$trabajador->apellidos?></td>
                                    <td><?=$trabajador->persona->correo?></td>
                                    <td><?=$trabajador->persona->telefono?></td>
                                    <td><?=$trabajador->area->nombre?></td>
                                    <td><?=$trabajador->puesto->nombre?></td>
                                    <td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_trabajador('<?=$trabajador->idtrabajador?>')" ></a></div>
                                    <div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_trabajador('<?=$trabajador->idtrabajador?>')"></a></div>
                                </td>
                            </tr>
                            <?php   $i++; ?>
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
      $cliente = Trabajador::with(['persona'])->with(['area'])->with(['puesto'])->with(['privilegio'])->find($id);
      //trae datos de la tabla clientes que tengan relacion con la tabla personas cuando el idcliente es igual a  $id;
      //
      // $decrypted = Crypt::decrypt($cliente->clave);
      //   dd($decrypted);
      return json_encode($cliente);
      //retorna los daton en toJson para que sea interpretado por .js;
    }

     public function RetornarIdPrivilegio($nombre)
    {
        $privilegio=Privilegio::select('idprivilegio')->where('nombre','=',$nombre)->first();
        return $privilegio->idprivilegio;
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

    public function CargarCombos () {

        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="trabajadores") {
                $area = Area::select('*')->where('estado',1)->get();
                $puesto = Puesto::all();
                $privilegio = Privilegio::select('*')->where('estado','=','1')->get();
                $trabajadores = Trabajador::where('persona.estado',1)->where('trabajador.estado',1)->with(['persona'])->with(['puesto'])->with(['area'])->join('persona','persona.idpersona','=','trabajador.idpersona')->orderBy('persona.nombre','asc')->get();
              //  dd($trabajadores);
                $modulos=Modulo::select('*')->where('estado','=',1)->get();
                $idprivilegio=DB::table('privilegio')->count();
                $idprivilegio=$idprivilegio+1;
                return view('trabajadores', ['areas' => $area, 'puestos'=>$puesto, 'privilegios'=>$privilegio,'trabajadores'=>$trabajadores,'modulos'=>$modulos,'idprivilegio'=>$idprivilegio]);
            }
        }

         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php
    }



    public function retornaCorreo($idtrabajador){
        $correor = Persona::select('correo')->where('estado','=','1')->where('idpersona','=',$idtrabajador)->take(1)->get();
        if(count($correor)==0){
        $correo='';
        }else{
        $correo=$correor[0]->correo;
        }
        return $correo;
    }

    public function retornaCelular($idtrabajador){
        $telefonor = Persona::select('telefono')->where('estado','=','1')->where('idpersona','=',$idtrabajador)->take(1)->get();
        if(count($telefonor)==0){
        $telefono='';
        }else{
        $telefono=$telefonor[0]->telefono;
        }
        return $telefono;
    }

    public function retornarPuestoTrabajador($idtrabajador){

        $trabajador = Trabajador::has('puesto')->whereHas('puesto', function ($q) {
        $q->where('estado', '=', '1');})->where('estado','=','1')->where('idpersona','=',$idtrabajador)->get();
        return $trabajador[0]->puesto->nombre;
    }

    public function deletetrabajador($id)
    {
      // dd($request->all());
        $persona = persona::where('idpersona',$id)->update(['estado'=>'0']);
        $trabajador = Trabajador::where('idtrabajador', $id)->update(['estado'=>'0']);
        $trabajadores = Trabajador::where('persona.estado',1)->where('trabajador.estado',1)->join('persona','persona.idpersona','=','trabajador.idpersona')->orderBy('persona.nombre','asc')->get();
        ?>
        <script type="text/javascript" src="{{asset('/js/sc.js')}}"></script>
        <table id="tabletrabajadores" class="table table-striped table-bordered">
        <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Area</th>
                                    <th>Puesto</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                            <?php foreach ($trabajadores as $trabajador){ ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$trabajador->persona->nombre?></td>
                                    <td><?=$trabajador->apellidos?></td>
                                    <td><?=$trabajador->persona->correo?></td>
                                    <td><?=$trabajador->persona->telefono?></td>
                                    <td><?=$trabajador->area->nombre?></td>
                                    <td><?=$trabajador->puesto->nombre?></td>
                                    <td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_trabajador('<?=$trabajador->idtrabajador?>')" ></a></div>
                                    <div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_trabajador('<?=$trabajador->idtrabajador?>')"></a></div>
                                </td>
                            </tr>
                            <?php   $i++; ?>
                            <?php } ?>
                            </tbody>
                            </table>
                            <?php
    }

    public function updatetrabajador(Request $request, $id)
    {
        $trabajador_pri=Trabajador::select('*')->where('idpersona',$id)->first();
        $eliminar=Privilegio_modulo::where('idprivilegio','=',$trabajador_pri->idprivilegio)->delete();
        $idprivilegio=$trabajador_pri->idprivilegio;
        if(!empty($request->p1)){
            DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 1]);
        }
        if(!empty($request->p2)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 2]);
        }
        if(!empty($request->p3)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 3]);
        }
        if(!empty($request->p4)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 4]);
        }
        if(!empty($request->p5)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 5]);
        }
        if(!empty($request->p6)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 6]);
        }
        if(!empty($request->p7)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 7]);
        }
        if(!empty($request->p8)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 8]);
        }
        if(!empty($request->p9)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 9]);
        }
        if(!empty($request->p10)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 10]);
        }
        if(!empty($request->p11)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 11]);
        }
        if(!empty($request->p12)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 12]);
        }
        if(!empty($request->p13)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 13]);
        }
        if(!empty($request->p14)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 14]);
        }
        if(!empty($request->p15)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 15]);
        }
        if(!empty($request->p16)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 16]);
        }
        if(!empty($request->p17)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 17]);
        }
        if(!empty($request->p18)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 18]);
        }
        if(!empty($request->p19)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 19]);
        }
        if(!empty($request->p20)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 20]);
        }
        if(!empty($request->p21)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 21]);
        }
        if(!empty($request->p22)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 22]);
        }
        if(!empty($request->p23)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 23]);
        }
        if(!empty($request->p24)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 24]);
        }
        if(!empty($request->p25)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 25]);
        }
        if(!empty($request->p26)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 26]);
        }
        if(!empty($request->p27)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 27]);
        }
        if(!empty($request->p28)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 28]);
        }
        if(!empty($request->p29)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 29]);
        }
        if(!empty($request->p30)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 30]);
        }
        if(!empty($request->p31)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 31]);
        }
        if(!empty($request->p32)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 32]);
        }
        if(!empty($request->p33)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 33]);
        }
        if(!empty($request->p34)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 34]);
        }
        if(!empty($request->p35)){
             DB::table('privilegio_modulo')->insert(['idprivilegio' => $idprivilegio, 'idmodulo' => 35]);
        }


      // dd($request->all());

        $nombre_doc =  $_FILES['foto']['name'];
        $temporal_doc = $_FILES['foto']['tmp_name'];
        if(!empty($nombre_doc)){
        $ruta = $request->dni."_".$nombre_doc;
        copy($temporal_doc, "documentos/trabajador/".$ruta);
        }else{
          $ruta="";
        }

        $nombre_doc2 =  $_FILES['firma']['name'];
        $temporal_doc2 = $_FILES['firma']['tmp_name'];


        if(!empty($nombre_doc2)){
        $ruta2 = "2"."_".$request->dni."_".$nombre_doc2;
        copy($temporal_doc2, "documentos/trabajador/".$ruta2);
        }else{
          $ruta2="";
        }

        $persona = persona::where('idpersona',$id)->update(['nombre'=>$request->nombre,'correo'=>$request->correo,'telefono'=>$request->telefono,'direccion'=>$request->direccion]);
        if(!empty($nombre_doc) && !empty($nombre_doc2)){
        $trabajador = Trabajador::where('idpersona', $id)->update(['apellidos'=>$request->apellidos,'idarea'=>$request->idarea,'idpuesto'=>$request->idpuesto,'usuario'=>$request->usuario,'clave'=>$request->clave,'foto'=>$ruta,'firma'=>$ruta2]);
        }elseif (!empty($nombre_doc)) {
            $trabajador = Trabajador::where('idpersona', $id)->update(['apellidos'=>$request->apellidos,'idarea'=>$request->idarea,'idpuesto'=>$request->idpuesto,'usuario'=>$request->usuario,'clave'=>$request->clave,'foto'=>$ruta]);
        }elseif(!empty($nombre_doc2)){
            $trabajador = Trabajador::where('idpersona', $id)->update(['apellidos'=>$request->apellidos,'idarea'=>$request->idarea,'idpuesto'=>$request->idpuesto,'usuario'=>$request->usuario,'clave'=>$request->clave,'firma'=>$ruta2]);
        }elseif(empty($nombre_doc) && empty($nombre_doc2)){
            $trabajador = Trabajador::where('idpersona', $id)->update(['apellidos'=>$request->apellidos,'idarea'=>$request->idarea,'idpuesto'=>$request->idpuesto,'usuario'=>$request->usuario,'clave'=>$request->clave]);
        }
        $trabajadores = Trabajador::where('persona.estado',1)->where('trabajador.estado',1)->join('persona','persona.idpersona','=','trabajador.idpersona')->orderBy('persona.nombre','asc')->get();
         ?>
        <script type="text/javascript" src="{{asset('/js/sc.js')}}"></script>
        <table id="tabletrabajadores" class="table table-striped table-bordered">
                          <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Area</th>
                                    <th>Puesto</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                            <?php foreach ($trabajadores as $trabajador){ ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$trabajador->persona->nombre?></td>
                                    <td><?=$trabajador->apellidos?></td>
                                    <td><?=$trabajador->persona->correo?></td>
                                    <td><?=$trabajador->persona->telefono?></td>
                                    <td><?=$trabajador->area->nombre?></td>
                                    <td><?=$trabajador->puesto->nombre?></td>
                                    <td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_trabajador('<?=$trabajador->idtrabajador?>')" ></a></div>
                                    <div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_trabajador('<?=$trabajador->idtrabajador?>')"></a></div>
                                </td>
                            </tr>
                            <?php   $i++; ?>
                            <?php } ?>
                            </tbody>
                            </table>
                            <?php
    }

}
