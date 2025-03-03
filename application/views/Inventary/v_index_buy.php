<div class="container-fluid">
   <div class="row">

      <div class="col-sm-12 col-md-12 col-lg-3">
         <?php $this->view('Inventary/v_navbar'); ?>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-9 animated fadeIn">
         <br>
         <div class="panel panel-primary">
            <div class="panel-heading text-left header-primary">
               <div class="panel-title text-left">
                   <span class="heading-primary"><i class="fas fa-hand-holding-usd"></i>
                     Compras
                  </span>
                  <a href="<?= base_url() ?>inventary/form_add_buy" class="btn btn-header pull-right"
                     id="btnAddProcedure">
                     <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nueva compra
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <form id="formBuy" href="<?php base_url(); ?>inventary/index_buy" method="post">
                  <input type="hidden" name="RG_BUSCAR" id="RG_BUSCAR" value="0">
                  <div class="row">
                     <div class='col-sm-12 col-mdx-6 col-lg-4'>
                        <div class="form-group">
                           <label for="RG_FECHA_INICIAL" class="control-label text-left">Fecha inicial</label>
                           <div class='input-group date' id='fechaInicio' style="cursor:pointer;">
                              <input type="text" name="RG_FECHA_INICIAL" data-type="datepicker" readonly=""  id="RG_FECHA_INICIAL"
                                 class="form-control" placeholder="Desde" value="<?= $fechaini ?>" readonly>
                              <span class="input-group-addon">
                                 <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class='col-sm-12 col-mdx-6 col-lg-4'>
                        <div class="form-group">
                           <label for="RG_FECHA_FINAL" class="control-label text-left">Fecha final</label>
                           <div class='input-group date' id='fechaFinal'>
                              <input type="text" name="RG_FECHA_FINAL" data-type="datepicker" readonly="" id="RG_FECHA_FINAL" class="form-control"
                                 placeholder="Hasta" value="<?= $fechafin ?>" readonly>
                              <span class="input-group-addon">
                                 <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class='col-sm-2 col-mdx-2 col-lg-2'>                                     
                        <button type="submit" id="btnCargaVentas" class="btn btn-info btn-mobile-load">
                           <i class="fa fa-search" aria-hidden="true"></i> Cargar
                        </button>                     
                     </div>
                  </div><br>
               </form>
               <table id="dataVentasDia" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th width="10%">Acciones</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Status</th>
                        <th width="15%">Empleado</th>
                        <th width="30%">Proveedor</th>
                        <th width="10%">Total</th>
                        <th width="20%">Comentarios</th>
                     </tr>
                  </thead>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- MODAL ELIMINAR BUY -->
<div class="modal fade" id="modDelBuy" tabindex="-1" role="dialog" aria-labelledby="modDelBuy" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <div class="modal-header header-primary" id="modalHeaderAdvice">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalTitleAdvice">Borrar compra</h4>
         </div>
         <div class="modal-body text-center" id="modBodyDelBuy">

         </div>
         <div class="clear"></div>
         <div class="modal-footer">
            <div class="btn-group ">
               <button class="btn" type="button" id="btnCancel" data-dismiss="modal">
                  <i class="fa fa-times" aria-hidden="true"></i> Cancelar
               </button>
               <button class="btn btn-primary" type="button" id="btnDelRowBuy">
                  <i class="fa fa-check-circle" aria-hidden="true"></i> Si, borrar
               </button>
            </div>
         </div>
      </div>
   </div>
</div>