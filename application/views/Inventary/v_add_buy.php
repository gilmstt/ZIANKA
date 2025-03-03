<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12 col-mdx-12 col-lg-9 text-center">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading text-left header-primary">
                    <div class="panel-title text-left"><span class="heading-primary">Nueva compra</span>
                        <button type="button" class="btn btn-header pull-right" id="btnAddItemBuy">
                        <i class="fas fa-cart-plus"></i> Agregar artículo
                        </button>
                    </div>
                </div>
                <div class="panel-body">
                  
                    <div class="control-group text-left">
                        <div class="table-responsive">  
                            <h3 class="h3-fichaConsumo" style="margin-top: 0px;">Articulos Agregados</h3>
                            <table id="" class="table table-bordered table-striped text-center " style="font-size: 14px;" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10%">Acciones</th>
                                        <th width="10%">Nombre</th>
                                        <th width="20%">Descripción</th>
                                        <th width="10%">Cantidad</th>
                                        <th width="10%">Costo</th>
                                        <th width="10%">Monto</th>
                                    </tr>
                                </thead>
                               
                                <tbody id="tbodyDataItems" style="font-size:14px;">
                                    <?php
                                    $SUM=0;
                                    if (count($ROW_DATA_BUY)):
                                        foreach ($ROW_DATA_BUY as $ROW):
                                            $TOTAL = 0.00;
                                            $TOTAL+=floatval($ROW['COSTO_PRODUCTO_ORDEN_TEMP']) * floatval($ROW['CANTIDAD_PRODUCTO_ORDEN_TEMP']);
                                            $SUM=$SUM+$TOTAL;
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="btn-group">
                                                        <button title="Borrar" id="btnDeleteItemCompra" class="btn btn-defaultz btn-del-item-compra"  data-id-item-compra="<?= $ROW['ID_PRODUCTO_ORDEN_TEMP'] ?>"><i class="fa fa-trash fa-1x" aria-hidden="true"></i></button>
                                                    </div>
                                                </td>
                                                <td><?= mb_strtoupper($ROW['NOMBRE_PRODUCTO']) ?></td>
                                                <td><?= mb_strtoupper($ROW['DESCRIPCION_PRODUCTO']) ?></td>
                                                <td><?= $ROW['CANTIDAD_PRODUCTO_ORDEN_TEMP'] ?></td>
                                                <td><?= $ROW['COSTO_PRODUCTO_ORDEN_TEMP'] ?></td>
                                                <td><?= sprintf("%10.2f", $TOTAL) ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-mdx-12 col-lg-3">
            <br>
            <div class="col-sm-12 divbuy">
                <div class="panel-heading header-black">
                    <div class="panel-title text-center">
                        <span class="heading-primary">Detalles de la compra</span>                       
                    </div>
                </div>
                <form data-toggle="validator" role="form" id="formRecordBuy"><br>
                    <div class="col-sm-12 col-mdx-12 col-lg-12">                       
                        <div class="form-group">
                            <label for="RG_FECHA_ORDEN" class="control-label text-left">Fecha</label>
                            <div class='input-group' id='fechaInicio'>
                                <input type="text" name="RG_FECHA_ORDEN" data-type="datepicker" readonly required id="RG_FECHA_ORDEN" class="form-control" value="<?= date('d/m/Y') ?>" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                            <label for="RG_ID_PROVEEDOR" class="control-label text-left"  >Proveedor</label>
                            <select required name="RG_ID_PROVEEDOR" id="RG_ID_PROVEEDOR" class="form-control">
                                <?php
                                if (count($ROW_SUPPLIERS) > NULO):
                                    ?>
                                    <option value="">Selecciona un proveedor</option>
                                    <?php
                                    foreach ($ROW_SUPPLIERS as $ROW):
                                        ?>
                                        <option value="<?= $ROW['ID_PROVEEDOR'] ?>">
                                            <?= $ROW['NOMBRE_PROVEEDOR'] ?>
                                        </option>
                                        <?PHP
                                    endforeach;
                                else:
                                    ?>
                                    <option value="">No existen registros</option>
                                <?php
                                endif;
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                            <label for="RG_comment" class="control-label text-left"  >Comentarios</label>
                            <textarea name="RG_comment" id="RG_comment" class="form-control" placeholder="Comentarios"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                            <label for="RG_total" class="control-label text-left"  >Total</label>
                            <input type="text" readonly required name="RG_total" id="RG_total" class="form-control" placeholder="$0.00" value="<?= sprintf("%10.2f", $SUM) ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                            <label for="RG_ID_TIPOPAGO" class="control-label text-left"  >Tipo de pago</label>
                            <select name="RG_ID_TIPOPAGO" id="RG_ID_TIPOPAGO" class="form-control">
                                <?PHP
                                if (count($ROW_PAYMENT_TYPE) > NULO):
                                    foreach ($ROW_PAYMENT_TYPE as $ROW):
                                        ?>
                                        <option value="<?= $ROW['ID_TIPOPAGO'] ?>">
                                            <?= $ROW['NOMBRE_TIPOPAGO'] ?>
                                        </option>
                                        <?PHP
                                    endforeach;
                                else:
                                    ?>
                                    <option value="-1">No existen registros</option>
                                <?php
                                endif;
                                ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div> 
                    <div class="col-sm-6 col-mdx-6 col-lg-6">
                        <button type="button" name="cancelAddCompra" id="cancelAddCompra" class="btn btn-danger">
                            <i class="fa fa-times" aria-hidden="true"></i>  Cancelar
                        </button>
                    </div>
                    <div class="col-sm-6 col-mdx-6 col-lg-6">                       
                        <button type="submit" name="OkAddBuy" id="OkAddBuy" class="btn btn-info float-right">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>  Guardar
                        </button>                     
                    </div>             
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL ELIMINAR ITEM BUY -->
<div class="modal fade" id="modDelItemBuy" tabindex="-1" role="dialog" aria-labelledby="modDelItemBuy" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Borrar artículo</h4>
            </div>
            <div class="modal-body text-center" id="modBodyDelItemBuy">
            </div>
            <div class="clear"></div>
            <div class="modal-footer">
                <div class="btn-group ">
                    <button class="btn" type="button"  id="btnCancel"  data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i> Cancelar
                    </button>
                    <button class="btn btn-primary" type="button"  id="btnDelRowItemBuy">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Si, borrar
                    </button>
                </div>       
            </div>
        </div>
    </div>
