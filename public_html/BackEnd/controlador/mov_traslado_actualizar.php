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
	$li_cod_estudiante	= $bd->bd_escapeCadena($_POST['id_cod_estudiante']);
	$li_flag_indefinido	= $bd->bd_escapeCadena($_POST['id_flag_indefinido']);
	$ld_fec_inicio		= $bd->bd_escapeCadena($_POST['id_fec_inicio']);
	$ld_fec_fin 		= $bd->bd_escapeCadena($_POST['id_fec_fin']);
	$li_cod_sede_origen	= $bd->bd_escapeCadena($_POST['id_cod_sede_origen']);
	$li_cod_sede_destino= $bd->bd_escapeCadena($_POST['id_cod_sede_destino']);
	$ls_observacion		= $bd->bd_escapeCadena($_POST['id_observacion']);
	$ls_flag_estado		= $bd->bd_escapeCadena($_POST['id_flag_estado']);
	$ls_flag_indefinido	= $bd->bd_escapeCadena($_POST['id_flag_indefinido']);

	// Gestionar estado
	if ($ls_flag_indefinido != '1') {
		$ls_flag_indefinido = '0';
	}else{
		$ld_fec_fin = null;
	}
	
	// Gestionar estado
	if ($ls_flag_estado != '1') {
		$ls_flag_estado = '0';
	}

	// Obtener datos iniciales
	$ldt_fecha_actualizacion = date('Y-m-d h:i:s');

	// ======================================= CRUD ACTUALIZAR =========================================== //
	
	// Definir estructura
	$array_campo_pk	= array('N_COD_TRASLADO');
	$array_valor_pk	= array($li_codigo);
	$array_campo	= array('N_COD_ESTUDIANTE', 'V_FLAG_INDEFINIDO', 'D_FEC_INICIO', 'D_FEC_FIN', 'N_COD_SEDE_ORIGEN', 'N_COD_SEDE_DESTINO'
							'V_OBSERVACION', 'V_FLAG_ESTADO', 'V_AUD_USR_MOD', 'D_AUD_FEC_MOD');
	$array_valor	= array($li_cod_estudiante, $ld_fec_inicio, $ld_fec_fin, $li_cod_sede_origen, $li_cod_sede_destino,
							$ls_observacion, $ls_flag_indefinido, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_actualizacion);
	
	// Invocar Actualización
	$lb_result = $crud->fila_actualizar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk, $array_campo, $array_valor);
	
	// ===================================== FIN CRUD ACTUALIZAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_traslado_lista.php");
	}
	else {
		header("Location: ../vista/mov_traslado_editar.php?id_codigo=".$_POST["id_codigo"]);
	}
	
}

?>
