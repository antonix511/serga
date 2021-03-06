<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Comite_gerentes;
use App\Comite_participantes;
use App\Firmas;
use App\Firmas_comite;
use App\Trabajador;
use App\Privilegio_modulo;

use App\Versati;


class Comite_controller extends Controller
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
          DB::beginTransaction();
          $comite=Comite_gerentes::create($request->all());
          $comite->save();
          DB::commit();

          $_SESSION["nacta"]=$request->nacta;
        // dd($_SESSION["nacta"]);
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

    }
    public function CargarUsuario($usuario){
      $usuario=Trabajador::select('idprivilegio')->where('usuario','=',$usuario)->first();
      return $usuario;
    }
    public function CargarModulos($idprivilegio)
    {
      $modulos=Privilegio_modulo::with(['modulos'])->where('idprivilegio','=',$idprivilegio)->get();
      return $modulos;
    }

    public function acta_comite()
    {
      $acta_comite = Comite_gerentes::select('nacta')->where('estado', '1')->orderby('idcomite','desc')->first();
      if($acta_comite){
          return $acta_comite->toJson();
      }else {
          return 0;
      }

    }

    public function Actualizar(Request $request)
    {
      // dd($request->tema);
       // DB::beginTransaction();
      $Actualizar = Comite_gerentes::where('nacta',$request->nacta)->update(['tema'=>$request->tema,'idencargado'=>$request->idencargado,'revision'=>$request->revision,'avances'=>$request->avances,'idarea'=>$request->idarea,'encargados'=>$request->encargados,'hora'=>$request->hora,'fecha_hora'=>$request->fecha_hora,'fecha_prox_reu'=>$request->fecha_prox_reu]);

        // DB::commit();

    }

    public function consultar_firmas($type, $id)
    {
      if ($type == 1) {
        // notificados
        $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
        ->join('area','area.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
        ->where('firmas_comite.idestadofirma','!=','1')
        ->where('firmas_comite.estado','=','1')
        ->where('firmas_comite.idcomite', $id)->get();

        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nº</th>
              <th>Gerencia</th>
              <th>Nombre</th>
              <th>Cargo</th>
              <th>Correo</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
              ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $v['area'];?></td>
                <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                <td><?php echo $v['puesto'];?></td>
                <td><?php echo $v['correo'];?></td>
                <td><?php echo $v['estado'];?></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
        <?php

      }else {
        $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
        ->join('area','area.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
        ->where('firmas_comite.idestadofirma','=','1')
        ->where('firmas_comite.estado','=','1')
        ->where('firmas_comite.idcomite', $id)->get();

        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="myTable2" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nº</th>
              <th>Gerencia</th>
              <th>Nombre</th>
              <th>Cargo</th>
              <th>Correo</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
              ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $v['area'];?></td>
                <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                <td><?php echo $v['puesto'];?></td>
                <td><?php echo $v['correo'];?></td>
                <td> <a href="#"><i class="fa fa-trash"onclick="EliminarFirmaComite(<?=$v["idfirma"]?>)"></i></a></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
        <?php

      }

    }

    public function NotificarFirmas(Request $request)
    {
      $lista = Firmas_comite::where('idcomite','=',$request->idcomite)->where('estado',1)->update(['idestadofirma'=>2]);
      session_start();
            $trabajador=Trabajador::with(['persona','puesto'])->where('idpersona',$_SESSION['idpersona'])->first();
      $comite=Comite_gerentes::select('area.nombre as nomarea','comite_gerentes.tema as tema')->join('area','area.idarea','=','comite_gerentes.idarea')
      ->where('comite_gerentes.idcomite','=',$request->idcomite2)
      ->where('comite_gerentes.estado','1')->first();
      $area_comite=$comite->nomarea;
      $tema_comite=$comite->tema;

      $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','persona.telefono as telefono')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','=','2')
      ->where('firmas_comite.estado','=','1')
      ->where('idcomite', $request->idcomite)->get();

    ?>
    <script type="text/javascript" src="/js/sc.js"></script>
    <table id="myTable2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Gerencia</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $v['area'];?></td>
                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                    <td><?php echo $v['puesto'];?></td>
                    <td><?php echo $v['correo'];?></td>
                    <td><?php echo $v['estado'];?></td>
                    <td> <a href="#"><i class="fa fa-trash"onclick="EliminarFirmaComiteNNotificada(<?=$v["idfirma"]?>)"></i></a></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php
foreach ($lista as $v ){
    $para= $v['correo'];
    $telefono= $v['telefono'];
    $titulo="Acta de Comité de Gerentes del ".$area_comite;

        if (!empty($telefono)) {
            Versati::_send_sms($telefono, 'SERGA: Acta Comité de Gerentes de la Reunión '.$tema_comite);
        }


    $mensaje = '
    <html>
    <head>
    <meta charset="utf-8">
    </head>
    <body>
     <p><strong>El siguiente correo es remitido por el siguiente usuario '.$trabajador->persona->correo.'</strong></p>
      <p>Estimado(a):
      Por medio del presente se remite el Acta Comité de Gerentes de la Reunión: "'.$tema_comite.'", para su aprobación y firma.</p>

      <p>Saludos.</p>
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
    if(Versati::_send_mail($para, $titulo, $mensaje, $cabeceras)){}
}
    }

    public function consultar_tabla($id)
    {
      $consultar_tabla = Comite_participantes::select('comite_participantes.cargo','persona.nombre','trabajador.apellidos')
      ->where('idcomite', '=', $id)->orderby('idcomite_participantes','asc')
      ->where('comite_participantes.estado', '=', 1)
      ->join('persona','persona.idpersona','=','idparticipante')
      ->join('trabajador','trabajador.idpersona','=','persona.idpersona')->get();
      // dd($id,$consultar_tabla);
    ?>
    <thead>
                                      <tr>
                                        <th>Nº</th>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Eliminar</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i=1; ?>
                                    <?php foreach ($consultar_tabla as $row) { ?>

                                      <tr>
                                        <td><?=$i;?></td>
                                        <td><?php echo $row->nombre. " ".$row->apellidos ?></td>
                                        <td><?=$row->cargo?></td>
                                        <td><a href="#"><i class="fa fa-trash" onclick="EliminarParticipantesComite(<?=$row->idcomite_participantes?>)"></i></a></td>
                                      </tr>
                                    <?php $i++; } ?>

                                    </tbody>
    <?php
    }

        public function consultar($id)
        {

          session_start();
          $consultar = Comite_gerentes::select('*')->where('idcomite',$id)->first();


          $nacta=Comite_gerentes::select('nacta')->where('idcomite', $id)->first();

          $_SESSION["nacta"]=$nacta->nacta;

           return $consultar->toJson();
        }
    public function mostrar_acta_firmas($id){


       session_start();
      $usuario=$_SESSION['usuario'];
      $DataUsuario=$this->CargarUsuario($usuario);
      $modulos=$this->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="comit/gerentes") {




          $objProyecto=new ProyectoController();
          $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

          $objArea=new Area_Controller();
          $areas=$objArea->listarAreas();
          $objActaReu=new ActaReu_Ejecucion_Controller();
          $trabajadores=$objActaReu->cargarTrabajadores();

          $ultimo_id = Comite_gerentes::select('nacta','idcomite')->where('estado', '1')->where('idcomite',$id)->orderby('nacta','desc')->first();

          $nacta=Comite_gerentes::select('nacta')->where('idcomite', $id)->first();
          $_SESSION["nacta"]=$nacta->nacta;


          $participantes=Comite_participantes::with(['nompa','apepa'])->where('estado','=',1)->where('idcomite','=',$ultimo_id["nacta"])->orderby('idcomite_participantes','desc')->get();
          $lista=$this->listarFirmasPendientes('15');

          $listadoc= Comite_gerentes::select('*')->where('estado','=','1')->orderby('idcomite','desc')->get();

          $ultimo_comite = Comite_gerentes::select('*')->orderby('idcomite','desc')->where('idcomite',$id)->first();

              $listano = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','!=','1')
      ->where('firmas_comite.estado','=','1')
      ->where('idcomite', $ultimo_comite->nacta)->get();





          // dd($ultimo_comite);

          return view('com_gerentes',['ultimo'=>$ultimo_comite,'ultimoid'=>$ultimo_id,'listadoc'=>$listadoc,'gerentesYJefes'=>$gerentesYJefes,'trabajadores'=>$trabajadores,'areas'=>$areas,'participantes'=>$participantes,'lista'=>$lista,'listano'=>$listano]);
        }
      }
      ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php




    }

    public function CargarComite() {
      session_start();
      $usuario=$_SESSION['usuario'];
      $DataUsuario=$this->CargarUsuario($usuario);
      $modulos=$this->CargarModulos($DataUsuario->idprivilegio);
      foreach ($modulos as $row) {
        if ($row->modulos->ruta=="comit/gerentes") {




          $objProyecto=new ProyectoController();
          $gerentesYJefes=$objProyecto->cargarGerentesYJefes();

          $objArea=new Area_Controller();
          $areas=$objArea->listarAreas();
          $objActaReu=new ActaReu_Ejecucion_Controller();
          $trabajadores=$objActaReu->cargarTrabajadores();

          $listadoc= Comite_gerentes::select('*')->where('estado','=','1')->orderby('idcomite','asc')->get();

          $c = 1;
          for ($i=0; $i < count($listadoc); $i++) {
            if (isset($listadoc[$i-1])) {
              if (date('Y',strtotime($listadoc[$i-1]->fecha_registro)) < date('Y',strtotime($listadoc[$i]->fecha_registro))) {
                $c = 1;
              }
            }
            $listadoc[$i]->nacta_fake = $c;
            $c++;
          }
          // dd($c);

          $create =true; //nuevo
          $ultimo_id = Comite_gerentes::select('nacta','idcomite', 'fecha_registro')->where('estado', '1')->orderby('nacta','desc')->first();
          // $ultimo_id = new Comite_gerentes();
          if (isset($ultimo_id)) {
            $nacta=Comite_gerentes::select('nacta')->where('idcomite', $ultimo_id->idcomite)->first();
            $ultimo_id->nacta_fake = $c;
            $ultimo_id->nacta++;
            $_SESSION["nacta"]=$ultimo_id->nacta;

          //   $participantes=Comite_participantes::with(['nompa','apepa'])->where('estado','=',1)->where('idcomite','=',$ultimo_id["nacta"])->orderby('idcomite_participantes','desc')->get();
          }else {
            $ultimo_id = new Comite_gerentes();
            $nacta = 1;
            $_SESSION["nacta"]=$nacta;
            $ultimo_id->nacta = $nacta;
            $ultimo_id->idcomite = 1;
          }
          $participantes=null;

          $lista=$this->listarFirmasPendientes('15');
          // $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
          // ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          // ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          // ->join('area','area.idarea','=','trabajador.idarea')
          // ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          // ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          // ->where('firmas_comite.idestadofirma','=','1')
          // ->where('firmas_comite.estado','=','1')
          // ->where('trabajador.estado','1')
          // ->where('persona.estado','1')
          // ->where('firmas_comite.iddocumento','=',15)
          // ->where('idcomite', $ultimo_id["nacta"])->get();


          // $ultimo_comite = Comite_gerentes::select('*')->orderby('idcomite','desc')->first();
          $ultimo_comite = new Comite_gerentes();
          if (empty($ultimo_comite)) {
              $ultimo_comite = null ;
              $listano=null;
            }else{
              $listano = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','!=','1')
      ->where('firmas_comite.estado','=','1')
      ->where('idcomite', $ultimo_comite->nacta)->get();

          }



          // dd($ultimo_comite);

          return view('com_gerentes',['ultimo'=>$ultimo_comite,'ultimoid'=>$ultimo_id,'listadoc'=>$listadoc,'gerentesYJefes'=>$gerentesYJefes,'trabajadores'=>$trabajadores,'areas'=>$areas,'participantes'=>$participantes,'lista'=>$lista,'listano'=>$listano]);
        }
      }
      ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php

    }

    public function tabla($id)
    {
       $listadoc= Comite_gerentes::select('*')->where('estado','=','1')->orderby('idcomite','desc')->get();
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
                                  echo "<td>Acta Comité de Gerentes - $row->nacta</td>";
                                  echo "<td class='text-center'>
                                <button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_Comite('$row->idcomite')>Ver más</button>
                                  </td></tr>";
                                  $contador+=1;
                                }
                              }
                            ?>
                          </tbody>

                        </table>

    <?php
    }

