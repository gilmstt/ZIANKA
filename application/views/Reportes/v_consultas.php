<script>
    $.ajax({
        type: "POST",
        url: raiz_url + 'report/ajax_obtener_medico_nombre',
        dataType: 'json',
        success: function(respuesta) {
            var apellidos_medico = new Array();
            $.each(respuesta, function(x, medico) {
                apellidos_medico.push(medico.APELLIDO_USUARIO);
            });
            $("#SEARCH_AP_MEDICO").autocomplete({
                source: apellidos_medico,
                select: function(event, ui) {
                    var apellido_medico = ui.item.value;
                    $.ajax({
                        type: "POST",
                        url: raiz_url + 'report/ajax_obtener_medico_nombre',
                        dataType: 'json',
                        data: 'apellidos_medico=' + apellido_medico,
                        success: function(respuesta) {
                            var nombres_medico = new Array();
                            $.each(respuesta, function(x, medico) {
                                nombres_medico.push(medico.NOMBRE_USUARIO);
                            });
                            /* Autocompleta los nombres obtenidos
                             */
                            $("#SEARCH_NOMBRE_MEDICO").autocomplete({
                                source: nombres_medico,
                                select: function(event, ui) {
                                    $("#SEARCH_NOMBRE_MEDICO").val(ui.item.value);
                                }
                            });
                        }
                    });
                }
            });
        }
    });
</script>

<!-- Barra de navegacion -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 "><br>
            <?php $this->view('Reportes/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9"><br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-file-invoice"></i>
                            BITACORA DE CONTROL Y REGISTRO DIARIO DE PACIENTES</span>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="formSearchConsultas" method="POST">
                        <!-- Tarifas y fecha -->
                        <div class="row text-left">
                            <div class="col-md-3 text-left">
                                <div class="form-group">
                                    <label class="control-label text-left">Elige un rango de fechas</label>
                                    <div class='input-group date'>
                                        <span class="input-group-addon">Desde</span>

                                        <input type="text" data-type="datepicker" name="RG_FECHA_INICIAL" required
                                               id="RG_FECHA_INICIAL" class="form-control" placeholder="Desde" readonly
                                               value="<?= date('d/m/Y', strtotime('-1 day')); ?>">
                                        <span class="input-group-addon">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-left">
                                <div class="form-group">
                                    <label class="control-label text-left">&nbsp;</label>
                                    <div class='input-group'>
                                        <span class="input-group-addon">Hasta</span>

                                        <input type="text" data-type="datepicker" name="RG_FECHA_FINAL" id="RG_FECHA_FINAL"
                                               required readonly class="form-control" placeholder="Hasta"
                                               value="<?= date('d/m/Y'); ?>">
                                        <span class="input-group-addon">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-md-3 text-left">
                                <div class="form-group">
                                    <label for="TIPO_DESCUENTO" class="control-label text-left">Tipo de descuento</label>
                                    <select id="TIPO_DESCUENTO" name="TIPO_DESCUENTO" class="form-control">
                                        <option disabled selected value="0">Todas</option>
                                        <option value="1">Tarifa</option>
                                        <option value="2">Membresia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 text-left">
                                <div class="form-group hidden" id="divTa" >
                                    <label for="BUSCAR_TARIFA" class="control-label text-left">Tarifa</label>
                                    <select id="BUSCAR_TARIFA" name="BUSCAR_TARIFA" class="form-control">
                                        <option selected value="0">Todas</option>
                                        <?php foreach ($TARFIAS as $tarifa) { ?>
                                            <option value="<?= $tarifa['ID_TARIFA'] ?>">
                                                <?= $tarifa['NOMBRE_TARIFA'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 text-left">
                                <div class="form-group hidden" id="divMem" >
                                    <label for="BUSCAR_MEMBRESIA" class="control-label text-left">Membresia</label>
                                    <select id="BUSCAR_MEMBRESIA" name="BUSCAR_MEMBRESIA" class="form-control">
                                        <option selected value="0">Todas</option>
                                        <?php foreach ($MEMBRESIAS as $membresia) { ?>
                                            <option value="<?= $membresia['ID_MEMBRESIA'] ?>">
                                                <?= $membresia['NOMBRE_MEMBRESIA'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>-->
                            <div id="opcion_buscar" class="col-lg-1">
                                <div class="form-group">
                                    <div class='input-group'>
                                        <label for="btnSearch" class="control-label text-left">&nbsp;</label>
                                        <button id="Buscar" class="btn btn-info" type="submit">
                                            <i class="fa fa-search"></i> Cargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="control-group text-left">
                        <div class="table-reportes">
                            <!-- Tabla de consultas -->
                            <table id="tablaReporte" class="table table-bordered text-center dataTable"
                                style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ver</th>
                                        <th class="text-center">Paciente</th>
                                        <th class="text-center">Médico</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Motivo</th>
                                        <th class="text-center">Diagnostico</th>
                                        <th class="text-center">Siguente cita</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_reportes" style="font-size: 14px; letter-spacing: 0.5px;">
                                    <?php
                                    if ($entries) {
                                        foreach ($entries as $entry) {
                                            var_dump($entry);
                                            if (isset($entry['NOMBRE_TARIFA'])) $tar_mem = $entry['NOMBRE_TARIFA'];
                                            if (isset($entry['NOMBRE_MEMBRESIA'])) $tar_mem = $entry['NOMBRE_MEMBRESIA'];
                                    ?>
                                            <tr>
                                                <td><?= $entry['NOMBRE_PACIENTE'] ?></td>
                                                <td><?= $entry['NOMBRE_USUARIO'] ?></td>
                                                <td><?= $entry['FECHA_CONSULTA'] ?></td>
                                                <td><?= $entry['HORA_CONSULTA'] ?></td>
                                                <!--<td><?= $tar_mem ?></td>-->
                                                <td><?= $entry['MOTIVO_CONSULTA'] ?></td>
                                                <td><?= $entry['DIAGNOSTICO_CONSULTA'] ?></td>
                                                <td><?= $entry['FECHA_CITA'] ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">No hay datos disponibles</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="ReporteByPatient">
    <div class="modal-dialog modal-dialogx modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal-headx">
                <span class="modal-title" id="myModalLabel">Reporte de ese <span style="color:#ffb53e">día</span></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pd-modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Fecha Ingreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                <input readonly="" type="text" name="RG_FECHA_FICHA" id="FECHA_INGRESO" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Hora ingreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <input readonly="" type="time" class="form-control " name="RG_HR_FICHA" id="HORA_INGRESO">
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Fecha egreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" class="form-control hasDatepicker" data-type="datepicker" placeholder="aaaa-mm-dd" readonly="" name="RG_FECHA_EGRESO" id="FECHA_EGRESO">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Hora egreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <input type="time" class="form-control require" readonly="" name="RG_HORA_EGRESO" id="HORA_EGRESO">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Motivo consulta :</label>
                            <textarea readonly="" class="form-control require" name="RG_MOTIVO_CONSULTA" id="MOTIVO" rows="5" placeholder="Escribe aquí.."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>