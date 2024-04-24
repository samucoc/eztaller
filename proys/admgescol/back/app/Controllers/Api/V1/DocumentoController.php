<?php

namespace App\Controllers\Api\V1;

use App\Models\TrabajadorModel;
use CodeIgniter\RESTful\ResourceController;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Parser\StreamReader;
class DocumentoController extends ResourceController
{
    protected $modelName = 'App\Models\DocumentoModel';
    protected $format = 'json';
    private $datetimeNow;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
    }

    //request data is raw json

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (empty($data)) {
            return $this->failNotFound(RESOURCE_NOT_FOUND);
        }
        return $this->respond($data);
    }
    public function showByRut($rut = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE trabajador = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut])->getResult();
        // Verificar si se encontraron resultados
        if (empty($data)) {
            return $this->failNotFound(RESOURCE_NOT_FOUND);
        }
        // Responder con los datos encontrados
        return $this->respond($data);
    }
    public function showLiquidaciones($rut = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and trabajador = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }
    public function showReglamento($rut = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '2' and trabajador = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showContratos($rut = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '3' and trabajador = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }



    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Documento;
        return $this->respond($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {

        // $data = $this->request->getJSON();

        // $data->created_at = $this->datetimeNow->format('Y-m-d H:i:s');
        // $data->updated_at = $this->datetimeNow->format('Y-m-d H:i:s');

        // Obtiene los datos del formulario
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $tipo_doc_id = $this->request->getPost('tipo_doc_id');
        $trabajador = $this->request->getPost('trabajador');
        $nombre = $this->request->getPost('nombre');
        $empresa_id = $this->request->getPost('empresa_id');

        // Obtiene el archivo subido
        $file = $this->request->getFile('file');

        // Verifica que se haya cargado un archivo válido
        if (!$file->isValid() || $file->hasMoved()) {
            throw new \Exception('Error: Archivo no válido.');
        }

        // Obtiene los datos del formulario
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');

        // Valida los campos del formulario
        if (empty($month) || empty($year)) {
            throw new \Exception('Error: Por favor, complete todos los campos.');
        }

        // Mueve el archivo a una carpeta temporal
        $tempFolder = FCPATH . 'pdfs/';
        $tempFileName = $file->getName();
        if (!$file->move($tempFolder, $tempFileName)) {
            throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
        }

        $docu = new \App\Entities\Documento;
        $docu->tipo_doc_id  = $tipo_doc_id;
        $docu->mes          = $month;
        $docu->agno         = $year;
        $docu->nombre       = $nombre;
        $docu->trabajador   = $trabajador;
        $docu->empresa_id   = $empresa_id;
        $docu->ruta         = 'pdfs/'.$tempFileName;

        if ($this->model->insert($docu)) {
            $docu->id = $this->model->insertID();
            return $this->respondCreated($docu, RESOURCE_CREATED);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {

        $validateEntry = $this->model->find($id);
        if (empty($validateEntry)) {
            return $this->failNotFound(RESOURCE_NOT_FOUND);
        }

        //divide in PATCH and PUT cases

        if ($this->request->getMethod() == 'patch') {
            $data = $this->model->find($id);
            $patchData = $this->request->getJSON();
            $data = array_merge((array) $data, (array) $patchData);
            $data = (object) $data;
        } elseif ($this->request->getMethod() == 'put') {
            $data = $this->request->getJSON();
        }

        $data->updated_at = $this->datetimeNow->format('Y-m-d H:i:s');

        if ($this->model->update($id, $data)) {
            $data->id = $id;
            return $this->respondUpdated($data, RESOURCE_UPDATED);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted($id, RESOURCE_DELETED);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function uploadDocumento()
    {
    
        // Obtiene el archivo subido
        $file = $this->request->getFile('file');

        // Verifica que se haya cargado un archivo válido
        if (!$file->isValid() || $file->hasMoved()) {
            throw new \Exception('Error: Archivo no válido.');
        }

        // Obtiene los datos del formulario
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');

        // Valida los campos del formulario
        if (empty($month) || empty($year)) {
            throw new \Exception('Error: Por favor, complete todos los campos.');
        }

        // Mueve el archivo a una carpeta temporal
        $tempFolder = WRITEPATH . 'temp\\';
        $tempFileName = 'uploaded_file_' . time() . '.pdf';
        if (!$file->move($tempFolder, $tempFileName)) {
            throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
        }
    
        $pdfFilePath = $tempFolder.$tempFileName;


        $trabsModel  = new TrabajadorModel();
        $trabs = $trabsModel->findAll();

        foreach($trabs as $t){
            // Número que deseas buscar
            $numberToFind = $t->rut;

            try {
                $pageNumber = $this->findTextInPDF($pdfFilePath, $numberToFind);
                if ($pageNumber !== null) {
                
                    $pdf = new Fpdi();

                    // Path to your existing PDF file
                    $inputPdf = $pdfFilePath;
                    
                    // Open existing PDF
                    $pageCount = $pdf->setSourceFile($inputPdf);
                    
                    // Loop through each page and create a new PDF for each page
                    $pdf->AddPage();
                    $templateId = $pdf->importPage($pageNumber);
                    $pdf->useTemplate($templateId);
                    
                    // Save the page as a separate PDF
                    $outputPdf = 'pdfs/Liquidacion_'.$month.'_' .$year.'_' . $numberToFind . '.pdf';
                    $pdf->Output($outputPdf, 'F');

                    $docu = new \App\Entities\Documento;
                    $docu->tipo_doc_id  = 1;
                    $docu->mes          = $month;
                    $docu->agno         = $year;
                    $docu->nombre       = 'Liquidacion_'.$month.'_' .$year.'_' . $numberToFind;
                    $docu->trabajador   = $numberToFind;
                    $docu->ruta         = $outputPdf;
                    $this->model->insert($docu);

                } else {
                echo "El texto no fue encontrado en el PDF.";
                }

            } catch (Exception $e) {
                echo "Error al procesar el PDF: " . $e->getMessage();
            }

        }

        


        // $this->model->insert($data); // Guardar datos en la base de datos

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Documento cargado exitosamente'
        ]);
    }

    public function findTextInPDF($pdfFilePath, $textToFind) {
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
    
        return $pageNumber+1;
    }

    public function extract_page_from_pdf($pdfPath, $pageNumber, $rut) {
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
}
