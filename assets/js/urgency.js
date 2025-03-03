$(document).ready(function (e) {
   let isEdit = false;
   var date = new Date();
   var currentYear = date.getFullYear();

   $("#RG_FECHA_NAC_PACIENTE").datepicker({
      yearRange:"1900:"+currentYear,
      dateFormat: "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
   });
// CONDICION URGENCIA
   $("body").on('click','.box',function(){
      let triage = $(this).data('triage');
      let bg,color ="";
      
      if(triage === "I"){
         bg = "red"; color = "white";
      }else if(triage === "II"){
         bg = "orange"; color = "black";
      }else if(triage === "III"){
         bg = "yellow"; color = "black";
      }else if(triage === "IV"){
         bg = "green"; color = "white";
      }else if(triage === "V"){
         bg = "#337ab7"; color = "white";
      }
      
      $("#TRIAGE").val("Triage "+triage);
      $("#TRIAGE").css({ "background": bg, "color": color});
   })
// OPEN AND CLOSE MENU  SIGNOUT
   $('.dropdown').on('show.bs.dropdown', function() {
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
   });  
   $('.dropdown').on('hide.bs.dropdown', function() {
         $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
   });
// DATATABLES URGENCIAS
   $('#dataPatientsUrgency').DataTable({
      "language": {"url": raiz_url+"assets/plugins/dataTables/Spanish.json"},
      "dom": "<'row'<'col-md-6'<'col-lg-12'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12't>><'row'<'col-md-12'i>><'row'<'col-md-12'p>>",
      "processing" : true,
      "retrieve" : true,
      "serverSide" : true,
      "order":[],
      "ajax" :{
         url: raiz_url+"Urgency/ajax_get_all_patients",
         type: "POST",
      },
      "buttons": ['excel'],          
      "columnDefs": [
         {"targets": [0,3,4,6],"orderable" : false},
      ],
      drawCallback: function() {
         $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        })
      }
   })// Init and get ajax Urgencias dt
   $('#dataUrgency').DataTable({
      "language": {"url": raiz_url+"assets/plugins/dataTables/Spanish.json"},
      "dom": "<'row'<'col-md-6'<'col-lg-12'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12't>><'row'<'col-md-12'i>><'row'<'col-md-12'p>>",
      "processing" : true,
      "retrieve" : true,
      "serverSide" : true,
      "order":[],
      "ajax" :{
         url: raiz_url+"Urgency/ajax_get_all_urgencys",
         type: "POST",
      },
      "buttons": ['excel'],          
      "columnDefs": [
         {"targets": [0,3,4,6],"orderable" : false},
      ],
      drawCallback: function() {
         $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        })
      }
   })// Init and get ajax Urgencias dt
   $("#NEW_URGENCY").validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         e.preventDefault();

         var formData = new FormData($(this)[0]);

         $.ajax({
            type: "POST",
            url: raiz_url + "Urgency/ajax_add_urgency_by_patient",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
         })
         .done(function (response) {
            var json = JSON.parse(response);
            var success = json.true;

            if (success) {

               Swal.fire({
                  title: 'Urgencia Registrada!',
                  icon: 'success',
                  showConfirmButton: false,
                  timer:2500,
                  onClose: function(){
                     window.location.href = raiz_url + "Urgency/index";
                  },
                })

            } else {
               Swal.fire({
                  icon: 'error',
                  title: 'Hubo un error al registrar!',
                  showConfirmButton: false,
                  timer: 1500
               })
            }
         })
      }
   })// Submit nueva urgencia

