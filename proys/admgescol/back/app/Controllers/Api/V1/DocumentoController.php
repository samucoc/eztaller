<?php

namespace App\Controllers\Api\V1;

use App\Models\DocumentoModel;
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
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class DocumentoController extends ResourceController
{
    protected $modelName = 'App\Models\DocumentoModel';
    protected $format = 'json';
    private $datetimeNow;
    private $documentoFirmadoModel;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        $this->documentoFirmadoModel = new \App\Models\DocumentoFirmadoModel;

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
    public function index($token=null)
    {
        $authHeader = new \App\Controllers\Api\V1\TokenController();
        $tokenValidation = $this->validateToken( $token);


        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
        $data = $this->model->findAll();
        foreach ($data as $key => $value) {
            $data[$key]->firmado = $this->documentoFirmadoModel->find($value->id);
        }
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
        $data->firmado = $this->documentoFirmadoModel->find($data->id);

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

    public function showCargaByUserByEmp($rut, $empresa, $token)
    {
        $tokenValidation = $this->validateToken( $token);
        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
        
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT documentos.*, 
                        COALESCE(documentos_firmados.documento_id, 0) AS firmado,
                        documentos_firmados.ruta_pdf
                    FROM documentos
                    LEFT JOIN documentos_firmados 
                        ON documentos_firmados.documento_id = documentos.id 
                        AND documentos_firmados.trabajador = '".$rut."'
                    WHERE (documentos.tipo_doc_id not in  ('1','2','5') and documentos.trabajador = ? and documentos.empresa_id = ?) 
                            or (documentos.tipo_doc_id not in  ('1','2','5') and documentos.cargo_id in (select cargo_id 
                                                                                                            from trabajadores 
                                                                                                            where rut = '".$rut."') )";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showFunGenByUserByEmp($rut, $empresa, $token)
    {
        $tokenValidation = $this->validateToken( $token);
        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
        
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT documentos.*, 
                        COALESCE(documentos_firmados.documento_id, 0) AS firmado,
                        documentos_firmados.ruta_pdf
                    FROM documentos
                    LEFT JOIN documentos_firmados 
                        ON documentos_firmados.documento_id = documentos.id 
                        AND documentos_firmados.trabajador = '".$rut."'
                    WHERE documentos.tipo_doc_id = '6' and documentos.trabajador = ? and documentos.empresa_id = ?";
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
        $query = "SELECT documentos.*, 
                        COALESCE(documentos_firmados.documento_id, 0) AS firmado,
                        documentos_firmados.ruta_pdf
                    FROM documentos
                    LEFT JOIN documentos_firmados 
                        ON documentos_firmados.documento_id = documentos.id 
                        AND documentos_firmados.trabajador = '".$rut."'
                    WHERE documentos.tipo_doc_id IN ('5', '6')
                    AND (documentos.trabajador = '".$rut."' 
                        OR documentos.empresa_id = '".$empresa."' 
                        OR documentos.cargo_id IN (
                            SELECT trabajadores.cargo_id 
                            FROM trabajadores 
                            WHERE trabajadores.rut = '".$rut."'
                        ));";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query)->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showContratosByUserByEmp($rut, $empresa, $token)
    {
        $tokenValidation = $this->validateToken( $token);
        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
        
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT documentos.*, 
                        COALESCE(documentos_firmados.documento_id, 0) AS firmado,
                        documentos_firmados.ruta_pdf
                    FROM documentos
                    LEFT JOIN documentos_firmados 
                        ON documentos_firmados.documento_id = documentos.id 
                        AND documentos_firmados.trabajador = '".$rut."'
                    WHERE documentos.tipo_doc_id = '2' and documentos.trabajador = ? and documentos.empresa_id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut, $empresa])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showLiqActByUserByEmp($rut, $empresa, $token)
    {
        $tokenValidation = $this->validateToken( $token);
        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }

        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        //$query = "SELECT * FROM documentos WHERE tipo_doc_id = '1' and trabajador = ? and empresa_id = ? and agno = '".date("Y")."'";
        $query = "SELECT documentos.*, 
                        COALESCE(documentos_firmados.documento_id, 0) AS firmado,
                        documentos_firmados.ruta_pdf
                    FROM documentos
                    LEFT JOIN documentos_firmados 
                        ON documentos_firmados.documento_id = documentos.id 
                        AND documentos_firmados.trabajador = '".$rut."'
                    WHERE documentos.tipo_doc_id = '1' and documentos.trabajador = ? and documentos.empresa_id = ? ";
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
        try {
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
                return $this->fail('Error: Archivo no válido o ya ha sido movido.');
            }

            // // Valida los campos del formulario
            // if (empty($month) || empty($year) || empty($tipo_doc_id) || empty($trabajador) || empty($nombre) || empty($cargo_id) || empty($empresa_id)) {
            //     return $this->fail('Error: Por favor, complete todos los campos.');
            // }

            $tempFileName = $file->getName();
            $tempFolder = FCPATH . 'pdfs/';

            // Mueve el archivo a la carpeta temporal
            if (!$file->move($tempFolder, $tempFileName)) {
                return $this->fail('Error: No se pudo mover el archivo a la carpeta temporal.');
            }

            // Crear una nueva entidad Documento
            $docu = new \App\Entities\Documento;
            $docu->tipo_doc_id  = $tipo_doc_id;
            $docu->cargo_id     = $cargo_id;
            $docu->mes          = $month;
            $docu->agno         = $year;
            $docu->nombre       = $nombre;
            $docu->trabajador   = $trabajador;
            $docu->empresa_id   = $empresa_id;
            $docu->ruta         = 'pdfs/' . $tempFileName;

            // Inserta el documento en la base de datos
            if ($this->model->insert($docu)) {
                $docu->id = $this->model->insertID();

                $tp = new Tipo_DocModel();
                $tp_u = $tp->find($tipo_doc_id)->nombre;

                // Registrar notificación
                $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
                $mensaje = "Documento del tipo {$tp_u} con nombre {$nombre} ha sido insertado.";
                $notificacionController->logNotification($trabajador, 'insert', "documento - {$tp_u}", $mensaje);

                return $this->respondCreated($docu, RESOURCE_CREATED);
            } else {
                return $this->fail($this->model->errors());
            }

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
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
                            $nombreTrabajador = $t->apellido_paterno.' '.$t->apellido_materno.', '.$t->nombres;
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

                    $docu->id = $this->model->insertID();

                    // Registrar notificación
                    $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
                    $mensaje = "Liquidacion por carga masiva con nombre {$docu->nombre} ha sido insertado.";
                    $notificacionController->logNotification($numberToFind, 'insert', 'documento - liquidacion', $mensaje);

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

    public function firmarDoc() {
        $payload = $this->request->getJSON();
    
        // Obtener datos del payload
        $documentId = $payload->documentId;
        $userDNI = $payload->userDNI;
        $clientIp = $payload->ip;
        $receivedToken = $payload->token;
    
        // Obtener la hora actual del servidor
        $timestamp = date('Y-m-d H:i:s');
    
        $tp = new DocumentoModel();
        $tp = $tp->find($documentId);
    
        if ($tp) {
            $db = \Config\Database::connect();
    
            // Anexar la hoja al PDF con los datos necesarios
            $nuevoPdfRuta = $this->anexarHojaAlPDF($tp->ruta, $userDNI, $timestamp, $clientIp, $receivedToken, $tp->trabajador);
    
            // Preparar la consulta SQL para insertar en documentos_firmados
            $query = "INSERT INTO documentos_firmados(documento_id, trabajador, token, ruta_pdf) VALUES(?, ?, ?, ?)";
            // Ejecutar la consulta utilizando Query Builder de CodeIgniter
            $data = $db->query($query, [$documentId, $userDNI, $receivedToken, $nuevoPdfRuta]);
    
            if ($data) {
                $tp->id = $documentId;
    
                // Registrar notificación
                $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
                $mensaje = "Documento con rut {$tp->trabajador} ha sido firmado correctamente.";
                $notificacionController->logNotification($tp->trabajador, 'insert', 'documento - firma', $mensaje);
    
                return $this->respondUpdated($tp, RESOURCE_UPDATED);
            } else {
                return $this->fail($this->model->errors());
            }
        } else {
            return $this->failNotFound('Documento no encontrado.');
        }
    }
    
    private function anexarHojaAlPDF($pdfRuta, $usuario, $fechaHora, $ip, $expectedToken, $rutTrabajador)
    {
        // Inicializar FPDI para agregar la nueva hoja
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
    
        // Título de la nueva hoja
        $pdf->Cell(0, 5, 'Datos de Firma', 0, 1, 'C');
        $pdf->Ln(10);
    
        // Agregar los datos del usuario
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 5, "Usuario: $usuario", 0, 1);
        $pdf->Cell(0, 5, "Fecha y Hora de Firma: $fechaHora", 0, 1);
        $pdf->Cell(0, 5, "IP: $ip", 0, 1);
        $pdf->Cell(0, 5, "Token: $expectedToken", 0, 1);
    
        // Guardar la nueva hoja en un archivo temporal
        $tempPdf = tempnam(sys_get_temp_dir(), 'pdf');
        $pdf->Output('F', $tempPdf);
    
        // Inicializar FPDI para combinar ambos PDFs
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($pdfRuta); // PDF original
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);
        
        // Agregar la nueva hoja con los datos de firma
        $pdf->AddPage();
        $pdf->setSourceFile($tempPdf);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx);
    
        // Crear un nuevo nombre para el PDF, incluyendo el RUT del trabajador
        $nuevoPdfRuta = str_replace('.pdf', "_$rutTrabajador.pdf", $pdfRuta);
    
        // Guardar el nuevo PDF en lugar de sobrescribir el original
        file_put_contents($nuevoPdfRuta, $pdf->Output('S'));
    
        // Eliminar el archivo temporal
        unlink($tempPdf);
    
        // Retornar la ruta del nuevo archivo generado
        return $nuevoPdfRuta;
    }
    

    
    public function generateSecurityToken($documentId, $userDNI, $timestamp, $secretKey) {
        // Crear un string único basado en los datos proporcionados
        $data = $documentId . $userDNI . $timestamp . $secretKey;
    
        // Generar un hash seguro usando SHA-256
        return hash('sha256', $data);
    }

    public function getToken() {
        $payload = $this->request->getJSON();
        $documentId = $payload->documentId;
        $userDNI = $payload->userDNI;
        $timestamp = $payload->formattedDateTime;
        
        // Definir la clave secreta
        $secretKey = 'your_secret_key_here';
    
        // Generar el token
        $token = $this->generateSecurityToken($documentId, $userDNI, $timestamp, $secretKey);
    
        return $this->respond(['token' => $token]);
    }

    public function validateToken($authHeader)
    {
        
        if (!$authHeader) {
            return $this->failUnauthorized('Authorization header missing');
        }

        $token = $authHeader;

        try {
            // Get the secret key from config or environment
            $secretKey = "s54adf769sd48sd468sadf46";
            
            // Decode and validate the token
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            
            // Now you can access the decoded token data
            $userDNI = $decoded->userDNI;
            $role_id = $decoded->role_id;
            
            // You could also perform additional checks here (e.g., expiration)
            
            return $this->respond([
                'status' => 200,
                'userDNI' => $userDNI,
                'role_id' => $role_id
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid token: ' . $e->getMessage());
        }
    }

    
}
