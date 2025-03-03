<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-mdx-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-mdx-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formEditSupplier">
                <div class="panel panel-primary">
                    <input type="hidden" name="RG_ID_PROVEEDOR" id="RG_ID_PROVEEDOR" value="<?= $ROW_DATA_SUPPLIER[0]['ID_PROVEEDOR'] ?>">
                    <div class="panel-heading header-black">
                        <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-edit"> </i>Editar proveedor</span></div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_NOMBRE_PROVEEDOR" class="control-label text-left"  >Nombre</label>
                                     <div class='input-group'>
                                        <span class="input-group-addon"><i class="fas fa-id-card"></i></span>
                                        <input type="text" name="RG_NOMBRE_PROVEEDOR" id="RG_NOMBRE_PROVEEDOR"      class="form-control" placeholder="Nombre de contacto" value="<?= $ROW_DATA_SUPPLIER[0]['NOMBRE_PROVEEDOR'] ?>">
                                    </div>                                
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>      
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group"> 
                                    <label for="RG_EMPRESA_PROVEEDOR" class="control-label text-left"  >Empresa</label>
                                     <div class='input-group'>
                                        <span class="input-group-addon"><i class="fas fa-building"></i></span>
                                        <input type="text" name="RG_EMPRESA_PROVEEDOR" required id="RG_EMPRESA_PROVEEDOR"      class="form-control" placeholder="Empresa proveedora" value="<?= $ROW_DATA_SUPPLIER[0]['EMPRESA_PROVEEDOR'] ?>">
                                    </div>                                
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> 
                            <div class="col-sm-12 col-mdx-12 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_DOMICILIO_PROVEEDOR" class="control-label text-left"  >Domicilio</label>
                                     <div class='input-group'>
                                        <span class="input-group-addon"><i class="fas fa-street-view"></i></span>
                                        <input type="text" name="RG_DOMICILIO_PROVEEDOR"  id="RG_DOMICILIO_PROVEEDOR"      class="form-control" placeholder="Domicilio" value="<?= $ROW_DATA_SUPPLIER[0]['DOMICILIO_PROVEEDOR'] ?>">
                                    </div>                                
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_TELEFONO_PROVEEDOR" class="control-label text-left"  >Télefono</label>
                                     <div class='input-group'>
                                        <span class="input-group-addon"><i class="fas fa-phone-square"></i></span>
                                        <input type="text" name="RG_TELEFONO_PROVEEDOR" id="RG_TELEFONO_PROVEEDOR" class="form-control" placeholder="Télefono" value="<?= $ROW_DATA_SUPPLIER[0]['TELEFONO_PROVEEDOR'] ?>">
                                    </div>                                
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="form-group">
                                    <label for="RG_NO_CUENTA_PROVEEDOR" class="control-label text-left"  >Descripción</label>
                                     <div class='input-group'>
                                        <span class="input-group-addon"><i class="fas fa-money-check-edit"></i></span>
                                        <input type="text" name="RG_NO_CUENTA_PROVEEDOR" id="RG_NO_CUENTA_PROVEEDOR" class="form-control integer" placeholder="Cuenta bancaria" value="<?= $ROW_DATA_SUPPLIER[0]['NO_CUENTA_PROVEEDOR'] ?>">
                                    </div>                                

                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="panel-footer">                                                      
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="<?= base_url() ?>inventary/index_supplier" class="btn btn-cancel pull-left" id="btnCloseAddPatient">
                                        <i class="fas fa-chevron-double-left"></i> Regresar
                                    </a>
                                    <button type="submit" class="btn btn-info pull-right">
                                        <i class="fas fa-user-check"></i> Actualizar proveedor
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modEditSupplier" tabindex="-1" role="dialog" aria-labelledby="modEditSupplier" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Actualización del proveedor</h4>
            </div>
            <div class="modal-body text-center" id="modBodyEditSupplier">
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