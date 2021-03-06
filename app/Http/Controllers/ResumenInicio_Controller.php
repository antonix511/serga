<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Documento_Controller;
use App\Http\Controllers\ProyectoController;
use App\Proyecto_doc_valida;

class ResumenInicio_Controller extends Controller
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

    public function resumeninicio($id){
        $objResumen=new ResumenProyecto_Controller();
        $objProyecto=new ProyectoController();


        //esto es para verificar si los documentos se han finalizado
        $actainicio=$objResumen->retornaActaInicioOK($id,1);
        $matrizcomu=$objResumen->retornaMatrizComuOK($id,2);
        $matrizrol=$objResumen->retornaMatrizRolOK($id,3);
        $reqlogist=$objResumen->retornaReqLogisOK($id,4);
        $reqcart=$objResumen->retornaReqCartOK($id,5);
        $matrizries=$objResumen->retornaMatrizRiesOK($id,15);
        $actareuc=$objResumen->retornaActaReuOK($id,12);
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);

        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        

        return view('inicio_resumen',['id'=>$id,'actainicio'=>$actainicio,'matrizcomu'=>$matrizcomu,'matrizrol'=>$matrizrol,
        'reqlogist'=>$reqlogist,'reqcart'=>$reqcart ,'nombreclave'=>$nombreclave,'matrizries'=>$matrizries,'actareuc'=>$actareuc,'doc_validados'=>$doc_validados]);
    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }
}
