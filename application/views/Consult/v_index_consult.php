<?php
$disabled = ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR) ? 'disabled' : '';
?>

<style>
   .col-lg-6 h3 {
      text-align: center
   }

   hr {
      border-top: 1px solid #ccc;
   }

   textarea {
      font-size: 12px !important;
   }

   .class_invalid span {
      color: #777;
   }
</style>
<div class="container-fluid animated fadeIn">
   <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-sm-12 col-lg-12 col-mdx-12 col-xl-10 text-center">
         <br>
         <div class="panel panel-primary">
            <div class="panel-heading header-primary">
               <div class="panel-title text-left"><span class="heading-primary"><i class="fa fa-stethoscope"></i>
                     CONSULTAS</span>
               </div>
            </div>
            <div class="panel-body">
               <!--  <div style="clear:both"><br></div> -->
               <div class="control-group text-left">
                  <div class="table-">
                     <table id="dataConsult" class="table table-bordered text-center"
                        style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                        <thead>
                           <tr>
                              <th width="5%" class="text-center active">Acciones</th>
                              <th width="5%" class="text-center active">Status</th>
                              <th width="30%" class="text-center active">Paciente</th>
                              <th width="15%" class="text-center active">Médico</th>
                              <th width="25%" class="text-center active">Procedimiento</th>
                              <th width="10%" class="text-center active">Fecha</th>
                              <th width="10%" class="text-center active">Hora</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <br>
      </div>
   </div>