// MODAL FICHA DIAGNOSTIC ===========================//
   $("body").on("click", "#BTN_FICHA_CLINICA_U", function (event) {
      let id_tarifa   = $(this).data('id_tarifa');
      let id_patient  = $(this).data('id_paciente');
      let id_urgencia = $(this).data('id_urgencia');

      $.ajax({
         type: "POST",
         url: raiz_url + "Urgency/ajax_get_urgency_by_id",
         data: { urgencia: id_urgencia, paciente: id_patient, tarifa: id_tarifa }
      })
      .done(function (respuesta) {
         let json = JSON.parse(respuesta);
         let patient = json.Paciente;
         let urgency = json.Urgencia;
         let doctors = json.Medicos;         

         var options = { day: 'numeric' , month: 'numeric', year: 'numeric'};
         var FechaIngreso  = new Date(urgency.FECHA_URGENCIA+'T00:00:00');
         var FechaEgreso  = new Date(urgency.FECHAEGRESO_URGENCIA+'T00:00:00');

         var fmt_FechaIngreso = FechaIngreso.toLocaleDateString("es-MX",options);
         var fmt_FechaEgreso  = "";
         
         if(urgency.FECHAEGRESO_URGENCIA != null){
             fmt_FechaEgreso = FechaEgreso.toLocaleDateString("es-MX",options);
         }else{
             FechaEgreso = new Date();
             /* fmt_FechaEgreso = FechaEgreso.toLocaleDateString("es-MX",options); */
             fmt_FechaEgreso = "Sin registrar";
         }

         set_medico_urgencia(doctors, urgency.ID_MEDICO);
         $("#ID_TARIFA").val(urgency.ID_TARIFA);
         $("#ID_PACIENTE").val(urgency.ID_PACIENTE);
         $("#ID_URGENCIA").val(urgency.ID_URGENCIA);

         $("#NOMBRE_PACIENTE").html(patient.NOMBRE_PACIENTE + ' ' + patient.APELLIDO_PATERNO_PACIENTE + ' ' + patient.APELLIDO_MATERNO_PACIENTE);
         $("#ORIGEN").val(urgency.ORIGEN_URGENCIA);
         $("#CONDICION").val(urgency.CONDICION_URGENCIA);
         $("#INICIOEVOLUCION").val(urgency.INICIOEVOLUCION_URGENCIA);
         $("#SIGNOS_VITALES").val(urgency.SIGNOS_VITALES);
         $("#FC").val(urgency.FC_URGENCIA);
         $("#RC").val(urgency.RITMO_CARDIACO_URGENCIA);
         $("#TEMP").val(urgency.TEMP_URGENCIA);
         $("#FR").val(urgency.FR_URGENCIA);
         $("#SAT").val(urgency.SAT_URGENCIA);
         $("#GC").val(urgency.GLICEMIA_CAPILAR_URGENCIA);
         $("#EVOLUCION").val(urgency.EVOLUCION_URGENCIA);
         $("#MANEJO_INTRAHOSPITALARIO").val(urgency.MANEJO_INTRAHOSPITALARIO_URGENCIA);
         $("#TRATAMIENTO").val(urgency.TRATAMIENTO_URGENCIA);
         $("#FECHA_INGRESO").val(fmt_FechaIngreso);
         $("#HORA_INGRESO").val(urgency.HORA_URGENCIA);
         $("#MOTIVO").val(urgency.MOTIVO_URGENCIA);
         $("#DIAGNOSTICO").val(urgency.DIAGNOSTICO);
         $("#EXPLORACION").val(urgency.EXPLORACION_FISICA);
         $("#ANTECEDENTES").val(patient.ANTECEDENTES_PACIENTE);
         $("#OBSERVACION").val(urgency.OBSERVACION_URGENCIA);
         $("#DESTINO").val(urgency.DESTINO);
         $("#DIAGNOSTICO_EGRESO").val(urgency.DIAGNOSTICO_EGRESO);
         $("#FECHA_EGRESO").val(fmt_FechaEgreso);
         $("#HORA_EGRESO").val(urgency.HREGRESO_URGENCIA);
      })
      $("#ficha_diagnostico").modal('toggle');
   })//recibo y muestro info en campos del modal
   $("#BTN_EDIT_DIAGNOSTIC_U").click(function () {

      let obj = $("#FORM_URGENCIA");
      obj.find(".require ").each(function () {

         var isDisabled = $(this).attr('readonly', true);
         if (isDisabled) {
            $(this).removeAttr('readonly')
         } else {
            return false;
         }

      })
      $(this).hide();
      $("#BTN_SUBMIT_DIAGNOSTIC_U").show();
      $("#BTN_CANCEL_DIAGNOSTIC_U").show();
   })// Habilito el modo edicion
   $("#BTN_CANCEL_DIAGNOSTIC_U").click(function () {

      let obj = $("#FORM_URGENCIA");
      obj.find(".require ").each(function () {

         var isDisabled = $(this).attr('readonly', true);
         if (isDisabled) {
            $(this).attr('readonly')
         } else {
            return false;
         }

      })
      $(this).hide();
      $("#BTN_SUBMIT_DIAGNOSTIC_U").hide();
      $("#BTN_EDIT_DIAGNOSTIC_U").show();
   })// Cancelo el modo edicion
   $("#BTN_SUBMIT_DIAGNOSTIC_U").click(function () {

      var formData = new FormData($("#FORM_URGENCIA")[0]);

      $.ajax({
         type: "POST",
         url: raiz_url + "Urgency/ajax_update_urgency",
         data: formData,
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
            let obj = $("#FORM_URGENCIA");
            obj.find(".require ").each(function () {

               var isDisabled = $(this).attr('readonly', true);
               if (isDisabled) {
                  $(this).attr('readonly')
               } else {
                  return false;
               }

            })
            $("#BTN_CANCEL_DIAGNOSTIC_U").hide();
            $("#BTN_SUBMIT_DIAGNOSTIC_U").hide();
            $("#BTN_EDIT_DIAGNOSTIC_U").show();
         }
      });
   }) //Envio los cambios de edicion
   function set_medico_urgencia(doctors, id_medico_urgency) {
      var html = "<option value='' disabled>Elige un médico</option>";
      var sel = "";

      for (let i = 0; i < doctors.length; i++) {
         const id_medico = doctors[i]['ID_USUARIO'];
         const nombre_medico = doctors[i]['NOMBRE_USUARIO'];

         if (id_medico == id_medico_urgency) {
            sel = "selected";
         } else {
            sel = "";
         }

         html += "<option " + sel + " value='" + id_medico + "'>" + nombre_medico + "</option>";

      }
      $("#MEDICO").html(html);

   }
