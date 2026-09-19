<?php
/*
	Funciones auxiliares compartidas por las páginas del sitio público.
*/

// Rutas de subida de archivos ya usadas por el panel admin (BackEnd).
define('SITE_UPLOAD_SEDE_DIR',       '../upload/sede/');
define('SITE_UPLOAD_INSTRUCTOR_DIR', '../upload/instructor/');
define('SITE_UPLOAD_CINTURON_DIR',   '../upload/cinturon/');
define('SITE_UPLOAD_EMPRESA_DIR',    '../upload/images/');
define('SITE_LOGO_INSTITUCIONAL',    'recursos/images/Logo.png');

/**
 * Devuelve la URL de una foto subida por el admin, o un placeholder si no existe.
 */
function f_foto_o_placeholder($nombre_archivo, $carpeta, $placeholder) {
	if (!empty($nombre_archivo) && file_exists(__DIR__ . '/../' . $carpeta . $nombre_archivo)) {
		return $carpeta . $nombre_archivo;
	}
	return $placeholder;
}

/** Arma "Nombres Apellido Paterno" a partir de los campos separados. */
function f_nombre_completo($nombres, $ape_paterno, $ape_materno = '') {
	$nombre = trim($nombres . ' ' . $ape_paterno . ' ' . $ape_materno);
	return preg_replace('/\s+/', ' ', $nombre);
}

/** Convierte los 7 flags V_FLAG_DIA_1..7 (1=Domingo … 7=Sábado) en texto "Lun, Mié, Vie". */
function f_dias_horario($horario) {
	$dias = array(1 => 'Dom', 2 => 'Lun', 3 => 'Mar', 4 => 'Mié', 5 => 'Jue', 6 => 'Vie', 7 => 'Sáb');
	$activos = array();
	for ($i = 1; $i <= 7; $i++) {
		if ($horario['V_FLAG_DIA_' . $i] == '1') {
			$activos[] = $dias[$i];
		}
	}
	return implode(', ', $activos);
}

/** Formatea una hora "HH:MM:SS" a "HH:MM a.m./p.m." */
function f_hora_legible($hora) {
	if (empty($hora)) return '';
	return date('h:i a', strtotime($hora));
}

/** Link de WhatsApp con mensaje precargado, a partir de un número local peruano. */
function f_whatsapp($numero, $mensaje = '') {
	$numero = preg_replace('/\D/', '', (string) $numero);
	if (empty($numero)) return '';
	if (substr($numero, 0, 2) !== '51') {
		$numero = '51' . $numero;
	}
	$url = 'https://wa.me/' . $numero;
	if (!empty($mensaje)) {
		$url .= '?text=' . rawurlencode($mensaje);
	}
	return $url;
}

/** Escapa texto para salida segura en HTML. */
function h($texto) {
	return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
