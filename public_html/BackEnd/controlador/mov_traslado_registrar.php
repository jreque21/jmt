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
	$li_cod_estudiante	= $bd->bd_escapeCadena($_POST['id_cod_estudiante']);
	$ld_fec_inicio		= $bd->bd_escapeCadena($_POST['id_fec_inicio']);
	$ld_fec_fin 		= $bd->bd_escapeCadena($_POST['id_fec_fin']);
	$li_cod_sede_origen	= $bd->bd_escapeCadena($_POST['id_cod_sede_origen_hide']);
	$li_cod_sede_destino= $bd->bd_escapeCadena($_POST['id_cod_sede_destino']);
	$ls_observacion		= $bd->bd_escapeCadena($_POST['id_observacion']);
	$ls_flag_estado		= '1';
	$ls_flag_indefinido	= $bd->bd_escapeCadena($_POST['id_flag_indefinido']);

	// Gestionar estado
	if ($ls_flag_indefinido != '1') {
		$ls_flag_indefinido = '0';
	}else{
		$ld_fec_fin = null;
	}

	// Obtener datos iniciales
	$ldt_fecha_insercion = date('Y-m-d h:i:s');
	
	// ==================================== VALIDACIONES SERVIDOR ======================================== //
	
	IF ($li_cod_sede_origen == $li_cod_sede_destino ){
		$ls_mensaje = 'Sede origen y destino deben ser distintas.';
		$lb_result  = false;
	}ELSEIF ($ld_fec_inicio	> $ld_fec_fin and $ls_flag_indefinido == '0'){
		$ls_mensaje = 'Fecha Fin debe ser mayor a fecha de inicio.';
		$lb_result  = false;
	}else{
		// Validar ingreso de datos correctos (registrado)
		$array_campo_pk	= array('N_COD_ESTUDIANTE', 'D_FEC_INICIO', 'N_COD_SEDE_ORIGEN', 'V_FLAG_ESTADO');
		$array_valor_pk	= array($li_cod_estudiante, $ld_fec_inicio, $li_cod_sede_origen	, '1');
		$li_cuenta = $crud->fila_contar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk);
		
		// Validar registrado
		if ($li_cuenta > 0) {
			$ls_mensaje = 'Estudiante ya cuenta con traslado registrado para esta fecha.';
			$lb_result  = false;
		}
		
		// Validar aprobado
		if ($li_cuenta == 0) {
			// Validar ingreso de datos correctos (aprobado)
			$array_campo_pk	= array('N_COD_ESTUDIANTE', 'D_FEC_INICIO', 'N_COD_SEDE_ORIGEN', 'V_FLAG_ESTADO');
			$array_valor_pk	= array($li_cod_estudiante, $ld_fec_inicio, $li_cod_sede_origen	, '2');
			$li_cuenta = $crud->fila_contar(DEF_TABLA_TRASLADO, $array_campo_pk, $array_valor_pk);
			
			// Código repetido
			if ($li_cuenta > 0) {
				$ls_mensaje = 'Estudiante ya cuenta con traslado aprobado para esta fecha.';
				$lb_result  = false;
			}
		}
	}
	
	// =================================== FIN VALIDACIONES SERVIDOR ====================================== //
	
	// ======================================= CRUD REGISTRAR =========================================== //
	if ($lb_result == true) {

		// Definir estructura
		$array_campo	= array('N_COD_ESTUDIANTE', 'V_FLAG_INDEFINIDO', 'D_FEC_INICIO', 'D_FEC_FIN',
								'N_COD_SEDE_ORIGEN', 'N_COD_SEDE_DESTINO', 'V_OBSERVACION', 'V_FLAG_ESTADO', 'V_AUD_USR_REG', 'D_AUD_FEC_REG');
		$array_valor	= array($li_cod_estudiante, $ls_flag_indefinido, $ld_fec_inicio, $ld_fec_fin,
								$li_cod_sede_origen, $li_cod_sede_destino, $ls_observacion, $ls_flag_estado, $_SESSION['usr_conectado'], $ldt_fecha_insercion);
		  
		// Invocar inserción
		$lb_result = $crud->fila_registrar(DEF_TABLA_TRASLADO, $array_campo, $array_valor, '0');

	}
	// ===================================== FIN CRUD REGISTRAR ========================================= //
	
	// Redireccionar
	if($lb_result == true) {
		header("Location: ../vista/mov_traslado_lista.php");
	}
	else {
		header("Location: ../vista/mov_traslado_nuevo.php?id_msgRpta=".$ls_mensaje);
	}
					
}

?>