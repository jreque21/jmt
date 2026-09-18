<?php
@session_start();

// Importar funcionalidades
require_once("../../config/global.php");

// Clase FPDF
class PDF extends FPDF
{
	// Header de Página
	function Header()
	{
		// Usar solo fuentes embebidas (Helvetica, Courier, Times)
		// Evitar fuentes personalizadas que pueden no existir
		$this->SetFont('Helvetica','',12);	 						// Tipo de Letra (embebida)
		$this->AliasNbPages();
		$this->setAuthor(SOPORTE_AUTOR);	 						// Autor
		$this->SetAutoPageBreak(true, 20);							// Cambio de Página
		$this->SetMargins(8, 8, 8);									// Margenes

		// Logo - Comentado si causa problemas
		// Descomenta si la imagen existe en: ../../../upload/empresa/Logo.png
		if (file_exists(dirname(__FILE__) . '/../../../upload/empresa/Logo.png')) {
			$this->Image('../../../upload/empresa/Logo.png',10,2,30,30); 	// Archivo, PosX, PosY, Width, Height
		}

		// Header Titulo
		$this->SetFont('Helvetica','B',16);
		$this->Cell(0, 0,'JM TALENT GROUP',0, 0,'C',false);	// Width, Height, Texto, Border, Ln, Align, Fill, Link
		$this->Ln(7);

		// Header Lema
		$this->SetFont('Helvetica','',10);
		$this->Cell(0,0,utf8_decode('INSCRITO EN LOS REGISTROS PÚBLICOS PARTIDA Nº 11046590'),0, 0,'C',false);
		$this->Ln(4);
		$this->Cell(0,0,utf8_decode('AFILIADO A LA FEDERACIÓN DEPORTIVA PERUANA DE TAEKWONDO'),0, 0,'C',false);
		$this->Ln(4);
		$this->Cell(0,0,utf8_decode('INSCRITO EN EL REGISTRO NACIONAL DEL DEPOTE (IPD)'),0, 0,'C',false);
		$this->Ln(7);

		// Header Línea
		$this->SetLineWidth(1);
		$this->SetDrawColor(236,50,55);
		$this->Cell(0,0,'',1, 0,'C',true);
		$this->Ln(10);

	}

	// Footer de Página
	function Footer()
	{

		// Capturar Fecha
		$ldt_fecha_consulta = date('Y-m-d h:i:s');

		// Posicionar
		$this->setY(-15);

		// Header Línea
		$this->SetLineWidth(1);
		$this->SetDrawColor(0,0,0);
		$this->Cell(0,0,'',1, 0,'C',true);
		$this->Ln(2);

		$this->SetFont('Helvetica','I',8);

		// Evitar error si usr_conectado no existe
		$usr = isset($_SESSION['usr_conectado']) ? $_SESSION['usr_conectado'] : 'Usuario';

		$this->Cell(60,4,'Consultado por : '.$usr,0,0,'L');
		$this->Cell(0,4,utf8_decode('Página : ').$this->PageNo().'/'.'{nb}',0,0,'R');
		$this->Ln(4);

		$this->Cell(60,4,'Fecha y Hora : '.$ldt_fecha_consulta,0,0,'L');

	}

}
?>