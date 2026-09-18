<?php

require_once(__DIR__ . "/../recursos/fpdf185/fpdf.php");

/**
 * Genera un PDF tabular genérico a partir de encabezados y filas.
 * Pensado para reportes: título, subtítulo (ej. rango de fechas), y una tabla.
 */
class TablaPDF extends FPDF {

    public $titulo_reporte = '';
    public $subtitulo_reporte = '';

    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 8, utf8_decode($this->titulo_reporte), 0, 1, 'C');
        if (!empty($this->subtitulo_reporte)) {
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 6, utf8_decode($this->subtitulo_reporte), 0, 1, 'C');
        }
        $this->Ln(2);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}  -  Generado el ' . date('d/m/Y H:i'), 0, 0, 'C');
    }

    /**
     * Dibuja la tabla.
     * @param array $encabezados  ['Col1', 'Col2', ...]
     * @param array $anchos       [30, 50, ...] en mm (debe sumar <= ancho útil de página)
     * @param array $filas        [['valor1','valor2'], ['valor1','valor2'], ...]
     */
    function TablaDatos($encabezados, $anchos, $filas) {

        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(230, 230, 230);
        foreach ($encabezados as $i => $enc) {
            $this->Cell($anchos[$i], 7, utf8_decode($enc), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        foreach ($filas as $fila) {
            foreach ($fila as $i => $valor) {
                $this->Cell($anchos[$i], 6, utf8_decode((string) $valor), 1, 0, 'L');
            }
            $this->Ln();
        }
    }
}

?>
