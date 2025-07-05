<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9">
            <br>
            <form data-toggle="validator" role="form" id="formEditTreatment">
                <input type="hidden" value="<?= $ROW_DATA_TREATMENT->id_tipo_consulta ?>" name="RG_ID_TREATMENT"
                    id="RG_ID_TREATMENT">
                    <pre>ID ACTUAL: <?= var_dump($ROW_DATA_TREATMENT->id_tipo_consulta) ?></pre>
                <div class="control-group text-left">
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-tasks"></i> Editar Tratamiento </span></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_TRATAMIENTO" class="control-label text-left">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-money-check-edit"></i></span>
                                            <input type="text" name="RG_NOMBRE_TRATAMIENTO" id="RG_NOMBRE_TRATAMIENTO"
                                                value="<?= $ROW_DATA_TREATMENT->nombre_tipo_consulta ?>" class="form-control" required placeholder="Nombre ">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="RG_PROCEDIMIENTO" class="control-label text-left">Tipo(s) de procedimientos</label>
                                        <select class="form-control selectpicker" name="RG_PROCEDIMIENTO[]" id="RG_PROCEDIMIENTO" multiple required data-live-search="true" title="Seleccione uno o varios procedimientos">
                                            <?php if (!empty($DATA_TIPOS_PROCEDIMIENTO)): ?>
                                                <?php
                                                $procedimientosSeleccionados = [];
                                                if (!empty($ROW_DATA_TREATMENT->id_tipo_consulta)) {
                                                    $procedimientosSeleccionados = $this->minventary->get_procedimientos_by_tipo_consulta($ROW_DATA_TREATMENT->id_tipo_consulta);
                                                }

                                                $idsSeleccionados = array_column($procedimientosSeleccionados, 'id_procedimiento');

                                                foreach ($DATA_TIPOS_PROCEDIMIENTO as $tipo):
                                                    $sel = in_array($tipo['id_procedimiento'], $idsSeleccionados) ? "selected" : "";
                                                ?>
                                                    <option <?= $sel ?> value="<?= $tipo['id_procedimiento'] ?>">
                                                        <?= $tipo['descripcion_procedimiento'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="-1">No hay registros</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-mdx-6">
                                    <a href="<?= base_url() ?>inventary/index_tipos_consultas" class="btn btn-cancel float-left" id="">
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
            <div class="modal-header header-primary" id="modalHeaderAdvice">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitleAdvice">Registrar procedimiento</h4>
            </div>
            <div class="modal-body" id="modBodyProcedure">
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