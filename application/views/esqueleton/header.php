<!DOCTYPE html>
<html>
    <head>
        <title>ZIANKA</title>
        <!--<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"  />-->
        <script type="text/javascript">
            var raiz_url = '<?php echo base_url() ?>';
        </script>
        <meta charset="utf-8">
        <meta content="utf-8" http-equiv="encoding">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="conten-type" content="text/html; charset=UTF-8" />
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
            
        <!-- Jquery + plugins -->
        <link  href="<?php echo base_url(); ?>assets/plugins/jquery/jquery-ui-theme.css" rel="stylesheet"/>         
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery1.9.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-ui.js"></script>
        <link  href="<?php echo base_url(); ?>assets/plugins/jquery/jquery.toast.min.css" rel='stylesheet'>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.toast.min.js"></script>
     
        <!-- Full calendar -->
        <link  href='<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
        <link  href='<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
        <script src='<?php echo base_url();?>assets/plugins/fullcalendar/moment.min.js'></script>
        <script src="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.min.js" ></script>
        <script src="<?php echo base_url();?>assets/plugins/fullcalendar/lang-all.js" ></script>

        <!-- Bootstrap CSS3 -->
        <link  href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet"/>
        <link  href="<?php echo base_url();?>assets/plugins/bootstrap/jasny-bootstrap.min.css" rel="stylesheet"/>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.js" ></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/validator.js" ></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/jasny-bootstrap.min.js" ></script>
        <!-- <link  href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css"  rel="stylesheet"> -->
        <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script> -->
        
        <!-- Plugins externos  -->
        <link  href="<?php echo base_url();?>assets/plugins/fontAwesome/all.css" rel="stylesheet" >
        <link  href="<?php echo base_url();?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/plugins/select2/select2.min.js"></script>  
        <link  href="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert2.js"></script>
  
        <!-- validación para campos numericos -->
        <script src="<?php echo base_url(); ?>assets/js/input.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.numeric.min.js" type="text/javascript"></script>
  
        <!--Datatables-->
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css"> -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/dataTables/dataTables.bootstrap.min.css">
        <!-- <script src="<?php echo base_url();?>assets/plugins/dataTables/dataTables.bootstrap4.min.js" type="text/javascript"></script> -->
        <script src="<?php echo base_url();?>assets/plugins/dataTables/dataTables.jquery.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
        

        <!--Scripts del sitio-->
        <script src="<?php echo base_url();?>assets/js/patient.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/reportes.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/urgency.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/receta.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/consult.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/inventary.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/config.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/schedule.js?v=<?= VERSION ?>"></script>
        <script src="<?php echo base_url();?>assets/js/filesaver.js?v=<?= VERSION ?>"></script>
        
        <!--Estilos del sitio-->
        <link href="<?php echo base_url();?>assets/css/atlantis.css?v=<?= VERSION ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();?>assets/css/styles.css?v=<?= VERSION ?>"   rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();?>assets/css/animate.css"  rel="stylesheet" type="text/css"/>


    </head>
    <style>
    .header-ul{
        text-transform: uppercase;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.5px;
    }
    

    </style>
    <body>
        <div class="wrapper" id="wrap"  >
            <div class="container-fluid " id="header_webpage">
                <header class="hero-unit">
                    <div class="nav_ma" >
                        <nav class="navbar navbar-inverse navbar-expand-lg navbar-fixed-top" style="background-color:#FFF;">
                            <div class="container container-navx">
                                <div class="navbar-header" style="background:#08296c">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav_ma_toggle">
                                        <span class="sr-only">Navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="<?= base_url()?>">
                                        <img src="<?= base_url(); ?>/assets/img/logo.png" width="70" class=" img-responsive img-index" alt="GRWS">
                                    </a>
                                </div>
                                <div id="nav_ma_toggle" class="navbar-collapse collapse">
                                    <ul class="nav navbar-nav navbar-right header-ul">
                                        <li <?=$classIni?>> <a href="<?= base_url(); ?>Inicio/index"><i class="fa fa-hospital" ></i> Inicio</a></li>
                                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == MEDICO || $this->session->userdata('CAREYES_ID_ROL') == RECEPCION){ ?>
                                        <li <?=$classSch?>> <a href="<?= base_url(); ?>Schedule/index"><i class="fa fa-calendar" ></i> Citas</a></li>
                                        <li <?=$classPat?>> <a href="<?= base_url(); ?>Patient/index"><i class="fa fa-users"></i> Pacientes</a></li>
                                        <?php } ?>
                                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == ALMACEN){ ?>
                                        <li <?=$classInv?>> <a href="<?= base_url(); ?>Inventary/index"><i class="fa fa-pills" ></i> Inventario</a></li>
                                        <?php } ?>
                                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR){ ?>
                                        <li <?=$classRep?>> <a href="<?= base_url(); ?>Report/consultas"><i class="fas fa-file-invoice"></i> Reportes</a></li>
                                        <?php } ?>
                                        <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR || $this->session->userdata('CAREYES_ID_ROL') == MEDICO || $this->session->userdata('CAREYES_ID_ROL') == RECEPCION){ ?>
                                        <li <?=$classCon?>> <a href="<?= base_url(); ?>Consult/index"><i class="fa fa-stethoscope"></i> Consultas</a></li>
                                        <li <?=$classUrg?>> <a href="<?= base_url(); ?>Urgency/index"><i class="fa fa-hospital-symbol"></i> Urgencias</a></li>
                                        <?php } ?>
                                        <li class="dropdown <?=$classCfg?>">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
                                                <i class="fa fa-cog" aria-hidden="true"></i>
                                                <?=  mb_strtoupper( $this->session->userdata('CAREYES_NOMBRE_USUARIO'));?> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <?php if($this->session->userdata('CAREYES_ID_ROL') == ADMINISTRADOR){ ?>
                                                <li <?=$classCfg?>><a href="<?= base_url() ?>config/index" style="color: #333"><i class="fa fa-cog"></i>  Configuración</a></li>
                                                <?php } ?>
                                                <li><a href="<?= base_url() ?>login/salir" style="color: #333"><b><i class="fa fa-sign-out-alt"></i>  Salir</b></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <!--/.nav-collapse -->
                            </div>
                            <!--/.container-fluid -->
                        </nav>
                    </div>
                </header>
            </div>

            <div class="push" id="push" >
