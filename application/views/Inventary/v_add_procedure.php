<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>           
            <form data-toggle="validator" role="form" id="formRecordProcedure">
                <div class="control-group text-left">                   
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-tasks"></i> Nuevo Procedimiento </span></div>
                        </div>
                        <div class="panel-body">   
                            <div class="row">                             
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="RG_DESCRIPCION_PROCEDIMIENTO" class="control-label text-left">Descripción</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fa fa-money-check-edit"></i></span> 
                                            <input type="text" name="RG_DESCRIPCION_PROCEDIMIENTO"    id="RG_DESCRIPCION_PROCEDIMIENTO" class="form-control" required placeholder="Descripción ">
                                        </div>                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-12">
                                    <div class="form-group">
                                        <label for="RG_PRECIO_PROCEDIMIENTO" class="control-label text-left">Precio</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span> 
                                            <input type="text" name="RG_PRECIO_PROCEDIMIENTO"     id="RG_PRECIO_PROCEDIMIENTO" class="form-control decimal-2-places" required placeholder="Precio">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-mdx-6">
                                    <a href="<?= base_url() ?>inventary/index_procedure" class="btn btn-cancel float-left" id="btnCloseAddPatient">
                                        <i class="fa fa-chevron-double-left" aria-hidden="true"></i> Regresar
                                    </a>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-mdx-6">
                                    <button type="submit" class="btn btn-info float-right">
                                        <i class="fa fa-check" aria-hidden="true"></i> Guardar Procedimiento
                                    </button>
                                </div>                                                                        
                            </div>                                
                        </div>
                    </div>                   
                </div>
            </form>        
        </div>
        <div class="col-sm-3">

        </div>
    </div>
</div>
<div class="modal fade" id="modProcedure" tabindex="-1" role="dialog" aria-labelledby="modProcedure" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Registrar procedimiento</h4>
            </div>
            <div class="modal-body" id="modBodyProcedure">
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

