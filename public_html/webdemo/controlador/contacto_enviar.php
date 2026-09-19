<?php
/*
	Proyecto   : Sitio público JM Talent Group (demo comercial)
	Propósito  : Procesar el formulario de contacto de forma segura.

	Corrige la vulnerabilidad presente en FrontEnd/vista/sendContact.php:
	ahí, $_POST['email'] y $_POST['nombre'] se insertaban sin validar
	directamente en las cabeceras "From"/"Reply-To"/"Return-Path" del correo,
	lo que permite inyección de cabeceras (header injection / spam relay).

	Aquí:
	  - Se valida cada campo (longitud, formato de email).
	  - Se elimina cualquier salto de línea de los valores antes de usarlos
	    en cabeceras, evitando la inyección de cabeceras adicionales.
	  - El remitente técnico del correo (From) es una dirección propia del
	    dominio, nunca el email escrito por el visitante; el dato del
	    visitante solo se usa como "Reply-To".
*/

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/site_helpers.php';

function redirigir_con_estado($estado) {
	header('Location: ../contacto.php?estado=' . $estado);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirigir_con_estado('error');
}

/** Quita saltos de línea y retornos de carro para prevenir inyección de cabeceras. */
function limpiar_cabecera($valor) {
	return trim(str_replace(array("\r", "\n", "%0a", "%0d"), '', (string) $valor));
}

$nombre   = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$mensaje  = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

$errores = array();

if ($nombre === '' || mb_strlen($nombre) > 150) {
	$errores[] = 'nombre';
}
if ($email === '' || mb_strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errores[] = 'email';
}
if ($telefono !== '' && mb_strlen($telefono) > 20) {
	$errores[] = 'telefono';
}
if ($mensaje === '' || mb_strlen($mensaje) > 1000) {
	$errores[] = 'mensaje';
}

if (!empty($errores)) {
	redirigir_con_estado('error');
}

$nombre_limpio = limpiar_cabecera($nombre);
$email_limpio  = limpiar_cabecera($email);

$empresa = db_query_all("SELECT * FROM MAE_EMPRESA WHERE V_ID = '1' LIMIT 1");
$empresa = !empty($empresa) ? $empresa[0] : array();
$para = !empty($empresa['V_EMAIL_SOPORTE']) ? $empresa['V_EMAIL_SOPORTE'] : (!empty($empresa['V_EMAIL']) ? $empresa['V_EMAIL'] : '');

if (empty($para) || !filter_var($para, FILTER_VALIDATE_EMAIL)) {
	// No hay una dirección de destino configurada; no se puede enviar el correo.
	redirigir_con_estado('error');
}

$asunto = 'Nuevo mensaje de contacto — sitio web';

$cuerpo  = "Se recibió un nuevo mensaje desde el formulario de contacto del sitio web.\n\n";
$cuerpo .= "Nombre: " . $nombre . "\n";
$cuerpo .= "Email: " . $email . "\n";
if ($telefono !== '') {
	$cuerpo .= "Teléfono: " . $telefono . "\n";
}
$cuerpo .= "\nMensaje:\n" . $mensaje . "\n";

// Dominio propio del remitente técnico; nunca el email escrito por el visitante.
$dominio_remitente = isset($_SERVER['SERVER_NAME']) ? preg_replace('/[^a-zA-Z0-9\.\-]/', '', $_SERVER['SERVER_NAME']) : 'localhost';
$remitente_tecnico = 'web@' . $dominio_remitente;

$cabeceras   = 'From: ' . $remitente_tecnico . "\r\n";
$cabeceras  .= 'Reply-To: ' . $nombre_limpio . ' <' . $email_limpio . '>' . "\r\n";
$cabeceras  .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
$cabeceras  .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

$enviado = @mail($para, $asunto, $cuerpo, $cabeceras);

redirigir_con_estado($enviado ? 'ok' : 'error');
