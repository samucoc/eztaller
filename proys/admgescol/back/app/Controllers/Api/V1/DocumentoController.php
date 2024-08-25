<?php

namespace App\Controllers\Api\V1;

use App\Models\TrabajadorModel;
use App\Models\Tipo_DocModel;
use CodeIgniter\RESTful\ResourceController;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Parser\StreamReader;
use setasign\Fpdi\PdfReader;
use PDFParser\PDFParser;
use PDFParser\L1Parser;
use PDFParser\L2Parser;
use PDFParser\L3Parser;
use PDFParser\TextExtractor;
use Smalot\PdfParser\Parser;

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

    public function showCargaByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '7' and trabajador = ? and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showFunGenByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '6' and trabajador = ? and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showRIOHSByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE (tipo_doc_id = '5' and trabajador = ? and empresa_id = ?) or (tipo_doc_id = '5' and trabajador = 0)";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showContratosByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '2' and trabajador = ? and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showLiqActByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and trabajador = ? and empresa_id = ? and agno = '".date("Y")."'";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showLiqAntByUserByEmp($rut, $empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $agno_ant = date("Y") -1;
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and trabajador = ? and empresa_id = ? and agno = '".$agno_ant."'";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    

    public function showCargaByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '7' and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showFunGenByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '6' and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showRIOHSByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '5' and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showContratosByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '2' and empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showLiqActByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and empresa_id = ? and agno = '".date("Y")."'";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showLiqAntByEmp($empresa)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $agno_ant = date("Y") -1;
        $query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and empresa_id = ? and agno = '".$agno_ant."'";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$empresa])->getResult();
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
        $cargo_id = $this->request->getPost('cargo_id');
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
        
        $tempFileName = $file->getName();
        // Mueve el archivo a una carpeta temporal
        $tempFolder = FCPATH . 'pdfs/';
        if (!$file->move($tempFolder, $tempFileName)) {
            throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
        }

        $pdfFilePath = FCPATH . 'pdfs/' . $tempFileName;
        //$pageNumber = $this->findTextInPDF($pdfFilePath, $trabajador);

        // if ($pageNumber === -1) {
        //     $pageNumber = $this->findTextInPDF($pdfFilePath, $this->formatRut($trabajador));
        //     if ($pageNumber !== -1) {
        //         $docu = new \App\Entities\Documento;
        //         $docu->tipo_doc_id  = $tipo_doc_id;
        //         $docu->mes          = $month;
        //         $docu->agno         = $year;
        //         $docu->nombre       = $nombre;
        //         $docu->trabajador   = $trabajador;
        //         $docu->empresa_id   = $empresa_id;
        //         $docu->ruta         = 'pdfs/'.$tempFileName;
    
        //         if ($this->model->insert($docu)) {
        //             $docu->id = $this->model->insertID();
        //             return $this->respondCreated($docu, RESOURCE_CREATED);
        //         } else {
        //             return $this->fail($this->model->errors());
        //         }
        //     }
        //     else{
        //         return $this->fail("Búsqueda rut en documento no encontrada");
        //     }
        // }
        // else{
        $docu = new \App\Entities\Documento;
        $docu->tipo_doc_id  = $tipo_doc_id;
        $docu->cargo_id     = $cargo_id;
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
        //}

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

    public function uploadVariosDocumento()
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
         $tipo_doc = $this->request->getPost('tipo_doc_id');
         $empresa_id = $this->request->getPost('empresa_id');
 
         // Valida los campos del formulario
         if (empty($month) || empty($year) || empty($empresa_id)) {
             throw new \Exception('Error: Por favor, complete todos los campos.');
         }
 
         // Mueve el archivo a una carpeta temporal
         $tempFolder = WRITEPATH . 'temp\\';
         $tempFileName = 'uploaded_file_' . time() . '.pdf';
         if (!$file->move($tempFolder, $tempFileName)) {
             throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
         }
     
         $pdfFilePath = $tempFolder.$tempFileName;
 
         if ($this->request->getPost('trabajador') === 0 || $this->request->getPost('trabajador') === '' || $this->request->getPost('trabajador') === null) {

            $pdf = new Fpdi();
            $tp = new Tipo_DocModel();
            $tp_u = $tp->find($tipo_doc)->nombre;
    
            // Path to your existing PDF file
            $inputPdf = $pdfFilePath;
            
            // Open existing PDF
            $pageCount = $pdf->setSourceFile($inputPdf);

            // Loop through each page and add it to the new PDF
            for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $pdf->AddPage();
                $templateId = $pdf->importPage($pageNumber);
                $pdf->useTemplate($templateId);
            }
            
            // Save the page as a separate PDF
            
            $outputPdf = 'pdfs/'.$tp_u.'_'.$month.'_' .$year.'_all.pdf';
            $pdf->Output($outputPdf, 'F');

            $docu = new \App\Entities\Documento;
            $docu->tipo_doc_id  = $tipo_doc;
            $docu->empresa_id   = $empresa_id;
            $docu->mes          = $month;
            $docu->agno         = $year;
            $docu->nombre       = $tp_u.'_'.$month.'_' .$year;
            $docu->trabajador   = 0;
            $docu->ruta         = $outputPdf;
            $this->model->insert($docu);

        }else{
            $trabsModel  = new TrabajadorModel();
            $trabs = $trabsModel->findAll();
   
            $tp = new Tipo_DocModel();
            $tp_u = $tp->find($tipo_doc)->nombre;
   
            foreach($trabs as $t){
                // Número que deseas buscar
                $numberToFind = $t->rut;
                try {
                    $pageNumber = $this->findTextInPDF($pdfFilePath, $numberToFind);
    
                    if ($pageNumber === -1) {
                       $pageNumber = $this->findTextInPDF($pdfFilePath, str_replace('.','',$numberToFind));
                       if ($pageNumber !== -1) {
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
                            
                            $outputPdf = 'pdfs/'.$tp_u.'_'.$month.'_' .$year.'_' . $numberToFind . '.pdf';
                            $pdf->Output($outputPdf, 'F');
    
                            $docu = new \App\Entities\Documento;
                            $docu->tipo_doc_id  = $tipo_doc;
                            $docu->empresa_id          = $empresa_id;
                            $docu->mes          = $month;
                            $docu->agno         = $year;
                            $docu->nombre       = $tp_u.'_'.$month.'_' .$year.'_' . $numberToFind;
                            $docu->trabajador   = $numberToFind;
                            $docu->ruta         = $outputPdf;
                            $this->model->insert($docu);
                        }
                        else{

                        }
                    }
                    else{
   
                    }
    
                } catch (Exception $e) {
                    echo "Error al procesar el PDF: " . $e->getMessage();
                }
    
            }
        }
 
         
 
         return $this->respondCreated([
             'status' => 'success',
             'message' => 'Documento cargado exitosamente'
         ]);
    }

    public function uploadContratosDocumento()
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
        $empresa_id = $this->request->getPost('empresa_id');

        // Valida los campos del formulario
        if (empty($month) || empty($year) || empty($empresa_id)) {
            throw new \Exception('Error: Por favor, complete todos los campos.');
        }

        // Mueve el archivo a una carpeta temporal
        $tempFolder = WRITEPATH . 'temp\\';
        $tempFileName = 'uploaded_file_' . time() . '.pdf';
        if (!$file->move($tempFolder, $tempFileName)) {
            throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
        }

        $pdfFilePath = $tempFolder . $tempFileName;

        $trabsModel = new TrabajadorModel();
        $trabs = $trabsModel->findAll();
        $pageNumbers = [];

        // Encuentra las páginas donde están los RUTs
        foreach ($trabs as $t) {
            $numberToFind = $t->rut;
            try {
                $pageNumber = $this->findTextInPDF($pdfFilePath, $numberToFind);
                if ($pageNumber !== -1) {
                    if (!isset($pageNumbers[$numberToFind])) {
                        $pageNumbers[$numberToFind] = [];
                    }
                    $pageNumbers[$numberToFind][] = $pageNumber;
                }
    
            } catch (Exception $e) {
                echo "Error al procesar el PDF: " . $e->getMessage();
            }
        }

        // Ordena las páginas por número de página
        foreach ($pageNumbers as $rut => $pages) {
            sort($pages);
        }
        $keys = array_keys($pageNumbers);
        $totalTrabs = count($keys);

        for ($i = 0; $i < $totalTrabs; $i++) {
            $pdf = new Fpdi();
            $inputPdf = $pdfFilePath;
            $pageCount = $pdf->setSourceFile($inputPdf);

            $currentRut = $keys[$i];
            $pages = $pageNumbers[$currentRut];
    
            // Combine all consecutive pages for the same RUT
            foreach ($pages as $page) {
                $templateId = $pdf->importPage($page);
                $pdf->AddPage();
                $pdf->useTemplate($templateId);
            }

            // Save the page range as a separate PDF
            $outputPdf = 'pdfs/Contrato_' . $month . '_' . $year . '_' . $currentRut . '.pdf';
            $pdf->Output($outputPdf, 'F');

            $docu = new \App\Entities\Documento;
            $docu->tipo_doc_id = 2;
            $docu->empresa_id = $empresa_id;
            $docu->mes = $month;
            $docu->agno = $year;
            $docu->nombre = 'Contrato_' . $month . '_' . $year . '_' . $currentRut;
            $docu->trabajador = $currentRut;
            $docu->ruta = $outputPdf;
            $this->model->insert($docu);
        }

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Documento cargado exitosamente'
        ]);
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
        $empresa_id = $this->request->getPost('empresa_id');
    
        // Valida los campos del formulario
        if (empty($month) || empty($year) || empty($empresa_id)) {
            throw new \Exception('Error: Por favor, complete todos los campos.');
        }
    
        // Mueve el archivo a una carpeta temporal
        $tempFolder = WRITEPATH . 'temp\\';
        $tempFileName = 'uploaded_file_' . time() . '.pdf';
        if (!$file->move($tempFolder, $tempFileName)) {
            throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
        }
    
        $pdfFilePath = $tempFolder . $tempFileName;
    
        $trabsModel = new TrabajadorModel();
        $trabs = $trabsModel->findAll();
    
        // Array para almacenar los resultados
        $resultados = [];
    
        foreach ($trabs as $t) {
            $numberToFind = $t->rut;
            $nombreArchivo = 'No se genero archivo';
            $nombreTrabajador = '';
            $nombreArchivo = '';
            
            try {
                $pageNumber = $this->findTextInPDF($pdfFilePath, $numberToFind);
    
                if ($pageNumber === -1) {
                    $pageNumber = $this->findTextInPDF($pdfFilePath, str_replace('.', '', $numberToFind));
                }
    
                if ($pageNumber !== -1) {
                    $pdf = new Fpdi();
    
                    // Open existing PDF
                    $pdf->setSourceFile($pdfFilePath);
                    $pdf->AddPage();
                    $templateId = $pdf->importPage($pageNumber);
                    $pdf->useTemplate($templateId);
    
                    // Save the page as a separate PDF
                    $outputPdf = 'pdfs/Liquidacion_' . $month . '_' . $year . '_' . $numberToFind . '.pdf';
                    $pdf->Output($outputPdf, 'F');
    
                    // Buscar al trabajador por rut en el modelo
                    // Crear una instancia de la base de datos
                    $db = \Config\Database::connect();
                    // Preparar la consulta SQL
                    $sql = "SELECT * FROM trabajadores WHERE rut = ?";
                    // Ejecutar la consulta
                    $trabajador = $db->query($sql, [$numberToFind])->getResult();

                    if ($trabajador) {
                        foreach($trabajador as $t){
                            $nombreTrabajador = $t->nombres.' '.$t->apellido_paterno.' '.$t->apellido_materno;
                        }
                    } else {
                        $nombreTrabajador = 'Nombre no disponible';
                    }
    
                    // Almacenar el nombre del archivo generado
                    $nombreArchivo = $outputPdf;
    
                    // Guardar en la base de datos
                    $docu = new \App\Entities\Documento;
                    $docu->tipo_doc_id = 1;
                    $docu->empresa_id = $empresa_id;
                    $docu->mes = $month;
                    $docu->agno = $year;
                    $docu->nombre = 'Liquidacion_' . $month . '_' . $year . '_' . $numberToFind;
                    $docu->trabajador = $numberToFind;
                    $docu->ruta = $outputPdf;
                    $this->model->insert($docu);
                } 
    
            } catch (\Exception $e) {
                $nombreTrabajador = 'Error al procesar el PDF';
            }
    
            // Agregar resultado al array
            $resultados[] = [
                'nombre_trabajador' => $nombreTrabajador,
                'nombre_archivo' => $nombreArchivo
            ];
        }
    
        return $this->respondCreated([
            'status' => 'success',
            'message' => $resultados // Devuelve el array con los resultados
        ]);
    }
    
    

    function findTextInPDF($pdfFilePath, $searchText) {
        // Open the PDF file in binary mode
        $file = fopen($pdfFilePath, 'rb');
        if (!$file) {
          die("Error: Unable to open PDF file.");
        }
      
        // Read and Parse PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfFilePath);

        // Perform String Search
        $found = false;
        $foundPage = -1;
        $pageNumber = 0;
        $searchTextFormatted = $this->formatRut($searchText);

        foreach ($pdf->getPages() as $pageNumber => $page) {
            $pageText = $page->getText();
            $pageNumber++;
            if (strpos($pageText, $searchText) !== false || strpos($pageText, $searchTextFormatted) !== false) {
                $found = true;
                $foundPage = $pageNumber;
                break;
            }

        }
        // Return the page number or -1 if not found
        return $found ? $foundPage : -1;
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

    public function formatRut($rut) {
        // Eliminar cualquier carácter no numérico, excepto la 'k' en caso de RUTs con dígito verificador 'k'
        $rut = preg_replace('/[^0-9]/', '', $rut);
        
        // Obtener el número sin el dígito verificador
        $number = $rut;
        
        // Formatear el número con puntos como separadores de miles
        $numberFormatted = number_format($number, 0, '', '.');
        
        // Combinar el número formateado con el dígito verificador
        return $numberFormatted;
    }

}
