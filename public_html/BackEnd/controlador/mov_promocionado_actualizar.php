<?php
@session_start();

// Importar funcionalidades
require_once("../config/global.php");  
require_once(DEF_PATH_ADMIN);

// Instanciar clase de la B.D
$bd = new baseDatos();
$crud = new crud();

// Validar ingreso de datos
if(isset($_POST) && !empty($_POST)){
	
	// Almacenar contenido con escape
	$li_codigo			= $bd->bd_escapeCadena($_POST['id_codigo']);
	$li_cod_promocion	= $bd->bd_escapeCadena($_POST['id_cod_promocion_hide']);
	$li_cod_estudiante	= $bd->bd_escapeCadena($_POST['id_cod_estudiante']);
	$ld_fec_prog		= $bd->bd_escapeCadena($_POST['id_fec_prog']);
	$ld_hora_prog		= $bd->bd_escapeCadena($_POST['id_hora_prog']);
	$li_cod_cinturon_actual	= $bd->bd_escapeCadena($_POST['id_cod_cinturon_actual']);
	$li_cod_cinturon_nuevo	= $bd->bd_escapeCadena($_POST['id_cod_cinturon_nuevo']);
	$li_cod_moneda		= $bd->bd_escapeCadena($_POST['id_cod_moneda']);
	$li_monto			= $bd->bd_escapeCadena($_POST['id_monto']);
	$li_cod_mediopago	= $bd->bd_escapeCadena($_POST['id_cod_mediopago']);
	$ls_comprobante		= $bd->bd_escapeCadena($_POST['id_comprobante']);
	$ls_flag_pago		= $bd->bd_escapeCadena($_POST['id_flag_pago']);
	$ls_observacion		= $bd->bd_escapeCadena($_POST['id_observacion']);
	$ls_flag_prog		= '1';

	// Gestionar estado
	if ($ls_flag_pago != '1') {
		$ls_flag_pago = '0';
	}
	
	// Obtener datos iniciales
	$ldt_fecha_actualizacion = date('Y-m-d h:i:s');

	// ======================================= CRUD ACTUALIZAR =========================================== //
	
	// Definir estructura
	$array_campo_pk	= array('N_COD_PROMOCION', 'N_COD_ESTUDIANTE');
	$array_valor_pk	= array($li_cod_promocion, $li_cod_estudiante);
	$array_campo	= array('N_COD_CINTURON_ACTUAL', 'N_COD_CINTURON_NUEVO', 'D_FEC_PROG', 'D_HORA_PROG', 
							'N_COD_MONEDA', 'N_MONTO', 'N_COD_MEDIOPAGO', 'V_COMPROBANTE', 'V_FLAG_PAGO',
							'V_OBSERVACION', 'V_FLAG_PROG', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
	$array_valor	= array($li_cod_cinturon_actual, $li_cod_cinturon_nuevo,$ld_fec_prog, $ld_hora_prog,
							$li_cod_moneda, $li_monto, $li_cod_mediopago, $ls_comprobante, $ls_flag_pago,
							$ls_observacion, $ls_flag_prog, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
	// Invocar Actualización
	$lb_result = $crud->fila_actualizar(DEF_TABLA_PROMOCIONPROG, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);
	
	// ===================================== FIN CRUD ACTUALIZAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_promocionado_lista.php?id_codigo_padre=".$li_cod_promocion); 
	}
	else {
		header("Location: ../vista/mov_promocionado_editar.php?id_codigo=".$_POST["id_codigo"]);
	}
	
}

?>
