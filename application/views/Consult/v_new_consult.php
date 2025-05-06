<?php
$ID_TARIFA = (isset($row_user->ID_TARIFA)) ? $row_user->ID_TARIFA : 0;
//$ID_MEMBRESIA = (isset($row_user->ID_MEMBRESIA)) ? $row_user->ID_MEMBRESIA : 0;
$ID_CASA = (isset($row_user->ID_CASA)) ? $row_user->ID_CASA : 0;

$CI = & get_instance();
$AllTarifas = $CI->db->get('tarifa')->result_array();
$Tarifas = $CI->db->get_where('tarifa', array('ID_TARIFA' => $ID_TARIFA))->row();
$TipoConsu = $CI->db->get('tipo_consulta')->result_array();
$Medicos = $CI->db->get_where('usuario', array('ID_ROL' => 4))->result_array();
$Productos = $CI->db->get_where('producto', array("ACTIVO_PRODUCTO" => 1))->result_array();
$Casa = $CI->db->get_where('casas', array('ID_CASA' => $ID_CASA))->row();
$ID_MEMBRESIA = isset($Casa->ID_MEMBRESIA) ? $Casa->ID_MEMBRESIA : 0;
//$Membresia = $CI->db->get_where('membresia', array('ID_MEMBRESIA' => $ID_MEMBRESIA))->row();
$Procedimientos = $CI->db->get_where('procedimiento', array("activo_procedimiento" => 1))->result_array();
$Antecedentes = $CI->db->get_where('antecedentes', array('ID_PACIENTE' => $row_user->ID_PACIENTE))->row();
?>
<style>
@media screen and (min-width: 768px) {
    .modal {
        text-align: center;
    }

    .modal:before {
        display: inline-block;
        vertical-align: middle;
        content: " ";
        height: 100%;
    }
}

.modal-dialog {
    display: inline-block;
    text-align: left;
    vertical-align: middle;
}