</div>
<!-- MODAL GUARDAR BUY -->
<div class="modal fade" id="modAddedBuy" tabindex="-1" role="dialog" aria-labelledby="modAddedBuy" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Guardar compra</h4>
            </div>
            <div class="modal-body text-center" id="modBodyAddedBuy">

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

<!--MODAL AGREGAR PRODUCTO COMPRA-->
<div class="modal fade" id="modAddItemCompra" tabindex="-1" role="dialog" aria-labelledby="modAddItemCompra" aria-hidden="true">
    <form data-toggle="validator" role="form" id="formRecordAddCompra">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-headx">
                    <div class="panel-title text-left">
                        <span class="modal-title" id="myModalLabel"><i class="fas fa-cart-plus"></i> Agregar artículo a la compra</span>
                        <button type="button" class="close" data-dismiss="modal" style="color:#FFF;" aria-label="Close"><span style="color:#FFF;" aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body text-left" id="modBodyAddItemOrder">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="CODIGO_PRODUCTO" class="control-label text-left"  >Código</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>   
                                    <input type="text" name="CODIGO_PRODUCTO" id="CODIGO_PRODUCTO" autofocus class="form-control" placeholder="Código">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <input type="hidden" id="RG_ID_PRODUCTO_O" name="RG_ID_PRODUCTO_O">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="RG_SEARCH_PRODUCTO" class="control-label text-left"  >Artículo</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                    <input type="text" id="RG_SEARCH_PRODUCTO" autocomplete="off" class="form-control" placeholder="Escribe la descripción"  >
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="suggestionsProd" class="divSuggestionProd"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="RG_CANTIDAD_PRODUCTO_ORDEN_TEMP" class="control-label text-left"  >Cantidad</label>

                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-sack"></i></span>
                                    <input type="text" name="RG_CANTIDAD_PRODUCTO_ORDEN_TEMP" required id="RG_CANTIDAD_PRODUCTO_ORDEN_TEMP" class="form-control integer" placeholder="Cantidad">
                                </div>

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="RG_CANTIDAD_PRODUCTO_ACTUAL_TEMP" class="control-label text-left"  >Cantidad Actual</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-sack"></i></span>
                                    <input type="text" name="RG_CANTIDAD_PRODUCTO_ACTUAL_TEMP" required id="RG_CANTIDAD_PRODUCTO_ACTUAL_TEMP" class="form-control integer" placeholder="Cantidad Actual">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="RG_COSTO_PRODUCTO_ORDEN_TEMP" class="control-label text-left"  >Costo</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                    <input type="text" name="RG_COSTO_PRODUCTO_ORDEN_TEMP" required id="RG_COSTO_PRODUCTO_ORDEN_TEMP" class="form-control decimal-2-places" placeholder="Costo">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="RG_PRECIO_PRODUCTO_ORDEN_TEMP" class="control-label text-left">Precio</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-dollar-sign"></i></span>
                                    <input type="text" name="RG_PRECIO_PRODUCTO_ORDEN_TEMP" required id="RG_PRECIO_PRODUCTO_ORDEN_TEMP" class="form-control decimal-2-places" placeholder="Precio">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="modal-footer">                   
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-mdx-6">
                            <button type="button" class="btn btn-cancel float-left" data-dismiss="modal">
                                <i class="fa fa-chevron-double-left" aria-hidden="true"></i> Cerrar
                            </button>
                        </div>                    
                        <div class="col-lg-6 col-sm-6 col-mdx-6">                                       
                            <button type="submit" class="btn btn-info float-right" id="okAddProductOrder">
                                <i class="fa fa-check" aria-hidden="true"></i> Agregar producto
                            </button>                                                                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modAddedItemOrder" tabindex="-1" role="dialog" aria-labelledby="modAddedItemOrder" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-primary" id="modalHeaderAdvice"  >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Agregar artículo a la compra</h4>
            </div>
            <div class="modal-body text-center" id="modBodyAddedItemOrder">

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
