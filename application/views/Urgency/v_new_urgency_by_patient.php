<?php
$ID_TARIFA = (isset($row_user->ID_TARIFA)) ? $row_user->ID_TARIFA : 0;
$ID_MEMBRESIA = (isset($row_user->ID_MEMBRESIA)) ? $row_user->ID_MEMBRESIA : 0;

$CI = & get_instance();
$AllTarifas = $CI->db->get('tarifa')->result_array();
$Tarifas = $CI->db->get_where('tarifa', array('ID_TARIFA' => $ID_TARIFA))->row();
$Medicos = $CI->db->get_where('usuario', array('ID_ROL' => 4))->result_array();
$Productos = $CI->db->get_where('producto', array("ACTIVO_PRODUCTO" => 1))->result_array();
$Membresia = $CI->db->get_where('membresia', array('ID_MEMBRESIA' => $ID_MEMBRESIA))->row();
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

label {
   font-size: 14px;
   letter-spacing: 0.5px;
   text-transform: uppercase;
}

.form-control[disabled],
.form-control[readonly],
fieldset[disabled] .form-control {
   background-color: #b7bec133;
}
</style>
<div class="container-fluid"><br>
   <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-sm-12 col-lg-10">
         <div class="panel">
            <div class="panel-heading header-black">
               <span class="heading-primary">NUEVA URGENCIA PARA:
                  <span class="name-yellow">
                     <?= $row_user->NOMBRE_PACIENTE . " " . $row_user->APELLIDO_PATERNO_PACIENTE . " " . $row_user->APELLIDO_MATERNO_PACIENTE ?></span></span>
            </div>
            <div class="panel-body">
               <form data-toggle="validator" id="NEW_URGENCY" method="post">
                  <div class="row">
                     <input type="hidden" name="ID_PACIENTE" value="<?php echo $row_user->ID_PACIENTE ?>">
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
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
                                          <?php $not_exist = "No hay datos registrados"; ?>
                                          <label for="">Patologicos :</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $PATOLOGICO = ($Antecedentes->PATOLOGICO != "") ? $Antecedentes->PATOLOGICO : $not_exist; ?></textarea><br>
                                          <label for="">No. Patologicos :</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $NO_PATOLOGICO = ($Antecedentes->NO_PATOLOGICO != "") ? $Antecedentes->NO_PATOLOGICO : $not_exist; ?></textarea>
                                          <label for="">Quirúrgicos</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $QUIRURGICOS = ($Antecedentes->QUIRURGICOS != "") ? $Antecedentes->QUIRURGICOS : $not_exist; ?></textarea>
                                          <label for="">Gineco-obstetricos</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $OBSTETRICOS = ($Antecedentes->OBSTETRICOS != "") ? $Antecedentes->QUIRURGICOS : $not_exist; ?></textarea>
                                          <label for="">alergias</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $ALERGIAS = ($Antecedentes->ALERGIAS != "") ? $Antecedentes->ALERGIAS : $not_exist; ?></textarea>
                                          <label for="">Medicamentos</label>
                                          <textarea readonly class="form-control txt-antecedentes" cols="10" rows="5"
                                             placeholder="Escribe aquí.."><?= $MEDICAMENTOS = ($Antecedentes->MEDICAMENTOS != "") ? $Antecedentes->MEDICAMENTOS : $not_exist; ?></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <hr>
                     </div>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <label for="">Fecha Ingreso</label>
                        <div class="form-group">
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                              <input data-type="datepicker" type="text" placeholder="Selecciona una fecha"
                                 name="RG_FECHA_FICHA" class="form-control" value="<?php echo date("d/m/Y"); ?>"
                                 readonly autocomplete="off">
                           </div>
                           <div class="help-block with-errors"></div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <div class="form-group">
                           <label for="">Hora ingreso</label>
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                              <input type="time" class="form-control" value="<?= date("H:i"); ?>" name="RG_HR_FICHA">
                           </div>
                           <div class="help-block with-errors"></div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-12 col-lg-3">
                        <div class="form-group">
                           <label for="">Origen</label>
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-map"></i></span>
                              <input type="text" class="form-control" placeholder="Escribe aquí.."
                                 name="RG_ORIGEN_URGENCIA">
                           </div>
                           <div class="help-block with-errors"></div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <div class="form-group">
                           <label for="">Médico</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-md"></i></span>
                              <select class="form-control" name="ID_MEDICO" id="" required>
                                 <option value="" disabled selected>Elige un médico</option>
                                 <?php
                                            foreach ($Medicos as $row) {
                                                $id = $row['ID_USUARIO'];
                                                $nombre = $row['NOMBRE_USUARIO'];
                                                $selected = "";
                                                if ($this->session->userdata('CAREYES_ID_ROL') == MEDICO && $this->session->userdata('CAREYES_ID_USUARIO') == $id)
                                                    $selected = "selected";
                                                echo "<option value='" . $id . "' " . $selected . ">" . $nombre . "</option>";
                                            }
                                            ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <?php if ($ID_TARIFA) { ?>
                     <div class="col-sm-12 col-mdx-6 col-lg-3">
                        <div class="form-group">
                           <label for="">Tarifa</label>
                           <div class="input-group">
                              <span class="input-group-addon" id="basic-addon1">
                                 <i class="fas fa-dollar-sign"></i>
                              </span>
                              <select class="form-control" id="SELECT_TARIFA_U" name="ID_TARIFA" required>
                                 <option value="" disabled selected>Elige una Tarifa</option>
                                 <?php
                                                foreach ($AllTarifas as $row) {
                                                    $id = $row['ID_TARIFA'];
                                                    $percent = $row['PORCENTAJE_TARIFA'];
                                                    $nombre = $row['NOMBRE_TARIFA'];
                                                    $PrecioConsulta = $row['URGENCIA_TARIFA'];
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
                     <?php } else { ?>
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
                     <?php } ?>
                     <div class="col-lg-9 col-sm-12 col-mdx-6">
                        <div class="form-group">
                           <label for="">Condición</label><br>
                           <div class="col-lg-4 col-sm-4 col-mdx-4 p-left0">
                              <input type="text" class="form-control" name="RG_CONDICION_URGENCIA" id="TRIAGE" readonly
                                 placeholder="Selecciona un color">
                              <input type="hidden" class="form-control" placeholder="Escribe aquí.."
                                 name="RG_CONDICION_URGENCIA">
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

                     <div class="col-sm-12 col-mdx-12 col-lg-12"">
                                <div class=" form-group">
                        <label for="">Motivo urgencia :</label>
                        <textarea class="form-control" name="RG_MOTIVO_URGENCIA" id="MOTIVO" cols="10" rows="5"
                           placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-sm-12 col-mdx-12 col-lg-12"">
                                <div class=" form-group">
                     <label for="">Inicio & Evolución</label>
                     <textarea class="form-control" name="RG_INICIOEVOLUCION_URGENCIA" id="INICIOEVOLUCION" cols="10"
                        rows="5" placeholder="Escribe aquí.."></textarea>
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
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
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
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
                  <label for="">Manejo intrahospitalario:</label>
                  <textarea placeholder="Escribe aquí.." class="form-control"
                     name="RG_MANEJO_INTRAHOSPITALARIO_URGENCIA" id="MANEJO_INTRAHOSPITALARIO_URGENCIA" cols="10"
                     rows="5"></textarea>
               </div>
            </div>
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
                  <label for="">Tratamiento</label>
                  <textarea placeholder="Escribe aquí.." class="form-control" name="RG_TRATAMIENTO_URGENCIA"
                     id="TRATAMIENTO" cols="10" rows="3"></textarea>
               </div>
            </div>
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
                  <label for="">Evolución</label>
                  <textarea placeholder="Escribe aquí.." class="form-control" name="RG_EVOLUCION_URGENCIA"
                     id="EVOLUCION" cols="10" rows="5"></textarea>
               </div>
            </div>
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
                  <label for="">DIAGNÓSTICO DE EGRESO</label>
                  <textarea class="form-control" name="RG_DIAGNOSTICO_EGRESO" id="DIAGNOSTICO" rows="5"
                     placeholder="Escribe aquí.."></textarea>
               </div>
            </div>
            <div class="col-sm-12 col-mdx-12 col-lg-12">
               <div class=" form-group">
                  <label for="">OBSERVACIONES</label>
                  <textarea class="form-control" name="RG_OBSERVACION_URGENCIA" id="OBSERVACION" rows="5"
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
         <div class="col-sm-1"></div>
      </div>
   </div>
</div>
</div>
<div class="container">
   <div class="row">
      <div class="col-lg-6">
         <div class="row">
            <div class="col-lg-12 row-proce">
               <div class="head">
                  <span class="text-center">PROCEDIMIENTOS</span>
                  <button type="button" class="btn btn-info button-head modal-proced_u"><i
                        class="fas fa-plus-circle"></i></button>
               </div>
               <table class="table">
                  <thead>
                     <tr>
                        <th>Nombre</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>*</th>
                     </tr>
                  </thead>
                  <tbody id='tbody_procedimientos' class="text-center">
                  </tbody>
               </table>
               <div id='div_msj'>
                  <div id="msj_temp" class="alert alert-warning"> No se han agregado procedimientos..</div>
               </div>
            </div>
            <div class="col-lg-12 row-material">
               <div class="head">
                  <span class="text-center">MATERIAL & MEDICAMENTOS</span>
                  <button type="button" class="btn btn-info button-head modal-product_u"><i
                        class="fas fa-plus-circle"></i></button>
               </div>
               <table class="table">
                  <thead>
                     <tr>
                        <th>Nombre</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>*</th>
                     </tr>
                  </thead>
                  <tbody id='tbody_productos' class="text-center">

                  </tbody>
               </table>
               <div id='div_msj2'>
                  <div id="msj_temp2" class="alert alert-warning"> No se han agregado productos..</div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 ">
         <div class="row">
            <?php if ($ID_MEMBRESIA): ?>
            <div class="col-lg-6">
               <div class="jss442 blue-x">
                  <div class="jss459 jss467 jss464 jss465">
                     <div class="jss473 jss474 bg-morado">
                        <i class="fas fa-user fa-3x"></i>
                     </div>
                     <p class="jss959 fz-13 text-left">
                        MEMBRESIA
                     </p>
                     <h3 class="jss956"><br>
                        <div class="form-group">
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                              <input type="text" class="form-control" value="<?= $nombre_membresia ?>" readonly>
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
                        TOTAL A PAGAR
                     </p>
                     <h3 class="jss956"><br>
                        <div class="form-group">
                           <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                              <input type="text" id="TOTAL_FINAL" class="form-control" placeholder="Total"
                                 readonly>
                              <span class="input-group-addon c-u">.00</span>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
            <?php else: ?>
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
                              <?php $readonly = ($ID_TARIFA) ? "" : "readonly"; ?>
                              <input type="text" id="PRECIO_CONSULTA" name="PRECIO_CONSULTA"
                                 onClick="this.setSelectionRange(0, this.value.length)"
                                 class="form-control text-right" <?= $readonly ?>
                                 value="<?= $Tarifas->URGENCIA_TARIFA; ?>">
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
                        <span class="fz19 f-bold" id="NOMBRE_TARIFA"> <?= $Tarifas->NOMBRE_TARIFA; ?>  </span>
                     </div>
                     <p class="jss959 fz-13">
                        DESC. POR TARIFA
                     </p>
                     <h3 class="jss956"><br>
                        <div class="form-group">
                           <div class="input-group">
                              <?php $readonly = ($ID_TARIFA) ? "" : "readonly"; ?>
                              <input type="text" id="DESC_TARIFA" name="DESC_TARIFA"
                                 class="form-control text-right" value="<?= $Tarifas->PORCENTAJE_TARIFA; ?>"
                                 <?= $readonly ?> onClick="this.setSelectionRange(0, this.value.length)">
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
                                    <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
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
                                 <label for="TOTAL_FINAL">TOTAL</label>
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-hand-holding-usd"></i></span>
                                    <input type="text" id="TOTAL_FINAL" class="form-control text-center"
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
            <div class="col-lg-12">
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
                                 <input type="text" id="TOTAL_PAGADO" name="RG_TOTAL_PAGADO_URGENCIA" class="form-control"
                                    placeholder="Total Pagado">
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
</div>
<div class="text-center">
   <hr>
       <a href="<?= base_url('Urgency/index'); ?>" class="btn btnx btn-cancel">
      <i class="fas fa-chevron-double-left"></i> Volver a urgencias
   </a>      
   <button type="submit" id="submit-urgency" class="btn btn-info btnx">
      registrar urgencia <i class="fas fa-check"></i>
   </button>
   </form>
</div>

</div><br>
<div class="modal animated faster " role="dialog" aria-hidden="true" id="modal">
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
                           <span class="input-group-addon"> <i class="fas fa-dollar-sign"></i> </span>
                           <input type="text" class="form-control" <?= $readonlyx = ($ID_TARIFA) ? "" : "readonly50"; ?>
                              id="proc_costo" onClick="this.setSelectionRange(0, this.value.length)">
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
            <div style="display:none" id='msj_vacio' class="col-lg-6 col-sm-6 col-md-6 alert alertx alert-danger"><i
                  class="fas fa-exclamation-circle"></i>  Selecciona un Procedimiento </div>

            <div id='msj_cant'
               class="col-lg-6 col-sm-5 col-mdx-6 hidex alertx animated shake faster alert-danger btn-mobile-sm">
               <i class="fas fa-exclamation-circle"></i>  Cantidad debe ser mayor a 0
            </div>
            <div id='msj_success'
               class="text-center col-lg-6 col-sm-5 col-mdx-6 hidex  animated zoomIn faster  btn-mobile-sm">
               <div class="col-lg-12 p-none alertx alert-success ml--15">
                  <i class="fas fa-check"></i>  Se agregó correctamente
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal animated faster " role="dialog" aria-hidden="true" id="modal2">
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
                  <form action="">
                     <div class="form-group" style="margin-bottom:0px">
                        <label for="">Buscar</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>


                           <select style="width:100%" name="SEARCH_PRODUCTO"
                              class="form-control js-example-basic-single" id="SEARCH_PRODUCTO">
                              <option value="" selected disabled>Elige</option>
                              <?php
                                        foreach ($Productos as $procs) {
                                            $name = $procs['NOMBRE_PRODUCTO'];
                                            $code = $procs['CODIGO_PRODUCTO'];
                                            echo "<option value='$name'>".$code." ".$name."</option>";
                                        }
                                        ?>
                           </select>

                        </div>
                     </div>
                  </form>
                  <br>
                  <div class="row hidex" id="div_producto">
                     <input type='hidden' id="id_producto" name='id_producto' value=''>

                     <div class="col-sm-12 col-mdx-12 col-lg-12">
                        <label style="font-weight:500" for="">Agregar: <span class="label_desc"
                              id="product_select"></span></label>
                     </div>
                     <div class="col-lg-4 col-sm-6 col-mdx-4 ">
                        <div class="input-group">
                           <span class="input-group-btn">
                              <button class="btn btn-default btns-grouped" type="button" id="minus_ficha_product"> <i
                                    class="fas fa-minus"></i></button>
                           </span>
                           <input type="text" class="form-control" placeholder="Cantidad" value="1" id="producto_cant">
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
                        </div><!-- /input-group -->
                     </div><!-- /.col-lg-6 -->
                     <div class="col-lg-6 col-sm-6">


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
<script>
$(document).ready(function() {
   animation_modal(".modal-proced_u", "#modal");
   animation_modal(".modal-product_u", "#modal2");

   function animation_modal(button, modal) {
      var modalBtn = $(button);
      var modal = $(modal);
      var animInClass = "";
      var animOutClass = "";

      modalBtn.on('click', function() {
         animInClass = "zoomIn";
         animOutClass = "zoomOut";
         if (animInClass == '' || animOutClass == '') {
            alert("Please select an in and out animation type.");
         } else {
            modal.addClass(animInClass);
            modal.modal({
               backdrop: true
            });
         }
      })
      modal.on('show.bs.modal', function() {
         var closeModalBtns = modal.find('button[data-custom-dismiss="modal"]');
         closeModalBtns.one('click', function() {
            modal.on('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(evt) {
               modal.modal('hide')
            });
            modal.removeClass(animInClass).addClass(animOutClass);
         })
      })
      modal.on('hidden.bs.modal', function(evt) {

         /* ///////////////////////////////////////////////////////
          $("#id_producto").val('');
          $("#SEARCH_PRODUCTO").val("").trigger('change');
          $("#div_producto").hide();
          ///////////////////////////////////////////////////////
          $("#id_proc").val('');
          $("#div_costo").hide();
          $("#SEARCH_PROCEDIMIENTO").val("").trigger('change');
          ///////////////////////////////////////////////////////
          */
         var closeModalBtns = modal.find('button[data-custom-dismiss="modal"]');
         modal.removeClass(animOutClass)
         modal.off('webkitAnimationEnd oanimationend msAnimationEnd animationend')
         closeModalBtns.off('click')
      })
   }
});
</script>