//MODIFICAR TARIFA FICHA CONSUMO URGENCIAS
$("#tarifa_select_urgency").change(function(){
   let desc = $(this).find(':selected').data('desc');
   let name = $(this).find(':selected').data('name');
   let precioU = $(this).find(':selected').data('precio_urgencia');
   let selectVal = $(this).val();
   let ficha = $("#id_ficha").val();

   $("#DESC_TARIFA_U").val(desc);
   $("#precio_urgencia").val(precioU);
   $(".type_modal").text(name);
   get_totalU(desc,ficha);
         
   $.ajax({
      type: "POST",
      url: raiz_url+"Urgency/change_tarifa_urgency",
      data: {ficha:ficha , id_tarifa:selectVal},
      dataType: "POST",
      success: function (response) {
        
      }
   });

})
// MODAL FICHA CONSUMO  ============================== //
   $("#BTN_EDIT_FICHA_U").click(function () {
      let html = $(this).html();
      if (html === 'Editar') {
         isEdit = true;
         $(this).html('Terminar').toggleClass('btn-info').toggleClass('btn-success');
         $("#DESC_TARIFA_U").attr('readonly', false);
         $("#FOLIO_URGENCIA").attr('readonly', false);
         $("#FOLIO_URGENCIA_M").attr('readonly', false);
         $(".product-quantity").attr('readonly',false);
          if($("#id_tarifa").val()>0){
         $("#tarifa_edit_urgency").toggle();
         $("#labelTypeU").toggle();
         }
      } else {
         
         $(".product-quantity").attr('readonly',false);
         isEdit = false;
         $(this).html('Editar').toggleClass('btn-success').toggleClass('btn-info');
        
            $.ajax({
               type: "post",
               url: raiz_url+"Urgency/ajax_edit_total_pagado",
               data: {
                     TotPag:$("#TOTAL_PAGADO_URGENCIA").val(),
                     ficha:$("#id_ficha").val()
               },        
               success:function(){
                  $('#dataUrgency').DataTable().ajax.reload();
               }  
            });
        
         
         if($("#id_tarifa").val() > 0){
            $("#DESC_TARIFA_U").attr('readonly',true);
            $.ajax({
               type: "post",
               url: raiz_url+"Urgency/ajax_edit_desc_tarifa",
               data: {desc:$("#DESC_TARIFA_U").val(),
                     TotPag:$("#TOTAL_PAGADO_URGENCIA").val(),
                     FolUrg:$("#FOLIO_URGENCIA").val(),
                     ficha:$("#id_ficha").val(),
                     urgencia:$("#id_urgencia").val()
               },        
               success:function(data){
                  if(data == 'repetido'){
                     Swal.fire({
                        title: 'Atención!',
                        text: 'Folio repetido',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2500
                     });
                  }else{
                     if(data == 'no ficha'){
                        Swal.fire({
                           title: 'Atención!',
                           text: 'Ficha no creada',
                           icon: 'warning',
                           showConfirmButton: false,
                           timer: 2500
                        });
                     }else{
                        $('#dataConsult').DataTable().ajax.reload(); 
                     }  
                  }
               }       
            });
         }else{
            $.ajax({
               type: "post",
               url: raiz_url+"Urgency/ajax_edit_desc_tarifa",
               data: {FolUrgM:$("#FOLIO_URGENCIA_M").val(),
               ficha:$("#id_ficha").val(),
               urgencia:$("#id_urgencia").val()},
               success:function(data){
                  if(data == 'repetido'){
                     Swal.fire({
                        title: 'Atención!',
                        text: 'Folio repetido',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2500
                     });
                  }else{
                     if(data == 'no ficha'){
                        Swal.fire({
                           title: 'Atención!',
                           text: 'Ficha no creada',
                           icon: 'warning',
                           showConfirmButton: false,
                           timer: 2500
                        });
                     }else{
                        $('#dataConsult').DataTable().ajax.reload(); 
                     }  
                  }
               }  
            });
         }
         if($("#id_tarifa").val()>0){
            $("#tarifa_edit_urgency").toggle();
            $("#labelTypeU").toggle();
         }
         $.toast({
            heading: 'Éxito',
            text: 'Cambios guardados',
            showHideTransition: 'slide',
            icon: 'success',
            loader:false,
            hideAfter: 2000,
        })
      }
      $("#TOTAL_PAGADO_URGENCIA").attr('readonly',false);
            
      $(".div_adds").toggle();
      $(".del_rel").toggle();
      $(".del_relp").toggle();
      $("#BTN_PRINT_FICHA_URGENCY").toggle();
   })
   // Habilito el modo edicion
   function actualizarSeleccion() {
      var id_tarifa = $('#id_tarifa').val();
      $('#tarifa_select_urgency option').each(function() {
         $(this).prop('selected', false);
          if ($(this).val() == id_tarifa) {
              $(this).prop('selected', true);
              return false; // Esto es equivalente a 'break' en un bucle jQuery
          }
      });
  }
       // Función para establecer el valor de id_tarifa y actualizar la selección
       function setIdTarifa(value) {
         $('#id_tarifa').val(value);
         actualizarSeleccion();
     }
 
     // Exponer la función setIdTarifa globalmente si es necesario
     window.setIdTarifa = setIdTarifa;
 
   $("body").on("click", "#BTN_FICHA_CONSUMO_U", function () {

      $("#ficha_consumo").modal('toggle');

      let ficha = $(this).data('id_ficha');
      let membresia = $(this).data('membresia');
      let tarifa = $(this).data('desc_tarifau');// tarifa = (tarifa ? tarifa.replace(".00", "") : "");    
      
      $("#id_ficha").val(ficha);
      setIdTarifa($(this).data('id_tarifa'));
     // $("#id_tarifa").val($(this).data('id_tarifa'));
      $("#id_urgencia").val($(this).data('id_urgencia'));
      $("#id_paciente").val($(this).data('id_paciente'));
      $("#close_urgencia").val($(this).data('close'));
      $("#paciente_name").html($(this).data('nombre_paciente'));
      $("#FOLIO_URGENCIA").val($(this).data('folio_urgencia'));
      $("#FOLIO_URGENCIA_M").val($(this).data('folio_urgencia_m'));
         
      get_procedimientos(ficha);
      get_productos(ficha,tarifa);
      
      if ($(this).data('id_tarifa')){
         /* $("#TH-DESC").show(); */
         $("#DESC_TARIFA_U").val(tarifa);
         $("#FOOTER_T_U").show();
         $("#FOOTER_M_U").hide();
         $("#TYPE").html("TARIFA "+"<font class='type_modal'>"+$(this).data('tarifa')+"</font>");
         $("#DIV_PRECIO_PROCE").show();
         $("#precio_urgencia").val($(this).data('precio_urgency'));
         get_totalU(tarifa,ficha);
      }else{
         /* $("#TH-DESC").hide(); */
         $("#MEMBRESIA").val(membresia);
         $("#FOOTER_M_U").show();
         $("#FOOTER_T_U").hide();
         $("#DESC_TARIFA_U").val("");
         $("#DIV_PRECIO_PROCE").hide();
         $("#TYPE").html("MEMBRESIA "+"<font class='type_modal'>"+$(this).data('membresia')+"</font>");
         $("#precio_urgencia").val(0);

         get_totalU(0,ficha);
      }
      if ($(this).data('close')===0){
         $("#BTN_EDIT_FICHA_U").show();
      }else{
         $("#BTN_EDIT_FICHA_U").hide();
      }
   })// Envio parametros para que me de los rows de rel procedimiento y productos

