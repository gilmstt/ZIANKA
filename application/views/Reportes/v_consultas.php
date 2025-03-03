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
                            CONSULTAS</span>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="formSearchConsultas" method="POST">
                        <!-- Tarifas y fecha -->
                        <div class="row text-left">
                            <div class="col-md-3 text-left">
                                <div class="form-group">
                                    <label class="control-label text-left">Elige un rango de fechas</label>
                                    <div class='input-group'>
                                        <span class="input-group-addon">Desde</span>

                                        <input type="text" data-type="datepicker" name="RG_FECHA_INICIAL" required
                                               id="RG_FECHA_INICIAL" class="form-control" placeholder="Desde" readonly
                                               value="<?= date('d/m/Y', strtotime('-1 month')); ?>">
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
                            <div class="col-md-3 text-left">
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
                            </div>
                        </div>
                        <!-- Busqueda por medico / paciente -->
                        <div class="row">
                                <!-- <input type="hidden" name="RG_BUSCAR" id="RG_BUSCAR" value="1"> -->								
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="BUSCAR_POR" class="control-label" style="color: #9C27B0;">Buscar
                                        por</label>
                                    <select id="BUSCAR_POR" name="BUSCAR_POR" class="form-control">
                                        <option selected value="0">Todos</option>
                                        <option value="1">Medico</option>
                                        <option value="2">Paciente</option>
                                    </select>
                                </div>
                            </div>								
                        </div>								
                        <div class="row">							
                            <div id="opcion_medico" style="display: none">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="SEARCH_APP" class="control-label text-left">Apellido(s)</label>
                                        <input type="text" name="SEARCH_AP_MEDICO" id="SEARCH_AP_MEDICO" class="form-control"
                                               placeholder="Paterno">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="SEARCH_CLIENT" class="control-label text-left">Nombre(s)</label>
                                        <input type="text" name="SEARCH_NOMBRE_MEDICO" id="SEARCH_NOMBRE_MEDICO"
                                               class="form-control" placeholder="Nombre(s)">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="opcion_paciente" style="display: none">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="SEARCH_APP" class="control-label text-left">Apellido paterno</label>
                                        <input type="text" name="SEARCH_APP_PACIENTE" id="SEARCH_APP_PACIENTE"
                                               class="form-control" placeholder="Paterno">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="SEARCH_APM" class="control-label text-left">Apellido materno</label>
                                        <input type="text" name="SEARCH_APM_PACIENTE" id="SEARCH_APM_PACIENTE"
                                               class="form-control" placeholder="Materno">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="SEARCH_CLIENT" class="control-label text-left">Nombre(s)</label>
                                        <input type="text" name="SEARCH_NOMBRE_PACIENTE" id="SEARCH_NOMBRE_PACIENTE"
                                               class="form-control" placeholder="Nombre(s)">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>
                            <div id="opcion_buscar" class="col-lg-1">
                                <div class="form-group">
                                    <label for="btnSearch" class="control-label text-left">&nbsp;</label>
                                    <button id="Buscar" class="btn btn-info" type="submit">
                                        <i class="fa fa-search"></i> Cargar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="control-group text-left">
                    <div class="table-reportes">
                        <!-- Tabla de consultas -->
                        <table id="tablaReportes" class="table table-bordered text-center"
                               style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Paciente</th>
                                    <th class="text-center">Médico</th>
                                    <th class="text-center">Tar/Mem</th>
                                    <th class="text-center">Motivo</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Hora</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_reportes" style="font-size: 14px; letter-spacing: 0.5px;">
                                <?php
                                if ($entries) {
                                    foreach ($entries as $entry) {
                                        //var_dump($entry);
                                        if(isset($entry['NOMBRE_TARIFA'])) $tar_mem = $entry['NOMBRE_TARIFA'];
                                        if(isset($entry['NOMBRE_MEMBRESIA'])) $tar_mem = $entry['NOMBRE_MEMBRESIA'];
                                        ?>
                                        <tr>
                                            <td><?= $entry['NOMBRE_PACIENTE'] ?></td>
                                            <td><?= $entry['NOMBRE_USUARIO'] ?></td>
                                            <td><?= $tar_mem ?></td>
                                            <td><?= $entry['MOTIVO_CONSULTA'] ?></td>
                                            <td><?= $entry['FECHA_CONSULTA'] ?></td>
                                            <td><?= $entry['HORA_CONSULTA'] ?></td>
                                        </tr>
                                        <?php
                                    }
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