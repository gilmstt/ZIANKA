<!-- Barra de navegacion -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 "><br>
            <?php $this->view('Reportes/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9"><br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-file-invoice"></i>
                            Recetas</span>
                    </div>
                </div>
                <div class="panel-body">
                
                <form id="FORM_RECETA">
                    <div id="parent">
                        <div class="row roww">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label >Medicamento</label>
                                    <input type="text" class="form-control" id=NOMBRE_MEDICAMENTO name="NOMBRE_MEDICAMENTO[]" placeholder="Nombre del medicamento">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label >Fórmula</label>
                                    <input type="text" class="form-control" id=FORMULA name="FORMULA[]" placeholder="Formula">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label >Nombre comercial</label>
                                    <input type="text" class="form-control" id="NOMBRE_COMERCIAL" name="NOMBRE_COMERCIAL[]" placeholder="Nombre comercial">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label >Indicación</label>
                                    <textarea class="form-control" id="INDICACION" name="INDICACION[]"  rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        <button class="btn btn-info" id="addReceta">Añadir otro</button>
                    <button type="submit" class="btn btn-info">Guardar</button>
                </form>
                </div>               
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){

    $("#addReceta").click(function(e){

        e.preventDefault();
        $('#parent').append($('.roww').html());
    })

})

</script>