// MODAL REL PROCEDIMIENTO ========================== //
   $("#SUBMIT_REL_PROCEDIMIENTO_U").click(function () {
      var formData = new FormData();

      var msj_cant = '';
      var ficha    = $("#id_ficha").val();
      var tarifa   = $("#id_tarifa").val();
      var descuento= $("#DESC_TARIFA_U").val();
      var urgencia = $("#id_urgencia").val();
      var paciente = $("#id_paciente").val();
      var select   = $("#select_procedimiento").val();
      var cant     = $("#cant_relprocedimiento").val();
      var precioPC = $("#proc_costo").val();
      
      formData.append('precio_proce', precioPC);
      formData.append('cantidad', cant);
      formData.append('id_ficha', ficha);
      formData.append('id_tarifa', tarifa);
      formData.append('id_urgencia', urgencia);
      formData.append('id_paciente', paciente);
      formData.append('id_procedimiento', select);

      if (select === '') {
         $("#msj_validSelect_proc")
           .show()
           .delay(2000)
           .fadeOut("fast");
      }
      else if(cant <= 0){
         $("#msj_validCant_proc")
           .show()
           .delay(2000)
           .fadeOut("fast");
      }
      else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Urgency/ajax_insert_relProcedimiento",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function (id_ficha) {
               $("#id_ficha").val(id_ficha);
               get_procedimientos(id_ficha);
               get_totalU(descuento,id_ficha);

               cant == 1 ? msj_cant = '  Procedimiento' : msj_cant = '  Procedimientos';

               $("#msj_cant_proc")
                  .html(cant+msj_cant);
               $("#proce_submit")
                  
                  .delay(1500)
                  .fadeOut("fast")
                  .css('display','inline-block');
            },
            complete:function(){
               $("#select_procedimiento").prop('selectedIndex',0);
               $("#cant_relprocedimiento").val('1');
            },
         });
      }

   })// Inserto los procedimieintos en rel-procedimiento
   $("body").on("click", "#del_rel_U", function (event) {
      event.preventDefault();

      var id = $(this).data('idrel');
      var ficha = $(this).data('id_ficha');
      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');
      $.ajax({
         url: raiz_url + "Urgency/ajax_delete_relProcedimiento",
         type: "POST",
         data: {
            id_rel: id,
            id_ficha: ficha
         },
      })
      .done(function (respuesta) {
         let desc = $("#DESC_TARIFA_U").val();
         get_procedimientos(ficha);
         get_totalU(desc,ficha);

      })

   })// Cacheo el id procedimiento a eliminar
   function get_procedimientos(ficha) {
      let id_ficha = ficha;
      $.ajax({
         type: "POST",
         url: raiz_url + "Urgency/ajax_get_procedimientos",
         data: { id_ficha: ficha },
         dataType: 'json',
      })
      .done(function (response) {
         var html = "";
         var display="";
         if(response.length > 0){
            $("#msj_tableEmptyProce").hide();
            if ($("#BTN_EDIT_FICHA_U").html() === 'Terminar') {
               display = "";
            } else {
               display = "none";
            }
            for (let i = 0; i < response.length; i++) {
               const nombre = response[i]['NOMBRE_PROCEDIMIENTO'];
               const cant = response[i]['CANT_PROCEDIMIENTO'];
               const precio = response[i]['PRECIO_PROCEDIMIENTO'];
               const id = response[i]['ID'];

               html += "<tr><td class='td-hidden'>" + nombre + "</td>" +
                  "<td>" + cant + "</td>" +
                  "<td>$" + precio + "</td>" +
                  "<td><a class='del_rel btn' style='display:"+display+"' href='#'  data-id_ficha='" + id_ficha + "' data-idrel='" + id + "' id='del_rel_U'> <i class='fas fa-trash-alt'></i></a> </td></tr>";
            }
         }else{
            $("#msj_tableEmptyProce").show();
         }
         $("#tbody_procedimientos").html(html);
      });
   }// Obtengo los procedimientos by id ficha  from rel_procedimientos

