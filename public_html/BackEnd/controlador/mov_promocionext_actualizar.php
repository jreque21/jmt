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
	$li_codigo		= $bd->bd_escapeCadena($_POST['id_codigo']);
	$ls_descripcion	= $bd->bd_escapeCadena($_POST['id_descripcion']);
	$ls_lugar		= $bd->bd_escapeCadena($_POST['id_lugar']);
	$ls_referencia	= $bd->bd_escapeCadena($_POST['id_referencia']);
	$ld_fecha		= $bd->bd_escapeCadena($_POST['id_fecha']);
	$li_cod_moneda	= $bd->bd_escapeCadena($_POST['id_cod_moneda']);
	$ldc_monto		= $bd->bd_escapeCadena($_POST['id_monto']);
	//$li_cod_sede	= $bd->bd_escapeCadena($_POST['id_cod_sede']);
	$ls_observacion	= $bd->bd_escapeCadena($_POST['id_observacion']);
	$ls_flag_estado	= $bd->bd_escapeCadena($_POST['id_flag_estado']);
	
	// Gestionar estado
	if ($ls_flag_estado != '1') {
		$ls_flag_estado = '0';
	}
	
	// Obtener datos iniciales
	$ldt_fecha_actualizacion = date('Y-m-d h:i:s');
			
	// ======================================= CRUD ACTUALIZAR =========================================== //
	
	// Definir estructura
	$array_campo_pk	= array('N_COD_PROMOCION');
	$array_valor_pk	= array($li_codigo);
	$array_campo	= array('V_DESCRIPCION', 'V_LUGAR', 'V_REFERENCIA', 'D_FEC_PROG', 'N_COD_MONEDA', 'N_MONTO', 'V_OBSERVACION', 'V_FLAG_ESTADO', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
	$array_valor	= array($ls_descripcion, $ls_lugar, $ls_referencia, $ld_fecha, $li_cod_moneda, $ldc_monto, $ls_observacion, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
	// Invocar Actualización
	$lb_result = $crud->fila_actualizar(DEF_TABLA_PROMOCIONEXT, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);
	
	// ===================================== FIN CRUD ACTUALIZAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_promocionext_lista.php");
	}
	else {
		header("Location: ../vista/mov_promocionext_editar.php?id_codigo=".$_POST["id_codigo"]);
	}
	
}

?>