function EliminarParticipante(Request $request)
{
  $actualiza=Comite_participantes::where('idcomite_participantes','=',$request->idparticipante)->update(['estado'=>0]);
  $participantes=Comite_participantes::with(['nompa','apepa'])->where('idcomite', $request->idcomite)->where('estado','=',1)->get();
        ?>
        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Cargo</th>
                                            <th>Eliminar</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php $i=1; ?>
                                        <?php foreach ($participantes as $row) { ?>

                                          <tr>
                                            <td><?=$i;?></td>
                                            <td><?php echo $row->nompa->nombre. " ".$row->apepa->apellidos ?></td>
                                            <td><?=$row->cargo?></td>
                                            <td><a href="#"><i class="fa fa-trash" onclick="EliminarParticipantesComite(<?=$row->idcomite_participantes?>)"></i></a></td>
                                          </tr>
                                        <?php $i++; } ?>

                                        </tbody>

                                        <?php
}
    public function GuardarParticipante(Request $request)
    {
      // dd($request);
      $participante = Comite_participantes::where('idcomite', $request->idcomite)
                                          ->where('idparticipante', $request->idparticipante)
                                          ->where('estado','=',1)
                                          ->get();
      if ($participante->count()>0) {
        ?><h1>Repetido</h1><?php
      }else {
        DB::beginTransaction();
        $comite=Comite_participantes::create($request->all());
        $comite->save();
        DB::commit();

        $participantes=Comite_participantes::with(['nompa','apepa'])->where('estado','=','1')->where('idcomite', $request->idcomite)->orderby('idcomite_participantes','asc')->get();
        ?>
        <thead>
                                          <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                            <th>Cargo</th>
<th>Eliminar</th>
                                          </tr>
                                        </thead>
                                        <tbody><?php $i=1; ?>
                                        <?php foreach ($participantes as $row) { ?>

                                          <tr>
                                            <td><?=$i;?></td>
                                            <td><?php echo $row->nompa->nombre. " ".$row->apepa->apellidos ?></td>
                                            <td><?=$row->cargo?></td>
                                            <td><a href="#"><i class="fa fa-trash" onclick="EliminarParticipantesComite(<?=$row->idcomite_participantes?>)"></i></a></td>
                                          </tr>
                                        <?php $i++; } ?>

                                        </tbody>

                                        <?php
        }
    }
    public function listarFirmasPendientes($iddocumento){
        $ultimo_id = Comite_gerentes::select('nacta')->where('estado', '1')->orderby('nacta','desc')->first();
        // dd($ultimo_id, $iddocumento);
        $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
        ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
        ->join('area','area.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
        ->where('firmas_comite.idestadofirma','=','1')
        ->where('firmas_comite.estado','=','1')
        ->where('trabajador.estado','1')
        ->where('persona.estado','1')
        ->where('firmas_comite.iddocumento','=',$iddocumento)
        ->where('idcomite', $ultimo_id["nacta"])->get();

        return $lista;
    }

    function MostrarCargo(Request $request){
    $ObjTrabajador=new TrabajadorController();
    $idtrabajador=$_REQUEST["idtrabajador"];
    $puesto=$ObjTrabajador->retornarPuestoTrabajador($idtrabajador);

    ?>
    <script type="text/javascript" src="/js/sc.js"></script>
    <select name="cargofirma" id="cargofirma" class="form-control1" disabled>
        <option value="<?php echo $puesto;?>"><?php echo $puesto;?></option>
    </select>
    <?php
    }
    public function EliminarFirmaNotificada(Request $request)
    {
      $actulaizaa = Firmas_comite::where('idfirma','=',$request->idfirma)->update(['estado'=>0]);

      $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','=','2')
      ->where('firmas_comite.estado','=','1')
      ->where('idcomite', $request->idcomite)->get();

    ?>

    <script type="text/javascript" src="/js/sc.js"></script>
    <table id="myTable2" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Gerencia</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Correo</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $v ){
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $v['area'];?></td>
                    <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                    <td><?php echo $v['puesto'];?></td>
                    <td><?php echo $v['correo'];?></td>
                    <td><?php echo $v['estado'];?></td>
                    <<td> <a href="#"><i class="fa fa-trash"onclick="EliminarFirmaComiteNNotificada(<?=$v["idfirma"]?>)"></i></a></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
<?php

    }


    function EliminarFirma(Request $request){
      // dd($request);
      $actulaizaa = Firmas_comite::where('idfirma','=',$request->idfirma)->update(['estado'=>0]);
      $firma = Firmas_comite::where('idfirma','=',$request->idfirma)->first();
      // dd($firma);

      // $lista=$this->listarFirmasPendientes('15');
      $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','=','1')
      ->where('firmas_comite.estado','=','1')
      ->where('trabajador.estado','1')
      ->where('persona.estado','1')
      ->where('firmas_comite.iddocumento','=',15)
      ->where('idcomite', $firma->idcomite)->get();

      ?>
      <script type="text/javascript" src="/js/sc.js"></script>
      <table id="myTable2" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th>Nº</th>
                  <th>Gerencia</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Correo</th>
                  <th>Estado</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              <?php
              $i=1;
              foreach ($lista as $v ){
                  ?>
                  <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $v['area'];?></td>
                      <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                      <td><?php echo $v['puesto'];?></td>
                      <td><?php echo $v['correo'];?></td>
                      <td><?php echo $v['estado'];?></td>
                      <<td> <a href="#"><i class="fa fa-trash"onclick="EliminarFirmaComite(<?=$v["idfirma"]?>)"></i></a></td>
                  </tr>
                  <?php
                  $i++;
              }
              ?>
          </tbody>
      </table>
      <?php
    }
    function AgregarFirma(Request $request){
      $firmas = Firmas_comite::where('estado','=','1')
                            ->where('iddocumento','=',$request->iddocumento)
                            ->where('idcomite', '=', $request->idcomite)
                            ->where('idtrabajador', '=', $request->idtrabajador)
                            ->get();
      if ($firmas->count()>0) {
        ?><h1>Repetido</h1><?php
      }else {
      DB::beginTransaction();
          $firma=Firmas_comite::create($request->all());
          $firma->save();
      DB::commit();


      // $lista=$this->listarFirmasPendientes('15');
      $lista = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo')
      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
      ->join('area','area.idarea','=','trabajador.idarea')
      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
      ->where('firmas_comite.idestadofirma','=','1')
      ->where('firmas_comite.estado','=','1')
      ->where('trabajador.estado','1')
      ->where('persona.estado','1')
      ->where('firmas_comite.iddocumento','=',15)
      ->where('idcomite', $request->idcomite)->get();
      ?>

      <table id="myTable2" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th>Nº</th>
                  <th>Gerencia</th>
                  <th>Nombre</th>
                  <th>Cargo</th>
                  <th>Correo</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              <?php
              $i=1;
              foreach ($lista as $v ){
                  ?>
                  <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $v['area'];?></td>
                      <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                      <td><?php echo $v['puesto'];?></td>
                      <td><?php echo $v['correo'];?></td>
                      <td> <a class="" href="#"><i class="fa fa-trash"onclick="EliminarFirmaComite(<?=$v["idfirma"]?>)"></i></a></td>
                  </tr>
                  <?php
                  $i++;
              }
              ?>
          </tbody>
      </table>
      <?php
      }
    }

    public function Exportar( $idcomite )
    {
      session_start();
        $comite=Comite_gerentes::select('comite_gerentes.hora as hora','comite_gerentes.fecha_hora as fecha','comite_gerentes.tema as tema','comite_gerentes.revision as revision','comite_gerentes.avances as avances','comite_gerentes.encargados as encargados','fecha_prox_reu as prox_reu','persona.nombre as nombre','trabajador.apellidos as apellidos','area.nombre as area')
        ->join('persona','persona.idpersona','=','comite_gerentes.idencargado')
        ->join('trabajador','trabajador.idpersona','=','comite_gerentes.idencargado')
        ->join('area','area.idarea','=','comite_gerentes.idarea')
        ->where('comite_gerentes.estado','=',1)
        ->where('comite_gerentes.idcomite','=',$idcomite)
        ->first();

        $participantes=Comite_participantes::with(['nompa','apepa'])->where('estado','=',1)->where('idcomite',$_SESSION["nacta"])->get();

        $permiso=Trabajador::select('idpersona')->where('idpuesto',83)->where('estado',1)->first();

        if (isset($permiso)) {
          $gerente_per= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma' )
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          // ->where('firmas_comite.idestadofirma','=','2')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $permiso->idpersona)
          ->where('idcomite', $_SESSION["nacta"])->first();
        }else {
          $gerente_per = null;
        }


        $idpersona_gerente_servicio=Trabajador::select('idpersona')->where('idpuesto',5)->where('estado',1)->first();

        if (isset($idpersona_gerente_servicio)) {
          $gerente_ser= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma')
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $idpersona_gerente_servicio->idpersona)
          ->where('idcomite',$_SESSION["nacta"])->first();
        }else {
          $gerente_ser = null;
        }


        $idpersona_gerente=Trabajador::select('idpersona')->where('idpuesto',3)->where('estado',1)->first();

        if ($idpersona_gerente) {
          $gerente= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma')
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $idpersona_gerente->idpersona)
          ->where('idcomite',$_SESSION["nacta"])->first();
        }else{
          $gerente = null;
        }

        $idpersona_calidad=Trabajador::select('idpersona')->where('idpuesto',7)->where('estado',1)->first();

        if ($idpersona_calidad) {
          $calidad= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma')
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $idpersona_calidad->idpersona)
          ->where('idcomite',$_SESSION["nacta"])->first();
        }else {
          $calidad = null;
        }

        $idpersona_adm=Trabajador::select('idpersona')->where('idpuesto',6)->where('estado',1)->first();

        if (isset($idpersona_adm)) {
          $adm= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma')
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $idpersona_adm->idpersona)
          ->where('idcomite',$_SESSION["nacta"])->first();
        }else {
          $adm = null;
        }

        $idpersona_coor=Trabajador::select('idpersona')->where('idpuesto',10)->where('estado',1)->first();

        if (isset($idpersona_coor)) {
          $coor= Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma')
          ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
          ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
          ->join('area','area.idarea','=','trabajador.idarea')
          ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
          ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
          ->where('firmas_comite.idestadofirma','=','3')
          ->where('firmas_comite.estado','=','1')
          ->where('persona.idpersona', '=', $idpersona_coor->idpersona)
          ->where('idcomite',$_SESSION["nacta"])->first();
        }else {
          $coord = null;
        }

        // Firmas adicionales a los 6 cargos definidos
        $firmas_extras = Firmas_comite::select('firmas_comite.idfirma as idfirma','area.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo', 'trabajador.firma as firma', 'puesto.nombre as puesto')
                                      ->join('persona','persona.idpersona','=','firmas_comite.idtrabajador')
                                      ->join('trabajador','trabajador.idpersona','=','firmas_comite.idtrabajador')
                                      ->join('area','area.idarea','=','trabajador.idarea')
                                      ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
                                      ->join('estado_firma','estado_firma.idestadofirma','=','firmas_comite.idestadofirma')
                                      // ->where('firmas_comite.idestadofirma','=','3')
                                      ->where('firmas_comite.estado','=','1')
                                      ->whereNotIn('trabajador.idpuesto',[83, 5, 3, 7, 6, 10])
                                      ->where('idcomite',$_SESSION["nacta"])->get();
                                      // dd($firmas_extras);

