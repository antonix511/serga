<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Code;
use App\Cliente;
use App\Documento;
use App\Proyecto;

class Code_Controller extends Controller
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
        $cliente=$request->cliente;
        $documento=$request->documento;
        $anio = date("Y");

        // $anio=$this->RetornarAnioProyecto($request->proyecto);
        $abrevpro=$this->RetornarAbrePro($request->proyecto);
        $correlativo=$this->traercorr($request->proyecto);

        $ceros="";
        if($correlativo<10){
            $ceros="0000";
        }elseif ($correlativo>9 && $correlativo<100) {
            $ceros="000";
        }elseif ($correlativo>99 && $correlativo<1000) {
            $ceros="00";
        }elseif ($correlativo>999 && $correlativo<10000) {
            $ceros="0";
        }



        $codigo=$request->codigo;

        //echo "la abre es: ".$abrevpro;

        $nombre=$documento."-".$ceros.$correlativo."-".$abrevpro."-".$cliente."-".$anio;
        DB::beginTransaction();
        $code = Code::create($request->all());
        $code->nombre=$nombre;
        $code->correlativo=$ceros.$correlativo;
        $code->save();
        DB::commit();
        $codes=Code::select('*')->where('cliente',$request->cliente)->where('proyecto',$request->proyecto)->where('estado','=','1')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <input type="hidden" id="codeResponse" name="" value="<?php echo $nombre ?>">
        <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODE</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de creación</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
        </table>


        <?php
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
        $code=Code::with(['proyecto'])->where('idcode','=',$id)->where('estado','=','1')->first();
        return $code->toJson();
    }

    public function RetornarAbrePro($idproyecto)
    {
        $proyecto=Proyecto::select('*')->where('idproyecto','=',$idproyecto)->where('estado','=',1)->first();
        $idservicio=$proyecto->idservicio;
        $objpro = new ProyectoController();
        $abreser=$objpro->retornarAbreviaturaServicio($idservicio);
        //echo "el abreser es: ".$abreser;

        //$correpro=$objpro->traerindicefinal($proyecto->idcliente,$proyecto->idservicio);
        $correpro=$objpro->traerindicefinalCorrecto($idproyecto);
                //echo "el correpro es: ".$correpro;
        return $abreser.$correpro;

    }

    public function traercorr($idproyecto)
    {

        $numero=Code::select('*')->join('proyecto','proyecto.idproyecto','=','code.proyecto')->where('code.proyecto',$idproyecto)->where('proyecto.estado',1)->where('code.estado',1)->count();
        return $numero+1;
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
    public function RetornarAnioProyecto($idproyecto)
    {
        $proyectos=Proyecto::select('anio')->where('idproyecto','=',$idproyecto)->where('estado','=',1)->first();
        return $proyectos->anio;
    }
    public function Cargar()
    {

        $clientes = Cliente::with(['persona'])->join('persona','persona.idpersona','=','cliente.idpersona')->where('persona.estado','=',1)->orderby('persona.nombre','asc')->get();
        $Documentos = Documento::select('iddocumento','nombre','abreviatura')->whereIn('iddocumento', [16,21,18,17,20,9,10,19,22])->where('estado','=',1)->orderby('nombre')->get();
        $proyectos = Proyecto::select('*')->where('estado','=',1)->orderby('nombre','asc')->get();
        $codes=Code::select('*')->where('estado','=','1')->with('trabajador')->get();
        return view('code',['clientes'=>$clientes,'documentos'=>$Documentos,'proyectos'=>$proyectos,'codes'=>$codes]);
    }
    function TraerProyectosxCliente(Request $request)
    {
        $cliente=Cliente::select('idpersona')->where('abreviatura',$request->idcliente)->where('estado',1)->first();
        $proyecto=Proyecto::select('idproyecto','nombre')->where('estado',1)->where('idcliente',$cliente->idpersona)->get();
        if (count($proyecto)>0) {
            echo "<option value='0' >Seleccionar Proyecto</option>";
            foreach ($proyecto as $row) {
                echo "<option value='$row->idproyecto' >$row->nombre</option>";
            }

        }else{
            echo "<option>Sin Proyectos</option>";
        }

    }
    public function ActualizarTabla(Request $request)
    {
        $codes=Code::select('*')->where('estado','=','1')->where('cliente',$request->idcliente)->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODE</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de registro</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
        </table>
    <?php }


    public function ActualizarTablaProyecto(Request $request)
    {
        $codes=Code::select('*')->where('estado','=','1')->where('cliente',$request->idcliente)->where('proyecto',$request->proyecto)->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODE</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de registro</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
        </table>
    <?php }


    public function ActualizarTablaDocumento(Request $request)
    {
        $codes=Code::select('*')->where('estado','=','1')->where('cliente',$request->idcliente)->where('documento',$request->documento)->where('proyecto',$request->proyecto)->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODE</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de registro</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
        </table>
    <?php }


    public function Actualizar(Request $request)
    {
        $cliente=$request->cliente;
        $documento=$request->documento;
        $anio=$this->RetornarAnioProyecto($request->proyecto);
        $abrevpro=$this->RetornarAbrePro($request->proyecto);
        $correlativo=$this->traercorr($request->proyecto);
        $codigo=$request->codigo;
        $codeee=Code::select('*')->where('idcode','=',$request->idcode)->first();

        $nombre=$documento."-".$codeee->correlativo."-".$abrevpro."-".$cliente."-".$anio;
        $actualizar=Code::where('idcode','=',$request->idcode)->update(['cliente'=>$cliente,'documento'=>$documento,'codigo'=>$codigo,'nombre'=>$nombre,'proyecto'=>$request->proyecto,'descripcion'=>$request->descripcion]);

        $codes=Code::select('*')->where('estado','=','1')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
        <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODEss</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de registro</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
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

        $actualizar=Code::where('idcode','=',$id)->update(['estado'=>0]);
        $codes=Code::select('*')->where('estado','=','1')->get();
        ?>
        <script type="text/javascript" src="/js/sc.js"></script>
         <table id="tablaCode" class="table table-striped table-bordered">
        <thead>
                                                <tr>
                                                    <th>Numero</th>
                                                    <th>CODE</th>
                                                    <th>descripcion</th>
                                                    <th>Usuario de registro</th>
                                                    <th>Fecha</th>
                                                    <th>Consultar</th>
                                                    <th>Eliminar</th>
                                                    <th style="display: none;">Expediente</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($codes)) { ?>
                                                <?php $i=1?>
                                                <?php foreach($codes as $row) { ?>
                                                <tr>

                                                    <td><?=$i?></td>
                                                    <td><?=$row->nombre?></td>
                                                    <td><?=$row->descripcion?></td>
                                                    <td><?=$row->trabajador ? $row->trabajador->usuario : ''?></td>
                                                    <td><?=date('Y-m-d', strtotime($row->fecha_registro))?></td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-pencil-square-o" onclick="TraerCode(<?=$row->idcode?>)" ></a>
                                                    </div>
                                                    </td>
                                                    <td>
                                                    <div class="opciones">
                                                        <a class="fa fa-trash" onclick="EliminarCode(<?=$row->idcode?>)"></a>
                                                    </div>
                                                    </td>
                                                    <td style="display: none;"><?=$row->codigo?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            <?php } ?>
                                            </tbody>
        </table>


        <?php

    }

}
