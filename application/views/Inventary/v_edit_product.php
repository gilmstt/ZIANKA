<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formEditProduct">
                <input type="hidden" value="<?= $ROW_DATA_PRODUCT[0]['ID_PRODUCTO'] ?>" name="RG_ID_PRODUCT" id="RG_ID_PRODUCT" >
                <div class="control-group text-left">                    
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-edit"></i> Editar producto</span></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-9 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_PRODUCT" class="control-label text-left"  >Nombre</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-money-check-edit"></i></span>
                                            <input required type="text" name="RG_NOMBRE_PRODUCT"  id="RG_NOMBRE_PRODUCT" class="form-control"  placeholder="Nombre producto" value="<?= $ROW_DATA_PRODUCT[0]['NOMBRE_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>                                
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_CODIGO_PRODUCTO" class="control-label text-left"  >Código</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-money-check-edit"></i></span>
                                            <input required type="text" name="RG_CODIGO_PRODUCTO" id="RG_CODIGO_PRODUCTO" class="form-control"  placeholder="Descriopcion" value="<?= $ROW_DATA_PRODUCT[0]['CODIGO_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>           

                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_STOCK_PRODUCT" class="control-label text-left"  >Stock</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-balance-scale-right"></i></span>
                                            <input required type="text" name="RG_STOCK_PRODUCT" id="RG_STOCK_PRODUCT" class="form-control positive-decimal"  placeholder="Stock" value="<?= $ROW_DATA_PRODUCT[0]['STOCK_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>   

                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_STOCK_MINIMO_PRODUCT" class="control-label text-left"  >Stock Mínimo</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-balance-scale-right"></i></span>
                                            <input required type="text" name="RG_STOCK_MINIMO_PRODUCT" id="RG_STOCK_MINIMO_PRODUCT" class="form-control positive-decimal"  placeholder="Stock minimo" value="<?= $ROW_DATA_PRODUCT[0]['STOCK_MINIMO_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>   

                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_COSTO_PRODUCT" class="control-label text-left"  >Costo</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <input required type="text" name="RG_COSTO_PRODUCT" id="RG_COSTO_PRODUCT" class="form-control decimal-2-places"  placeholder="Costo" value="<?= $ROW_DATA_PRODUCT[0]['COSTO_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>   

                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_PRECIO_PRODUCT" class="control-label text-left"  >Precio</label>
                                        <div class="input-group">      
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <input required type="text" name="RG_PRECIO_PRODUCT" id="RG_PRECIO_PRODUCT" class="form-control decimal-2-places"  placeholder="Precio" value="<?= $ROW_DATA_PRODUCT[0]['PRECIO_PRODUCTO'] ?>">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_FECHA_CADUCIDAD_PRODUCTO" class="control-label text-left">Fecha de caducidad</label><br>
                                        <div class="row">
                                            <div class=" col-md-6"> 
                                                <div class="input-group">
                                                    <span class="input-group-addon "><i class="fa fa-calendar"></i></span>
                                                    <input name="RG_FECHA_MES_PRODUCTO" id="RG_FECHA_MES_PRODUCTO" class="form-control"
                                                           placeholder="Mes" value="<?= $ROW_DATA_PRODUCT[0]['FECHA_CADUCIDAD_MES'] ?>"> 
                                                </div>
                                            </div>  
                                            <div class=" col-md-6"> 
                                                <div class="input-group">
                                                    <span class="input-group-addon "><i class="fa fa-calendar"></i></span>
                                                    <input name="RG_FECHA_ANNIO_PRODUCTO" id="RG_FECHA_ANNIO_PRODUCTO" class="form-control"
                                                           placeholder="Año" value="<?= $ROW_DATA_PRODUCT[0]['FECHA_CADUCIDAD_AÑO'] ?>"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_TIPO_PRODUCTO" class="control-label text-left"  >Tipo producto</label>
                                        <select name="RG_TIPO_PRODUCTO" required="" id="RG_TIPO_PRODUCTO" class="form-control">
                                            <?php
                                            if (count($ROW_TYPE_PRODUCT) > NULO):
                                                echo '<option value="">Seleccionar</option>';
                                                foreach ($ROW_TYPE_PRODUCT as $ROW):
                                                    $selected = '';
                                                    $selected = ($ROW['ID_TIPO_PRODUCTO'] == $ROW_DATA_PRODUCT[0]['ID_TIPO_PRODUCTO'])? 'selected="selected"': '';
                                                    ?>
                                                    <option <?= $selected ?> value="<?= $ROW['ID_TIPO_PRODUCTO'] ?>">
                                                        <?= mb_strtoupper($ROW['NOMBRE_TIPO_PRODUCTO']) ?>
                                                    </option>
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <option value="-1">No existen registros</option>
                                            <?php
                                            endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">                            
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-mdx-6">
                                    <a href="<?= base_url() ?>inventary/index" class="btn btn-cancel float-left" >
                                        <i class="fa fa-chevron-double-left" aria-hidden="true"></i> Regresar
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-mdx-6">                                       
                                    <button type="submit" class="btn btn-info float-right">
                                        <i class="fa fa-check" aria-hidden="true"></i> Guardar cambios
                                    </button>                                                                     
                                </div>
                            </div>
                        </div>
                    </div>                                         
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-sm-3"></div>        

<div class="modal fade" id="modEditProduct" tabindex="-1" role="dialog" aria-labelledby="modEditProduct" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Editar Producto</h4>
            </div>
            <div class="modal-body" id="modBodyEditProduct">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group "> 
                    <button class="btn btn-primary" type="button"  id="btnOkAdvice"  data-dismiss="modal">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Ok
                    </button>
                </div>       
            </div>
        </div>

    </div>
</div>      

