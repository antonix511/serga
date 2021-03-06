<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proyecto;
use App\Solicitud_cambio;
use DB;
use App\Seguimiento_proyecto;
use App\Firmas;
use App\Proyecto_doc_valida;

class SolicitudCambio_Ejecucion_Controller extends Controller
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
        DB::beginTransaction();
        $solicitud=Solicitud_cambio::create($request->all());
        $solicitud->save();
        DB::commit();
        $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
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

    public function cargarContactoClienteProyecto($id){

        $resultado = Proyecto::select('contacto')->where('estado','=','1')->where('idproyecto','=',$id)->get();
        if(count($resultado)==0){
            $cod=1;
        }else{
            $cod =$resultado[0]->contacto;
        }
        return $cod;
    }
    public function retornarSolCambio($idproyecto){
        $req=Solicitud_cambio::with(['documento'])->where('solicitud_cambio.idproyecto','=',$idproyecto)->orderby('idsolicitud','desc')->first();
        return $req;
    }
     public function ActualizarSolicitud(Request $request){

        DB::beginTransaction();

        $solcam = Solicitud_cambio::where('idsolicitud','=',$request->idacta)->update([
          'fecha'=>$request->fecha,
          'motivo_tiempo'=>$request->motivo_tiempo,
          'motivo_alcance'=>$request->motivo_alcance,
          'motivo_costo'=>$request->motivo_costo,
          'motivo_sgc'=>$request->motivo_sgc,
          'medio'=>$request->medio,
          'descripcion'=>$request->descripcion,
          'nombre'=>$request->nombre,
          'cargo'=>$request->cargo,
          'fecha_entrega'=>$request->fecha_entrega
        ]);
        DB::commit();

        $objActaAcu=new ActaAcuerdo_Ejecucion_Controller();
        $verificar=$objActaAcu->VerificarDocumentos($request->idproyecto);
        if ($verificar>0) {
            $actualizar=Seguimiento_proyecto::where('idproyecto','=',$request->idproyecto)->update(['idfase'=>3]);
        }
    }

     public function ejecucion_solicitudcam($id){

        $objProyecto=new ProyectoController();
        $nom=$objProyecto->retronarNombreProyecto($id);
        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);
        $centrodecosto=$objProyecto->retornarCentroCostos($id);
        $cli=$objProyecto->retronarClienteProyecto($id);
        $contacto=$this->cargarContactoClienteProyecto($id);
        $idacta = $this->idacta('7');
        $objActaInicio=new Acta_inicioController();

        if(empty($idacta)){
            $idacta = 0;
            $lista = 0;
        }else{
            $lista=$objActaInicio->listarFirmasPendientes($id,7,$idacta);
        }

        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();
        $solcam=$this->retornarSolCambio($id);
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        $listadoc= Solicitud_cambio::select('*')->where('idproyecto',$id)->orderby('idsolicitud','desc')->get();

        $firmas=$objActaReu->listarFirmasNotificadas($id,7);

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        
        return view('ejecucion_solicitudcam',['id'=>$id,'nom'=> $nom,'nomcla'=>$nomcla,'centrodecosto'=>$centrodecosto,'cli'=>$cli,'contacto'=>$contacto,'trabajadores'=>$trabajadores,'lista'=>$lista,'solcam'=>$solcam,'nombreclave'=>$nombreclave,'listadoc'=>$listadoc,'firmas'=>$firmas,'doc_validados'=>$doc_validados]);

    }

    public function tabla_solicitudcam($id)
    {
      $listadoc= Solicitud_cambio::select('*')->orderby('idsolicitud','desc')->get();
    ?>
      <table class="table">
                              <thead>
                                <tr>
                                <th>N°</th>
                                <th>Medio de Aprobación - fecha</th>
                                <th>Ver</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  if(!empty($listadoc)){
                                    $contador = 1;
                                    foreach ($listadoc as $row) {
                                      echo "<tr><td>$contador</td>";
                                      echo "<td>$row->medio-$row->fecha</td>";
                                      echo "<td class='text-center'>
                                    <button type='button' class='btn btn-primary' data-dismiss='modal' aria-label='Close' onclick=datos_doc_solicitud_cambio('$row->idsolicitud')>Ver más</button>
                                      </td></tr>";
                                      $contador+=1;
                                    }
                                  }
                                ?>
                              </tbody>

                            </table>
    <?php
    }

    public function idacta($id)
    {
      $idacta = Solicitud_cambio::select('*')->where('iddocumento', $id)->orderby('idsolicitud','desc')->first();


      if (!empty($idacta)) {
        return $idacta->idsolicitud;
      }else {

      }

      // dd($idacta->idacta_reunion);
    }

    public function firmas_solicitud(Request $request)
    {
        $objActaInicio=new Acta_inicioController();
        $firmas_solicitud = $objActaInicio->listarFirmasPendientes($request->id,'7',$request->idacta_acuerdo);
        // return $firmas_solicitud->toJson();
    ?>
    <table class="table">
      <thead>
        <tr>
          <th>Nº</th>
          <th>Nombre</th>
          <th>Cargo</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $i=1;
                  foreach ($firmas_solicitud as $v ){
                      ?>
                      <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $v['nombres'].' '.$v['apellidos'];?></td>
                          <td><?php echo $v['puesto'];?></td>
                          <td> <a class="fa fa-trash" href="#" onclick="eliminarfirma(<?php echo $v['idfirma'];?>, <?php echo $request->id;?>);"></a></td>
                      </tr>
                      <?php
                      $i++;
                  }
              ?>
      </tbody>
    </table>
    <?php

    }


    public function lista_solicitud($idacta_acuerdo)
    {
        $lista_solicitud = Solicitud_cambio::select('*')->where('idsolicitud','=',$idacta_acuerdo)->first();

        return $lista_solicitud->toJson();
    }

     public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }
    public function ExportarWord($id){

        $objProyecto=new ProyectoController();
        $nom=$objProyecto->retronarNombreProyecto($id);
        $nomcla=$objProyecto->retronarNombreClaveProyecto($id);
        $centrodecosto=$objProyecto->retornarCentroCostos($id);
        $cli=$objProyecto->retronarClienteProyecto($id);
        $contacto=$this->cargarContactoClienteProyecto($id);
        $responsable_proyecto = $objProyecto->retronarGerente($id);

        $objActaInicio=new Acta_inicioController();
        $solcam=$this->retornarSolCambio($id);
        $lista=$objActaInicio->listarFirmasPendientes($id,7,$solcam->idsolicitud);
        $fecha_entrega = $solcam->fecha_entrega != '0000-00-00' ? date('d/m/Y', strtotime($solcam->fecha_entrega)) : '';
        // dd($solcam, $fecha_entrega);


        $objActaReu=new ActaReu_Ejecucion_Controller();
        $trabajadores=$objActaReu->cargarTrabajadores();
        $solcam=$this->retornarSolCambio($id);


        $listano = Firmas::select('a.nombre as area','persona.nombre as nombres','trabajador.apellidos as apellidos','puesto.nombre as puesto','estado_firma.nombre as estado','persona.correo as correo','trabajador.firma as firma')
        ->join('persona','persona.idpersona','=','firmas.idtrabajador')
        ->join('trabajador','trabajador.idpersona','=','firmas.idtrabajador')
        ->join('area as a','a.idarea','=','trabajador.idarea')
        ->join('puesto','puesto.idpuesto','=','trabajador.idpuesto')
        ->join('estado_firma','estado_firma.idestadofirma','=','firmas.idestadofirma')
        ->where('firmas.idestadofirma','=','3')
        ->where('firmas.estado','=','1')
        ->where('firmas.idproyecto','=',$id)
        ->where('firmas.iddocumento','=',7)->get();

$html='<!DOCTYPE html><html>';
        $html.='<head>
    <meta charset="UTF-8">
    <title>Solicitud de Cambio</title>
    <style>
        *{
            box-sizing: border-box;
            font-family: sans-serif;
        }
        table{
            border-spacing: 0px;
        }
    </style>

</head>';
$html.='<body><table width="100%">';
$html.='<tr>';
$html.='<td width="30%" style="padding: 15px; border: 1px solid #000" ><img src="logo.png" border="0" height="70" width="175" align="middle" /></td>';
$html.='<td width="50%" style="border: 1px solid #000;font-size:15.5pt" colspan="2"><center><strong>Solicitud de Cambio</strong></center></td>';
$html.='<td width="33%" valign="top" style="border: 1px solid #000;font-size:10pt""><br>Código: SGC-FOR-22<br>Versión: 02<br>Fecha: 15/03/2018</td>';
$html.='</tr></table><br>';

$html.='<table width="100%">';

$html.='<tr>';
$html.='<td width="80%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt;text-align:left;"><strong>N°: </strong>1</td>';
$html.='<td width="20%" style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>FECHA</strong>: '.date('d/m/Y', strtotime($solcam->fecha_registro)).'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border-top: 1px solid #000;font-size:10pt;border-left: 1px solid #000;border-right: 1px solid #000;font-size:10pt;"><strong>PROPÓSITO DE CAMBIO:</strong></td>';
$html.='</tr>';

$html.='<tr><td colspan="4"><table width="100%" border="0" align="center"><tr>';
$html.='<td width="25%" style="padding: 5px;border-bottom: 1px solid #000;border-left: 1px solid #000;;font-size:10pt"><strong>TIEMPO [';if($solcam->motivo_tiempo==1){$html.='X';}  $html.='] </strong></td>';
$html.='<td width="25%" colspan="2" style="padding: 5px;border-bottom: 1px solid #000;font-size:10pt"><strong>COSTO ['; if($solcam->motivo_costo==1){$html.='X';} $html.=']</strong></td>';
$html.='<td width="25%" style="padding: 5px;border-bottom: 1px solid #000;;border-right: 1px solid #000;font-size:10pt"><strong>ALCANCE [';if($solcam->motivo_alcance==1){$html.='X';} $html.=']</strong></td>';
$html.='<td width="25%" style="padding: 5px;border-bottom: 1px solid #000;;border-right: 1px solid #000;font-size:10pt"><strong>SGC [';if($solcam->motivo_sgc==1){$html.='X';} $html.=']</strong></td>';
$html.='</tr></table></td></tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>NOMBRE DEL PROYECTO:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$nom.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>NOMBRE CLAVE DEL PROYECTO:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$nomcla.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>CENTRO DE COSTOS:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$centrodecosto.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>CLIENTE:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$cli.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>CONTACTO (CLIENTE):</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$contacto.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="30%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>MEDIO DE APROBACIÓN:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$solcam->medio.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="40%"  style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>RESPONSABLE DEL PROYECTO:</strong></td>';
$html.='<td width="70%" colspan="3" style="padding: 5px; border: 1px solid #000;font-size:10pt">'.$responsable_proyecto.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>DESCRIPCIÓN:</strong><br>'.$solcam->descripcion.'</td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="100%" colspan="4" style="padding: 5px; border: 1px solid #000;font-size:10pt"><strong>FECHA DE ENTREGA:</strong><br>'.$fecha_entrega.'</td>';
$html.='</tr>';

$html.='</table>';
$html.='<br><br><br><br>';

$html.='<table width="45%" align="right" >';

$html.='<tr>';
$html.='<td width="70%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:10pt"><center><strong>APROBACIÓN</strong></center></td>';
$html.='</tr>';

$html.='<tr>';
$html.='<td width="70%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:10pt">Nombre: '.$solcam->nombre.'<br>Cargo: '.$solcam->cargo.'</td>';
$html.='</tr>';

for ($i=0; $i <count($listano) ; $i++) {
$html.='<tr>';

  if (!empty($listano[$i])) {
    $html.='<td width="70%" colspan="2" style="padding: 5px; border: 1px solid #000;font-size:10pt;text-align:center;">';

    $html.='<img style="width: 190px; height: 100px;"  src="documentos/trabajador/'.$listano[$i]['firma'].'" alt="">';
    $html.='</td>';

  }
$html.='</tr>';
}

$html.='</table></body>
</html>';

      $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A4','portrait');
        $pdf->loadHTML($html);
        return @$pdf->stream('Solicitud_cambio.pdf');
    }
}