// MODAL REL PRODUCTO ===============================//
   $("#SUBMIT_REL_PRODUCTO_U").click(function () {
      let formData = new FormData();
      var cant   = $("#cant_relproducto").val();
      var ficha  = $("#id_ficha").val();
      var tarifa = $("#id_tarifa").val();
      var select = $("#select_producto").val();
      var urgencia = $("#id_urgencia").val();
      var paciente = $("#id_paciente").val();
      var descuento= $("#DESC_TARIFA_U").val();
  
      
      formData.append('id_urgencia', urgencia);
      formData.append('id_paciente', paciente);
      formData.append('cantidad', cant);
      formData.append('id_ficha', ficha);
      formData.append('id_tarifa', tarifa);
      formData.append('id_producto', select);

      if (select === '') {
         $("#msj_validSelect_product")
            .show()
            .delay(2000)
            .fadeOut("fast");
      }
      else if(cant <= 0){
         $("#msj_validCant_product")
           .show()
           .delay(2000)
           .fadeOut("fast");
      }
      else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Urgency/ajax_insert_relProducto",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (id_ficha) {
               cant == 1 ? msj_cant = ' Producto' : msj_cant = ' Productos';
               $("#id_ficha").val(id_ficha);
               get_productos(id_ficha);
               get_totalU(descuento,id_ficha);

               $("#msj_cant_prod")
                  .html(cant+msj_cant);
               $("#produ_submit")
                  .delay(1500)
                  .fadeOut("fast")
                  .css('display','inline-block');
            },
            complete:function(){
               $("#select_producto").prop('selectedIndex',0);
               $("#cant_relproducto").val('1');
            },
         });
      }

   })//Inserto los productos en rel -producto
   $("body").on("click", "#del_relp_U", function (event) {
      event.preventDefault();

      var id = $(this).data('idrelp');
      var ficha = $(this).data('id_ficha');
      let tarifa= $("#DESC_TARIFA_U").val();

      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');
      $.ajax({
         url: raiz_url + "Urgency/ajax_delete_relProducto",
         type: "POST",
         data: {
            id_relP: id,
            id_ficha: ficha
         }
      })
      .done(function (respuesta) {
         let desc = $("#DESC_TARIFA_U").val();
         get_productos(ficha,tarifa);
         get_totalU(desc,ficha);

      })

   })// Cacheo el id producto a eliminar
   function get_productos(ficha) {
      let id_ficha = ficha;
      $.ajax({
         type: "POST",
         url: raiz_url + "Urgency/ajax_get_productos",
         data: { id_ficha: ficha },
         dataType: 'json',
      })
      .done(function (response) {
         var html2 = "";
         var display= "";
         if(response.length > 0){
            $("#msj_tableEmptyProdu").hide();
            display = ($("#BTN_EDIT_FICHA_U").html() === 'Terminar' ? "" : "none");

          /*   if(tarifa){               
               tarifa = (tarifa ? tarifa.replace(".00", "") : "");
               for (let i = 0; i < response.length; i++){
                  const nombre = response[i]['NOMBRE_PRODUCTO'];
                  const cant = response[i]['CANT_PRODUCTO'];
                  const precio = response[i]['PRECIO_PRODUCTO'];
                  const id = response[i]['ID'];
                  
                  html2 += 
                  "<tr>" +
                     "<td class='td-hidden'><span title='"+nombre+"'>" + nombre + "</span></td>" +
                     "<td>" + tarifa + "%</td>" +
                     "<td>" + cant + "</td>" +
                     "<td>$" + precio + "</td>" +
                     "<td> <a class='btn del_relp' style='display:" + display + "' data-idrelp='" + id + "' data-id_ficha='" + id_ficha + "' id='del_relp_U'>" +
                     "<i class='fas fa-trash-alt'</a></td>" +
                  "</tr>";
               }
            }else{ */
               for (let i = 0; i < response.length; i++) {
                  const nombre = response[i]['NOMBRE_PRODUCTO'];
                  const cant = response[i]['CANT_PRODUCTO'];
                  const precio = response[i]['PRECIO_PRODUCTO'];
                  const id = response[i]['ID'];
                  
                  let readonly = isEdit ? "" : "readonly";
                  html2 += 
                  "<tr>" +
                     "<td>" + nombre + "</td>" +
                     "<td>" +
                     "<input type='number' class='product-quantity form-control '" + readonly + "  value='" + cant + "' data-idrelp='" + id + "' />" +
                     "</td>" +
                     "<td>$" + precio + "</td>" +
                     "<td> <a class='btn del_relp' style='display:" + display + "' data-idrelp='" + id + "' data-id_ficha='" + id_ficha + "' id='del_relp_U'>" +
                     "<i class='fas fa-trash-alt'</a></td>" +
                  "</tr>";
               }
          /*   } */

         }else{
            $("#msj_tableEmptyProdu").show();
         }
         $("#tbody_productos").html(html2);
      });
   }// Obtengo los productos by id ficha from rel_productos
   
   $('body').on("change", ".product-quantity", function (e) {
      var idrel = $(this).data('idrelp');
      $.ajax({
         url: raiz_url + "Urgency/ajax_update_cantidad_producto",
         type: 'POST',
         data: {id:idrel, cantidad: $(this).val()},
         success: function (id_ficha) {
            if (id_ficha > 0) {
               var descuento = $("#DESC_TARIFA_U").val() || 0;
               get_productos(id_ficha);
               get_totalU(descuento,id_ficha);
            }
         }
      }); 
   } );