</div>
<div class="modal fade" id="ficha_diagnostico" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialogx modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-headx">
            <button type="button" class="close" data-dismiss="modal">
               <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
            </button>
            <input type="hidden" id="id_consulta_consumo_diagnostico">
            <span class="modal-title" id="myModalLabel">Ficha diagnóstico de: <span id="NOMBRE_PACIENTE"></span></span>
         </div>
         <div class="modal-body modal-bodyx">
            <form id="FORM_CONSULTA">
               <div class="row">
                  <input type="hidden" name="ID_PACIENTE" id="ID_PACIENTE">
                  <input type="hidden" name="ID_CONSULTA" id="ID_CONSULT">
                  <input type="hidden" name="ID_TARIFA" id="ID_TARIFA">
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Fecha Ingreso</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                           <input readonly type="text" name="RG_FECHA_FICHA" id="FECHA_INGRESO" class="form-control"
                              autocomplete="off">
                        </div>
                     </div>
                     <div class="help-block with-errors"></div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Hora ingreso</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                           <input readonly type="time" class="form-control require" name="RG_HR_FICHA"
                              id="HORA_INGRESO">
                        </div>
                     </div>
                     <div class="help-block with-errors"></div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Fecha egreso</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                           <input type="text" class="form-control" data-type="datepicker" placeholdeR="aaaa-mm-dd"
                              readonly name="RG_FECHA_EGRESO" id="FECHA_EGRESO">
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Hora egreso</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                           <input type="time" class="form-control require" readonly name="RG_HORA_EGRESO"
                              id="HORA_EGRESO">
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Condición</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control require" readonly id="CONDICION"
                                           placeholder="Escribe aquí.." name="RG_CONDICION_CONSULTA">
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div> -->
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Origen</label>
                        <div class="input-group">
                           <span class="input-group-addon"><i class="fas fa-map"></i></span>
                           <input type="text" class="form-control require" readonly id="ORIGEN"
                              placeholder="Escribe aquí.." name="RG_ORIGEN_CONSULTA">
                        </div>
                     </div>
                     <div class="help-block with-errors"></div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label for="">Médico</label>
                        <div class="input-group">
                           <span class="input-group-addon" id="basic-addon1"><i class="fas fa-user-md"></i></span>
                           <select readonly class="form-control require" name="ID_MEDICO" id="MEDICO" required>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!--<div class="col-lg-12">
                            <div class="form-group">
                                <div class="alert alert-info">
                                    <label for="">Antecedentes :</label>
                                    <textarea class="form-control txt-antecedentes" name="ANTECEDENTES" id="ANTECEDENTES"
                                              rows="1" placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                        </div>-->
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Motivo consulta :</label>
                        <textarea readonly class="form-control require" name="RG_MOTIVO_CONSULTA" id="MOTIVO" rows="5"
                           placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Inicio & Evolución</label>
                        <textarea readonly class="form-control require" name="RG_INICIOEVOLUCION_CONSULTA"
                           id="INICIOEVOLUCION" rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12 col-sm-12 col-mdx-12">
                     <label for="">Signos vitales</label><br>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">TA</label>
                           <textarea readonly class="form-control require" name="RG_SIGNOS_VITALES_CONSULTA"
                              id="SIGNOS_VITALES" rows="2" placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">FC</label>
                           <textarea readonly class="form-control require" name="RG_FC_CONSULTA" id="FC" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">Ritmo Cardiaco</label>
                           <textarea readonly class="form-control require" name="RG_RITMO_CARDIACO_CONSULTA" id="RC"
                              rows="2" placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">Temp.</label>
                           <textarea readonly class="form-control require" name="RG_TEMP_CONSULTA" id="TEMP" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>

                     <div class="col-lg-4 col-sm-4 col-mdx-4">
                        <div class="form-group">
                           <label for="">FR</label>
                           <textarea readonly class="form-control require" name="RG_FR_CONSULTA" id="FR" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-4 col-mdx-4">
                        <div class="form-group">
                           <label for="">Sat. O2</label>
                           <textarea readonly class="form-control require" name="RG_SAT_CONSULTA" id="SAT" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-12 col-sm-4 col-mdx-4">
                        <div class="form-group">
                           <label for="">Glicemia Capilar</label>
                           <textarea readonly class="form-control require" name="RG_GLICEMIA_CAPILAR_CONSULTA" id="GC"
                              rows="2" placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                  </div>

                  <!--consulta pediatrica-->

                  <div class="col-lg-12 col-sm-12 col-mdx-12">
                     <label for="">Somatometría</label><br>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">PESO</label>
                           <textarea readonly class="form-control require" name="RG_PESO_CONSULTA" id="PE" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">TALLA</label>
                           <textarea readonly class="form-control require" name="RG_TALLA_CONSULTA" id="TA" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">PC</label>
                           <textarea readonly class="form-control require" name="RG_PC_CONSULTA" id="PC" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                     <div class="col-lg-4 col-sm-3 col-mdx-3">
                        <div class="form-group">
                           <label for="">PA</label>
                           <textarea readonly class="form-control require" name="RG_PA_CONSULTA" id="PA" rows="2"
                              placeholder="Escribe aquí.."></textarea>
                        </div>
                     </div>
                  </div>

                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Diagnóstico Presuntivo</label>
                        <textarea readonly class="form-control require" name="RG_DIAGNOSTICO_CONSULTA" id="DIAGNOSTICO"
                           rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Exploración Física</label>
                        <textarea readonly class="form-control require" name="RG_EXPLORACION_FISICA" id="EXPLORACION"
                           rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Manejo intrahospitalario:</label>
                        <textarea readonly class="form-control require" name="RG_MANEJO_INTRAHOSPITALARIO_CONSULTA"
                           id="MANEJO_INTRAHOSPITALARIO_CONSULTA" rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Tratamiento</label>
                        <textarea readonly class="form-control require" name="RG_TRATAMIENTO_CONSULTA" id="TRATAMIENTO"
                           rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Evolución</label>
                        <textarea readonly class="form-control require" name="RG_EVOLUCION_CONSULTA" id="EVOLUCION"
                           rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="">Observaciones</label>
                        <textarea readonly class="form-control require" name="RG_OBSERVACION_CONSULTA" id="OBSERVACION"
                           rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
                  <div class="col-sm-12 col-mdx-12 col-lg-12">
                     <div class=" form-group">
                        <label for="">DIAGNÓSTICO DE EGRESO</label>
                        <textarea readonly="" class="form-control require" name="RG_DIAGNOSTICO_EGRESO_CONSULTA"
                           id="DIAGNOSTICO_CON" rows="5" placeholder="Escribe aquí.."></textarea>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button id="BTN_SUBMIT_DIAGNOSTIC" style="display:none" class="btn btn-success" data-btn="edit-ficha"
               type="button">Guardar
               cambios</button>
            <button id="BTN_EDIT_DIAGNOSTIC" class="btn btn-info" type="button">Editar</button>
            <button id="BTN_CANCEL_DIAGNOSTIC" data-cancel="cancel" style="display:none" class="btn btn-info"
               type="button">Cancelar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button id="BTN_PRINT_DIAG_CONSULT" class="float-left btn btn-warning">Imprimir</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="ficha_consumo" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header modal-headx">
            <button type="button" class="close" data-dismiss="modal">
               <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
            </button>
            <input type="hidden" id="id_ficha_consumo">
            <input type="hidden" id="close_consulta">
            <input type="hidden" id="id_tarifa">
            <input type="hidden" id="id_consulta">
            <input type="hidden" id="id_consulta_consumo">
            <input type="hidden" id="id_paciente_consumo">
            <span class="modal-title" id="myModalLabel">FICHA CONSUMO DE <span id="paciente_name"></span></span>
            <span class="float-right color-white" id="labelType">
               <font id="TYPE"></font>
            </span>
            <span class="float-right color-white" style="display:none" id="tarifa_edit">
               Tarifa
               <select name="" id="tarifa_select">
               <option value="">--SELECCIONE--</option>
                  <?php
                        $CI = &get_instance();
                        $Tarifas = $this->db->get_where("tarifa", array('VIGENCIA_TARIFA' => 1))->result_array();
                        foreach ($Tarifas as $row) {
                            $nombre = $row['NOMBRE_TARIFA'];
                            $id = $row['ID_TARIFA'];
                            $desc = $row['PORCENTAJE_TARIFA'];
                            $consulta = $row['CONSULTA_TARIFA'];

                            echo "<option data-precioConsulta='" . $consulta . "' data-name='" . $nombre . "' data-desc='" . $desc . "' value='" . $id . "'>" . $nombre . "</option>";
                        }
                        ?>

               </select>
            </span>
            <!-- <span class="float-right hide" id="membre_edit">
                    Tarifa
                    <select name="" id="">
                    <option value="">A</option>
                    <option value="">B</option>
                    <option value="">C</option>
                    </select>
                </span> -->

         </div>
         <div class="modal-body pd-3rem">
            <div class="row">
               <div class="col-lg-6">
                  <div class="row">
                     <!-- // PANEL PROCEDIMIENTOS // -->
                     <div class="col-lg-12 col-sm-12 col-md-12 div_adds p-none hidex" id="addProcedimiento">
                        <label for="">Agregar procedimiento</label>
                        <select name="proc" id="select_procedimiento" class="form-control">
                           <option id="optSelected" value="" selected>Elige un procedimiento</option>
                           <?php
                                $CI = &get_instance();
                                $Procedimientos = $CI->db->get('procedimiento')->result_array();

                                foreach ($Procedimientos as $row) {
                                    echo "<option data-precio_proce='" . $row["precio_procedimiento"] . "' value='" . $row["id_procedimiento"] . "'>" . $row['descripcion_procedimiento'] . "</option>";
                                }
                                ?>
                        </select>

                        <div class="class_invalid hidex mb-10 animated shake fast" id="msj_validSelect_proc">
                           <i class="fas fa-check-square"></i> Selecciona un procedimiento
                        </div>

                        <div class="col-lg-4 col-sm-5 col-mdx-5 p-left0">
                           <div class="input-group">
                              <span class="input-group-btn">
                                 <button class="btn btn-default btns-grouped" type="button" id="minus_cant_proc"> <i
                                       class="fas fa-minus"></i></button>
                              </span>
                              <input type="text" class="form-control numeric" placeholder="Cantidad" value="1"
                                 id="cant_relprocedimiento">
                              <span class="input-group-btn">
                                 <button class="btn btn-default btns-grouped" type="button" id="add_cant_proc"><i
                                       class="fas fa-plus"></i></button>
                              </span>
                           </div><!-- /input-group -->
                        </div>
                        <div class="col-lg-5 col-sm-6 col-mdx-6">
                           <div class="input-group" id="DIV_PRECIO_PROCE">
                              <div class="input-group-btn">
                                 <span class="btn btn-default btns-grouped"> <i class="fas fa-dollar-sign"></i> </span>
                              </div>
                              <input type="text" class="form-control text-center" id="proc_costo"
                                 onClick="this.setSelectionRange(0, this.value.length)">
                              <span class="input-group-addon c-u">c/u</span>
                           </div>
                        </div><!-- /.col-lg-6 -->
                        <div class="col-lg-3 col-sm-1 col-md-1 p-right0">
                           <button type="button" class="btn btn-info button-head" id="SUBMIT_REL_PROCEDIMIENTO_C"
                              style="padding: 6px 6px 6px 6.5px;margin-right:-10px;"><i
                                 class="fas fa-plus"></i></button>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 class_invalid">
                           <div class="animated shake fast" style="display:none" id="msj_validCant_proc">
                              <i class="fas fa-sort-numeric-up-alt"></i> Cantidad debe ser mayor a 0
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-sm-12 col-md-12 table-consumo p-none">
                        <h3 class="h3-fichaConsumo">Procedimientos</h3>
                        <div class="table-responsivex">
                           <table class="table table- text-center">
                              <thead>
                                 <th width="30%" class="">Nombre</th>
                                 <th width="20%" class="">Cantidad</th>
                                 <th width="20%" class="">Precio</th>
                                 <th width="30%" class="">Acción</th>
                              </thead>
                              <tbody id="tbody_procedimientos" class="b-1p"></tbody>
                           </table>
                        </div>
                        <div id="msj_tableEmptyProce" class="alert alert-warning hidex"> No se han agregado
                           procedimientos..</div>
                        <div class="text-center">
                           <div class="hidex animated pulse fast mb-10" id="proce_submit"><span
                                 class="msj-addSuccess"><i class="fas fa-check"></i> 
                                 Se ha añadido  <span id="msj_cant_proce"></span></span></div>
                        </div>
                     </div>
                      <!-- // PANEL PRODUCTOS // -->
                     <div class="col-lg-12 col-sm-12 col-md-12 div_adds p-none hidex" id="addProducto">
                        <label for="">Agregar producto</label>
                        <select name="producto" id="select_producto" class="form-control">
                           <option value="" selected>Elige un producto</option>
                           <?php
                              foreach ($PRODUCTOS as $row) {
                                 echo "<option value='" . $row["ID_PRODUCTO"] . "'> " . $row['NOMBRE_PRODUCTO'] . "</option>";
                              }
                           ?>
                        </select>

                        <div class="class_invalid hidex mb-10 animated shake fast" id="msj_validSelect_product">
                           <i class="fas fa-check-square"></i> Selecciona un producto
                        </div>

                        <div class="col-lg-5 col-sm-6 col-mdx-4 p-left0">
                           <div class="input-group">
                              <span class="input-group-btn">
                                 <button class="btn btn-default btns-grouped" type="button" id="minus_cant_product"> <i
                                       class="fas fa-minus"></i></button>
                              </span>
                              <input type="text" class="form-control numeric" placeholder="Cantidad" value="1"
                                 id="cant_relproducto">
                              <span class="input-group-btn">
                                 <button class="btn btn-default btns-grouped" type="button" id="add_cant_product"><i
                                       class="fas fa-plus"></i></button>
                              </span>
                           </div><!-- /input-group -->
                        </div>
                        <div class="col-lg-1 col-mdx-2">
                        </div>
                        <div class="col-lg-6 col-sm-6 col-mdx-6 p-right0">
                           <button type="button" class="btn btn-info button-head" id="SUBMIT_REL_PRODUCTO_C"
                              style="padding: 6px 6px 6px 6.5px;margin-right:-10px;"><i
                                 class="fas fa-plus"></i></button>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 class_invalid">
                           <div class="animated shake fast" style="display:none" id="msj_validCant_product"><i
                                 class="fas fa-sort-numeric-up-alt"></i>
                              Cantidad debe ser mayor a 0</div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-sm-12 col-md-12 table-consumo p-none">
                        <h3 class="h3-fichaConsumo">Materiales & Productos</h3>
                        <div class="table-responsivex">
                           <table class="table text-center">
                              <thead>
                                 <th class="">Nombre</th>
                                 <!--  <th class="hidex info" id="TH-DESC">Desc.</th> -->
                                 <th class="">Cantidad</th>
                                 <th class="">Precio</th>
                                 <th class="">Acción</th>
                              </thead>
                              <tbody id="tbody_productos" class="b-1p"></tbody>
                           </table>
                        </div>
                        <div id="msj_tableEmptyProdu" class="alert alert-warning hidex"> No se han agregado productos..
                        </div>
                        <div class="text-center">
                           <div class="hidex animated pulse fast mb-10" id="produ_submit"><span
                                 class="msj-addSuccess"><i class="fas fa-check"></i> 
                                 Se ha añadido  <span id="msj_cant_prod"></span></span></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <!-- // PANEL DETALLES // -->
                  <!-- <div class="row">
                     <div class="col-lg-12 col-mdx-12 col-sm-12 bg-grey pd-details hidex" id="FOOTER_M">
                        <div class="col-lg-12 text-center p-none">
                           <div class="form-group">
                               <label class="label_card">FOLIO</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-hashtag"></i></span>
                                  <input type="text" id="FOLIO_CONSULTA_M" class="form-control text-center"
                                    placeholder="Folio" readonly> 
                              </div>
                           </div>
                        </div> -->
                        <div  class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">MEMBRESÍA</label>
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                                 <input type="text" class="form-control numeric text-center br-0" readonly
                                    id="MEMBRESIA">

                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">TOTAL A PAGAR</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                 <input type="text" id="TOTAL_FINAL_INDEX" class="form-control text-center"
                                    placeholder="Total" readonly>
                              </div>
                           </div>
                        </div>
                       
                      </div>
                     <div class="col-lg-12 col-mdx-12 col-sm-12 bg-grey pd-details hidex" id="FOOTER_T">
                        <div class="col-lg-12 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">FOLIO</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-hashtag"></i></span>
                                 <input type="text" id="FOLIO_CONSULTA" class="form-control text-center"
                                    placeholder="Folio" readonly>
                              </div>
                           </div>
                        </div> 
                       
                        <div class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">PRECIO CONSULTA</label>
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                 <input type="text" id="precio_consult" class="form-control text-center br-0" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">DESC. TARIFA</label>
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                                 <input type="text" id="DESC_TARIFA_INDEX"
                                    class="form-control text-center br-0 DESC_TARIFA_INDEX" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">      SUBTOTAL</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                 <input type="text" id="SUBTOTAL_INDEX" class="form-control text-center br-0"
                                    placeholder="Total" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 text-center p-none">
                           <div class="form-group">
                              <label class="label_card">      DESCUENTO</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-minus"></i></span>
                                 <input type="text" id="DESCUENTO_TOTAL_INDEX" class="form-control text-center br-0"
                                    placeholder="Desc" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 total text-center p-none">
                           <div class="form-group">
                              <label class="label_card">      TOTAL</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                 <input type="text" id="TOTAL_FINAL_INDEX_T" class="form-control text-center"
                                    placeholder="Total" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 total text-center p-none">
                           <div class="form-group">
                              <label class="label_card">      TOTAL PAGADO</label>
                              <div class="input-group">
                                 <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                 <input type="text" id="TOTAL_PAGADO_CONSULTA" class="form-control text-center"
                                    placeholder="Total" readonly>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <button type="button" id="BTN_EDIT_FICHA" class="btn btn-info" data-btn="edit-ficha">Editar</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
         <button id="BTN_PRINT_FICHA" type="button" class="btn btn-warning float-left">Imprimir ficha</button>
      </div>
   </div>
