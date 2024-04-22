<?php 
require_once '../../vendor/autoload.php';
use setasign\Fpdi\Fpdi;

function findTextInPDF($pdfFilePath, $textToFind) {
    // Abrir el archivo PDF en modo lectura binaria
    $file = fopen($pdfFilePath, 'rb');

    // Verificar si se pudo abrir el archivo correctamente
    if (!$file) {
        die("Error: No se pudo abrir el archivo PDF.");
    }

    // Contador de páginas
    $pageNumber = 0;

    // Contador de bytes leídos
    $totalBytesRead = 0;

    // Tamaño del bloque de lectura
    $bufferSize = 8192;

    // Leer el contenido del archivo por bloques
    while (!feof($file)) {
        // Leer un bloque del archivo
        $buffer = fread($file, $bufferSize);

        // Incrementar el contador de bytes leídos
        $totalBytesRead += strlen($buffer);

        // Buscar el texto en el bloque actual
        $pos = strpos($buffer, $textToFind);

        // Si se encuentra el texto en el bloque actual, calcular la página
        if ($pos !== false) {
            // Calcular el número de página
            $pageNumber = substr_count(substr($buffer, 0, $pos), '/Type /Page') + 1;
            break;
        }
    }

    // Cerrar el archivo
    fclose($file);

    // Mostrar la página donde se encontró el texto (si se encontró)
    if ($pageNumber > 0) {
        echo "El texto '$textToFind' se encontró en la página $pageNumber.";
    } 

    return $pageNumber+1;
  }

  // Function to extract a specific page from the PDF
function extract_page_from_pdf($pdfPath, $pageNumber, $rut) {
    $pdf = new Fpdi();

    // Path to your existing PDF file
    $inputPdf = $pdfPath;
    
    // Open existing PDF
    $pageCount = $pdf->setSourceFile($inputPdf);
    
    // Loop through each page and create a new PDF for each page
    $pdf->AddPage();
    $templateId = $pdf->importPage($pageNumber);
    $pdf->useTemplate($templateId);
    
    // Save the page as a separate PDF
    $outputPdf = 'output_page_' . $rut . '.pdf';
    $pdf->Output($outputPdf, 'F');

    return $outputPdf;
}

// Uso de la función
$pdfPath = '../../writable/temp/uploaded_file_1712032110.pdf';
$searchString = '16968853';

try {
  $pageNumber = findTextInPDF($pdfPath, $searchString);
  if ($pageNumber !== null) {
    
    $outputPdf = extract_page_from_pdf($pdfPath, $pageNumber, $searchString);

  } else {
    echo "El texto no fue encontrado en el PDF.";
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage(); // Consider catching specific FPDI exceptions
}
?>