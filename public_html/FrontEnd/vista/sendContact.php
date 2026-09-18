<?php

	$id         = $_POST['id'];
	$para       = "secretaria@jmtalentgroup.com";
	$titulo     = "Mensaje desde www.jmtalentgroup.com";
	$from       = $_POST['email'];
	$from_name  = $_POST['nombre'];

	$mensaje="Tienes un nuevo mensaje desde tu página web : \r\n\r\n";
	$mensaje .= "Datos : " . $_POST['nombre']. " \r\n";
	$mensaje .= "E-mail : " . $_POST['email']. " \r\n";
	//$mensaje .= "Tema : " . $_POST['asunto']. " \r\n";
	$mensaje .= "Mensaje : " . $_POST['mensaje']. " \r\n\r\n";
	$mensaje .= "Enviado el " . date('d/m/Y', time());
			
	// construct MIME PLAIN Email headers
	$cabecera = "MIME-Version: 1.0\n";
	$cabecera .= "Content-type: text/plain; charset=utf-8\n";
	$cabecera .= "From: $from_name <$from>\r\nReply-To:  $from_name <$from>\r\nReturn-Path: <$from>\r\n";
				
	// send email
	$mail_sent = mail($para, $titulo, $mensaje, $cabecera);
	
	header("Location: panel_intranet.php");
	
?>