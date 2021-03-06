<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Centro_costos;
use App\Trabajador;
use App\Proyecto;
use App\notificacion_centro_costos;
use DB;

class ListaProyecto_Controller extends Controller
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

    public function listarproyectos()
    {
        session_start();
        $proyectos=Proyecto::select('idproyecto','fecha','nombre','code')->where('estado','=',1)->orderby('fecha','desc')->get();
        return view('lista_proyectos',['proyectos'=>$proyectos]);
    }

    public function eliminarproyecto($id)
    {
        $actualizar=Proyecto::where('idproyecto','=',$id)->update(['estado'=>0]);
        $proyectos=Proyecto::select('idproyecto','fecha','nombre','code')->where('estado','=',1)->orderby('fecha','desc')->get();

        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Código</th>
                                            <th>Nombre del Proyecto</th>
                                            <th>Fecha</th>
                                            <th>Eliminar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=count($proyectos);?>
                                        <?php foreach ($proyectos as $proy) {  ?>     

                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$proy->code?></td>
                                            <td><?=$proy->nombre?></td>
                                            <?php  
                                            $date=date_create($proy->fecha);
                                            $freu=$date->format('d-m-Y');
                                            ?>
                                            <td><?=$freu?></td>
                                            <td><button class="course-submit" onclick="EliminarProyecto(<?=$proy->idproyecto?>)" type="button">ELIMINAR</button></td>
                                          </tr>
                                          <?php $i--;?>
                                          <?php } ?>

                                        </tbody>
                                      </table>
            <?php
        
    }

}
