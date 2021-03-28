$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


function datos_doc_menu(idproyecto) {
	//alert("prueba aqui");
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
                var select = $('#idencargado');
                select.val(datos['idencargado']);
                $('#temas').val(datos['temas']);
                $('#hora').val(datos['hora']);
                $('#acciones').val(datos['acciones']);
                $('#fecha_requerida').val(datos['fecha_requerida']);
                $('#accion_guardar').val('2');
                document.getElementById('exportar_reunion_menu').href ="/actareumenu/exportaractareu/"+datos['idacta_reunion'];
                actualizarlistanotificados_menu(datos['idacta_reunion'],13,token);
                $.ajax({

                  url:'/firmas/'+datos['idacta_reunion'],
                  type: 'POST',
                  data: {id:datos['idacta_reunion'],idproyecto:idproyecto, _token:token},
                  cache: false,
                  //headers: {'X-CSRF-TOKEN':token},
                  contentType: false,
                  processData: false,
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


function guardarReporte(){

  var f = $(this);//tampoco se
  var op = $("#op").val();
  var accion = $("#accion").val();
  var idproyecto=$("#idproyecto").val();
  var file = $("#file")[0].files[0];
  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();
  var idreporteho = $('#idreporteho').val();
  formData.append("op", op);
  formData.append("accion", accion);
  formData.append("idproyecto", idproyecto);
  formData.append("file", file);
  formData.append("idreporteho", idreporteho);

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
    url: "/ajax/reporteho",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

      swal("Enviado!", "Datos registrados correctamente.", "success");


    $("#resultado").html(data);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});

}


function eliminarReporte(idproyecto){

 swal({
  title: "Eliminar",
  text: "Confirme la eliminacion",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){


   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/reporteho',//archivo donde llegan los datos
      data:{op:2,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultado").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}




function guardarReportesa(){

  var f = $(this);//tampoco se
  var op = $("#op").val();
  var accion = $("#accion").val();
  var idproyecto=$("#idproyecto").val();
  var file = $("#file")[0].files[0];
  var fileName = file.name;
  var fileSize = file.size;
  var formData = new FormData();
  var idsolicitudac = $('#idsolicitudac').val();

  formData.append("op", op);
  formData.append("accion", accion);
  formData.append("idproyecto", idproyecto);
  formData.append("file", file);
  formData.append("idsolicitudac",idsolicitudac);

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
    url: "/ajax/solicitudac",//url
    type: "post",//tipo post
    dataType: "html",
    data: formData,//se manda con todo por la foto
    cache: false,
    contentType: false,
    processData: false,
    success:function(data){

      swal("Enviado!", "Datos registrados correctamente.", "success");


    $("#resultado").html(data);

    },
    error:function (data){
          swal("Error", "Error.", "error");
    }
    });
});

}


function eliminarReportesa(idproyecto){

 swal({
  title: "Eliminar",
  text: "Confirme la eliminacion",
  type: "info",
  showCancelButton: true,
  closeOnConfirm: false,
  showLoaderOnConfirm: true,
},
function(){


   $.ajax({//envio por ajax
      type:'post',//tipo post
      url:'/ajax/solicitudac',//archivo donde llegan los datos
      data:{op:2,idproyecto:idproyecto},//opcion 1 es para consultar grados
      success:function(data){//si se ejecuto correctamente
      $("#resultado").html(data);//muestra lo procesado en la url. #Resultado_Grado es el id de un div donde se muestra el resultado

      },
      error:function (data){
          swal("Error", "Error", "error");
      }

    });
});

}
