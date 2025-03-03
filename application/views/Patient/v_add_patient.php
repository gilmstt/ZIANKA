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
                                                   class="form-control" required placeholder="Nombre paciente"
                                                   pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
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
                                                   class="form-control" required placeholder="Apellido paterno paciente"
                                                   pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
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
                                                   class="form-control" placeholder="Apellido materno paciente"
                                                   pattern="[a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
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
                                        <label for="RG_TELEFONO_URGENCIA" class="control-label text-left">CONTACTO DE URGENCIA</label>
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
                                        <label for="RG_LUGAR_NACIMIENTO" class="control-label text-left">Lugar de nacimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_LUGAR_NACIMIENTO"
                                                   id="RG_LUGAR_NACIMIENTO"
                                                   class="form-control" placeholder="lugar de nacimiento"
                                                   pattern="[a-zA-Z,\. ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
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
                                                   class="form-control" placeholder="Número domicilio paciente"
                                                   pattern="[0-9#/\.,a-zA-Z ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{1,}">
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
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_ESTADO_REPUBLICA" class="control-label text-left">Estado</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_ESTADO_REPUBLICA"
                                                   id="RG_ESTADO_REPUBLICA"
                                                   class="form-control" placeholder="Estado paciente"
                                                   pattern="[a-zA-Z,\. ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_MUNICIPIO_PACIENTE" class="control-label text-left">Municipio</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_MUNICIPIO_PACIENTE"
                                                   id="RG_MUNICIPIO_PACIENTE"
                                                   class="form-control" placeholder="Municipio paciente"
                                                   pattern="[a-zA-Z,\. ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="RG_RESIDENCIA" class="control-label text-left">Residencia</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-question"></i></span>
                                            <input type="text" name="RG_RESIDENCIA"
                                                   id="RG_RESIDENCIA"
                                                   class="form-control" placeholder="Residencia paciente"
                                                   pattern="[a-zA-Z,\. ñÑáéíóúÁÉÍÓÚàÀèÈìÌòÒùÙäÄëËïÏöÖüÜ]{2,}"
                                                   title="No debe incluir números ni símbolos">
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-sm-12 col-mdx-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label text-left">Tipo descuento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-hand-pointer"></i></span>
                                            <select class="form-control" required id="CHOOSE_TYPE_DESCUENTO">
                                                <option disabled selected value="">Elige una opción</option>
                                                <option value="1">Tarifa</option>
                                                <option value="2">Membresia</option>
                                            </select>
                                        </div>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4 hidden" id="divTarifa">
                                    <div class="form-group">
                                        <label for="RG_ID_TARIFA" class="control-label text-left">Tarifa</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <select required name="RG_ID_TARIFA" id="ID_TARIFA" class="form-control">
                                                <option disabled selected value="">Elige una opción</option>
                                                <?php
                                                $CI = & get_instance();
                                                $Tarifas = $this->db->get_where('tarifa', array('VIGENCIA_TARIFA' => 1))->result_array();
                                                if (count($Tarifas) > NULO):
                                                    foreach ($Tarifas as $ROW):
                                                        ?>
                                                        <option value="<?= $ROW['ID_TARIFA'] ?>"><?= mb_strtoupper($ROW['NOMBRE_TARIFA']) ?>
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       class="form-control" placeholder="No. teléfono">
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       title="No debe incluir números ni símbolos">
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
                                                       id="RG_TELEFONO_MADRE_PACIENTE"
                                                       class="form-control" placeholder="No. teléfono">
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
                                        <textarea class="form-control" name="PATOLOGICO" placeholder="Escribe aquí.." rows="5"   ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">No. Patólogico</label>
                                        <textarea class="form-control" name="NO_PATOLOGICO" placeholder="Escribe aquí.." rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Heredo Familiares</label>
                                        <textarea class="form-control" name="HEREDO_FAMILIARES" placeholder="Escribe aquí.." rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Quirúrgicos</label>
                                        <textarea class="form-control" name="QUIRURGICOS" placeholder="Escribe aquí.." rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Gineco-obstetricos</label>
                                        <textarea class="form-control" name="OBSTETRICOS" placeholder="Escribe aquí.." rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Alergias</label>
                                        <textarea class="form-control" name="ALERGIAS" placeholder="Escribe aquí.." rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Medicamentos</label>
                                        <textarea class="form-control" name="MEDICAMENTOS" placeholder="Escribe aquí.." id="" rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Prenatales</label>
                                        <textarea class="form-control" name="PRENATALES" placeholder="Escribe aquí.." id="" rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Perinatales</label>
                                        <textarea class="form-control" name="PERINATALES" placeholder="Escribe aquí.." id="" rows="5"  ></textarea>
                                    </div>                          
                                </div>
                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-left">Posnatales</label>
                                        <textarea class="form-control" name="POSNATALES" placeholder="Escribe aquí.." id="" rows="5"  ></textarea>
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