<div class="container-fluid">
   <div class="row mt-20">
      <div class="col-lg-4">
         <div class="card-ui">
            <div class="form-group">
               <label for="date1" class="control-label text-left">Fecha inicial</label>
               <div class='input-group'>
                  <span class="input-group-addon">
                     <span class="fas fa-calendar"></span>
                  </span>
                  <input type="date" name="date1" id="date1" class="form-control" value="<?=date('Y-m-d')?>">
               </div>
            </div>
            <div class="form-group">
               <label for="date2" class="control-label text-left">Fecha inicial</label>
               <div class='input-group'>
                  <span class="input-group-addon">
                     <span class="fas fa-calendar"></span>
                  </span>
                  <input type="date" name="date2" id="date2" class="form-control" value="<?=date('Y-m-d')?>">
               </div>
            </div>
               <div class="form-group text-left">
                  <a class="link-title-a" href="<?= base_url() ?>report/index">
                     <span class="link-title-span">Regresar</span>
                  </a>
               </div>
               <div class="form-group text-right">
                  <button id="BtnSearchSales">Buscar</button>
               </div>
         </div>
      </div>
      <div class="col-lg-8">
         <div class="card-ui">
            <table class="table">
               <thead>
                  <th>Fecha</th>
                  <th>Facturado</th>
                  <th>Activa</th>
                  <th>Commentarios</th>
                  <th>Opciones</th>
               </thead>
               <tbody id="tbodySales"></tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modAdvice" tabindex="-1" role="dialog" aria-labelledby="modAdvice" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Reimpresión</h4>
            </div>
            <div class="modal-body text-left" id="modBodyAdvice"></div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn" type="button"  id="btnCancel"  data-dismiss="modal">
                        <i class="fa fa-check" aria-hidden="true"></i> Aceptar
                    </button>
                </div>       
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modAdvice2" tabindex="-1" role="dialog" aria-labelledby="modAdvice2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Facturar</h4>
            </div>
            <div class="modal-body text-left" id="modBodyAdvice2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="RG_ID_CLIENTE" class="control-label text-left"  >Seleccionar cliente:</label>
                            <select required name="RG_ID_CLIENTE" id="RG_ID_CLIENTE" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php foreach ($CLIENTES as $CLIENTE) { ?>
                                    <option value="<?= $CLIENTE['ID_CLIENTE'] ?>"><?= $CLIENTE['RSOC_CLIENTE'] . " " . " (" . $CLIENTE['RFC_CLIENTE'] . ")" ?></option>
                                <?php } ?>
                            </select>
                            <div id="error_div1" class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="RG_FORMA_PAGO" class="control-label text-left"  >Seleccionar forma de pago:</label>
                            <select required name="RG_FORMA_PAGO" id="RG_FORMA_PAGO" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="01">Efectivo</option>
                                <option value="02">Cheque nominativo</option>
                                <option value="03">Transferencia electrónica de fondos</option>
                                <option value="04">Tarjeta de crédito</option>
                                <option value="28">Tarjeta de débito</option>
                                <option value="99">Por definir</option>
                            </select>
                            <div id="error_div2" class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="RG_USO_CFDI" class="control-label text-left"  >Uso de CFDI:</label>
                            <select required name="RG_USO_CFDI" id="RG_USO_CFDI" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="G01">Adquisición de mercancias</option>
                                <option value="G03">Gastos en general</option>
                                <option value="I08">Otra maquinaria y equipo</option>
                                <option value="S01">Sin efectos fiscales</option>
                                <option value="P01">Por definir</option>
                            </select>
                            <div id="error_div3" class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="RG_TIPO_PAGO" class="control-label text-left"  >Tipo pago:</label>
                            <select required name="RG_TIPO_PAGO" id="RG_TIPO_PAGO" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="PUE">Pago en una sola exhibición</option>
                                <option value="PPD">Pago en parcialidades o diferido</option>
                            </select>
                            <div id="error_div4" class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn" type="button" id="btnCancel" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                    </button>
                    <button type="button" id="btnFacturaMod" class="btn btn-primary pull-right">
                        <i class="fa fa-file" aria-hidden="true"></i> Facturar
                    </button>
                </div>       
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/ventas.js') ?>"></script>
