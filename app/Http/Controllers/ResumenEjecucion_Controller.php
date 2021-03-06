<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proyecto_doc_valida;

class ResumenEjecucion_Controller extends Controller
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

    public function ejecucion_resumen($id){
        $objResumen=new ResumenProyecto_Controller();
        $objProyecto=new ProyectoController();

        $actareunion=$objResumen->retornaActaReuOK($id,6);
        $solcambio=$objResumen->retornaSolCambioOK($id,7);
        $actaacuerdo=$objResumen->retornaActaAcuerdoOK($id,8);
        $reportho=$objResumen->retornaReporteHoOK($id,9);
        $solac=$objResumen->retornaSolAcOK($id,9);
        $nombreclave=$objProyecto->retronarNombreClaveProyecto($id);
        
        $doc_valida = Proyecto_doc_valida::where('idproyecto', '=', $id)->select('iddocumento', 'valida')->get()->toArray();
        $doc_validados = [];
        foreach ($doc_valida as $kdoc => $vdoc) {
            $doc_validados[$vdoc['iddocumento']] = $vdoc['valida'];
        }

        return view('ejecucion_resumen',['id'=>$id,'actareunion'=>$actareunion,'solcambio'=>$solcambio,
        'actaacuerdo'=>$actaacuerdo,'reportho'=>$reportho,'solac'=>$solac ,'nombreclave'=>$nombreclave,'doc_validados'=>$doc_validados]);
    }

    public function CargarAjax(Request $request){
        $ObjTrabajador=new TrabajadorController();
        if($request->op=="1"){

        }else if($request->op=="2"){

        }else if($request->op=="3"){

        }
    }


}
