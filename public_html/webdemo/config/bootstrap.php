<?php
/*
	Arranque común de cada página pública: conexión, helpers y datos de la empresa.
	Cada página incluye este archivo antes de imprimir su HTML.
*/

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/site_helpers.php';

// Datos generales de la empresa (usados en header, footer y home).
$filas_empresa = db_query_all("SELECT * FROM MAE_EMPRESA WHERE V_ID = '1' LIMIT 1");
$empresa = !empty($filas_empresa) ? $filas_empresa[0] : array();

$empresa_nombre  = !empty($empresa['V_DESCRIPCION']) ? $empresa['V_DESCRIPCION'] : 'JM Talent Group';
$empresa_lema    = !empty($empresa['V_LEMA']) ? $empresa['V_LEMA'] : 'Escuela de Taekwondo';
$empresa_direccion = !empty($empresa['V_DIRECCION']) ? $empresa['V_DIRECCION'] : '';
$empresa_movil   = !empty($empresa['V_MOVIL']) ? $empresa['V_MOVIL'] : '';
$empresa_email   = !empty($empresa['V_EMAIL']) ? $empresa['V_EMAIL'] : '';
$empresa_logo    = f_foto_o_placeholder(!empty($empresa['V_FOTO']) ? $empresa['V_FOTO'] : '', SITE_UPLOAD_EMPRESA_DIR, SITE_LOGO_INSTITUCIONAL);

// Sedes activas (usadas en el footer, home y página de sedes).
$sedes = db_query_all("SELECT * FROM MAE_SEDE WHERE V_FLAG_ESTADO = '1' ORDER BY V_NOMBRE ASC");

// Título y descripción por defecto (cada página puede sobreescribirlos antes de incluir el header).
if (!isset($meta_titulo)) $meta_titulo = $empresa_nombre . ' — ' . $empresa_lema;
if (!isset($meta_descripcion)) $meta_descripcion = 'Academia de Taekwondo WT en Chachapoyas. Clases para niños, jóvenes y adultos en varias sedes.';
