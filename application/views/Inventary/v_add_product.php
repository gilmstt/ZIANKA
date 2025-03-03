<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formRecordProduct">
                <div class="control-group text-left">
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-layer-plus"></i>
                                    Nuevo Producto </span></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-9 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_PRODUCTO" class="control-label text-left">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-money-check-edit"></i></span>
                                            <input type="text" name="RG_NOMBRE_PRODUCTO"
                                                       id="RG_NOMBRE_PRODUCTO"
                                                   class="form-control" required placeholder="Nombre producto">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_CODIGO_PRODUCTO" class="control-label text-left">Código</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-money-check-edit"></i></span>
                                            <input type="text" name="RG_CODIGO_PRODUCTO"
                                                       id="RG_CODIGO_PRODUCTO"
                                                   class="form-control" required placeholder="Código producto">
                                        </div>

                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">

                                        <label for="RG_STOCK_PRODUCTO" class="control-label text-left">Stock</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-box-check"></i></span>
                                            <input type="text" name="RG_STOCK_PRODUCTO" id="RG_STOCK_PRODUCTO" class="form-control positive-decimal"
                                                   required placeholder="Stock producto">
                                        </div>

                                        <div class="with-errors"></div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_STOCK_MINIMO_PRODUCTO" class="control-label text-left">Stock
                                            Mínimo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-sack"></i></span>
                                            <input type="text" name="RG_STOCK_MINIMO_PRODUCTO"
                                                       id="RG_STOCK_MINIMO_PRODUCTO"
                                                   required="" class="form-control positive-decimal" placeholder="Stock mínimo">
                                        </div>

                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_COSTO_PRODUCTO" class="control-label text-left">Costo</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                            <input required type="text" name="RG_COSTO_PRODUCTO" id="RG_COSTO_PRODUCTO" class="form-control decimal-2-places"
                                                   placeholder="0.00">
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_PRECIO_PRODUCTO" class="control-label text-left">Precio</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                            <input required type="text" name="RG_PRECIO_PRODUCTO" id="RG_PRECIO_PRODUCTO" class="form-control decimal-2-places"
                                                   placeholder="0.00">
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
                                                    <input       name="RG_FECHA_MES_PRODUCTO" id="RG_FECHA_MES_PRODUCTO" class="form-control"
                                                           placeholder="Mes"> 
                                                </div>
                                            </div>  
                                            <div class=" col-md-6"> 
                                                <div class="input-group">
                                                    <span class="input-group-addon "><i class="fa fa-calendar"></i></span>
                                                    <input   name="RG_FECHA_ANNIO_PRODUCTO" id="RG_FECHA_ANNIO_PRODUCTO" class="form-control"
                                                           placeholder="Año"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="with-errors"></div>
                                    </div>
                                </div> 

                                <div class="col-sm-12 col-mdx-3 col-lg-4">
                                    <div class="form-group">
                                        <input type="hidden" id="RG_TIPO_PRODUCTO" name="RG_TIPO_PRODUCTO" value="<?= $ID_TIPO_PRODUCTO ?>">
                                        <label for="RG_TIPO_PRODUCTO" class="control-label text-left"  >Tipo producto</label>
                                        <select disabled=""   class="form-control">
                                            <?php
                                            if (count($ROW_TYPE_PRODUCT) > NULO):
                                                echo '<option value="">Seleccionar</option>';
                                                foreach ($ROW_TYPE_PRODUCT as $ROW):
                                                    $sel = "";
                                                    if ($ROW["ID_TIPO_PRODUCTO"] == $ID_TIPO_PRODUCTO)
                                                        $sel = "selected";
                                                    ?>
                                                    <option <?= $sel ?> value="<?= $ROW['ID_TIPO_PRODUCTO'] ?>"><?= mb_strtoupper($ROW['NOMBRE_TIPO_PRODUCTO']) ?></option>
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
                                    <a href="<?= base_url() ?>inventary/index" class="btn btn-cancel float-left"
                                       id="btnCloseAddPatient">
                                        <i class="fa fa-chevron-double-left" aria-hidden="true"></i> Regresar
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-mdx-6">
                                    <button type="submit" class="btn btn-info float-right">
                                        <i class="fa fa-check" aria-hidden="true"></i> Guardar Producto
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
<div class="modal fade" id="modProduct" tabindex="-1" role="dialog" aria-labelledby="modProduct" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Registrar producto</h4>
            </div>
            <div class="modal-body" id="modBodyProduct">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn btn-primary" type="button" id="btnOkAdvice" data-dismiss="modal">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Entiendo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>