// ADJUNTAR ARCHIVOS ==================================//
   $('body').on("click", ".btn-del-file-client_U", function (e) {
      var ID_URGENCIA = $(this).attr('data-id-urgencia');
      var ID_DOCUMENTO = $(this).attr('data-id-document');
      var NOMBRE_DOCUMENTO = $(this).attr('data-document-name');
      $.ajax({
         url: raiz_url + "Urgency/ajax_delete_file_by_id",
         type: 'POST',
         data: {ID_URGENCIA:ID_URGENCIA,ID_DOCUMENTO:ID_DOCUMENTO,NOMBRE_DOCUMENTO:NOMBRE_DOCUMENTO},
         success: function (data) {
            if (data > 0) {
               console.log("BORRANDO" + data);
               load_tbody_files();
            }
         }
      });

      load_tbody_files();


   });// Elimino archivo by id
   $('body').on("click", "#BTN_ADJUNTAR_ARCHIVO_U", function(){
      $("#ID_URGENCIA_U").val($(this).data('id_urgencia'));

      load_tbody_files();
      $("#modAddFiles").modal('toggle');
   })// Al abrir el modal listo los archivos existentes
   $("#formFilesClient_U").on('submit', (function (e) {
      e.preventDefault();
      $.ajax({
         url: raiz_url + "Urgency/ajax_subir_archivo",
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

            }
            else if (data == -2) {
               $("#divMensajesFiles").html("<span class='error text-left' style='color:#F00;'><b>El archivo ha excedido el tamaño maximo permitido 40MB..</b></span>");

            }
         },
         error: function () {

            $("#divMensajesFiles").html("<span class='error text-left'><b>Ha ocurrido un error..</b></span>");
         }
      });
   }));// Envio peticion para insertar nuevos archivos
   function load_tbody_files() {
      $('#userfile').val('');
      var ID_URGENCIA = $('#ID_URGENCIA_U').val();
      //  $('#modAddFiles').modal('toggle');

      $.ajax({
         url: raiz_url + "Urgency/ajax_get_files_urgency",
         type: 'POST',
         data: 'ID_URGENCIA=' + ID_URGENCIA,
         success: function (data2) {

            if (data2.length > 0) {
               var cont = 1;

               $("#tbodyTableFilesClient").empty();

               $.each(data2, function (arrayID, row) {
                  $("#tbodyTableFilesClient").append("<tr>"+
                    "<td style='width: 15%'><b>" + cont + "</b></td><td style='width: 55%'>" + row.NOMBRE_DOCUMENTO + "</td>\n\
                     <td style='width: 15%' >" + row.TIPO_DOCUMENTO + "</td>\n\
                     <td style='width: 70%'>"+
                        "<div class='pull-right '>"+

                           "<button id='btnDeleteFileClient' class='btn btn-danger btn-actions pull-left btn-del-file-client_U' data-original-title='Borrar archivo' data-toggle='tooltip' data-document-name='"+ row.NOMBRE_DOCUMENTO + "' data-id-urgencia='" + row['ID_URGENCIA'] + "' data-id-document='" + row['ID_DOCUMENTO'] + "'>\n\
                                 <i class='fa fa-trash' aria-hidden='true'></i>\n\
                           </button> "+

                           "<a href='" + raiz_url + 'FILES/' + row.NOMBRE_DOCUMENTO + "' target='_blank' id='btnDownloadFileClient' class='btn pull-right btn-success      btn-down-file-client_U' data-original-title='Descargar archivo' data-toggle='tooltip' style='padding: 2px 5px !important;     ' data-id-urgencia='" + row['ID_URGENCIA'] + "' data-document-name=" + row.NOMBRE_DOCUMENTO + " data-id-document='" +      row['ID_DOCUMENTO'] + "'>"+
                              "<i class='fa fa-download' aria-hidden='true'></i>\n\
                           </a>"+

                        "</div>"+
                     "</td>"+
                  "</tr>");
                  cont++;
               });

            }
            else {
               $('#tbodyTableFilesClient').empty().append('<tr><td colspan="4" ><b>No se encontraron archivos adjuntos..</b></td></tr>');
            }

         }, error: function (data) {
            ('#modAddFiles').modal('hide');
         }
      });
   }// Obtengo los archivos existentes

