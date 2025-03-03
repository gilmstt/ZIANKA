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
</style>
<?php $CI = & get_instance(); ?>
<div class="container-fluid"><br>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-sm-12 col-lg-10">
            <div class="panel">
                <div class="panel-heading header-black">
                    <span class="heading-primary">NUEVA URGENCIA</span>
                </div>
                <div class="panel-body">
                    <form id="NEW_URGENCY" data-toggle="validator" method="post">
                        <div class="row">
                            <h3 class="h3-fichaConsumo" style="margin-top:-15px">  Registrar Paciente</h3>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Apellido Paterno</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" required placeholder="Escribe aquí.."
                                               name="RG_APELLIDO_PATERNO">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Apellido Materno</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control"  name="RG_APELLIDO_MATERNO"
                                               placeholder="Escribe aquí.." >
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" required name="RG_NOMBRE_PACIENTE"
                                               placeholder="Escribe aquí..">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Fecha de nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-calendar"></i></span>
                                        <input type="text" data-type="datepicker" required class="form-control"
                                               placeholder="Selecciona una fecha" autocomplete="off"
                                               pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}"
                                               name='RG_FECHA_NAC_PACIENTE' id="RG_FECHA_NAC_PACIENTE">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Sexo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-calendar"></i></span>
                                        <select name="RG_SEXO" id="" required class="form-control">
                                            <option value="" selected disabled>Elige una opción</option>
                                            <?php
                                            $Sexos = $CI->db->get('sexo')->result_array();
                                            foreach ($Sexos as $row):
                                                $id = $row['ID_SEXO'];
                                                $nombre = $row['NOMBRE_SEXO'];
                                                echo "<option value='$id'>$nombre</option>";
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
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
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
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
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
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
                        </div>
                        <div class="row">
                            <h3 class="h3-fichaConsumo" style="margin-top:0px">  Registrar Urgencia</h3>
                            <div class="col-sm-12 col-mdx-6 col-lg-3">
                                <div class="form-group">
                                    <label for="">Fecha Ingreso</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                        <input data-type="datepicker" required
                                               pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}" type="text"
                                               name="RG_FECHA_FICHA" class="form-control" value="<?php echo date("d/m/Y"); ?>"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="col-sm-12 col-mdx-6 col-lg-3">
                                <div class="form-group">
                                    <label for="">Hora ingreso</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                        <input type="time" required class="form-control" value="<?= date("H:i"); ?>"
                                               name="RG_HR_FICHA">
                                    </div>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="col-sm-12 col-mdx-12 col-lg-3">
                                <div class="form-group">
                                    <label for="">Origen</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-map"></i></span>
                                        <input type="text" class="form-control" placeholder="Escribe aquí.."
                                               name="RG_ORIGEN_URGENCIA">
                                    </div>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Médico</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-md"></i></span>
                                        <select class="form-control" name="ID_MEDICO" id="" required>
                                            <option value="" disabled selected>Elige un médico</option>
                                            <?php
                                            $Medicos = $CI->db->get_where('usuario', array('ID_ROL' => 4))->result_array();
                                            foreach ($Medicos as $row) {
                                                $id = $row['ID_USUARIO'];
                                                $nombre = $row['NOMBRE_USUARIO'];

                                                echo "<option value='$id'>$nombre</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
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

                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-4 col-lg-3">
                                <div class="form-group hidden" id="divTarifa">
                                    <label for="RG_ID_TARIFA" class="control-label text-left">Tarifa</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>

                                        <select required name="ID_TARIFA" id="ID_TARIFA" class="form-control">
                                            <option disabled selected value="">Elige una opción</option>

                                            <?php
                                            $Tarifas = $this->db->get('tarifa')->result_array();
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
                                <div class="form-group hidden" id="divMembresia">
                                    <label for="RG_ID_MEMBRESIA" class="control-label text-left">Membresía</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                                        <select required name="RG_ID_MEMBRESIA" id="ID_MEMBRESIA" class="form-control">
                                            <option disabled selected value="">Elige una opción</option>

                                            <?php
                                            $Membresias = $this->db->get_where('membresia', array('VIGENCIA_MEMBRESIA' => 1))->result_array();
                                            if (count($Membresias) > NULO):
                                                foreach ($Membresias as $ROW):
                                                    ?>
                                                    <option value="<?= $ROW['ID_MEMBRESIA'] ?>"><?= mb_strtoupper($ROW['NOMBRE_MEMBRESIA']) ?>
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
                            <div class="col-lg-3 col-sm-12 col-mdx-4">
                                <div class="form-group hidden" id="divPerfilMem">
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
                            <div class="col-lg-9 col-sm-12 col-mdx-12">
                                <div class="form-group">
                                    <label for="">Condición</label><br>
                                    <div class="col-lg-4 col-sm-4 col-mdx-4 p-left0">
                                        <input type="text" class="form-control" name="RG_CONDICION_URGENCIA" id="TRIAGE" readonly
                                               placeholder="Selecciona un color">
                                    </div>
                                    <div class="inline-flex">
                                        <div id="rojo" class="box" data-triage="I"></div>  
                                        <div id="naranja" class="box" data-triage="II"></div>  
                                        <div id="amarillo" class="box" data-triage="III"></div>  
                                        <div id="verde" class="box" data-triage="IV"></div>  
                                        <div id="azul" class="box" data-triage="V"></div>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="form-group">
                                    <label for="">Motivo urgencia :</label>
                                    <textarea required class="form-control" name="RG_MOTIVO_URGENCIA" id="MOTIVO" cols="10"
                                              rows="5" placeholder="Escribe aquí.."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="form-group">
                                    <label for="">Inicio & Evolución</label>
                                    <textarea class="form-control" name="RG_INICIOEVOLUCION_URGENCIA" id="INICIOEVOLUCION"
                                              cols="10" rows="5" placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <label for="">Signos vitales</label><br>
                                <div class="col-lg-3 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">TA</label>
                                        <textarea class="form-control" name="RG_SIGNOS_VITALES_URGENCIA" id="SIGNOS_VITALES" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">FC</label>
                                        <textarea class="form-control" name="RG_FC_URGENCIA" id="FC" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">Ritmo Cardiaco</label>
                                        <textarea class="form-control" name="RG_RITMO_CARDIACO_URGENCIA" id="RC" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-mdx-3">
                                    <div class="form-group">
                                        <label for="">Temp.</label>
                                        <textarea class="form-control" name="RG_TEMP_URGENCIA" id="TEMP" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">FR</label>
                                        <textarea class="form-control" name="RG_FR_URGENCIA" id="FR" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">Sat. O2</label>
                                        <textarea class="form-control" name="RG_SAT_URGENCIA" id="SAT" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-mdx-4">
                                    <div class="form-group">
                                        <label for="">Glicemia Capilar</label>
                                        <textarea class="form-control" name="RG_GLICEMIA_CAPILAR_URGENCIA" id="GC" rows="1"
                                                  placeholder="Escribe aquí.."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-mdx-12">
                                <div class="form-group">
                                    <label for="">Diagnóstico Presuntivo</label>
                                    <textarea placeholder="Escribe aquí.." class="form-control" name="RG_DIAGNOSTICO_URGENCIA"
                                              id="DIAGNOSTICO" cols="10" rows="5"></textarea>

                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class=" form-group">
                                    <label for="">Exploración Física</label>
                                    <textarea placeholder="Escribe aquí.." class="form-control" name="RG_EXPLORACION_FISICA"
                                              id="EXPLORACION" cols="10" rows="5"></textarea>
                                </div>      
                            </div>     
                            <div class="col-sm-12 col-mdx-12 col-lg-12"">
                                <div class=" form-group">
                                    <label for="">Manejo intrahospitalario:</label>
                                    <textarea placeholder="Escribe aquí.." class="form-control" name="RG_MANEJO_INTRAHOSPITALARIO_URGENCIA"
                                              id="RG_MANEJO_INTRAHOSPITALARIO_URGENCIA" cols="10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12"">
                                <div class=" form-group">
                                    <label for="">Tratamiento</label>
                                    <textarea placeholder="Escribe aquí.." class="form-control" name="RG_TRATAMIENTO_URGENCIA"
                                              id="TRATAMIENTO" cols="10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class=" form-group">
                                    <label for="">Evolución</label>
                                    <textarea placeholder="Escribe aquí.." class="form-control" name="RG_EVOLUCION_URGENCIA" id="EVOLUCION"
                                              cols="10" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class=" form-group">
                                    <label for="">DIAGNÓSTICO DE EGRESO</label>
                                    <textarea class="form-control" name="RG_DIAGNOSTICO_EGRESO" id="DIAGNOSTICO" rows="5"
                                              placeholder="Escribe aquí.." ></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class=" form-group">
                                    <label for="">OBSERVACIONES</label>
                                    <textarea  class="form-control" name="RG_OBSERVACION_URGENCIA" id="OBSERVACION" rows="5"
                                               placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <div class=" form-group">
                                    <label for="">Destino</label>
                                    <textarea class="form-control" name="RG_DESTINO" id="DESTINO" rows="5"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="col-lg-12 row-proce">
                    <div class="head">
                        <span class="text-center">PROCEDIMIENTOS</span>
                        <button type="button" id="BTN_OPEN_MODAL" class="btn btn-info button-head modal-proced_u"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Costo</th>
                                <th>Cantidad</th>
                                <th>*</th>
                            </tr>
                        </thead>
                        <tbody id='tbody_procedimientos'>
                        </tbody>
                    </table>
                    <div id='div_msj'>
                        <div id="msj_temp" class="alert alert-warning"> No se han agregado procedimientos..</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <div class="col-lg-12 row-material">
                    <div class="head">
                        <span class="text-center">MATERIAL & MEDICAMENTOS</span>
                        <button type="button" id="BTN_OPEN_MODAL2" class="btn btn-info button-head modal-product_u"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th id="onlyurgency" class="hidex"> Desc</th>
                                <th>Costo</th>
                                <th>Cantidad</th>
                                <th>*</th>
                            </tr>
                        </thead>
                        <tbody id='tbody_productos'>


                        </tbody>
                    </table>
                    <div id='div_msj2'>
                        <div id="msj_temp2" class="alert alert-warning"> No se han agregado productos..</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-mdx-12 col-sm-12 hidex" id="FOOTER_BY_MEMBRESIA">
            <div class="col-lg-6 col-mdx-4 col-sm-6 p-none">
                <div class="col-lg-6 col-lg-offset-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                MEMBRESIA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                                        <input type="text" class="form-control numeric" id="MEMBRESIA_NAME" name="RG_DESCUENTO"
                                               readonly>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-mdx-8 col-sm-12 p-none">
                <!-- <div class="col-lg-10">
                <div class="jss442 blue-x">
                   <div class="jss459 jss467 jss464 jss465">
                      <div class="jss473 jss474 bg-morado">
                         <i class="fas fa-usd-circle fa-3x"></i>
                      </div>
                      <p class="jss959 fz-13">
                         <span class="float-left">TOTAL</span>
                         <span>DESCUENTO</span>            
                         <span>TOTAL A PAGAR</span> 
                      </p>
 
 
                             <h3 class="jss956"><br>
                                 <div class="col-lg-12 p-none">
                                     <div class="form-group">
                                         <div class="input-group">
                                             <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                             <input type="text" id="TOTAL" class="form-control" placeholder="Total" readonly>
                                             <span class="input-group-addon"><i class="fas fa-minus"></i></span>
                                             <input type="text" id="DESCUENTO_TOTAL" class="form-control" placeholder="Desc"
                                                    readonly>
                                             <span class="input-group-addon"><i class="fas fa-hand-holding-usd"></i></span>
                                             <input type="text" id="TOTAL_FINAL" class="form-control" placeholder="Total" readonly>
                                         </div>
                                     </div>
                                 </div>
                             </h3>
                         </div>
                      </h3>
                   </div>
                </div>
             </div> -->
                <div class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-usd-circle fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                TOTAL A PAGAR
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                        <input type="text" id="TOTAL_FINAL" class="form-control" placeholder="Total" readonly>

                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-mdx-12 col-sm-12 hidex" id="FOOTER_BY_TARIFA">
            <div class="col-lg-6 p-none">
                <div class="col-lg-6">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <span class="fz19 f-bold"> <i class="fas fa-file-signature"></i></span>
                            </div>
                            <p class="jss959 fz-13">
                                PRECIO URGENCIA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">

                                        <input type="text" id="PRECIO_CONSULTA" 
                                               onClick="this.setSelectionRange(0, this.value.length)"
                                               class="form-control text-right"
                                               >
                                        <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
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
                                <span class="fz19 f-bold" id="SPAN_DESC_TARIFA">  </span>
                            </div>
                            <p class="jss959 fz-13">
                                DESC. POR TARIFA
                            </p>
                            <h3 class="jss956"><br>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="DESC_TARIFA" name="DESC_TARIFA" class="form-control text-right"
                                               value="" onClick="this.setSelectionRange(0, this.value.length)">
                                        <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 p-none">
                <div class="col-lg-10">
                    <div class="jss442 blue-x">
                        <div class="jss459 jss467 jss464 jss465">
                            <div class="jss473 jss474 bg-morado">
                                <i class="fas fa-usd-circle fa-3x"></i>
                            </div>
                            <p class="jss959 fz-13">
                                <span class="float-left">SUBTOTAL</span>
                                <span>DESCUENTO</span>            
                                <span>TOTAL A PAGAR</span> 
                            </p>

                            <h3 class="jss956"><br>
                                <div class="col-lg-12 p-none">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="text" id="TOTAL" class="form-control text-center"
                                                   placeholder="subtotal" readonly>
                                            <span class="input-group-addon"><i class="fas fa-minus"></i></span>
                                            <input type="text" id="DESCUENTO_TOTAL" class="form-control text-center"
                                                   placeholder="desc" readonly>
                                            <span class="input-group-addon"><i class="fas fa-hand-holding-usd"></i></span>
                                            <input type="text" id="TOTAL_FINAL_T" class="form-control text-center"
                                                   placeholder="total" readonly>
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 col-mdx-8 col-sm-12 p-none">
                <div class="col-lg-9">
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
                                            <span class="input-group-addon"><i class="fas fa-hand-holding-usd"></i></span>
                                            <input type="text" id="TOTAL_PAGADO" name="RG_TOTAL_PAGADO_URGENCIA" class="form-control" placeholder="Total Pagado" >
                                        </div>
                                    </div>
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>

        <div class="text-center">
            <hr class="mt-0">
                <a href="<?= base_url('Urgency/index'); ?>" class="btn btnx btn-cancel">
                <i class="fas fa-chevron-double-left"></i> Volver a urgencias
            </a>      
            <button type="submit" id="submit-urgency" class="btn btn-info btnx">
                registrar urgencia <i class="fas fa-check"></i>
            </button>
            </form>
        </div>
    </div>
</div>
<br>
<div class="modal fade" role="dialog" id="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <span class="modal-title">Agregar Procedimientos</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="">
                            <div class="form-group" style="margin-bottom:0px">
                                <label for="">Buscar</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>

                                    <select style="width:100%" name="SEARCH_PROCEDIMIENTO"
                                            class="form-control js-example-basic-single" id="SEARCH_PROCEDIMIENTO">
                                        <option value="" selected disabled>Elige</option>
                                        <?php
                                        $Procedimientos = $CI->db->get_where('procedimiento', array("activo_procedimiento" => 1))->result_array();
                                        foreach ($Procedimientos as $procs) {
                                            $name = $procs['descripcion_procedimiento'];

                                            echo "<option value='$name'>$name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form> <br>
                        <div class="row" style="display:none;" id="div_costo">
                            <input type='hidden' id="id_proc" name='id_proc' value=''>
                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <label><i class="fas fa-layer-plus"></i> <span class="label_desc"
                                                                               id="proc_select"></span></label>
                            </div><!-- /.col-lg--->
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button" id="minus_ficha_proc"> <i
                                                class="fas fa-minus"></i></button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cantidad" value="1" id="proc_cant">

                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button" id="add_ficha_proc"><i
                                                class="fas fa-plus"></i></button>
                                    </span>
                                </div>
                            </div><!-- /.col-lg--->
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <span class="btn btn-default btns-grouped"> <i class="fas fa-dollar-sign"></i> </span>
                                    </div>
                                    <input type="text" class="form-control" id="proc_costo"
                                           onClick="this.setSelectionRange(0, this.value.length)">
                                    <span class="input-group-addon c-u">c/u</span>
                                </div>
                            </div><!-- /.col-lg--->

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="SUBMIT_PROCEDIMIENTO" type="button" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div style="display:none" id='msj_vacio'
                     class="col-lg-6 col-sm-5 col-mdx-6 alert alertx alert-danger btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i>  Selecciona un Procedimiento
                </div>
                <div style="display:none" id='msj_cant_0'
                     class="col-lg-6 col-sm-5 col-mdx-6 alert alertx alert-danger btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i> Cantidad debe ser mayor a 1
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <span class="modal-title">Agregar Productos</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="">
                            <div class="form-group" style="margin-bottom:0px">
                                <label for="">Buscar</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>


                                    <select style="width:100%" name="SEARCH_PRODUCTO"
                                            class="form-control js-example-basic-single" id="SEARCH_PRODUCTO">
                                        <option value="" selected disabled>Elige</option>
                                        <?php
                                        $Productos = $CI->db->get_where('producto', array("ACTIVO_PRODUCTO" => 1))->result_array();
                                        foreach ($Productos as $procs) {
                                            $name = $procs['NOMBRE_PRODUCTO'];
                                            echo "<option value='$name'> " . $name . "</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </form> <br>
                        <div class="row" style="display:none;" id="div_producto">
                            <input type='hidden' id="id_producto" name='id_producto' value=''>

                            <div class="col-sm-12 col-mdx-12 col-lg-12">
                                <label style="font-weight:500" for="">Agregar: <span class="label_desc"
                                                                                     id="product_select"></span></label>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button" id="minus_ficha_product"> <i
                                                class="fas fa-minus"></i></button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cantidad" value="1"
                                           id="producto_cant">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btns-grouped" type="button" id="add_ficha_product"><i
                                                class="fas fa-plus"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <div class="col-lg-4 col-sm-6 col-mdx-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <span class="btn btn-default btns-grouped"> <i class="fas fa-dollar-sign"></i> </span>
                                    </div>
                                    <input type="text" class="form-control" id="producto_costo">
                                    <span class="input-group-addon c-u">c/u</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="SUBMIT_PRODUCTO" type="button" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div style="display:none" id='msj_vacio2'
                     class="col-lg-6 col-sm-5 col-mdx-6 btn-mobile-sm alert alertx alert-danger btn-mobile-sm"><i
                        class="fas fa-exclamation-circle"></i>  Selecciona un Procedimiento </div>
                <div style="display:none" id='msj_cant_2'
                     class="col-lg-6 col-sm-5 col-mdx-6 alert alertx alert-danger btn-mobile-sm">
                    <i class="fas fa-exclamation-circle"></i> Cantidad debe ser mayor a 1
                </div>
            </div>
        </div>
    </div>
</div>

