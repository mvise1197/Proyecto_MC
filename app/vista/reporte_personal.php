<?php
require '../libs/fpdf/fpdf.php';

class PDF extends FPDF {
    // Cabecera personalizada
    function Header() {
        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Personal', 0, 1, 'C');
        $this->Ln(10); // Espacio entre el título y la tabla
    }

    // Pie de página personalizado
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear una nueva instancia de PDF
$pdf = new PDF();
$pdf->AddPage();

// Colores para el encabezado
$headerFillColor = [230, 230, 230];
$headerTextColor = [0, 0, 0];

// Configurar colores del encabezado
$pdf->SetFillColor($headerFillColor[0], $headerFillColor[1], $headerFillColor[2]);
$pdf->SetTextColor($headerTextColor[0], $headerTextColor[1], $headerTextColor[2]);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Apellidos', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Usuario', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Correo Electronico', 1, 1, 'C', true);

// Obtener lista de personal (suponiendo que ya tienes un método para esto)
require_once '../controlador/PersonalController.php';
$controller = new PersonalController();
$personales = $controller->read();

// Configurar fuente y colores de filas
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

// Alternar colores de fondo para las filas
$rowFillColor1 = [255, 255, 255];
$rowFillColor2 = [240, 240, 240];
$isAlternate = false;

foreach ($personales as $personal) {
    $fillColor = $isAlternate ? $rowFillColor2 : $rowFillColor1;
    $pdf->SetFillColor($fillColor[0], $fillColor[1], $fillColor[2]);

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Agregar cada celda de manera alineada
    $pdf->Cell(20, 10, htmlspecialchars($personal['idPersonal']), 1, 0, 'C', true);
    $pdf->Cell(40, 10, htmlspecialchars($personal['Nombre']), 1, 0, 'C', true);
    $pdf->Cell(40, 10, htmlspecialchars($personal['Apellidos']), 1, 0, 'C', true);
    $pdf->Cell(30, 10, htmlspecialchars($personal['Usuario']), 1, 0, 'C', true);

    // Usar MultiCell para el correo electrónico y ajustar el cursor manualmente
    $pdf->SetXY($x + 130, $y);
    $pdf->MultiCell(60, 10, htmlspecialchars($personal['Correo']), 1, 'C', true);
    $pdf->SetXY($x, $y + 10); // Ajustar la posición de la siguiente fila

    $isAlternate = !$isAlternate; // Alternar color
}

// Salida del PDF al navegador
$pdf->Output('D', 'reporte_personal.pdf');
?>
