String.prototype.trim = function () {
   return this.replace(/^\s+|\s+$/g, "");
};

$(document).ready(function () {
   var date = new Date();
   var currentYear = date.getFullYear();

   $("#RG_FECHA_NAC_PACIENTE, #RG_FECHA_NAC_PTIENT" ).datepicker({
      yearRange:"1900:"+currentYear,
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd/mm/yy",
   });

   $('#dataPatients').DataTable({
      "dom": "<'row'<'col-lg-6 col-mdx-6 col-sm-12'fB><'col-lg-6 col-mdx-6 col-sm-12 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Patient/ajax_get_patients",
         type: "POST",
      },
      "columnDefs": [
         { "targets": [0, 4], "orderable": false },
         { "targets": [0, 1, 2, 3, 4], "className": 'text-center' },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
      trigger : 'hover'
   });
      }
   });

   //Onchange option type descuento
   $("#CHOOSE_TYPE_DESCUENTO").change(function () {
      if ($(this).val() == 1) {
         $("#divTarifa").removeClass('hidden')
         $("#divMembresia").addClass('hidden')
         $("#divPerfilMem").addClass('hidden')
         $("#divCasaMem").addClass('hidden')

         $("#ID_TARIFA").attr("disabled", false);
         $("#ID_MEMBRESIA").attr("disabled", true);
         $("#TIPO_MEMBRESIA").attr("disabled", true);
         $("#RG_CASA_MEMBRESIA").attr("disabled", true);
      } else {
         $("#divTarifa").addClass('hidden')
         $("#divMembresia").removeClass('hidden')
         $("#divPerfilMem").removeClass('hidden')
         $("#divCasaMem").removeClass('hidden')

         $("#ID_TARIFA").attr("disabled", true);
         $("#ID_MEMBRESIA").attr("disabled", false);
         $("#TIPO_MEMBRESIA").attr("disabled", false);
         $("#RG_CASA_MEMBRESIA").attr("disabled", false);
      }
      $("#RG_NOMBRE_MEMBRESIA").val("");
      $("#RG_ID_MEMBRESIA").val("");
      $('#ID_TARIFA').val('');
      $('#RG_ID_CASA').val('');
   })
   
   //Onchange house
   $("#RG_ID_CASA").on("change", function(){
       var selected = $(this).find('option:selected');
       $("#RG_NOMBRE_MEMBRESIA").val((selected.data('membership')));
       $("#RG_ID_MEMBRESIA").val(selected.data('id-membership'));
       $('#ID_TARIFA').val('');
   });

   //filtros--
   $("thead input").keyup(function () {
      /* Filter on the column (the index) of this element */
      pTable.fnFilter(this.value, $("thead input").index(this));
   });
   /*
    * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
    * the footer
    */
   $("thead input").each(function (i) {
      asInitVals[i] = this.value;
   });

   $("thead input").focus(function () {
      if (this.className == "search_init") {
         this.className = "";
         this.value = "";
      }
   });

   $("thead input").blur(function (i) {
      if (this.value == "") {
         this.className = "search_init";
         this.value = asInitVals[$("thead input").index(this)];
      }
   });

   //ADD PATIENT
   $('#formRecordPatient').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         e.preventDefault();
         $.ajax({
            url: raiz_url + "Patient/ajax_add_patient", 
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {

               if (data > 0) {
                  Swal.fire({
                     title: '¡Paciente Registrado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 2500,
                     onClose: function () {
                        window.location.href = raiz_url + "patient/index";
                     },
                  })
               } else {
                  Swal.fire({
                     title: '¡ Ya existe !',
                     text: 'Este paciente ya existe',
                     icon: 'warning',
                     showConfirmButton: false,
                     timer: 2500,
                  })
               }
            },
            error: function () {
               Swal.fire({
                  title: 'Hubo un error con el registro',
                  text: 'Revise bien los datos introducidos',
                  icon: 'warning',
                  showConfirmButton: false,
                  timer: 2500,
               })
            }
         });
      }
   });

   $('body').on("click", ".btn-edit-patient", function (e) {
      var ID_PATIENT = $(this).attr('data-id-patient');
      window.location.href = raiz_url + "patient/form_edit_patient/" + ID_PATIENT;
   });

   //EDIT COMPANY
   $('#formEditPatient').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         // everything looks good!
         e.preventDefault();

         $.ajax({
            url: raiz_url + "patient/ajax_edit_patient",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               console.log(data);
               if (data === "success") {
                  Swal.fire({
                     title: 'Cambios guardados!',
                     text: 'Se edito la información del paciente',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 2500,
                     onClose: function () {
                        window.location.href = raiz_url + "patient/index";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Realiza un cambio',
                     text: 'No hubo ningún cambio',
                     icon: 'info',
                     showConfirmButton: false,
                     timer: 2500,
                  })
               }
            }
         });
      }
   });

   //DELETE COMPANY
   $('body').on("click", ".btn-delete-patient", function (e) {
      var ID_PATIENT = $(this).attr('data-id-patient');

      if (ID_PATIENT > 0) {
         Swal.fire({
            title: '¿Estás seguro?',
            text: "No se puede revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "patient/ajax_disable_patient",
                  type: 'POST',
                  data: 'ID_PATIENT=' + ID_PATIENT,
               })
                  .done(function (data) {
                     console.log(data);
                     if (data === '1') {
                        Swal.fire({
                           title: '¡Paciente Eliminado!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              window.location.reload();
                           },
                        })
                     } else {
                        Swal.fire({
                           title: 'Error al eliminar!',
                           icon: 'error',
                           showConfirmButton: false,
                           timer: 1500,
                        })
                     }

                  });

            }
         })
      }
   });