.form-control[disabled],
.form-control[readonly],
fieldset[disabled] .form-control {
    background-color: #b7bec133;
}
</style>
<div class="container animated fadeIn"><br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-sm-12 col-lg-12 col-xl-10 col-mdx-12">
            <div class="panel">
                <div class="panel-heading header-black">
                    <span class="heading-primary">NUEVA CONSULTA PARA:
                        <span class="name-yellow">
                            <?= $row_user->NOMBRE_PACIENTE . " " . $row_user->APELLIDO_PATERNO_PACIENTE . " " . $row_user->APELLIDO_MATERNO_PACIENTE ?></span>
                    </span>
                </div>
                <div class="panel-body">
                    <form id="NEW_CONSULT" data-toggle="validator" method="post">
                        <div class="row">
                            <input type="hidden" name="ID_PACIENTE" value="<?= $row_user->ID_PACIENTE ?>">

                            <!-- <div class="col-sm-12 col-mdx-12 col-lg-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne" style="background: #e8e8e8;">
                                    <h4 class="panel-title" style="padding-top:15px;text-align:center">
                                        <a style="font-size: 20px;font-weight: 700;" role="button" data-toggle="collapse"
                                        data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        ANTECEDENTES GENERALES
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                    aria-labelledby="headingOne">
                                    <div class="panel-body" style="padding:0px">
                                        <div class="form-group" style="margin-bottom:0px">
                                        <div class="alert alert-info" style="margin-bottom:0px">
                                            <label for="">Patologicos :</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->PATOLOGICO : "" ?></textarea><br>
                                            <label for="">No. Patologicos :</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->NO_PATOLOGICO : "" ?></textarea>
                                            <label for="">Heredo Familiares :</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->HEREDO_FAMILIARES : "" ?></textarea>
                                            <label for="">Quirúrgicos</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->QUIRURGICOS : "" ?></textarea>
                                            <label for="">Gineco-obstetricos</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->QUIRURGICOS : "" ?></textarea>
                                            <label for="">alergias</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->ALERGIAS : "" ?></textarea>
                                            <label for="">Medicamentos</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->MEDICAMENTOS : "" ?></textarea>
                                            <label for="">PRENATALES</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->PRENATALES : "" ?></textarea>
                                            <label for="">Perinatales</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->PERINATALES : "" ?></textarea>
                                            <label for="">Posnatales</label>
                                            <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                                placeholder="Escribe aquí.."><?= count($Antecedentes) > 0 ? $Antecedentes->POSNATALES : "" ?></textarea>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>-->

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class="col-sm-12 col-mdx-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="">Hora ingreso</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                            <input type="time" class="form-control" value="<?= date("H:i"); ?>"
                                                name="RG_HR_FICHA">
                                        </div>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Selecciona procedimiento</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i
                                                    class="fas fa-procedures"></i></span>
                                            <select class="form-control" name="RG_TIPO_CONSULTA"
                                                id="SELECT_TIPO_CONSULTA" required>
                                                <option value="" disabled selected>Seleccionar...</option>
                                                <?php
                                                    foreach ($TipoConsu as $row) {
                                                        $id = $row['id_tipo_consulta'];
                                                        $nombre = $row['nombre_tipo_consulta'];
                                                        $selected = "";
                                                        if ($this->session->userdata('CAREYES_ID_ROL') == MEDICO && $this->session->userdata('CAREYES_ID_USUARIO') == $id)
                                                            $selected = "selected";
                                                        echo "<option value='$id' $selected>$nombre</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Fecha</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                            <input data-type="datepicker" readonly type="text" name="RG_FECHA_FICHA"
                                                class="form-control" value="<?= date("d/m/Y"); ?>" autocomplete="off">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-mdx-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="">Médico</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i
                                                    class="fas fa-user-md"></i></span>
                                            <select class="form-control" name="ID_MEDICO" id="" required>
                                                <option value="" disabled selected>Elige un médico</option>
                                                <?php
                                                        foreach ($Medicos as $row) {
                                                            $id = $row['ID_USUARIO'];
                                                            $nombre = $row['NOMBRE_USUARIO'];
                                                            $selected = "";
                                                            if ($this->session->userdata('CAREYES_ID_ROL') == MEDICO && $this->session->userdata('CAREYES_ID_USUARIO') == $id)
                                                                $selected = "selected";
                                                            echo "<option value='$id' $selected>$nombre</option>";
                                                        }
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <br>
                                    <h4 class="h3Antecedentes">FOTO PROTECCIÓN</h4>
                                </div>

                                <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <label class="control-label" for=" EXPOSICION_SOLAR">
                                            EXPOSICIÓN SOLAR:
                                        </label>
                                    </div>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <input class="form-check-input" type="checkbox" name="EXPOSICION_SOLAR_SI"
                                            id="EXPOSICION_SOLAR_SI">
                                        <label class="form-check-label" for="EXPOSICION_SOLAR_SI">
                                            SI
                                        </label>
                                    </div>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <input class="form-check-input" type="checkbox" name="EXPOSICION_SOLAR_NO"
                                            id="EXPOSICION_SOLAR_NO">
                                        <label class="form-check-label" for="EXPOSICIÓN_SOLAR_NO">
                                            NO
                                        </label>
                                    </div>
                                    <div class="col-sm-6 col-mdx-6 col-lg-6">
                                        <label class="control-label text-left"> TIEMPO DE EXPOSICIÓN SOLAR:</label>
                                        <textarea class="form-control" name="TIEMPO_EXPOSICION_SOLAR"
                                            placeholder="Escribe aquí.." rows="1"></textarea>
                                    </div>
                                </div>

                                <div class=" row col-sm-12 col-mdx-12 col-lg-12"><br>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <label class="control-label" for=" USO_PROTECTOR_SOLAR">
                                            USO DE PROTECCIÓN SOLAR:
                                        </label>
                                    </div>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <input class="form-check-input" type="checkbox" name="USO_PROTECTOR_SOLAR_SI"
                                            id="USO_PROTECTOR_SOLAR_SI">
                                        <label class="form-check-label" for="USO_PROTECTOR_SOLAR_SI">
                                            SI
                                        </label>
                                    </div>
                                    <div class="col-sm-2 col-mdx-2 col-lg-2">
                                        <input class="form-check-input" type="checkbox" name="USO_PROTECTOR_SOLAR_NO"
                                            id="USO_PROTECTOR_SOLAR_NO">
                                        <label class="form-check-label" for="USO_PROTECTOR_SOLAR_NO">
                                            NO
                                        </label>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <label class="control-label text-left">MARCA PROTECTOR SOLAR:</label>
                                        <textarea class="form-control" name="MARCA_PROTECTOR_SOLAR"
                                            placeholder="Escribe aquí.." rows="1"></textarea>
                                    </div>
                                    <div class="col-sm-3 col-mdx-3 col-lg-3">
                                        <label class="control-label text-left">FPS:</label>
                                        <textarea class="form-control" name="FPS_PROTECTOR_SOLAR"
                                            placeholder="Escribe aquí.." rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <h4 class="h3Antecedentes">MOTIVO DE CONSULTA</h4>
                                </div>

                                <div class="form-check">
                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ENVEJECIMIENTO_CUTANEO">
                                                Envejecimiento Cutáneo
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="ENVEJECIMIENTO_CUTANEO" id="ENVEJECIMIENTO_CUTANEO">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="RITIDES">
                                                Ritides (Arrugas)
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="RITIDES" id="RITIDES">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="BRUXISMO">
                                                Bruxismo
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="BRUXISMO"
                                                id="BRUXISMO">
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ADIP_LOCALIZADA">
                                                Adiposidad Localizada
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ADIP_LOCALIZADA"
                                                id="ADIP_LOCALIZADA">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ESTRIAS">
                                                Estrías
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ESTRIAS" id="ESTRIAS">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="VARICES">
                                                Várices
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="VARICES" id="VARICES">
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="HIPERMEGTACION">
                                                Hiperpigmentación
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HIPERMEGTACION"
                                                id="HIPERMEGTACION">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ALOPECIA">
                                                Alopecia
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ALOPECIA"
                                                id="ALOPECIA">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="VERRUGAS">
                                                Verrugas
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="VERRUGAS"
                                                id="VERRUGAS">
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="FLACIDEZ_CUTANEA">
                                                Flacidez Cutánea
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="FLACIDEZ_CUTANEA"
                                                id="FLACIDEZ_CUTANEA">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ACNE">
                                                Acné
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ACNE" id="ACNE">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="PEFE">
                                                PEFE (Celulitis)
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="PEFE" id="PEFE">
                                        </div>
                                    </div>

                                    <div class=" row col-sm-12 col-mdx-12 col-lg-12">
                                        <br>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="CICATRICES">
                                                Cicatrices
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="CICATRICES"
                                                id="CICATRICES">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="ROSACEA">
                                                Rosácea
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="ROSACEA" id="ROSACEA">
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <label class="control-label" for="HIPERHIDROSIS">
                                                Hiperhidrosis
                                            </label>
                                        </div>
                                        <div class="col-sm-2 col-mdx-2 col-lg-2">
                                            <input class="form-check-input" type="checkbox" name="HIPERHIDROSIS"
                                                id="HIPERHIDROSIS">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-mdx-12 col-lg-12">
                                        <label class="control-label text-left">OTROS:</label>
                                        <textarea class="form-control" name="OTROS_MOTIVO_CONSULTA"
                                            placeholder="Escribe aquí.." rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-mdx-12 col-lg-12">
                                    <h4 class="h3Antecedentes">TRATAMIENTOS ESTÉTICOS PREVIOS</h4>
                                </div>

                                <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">PROCEDIMIENTO</label>
                                    </div>
                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">PRODUCTO / MARCA</label>
                                    </div>
                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">FECHA DE APLICACIÓN</label>
                                    </div>
                                </div>

                                <!-- Container for dynamic rows -->
                                <div id="tratamientos_previos_container" class="row col-sm-12 col-mdx-12 col-lg-12">
                                    <!-- Rows will be added here dynamically -->
                                </div>

                                <!-- Button to add new row -->
                                <div class="row col-sm-12 col-mdx-12 col-lg-12 mt-2">
                                    <br>
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-info btn-sm" id="add_tratamiento_row">
                                            <i class="fas fa-plus-circle"></i> Agregar Tratamiento
                                        </button>
                                    </div>
                                </div>

                                <!-- Otros field -->
                                <div class="col-sm-12 col-mdx-12 col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label class="control-label text-left">Otros</label>
                                        <textarea class="form-control" name="OTROS_TRATAMIENTOS_ESTETICOS"
                                            id="OTROS_TRATAMIENTOS_ESTETICOS" placeholder="Escribe aquí.."
                                            rows="5"></textarea>
                                    </div>
                                </div>

                                

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes"> EXPLORACIÓN FÍSICA</h4>
                            </div>

                            <!-- FITZPATRICK -->
                            <div class="form-group">
                                <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">FITZPATRICK:</label><br>
                                        <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <input class="form-check-input" type="radio" name="FITZPATRICK"
                                            id="FITZPATRICK_<?php echo $i; ?>" value="<?php echo $i; ?>">
                                        <label class="form-check-label" for="FITZPATRICK_<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </label>
                                        <?php endfor; ?>
                                    </div>

                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">GLOGAU:</label><br>
                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <input class="form-check-input" type="radio" name="GLOGAU"
                                            id="GLOGAU_<?php echo $i; ?>" value="<?php echo $i; ?>">
                                        <label class="form-check-label" for="GLOGAU_<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </label>
                                        <?php endfor; ?>
                                    </div>

                                    <div class="col-sm-4 col-mdx-4 col-lg-4">
                                        <label class="control-label">TIPO DE PIEL:</label><br>
                                        <input class="form-check-input" type="radio" name="TIPO_PIEL"
                                            id="TIPO_PIEL_MIXTA" value="MIXTA">
                                        <label class="form-check-label" for="TIPO_PIEL_MIXTA">MIXTA</label>
                                        <input class="form-check-input" type="radio" name="TIPO_PIEL"
                                            id="TIPO_PIEL_SECA" value="SECA">
                                        <label class="form-check-label" for="TIPO_PIEL_SECA">SECA</label>
                                        <input class="form-check-input" type="radio" name="TIPO_PIEL"
                                            id="TIPO_PIEL_GRASA" value="GRASA">
                                        <label class="form-check-label" for="TIPO_PIEL_GRASA">GRASA</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <label class="control-label">TIPO DE ROSTRO:</label><br>

                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_OVALADO" value="OVALADO">
                                    <label class="form-check-label" for="TIPO_ROSTRO_OVALADO">OVALADO</label>
                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_RECTANGULAR" value="RECTANGULAR">
                                    <label class="form-check-label" for="TIPO_ROSTRO_RECTANGULAR">RECTANGULAR</label>
                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_REDONDO" value="REDONDO">
                                    <label class="form-check-label" for="TIPO_ROSTRO_REDONDO">REDONDO</label>
                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_CUADRADO" value="CUADRADO">
                                    <label class="form-check-label" for="TIPO_ROSTRO_CUADRADO">CUADRADO</label>
                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_TRIANGULAR" value="TRIANGULAR">
                                    <label class="form-check-label" for="TIPO_ROSTRO_TRIANGULAR">TRIANGULAR</label>
                                    <input class="form-check-input" type="radio" name="TIPO_ROSTRO"
                                        id="TIPO_ROSTRO_DIAMANTE" value="DIAMANTE">
                                    <label class="form-check-label" for="TIPO_ROSTRO_DIAMANTE">DIAMANTE</label>
                            </div>


                            <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label"> LESIONES DERMATOLÓGICAS:</label>
                                </div>
                                <div class="col-sm-9 col-mdx-9 col-lg-9">
                                    <textarea class="form-control" name="LESIONES_DERMATOLOGICAS"
                                        id="LESIONES_DERMATOLOGICAS" placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>
                            <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label"> TIPO:</label>
                                </div>
                                <div class="col-sm-9 col-mdx-9 col-lg-9">
                                    <textarea class="form-control" name="TIPO_DERMATOLOGICAS" id="TIPO_DERMATOLOGICAS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>

                            <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label"> LOCALIZACIÓN:</label>
                                </div>
                                <div class="col-sm-9 col-mdx-9 col-lg-9">
                                    <textarea class="form-control" name="LOCALIZACION_DERMATOLOGICAS"
                                        id="LOCALIZACION_DERMATOLOGICAS" placeholder="Escribe aquí.."
                                        rows="1"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes"> HABITUS EXTERIOR</h4>
                            </div>

                            <div class="row col-sm-12 col-mdx-12 col-lg-12">
                                <br>
                                <div class="col-sm-3 col-mdx-3 col-lg-3">
                                    <label class="control-label"> CONDICIÓN DEL PACIENTE:</label>
                                </div>
                                <div class="col-sm-9 col-mdx-9 col-lg-9">
                                    <textarea class="form-control" name="CONDICION_PACIENTE" id="CONDICION_PACIENTE"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>

                            <div class="row col-sm-12 col-mdx-12 col-lg-12 "> <br>
                                <div class="col-sm-4 col-mdx-4 col-lg-4 d-flex">

                                    <label class="control-label">CONSTITUCIÓN:</label>

                                    <textarea class="form-control" name="CONSTITUCION_HABITUS" id="CONSTITUCION_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>

                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">CONFORMACIÓN:</label>
                                    <textarea class="form-control" name="CONFORMACION_HABITUS" id="CONFORMACION_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>

                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">ACTITUD:</label>
                                    <textarea class="form-control" name="ACTITUD_HABITUS" id="ACTITUD_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>

                            <div class="row col-sm-12 col-mdx-12 col-lg-12"> <br>
                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">FACIES:</label>
                                    <textarea class="form-control" name="FACIES_HABITUS" id="FACIES_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>

                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">MOVIMIENTOS ANORMALES:</label>
                                    <textarea class="form-control" name="MOVIMIENTOS_ANORMALES_HABITUS"
                                        id="MOVIMIENTOS_ANORMALES_HABITUS" placeholder="Escribe aquí.."
                                        rows="1"></textarea>
                                </div>

                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">MARCHA:</label>
                                    <textarea class="form-control" name="MARCHA_HABITUS" id="MARCHA_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>

                            <div class="row col-sm-12 col-mdx-12 col-lg-12"> <br>
                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">ESTADO DE CONSCIENCIA:</label>
                                    <textarea class="form-control" name="ESTADO_CONCIENCIA_HABITUS"
                                        id="ESTADO_CONCIENCIA_HABITUS" placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>

                                <div class="col-sm-4 col-mdx-4 col-lg-4">
                                    <label class="control-label">OTROS:</label>
                                    <textarea class="form-control" name="OTROS_HABITUS" id="OTROS_HABITUS"
                                        placeholder="Escribe aquí.." rows="1"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes"> SIGNOS VITALES:</h4>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="col-lg-4 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">FC</label>
                                        <textarea class="form-control" name="RG_FC_CONSULTA" id="FC" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">FR</label>
                                        <textarea class="form-control" name="RG_FR_CONSULTA" id="FR" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">TA</label>
                                        <textarea class="form-control" name="RG_TA_CONSULTA" id="RG_TA_CONSULTA"
                                            rows="2" placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">Temp.</label>
                                        <textarea class="form-control" name="RG_TEMP_CONSULTA" id="TEMP" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">PESO</label>
                                        <textarea class="form-control" name="RG_PESO_CONSULTA" id="RC" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>


                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">TALLA</label>
                                        <textarea class="form-control" name="RG_TALLA_CONSULTA" id="TALLA" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">IMC</label>
                                        <textarea class="form-control" name="RG_IMC_CONSULTA" id="GC" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <h4 class="h3Antecedentes"> LABORATORIOS</h4>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="col-12-4 col-sm-12 col-mdx-12">
                                    <div class="form-group">
                                        <label for="">LABORATORIOS A SOLICITAR</label>
                                        <textarea class="form-control" name="RG_LABORATORIOS" id="LS" rows="2"
                                            placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-mdx-12">
                                    <div class="form-group">
                                        <label for="">IMPRESIÓN DIAGNÓSTICA</label>
                                        <textarea class="form-control" name="RG_LABORATORIOS_I_DIAGNOSTICA" id="LID"
                                            rows="2" placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!--  <div class="col-sm-12 col-mdx-12 col-lg-3">
                               <div class="form-group">
                                  <label for="">Condición</label>
                                  <div class="input-group">
                                     <span class="input-group-addon"><i class="fas fa-user-injured"></i></span>
                                     <input type="text" class="form-control" placeholder="Escribe aquí.."
                                        name="RG_CONDICION_CONSULTA"  >
                                  </div>
                               </div>
                               <div class="help-block with-errors"></div>
                            </div> -->
                        <!--<div class="col-sm-12 col-mdx-12 col-lg-6">
                        <div class="form-group">
                           <label for="">Origen</label>
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-file-signature"></i></span>
                              <input type="text" class="form-control" placeholder="Escribe aquí.."
                                 name="RG_ORIGEN_CONSULTA">
                           </div>
                        </div>
                        <div class="help-block with-errors"></div>
                     </div>

                     
                     </div>
                     <?php
                            $valida = 0;
                            if ($ID_TARIFA) {
                                $valida = 1;
                                $readonlyx = "";
                                ?>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <div class="form-group">
                           <label for="">Tarifa</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">
                                 <i class="fas fa-dollar-sign"></i>
                              </span>
                              <input type="hidden" id="PORCENTAJE_TARIFA" value="<?= $Tarifas->PORCENTAJE_TARIFA; ?>">
                              <select class="form-control" id="SELECT_TARIFA" name="ID_TARIFA" required>
                                 <option value="" disabled selected>Elige una Tarifa</option>
                                 <?php
                                                foreach ($AllTarifas as $row) {
                                                    $id = $row['ID_TARIFA'];
                                                    $percent = $row['PORCENTAJE_TARIFA'];
                                                    $nombre = $row['NOMBRE_TARIFA'];
                                                    $PrecioConsulta = $row['CONSULTA_TARIFA'];
                                                    $selected = "";
                                                    if ($ID_TARIFA == $id)
                                                        $selected = "selected";
                                                    echo "<option data-percent='$percent' data-precioconsulta='$PrecioConsulta' data-nombre='$nombre' value='$id' $selected>$nombre</option>";
                                                }
                                                ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <?php
                            }
                            if ($ID_MEMBRESIA) {
                                $valida = 1;
                                $readonlyx = "readonly";
                                ?>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <div class="form-group">
                           <label for="">Membresia</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">
                                 <i class="fas fa-credit-card"></i>
                              </span>
                              <?php
                                            $nombre_membresia = $Membresia->NOMBRE_MEMBRESIA;
                                            $ide_membresia = $Membresia->ID_MEMBRESIA;
                                            ?>
                              <input type="hidden" id="ID_MEMBRESIA" name="ID_MEMBRESIA" value="<?= $ide_membresia ?>">
                              <input type="text" class="form-control" readonly value="<?= $nombre_membresia ?>"
                                 placeholder="Escribe aquí..">
                           </div>
                        </div>
                     </div>
                     <?php
                            }
                            if ($valida == 0) {
                                ?>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <label style="color:red;">Para asignar una tarifa o membresía "favor de editar el
                           paciente"</label>
                     </div>
                     <?php }
                            ?>
                     <?php if ($ID_CASA > 0): ?>
                     <div class="col-sm-12 col-mdx-6 col-lg-4">
                        <div class="form-group">
                           <label for="RG_ID_CASA" class="control-label text-left">Casa</label>
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-home"></i></span>
                              <?php
                                        $nombre_casa = $Casa->NOMBRE_CASA;
                                        $id_casa = $Casa->ID_CASA;
                                        ?>
                              <input type="hidden" id="ID_CASA" name="ID_CASA" value="<?= $id_casa ?>">
                              <input type="text" class="form-control" readonly value="<?= $nombre_casa ?>"
                                 placeholder="Escribe aquí..">
                           </div>
                        </div>
                     </div>
                     <?php endif; ?>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Motivo consulta :</label>
                           <textarea class="form-control" name="RG_MOTIVO_CONSULTA" id="MOTIVO" cols="10" rows=5
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Inicio & Evolución</label>
                           <textarea class="form-control" name="RG_INICIOEVOLUCION_CONSULTA" id="INICIOEVOLUCION"
                              cols="10" rows="5" placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>

                     <div class="col-lg-12 col-sm-12 col-mdx-12">
                        <label for="">Signos vitales</label><br>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">TA</label>
                              <textarea class="form-control" name="RG_SIGNOS_VITALES_CONSULTA" id="SIGNOS_VITALES"
                                 rows="2" placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">FC</label>
                              <textarea class="form-control" name="RG_FC_CONSULTA" id="FC" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">Ritmo Cardiaco</label>
                              <textarea class="form-control" name="RG_RITMO_CARDIACO_CONSULTA" id="RC" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">Temp.</label>
                              <textarea class="form-control" name="RG_TEMP_CONSULTA" id="TEMP" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-mdx-4">
                           <div class="form-group">
                              <label for="">FR</label>
                              <textarea class="form-control" name="RG_FR_CONSULTA" id="FR" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-mdx-4">
                           <div class="form-group">
                              <label for="">Sat. O2</label>
                              <textarea class="form-control" name="RG_SAT_CONSULTA" id="SAT" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-12 col-sm-4 col-mdx-4">
                           <div class="form-group">
                              <label for="">Glicemia Capilar</label>
                              <textarea class="form-control" name="RG_GLICEMIA_CAPILAR_CONSULTA" id="GC" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                     </div>-->
                        <!--consulta pediatrica-->

                        <!--<div class="col-lg-12 col-sm-12 col-mdx-12">
                        <label for="">Somatometría</label><br>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">PESO</label>
                              <textarea class="form-control" name="RG_PESO_CONSULTA" id="PESO" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">TALLA</label>
                              <textarea class="form-control" name="RG_TALLA_CONSULTA" id="TALLA" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">PC</label>
                              <textarea class="form-control" name="RG_PC_CONSULTA" id="PC" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-3 col-mdx-3">
                           <div class="form-group">
                              <label for="">PA</label>
                              <textarea class="form-control" name="RG_PA_CONSULTA" id="PA" rows="2"
                                 placeholder="Escribe aquí.."></textarea>
                           </div>
                        </div>
                     </div>

                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Diagnóstico Presuntivo</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_DIAGNOSTICO_CONSULTA"
                              id="DIAGNOSTICO" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Exploración Física</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_EXPLORACION_FISICA"
                              id="EXPLORACION" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">DESARROLLO PSICOMOTOR</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_DESARROLLO_PSICOMOTOR"
                              id="DESARROLLO_PSICOMOTOR" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class=" form-group">
                           <label for="">Manejo intrahospitalario:</label>
                           <textarea placeholder="Escribe aquí.." class="form-control"
                              name="RG_MANEJO_INTRAHOSPITALARIO_CONSULTA" id="MANEJO_INTRAHOSPITALARIO_CONSULTA"
                              cols="10" rows="5"></textarea>
                        </div>
                     </div>

                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Tratamiento</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_TRATAMIENTO_CONSULTA"
                              id="TRATAMIENTO" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Evolución</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_EVOLUCION_CONSULTA"
                              id="EVOLUCION" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <div class="form-group">
                           <label for="">Observaciones</label>
                           <textarea placeholder="Escribe aquí.." class="form-control" name="RG_OBSERVACION_CONSULTA"
                              id="EVOLUCION" cols="10" rows="5"></textarea>
                        </div>
                     </div>
                  </div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>
</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12 row-proce">
                    <div class="head modal-headx">
                        <span class="text-center">PROCEDIMIENTOS</span>
                        <button type="button" class="btn btn-info button-head modal-proced"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th width="40%">Nombre</th>
                                <th width="20%">Cantidad</th>
                                <th width="20%">Precio</th>
                                <th width="20%"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody id='tbody_procedimientos'>
                        </tbody>
                    </table>
                    <div id='div_msj'>
                        <div id="msj_temp" class="alert alert-warning"> No se han agregado procedimientos..
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 row-material">
                    <div class="head">
                        <span class="text-center">MATERIAL & MEDICAMENTOS</span>
                        <button type="button" class="btn btn-info button-head modal-product"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th width="30%">Nombre</th>
                                <th width="15%">Cantidad</th>
                                <th width="15%">Precio</th>
                                <th width="10%"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody id='tbody_productos'>

                        </tbody>
                    </table>
                    <div id='div_msj2'>
                        <div id="msj_temp2" class="alert alert-warning"> No se han agregado medicamentos..</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <?php if ($ID_MEMBRESIA > 0): ?>
                <div class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                <!--  DESC. POR --> MEMBRESIA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                                        <input type="text" class="form-control numeric" placeholder="0"
                                            value="<?= $nombre_membresia ?>" readonly id="MEMBRESIA_NAME"
                                            name="MEMBRESIA_NAME">
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-usd-circle fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                <span>TOTAL A PAGAR</span>
                            </p>

                            <h3 class="jss956"><br>
                                <div class="col-lg-12 p-none">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                    class="fas fa-hand-holding-usd"></i></span>
                                            <input type="text" id="TOTAL_FINAL" class="form-control" placeholder="Total"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($ID_TARIFA > 0):?>
                <div hidden class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <span class="fz19 f-bold"> <i class="fas fa-file-signature"></i></span>
                            </div>
                            <p class="jss959 fz-13">
                                PRECIO CONSULTA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <?php $readonly = ($ID_TARIFA) ? "" : "readonly"; ?>
                                        <input type="text" id="PRECIO_CONSULTA" name="PRECIO_CONSULTA"
                                            onClick="this.setSelectionRange(0, this.value.length)"
                                            class="form-control text-right" <?= $readonly ?>
                                            value="<?= $Tarifas->CONSULTA_TARIFA; ?>">
                                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <div hidden class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <span class="fz19 f-bold" id="NOMBRE_TARIFA"> <?= $Tarifas->NOMBRE_TARIFA; ?> </span>
                            </div>
                            <p class="jss959 fz-13">
                                DESC. POR TARIFA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <?php $readonly = ($ID_TARIFA) ? "" : "readonly"; ?>
                                        <input type="text" id="DESC_TARIFA" name="DESC_TARIFA"
                                            onClick="this.setSelectionRange(0, this.value.length)"
                                            class="form-control text-right" <?= $readonly ?>
                                            value="<?= $Tarifas->PORCENTAJE_TARIFA; ?>">
                                        <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-2rem">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <h3 class="jss956">
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group d-inline-block">
                                            <label for="TOTAL">Subtotal</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="fas fa-dollar-sign"></i></span>
                                                <input type="text" id="TOTAL" class="form-control text-center"
                                                    placeholder="subtotal" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group d-inline-block">
                                            <label for="DESCUENTO_TOTAL">DESCUENTO</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-minus"></i></span>
                                                <input type="text" id="DESCUENTO_TOTAL" class="form-control text-center"
                                                    placeholder="desc" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="TOTAL_FINAL">Total</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="fas fa-hand-holding-usd"></i></span>
                                                <input type="text" id="TOTAL_FINAL_T" class="form-control text-center"
                                                    placeholder="total" readonly>
                                                <span class="input-group-addon c-u">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-lg-12 mb-2rem">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-usd-circle fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                <span>TOTAL PAGADO</span>
                            </p>

                            <h3 class="jss956"><br>
                                <div class="col-lg-12 p-none">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i
                                                    class="fas fa-hand-holding-usd"></i></span>
                                            <input type="text" id="TOTAL_PAGADO" name="RG_TOTAL_PAGADO_CONSULTA"
                                                class="form-control" placeholder="Total Pagado">
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="text-center">
        <hr>
            <a href="<?= base_url('Patient/index'); ?>" class="btn btnx btn-cancel">
            <i class="fas fa-chevron-double-left"></i> Volver a pacientes
        </a>      
          <button type="submit" class="btn btn-info btnx">
            registrar consulta <i class="fas fa-check"></i>
        </button>
        </form>
    </div>
</div><br>
<script>
$(document).ready(function() {
    // Exclusividad para EXPOSICIÓN SOLAR
    $('#EXPOSICION_SOLAR_SI').on('change', function() {
        if (this.checked) {
            $('#EXPOSICION_SOLAR_NO').prop('checked', false);
        }
    });

    $('#EXPOSICION_SOLAR_NO').on('change', function() {
        if (this.checked) {
            $('#EXPOSICION_SOLAR_SI').prop('checked', false);
        }
    });

    // Exclusividad para USO DE PROTECCIÓN SOLAR
    $('#USO_PROTECTOR_SOLAR_SI').on('change', function() {
        if (this.checked) {
            $('#USO_PROTECTOR_SOLAR_NO').prop('checked', false);
        }
    });

    $('#USO_PROTECTOR_SOLAR_NO').on('change', function() {
        if (this.checked) {
            $('#USO_PROTECTOR_SOLAR_SI').prop('checked', false);
        }
    });

    // Available treatments
    const tratamientos = <?php echo json_encode($tratamientos); ?>;
    let rowIndex = 0;

    // Function to generate select options, excluding selected treatments
    function getSelectOptions(exclude = [], include = null) {
        let options = '<option value="" selected disabled>Selecciona un tratamiento</option>';
        $.each(tratamientos, function(key, value) {
            if (!exclude.includes(key) || key === include) {
                options += `<option value="${key}">${value}</option>`;
            }
        });
        return options;
    }

    // Function to add a new row
    function addTratamientoRow() {
        // Get currently selected treatments
        let selectedTreatments = [];
        $('.tratamiento-select').each(function() {
            let val = $(this).val();
            if (val) selectedTreatments.push(val);
        });

        // Generate HTML for new row
        let rowHtml = `
            <div class="row tratamiento-row mb-2" data-index="${rowIndex}">
                <br><div class="col-sm-4 col-mdx-4 col-lg-4">
                    <select class="form-control tratamiento-select" 
                            name="TRATAMIENTOS[${rowIndex}][PROCEDIMIENTO]" required>
                        ${getSelectOptions(selectedTreatments)}
                    </select>
                </div>
                <div class="col-sm-4 col-mdx-4 col-lg-4">
                    <textarea class="form-control" 
                             name="TRATAMIENTOS[${rowIndex}][PRODUCTO]" 
                             placeholder="Escribe aquí.." 
                             rows="1"></textarea>
                </div>
                <div class="col-sm-3 col-mdx-3 col-lg-3">
                    <input type="text" 
                           class="form-control datepicker" 
                           name="TRATAMIENTOS[${rowIndex}][FECHA]" value="<?= date("d/m/Y"); ?>"
                           placeholder="Selecciona fecha" 
                           readonly>
                </div>
                <div class="col-sm-1 col-mdx-1 col-lg-1">
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        // Append row to container
        $('#tratamientos_previos_container').append(rowHtml);

        // Initialize datepicker for the new row
        $(`[data-index="${rowIndex}"] .datepicker`).datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            language: 'es'
        });

        // Increment row index
        rowIndex++;
    }

    // Handle add row button click
    $('#add_tratamiento_row').on('click', function() {
        addTratamientoRow();
    });

    // Handle treatment selection change to update available options
    $(document).on('change', '.tratamiento-select', function() {
        let currentSelect = $(this);
        let currentVal = currentSelect.val();

        // Store all current selections
        let selections = {};
        $('.tratamiento-select').each(function() {
            let select = $(this);
            selections[select.closest('.tratamiento-row').data('index')] = select.val() || '';
        });

        // Get currently selected treatments, excluding the current select
        let selectedTreatments = [];
        $('.tratamiento-select').not(currentSelect).each(function() {
            let val = $(this).val();
            if (val) selectedTreatments.push(val);
        });

        // Update options for each select
        $('.tratamiento-select').each(function() {
            let select = $(this);
            let index = select.closest('.tratamiento-row').data('index');
            let selectedVal = selections[index]; // Use stored selection

            // Determine which treatments to exclude
            let excludeList = selectedVal ? selectedTreatments.concat(selectedVal) :
                selectedTreatments;
            if (select.is(currentSelect)) {
                excludeList = selectedTreatments; // Current select should include its own value
            }

            // Update options
            select.html(getSelectOptions(excludeList, selectedVal));
            select.val(selectedVal); // Restore selected value
        });
    });

    // Handle row removal
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.tratamiento-row').remove();
        // Trigger change to update select options
        $('.tratamiento-select').first().trigger('change');
    });

    // Form validation
    $('#NEW_CONSULT').on('submit', function(e) {
        let isValid = true;
        $('.tratamiento-row').each(function() {
            let select = $(this).find('.tratamiento-select');
            let textarea = $(this).find('textarea');
            let date = $(this).find('.datepicker');
            if (!select.val() || !textarea.val() || !date.val()) {
                isValid = false;
                $(this).addClass('has-error');
            } else {
                $(this).removeClass('has-error');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Por favor, completa todos los campos en los tratamientos previos.');
        }
    });
});
</script>

<div class="modal animated faster" role="dialog" aria-hidden="true" id="modal">
    <div class="modal-dialog modal-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <span class="modal-title">Agregar Procedimientos</span>
                <button type="button" class="close" data-custom-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="">
                            <div class="form-group mb-0">
                                <label for="">Buscar</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                                    <select style="width:100%" name="SEARCH_PROCEDIMIENTO"
                                        class="form-control js-example-basic-single" id="SEARCH_PROCEDIMIENTO">
                                        <option value="" selected disabled>Elige</option>
                                        <?php
                                        foreach ($Procedimientos as $procs) {
                                            $name = $procs['descripcion_procedimiento'];
                                            echo "<option value='$name'>$name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="row hidex" id="div_costo">
                            <input type='hidden' id="id_proc" name='id_proc' value=''>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <label><i class="fas fa-layer-plus"></i>  <span class="label_desc"
                                        id="proc_select"></span></label>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button"
                                            id="minus_ficha_proc"> <i class="fas fa-minus"></i></button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cantidad" id="proc_cant">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button"
                                            id="add_ficha_proc"><i class="fas fa-plus"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->

                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <span class="btn btn-default btns-grouped"> <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input readonly type="text" class="form-control" id="proc_costo"
                                        onClick="this.setSelectionRange(0, this.value.length)">
                                    <span class="input-group-addon c-u">c/u</span>
                                </div>
                            </div><!-- /.col-lg-6 -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="SUBMIT_PROCEDIMIENTO" type="button" class="btn btn-success btn-mobile-sm">Agregar</button>
                <button type="button" class="btn btn-secondary btn-mobile-sm"
                    data-custom-dismiss="modal">Cerrar</button>

                <div id='msj_vacio'
                    class="col-lg-6 col-sm-5 col-mdx-6 hidex alertx animated shake faster alert-danger btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i>  Selecciona un Procedimiento
                </div>
                <div id='msj_cant'
                    class="col-lg-6 col-sm-5 col-mdx-6 hidex alertx animated shake faster alert-danger btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i>  Cantidad debe ser mayor a 0
                </div>
                <div id='msj_success'
                    class="text-center col-lg-6 col-sm-5 col-mdx-6 hidex animated zoomIn faster btn-mobile-sm">
                    <div class="col-lg-12 p-none alertx alert-success ml--15">
                        <i class="fas fa-check"></i>  Se agregó correctamente
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal animated faster" role="dialog" aria-hidden="true" id="modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <span class="modal-title">Agregar Productos</span>
                <button type="button" class="close" data-custom-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" style="margin-bottom:0px">
                            <label for="">Buscar</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-search"></i></span>
                                <select style="width:100%" name="SEARCH_PRODUCTO"
                                    class="form-control js-example-basic-single" id="SEARCH_PRODUCTO">
                                    <option value="" selected disabled>Elige</option>
                                    <?php
                                    foreach ($Productos as $procs) {
                                        $name = $procs['NOMBRE_PRODUCTO'];
                                        $code = $procs['CODIGO_PRODUCTO'];
                                        echo "<option value='$name'> " . $name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row" style="display:none;" id="div_producto">
                            <input type='hidden' id="id_producto" name='id_producto' value=''>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <label style="font-weight:500" for=""><i class="fas fa-layer-plus">  </i><span
                                        class="label_desc" id="product_select"></span></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button"
                                            id="minus_ficha_product"> <i class="fas fa-minus"></i></button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cantidad" id="producto_cant">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button"
                                            id="add_ficha_product"><i class="fas fa-plus"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <span class="btn btn-default btns-grouped"> <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" onClick="this.select();"
                                        id="producto_costo">
                                    <span class="input-group-addon c-u">c/u</span>

                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="SUBMIT_PRODUCTO" type="button" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-secondary" data-custom-dismiss="modal">Cerrar</button>

                <div id='msj_vacio2'
                    class="hidex col-lg-6 col-sm-5 col-mdx-6 alertx alert-danger animated shake fast btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i>  Selecciona un Procedimiento
                </div>
                <div id='msj_cant2'
                    class="hidex col-lg-6 col-sm-5 col-mdx-6 alertx alert-danger animated shake fast btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i>  Cantidad debe ser mayor a 0
                </div>

                <div id='msj_success2'
                    class=" hidex text-center col-lg-6 col-sm-5 col-mdx-6 animated zoomIn faster btn-mobile-sm">
                    <div class="col-lg-12 p-none alertx alert-success ml--15">
                        <i class="fas fa-check"></i>  Se agregó correctamente
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>