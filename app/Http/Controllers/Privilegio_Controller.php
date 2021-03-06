<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modulo;
use DB;
use App\Privilegio;
use App\Privilegio_modulo;

class Privilegio_Controller extends Controller
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
        $modulos = Privilegio_modulo::with(['Privilegio'])->where('idprivilegio','=',$id)->get();
        //trae datos de la tabla clientes que tengan relacion con la tabla personas cuando el idcliente es igual a  $id;
        return $modulos->toJson();
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
    public function RetornarIdPrivilegio($nombre)
    {
        $privilegio=Privilegio::select('idprivilegio')->where('nombre','=',$nombre)->first();
        return $privilegio->idprivilegio;
    }
    public function eliminar(Request $request)
    {
        $eliminar=Privilegio::where('idprivilegio','=',$request->idprivilegio)->update(['estado'=>0]);
        $privilegios=Privilegio::select('*')->where('estado','=',1)->get();



        ?>
        <table>
            <tr>
                <th>Item</th>
                <th>Nombre</th>
                <th>Consultar</th>
                <th>Eliminar</th>
            </tr>
            <?php $i=1; ?>
            <?php foreach($privilegios as $fila) { ?>
            <tr>
                <td><?=$i?></td>
                <td><?=$fila->nombre?></td>
                <td>
                <div class="opciones"><a class="fa fa-pencil-square-o" onclick="TraerPrivilegio(<?=$fila->idprivilegio?>)" ></a></div>
                </td>
                <td>
                    <div class="opciones"><a class="fa fa-trash" onclick="EliminarPrivilegio(<?=$fila->idprivilegio?>)"></a></div>
                </td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
        </table>

        <?php

    }
    public function actualizar(Request $request)
    {
        $eliminar=Privilegio_modulo::where('idprivilegio','=',$request->idprivilegio)->delete();
        $idprivilegio=$request->idprivilegio;
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

        $privilegios=Privilegio::select('*')->where('estado','=',1)->get();



        ?>
        <table>
            <tr>
                <th>Item</th>
                <th>Nombre</th>
                <th>Consultar</th>
                <th>Eliminar</th>
            </tr>
            <?php $i=1; ?>
            <?php foreach($privilegios as $fila) { ?>
            <tr>
                <td><?=$i?></td>
                <td><?=$fila->nombre?></td>
                <td>
                <div class="opciones"><a class="fa fa-pencil-square-o" onclick="TraerPrivilegio(<?=$fila->idprivilegio?>)" ></a></div>
                </td>
                <td>
                    <div class="opciones"><a class="fa fa-trash" onclick="EliminarPrivilegio(<?=$fila->idprivilegio?>)"></a></div>
                </td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
        </table>

        <?php

    }
    public function guardar(Request $request){
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

        $privilegios=Privilegio::select('*')->where('estado','=',1)->get();



        ?>
        <table>
            <tr>
                <th>Item</th>
                <th>Nombre</th>
                <th>Consultar</th>
                <th>Eliminar</th>
            </tr>
            <?php $i=1; ?>
            <?php foreach($privilegios as $fila) { ?>
            <tr>
                <td><?=$i?></td>
                <td><?=$fila->nombre?></td>
                <td>
                <div class="opciones"><a class="fa fa-pencil-square-o" onclick="TraerPrivilegio(<?=$fila->idprivilegio?>)" ></a></div>
                </td>
                <td>
                    <div class="opciones"><a class="fa fa-trash" onclick="EliminarPrivilegio(<?=$fila->idprivilegio?>)"></a></div>
                </td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
        </table>

        <?php


    }

    public function CargarPrivilegio(){
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="privilegios") {
                $modulos=Modulo::select('*')->where('estado','=',1)->get();
                $privilegios=Privilegio::select('*')->where('estado','=',1)->get();
                return view('privilegio',['modulos'=>$modulos,'privilegios'=>$privilegios]);
            }
        }

         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php
    }

}
