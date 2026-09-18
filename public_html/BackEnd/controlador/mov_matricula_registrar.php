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
	$li_cod_horario		= $bd->bd_escapeCadena($_POST['id_cod_horario_hide']);
	$li_cod_estudiante	= $bd->bd_escapeCadena($_POST['id_cod_estudiante']);
	$li_monto_tarifa	= $bd->bd_escapeCadena($_POST['id_monto_tarifa']);
	$li_monto_descuento	= $bd->bd_escapeCadena($_POST['id_monto_descuento']);
	$li_monto_neto		= $li_monto_tarifa - $li_monto_descuento;
	$li_cod_moneda		= $bd->bd_escapeCadena($_POST['id_cod_moneda']);
	$li_cod_formapago	= $bd->bd_escapeCadena($_POST['id_cod_formapago']);
	$li_cod_mediopago	= $bd->bd_escapeCadena($_POST['id_cod_mediopago']);
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
	$ldt_fecha_insercion = date('Y-m-d h:i:s');
	$ld_fec_matricula	 = date('Y-m-d');
	
	// ==================================== VALIDACIONES SERVIDOR ======================================== //
	// Validar ingreso de datos correctos
	$array_campo_pk	= array('N_COD_HORARIO', 'N_COD_ESTUDIANTE');
	$array_valor_pk	= array($li_cod_horario, $li_cod_estudiante);
	$li_cuenta = $crud->fila_contar(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk);
	
	// Código repetido
	if ($li_cuenta > 0) {
		$ls_mensaje = 'Estudiante ya se encuentra registrado para este horario.';
		$lb_result  = false;
	}
	// =================================== FIN VALIDACIONES SERVIDOR ====================================== //
	
	// ======================================= CRUD REGISTRAR =========================================== //
	if ($lb_result == true) {

		// Definir estructura
		$array_campo	= array('N_COD_HORARIO', 'N_COD_ESTUDIANTE', 'N_MONTO_TARIFA', 'N_MONTO_DSCTO', 'N_MONTO_NETO',
								'N_COD_MONEDA', 'N_COD_FORMAPAGO', 'V_FLAG_PAGO', 'N_COD_MEDIOPAGO', 'V_COMPROBANTE',
								'D_FEC_MATRICULA', 'D_FEC_INICIO', 'V_FLAG_ESTADO', 'V_AUD_USR_REG', 'D_AUD_FEC_REG');
		$array_valor	= array($li_cod_horario, $li_cod_estudiante, $li_monto_tarifa, $li_monto_descuento, $li_monto_neto,
								$li_cod_moneda, $li_cod_formapago, $ls_flag_pago, $li_cod_mediopago, $ls_comprobante,
								$ld_fec_matricula, $ld_fec_inicio, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_insercion);
		
		// Invocar inserción
		$lb_result = $crud->fila_registrar(DEF_TABLA_MATRICULA, $array_campo, $array_valor, '0');

	}
	// ===================================== FIN CRUD REGISTRAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_matricula_lista.php?id_codigo_padre=".$li_cod_horario); 
	}
	else {
		header("Location: ../vista/mov_matricula_nuevo.php?id_codigo_padre=".$li_cod_horario."&id_respuesta='".$ls_mensaje."'"); 
	}
					
}

?>