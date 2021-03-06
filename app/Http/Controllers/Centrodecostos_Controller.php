<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TrabajadorController;
use App\Centro_costos;
use App\Trabajador;
use App\Proyecto;
use App\notificacion_centro_costos;

use App\Versati;

use DB;

class Centrodecostos_Controller extends Controller
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

     public function retronarCentrodeCostos1($idproyecto){

        $centro = Proyecto::select('centrodecosto','observacion','nombreclave')->where('idproyecto','=',$idproyecto)->where('estado','=','1')->first();

        return $centro;
    }
    public function actualizarCentroCosto($idproyecto,$centrodecosto,$observacion){
        DB::beginTransaction();
        $centro = Proyecto::where('idproyecto',$idproyecto)->update(['centrodecosto'=>$centrodecosto,'observacion'=>$observacion]);
        DB::commit();
    }
    public function MostrarNotificados($idproyecto){
        DB::beginTransaction();
        $centro = notificacion_centro_costos::with(['trabajador','persona'])->where('idproyecto',$idproyecto)->where('estado',1)->get();
        DB::commit();
        return $centro;
    }
    public function retronarCentrodeCostos2($idproyecto){

        $trabajador = Centro_costos::select('numero','observaciones')->where('idproyecto','=',$idproyecto)->where('estado','=','1')->get();
        if(count($trabajador)==0){
            $t='';

        }else{
            $t=$trabajador[0]->observaciones;
        }
        return $t;
    }
    function NotificarPersonas(Request $request)
    {
        session_start();
        $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
        $notificados=$this->MostrarNotificados($request->idproyecto);
        $proyecto=Proyecto::select('nombre','centrodecosto')->where('idproyecto',$request->idproyecto)->first();
        $namepro=$proyecto->nombre;
        $centrocosto=$proyecto->centrodecosto;
        foreach ($notificados as $row) {
                $nombres= $row->persona->nombre;
                $apellidos= $row->trabajador->apellidos;
                $para= $row->persona->correo;
                $telefono= @$row->persona->telefono;
                $proyecto= $namepro;
                $titulo="CC_".$centrocosto."_".$namepro;



                if (!empty($telefono)) {
                    Versati::_send_sms($telefono, 'SERGA: '.$titulo);
                }


                $mensaje = '
                <html>
                <head>
                <meta charset="utf-8">
                <title>Centro de Costos</title>
                </head>
                <body>
                <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
                <p>Estimado(a) :</p>
                <p>Por el presente se comunica el N° de Centro de Costos del Proyecto '.$proyecto.'</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CENTRO DE COSTOS:'.$centrocosto.'</p>
                <p>Tener en cuenta el Nombre clave y Código de centro de costos para la presentación de todos los formatos inherentes a la gestión administrativa que se especifican a continuación: </p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAD-FOR-06. Solicitud de fondos de Caja Chica.</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAD FOR-07. Reporte de Caja Chica</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAD-FOR-08. Declaración Jurada</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAD-FOR-09. Conciliación de saldos de Caja Chica</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAD-FOR-10. Recibo de Movilidad</p>
                <p></p>
                <p>Asimismo, considerar  los formatos inherentes a la Gestión Logística.</p>
                <p>Atentamente.</p>
                <p><strong>'.$trabajador->persona->nombre.' '.$trabajador->apellidos.'</strong></p>
                <p>'.$trabajador->puesto->nombre.'</p>
                <p>Ca. Las Begonias 2695, Urb. San Eugenio, Lince</p>
                <p>T:'.$trabajador->persona->telefono.'</p>
                <p>email: <a href="mailto:'.$trabajador->persona->correo.'">'.$trabajador->persona->correo.'</a></p>
                <p>Web Site: <a href="http://www.jp-planning.com">www.jp-planning.com</a></p>
                <p>Web Site Serga: <a href="http://serga.jp-planning.com">serga.jp-planning.com</a></p>
                </body>
                </html>
                ';

                // Para enviar un correo HTML, debe establecerse la cabecera Content-type
                $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                // Cabeceras adicionales
                $cabeceras .= 'To:' . "\r\n";
                $cabeceras .= 'From: SERGA<serga@jp-planning.com>' . "\r\n";
                /*$cabeceras .= 'Cc: izamorar1394@gmail.com' . "\r\n";
                $cabeceras .= 'Bcc: izamorar1394@gmail.com' . "\r\n";*/

                // Enviarlo
                if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){
                ?><script type="text/javascript">swal("Enviados", "Correos enviados correctamente", "success");</script><?php
                }else{
                ?><script type="text/javascript">swal("Enviados", "Error al Envíar correos", "error");</script><?php
                }
        }

        $actualizar=notificacion_centro_costos::where('idproyecto',$request->idproyecto)->update(['estado'=>0]);
        $notificados2=$this->MostrarNotificados($request->idproyecto);
            $i=1;

            ?><thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>                        
                                </tr>
                            </thead>
            <?php
            foreach ($notificados2 as $row) {?>
                
                            <tbody>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$row->persona->nombre.' '.$row->trabajador->apellidos?></td>
                                    <td><?=$row->persona->correo?></td>

                                </tr>

                            </tbody>
            <?php $i++;}


    }


    public function CargarAjax(Request $request){


        $objProyecto=new ProyectoController();
        $ObjTrabajador=new TrabajadorController();

        if($request->op=="1"){

            $idproyecto=$_REQUEST["idproyecto"];
            $trabajadores=$objProyecto->cargarTodosTrabajadores2();
            $centros=$this->retronarCentrodeCostos1($idproyecto);

        ?>
        <script type="text/javascript" src="/js/sc.js"></script>

        <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Nº Centro Costos</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control1" name="centrodecosto" id="centrodecosto"  value="<?php echo $centros->centrodecosto;?>">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Nombre Clave del Proyecto</label>

                        <div class="col-sm-9">
                          <input type="text" class="form-control1" name="nombreclave"  value="<?php echo $centros->nombreclave;?>" disabled>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Observaciones</label>
                        <div class="col-sm-9">
                          <textarea  name="observacion" id="observacion" cols="0" rows="10" class="form-control1" value=""><?php echo $centros->observacion;?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default" onclick="ActualizarCentroDeCosto(<?php echo $idproyecto;?>)">Guardar</button> 
                    </div>
                    
                    <br>
                    <br>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Notificar a:</label>
                        <div class="col-sm-9">
                          <select id="trabajadorcostos" class="form-control1" required >
                                            <option value="">-Seleccione un trabajador-</option>
                                            <?php
                                            foreach ($trabajadores as $t) {
                                            ?>
                            <option value="<?php  echo $t['idpersona'];?>"><?php  echo $t['nombres'].' '.$t['apellidos'];?></option>

                                            <?php
                                            }
                                            ?>
                                
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-3 control-label">Correo</label>
                        <div id="correo">
                        <div class="col-sm-9">
                          <input type="text" class="form-control1" id="correo" name="correo"  value="" disabled>
                        </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default" onclick="AgregarNotificadoCostos(<?php echo $idproyecto;?>)"  >Agregar</button> 
                    </div>
                    
                    <br>
                    <br>
                </div>
                <div class="col-sm-12">



            
                        <table class="table" id="TablaNotificadoCosto">
                        <?php $notificados=$this->MostrarNotificados($idproyecto);
                        $i=1;?>

                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Nombre</th>
                                                <th>Correo</th>                        
                                            </tr>
                                        </thead>
                        <?php
                        //print_r($notificados);
                        foreach ($notificados as $row) {?>
                            
                                        <tbody>
                                            <tr>
                                                <td><?=$i?></td>
                                                
                                                <td><?=$row->nombre.' '.$row->apellidos?></td>
                                                <?if($row->correo){?>
                                                <td><?=$row->correo?></td>
						<?}?>
                                            </tr>

                                        </tbody>
                        <?php $i++;}?>
                        </table>

                        </div>
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-9"></div>
                    <div class="col-xs-12 col-sm-3">
                        <button type="button" class="btn btn-default" onclick="NotificarTodasPersonas(<?=$idproyecto?>)" >Notificar</button> 
                    </div>
                    <br>
                </div>
                            



        <?php



        }else if($request->op=="2"){

        
        $idtrabajador=$_REQUEST["idtrabajador"];
        $correo=$ObjTrabajador->retornaCorreo($idtrabajador);

        ?>
        <div class="col-sm-9">
        <input type="text" class="form-control1" name="correo" id="correocostos" value="<?php echo $correo;?>" disabled>
        </div>
        <?php



        }else if($request->op=="3"){
            $idproyecto=$request->idproyecto;
            $a=$this->actualizarCentroCosto($idproyecto,$request->centrodecosto,$request->observacion);
        }else if($request->op=="4"){


            $idproyecto=$request->idproyecto;
            DB::beginTransaction();
            $notificado=notificacion_centro_costos::create($request->all());
            $notificado->save();
            DB::commit();
            $notificados=$this->MostrarNotificados($idproyecto);
            $i=1;

            ?><thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>                        
                                </tr>
                            </thead>
            <?php
            foreach ($notificados as $row) {?>
                
                            <tbody>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$row->nombre.' '.$row->apellidos?></td>
                                    <td><?=$row->correo?></td>

                                </tr>

                            </tbody>
            <?php $i++;}

        }
    }

    }
