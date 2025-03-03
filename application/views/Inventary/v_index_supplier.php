<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9 text-center animated fadeIn">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-users"></i> PROVEEDORES</span>
                        <a href="<?= base_url() ?>inventary/form_add_supplier" class="btn btn-header pull-right"  id="btnAddSupplier">
                            <i class="fa fa-plus-circle" prescription-bottle aria-hidden="true"></i> Nuevo proveedor
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group text-left">
                        <div>
                            <table id="dataSupliers" class="table table-bordered table-striped text-center fz-table">
                                <thead>
                                    <tr>
                                        <th width="10%">acciones</th>
                                        <th width="20%">Empresa</th>
                                        <th width="10%">Teléfono</th>
                                        <th width="60%">Dirección</th>
                                    </tr>
                                </thead>
                              
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modDelSupplier" tabindex="-1" role="dialog" aria-labelledby="modDelSupplier" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Borrar proveedor</h4>
            </div>
            <div class="modal-body text-center" id="modBodyDelSupplier">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn" type="button"  id="btnCancel"  data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancelar
                    </button>
                    <button class="btn btn-primary" type="button"  id="btnDelRowSupplier">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Si, borrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>