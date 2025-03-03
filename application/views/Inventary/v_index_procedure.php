    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
            <div class="col-sm-12 col-md-12 col-lg-9 text-center animated fadeIn">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fa fa-tasks"></i> Procedimientos</span>
                    <?php
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        $disabled = '';
                    else:
                        $disabled = '';
                    endif;
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        ?>
                        <a href="<?= base_url() ?>inventary/form_add_procedure" class="btn btn-header pull-right" id="btnAddProcedure">
                            <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nuevo procedimiento
                        </a>
                    <?php endif;?>
                    </div>
                </div>
                <div class="panel-body">

                    <div style="clear:both"><br></div>
                    <div class="control-group text-left">
                        <div class="table-responsive">
                            <table id="dataProcedure" class="table table-bordered table-striped text-center fz-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Acciones</th>
                                        <th width="70%">Descripción</th>
                                        <th width="15%">Precio</th>
                                    </tr>
                                </thead>
                             
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
            <div><br></div>
        </div>
    </div>
</div>


