<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 "><br>
            <?php $this->view('Reportes/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9"><br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-home"></i>
                            CASAS</span>
                    </div>
                </div>
                <div class="panel-body">
                    <form id="formSearchHouses" method="POST">
                        <div class="row">							
                            <div id="opcion_paciente">
                                <div class="col-lg-4 text-left">
                                <div class="form-group">
                                    <label class="control-label text-left">Fecha inicio</label>
                                    <div class='input-group date' id='fechaInicio'>
                                        <span class="input-group-addon">Desde</span>
                                        <input type="text" name="RG_FECHA_INICIAL" data-type="datepicker" readonly="" required id="RG_FECHA_INICIAL"
                                        class="form-control" placeholder="Desde"
                                        value="<?= date('d/m/Y', strtotime('-1 months')); ?>">
                                        <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Fecha fin</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">Hasta</span>
                                        <input type="text" name="RG_FECHA_FINAL" data-type="datepicker" readonly="" required id="RG_FECHA_FINAL" class="form-control"
                                        placeholder="Hasta" value="<?= date('d/m/Y'); ?>">
                                        <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            </div><br>
                            <div id="opcion_buscar" class="col-lg-3">
                                <div class="form-group">
                                    <label for="btnSearch" class="control-label text-left">&nbsp;</label>
                                    <button id="btnSearchHouses" class="btn btn-info" type="button">
                                        <i class="fa fa-search"></i> Cargar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <input type="hidden" name="id_paciente" id="id_paciente" >
                </div>
                <hr>
                <div class="control-group text-left">
                    <div class="table-reportes">
                        <!-- Tabla de consultas -->
                        <table id="tablaReportes" class="table table-bordered text-center"
                               style="font-size: 14px; border-radius:5px" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Casa</th>
                                    <th class="text-center">Consulta</th>
                                    <th class="text-center">Urgencias</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_houses" style="font-size: 14px; letter-spacing: 0.5px;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
