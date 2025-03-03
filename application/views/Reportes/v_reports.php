
<div class="container-fluid">
    <div class="row"><br></div>
    <div class="row">
        <div class="col-sm-2">
            <?php $this->view('Reportes/v_navbar'); ?>
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Consultas</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Consultas por Tarifas</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="pie-chart" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Consultas por Membresias</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="doughnut-chart" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sel1=""; $sel2=""; $sel3="";
            if($ID_MEMBRESIA==1) $sel1="selected";
            if($ID_MEMBRESIA==3) $sel2="selected";
            if($ID_MEMBRESIA==5) $sel3="selected";
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Membresias por casa
                        </div>
                        <div class="panel-body">
                            <form id="form_membresia" method="POST" action="<?= base_url() ?>report/grafica">
                                <select class="form-control" id="ID_MEMBRESIA_S" name="ID_MEMBRESIA_S">
                                    <option <?=$sel1?> value="1">Plata</option>
                                    <option <?=$sel2?> value="3">Oro</option>
                                    <option <?=$sel3?> value="5">Platino</option>
                                </select>
                            </form>
                            <div class="canvas-wrapper">
                                <canvas class="main-chart" id="bar-chart" height="200" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN CONSULTAS -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Urgencias</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="main-chart" id="line-chart2" height="200" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Urgencias por Tarifas</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="pie-chart2" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Urgencias por Membresias</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <canvas class="chart" id="doughnut-chart2" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sel_1=""; $sel_2=""; $sel_3="";
            if($ID_MEMBRESIAU==1) $sel_1="selected";
            if($ID_MEMBRESIAU==3) $sel_2="selected";
            if($ID_MEMBRESIAU==5) $sel_3="selected";
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Membresias por casa
                        </div>
                        <div class="panel-body">
                            <form id="form_membresiau" method="POST" action="<?= base_url() ?>report/grafica">
                                <select class="form-control" id="ID_MEMBRESIA_U" name="ID_MEMBRESIA_U">
                                    <option <?=$sel_1?> value="1">Plata</option>
                                    <option <?=$sel_2?> value="3">Oro</option>
                                    <option <?=$sel_3?> value="5">Platino</option>
                                </select>
                            </form>
                            <div class="canvas-wrapper">
                                <canvas class="main-chart" id="bar-chartu" height="200" width="600"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/lumino.glyphs.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/chart-data.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/chart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/easypiechart.js" type="text/javascript"></script>