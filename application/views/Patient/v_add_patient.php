<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
            <br>
            <form data-toggle="validator" role="form" id="formRecordPatient">
                <div class="control-group text-left">
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-user-plus"></i>
                                    Nuevo Paciente </span></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_PACIENTE" class="control-label text-left">Nombre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_NOMBRE_PACIENTE"
                                                id="RG_NOMBRE_PACIENTE"
                                                class="form-control" required placeholder="Nombre paciente">
                                        </div>
                                        <div class=" help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_PATERNO_PACIENTE" class="control-label text-left">Apellido
                                            paterno</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_PATERNO_PACIENTE"
                                                id="RG_APELLIDO_PATERNO_PACIENTE"
                                                class="form-control" required placeholder="Apellido paterno paciente">
                                        </div>
                                        <div class=" help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_MATERNO_PACIENTE" class="control-label text-left">Apellido
                                            materno</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_MATERNO_PACIENTE"
                                                id="RG_APELLIDO_MATERNO_PACIENTE"
                                                class="form-control" placeholder="Apellido materno paciente">
                                        </div>
                                        <div class=" help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ID_SEXO" class="control-label text-left">Sexo</label>
                                        <div class='input-group'>
                                            <span class="input-group-addon"><i class="fas fa-venus-mars"></i></span>
                                            <select name="RG_ID_SEXO" id="RG_ID_SEXO" class="form-control">
                                                <?php
                                                if (count($ROW_SEX) > NULO):
                                                    foreach ($ROW_SEX as $ROW):
                                                ?>
                                                        <option value="<?= $ROW['ID_SEXO'] ?>"><?= mb_strtoupper($ROW['NOMBRE_SEXO']) ?></option>
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
                                        <label for="RG_FECHA_NAC_PACIENTE" class="control-label text-left">Fecha nacimiento</label>
                                        <div class='input-group'>
                                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                            <input type='text' readonly data-type="datepicker" class="form-control" id="RG_FECHA_NAC_PACIENTE" name="RG_FECHA_NAC_PACIENTE" placeholder="dd/mm/yyyy" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ESTADO_CIVIL_PACIENTE" class="control-label text-left">Estado Civil</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input type="text" name="RG_ESTADO_CIVIL_PACIENTE"
                                                id="RG_ESTADO_CIVIL_PACIENTE"
                                                class="form-control" placeholder="Estado civil">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_RELIGION_PACIENTE" class="control-label text-left">Religión</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-mosque"></i></span>
                                            <input type="text" name="RG_RELIGION_PACIENTE"
                                                id="RG_RELIGION_PACIENTE"
                                                class="form-control" placeholder="Religión">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_OCUPACION_PACIENTE" class="control-label text-left">Ocupación</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user-hard-hat"></i></span>
                                            <input type="text" name="RG_OCUPACION_PACIENTE"
                                                id="RG_OCUPACION_PACIENTE"
                                                class="form-control" placeholder="Ocupación">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_CALLE_PACIENTE" class="control-label text-left">Calle</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fad fa-road"></i></span>
                                            <input type="text" name="RG_CALLE_PACIENTE"
                                                id="RG_CALLE_PACIENTE"
                                                class="form-control" placeholder="Calle domicilio paciente">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NUMERO_PACIENTE" class="control-label text-left">Número</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">#</span>
                                            <input type="text" name="RG_NUMERO_PACIENTE"
                                                id="RG_NUMERO_PACIENTE"
                                                class="form-control" placeholder="Número domicilio paciente">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-8 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_COLONIA_PACIENTE" class="control-label text-left">Colonia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fad fa-street-view"></i></span>
                                            <input type="text" name="RG_COLONIA_PACIENTE"
                                                id="RG_COLONIA_PACIENTE"
                                                class="form-control" placeholder="Colonia domicilio paciente">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_EMAIL_PACIENTE" class="control-label text-left">Correo electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                            <input type="email" name="RG_EMAIL_PACIENTE"
                                                id="RG_EMAIL_PACIENTE"
                                                class="form-control" placeholder="Correo electrónico">
                                        </div>
                                        <div class=" help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_PACIENTE" class="control-label text-left">No. Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_PACIENTE"
                                                id="RG_TELEFONO_PACIENTE"
                                                class="form-control" placeholder="No. teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_URGENCIA" class="control-label text-left">CONTACTO DE EMERGENCIA</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_URGENCIA"
                                                id="RG_TELEFONO_URGENCIA"
                                                class="form-control" placeholder="No. teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ID_TIPO_SANGRE" class="control-label text-left">TIPO DE SANGRE</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-tint"></i></span>
                                            <select class="form-control" required id="RG_ID_TIPO_SANGRE" name="RG_ID_TIPO_SANGRE">
                                                <?php
                                                $CI = &get_instance();
                                                $Tipo_sangre = $this->db->get_where('sangre', array('vigencia_sangre' => 1))->result_array();
                                                if (count($Tipo_sangre) > NULO):
                                                    foreach ($Tipo_sangre as $ROW):
                                                ?>
                                                        <option value="<?= $ROW['id_sangre'] ?>"><?= mb_strtoupper($ROW['tipo_sangre']) ?>
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
                                <div hidden class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label text-left">Tipo descuento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-hand-pointer"></i></span>
                                            <select class="form-control" required id="CHOOSE_TYPE_DESCUENTO">
                                                <option disabled selected value="">Elige una opción</option>
                                                <option value="1" selected>Tarifa</option>
                                                <option value="2">Membresia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div hidden class="col-sm-12 col-mdx-6 col-lg-4 " id="divTarifa">
                                    <div class="form-group">
                                        <label for="RG_ID_TARIFA" class="control-label text-left">Tarifa</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <select required name="RG_ID_TARIFA" id="ID_TARIFA" class="form-control">
                                                <?php
                                                $CI = &get_instance();
                                                $Tarifas = $this->db->get_where('tarifa', array('VIGENCIA_TARIFA' => 1, 'ID_TARIFA' => 1))->result_array();
                                                if (count($Tarifas) > NULO):
                                                    foreach ($Tarifas as $ROW):
                                                ?>
                                                        <option value="<?= $ROW['ID_TARIFA'] ?>" selected><?= mb_strtoupper($ROW['NOMBRE_TARIFA']) ?>
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
                                <div class="hidden" id="divMembresia">
                                    <div class="col-sm-12 col-mdx-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_ID_CASA" class="control-label text-left">Casa</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                                <select required name="RG_ID_CASA" id="RG_ID_CASA" class="form-control">
                                                    <option disabled selected value="">Elige una opción</option>
                                                    <?php
                                                    if (count($casas) > NULO):
                                                        foreach ($casas as $ROW):
                                                    ?>
                                                            <option value="<?= $ROW['ID_CASA'] ?>" data-membership="<?= $ROW['NOMBRE_MEMBRESIA'] ?>" data-id-membership="<?= $ROW['ID_MEMBRESIA'] ?>"><?= mb_strtoupper($ROW['NOMBRE_CASA']) ?></option>
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
                                    <input type="hidden" name="RG_ID_MEMBRESIA" id="RG_ID_MEMBRESIA">
                                    <div class="col-sm-12 col-mdx-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_NOMBRE_MEMBRESIA" class="control-label text-left">Membresía</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                                <input readonly type="text" name="RG_NOMBRE_MEMBRESIA" id="RG_NOMBRE_MEMBRESIA" class="form-control" placeholder="Membresía">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_ID_PERFIL_MEMBRESIA" class="control-label text-left">Perfil Membresía</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-user-tag"></i></span>
                                                <select name="RG_ID_PERFIL_MEMBRESIA" id="TIPO_MEMBRESIA" class="form-control">
                                                    <option disabled selected value="">Elige una opción</option>
                                                    <?php
                                                    $Perfiles = $this->db->get_where('perfil', array('VIGENCIA_PERFIL' => 1))->result_array();
                                                    if (count($Perfiles) > NULO):
                                                        foreach ($Perfiles as $ROW) {
                                                            echo "<option value='" . $ROW['ID_PERFIL'] . "'>" . mb_strtoupper($ROW['NOMBRE_PERFIL']) . "</option>";
                                                        }
                                                    else:
                                                        echo "<option disabled value=''>No hay registros</option>";
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
                                                id="DIABETES_MADRE">
                                            <label class="form-check-label" for="DIABETES_MADRE">
                                                DIABETES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="HIPERTENSION_MADRE"
                                                id="HIPERTENSION_MADRE" >
                                            <label class="form-check-label" for="HIPERTENSION_MADRE">
                                                HIPERTENSIÓN
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_MADRE"
                                                id="ENF_AUTOINMUNES_MADRE">
                                            <label class="form-check-label" for="ENF_AUTOINMUNES_MADRE">
                                                ENF. AUTOINMUNES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="CANCER_MADRE"
                                                id="CANCER_MADRE" >
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
                                                id="DIABETES_PADRE" >
                                            <label class="form-check-label" for="DIABETES_PADRE">
                                                DIABETES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="HIPERTENSION_PADRE"
                                                id="HIPERTENSION_PADRE" >
                                            <label class="form-check-label" for="HIPERTENSION_PADRE">
                                                HIPERTENSIÓN
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_PADRE"
                                                id="ENF_AUTOINMUNES_PADRE" >
                                            <label class="form-check-label" for="ENF_AUTOINMUNES_PADRE">
                                                ENF. AUTOINMUNES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="CANCER_PADRE"
                                                id="CANCER_PADRE">
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
                                                id="DIABETES_HERMANOS">
                                            <label class="form-check-label" for="DIABETES_HERMANOS">
                                                DIABETES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3 text-left">
                                            <input class="form-check-input" type="checkbox" name="HIPERTENSION_HERMANOS"
                                                id="HIPERTENSION_HERMANOS" >
                                            <label class="form-check-label" for="HIPERTENSION_HERMANOS">
                                                HIPERTENSIÓN
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="ENF_AUTOINMUNES_HERMANOS"
                                                id="ENF_AUTOINMUNES_HERMANOS" >
                                            <label class="form-check-label" for="ENF_AUTOINMUNES_HERMANOS">
                                                ENF. AUTOINMUNES
                                            </label>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <input class="form-check-input" type="checkbox" name="CANCER_HERMANOS"
                                                id="CANCER_HERMANOS">
                                            <label class="form-check-label" for="CANCER_HERMANOS">
                                                CÁNCER
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Otros</label>
                                        <textarea class="form-control" name="OTROS_HEREDOFAMILIARES"
                                            placeholder="Escribe aquí.." rows="5"></textarea>
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
                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="DIABETES_MELLITUS">
                                                Diabetes Mellitus
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="DIABETES_MELLITUS_SI"
                                                id="DIABETES_MELLITUS_SI" >
                                            <label class="form-check-label" for="DIABETES_MELLITUS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="DIABETES_MELLITUS_NO"
                                                id="DIABETES_MELLITUS_NO" >
                                            <label class="form-check-label" for="DIABETES_MELLITUS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_DIABETES"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"> <br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="DIABETES_MELLITUS">
                                                Hipertensión Arterial
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HIPERTENSION_ARTERIAL_SI"
                                                id="HIPERTENSION_ARTERIAL_SI" >
                                            <label class="form-check-label" for="HIPERTENSION_ARTERIAL_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HIPERTENSION_ARTERIAL_NO"
                                                id="HIPERTENSION_ARTERIAL_NO" >
                                            <label class="form-check-label" for="HIPERTENSION_ARTERIAL_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_HIPERTENSION"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ENFERMEDADES_ENDOCRINOLOGICAS">
                                                Enfermedades Endocrinológicas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_ENDOCRINOLOGICAS_SI"
                                                id="ENFERMEDADES_ENDOCRINOLOGICAS_SI" >
                                            <label class="form-check-label" for="ENFERMEDADES_ENDOCRINOLOGICAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_ENDOCRINOLOGICAS_NO"
                                                id="ENFERMEDADES_ENDOCRINOLOGICAS_NO" >
                                            <label class="form-check-label" for="ENFERMEDADES_ENDOCRINOLOGICAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control"
                                                name="TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ENFERMEDADES_PSIQUIATRICAS">
                                                Enfermedades Psiquiátricas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_PSIQUIATRICAS_SI" id="ENFERMEDADES_PSIQUIATRICAS_SI"
                                                >
                                            <label class="form-check-label" for="ENFERMEDADES_PSIQUIATRICAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_PSIQUIATRICAS_NO" id="ENFERMEDADES_PSIQUIATRICAS_NO"
                                                >
                                            <label class="form-check-label" for="ENFERMEDADES_PSIQUIATRICAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control"
                                                name="TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ENFERMEDADES_AUTOINMUNES">
                                                Enfermedades Autoinmunes
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_AUTOINMUNES_SI" id="ENFERMEDADES_AUTOINMUNES_SI"
                                                >
                                            <label class="form-check-label" for="ENFERMEDADES_AUTOINMUNES_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENFERMEDADES_AUTOINMUNES_NO" id="ENFERMEDADES_AUTOINMUNES_NO"
                                                >
                                            <label class="form-check-label" for="ENFERMEDADES_AUTOINMUNES_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="VIH">
                                                Virus Inmunodeficiencia Humana (VIH)
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="VIH_SI" id="VIH_SI"
                                                >
                                            <label class="form-check-label" for="VIH_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="VIH_NO" id="VIH_NO"
                                                >
                                            <label class="form-check-label" for="VIH_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_VIH"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="HERPES_LABIAL">
                                                Herpes Labial (Fuegos) / Herpes Zoster
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HERPES_LABIAL_SI"
                                                id="HERPES_LABIAL_SI" >
                                            <label class="form-check-label" for="HERPES_LABIAL_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HERPES_LABIAL_NO"
                                                id="HERPES_LABIAL_NO" >
                                            <label class="form-check-label" for="HERPES_LABIAL_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_HERPES_LABIAL"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="TRANSFUSIONES_SANGUINEAS">
                                                Transfusiones Sanguíneas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="TRANSFUSIONES_SANGUINEAS_SI" id="TRANSFUSIONES_SANGUINEAS_SI"
                                                >
                                            <label class="form-check-label" for="TRANSFUSIONES_SANGUINEAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="TRANSFUSIONES_SANGUINEAS_NO" id="TRANSFUSIONES_SANGUINEAS_NO"
                                                >
                                            <label class="form-check-label" for="TRANSFUSIONES_SANGUINEAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="FRACTURAS">
                                                Traumatismos / Fracturas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FRACTURAS_SI"
                                                id="FRACTURAS_SI" >
                                            <label class="form-check-label" for="FRACTURAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FRACTURAS_NO"
                                                id="FRACTURAS_NO" >
                                            <label class="form-check-label" for="FRACTURAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_FRACTURAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="HOSPITALIZACIONES">
                                                Hospitalizaciones
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HOSPITALIZACIONES_SI"
                                                id="HOSPITALIZACIONES_SI" >
                                            <label class="form-check-label" for="HOSPITALIZACIONES_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HOSPITALIZACIONES_NO"
                                                id="HOSPITALIZACIONES_NO" >
                                            <label class="form-check-label" for="HOSPITALIZACIONES_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_HOSPITALIZACIONES"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="CIRUGIAS_PREVIAS">
                                                Cirugías previas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="CIRUGIAS_PREVIAS_SI"
                                                id="CIRUGIAS_PREVIAS_SI" >
                                            <label class="form-check-label" for="CIRUGIAS_PREVIAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="CIRUGIAS_PREVIAS_NO"
                                                id="CIRUGIAS_PREVIAS_NO" >
                                            <label class="form-check-label" for="CIRUGIAS_PREVIAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="HEPATITIS">
                                                Hepatitis
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HEPATITIS_SI"
                                                id="HEPATITIS_SI" >
                                            <label class="form-check-label" for="HEPATITIS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HEPATITIS_NO"
                                                id="HEPATITIS_NO" >
                                            <label class="form-check-label" for="HEPATITIS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_HEPATITIS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="CANCER">
                                                Cáncer
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="CANCER_SI" id="CANCER_SI"
                                                >
                                            <label class="form-check-label" for="CANCER_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="CANCER_NO" id="CANCER_NO"
                                                >
                                            <label class="form-check-label" for="CANCER_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_CANCER"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="EPILEPSIA">
                                                Epilepsia
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="EPILEPSIA_SI"
                                                id="EPILEPSIA_SI" >
                                            <label class="form-check-label" for="EPILEPSIA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="EPILEPSIA_NO"
                                                id="EPILEPSIA_NO" >
                                            <label class="form-check-label" for="EPILEPSIA_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_EPILEPSIA"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ALERGIAS">
                                                Alergias
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ALERGIAS_SI"
                                                id="ALERGIAS_SI" >
                                            <label class="form-check-label" for="ALERGIAS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ALERGIAS_NO"
                                                id="ALERGIAS_NO" >
                                            <label class="form-check-label" for="ALERGIAS_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <textarea class="form-control" name="TIEMPO_EVOLUCION_ALERGIAS"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label text-left">OTROS</label>
                                            <textarea class="form-control" name="OTROS_PATOLOGICO"
                                                placeholder="Escribe aquí.." rows="5"></textarea>
                                        </div>
                                    </div>


                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="FUMA">
                                                ¿FUMA?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FUMA_SI" id="FUMA_SI"
                                                >
                                            <label class="form-check-label" for="FUMA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FUMA_NO" id="FUMA_NO"
                                                >
                                            <label class="form-check-label" for="FUMA_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> CUANTOS POR DÍA?</label>
                                            <textarea class="form-control" name="FUMA_CUANTOS" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ADICCIONES">
                                                ¿ADICCIONES?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ADICCIONES_SI"
                                                id="ADICCIONES_SI" >
                                            <label class="form-check-label" for="ADICCIONES_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ADICCIONES_NO"
                                                id="ADICCIONES_NO" >
                                            <label class="form-check-label" for="ADICCIONES_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ESPECIFIQUE:</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_ADICCIONES"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="BEBE_ALCOHOL">
                                                ¿BEBE ALCOHOL?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="BEBE_ALCOHOL_SI"
                                                id="BEBE_ALCOHOL_SI" >
                                            <label class="form-check-label" for="BEBE_ALCOHOL_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="BEBE_ALCOHOL_NO"
                                                id="BEBE_ALCOHOL_NO" >
                                            <label class="form-check-label" for="BEBE_ALCOHOL_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ESPECIFIQUE:</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_ALCOHOL"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="FOBIA">
                                                ¿FOBIA A LA SANGRE O AGUJAS?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FOBIA_SI" id="FOBIA_SI"
                                                >
                                            <label class="form-check-label" for="FOBIA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-8 col-mdx-8 col-lg-8">
                                            <input class="form-check-input" type="checkbox" name="FOBIA_NO" id="FOBIA_NO"
                                                >
                                            <label class="form-check-label" for="FOBIA_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="DESMAYOS">
                                                ¿ES PROPENSO A LOS DESMAYOS?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="DESMAYOS_SI"
                                                id="DESMAYOS_SI" >
                                            <label class="form-check-label" for="DESMAYOS_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-8 col-mdx-8 col-lg-8">
                                            <input class="form-check-input" type="checkbox" name="DESMAYOS_NO"
                                                id="DESMAYOS_NO" >
                                            <label class="form-check-label" for="DESMAYOS_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ASPIRINA">
                                                ¿TOMA ASPIRINA, WARFARINA O ANTICOAGULANTES?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ASPIRINA_SI"
                                                id="ASPIRINA_SI" >
                                            <label class="form-check-label" for="ASPIRINA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-8 col-mdx-8 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ASPIRINA_NO"
                                                id="ASPIRINA_NO" >
                                            <label class="form-check-label" for="ASPIRINA_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="MORETES">
                                                ¿ES PROPENSO A SUFRIR MORETES?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="MORETES_SI"
                                                id="MORETES_SI" >
                                            <label class="form-check-label" for="MORETES_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-8 col-mdx-8 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="MORETES_NO"
                                                id="MORETES_NO" >
                                            <label class="form-check-label" for="MORETES_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="BRONCEADO">
                                                ¿HA USADO CAMA DE BRONCEADO EN LOS ÚLTIMOS 3 MESES?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="BRONCEADO_SI"
                                                id="BRONCEADO_SI" >
                                            <label class="form-check-label" for="BRONCEADO_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-8 col-mdx-8 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="BRONCEADO_NO"
                                                id="BRONCEADO_NO" >
                                            <label class="form-check-label" for="BRONCEADO_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label" for="ANESTESIA">
                                                ¿ALGUNA VEZ LE HAN ADMINISTRADO INYECCIONES DE ANESTESIA LOCAL (INCLUIDAS EN
                                                EL DENTISTA)?
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="ANESTESIA_SI"
                                                id="ANESTESIA_SI" >
                                            <label class="form-check-label" for="ANESTESIA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2 ">
                                            <input class="form-check-input" type="checkbox" name="ANESTESIA_NO"
                                                id="ANESTESIA_NO" >
                                            <label class="form-check-label" for="ANESTESIA_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label" for="PROBLEMA_ANESTESIA">
                                                ¿HA SUFRIDO ALGÚN PROBLEMA CON LA ANESTESIA?
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="PROBLEMA_ANESTESIA_SI"
                                                id="PROBLEMA_ANESTESIA_SI" >
                                            <label class="form-check-label" for="PROBLEMA_ANESTESIA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="PROBLEMA_ANESTESIA_NO"
                                                id="PROBLEMA_ANESTESIA_NO" >
                                            <label class="form-check-label" for="PROBLEMA_ANESTESIA_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ESPECIFIQUE:</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_PROBLEMA_ANESTESIA"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label" for="INMUNIZACIÓN">
                                                ¿HA RECIBIDO ALGUNA INMUNIZACIÓN (VACUNA) EN LOS ÚLTIMOS 3 MESES?
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="INMUNIZACION_SI"
                                                id="INMUNIZACION_SI" >
                                            <label class="form-check-label" for="INMUNIZACION_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="INMUNIZACION_NO"
                                                id="INMUNIZACION_NO" >
                                            <label class="form-check-label" for="INMUNIZACION_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ¿CUÁL?</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_INMUNIZACION"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label" for="INFECCION_PIEL">
                                                ¿TIENE O HA TENIDO EN LOS ÚLTIMOS 3 MESES ALGUNA INFECCIÓN EN LA PIEL?
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="INFECCION_PIEL_SI"
                                                id="INFECCION_PIEL_SI" >
                                            <label class="form-check-label" for="INFECCION_PIEL_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="INFECCION_PIEL_NO"
                                                id="INFECCION_PIEL_NO" >
                                            <label class="form-check-label" for="INFECCION_PIEL_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ¿CUÁL?</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_INFECCION_PIEL"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-4 col-mdx-4 col-lg-4">
                                            <label class="control-label" for="ESTEROIDES">
                                                ¿ESTÁ RECIBIENDO O HA RECIBIDO EN LOS ÚLTIMOS 3 MESES ALGÚN TRATAMIENTO
                                                MÉDICO CON ESTEROIDES O CUALQUIER
                                                OTRO MEDICAMENTO DE VENTA LIBRE AUTO INDICADO (ANALGÉSICOS,
                                                ANTINFLAMATORIOS, ANTIÁCIDOS)?
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="ESTEROIDES_SI"
                                                id="ESTEROIDES_SI" >
                                            <label class="form-check-label" for="ESTEROIDES_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-1 col-mdx-1 col-lg-1">
                                            <input class="form-check-input" type="checkbox" name="ESTEROIDES_NO"
                                                id="ESTEROIDES_NO" >
                                            <label class="form-check-label" for="ESTEROIDES_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ¿CUÁL?</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_ESTEROIDES"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="EJERCICIO">
                                                ¿HACE EJERCICIO?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="EJERCICIO_SI"
                                                id="EJERCICIO_SI" >
                                            <label class="form-check-label" for="EJERCICIO_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="EJERCICIO_NO"
                                                id="EJERCICIO_NO" >
                                            <label class="form-check-label" for="EJERCICIO_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> TIPO:</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_EJERCICIO"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="DIETA">
                                                ¿SIGUE ALGUNA DIETA?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="DIETA_SI" id="DIETA_SI"
                                                >
                                            <label class="form-check-label" for="DIETA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="DIETA_NO" id="DIETA_NO"
                                                >
                                            <label class="form-check-label" for="DIETA_NO">
                                                NO
                                            </label>
                                        </div>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label text-left"> ¿CUÁL?</label>
                                            <textarea class="form-control" name="ESPECIFIQUE_DIETA"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                                        <h4 class="h3Antecedentes">ANTECEDENTES GINECOBSTÉTRICOS</h4>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-6 col-mdx-6 col-lg-6">
                                            <label class="control-label" for="ACTUALMENTE_EMBARAZADA">
                                                ¿ESTÁ ACTUALMENTE EMBARAZADA, EN PERIODO DE LACTANCIA O EN TRATAMIENTO DE
                                                FERTILIZACIÓN IN VITRO?
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ACTUALMENTE_EMBARAZADA_SI"
                                                id="ACTUALMENTE_EMBARAZADA_SI" >
                                            <label class="form-check-label" for="ACTUALMENTE_EMBARAZADA_SI">
                                                SI
                                            </label>
                                        </div>
                                        <div class="col-sm-4 col-mdx-4 col-lg-4">
                                            <input class="form-check-input" type="checkbox" name="ACTUALMENTE_EMBARAZADA_NO"
                                                id="ACTUALMENTE_EMBARAZADA_NO" >
                                            <label class="form-check-label" for="ACTUALMENTE_EMBARAZADA_NO">
                                                NO
                                            </label>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label text-left">MENARCA </label>
                                            <textarea class="form-control" name="MENARCA" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label text-left">F.U.M </label>
                                            <textarea class="form-control" name="FUM" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label text-left">RITMO MENSTRUAL </label>
                                            <textarea class="form-control" name="RITMO_MENSTRUAL"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-3 col-mdx-3 col-lg-3">
                                            <label class="control-label text-left">FUP O CESÁREA</label>
                                            <textarea class="form-control" name="FUP_CESAREA" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label text-left">G </label>
                                            <textarea class="form-control" name="G" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label text-left">P </label>
                                            <textarea class="form-control" name="P" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label text-left">A </label>
                                            <textarea class="form-control" name="A" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label text-left">C</label>
                                            <textarea class="form-control" name="C" placeholder="Escribe aquí.."
                                                rows="1"></textarea>
                                        </div>
                                        <div class="col-sm-2 col-mdx-4 col-lg-4">
                                            <label class="control-label text-left">MÉTODO ANTICONCEPTIVO</label>
                                            <textarea class="form-control" name="METODO_ANTICONCEPTIVO"
                                                placeholder="Escribe aquí.." rows="1"></textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="<?= base_url() ?>patient/index" class="btn btn-cancel pull-left"
                                        id="btnCloseAddPatient">
                                        <i class="fas fa-chevron-double-left"></i> Regresar
                                    </a>
                                    <button type="submit" class="btn btn-info pull-right">
                                        <i class="fas fa-user-check"></i> Guardar paciente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>