// ELIMINAR URGENCIAS ==================================//
   $("body").on('click','#BTN_ELIMINAR_URGENCIA', function(){

      id = $(this).data('id-urgencia');

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
               type: "POST",
               url: raiz_url+"Urgency/ajax_delete_urgency",
               data: {id_urgencia:id},
            })
            .done( function(){
               Swal.fire({
                  title: 'Registro eliminado!',
                  icon: 'success',
                  showConfirmButton : false,
                  timer:1500,
                  onClose: function(){
                     $('#dataUrgency').DataTable().ajax.reload();
                  },
               })

            })
         }
      })
   })
// REFRESH TOTAL ======================================================//
   $("#DESC_TARIFA_U").keyup(function(){
      let desc = $("#DESC_TARIFA_U").val();
      let ficha = $("#id_ficha").val();
      get_totalU(desc,ficha);
   })
// ON CHANGE ID TARIFA
   $("#ID_TARIFA").change(function(){
      $("#ID_MEMBRESIA").prop('selectedIndex',0);
      let PrecioUrgencia="";
      $.ajax({
         type: "POST",
         url: raiz_url+"Urgency/ajax_get_tarifa_by_id",
         data:{tarifa:$(this).val()},
         success: function (data) {
            let json = JSON.parse(data);
            desc = json.PORCENTAJE_TARIFA;
            name = json.NOMBRE_TARIFA;
            PrecioUrgencia = json.URGENCIA_TARIFA;
         
            $("#PRECIO_CONSULTA").val(PrecioUrgencia);
            $("#DESC_TARIFA").val(desc);
            $("#SPAN_DESC_TARIFA").html(name);
            get_total_temp(desc);
         }
      });
     
   })
// ON CHANGE ID MEMBRESIA
   $("#ID_MEMBRESIA").change(function(){
      $("#MEMBRESIA_NAME").val($("#ID_MEMBRESIA option:selected").text());

   })
// CHOOSE TYPE DESCUENTO
   $("#CHOOSE_TYPE_DESCUENTO").change(function(){
      if($(this).val()==1){
         $("#FOOTER_BY_TARIFA").show();
         $("#FOOTER_BY_MEMBRESIA").hide();
         $("#ID_TARIFA").attr('disabled', false);
         $("#ID_MEMBRESIA").attr('disabled', true);
         $("#TIPO_MEMBRESIA").attr('disabled', true);     
         $("#proc_costo").attr('readonly',false);
         $("#ID_MEMBRESIA").prop('selectedIndex',0);    

         $.ajax({
            type: "POST",
            url: raiz_url+"Urgency/ajax_get_tarifa_by_id",
            data:{tarifa:$("#ID_TARIFA").val()},
            success: function (data) {
               let json = JSON.parse(data);
               desc = json.PORCENTAJE_TARIFA;
               name = json.NOMBRE_TARIFA;
            
               $("#DESC_TARIFA").val(desc);
               $("#SPAN_DESC_TARIFA").html(name);
               get_total_temp(desc);
           
            }
         });
      }else{
         $("#proc_costo").attr('readonly',true);
         $("#FOOTER_BY_MEMBRESIA").show();
         $("#FOOTER_BY_TARIFA").hide();
         $("#ID_TARIFA").attr('disabled', true);
         $("#ID_MEMBRESIA").attr('disabled', false);     
         $("#TIPO_MEMBRESIA").attr('disabled', false);     
         $("#PRECIO_CONSULTA").val('0.00');
         $("#DESC_TARIFA").val('0.00');

         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_total_final",
            data: {descuento:'0.00'},        
            success: function (response) {
               var json = JSON.parse(response);   
               $("#TOTAL_FINAL").val(json.total);      
            }  
         });
        
      }
   })
// OPEN MODAL SEARCH ITEM
   $("#BTN_OPEN_MODAL").click(function () {
      swOpenModal("#modal");
   });// Abre modal solo si hay una tarifa o membresia elegida
   $("#BTN_OPEN_MODAL2").click(function () {
      swOpenModal("#modal2");
   });// Abre modal solo si hay una tarifa o membresia elegida
   
