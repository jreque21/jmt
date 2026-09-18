<?php
@session_start();

// Importar funcionalidades
require_once("../config/global.php");  
require_once(DEF_PATH_ADMIN);

// Instanciar clase de la B.D
$bd = new baseDatos();
$crud = new crud();

// Inicializar variable
$lb_result  = true;

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
	$ldt_fecha_insercion = date('Y-m-d h:i:s');
	
	// ======================================= CRUD REGISTRAR =========================================== //
	if ($lb_result == true) {

		// Definir estructura
		$array_campo	= array('N_COD_MATRICULA', 'N_ITEM', 'D_FEC_PAGO', 'N_COD_MONEDA', 'N_MONTO', 
								'N_COD_MEDIOPAGO', 'V_COMPROBANTE', 'V_OBSERVACION', 'V_FLAG_ESTADO', 'V_AUD_USR_REG', 'D_AUD_FEC_REG');
		$array_valor	= array($li_cod_matricula, $li_item, $ld_fec_pago, $li_cod_moneda, $li_monto, 
								$li_cod_mediopago, $ls_comprobante, $ls_observacion, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_insercion);
		
		// Invocar inserción
		$lb_result = $crud->fila_registrar(DEF_TABLA_PAGO, $array_campo, $array_valor, '0');

		// Actualizar Check de Pago
		if($lb_result == true) {
			$lb_result = $crud->f_update_saldoPendiente($li_cod_matricula);
		}

	}
	// ===================================== FIN CRUD REGISTRAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_pago_lista.php?id_codigo_padre=".$li_cod_matricula); 
	}
	else {
		header("Location: ../vista/mov_pago_nuevo.php?id_codigo_padre=".$li_cod_matricula."&id_respuesta='".$ls_mensaje."'"); 
	}
					
}

?>