// function GuardarFormatosxProyecto(idproyecto, fases) {
//   var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
//   formData.append('formFormatos',idproyecto);
//   var formatos =  $('#formFormatos-'+idproyecto);
//   console.log(fases);
//   console.log(formatos);
//     var token = $('input[name=_token]').val();
//     $.ajax({
//       url: "/proyecto/formatos",//url
//       type: "post",//tipo post
//       dataType: "html",
//       data:formData,
//       cache: false,
//       headers: {'X-CSRF-TOKEN':token},
//       //contentType: false,
//       //processData: false,
//       success:function(data){
//         var acuerdo = JSON.parse(data);
//         console.log(acuerdo);
//         console.log(acuerdo.actividad);
//         $('textarea[name=actividad]').val(acuerdo.actividad);
//         $('input[name=fecha]').val(acuerdo.fecha);
//         $("#idprogra").val(acuerdo.idactaacuerdodet);
//     },
//     error:function (data){
//           swal("Error", "Error.", "error");
//     }
//
//     });
// }

function gen_NuevaActa(nacta){
  var res = nacta.split("-");
  var n = Number(res[res.length-1])+1;
  var nacata1 = "";
  for (var i = 0; i < res.length - 1; i++) {
    nacata1 += ((nacata1!="")?"-":"") + res[i];
  }
  nacata1 += "-"+n;
  return nacata1;
}

function NotificarTodasPersonas(idproyecto) {
  swal({
    title: "¿Está seguro de notificar Centro de Costos?",
    text: "Confirme notificacion",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idproyecto',idproyecto);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/centro_costos/notificar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $("#TablaNotificadoCosto").html(data);
        swal("Enviado!", "Notificados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function ConsultarProgramacionAcuerdo(id) {
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idactaacuerdodet',id);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/acuerdo_programacion/controller",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        var acuerdo = JSON.parse(data);
        console.log(acuerdo);
        console.log(acuerdo.actividad);
        $('textarea[name=actividad]').val(acuerdo.actividad);
        $('input[name=fecha]').val(acuerdo.fecha);
        $("#idprogra").val(acuerdo.idactaacuerdodet);
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });
}
function EliminarProgramacionAcuerdo(id) {
  swal({
    title: "¿Está seguro de eliminar la programación?",
    text: "Confirme eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var numero_acta=$("#cliente").val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idactaacuerdodet',id);
  formData.append('numero_acta',numero_acta);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/acuerdo_programacion/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $("#TableAgregaProgramacion").html(data);
        console.log(data);
        swal("Enviado!", "Datos eliminados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function exportateexcedeM(id) {
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('id',id);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/reqcarto/exportareq",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
       swal("Exportado!", "Exitoso.", "success");
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });
}
function ConsultarEquipCartografia(id) {
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idreqcartodeta',id);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/consult_carto_detalle/controller",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        var areacar = JSON.parse(data);
        console.log(areacar);
        $('input[name=cantidad]').val(areacar.cantidad);
        $('input[name=fecha_devolucion]').val(areacar.fecha_devolucion);
        $('#idequipo option:contains('+areacar.equipo.nombre+')').prop('selected',true);
        $('textarea[name=observaciones]').val(areacar.observaciones).jqteVal(areacar.observaciones);
        $("#detalle_carto").val(id);
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });
}