// FUNCTIONS =============================================================//
   $("#add_cant_product").click(function(){add($("#cant_relproducto"))})
   $("#add_cant_proc").click(function(){ add($("#cant_relprocedimiento"))})
   $("#minus_cant_product").click(function(){minus($("#cant_relproducto"))})
   $("#minus_cant_proc").click(function(){ minus($("#cant_relprocedimiento"))})

   /* CLICK DESDE FORM NEW CONSULT - FICHA CONSUMO */
   $("#add_ficha_product").click(function(){add($("#producto_cant"))})
   $("#add_ficha_proc").click(function(){ add($("#proc_cant"))})
   $("#minus_ficha_product").click(function(){minus($("#producto_cant"))})
   $("#minus_ficha_proc").click(function(){ minus($("#proc_cant"))})

   function get_totalU(desc,ficha){
      let precio_urgency = $("#precio_urgencia").val();
      let IsTarifa = $("#id_tarifa").val();

      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_costo_total",
         data: {descuento:desc, ficha:ficha, precio:precio_urgency, tarifa:IsTarifa},
         
         success: function (response) {
            var json = JSON.parse(response);
            $("#TOTAL_INDEX_U").val(json.costo);
            $("#DESCUENTO_TOTAL_INDEX_U").val(json.desc);
            $("#TOTAL_FINAL_INDEX_U").val(json.total);
            $("#TOTAL_FINAL_INDEX_T_U").val(json.total);
            $("#TOTAL_PAGADO_URGENCIA").val(json.totalpagado);
         }  
      });
   }//index
   function add(cant){
      var oldValue = cant.val();
      var sum=0;

      if(oldValue < 1){
         sum = 1;
      }else{
         sum = parseInt(oldValue) + 1;
      }
      cant.val(sum);
   }// le sumo 1 cantidad
   function minus(cant){
      var oldValue = cant.val();
      var sum=0

      if(oldValue <= 1){
         sum = 1;
      }else{
         sum = parseInt(oldValue) - 1;
      }
      cant.val(sum)
   }// le resto 1 a cantidad

   function get_total_temp(desc){
      let isMembresia = $("#ID_MEMBRESIA").val();
      let PrecioUrgency = $("#PRECIO_CONSULTA").val();
     
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_total_final",
         data: {descuento:desc,
               precio:PrecioUrgency,
               membresia:isMembresia},        
         success: function (response) {
            var json = JSON.parse(response);   
            
            $("#TOTAL").val(json.costo);
            $("#DESCUENTO_TOTAL").val(json.desc);
            $("#TOTAL_FINAL_T").val(json.total);
         }  
      });
   }
   function swOpenModal(modal){
      let type = $("#CHOOSE_TYPE_DESCUENTO").val(); type = (type == 1 ? "TARIFA" : "MEMBRESÍA");
      
      if ($("#CHOOSE_TYPE_DESCUENTO").val() <= 0) {
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            timer: 2000,
            showConfirmButton: false,
            html: '<div class="class_invalid">¡SELECCIONA UN TIPO DE DESCUENTO!</div>'
         });
      }else if($("#ID_TARIFA").val() == null && $("#CHOOSE_TYPE_DESCUENTO").val() == 1) {
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            timer: 2000,
            showConfirmButton: false,
            html: '<div class="class_invalid">¡ELIGE UNA '+type+'!</div>'
         });
      }else if($("#ID_MEMBRESIA").val() == null && $("#CHOOSE_TYPE_DESCUENTO").val() ==2) {
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            timer: 2000,
            showConfirmButton: false,
            html: '<div class="class_invalid">¡ELIGE UNA '+type+'!</div>'
         });
      } else {
         $(modal).appendTo("body").modal('show');
        /*  animation_modal(button,modal); */
        
      }
   }
   
   //-----------------------------------------------------------//
   $('#BTN_PRINT_FICHA_URGENCY').on('click', function () {
      var URGENCY_ID = $('#id_urgencia').val();    
      var close = $('#close_urgencia').val();
     
      if(close <= 0){
         Swal.fire({
            title: '¿Estás seguro?',
            html: "No se podrá <b>EDITAR</b> la ficha después de imprimir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Imprimir!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: "POST",
                  url: raiz_url + "Urgency/ajax_close_urgency",
                  data: { id_urgencia: URGENCY_ID },
               })
                  .done(function (response) {
                     if (response === "success") {
                        $('#dataUrgency').DataTable().ajax.reload();
                        $("#BTN_EDIT_FICHA_U").hide();
                        window.open(raiz_url + "Consult/creaPdfUrgency/" + URGENCY_ID);
                     } else {
                        alert('Hubo un error, intente de nuevo');
                     }
                  })

            }
         })
      }else{
         window.open(raiz_url + "Consult/creaPdfUrgency/" + URGENCY_ID);
      }
      
   });
   
   $('#BTN_PRINT_DIAG_URGENCY').on('click', function () {
      var URGENCY_ID = $('#ID_URGENCIA').val();
      if($("#FECHA_EGRESO").val() === "" || $("#FECHA_EGRESO").val() ==="Sin registrar"){
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            timer: 2000,
            showConfirmButton: false,
            html: '<div class="class_invalid">¡ESTABLECE FECHA Y HORA EGRESO!</div>'
         });
      }else{
         window.open(raiz_url + "Consult/creaPdfFichaUrgency/" + URGENCY_ID);
      }
   });
   $("body").on('click', '.btn-receta-urgency-show', function () {
      var ID_URGENCIA = $(this).attr('data-id_urgencia');
      window.open(raiz_url + "urgency/creaPdfReceta/" + ID_URGENCIA);
      
   });
})

