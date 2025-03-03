<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9 text-center animated fadeIn">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <ul class="nav nav-tabs">
                        <li id="mat" class=" active"><a href="#VIEW_MAT" data-toggle="tab"><i class="fa fa-tools"></i> MATERIALES</a>
                        </li>
                        <li id="med" class=""><a href="#VIEW_MED" data-toggle="tab"><i class="fa fa-tablets"></i> MEDICAMENTOS</a>
                        </li>
                    <?php
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        ?>
                        <a id="btnAddProduct" class="btn btn-header pull-right" >
                            <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nuevo producto
                        </a>
                    <?php endif; ?>
                    </ul>
                </div>
            </div> 
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="VIEW_MAT">
                        <div class="panel-body p-resp">
                            <div class="control-group text-left">
                                <div class="table-responsivex">
                                    <table id="dataProducts" class="table table-bordered table-striped text-center" style="font-size: 14px; border-radius:5px;" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%">Acciones</th>
                                                <th width="25%">Nombre</th>
                                                <th width="25%">Código</th>
                                                <th width="15%">Stock</th>
                                                <th width="15%">Stock mínimo</th>
                                                <th width="10%">Precio</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="VIEW_MED">
                        <div class="panel-body p-resp">
                            <div class="control-group text-left">
                                <div class="table-responsivex">
                                    <table id="dataMed" class="table table-bordered table-striped  text-center" style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%">Acciones</th>
                                                <th width="25%">Nombre</th>
                                                <th width="25%">Código</th>
                                                <th width="15%">Stock</th>
                                                <th width="15%">Stock mínimo</th>
                                                <th width="10%">Precio</th>
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
    </div>
</div>
</div>
<div class="modal fade" id="modDelProduct" tabindex="-1" role="dialog" aria-labelledby="modDelProduct" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Borrar Producto</h4>
            </div>
            <div class="modal-body text-center" id="modBodyDelProduct">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">

                    <button class="btn btn-default" type="button"  id="btnCancel"  data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancelar
                    </button>

                    <button class="btn btn-primary" type="button"  id="btnDelRowProduct">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Si, borrar
                    </button>
                </div>
            </div>
        </div>
        <div class="col-sm-2 text-center"></div>
    </div>
</div>

