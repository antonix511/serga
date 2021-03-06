<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Servicio;
use DB;

class Servicio_Controller extends Controller
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
        $existe=Servicio::where('estado',1)->where('nombre',$request->nombre)->first();
        if(empty($existe)){
        DB::beginTransaction();
        $servicios=Servicio::create($request->all());
        $servicios->save();
        DB::commit();

      $servicios = Servicio::where('estado','=','1')->orderby('nombre','asc')->get();
      return view('servicio_tabla', ['servicios'=>$servicios]);
        }else{
         $existe=Servicio::where('estazxczxczcxdo',1)->where('nombre',$request->nombre)->first();
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
        $servicios=Servicio::where('idservicio',$id)->orderBy('idservicio','desc')->first();

        return $servicios->toJson();
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
    public function cargarServicio(){
        $servicios = Servicio::where('estado','=','1')->orderby('nombre','asc')->get();
        return $servicios;
    }


    public function CargarTabla ()
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="servicio") {
                $servicios=$this->cargarServicio();       
                return view('servicio', ['servicios' => $servicios]);
            }
        }
         ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php
    }

     public function updateservicio(Request $request, $id)
    {
      // dd($request->all());
        $servicio = Servicio::where('idservicio', $id)->update(['nombre'=>$request->nombre,'abreviatura'=>$request->abreviatura]);
        $servicios = Servicio::where('estado','=','1')->orderby('nombre','asc')->get();
        return view('servicio_tabla', ['servicios'=>$servicios]);
    }
    public function deleteservicio($id)
    {
      // dd($request->all());
        $servicio = Servicio::where('idservicio', $id)->update(['estado'=>'0']);
        $servicios = Servicio::where('estado','=','1')->orderby('nombre','asc')->get();
        return view('servicio_tabla', ['servicios'=>$servicios]);
    }
}
