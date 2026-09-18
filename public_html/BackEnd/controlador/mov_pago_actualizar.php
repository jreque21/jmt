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
	$li_cod_matricula	= $bd->bd_escapeCadena($_POST['id_cod_matricula_hide']);
	$li_item			= $bd->bd_escapeCadena($_POST['id_item_hide']);
	$ld_fec_pago		= $bd->bd_escapeCadena($_POST['id_fec_pago']);
	$li_cod_moneda		= $bd->bd_escapeCadena($_POST['id_cod_moneda']);
	$li_monto			= $bd->bd_escapeCadena($_POST['id_monto']);
	$li_cod_mediopago	= $bd->bd_escapeCadena($_POST['id_cod_mediopago']);
	$ls_comprobante		= $bd->bd_escapeCadena($_POST['id_comprobante']);	
	$ls_observacion		= $bd->bd_escapeCadena($_POST['id_observacion']);
	$ls_flag_estado		= '1';

	// Obtener datos iniciales
	$ldt_fecha_actualizacion = date('Y-m-d h:i:s');

	// ======================================= CRUD ACTUALIZAR =========================================== //
	
	// Definir estructura
	$array_campo_pk	= array('N_COD_MATRICULA', 'N_ITEM');
	$array_valor_pk	= array($li_cod_matricula, $li_item);
	$array_campo	= array('D_FEC_PAGO', 'N_COD_MONEDA', 'N_MONTO', 
							'N_COD_MEDIOPAGO', 'V_COMPROBANTE', 'V_OBSERVACION', 'V_FLAG_ESTADO', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
	$array_valor	= array($ld_fec_pago, $li_cod_moneda, $li_monto, 
							$li_cod_mediopago, $ls_comprobante, $ls_observacion, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
	// Invocar Actualización
	$lb_result = $crud->fila_actualizar(DEF_TABLA_PAGO, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);
	
	// Actualizar Check de Pago
	if($lb_result == true) {
		$lb_result = $crud->f_update_saldoPendiente($li_cod_matricula);
	}
	// ===================================== FIN CRUD ACTUALIZAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_pago_lista.php?id_codigo_padre=".$li_cod_matricula); 
	}
	else {
		header("Location: ../vista/mov_pago_editar.php?id_codigo=".$_POST["id_codigo"]);
	}
	
}

?>
