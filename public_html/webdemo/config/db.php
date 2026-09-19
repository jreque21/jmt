<?php
/*
	Proyecto   : Sitio público JM Talent Group (demo comercial)
	Propósito  : Conexión de solo lectura a la base de datos existente del negocio.
	             Reutiliza la misma clase de conexión que ya usa el panel admin
	             (BackEnd/config/class_baseDatos.php) en vez de duplicar credenciales.
*/

require_once __DIR__ . '/../../BackEnd/config/class_baseDatos.php';

/**
 * Ejecuta una consulta SELECT y devuelve un array asociativo con todas las filas.
 * Solo debe usarse con SQL de solo lectura (SELECT). No recibe entrada del
 * usuario directamente: cualquier valor externo debe escaparse antes con
 * db_escape() e insertarse ya escapado en el SQL.
 */
function db_query_all($sql) {
	$bd = new baseDatos();
	$con = $bd->bd_conexion();
	$result = mysqli_query($con, $sql);
	$filas = array();
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$filas[] = $row;
		}
	}
	$bd->bd_desconectar();
	return $filas;
}

/** Escapa una cadena para uso seguro dentro de una consulta SQL. */
function db_escape($valor) {
	$bd = new baseDatos();
	return $bd->bd_escapeCadena($valor);
}
