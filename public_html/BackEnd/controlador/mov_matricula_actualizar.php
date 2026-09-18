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
	$li_cod_horario		= $bd->bd_escapeCadena($_POST['id_cod_horario_hide']);
	$li_cod_estudiante	= $bd->bd_escapeCadena($_POST['id_cod_estudiante']);
	$li_monto_tarifa	= $bd->bd_escapeCadena($_POST['id_monto_tarifa']);
	$li_monto_descuento	= $bd->bd_escapeCadena($_POST['id_monto_descuento']);
	$li_monto_neto		= $li_monto_tarifa - $li_monto_descuento;
	$li_cod_moneda		= $bd->bd_escapeCadena($_POST['id_cod_moneda']);
	$li_cod_formapago	= $bd->bd_escapeCadena($_POST['id_cod_formapago']);
	$li_cod_mediopago	= $bd->bd_escapeCadena($_POST['id_cod_mediopago']);
	$ls_flag_pago		= $bd->bd_escapeCadena($_POST['id_flag_pago']);
	$ls_comprobante		= $bd->bd_escapeCadena($_POST['id_comprobante']);
	$ld_fec_inicio		= $bd->bd_escapeCadena($_POST['id_fec_inicio']);	
	$ls_flag_estado		= '1';
	
	// Gestionar Checks
	if ($li_cod_formapago == '00001'){ // Al contado
		$ls_flag_pago = '1';
	}else{
		$ls_flag_pago = '0';
	}

	// Obtener datos iniciales
	$ldt_fecha_actualizacion = date('Y-m-d h:i:s');

	// ======================================= CRUD ACTUALIZAR =========================================== //
	
	// Definir estructura
	$array_campo_pk	= array('N_COD_MATRICULA');
	$array_valor_pk	= array($li_codigo);
	$array_campo	= array('N_COD_HORARIO', 'N_COD_ESTUDIANTE', 'N_MONTO_TARIFA', 'N_MONTO_DSCTO', 'N_MONTO_NETO',
							'N_COD_MONEDA', 'N_COD_FORMAPAGO', 'V_FLAG_PAGO', 'N_COD_MEDIOPAGO', 'V_COMPROBANTE',
							'D_FEC_INICIO', 'V_FLAG_ESTADO', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
	$array_valor	= array($li_cod_horario, $li_cod_estudiante, $li_monto_tarifa, $li_monto_descuento, $li_monto_neto,
							$li_cod_moneda, $li_cod_formapago, $ls_flag_pago, $li_cod_mediopago, $ls_comprobante,
							$ld_fec_inicio, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
	// Invocar Actualización
	$lb_result = $crud->fila_actualizar(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);
	
	// ===================================== FIN CRUD ACTUALIZAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_matricula_lista.php?id_codigo_padre=".$li_cod_horario); 
	}
	else {
		header("Location: ../vista/mov_matricula_editar.php?id_codigo=".$_POST["id_codigo"]);
	}
	
}

?>