$html='<!DOCTYPE html><html>';
        $html.='<head>
    <meta charset="UTF-8">
    <title>Comite Controler</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: Arial;
        }
        table{
            border-spacing: 0px;
        }
    </style>

</head>';
$html.='<body><table width="100%">';

$html.='<tr>';
$html.='<td width="20%" style="padding: 15px; border: 1px solid #000" ><img src="logo.png" border="0" height="50" width="150" align="middle" /></td>';
$html.='<td width="50%" style="border: 1px solid #000" colspan="2"><h2 style="text-align: center;  ">Acta de Comité de Gerentes</h2></td>';
$html.='<td width="30%" valign="top" style="border: 1px solid #000""><br>Codigo: SGC-FOR-25<br>Version: 00</td>';
$html.='</tr></table><br>';


$html.='<table width="100%">';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><strong>N°</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000">'.$_SESSION["nacta"].'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><strong>ÁREA/PROYECTO</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000">'.$comite->area.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><strong>TEMA DE LA REUNIÓN</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000">'.$comite->tema.'</td>';
$html.='</tr>';

$date_fecha=date_create($comite->fecha);
$fecha=$date_fecha->format('d/m/Y');

$html.='<tr>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><strong>FECHA</strong></td>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000">'.$fecha.'</td>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><strong>Hora</strong></td>';

