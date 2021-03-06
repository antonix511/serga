<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tipo_proyecto;
use DB;

class TipoProyecto_Controller extends Controller
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
      $existe=Tipo_proyecto::select('*')->where('estado','=',1)->where('nombre',$request->nombre)->first();
      if(empty($existe)){
        DB::beginTransaction();
        $TipPro = Tipo_proyecto::create($request->all());
        $TipPro->save();
        DB::commit();
        $tipos=Tipo_proyecto::select('*')->where('estado','=',1)->orderBy('nombre','asc')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaTipPro" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Consultar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                                <?php foreach($tipos as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td><?=$row->abreviatura?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerTipPro(<?=$row->idtipoproyecto?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarTipPro(<?=$row->idtipoproyecto?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            </tbody>
                        </table>


        <?php
      }else{
         $servicios = Servicio::where('essfdfgdfhdfgdfgstado',1)->orderBy('idservicio','desc')->get();
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
        $tipos=Tipo_proyecto::select('*')->where('idtipoproyecto','=',$id)->first();
        return $tipos->toJson();
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

    public function CargarTipos()
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
          if ($row->modulos->ruta=="TipoProyecto") {
            $tipos=Tipo_proyecto::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
            return view('Tipo_Proyecto',['tipos'=>$tipos]);
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
        $actualizar=Tipo_proyecto::where('idtipoproyecto','=',$request->idtipoproyecto)->update(['nombre'=>$request->nombre,'abreviatura'=>$request->abreviatura]);

        $tipos=Tipo_proyecto::select('*')->where('estado','=',1)->orderBy('nombre','asc')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaTipPro" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Consultar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                                <?php foreach($tipos as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td><?=$row->abreviatura?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerTipPro(<?=$row->idtipoproyecto?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarTipPro(<?=$row->idtipoproyecto?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            </tbody>
                        </table>


        <?php


    }
    public function Eliminar($id)
    {
        $actualizar=Tipo_proyecto::where('idtipoproyecto','=',$id)->update(['estado'=>0]);
        $tipos=Tipo_proyecto::select('*')->where('estado','=',1)->orderBy('nombre','asc')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaTipPro" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Consultar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php   $i=1; ?>
                                <?php foreach($tipos as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td><?=$row->abreviatura?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerTipPro(<?=$row->idtipoproyecto?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarTipPro(<?=$row->idtipoproyecto?>)" ></a>
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
