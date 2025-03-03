<!-- 
<html>
    <head>
        <title>CLINICA CAREYES</title>
        <link rel="shortcut icon" href="img/favicon.png" />-->
        <!--<script type="text/javascript">
            var raiz_url = '<?php echo base_url(); ?>';
        </script>
        <meta charset="utf-8">
        <meta content="utf-8" http-equiv="encoding">
        <meta http-equiv="conten-type" content="text/html; charset=UTF-8" />
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">

        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/jquery/jquery-ui-theme.css" rel="stylesheet" type="text/css"/>
        <link  href="<?php echo base_url();?>assets/plugins/fontAwesome/all.css" rel="stylesheet" >


        <script src="<?php echo base_url();?>assets/plugins/jquery/jquery1.9.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery/jquery-ui.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/login.js" type="text/javascript"></script>

        <style type="text/css">
            .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;


                &:focus {
                    z-index: 2;
                }
            }
            .login-form {
                margin-top: 40PX;
            }
            .btn-primaro:hover,
            .btn-primaro:focus,
            .btn-primaro:active{
                color: #000 !important;
                background:  #FFF !important;
                border-color: #FFF !important;
            }
            #btnEntrar{
                font-size: 20px important;
                color: #fff !important;
                background: #0404a4  !important;
                border-color: #0404a4 !important;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row" id="pwd-container">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <form  name="form" autocomplete="off" >
                        <section class="login-form" style="text-align: center;">
                            <img src="<?php echo base_url(); ?>assets/img/logo.png" class="img-responsive center-block" alt="CAREYES" />
                            <!--<label class="label-control text-center"><h3>Welcome</h3></label>
                            <div class="input-group mb-3">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input type="text" autocomplete="off" value="admin" name="RG_USERNAME_USUARIO" id="RG_USERNAME_USUARIO" placeholder="User name" required class="form-control input-lg" style=" height: 45px;" value="" />
                            </div><br>
                            <div class="input-group mb-3">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input type="password" autocomplete="off" value="admin" class="form-control input-lg" id="RG_PASSWD_USUARIO" name="RG_PASSWD_USUARIO" required style=" height: 45px;" placeholder="Password" value="" />
                            </div><hr>
                            <button type="button" name="btnEntrar" id="btnEntrar" class="btn btn-lg btn-block">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                Entrar
                            </button>
                        </section>
                    </form>
                    <br>
                    <p id="messages" class="pull-right" style="color:#F00;"></p>
                </div>
                <div class="col-sm-4"><br></div>
            </div>
        </div>
    </body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ZIANKA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/login/bootstrap.min.css">
<!--===============================================================================================-->
    <script> var raiz_url = '<?php echo base_url(); ?>'; </script>
  
     <link  href="<?php echo base_url();?>assets/plugins/login/font-awesome/css/font-awesome.min.css" rel="stylesheet" >
     <link  href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" >
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/login/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/login/main.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">

    
<!--===============================================================================================-->
</head>

<body>	
	<div class="limiter">
		<div class="container-login100">
            <div class="cssload-thecube hidex" id="loadercss">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
			<div class="wrap-login100 animated " id="MAIN">
				<div class="login100-pic js-tilt" data-tilt>
					<!--<img src="<?php echo base_url();?>assets/plugins/login/img-01.png" alt="IMG">-->
				</div>

				<form class="login100-form validate-form" id="LOGIN_FORM">
					<span class="login100-form-title">
						ZIANKA
					</span>

					<div class="wrap-input100 validate-input" data-validate = "El usuario es requerido">
                        <input class="input100" type="text" autocomplete="off" name="user" placeholder="Usuario"
                        name="RG_USERNAME_USUARIO" id="RG_USERNAME_USUARIO">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "La contraseña es requerida">
                        <input class="input100" type="password" name="pass" placeholder="Contraseña"
                        id="RG_PASSWD_USUARIO" name="RG_PASSWD_USUARIO">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" name="btnEntrar" id="btnEntrar" class="login100-form-btn">
							Iniciar sesión
						</button>
                    </div>		
                    <p id="messages" style="color:#F00;"></p>	
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
    <script src="<?php echo base_url();?>assets/plugins/login/jquery-3.2.1.min.js"></script>
    
<!--===============================================================================================-->
    <script src="<?php echo base_url();?>assets/plugins/login/popper.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/login/bootstrap.min.js"></script>
    
    <script src="<?php echo base_url();?>assets/js/login.js"></script>
<!--===============================================================================================-->
    <script src="<?php echo base_url();?>assets/plugins/login/main.js"></script>

<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/plugins/login/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: .9
		})
	</script>
<!--===============================================================================================-->
</body>
</html>