$horas=substr($comite->hora,0,2);
$minutos=substr($comite->hora,0-2);
$horas=$horas*1;
$cosa="";
if($horas>11){
    $horas=$horas-12;
    $cosa=" p.m.";
}else{
    $cosa=" a.m.";
}

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000">'.$horas.':'.$minutos.$cosa.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>PARTICIPANTES</strong></td>';
$html.='</tr>';


$html.='<tr>';
$html.='<td width="50%" colspan="2" style="padding: 5px; border: 1px solid #000"><strong>Nombre:</strong></td>';
$html.='<td width="50%" colspan="2" style="padding: 5px; border: 1px solid #000"><strong>Cargo:</strong></td>';
$html.='</tr>';

foreach ($participantes as $v) {
  $html.='<tr>';
  $html.='<td width="50%" colspan="2" style="padding: 5px; border: 1px solid #000">'.$v->nompa->nombre.' '.$v->apepa->apellidos.'</td>';
  $html.='<td width="50%" colspan="2" style="padding: 5px; border: 1px solid #000">'.$v->cargo.'</td>';
  $html.='</tr>';
}

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>REVISIÓN DE PENDIENTES:</strong></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000">'.$comite->revision.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>AVANCES DEL PROYECTO:</strong></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000">'.$comite->avances.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>ENCARGOS DE LA SIGUIENTE SEMANA:</strong></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000">'.$comite->encargados.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>FECHA PROXIMA REUNIÓN:</strong></td>';
$html.='</tr>';

