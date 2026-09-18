<?php 
ob_start();
session_start();
require_once("../modelo/class_usuario.php"); 
require_once("../config/global.php");
?>
<?php 
	if( !empty( $_POST )){
		try {
			$user_obj = new usuario();
			$data = $user_obj->f_usuario_login( $_POST );
			if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
				header('Location: panel_admin.php');
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
	}
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
		header('Location: panel_admin.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
	<!-- Metas Bootstrap -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<!-- Meta String -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    
	<!-- Título -->
    <title>:: <?php echo TITULO_PANEL?> ::</title>
	
	<!-- Favicon -->
    <link rel="shortcut icon" href="../recursos/images/favicon.ico" type="image/x-icon" />
	
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../recursos/css/bootstrap.min.css">
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../recursos/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	
	<!-- Estilo Personalizado -->
    <link rel="stylesheet" href="../recursos/css/style_login.css">
	
	<!-- jQuery 3 -->  
	<script src="../recursos/js/jquery.min.js"></script>
	
	<!-- Bootstrap 3.3.7 -->
	<script src="../recursos/js/bootstrap.min.js"></script>
    	
  </head>
  
  <body>
	<div class="container">
		<div class="login-form">
			<?php require_once 'Layout/login_aviso.php';?>
			<div class="form-header">				
				<img src="../../website/recursos/images/Logo.png" width="140px" class="img-circle" alt="Logo">				
			</div>
			<form id="login-form" method="post" class="form-signin" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
				
				<div class="form-group">
					<label for="id_usuario">Usuario</label>
					<input name="id_usuario" id="id_usuario" type="text" class="form-control" placeholder="Ingrese usuario" maxlength="10" required autofocus> 
				</div>
				
				<div class="form-group">
					<label for="id_clave">Contraseña</label>
					<input name="id_clave" id="id_clave" type="password" class="form-control" placeholder="Ingrese contraseña" maxlength="20" required>
				</div>
				<button class="btn btn-block bt-login" type="submit" id="submit_btn" data-loading-text="Iniciando....">Iniciar sesión</button>
			
			</form>
			<div class="form-footer">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<i class="fa fa-lock"></i>
						<a href="forget_password.php"> Olvidó su contraseña? </a>					
					</div>					
					<div class="col-xs-6 col-sm-6 col-md-6">
						<i class="fa fa-check"></i>
						Copyright &copy; <?php echo COPYRIGHT ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /container -->
    <script src="../recursos/js/jquery.validate.min.js"></script>
    <script src="../recursos/js/login.js"></script>
  </body>
  
</html>
<?php ob_end_flush(); ?>
