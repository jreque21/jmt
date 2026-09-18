<?php
@session_start();
require_once("../lib_frontend.php");

// Controlar sesión activa
if(!isset($_SESSION['logged_in_numdoc']) && !$_SESSION['logged_in_numdoc']){
	header('Location: '+ DEF_URL_LOGIN_INTRANET);
}

// Capturar Variable GET Msg Rpta
if (isset($_GET['id_msgRpta'])) {
	$ls_msgRpta = $_GET["id_msgRpta"];
}else{
	$ls_msgRpta = '';
}

// Carga
f_loag_pagina();
f_seccion_cargando();

?>
<div class="page">
	<?php	
	f_seccion_menu('index');
	f_seccion_cambiarclave($ls_msgRpta);	
	f_seccion_pie();
	?>
</div>
<?php
f_close_pagina();
?>