if ($comite->prox_reu == '0000-00-00') {
  $freu = '';
}else {
  $date=date_create($comite->prox_reu);
  $freu=$date->format('d/m/Y');
}

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000">'.$freu.'</td>';
$html.='</tr>';

$html.='</table>';

$html.='<br><br>';

$html.='<table width="100%" >';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000"><strong>FIRMAS</strong></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">Cargo: Gerente de Proyectos de Gestión Predial</td>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000">Cargo: Gerente de Autorizaciones y Permisos</td>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">Cargo: Gerente de Servicios en Gestión Predial</td>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000">Cargo: Gerente de Calidad</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if(!empty($gerente)) {
  $html.='<img align="center" src="documentos/trabajador/'.$gerente->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if(!empty($gerente_per)) {
  $html.='<img align="center" src="documentos/trabajador/'.$gerente_per->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if(!empty($gerente_ser)) {
  $html.='<img align="center" src="documentos/trabajador/<'.$gerente_ser->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if (!empty($calidad)) {
  $html.='<img align="center" src="documentos/trabajador/'.$calidad->firma.'" width="115" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='</tr>';

$html.='<tr>';
$html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;">Cargo: Gerente de Administración</td>';
$html.='<td width="25%" style="padding: 5px; border: 1px solid #000">Cargo: Coordinador de Contratos y Propuestas</td>';

if (!empty( $firmas_extras->get(0) )) {
  $html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;text-transform: capitalize;">Cargo: '.$firmas_extras->get(0)->puesto.'</td>';
}else {
  $html.='<td width="25%" style="padding: 5px; border: 1px solid #000"></td>';
}
if (!empty( $firmas_extras->get(1) )) {
  $html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;text-transform: capitalize;">Cargo: '.$firmas_extras->get(1)->puesto.'</td>';
}else {
  $html.='<td width="25%" style="padding: 5px; border: 1px solid #000"></td>';
}
// $html.='<td width="25%" style="padding: 5px; border: 1px solid #000"></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if(!empty($adm)) {
  $html.='<img align="center" src="documentos/trabajador/'.$adm->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if(!empty($coor)) {
  $html.='<img align="center" src="documentos/trabajador/'.$coor->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if (!empty( $firmas_extras->get(0)) && $firmas_extras->get(0)->estado == 'APROBADO') {
  $html.='<img align="center" src="documentos/trabajador/'.$firmas_extras->get(0)->firma.'" width="145" height="83" hspace="10" >';
}else {
  $html.='<br><br><br>';
}
$html.='</td>';

$html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
if (!empty($firmas_extras->get(1))) {
  if ($firmas_extras->get(1)->estado == 'APROBADO') {
    $html.='<img align="center" src="documentos/trabajador/'.$firmas_extras->get(1)->firma.'" width="145" height="83" hspace="10" >';
  }else {
    $html.='<br><br><br>';
  }
}
$html.='</td>';

// $html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><br><br><br></td>';
// $html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;"><br><br><br></td>';
$html.='</tr>';

// Se le resta 2 por los cuadros anteriores
$size = $firmas_extras->count()-2;
$loops = (int) floor( $size/4 );
// dd(floor( $size/4 ), $loops);
for ($i=0; $i < $loops ; $i++) {
  $x = ($i*4)+2;
  $html.='<tr>';
  for ($j=$x; $j < $x+4 ; $j++) {
    $html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;text-transform: capitalize;">Cargo: '.$firmas_extras->get($j)->puesto.'</td>';
  }
  $html.='</tr>';
  $html.='<tr>';
  for ($j=$x ; $j <$x+4 ; $j++) {
    $html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
    if ($firmas_extras->get($j)->estado == 'APROBADO') {
      $html.='<img align="center" src="documentos/trabajador/'.$firmas_extras->get($j)->firma.'" width="145" height="83" hspace="10" >';
    }else {
      $html.='<br><br><br>';
    }
    $html.='</td>';
  }
  $html.='</tr>';
}

$init = ($loops*4+2);
// dd($init);
if ($loops >= 0) {
  $html.='<tr>';
  for ($i=0; $i < 4 ; $i++) {
    if (!empty( $firmas_extras->get($init+$i) )) {
      $html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;text-transform: capitalize;">Cargo: '.$firmas_extras->get($init+$i)->puesto.'</td>';
    }else {
      $html.='<td width="25%" style="padding: 5px; border: 1px solid #000;text-align:left;text-transform: capitalize;"></td>';
    }
  }
  $html.='</tr>';
  $html.='<tr>';
  for ($i=0; $i < 4; $i++) {
    $html.='<td width="25%"  style="padding: 5px; border: 1px solid #000;text-align:left;">';
    if (!empty($firmas_extras->get($init+$i)) ) {
      if ($firmas_extras->get($init+$i)->estado == 'APROBADO') {
        $html.='<img align="center" src="documentos/trabajador/'.$firmas_extras->get($init+$i)->firma.'" width="145" height="83" hspace="10" >';
      }else {
        $html.='<br><br><br>';
      }
    }
    $html.='</td>';
  }
  $html.='</tr>';
  // $html.='<tr></tr>';
}


$html.='</table></body>
</html>';

  $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','portrait');
        $pdf->loadHTML($html);
        return @$pdf->stream('Comite_Gerentes.pdf');

    }
}
