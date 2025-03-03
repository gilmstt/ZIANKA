<style>
    html{ background:#f0f0f0;}
</style>
<div class="container-fluid" style="background:#f0f0f0;">
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-sm-12 col-lg-10 text-center">
            <br />
            <div class="panel panel-primary" style="background:#f0f0f0;box-shadow:none">
                <div class="panel-heading header-primary" style="border-radius:10px">
                    <div class="panel-title text-center">
                        <span class="heading-primary">Inicio</span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == MEDICO || $this->session->userdata('CAREYES_ID_ROL') == RECEPCION){ ?>
                        <a href="<?= base_url(); ?>patient/index">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-azul">
                                       <i class="fa fa-users fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        PACIENTES
                                    </p>
                                    <h3 class="jss956">
                                        <?= $countPaciente ?><small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961" style="color: #1766cc;">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ver los pacientes
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == ALMACEN){ ?>
                        <a href="<?= base_url() ?>inventary/index">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-naranja">
                                        <i class="fa fa-pills fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        INVENTARIO
                                    </p>
                                    <h3 class="jss956">
                                        <?= $countInventario ?><small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ir al inventario
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == MEDICO || $this->session->userdata('CAREYES_ID_ROL') == RECEPCION){ ?>
                        <a href="<?= base_url() ?>consult/index">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-rojo">
                                        <i class="fa fa-stethoscope fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        CONSULTAS
                                    </p>
                                    <h3 class="jss956">
                                        <?= $countConsulta ?><small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ver las consultas
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR){ ?>
                        <a href="<?= base_url() ?>report/consultas">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-rojo">
                                        <i class="fas fa-file-invoice fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        REPORTES
                                    </p>
                                    <h3 class="jss956"> <small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ver los reportes
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == MEDICO || $this->session->userdata('CAREYES_ID_ROL') == RECEPCION){ ?>
                        <a href="<?= base_url() ?>urgency/index">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-morado">
                                        <i class="fa fa-hospital-symbol fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        URGENCIAS
                                    </p>
                                    <h3 class="jss956">
                                        <?= $countUrgencia ?><small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ir a urgencias
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR){ ?>
                        <a href="<?= base_url() ?>config/config_user">
                        <div class="col-lg-4 text-center">
                            <div class="jss442">
                                <div class="jss459 jss467 jss464 jss465">
                                    <div class="jss473 jss474 bg-gris">
                                        <i class="fa fa-cog fa-4x"></i>
                                    </div>
                                    <p class="jss959">
                                        CONFIGURACIÓN
                                    </p>
                                    <h3 class="jss956">
                                         <small></small>
                                    </h3>
                                </div>
                                <div class="jss938 jss943">
                                    <div class="jss961">
                                        <div class="jss967 jss977">
                                            <i class="fas fa-link"></i>
                                        </div>  
                                        Ver confinguración
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <br />
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>