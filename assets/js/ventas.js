$(document).ready(function () {

   GetCart()

   //Get inputs params
   const InputAmount = $("#AmountRecieve")
   const InputReceive = $("#receive");
   const InputNamePay = $("#InputNamePayment")
   const InputPayMethod = $("#InputPaymentMethod")
   //Get values cart
   const ChangeCash = $(".Cambio")
   const TotalToPay = $(".TotalPagar")
   const AmountToPay = $(".MontoPagar")
   const TotalPayments = $(".TotalPagos")
   //Get handlers
   const TbodyCart = $("#tbodyCart")

   $.fn.delayPasteKeyUp = function (fn, ms)
    {
       var timer = 0;
       $(this).on("keyup paste", function ()
       {
           clearTimeout(timer);
           timer = setTimeout(fn, ms);
       });
   };
   $("#SearchCode").delayPasteKeyUp(function () {
       GetProducts()
   }, 500);

   /*$("#SearchCode").keyup(function (e) {
      GetProducts()
   });*/
   $("body").on('keyup', '.ItemDesc', function (e) {
      let id = $(this).data('id')
      let qty = $('.item-' + id).val();

      UpdateCart(id, qty, 'desc')

   })
   $("body").on('change', '.ItemDesc', function (e) {
      let id = $(this).data('id')
      let qty = $('.item-' + id).val();

      UpdateCart(id, qty, 'desc')
   })
   $("body").on('keyup', '.ItemQty', function (e) {
      let qty = $(this).val()
      let id = $(this).data('id')

      UpdateCart(id, qty)
   })
   $("body").on('change', '.ItemQty', function (e) {
      let qty = $(this).val()
      let id = $(this).data('id')

      UpdateCart(id, qty)
   })

   $("body").on('click', '.card-paymentMethod', function () {
      let card = $(this)
      let method_id = card.data('id')

      $('.card-paymentMethod').each(function () {
         $(this).removeClass('select-method')
      });

      if (method_id == 2 || method_id == 3) {
         InputAmount.val(AmountToPay.html())
         InputReceive.hide();
      } else {
         InputAmount.val(AmountToPay.html())
         //InputAmount.val('').focus()
         InputReceive.show();
      }

      card.addClass('select-method')
      InputNamePay.val(card.data('name'))
      InputPayMethod.val(card.data('id'))

   })
   $("body").on('click', '.AddPayment', function () {
      let id = $(this).data('id')

      $.ajax({

         type: "POST",
         url: raiz_url + "Ventas/PaymentCart",
         data: { id: id, action: 'add' },
         success: function (response) {
            PaymentsCart()
            InputAmount.val('')
            $("#ListPayments").html('').hide()
         }
      });

   })
   $("body").on('click', '.AddItem', function () {
      let id = $(this).data('id')

      $.ajax({
         type: "POST",
         url: raiz_url + "Ventas/ProductCart",
         data: { id: id, action: 'add' },
         success: function (response) {
            GetCart()
            $("#SearchCode").val('').focus()
            $("#ListProducts").html('').hide()
         }
      });

   })
   $("body").on('click', '.RemovePayment', function () {
      let id = $(this).data('id')

      $.ajax({
         type: "POST",
         url: raiz_url + "Ventas/removePayment",
         data: { id: id },
         success: function (response) {
            if (response == true) {
               PaymentsCart()
            }
         }
      });

   })
   $("body").on('click', '.RemoveItem', function () {
      let id = $(this).data('id')

      $.ajax({
         type: "POST",
         url: raiz_url + "Ventas/ProductCart",
         data: { id: id, action: 'remove' },
         success: function (response) {
            if (response == true) {
               GetCart()
            }
         }
      });

   })
   $("#SubmitVentaLibre").click(function (e) {
      e.preventDefault()
      var form = $('#FormVentaLibre')[0];
      var data = new FormData(form);

      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/VentaLibre",
         data: data,
         processData: false,
         contentType: false,
         dataType: "json",
         success: function (response) {
            if (response == true) {
               GetCart()
               form.reset();
               $("#modVentaLibre").modal('hide')
            } else {
               alert('error')
            }
         }
      });
   })
   $("#BtnAmountRecieve").click(function (e) {

      let name = InputNamePay.val()
      let amount = InputAmount.val()
      let receive = InputReceive.val()
      let method = InputPayMethod.val()

      if ((amount < receive) && (name !== "Efectivo") && (name !== "Tarjeta")) {
         Swal.fire({
            title: 'La cantidad recibida no puede ser menor al monto a pagar',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500,
         });
      } else {

         const AlertCart = $(".alert-cart")
         const BorderInput = $(".group-amount")

         if (TbodyCart.is(':empty')) {
            AlertCart.removeClass('alert-secondary').addClass('alert-warning')
            setTimeout(() => {
               AlertCart.removeClass('alert-warning').addClass('alert-secondary')
            }, 1500);
            return false
         }

         if (amount == '' || amount <= 0) {
            BorderInput
               .css({ 'border': '1px solid red', 'border-radius': '5px' })

            setTimeout(() => {
               BorderInput.css('border', 'none')
            }, 1000);

            return false
         }
         console.log("amount:" + amount);
         console.log("receive:" + receive);
         console.log("topay:" + $(".MontoPagar").html());
         $.ajax({
            type: "post",
            url: raiz_url + "Ventas/insertPayment",
            data: {
               amount: amount,
               method: method,
               receive: receive,
               topay: $(".MontoPagar").html(),
               name: name,
            },
            success: function (response) {
               PaymentsCart()
               InputAmount.val('').focus()
            }
         });
      }
   })
   $("#BtnSearchSales").click(function () {
      GetSales()
   })
   $("#BtnFinishSale").click(function (e) {

      let amount = parseFloat(AmountToPay.html())
      let cart = $("#tbodyCart").html().length

      if (cart <= 0) {
         Swal.fire({
            title: 'No has agregado productos al carrito',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500,
         });
         return false
      }

      if (amount <= 0) {
         $.ajax({
            type: "post",
            url: raiz_url + "Ventas/insertSale",
            dataType: "json",
            success: function (response) {
               if (response.data.status == true) { console.log(data);
                  Swal.fire({
                     title: 'Venta Registrada!',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1500,
                     onClose: function () {
                        window.location.reload();
                     }
                  });

               }
            }
         });
      } else {
         Swal.fire({
            title: 'Monto a pagar debe quedar en 0',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500,
         });
      }

   })
   function GetSales() {
      let items = '';
      const start_date = $("#date1").val()
      const end_date = $("#date2").val()

      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/getSales",
         data: {
            start_date: start_date,
            end_date: end_date,
         },
         dataType: 'json',
         success: function (response) {
            response.data.forEach(function (val, i) {
               let active = val.ACTIVA == 1 ? 'Activa' : 'Inactiva'
               var facturado = val.FACTURADO == 1 ? '<span style="color:green">Facturado</span>' : 'No Facturado'
               let buttons = ""
               buttons += val.FACTURADO == 1 ? "" : "<button title='Facturar' id='btnFacturar' class='btn btn-primary btn-facturar' data-sale-id='" + val.ID_VENTA + "'><i class='fa fa-file-pdf' ></i></button>"
               buttons += "<button title='Reimprimir' id='btnPrint' class='btn btn-primary btn-print'  data-sale-id='" + val.ID_VENTA + "'><i class='fa fa-print'></i></button>\n\
                           <button id='btnViewSale' class='btn btn-primary btn-view-sale' data-original-title='Ver venta' data-toggle='tooltip' data-id-venta='" + val.ID_VENTA + "'><i class='fa fa-eye'></i></button>\n\
                           <button id='btnCancelSale' class='btn btn-primary btn-cancel-sale' data-original-title='Cancelar venta' data-toggle='tooltip' data-id-venta='" + val.ID_VENTA + "' style='color: red;'><i class='fa fa-times'></i></button>";
               items += `
                  <tr>
                     <td class="text-center pointer">${val.FECHA}</td>
                     <td class="text-center">${facturado}</td>
                     <td class="text-center">${active}</td>
                     <td class="text-center">${val.COMENTARIOS}</td>
                     <td class="text-center">${buttons}</td>
                  </tr>
               `;
            })
            $("#tbodySales").html(items)
         }
      })
   }
   $("body").on('click', '.btn-view-sale', function () {
      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/searchSale",
         data: {
            sale_id: $(this).data('id-venta')
         },
         success: function (response) {
            Swal.fire({
               html: response
            });
         }
      });

   });
   $('body').on("click", ".btn-print", function (e) {
      var SALE_ID = $(this).attr('data-sale-id');
      if (SALE_ID > 0) {
         $('#modAdvice').modal('toggle');
         $('#myModal').modal('toggle');
         $('#modBodyAdvice').html('Reimprimiendo...');
         $.ajax({
            url: raiz_url + "sales/ajax_reprint_ticket",
            type: 'POST',
            data: 'SALE_ID=' + SALE_ID,
            success: function (data) {
               console.log(data);
               if (data > 0) {
                  $('#modBodyAdvice').html('<b>Reimpresión finalizada</b>');
                  //window.location.reload();
               } else {
                  $('#modBodyAdvice').html('<b>Hubo un error al reimprimir el ticket</b>');
               }
            }
         });
      } else {
         $('#modBodyAdvice').html('Hubo un error al reimprimir el ticket');
      }
   });
   $('body').on("click", ".btn-facturar", function (e) {
      $('#myModal').modal('hide');
      var SALE_ID = $(this).attr('data-sale-id');
      if (SALE_ID > 0) {
         $('#modAdvice2').modal('show');
         $('#btnFacturaMod').on('click', function (e) {
            var ID_CLIENTE = $('#RG_ID_CLIENTE').val();
            var FORMA_PAGO = $('#RG_FORMA_PAGO').val();
            var USO_CFDI = $('#RG_USO_CFDI').val();
            var TIPO_PAGO = $('#RG_TIPO_PAGO').val();
            if (!ID_CLIENTE || !FORMA_PAGO || !USO_CFDI || !TIPO_PAGO) {
               if (!$('#RG_ID_CLIENTE').val()) {
                  $('#RG_ID_CLIENTE').closest('.form-group').removeClass('has-success').addClass('has-error');
                  $('#error_div1').html('Elige una opción');
               }
               if (!$('#RG_FORMA_PAGO').val()) {
                  $('#RG_FORMA_PAGO').closest('.form-group').removeClass('has-success').addClass('has-error');
                  $('#error_div2').html('Elige una opción');
               }
               if (!$('#RG_USO_CFDI').val()) {
                  $('#RG_USO_CFDI').closest('.form-group').removeClass('has-success').addClass('has-error');
                  $('#error_div3').html('Elige una opción');
               }
               if (!$('#RG_TIPO_PAGO').val()) {
                  $('#RG_TIPO_PAGO').closest('.form-group').removeClass('has-success').addClass('has-error');
                  $('#error_div4').html('Elige una opción');
               }
            } else {
               $('#btnFacturaMod').hide();
               $('#modBodyAdvice2').html('Facturando...<br><img src="' + raiz_url + '/assets/img/loading.svg" width="20" class=" img-responsive" alt="Cargando"/>');
               $.ajax({
                  url: raiz_url + "factura/ajax_genera_factura",
                  type: 'POST',
                  data: 'SALE_ID=' + SALE_ID + '&ID_CLIENTE=' + ID_CLIENTE + '&FORMA_PAGO=' + FORMA_PAGO + '&USO_CFDI=' + USO_CFDI + '&TIPO_PAGO=' + TIPO_PAGO,
                  success: function (data) {
                     //console.log(data);
                     if (data) {
                        //var response = JSON.parse(data);
                        if (data.error == 1) {
                           $('#modAdvice2').modal('show');
                           $('#modBodyAdvice2').html(data.message);
                        } else {
                           $('#modAdvice2').modal('show');
                           $('#modBodyAdvice2').html("La factura se realizó correctamente!!");
                           $('#modAdvice2').on('hidden.bs.modal', function () {
                              window.location.href = raiz_url + "factura/index_factura";
                           });
                        }
                     } else {
                        $('#modBodyAdvice2').html('<b>Hubo un error al generar la factura</b>');
                     }
                  },
                  error: function (e) {
                     $('#modBodyAdvice2').html('<b>Hubo un error al generar la factura</b>');
                  }
               });
            }
         });
      } else {
         $('#modBodyAdvice').html('Seleccione una venta por favor');
      }
   });
   $("body").on('click', '.btn-cancel-sale', function () {
      Swal.fire({
         title: '¿Estas seguro?',
         text: "Este cambio no se puede revertir!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Si, cancelarla!',
         cancelButtonText: 'No',
      }).then((result) => {
         if (result.value == true) {
            $.ajax({
               type: "post",
               url: raiz_url + "Ventas/cancelSale",
               dataType: "json",
               data: {
                  sale_id: $(this).data('id-venta')
               },
               success: function (response) {
                  if (response.data.status == true) {
                     Swal.fire({
                        title: 'La venta ha sido cancelada',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: function () {
                           window.location.reload();
                        }
                     });
                  }
               }
            });
         }
      })
   });
   function GetProducts() {
      const code = $("#SearchCode").val()
      const ListProducts = $("#ListProducts")

      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/searchCode",
         data: {
            code: code
         },
         success: function (response) {
            if (code.length > 0) {
               ListProducts.html(response).show()
            } else {
               ListProducts.html('').hide()
            }
         }
      });
   }
   function PaymentsCart() {
      let items = '';
      let total = 0;
      let Table = $("#tbodyPayments")

      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/getPayments",
         dataType: 'json',
         success: function (response) {
            if (response.data.length > 0) {
               response.data.forEach(function (val, i) {
                  total = parseFloat(val.amount) + total;
                  items += `
                  <tr>
                     <td class="text-center">${val.name}</td>

                     <td class="text-center">${val.amount}</td>

                     <td class="text-center">
                        <i class="fas fa-times RemovePayment pointer" data-id='${val.method}'></i>
                     </td>
                  </tr>
                  `
               });

               Table.html(items)
               ChangeCash.html(response.change)
               TotalPayments.html(response.totalPayments)
              /* if(AmountToPay.html((parseFloat(TotalToPay.html()) - parseFloat(response.totalPayments))<=0)){
                  AmountToPay.html('0.00')
               }
               else{
                  AmountToPay.html((parseFloat(TotalToPay.html()) - parseFloat(response.totalPayments)))
               }*/
               AmountToPay.html(response.totalCart);
            } else {
               Table
                  .html('<td class="text-center alert-secondary" colspan="8">Agrega un Pago</td>')

               ChangeCash.html('0.00')
               TotalPayments.html('0.00')
               AmountToPay.html(TotalToPay.html());

            }
         }
      });
   }
   function GetCart() {
      let items = '';
      let total = 0;
      let totalItem = 0;
      const AlertCart = $('.alert-cart')

      $.ajax({
         type: "post",
         url: raiz_url + "Ventas/getCart",
         dataType: 'json',
         success: function (response) {
            //console.log(response);
            //if (response.length > 0) {
               //response.forEach(function (val, i) {
               Object.entries(response).forEach(([key, val]) => {

                  totalItem = parseFloat(val.price) * val.qty;

                  let desc = totalItem * (val.desc / 100);
                  let priceDiscount = totalItem - desc;

                  total = total + priceDiscount;

                  items += `
                  <tr>
                     <td class="text-center pointer">
                        <i class='fas fa-times RemoveItem' data-id='${val.id}'></i>
                     </td>

                     <td class="text-center">${val.code}</td>

                     <td>${val.name}</td>

                     <td class="text-center">${val.price}</td>

                     <td class="text-center">
                        <input type='number' value='${val.qty}' min='1' data-id='${val.id}'
                        class='form-control text-center ItemQty item-${val.id}' onclick="this.select()">
                     </td>

                     <td class="text-center">
                        <input type='number' value='${val.desc}' class='form-control text-center ItemDesc desc-${val.id}' min='0' data-id='${val.id}'  onclick="this.select()">
                     </td>

                     <td class="text-center">$ ${priceDiscount}</td>
                  </tr>
                  `
               });

               AlertCart.remove()
               TbodyCart.html(items)
               TotalToPay.html(total)
               AmountToPay.html((total - parseInt(TotalPayments.html())))

               //amount receive
               InputAmount.val(total)

               //ammount payment
               InputReceive.val(total)
               if(total <= 0){
                  AmountToPay.html('0.00')
                  InputReceive.val('0.00')
                  InputAmount.val('0.00')
               }
            /*} else {
               TbodyCart.html('')
               TotalToPay.html('0.00')
               AmountToPay.html('0.00')
               InputReceive.val('0.00')
               InputAmount.val('0.00')

               $(".table-cart").after('<div class="alert alert-secondary text-center alert-cart">Agrega un producto al carrito</div>')
            }*/
         }
      });

      PaymentsCart()
   }
   function UpdateCart(id, qty, event = '') {

      const desc = $('.desc-' + id).val();
      const inputQty = $('.item-' + id);

      if (qty <= 0) {
         inputQty.val('1')
      }
      else {
         $.ajax({
            type: "POST",
            url: raiz_url + "Ventas/ProductCart",
            data: { id: id, qty: qty, desc: desc, action: 'update' },
            success: function (response) {
               GetCart()
               if (event == 'desc') {
                  setTimeout(() => {
                     $(`.desc-${id}`).attr('type', 'text')
                     PosEnd(document.querySelector(`.desc-${id}`))
                     $(`.desc-${id}`).attr('type', 'number')
                  }, 100);
               } else {
                  setTimeout(() => {
                     $(`.item-${id}`).attr('type', 'text')
                     PosEnd(document.querySelector(`.item-${id}`))
                     $(`.item-${id}`).attr('type', 'number')
                  }, 100);
               }
            }
         });
      }
   }
   function PosEnd(end) {
      var len = end.value.length;

      // Mostly for Web Browsers
      if (end.setSelectionRange) {
         end.focus();
         end.setSelectionRange(len, len);
      } else if (end.createTextRange) {
         var t = end.createTextRange();
         t.collapse(true);
         t.moveEnd('character', len);
         t.moveStart('character', len);
         t.select();
      }
   }

});

