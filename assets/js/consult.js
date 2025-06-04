$(document).ready(function () {
   let isEdit = false;
   $.ajax({
      type: "method",
      url: raiz_url + "Consult/ajax_get_all_consults",
      data: "data",
      dataType: "json",
      success: function (response) {
         console.log(response);
      }
   });
   $('#dataConsult').DataTable({
      "dom": "<'row'<'col-md-6'<'col-lg-12'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12't>><'row'<'col-md-12'i>><'row'<'col-md-12'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "buttons": ['excel'],
      "ajax": {
         url: raiz_url + "Consult/ajax_get_all_consults",
         type: "POST"
      },
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
         })
      }
   });
   // SEND FORM FICHA =================================================================//
   $("#NEW_CONSULT").validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         e.preventDefault();
         var formData = new FormData($(this)[0]);
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_nueva_consulta",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
         })
            .done(function (response) {
               var json = JSON.parse(response);
               ;
               var msj = json.msj;

               if (msj === 'okay') {
                  Swal.fire({
                     title: 'Registro exitoso!',
                     text: 'Se ha registrado una consulta nueva',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 2500,
                     onClose: function () {
                        window.location.href = raiz_url + "Consult/index";
                     },
                  });

                  load_tempProductos();
                  load_temProcedimientos();
                  $("#NEW_CONSULT")[0].reset();

               } else {
                  Swal.fire({
                     title: 'Error!',
                     text: 'Hubo un error al registrar, intente nuevamente',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 2500
                  });
               }
            })
            .fail(function () {
               Swal.fire({
                  title: 'Error!',
                  text: 'Hubo un error al registrar, intente nuevamente',
                  icon: 'error',
                  confirmButton: false,
                  timer: 2500
               });
            });

      }
   });
   $("#SELECT_TARIFA").change(function () {
      let percent = $(this).find(':selected').data('percent');
      let nombre = $(this).find(':selected').data('nombre');
      let precioConsult = $(this).find(':selected').data('precioconsulta');

      $("#DESC_TARIFA").val(percent);
      $("#NOMBRE_TARIFA").html(" " + nombre + " ");
      $("#PRECIO_CONSULTA").val(precioConsult);
      get_total_final(percent);
   })
   $("#SELECT_TARIFA_U").change(function () {
      let percent = $(this).find(':selected').data('percent');
      let nombre = $(this).find(':selected').data('nombre');
      let precioConsult = $(this).find(':selected').data('precioconsulta');

      $("#PRECIO_CONSULTA").val(precioConsult);
      $("#DESC_TARIFA").val(percent);
      $("#NOMBRE_TARIFA").html(" " + nombre + " ");
      get_total_final(percent);
   })
   // INIT SELECT 2 ==================================================================//
   $('#SEARCH_PROCEDIMIENTO').select2({
      placeholder: "Elige un procedimiento",
      dropdownParent: $("#modal"),
   });
   $('#SEARCH_PRODUCTO').select2({
      placeholder: "Elige un producto",
      dropdownParent: $("#modal2"),
   });

   $("#SELECT_TIPO_CONSULTA").change(function () {
      var id_tipo_consulta = $(this).val();

      if (id_tipo_consulta) {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_get_procedimientos_por_tipo",
            data: { id_tipo_consulta: id_tipo_consulta },
            dataType: "json",
            success: function (response) {
               var select = $("#SEARCH_PROCEDIMIENTO");
               select.empty(); // limpia anteriores
               select.append('<option value="" disabled selected>Elige</option>');

               if (response.length > 0) {
                  $.each(response, function (index, item) {
                     select.append('<option value="' + item.descripcion_procedimiento + '">' + item.descripcion_procedimiento + '</option>');
                  });
               }
            }
         });
      }
   });


   // MODAL FICHA CONSUMO - TEMP PROCEDIMIENTOS =====================================//
   $("#SEARCH_PROCEDIMIENTO").change(function () {
      let txt = $("#SEARCH_PROCEDIMIENTO").val();
      if (txt) {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_obtener_procedimiento",
            data: { var: txt },
            dataType: 'json',
            success: function (respuesta) {

               var costo = respuesta.row.precio_procedimiento;
               var id = respuesta.row.id_procedimiento;
               var name = respuesta.row.descripcion_procedimiento;

               $("#proc_costo").val(costo);
               $("#id_proc").val(id);
               $("#proc_cant").val('1');
               $("#proc_select").html(name);
               $("#div_costo").show();
            }
         });
      }

   });// Busco el procedimiento por nombre
   $("#SUBMIT_PROCEDIMIENTO").click(function () {
      var formData = new FormData();
      let id = $("#id_proc").val();
      let costo = $("#proc_costo").val();
      let cantidad = $("#proc_cant").val();
      let nombre_proc = $("#SEARCH_PROCEDIMIENTO").val();
      let descuento = $("#DESC_TARIFA").val();

      formData.append('ID_PROCEDIMIENTO', id);
      formData.append('COSTO_PROCEDIMIENTO', costo);
      formData.append('CANT_PROCEDIMIENTO', cantidad);
      formData.append('NOMBRE_PROCEDIMIENTO', nombre_proc);

      if (!nombre_proc) {
         $("#msj_vacio")
            .show()
            .delay(2500)
            .fadeOut("fast");
      } else if (cantidad <= 0) {
         $("#msj_cant")
            .show()
            .delay(2500)
            .fadeOut("fast");
      } else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_temp_procedimiento",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {

               $("#id_proc").val('');
               $("#div_costo").hide();
               $("#SEARCH_PROCEDIMIENTO").val("").trigger('change');
               $("#msj_temp").hide();
               $("#msj_success").show().delay(2500).fadeOut("fast");

               load_temProcedimientos();
               get_total_final(descuento);

            }
         });
      }

   });// Inserto el procedimiento temporalmente
   $("body").on("click", "#temp-del", function (event) {
      event.preventDefault();

      var id = $(this).data('idtemp');
      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');
      $.ajax({
         url: raiz_url + "Consult/ajax_delete_temProcedimiento",
         type: "POST",
         data: { id_temp: id }
      })
         .done(function () {
            /* let desc = $("#DESCUENTO").val(); */
            let desc = $("#DESC_TARIFA").val();
            get_total_final(desc);
            load_temProcedimientos();
         });

   });// Elimino el procedimiento temporal
   function load_temProcedimientos() {
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_show_tempProcedimientos",
         dataType: 'json',
         success: function (respuesta) {

            var data = respuesta.data;
            var suma = respuesta.suma['PRECIO_PROCEDIMIENTO'];

            if (data.length > 0) {
               let html = "";
               for (let i = 0; i < data.length; i++) {
                  const cant = data[i]['CANT_PROCEDIMIENTO'];
                  const costo = data[i]['PRECIO_PROCEDIMIENTO'];
                  const nombre = data[i]['NOMBRE_PROCEDIMIENTO'];
                  const id_temp = data[i]['ID_TEMP'];

                  html += "<tr><td class='td-hidden'>" + nombre + "</td>" +
                     "<td>" + cant + "</td>" +
                     "<td>$" + costo + "</td>" +
                     "<td> <a data-idtemp='" + id_temp + "' id='temp-del'> <i class='fas fa-trash-alt'</a> </td></tr>";
               }
               if ($("#ID_MEMBRESIA").val()) {
                  suma = 0;
               } else {
                  suma = suma;
               }
               html += "<td></td> <td>TOTAL</td> <td>" + suma + "</td> <td></td>";

               $("#tbody_procedimientos").html(html);
            } else {
               var html = "<div id='msj_temp' class='alert alert-warning'> No se han agregado procedimientos..</div>";
               $("#div_msj").html(html);
               $("#tbody_procedimientos").html('');
            }
         }
      });
   }// Listo los procedimientos temporales

   // MODAL FICHA CONSUMO - TEMP PRODUCTOS =========================================//
   $("#SEARCH_PRODUCTO").change(function () {
      let txt = $("#SEARCH_PRODUCTO").val();
      if (txt) {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_obtener_producto",
            data: { var: txt },
            dataType: 'json',
            success: function (respuesta) {

               var costo = respuesta.row.PRECIO_PRODUCTO;
               var id = respuesta.row.ID_PRODUCTO;
               var name = respuesta.row.NOMBRE_PRODUCTO;
               var stock = respuesta.row.STOCK_PRODUCTO;

               $("#id_producto").val(id);
               $("#product_select").html(name);
               $("#producto_costo").val(costo);
               $("#producto_cant").val('1');

               $("#div_producto").show();
            }
         });
      }

   });// Busco el producto por nombre
   $("#select_procedimiento").change(function () {
      let $this = "#select_procedimiento option:selected";
      $("#proc_costo").val($($this).data('precio_proce'));
   })
   $("#SUBMIT_PRODUCTO").click(function () {
      var formData = new FormData();

      let id = $("#id_producto").val();
      let tarifa = $("#ID_TARIFA").val();
      let costo = $("#producto_costo").val();
      let cantidad = $("#producto_cant").val();
      let nombre_product = $("#SEARCH_PRODUCTO").val();
      let descuento = $("#DESC_TARIFA").val();

      formData.append('ID_PRODUCTO', id);
      formData.append('COSTO_PRODUCTO', costo);
      formData.append('CANT_PRODUCTO', cantidad);
      formData.append('NOMBRE_PRODUCTO', nombre_product);
      formData.append('ID_TARIFA', tarifa);

      if (!nombre_product) {
         $("#msj_vacio2")
            .show()
            .delay(2500)
            .fadeOut("fast");
      } else if (cantidad <= 0) {
         $("#msj_cant2")
            .show()
            .delay(2500)
            .fadeOut("fast");
      } else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_temp_producto",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {

               $("#id_producto").val('');
               $("#SEARCH_PRODUCTO").val("").trigger('change');
               $("#div_producto").hide();
               $("#msj_temp2").hide();
               $("#msj_success2").show().delay(2500).fadeOut("fast");

               load_tempProductos();
               get_total_final(descuento);
            }
         });
      }

   });// Inserto el producto temporalmente
   $("body").on("click", "#temp-del2", function (event) {
      event.preventDefault();

      var id = $(this).data('idtemp');
      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');

      $.ajax({
         url: raiz_url + "Consult/ajax_delete_temProducto",
         type: "POST",
         data: { id_temp: id }
      })
         .done(function () {
            /* let desc = $("#DESCUENTO").val(); */
            let desc = $("#DESC_TARIFA").val();
            get_total_final(desc);
            load_tempProductos();
         });

   });// Elimino el producto temporal
   function load_tempProductos() {
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_show_tempProductos",
         dataType: 'json',
         success: function (respuesta) {
            var data = respuesta.data;
            var suma = respuesta.sumaProductos['PRECIO_PRODUCTO'];
            /*  let tarifa = $("#ID_TARIFA").val(); 
             let desc = $("#DESC_TARIFA").val();    */
            /*     desc = desc.replace(".00", ""); */

            if (data.length > 0) {
               /*  let html = "";
                if(tarifa){
                   for (let i = 0; i < data.length; i++) {
                      const nombre = data[i]['NOMBRE_PRODUCTO'];
                      const total = data[i]['PRECIO_PRODUCTO'];
                      const cant = data[i]['CANT_PRODUCTO'];
                      const id_temp = data[i]['ID_TEMP'];
 
                      html += "<tr><td class='td-hidden'><span data-toggle='tooltip' title="+nombre+">" + nombre + "</span></td>" +
                      "<td>" + desc + "%</td>" +
                      "<td>"  + cant  + "</td>" +
                      "<td>$" + total + "</td>" +
                      "<td> <a data-idtemp='" + id_temp + "' id='temp-del2'> <i class='fas fa-trash-alt'</a> </td></tr>";
                   } 
                   $("#onlyurgency").show();
                }else{ */
               for (let i = 0; i < data.length; i++) {
                  const nombre = data[i]['NOMBRE_PRODUCTO'];
                  const costo = data[i]['PRECIO_PRODUCTO'];
                  const cant = data[i]['CANT_PRODUCTO'];
                  const id_temp = data[i]['ID_TEMP'];

                  html += "<tr><td class='td-hidden'><span data-toggle='tooltip' title=" + nombre + ">" + nombre + "</span></td>" +
                     "<td>" + cant + "</td>" +
                     "<td>$" + costo + "</td>" +
                     "<td> <a data-idtemp='" + id_temp + "' id='temp-del2'> <i class='fas fa-trash-alt'</a> </td></tr>";
               }
               /*       $("#onlyurgency").hide();
                  }
                  let td = (tarifa ? "<td></td>" : ""); */

               html += /* td+ */"<td></td> <td>TOTAL</td> <td>" + suma + "</td> <td></td>";
               $("#tbody_productos").html(html);
            } else {
               var html = "<div id='msj_temp2' class='alert alert-warning'> No se han agregado productos..</div>";
               $("#div_msj2").html(html);
               $("#tbody_productos").html('');
            }
         }
      });
   }// Listo los productos temporales      

   // MODAL FICHA CONSUMO ====================================//
   // Habilito el modo edicion
   function actualizarSeleccion() {
      var id_tarifa = $('#id_tarifa').val();
      $('#tarifa_select_urgency option').each(function () {
         $(this).prop('selected', false);
         if ($(this).val() == id_tarifa) {
            $(this).prop('selected', true);
            return false; // Esto es equivalente a 'break' en un bucle jQuery
         }
      });
   }
   // Función para establecer el valor de id_tarifa y actualizar la selección
   function setIdTarifaC(value) {
      $('#id_tarifa').val(value);
      actualizarSeleccion();
   }

   // Exponer la función setIdTarifa globalmente si es necesario
   window.setIdTarifaC = setIdTarifaC;

   $("body").on("click", "#BTN_FICHA_CONSUMO", function () {

      $("#ficha_consumo").modal('toggle');

      let ficha = $(this).data('id_ficha');
      let membresia = $(this).data('membresia');
      let tarifa = $(this).data('desc_tarifa'); tarifa = (tarifa ? tarifa.replace(".00", "") : "");
      /* let descuento = $(this).data('desc_membresia'); descuento = (descuento ? descuento.replace(".00", "") : ""); */

      $("#id_ficha_consumo").val(ficha);
      setIdTarifaC($(this).data('id_tarifa'));
      //$("#id_tarifa").val($(this).data('id_tarifa'));  
      $("#id_consulta_consumo").val($(this).data('id_consulta'));
      $("#id_paciente_consumo").val($(this).data('id_paciente'));

      $("#paciente_name").html($(this).data('nombre_paciente'));
      $("#close_consulta").val($(this).data('close'));
      $("#FOLIO_CONSULTA").val($(this).data('folio'));
      $("#FOLIO_CONSULTA_M").val($(this).data('folio_m'));

      get_procedimientos(ficha);
      get_productos(ficha);

      if ($(this).data('id_tarifa')) {
         $("#DESC_TARIFA_INDEX").val(tarifa);
         $("#TYPE").html("TARIFA " + "<font class='type_modal'>" + $(this).data('tarifa') + "</font>");
         $("#FOOTER_T").show();
         $("#FOOTER_M").hide();
         $("#precio_consult").val($(this).data('precio_consult'));
         $("#DIV_PRECIO_PROCE").show();

         $("#tarifa_select").val($(this).data('id_tarifa'));
         get_total(tarifa, ficha);
      } else {
         $("#MEMBRESIA").val(membresia);
         $("#FOOTER_T").hide();
         $("#FOOTER_M").show();
         $("#DESC_TARIFA_INDEX").val("");
         $("#precio_consult").val(0);
         $("#proc_costo").val(0);
         $("#DIV_PRECIO_PROCE").hide();

         $("#TYPE").html("MEMBRESIA " + "<font class='type_modal'>" + $(this).data('membresia') + "</font>");
         get_total(0, ficha);
      }
      if ($(this).data('close') === 0) {
         $("#BTN_EDIT_FICHA").show();
      } else {
         $("#BTN_EDIT_FICHA").hide();
      }
   });// Envio parametros para que me de los rows de rel procedimiento y productos
   $("#tarifa_select").change(function () {
      let desc = $(this).find(':selected').data('desc');
      let name = $(this).find(':selected').data('name');
      let precioC = $(this).find(':selected').data('precioconsulta');
      let selectVal = $(this).val();
      let ficha = $("#id_ficha_consumo").val();

      $("#DESC_TARIFA_INDEX").val(desc);
      $("#precio_consult").val(precioC);
      $(".type_modal").text(name);
      get_total(desc, ficha);

      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/change_tarifa",
         data: { ficha: ficha, id_tarifa: selectVal },
         dataType: "POST",
         success: function (response) {

         }
      });

   })
   $("body").on("click", "#BTN_EDIT_FICHA", function () {
      let html = $(this).html();
      if (html === 'Editar') {
         isEdit = true;
         $(this).html('Terminar').toggleClass('btn-info').toggleClass('btn-success');
         $("#DESC_TARIFA_INDEX").attr('readonly', false);
         $("#FOLIO_CONSULTA").attr('readonly', false);
         $("#FOLIO_CONSULTA_M").attr('readonly', false);
         $(".product-quantityC").attr('readonly', false);
         if ($("#id_tarifa").val() > 0) {
            $("#tarifa_edit").toggle();
            $("#labelType").toggle();
         }
      } else {
         $(".product-quantityC").attr('readonly', true);
         isEdit = false;
         $(this).html('Editar').toggleClass('btn-success').toggleClass('btn-info');

         if ($("#DESC_TARIFA_INDEX").val()) {

            $("#DESC_TARIFA_INDEX").attr('readonly', true);
            $.ajax({
               type: "post",
               url: raiz_url + "Consult/ajax_edit_desc_tarifa",
               data: {
                  desc: $("#DESC_TARIFA_INDEX").val(),
                  TotPag: $("#TOTAL_PAGADO_CONSULTA").val(),
                  FolCon: $("#FOLIO_CONSULTA").val(),
                  ficha: $("#id_ficha_consumo").val(),
                  consulta: $("#id_consulta").val()
               },
               success: function (data) {
                  if (data == 'repetido') {
                     Swal.fire({
                        title: 'Atención!',
                        text: 'Folio repetido',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2500
                     });
                  } else {
                     if (data == 'no ficha') {
                        Swal.fire({
                           title: 'Atención!',
                           text: 'Ficha no creada',
                           icon: 'warning',
                           showConfirmButton: false,
                           timer: 2500
                        });
                     } else {
                        $('#dataConsult').DataTable().ajax.reload();
                     }
                  }
               }
            });

         } else {
            $.ajax({
               type: "post",
               url: raiz_url + "Consult/ajax_edit_desc_tarifa",
               data: {
                  FolConM: $("#FOLIO_CONSULTA_M").val(),
                  ficha: $("#id_ficha_consumo").val(),
                  consulta: $("#id_consulta").val()
               },
               success: function (data) {
                  if (data == 'repetido') {
                     Swal.fire({
                        title: 'Atención!',
                        text: 'Folio repetido',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 2500
                     });
                  } else {
                     if (data == 'no ficha') {
                        Swal.fire({
                           title: 'Atención!',
                           text: 'Ficha no creada',
                           icon: 'warning',
                           showConfirmButton: false,
                           timer: 2500
                        });
                     } else {
                        $('#dataConsult').DataTable().ajax.reload();
                     }
                  }
               }
            });
         }
         if ($("#id_tarifa").val() > 0) {
            $("#tarifa_edit").toggle();
            $("#labelType").toggle();
         }

         /* $.toast({
             heading: 'Éxito',
             text: 'Cambios guardados',
             showHideTransition: 'slide',
             icon: 'success',
             loader:false,
             hideAfter: 2000,
         }) */
      }
      $("#TOTAL_PAGADO_CONSULTA").attr('readonly', false);
      $(".div_adds").toggle();
      $(".del_rel").toggle();
      $(".del_relp").toggle();
      $("#BTN_PRINT_FICHA").toggle();


   });// Habilito el modo edicion   

   // MODAL FICHA CONSUMO - REL  PROCEDIMIENTO ====================================//
   $("body").on("click", "#del_rel", function (event) {
      event.preventDefault();

      var id = $(this).data('idrel');
      var ficha = $(this).data('id_ficha');
      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');
      $.ajax({
         url: raiz_url + "Consult/ajax_delete_relProcedimiento",
         type: "POST",
         data: {
            id_rel: id,
            id_ficha: ficha
         }
      })
         .done(function (respuesta) {
            let desc = $("#DESC_TARIFA_INDEX").val();
            get_procedimientos(ficha);
            get_total(desc, ficha);

         });

   });// Cacheo el id procedimiento y lo elimino
   $("#SUBMIT_REL_PROCEDIMIENTO_C").click(function () {
      let formData = new FormData();

      var msj_cant = '';
      var ficha = $("#id_ficha_consumo").val();
      var tarifa = $("#id_tarifa").val();
      var descuento = $("#DESC_TARIFA_INDEX").val();
      var consulta = $("#id_consulta_consumo").val();
      var paciente = $("#id_paciente_consumo").val();
      var select = $("#select_procedimiento").val();
      var cant = $("#cant_relprocedimiento").val();
      var precioPC = $("#proc_costo").val();

      formData.append('precio_proce', precioPC);
      formData.append('cantidad', cant);
      formData.append('id_ficha', ficha);
      formData.append('id_tarifa', tarifa);
      formData.append('id_consulta', consulta);
      formData.append('id_paciente', paciente);
      formData.append('id_procedimiento', select);

      if (select === '') {
         $("#msj_validSelect_proc")
            .show()
            .delay(2000)
            .fadeOut("fast");
      } else if (cant <= 0) {
         $("#msj_validCant_proc")
            .show()
            .delay(2000)
            .fadeOut("fast");

      } else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_insert_relProcedimiento",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (id_ficha) {
               $("#id_ficha_consumo").val(id_ficha);
               get_procedimientos(id_ficha);
               get_total(descuento, id_ficha);

               cant == 1 ? msj_cant = '  Procedimiento' : msj_cant = '  Procedimientos';

               $("#msj_cant_proce")
                  .html(cant + msj_cant);
               $("#proce_submit")
                  .delay(1500)
                  .fadeOut("fast")
                  .css('display', 'inline-block');
            },
            complete: function () {
               $("#select_procedimiento").prop('selectedIndex', 0);
               $("#cant_relprocedimiento").val('1');
            }
         });
      }

   });// Inserto los procedimieintos en rel-procedimiento
   function get_procedimientos(ficha) {
      let id_ficha = ficha;
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_get_procedimientos",
         data: { id_ficha: ficha },
         dataType: 'json'
      })
         .done(function (response) {
            var html = "";
            var display = "";
            if (response.length > 0) {
               $("#msj_tableEmptyProce").hide();
               display = ($("#BTN_EDIT_FICHA").html() === 'Terminar' ? "" : "none");

               for (let i = 0; i < response.length; i++) {
                  const nombre = response[i]['NOMBRE_PROCEDIMIENTO'];
                  const cant = response[i]['CANT_PROCEDIMIENTO'];
                  const precio = response[i]['PRECIO_PROCEDIMIENTO'];
                  const id = response[i]['ID'];

                  html += "<tr><td class='td-hidden'><span title='" + nombre + "'>" + nombre + "</span></td>" +
                     "<td>" + cant + "</td>" +
                     "<td>$" + precio + "</td>" +
                     "<td>" +
                     "<a class='del_rel btn' style='display:" + display + "' href='#'  data-id_ficha='" + id_ficha + "' data-idrel='" + id + "' id='del_rel'>" +
                     " <i class='fas fa-trash-alt'></i>" +
                     "</a> </td>" +
                     "</tr>";
               }
            } else {
               $("#msj_tableEmptyProce").show();
            }
            $("#tbody_procedimientos").html(html);
         });
   }// Obtengo los procedimientos by id ficha  from rel_procedimientos

   // MODAL FICHA CONSUMO - REL  PRODUCTO=========================================//
   $("#SUBMIT_REL_PRODUCTO_C").click(function () {
      let formData = new FormData();
      var cant = $("#cant_relproducto").val();
      var ficha = $("#id_ficha_consumo");
      var tarifa = $("#id_tarifa").val();
      var select = $("#select_producto").val();
      var id_ficha = $("#id_ficha_consumo").val();
      var consulta = $("#id_consulta_consumo").val();
      var paciente = $("#id_paciente_consumo").val();
      /*  var descuento= $("#DESCUENTO").val(); */
      var tarifa_desc = $("#DESC_TARIFA_INDEX").val();

      formData.append('cantidad', cant);
      formData.append('id_ficha', id_ficha);
      formData.append('id_tarifa', tarifa);
      formData.append('id_producto', select);
      formData.append('id_consulta', consulta);
      formData.append('id_paciente', paciente);

      if (select === '') {
         $("#msj_validSelect_product")
            .show()
            .delay(2000)
            .fadeOut("fast");
      } else if (cant <= 0) {
         $("#msj_validCant_product")
            .show()
            .delay(2000)
            .fadeOut("fast");
      } else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Consult/ajax_insert_relProducto",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (id_ficha) {
               cant == 1 ? msj_cant = ' Producto' : msj_cant = ' Productos';
               ficha.val(id_ficha);
               get_productos(id_ficha);
               get_total(tarifa_desc, id_ficha);

               $("#msj_cant_prod")
                  .html(cant + msj_cant);
               $("#produ_submit")
                  .delay(1500)
                  .fadeOut("fast")
                  .css('display', 'inline-block');
            },
            complete: function () {
               $("#select_producto").prop('selectedIndex', 0);
               $("#cant_relproducto").val('1');
            }
         });
      }

   });//Inserto los productos en rel -producto
   $("body").on("click", "#del_relp", function (event) {
      event.preventDefault();

      var tarifa_desc = $("#DESC_TARIFA_INDEX").val();
      var id = $(this).data('idrelp');
      var ficha = $(this).data('id_ficha');
      $(this).html('<img src="' + raiz_url + 'assets/img/loader.gif">');
      $.ajax({
         url: raiz_url + "Consult/ajax_delete_relProducto",
         type: "POST",
         data: {
            id_relP: id,
            id_ficha: ficha
         }
      })
         .done(function (respuesta) {
            let desc = $("#DESC_TARIFA_INDEX").val();
            get_productos(ficha);
            get_total(desc, ficha);
         });

   });// Cacheo el id producto a eliminar
   function get_productos(ficha) {

      let id_ficha = ficha;
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_get_productos",
         data: { id_ficha: ficha },
         dataType: 'json'
      })
         .done(function (response) {
            var html2 = "";
            var display = '';

            if (response.length > 0) {
               $("#msj_tableEmptyProdu").hide();
               display = ($("#BTN_EDIT_FICHA").html() === 'Terminar' ? "" : "none");

               /* if(tarifa){               
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
                        "<td> <a class='btn del_relp' style='display:" + display + "' data-idrelp='" + id + "' data-id_ficha='" + id_ficha + "' id='del_relp'>" +
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
                     "<input type='number' class='product-quantityC form-control' " + readonly + " value='" + cant + "' data-idrelp='" + id + "' />" +
                     "</td>" +
                     "<td>$" + precio + "</td>" +
                     "<td> <a class='btn del_relp' style='display:" + display + "' data-idrelp='" + id + "' data-id_ficha='" + id_ficha + "' id='del_relp'>" +
                     "<i class='fas fa-trash-alt'</a></td>" +
                     "</tr>";
               }
               /* } */


            } else {
               $("#msj_tableEmptyProdu").show();
            }
            $("#tbody_productos").html(html2);
         });
   }// Obtengo los productos by id ficha from rel_productos

   $('body').on("change", ".product-quantityC", function (e) {
      var idrel = $(this).data('idrelp');
      $.ajax({
         url: raiz_url + "Urgency/ajax_update_cantidad_producto",
         type: 'POST',
         data: { id: idrel, cantidad: $(this).val() },
         success: function (id_ficha) {
            if (id_ficha > 0) {
               var descuento = $("#DESC_TARIFA_INDEX").val() || 0;
               get_productos(id_ficha);
               get_total(descuento, id_ficha);
            }
         }
      });
   });

   // MODAL FICHA DIAGNOSTIC ====================================================//
   $("body").on("click", "#BTN_FICHA_CLINICA", function (event) {
      let id_patient = $(this).data('id_paciente');
      let id_consult = $(this).data('id_consulta');
      let id_tarifa = $(this).data('id_tarifa');
      $("#ficha_diagnostico").modal('toggle');

      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_get_consulta_by_id",
         data: { consulta: id_consult, paciente: id_patient, tarifa: id_tarifa }
      })
         .done(function (respuesta) {
            let json = JSON.parse(respuesta);
            let patient = json.Paciente;
            let consult = json.Consulta;
            let doctors = json.Medicos;

            set_medico_consulta(doctors, consult.ID_MEDICO);
            $("#ID_TARIFA").val(consult.ID_TARIFA);
            $("#ID_PACIENTE").val(consult.ID_PACIENTE);
            $("#ID_CONSULT").val(consult.ID_CONSULTA);

            var options = { day: 'numeric', month: 'numeric', year: 'numeric' };
            var fecha_i = new Date(consult.FECHA_CONSULTA + 'T00:00:00');
            var fecha_e = new Date(consult.FECHAEGRESO_CONSULTA + 'T00:00:00');

            var formatFechaI = fecha_i.toLocaleDateString("es-MX", options);
            var formatFechaE = "";

            if (consult.FECHAEGRESO_CONSULTA != null) {
               formatFechaE = fecha_e.toLocaleDateString("es-MX", options);
            } else {
               /*   let FechaEgreso = new Date("");
                 formatFechaE = FechaEgreso.toLocaleDateString("es-MX",options); */
               formatFechaE = "Sin registrar";
            }

            $("#NOMBRE_PACIENTE").html(patient.NOMBRE_PACIENTE + ' ' + patient.APELLIDO_PATERNO_PACIENTE + ' ' + patient.APELLIDO_MATERNO_PACIENTE);
            $("#ORIGEN").val(consult.ORIGEN_CONSULTA);
            $("#CONDICION").val(consult.CONDICION_CONSULTA);
            $("#INICIOEVOLUCION").val(consult.INICIOEVOLUCION_CONSULTA);
            $("#SIGNOS_VITALES").val(consult.SIGNOS_VITALES);
            $("#FC").val(consult.FC_CONSULTA);
            $("#RC").val(consult.RITMO_CARDIACO_CONSULTA);
            $("#TEMP").val(consult.TEMP_CONSULTA);
            $("#FR").val(consult.FR_CONSULTA);
            $("#SAT").val(consult.SAT_CONSULTA);
            $("#GC").val(consult.GLICEMIA_CAPILAR_CONSULTA);
            $("#PE").val(consult.PESO_CONSULTA);
            $("#TA").val(consult.TALLA_CONSULTA);
            $("#PC").val(consult.PC);
            $("#PA").val(consult.PA);
            $("#EVOLUCION").val(consult.EVOLUCION_CONSULTA);
            $("#MANEJO_INTRAHOSPITALARIO_CONSULTA").val(consult.MANEJO_INTRAHOSPITALARIO_CONSULTA);
            $("#TRATAMIENTO").val(consult.TRATAMIENTO_CONSULTA);
            $("#FECHA_INGRESO").val(formatFechaI);
            $("#HORA_INGRESO").val(consult.HORA_CONSULTA);
            $("#MOTIVO").val(consult.MOTIVO_CONSULTA);
            $("#DIAGNOSTICO").val(consult.DIAGNOSTICO);
            $("#EXPLORACION").val(consult.EXPLORACION_FISICA);
            $("#ANTECEDENTES").val(patient.ANTECEDENTES_PACIENTE);
            $("#FECHA_EGRESO").val(formatFechaE);
            $("#OBSERVACION").val(consult.OBSERVACIONES_CONSULTA);
            $("#DIAGNOSTICO_CON").val(consult.DIAGNOSTICO_EGRESO_CONSULTA);
            $("#HORA_EGRESO").val(consult.HREGRESO_CONSULTA);
         });
   });//recibo y muestro info en campos del modal
   $("#BTN_EDIT_DIAGNOSTIC").click(function () {

      let obj = $("#FORM_CONSULTA");
      obj.find(".require ").each(function () {

         var isDisabled = $(this).attr('readonly', true);
         if (isDisabled) {
            $(this).removeAttr('readonly');
         } else {
            return false;
         }

      });
      $(this).hide();
      $("#BTN_SUBMIT_DIAGNOSTIC").show();
      $("#BTN_CANCEL_DIAGNOSTIC").show();
      $("#BTN_PRINT_DIAG_CONSULT").hide();
   });// Habilito el modo edicion
   $("#BTN_CANCEL_DIAGNOSTIC").click(function () {

      let obj = $("#FORM_CONSULTA");
      obj.find(".require ").each(function () {

         var isDisabled = $(this).attr('readonly', true);
         if (isDisabled) {
            $(this).attr('readonly');
         } else {
            return false;
         }

      });
      $(this).hide();
      $("#BTN_SUBMIT_DIAGNOSTIC").hide();
      $("#BTN_EDIT_DIAGNOSTIC").show();
      $("#BTN_PRINT_DIAG_CONSULT").show();

   });// Cancelo el modo edicion
   $("#BTN_SUBMIT_DIAGNOSTIC").click(function () {

      var formData = new FormData($("#FORM_CONSULTA")[0]);

      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_update_consulta",
         data: formData,
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {

            let obj = $("#FORM_CONSULTA");
            obj.find(".require ").each(function () {

               var isDisabled = $(this).attr('readonly', true);
               if (isDisabled) {
                  $(this).attr('readonly');
               } else {
                  return false;
               }

            });
            $("#BTN_CANCEL_DIAGNOSTIC").hide();
            $("#BTN_SUBMIT_DIAGNOSTIC").hide();
            $("#BTN_EDIT_DIAGNOSTIC").show();
            $("#BTN_PRINT_DIAG_CONSULT").show();

         }
      });
   }); //Envio los cambios de edicion
   function set_medico_consulta(doctors, id_medico_consult) {
      var html = "<option value='' disabled>Elige un médico</option>";
      var sel = "";

      for (let i = 0; i < doctors.length; i++) {
         const id_medico = doctors[i]['ID_USUARIO'];
         const nombre_medico = doctors[i]['NOMBRE_USUARIO'];

         if (id_medico == id_medico_consult) {
            sel = "selected";
         } else {
            sel = "";
         }

         html += "<option " + sel + " value='" + id_medico + "'>" + nombre_medico + "</option>";

      }
      $("#MEDICO").html(html);

   }

   // ADJUNTAR ARCHIVOS ========================================================//
   $('body').on("click", ".btn-del-file-client", function (e) {
      var ID_CONSULTA = $(this).attr('data-id-consulta');
      var ID_DOCUMENTO = $(this).attr('data-id-document');
      var NOMBRE_DOCUMENTO = $(this).attr('data-document-name');
      $.ajax({
         url: raiz_url + "Consult/ajax_delete_file_by_id",
         type: 'POST',
         data: 'ID_CONSULTA=' + ID_CONSULTA + "&ID_DOCUMENTO=" + ID_DOCUMENTO + "&NOMBRE_DOCUMENTO=" + NOMBRE_DOCUMENTO,
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
   $("#formFilesClient").on('submit', (function (e) {
      e.preventDefault();
      $.ajax({
         url: raiz_url + "Consult/ajax_subir_archivo",
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
   $("body").on('click', '#BTN_ADJUNTAR_ARCHIVO', function () {
      $("#ID_CONSULTA").val($(this).data('id_consult'));

      load_tbody_files();
   });// Al abrir el modal listo los archivos existentes
   function load_tbody_files() {
      $('#userfile').val('');
      var ID_CLIENTE = $('#ID_CONSULTA').val();
      //  $('#modAddFiles').modal('toggle');

      $.ajax({
         url: raiz_url + "Consult/ajax_get_files_consult",
         type: 'POST',
         data: 'ID_CONSULTA=' + ID_CLIENTE,
         success: function (data2) {

            if (data2.length > 0) {
               var cont = 1;

               $("#tbodyTableFilesClient").empty();

               $.each(data2, function (arrayID, row) {
                  $("#tbodyTableFilesClient").append("<tr>" +
                     "<td><b>" + cont + "</b></td>" +
                     "<td>" + row.NOMBRE_DOCUMENTO + "</td>\n\
                     <td>" + row.TIPO_DOCUMENTO + "</td>\n\
                     <td>" +
                     "<button id='btnDeleteFileClient' class='btn btn-danger pull-left btn-actions btn-del-file-client'\n\
                           data-original-title='Borrar archivo' data-toggle='tooltip' data-document-name='"+ row.NOMBRE_DOCUMENTO + "' data-id-consulta='" + row['ID_CONSULTA'] + "' data-id-document='" + row['ID_DOCUMENTO'] + "'>\n\
                           <i class='fa fa-trash' aria-hidden='true'></i>\n\
                        </button>" +
                     "<a  href='" + raiz_url + 'FILES/' + row.NOMBRE_DOCUMENTO + "'target='_blank'  class='btn pull-right btn-success btn-actions btn-down-file-client' data-original-title='Descargar archivo' data-toggle='tooltip' data-id-consulta='" + row['ID_CONSULTA'] + "' data-document-name=" + row.NOMBRE_DOCUMENTO + " data-id-document='" + row['ID_DOCUMENTO'] + "'>" +
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

   // ELIMINAR CONSULTAS ======================================================//
   $("body").on('click', '#BTN_ELIMINAR_CONSULTA', function () {

      var id = $(this).data('id-consult');

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
               url: raiz_url + "Consult/ajax_delete_consult",
               data: { id_consulta: id }
            })
               .done(function () {
                  Swal.fire({
                     title: 'Registro eliminado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        $('#dataConsult').DataTable().ajax.reload();
                     }
                  });
               });
         }
      });
   });
   // REFRESH TOTAL ======================================================//
   $(".DESC_TARIFA").keyup(function () {
      let desc = $(this).val();
      let ficha = $("#id_ficha_consumo").val();
      get_total(desc, ficha);
   })
   $("#REFRESH_TOTAL_INDEX").click(function () {
      let desc = $("#DESCUENTO").val();
      let ficha = $("#id_ficha_consumo").val();
      get_total(desc, ficha);
   })


   /* $("#DESCUENTO_NEWCONSULT").keyup(function(){
      let desc = $(this).val();
      get_total_final(desc);
   }) */
   $("#DESC_TARIFA").keyup(function () {
      let desc = $(this).val();
      get_total_final(desc);
   })
   $("#PRECIO_CONSULTA").keyup(function () {

      var DescTemp = $("#DESC_TARIFA").val();
      get_total_final(DescTemp);
   })

   $("#DESC_TARIFA_INDEX").keyup(function () {
      let desc = $(this).val();
      let ficha = $("#id_ficha_consumo").val();
      get_total(desc, ficha);
   })
   // FORMATOS DE IMPRESION ======================================================//
   $('#BTN_PRINT_FICHA').on('click', function () {
      var CONSULT_ID = $('#id_consulta_consumo').val();
      var close = $('#close_consulta').val();

      if (close <= 0) {
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
                  url: raiz_url + "Consult/ajax_close_consult",
                  data: { id_consulta: CONSULT_ID },
               })
                  .done(function (response) {
                     if (response === "success") {
                        $('#close_consulta').val('1');
                        $('#dataConsult').DataTable().ajax.reload();
                        $("#BTN_EDIT_FICHA").hide();
                        window.open(raiz_url + "Consult/creaPdf/" + CONSULT_ID);

                     } else {
                        alert('Hubo un error, intente de nuevo');
                     }
                  })

            }
         })
      } else {
         window.open(raiz_url + "Consult/creaPdf/" + CONSULT_ID);
      }
   });
   $('#BTN_PRINT_DIAG_CONSULT').on('click', function () {
      var CONSULT_ID = $('#ID_CONSULT').val();

      if ($("#FECHA_EGRESO").val() === "" || $("#FECHA_EGRESO").val() === "Sin registrar") {
         Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            timer: 2000,
            showConfirmButton: false,
            html: '<div class="class_invalid">¡ESTABLECE FECHA Y HORA EGRESO!<br><br><span>Haz click en editar para elegir fecha y hora</span></div>',

         });
      } else {
         window.open(raiz_url + "Consult/creaPdfFichaDiagnostic/" + CONSULT_ID);

      }
   });
   //ON CLOSE MODAL FICHA CONSUMO
   $("#ficha_consumo").on("hidden.bs.modal", function () {
      let modal = $("#ficha_consumo");
      let BtnFinish = modal.find('button[data-btn="edit-ficha"]');
      let txt = BtnFinish.html();

      if (txt === 'Terminar') {
         BtnFinish.click();

      }
   });
   $("#ficha_diagnostico").on("hidden.bs.modal", function () {
      let modal = $("#ficha_diagnostico");
      let BtnFinish = modal.find('button[data-cancel="cancel"]');
      let txt = BtnFinish.html();

      if (txt === 'Cancelar') {
         BtnFinish.click();

      }

   });
   //OTHER FUNCTIONS ======================================================//


   animation_modal(".modal-proced", "#modal");
   animation_modal(".modal-product", "#modal2");
   function animation_modal(button, modal) {
      var modalBtn = $(button);
      var modal = $(modal);
      var animInClass = "";
      var animOutClass = "";

      modalBtn.on('click', function () {
         animInClass = "zoomIn";
         animOutClass = "zoomOut";
         if (animInClass == '' || animOutClass == '') {
            alert("Please select an in and out animation type.");
         } else {
            modal.addClass(animInClass);
            modal.modal({ backdrop: true });
         }
      })
      modal.on('show.bs.modal', function () {
         var closeModalBtns = modal.find('button[data-custom-dismiss="modal"]');
         closeModalBtns.one('click', function () {
            modal.on('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (evt) {
               modal.modal('hide')
            });
            modal.removeClass(animInClass).addClass(animOutClass);
         })
      })
      modal.on('hidden.bs.modal', function (evt) {

         /* ///////////////////////////////////////////////////////
         $("#id_producto").val('');
         $("#SEARCH_PRODUCTO").val("").trigger('change');
         $("#div_producto").hide();
         ///////////////////////////////////////////////////////
         $("#id_proc").val('');
         $("#div_costo").hide();
         $("#SEARCH_PROCEDIMIENTO").val("").trigger('change');
         ///////////////////////////////////////////////////////
         */
         var closeModalBtns = modal.find('button[data-custom-dismiss="modal"]');
         modal.removeClass(animOutClass)
         modal.off('webkitAnimationEnd oanimationend msAnimationEnd animationend')
         closeModalBtns.off('click')
      })
   }
   function get_total(desc, ficha) {
      let precio_consult = $("#precio_consult").val();
      let IsTarifa = $("#id_tarifa").val();
      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_costo_total",
         data: {
            descuento: desc,
            ficha: ficha,
            precio: precio_consult,
            tarifa: IsTarifa
         },
         success: function (response) {
            var json = JSON.parse(response);
            $("#SUBTOTAL_INDEX").val(json.costo);
            $("#DESCUENTO_TOTAL_INDEX").val(json.desc);

            $("#TOTAL_FINAL_INDEX").val(json.total);
            $("#TOTAL_FINAL_INDEX_T").val(json.total);
            $("#TOTAL_PAGADO_CONSULTA").val(json.totalpagado);

         }
      });
   }//index
   function get_total_final(desc) {
      let PrecioConsult = $("#PRECIO_CONSULTA").val();
      let IsMembresia = $("#ID_MEMBRESIA").val();
      let tarifa = $('#SELECT_TARIFA,#SELECT_TARIFA_U,#ID_TARIFA').val();

      $.ajax({
         type: "POST",
         url: raiz_url + "Consult/ajax_total_final",
         data: {
            descuento: desc,
            precio: PrecioConsult,
            membresia: IsMembresia,
            tarifa: tarifa
         },
         success: function (response) {
            var json = JSON.parse(response);

            $("#TOTAL").val(json.costo);
            $("#DESCUENTO_TOTAL").val(json.desc);
            $("#TOTAL_FINAL").val(json.total);
            $("#TOTAL_FINAL_T").val(json.total);
            $("#TOTAL_PAGADO_CONSULTA").val(json.totalpagado);

         }
      });
   }
   $("body").on('click', '.btn-receta-show', function () {
      var ID_CONSULT = $(this).attr('data-id_consulta');
      window.open(raiz_url + "consult/creaPdfReceta/" + ID_CONSULT + "?modo=imprimir");
   });

   $("body").on('click', '.btn-receta-ver', function () {
      var ID_CONSULT = $(this).attr('data-id_consulta');
      window.open(raiz_url + "consult/creaPdfReceta/" + ID_CONSULT);
   });

   $("body").on('click', '.btn_hist_clinica', function () {
      var ID_CONSULT = $(this).attr('data-id_consulta');
      window.open(raiz_url + "consult/creaHistClinica/" + ID_CONSULT);
   });

      $("body").on('click', '.btn_impr_clinica', function () {
         
         var ID_CONSULT = $(this).attr('data-id_consulta');
         window.open(raiz_url + "consult/creaHistClinica/" + ID_CONSULT + "?modo=imprimir");
   });

      $("body").on('click', '.btn_consentimiento', function () {
         var ID_CONSULT = $(this).attr('data-id_consulta');
         window.open(raiz_url + "consult/creaConsentimiento/" + ID_CONSULT);
   });
   
   
      /*document.onkeyup = function (e) {
         if (e.shiftKey && e.which == 66) {
           
            location.href = raiz_url+"Inventary/form_add_buy";
         }
      }*/


   /* $(window).load(function() {
     $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  }); */
})