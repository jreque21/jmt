<?php
@session_start();

// Importar funcionalidades
require_once("../config/global.php");  
require_once(DEF_PATH_ADMIN);

// Instanciar clase de la B.D
$bd = new baseDatos();
$crud = new crud();

// Según Caso
if (isset($_GET['id_codigo'])) { 		// Esta siendo invocado desde Lista
	$li_codigo = $_GET["id_codigo"];
	$lb_form   = false;
}else{									// Esta siendo invocado desde Formulario
	$li_codigo = $bd->bd_escapeCadena($_POST['id_codigo']);
	$lb_form   = true;	
}

// ======================================== PRE ACEPTAR ============================================= //
// Definir estructura
$array_campo_pk	= array('N_COD_TRASLADO', 'V_FLAG_ESTADO');
$array_valor_pk	= array($li_codigo, '2');

// Invocar CRUD
$li_contador = $crud->fila_contar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk);
if ( $li_contador > 0 ) {
	$ls_mensaje	= 'Solicitud de Traslado ya se encuentra en estado Aprobado.';
}
if ($li_contador == 0) {
	// Definir estructura
	$array_campo_pk	= array('N_COD_TRASLADO', 'V_FLAG_ESTADO');
	$array_valor_pk	= array($li_codigo, '0');
	$li_contador = $crud->fila_contar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk);
	if ( $li_contador > 0 ){
		$ls_mensaje	= 'Solicitud de Traslado ya se encuentra en estado Rechazado.';
	}
}

// Controlar Error
if ( $li_contador > 0 ) {
	// Redireccionar
	header("Location: ../vista/mov_trasladoaprob_lista.php?id_msgRpta=".$ls_mensaje);
	return;
}
// ======================================= FIN PRE ACEPTAR =========================================== //

// ======================================== CRUD ACEPTAR ============================================= //
// Obtener datos iniciales
$ldt_fecha_actualizacion = date('Y-m-d h:i:s');
$ls_flag_estado          = '2';

// Definir estructura
$array_campo_pk	= array('N_COD_TRASLADO');
$array_valor_pk	= array($li_codigo);
$array_campo	= array('V_FLAG_ESTADO', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
$array_valor	= array($ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
// Invocar Actualización
$lb_result = $crud->fila_actualizar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);

// Capturar User
$ls_user = $_SESSION['usr_conectado'];

// Invocar SP para poblar tabla detalle
$lb_result = $crud->ejecutar_sp("call sp_generar_estudiantesede('$li_codigo','$ls_user')");

// ======================================= FIN CRUD ACEPTAR =========================================== //

// Redireccionar
if($lb_result == true) {
	header("Location: ../vista/mov_trasladoaprob_lista.php");
}
else {
	$ls_mensaje	= 'No se pudo completar acción de forma satisfactoria.';
	header("Location: ../vista/mov_trasladoaprob_lista.php?id_msgRpta=".$ls_mensaje);
}

?>