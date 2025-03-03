<?php 
$CI = & get_instance();
$USO = $CI->db->get('uso_interno')->result_array();

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3">
            <?php $this->view('Inventary/v_navbar'); ?>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9 text-center animated fadeIn">
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading header-primary">
                    <div class="panel-title text-left"><span class="heading-primary"><i class="fas fa-briefcase"></i> USO INTERNO</span>
                        <a href="<?= base_url() ?>inventary/add_usage" class="btn btn-header pull-right">
                            <i class="fa fa-plus-circle" prescription-bottle aria-hidden="true"></i> Registrar Uso
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group text-left">
                        <div>
                            <table id="dataUsage" class="table table-bordered table-striped text-center fz-table">
                                <thead>
                                    <tr>
                                        <th width="10%">Acciones</th>
                                        <th width="20%">Fecha</th>                                                                            
                                        <th width="50%">Descripción</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <?php 
                                foreach ($USO as $row) {

                                    $desc = $row['DESCRIPCION'];
                                    $id = $row['ID_USO'];
                                    $date = $row['FECHA'];
                                    echo "<tr>".
                                    "<td>$id</td>".
                                    "<td>$date</td>".
                                    "<td>$desc</td>".
                                    
                                    "<tr>";
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
