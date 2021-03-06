<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Persona;
use App\Cliente;

class Cliente_Controller extends Controller
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
      $persona = Persona::create($request->all());
      $cliente = new Cliente($request->all());
      $persona->cliente()->save($cliente);
      DB::commit();

      $clientes = Cliente::where('cliente.estado',1)->join('persona','persona.idpersona','=','cliente.idpersona')->orderBy('persona.nombre','asc')->get();
      return view('cliente_tabla', ['clientes'=>$clientes]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::with(['persona'])->find($id);
        //trae datos de la tabla clientes que tengan relacion con la tabla personas cuando el idcliente es igual a  $id;
        return $cliente->toJson();
        //retorna los daton en toJson para que sea interpretado por .js;
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
    public function retornarCliente($id)
    {
      $cliente = Cliente::where('idcliente',$id)->first();
      //dd($clientes);  //    ---->   dd remplaza al echo o var_dump en php
      return $cliente;
    }
    public function listarClientes()
    {
        session_start();
        $usuario=$_SESSION['usuario'];
        $objComite=new Comite_controller();
        $DataUsuario=$objComite->CargarUsuario($usuario);
        $modulos=$objComite->CargarModulos($DataUsuario->idprivilegio);
        foreach ($modulos as $row) {
            if ($row->modulos->ruta=="clientes") {
              $clientes = Cliente::where('cliente.estado',1)->join('persona','persona.idpersona','=','cliente.idpersona')->orderBy('persona.nombre','asc')->get();
              //dd($clientes);  //    ---->   dd remplaza al echo o var_dump en php
              return view('clientes', ['clientes'=>$clientes]);
            }
        }
        ?>
      <script type="text/javascript">
        alert("Usted no Tiene permitido el acceso a este modulo");
        window.location.href='/inicio';
      </script>
      <?php
    }

    public function updatecliente(Request $request, $id)
    {
      // dd($request->all());
        $persona = persona::where('idpersona',$id)->update(['nombre'=>$request->nombre,'correo'=>$request->correo,'telefono'=>$request->telefono,'direccion'=>$request->direccion]);
        $cliente = Cliente::where('idpersona', $id)->update(['ruc'=>$request->ruc,'abreviatura'=>$request->abreviatura,'contacto'=>$request->contacto]);
        $clientes = Cliente::where('cliente.estado',1)->join('persona','persona.idpersona','=','cliente.idpersona')->orderBy('persona.nombre','asc')->get();
        return view('cliente_tabla', ['clientes'=>$clientes]);
    }
    public function deletecliente($id)
    {
      // dd($request->all());
        $persona = persona::where('idpersona',$id)->update(['estado'=>'0']);
        $cliente = Cliente::where('idpersona', $id)->update(['estado'=>'0']);
        $clientes =Cliente::where('cliente.estado',1)->join('persona','persona.idpersona','=','cliente.idpersona')->orderBy('persona.nombre','asc')->get();
        return view('cliente_tabla', ['clientes'=>$clientes]);
    }
}
