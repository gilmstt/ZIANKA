<script>
    // Funcion para generar la tabla con la informacion de la sesion
    function crearTabla() {
        $.ajax({
            url: raiz_url + "Receta/ajax_obtener_indicaciones",
            type: 'POST',
            data: $(this).serialize(),
            success: function (data) {

                var recetas = JSON.parse(data);
                var nuevaIndicacion = ""

                for (let i = 0; i < recetas.length; i++) {
                    nuevaIndicacion += "<tr><td> <a data-indicacion='" + recetas[i]["id"] + "' id='borrar-receta'> <i class='fas fa-trash-alt'</a> </td>"
                        + "<td>" + recetas[i]["nombre"] + "</td>"
                        + "<td>" + recetas[i]["comercial"] + "</td>"
                        + "<td>" + recetas[i]["formula"] + "</td>"
                        + "<td>" + recetas[i]["indicacion"] + "</td></tr>";
                }
                $("#tbodyIndicacion").html(nuevaIndicacion);
            }
        });
    }
    crearTabla();
</script>

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12 col-mdx-12 col-lg-12 text-center">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading text-left header-primary">
                    <div class="panel-title text-left"><span class="heading-primary">Nueva Receta</span>
                        <button type="button" class="btn btn-header pull-right" id="btnAddItemBuy">
                        <i class="fas fa-cart-plus"></i> Agregar Indicación
                        </button>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="ID_RECETA" id="ID_RECETA">
                    <div class="control-group text-left">
                        <div class="table-responsive">  
                            <h3 class="h3-fichaConsumo" style="margin-top: 0px;">Indicaciones Agregadas</h3>
                            <table id="" class="table table-bordered table-striped text-center " style="font-size: 14px;" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="2%"><i class="fas fa-cogs"></i></th>
                                        <th width="10%">Nombre</th>
                                        <th width="10%">Nombre Comercial</th>
                                        <th width="10%">Fórmula</th>
                                        <th width="20%">Indicación</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyIndicacion" style="font-size:14px;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a href="<?php echo base_url() . $URL ?>" class="btn btn-cancel pull-left">
                        <i class="fas fa-chevron-double-left"></i> Regresar
                    </a>
                    <button name="OkAddBuy" style="display:none" id="addReceta" class="btn btn-info float-right">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>  Guardar Receta
                    </button>
                    <button id="PrintReceta" style="display:none" class="btn btn-success float-right">
                        <i class="fa fa-print" aria-hidden="true"></i>  Imprimir Receta
                    </button>
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
    <form data-toggle="validator" role="form" id="formAddReceta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-headx">
                    <div class="panel-title text-left">
                        <span class="modal-title" id="myModalLabel"><i class="fas fa-cart-plus"></i>  Nueva Indicación</span>
                        <button type="button" class="close" data-dismiss="modal" style="color:#FFF;" aria-label="Close"><span style="color:#FFF;" aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body text-left" id="modBodyAddItemOrder">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NOMBRE_MEDICAMENTO" class="control-label text-left"  >Nombre del medicamento</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                    <input type="text" name="NOMBRE_MEDICAMENTO" id="NOMBRE_MEDICAMENTO" autocomplete="on" class="form-control">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="suggestionsProd" class="divSuggestionProd"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="NOMBRE_COMERCIAL" class="control-label text-left"  >Nombre comercial del medicamento</label>
                                <div class="input-group">      
                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>   
                                    <input autocomplete="on" type="text" name="NOMBRE_COMERCIAL" id="NOMBRE_COMERCIAL" autofocus class="form-control">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <input type="hidden" id="ID_MEDICAMENTO" name="ID_MEDICAMENTO">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="FORMULA" class="control-label text-left"  >Formula</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                    <input type="text" name="FORMULA" id="FORMULA" autocomplete="on" class="form-control" >
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="suggestionsProd" class="divSuggestionProd"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="INDICACION" class="control-label text-left"  >Indicación</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                    <input type="text" name="INDICACION" id="INDICACION" autocomplete="on" class="form-control"  >
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="suggestionsProd" class="divSuggestionProd"></div>
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
                            <button type="submit" class="btn btn-info float-right" id="addReceta">
                                <i class="fa fa-check" aria-hidden="true"></i> Aceptar
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
