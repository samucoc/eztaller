<?php

namespace App\Controllers\Api\V1;

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
class TrabajadorController extends ResourceController
{
    protected $modelName = 'App\Models\TrabajadorModel';
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

    public function showByEmpresa($id = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM trabajadores WHERE empresa_id = ? ";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$id])->getResult();
        // Verificar si se encontraron resultados
        // if (empty($data)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }
        // Responder con los datos encontrados
        return $this->respond($data);
    }

    public function showByRut($id = null)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "SELECT * FROM trabajadores WHERE rut = ? ";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$id])->getResult();
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
        $data = new \App\Entities\Trabajador;
        return $this->respond($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {

        $data = $this->request->getJSON();

        $data->created_at = $this->datetimeNow->format('Y-m-d H:i:s');
        $data->updated_at = $this->datetimeNow->format('Y-m-d H:i:s');

        if ($this->model->insert($data)) {
            $data->id = $this->model->insertID();
            return $this->respondCreated($data, RESOURCE_CREATED);
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
    public function uploadFoto($id = null)
    {

        // Obtiene el archivo subido
        $file = $this->request->getFile('foto');
        $tempFileName = $file?->getName();
        
        if ($file?->isValid() && !$file?->getError()) {
            // Mueve el archivo a una carpeta temporal
            $tempFolder = FCPATH . 'fotos_trabajadores/';
            if (!$file->move($tempFolder, $tempFileName)) {
                throw new \Exception('Error: No se pudo mover el archivo a la carpeta temporal.');
            }

            $pdfFilePath =  URL_BACK . '/fotos_trabajadores/' . $tempFileName;
        
            $db = \Config\Database::connect();
            // Preparar la consulta SQL
            $query = "UPDATE trabajadores 
                            SET foto = '".$pdfFilePath."'
                        WHERE id = ? ";
            // Ejecutar la consulta utilizando Query Builder de CodeIgniter
            $data = $db->query($query, [$id]);
        
            return $this->respondUpdated($data, RESOURCE_UPDATED);
        }
        return $this->failNotFound(RESOURCE_NOT_FOUND);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {

        // $validateEntry = $this->model->find($id);
        // if (empty($validateEntry)) {
        //     return $this->failNotFound(RESOURCE_NOT_FOUND);
        // }

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

}
