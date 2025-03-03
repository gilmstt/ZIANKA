String.prototype.trim = function () {
   return this.replace(/^\s+|\s+$/g, "");
};
$(document).ready(function () {
   /*INICIALIZACION DE CALENDARIO EN ESPAÑOL*/
   var datepick = $("input[data-type='datepicker']");

   var date = new Date();
   var options_num = {day: 'numeric', month: 'numeric',  year: 'numeric',};
   var currentDate = date.getDate(), currentMonth = "11",currentYear = date.getFullYear();

   var fecha = new Date(currentYear, currentMonth, currentDate);
   var max_Date= fecha.toLocaleDateString("es-MX",options_num);    
 
   $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '< Ant',
      nextText: 'Sig >',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      weekHeader: 'Sm', 
      dateFormat: "dd/mm/yy",
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
   }
   $.datepicker.setDefaults($.datepicker.regional['es']);

   datepick.datepicker({
      changeMonth: true,
      changeYear: true, 
      showButtonPanel: false,
      dateFormat: "dd/mm/yy",
      showAnim: 'slideDown',      
      maxDate: max_Date,
      yearRange: '1980'+":"+currentYear,
      container: '.modal-body'
   });

   $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})

   $('#dataProducts').DataTable({
      "dom": "<'row'<'col-md-6'<'col-lg-12 p-dt'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Inventary/ajax_dt_product",
         type: "POST",
      },
      "columnDefs": [
         { "targets": [0, 3, 4], "orderable": false },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})
      }
   })
   $('#dataMed').DataTable({
      "dom": "<'row'<'col-md-6'<'col-lg-12 p-dt'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Inventary/ajax_dt_med",
         type: "POST",
      },
      "columnDefs": [
         { "targets": [0, 3, 4], "orderable": false },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})
      }
   })
   $('#dataVentasDia').DataTable({
      "dom": "<'row'<'col-lg-6 col-mdx-6 col-sm-12'fB><'col-lg-6 col-mdx-6 col-sm-12 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Inventary/search_compras",
         type: "POST",
         data: function (d) {
            d.RG_FECHA_INICIAL = $("#RG_FECHA_INICIAL").val();
            d.RG_FECHA_FINAL = $("#RG_FECHA_FINAL").val();
            d.RG_BUSCAR = $("#RG_BUSCAR").val();
         }
      },
      "columnDefs": [
         { "targets": [0, 4], "orderable": false },
         { "targets": [0, 1, 2, 3, 5], "className": 'text-center' },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})
      }
   });
   $("#dataSupliers").DataTable({
      "dom": "<'row'<'col-md-6'<'col-lg-12 p-dt'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Inventary/ajax_dt_supliers",
         type: "POST",
      },
      "columnDefs": [
         { "targets": [0], "orderable": false },
         { "targets": [0, 1, 2], "className": 'text-center' },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})
      }
   });
   $("#dataProcedure").DataTable({
      "dom": "<'row'<'col-md-6'<'col-lg-12 p-dt'fB>><'col-md-6 text-right'l>><'row op'<'col-md-12 p-dt't>><'row'<'col-md-12 p-dt'i>><'row'<'col-md-12 p-dt'p>>",
      "language": { "url": raiz_url + "assets/plugins/dataTables/Spanish.json" },
      "buttons": ['excel'],
      "processing": true,
      "retrieve": true,
      "serverSide": true,
      "order": [],
      "ajax": {
         url: raiz_url + "Inventary/ajax_dt_procedures",
         type: "POST",
      },
      "columnDefs": [
         { "targets": [0], "orderable": false },
         { "targets": [0, 1, 2], "className": 'text-center' },
      ],
      drawCallback: function () {
         $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
})
      }
   });
   
   $("#btnCargaVentas").click(function (e) {
      e.preventDefault();
      $("#RG_BUSCAR").val(1);
      $('#dataVentasDia').DataTable().ajax.reload();
   })
   //filtros--
   $("thead input").keyup(function () {
      /* Filter on the column (the index) of this element */
      inTable.fnFilter(this.value, $("thead input").index(this));
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


   //AGREGAR PRODUCTO
   $('#formRecordProduct').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();

         $.ajax({
            url: raiz_url + "inventary/ajax_add_product",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               if (data > 0) {
                  Swal.fire({
                     title: 'Producto Registrado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "Inventary/index/";
                     },
                  })
               } else {
                   if (data == -2) {
                  Swal.fire({
                     title: 'Error al Registrar!',
                     text: 'Este producto ya existe',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
               else {
                  Swal.fire({
                     title: 'Error al Registrar!',
                     text: 'hubo un error al registrar el producto',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
              }
          }
            },
         });
      }
   });

   $('body').on("click", ".btn-edit-product", function (e) {
      var ID_PRODUCT = $(this).attr('data-id-product');
      window.location.href = raiz_url + "inventary/form_edit_product/" + ID_PRODUCT;
   });

   //EDIT COMPANY
   $('#formEditProduct').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_edit_product",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               console.log(data);
               if (data > 0) {
                  Swal.fire({
                     title: 'Cambios Guardados!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "Inventary/index/";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al actualizar!',
                     text: 'No se guardaron los cambios',
                     icon: 'info',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            }
         });

      }
   });

   /*DELETE PRODUCTO*/
   $('body').on("click", ".btn-delete-product", function (e) {
      var ID_PRODUCT = $(this).attr('data-id-product');
      if (ID_PRODUCT > 0) {

         Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará este producto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "inventary/ajax_disable_product",
                  type: 'POST',
                  data: 'ID_PRODUCT=' + ID_PRODUCT,
                  success: function (data) {
                     console.log(data);
                     if (data > 0) {
                        Swal.fire({
                           title: 'Producto eliminado!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              $('#dataProducts').DataTable().ajax.reload();
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
                  }
               });
            }
         })

      }
   });
   
   /*DELETE MEDICAMENTO*/
   $('body').on("click", ".btn-delete-med", function (e) {
      var ID_PRODUCT = $(this).attr('data-id-med');
      if (ID_PRODUCT > 0) {

         Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará este producto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "inventary/ajax_disable_product",
                  type: 'POST',
                  data: 'ID_PRODUCT=' + ID_PRODUCT,
                  success: function (data) {
                     console.log(data);
                     if (data > 0) {
                        Swal.fire({
                           title: 'Producto eliminado!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              $('#dataMed').DataTable().ajax.reload();
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
                  }
               });
            }
         })

      }
   });
   
   $('#btnAddProduct').attr('href',raiz_url + 'inventary/form_add_product/1');
   
   $('#mat').click(function(){
       $('#btnAddProduct').attr('href',raiz_url + 'inventary/form_add_product/1');
   });
   
   $('#med').click(function(){
       $('#btnAddProduct').attr('href', raiz_url + 'inventary/form_add_product/2');
   });
   
   /*********************USO INTERNO*****************************/
   $("#SEARCH_PRODUCTO_USAGE").change(function(){
      let val = $(this).val();
      let name = $("#SEARCH_PRODUCTO_USAGE option:selected").text();
      let code = $("#SEARCH_PRODUCTO_USAGE option:selected").data('code');
      let table = "#TABLE_ADD_USAGE";
      let inputCantidad = "<input type='number' class='form-control text-center' value='1' name='cant[]'>";
      let inputProduct = "<input type='hidden' value='"+val+"' name='idProduct[]'>";
      
      
      $(table).append('<tr></tr>');
		$(table+' tr:last').append('<td> <a href="" class="delete-product"><i class="fas fa-trash"></i></td>');
		$(table+' tr:last').append('<td>'+code+'</td>');
		$(table+' tr:last').append('<td>'+inputCantidad+'</td>');
		$(table+' tr:last').append('<td>'+name+inputProduct+'</td>');
   })
   
   $("#TABLE_ADD_USAGE").on("click", ".delete-product", function(e) {
      e.preventDefault();
      $(this).closest("tr").remove();
   });
   $('#formRecordUsage').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_add_usage",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               if (data === "sucess") {
                  Swal.fire({
                     title: 'Uso Registrado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "inventary/index_usage";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al Registrar!',
                     text: 'Hubo un error con el registro',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            },           
         });
      }
   });
     /*********************PROCEDIMIENTOS*****************************/
   //AGREGAR PROEDIMIENTO
   $('#formRecordProcedure').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_add_procedure",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               if (data > 0) {
                  Swal.fire({
                     title: 'Procedimiento Registrado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "inventary/index_procedure";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al Registrar!',
                     text: 'Hubo un error con el registro',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            },
            error: function () {
               Swal.fire({
                  title: 'Procedimiento Existente',
                  text: 'Este procedimiento ya existe',
                  icon: 'info',
                  showConfirmButton: false,
                  timer: 1500,
               })
            }
         });
      }
   });

   $('body').on("click", ".btn-edit-procedure", function (e) {
      var ID_PROC = $(this).attr('data-id-procedure');
      window.location.href = raiz_url + "inventary/form_edit_procedure/" + ID_PROC;
   });

   //EDIT PROCEDURE
   $('#formEditProcedure').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         // everything looks good!
         e.preventDefault();

         $.ajax({
            url: raiz_url + "inventary/ajax_edit_procedure",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               console.log(data);
               if (data > 0) {

                  Swal.fire({
                     title: 'Cambios Guardados!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "inventary/index_procedure";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al actualizar!',
                     text: 'No se guardaron los cambios',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            }
         });

      }
   });

   /*DELETE PROCEDURE*/
   $('body').on("click", ".btn-delete-procedure", function (e) {
      var ID_PROC = $(this).attr('data-id-procedure');
      if (ID_PROC > 0) {

         Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará este producto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "inventary/ajax_disable_procedure",
                  type: 'POST',
                  data: 'ID_PROC=' + ID_PROC,
                  success: function (data) {
                     console.log(data);
                     if (data > 0) {
                        Swal.fire({
                           title: 'Procedimiento Eliminado!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              $('#dataProcedure').DataTable().ajax.reload();
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
                  }
               });
            }
         })

      }
   });

   /****INICIO INDEX COMPRAS******************/

   $('body').on("click", ".btn-del-buy", function (e) {
      var ID_BUY = $(this).attr('data-id-buy');
      if (ID_BUY > 0) {

         Swal.fire({
            title: '¿Estás seguro?',
            text: "Se cancelará esta compra!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "Inventary/ajax_cancel_buy",
                  type: 'POST',
                  data: { ID_BUY: ID_BUY },
                  success: function (data) {
                     console.log(data);
                     if (data > 0) {
                        Swal.fire({
                           title: 'Compra Cancelada!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              $('#dataVentasDia').DataTable().ajax.reload();
                           },
                        })
                     } else {
                        Swal.fire({
                           title: 'Error al cancelar!',
                           icon: 'error',
                           showConfirmButton: false,
                           timer: 1500,
                        })
                     }
                  }
               });
            }
         })
      }
   });


   //AGREGAR PROVEEDOR.. 
   $('#formRecordSupplier').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_add_supplier",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {

               if (data > 0) {
                  Swal.fire({
                     title: 'Proveedor Registrado!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "Inventary/index_supplier";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al registrar!',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            }
         });
      }
   });

   //EDITAR PROVEEDOR...
   $('body').on("click", ".btn-edit-supplier", function (e) {
      var ID_SUPPLIER = $(this).attr('data-id-supplier');
      window.location.href = raiz_url + "inventary/form_edit_supplier/" + ID_SUPPLIER;
   });

   $('#formEditSupplier').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...
      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_edit_supplier",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {
               console.log(data);
               if (data > 0) {
                  Swal.fire({
                     title: 'Cambios Guardados!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.href = raiz_url + "inventary/index_supplier";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Error al Registrar!',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 1500,
                  })
               }
            }
         });
         //MANDAR AJAXX... 
         $('#modEditSupplier').on('hidden.bs.modal', function () {
         });
      }
   });

   //ELIMINAR PROVEEDOR
   $('body').on("click", ".btn-del-supplier", function (e) {
      var ID_PROVEEDOR = $(this).attr('data-id-supplier');
      if (ID_PROVEEDOR > 0) {

         Swal.fire({
            title: '¿Estás seguro?',
            text: "Se cancelará esta compra!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  url: raiz_url + "inventary/ajax_disable_supplier",
                  type: 'POST',
                  data: 'ID_PROVEEDOR=' + ID_PROVEEDOR,
                  success: function (data) {
                     console.log(data);
                     if (data > 0) {
                        Swal.fire({
                           title: 'Proveedor Eliminado!',
                           icon: 'success',
                           showConfirmButton: false,
                           timer: 1500,
                           onClose: function () {
                              $('#dataSupliers').DataTable().ajax.reload();
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
                  }
               });
            }
         })
      }
   });

   $('#btnAddItemBuy').on('click', function () {
      $('#modAddItemCompra').modal('toggle');
   });


   $('#cancelAddItemCompra').on('click', function () {
      window.location.href = raiz_url + "Inventary/index_buy";
   });


   $('#formRecordAddCompra').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();
         if (!$('#RG_ID_PRODUCTO_O').val() || !$('#RG_CANTIDAD_PRODUCTO_ORDEN_TEMP').val() || !$('#RG_COSTO_PRODUCTO_ORDEN_TEMP').val()) {
            if (!$('#RG_ID_PRODUCTO_O').val())
               $('#RG_ID_PRODUCTO_O').closest('.form-group').removeClass('has-success').addClass('has-error');
            if (!$('#RG_CANTIDAD_PRODUCTO_ORDEN_TEMP').val())
               $('#RG_CANTIDAD_PRODUCTO_ORDEN_TEMP').closest('.form-group').removeClass('has-success').addClass('has-error');
            if (!$('#RG_COSTO_PRODUCTO_ORDEN_TEMP').val())
               $('#RG_COSTO_PRODUCTO_ORDEN_TEMP').closest('.form-group').removeClass('has-success').addClass('has-error');
           if (!$('#RG_PRECIO_PRODUCTO_ORDEN_TEMP').val())
               $('#RG_PRECIO_PRODUCTO_ORDEN_TEMP').closest('.form-group').removeClass('has-success').addClass('has-error');
         } else {

            $.ajax({
               url: raiz_url + "inventary/ajax_add_compra",
               type: 'POST',
               data: $(this).serialize(),
               success: function (data) {
                  if (data > 0) {

                     $.toast({
                        heading: '<i class="fas fa-check"></i> Se añadió un artículo ',
                        showHideTransition: 'slide',
                        allowToastClose: true,
                        hideAfter: 2000,
                        position: 'bottom-left',
                        loader: false,
                        afterHidden: function () { window.location.href = raiz_url + "inventary/form_add_buy"; }
                     });
                  } else {
                     $.toast({
                        heading: '<i class="fas fa-times"></i> Error al añadir',
                        showHideTransition: 'slide',
                        allowToastClose: true,
                        hideAfter: 2000,
                        position: 'bottom-left',
                        loader: false,
                     });
                  }
               },
               error: function () {
                  $.toast({
                     heading: '<i class="fas fa-times"></i> Error al añadir',
                     showHideTransition: 'slide',
                     allowToastClose: true,
                     hideAfter: 2000,
                     position: 'bottom-left',
                     loader: false,
                  });
               }
            });
            //MANDAR AJAXX... 
            /*   $('#modAddedItemOrder').on('hidden.bs.modal', function () {
                  window.location.href = raiz_url + "inventary/form_add_buy";
              }); */
         }
      }
   });

   $("#CODIGO_PRODUCTO").on('change', function () {
      traeArticulo();
   });
   $('#SEARCH_PRODUCTO_USAGE').select2({
      placeholder: "Elige un producto",
 
   });
   function traeArticulo() {
      $.ajax({
         type: "POST",
         url: raiz_url + "inventary/product_search",
         data: "autocomplete=" + $("#CODIGO_PRODUCTO").val(),
         success: function (data) {
            if (data) {
               var json = JSON.parse(data);
               if (json.res == 'full') {
                  var x = 0;
                  $('#RG_ID_PRODUCTO_O').val(json.data[x].id);
                  $.ajax({
                     url: raiz_url + "inventary/ajax_get_product_by_id",
                     type: 'POST',
                     data: 'ID_PRODUCTO=' + json.data[x].id,
                     success: function (data) {
                        if (data.length > 0) {
                           $('#RG_COSTO_PRODUCTO_ORDEN_TEMP').val(data[0].COSTO_PRODUCTO);
                           $('#RG_PRECIO_PRODUCTO_ORDEN_TEMP').val(data[0].PRECIO_PRODUCTO);
                           $('#RG_SEARCH_PRODUCTO').val(data[0].NOMBRE_PRODUCTO + " " + data[0].DESCRIPCION_PRODUCTO);
                        }
                     }
                  });
               }
            }
         }
      });
   }

   $('#RG_SEARCH_PRODUCTO').keyup(function () {

      $("#btnaddConcepFact").html('<img src="' + raiz_url + 'assets/img/loading.svg" width="20">');

      var dataString = $(this).val().trim();
      $("#suggestionsProd").empty();
      //if (dataString != '') {
      $.ajax({
         type: "POST",
         url: raiz_url + "inventary/ajax_search_product_by_param",
         data: "data_params=" + dataString,
         cache: false,
         success: function (data) {
            var resultData;
            var id;
            if (data.length > 0) {
               $.each(data, function (arrayID, row) {
                  $("#suggestionsProd").append('<div class="display_box" align="left" data-unit="' + row['COSTO_PRODUCTO']+  '" cant-act="' + row['STOCK_PRODUCTO'] +'" pre="' + row['PRECIO_PRODUCTO'] + '" id="' + row['ID_PRODUCTO'] + '" codigo="' + row['CODIGO_PRODUCTO'] + '">' +
                     row['NOMBRE_PRODUCTO'] + ' ' + row['CODIGO_PRODUCTO'] + '</div>');

               });
               $("#suggestionsProd").show();

               $('.display_box').on('click', function () {

                  //Obtenemos la id unica de la sugerencia pulsada
                  id = $(this).attr('id');
                  if (id > 0) {
                     $('#RG_ID_PRODUCTO_O').val($(this).attr('id'));
                     $('#RG_SEARCH_PRODUCTO').val($(this).html());
                     //meter el hidden de RG_ID_PRODUCTO--
                     $('#RG_ID_PRODUCTO_BOX').val($(this).attr('id'));
                     $('#RG_CANTIDAD_PRODUCTO_ACTUAL_TEMP').val($(this).attr('cant-act'));
                     $('#RG_COSTO_PRODUCTO_ORDEN_TEMP').val($(this).attr('data-unit'));
                     $('#RG_PRECIO_PRODUCTO_ORDEN_TEMP').val($(this).attr('pre'));
                     $('#CODIGO_PRODUCTO').val($(this).attr('codigo'));
                  } else {
                     $('#RG_SEARCH_PRODUCTO').val('');
                  }
                  $('#suggestionsProd').fadeOut(700);
               });
            } else {
               $("#suggestionsProd").html('No hay coincidencias').show();
            }

         }

      });

      $("#btnaddConcepFact").html('<i class="fa fa-plus fa-2x" aria-hidden="true"></i>');

   });

   $('body').on("click", ".btn-del-item-compra", function (e) {
      var ID_PRODUCTO = $(this).attr('data-id-item-compra');
      if (ID_PRODUCTO > 0) {
         $('#modDelItemBuy').modal('toggle');
         $('#modBodyDelItemBuy').html('<b>El artículo será borrado.   <br> ¿ Estás seguro ?</b>');
         $('#btnDelRowItemBuy').on('click', function (e) {
            $.ajax({
               url: raiz_url + "inventary/ajax_delete_product_compra",
               type: 'POST',
               data: 'ID_PRODUCTO=' + ID_PRODUCTO,
               success: function (data) {
                  console.log(data);
                  if (data > 0) {
                     window.location.reload();
                  } else {
                     $('#modBodyDelItemBuy').html('<b>Hubo un error al realizar la operación</b>');
                     $('#btnDelRowItemBuy').attr("disabled", "disabled");
                  }
               }
            });
         });
      }
   });

   $('#cancelAddCompra').on('click', function () {
      console.log("aqui");
      $.ajax({
         url: raiz_url + "inventary/ajax_delete_compra_temp",
         type: 'POST',
         data: $(this).serialize(),
         success: function (data) {
            if (data > 0) {
               window.location.href = raiz_url + "inventary/index_buy";
            } else {
               alert('Falló la base de datos');
            }
         },
         error: function () {
            alert('Hubo un error');
         }
      });
   });

   $('#formRecordBuy').validator().on('submit', function (e) {
      if (e.isDefaultPrevented()) {
         // handle the invalid form...

      } else {
         // everything looks good!
         e.preventDefault();
         $.ajax({
            url: raiz_url + "inventary/ajax_add_new_compra",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {

               if (data > 0) {

                  Swal.fire({
                     title: 'Compra Guardada!',
                     text: 'La compra se guardo correctamente',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 2500,
                     onClose: function () {
                        window.location.href = raiz_url + "inventary/index_buy";
                     },
                  })
               } else {
                  Swal.fire({
                     title: 'Hubo un error al registrar',
                     text: 'No se guardó la compra',
                     icon: 'error',
                     showConfirmButton: false,
                     timer: 2500,
                  })
               }
            }
         });   
      }
   });

   $('body').on("click", ".btn-view-entrie", function (e) {
      var ID_COMPRA = $(this).attr('data-id-buy');
      if (ID_COMPRA > 0) {
         window.open(raiz_url + "inventary/buy_print/" + ID_COMPRA, '_blank');
      }
   });

});