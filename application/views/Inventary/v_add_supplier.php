<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formRecordSupplier">
                <div class="panel">
                     <div class="panel-heading header-black">
                        <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-user-plus"></i> Nuevo proveedor</span></div>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_NOMBRE_PROVEEDOR" class="control-label text-left"  >Nombre</label>
                                    <div class="input-group">      
                                        <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 
                                        <input type="text" required pattern="[a-zA-Z ]+" name="RG_NOMBRE_PROVEEDOR"      id="RG_NOMBRE_PROVEEDOR" class="form-control" placeholder="Nombre de contacto">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>      
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group"> 
                                    <label for="RG_EMPRESA_PROVEEDOR" class="control-label text-left"  >Empresa</label>
                                    <div class="input-group">      
                                        <span class="input-group-addon"><i class="fa fa-building"></i></span> 
                                        <input type="text" name="RG_EMPRESA_PROVEEDOR" required pattern="[0-9a-zA-z.#\- ]+" id="RG_EMPRESA_PROVEEDOR"      class="form-control" placeholder="Empresa proveedora">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>  

                            <div class="col-sm-12 col-mdx-12 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_DOMICILIO_PROVEEDOR" class="control-label text-left"  >Domicilio</label>
                                    <div class="input-group">      
                                        <span class="input-group-addon"><i class="fa fa-street-view"></i></span> 
                                        <input type="text" name="RG_DOMICILIO_PROVEEDOR"  id="RG_DOMICILIO_PROVEEDOR"      class="form-control" required pattern="[0-9a-zA-z,.#\- ]+" placeholder="Domicilio">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_TELEFONO_PROVEEDOR" class="control-label text-left"  >Teléfono</label>
                                    <div class="input-group">      
                                        <span class="input-group-addon"><i class="fa fa-phone-square"></i></span> 
                                        <input type="text" max="10" required pattern="[0-9\-#() ]+" maxlength="30" name="RG_TELEFONO_PROVEEDOR" id="RG_TELEFONO_PROVEEDOR" class="form-control"  placeholder="Teléfono">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_NO_CUENTA_PROVEEDOR" class="control-label text-left">Número de cuenta</label>
                                    <div class="input-group">      
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span> 
                                        <input type="text" required pattern="[0-9]+" name="RG_NO_CUENTA_PROVEEDOR" id="RG_NO_CUENTA_PROVEEDOR" class="form-control integer" placeholder="Cuenta bancaria">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>                                 
                    </div>
                    <div class="panel-footer">                           
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-mdx-6">
                                <a href="<?= base_url() ?>inventary/index_supplier" class="btn btn-cancel float-left">
                                    <i class="fa fa-chevron-double-left" aria-hidden="true"></i> Regresar
                                </a>
                            </div>
                            
                            <div class="col-lg-6 col-sm-6 col-mdx-6">                                       
                                <button type="submit" class="btn btn-info float-right">
                                    <i class="fa fa-check" aria-hidden="true"></i> Guardar proveedor
                                </button>                                                                     
                            </div>
                        </div>
                    </div> 
                </div>
            </form> 
        </div>
    </div>
</div>
<div class="modal fade" id="modSupplier" tabindex="-1" role="dialog" aria-labelledby="modSupplier" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Alta de proveedor</h4>
            </div>
            <div class="modal-body text-center" id="modBodySupplier">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group "> 
                    <button class="btn btn-primary" type="button"  id="btnOkAdvice"  data-dismiss="modal">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Entiendo
                    </button>
                </div>       
            </div>
        </div>
    </div>
</div>
