<div class="container-fluid">
    <br>
    <div class="col-lg-1"></div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
        <div class="panel with-nav-tabs panel-primary">
            <div class="panel-heading header-primary">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#SEARCH_PATIENT" data-toggle="tab"><i class="fa fa-users"></i> BUSCAR
                            PACIENTE</a></li>
                    <li><a href="#VIEW_URGENCYS" data-toggle="tab"><i class="fa fa-stethoscope"></i> VER URGENCIAS</a></li>

                    <?php
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        $disabled = '';
                    else:
                        $disabled = 'disabled';
                    endif;
                    if ($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR):
                        ?>

                        <a href="<?= base_url() ?>Urgency/form_add_urgency" class="btn pull-right btn-header" id="">
                            <i class="fas fa-plus" prescription-bottle aria-hidden="true"></i> Nueva urgencia
                        </a>
                    <?php endif; ?>
                </ul>
                <!--  </div> -->
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="SEARCH_PATIENT">
                        <div class="panel-body p-resp">
                            <div class="control-group text-left">
                                <div class="table-responsivex">
                                    <table id="dataPatientsUrgency" class="table table-bordered text-center"
                                           style="font-size: 14px; border-radius:5px" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10%">Acciones</th>
                                                <th width="30%">Nombre</th>
                                                <th width="20%">Domicilio</th>
                                                <th width="10%">Municipio</th>
                                                <th width="10%">Estado</th>
                                                <th width="10%">Edad</th>
                                                <th width="10%">Sexo</th>
                                            </tr>
                                        </thead>                            
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="VIEW_URGENCYS">
                        <div class="panel-body p-resp">
                            <div class="control-group">
                                <table id="dataUrgency" class="table table-striped table-bordered text-center"
                                       style="font-size: 14px; border-radius:5px" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="25%">Acciones</th>
                                            <th width="5%">Status</th>
                                            <th width="10%">Paciente</th>
                                            <th width="10%">Médico</th>
                                            <th width="10%">Tar/Mem</th>
                                            <th width="15%">Domicilio</th>
                                            <th width="15%">Motivo</th>
                                            <th width="10%">Fecha</th>
                                           <!--<th width="10%">Hora</th>-->
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1"></div>
</div>
<div class="modal fade" id="ficha_diagnostico" role="dialog">  
    <div class="modal-dialog modal-dialogx modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                </button>
                <span class="modal-title" id="myModalLabel">Ficha diagnostico de: <span id="NOMBRE_PACIENTE"></span></span>
            </div>
            <div class="modal-body modal-bodyx">
                <form id="FORM_URGENCIA">
                    <div class="row">
                        <input type="hidden" name="ID_PACIENTE" id="ID_PACIENTE">
                        <input type="hidden" name="ID_URGENCIA" id="ID_URGENCIA">
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
                                    <input readonly type="time" class="form-control" name="RG_HR_FICHA" id="HORA_INGRESO">
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Origen</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-map"></i></span>
                                    <input type="text" class="form-control require" readonly id="ORIGEN"
                                           placeholder="Escribe aquí.." name="RG_ORIGEN_URGENCIA">
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

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="RG_FECHA_EGRESO" class="control-label text-left">fECHA egreso</label>
                                <div class='input-group' id='DIV_RG_FECHA_EGRESO_U' style="cursor:pointer;">
                                    <input data-type="datepicker" type='text' class="form-control" name="RG_FECHA_EGRESO"
                                           id="FECHA_EGRESO" readonly required />

                                    <span class="input-group-addon">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Hora egreso</label>
                                <input type="time" class="form-control require" readonly name="RG_HORA_EGRESO" id="HORA_EGRESO">
                            </div>
                        </div><hr>
                        <div class="col-lg-9 col-sm-12 col-mdx-12">
                            <div class="form-group">
                                <label for="">Condición</label><br>
                                <div class="col-lg-4 col-sm-4 col-mdx-4 p-left0">
                                    <input type="text" class="form-control" name="RG_CONDICION_URGENCIA" id="CONDICION" readonly
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
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Motivo consulta :</label>
                                <textarea readonly class="form-control require" name="RG_MOTIVO_URGENCIA" id="MOTIVO"
                                          cols="10" rows="5" placeholder="Escribe aquí.."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Inicio & Evolución</label>
                                <textarea readonly class="form-control require" name="RG_INICIOEVOLUCION_URGENCIA"
                                          id="INICIOEVOLUCION" cols="10" rows="5" placeholder="Escribe aquí.."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-mdx-12">
                            <label for="">Signos vitales</label><br>
                            <div class="col-lg-3 col-sm-3 col-mdx-3">
                                <div class="form-group">
                                    <label for="">TA</label>
                                    <textarea readonly class="form-control require" name="RG_SIGNOS_VITALES_URGENCIA" id="SIGNOS_VITALES" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-mdx-3">
                                <div class="form-group">
                                    <label for="">FC</label>
                                    <textarea readonly class="form-control require" name="RG_FC_URGENCIA" id="FC" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-mdx-3">
                                <div class="form-group">
                                    <label for="">Ritmo Cardiaco</label>
                                    <textarea readonly class="form-control require" name="RG_RITMO_CARDIACO_URGENCIA" id="RC" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-mdx-3">
                                <div class="form-group">
                                    <label for="">Temp.</label>
                                    <textarea readonly class="form-control require" name="RG_TEMP_URGENCIA" id="TEMP" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-mdx-12">
                            <div class="col-lg-4 col-sm-4 col-mdx-4">
                                <div class="form-group">
                                    <label for="">FR</label>
                                    <textarea readonly class="form-control require" name="RG_FR_URGENCIA" id="FR" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-mdx-4">
                                <div class="form-group">
                                    <label for="">Sat. O2</label>
                                    <textarea readonly class="form-control require" name="RG_SAT_URGENCIA" id="SAT" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-mdx-4">
                                <div class="form-group">
                                    <label for="">Glicemia Capilar</label>
                                    <textarea readonly class="form-control require" name="RG_GLICEMIA_CAPILAR_URGENCIA" id="GC" rows="1"
                                              placeholder="Escribe aquí.."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Diagnóstico Ingreso</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_DIAGNOSTICO_URGENCIA" id="DIAGNOSTICO" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Exploración Física</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_EXPLORACION_FISICA" id="EXPLORACION" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-mdx-12 col-lg-12">
                            <div class=" form-group">
                                <label for="">Manejo intrahospitalario:</label>
                                <textarea readonly="" placeholder="Escribe aquí.." class="form-control require" name="RG_MANEJO_INTRAHOSPITALARIO_URGENCIA"
                                          id="MANEJO_INTRAHOSPITALARIO" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Tratamiento</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_TRATAMIENTO_URGENCIA" id="TRATAMIENTO" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Evolución</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_EVOLUCION_URGENCIA" id="EVOLUCION" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_OBSERVACION_URGENCIA" id="OBSERVACION" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Destino</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require"
                                          name="RG_DESTINO" id="DESTINO" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-mdx-12 col-lg-12">
                            <div class=" form-group">
                                <label for="">DIAGNÓSTICO DE EGRESO</label>
                                <textarea readonly placeholder="Escribe aquí.." class="form-control require" name="RG_DIAGNOSTICO_EGRESO" id="DIAGNOSTICO_EGRESO" cols="10" rows="5"
                                          placeholder="Escribe aquí.." ></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="BTN_SUBMIT_DIAGNOSTIC_U" style="display:none" class="btn btn-success save" name="save" type="button" data-btn="edit-ficha">Guardar
                    cambios</button>
                <button id="BTN_EDIT_DIAGNOSTIC_U" class="btn btn-info" type="button">Editar</button>
                <button id="BTN_CANCEL_DIAGNOSTIC_U" data-cancel="cancel" style="display:none" class="btn btn-info"
                        type="button">Cancelar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="BTN_PRINT_DIAG_URGENCY" class="float-left btn btn-warning">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ficha_consumo" role="dialog">  
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span>
                </button>
                <input type="hidden" id="id_ficha">
                <input type="hidden" id="id_tarifa">
                <input type="hidden" id="id_urgencia">
                <input type="hidden" id="id_paciente">
                <input type="hidden" id="close_urgencia">
                <span class="modal-title" id="myModalLabel">FICHA CONSUMO DE <span id="paciente_name"></span></span>
                <span class="float-right color-white" id="labelTypeU">
                    <font id="TYPE"></font>
                </span>
                <span class="float-right color-white" style="display:none" id="tarifa_edit_urgency">
                    Tarifa
                    <select name="" id="tarifa_select_urgency">
                        <option value="">--SELECCIONE--</option>
                        <?php
                                $CI = &get_instance();
                                $Tarifas = $this->db->get_where("tarifa", array('VIGENCIA_TARIFA' => 1))->result_array();
                                foreach ($Tarifas as $row) {
                                    $nombre = $row['NOMBRE_TARIFA'];
                                    $id = $row['ID_TARIFA'];
                                    $desc = $row['PORCENTAJE_TARIFA'];
                                    $urgencia = $row['URGENCIA_TARIFA'];

                                    echo "<option data-precio_urgencia='" . $urgencia . "' data-name='" . $nombre . "' data-desc='" . $desc . "' value='" . $id . "'>" . $nombre . "</option>";
                                }
                                ?>

                    </select>
                </span>

            </div>
            <div class="modal-body pd-modal-body">
                <div class="row">
                    <!-- // PANEL PROCEDIMIENTOS // -->
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="col-lg-12 col-sm-12 col-md-12 div_adds p-none hidex " id="addProcedimiento">
                            <label>Agregar procedimiento</label>
                            <select name="proc" id="select_procedimiento" class="form-control">
                                <option value="" selected>Elige un procedimiento</option>
                                <?php
                                $CI = & get_instance();
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
                                    <input  type="text" class="form-control text-center" id="proc_costo" value="0.00"
                                            onClick="this.setSelectionRange(0, this.value.length)">
                                    <span class="input-group-addon c-u">c/u</span>
                                </div>
                            </div><!-- /.col-lg-6 -->                   
                            <div class="col-lg-3 col-sm-1 col-mdx-1 p-right0">                     
                                <button type="button" class="btn btn-info button-head" id="SUBMIT_REL_PROCEDIMIENTO_U" style="padding: 6px 6px 6px 6.5px;margin-right:-10px;"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 class_invalid">
                                <div class="animated shake fast hidex" id="msj_validCant_proc">
                                    <i class="fas fa-sort-numeric-up-alt"></i> Cantidad debe ser mayor a 0
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 table-consumo p-none">
                            <h3 class="h3-fichaConsumo">Procedimientos</h3>
                            <div class="table-responsivex">
                                <table class="table text-center">
                                    <thead>
                                    <th class="">Nombre</th>
                                    <th class="">Cantidad</th>
                                    <th class="">Precio</th>
                                    <th class="">Acción</th>
                                    </thead>
                                    <tbody id="tbody_procedimientos"></tbody>
                                </table>
                            </div>
                            <div id="msj_tableEmptyProce" class="alert alert-warning hidex "> No se han agregado procedimientos..</div>                                                                    
                            <div class="text-center">
                                <div class="hidex animated pulse fast mb-10" id="proce_submit">
                                    <span class="msj-addSuccess">  <i class="fas fa-check"></i>  Se ha añadido  <span id="msj_cant_proc"></span>
                                    </span>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // PANEL PRODUCTOS // -->
                    <div class="col-lg-6 col-sm-12 col-md-12">
                        <div class="col-lg-12  col-sm-12 col-md-12 div_adds hidex p-none" id="addProducto">
                            <label for="">Agregar producto</label>
                            <select name="producto" id="select_producto" class="form-control">
                                <option value="" selected>Elige un producto</option>
                                <?php
                                foreach ($PRODUCTOS as $row) {
                                    echo "<option value='" . $row["ID_PRODUCTO"] . "'> ". $row['NOMBRE_PRODUCTO'] . "</option>";
                                }
                                ?>
                            </select>
                            <div class="class_invalid mb-10 animated shake fast hidex" id="msj_validSelect_product">
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
                            <div class="col-lg-1 col-mdx-2"></div>                    
                            <div class="col-lg-6 col-sm-6 col-mdx-6 p-right0">                     
                                <button type="button" class="btn btn-info button-head" id="SUBMIT_REL_PRODUCTO_U" style="padding: 6px 6px 6px 6.5px;margin-right:-10px;"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 class_invalid">
                                <div class="animated shake fast" style="display:none" id="msj_validCant_product"><i
                                        class="fas fa-sort-numeric-up-alt"></i> Cantidad debe ser mayor a 0</div>
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
                                    <tbody id="tbody_productos"></tbody>
                                </table>
                            </div>
                            <div id="msj_tableEmptyProdu" class="alert alert-warning hidex"> No se han agregado productos..</div>                     
                            <div class="text-center">
                                <div class="hidex animated pulse fast mb-10" id="produ_submit"><span class="msj-addSuccess"><i
                                            class="fas fa-check"></i>  Se ha añadido  <span id="msj_cant_prod"></span></span></div>
                            </div>
                        </div>                 
                    </div>
                    <!-- // PANEL DETALLES // -->              
                    <div class="col-lg-12 col-mdx-12 col-sm-12 bg-grey pd-details hidex" id="FOOTER_M_U">                                   
                        <div class="col-lg-2 col-mdx-3 col-sm-5 col-lg-offset-3 col-mdx-offset-3 col-sm-offset-1 text-center p-none  mr-10">                     
                            <div class="form-group">
                                <label class="label_card">MEMBRESÍA</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-credit-card"></i></span>
                                    <input type="text" class="form-control numeric text-center br-0" readonly id="MEMBRESIA">                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-mdx-3 col-sm-5 text-center p-none">
                            <div class="form-group">
                                <label class="label_card">TOTAL A PAGAR</label>
                                <div class="input-group">
                                    <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" id="TOTAL_FINAL_INDEX_U" class="form-control text-center" placeholder="Total" readonly>                                       
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-mdx-3 col-sm-5 text-center p-none ">
                            <div class="form-group">
                                <label class="label_card">FOLIO</label>
                                <div class="input-group">
                                    <span class="input-group-addon br-0"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" id="FOLIO_URGENCIA_M" name="FOLIO_URGENCIA_M" class="form-control text-center" placeholder="Folio" readonly>
                                </div>
                            </div>
                        </div>
                    </div>           
                    <div class="col-lg-12 col-mdx-12 col-sm-12 bg-grey pd-details hidex" id="FOOTER_T_U"> 
                        <div class="col-lg-2 col-mdx-3 col-sm-6 col-lg-offset-1 text-center p-none">
                            <div class="form-group">
                                <label class="label_card">PRECIO URGENCIA</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" id="precio_urgencia" class="form-control text-center br-0" readonly>
                                </div>
                            </div>
                        </div>                 
                        <div class="col-lg-2 col-mdx-3 col-sm-6 desc text-center p-none">
                            <div class="form-group">
                                <label class="label_card">DESC. TARIFA</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                                    <input type="text" id="DESC_TARIFA_U" class="form-control text-center br-0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-mdx-3 col-sm-6 text-center p-none">
                            <div class="form-group">                        
                                <label class="label_card">      SUBTOTAL</label>
                                <div class="input-group">
                                    <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" id="TOTAL_INDEX_U" class="form-control text-center br-0" placeholder="Total" readonly>                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-mdx-3 col-sm-6 text-center p-none">                     
                            <div class="form-group">
                                <label class="label_card">      DESCUENTO</label>
                                <div class="input-group">
                                    <span class="input-group-addon br-0"><i class="fas fa-minus"></i></span>
                                    <input type="text" id="DESCUENTO_TOTAL_INDEX_U" class="form-control text-center br-0" placeholder="Desc" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-mdx-3 col-sm-6 total text-center p-none">                     
                            <div class="form-group">
                                <label class="label_card">      TOTAL</label>
                                <div class="input-group">
                                    <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" id="TOTAL_FINAL_INDEX_T_U" class="form-control text-center" placeholder="Total" readonly>
                                </div>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-lg-12 col-mdx-12 col-sm-12"></div>
                                <div class="col-lg-2 col-mdx-3 col-sm-6 total col-lg-offset-5 text-center p-none">                     
                                    <div class="form-group">
                                        <label class="label_card">      TOTAL PAGADO</label>
                                        <div class="input-group">
                                            <span class="input-group-addon br-0"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="text" id="TOTAL_PAGADO_URGENCIA" class="form-control text-center" placeholder="Total" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-mdx-3 col-sm-5 text-center p-none">
                                    <div class="form-group">
                                        <label class="label_card">FOLIO</label>
                                        <div class="input-group">
                                            <span class="input-group-addon br-0"><i class="fas fa-hashtag"></i></span>
                                            <input type="text" id="FOLIO_URGENCIA" class="form-control text-center" placeholder="Folio" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default float-right" data-dismiss="modal">Cerrar</button>      
                    <button type="button" id="BTN_EDIT_FICHA_U" class="btn btn-info float-right mr-10">Editar</button>
                    <button type="button" id="BTN_PRINT_FICHA_URGENCY" class="btn btn-warning float-left">Imprimir
                        ficha</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modAddFiles" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-headx header-primary" id="modalHeaderAdvice">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <span class="modal-title"><i class="fas fa-paperclip"></i> ADJUNTAR ARCHIVOS</span>
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
                                <th style="max-width: 5%">#</th>
                                <th style="max-width: 50%">Archivo</th>
                                <th style="max-width: 1% ">Tipo</th>
                                <th style="max-width: 44% !important; text-align: right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyTableFilesClient"></tbody>
                    </table>
                    <div id="divMensajesFiles">

                    </div>
                    <br>
                </div>
                <div class="col-lg-12">
                    <form method="post" enctype="multipart/form-data" id="formFilesClient_U">
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

                <button class="btn btn-default" type="button" id="btnCancel" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i> Cerrar
                </button>
                <div class="col-sm-4 text-left float-left p-left0">
                    <button type="submit" value="Adjuntar" class="btn btn-info"> <i class="fa fa-upload"
                                                                                    aria-hidden="true"></i> Subir archivo
                    </button>
                    <input type="hidden" name="ID_URGENCIA" id="ID_URGENCIA_U">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>