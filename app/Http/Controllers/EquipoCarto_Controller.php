<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Equipo_cartografia;
use DB;

class EquipoCarto_Controller extends Controller
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
        $existe=Equipo_cartografia::select('*')->where('estado','=',1)->where('nombre',$request->nombre)->first();
        if(empty($existe)){
        DB::beginTransaction();
        $equip = Equipo_cartografia::create($request->all());
        $equip->save();
        DB::commit();
        $this->MostrarTabla();
        }else{
            Equipo_cartografia::select('*')->where('estaasdasddo','=',1)->where('nomasdasdbre',$request->nombre)->first();
        }
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
        $equipo=Equipo_cartografia::select('*')->where('idequipo','=',$id)->first();
        return $equipo->toJson();
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

    public function CargarEquipos()
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
          if ($row->modulos->ruta=="EquipCartografia") {
            $equipos=Equipo_cartografia::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
            return view('Equipos_cartografia',['equipos'=>$equipos]);
          }
        }
        ?>
        <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
        </script>
        <?php
    }

    public function Actualizar(Request $request)
    {
        $actualizar=Equipo_cartografia::where('idequipo','=',$request->idequipo)->update(['nombre'=>$request->nombre]);
        $this->MostrarTabla();



    }
    public function Eliminar($id)
    {
        $actualizar=Equipo_cartografia::where('idequipo','=',$id)->update(['estado'=>0]);
        $this->MostrarTabla();

    }

    public function MostrarTabla()
    {
        $equipos=Equipo_cartografia::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaTipPro" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Consultar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                                <?php foreach($equipos as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerEquip(<?=$row->idequipo?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarEquip(<?=$row->idequipo?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            </tbody>
                        </table>


        <?php
    }


}
