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

?>
<div class="page">
	<?php	
	f_seccion_menu('index');
	f_seccion_asistencia($_SESSION['N_COD_REFERENCIA']);
	f_seccion_pie();
	?>
</div>
<?php
f_close_pagina();
?>    