// ADJUNTAR ARCHIVOS ========================================================//
$('body').on("click", ".btn-del-file-client", function (e) {
   var ID_PACIENTE = $(this).attr('data-id-paciente');
   var ID_DOCUMENTO = $(this).attr('data-id-document');
   var NOMBRE_DOCUMENTO = $(this).attr('data-document-name');
   $.ajax({
      url: raiz_url + "Patient/ajax_delete_file_by_id",
      type: 'POST',
      data: 'ID_PACIENTE=' + ID_PACIENTE + "&ID_DOCUMENTO=" + ID_DOCUMENTO + "&NOMBRE_DOCUMENTO=" + NOMBRE_DOCUMENTO,
      success: function (data) {
         if (data > 0) {
            console.log("BORRANDO" + data);
            load_tbody_files();


         }
      }
   });
   // $('#modAddFiles').modal('toggle');
   // $('#ID_CLIENTE').val(ID_CLIENTE);

   load_tbody_files();

});// Elimino archivo by id
$("#formFilesPatient").on('submit', (function (e) {
   e.preventDefault();
   $.ajax({
      url: raiz_url + "Patient/ajax_subir_archivo",
      type: "POST",
      data: new FormData(this),
      mimeType: "multipart/form-data",
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {

         $("#divMensajesFiles").html('<br><span class="before text-left" ><b>Adjuntando archivo...</b></span>');
      },
      success: function (data) {
         $("#divMensajesFiles").html('');
         //console.log('data insert..'+data);
         if (data > 0) {

            //TABLA QUE SE LLENE POR AJAX..
            load_tbody_files();

         } else if (data == -2) {
            $("#divMensajesFiles").html("<span class='error text-left' style='color:#F00;'><b>El archivo ha excedido el tamaño maximo permitido 40MB..</b></span>");

         }
      },
      error: function () {

         $("#divMensajesFiles").html("<span class='error text-left'><b>Ha ocurrido un error..</b></span>");
      }
   });
}));// Envio peticion para insertar nuevos archivos
$("body").on('click', '#BTN_ADJUNTAR_ARCHIVOP', function () {
   $("#ID_PACIENTE").val($(this).data('id_patient'));

   load_tbody_files();
});// Al abrir el modal listo los archivos existentes
function load_tbody_files() {
   $('#userfile').val('');
   var ID_CLIENTE = $('#ID_PACIENTE').val();
   //  $('#modAddFiles').modal('toggle');

   $.ajax({
      url: raiz_url + "Patient/ajax_get_files_patient",
      type: 'POST',
      data: 'ID_PACIENTE=' + ID_CLIENTE,
      success: function (data2) {

         if (data2.length > 0) {
            var cont = 1;

            $("#tbodyTableFilesClient").empty();

            $.each(data2, function (arrayID, row) {
               $("#tbodyTableFilesClient").append("<tr>" +
                 "<td><b>" + cont + "</b></td>"+
                 "<td>" + row.NOMBRE_DOCUMENTO + "</td>\n\
                  <td>" + row.TIPO_DOCUMENTO + "</td>\n\
                  <td>" +                     
                     "<button id='btnDeleteFileClient' class='btn btn-danger pull-left btn-actions btn-del-file-client'\n\
                        data-original-title='Borrar archivo' data-toggle='tooltip' data-document-name='"+row.NOMBRE_DOCUMENTO +"' data-id-paciente='" + row['ID_PACIENTE'] + "' data-id-document='" + row['ID_DOCUMENTO'] + "'>\n\
                        <i class='fa fa-trash' aria-hidden='true'></i>\n\
                     </button>" +
                     "<a href='" + raiz_url + 'FILES/' + row.NOMBRE_DOCUMENTO + "' download='"+row.NOMBRE_DOCUMENTO+"' id='btnDownloadFileClient' class='btn pull-right btn-success btn-actions btn-down-file-client' data-original-title='Descargar archivo' data-toggle='tooltip' data-id-paciente='" + row['ID_PACIENTE'] + "' data-document-name=" + row.NOMBRE_DOCUMENTO + " data-id-document='" + row['ID_DOCUMENTO'] + "'>" +
                        "<i class='fa fa-download' aria-hidden='true'></i>\n\
                     </a>" +                    
                  "</td>" +
                  "</tr>");
               cont++;

            });

         } else {
            $('#tbodyTableFilesClient').empty().append('<tr><td colspan="4" ><b>No se encontraron archivos adjuntos..</b></td></tr>');
         }

      }, error: function (data) {
         ('#modAddFiles').modal('hide');
      }
   });
}// Obtengo los archivos existentes

});