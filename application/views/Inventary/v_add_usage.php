<?php 
$CI = & get_instance();
$Productos = $CI->db->get_where('producto', array("ACTIVO_PRODUCTO" => 1))->result_array();
?>
<style>
.table tbody td {
   
    text-align: center !important;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formRecordUsage">
                <div class="panel">
                     <div class="panel-heading header-black">
                        <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-user-plus"></i> Registrar uso interno</span></div>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Descripción</label>
                                        <textarea placeholder="Escribe aquí.." class="form-control" name="RG_DESCRIPCION" id="DESCRIPCION" cols="10" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group"> 
                                        <label for="RG_MATERIAL" class="control-label text-left"  >Buscar material</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span> 
                                            <select style="width:100%" name="SEARCH_PRODUCTO" class="form-control js-example-basic-single"
                                                id="SEARCH_PRODUCTO_USAGE">
                                                <option value="" selected disabled>Elige</option>
                                                <?php
                                                foreach ($Productos as $procs) {
                                                    $name = $procs['NOMBRE_PRODUCTO'];
                                                    $id = $procs['ID_PRODUCTO'];
                                                    $code = $procs['CODIGO_PRODUCTO'];
                                                    echo "<option value='$id' data-code='$code'>$name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>  
                            </div>  
                            <div class="col-sm-12 col-mdx-6 col-lg-6">
                                <table class="table table-centered table-striped" id="TABLE_ADD_USAGE">
                                    <thead>
                                        <th width="10%">*</th>
                                        <th width="20%">Código</th>
                                        <th width="20%">Cantidad</th>
                                        <th width="50%">Nombre</th>
                                      
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
                                    <i class="fa fa-check" aria-hidden="true"></i> Registrar uso
                                </button>                                                                     
                            </div>
                        </div>
                    </div> 
                </div>
            </form> 
        </div>
    </div>
</div>