</div>
</div>

<div class="modal fade" id="modAddFiles" tabindex="-1" role="dialog" aria-labelledby="modAddFiles" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header modal-headx header-primary" id="modalHeaderAdvice">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>

            <span class="modal-title" id="myModalLabel"><i class="fas fa-paperclip"></i> ADJUNTAR ARCHIVOS</span>
         </div>
         <div class="modal-body text-center" id="modBodyAddFiles" style="text-align: center">
            <div class="col-sm-12 text-left">
               <div class="alert alert-warning"> Puedes adjuntar archivos como imagenes, excel, word, PDF. Deben ser
                  menores a 40 MB.</div>
            </div>
            <div class="col-sm-12 text-left">
               <table class="table table-responsive" style="width: 98%; font-size: 12px;">
                  <thead>
                     <tr>
                        <th width="10%" class="text-center active">#</th>
                        <th width="60%" class="text-center active">Archivo</th>
                        <th width="20%" class="text-center active">Tipo</th>
                        <th width="10%" class="text-center active">Acciones</th>
                     </tr>
                  </thead>
                  <tbody id="tbodyTableFilesClient"></tbody>
               </table>
               <div id="divMensajesFiles">

               </div>
               <br>
            </div>
            <div class="col-sm-12">
               <form method="post" enctype="multipart/form-data" id="formFilesClient">
                  <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                     <span class="input-group-append">
                        <span class="input-group-text fileinput-exists" data-dismiss="fileinput">
                           <i class="fas fa-file-minus"></i> Quitar
                        </span>

                        <span class="input-group-text btn-file">
                           <span class="fileinput-new"><i class="fad fa-hand-pointer"></i> Seleccionar archivo</span>
                           <span class="fileinput-exists"><i class="fad fa-sync-alt"></i> Cambiar</span>
                           <input type="file" name="userfile" id="userfile" multiple>
                        </span>
                     </span>
                     <div class="form-control" data-trigger="fileinput">
                        <span class="fileinput-filename"></span>
                     </div>
                  </div>
            </div>
         </div>
         <div style="clear:both"><br></div>
         <div class="modal-footer">

            <button class="btn btn-default" type="button" data-dismiss="modal">
               <i class="fa fa-times" aria-hidden="true"></i> Cerrar
            </button>
            <div class="col-sm-4 float-left text-left p-left0">
               <button type="submit" class="btn btn-info"> <i class="fa fa-upload" aria-hidden="true"></i> Subir archivo
               </button>
               <input type="hidden" name="ID_CONSULTA" id="ID_CONSULTA">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>