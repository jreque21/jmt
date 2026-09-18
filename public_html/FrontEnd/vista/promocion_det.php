<?php
@session_start();
require_once("../lib_frontend.php");

// Controlar sesión activa
if(!isset($_SESSION['logged_in_numdoc']) && !$_SESSION['logged_in_numdoc']){
	header('Location: '+ DEF_URL_LOGIN_INTRANET);
}

// Carga
f_loag_pagina();
f_seccion_cargando();

// Capturar Padre
$id_codigo_padre = $_GET["id_codigo"];
?>
<div class="page">
	<?php	
	f_seccion_menu('promociones');
	f_seccion_promocion_det($id_codigo_padre);	
	f_seccion_pie();
	?>
</div>
<?php
f_close_pagina();
?>    