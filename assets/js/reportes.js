
// String.prototype.trim = function () {
// 	return this.replace(/^\s+|\s+$/g, "");
// };


$(document).ready(function () {
    
   var Table = $('#tablaReportes').dataTable({
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "dom": "<'row'<'col-md-6'><'col-md-6 text-right'l>><'row op'<'col-md-12't>><'row'<'col-md-12'i>><'row'<'col-md-12'p>>",
      buttons: [
         {
            extend: 'csv',
            text: "Excel",
            title: 'Reportes',
            exportOptions: {
               modifier: {
                  page: 'current'
               }
            }
         }
      ],
      "scrollCollapse": true
   });
   $('#BUSCAR_POR').on('change', function () {
      if ($('#BUSCAR_POR').val() == 1) {
         $('#opcion_medico').show();
         $('#opcion_paciente').hide();
      }
      else if ($('#BUSCAR_POR').val() == 2) {
         $('#opcion_medico').hide();
         $('#opcion_paciente').show();
      }
      else {
         $('#opcion_medico').hide();
         $('#opcion_paciente').hide();
      }
   });
   $('#formSearchConsultas').on('submit', function (e) {
      e.preventDefault();
      var formdata = new FormData($(this)[0]);
      $('#tablaReportes').dataTable().fnDestroy();
      if ($('#BUSCAR_POR').val() == 1) {
         getConsultas(formdata, 'report/ajax_consulta_medico');
      }
      else if ($('#BUSCAR_POR').val() == 2) {
         getConsultas(formdata, 'report/ajax_consulta_paciente');
      }
      else {
         getConsultas(formdata, 'report/ajax_consulta_todos');
      }
   });
   function getConsultas(formdata, method) {
      $.ajax({
         type: "POST",
         url: raiz_url + method,
         dataType: 'json',
         data: formdata,
         cache: false,
         contentType: false,
         processData: false,
         success: function (respuesta) {

            var html = '';
            for (let i = 0; i < respuesta.length; i++) {
               var tar_mem = "indefinida";
               $('#id_paciente').val(respuesta[i]["ID_PACIENTE"]);
               if (respuesta[i]["NOMBRE_TARIFA"] != null) tar_mem = respuesta[i]["NOMBRE_TARIFA"];
               if (respuesta[i]["NOMBRE_MEMBRESIA"] != null) tar_mem = respuesta[i]["NOMBRE_MEMBRESIA"];
               html += '<tr>' +
                  '<td><button class="btn-ver"'+
                  "data-motivo='"+ respuesta[i]["MOTIVO_CONSULTA"]+"'"+
                  "data-evolucion='"+ respuesta[i]["INICIOEVOLUCION_CONSULTA"]+"'"+
                  "data-fechaingreso='"+ respuesta[i]["FECHA_CONSULTA"]+"'"+
                  "data-hrIngreso='"+ respuesta[i]["HORA_CONSULTA"]+"'"+
                  "data-hregreso='"+ respuesta[i]["HORAEGRESO_CONSULTA"]+"'"+
                  "data-fechaEgreso='"+ respuesta[i]["FECHAEGRESO_CONSULTA"]+"'"+
                  '><i class="fas fa-eye "></i></button></td>' +
                  '<td>' + respuesta[i]["NOMBRE_PACIENTE"] + '</td>' +
                  '<td>' + respuesta[i]["NOMBRE_USUARIO"] + '</td>' +
                  '<td>' + tar_mem + '</td>' +
                  '<td>' + respuesta[i]["MOTIVO_CONSULTA"] + '</td>' +
                  '<td>' + respuesta[i]["FECHA_CONSULTA"] + '</td>' +
                  '<td>' + respuesta[i]["HORA_CONSULTA"] + '</td></tr>';
            }
            $('#tbody_reportes').html(html);
            var Table = $('#tablaReportes').dataTable({
               "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
               "dom": "<'row'<'col-md-6'<'col-lg-12'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12't>><'row'<'col-md-12'i>><'row'<'col-md-12'p>>",
               buttons: [
                  {
                     extend: 'csv',
                     text: "Excel",
                     title: 'Reportes',
                     exportOptions: {
                        modifier: {
                           page: 'current'
                        }
                     }
                  }
               ],
               "scrollCollapse": true
            });
         }
      });
   }
   $("body").on('click', '.btn-ver',function(){
      $("#ReporteByPatient").modal("show");

      $("#FECHA_INGRESO").val($(this).data('fechaingreso'));
      $("#HORA_INGRESO").val($(this).data('hringreso'));
      $("#FECHA_EGRESO").val($(this).data('fechaegreso'));
      $("#HORA_EGRESO").val($(this).data('hregreso'));
      $("#MOTIVO").val($(this).data('motivo'));

   })
   $('#formSearchUrgencias').submit(function (e) {
      e.preventDefault();
      var formdata = new FormData($(this)[0]);
      $('#tablaReportes').dataTable().fnDestroy();
      if ($('#BUSCAR_POR').val() == 1) {
         getUrgencias(formdata, 'report/ajax_urgencia_medico');
      }
      else if ($('#BUSCAR_POR').val() == 2) {
         getUrgencias(formdata, 'report/ajax_urgencia_paciente');
      }
      else {
         getUrgencias(formdata, 'report/ajax_urgencia_todos');
      }
   });
   function getUrgencias(formdata, method) {
      $.ajax({
         type: "POST",
         url: raiz_url + method,
         dataType: 'json',
         data: formdata,
         cache: false,
         contentType: false,
         processData: false,
         success: function (respuesta) {

            var html = '';
            for (let i = 0; i < respuesta.length; i++) {
               $('#id_paciente').val(respuesta[i]["ID_PACIENTE"]);
               if (respuesta[i]["NOMBRE_TARIFA"] != null) tar_mem = respuesta[i]["NOMBRE_TARIFA"];
               if (respuesta[i]["NOMBRE_MEMBRESIA"] != null) tar_mem = respuesta[i]["NOMBRE_MEMBRESIA"];
               html += '<tr>' +
                  '<td>' + respuesta[i]["NOMBRE_PACIENTE"] + '</td>' +
                  '<td>' + respuesta[i]["NOMBRE_USUARIO"] + '</td>' +
                  '<td>' + tar_mem + '</td>' +
                  '<td>' + respuesta[i]["MOTIVO_URGENCIA"] + '</td>' +
                  '<td>' + respuesta[i]["FECHA_URGENCIA"] + '</td>' +
                  '<td>' + respuesta[i]["HORA_URGENCIA"] + '</td></tr>';
            }
            $('#tbody_reportes').html(html);
            var Table = $('#tablaReportes').dataTable({
               "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
               "dom": 'lBfrtip',
               "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
               "scrollCollapse": true
            });
         }
      })
   }

   $('#formSearchProcedimientos').submit(function (e) {
      e.preventDefault();
      var formdata = new FormData($(this)[0]);
      $('#tablaReportes').dataTable().fnDestroy();
      getProcedimientos(formdata);
   });
   function getProcedimientos(formdata) {
      $.ajax({
         type: "POST",
         url: raiz_url + "report/ajax_ficha_procedimiento",
         dataType: 'json',
         data: formdata,
         cache: false,
         contentType: false,
         processData: false,
         success: function (respuesta) {

            var html = '';
            for (let i = 0; i < respuesta.length; i++) {
               html += '<tr>' +
                  '<td>' + respuesta[i]["NOMBRE_PROCEDIMIENTO"] + '</td>' +
                  '<td>' + respuesta[i]["SUM(rel.CANT_PROCEDIMIENTO)"] + '</td>' +
                  '<td>' + respuesta[i]["SUM(rel.PRECIO_PROCEDIMIENTO)"] + '</td></tr>';
            }
            $('#tbody_reportes').html(html);
            var Table = $('#tablaReportes').dataTable({
               "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
               "dom": 'lBfrtip',
               "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
               "scrollCollapse": true
            });
         }
      })
   }

   $('#formSearchProductos').submit(function (e) {
      e.preventDefault();
      var formdata = new FormData($(this)[0]);
      $('#tablaReportes').dataTable().fnDestroy();
      getProductos(formdata);
   });
   function getProductos(formdata) {
      $.ajax({
         type: "POST",
         url: raiz_url + "report/ajax_ficha_producto",
         dataType: 'json',
         data: formdata,
         cache: false,
         contentType: false,
         processData: false,
         success: function (respuesta) {

            var html = '';
            for (let i = 0; i < respuesta.length; i++) {
               html += '<tr>' +
                  '<td>' + respuesta[i]["NOMBRE_PRODUCTO"] + '</td>' +
                  '<td>' + respuesta[i]["SUM(rel.CANT_PRODUCTO)"] + '</td>' +
                  '<td>' + respuesta[i]["SUM(rel.PRECIO_PRODUCTO)"] + '</td></tr>';
            }
            $('#tbody_reportes').html(html);
            var Table = $('#tablaReportes').dataTable({
               "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
               "dom": 'lBfrtip',
               "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
               "scrollCollapse": true
            });
         }
      })
   }


   $('#BUSCAR_POR').change(function () {
      var i = $('#BUSCAR_POR').val();
      switch (i) {
         case '1':
            autocompleteResult(i);
            break;
         case '2':
            autocompleteResult(i);
            break;
      }
   });
   function autocompleteResult(selector) {
      var metodo;
      switch (selector) {
         case '1':
            metodo = 'report/ajax_obtener_medico_ap';
            break;
         case '2':
            metodo = 'report/ajax_obtener_paciente_app';
            break;
      }


      $.ajax({
         type: "POST",
         url: raiz_url + metodo,
         dataType: 'json',
         success: function (respuesta) {
            if (selector == 1) {
               var apellidos_medico = new Array();
               $.each(respuesta, function (x, medico) {
                  apellidos_medico.push(medico.APELLIDO_USUARIO);
               });
               $("#SEARCH_AP_MEDICO").autocomplete({
                  source: apellidos_medico,
                  select: function (event, ui) {
                     var apellido_medico = ui.item.value;
                     $.ajax({
                        type: "POST",
                        url: raiz_url + 'report/ajax_obtener_medico_nombre',
                        dataType: 'json',
                        data: 'apellidos_medico=' + apellido_medico,
                        success: function (respuesta) {
                           var nombres_medico = new Array();
                           $.each(respuesta, function (x, medico) {
                              nombres_medico.push(medico.NOMBRE_USUARIO);
                           });
                           /* Autocompleta los nombres obtenidos
                            */
                           $("#SEARCH_NOMBRE_MEDICO").autocomplete({
                              source: nombres_medico,
                              select: function (event, ui) {
                                 $("#SEARCH_NOMBRE_MEDICO").val(ui.item.value);
                              }
                           });
                        }
                     });
                  }
               });
            } else if (selector == 2) {
               var apellidos_paternos_pacientes = new Array();
               $.each(respuesta, function (x, paciente) {
                  apellidos_paternos_pacientes.push(paciente.APELLIDO_PATERNO_PACIENTE);
               });
               $("#SEARCH_APP_PACIENTE").autocomplete({
                  source: apellidos_paternos_pacientes,
                  select: function (event, ui) {
                     var apellido_paterno_paciente = ui.item.value;
                     $.ajax({
                        type: "POST",
                        url: raiz_url + 'report/ajax_obtener_paciente_apm',
                        dataType: 'json',
                        data: 'apellido_paterno=' + apellido_paterno_paciente,
                        success: function (respuesta) {
                           var apellidos_maternos_pacientes = new Array();
                           $.each(respuesta, function (x, paciente) {
                              apellidos_maternos_pacientes.push(paciente.APELLIDO_MATERNO_PACIENTE);
                           });
                           /*	Obtiene los nombres de los pacientes cuyos apellidos coincidan
                            *	con la busqueda hasta el momento, autocompleta los resultados.
                            */
                           $("#SEARCH_APM_PACIENTE").autocomplete({
                              source: apellidos_maternos_pacientes,
                              select: function (event, ui) {
                                 var apellido_materno_paciente = ui.item.value;
                                 $.ajax({
                                    type: "POST",
                                    url: raiz_url + 'report/ajax_obtener_paciente_nombre',
                                    dataType: 'json',
                                    data: 'apellido_paterno=' + apellido_paterno_paciente + '&apellido_materno=' + apellido_materno_paciente,
                                    success: function (respuesta) {
                                       var nombres_pacientes = new Array();
                                       $.each(respuesta, function (x, paciente) {
                                          nombres_pacientes.push(paciente.NOMBRE_PACIENTE);
                                       });
                                       /* Autocompleta los nombres obtenidos
                                        */
                                       $("#SEARCH_NOMBRE_PACIENTE").autocomplete({
                                          source: nombres_pacientes,
                                          select: function (event, ui) {
                                             $("#SEARCH_NOMBRE_MEDICO").val(ui.item.value);
                                          }
                                       });
                                    }
                                 });
                              }
                           });
                        }
                     });
                  }
               });
            }
         }
      });
   }

   $("#TIPO_DESCUENTO").change(function () {
      if ($(this).val() == 1) {
         $("#divTa").removeClass('hidden')
         $("#divMem").addClass('hidden')

         $("#BUSCAR_TARIFA").attr("disabled", false);
         $("#BUSCAR_MEM").attr("disabled", true);
      } else {
         $("#divTa").addClass('hidden')
         $("#divMem").removeClass('hidden')

         $("#BUSCAR_TARIFA").attr("disabled", true);
         $("#BUSCAR_MEM").attr("disabled", false);
      }
   })

   $("#Buscar").on("click", function () {
      $("#Historia").removeClass('hidden')
   });
   $("#Historial").on("click", function () {
      window.open(raiz_url + "Report/pdfPaciente/");
   });
   $('#formSearchPaciente').submit(function (e) {
      e.preventDefault();
      var formdata = new FormData($(this)[0]);
      $('#tablaReportes').dataTable().fnDestroy();
      getConsultas(formdata, 'report/ajax_consulta_por_paciente');
   });
   $('#btn_ver_historial').on('click', function () {
      var PACIENT_ID = $('#id_paciente').val();
      {
         window.open(raiz_url + "Report/pdfPaciente/" + PACIENT_ID);
      }

   });
   
   $('#ID_MEMBRESIA_S').on("change", function(){
       $('#form_membresia').submit();
   });
   
   $('#ID_MEMBRESIA_U').on("change", function(){
       $('#form_membresiau').submit();
   });
   //CARGAR CASAS...
    $('#btnSearchHouses').on('click', function () {
        var FECHAINI = $('#RG_FECHA_INICIAL').val();
        var FECHAFIN = $('#RG_FECHA_FINAL').val();

        $.ajax({
            type: "POST",
            url: raiz_url + "Report/ajax_search_houses",
            data: {fecha_ini: FECHAINI, fecha_fin: FECHAFIN},
            dataType: 'json',
            success: function (respuesta) {
                $('#tbody_houses').html('');
                $.each(respuesta, function(ID,row){
                    agregarFila(row.NOMBRE, row.CONSULTAS, row.URGENCIAS);
                });
             
            }
        });
    });
    
    function agregarFila(Nombre, Consultas, Urgencias) {
   
         var htmlTags = '<tr>'+
        '<td>' + Nombre + '</td>'+
        '<td>' + Consultas + '</td>'+
        '<td>' + Urgencias + '</td>'+
         '</tr>';
      
        $('#tbody_houses').append(htmlTags);
    }
    
});