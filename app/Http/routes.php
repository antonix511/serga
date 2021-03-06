<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


    Route::post('/', 'LoginController@validarLogin');

    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::group(['middleware' =>['auth']],function(){


    Route::get('/inicio', function () {
        return view('main-page');
    })->name('main-page');

    Route::get('/login', function () {
        return view('index');
    })->name('index');

    Route::get('/proyectos', function () {
        return view('proyectos');
    })->name('proyectos');

    // Route::get('/clientes', function () {
    //     return view('clientes');
    // })->name('clientes');

    Route::get('/seguimiento', function () {
        return view('seguimiento');
    })->name('seguimiento');

    Route::get('/seguimiento-proyectos', 'SeguimientoProyectosController@index')->name('seguimiento-proyectos');

    Route::get('listacentrocostos', function () {
        return view('listacentrocostos');
    })->name('listacentrocostos');


    Route::get('/com_gerentes', function () {
        return view('com_gerentes');
    })->name('com_gerentes');


    Route::get('/inicio_resumen', function () {
        return view('inicio_resumen');
    })->name('inicio_resumen');

    Route::get('/inicio_actainicio', function () {
        return view('inicio_actainicio');
    })->name('inicio_actainicio');

    Route::get('/inicio_matrizcomun', function () {
        return view('inicio_matrizcomun');
    })->name('inicio_matrizcomun');

    Route::get('/inicio_matrizrol', function () {
        return view('inicio_matrizrol');
    })->name('inicio_matrizrol');

    Route::get('/inicio_matrizriesgos', function () {
        return view('inicio_matrizriesgos');
    })->name('inicio_matrizriesgos');


    Route::get('/inicio_reqlogisti', function () {
        return view('inicio_reqlogisti');
    })->name('inicio_reqlogisti');

    Route::get('/inicio_reqcartog', function () {
        return view('inicio_reqcartog');
    })->name('inicio_reqcartog');

    Route::get('/ejecucion_resumen', function () {
        return view('ejecucion_resumen');
    })->name('ejecucion_resumen');

    Route::get('/ejecucion_acta', function () {
        return view('ejecucion_acta');
    })->name('ejecucion_acta');

    Route::get('/ejecucion_solicitudcam', function () {
        return view('ejecucion_solicitudcam');
    })->name('ejecucion_solicitudcam');

    Route::get('/ejecucion_acuerdo', function () {
        return view('ejecucion_acuerdo');
    })->name('ejecucion_acuerdo');

    Route::get('/ejecucion_reporte', function () {
        return view('ejecucion_reporte');
    })->name('ejecucion_reporte');

    Route::get('/ejecucion_solicitudac', function () {
        return view('ejecucion_solicitudac');
    })->name('ejecucion_solicitudac');

    Route::get('/ejecucion_modelos', function () {
        return view('ejecucion_modelos');
    })->name('ejecucion_modelos');

    Route::get('/cierre_resumen', function () {
        return view('cierre_resumen');
    })->name('cierre_resumen');

    Route::get('/cierre_actac', function () {
        return view('cierre_actac');
    })->name('cierre_actac');

    Route::get('/cierre_actar', function () {
        return view('cierre_actar');
    })->name('cierre_actar');

    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');
    Route::get('/busqueda', function () {
        return view('busqueda');
    })->name('busqueda');

    Route::get('/historial-seguimiento/{id}/dashboard', 'DashboardController@index')->name('dashboard');
    //RUTAS DE TODOS LOS DOCUMENOTS

      //Acta Cierre
    Route::resource('cierre/actacierre', 'ActaCierre_Cierre_Controller@ExportarExcel');
    //Comite Gerentes
    Route::get('inicio/com_gerentes/exportar/{id}', 'Comite_controller@Exportar');

    //para verificar los documentos en general
    Route::get('/resumen_proyecto/{id}','ResumenProyecto_Controller@resumenProyecto');
    //Configuración de documentos
    Route::post('/proyecto_doc_valida', 'ResumenProyecto_Controller@proyecto_doc_valida');

    //para verificar los documentos fase de inicio
    Route::get('/inicio_ventas/{id}','VentasInicio_Controller@CargarProyecto');
    Route::get('/inicio_resumen/{id}','ResumenInicio_Controller@resumeninicio');
    Route::get('/inicio_actainicio/{id}','Acta_inicioController@inicio_actainicio');
    Route::get('/inicio_matrizcomu/{id}','MatrizComu_Inicio_Controller@inicio_matrizcomu');
    Route::get('/inicio_matrizrol/{id}','MatrizRoles_Inicio_Controller@inicio_matrizrol');
    Route::get('/inicio_matrizriesgos/{id}','MatrizRiesgos_Inicio_Controller@inicio_matrizriesgos');

    Route::get('/inicio_reqlogisti/{id}','ReqLogistica_Inicio_Controller@inicio_reqlogisti')->name('reqlogostocainicio');
    Route::get('/inicio_reqcartog/{id}','ReqCartografia_Inicio_Controller@inicio_reqcartog');

    Route::get('/ejecucion_resumen/{id}','ResumenEjecucion_Controller@ejecucion_resumen');
    Route::get('/ejecucion_acta/{id}','ActaReu_Ejecucion_Controller@ejecucion_acta');
    Route::get('/ejecucion_solicitudcam/{id}','SolicitudCambio_Ejecucion_Controller@ejecucion_solicitudcam');
    Route::get('/ejecucion_acuerdo/{id}','ActaAcuerdo_Ejecucion_Controller@ejecucion_acuerdo');
    Route::get('/ejecucion_reporte/{id}','ReporteHo_Ejecucion_Controller@ejecucion_reporte');
    Route::get('/ejecucion_solicitudac/{id}','SolicitudAc_Ejecucion_Controller@ejecucion_solicitudac');
    Route::get('/ejecucion_modelos/{id}','Modelos_Ejecucion_Controller@ejecucion_modelos');
    Route::get('/plantillas/{id}','Plantillas_Ejecucion_Controller@plantillas');

    Route::get('/cierre_resumen/{id}','ResumenCierre_Controller@cierre_resumen');
    Route::get('/cierre_actac/{id}','ActaCierre_Cierre_Controller@cierre_actac');
    Route::get('/cierre_actar/{id}','ActaReunion_Cierre_Controller@cierre_actar');

    Route::get('/seguimiento-proyectos/{id}', 'HistorialSeguimientoController@listar');

    //para cargar desde el comienzo
    Route::get('clientes', 'Cliente_Controller@listarClientes');
    Route::get('servicio', 'Servicio_Controller@CargarTabla');
    Route::get('trabajadores', 'TrabajadorController@CargarCombos');
    Route::get('modelos', 'Modelos_Ejecucion_Controller@FormularioModelos');
    // Route::get('/trabajador', 'TrabajadorController@listarTrabajadores');
    Route::get('proyectos', 'ProyectoController@CargarCombos');
    Route::get('seguimiento', 'ProyectoController@listarProyectos');
    Route::get('listacentrocostos', 'ProyectoController@listarProyectosCentro');
    Route::get('busqueda', 'ProyectoController@listarProyectosBusqueda');
    Route::get('privilegios', 'Privilegio_Controller@CargarPrivilegio');
    Route::get('firmascentrocostos', 'FirmaCentroCostos_Controller@CargarFirmas');
    Route::get('code', 'Code_Controller@Cargar');
    Route::get('areas', 'Area_Controller@CargarAreas');
    Route::get('TipProyecto', 'TipoProyecto_Controller@CargarTipos');
    Route::get('TipContrato', 'TipoContrato_Controller@CargarContratos');
    Route::get('EquipCarto', 'EquipoCarto_Controller@CargarEquipos');
    Route::get('ListProyectos', 'ListaProyecto_Controller@listarproyectos');
    Route::get('/cerrarsesion', 'LoginController@Cerrarsesion')->name('cerrarsesion');

    //RUTAS DE AJAX
    Route::get('/inicio/actainicio/exportar/{id}', 'Acta_inicioController@Exportar');
    Route::get('/ajax/cargar-detalle-historial/{id}', 'HistorialSeguimientoController@CargarAjax');
    Route::post('/ajax/proyecto', 'ProyectoController@CargarAjax');
    Route::post('/ajax/seguimiento-proyecto', 'ProyectoController@CargarSeguimientoProyectos');
    Route::post('/ajax/seguimiento-proyecto-filter', 'SeguimientoProyectosController@cargarSeguimientosFilter');
    Route::get('/ajax/data-dashboard/{nroSeguimiento}/{intervalo}', 'DashboardController@cargarAjax');
    Route::post('/ajax/historial-seguimiento/{id}', 'HistorialSeguimientoController@guardarHistorial');
//    Route::post('/ajax/historial-seguimiento', 'HistorialSeguimientoController@guardarHistorial');
    Route::post('/ajax/centro', 'Centrodecostos_Controller@CargarAjax');
    Route::post('/ajax/modelotipo', 'Modelos_Ejecucion_Controller@MostrarModelos');
    //para inicio
    Route::post('/ajax/actainicio', 'Acta_inicioController@CargarAjax');
    Route::post('/ajax/matrizcomuinicio', 'MatrizComu_Inicio_Controller@CargarAjax');
    Route::post('/ajax/matrizrolesinicio', 'MatrizRoles_Inicio_Controller@CargarAjax');
    Route::post('/ajax/matrizriesgos', 'MatrizRiesgos_Inicio_Controller@CargarAjax');
    Route::post('/ajax/reqlogisinicio', 'ReqLogistica_Inicio_Controller@CargarAjax');
    Route::post('/ajax/reqcartinicio', 'ReqCartografia_Inicio_Controller@CargarAjax');
    Route::post('/ajax/reporteho', 'ReporteHo_Ejecucion_Controller@CargarAjax');
    Route::post('/ajax/solicitudac', 'SolicitudAc_Ejecucion_Controller@CargarAjax');

    Route::get('consultar_acta_cierre/{id}','ActaCierre_Cierre_Controller@consultar_acta_cierre');
    //Comite Gerentes

    Route::resource('comit/gerentes', 'Comite_controller@CargarComite');
    Route::resource('acta/gerentes', 'ActaReunion_Cierre_Controller@acta_menu');
    Route::resource('comite/guardar', 'Comite_controller');
    Route::resource('comite_participantes/guardar', 'Comite_controller@GuardarParticipante');
    Route::resource('comite_participantes/eliminar', 'Comite_controller@EliminarParticipante');
    Route::resource('comite_firma/cargo', 'Comite_controller@MostrarCargo');
    Route::resource('comite_firma/notificar', 'Comite_controller@NotificarFirmas');
    Route::resource('comite_firma/agregar', 'Comite_controller@AgregarFirma');
    Route::resource('comite_firma/eliminar', 'Comite_controller@EliminarFirma');
    Route::resource('comite_firma_notificada/eliminar', 'Comite_controller@EliminarFirmaNotificada');

    Route::resource('centro_costos/notificar', 'Centrodecostos_Controller@NotificarPersonas');

    //cliente
    Route::post('/ajax/updatecliente/{id}', 'Cliente_Controller@updatecliente');
    Route::post('/ajax/deletecliente/{id}', 'Cliente_Controller@deletecliente');

    //firmas
    Route::post('/ajax/deletefirma/{id}', 'Acta_inicioController@deletefirma');
    //servicio
    Route::post('/ajax/deleteservicio/{id}', 'Servicio_Controller@deleteservicio');
    Route::post('/ajax/updateservicios/{id}','Servicio_Controller@updateservicio');

    //reLogistica
    Route::resource('reqlog/controller', 'ReqLogistica_Inicio_Controller');
    Route::resource('reqlog/controller/actualizar', 'ReqLogistica_Inicio_Controller@ActualizarReqLogistica');

    //reLogistica_dettale
    Route::post('reqlog_detalle/controller', 'ReqLogistica_Inicio_Controller@insertar_detalle');
    Route::resource('reqlog_detalle/actualizar', 'ReqLogistica_Inicio_Controller@actualizar_detalle');
    Route::resource('reqlog_detalle/eliminar', 'ReqLogistica_Inicio_Controller@eliminar_detalle');
    Route::resource('consult_reqlog_detalle/controller', 'ReqLogistica_Inicio_Controller@TraerDetalle');

    //reCartografia
    Route::resource('reqcarto/controller', 'ReqCartografia_Inicio_Controller');
    Route::resource('reqcarto/controller/actualizar', 'ReqCartografia_Inicio_Controller@ActualizarReqCarto');

    //reCartografia_dettale
    Route::resource('reqcarto_detalle/controller', 'ReqCartografia_Inicio_Controller@insertar_detalle');
    Route::resource('reqcarto_detalle/eliminar', 'ReqCartografia_Inicio_Controller@eliminar_detalle');
    Route::resource('consult_carto_detalle/controller', 'ReqCartografia_Inicio_Controller@traer_detalle');
    Route::post('actualizar_cartografia_equipo', 'ReqCartografia_Inicio_Controller@ActualizarEquipoCarto');

    //Acta Reunion
    Route::resource('actareu_ejecucion/controller', 'ActaReu_Ejecucion_Controller');
    Route::resource('actareu_ejecucion/actualizar', 'ActaReu_Ejecucion_Controller@ActualizarActa');
    Route::resource('actareu_ejecucion/firmas', 'ActaReu_Ejecucion_Controller@AgregarFirmas');
    Route::resource('actareu_ejecucion/notificarfirmas', 'ActaReu_Ejecucion_Controller@NotificarFirmas');
    Route::resource('actareu_ejecucion/notificarfirmas_menu', 'ActaReu_Ejecucion_Controller@NotificarFirmas_menu');
    Route::resource('actareu_ejecucion/actualizarfirmas', 'ActaReu_Ejecucion_Controller@ActualizarFirmas');
    Route::resource('actareu_ejecucion/actualizarnotificados', 'ActaReu_Ejecucion_Controller@ActualizarNotificados');
    Route::resource('actareu_ejecucion/actualizarnotificados_menu', 'ActaReu_Ejecucion_Controller@ActualizarNotificados_menu');
    //ACTA CIERRE

    Route::resource('actareu_cierre/actualizar', 'ActaReunion_Cierre_Controller@ActualizarActa');
    //Acta Acuerdo

    Route::resource('actaacu_ejecucion/actualizaracta', 'ActaAcuerdo_Ejecucion_Controller@ActualizarActa');
    Route::resource('actaacu_ejecucion/controller', 'ActaAcuerdo_Ejecucion_Controller');
    Route::resource('actaacuerdo_detalle/controller', 'ActaAcuerdo_Ejecucion_Controller@insertar_detalle');
    Route::resource('actaacuerdo_detalle/actualizar', 'ActaAcuerdo_Ejecucion_Controller@actualizar_detalle');
    Route::resource('acuerdo_programacion/eliminar', 'ActaAcuerdo_Ejecucion_Controller@eliminar_programacion');
    Route::resource('acuerdo_programacion/controller', 'ActaAcuerdo_Ejecucion_Controller@traer_programacion');

    //Solicitud Cambio
    Route::resource('ejecucion_solicitudcam/controller','SolicitudCambio_Ejecucion_Controller');
    Route::resource('ejecucion_solicitudcam/actualizarsolicitud','SolicitudCambio_Ejecucion_Controller@ActualizarSolicitud');
    Route::post('cliente_proyecto/traer', 'Code_Controller@TraerProyectosxCliente');




    //Acta Cierre
    Route::resource('actacierre/controller','ActaCierre_Cierre_Controller');
    Route::resource('actacierre/actualizar','ActaCierre_Cierre_Controller@ActualizarActa');
    Route::resource('actacierre/agregarentregable','ActaCierre_Cierre_Controller@AgregarEntregable');
    Route::resource('actacierre/actualizarentregable','ActaCierre_Cierre_Controller@ActualizarEntregable');
    Route::resource('actacierre/agregarleccion','ActaCierre_Cierre_Controller@AgregarLeccion');
    Route::resource('cliente/controller', 'Cliente_Controller');
    //resource
    Route::resource('equipcarto/controller', 'EquipoCarto_Controller');
    Route::resource('trabajador/controller', 'TrabajadorController');

    Route::resource('servicio/controller', 'Servicio_Controller');
    Route::resource('proyecto/controller', 'ProyectoController');
    Route::resource('inicio/actainicio/guardar', 'Acta_inicioController@guardar');
    Route::resource('inicio_actualiza/actainicio', 'Acta_inicioController@ActualizarActa');
    Route::resource('inicio/matrizrol', 'Matriz_rolesController');
    Route::resource('inicio/actainicio/equipo', 'Equipo_trabajadorController');

    //trabajador
    Route::post('/ajax/deletetrabajador/{id}', 'TrabajadorController@deletetrabajador');
    Route::post('/ajax/updatetrabajador/{id}', 'TrabajadorController@updatetrabajador');

    //Privilegio
    Route::resource('privilegio/guardar', 'Privilegio_Controller@guardar');
    Route::resource('privilegio/actualizar', 'Privilegio_Controller@actualizar');
    Route::resource('privilegio/eliminar', 'Privilegio_Controller@eliminar');
    Route::resource('privilegio/controller', 'Privilegio_Controller');
    //EXPORTAR EXCEL
        //Info Proyecto
    Route::resource('info/infoproyecto', 'VentasInicio_Controller@ExportarExcel');

        //Acta Inicio

        //ReqLogistica
    Route::resource('reqlogis/exportareq', 'ReqLogistica_Inicio_Controller@ExportarExcel');
    //ReqCarto
    Route::resource('reqcarto/exportareq', 'ReqCartografia_Inicio_Controller@ExportarExcel');
    //EXPORTAR WORD
        //Solicitud Cambio
    Route::resource('solcam/exportarsolcam', 'SolicitudCambio_Ejecucion_Controller@ExportarWord');
        //Acta Reunion EJECUCION
    Route::resource('/actareu/exportaractareu', 'ActaReu_Ejecucion_Controller@ExportarWord');
        //Acta Reunion CIERRE
    Route::resource('actareucierre/exportaractareu', 'ActaReunion_Cierre_Controller@ExportarWord');
        //Acta Reunion MENU
    Route::resource('actareumenu/exportaractareu', 'ActaReunion_Cierre_Controller@ExportarWord_Menu');
        //Acta Acuerdo
    Route::resource('actaacu/exportaractaacu', 'ActaAcuerdo_Ejecucion_Controller@ExportarWord');





    Route::resource('pdf/total', 'PdfController@PDF');

    //Firmas
    Route::post('firmas/aprobar', 'FirmaCentroCostos_Controller@AprobarFirma');
    Route::post('firmas/desaprobar', 'FirmaCentroCostos_Controller@DesaprobarFirma');
    Route::post('firmas_comite/aprobar', 'FirmaCentroCostos_Controller@AprobarFirma_Comite');
    Route::post('firmas_comite/desaprobar', 'FirmaCentroCostos_Controller@DesaprobarFirma_Comite');

    //CODE

    Route::resource('code/guardar', 'Code_Controller');
    Route::resource('code/controller', 'Code_Controller');
    Route::resource('code/actualizar', 'Code_Controller@Actualizar');
    Route::post('/code/eliminar/{id}', 'Code_Controller@Eliminar');
    Route::post('cliente_proyecto/proyecto_tablas', 'Code_Controller@ActualizarTabla');
    Route::post('proyecto_proyecto/proyecto_tablas', 'Code_Controller@ActualizarTablaProyecto');
    Route::post('documento_proyecto/proyecto_tablas', 'Code_Controller@ActualizarTablaDocumento');

    //AREAS

    Route::resource('area/guardar', 'Area_Controller');
    Route::resource('/area/controller', 'Area_Controller');
    Route::resource('area/actualizar', 'Area_Controller@Actualizar');
    Route::post('/area/eliminar/{id}', 'Area_Controller@Eliminar');

    //TIPO PROYECTO

    Route::resource('tippro/guardar', 'TipoProyecto_Controller');
    Route::resource('/tippro/controller', 'TipoProyecto_Controller');
    Route::resource('tippro/actualizar', 'TipoProyecto_Controller@Actualizar');
    Route::post('/tippro/eliminar/{id}', 'TipoProyecto_Controller@Eliminar');

    //TIPO CONTRATO

    Route::resource('tipcon/guardar', 'TipoContrato_Controller');
    Route::resource('/tipcon/controller', 'TipoContrato_Controller');
    Route::resource('tipcon/actualizar', 'TipoContrato_Controller@Actualizar');
    Route::post('/tipcon/eliminar/{id}', 'TipoContrato_Controller@Eliminar');


    //EQUIPOS CARTOGRAFIA

    Route::resource('equipcarto/guardar', 'EquipoCarto_Controller');

    Route::resource('equipcarto/actualizar', 'EquipoCarto_Controller@Actualizar');
    Route::post('/equipcarto/eliminar/{id}', 'EquipoCarto_Controller@Eliminar');





    // rutas para la modificacion -> ver doc registrados  y agregar doc








    Route::post('comite/actualizar/{id}','Comite_controller@Actualizar');
    Route::get('tabla/{id}','Comite_controller@tabla');


     //EDITAR PROYECTO
    Route::get('/proyecto/editar/{id}', 'VentasInicio_Controller@editarproyecto');
    Route::post('/listaproyecto/editarinfo/{id}', 'VentasInicio_Controller@editar_info_proyecto');
    //Modelos
    Route::get('/firmas_actainicio/{id}', 'ResumenProyecto_Controller@inicio_actainicio');
    //Reunoin
    Route::get('/firmas_actareunion/{id}', 'ActaReunion_Cierre_Controller@acta_menu_firmas');
    //Comite
    Route::get('/firmas_actacomite/{id}', 'Comite_controller@mostrar_acta_firmas');

    Route::resource('modelos/insertar', 'Modelos_Ejecucion_Controller');
      //LISTA PROYECTOS
    Route::post('/listaproyecto/eliminar/{id}', 'ListaProyecto_Controller@eliminarproyecto');


    Route::post('id_firmas/{id}','ActaReunion_Cierre_Controller@id_firmas');

     Route::post('/datos_Doc/{id}', 'ActaReunion_Cierre_Controller@datos_Doc');
     Route::post('lista_programacion/{id}','ActaAcuerdo_Ejecucion_Controller@tabladeprogramacion');
      Route::get('tabla_actualizada/{id}','ActaAcuerdo_Ejecucion_Controller@tabla_actualizada');


       Route::post('ultimo_id','ActaAcuerdo_Ejecucion_Controller@ultimo_id');
    Route::post('ultimi_id_reu/{id}','ActaReunion_Cierre_Controller@ultimi_id_reu');
    Route::post('datos_doc_acta_acuerdo/{id}','ActaAcuerdo_Ejecucion_Controller@lista_acuerdo');
    Route::post('tabla_ejecu_acta_reu/{id}','ActaReu_Ejecucion_Controller@tabla_ejecu_acta_reu');
    Route::post('firmas/{id}','ActaReunion_Cierre_Controller@firmas');
    Route::post('ultimi_id/{id}','ActaReunion_Cierre_Controller@ultimi_id');


    Route::get('tabla_documentos/{id}','ActaReunion_Cierre_Controller@tabla_documentos');
    Route::post('lista_solicitud/{id}','SolicitudCambio_Ejecucion_Controller@lista_solicitud');
    Route::post('firmas_solicitud/{id}','SolicitudCambio_Ejecucion_Controller@firmas_solicitud');
    Route::post('tabla_solicitudcam/{id}','SolicitudCambio_Ejecucion_Controller@tabla_solicitudcam');
    Route::get('reporte_ho/{id}','ReporteHo_Ejecucion_Controller@reporte_ho');
    Route::get('reporte_sa/{id}','SolicitudAc_Ejecucion_Controller@reporte_sa');
    Route::post('req_cartografia/{id}','ReqCartografia_Inicio_Controller@req_cartografia');
    Route::post('tabla_equipo_carto/{id}','ReqCartografia_Inicio_Controller@tabla_equipo_carto');
    Route::post('id_cartografia/{id}','ReqCartografia_Inicio_Controller@id_cartografia');
    Route::post('id_cartografia2/{id}','ReqCartografia_Inicio_Controller@id_cartografia2');
    Route::get('tabla_requistrado_carto/{id}','ReqCartografia_Inicio_Controller@tabla_requistrado_carto');
    Route::post('req_logistica/{id}','ReqLogistica_Inicio_Controller@req_logistica');
    Route::post('tabla_req_logistica/{id}','ReqLogistica_Inicio_Controller@tabla_req_logistica');
    Route::post('tabla_registro_logis/{id}','ReqLogistica_Inicio_Controller@tabla_registro_logis');
    Route::post('id_req_logistica/{id}','ReqLogistica_Inicio_Controller@id_req_logistica');
    Route::post('logistica/{id}','ReqLogistica_Inicio_Controller@logistica');
    Route::resource('acta_comite','Comite_controller@acta_comite');

     Route::post('eliminar_acta_cierre/{id}','ActaCierre_Cierre_Controller@eliminar_acta_cierre');
    Route::post('consultar/{id}','Comite_controller@consultar');
    Route::post('consultar_tabla/{id}','Comite_controller@consultar_tabla');
    Route::post('consultar_firmas/{table}/{id}','Comite_controller@consultar_firmas');




    Route::resource('prueba','Prueba_Controller@index');


});
