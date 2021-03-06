<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TrabajadorController;
use App\Firmas;
use App\Trabajador;
use App\Firmas_comite;
use Auth;
use DB;

class FirmaCentroCostos_Controller extends Controller
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

    public function retornarIdTrabajador(){
        session_start();
        $usuario=$_SESSION['usuario'];
        $trabajador=Trabajador::select('idpersona')->where('usuario','=',$usuario)->first();
        return $trabajador->idpersona;
    }

    public function CargarFirmas()
    {
      $usuario=Auth::user()->usuario;
      // dd($usuario);
      $objComite=new Comite_controller();
      $DataUsuario=$objComite->CargarUsuario($usuario);
      $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="firmascentrocostos") {
          $idtrabajador=$this->retornarIdTrabajador();
          // $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->where('idestadofirma','=',2)->where('estado','=',1)->get();
          $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->whereIn('idestadofirma',[2,4])->where('estado','=',1)->get();

          $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area','ac.idacta_reunion as idacta')
          ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
          ->join('area','area.idarea','=','ac.area_proyecto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
          ->where('firmas.idproyecto',0)
          ->where('firmas.idtrabajador','=',$idtrabajador)
          ->whereIn('firmas.idestadofirma',[2,4])
          ->where('firmas.estado','=','1')
          ->where('ac.estado','1')
          ->get();

          $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','comite_gerentes.idcomite as idcomite')
          ->join('comite_gerentes','comite_gerentes.nacta','=','firmas_comite.idcomite')
          ->join('area','area.idarea','=','comite_gerentes.idarea')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idtrabajador','=',$idtrabajador)
          ->whereIn('firmas_comite.idestadofirma',[2,4])
          ->where('firmas_comite.estado','=','1')
          ->get();
          return view('firma_centrocosto',['firmas'=>$firmas,'firmascom'=>$firmascom,'firmasreu'=>$firmasreu]);
        }
      }
      ?>
      <script type="text/javascript">
      alert("Usted no Tiene permitido el acceso a este modulo");
      window.location.href='/inicio';
      </script>
      <?php
    }
    public function AprobarFirma(Request $request)
    {
        $aprobar=Firmas::where('idfirma','=',$request->idfirma)->update(['idestadofirma'=>3]);
         $idtrabajador=$this->retornarIdTrabajador();
         $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->whereIn('idestadofirma',[2,4])->where('estado','=',1)->get();
         // $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idestadofirma','=',2)->where('estado','=',1)->get();

         $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area','ac.idacta_reunion as idacta')
         ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
         ->join('area','area.idarea','=','ac.area_proyecto')
         ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
         ->where('firmas.idproyecto',0)
         ->where('firmas.idtrabajador','=',$idtrabajador)
         ->whereIn('firmas.idestadofirma',[2,4])
         ->where('firmas.estado','=','1')
         ->where('ac.estado','1')
         ->get();
      //   $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area')
      //   // ->join('acta_reunion','acta_reunion.idproyecto','=','firmas.idproyecto')
      // ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
      // ->join('area','area.idarea','=','ac.area_proyecto')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
      // ->where('firmas.idproyecto',0)
      // ->where('firmas.idtrabajador','=',$idtrabajador)
      // ->where('firmas.idestadofirma','=','2')
      // ->where('firmas.estado','=','1')
      // ->where('ac.estado', '=', 1)
      // ->get();

      $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','comite_gerentes.idcomite as idcomite')
      ->join('comite_gerentes','comite_gerentes.nacta','=','firmas_comite.idcomite')
      ->join('area','area.idarea','=','comite_gerentes.idarea')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      ->whereIn('firmas_comite.idestadofirma',[2,4])
      ->where('firmas_comite.estado','=','1')
      ->get();
      //
      // $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area')
      // ->join('comite_gerentes','comite_gerentes.idcomite','=','firmas_comite.idcomite')
      // ->join('area','area.idarea','=','comite_gerentes.idarea')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      // ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      // ->where('firmas_comite.idestadofirma','=','2')
      // ->where('firmas_comite.estado','=','1')
      // ->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Proyecto</th>
                                            <th>Documento</th>
                                            <th>Aprobar</th>
                                            <th>Desaprobar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            <?php if (!empty($firmas)) { ?>
                                            <?php foreach($firmas as $fila){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=isset($fila->proyecto_firma->nombre) ? $fila->proyecto_firma->nombre : '' ?></td>
                                            <td>
                                              <div class="row">
                                                <div class="col-md-7">
                                                  <?=$fila->documento_firma->nombre?>
                                                </div>
                                                <div class="col-md-5">
                                                  <?php if ( $fila->idproyecto > 0 ) {?>
                                                    <a href="/firmas_actainicio/<?=$fila->idproyecto?>">
                                                      <button type="button" class="btn">
                                                        Ver
                                                      </button>
                                                    </a>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </td>
                                            <td>
                                              <?php if ( $fila->idestadofirma == 2) {?>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma(<?=$fila->idfirma?>)">
                                                Aprobar
                                                </button>
                                              <?php } ?>
                                            </td>
                                            <td>
                                              <?php if ( $fila->idestadofirma == 2) {?>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma(<?=$fila->idfirma?>)">
                                                Desaprobar
                                                </button>
                                              <?php } ?>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>


                                          <?php if(!empty($firmasreu)){ ?>
                                            <?php foreach($firmasreu as $filar){ ?>
                                            <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filar->area?></td>
                                            <td>Acta Reunion
                                              <a href="/firmas_actareunion/<?=$filar->idacta?>"><button type="button" class="btn">Ver
                        												</button></a>
                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="AprobarFirma(<?=$filar->idfirma?>)">
                                              Aprobar
                                              </button>

                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="DesaprobarFirma(<?=$filar->idfirma?>)">
                                              Desaprobar
                                              </button>
                                            </td>


                                            </tr>
                                            <?php $i++;?>
                                            <?php } ?>
                                          <?php } ?>


                                          <?php if (!empty($firmascom)) { ?>
                                            <?php foreach($firmascom as $filac){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filac->area?></td>
                                            <td>
                                              Acta Comite Gerentes
                                              <a href="/firmas_actacomite/<?=$filac->idcomite?>"><button type="button" class="btn">Ver</button></a>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>


                                        </tbody>
                                      </table>

        <?php

    }
        public function AprobarFirma_Comite(Request $request)
    {
        $aprobar=Firmas_comite::where('idfirma','=',$request->idfirma)->update(['idestadofirma'=>3]);
         $idtrabajador=$this->retornarIdTrabajador();

        $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->whereIn('idestadofirma',[2,4])->where('estado','=',1)->get();
        // $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idestadofirma','=',2)->where('estado','=',1)->get();

        $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area','ac.idacta_reunion as idacta')
        ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
        ->join('area','area.idarea','=','ac.area_proyecto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idproyecto',0)
        ->where('firmas.idtrabajador','=',$idtrabajador)
        ->whereIn('firmas.idestadofirma',[2,4])
        ->where('firmas.estado','=','1')
        ->where('ac.estado','1')
        ->get();

      //    $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area')
      // ->join('acta_reunion','acta_reunion.idproyecto','=','firmas.idproyecto')
      // ->join('area','area.idarea','=','acta_reunion.area_proyecto')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
      // ->where('firmas.idproyecto',0)
      // ->where('firmas.idtrabajador','=',$idtrabajador)
      // ->where('firmas.idestadofirma','=','2')
      // ->where('firmas.estado','=','1')
      // ->get();

      $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','comite_gerentes.idcomite as idcomite')
      ->join('comite_gerentes','comite_gerentes.nacta','=','firmas_comite.idcomite')
      ->join('area','area.idarea','=','comite_gerentes.idarea')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      ->whereIn('firmas_comite.idestadofirma',[2,4])
      ->where('firmas_comite.estado','=','1')
      ->get();

      // $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area')
      // ->join('comite_gerentes','comite_gerentes.idcomite','=','firmas_comite.idcomite')
      // ->join('area','area.idarea','=','comite_gerentes.idarea')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      // ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      // ->where('firmas_comite.idestadofirma','=','2')
      // ->where('firmas_comite.estado','=','1')
      // ->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Proyecto</th>
                                            <th>Documento</th>
                                            <th>Aprobar</th>
                                            <th>Desaprobar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            <?php if (!empty($firmas)) { ?>
                                            <?php foreach($firmas as $fila){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td>
                                              <div class="row">
                                                <div class="col-md-7">
                                                  <?=$fila->documento_firma->nombre?>
                                                </div>
                                                <div class="col-md-5">
                                                  <?php if ( $fila->idproyecto > 0 ) {?>
                                                    <a href="/firmas_actainicio/<?=$fila->idproyecto?>">
                                                      <button type="button" class="btn">
                                                        Ver
                                                      </button>
                                                    </a>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma(<?=$fila->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma(<?=$fila->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>


                                          <?php if(!empty($firmasreu)){ ?>
                                            <?php foreach($firmasreu as $filar){ ?>
                                            <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filar->area?></td>
                                            <td>Acta Reunion
                                              <a href="/firmas_actareunion/<?=$filar->idacta?>"><button type="button" class="btn">Ver</button></a>
                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="AprobarFirma(<?=$filar->idfirma?>)">
                                              Aprobar
                                              </button>

                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="DesaprobarFirma(<?=$filar->idfirma?>)">
                                              Desaprobar
                                              </button>
                                            </td>


                                            </tr>
                                            <?php $i++;?>
                                            <?php } ?>
                                          <?php } ?>



                                          <?php if (!empty($firmascom)) { ?>
                                            <?php foreach($firmascom as $filac){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filac->area?></td>
                                            <td>
                                              Acta Comite Gerentes
                                              <a href="/firmas_actacomite/<?=$filac->idcomite?>"><button type="button" class="btn">Ver</button></a>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>


                                        </tbody>
                                      </table>

        <?php

    }

    public function DesaprobarFirma(Request $request)
    {
        $desaprobar=Firmas::where('idfirma','=',$request->idfirma)->update(['idestadofirma'=>4]);
         $idtrabajador=$this->retornarIdTrabajador();
         $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->whereIn('idestadofirma',[2,4])->where('estado','=',1)->get();
        // $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idestadofirma','=',2)->where('estado','=',1)->get();

        $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area','ac.idacta_reunion as idacta')
        ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
        ->join('area','area.idarea','=','ac.area_proyecto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idproyecto',0)
        ->where('firmas.idtrabajador','=',$idtrabajador)
        ->whereIn('firmas.idestadofirma',[2,4])
        ->where('firmas.estado','=','1')
        ->where('ac.estado','1')
        ->get();

      //    $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area')
      // ->join('acta_reunion','acta_reunion.idproyecto','=','firmas.idproyecto')
      // ->join('area','area.idarea','=','acta_reunion.area_proyecto')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
      // ->where('firmas.idproyecto',0)
      // ->where('firmas.idtrabajador','=',$idtrabajador)
      // ->where('firmas.idestadofirma','=','2')
      // ->where('firmas.estado','=','1')
      // ->get();

      $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','comite_gerentes.idcomite as idcomite')
      ->join('comite_gerentes','comite_gerentes.nacta','=','firmas_comite.idcomite')
      ->join('area','area.idarea','=','comite_gerentes.idarea')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      ->whereIn('firmas_comite.idestadofirma',[2,4])
      ->where('firmas_comite.estado','=','1')
      ->get();
      //
      // $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area')
      // ->join('comite_gerentes','comite_gerentes.idcomite','=','firmas_comite.idcomite')
      // ->join('area','area.idarea','=','comite_gerentes.idarea')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      // ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      // ->where('firmas_comite.idestadofirma','=','2')
      // ->where('firmas_comite.estado','=','1')
      // ->get();
         ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Proyecto</th>
                                            <th>Documento</th>
                                            <th>Aprobar</th>
                                            <th>Desaprobar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            <?php if (!empty($firmas)) { ?>
                                            <?php foreach($firmas as $fila){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=isset($fila->proyecto_firma->nombre) ? $fila->proyecto_firma->nombre : '' ?></td>
                                            <td>
                                              <div class="row">
                                                <div class="col-md-7">
                                                  <?=$fila->documento_firma->nombre?>
                                                </div>
                                                <div class="col-md-5">
                                                  <?php if ( $fila->idproyecto > 0 ) {?>
                                                    <a href="/firmas_actainicio/<?=$fila->idproyecto?>">
                                                      <button type="button" class="btn">
                                                        Ver
                                                      </button>
                                                    </a>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </td>
                                            <td>
                                              <?php if ( in_array($fila->idestadofirma, array(2,4))) {?>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma(<?=$fila->idfirma?>)">
                                                Aprobar
                                                </button>
                                              <?php } ?>
                                            </td>
                                            <td>
                                              <?php if ( in_array($fila->idestadofirma, array(2,4))) {?>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma(<?=$fila->idfirma?>)">
                                                Desaprobar
                                                </button>
                                              <?php } ?>
                                            </td>
                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>

                                          <?php if(!empty($firmasreu)){ ?>
                                            <?php foreach($firmasreu as $filar){ ?>
                                            <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filar->area?></td>
                                            <td>Acta Reunion
                                              <a href="/firmas_actareunion/<?=$filar->idacta?>"><button type="button" class="btn">Ver</button></a>
                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="AprobarFirma(<?=$filar->idfirma?>)">
                                              Aprobar
                                              </button>

                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="DesaprobarFirma(<?=$filar->idfirma?>)">
                                              Desaprobar
                                              </button>
                                            </td>


                                            </tr>
                                            <?php $i++;?>
                                            <?php } ?>
                                          <?php } ?>



                                          <?php if (!empty($firmascom)) { ?>
                                            <?php foreach($firmascom as $filac){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filac->area?></td>
                                            <td>Acta Comite Gerentes
                                              <a href="/firmas_actacomite/<?=$filac->idcomite?>"><button type="button" class="btn">Ver
                        												</button></a>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>
                                        </tbody>
                                      </table>

        <?php




    }






    public function DesaprobarFirma_Comite(Request $request)
    {
        $desaprobar=Firmas_comite::where('idfirma','=',$request->idfirma)->update(['idestadofirma'=>4]);
         $idtrabajador=$this->retornarIdTrabajador();

         $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idproyecto','!=',0)->whereIn('idestadofirma',[2,4])->where('estado','=',1)->get();
        // $firmas=Firmas::with(['proyecto_firma','trabajador_firma','documento_firma','estado_firma_firma'])->where('idtrabajador','=',$idtrabajador)->where('idestadofirma','=',2)->where('estado','=',1)->get();

        $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area','ac.idacta_reunion as idacta')
        ->join('acta_reunion as ac','ac.idacta_reunion','=','firmas.idacta')
        ->join('area','area.idarea','=','ac.area_proyecto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idproyecto',0)
        ->where('firmas.idtrabajador','=',$idtrabajador)
        ->whereIn('firmas.idestadofirma',[2,4])
        ->where('firmas.estado','=','1')
        ->where('ac.estado','1')
        ->get();
      $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','comite_gerentes.idcomite as idcomite')
      ->join('comite_gerentes','comite_gerentes.nacta','=','firmas_comite.idcomite')
      ->join('area','area.idarea','=','comite_gerentes.idarea')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      ->whereIn('firmas_comite.idestadofirma',[2,4])
      ->where('firmas_comite.estado','=','1')
      ->get();
      //
      //   $firmasreu=Firmas::select('firmas.idfirma as idfirma','area.nombre as area')
      // ->join('acta_reunion','acta_reunion.idproyecto','=','firmas.idproyecto')
      // ->join('area','area.idarea','=','acta_reunion.area_proyecto')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
      // ->where('firmas.idproyecto',0)
      // ->where('firmas.idtrabajador','=',$idtrabajador)
      // ->where('firmas.idestadofirma','=','2')
      // ->where('firmas.estado','=','1')
      // ->get();
      //
      // $firmascom=Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area')
      // ->join('comite_gerentes','comite_gerentes.idcomite','=','firmas_comite.idcomite')
      // ->join('area','area.idarea','=','comite_gerentes.idarea')
      // ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      // ->where('firmas_comite.idtrabajador','=',$idtrabajador)
      // ->where('firmas_comite.idestadofirma','=','2')
      // ->where('firmas_comite.estado','=','1')
      // ->get();
         ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Proyecto</th>
                                            <th>Documento</th>
                                            <th>Aprobar</th>
                                            <th>Desaprobar</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;?>
                                            <?php if (!empty($firmas)) { ?>
                                            <?php foreach($firmas as $fila){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$fila->proyecto_firma->nombre?></td>
                                            <td>
                                              <div class="row">
                                                <div class="col-md-7">
                                                  <?=$fila->documento_firma->nombre?>
                                                </div>
                                                <div class="col-md-5">
                                                  <?php if ( $fila->idproyecto > 0 ) {?>
                                                    <a href="/firmas_actainicio/<?=$fila->idproyecto?>">
                                                      <button type="button" class="btn">
                                                        Ver
                                                      </button>
                                                    </a>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma(<?=$fila->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma(<?=$fila->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>

                                          <?php if(!empty($firmasreu)){ ?>
                                            <?php foreach($firmasreu as $filar){ ?>
                                            <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filar->area?></td>
                                            <td>Acta Reunion
                                              <a href="/firmas_actareunion/<?=$filar->idacta?>"><button type="button" class="btn">Ver
                        												</button></a>
                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="AprobarFirma(<?=$filar->idfirma?>)">
                                              Aprobar
                                              </button>

                                            </td>
                                            <td>
                                              <button id="btncronograma" type="button" class="btn btn-default"
                                              onclick="DesaprobarFirma(<?=$filar->idfirma?>)">
                                              Desaprobar
                                              </button>
                                            </td>


                                            </tr>
                                            <?php $i++;?>
                                            <?php } ?>
                                          <?php } ?>



                                          <?php if (!empty($firmascom)) { ?>
                                            <?php foreach($firmascom as $filac){ ?>
                                          <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?=$filac->area?></td>
                                            <td>Acta Comite Gerentes
                                              <a href="/firmas_actacomite/<?=$filac->idcomite?>"><button type="button" class="btn">Ver
                        												</button></a>
                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="AprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Aprobar
                                                </button>

                                            </td>
                                            <td>
                                                <button id="btncronograma" type="button" class="btn btn-default"
                                                onclick="DesaprobarFirma_comite(<?=$filac->idfirma?>)">
                                                Desaprobar
                                                </button>
                                            </td>

                                          </tr>
                                          <?php $i++;?>
                                          <?php } ?>
                                          <?php } ?>
                                        </tbody>
                                      </table>

        <?php




    }


    }
