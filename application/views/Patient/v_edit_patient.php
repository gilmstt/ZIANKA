<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 text-center">
            <br>
            <form data-toggle="validator" role="form" id="formEditPatient">
                <input type="hidden" value="<?= $ROW_DATA_PATIENT->ID_PACIENTE ?>" name="RG_ID_PATIENT" id="RG_ID_PATIENT">
                <div class="control-group text-left">
                    <div class="panel">
                        <div class="panel-heading header-black">
                            <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-user-edit"></i>
                                    Editar Paciente</span>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NOMBRE_PATIENT" class="control-label text-left">Nombre del paciente</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_NOMBRE_PATIENT" id="RG_NOMBRE_PATIENT" class="form-control"
                                                   required placeholder="Nombre del paciente"
                                                   value="<?= $ROW_DATA_PATIENT->NOMBRE_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_PATERNO_PATIENT" class="control-label text-left">Apellido paterno
                                            paciente</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_PATERNO_PATIENT" id="RG_APELLIDO_PATERNO_PATIENT"
                                                   class="form-control" required placeholder="Apellido paterno paciente"
                                                   value="<?= $ROW_DATA_PATIENT->APELLIDO_PATERNO_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_APELLIDO_MATERNO_PATIENT" class="control-label text-left">Apellido materno
                                            paciente</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                            <input type="text" name="RG_APELLIDO_MATERNO_PATIENT" id="RG_APELLIDO_MATERNO_PATIENT"
                                                   class="form-control" placeholder="Apellido materno paciente"
                                                   value="<?= $ROW_DATA_PATIENT->APELLIDO_MATERNO_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_PACIENTE" class="control-label text-left">No. Teléfono</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_PACIENTE" id="RG_TELEFONO_PACIENTE"
                                                   value="<?= $ROW_DATA_PATIENT->TELEFONO_PACIENTE ?>"
                                                   class="form-control" placeholder="No. teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-mdx-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="RG_TELEFONO_URGENCIA" class="control-label text-left">Contacto de urgencia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="text" name="RG_TELEFONO_URGENCIA" id="RG_TELEFONO_URGENCIA"
                                                   value="<?= $ROW_DATA_PATIENT->TELEFONO_URGENCIA ?>"
                                                   class="form-control" placeholder="No. teléfono">
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
                                                   value="<?= $ROW_DATA_PATIENT->EMAIL_PACIENTE ?>"
                                                   class="form-control" placeholder="Correo electrónico">
                                        </div>
                                        <div class=" help-block with-errors"></div>
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
                                        <label for="RG_FECHA_NAC_PTIENT" class="control-label text-left">Fecha nacimiento</label>
                                        <div class='input-group'>
                                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                            <input  type='text' data-type="datepicker" class="form-control" id="RG_FECHA_NAC_PTIENT"
                                                    required name="RG_FECHA_NAC_PTIENT"
                                                    value="<?= convierte_fecha_db_to_show($ROW_DATA_PATIENT->FECHA_NAC_PACIENTE) ?>"
                                                    pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_LUGAR_NACIMIENTO" class="control-label text-left">Lugar de nacimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_LUGAR_NACIMIENTO" value="<?= $ROW_DATA_PATIENT->LUGAR_NACIMIENTO ?>"
                                                   id="RG_LUGAR_NACIMIENTO"
                                                   class="form-control" placeholder="lugar de nacimiento">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_CALLE_PATIENT" class="control-label text-left">Calle</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-road"></i></span>
                                            <input type="text" name="RG_CALLE_PATIENT" id="RG_CALLE_PATIENT" class="form-control"
                                                   placeholder="Calle" value="<?= $ROW_DATA_PATIENT->CALLE_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_NUMERO_PATIENT" class="control-label text-left">Numero</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-sort-numeric-up-alt"></i></span>
                                            <input type="text" name="RG_NUMERO_PATIENT" id="RG_NUMERO_PATIENT" class="form-control"
                                                   placeholder="Numero" value="<?= $ROW_DATA_PATIENT->NUMERO_PACIENTE ?>"
                                                   pattern="[0-9#/\.,a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{1,}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-8 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_COLONIA_PATIENT" class="control-label text-left">Colonia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fad fa-street-view"></i></span>
                                            <input type="text" name="RG_COLONIA_PATIENT" id="RG_COLONIA_PATIENT"
                                                   class="form-control" placeholder="Colonia"
                                                   value="<?= $ROW_DATA_PATIENT->COLONIA_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ESTADO_REPUBLICAP" class="control-label text-left">Estado</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_ESTADO_REPUBLICAP" id="RG_ESTADO_REPUBLICAP"
                                                   class="form-control" placeholder="estado"
                                                   value="<?= $ROW_DATA_PATIENT->ESTADO_REPUBLICA ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_MUNICIPIO_PATIENT" class="control-label text-left">Municipio</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_MUNICIPIO_PATIENT" id="RG_MUNICIPIO_PATIENT"
                                                   class="form-control" placeholder="Municipio"
                                                   value="<?= $ROW_DATA_PATIENT->MUNICIPIO_PACIENTE ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_RESIDENCIA" class="control-label text-left">Residencia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_RESIDENCIA" value="<?= $ROW_DATA_PATIENT->RESIDENCIA ?>"
                                                   id="RG_RESIDENCIA" class="form-control" placeholder="Residencia paciente">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label text-left">Tipo descuento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-hand-pointer"></i></span>
                                            <select class="form-control" required id="CHOOSE_TYPE_DESCUENTO">
                                                <?php
                                                $a = $ROW_DATA_PATIENT->ID_TARIFA;
                                                $b = $ROW_DATA_PATIENT->ID_MEMBRESIA;

                                                $hidden_tarifa = ($a <= 0) ? "hidden" : "";
                                                $hidden_membre = ($b <= 0) ? "hidden" : "";
                                                $sel_tarifa = ($a > 0) ? "selected" : "";
                                                $sel_membre = ($b > 0) ? "selected" : "";
                                                ?>
                                                <option disabled selected value="">Elige una opción</option>
                                                <option <?= $sel_tarifa ?> value="1">Tarifa</option>
                                                <option <?= $sel_membre ?> value="2">Membresia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4 <?= $hidden_tarifa ?>" id="divTarifa">                       
                                    <div class="form-group">
                                        <label for="ID_TARIFA" class="control-label text-left">Tarifa</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <select name="RG_ID_TARIFA" id="ID_TARIFA" class="form-control">
                                                <option disabled selected value="">Elige una opción</option>
                                                <?php
                                                $CI = &get_instance();
                                                $Tarifas = $this->db->get('tarifa')->result_array();
                                                $ID_TARIFA = $ROW_DATA_PATIENT->ID_TARIFA;
                                                if (count($Tarifas) > NULO):
                                                    foreach ($Tarifas as $ROW):
                                                        $_sel = ($ROW['ID_TARIFA'] == $ID_TARIFA) ? "selected" : "";
                                                        ?>
                                                        <option <?= $_sel ?> value="<?= $ROW['ID_TARIFA'] ?>"><?= mb_strtoupper($ROW['NOMBRE_TARIFA']) ?>
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
                                <div class="<?= $hidden_membre ?>" id="divMembresia">
                                    <div class="col-sm-12 col-mdx-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_ID_CASA" class="control-label text-left">Casa</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                                <select name="RG_ID_CASA" id="RG_ID_CASA" class="form-control">      
                                                    <option disabled selected value="">Elige una opción</option>
                                                    <?php
                                                    $ID_CASA = $ROW_DATA_PATIENT->ID_CASA;
                                                    $nombre_mem = "";
                                                    if (count($casas) > 0):
                                                        echo "<option disabled selected value=''>Elige una opción</option>";
                                                        foreach ($casas as $ROW) {
                                                            $sel = "";
                                                            //echo $ROW['ID_CASA'] . " es igual a " . $ID_CASA . "<br>";
                                                            if ($ROW['ID_CASA'] == $ID_CASA) {
                                                                $sel = "selected";
                                                                $nombre_mem = $ROW["NOMBRE_MEMBRESIA"];
                                                            }
                                                            echo "<option $sel value='" . $ROW['ID_CASA'] . "' data-membership='" . $ROW['NOMBRE_MEMBRESIA'] . "' data-id-membership='" . $ROW['ID_MEMBRESIA'] . "'>" . mb_strtoupper($ROW['NOMBRE_CASA']) . "</option>";
                                                        }
                                                    else:
                                                        echo "<option disabled selected value=''>Sin opciones</option>";
                                                    endif;
                                                    ?>
                                                </select>
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
                                                    $ID_P_MEMBRESIA = $ROW_DATA_PATIENT->ID_PERFIL_MEMBRESIA;
                                                    foreach ($Perfiles as $ROW) {
                                                        $sel = ($ROW['ID_PERFIL'] == $ID_P_MEMBRESIA) ? "selected" : "";

                                                        echo "<option $sel value='" . $ROW['ID_PERFIL'] . "'>" . mb_strtoupper($ROW['NOMBRE_PERFIL']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="RG_ID_MEMBRESIA" id="RG_ID_MEMBRESIA" value="<?= $ROW_DATA_PATIENT->ID_MEMBRESIA ?>">
                                    <div class="col-sm-12 col-mdx-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_NOMBRE_MEMBRESIA" class="control-label text-left">Membresía</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                                <input type="text" readonly name="RG_NOMBRE_MEMBRESIA" id="RG_NOMBRE_MEMBRESIA" class="form-control" placeholder="Membresía" value="<?= $nombre_mem ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">   <h4>&nbsp; Madre o encargada</h4>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_NOMBRE_MADRE_PACIENTE" class="control-label text-left">Nombre</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_NOMBRE_MADRE_PACIENTE"
                                                       id="RG_NOMBRE_PACIENTE"
                                                       class="form-control" placeholder="Nombre"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->NOMBRE_MADRE_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_APELLIDO_MADRE_PATERNO_PACIENTE" class="control-label text-left">Apellido
                                                paterno</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_APELLIDO_MADRE_PATERNO_PACIENTE"
                                                       id="RG_APELLIDO_PATERNO_PACIENTE"
                                                       class="form-control" placeholder="Apellido paterno"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->APELLIDO_MADRE_PATERNO_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_APELLIDO_MADRE_MATERNO_PACIENTE" class="control-label text-left">Apellido  materno</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_APELLIDO_MADRE_MATERNO_PACIENTE"
                                                       id="RG_APELLIDO_MATERNO_PACIENTE"
                                                       class="form-control" placeholder="Apellido materno"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->APELLIDO_MADRE_MATERNO_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_TELEFONO_MADRE_PACIENTE" class="control-label text-left">No. Teléfono</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input type="text" name="RG_TELEFONO_MADRE_PACIENTE"
                                                       id="RG_TELEFONO_MADRE_PACIENTE"
                                                       class="form-control" placeholder="No. teléfono"
                                                       value="<?= $ROW_DATA_PATIENT->TELEFONO_MADRE_PACIENTE ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-mdx-12 col-lg-12"><h4>&nbsp; Padre o encargado</h4>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_NOMBRE_PADRE_PACIENTE" class="control-label text-left">Nombre</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_NOMBRE_PADRE_PACIENTE"
                                                       id="RG_NOMBRE_PACIENTE"
                                                       class="form-control" placeholder="Nombre"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->NOMBRE_PADRE_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_APELLIDO_PADRE_PATERNO_PACIENTE" class="control-label text-left">Apellido
                                                paterno</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_APELLIDO_PADRE_PATERNO_PACIENTE"
                                                       id="RG_APELLIDO_PATERNO_PACIENTE"
                                                       class="form-control" placeholder="Apellido paterno"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->APELLIDO_PADRE_PATERNO_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_APELLIDO_PADRE_MATERNO_PACIENTE" class="control-label text-left">Apellido
                                                materno</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user-edit"></i></span>
                                                <input type="text" name="RG_APELLIDO_PADRE_MATERNO_PACIENTE"
                                                       id="RG_APELLIDO_MATERNO_PACIENTE"
                                                       class="form-control" placeholder="Apellido materno"
                                                       pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                       title="No debe incluir números ni símbolos"
                                                       value="<?= $ROW_DATA_PATIENT->APELLIDO_PADRE_MATERNO_PACIENTE ?>">
                                            </div>
                                            <div class=" help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="RG_TELEFONO_PADRE_PACIENTE" class="control-label text-left">No. Teléfono</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input type="text" name="RG_TELEFONO_PADRE_PACIENTE"
                                                       id="RG_TELEFONO_PADRE_PACIENTE"
                                                       class="form-control" placeholder="No. teléfono"
                                                       value="<?= $ROW_DATA_PATIENT->TELEFONO_PADRE_PACIENTE ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="h3Antecedentes">ANTECEDENTES GENERALES</h4>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Patológico</label>
                                        <textarea class="form-control" name="PATOLOGICO" placeholder="Escribe aquí.." rows="5"><?= count($Antecedentes) > 0 ? $Antecedentes->PATOLOGICO : "" ?> </textarea>                                                             
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">No. Patólogico</label>
                                        <textarea class="form-control" name="NO_PATOLOGICO" placeholder="Escribe aquí.." rows="5" ><?= count($Antecedentes) > 0 ? $Antecedentes->NO_PATOLOGICO : "" ?></textarea>                                                               
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Heredo Familiares</label>
                                        <textarea class="form-control" name="HEREDO_FAMILIARES" placeholder="Escribe aquí.." rows="5" ><?= count($Antecedentes) > 0 ? $Antecedentes->HEREDO_FAMILIARES : "" ?></textarea>                                                               
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Quirúrgicos</label>
                                        <textarea class="form-control" name="QUIRURGICOS" placeholder="Escribe aquí.." rows="5" ><?= count($Antecedentes) > 0 ? $Antecedentes->QUIRURGICOS : "" ?></textarea>                                                               
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Gineco-obstetricos</label>
                                        <textarea class="form-control" name="OBSTETRICOS" placeholder="Escribe aquí.." rows="5" ><?= count($Antecedentes) > 0 ? $Antecedentes->OBSTETRICOS : "" ?></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Alergias</label>
                                        <textarea class="form-control" name="ALERGIAS" placeholder="Escribe aquí.." rows="5" ><?= count($Antecedentes) > 0 ? $Antecedentes->ALERGIAS : "" ?></textarea>                                                                
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Medicamentos</label>
                                        <textarea class="form-control" name="MEDICAMENTOS" id="" rows="5"><?= count($Antecedentes) > 0 ? $Antecedentes->MEDICAMENTOS : "" ?></textarea>                                                               
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Prenatales</label>
                                        <textarea class="form-control" name="PRENATALES" placeholder="Escribe aquí.." id="" rows="5"  ><?= count($Antecedentes) > 0 ? $Antecedentes->PRENATALES : "" ?></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Perinatales</label>
                                        <textarea class="form-control" name="PERINATALES" placeholder="Escribe aquí.." id="" rows="5"  ><?= count($Antecedentes) > 0 ? $Antecedentes->PERINATALES : "" ?></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Posnatales</label>
                                        <textarea class="form-control" name="POSNATALES" placeholder="Escribe aquí.." id="" rows="5"  ><?= count($Antecedentes) > 0 ? $Antecedentes->POSNATALES : "" ?></textarea>
                                    </div>                          
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
            </form>
        </div>
        <div class="col-lg-2"></div>
    </div>
</div>