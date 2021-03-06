<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tipo_contrato;
use DB;

class TipoContrato_Controller extends Controller
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
        $existe=Tipo_contrato::select('*')->where('estado','=',1)->where('nombre',$request->nombre)->first();
        if(empty($existe)){
        DB::beginTransaction();
        $TipCon = Tipo_contrato::create($request->all());
        $TipCon->save();
        DB::commit();
        $this->MostrarTabla();
        }else{
            $existe=Tipo_contrato::select('*')->where('estasdado','=',1)->where('nomasdasdbre',$request->nombre)->first();

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
        $tipos=Tipo_contrato::select('*')->where('idtipocontrato','=',$id)->first();
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

    public function CargarContratos()
    {
      session_start();
      $usuario=$_SESSION['usuario'];
      $objComite=new Comite_controller();
      $DataUsuario=$objComite->CargarUsuario($usuario);
      $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="TipoContrato") {
          $tipos=Tipo_contrato::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
          return view('Tipo_Contrato',['tipos'=>$tipos]);
        }
      }
      ?>
      <script type="text/javascript">
      alert("Usted no Tiene permitido el acceso a este modulo");
      window.location.href='/inicio';
      </script>
      <?php
    }

    public function MostrarTabla()
    {
        $tipos=Tipo_contrato::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
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
                                <?php foreach($tipos as $row) { ?>
                                         <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$row->nombre?></td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerTipCon(<?=$row->idtipocontrato?>)" ></a>
                                                    </div>
                                            </td>
                                            <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarTipCon(<?=$row->idtipocontrato?>)" ></a>
                                                    </div>
                                            </td>


                                          </tr>
                                          <?php $i++; ?>
                                <?php } ?>
                            </tbody>
                        </table>


        <?php
    }

    public function Actualizar(Request $request)
    {
        $actualizar=Tipo_contrato::where('idtipocontrato','=',$request->idtipocontrato)->update(['nombre'=>$request->nombre]);
        $this->MostrarTabla();



    }
    public function Eliminar($id)
    {
        $actualizar=Tipo_contrato::where('idtipocontrato','=',$id)->update(['estado'=>0]);
        $this->MostrarTabla();

    }
}
