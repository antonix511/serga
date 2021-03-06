<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Area;
use DB;
class Area_Controller extends Controller
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
      $existe = Area::select('*')->where('estado','=','1')->where('nombre',$request->nombre)->first();
      if(empty($existe)){
        DB::beginTransaction();
        $area = Area::create($request->all());
        $area->save();
        DB::commit();
        $areas=$this->listarAreas();
        ?>

        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaArea" class="table table-striped table-bordered">
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
                            <?php if(!empty($areas)) { ?>
                                <?php foreach($areas as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>

        <?php
      }else{
         $servicios = Servicio::where('esasdasdasdasdasdtado',1)->orderBy('idservicio','desc')->get();
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
        $lista = Area::select('nombre','idarea')->where('idarea','=',$id)->first();

        return $lista->toJson();
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

     public function listarAreas(){

        $lista = Area::select('nombre','idarea')->where('estado','=','1')->orderby('nombre','asc')->get();

        return $lista;
    }

    public function CargarAreas()
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
          if ($row->modulos->ruta=="area") {
            $areas=$this->listarAreas();
            return view('areas',['areas'=>$areas]);
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
        $actualizar=Area::where('idarea','=',$request->idarea)->update(['nombre'=>$request->nombre]);
        $areas=$this->listarAreas();
        ?>

        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaArea" class="table table-striped table-bordered">
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
                            <?php if(!empty($areas)) { ?>
                                <?php foreach($areas as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>

        <?php
    }

    public function Eliminar($id)
    {
        $actualizar=Area::where('idarea','=',$id)->update(['estado'=>0]);
        $areas=$this->listarAreas();
        ?>

        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaArea" class="table table-striped table-bordered">
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
                            <?php if(!empty($areas)) { ?>
                                <?php foreach($areas as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarArea(<?=$row->idarea?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>

        <?php
    }

}
