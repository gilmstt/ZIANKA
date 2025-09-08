<div class="container-fluid">
   <div class="row mt-20">
      <div class="col-lg-8">
         <div class="card-ui">
            <div class="form-group">
               <form id="FormSearch" autocomplete="off" action="<?= base_url("Ventas/index") ?>" method="post">
                  <label for="search" class="control-label text-left">Buscar por código</label>
                  <div class='input-group'>
                     <span class="input-group-addon">
                        <span class="fas fa-barcode"></span>
                     </span>
                     <input type="text" name="search" id="SearchCode" class="form-control"
                        placeholder="Escriba o escanee el producto" required>
                     <span class="input-group-addon">
                        <span class="pointer">Añadir</span>
                     </span>
                  </div>
                  <ul class="list-group" id="ListProducts" style="display: none;"></ul>
               </form>
            </div>
            <br>
            <table class="table table-striped table-cart">
               <thead>
                  <th width="5%"><i class="fas fa-cog"></i></th>
                  <th width="15%">Codigo</th>
                  <th width="30%">Producto</th>
                  <th width="10%">Precio</th>
                  <th width="10%">Cant</th>
                  <th width="15%">Desc.</th>
                  <th width="15%">Total</th>
               </thead>
               <tbody id="tbodyCart"></tbody>
            </table>
            <!--<div class="clearfix">
               <button type="button" class="float-right btn btn-success" id="VentaLibre" data-toggle="modal"
                  data-target="#modVentaLibre">Venta libre</button>
            </div>-->
         </div>

      </div>
      <div class="col-lg-4">
         <div class="card-ui">
            <div class="row card-summary">
               <div class="col-lg-12">
                  <h4>Metodo de pago</h4>
               </div>
               <div class="col-lg-4 text-center">
                  <div class="card-paymentMethod select-method" data-id='1' data-name='Efectivo'><i
                        class="fas fa-money-bill fa-2x"></i></div>
               </div>
               <div class="col-lg-4 text-center">
                  <div class="card-paymentMethod" data-id='2' data-name='Tarjeta'><i
                        class="fas fa-credit-card fa-2x"></i></div>
               </div>
               <div class="col-lg-4 text-center">
                  <div class="card-paymentMethod" data-id=3 data-name='Transferencia'><i
                        class="fas fa-share-all fa-2x"></i></div>
               </div>
               <input type="hidden" id="InputPaymentMethod" value="1">
               <input type="hidden" id="InputNamePayment" value="Efectivo">
               <div class="col-lg-12">
                  <h4 class="mt-20">Detalles</h4>
               </div>
               <div class="col-lg-12">
                  <div class="form-group mt-10">
                     <div class='input-group group-amount'>
                        <span class="input-group-addon">
                           Monto
                        </span>
                        <input type="text" name="receive" id="receive" class="form-control"
                           placeholder="Escriba el monto a pagar" readonly>
                        <input type="text" name="search" id="AmountRecieve" class="form-control"
                           placeholder="Escriba la cantidad recibida" required>
                        <span class="input-group-addon pointer" id="BtnAmountRecieve">
                           <i class="fas fa-plus"></i>  Añadir
                        </span>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <table class="table table-bordered table-striped ">
                     <thead>
                        <th>Método</th>
                        <th>Monto</th>
                        <th><i class="fas fa-cog"></i></th>
                     </thead>
                     <tbody id="tbodyPayments">

                     </tbody>
                  </table>
               </div>
            </div>
            <div class="row card-summary">
               <div class="col-lg-6 text-left">
                  <span>Monto Pagar</span>
               </div>
               <div class="col-lg-6 text-right">
                  <span class="MontoPagar">0.00</span>
               </div>
            </div>
            <div class="row card-summary">
               <div class="col-lg-6 text-left">
                  <span>Cambio</span>
               </div>
               <div class="col-lg-6 text-right">
                  <span class="Cambio">0.00</span>
               </div>
            </div>
            <div class="row card-summary">
               <div class="col-lg-6 text-left">
                  <span>Total Pagos</span>
               </div>
               <div class="col-lg-6 text-right">
                  <span class="TotalPagos">0.00</span>
               </div>
            </div>

            <br>
            <div class="row card-summary">
               <div class="col-lg-6 text-left">
                  <span>Total Pagar</span>
               </div>
               <div class="col-lg-6 text-right">
                  <span class="TotalPagar">0.00</span>
               </div>
               <div class="col-lg-12">
                  <button type="button" id="BtnFinishSale" class="btn btn-success w100 mt-20">Finalizar Venta</button>
               </div>
               <div class="col-lg-12">
                  <button type="button" class="btn btn-secondary w100 mt-20">Cancelar ventar</button>
               </div>
               <div class="col-lg-12">
                  <a href="<?= base_url('Ventas/history') ?>" class="btn btn-secondary w100 mt-20">Ver ventas</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modVentaLibre" tabindex="-1" role="dialog" aria-labelledby="modVentaLibre"
   aria-hidden="true">
   <div class="modal-dialog ">
      <div class="modal-content">
         <form id="FormVentaLibre">
            <div class="modal-header header-primary" id="modalHeaderAdvice">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                     aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="modalTitleAdvice">VENTA LIBRE</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label for="name" class="control-label text-left">Nombre</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                           <input type="text" name="namefree" id="namefree" class="form-control" required
                              placeholder="Nombre producto">
                        </div>
                        <div class="with-errors"></div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="name" class="control-label text-left">Precio</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                           <input type="number" name="pricefree" id="pricefree" class="form-control" required placeholder="0.00">
                        </div>
                        <div class="with-errors"></div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="name" class="control-label text-left">Tipo producto</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fa fa-money-check-edit"></i></span>
                           <select name="type_product" class="form-control">
                              <?php 
                                 $tipos = $this->db->get('tipo_producto')->result_array();
                                 foreach ($tipos as $row) {
                                 echo "<option value='{$row['ID_TIPO_PRODUCTO']}'>{$row['NOMBRE_TIPO_PRODUCTO']}</option>";
                                 }
                              ?>
                           
                           </select>
                        </div>
                        <div class="with-errors"></div>
                     </div>
                  </div>
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label for="name" class="control-label text-left">Descripcion</label>
                       <textarea class="form-control" name="descriptionfree" cols="30" rows="2"></textarea>
                        <div class="with-errors"></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
               <div class="btn-group ">
                  <button class="btn btn-primary" type="button" id="SubmitVentaLibre">
                     <i class="fa fa-check-circle" aria-hidden="true"></i> Añadir
                  </button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="<?= base_url('assets/js/ventas.js') ?>"></script>