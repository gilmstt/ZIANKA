<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 text-center">
            <br>
            <form data-toggle="validator" role="form" id="formEditPatient">
                <input type="hidden" value="<?= $ROW_DATA_PATIENT->ID_PACIENTE ?>" name="RG_ID_PATIENT"
                    id="RG_ID_PATIENT">
                <div class="control-group text-left">
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i
                                        class="fas fa-user-edit"></i>
                                    Editar Paciente</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_PATIENT" class="control-label text-left">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_NOMBRE_PATIENT" id="RG_NOMBRE_PATIENT"
                                                class="form-control" required placeholder="Nombre del paciente"
                                                value="<?= $ROW_DATA_PATIENT->NOMBRE_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_PATERNO_PATIENT"
                                            class="control-label text-left">Apellido paterno</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_PATERNO_PATIENT"
                                                id="RG_APELLIDO_PATERNO_PATIENT" class="form-control" required
                                                placeholder="Apellido paterno paciente"
                                                value="<?= $ROW_DATA_PATIENT->APELLIDO_PATERNO_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_MATERNO_PATIENT"
                                            class="control-label text-left">Apellido materno</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_MATERNO_PATIENT"
                                                id="RG_APELLIDO_MATERNO_PATIENT" class="form-control"
                                                placeholder="Apellido materno paciente"
                                                value="<?= $ROW_DATA_PATIENT->APELLIDO_MATERNO_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ID_SEXOP" class="control-label text-left">Sexo</label>
                                        <div class='input-group'>
                                            <span class="input-group-addon"><i class="fas fa-venus-mars"></i></span>
                                            <select name="RG_ID_SEXOP" id="RG_ID_SEXOP" class="form-control">
                                                <?php
                                                if (count($ROW_SEX) > NULO):
                                                    foreach ($ROW_SEX as $ROW):
                                                        $sel = "";
                                                        if ($ROW['ID_SEXO'] == $ROW_DATA_PATIENT->ID_SEXO)
                                                            $sel = "selected";
                                                        ?>

                                                <option <?= $sel ?> value="<?= $ROW['ID_SEXO'] ?>">
                                                    <?= mb_strtoupper($ROW['NOMBRE_SEXO']) ?></option>
                                                <?php
                                                    endforeach;
                                                else:
                                                    ?>
                                                <option value="-1">No hay registros</option>
                                                <?php
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_FECHA_NAC_PTIENT" class="control-label text-left">Fecha
                                            nacimiento</label>
                                        <div class='input-group'>
                                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                            <input type='text' data-type="datepicker" class="form-control"
                                                id="RG_FECHA_NAC_PTIENT" required name="RG_FECHA_NAC_PTIENT"
                                                value="<?= convierte_fecha_db_to_show($ROW_DATA_PATIENT->FECHA_NAC_PACIENTE) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ESTADO_CIVIL_PACIENTE" class="control-label text-left">Estado
                                            Civil</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input type="text" name="RG_ESTADO_CIVIL_PACIENTE"
                                                id="RG_ESTADO_CIVIL_PACIENTE" class="form-control"
                                                placeholder="Estado civil"
                                                value="<?= $ROW_DATA_PATIENT->ESTADO_CIVIL_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_RELIGION_PACIENTE"
                                            class="control-label text-left">Religión</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-mosque"></i></span>
                                            <input type="text" name="RG_RELIGION_PACIENTE" id="RG_RELIGION_PACIENTE"
                                                class="form-control" placeholder="Religión"
                                                value="<?= $ROW_DATA_PATIENT->RELIGION_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_OCUPACION_PACIENTE"
                                            class="control-label text-left">Ocupación</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user-hard-hat"></i></span>
                                            <input type="text" name="RG_OCUPACION_PACIENTE" id="RG_OCUPACION_PACIENTE"
                                                class="form-control" placeholder="Ocupación"
                                                value="<?= $ROW_DATA_PATIENT->OCUPACION_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_CALLE_PACIENTE" class="control-label text-left">Calle</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fad fa-road"></i></span>
                                            <input type="text" name="RG_CALLE_PACIENTE" id="RG_CALLE_PACIENTE"
                                                class="form-control" placeholder="Calle domicilio paciente"
                                                value="<?= $ROW_DATA_PATIENT->CALLE_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NUMERO_PACIENTE" class="control-label text-left">Número</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">#</span>
                                            <input type="text" name="RG_NUMERO_PACIENTE" id="RG_NUMERO_PACIENTE"
                                                class="form-control" placeholder="Número domicilio paciente"
                                                value="<?= $ROW_DATA_PATIENT->NUMERO_PACIENTE?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-8 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_COLONIA_PACIENTE" class="control-label text-left">Colonia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fad fa-street-view"></i></span>
                                            <input type="text" name="RG_COLONIA_PACIENTE" id="RG_COLONIA_PACIENTE"
                                                class="form-control" placeholder="Colonia domicilio paciente"
                                                value="<?= $ROW_DATA_PATIENT->COLONIA_PACIENTE?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_EMAIL_PACIENTE" class="control-label text-left">Correo
                                            electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                            <input type="email" name="RG_EMAIL_PACIENTE" id="RG_EMAIL_PACIENTE"
                                                class="form-control" placeholder="Correo electrónico"
                                                value="<?= $ROW_DATA_PATIENT->EMAIL_PACIENTE?>">
                                        </div>
                                        <div class=" help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_PACIENTE" class="control-label text-left">No.
                                            Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_PACIENTE" id="RG_TELEFONO_PACIENTE"
                                                value="<?= $ROW_DATA_PATIENT->TELEFONO_PACIENTE ?>" class="form-control"
                                                placeholder="No. teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_URGENCIA" class="control-label text-left">Contacto de
                                            eMERGENCIA</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_URGENCIA" id="RG_TELEFONO_URGENCIA"
                                                value="<?= $ROW_DATA_PATIENT->TELEFONO_URGENCIA ?>" class="form-control"
                                                placeholder="No. teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ID_TIPO_SANGRE" class="control-label text-left">TIPO DE
                                            SANGRE</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-tint"></i></span>
                                            <select class="form-control" required id="RG_ID_TIPO_SANGRE"
                                                name="RG_ID_TIPO_SANGRE">
                                                <?php
                                                $CI = &get_instance();
                                                $Tipo_sangre = $this->db->get('sangre')->result_array();
                                                if (count($Tipo_sangre) > NULO):
                                                    foreach ($Tipo_sangre as $ROW):
                                                        $_sel = ($ROW['id_sangre'] == $id_sangre) ? "selected" : "";
                                                ?>
                                                <option value="<?= $ROW['id_sangre'] ?>">
                                                    <?= mb_strtoupper($ROW['tipo_sangre']) ?>
                                                </option>
                                                <?php
                                                    endforeach;
                                                else:
                                                    ?>
                                                <option value="-1">No hay registros</option>
                                                <?php
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes">ANTECEDENTES HEREDOFAMILIARES</h4>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class="form-group">
                                    <label class="control-label text-left">MADRE</label>
                                </div>
                                <div class="form-check">
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="DIABETES_MADRE"
                                            id="DIABETES_MADRE"
                                            <?= $ROW_DATA_PATIENT->DIABETES_MADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIABETES_MADRE">
                                            DIABETES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="HIPERTENSION_MADRE"
                                            id="HIPERTENSION_MADRE"
                                            <?= $ROW_DATA_PATIENT->HIPERTENSION_MADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HIPERTENSION_MADRE">
                                            HIPERTENSIÓN
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_MADRE"
                                            id="ENF_AUTOINMUNES_MADRE"
                                            <?= $ROW_DATA_PATIENT->ENF_AUTOINMUNES_MADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENF_AUTOINMUNES_MADRE">
                                            ENF. AUTOINMUNES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="CANCER_MADRE"
                                            id="CANCER_MADRE" <?= $ROW_DATA_PATIENT->CANCER_MADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CANCER_MADRE">
                                            CÁNCER
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="form-group">
                                    <label class="control-label text-left">PADRE</label>
                                </div>
                                <div class="form-check">
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="DIABETES_PADRE"
                                            id="DIABETES_PADRE"
                                            <?= $ROW_DATA_PATIENT->DIABETES_PADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIABETES_PADRE">
                                            DIABETES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="HIPERTENSION_PADRE"
                                            id="HIPERTENSION_PADRE"
                                            <?= $ROW_DATA_PATIENT->HIPERTENSION_PADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HIPERTENSION_PADRE">
                                            HIPERTENSIÓN
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_PADRE"
                                            id="ENF_AUTOINMUNES_PADRE"
                                            <?= $ROW_DATA_PATIENT->ENF_AUTOINMUNES_PADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENF_AUTOINMUNES_PADRE">
                                            ENF. AUTOINMUNES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="CANCER_PADRE"
                                            id="CANCER_PADRE" <?= $ROW_DATA_PATIENT->CANCER_PADRE ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CANCER_PADRE">
                                            CÁNCER
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="form-group">
                                    <label class="control-label text-left">HERMANOS</label>
                                </div>
                                <div class="form-check">
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="DIABETES_HERMANOS"
                                            id="DIABETES_HERMANOS"
                                            <?= $ROW_DATA_PATIENT->DIABETES_HERMANOS ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIABETES_HERMANOS">
                                            DIABETES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3 text-left">
                                        <input class="form-check-input" type="checkbox" name="HIPERTENSION_HERMANOS"
                                            id="HIPERTENSION_HERMANOS"
                                            <?= $ROW_DATA_PATIENT->HIPERTENSION_HERMANOS ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HIPERTENSION_HERMANOS">
                                            HIPERTENSIÓN
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_HERMANOS"
                                            id="ENF_AUTOINMUNES_HERMANOS"
                                            <?= $ROW_DATA_PATIENT->ENF_AUTOINMUNES_HERMANOS ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENF_AUTOINMUNES_HERMANOS">
                                            ENF. AUTOINMUNES
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <input class="form-check-input" type="checkbox" name="CANCER_HERMANOS"
                                            id="CANCER_HERMANOS"
                                            <?= $ROW_DATA_PATIENT->CANCER_HERMANOS ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CANCER_HERMANOS">
                                            CÁNCER
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class="form-group">
                                    <label class="control-label text-left">Otros</label>
                                    <textarea class="form-control" name="OTROS_HEREDOFAMILIARES" rows="5"
                                        placeholder="Escribe aquí.."><?= $ROW_DATA_PATIENT->OTROS_HEREDOFAMILIARES ?></textarea>
                                </div>
                            </div>



                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes">ANTECEDENTES PERSONALES PATOLÓGIVOS Y NO PATOLÓGICOS</h4>

                            </div>
                            <div class="cointainer">
                                <div class="col-sm-6 col-md-6"></div>
                                <label class="col-sm-12 col-md-6 offset-sm-12 text-end">
                                    TIEMPO DE EVOLUCIÓN / TRATAMIENTO
                                </label>
                            </div>

                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="DIABETES_MELLITUS">Diabetes Mellitus</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DIABETES_MELLITUS"
                                            id="DIABETES_MELLITUS" value="1"
                                            <?= ($ROW_DATA_PATIENT->DIABETES_MELLITUS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIABETES_MELLITUS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DIABETES_MELLITUS"
                                            id="DIABETES_MELLITUS_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->DIABETES_MELLITUS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIABETES_MELLITUS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_DIABETES"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_DIABETES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Hipertensión Arterial -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="HIPERTENSION_ARTERIAL">Hipertensión
                                            Arterial</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HIPERTENSION_ARTERIAL"
                                            id="HIPERTENSION_ARTERIAL" value="1"
                                            <?= ($ROW_DATA_PATIENT->HIPERTENSION_ARTERIAL == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HIPERTENSION_ARTERIAL">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HIPERTENSION_ARTERIAL"
                                            id="HIPERTENSION_ARTERIAL_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->HIPERTENSION_ARTERIAL == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HIPERTENSION_ARTERIAL_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_HIPERTENSION"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_HIPERTENSION) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Enfermedades Endocrinológicas -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ENFERMEDADES_ENDOCRINOLOGICAS">Enfermedades
                                            Endocrinológicas</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio"
                                            name="ENFERMEDADES_ENDOCRINOLOGICAS" id="ENFERMEDADES_ENDOCRINOLOGICAS"
                                            value="1"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_ENDOCRINOLOGICAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label"
                                            for="ENFERMEDADES_ENDOCRINOLOGICAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio"
                                            name="ENFERMEDADES_ENDOCRINOLOGICAS" id="ENFERMEDADES_ENDOCRINOLOGICAS_NO"
                                            value="0"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_ENDOCRINOLOGICAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label"
                                            for="ENFERMEDADES_ENDOCRINOLOGICAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control"
                                            name="TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Enfermedades Psiquiátricas -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ENFERMEDADES_PSIQUIATRICAS">Enfermedades
                                            Psiquiátricas</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ENFERMEDADES_PSIQUIATRICAS"
                                            id="ENFERMEDADES_PSIQUIATRICAS" value="1"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_PSIQUIATRICAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENFERMEDADES_PSIQUIATRICAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ENFERMEDADES_PSIQUIATRICAS"
                                            id="ENFERMEDADES_PSIQUIATRICAS_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_PSIQUIATRICAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENFERMEDADES_PSIQUIATRICAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control"
                                            name="TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Enfermedades Autoinmunes -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ENFERMEDADES_AUTOINMUNES">Enfermedades
                                            Autoinmunes</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ENFERMEDADES_AUTOINMUNES"
                                            id="ENFERMEDADES_AUTOINMUNES" value="1"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_AUTOINMUNES == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENFERMEDADES_AUTOINMUNES">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ENFERMEDADES_AUTOINMUNES"
                                            id="ENFERMEDADES_AUTOINMUNES_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->ENFERMEDADES_AUTOINMUNES == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ENFERMEDADES_AUTOINMUNES_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- VIH -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="VIH">Virus Inmunodeficiencia Humana
                                            (VIH)</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="VIH" id="VIH" value="1"
                                            <?= ($ROW_DATA_PATIENT->VIH == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="VIH">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="VIH" id="VIH_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->VIH == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="VIH_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_VIH"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_VIH) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Herpes Labial -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="HERPES_LABIAL">Herpes Labial (Fuegos) / Herpes
                                            Zoster</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HERPES_LABIAL"
                                            id="HERPES_LABIAL" value="1"
                                            <?= ($ROW_DATA_PATIENT->HERPES_LABIAL == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HERPES_LABIAL">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HERPES_LABIAL"
                                            id="HERPES_LABIAL_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->HERPES_LABIAL == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HERPES_LABIAL_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_HERPES_LABIAL"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_HERPES_LABIAL) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Transfusiones Sanguíneas -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="TRANSFUSIONES_SANGUINEAS">Transfusiones
                                            Sanguíneas</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="TRANSFUSIONES_SANGUINEAS"
                                            id="TRANSFUSIONES_SANGUINEAS" value="1"
                                            <?= ($ROW_DATA_PATIENT->TRANSFUSIONES_SANGUINEAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="TRANSFUSIONES_SANGUINEAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="TRANSFUSIONES_SANGUINEAS"
                                            id="TRANSFUSIONES_SANGUINEAS_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->TRANSFUSIONES_SANGUINEAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="TRANSFUSIONES_SANGUINEAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Traumatismos / Fracturas -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="FRACTURAS">Traumatismos / Fracturas</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FRACTURAS" id="FRACTURAS"
                                            value="1" <?= ($ROW_DATA_PATIENT->FRACTURAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FRACTURAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FRACTURAS" id="FRACTURAS_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->FRACTURAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FRACTURAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_FRACTURAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_FRACTURAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Hospitalizaciones -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="HOSPITALIZACIONES">Hospitalizaciones</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HOSPITALIZACIONES"
                                            id="HOSPITALIZACIONES" value="1"
                                            <?= ($ROW_DATA_PATIENT->HOSPITALIZACIONES == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HOSPITALIZACIONES">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HOSPITALIZACIONES"
                                            id="HOSPITALIZACIONES_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->HOSPITALIZACIONES == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HOSPITALIZACIONES_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_HOSPITALIZACIONES"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_HOSPITALIZACIONES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Cirugías Previas -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="CIRUGIAS_PREVIAS">Cirugías Previas</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="CIRUGIAS_PREVIAS"
                                            id="CIRUGIAS_PREVIAS" value="1"
                                            <?= ($ROW_DATA_PATIENT->CIRUGIAS_PREVIAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CIRUGIAS_PREVIAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="CIRUGIAS_PREVIAS"
                                            id="CIRUGIAS_PREVIAS_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->CIRUGIAS_PREVIAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CIRUGIAS_PREVIAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Hepatitis -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="HEPATITIS">Hepatitis</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HEPATITIS" id="HEPATITIS"
                                            value="1" <?= ($ROW_DATA_PATIENT->HEPATITIS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HEPATITIS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="HEPATITIS" id="HEPATITIS_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->HEPATITIS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="HEPATITIS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_HEPATITIS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_HEPATITIS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Cáncer -->
                            <div class="form Nenhum-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="CANCER">Cáncer</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="CANCER" id="CANCER"
                                            value="1" <?= ($ROW_DATA_PATIENT->CANCER == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CANCER">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="CANCER" id="CANCER_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->CANCER == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="CANCER_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_CANCER"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_CANCER) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Epilepsia -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="EPILEPSIA">Epilepsia</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="EPILEPSIA" id="EPILEPSIA"
                                            value="1" <?= ($ROW_DATA_PATIENT->EPILEPSIA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="EPILEPSIA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="EPILEPSIA" id="EPILEPSIA_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->EPILEPSIA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="EPILEPSIA_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_EPILEPSIA"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_EPILEPSIA) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Alergias -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ALERGIAS">Alergias</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ALERGIAS" id="ALERGIAS"
                                            value="1" <?= ($ROW_DATA_PATIENT->ALERGIAS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ALERGIAS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ALERGIAS" id="ALERGIAS_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->ALERGIAS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ALERGIAS_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <textarea class="form-control" name="TIEMPO_EVOLUCION_ALERGIAS"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->TIEMPO_EVOLUCION_ALERGIAS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Otros -->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="control-label text-left">OTROS</label>
                                    <textarea class="form-control" name="OTROS_PATOLOGICO" placeholder="Escribe aquí.."
                                        rows="5"><?= htmlspecialchars($ROW_DATA_PATIENT->OTROS_PATOLOGICO) ?></textarea>
                                </div>
                            </div>
                            <br>

                            <!-- Fuma -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="FUMA">¿FUMA?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FUMA" id="FUMA" value="1"
                                            <?= ($ROW_DATA_PATIENT->FUMA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FUMA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FUMA" id="FUMA_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->FUMA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FUMA_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">CUANTOS POR DÍA?</label>
                                        <textarea class="form-control" name="FUMA_CUANTOS" placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->FUMA_CUANTOS) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Adicciones -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ADICCIONES">¿ADICCIONES?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ADICCIONES"
                                            id="ADICCIONES" value="1"
                                            <?= ($ROW_DATA_PATIENT->ADICCIONES == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ADICCIONES">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ADICCIONES"
                                            id="ADICCIONES_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->ADICCIONES == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ADICCIONES_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">ESPECIFIQUE:</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_ADICCIONES"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_ADICCIONES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Bebe Alcohol -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="BEBE_ALCOHOL">¿BEBE ALCOHOL?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="BEBE_ALCOHOL"
                                            id="BEBE_ALCOHOL" value="1"
                                            <?= ($ROW_DATA_PATIENT->BEBE_ALCOHOL == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="BEBE_ALCOHOL">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="BEBE_ALCOHOL"
                                            id="BEBE_ALCOHOL_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->BEBE_ALCOHOL == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="BEBE_ALCOHOL_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">ESPECIFIQUE:</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_ALCOHOL"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_ALCOHOL) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Fobia -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="FOBIA">¿FOBIA A LA SANGRE O AGUJAS?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FOBIA" id="FOBIA"
                                            value="1" <?= ($ROW_DATA_PATIENT->FOBIA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FOBIA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="FOBIA" id="FOBIA_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->FOBIA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="FOBIA_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Desmayos -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="DESMAYOS">¿ES PROPENSO A LOS DESMAYOS?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DESMAYOS" id="DESMAYOS"
                                            value="1" <?= ($ROW_DATA_PATIENT->DESMAYOS == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DESMAYOS">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DESMAYOS" id="DESMAYOS_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->DESMAYOS == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DESMAYOS_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Aspirina -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="ASPIRINA">¿TOMA ASPIRINA, WARFARINA O
                                            ANTICOAGULANTES?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ASPIRINA" id="ASPIRINA"
                                            value="1" <?= ($ROW_DATA_PATIENT->ASPIRINA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ASPIRINA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ASPIRINA" id="ASPIRINA_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->ASPIRINA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ASPIRINA_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Moretes -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="MORETES">¿ES PROPENSO A SUFRIR
                                            MORETES?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="MORETES" id="MORETES"
                                            value="1" <?= ($ROW_DATA_PATIENT->MORETES == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="MORETES">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="MORETES" id="MORETES_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->MORETES == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="MORETES_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Bronceado -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="BRONCEADO">¿HA USADO CAMA DE BRONCEADO EN LOS
                                            ÚLTIMOS 3 MESES?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="BRONCEADO" id="BRONCEADO"
                                            value="1" <?= ($ROW_DATA_PATIENT->BRONCEADO == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="BRONCEADO">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="BRONCEADO" id="BRONCEADO_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->BRONCEADO == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="BRONCEADO_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Anestesia -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <label class="control-label" for="ANESTESIA">¿ALGUNA VEZ LE HAN ADMINISTRADO
                                            INYECCIONES DE ANESTESIA LOCAL (INCLUIDAS EN EL DENTISTA)?</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="ANESTESIA" id="ANESTESIA"
                                            value="1" <?= ($ROW_DATA_PATIENT->ANESTESIA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ANESTESIA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ANESTESIA" id="ANESTESIA_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->ANESTESIA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ANESTESIA_NO">NO</label>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Problema Anestesia -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <label class="control-label" for="PROBLEMA_ANESTESIA">¿HA SUFRIDO ALGÚN PROBLEMA
                                            CON LA ANESTESIA?</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="PROBLEMA_ANESTESIA"
                                            id="PROBLEMA_ANESTESIA" value="1"
                                            <?= ($ROW_DATA_PATIENT->PROBLEMA_ANESTESIA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="PROBLEMA_ANESTESIA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="PROBLEMA_ANESTESIA"
                                            id="PROBLEMA_ANESTESIA_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->PROBLEMA_ANESTESIA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="PROBLEMA_ANESTESIA_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">ESPECIFIQUE:</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_PROBLEMA_ANESTESIA"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_PROBLEMA_ANESTESIA) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Inmunización -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <label class="control-label" for="INMUNIZACION">¿HA RECIBIDO ALGUNA INMUNIZACIÓN
                                            (VACUNA) EN LOS ÚLTIMOS 3 MESES?</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="INMUNIZACION"
                                            id="INMUNIZACION" value="1"
                                            <?= ($ROW_DATA_PATIENT->INMUNIZACION == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="INMUNIZACION">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="INMUNIZACION"
                                            id="INMUNIZACION_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->INMUNIZACION == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="INMUNIZACION_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">¿CUÁL?</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_INMUNIZACION"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_INMUNIZACION) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Infección Piel -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <label class="control-label" for="INFECCION_PIEL">¿TIENE O HA TENIDO EN LOS
                                            ÚLTIMOS 3 MESES ALGUNA INFECCIÓN EN LA PIEL?</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="INFECCION_PIEL"
                                            id="INFECCION_PIEL" value="1"
                                            <?= ($ROW_DATA_PATIENT->INFECCION_PIEL == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="INFECCION_PIEL">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="INFECCION_PIEL"
                                            id="INFECCION_PIEL_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->INFECCION_PIEL == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="INFECCION_PIEL_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">¿CUÁL?</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_INFECCION_PIEL"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_INFECCION_PIEL) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Esteroides -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        <label class="control-label" for="ESTEROIDES">¿ESTÁ RECIBIENDO O HA RECIBIDO EN
                                            LOS ÚLTIMOS 3 MESES ALGÚN TRATAMIENTO MÉDICO CON ESTEROIDES O CUALQUIER OTRO
                                            MEDICAMENTO DE VENTA LIBRE AUTO INDICADO (ANALGÉSICOS, ANTIINFLAMATORIOS,
                                            ANTIÁCIDOS)?</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="ESTEROIDES"
                                            id="ESTEROIDES" value="1"
                                            <?= ($ROW_DATA_PATIENT->ESTEROIDES == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ESTEROIDES">SÍ</label>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                        <input class="form-check-input" type="radio" name="ESTEROIDES"
                                            id="ESTEROIDES_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->ESTEROIDES == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ESTEROIDES_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">¿CUÁL?</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_ESTEROIDES"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_ESTEROIDES) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Ejercicio -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="EJERCICIO">¿HACE EJERCICIO?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="EJERCICIO" id="EJERCICIO"
                                            value="1" <?= ($ROW_DATA_PATIENT->EJERCICIO == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="EJERCICIO">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="EJERCICIO" id="EJERCICIO_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->EJERCICIO == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="EJERCICIO_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">TIPO:</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_EJERCICIO"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_EJERCICIO) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Dieta -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <label class="control-label" for="DIETA">¿SIGUE ALGUNA DIETA?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DIETA" id="DIETA"
                                            value="1" <?= ($ROW_DATA_PATIENT->DIETA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIETA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="DIETA" id="DIETA_NO"
                                            value="0" <?= ($ROW_DATA_PATIENT->DIETA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="DIETA_NO">NO</label>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label text-left">¿CUÁL?</label>
                                        <textarea class="form-control" name="ESPECIFIQUE_DIETA"
                                            placeholder="Escribe aquí.."
                                            rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->ESPECIFIQUE_DIETA) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <!-- Antecedentes Ginecobstétricos -->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h4 class="h3Antecedentes">ANTECEDENTES GINECOBSTÉTRICOS</h4>
                            </div>

                            <!-- Actualmente Embarazada -->
                            <div class="form-check">
                                <div class="row col-sm-12 col-md-12 col-lg-12">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="control-label" for="ACTUALMENTE_EMBARAZADA">¿ESTÁ ACTUALMENTE
                                            EMBARAZADA, EN PERIODO DE LACTANCIA O EN TRATAMIENTO DE FERTILIZACIÓN IN
                                            VITRO?</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ACTUALMENTE_EMBARAZADA"
                                            id="ACTUALMENTE_EMBARAZADA" value="1"
                                            <?= ($ROW_DATA_PATIENT->ACTUALMENTE_EMBARAZADA == 1) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ACTUALMENTE_EMBARAZADA">SÍ</label>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <input class="form-check-input" type="radio" name="ACTUALMENTE_EMBARAZADA"
                                            id="ACTUALMENTE_EMBARAZADA_NO" value="0"
                                            <?= ($ROW_DATA_PATIENT->ACTUALMENTE_EMBARAZADA == 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ACTUALMENTE_EMBARAZADA_NO">NO</label>
                                    </div>
                                </div>
                            </div>

                            <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label text-left">MENARCA </label>
                                    <textarea class="form-control" name="MENARCA" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->MENARCA) ?></textarea>
                                </div>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label text-left">F.U.M </label>
                                    <textarea class="form-control" name="FUM" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->FUM) ?></textarea>
                                </div>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label text-left">RITMO MENSTRUAL </label>
                                    <textarea class="form-control" name="RITMO_MENSTRUAL" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->RITMO_MENSTRUAL) ?></textarea>
                                </div>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label text-left">FUP O CESÁREA</label>
                                    <textarea class="form-control" name="FUP_CESAREA" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->FUP_CESAREA) ?></textarea>
                                </div>
                            </div>

                            <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                <div class="col-sm-2 col-mdx-2 col-lg-2">
                                    <label class="control-label text-left">G </label>
                                    <textarea class="form-control" name="G" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->G) ?></textarea>
                                </div>
                                <div class="col-sm-2 col-mdx-2 col-lg-2">
                                    <label class="control-label text-left">P </label>
                                    <textarea class="form-control" name="P" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->P) ?></textarea>
                                </div>
                                <div class="col-sm-2 col-mdx-2 col-lg-2">
                                    <label class="control-label text-left">A </label>
                                    <textarea class="form-control" name="A" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->A) ?></textarea>
                                </div>
                                <div class="col-sm-2 col-mdx-2 col-lg-2">
                                    <label class="control-label text-left">C</label>
                                    <textarea class="form-control" name="C" placeholder="Escribe aquí.."
                                        rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->C) ?></textarea>
                                </div>
                                <div class="col-sm-2 col-mdx-4 col-lg-4">
                                    <label class="control-label text-left">MÉTODO ANTICONCEPTIVO</label>
                                    <textarea class="form-control" name="METODO_ANTICONCEPTIVO"
                                        placeholder="Escribe aquí.." rows="1"><?= htmlspecialchars($ROW_DATA_PATIENT->METODO_ANTICONCEPTIVO) ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="<?= base_url() ?>Patient/index" class="btn btn-cancel pull-left"
                                        id="btnCloseAddAgent">
                                        <i class="fas fa-chevron-double-left"></i> Regresar
                                    </a>
                                    <button type="submit" class="btn btn-info pull-right">
                                        <i class="fas fa-user-check"></i> Guardar cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </form>
</div>
<div class="col-lg-2"></div>
</div>
</div>