function EliminarEquipCartografia(id) {
  swal({
    title: "¿Está seguro de eliminar el equipo de cartografia?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var idreqcartografia=$("#idreqcartografia").val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idreqcartodeta',id);
  formData.append('idreqcartografia',idreqcartografia);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/reqcarto_detalle/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $("#tablecartografiaequipo").html(data);
        console.log(data);
        swal("Enviado!", "Datos eliminados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function ConsultarEquipLogistica(id) {
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idreqlogisdeta',id);
    var token = $('input[name=_token]').val();
    console.log(token);
    formData.append('_token',token);
    $.ajax({
      url: "/consult_reqlog_detalle/controller",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        var areareq = JSON.parse(data);
        console.log(areareq);
        $('input[name=cantidad]').val(areareq.cantidad);
        $('input[name=opcion]').val(id);
        $('textarea[name=descripcion]').val(areareq.descripcion);
        $('#idlogistica option:contains('+areareq.logistica.nombre+')').prop('selected',true);
        $('#idunidad option:contains('+areareq.unidad.nombre+')').prop('selected',true);
        $('#idpersona option:contains('+areareq.persona.nombre+')').prop('selected',true);
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });
}

function EliminarEquipLogistica(id) {
  swal({
    title: "¿Está seguro de eliminar el área?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var idreqlogis=$("#idreqlogis").val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idreqlogisdeta',id);
  formData.append('idreqlogis',idreqlogis);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/reqlog_detalle/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //$("#tablelogisti").empty();
        $("#tablelogisti").html(data);
        console.log(data);
        swal("Enviado!", "Datos eliminados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}

function EliminarParticipantesComite(id) {
  var idcomite = $('#idcomite').val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idparticipante',id);
  formData.append('idcomite',idcomite);
    var token = $('input[name=_token]').val();
  swal({
    title: "¿Está seguro de eliminar a este participante?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    // console.log(token);
    $.ajax({
      url: "/comite_participantes/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data: formData,//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        $("#TableComiteGerentes").html(data);
        swal("Enviado!", "Se eliminó al participante Correctamente .", "success");

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function EliminarFirmaComite(id){
  var token = $('input[name=_token]').val();
  swal({
    title: "¿Está seguro eliminar?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idfirma',id);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/comite_firma/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //alert(data);
        $("#resultadoagregarfirmantescomite").html(data);
        swal("Enviado!", "Datos registrados correctamente.", "success");


      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}

function EliminarFirmaComiteNNotificada(id){
  var token = $('input[name=_token]').val();
  var idcomite = $('#idcomite').val();
  swal({
    title: "¿Está seguro eliminar?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idfirma',id);
  formData.append('idcomite',idcomite);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/comite_firma_notificada/eliminar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //alert(data);
        $("#TablaNotificadosComite").html(data);
        swal("Enviado!", "Datos registrados correctamente.", "success");


      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function BotonCancelarActas() {
  swal({
    title: "¿Está seguro de Cancelar?",
    text: "Confirme la cancelacion",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    window.location.href='/inicio';
  });
}

function traer_Datos_clientes(id) {
  $.ajax({
    url: "/cliente/controller/"+id,
    type: "get",
    success:function(data){
        var cliente = JSON.parse(data);
        console.log(cliente);
        $('input[name=opcion]').val("2");
        $('input[name=id]').val(cliente.persona.idpersona);
        $('input[name=ruc]').val(cliente.ruc);
        $('input[name=nombre]').val(cliente.persona.nombre);
        $('input[name=abreviatura]').val(cliente.abreviatura);
        $('input[name=contacto]').val(cliente.contacto);
        $('input[name=correo]').val(cliente.persona.correo);
        $('input[name=telefono]').val(cliente.persona.telefono);
        $('input[name=direccion]').val(cliente.persona.direccion);
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
};

function limpiar_Campos_clientes() {
        $('input[name=opcion]').val("1");
};



function eliminar_Datos_clientes(id){
    swal({
    title: "¿Está seguro de eliminar al cliente seleccionado?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/ajax/deletecliente/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Datos del cliente eliminados correctamente.", "success");
        $('#myTable').DataTable().destroy();
        $('#myTable').html(data);
        $('#myTable').DataTable();
        nuevo_trabajador();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
};

/*  datos de trabajadores */

function traer_Datos_trabajador(id) {
    var token = $('input[name=_token]').val();
  $.ajax({
      url: "/trabajador/controller/"+id,
      type: "get",
      dataType: "html",
      //headers: {'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    success:function(data){
        var trabajador = JSON.parse(data);
        console.log(trabajador);
        TraerPrivilegio(trabajador.idprivilegio);
        $('input[name=opcion]').val("2");
        $('input[name=abreviatura]').val(trabajador.abreviatura);
        $('input[name=id]').val(trabajador.persona.idpersona);
        $('input[name=dni]').val(trabajador.dni);
        $('input[name=nombre]').val(trabajador.persona.nombre);
        $('input[name=apellidos]').val(trabajador.apellidos);
        $('input[name=correo]').val(trabajador.persona.correo);
        $('input[name=telefono]').val(trabajador.persona.telefono);
        $('input[name=direccion]').val(trabajador.persona.direccion);
        $('select option:contains('+trabajador.area.nombre+')').prop('selected',true);
        $('select option:contains('+trabajador.puesto.nombre+')').prop('selected',true);
        $('input[name=usuario]').val(trabajador.usuario);
        $('input[name=clave]').val(trabajador.clave);
        var url=window.location.origin;
        $('#list').html('<img src="'+url+'/documentos/trabajador/'+trabajador.foto+'" alt="">');
        $('#list2').html('<img src="'+url+'/documentos/trabajador/'+trabajador.firma+'" alt="" style="height:198px;">');

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
};
function limpiar_Campos_trabajador() {
        $('input[name=opcion]').val("1");
        $("#list").empty();
        $("#list2").empty();
};

function eliminar_Datos_trabajador(id){
    swal({
    title: "¿Está seguro de eliminar al trabajador seleccionado?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/ajax/deletetrabajador/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Datos del trabajador eliminados correctamente.", "success");
          $('#tabletrabajadores').DataTable().destroy();
          $('#divtrabajadores').html(data);
          $('#tabletrabajadores').DataTable();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
};

/*  datos de servicio */

function traer_Datos_servicio(id) {
  $.ajax({
    url: "/servicio/controller/"+id,
    type: "get",
    success:function(data){
       var servicio = JSON.parse(data);
        console.log(servicio);
        $('input[name=opcion]').val("2");
        $('input[name=id]').val(servicio.idservicio);
        $('input[name=nombre]').val(servicio.nombre);
        $('input[name=abreviatura]').val(servicio.abreviatura);
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
};
function limpiar_Campos_servicio() {
        $('input[name=opcion]').val("1");
};

function eliminar_Datos_servicio(id){
    swal({
    title: "¿Está seguro de eliminar al servicio seleccionado?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/ajax/deleteservicio/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Datos del servicio eliminados correctamente.", "success");
          $('#tableservicios').DataTable().destroy();
          $('#tableservicios').html(data);
          $('#tableservicios').DataTable();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
};

function ActualizarCentroDeCosto(idproyecto){
  var centrodecosto=$("#centrodecosto").val();
  var observacion=$("#observacion").val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
    formData.append('idproyecto',idproyecto);
    formData.append('op',3);
    formData.append('centrodecosto',centrodecosto);
    formData.append('observacion',observacion);
    swal({
    title: "¡Seguro de Modifcar Centro de Costo?",
    text: "Confirme la actualizacion",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    // console.log(token);
    console.log(idproyecto);
    $.ajax({
      url: "/ajax/centro",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        swal("Actualizado!", "Datos del centro de costos cargados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}

$(document).ready(function() {

$("#idcliente").change(function() {
      var idcliente = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:1,idcliente:idcliente},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente

      $("#abreviatura_campo").attr("value",data);
      }
      });
    });

$("#iddepartamento").change(function() {
      var iddepartamento = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:7,iddepartamento:iddepartamento},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente

      $("#provincia").html(data);
      }
      });
    });


$("#idprovincia").change(function() {
      var idprovincia = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:8,idprovincia:idprovincia},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente

      $("#distrito").html(data);
      }
      });
    });



$("#idservicio").change(function() {
  console.log('holi');
  var idservicio = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
    //alert(idcliente);
      $.ajax({//envio por ajax
        type:'post',//tipo post
        url:'/ajax/proyecto',//archivo donde llegan los datos
        data:{op:3,idservicio:idservicio},//opcion 1 es para consultar grados
        success:function(data){//si se ejecuto correctamente
          console.log(data);
          $("#abreviaturaservicio").attr("value",data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
          var clave = $('#abreviatura_campo').val();
          // var code = $('#code').val();
          clave = clave.split('-');
          clave[3] = data;
          var nombre
          if (typeof clave[4] != 'undefined') {
            nombre = clave[0]+'-'+clave[1]+'-'+clave[2]+'-'+clave[3]+'-'+clave[4];
          }else {
            nombre = clave[0]+'-'+clave[1]+'-'+clave[2]+'-'+clave[3];
          }
          // console.log(nombre);
          $('#abreviatura_campo').val(nombre);
          $('#code').val(nombre);
        }
      });
    });

// LPLP
  $("#icliente").change(function() {
    var idcliente = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
    //alert(idcliente);
    $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:1,idcliente:idcliente},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
        // console.log(data);
        // console.log($('#abreviatura_campo').val());
        var clave = $('#abreviatura_campo').val();
        // var code = $('#code').val();
        clave = clave.split('-');
        clave[1] = data;
        if (typeof clave[4] != 'undefined') {
          nombre = clave[0]+'-'+clave[1]+'-'+clave[2]+'-'+clave[3]+'-'+clave[4];
        }else {
          nombre = clave[0]+'-'+clave[1]+'-'+clave[2]+'-'+clave[3];
        }
        // console.log(nombre);
        $('#abreviatura_campo').val(nombre);
        $('#code').val(nombre);
        $("#correonotifica").attr("value",data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });
  });

$("#idtrabajador").change(function() {
  var idtrabajador = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
    //alert(idcliente);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:4,idtrabajador:idtrabajador},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
        var objData = data.split("||");
      $("#correonotifica").attr("value",((objData[0])?objData[0]:''));
      $("#celnotifica").attr("value",((objData[1])?objData[1]:''));
      }
      });

    });


$("#idtrabajador2").change(function() {
  var idtrabajador2 = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
    //alert(idcliente);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:9,idtrabajador2:idtrabajador2},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
        var objData = data.split("||");
      $("#correonotifica2").attr("value",((objData[0])?objData[0]:''));
      $("#celnotifica2").attr("value",((objData[1])?objData[1]:''));
      }
      });

    });

//para actas

$("#equipotrabajo").change(function() {

  var equipotrabajo = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
   //alert(equipotrabajo);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:6,equipotrabajo:equipotrabajo},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#cargarpuesto").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      }
      });

    });
//para matriz de comunicacion
$("#interesado").change(function() {

  var interesado = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
   //alert(equipotrabajo);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:8,interesado:interesado},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#cargarpuesto").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      }
      });

    });




/*envio del formulario por post con ajax*/
$("#formtrabajador").on("submit",function (e){//se mpregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar

   e.preventDefault();//no se
   var f = $(this);//tampoco se

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formtrabajador"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto

    $.ajax({//envia por ajax
    url: "/trabajador/controller",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
         // $("#resultado").html(data);//aqui se muestra el resultado
          swal("Enviado!", "Datos registrados correctamente.", "success");
          nuevo_trabajador();
          limpiar_Campos_trabajador();
          $('#list2').html(' ');
            $('#list').html(' ');
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
});

/* funciones de los clientes */

$("#formcliente").on("submit",function (e){//se pregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar

   e.preventDefault();//previene que recarge la pagina
   var f = $(this);//tampoco se
var opcion = $('input[name=opcion]').val();
var id = $('input[name=id]').val();
if(opcion == "1"){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formcliente"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto


    $.ajax({//envia por ajax
    url: "/cliente/controller",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos registrados correctamente.", "success");
          document.getElementById("formcliente").reset();
          $('input[name=opcion]').val("1");
          $('#myTable').DataTable().destroy();
          $('#myTable').html(data);
          $('#myTable').DataTable();
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}else if (opcion == "2") {
  swal({
  title: "Actualizar",
  text: "Confirme la actualizacion",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formcliente"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto
  console.log(formData);

    $.ajax({//envia por ajax
    url: "/ajax/updatecliente/"+id,//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos actualizados correctamente.", "success");
          document.getElementById("formcliente").reset();
          $('input[name=opcion]').val("1");
          $('#myTable').DataTable().destroy();
          $('#myTable').html(data);
          $('#myTable').DataTable();
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}
});




/* funciones de los clientes */

$("#formtrabajador").on("submit",function (e){//se pregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar

   e.preventDefault();//previene que recarge la pagina
   var f = $(this);//tampoco se
var opcion = $('input[name=opcion]').val();
var id = $('input[name=id]').val();
if(opcion == "1"){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formtrabajador"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto


    $.ajax({//envia por ajax
    url: "/trabajador/controller",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos registrados correctamente.", "success");
          document.getElementById("formtrabajador").reset();
          $('input[name=opcion]').val("1");

          $('#tabletrabajadores').DataTable().destroy();
          $('#divtrabajadores').html(data);
          $('#tabletrabajadores').DataTable();
          $('#list2').html(' ');
          $('#list').html(' ');
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}else if (opcion == "2") {
  swal({
  title: "Actualizar",
  text: "Confirme la actualizacion",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formtrabajador"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto
  console.log(formData);

    $.ajax({//envia por ajax
    url: "/ajax/updatetrabajador/"+id,//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos actualizados correctamente.", "success");
          document.getElementById("formtrabajador").reset();
          $('input[name=opcion]').val("1");
          $('#tabletrabajadores').DataTable().destroy();
          $('#divtrabajadores').html(data);
          $('#tabletrabajadores').DataTable();
          $('#list2').html(' ');
          $('#list').html(' ');
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}
});





/* funciones de los servicios */

$("#formservicio").on("submit",function (e){//se pregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar

   e.preventDefault();//previene que recarge la pagina
   var f = $(this);//tampoco se
var opcion = $('input[name=opcion]').val();
var id = $('input[name=id]').val();
if(opcion == "1"){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formservicio"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto


    $.ajax({//envia por ajax
    url: "/servicio/controller",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos registrados correctamente.", "success");
          document.getElementById("formservicio").reset();
          $('input[name=opcion]').val("1");
          $('#tableservicios').DataTable().destroy();
          $('#tableservicios').html(data);
          $('#tableservicios').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}else if (opcion == "2") {
  swal({
  title: "Actualizar",
  text: "Confirme la actualizacion",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

  var formData= new FormData(document.getElementById("formservicio"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto
  console.log(formData);

    $.ajax({//envia por ajax
    url: "/ajax/updateservicios/"+id,//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal("Enviado!", "Datos actualizados correctamente.", "success");
          document.getElementById("formservicio").reset();
          $('input[name=opcion]').val("1");
          $('#tableservicios').DataTable().destroy();
          $('#tableservicios').html(data);
          $('#tableservicios').DataTable();
    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

    });


});
}
});





/*  funciones de los proyectos */

$("#formproyectos").on("submit",function (e){//se mpregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar
  e.preventDefault();//no se
  var f = $(this);//tampoco se
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
  var formData= new FormData(document.getElementById("formproyectos"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto

    $.ajax({//envia por ajax
    url: "/proyecto/controller",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){
          swal({
            title: "Enviado",
            text: "Datos registrados correctamente.",
            type: "success",
            closeOnConfirm: false
          },
          function(){
            window.location.replace("/seguimiento");
          });
         // swal("Enviado!", "Datos registrados correctamente.", "success");

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });


});

});










});

function guardarSeguimiento() {
  var comentario = $("#seguimientoComentario").val();
  var fileCostos = $("#seguimientoCostos")[0].files[0];
  var fileCostosName = fileCostos.name;
  var fileCostosSize = fileCostos.size;
  var id = $('#seguimiento-historia-id').val();
  var it = $('#seguimiento-historia-it').val();

  var formData = new FormData();

  formData.append("comentario", comentario);
  formData.append("file_costos", fileCostos);
  formData.append("iteracion", it);

  swal(
    {
      title: "Guardar",
      text: "Confirme el guardado",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    },
    function () {
      $.ajax({
        url: "/ajax/historial-seguimiento/" + id,
        type: "post",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function () {
          swal("Enviado!", "Datos registrados correctamente", "success");
          location.reload();
        },
        error: function () {
          swal("Error", "error", "error");
        }
      });
    }
  );
}

function guardarCronograma () {
  var f = $(this);//tampoco se
  var op = $("#op").val();
  var version = $("#version").val();
  var idproyecto = $("#idproyecto").val();
  var nroInt = $("#nroIntervalos").val();
  var nroTareas = $("#nroTareas").val();
  var nroDias = $("#nroDias").val();
  var vpFile = $("#vpFile")[0].files[0];
  var vpFileName = vpFile.name;
  var vpFileSize = vpFile.size;
  var file = $("#file")[0].files[0];
  var fileName = file.name;
  var fileSize = file.size;

  var formData = new FormData();

  formData.append("op", op);
  formData.append("version", version);
  formData.append("idproyecto", idproyecto);
  formData.append("file", file);
  formData.append('vp_file', vpFile);
  formData.append("nro_intervalos", nroInt);
  formData.append("nro_tareas", nroTareas);
  formData.append("nro_dias", nroDias);

  // TEMPORAL
  formData.append("idestado_cro", 1);

  swal({
    title: "Guardar",
    text: "Confirme el guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function () {
    $.ajax({//envia por ajax
      url: "/ajax/actainicio",//url
      type: "post",//tipo post
      dataType: "html",
      data: formData,//se manda con todo por la foto
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){
        swal("Enviado!", "Datos registrados correctamente.", "success");
        $("#resultadocrono").html(data);
      },
      error:function (data){
        swal("Error", "Error.", "error");
      }
    });
  });
}




function guadarMatrizComu(){
  //con este metodo estamos guardando los archivos en un directorio

  var f = $(this);//tampoco se
  var op = $("#op").val();
  var idproyecto=$("#idproyecto").val();
  var fecha=$("#fecha").val();
  var accion=$("#accion").val();
  var descripcion=$("#descripcion").val();
  var file = $("#file")[0].files[0];
  console.log(file);
  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();

  formData.append("op", op);
  formData.append("idproyecto", idproyecto);
  formData.append("fecha", fecha);
  formData.append("file", file);
  formData.append("accion", accion);
  formData.append("descripcion", descripcion);

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
  function(){

    $.ajax({//envia por ajax
    url: "/ajax/matrizcomuinicio",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

    swal("Enviado!", "Datos guardados correctamente", "success");

    $("#resultadomatrizcomu").html(data);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});

}


function guadarMatrizRol(){
  //con este metodo estamos guardando los archivos en un directorio

  var f = $(this);//tampoco se
  var op = $("#op").val();
  var idproyecto=$("#idproyecto").val();
  var fecha=$("#fecha").val();
  var descripcion=$("#descripcion").val();
  var accion=$("#accion").val();
  var file = $("#file")[0].files[0];

  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();

  formData.append("op", op);
  formData.append("idproyecto", idproyecto);
  formData.append("fecha", fecha);
  formData.append("file", file);
  formData.append("accion", accion);
  formData.append("descripcion", descripcion);

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
  function(){

    $.ajax({//envia por ajax
    url: "/ajax/matrizrolesinicio",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

    swal("Enviado!", "Datos guardados correctamente", "success");

    $("#resultadomatrizresol").html(data);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});

}

function guardarMatrizRiesgos(){
  //con este metodo estamos guardando los archivos en un directorio

  var f = $(this);//tampoco se
  var op = $("#op").val();
  var idproyecto=$("#idproyecto").val();
  var fecha=$("#fecha").val();
  var descripcion=$("#descripcion").val();
  var accion=$("#accion").val();
  var file = $("#file")[0].files[0];

  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();

  formData.append("op", op);
  formData.append("idproyecto", idproyecto);
  formData.append("fecha", fecha);
  formData.append("file", file);
  formData.append("accion", accion);
  formData.append("descripcion", descripcion);

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
  function(){

    $.ajax({//envia por ajax
    url: "/ajax/matrizriesgos",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

    swal("Enviado!", "Datos guardados correctamente", "success");

    $("#resultadomatrizriesgos").html(data);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});

}


function centrocostos(idproyecto){
  console.log(idproyecto);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/centro',//archivo donde llegan los datos
      data:{op:1,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#notificar").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });
}


function listarProyectos(){

  var fase = document.getElementById("fase").value;
  var fechainicio = document.getElementById("fechainicio").value;
  var fechafin = document.getElementById("fechafin").value;
   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:5,fase:fase,fechainicio:fechainicio,fechafin:fechafin},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#listaproyectos").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });

}


function listarProyectos2(){
  var fase = document.getElementById("fase").value;
  var fechainicio = document.getElementById("fechainicio").value;
  var fechafin = document.getElementById("fechafin").value;

  $('#myTable').dataTable().fnDestroy();
  $('#myTable tbody').html('<tr><td colspan="'+$('#myTable thead th').length+'" align="center" class="text-center">Cargando...</td></tr>');
  
  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:10,fase:fase,fechainicio:fechainicio,fechafin:fechafin},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#listaproyectos").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });
}

function listarSeguimientos() {
  var fase = document.getElementById("fase").value;
  var fecha_inicio = document.getElementById("fechainicio").value;
  var fecha_fin = document.getElementById("fechafin").value;
  var vc = document.getElementById("vc").value;
  var vs = document.getElementById("vs").value;

  $('#seguimientoTable').dataTable().fnDestroy();
  $('#seguimientoTable tbody').html('<tr><td colspan="' + $('#seguimientoTable thead th').length + '" align="center" class="text-center">Cargando...</td></td></tr>')

  $.ajax({
    type: 'post',
    url: '/ajax/seguimiento-proyecto',
    data: {op: 10, fase: 0, fechainicio: '', fechafin: '', vc: 0, vs: 0 },
    success: function (data) {
      $("#listSeguimientoProyecto").html(data);
    }
  });
}

function listarSeguimientosFilter() {
  var fase = document.getElementById("fase").value;
  var fecha_inicio = document.getElementById("fechainicio").value;
  var fecha_fin = document.getElementById("fechafin").value;
  var vc = document.getElementById("vc").value;
  var vs = document.getElementById("vs").value;

  $('#seguimientoTable').dataTable().fnDestroy();
  $('#seguimientoTable tbody').html('<tr><td colspan="' + $('#seguimientoTable thead th').length + '" align="center" class="text-center">Cargando...</td></td></tr>')

  $.ajax({
    type: 'post',
    url: '/ajax/seguimiento-proyecto-filter',
    data: {fase: fase, fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, vc: vc, vs: vs },
    success: function (data) {
      $("#listSeguimientoProyecto").html(data);
    }
  });
}


function actualizarfirma(){
  var idproyecto = document.getElementById("idproyecto").value;
  var personaacta = document.getElementById("personaacta").value;
  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:9,idproyecto:idproyecto,personaacta:personaacta},//opcion 1 es para consultar grados

      success:function(data){//si se ejecuto correctamente
      $("#resultadoagregarfirmantes").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

}
function actualizarnotificados(){
  var idproyecto = document.getElementById("idproyecto").value;
  var personaacta = document.getElementById("personaacta").value;
  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:10,idproyecto:idproyecto,personaacta:personaacta},//opcion 1 es para consultar grados

      success:function(data){//si se ejecuto correctamente
      $("#myTable3").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

}


function enviarCorreos(){

   swal({
  title: "Notificar",
  text: "Desea notificar por correo",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

    var idproyecto = document.getElementById("idproyecto").value;
   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:7,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente

      $("#resupestanotificar").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      actualizarfirma();
      actualizarnotificados();

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});



}



function nuevo_trabajador(){

  document.getElementById("formtrabajador").reset();//limpiuando todos los campos
  //$('#imgInp').attr('src','images/g.png');
  document.getElementById("dni").focus();//focus

}

 function archivo(evt) {
                  var files = evt.target.files; // FileList object

                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);

                    reader.readAsDataURL(f);
                  }
              }
              if (document.getElementById('files')) {
                document.getElementById('files').addEventListener('change', archivo, false);
              }
//

function archivo2(evt) {
                  var files2 = evt.target.files; // FileList object

                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files2[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list2").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                        };
                    })(f);

                    reader.readAsDataURL(f);
                  }
              }
              if(document.getElementById('files2')){
document.getElementById('files2').addEventListener('change', archivo2, false);
              }




//ACTA INICIO

function registrarEquipo(){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){

    var idproyecto = document.getElementById("idproyecto").value;
    var idtrabajador = document.getElementById("equipotrabajo").value;
   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:1,idproyecto:idproyecto,idtrabajador:idtrabajador,accion:1,idequipox:0},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoequipo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      $('#equipotrabajo option:contains(-Seleccione un trabajador-)').prop('selected',true);
      $("#puesto").html("<option>seleccione un trabajador</option>");
      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}

function eliminarequipo(idequipox){

 swal({
  title: "Desasignar",
  text: "Confirme la desasignación",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
  var idproyecto = document.getElementById("idproyecto").value;
    var idtrabajador = document.getElementById("equipotrabajo").value;

   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:1,idproyecto:idproyecto,idtrabajador:idtrabajador,idequipox:idequipox,accion:2},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoequipo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}

function eliminarCronograma(idcrono){
 swal({
  title: "Eliminar",
  text: "Confirme la eliminación del cronograma",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
  var idproyecto = document.getElementById("idproyecto").value;

   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:8,idcrono:idcrono,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadocrono").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}




function guardarMatrizcomu(){


  var accion = $("#accion").val();

  if(accion==1){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
    var idproyecto = document.getElementById("idproyecto").value;
    var fecha = document.getElementById("fecha").value;

   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:17,idproyecto:idproyecto,fecha:fecha},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoguardarmatrizcomu").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      swal("Enviado!", "Datos registrados correctamente.", "success");
      },
      error:function (data){
          swal("Error", "Error.", "error");
      }

    });
});

}else if(accion==2){

  alert("actualizacion en desarrollo");
}
}

function registroEntregable(){

   var nombreentregable = document.getElementById("nombreentregable").value;

  if(nombreentregable ==""){
     swal("Error", "El campo no puede estar vacío", "error");
  }else{

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
    var idproyecto = document.getElementById("idproyecto").value;
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:2,idproyecto:idproyecto,nombreentregable:nombreentregable,accion:1,identregable:0},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoentregables").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      limpiarEntregable();
      },
      error:function (data){
          swal("Error", "Error.", "error");
      }

    });
});

    }

}

function eliminarEntregable(identregable){
  swal({
  title: "Eliminar",
  text: "Confirme la eliminación",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
    var idproyecto = document.getElementById("idproyecto").value;
    var nombreentregable = document.getElementById("nombreentregable").value;

   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:2,idproyecto:idproyecto,nombreentregable:nombreentregable,accion:2,identregable:identregable},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoentregables").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      },
      error:function (data){
          swal("Error", "Error.", "error");
      }

    });
});



}

function eliminarfirma(id,idproyecto){
  var iddocumento=$("#iddocumento").val();
  var idacta=$("#idacta").val();
  console.log(id);
  swal({
    title: "¿Está seguro de eliminar al firmante seleccionado?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var formData= new FormData(document.getElementById("Formelima"));
    formData.append('idproyecto',idproyecto);
    formData.append('iddocumento',iddocumento);
    formData.append('idacta',idacta);
    formData.append('id',id);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    // console.log(token);
    $.ajax({
      url: "/ajax/deletefirma/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: formData,//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        $("#resultadoagregarfirmantes").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
        swal("Eliminado!", "Firma  eliminada correctamente.", "success");

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}



function agregarFirmantes(){
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
    var idproyecto = document.getElementById("idproyecto").value;
    var personaacta = document.getElementById("personaacta").value;

   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:5,idproyecto:idproyecto,personaacta:personaacta},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoagregarfirmantes").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      swal("Enviado!", "Datos registrados correctamente.", "success");
      $('#area option:contains(-Seleccione un area-)').prop('selected',true);
      $("#personaacta").html("<option>-Seleccione una persona-</option>");
      $("#cargo").html("<option>-Seleccione un cargo-</option>");
      },
      error:function (data){
          swal("Error", "Error.", "error");
      }

    });

});

}


function limpiarEntregable(){
document.getElementById("nombreentregable").value="";
}







$("#area").change(function() {
  var idarea = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
    //alert(idarea);

      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:3,idarea:idarea},//opcion 1 es para consultar grados

      success:function(data){//si se ejecuto correctamente
      $("#cargarpersona").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

    });

$("#personaacta").change(function() {

  var idtrabajador = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
  //alert(idtrabajador);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:4,idtrabajador:idtrabajador},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#cargarcargo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

    });

//COSTOS
$("#trabajadorcostos").change(function() {

      var idtrabajador = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/centro',//archivo donde llegan los datos
      data:{op:2,idtrabajador:idtrabajador},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#correo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

    });


//validaciones

function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8,37,39,46];

    tecla_especial = false;
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        }
    }

    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}

// SUJETO A BONOS

$("#bono").change(function() {

  var idbono = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
  //alert(idtrabajador);
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/actainicio',//archivo donde llegan los datos
      data:{op:11,idbono:idbono},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#opsujbono").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

    });


// Requerimiento Logistica

function guardarReqLogis(id){


  var observacion=$("#observacion").val();
  var accion=$("#accion").val();

if (accion==1) {

    swal({
        title: "¿Está seguro de guardar los datos?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("formreqlogi"));//se crea el formato de datos, para enio de archivos y datos
      formData.append("dato", "valor");//colocar esto
      formData.append("observacion", observacion);//colocar esto
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        var accion=$("#accion").val('2');
        console.log(token);
        $.ajax({
          url: "/reqlog/controller",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqlogis").val(data);
            document.getElementById("btnAgregar").disabled=false;
            document.getElementById("idlogistica").disabled=false;
            document.getElementById("cantidad").disabled=false;
            document.getElementById("idunidad").disabled=false;
            document.getElementById("descripcion").disabled=false;
            document.getElementById("idpersona").disabled=false;
            document.getElementById("ExportarReqLogis").disabled=false;
            swal("Enviado!", "Datos registrados correctamente.", "success");
            var idproyecto = $('#idproyecto').val();
            $.ajax({
              url: "/tabla_registro_logis/"+idproyecto,//url
              type: "post",//tipo post
              dataType: "html",
              data:{idproyecto:idproyecto, _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success:function(data){
                $("#tabla_req_logistica").html(data);
              }
            })
          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });

}else{

    swal({
        title: "¿Está seguro de actualizar los datos?",
        text: "Confirme actualizado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("formreqlogi"));//se crea el formato de datos, para enio de archivos y datos
      formData.append("dato", "valor");//colocar esto
      formData.append("observacion", observacion);//colocar esto
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/reqlog/controller/actualizar",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqlogis").val(data);
            swal("Enviado!", "Datos registrados correctamente.", "success");
          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });

}

}

function agregarArea(id){
var opcion=$("#opcion").val();
if(opcion==0){
        swal({
            title: "¿Está seguro de ingresar el área?",
            text: "Confirme guardado",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){
            var idreqlogis=$("#idreqlogis").val();
            var idlogistica=$("#idlogistica").val();
            var cantidad=$("#cantidad").val();
            var idunidad=$("#idunidad").val();
            var descripcion=$("#descripcion").val();
            var idpersona=$("#idpersona").val();
          var formData= new FormData(document.getElementById("formreqarea"));//se crea el formato de datos, para enio de archivos y datos
          formData.append("dato", "valor");//colocar esto
          formData.append("cantidad", cantidad);//colocar esto
          formData.append("idunidad", idunidad);//colocar esto
          formData.append("descripcion", descripcion);//colocar esto
          formData.append("idlogistica", idlogistica);//colocar esto
          formData.append("idpersona", idpersona);//colocar esto
            var token = $('input[name=_token]').val();
            console.log(token);
            var nrequerimiento = $('#nrequerimiento').val();
            console.log(nrequerimiento);
            $.ajax({
              url: "/id_req_logistica/"+nrequerimiento,//url
              type: "post",//tipo post
              dataType: "html",
              data:{nrequerimiento:nrequerimiento, _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success:function(data){
                var datos = JSON.parse(data);
                formData.append('_token',token);
                formData.append("idreqlogis", datos["idreqlogis"]);//colocar esto
                $.ajax({
                  url: "/reqlog_detalle/controller",//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){
                    //$("#tablelogisti").empty();
                    $('#idlogistica option:contains(-Seleccione una Opción-)').prop('selected',true);
                    $("#cantidad").val("");
                    $('#idunidad option:contains(-Seleccione una Opción-)').prop('selected',true);
                    $("#descripcion").val("");
                    $('#idpersona option:contains(-Seleccione un Trabajador-)').prop('selected',true);
                    $("#tablelogisti").html(data);
                    console.log(data);
                    swal("Enviado!", "Datos registrados correctamente.", "success");

                  },
                  error:function (data){
                        swal("Error", "Error.", "error");
                  }

                });
              }
            })

          });
 }else{

  swal({
            title: "¿Está seguro de actualizar el área?",
            text: "Confirme guardado",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){
            var idreqlogis=$("#idreqlogis").val();
            var idlogistica=$("#idlogistica").val();
            var cantidad=$("#cantidad").val();
            var idunidad=$("#idunidad").val();
            var descripcion=$("#descripcion").val();
            var idpersona=$("#idpersona").val();
          var formData= new FormData(document.getElementById("formreqarea"));//se crea el formato de datos, para enio de archivos y datos
          formData.append("dato", "valor");//colocar esto
          formData.append("cantidad", cantidad);//colocar esto
          formData.append("idunidad", idunidad);//colocar esto
          formData.append("descripcion", descripcion);//colocar esto
          formData.append("idlogistica", idlogistica);//colocar esto
          formData.append("idpersona", idpersona);//colocar esto
          formData.append("idreqlogisdeta", opcion);//colocar esto
            var token = $('input[name=_token]').val();
            console.log(token);
            var nrequerimiento = $('#nrequerimiento').val();
            console.log(nrequerimiento);
            $.ajax({
              url: "/id_req_logistica/"+nrequerimiento,//url
              type: "post",//tipo post
              dataType: "html",
              data:{nrequerimiento:nrequerimiento, _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success:function(data){
                var datos = JSON.parse(data);
                formData.append('_token',token);
                formData.append("idreqlogis", datos["idreqlogis"]);//colocar esto
                $.ajax({
                  url: "/reqlog_detalle/actualizar",//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){
                    //$("#tablelogisti").empty();
                    $('#idlogistica option:contains(-Seleccione una Opción-)').prop('selected',true);
                    $("#cantidad").val("");
                    $('#idunidad option:contains(-Seleccione una Opción-)').prop('selected',true);
                    $("#descripcion").val("");
                    $('#idpersona option:contains(-Seleccione un Trabajador-)').prop('selected',true);
                    $("#tablelogisti").html(data);
                    $('input[name=opcion]').val(0);
                    console.log(data);
                    swal("Enviado!", "Datos registrados correctamente.", "success");

                  },
                  error:function (data){
                        swal("Error", "Error.", "error");
                  }

                });
              }
            })

          });

 }

}


// Requerimiento Cartografia

function guardarReqCarto(id){
  var fecha_entrega=$("#fecha_entrega").val();
  var accion=$("#accion").val();
  var numero_requerimiento = $('#numero_requerimiento').val();
  if (accion==1) {
      swal({
          title: "¿Está seguro de guardar los datos?",
          text: "Confirme guardado",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
        var formData= new FormData(document.getElementById("formreqcartografia"));//se crea el formato de datos, para enio de archivos y datos
        formData.append("dato", "valor");//colocar esto
        formData.append("fecha_entrega",fecha_entrega);
        formData.append("numero_requerimiento",numero_requerimiento);
        var accion=$("#accion").val('2');
          var token = $('input[name=_token]').val();
          formData.append('_token',token);
          // console.log(token);
          $.ajax({
            url: "/reqcarto/controller",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              //alert(data);
              $("#idreqcarto").val(data);
              document.getElementById("btnAgregarEquip").disabled=false;
              document.getElementById("observaciones").disabled=false;
              document.getElementById("idequipo").disabled=false;
              document.getElementById("fecha_devolucion").disabled=false;
              document.getElementById("cantidad").disabled=false;
              document.getElementById("ExportarReqCarto").disabled=false;
              swal("Enviado!", "Datos registrados correctamente.", "success");
              var idproyecto = $('#idproyecto').val();
              $.ajax({
                url: "/tabla_requistrado_carto/"+idproyecto,//url
                type: "post",//tipo post
                dataType: "html",
                data:{idproyecto:idproyecto, _token:token},
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                //contentType: false,
                //processData: false,
                success:function(data){
                    $("#tabla_cartografia").html(data);
                }
              })

            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });

    }else{

      swal({
          title: "¿Está seguro de actualizar los datos?",
          text: "Confirme actualizado",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
        var formData= new FormData(document.getElementById("formreqcartografia"));//se crea el formato de datos, para enio de archivos y datos
        formData.append("dato", "valor");//colocar esto
        formData.append("fecha_entrega",fecha_entrega);

          var token = $('input[name=_token]').val();
          formData.append('_token',token);
          console.log(token);
          $.ajax({
            url: "/reqcarto/controller/actualizar",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              //alert(data);
              $("#idreqcarto").val(data);
              swal("Enviado!", "Datos registrados correctamente.", "success");


            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });



    }
}

function agregarEquipoCarto(id){
var idreqcartografia=$("#idreqcartografia").val();
var detalle_carto=$("#detalle_carto").val();

if(detalle_carto==0){

        swal({
            title: "¿Está seguro de ingresar el área?",
            text: "Confirme guardado",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){
            var cantidad=$("#cantidad").val();
            var fecha_devolucion=$("#fecha_devolucion").val();
            var idequipo=$("#idequipo").val();
            var observaciones=$("#observaciones").val();

          var formData= new FormData(document.getElementById("formreqcartoequipo"));//se crea el formato de datos, para enio de archivos y datos
          formData.append("dato", "valor");//colocar esto
          formData.append("cantidad", cantidad);//colocar esto
          formData.append("fecha_devolucion", fecha_devolucion);//colocar esto
          formData.append("idequipo", idequipo);//colocar esto
          formData.append("observaciones", observaciones);//colocar esto
          formData.append("idreqcartografia", idreqcartografia);//colocar esto
          LimpiarCarto();
            var token = $('input[name=_token]').val();
            console.log(token);
            var numero_requerimiento = $('#numero_requerimiento').val();
            $.ajax({
              url: "/id_cartografia2/"+numero_requerimiento,//url
              type: "post",//tipo post
              dataType: "html",
              data:{numero_requerimiento:numero_requerimiento, _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success:function(data){
                var datos = JSON.parse(data);
                console.log(datos["idreqcartografia"]);
                formData.append("idreqcartografia", datos["idreqcartografia"]);//colocar esto
                formData.append('_token',token);
                LimpiarCarto();
                $.ajax({
                  url: "/reqcarto_detalle/controller",//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){
                    //$("#tablelogisti").empty();
                    $("#tablecartografiaequipo").html(data);
                    LimpiarCarto();
                    console.log(data);
                    swal("Enviado!", "Datos registrados correctamente.", "success");
                  },
                  error:function (data){
                        swal("Error", "Error.", "error");
                  }

                });
              }
            })

          });

}else{


  swal({
            title: "Actualizar",
            text: "Actualizacion",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){
            var cantidad=$("#cantidad").val();
            var fecha_devolucion=$("#fecha_devolucion").val();
            var idequipo=$("#idequipo").val();
            var observaciones=$("#observaciones").val();

          var formData= new FormData(document.getElementById("formreqcartoequipo"));//se crea el formato de datos, para enio de archivos y datos
          formData.append("dato", "valor");//colocar esto
          formData.append("cantidad", cantidad);//colocar esto
          formData.append("fecha_devolucion", fecha_devolucion);//colocar esto
          formData.append("idequipo", idequipo);//colocar esto
          formData.append("observaciones", observaciones);//colocar esto
          formData.append("idreqcartodeta",detalle_carto);
          formData.append("idreqcartografia", idreqcartografia);//colocar esto
            var token = $('input[name=_token]').val();
            formData.append('_token',token);
            console.log(token);
            var numero_requerimiento = $('#numero_requerimiento').val();
            $.ajax({
              url: "/actualizar_cartografia_equipo",//url
              type: "post",//tipo post
              dataType: "html",
              data:formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success:function(data){
                $("#tablecartografiaequipo").html(data);
                    console.log(data);
                    swal("Enviado!", "Datos registrados correctamente.", "success");
                     LimpiarCarto();
                     $("#detalle_carto").val(0);
              }
            })

          });

}

}



// Requerimiento Cartografia

function GuardarActaReunion(id){
var accion=$("#accion_guardar").val();
if (accion==1) {
      swal({
          title: "¿Está seguro de guardar los datos?",
          text: "Confirme guardado",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
        var formData= new FormData(document.getElementById("formActaReu"));//se crea el formato de datos, para enio de archivos y datos
        formData.append('iddocumento',6);
          var token = $('input[name=_token]').val();
          var accion=$("#accion_guardar").val('2');
          formData.append('_token',token);
          console.log(token);
          $.ajax({
            url: "/actareu_ejecucion/controller",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              //alert(data);
              var idproyecto = $('#idproyecto').val();
              $("#idreqcarto").val(data);
              swal("Enviado!", "Datos registrados correctamente.", "success");
              formData.append('_token',token);
              $.ajax({
                url: "/tabla_ejecu_acta_reu/"+idproyecto,//url
                type: "post",//tipo post
                dataType: "html",
                data:formData,
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){
                  $('#tabla2').html(data);
                }
              })

            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });

}else{

  swal({
          title: "¿Está seguro de actualizar los datos?",
          text: "Confirme actualizado",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
        var formData= new FormData(document.getElementById("formActaReu"));//se crea el formato de datos, para enio de archivos y datos
          var token = $('input[name=_token]').val();
          formData.append('_token',token);
          console.log(token);
          $.ajax({
            url: "/actareu_ejecucion/actualizar",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              //alert(data);
              swal("Enviado!", "Datos actualizar correctamente.", "success");


            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });

}

}
// Acta Acuerdo
function GuardarActaAcuerdo(id){
  var fecha1 = $('#fecha_hora_fecha').val();
  console.log(fecha1);
  var accion=$("#accion_guardar").val();
  console.log(accion);
  if(accion==1){
      var fecha_prox_reu=$("#fecha_prox_reu").val();
      var fecha=$("#fecha_hora_fecha").val();
      var hora=$("#fecha_hora_hora").val();
      var fecha_hora=fecha+" "+hora;
      // var numero_acta = $("#numero_acta").val();
    swal({
        title: "¿Está seguro de guardar los datos?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("formactaAcuerdo"));//se crea el formato de datos, para enio de archivos y datos
      formData.append('iddocumento',8);
      formData.append('fecha_hora',fecha_hora);
      formData.append('idproyecto',id);
      formData.append('fecha_prox_reu',fecha_prox_reu);
      var accion=$("#accion_guardar").val('2');
      // formData.append('numero_acta',numero_acta);
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/actaacu_ejecucion/controller",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqcarto").val(data);
            document.getElementById("AgregarProgramacionAcuerdo").disabled=false;
            document.getElementById("actividad").disabled=false;
            document.getElementById("fecha").disabled=false;
            document.getElementById("ExportarAcuerdo").disabled=false;
            swal("Enviado!", "Datos registrados correctamente.", "success");

            $.ajax({
              url: "/tabla_actualizada/"+id,//url
              type: "post",//tipo post
              dataType: "html",
              data:formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success:function(data){
                $('#tabla_acuerdo').html(data);
              }


            })

          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });
    }else{
      var fecha_prox_reu=$("#fecha_prox_reu").val();
      swal({
        title: "¿Está seguro de actualizar los datos?",
        text: "Confirme actualizacion",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("formactaAcuerdo"));//se crea el formato de datos, para enio de archivos y datos
        var token = $('input[name=_token]').val();
        formData.append('idproyecto',id);
        formData.append('fecha_prox_reu',fecha_prox_reu);
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/actaacu_ejecucion/actualizaracta",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqcarto").val(data);
            swal("Enviado!", "Datos actualizados correctamente.", "success");


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });

    }

}
function AgregarProgramacion(id){
  var idprogra=$("#idprogra").val();
  if(idprogra==0){
    swal({
        title: "¿Está seguro de ingresar la programación?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
        var idacta_acuerdo=$("#idacta_acuerdo").val();
        var numero_acta = $("#numero_acta").val();
        var fecha=$("#fecha").val();
        var actividad=$("#actividad").val();;
        var formData= new FormData(document.getElementById("formAgregarProgramacion"));//se crea el formato de datos, para enio de archivos y datos
        formData.append("idacta_acuerdo", idacta_acuerdo);//colocar esto
        formData.append("fecha", fecha);//colocar esto
        formData.append("actividad", actividad);//colocar esto
        formData.append("numero_acta",numero_acta);
        var token = $('input[name=_token]').val();
        console.log(token);
        formData.append('_token',token);
        $.ajax({
          url: "/actaacuerdo_detalle/controller",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //$("#tablelogisti").empty();
            $("#TableAgregaProgramacion").html(data);
            console.log(data);
            swal("Enviado!", "Datos registrados correctamente.", "success");
            $("#actividad").val("");
          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });
  }else{

    swal({
        title: "¿Está seguro de actualizar la programación?",
        text: "Confirme actualizacion",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
        var idacta_acuerdo=$("#idacta_acuerdo").val();
        var numero_acta = $("#numero_acta").val();
        var fecha=$("#fecha").val();
        var actividad=$("#actividad").val();;
        var formData= new FormData(document.getElementById("formAgregarProgramacion"));//se crea el formato de datos, para enio de archivos y datos
        formData.append("idacta_acuerdo", idacta_acuerdo);//colocar esto
        formData.append("fecha", fecha);//colocar esto
        formData.append("actividad", actividad);//colocar esto
        formData.append("numero_acta",numero_acta);
        formData.append('idactaacuerdodet',idprogra);
        var token = $('input[name=_token]').val();
        console.log(token);
        formData.append('_token',token);
        $.ajax({
          url: "/actaacuerdo_detalle/actualizar",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //$("#tablelogisti").empty();
          $('textarea[name=actividad]').val("");
          $('input[name=fecha]').val("");
            $("#idprogra").val(0);
            $("#TableAgregaProgramacion").html(data);
            console.log(data);
            $("#actividad").val("");
            swal("Enviado!", "Datos registrados correctamente.", "success");
          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });

  }


}
//SOLICITUD CAMBIO

function AgregarSolicitudCambio(id){
  var accion=$("#accion_guardar").val();
  var cargo=$("#acta_cargo").val();
if (accion==1) {
        swal({
            title: "¿Está seguro de ingresar la solicitud de cambio?",
            text: "Confirme guardado",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){

          var formData= new FormData(document.getElementById("formSolicitudCambio"));//se crea el formato de datos, para enio de archivos y datos
          var token = $('input[name=_token]').val();
          formData.set('cargo',cargo);
          formData.append('idproyecto',id);
          formData.append('_token',token);
            $("#accion_guardar").val('2');
            console.log(token);
            $.ajax({
              url: "/ejecucion_solicitudcam/controller",//url
              type: "post",//tipo post
              dataType: "html",
              data:formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success:function(data){
                //$("#tablelogisti").empty();
                $("#TableAgregaProgramacion").html(data);
                console.log(data);
                swal("Enviado!", "Datos registrados correctamente.", "success", function(confirma){
                  //document.location.reload()
                });
                recargar_pag();

                $.ajax({
                  url: "/tabla_solicitudcam/"+id,//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){
                    $('#tabla_solicitud').html(data);
                  }
                })
              },
              error:function (data){
                    swal("Error", "Error.", "error");
              }

            });
          });
  }else{
    swal({
            title: "¿Está seguro que desea actualizar la solicitud de cambio?",
            text: "Confirme sctualización",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
          },
          function(){

          var formData= new FormData(document.getElementById("formSolicitudCambio"));//se crea el formato de datos, para enio de archivos y datos
          var token = $('input[name=_token]').val();
          formData.set('cargo',cargo);
          formData.append('idproyecto',id);
          formData.append('_token',token);
            console.log(token);
            $.ajax({
              url: "/ejecucion_solicitudcam/actualizarsolicitud",//url
              type: "post",//tipo post
              dataType: "html",
              data:formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success:function(data){
                //$("#tablelogisti").empty();
                console.log(data);
                swal("Enviado!", "Datos actualizados correctamente.", "success", function(confirma){
                  
                });

                recargar_pag();
              },
              error:function (data){
                    swal("Error", "Error.", "error");
              }

            });
          });
  }

}

//Acta de Cierre

function GuardarActaCierre(id){
  var accion=$("#accion_guardar").val();

  if(accion==1){
      swal({
          title: "¿Está seguro de ingresar el acta de cierre?",
          text: "Confirme guardado",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){

        var formData= new FormData(document.getElementById("FormActaCierre"));//se crea el formato de datos, para enio de archivos y datos
        var token = $('input[name=_token]').val();
        formData.append('idproyecto',id);
        formData.append('_token',token);
          console.log(token);
          $.ajax({
            url: "/actacierre/controller",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
            document.getElementById("Entregables").disabled=false;
            document.getElementById("LeccionesAprendidas").disabled=false;
            document.getElementById("ParticipantesFirmas").disabled=false;
            document.getElementById("Exportar").disabled=false;
            swal("Enviado!", "Datos registrados correctamente.", "success");

            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });
  }else{

    swal({
          title: "¿Está seguro que desea actualizar el acta de cierre?",
          text: "Confirme actualización",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){

        var formData= new FormData(document.getElementById("FormActaCierre"));//se crea el formato de datos, para enio de archivos y datos
        var token = $('input[name=_token]').val();
        formData.append('idproyecto',id);
        formData.append('_token',token);
          console.log(token);
          $.ajax({
            url: "/actacierre/actualizar",//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              swal("Enviado!", "Datos actualizados correctamente.", "success");
            },
            error:function (data){
                  swal("Error", "Error.", "error");
            }

          });
        });

  }

}

function consultar_acta_cierre(id) {
  $.ajax({
    url: "/consultar_acta_cierre/"+id,
    type: "get",
    success:function(data){
        var entregable = JSON.parse(data);
        console.log(entregable);
        $("#nombreentregable").val(entregable.nombre);
        $("#accion").val(entregable.identregable);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}
function eliminar_acta_cierre($identregable) {
    swal({
          title: "¿Está seguro de Eliminar el entregable seleccionado?",
          text: "Confirme Eliminación",
          type: "info",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
          var formData= new FormData(document.getElementById("FormActaCierre"));//se crea el formato de datos, para enio de archivos y datos
          var token = $('input[name=_token]').val();
          console.log(token);
          formData.append('_token',token);
           $.ajax({
            url: "/eliminar_acta_cierre/"+$identregable,//url
            type: "post",//tipo post
            dataType: "html",
            data:formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success:function(data){
              swal("Enviado!", "Datos registrados correctamente.", "success");
              $('#TablaEntregablesCierre').html(data);


            }
          })
        });

}



        //ENTREGABLE
function AgregarEntregableCierre(id){
  var accion =$("#accion").val();
  var nombre=$("#nombreentregable").val();
  if(accion==0){
        swal({
                title: "¿Está seguro de ingresar el entregable?",
                text: "Confirme guardado",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
              },
              function(){

              var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
              var token = $('input[name=_token]').val();
              formData.append('idproyecto',id);
              formData.append('nombre',nombre);
              formData.append('iddocumento',12);
              formData.append('_token',token);
                console.log(token);
                $.ajax({
                  url: "/actacierre/agregarentregable",//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){

                    swal("Enviado!", "Datos actualizados correctamente.", "success");
                    $("#TablaEntregablesCierre").html(data);
                    $("#nombreentregable").val(" ");

                  },
                  error:function (data){
                        swal("Error", "Error.", "error");
                  }

                });
              });
  }else{
    swal({
                title: "Actualizar",
                text: "Confirme",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
              },
              function(){

              var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
              var token = $('input[name=_token]').val();
              formData.append('idproyecto',id);
              formData.append('nombre',nombre);
              formData.append('iddocumento',12);
              formData.append('identregable',accion);
              formData.append('_token',token);
                console.log(token);
                $.ajax({
                  url: "/actacierre/actualizarentregable",//url
                  type: "post",//tipo post
                  dataType: "html",
                  data:formData,
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
                  success:function(data){
                    $("#nombreentregable").val("");
                    $("#accion").val(0);
                    swal("Enviado!", "Datos registrados correctamente.", "success");
                    $("#TablaEntregablesCierre").html(data);
                    $("#nombreentregable").val(" ");

                  },
                  error:function (data){
                        swal("Error", "Error.", "error");
                  }

                });
              });
  }
}




          //LECCIONES
function AgregarLeccionCierre(id){

  var etapa=$("#etapa").val();
  var descripcion=$("#descripcion_leccion").val();
  var accion=$("#accion_leccion").val();
  var consecuencia=$("#consecuencia_leccion").val();
  var concepto=$("#concepto_leccion").val();
  console.log(descripcion);


    swal({
        title: "¿Está seguro de guardar la lección?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("FormActaReuCierre"));//se crea el formato de datos, para enio de archivos y datos
      formData.append('idproyecto',id);
      formData.append('descripcion',descripcion);
      formData.append('accion',accion);
      formData.append('consecuencia',consecuencia);
      formData.append('concepto',concepto);
      formData.append('etapa',etapa);
      formData.append('iddocumento',12);
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/actacierre/agregarleccion",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqcarto").val(data);
            swal("Enviado!", "Datos registrados correctamente.", "success");
            $("#TablaLeccionCierre").html(data);
          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });





  }




// Requerimiento Cartografia

function GuardarActaReunionCierre(id){
  var nacata=$("#pvad").val();
  var accion=$("#accion_guardar").val();
  console.log(id + '-'+accion+'-' + nacata);
  if (accion==1) {
    swal({
        title: "¿Está seguro de guardar los datos?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("FormActaReuCierre"));//se crea el formato de datos, para enio de archivos y datos
      formData.append('iddocumento',12);
      formData.append('nacata',nacata);
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        var idproyecto = $('#idproyecto').val();
        var accion=$("#accion_guardar").val('2');
        $.ajax({
          url: "/actareu_ejecucion/controller",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqcarto").val(data);
            swal("Enviado!", "Datos registrados correctamente.", "success");
            $.ajax({
              url: "/tabla_documentos/"+idproyecto,//url
              type: "post",//tipo post
              dataType: "html",
              data:{idproyecto:idproyecto, _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success:function(data){
                  $("#tabla_documentos").html(data);
              }
            })

          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });
  }else{
  var idencargado=$("#idencargado").val();
    swal({
        title: "¿Está seguro que desea actualizar los datos?",
        text: "Confirme actualización",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
      var formData= new FormData(document.getElementById("FormActaReuCierre"));//se crea el formato de datos, para enio de archivos y datos
      formData.append('iddocumento',12);
      formData.append('nacata',nacata);
      formData.append('idencargado',idencargado);
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/actareu_cierre/actualizar",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#idreqcarto").val(data);
            swal("Enviado!", "Datos actualizados correctamente.", "success");


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });

  }

}
// AGREGAR FIRMAS
function AgregarFirmasActas(id){
  var trabajador=$("#personaacta").val();
  var documento=$("#iddocumento").val();
   var idacta=$("#idacta").val();
   console.log(idacta);
  swal({
    title: "¿Está seguro agregar al firmante?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var nacata = $('#nacata').val();
    console.log(nacata);
  var formData= new FormData(document.getElementById("FormGuardarFirma"));//se crea el formato de datos, para enio de archivos y datos
  formData.append('idproyecto',id);
  formData.append('idtrabajador',trabajador);
  formData.append('iddocumento',documento);
    formData.append('nacata',nacata);
    formData.append('idacta',idacta);

  console.log(documento);
    var token = $('input[name=_token]').val();
    console.log(token);
    formData.append('_token',token);

    $.ajax({
      url: "/id_firmas/"+nacata,//url
      type: "POST",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        var datos = JSON.parse(data);
        console.log(datos["idacta_reunion"]);
        //formData.append('idacta',datos["idacta_reunion"]);
        $.ajax({
          url: "/actareu_ejecucion/firmas",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#resultadoagregarfirmantes").html(data);
            swal("Enviado!", "Datos registrados correctamente.", "success");
            $('#personaacta option:contains(Seleccionar Trabajador)').prop('selected',true);
            $("#cargo").html("<option>-Seleccione un cargo-</option>");

          },
          error:function (data){
                swal("El trabajador ya fue notificado", "Error.", "error");
          }

        });

      }
    })

  });

}
//NOTIFICAR
function enviarNotificacion(id){
  var documento=$("#iddocumento").val();
  var token = $('input[name=_token]').val();
  console.log(token);
   swal({
  title: "Notificar",
  text: "Desea notificar por correo",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/actareu_ejecucion/notificarfirmas',//archivo donde llegan los datos
      data:{idproyecto:id,iddocumento:documento, _token:token},
      //headers: {'X-CSRF-TOKEN':token},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      //$("#resupestanotificar").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

            actualizarfirmanotificada(token);
            actualizarlistanotificados(id,documento,token);
            swal("Enviados", "Se envio el correo satisfactoriamente", "success");


      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}
function enviarNotificacion_menu(id){
  var documento=$("#iddocumento").val();
  var token = $('input[name=_token]').val();
  var idacta=$("#idacta").val();
  var idarea=$("#area_proyecto").val();
  console.log(token);
   swal({
  title: "Notificar",
  text: "Desea notificar por correo",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/actareu_ejecucion/notificarfirmas_menu',//archivo donde llegan los datos
      data:{idproyecto:0,iddocumento:documento,idacta:idacta,idarea:idarea, _token:token},
      //headers: {'X-CSRF-TOKEN':token},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      //$("#resupestanotificar").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

          actualizarfirmanotificada(token);
          actualizarlistanotificados_menu(idacta,documento,token);
          swal("Enviados", "Se envio el correo satisfactoriamente", "success");

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}


function actualizarfirmanotificada(token){
  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/actareu_ejecucion/actualizarfirmas',//archivo donde llegan los datos
      data:{op:5,_token:token},
      //headers: {'X-CSRF-TOKEN':token},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultadoagregarfirmantes").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      },
      error:function (data){
          swal("Error", "Error2", "error");
      }
      });

}

function actualizarlistanotificados_menu(idacta,documento,token){

  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/actareu_ejecucion/actualizarnotificados_menu',//archivo donde llegan los datos
      data:{idacta:idacta,iddocumento:documento, _token:token},
      //headers: {'X-CSRF-TOKEN':token},
      success:function(data){//si se ejecuto correctamente
      $("#FirmasNotificadas").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      },
      error:function (data){
          swal("Error", "Error", "error");
      }
      });

}
function actualizarlistanotificados(id,documento,token){

  $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/actareu_ejecucion/actualizarnotificados',//archivo donde llegan los datos
      data:{idproyecto:id,iddocumento:documento, _token:token},
      //headers: {'X-CSRF-TOKEN':token},
      success:function(data){//si se ejecuto correctamente
      $("#FirmasNotificadas").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

}
//Modelos

function insertarModelo(){


  var codigo=$("#codigo").val();
  var idtipo_modelo=$("#idtipo_modelo").val();
  var f = $(this);//tampoco se

  var file = $("#file")[0].files[0];
  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();
  formData.append("file", file);
  formData.append("idtipodoc",1);
  formData.append("codigo",codigo);
  formData.append("idtipo_modelo",idtipo_modelo);
  var token = $('input[name=_token]').val();
  formData.append('_token',token);

  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
  function(){

    $.ajax({//envia por ajax
    url: "/modelos/insertar",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    //headers: {'X-CSRF-TOKEN':token},
    success:function(data){

      swal("Enviado!", "Datos registrados correctamente.", "success");
      $('#TablaModelosTipo').DataTable().destroy();
          $("#divModelos").html(data);
          $('#TablaModelosTipo').DataTable();


    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});
}

//Notificados Centro de costos

function AgregarNotificadoCostos(id){

  var correo=$("#correocostos").val();
  var trabajador=$("#trabajadorcostos").val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
    formData.append('idproyecto',id);
    formData.append('op',4);
    formData.append('idtrabajador',trabajador);
    formData.append('correo',correo);
    swal({
    title: "¡Seguro de Registrar Notificado?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    // console.log(token);
    $.ajax({
      url: "/ajax/centro",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        swal("Actualizado!", "Datos registrados correctamente.", "success");
        $("#TablaNotificadoCosto").html(data);
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}


function notificarActaCierre(){

  var trabajador=$("#personaacta").val();
  var documento=$("#iddocumento").val();
  swal({
    title: "¿Está seguro de notificar?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var formData= new FormData(document.getElementById("FormGuardarFirma"));//se crea el formato de datos, para enio de archivos y datos
  formData.append('idproyecto',id);
  formData.append('idtrabajador',trabajador);
  formData.append('iddocumento',documento);
  console.log(documento);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/actacierre_cierre/notificar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //alert(data);
        $("#resultadoagregarfirmantes").html(data);
        swal("Enviado!", "Notificación realizada correctamente.", "success");


      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}

//COMITE GERENTES
function GuardarComite()
{
  var accion = $('#accion').val();
  if(accion == '1'){
      swal({
        title: "¿Está seguro de Guardar el Acta de Comite?",
        text: "Confirme guardado",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
        var idcomite = $('#idcomite').val();
        var formData = new FormData(document.getElementById("FormComite"));//se crea el formato de datos, para enio de archivos y datos
        formData.append('nacta',idcomite);
        var token = $('input[name=_token]').val();
        formData.append('_token',token);
        console.log(token);
        $.ajax({
          url: "/comite/guardar",//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            var accion = $('#accion').val('2');
            //alert(data);
             // var datos = JSON.parse(data);
             //  console.log(datos);
            $("#resultadoagregarfirmantes").html(data);
            swal("Enviado!", "Datos Registrados correctamente.", "success");

            $.ajax({
              url: "/tabla/"+idcomite,//url
              type: "post",//tipo post
              dataType: "html",
              data:formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success:function(data){
                  $('#hola').html(data);
              }
            })


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });
  }else{
     swal({
        title: "¿Está seguro de Actualizar el Acta de Comite?",
        text: "Confirme Actualizacion",
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
      },
      function(){
        var idcomite = $('#idcomite').val();
        var formData = new FormData(document.getElementById("FormComite"));//se crea el formato de datos, para enio de archivos y datos
        formData.append('nacta',idcomite);
        var token = $('input[name=_token]').val();
        console.log(token);
        formData.append('_token',token);
        $.ajax({
          url: "/comite/actualizar/"+idcomite,//url
          type: "post",//tipo post
          dataType: "html",
          data:formData,
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){
            //alert(data);
            $("#resultadoagregarfirmantes").html(data);
            swal("Enviado!", "Datos Actualizados correctamente.", "success");


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }

        });
      });
  }


}


function agregarParticipantesComite()
{
  var traba=$("#personaacta").val();
  var cargo=$("#cargo").val();
  console.log(traba);
  console.log(cargo);
  swal({
    title: "¿Está seguro de Guardar el Participante?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var idcomite = $('#idcomite').val();
  var formData= new FormData(document.getElementById("FormComite"));//se crea el formato de datos, para enio de archivos y datos
  formData.append('idcomite',idcomite);
  formData.append('idparticipante',traba);
  formData.append('cargo',cargo);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/comite_participantes/guardar",//url
      type: "post",//tipo post
      dataType: "html",
      // dataType: "json",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //alert(data);
        if (data == '<h1>Repetido</h1>') {
          swal("Error", "Participante ya agregado", "error");
        }else {
          $("#TableComiteGerentes").html(data);
          swal("Enviado!", "Se Agrego al participante Correctamente .", "success");
          $('#personaacta option:contains(--Seleccione un Trabajador--)').prop('selected',true);
          $("#cargo").html("<option>-Seleccione un cargo-</option>");
        }

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}

$("#personafirmacomite").change(function() {

  var idtrabajador = $(this).children(":selected").attr("value");//se obtiene el valor de la opción del select nivel
  //alert(idtrabajador);
  var token = $('input[name=_token]').val();
      $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/comite_firma/cargo',//archivo donde llegan los datos
      data:{idtrabajador:idtrabajador, _token:token},//opcion 1 es para consultar grados
      //headers: {'X-CSRF-TOKEN':token},
      success:function(data){//si se ejecuto correctamente
      $("#cargofirma").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
      });

    });

function agregarfirmaComite(){
  var trabajador=$("#personafirmacomite").val();
  var documento=15;
  swal({
    title: "¿Está seguro agregar al firmante?",
    text: "Confirme guardado",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var idcomite = $('#idcomite').val();
  var formData= new FormData(document.getElementById("FormGuardarFirma"));//se crea el formato de datos, para enio de archivos y datos
  formData.append('idcomite',idcomite);
  formData.append('idtrabajador',trabajador);
  formData.append('iddocumento',documento);
  console.log(documento);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/comite_firma/agregar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        if (data == '<h1>Repetido</h1>') {
          swal("Error", "Firmante ya agregado", "error");
        }else {
          $("#resultadoagregarfirmantescomite").html(data);
          swal("Enviado!", "Datos registrados correctamente.", "success");
        }

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
function notificarfirmaComite(){
  var documento=15;
  swal({
    title: "¿Está seguro de Notificar?",
    text: "Confirme",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
  var idcomite = $('#idcomite').val();
  var idcomite2=$('#idcomite2').val();
  var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
  formData.append('idcomite',idcomite);
  formData.append('idcomite2',idcomite2);
  formData.append('iddocumento',documento);
  console.log(documento);
    var token = $('input[name=_token]').val();
    formData.append('_token',token);
    console.log(token);
    $.ajax({
      url: "/comite_firma/notificar",//url
      type: "post",//tipo post
      dataType: "html",
      data:formData,
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      contentType: false,
      processData: false,
      success:function(data){
        //alert(data);
        $("#TablaNotificadosComite").html(data);
        $("#resultadoagregarfirmantescomite").html('<table class="table"><thead><tr><th>Nº</th><th>Gerencia</th><th>Nombre</th><th>Cargo</th><th>Correo</th><th>Estado</th><th></th></tr></thead></table>');
        swal("Enviado!", "Datos registrados correctamente.", "success");
      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });
}
//BUSQUEDA
function MetododeBusca(){
  var idbono = $("#busquedaCombo").val();
  if (idbono==1) {
    $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:12},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#MetodoBusca").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });

  }else{

    $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:13},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#MetodoBusca").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });

  }

}

function BusquedaProyectos(){

  var cliente = document.getElementById("idcliente").value;
  var fase = document.getElementById("fase").value;
  var fechainicio = document.getElementById("fechainicio").value;
  var fechafin = document.getElementById("fechafin").value;
  var iddepartamento = document.getElementById("iddepartamento").value;
  var idprovincia = document.getElementById("idprovincia").value;
  var iddistrito = document.getElementById("iddistrito").value;

   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:11,fase:fase,fechainicio:fechainicio,fechafin:fechafin,cliente:cliente,iddepartamento:iddepartamento,idprovincia:idprovincia,iddistrito:iddistrito},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#listaproyectos2").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });

}
function BusquedaDocumentos(){

  var idproyecto = document.getElementById("idproyecto").value;

   //alert('Hola bebe'+fase+fechainicio+fechafin);
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/proyecto',//archivo donde llegan los datos
      data:{op:14,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#listaproyectos2").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
      }
    });

}


function GuardarActaInicioForm(){//se mpregunta si ya se preiocnó el boton submit, que en este cdaso es el mguardar
  var accion = $("#accion").val();
  //alert(accion);

if(accion==1){ //si es uno entonces tiene que guardar
  swal({
  title: "Guardar",
  text: "Confirme el guardado",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
function(){
  var formData= new FormData(document.getElementById("fromacta_inicio"));//se crea el formato de datos, para enio de archivos y datos
  formData.append("dato", "valor");//colocar esto

    $.ajax({//envia por ajax
    url: "/inicio/actainicio/guardar",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

    swal("Enviado!", "Datos registrados correctamente.", "success");
    recargar_pag();


    document.getElementById("btnequipo").disabled=false;
    document.getElementById("btnentregables").disabled=false;
    document.getElementById("btncronograma").disabled=false;
    document.getElementById("btnfirmas").disabled=false;

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });

});


}else if(accion==2){

  swal({
  title: "Actualizar",
  text: "Confirme la actualización de Acta de Inicio",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
    },
  function(){
    var formData= new FormData(document.getElementById("fromacta_inicio"));//se crea el formato de datos, para enio de archivos y datos
    formData.append("dato", "valor");//colocar esto

      $.ajax({//envia por ajax
      url: "/inicio_actualiza/actainicio",//url
      type: "post",//tipo post
      dataType: "html",
      data: formData,//se manda con todo por la foto
      cache: false,
      contentType: false,
      processData: false,
      success:function(data){

      swal("Enviado!", "Datos registrados correctamente.", "success");
      recargar_pag();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }
      });

    });
}

}

function SeleccionModeloxTipo(){
  var idtipo_modelo=$("#idtipo_modelo").val();
  var token = $('input[name=_token]').val();
   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/modelotipo',//archivo donde llegan los datos
      data:{idtipo_modelo:idtipo_modelo, _token:token},
      //headers: {'X-CSRF-TOKEN':token},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
        $('#TablaModelosTipo').DataTable().destroy();
        $("#TablaModelosTipo").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado
          $('#TablaModelosTipo').DataTable();

      }
    });
}

function LimpiarPrivilegios() {
  for (var i = 1; i <= 35; i++) {
          var pId="p"+i;
          document.getElementById(pId).checked = false;
        }
  $("#opcion").val(1);
}
function TraerPrivilegio(id) {
  LimpiarPrivilegios();
  $.ajax({
    url: "/privilegio/controller/"+id,
    type: "get",
    success:function(data){
        var privilegio = JSON.parse(data);
        console.log(privilegio);
        for (var i = 0; i < privilegio.length; i++) {
          var pId="p"+privilegio[i]['idmodulo'];
          console.log(pId);
          document.getElementById(pId).checked = true;
        }
        $("#nombre").val(privilegio[0]["privilegio"]["nombre"]);
        $("#idprivilegio").val(privilegio[0]["privilegio"]["idprivilegio"]);
        $("#opcion").val(200);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarPrivilegio(id){
  swal({
      title: "Eliminar",
      text: "¿Está seguro de eliminar el privilegio",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
        },
      function(){
        var formData= new FormData(document.getElementById("formPrivilegio"));//se crea el formato de datos, para enio de archivos y datos
        formData.append('idprivilegio',id);
          $.ajax({//envia por ajax
          url: "/privilegio/eliminar",//url
          type: "post",//tipo post
          dataType: "html",
          data: formData,//se manda con todo por la foto
          cache: false,
          contentType: false,
          processData: false,
          success:function(data){

          swal("Eliminado!", "Datos eliminados correctamente.", "success");

          $("#TablaPrivilegios").html(data);

          },
          error:function (data){
                swal("Error", "Error.", "error");
          }
          });

        });
}

function GuardarPrivilegio(){
  var opcion=$("#opcion").val();
  var idprivilegio=$("#idprivilegio").val();
  var privilegio=$("#nombre").val();
  if(privilegio == ""){
    swal("Error", "No se puede ingresar un privilegio vacio", "error");

  }else{

    if (opcion==1) {
            swal({
            title: "Guardar",
            text: "¿Está seguro de guardar el privilegio",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var formData= new FormData(document.getElementById("formPrivilegio"));//se crea el formato de datos, para enio de archivos y datos

                $.ajax({//envia por ajax
                url: "/privilegio/guardar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");

                $("#TablaPrivilegios").html(data);

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
        }else{

              swal({
            title: "Actualizar",
            text: "¿Está seguro de actualizar el privilegio",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var formData= new FormData(document.getElementById("formPrivilegio"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('idprivilegio',idprivilegio);
                $.ajax({//envia por ajax
                url: "/privilegio/actualizar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");

                $("#guardado").html(data);

                window.location.href='/privilegios';
                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
        }

  }
}



function LimpiarCarto(){
  $("#observaciones").val("").jqteVal("");
  $("#cantidad").val("");
  $("#detalle_carto").val(0);
  $('#idequipo option:contains(-Seleccione un Producto-)').prop('selected',true);
}

function AprobarFirma(idfirma) {

  swal({
      title: "Aprobar",
      text: "¿Está seguro de Aprobar la firma?",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
        },
      function(){
        var token = $('input[name=_token]').val();
        var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
          formData.append('idfirma',idfirma);
          formData.append('_token',token);
          $.ajax({//envia por ajax
          url: "/firmas/aprobar",//url
          type: "post",//tipo post
          dataType: "html",
          data: formData,//se manda con todo por la foto
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){

          swal("Enviado!", "Firma Aprobada con exito.", "success");
          $('#myTable').DataTable().destroy();
          $("#firmascentrocostos").html(data);
          $('#myTable').DataTable();


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }
          });

        });

}
function AprobarFirma_comite(idfirma) {

  swal({
      title: "Aprobar",
      text: "¿Está seguro de Aprobar la firma?",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
        },
      function(){
        var token = $('input[name=_token]').val();
        var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
          formData.append('idfirma',idfirma);
          formData.append('_token',token);
          $.ajax({//envia por ajax
          url: "/firmas_comite/aprobar",//url
          type: "post",//tipo post
          dataType: "html",
          data: formData,//se manda con todo por la foto
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){

          swal("Enviado!", "Firma Aprobada con exito.", "success");
          $('#myTable').DataTable().destroy();
          $("#firmascentrocostos").html(data);
          $('#myTable').DataTable();


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }
          });

        });

}
function DesaprobarFirma(idfirma){

  swal({
      title: "Desaprobar",
      text: "¿Está seguro de desaprobar la firma",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
        },
      function(){
        var token = $('input[name=_token]').val();
        var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
          formData.append('idfirma',idfirma);
          formData.append('_token',token);
          $.ajax({//envia por ajax
          url: "/firmas/desaprobar",//url
          type: "post",//tipo post
          dataType: "html",
          data: formData,//se manda con todo por la foto
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){

          swal("Enviado!", "Firma Desaprobada con Exito", "success");
          $('#myTable').DataTable().destroy();
          $("#firmascentrocostos").html(data);
          $('#myTable').DataTable();


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }
          });

        });

}
function DesaprobarFirma_comite(idfirma){

  swal({
      title: "Desaprobar",
      text: "¿Está seguro de desaprobar la firma",
      type: "info",
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
        },
      function(){
        var token = $('input[name=_token]').val();
        var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
          formData.append('idfirma',idfirma);
          formData.append('_token',token);
          $.ajax({//envia por ajax
          url: "/firmas_comite/desaprobar",//url
          type: "post",//tipo post
          dataType: "html",
          data: formData,//se manda con todo por la foto
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          contentType: false,
          processData: false,
          success:function(data){

          swal("Enviado!", "Firma Desaprobada con Exito", "success");
          $('#myTable').DataTable().destroy();
          $("#firmascentrocostos").html(data);
          $('#myTable').DataTable();


          },
          error:function (data){
                swal("Error", "Error.", "error");
          }
          });

        });

}

function GuardarCode(){

  var opcion=$("#opcion").val();
  var cliente=$("#cliente").val();
  var documento=$("#documento").val();
  var proyecto=$("#proyecto").val();
  var codigo=$("#codigo").val();
  var descripcion=$("#descripcion").val();
  var nombre=documento+"-"+cliente+"-"+proyecto+"-"+codigo;
  if(proyecto == 0 || cliente == 0 || documento == 0 ){
    swal("Error", "Necesita Escoger todos los items.", "warning");
  } else if (descripcion === "" || descripcion.length < 10 ) {
    swal("Error", "La descripción es requerida y con un mínimo de 10 caracteres ", "warning");

  } else{
      if (opcion==1) {

            swal({
                title: "Guardar",
                text: "¿Está seguro de guardar el CODE",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                  },
                function(){
                  var token = $('input[name=_token]').val();
                  var formData= new FormData(document.getElementById("formcode"));//se crea el formato de datos, para enio de archivos y datos
                    formData.append('nombre',nombre);
                    formData.append('descripcion',descripcion);
                    formData.append('cliente',cliente);
                    formData.append('documento',documento);
                    formData.append('proyecto',proyecto);
                    formData.append('codigo',codigo);
                    formData.append('_token',token);
                    $.ajax({//envia por ajax
                    url: "/code/guardar",//url
                    type: "post",//tipo post
                    dataType: "html",
                    data: formData,//se manda con todo por la foto
                    cache: false,
                    //headers: {'X-CSRF-TOKEN':token},
                    contentType: false,
                    processData: false,
                    success:function(data){

                     $('#myTable').DataTable().destroy();
                       $('#resultado').html(data);
                      var code = $('#codeResponse').val();
                      swal("Enviado!", "Se registró el CODE "+code, "success");
                      $('#tablaCode').DataTable();
                    LimpiarCode();

                    },
                    error:function (data){
                          swal("Error", "Error.", "error");
                    }
                    });

                  });
      }else{
        var idcode=$("#id").val();
        swal({
                title: "Actualizar",
                text: "¿Está seguro de actualizar el CODE",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                  },
                function(){
                  var token = $('input[name=_token]').val();
                  var formData= new FormData(document.getElementById("formcode"));//se crea el formato de datos, para enio de archivos y datos
                    formData.append('nombre',nombre);
                    formData.append('descripcion',descripcion);
                    formData.append('cliente',cliente);
                    formData.append('documento',documento);
                    formData.append('proyecto',proyecto);
                    formData.append('codigo',codigo);
                    formData.append('idcode',idcode);
                    formData.append('_token',token);
                    $.ajax({//envia por ajax
                    url: "/code/actualizar",//url
                    type: "post",//tipo post
                    dataType: "html",
                    data: formData,//se manda con todo por la foto
                    cache: false,
                    //headers: {'X-CSRF-TOKEN':token},
                    contentType: false,
                    processData: false,
                    success:function(data){

                    swal("Enviado!", "Datos actualizados correctamente.", "success");
                    $('#myTable').DataTable().destroy();
                    $('#resultado').html(data);
                    $('#tablaCode').DataTable();
                    LimpiarCode();

                    },
                    error:function (data){
                          swal("Error", "Error.", "error");
                    }
                    });

                  });
      }
    }


}


function TraerCode(id){

  $.ajax({
    url: "/code/controller/"+id,
    type: "get",
    success:function(data){
        var code = JSON.parse(data);
        console.log(code);
        $("#id").val(code.idcode);
        $("#codigo").val(code.codigo);
        $("#descripcion").val(code.descripcion);
        $("#correlativo").val(code.correlativo);

        $('#documento option[value="' + code.documento +'"]').prop("selected", true);


        $('#proyecto').html('<option value="'+code.proyecto.idproyecto+'">'+code.proyecto.nombre+'</option>');


        $('#cliente option[value="' + code.cliente +'"]').prop("selected", true);

        $("#opcion").val(2);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarCode(id){

  swal({
    title: "¿Está seguro de eliminar el CODE?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/code/eliminar/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Datos del cliente eliminados correctamente.", "success");
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaCode').DataTable();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });

}

function LimpiarCode() {

      $("#codigo").val("");
      $("#descripcion").val("");
      $('#documento option[value="0"]').prop("selected", true);
      $("#opcion").val(1);
}


function GuardarArea(){

  var opcion=$("#opcion").val();
  var nombre=$("#nombre").val();
  if (opcion==1) {
        swal({
            title: "Guardar",
            text: "¿Está seguro de guardar el Área",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formarea"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/area/guardar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");

                $("#resultado").html(data);
                LimpiarArea();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }else{
    var idarea=$("#id").val();
    swal({
            title: "Actualizar",
            text: "¿Está seguro de actualizar el Area",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formarea"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('idarea',idarea);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/area/actualizar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos actualizados correctamente.", "success");

                $('#tablaArea').DataTable().destroy();
                $('#resultado').html(data);
                $('#tablaArea').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarArea();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }

}


function TraerArea(id){

  $.ajax({
    url: "/area/controller/"+id,
    type: "get",
    success:function(data){
        var area = JSON.parse(data);
        console.log(area);
        $("#id").val(area.idarea);
        $("#nombre").val(area.nombre);
        $("#opcion").val(2);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarArea(id){

  swal({
    title: "¿Está seguro de eliminar el Area seleccionada?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/area/eliminar/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Datos del area eliminados correctamente.", "success");
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaArea').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });

}

function LimpiarArea() {

      $("#nombre").val("");
      $("#opcion").val(1);
}



function GuardarTipPro(){

  var opcion=$("#opcion").val();
  var nombre=$("#nombre").val();
  var abreviatura=$("#abreviatura").val();
  if (opcion==1) {
        swal({
            title: "Guardar",
            text: "¿Está seguro de guardar el Tipo de Proyecto?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formtippro"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('abreviatura',abreviatura);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/tippro/guardar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");
                $('#tablaTipPro').DataTable().destroy();
                $('#resultado').html(data);
                $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarTipPro();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }else{
    var idtipopro=$("#id").val();
    swal({
            title: "Actualizar",
            text: "¿Está seguro de actualizar el Tipo de Proyecto",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formtipro"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('idtipoproyecto',idtipopro);
                formData.append('abreviatura',abreviatura);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/tippro/actualizar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos actualizados correctamente.", "success");
                $("#resultado").html(data);
                LimpiarTipPro();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }

}


function TraerTipPro(id){

  $.ajax({
    url: "/tippro/controller/"+id,
    type: "get",
    success:function(data){
        var tip = JSON.parse(data);
        console.log(tip);
        $("#id").val(tip.idtipoproyecto);
        $("#nombre").val(tip.nombre);
        $("#abreviatura").val(tip.abreviatura);
        $("#opcion").val(2);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarTipPro(id){

  swal({
    title: "¿Está seguro de eliminar el Tipo de Proyecto?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/tippro/eliminar/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Tipo de Proyecto  eliminado correctamente.", "success");
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaTipPro').DataTable();

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });

}

function LimpiarTipPro() {

      $("#nombre").val("");
      $("#abreviatura").val("");
      $("#opcion").val(1);
}



function GuardarTipCon(){

  var opcion=$("#opcion").val();
  var nombre=$("#nombre").val();
  if (opcion==1) {
        swal({
            title: "Guardar",
            text: "¿Está seguro de guardar el Tipo de Contrato?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formtipocon"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/tipcon/guardar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");

                $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarTipCon();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }else{
    var idtipocon=$("#id").val();
    swal({
            title: "Actualizar",
            text: "Actualizado",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formtipocon"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('idtipocontrato',idtipocon);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/tipcon/actualizar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos actualizados correctamente.", "success");
                $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarTipCon();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }
}


function TraerTipCon(id){

  $.ajax({
    url: "/tipcon/controller/"+id,
    type: "get",
    success:function(data){
        var tip = JSON.parse(data);
        console.log(tip);
        $("#id").val(tip.idtipocontrato);
        $("#nombre").val(tip.nombre);
        $("#opcion").val(2);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarTipCon(id){

  swal({
    title: "¿Está seguro de eliminar el Tipo de Contrato?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/tipcon/eliminar/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Tipo de Contrato  eliminado correctamente.", "success");
        $('#myTable').DataTable().destroy();
        $('#resultado').html(data);
        $('#tablaTipCon').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });

}

function LimpiarTipCon() {

      $("#nombre").val("");
      $("#opcion").val(1);
}



function GuardarEquip(){

  var opcion=$("#opcion").val();
  var nombre=$("#nombre").val();
  if (opcion==1) {
        swal({
            title: "Guardar",
            text: "¿Está seguro de guardar el Equipo de Cartografia ",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formequip"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/equipcarto/guardar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos registrados correctamente.", "success");
                $('#myTable').DataTable().destroy();
                  $('#resultado').html(data);
                  $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarEquip();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }else{
    var idequipo=$("#id").val();
    swal({
            title: "Actualizar",
            text: "¿Está seguro de actualizar el Equipo de Cartografia",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
              },
            function(){
              var token = $('input[name=_token]').val();
              var formData= new FormData(document.getElementById("formequip"));//se crea el formato de datos, para enio de archivos y datos
                formData.append('nombre',nombre);
                formData.append('idequipo',idequipo);
                formData.append('_token',token);
                $.ajax({//envia por ajax
                url: "/equipcarto/actualizar",//url
                type: "post",//tipo post
                dataType: "html",
                data: formData,//se manda con todo por la foto
                cache: false,
                //headers: {'X-CSRF-TOKEN':token},
                contentType: false,
                processData: false,
                success:function(data){

                swal("Enviado!", "Datos actualizados correctamente.", "success");
                $('#myTable').DataTable().destroy();
                  $('#resultado').html(data);
                  $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });
                LimpiarTipCon();

                },
                error:function (data){
                      swal("Error", "Error.", "error");
                }
                });

              });
  }

}


function TraerEquip(id){

  $.ajax({
    url: "/equipcarto/controller/"+id,
    type: "get",
    success:function(data){
        var tip = JSON.parse(data);
        console.log(tip);
        $("#id").val(tip.idequipo);
        $("#nombre").val(tip.nombre);
        $("#opcion").val(2);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }

  });
}

function EliminarEquip(id){

  swal({
    title: "¿Está seguro de eliminar el Equipo de Cartografia seleccionado?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    var token = $('input[name=_token]').val();
    // console.log(token);
    $.ajax({
      url: "/equipcarto/eliminar/"+id,//url
      type: "post",//tipo post
      dataType: "html",
      data: {id:id, _token:token},//se manda con todo por la foto
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success:function(data){
        swal("Eliminado!", "Equipo de Cartografia  eliminado correctamente.", "success");
        $('#myTable').DataTable().destroy();
                  $('#resultado').html(data);
                  $('#tablaTipPro').DataTable({
                 "language": {
                "lengthMenu": "Ver los _MENU_ Primeros Registros",
                "zeroRecords": "Nothing found - sorry",
                "info": "Pagina Nº _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch":         "BUSCAR:",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",

                 "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
                },
                 "fnInfoCallback": null}
     });

      },
      error:function (data){
            swal("Error", "Error.", "error");
      }

    });
  });

}

function LimpiarEquip() {

      $("#nombre").val("");
      $("#opcion").val(1);
}

function EliminarProyecto(id) {
  var token = $('input[name=_token]').val();
  swal({
    title: "¿Está seguro de eliminar el Proyecto?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    $.ajax({
            url:"listaproyecto/eliminar/"+id,
            type: 'POST',
            data: {id:id, _token:token},
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            //contentType: false,
            //processData: false,
            success: function(data){
                $('#myTable').DataTable().destroy();
                $("#lista_proyectos").html(data);
                $('#myTable').DataTable();
                swal("Eliminado!", "Proyecto eliminado correctamente.", "success");
            },
            error:function (data){
            swal("Error", "Error.", "error");
      }
        });
    // console.log(token);

  });
}

function editarInfoProyecto(id) {

  var token = $('input[name=_token]').val();
  var formData= new FormData(document.getElementById("formInfo"));
  formData.append('idproyecto',id);
  formData.append('_token',token);
  swal({
    title: "¿Está seguro de editar el Proyecto?",
    text: "Confirme la eliminación",
    type: "info",
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
  },
  function(){
    $.ajax({
            url:"/listaproyecto/editarinfo/"+id,
            type: 'POST',
            data: formData,
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            contentType: false,
            processData: false,
            success: function(data){
                swal("Editado!", "Proyecto editado correctamente.", "success");
            },
            error:function (data){
            swal("Error", "Error.", "error");
      }
        });
    // console.log(token);

  });
}

function AgregarDoc() {
  var iddocumento=$("#iddocumento").val();
  var nacta = $('#pvad').val();
  // console.log(nacta)
  var res = nacta.split("-");
  var n = Number(res[res.length-1])+1;
  var nacata1 = gen_NuevaActa(nacta);
  // console.log(nacata1);

  //var select = $('#area_proyecto');
  //select.val($('option:first', select).val());
  var select = $('#idencargado');
  select.val($('option:first', select).val());

  var fecha = new Date();
  var año = fecha.getFullYear();
  var mes = fecha.getMonth()+1;
  var dia = fecha.getDate();

  var fecha_actual = año+"-0"+mes+"-0"+dia;

  console.log(fecha_actual);
  $('#fecha').val(fecha_actual);

  $('#accion_guardar').val("1")
  $('#tema').val("");
  $('#temas').val(" ").jqteVal(" ");
  $('#acciones').val(" ").jqteVal(" ");
  $('#fecha_requerida').val(" ");
  $('#hora').val(" ");
  var idacta_acuerdo = "hola";
  var token = $('input[name=_token]').val();
  var formData = new FormData();
  formData.append('iddocumento',iddocumento);
  formData.append('idacta_acuerdo',idacta_acuerdo);
  formData.append('_token',token);
  $.ajax({
        url: '/ultimi_id/'+idacta_acuerdo,
        type: 'POST',
        data: formData,
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        contentType: false,
        processData: false,
        success: function(data){
          var datos = JSON.parse(data);
          console.log(datos["nacata"]);
          var nacta = datos["nacata"];
          var res = nacta.split("-");
          var n = Number(res[res.length-1])+1;
          var nacata1 = gen_NuevaActa(nacta);
          $('#pvad').val(nacata1);
          $('#nacata').val(nacata1);
            $("#resultadoagregarfirmantes").html('<table class="table"><thead><tr><th>Nº</th><th>Nombre</th><th>Cargo</th><th>Opciones</th></tr></thead></table>');
        },
        error:function (data){
          swal("Error", "Error.", "error");
        }
  });

}
function AgregarDocActa() {
  var nacta = $('#pvad').val();
  console.log(nacta);
  var res = nacta.split("-");
  var n = Number(res[res.length-1])+1;
  var nacata1 = gen_NuevaActa(nacta);

  var select = $('#area_proyecto');
  select.val($('option:first', select).val());
  var select = $('#idencargado');
  select.val($('option:first', select).val());

  var fecha = new Date();
  var año = fecha.getFullYear();
  var mes = fecha.getMonth()+1;
  var dia = fecha.getDate();

  var fecha_actual = año+"-0"+mes+"-0"+dia;

  console.log(fecha_actual);
  $('#fecha').val(fecha_actual);

  $('#accion_guardar').val("1")
  $('#tema').val(" ");
  $('#temas').val(" ").jqteVal(" ");
  $('#acciones').val(" ").jqteVal(" ");
  $('#fecha_requerida').val(" ");
  var idacta_acuerdo = "hola";
  var token = $('input[name=_token]').val();
  $.ajax({
        url: '/ultimi_id_reu/'+idacta_acuerdo,
        type: 'POST',
        data: {idacta_acuerdo:idacta_acuerdo, _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
          var datos = JSON.parse(data);
          console.log(datos["nacata"]);
          var nacta = datos["nacata"];
          var res = nacta.split("-");
          var n = Number(res[res.length-1])+1;
          var nacata1 = gen_NuevaActa(nacta);
          $('#pvad').val(nacata1);
          $('#nacata').val(nacata1);
          var idacta=$("#idnuevaacta").val();
          // var idacta=$("#idacta").val();
          // idacta= (idacta*1)+1;
          $("#idacta").val(idacta);
          $("#resultadoagregarfirmantes").html('<table class="table"><thead><tr><th>Nº</th><th>Nombre</th><th>Cargo</th><th>Opciones</th></tr></thead></table>');
        },
        error:function (data){
          swal("Error", "Error.", "error");
        }
  });

}

function AgregarDoc1(){

var token = $('input[name=_token]').val();
    $.ajax({
      url: '/ultimo_id',
        type: 'POST',
        data: {idacta_acuerdo:idacta_acuerdo, _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
          var datos = JSON.parse(data);
                // console.log(datos);
          var nacta = datos["numero_acta"];
          // console.log(nacta);
          var res = nacta.split("-");
          var n = Number(res[res.length-1])+1;
          var nacata1 = gen_NuevaActa(nacta);
          $('#cliente').val(nacata1);
          $('#numero_acta').val(nacata1);
        }
    })


    var select = $('#area_proyecto');
    select.val($('option:first', select).val());
    var select = $('#idencargado');
    select.val($('option:first', select).val());

    var fecha = new Date();
    var año = fecha.getFullYear();
    var mes = fecha.getMonth()+1;
    var dia = fecha.getDate()+1;

    var fecha_actual = año+"-0"+mes+"-0"+dia;

    console.log(fecha_actual);

    $('#fecha_hora_fecha').val(fecha_actual);
    $('#fecha_hora_hora').val(" ");
    $('#accion_guardar').val("1")
    $('#revision').val(" ");
    $('#acuerdos').val(" ");
    $('#tema').val(" ");
    $('#cronograma').val(" ");
    document.getElementById("AgregarProgramacionAcuerdo").disabled=true;
    document.getElementById("ExportarAcuerdo").disabled=true;


    var idacta_acuerdo = ($('#idacta_acuerdo').val())*1+1;


    $.ajax({
        url: '/lista_programacion/'+idacta_acuerdo,
        type: 'POST',
        data: {idacta_acuerdo:idacta_acuerdo, _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
            $("#TableAgregaProgramacion").html(data);
        },
        error:function (data){
          swal("Error", "Error.", "error");
        }
    });

}

function AgregarDoc2() {

  var fecha = new Date();
  var año = fecha.getFullYear();
  var mes = fecha.getMonth()+1;
  var dia = fecha.getDate();
  if(dia < 10 && mes < 10){
    var fecha_actual = año+"-0"+mes+"-0"+dia;
  }else if(dia < 10 && mes > 10){
    var fecha_actual = año+"-"+mes+"-0"+dia;
  }else if(dia > 10 && mes < 10){
    var fecha_actual = año+"-0"+mes+"-"+dia;
  }else{
     var fecha_actual = año+"-"+mes+"-"+dia;
  }

  console.log(fecha_actual);

  $('#accion_guardar').val('1');
  $('#fecha').val(fecha_actual);

  document.getElementById('input').checked=0;
  document.getElementById('input1').checked=0;
  document.getElementById('input2').checked=0;
  document.getElementById('input3').checked=0;

  // $("input:checkbox").checked=0;

  $('#medio').val(" ");
  $('#idacta').val("");
  $('#descripcion').val(" ").jqteVal(" ");
  $('#nombre').val(" ");
  $('#acta_cargo').val(" ");
  $("#resultadoagregarfirmantes").html("<table class='table'><tr><th>N°</th><th>NOMBRE</th><th>CARGO</th><th>OPCIONES</th></tr></table>");
}

function datos_doc(idproyecto) {
  var token = $('input[name=_token]').val();
  $.ajax({
            url:"/datos_Doc/"+idproyecto,
            type: 'POST',
            data: {id:idproyecto, _token:token},
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            //contentType: false,
            //processData: false,
            success: function(data){
                var datos = JSON.parse(data);
                console.log(datos);
                $('#idacta').val(datos['idacta_reunion']);
                $('#pvad').val(datos['nacata']);
                $('#nacata').val(datos['nacata']);
                var select = $('#area_proyecto');
                select.val(datos['area_proyecto']);
                $('#tema').val(datos['tema']);
                $('#fecha').val(datos['fecha']);
                $('#hora').val(datos['hora']);
                var select = $('#idencargado');
                select.val(datos['idencargado']);
                $('#temas').val(datos['tema']).jqteVal(datos['tema']);
                $('#acciones').val(datos['acciones']).jqteVal(datos['acciones']);
                $('#fecha_requerida').val(datos['fecha_requerida']);
                $('#accion_guardar').val('2');

                var ruta_exp = $('#ExportarActaReu').parent().prop('href');
                var arr_ruta = ruta_exp.split("/");
                ruta_exp = ruta_exp.replace(arr_ruta[arr_ruta.length-1],datos['idproyecto']+"_"+datos['idacta_reunion']);
                 $('#ExportarActaReu').parent().prop('href',ruta_exp);

                $.ajax({

                  url:'/firmas/'+datos['idacta_reunion'],
                  type: 'POST',
                  data: {id:datos['idacta_reunion'],idproyecto:idproyecto, _token:token},
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  //contentType: false,
                  //processData: false,
                  success: function(data){
                      $("#resultadoagregarfirmantes").html(data);
                  }

                });

                // $('#registro').modal('hide');
            },
            error:function (data){
                swal("Error", "Error.", "error");
            }
  });
}
/*
function datos_doc_menu(idproyecto) {
alert(idproyecto);

  var token = $('input[name=_token]').val();
  $.ajax({
            url:"/datos_Doc/"+idproyecto,
            type: 'POST',
            data: {id:idproyecto},
            cache: false,
            headers: {'X-CSRF-TOKEN':token},
            //contentType: false,
            //processData: false,
            success: function(data){
                var datos = JSON.parse(data);
                console.log(datos);
                $('#idacta').val(datos['idacta_reunion']);
                $('#pvad').val(datos['nacata']);
                $('#nacata').val(datos['nacata']);
                var select = $('#area_proyecto');
                select.val(datos['area_proyecto']);
                $('#tema').val(datos['tema']);
                $('#fecha').val(datos['fecha']);
                var select = $('#idencargado');
                select.val(datos['idencargado']);
                alert(datos['temas']);
                $('#temas').val(prueba);
                $('#acciones').val(datos['acciones']);
                $('#fecha_requerida').val(datos['fecha_requerida']);
                $('#accion_guardar').val('2');
                document.getElementById('exportar_reunion_menu').href ="/actareumenu/exportaractareu/"+datos['idacta_reunion'];
                actualizarlistanotificados_menu(datos['idacta_reunion'],13,token);
                $.ajax({

                  url:'/firmas/'+datos['idacta_reunion'],
                  type: 'POST',
                  data: {id:datos['idacta_reunion'],idproyecto:idproyecto},
                  cache: false,
                  headers: {'X-CSRF-TOKEN':token},
                  //contentType: false,
                  //processData: false,
                  success: function(data){
                      $("#resultadoagregarfirmantes").html(data);
                  }

                });

                // $('#registro').modal('hide');
            },
            error:function (data){
                swal("Error", "Error.", "error");
            }
  });
}
*/

function datos_doc_acta_acuerdo(idacuerdo) {
  var token = $('input[name=_token]').val();
  $.ajax({
            url:"/datos_doc_acta_acuerdo/"+idacuerdo,
            type: 'POST',
            data: {id:idacuerdo, _token:token},
            cache: false,
            //headers: {'X-CSRF-TOKEN':token},
            //contentType: false,
            //processData: false,
            success: function(data){
                var datos = JSON.parse(data);
                console.log(datos);
                $('#cliente').val(datos['numero_acta']);
                $('#numero_acta').val(datos['numero_acta']);
                $('#idacta_acuerdo').val(datos['idacta_acuerdo']);
                $('#tema').val(datos['tema']);
                $('#revision').val(datos['revision']);
                $('#acuerdos').val(datos['acuerdos']);
                var fecha = datos['fecha_hora'];
                console.log(fecha);
                var fecha = fecha.split(" ")
                console.log(fecha[0]+'T'+fecha[1]);
                $('#fecha_hora_fecha').val(fecha[0]+'T'+fecha[1]);
                $.ajax({
                    url: '/lista_programacion/'+datos['idacta_acuerdo'],
                    type: 'POST',
                    data: {idacta_acuerdo:datos['idacta_acuerdo'], _token:token},
                    cache: false,
                    //headers: {'X-CSRF-TOKEN':token},
                    //contentType: false,
                    //processData: false,
                    success: function(data){
                        $("#TableAgregaProgramacion").html(data);
                        document.getElementById("AgregarProgramacionAcuerdo").disabled=false;
                        document.getElementById("ExportarAcuerdo").disabled=false;
                    },
                    error:function (data){
                      swal("Error", "Error.", "error");
                    }
                });
                // $('#accion_guardar').val('2');
            },
            error:function (data){
                swal("Error", "Error.", "error");
            }
  });
}

function datos_doc_solicitud_cambio(idacta_acuerdo) {
  var token = $('input[name=_token]').val();
   $.ajax({
        url: '/lista_solicitud/'+idacta_acuerdo,
        type: 'POST',
        data: {idacta_acuerdo:idacta_acuerdo, _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
            var datos = JSON.parse(data);
            console.log(datos);
            if(datos['motivo_tiempo']==0){
              document.getElementById('input').checked = 0;
            }else{
              document.getElementById('input').checked = 1;
            }
            if (datos['motivo_costo'] == 0) {
              document.getElementById('input1').checked = 0;
            } else {
              document.getElementById('input1').checked = 1;
            }
            if (datos['motivo_alcance'] == 0) {
              document.getElementById('input2').checked = 0;
            } else {
              document.getElementById('input2').checked = 1;
            }
            if (datos['motivo_sgc'] == 0) {
              document.getElementById('input3').checked = 0;
            } else {
              document.getElementById('input3').checked = 1;
            }

            $('#medio').val(datos['medio']);
            $('#descripcion').val(datos['descripcion']).jqteVal(datos['descripcion']);
            $('#nombre').val(datos['nombre']);
            $('#acta_cargo').val(datos['cargo']);
            $('#idacta').val(datos['idsolicitud']);

            var ruta_exp = $('#ExportarSolCam').parent().prop('href');
            var arr_ruta = ruta_exp.split("/");
            ruta_exp = ruta_exp.replace(arr_ruta[arr_ruta.length-1],datos['idproyecto']+"_"+datos['idsolicitud']);
             $('#ExportarSolCam').parent().prop('href',ruta_exp);

            var id = $('#idproyecto').val();
            console.log(id);
            var formData= new FormData();//se crea el formato de datos, para enio de archivos y datos
            formData.append('idacta_acuerdo',idacta_acuerdo);
            formData.append('id',id);
            formData.append('_token',token);
            $.ajax({
              url: '/firmas_solicitud/'+idacta_acuerdo,
              type: 'POST',
              data: formData,
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              contentType: false,
              processData: false,
              success: function(data){
                // var datos = JSON.parse(data);
                // console.log(datos);
                $("#resultadoagregarfirmantes").html(data);
              },
              error:function (data){
                swal("Error", "Error.", "error");
              }
            });

        },
        error:function (data){
          swal("Error", "Error.", "error");
        }
    });
}


function AgregarDocHo() {
  $('#accion').val('1');
  $('#resultado').html('<embed src="" width="100%" height="600">');
  $('#titulo_documento').html(" ");
  // console.log("hola como estas ");
}


function datos_doc_ho(idreporteho) {
    var token = $('input[name=_token]').val();
  $.ajax({
    url: '/reporte_ho/'+idreporteho,
    type: 'POST',
    data: {idreporteho:idreporteho, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      var datos = JSON.parse(data);
      // console.log(datos["archivo"]);
      $('#resultado').html('<embed src="../documentos/reporteho/'+datos["archivo"]+'" width="100%" height="600">');
      $('#titulo_documento').html(datos["nombre"]);
    },
    error:function (data){
      swal("Error", "Error.", "error");
    }
  })
}

function datos_doc_sa(idsolicitudac) {
    var token = $('input[name=_token]').val();
  $.ajax({
    url: '/reporte_sa/'+idsolicitudac,
    type: 'POST',
    data: {idsolicitudac:idsolicitudac, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      var datos = JSON.parse(data);
      // console.log(datos["archivo"]);
      $('#resultado').html('<embed src="../documentos/solicitudac/'+datos["archivo"]+'" width="100%" height="600">');
      $('#titulo_documento').html(datos["nombre"]);
    },
    error:function (data){
      swal("Error", "Error.", "error");
    }
  })
}

function AgregarDoc_Reque_Cartografia( idproyecto ) {
    var token = $('input[name=_token]').val();
     var fecha = new Date();
  var año = fecha.getFullYear();
  var mes = fecha.getMonth()+1;
  var dia = fecha.getDate();
  if(dia < 10 && mes < 10){
    var fecha_actual = año+"-0"+mes+"-0"+dia;
  }else if(dia < 10 && mes > 10){
    var fecha_actual = año+"-"+mes+"-0"+dia;
  }else if(dia > 10 && mes < 10){
    var fecha_actual = año+"-0"+mes+"-"+dia;
  }else{
     var fecha_actual = año+"-"+mes+"-"+dia;
  }
    console.log(fecha);
  $.ajax({
    url: '/id_cartografia/'+idproyecto,
    type: 'POST',
    data: {idsolicitudac:'1', _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      if (data) {
        var datos = JSON.parse(data);
        console.log(datos["numero_requerimiento"]);
        var numero = datos["numero_requerimiento"];
        var res = numero.split("-");
        var n = Number(res[res.length-1])+1;
        var nacata1 = gen_NuevaActa(numero);
        $('#numero_requerimiento').val(nacata1);
        $('#fecha_entrega').val(fecha_actual);
        $('#fecha').val(fecha_actual);
        $('#ndocumento').val(nacata1);
      }
    }
  })
  var select = $('#idjefegerente');
  select.val("");
  $('#solicitante').val("0");
  $('#colaborador').val("0");
  $('#cantidad').val('');
  $('#idequipo').val('0');
  $('#observaciones').val(' ');
  document.getElementById("fecha").disabled=false;
  document.getElementById("fecha_entrega").disabled=false;
  $('#accion').val('1');
  document.getElementById("cantidad").disabled=true;
  document.getElementById("fecha_devolucion").disabled=true;
  document.getElementById("idequipo").disabled=true;
  document.getElementById("observaciones").disabled=true;
  document.getElementById("btnAgregarEquip").disabled=true;
    $("#tablecartografiaequipo").html('<thead><tr><th>N</th><th>Cantidad</th><th>Descripción</th><th>Fecha de devolución</th><th>Observación</th><th>Consultar</th></tr></thead>');
}
function datos_doc_req_Cartografia(idreqcartografia) {
  var token = $('input[name=_token]').val();
    $.ajax({
      url: '/req_cartografia/'+idreqcartografia,
      type: 'POST',
      data: {idreqcartografia:idreqcartografia, _token:token},
      cache: false,
      //headers: {'X-CSRF-TOKEN':token},
      //contentType: false,
      //processData: false,
      success: function(data){
        var datos = JSON.parse(data);
        console.log(datos);
        $('#ndocumento').val(datos["numero_requerimiento"]);
        $('#fecha').val(datos["fecha"]);
        $('#nombre_proyecto').val(datos["nombre"]);
        $('#nomclaveproyecto').val(datos["nombreclave"]);
        $('#fecha_entrega').val(datos["fecha_entrega"]);
        $('#idreqcartografia').val(idreqcartografia);
        $('#idjefegerente').val(datos["idjefegerente"]);
        $('#solicitante').val(datos["idsolicitante"]);
        $('#colaborador').val(datos["colaborador"]);
        //$('#idjefegerente option:contains('+datos["nombre_persona"]+' '+datos["apellidos_jefegerente"]+')').prop('selected',true);
        //$('#solicitante option:contains('+datos["nombre_solicitante"]+' '+datos["apellidos_solicitante"]+')').prop('selected',true);
        //$('#colaborador option:contains('+datos["nombre_colaborador"]+' '+datos["apellidos_colaborador"]+')').prop('selected',true);

        var ruta_exp = $('#ExportarReqCarto').parent().prop('href');
        var arr_ruta = ruta_exp.split("/");
        ruta_exp = ruta_exp.replace(arr_ruta[arr_ruta.length-1],datos["idproyecto"]+"_"+datos["idreqcartografia"]);
         $('#ExportarReqCarto').parent().prop('href',ruta_exp);


        $.ajax({
          url: '/tabla_equipo_carto/'+idreqcartografia,
          type: 'POST',
          data: {idreqcartografia:idreqcartografia, _token:token},
          cache: false,
          //headers: {'X-CSRF-TOKEN':token},
          //contentType: false,
          //processData: false,
          success: function(data){
            // var datos = JSON.parse(data);

              $("#tablecartografiaequipo").html(data);
          },
          error:function (data){
            swal("Error", "Error.", "error");
          }
        })

      },
      error:function (data){
        swal("Error", "Error.", "error");
      }
    })
}

function AgregarDoc_Reque_Logistica(idproyecto) {
  // var idreqcartografia = 'hola';
  // console.log('test' + idproyecto);
    var token = $('input[name=_token]').val();
  $.ajax({
    url: '/logistica/'+idproyecto,
    type: 'POST',
    data: {idproyecto: idproyecto, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: "application/json",
    //processData: false,
    success: function(data){
      if (data) {
        var datos = JSON.parse(data);
        console.log(datos);
        var numero = datos["nrequerimiento"];
        var res = numero.split("-");
        var n = Number(res[res.length-1])+1;
        console.log(n);
        var nacata1 = gen_NuevaActa(numero);
        $('#nrequerimiento').val(nacata1);
        $('#nrequerimiento_2').val(nacata1);
        var idreqlogis = datos["idreqlogis"]+1;
        console.log(idreqlogis);
        $('#idreqlogis').val(idreqlogis);
        $("#tablelogisti").html('<thead><tr><th>Área de Logistica y Mantenimiento</th><th>Cantidad</th><th>Unidad</th><th>Descripción</th><th>Personal Asignado</th><th>Consultar</th></tr></thead>');
      }

    },
    error:function (data){
      swal("Error", "Error.", "error");
    }
  })
  $('#idjefegerente').val("0");
  $('#idsolicitante').val("0");
  $('#accion').val('1');
  $('#ExportarReqLogis').val("");
  $('#idlogistica').val("");
  $('#cantidad').val(" ");
  $('#idunidad').val(" ");
  $('#descripcion').val("");
  $('#idpersona').val(" ");
  $('#observacion').val(" ");
  document.getElementById('btnAgregar').disabled=true;
  document.getElementById('ExportarReqLogis').disabled=true;
  document.getElementById('idlogistica').disabled=true;
  document.getElementById('cantidad').disabled=true;
  document.getElementById('idunidad').disabled=true;
  document.getElementById('descripcion').disabled=true;
  document.getElementById('idpersona').disabled=true;
}

function datos_doc_req_Logistica(idreqlogistica) {
  var token = $('input[name=_token]').val();
  $.ajax({
    url: '/req_logistica/'+idreqlogistica,
    type: 'POST',
    data: {idreqlogistica:idreqlogistica, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      var datos = JSON.parse(data);
      console.log(datos);
      $('#nrequerimiento_2').val(datos["nrequerimiento"])
      $('#nrequerimiento').val(datos["nrequerimiento"]);
      $('#fecha').val(datos["fecha"]);
      $('#idjefegerente option:contains('+datos["nombre"]+' '+datos["apellidos"]+')').prop('selected',true);
      $('#idsolicitante option:contains('+datos["nombre_solicitante"]+' '+datos["apellidos_solicitante"]+')').prop('selected',true);
      $('#fecha_entrega').val(datos["fecha_entrega"]);
      $('#observacion').val(datos["observacion"]).jqteVal(datos["observacion"]);

      var ruta_exp = $('#ExportarReqLogis').parent().prop('href');
      var arr_ruta = ruta_exp.split("/");
      ruta_exp = ruta_exp.replace(arr_ruta[arr_ruta.length-1],datos["idproyecto"]+"_"+datos["idreqlogis"]);
       $('#ExportarReqLogis').parent().prop('href',ruta_exp);

      $.ajax({
        url: '/tabla_req_logistica/'+idreqlogistica,
        type: 'POST',
        data: {idreqlogistica:idreqlogistica, _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
            $("#tablelogisti").html(data);
        },
        error:function (data){
          swal("Error", "Error.", "error");
        }
      })
    },
    error:function (data){
      swal("Error", "Error.", "error");
    }
  })
  console.log("hola como estas");
}

function AgregarDoc_comite_Gerente( nacta_fake ) {
  var idreqcartografia = "hola como estas";
  var token = $('input[name=_token]').val();
  $.ajax({
    url: '/acta_comite',
    type: 'POST',
    data: {idreqcartografia:idreqcartografia, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      var datos = JSON.parse(data);
      // console.log(datos);
    var n = parseInt(datos["nacta"])+1;
      $('#accion').val('1');
      $('#nacta_fake').val(nacta_fake);
      $('#pvad').val(n);
      $('#idcomite').val(n);
      $('#idarea option:contains(-Seleccione un area-)').prop('selected',true);
      $('#tema').val(" ");
      $('#fecha_hora').val(" ");
      $('#idencargado option:contains(-Seleccione un Gerente/Jefe-)').prop('selected',true);
      $('#personaacta option:contains(--Seleccione un Trabajador--)').prop('selected',true);
      $("#cargo").html('<option>-Seleccione un cargo-</option>');
      $('#TableComiteGerentes').html('<thead><tr><th>Nº</th><th>Nombre</th><th>Cargo</th><th>Eliminar</th></tr></thead>');
      $('#revision').val(" ");
      $('#avances').val(" ");
      $('#encargados').val(" ");
      $('#resultadoagregarfirmantescomite').html('<table class="table"><thead><tr><th>Nº</th><th>Gerencia</th><th>Nombre</th><th>Cargo</th><th>Correo</th><th>Estado</th><th></th></tr></thead>');
      $('#TablaNotificadosComite').html('<table class="table"><thead><tr><th>Nº</th><th>Gerencia</th><th>Nombre</th><th>Cargo</th><th>Correo</th><th>Estado</th></tr></thead>');
    }
  })
}

function datos_doc_Comite(id, nacta_fake) {
  var token = $('input[name=_token]').val();
  $.ajax({
    url: '/consultar/'+id,
    type: 'POST',
    data: {id:id, _token:token},
    cache: false,
    //headers: {'X-CSRF-TOKEN':token},
    //contentType: false,
    //processData: false,
    success: function(data){
      var datos = JSON.parse(data);
      console.log(datos);
      $('#accion').val('2');
      $('#nacta_fake').val(nacta_fake);
      $('#pvad').val(datos["nacta"]);
      $('#idcomite').val(datos["nacta"]);
      $('#idcomite2').val(datos["idcomite"]);
      $('#tema').val(datos["tema"]);
      $('#fecha_hora').val(datos["fecha_hora"]);
      $('#hora').val(datos["hora"]);
      $('#idarea').val(datos["idarea"]);
      $('#idencargado').val(datos["idencargado"]);
      $('#fecha_prox_reu').val(datos["fecha_prox_reu"]);
      $('#revision').val(datos["revision"]);
      $('#avances').val(datos["avances"]);
      $('#encargados').val(datos["encargados"]);
      $.ajax({
        url: '/consultar_tabla/'+datos["nacta"],
        type: 'POST',
        data: {id:datos["nacta"], _token:token},
        cache: false,
        //headers: {'X-CSRF-TOKEN':token},
        //contentType: false,
        //processData: false,
        success: function(data){
          console.log(datos["nacta"]);
            $("#TableComiteGerentes").html(data);
            $.ajax({
              url: '/consultar_firmas/1/'+datos["nacta"],
              type: 'POST',
              data: {id:datos["nacta"], _token:token},
              cache: false,
              //headers: {'X-CSRF-TOKEN':token},
              //contentType: false,
              //processData: false,
              success: function(data){
                $("#TablaNotificadosComite").html(data);
                // $("#resultadoagregarfirmantescomite").html(data);
                $.ajax({
                  url: '/consultar_firmas/2/'+datos["nacta"],
                  type: 'POST',
                  data: {id:datos["nacta"], _token:token},
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  //contentType: false,
                  //processData: false,
                  success: function(data){
                    $("#resultadoagregarfirmantescomite").html(data);

                  }
                })
              }
            })
        }
      })
    }
  })
}

$( "#exportar" ).click(function() {
  var idcomite = $('#idcomite2').val();
  if (idcomite > 0) {
    $("#exportar").attr("href", "/inicio/com_gerentes/exportar/"+idcomite+"");
  }else {
    swal("Error", "Acta no guardada.", "error");
  }
});

$( "#exportar_reunion_menu" ).click(function() {
  var idacta = $('#idacta').val();
  var idnuevaacta = $('#idnuevaacta').val();

  if (idacta != idnuevaacta ) {
    $("#exportar_reunion_menu").attr("href", "/actareumenu/exportaractareu/"+idacta+"");
  }else {
    swal("Error", "Acta no guardada.", "error");
  }
});



function EscogerActas() {
 swal({
  title: "Escoger",
  text: "De click en el botón con el nombre del acta que desea realizar",
  timer: 5000,
  type: "info",
  showCancelButton: true,
  confirmButtonColor: "#559BDD",
  confirmButtonText: "Acta Comité",
  cancelButtonText: "Acta Reunión",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    window.location.href='/comit/gerentes';
  } else {
    window.location.href='/acta/gerentes';
  }
});
}


function recargar_pag(){
  setTimeout(function(){document.location.reload();},100);
}