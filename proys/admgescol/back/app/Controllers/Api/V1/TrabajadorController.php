<?php

namespace App\Controllers\Api\V1;

use App\Entities\Trabajador;
use App\Models\UserModel;
use App\Models\TrabajadorModel;
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
class TrabajadorController extends ResourceController
{
    protected $modelName = 'App\Models\TrabajadorModel';
    protected $format = 'json';
    private $CargoModel;
    private $UserModel;
    private $datetimeNow;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        $this->CargoModel = new \App\Models\CargoModel;
        $this->UserModel = new \App\Models\UserModel;

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
    }

    public function findByRut($rut)
    {
        $db = \Config\Database::connect();
        $query = "SELECT t.* , c.nombre as nombre_cargo
                    FROM trabajadores t
                        inner join cargos c
                            on t.cargo_id = c.id
                    WHERE rut = ? ";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$rut])->getResult();

        return $this->respond($data);
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
            $data[$key]->cargo = $this->CargoModel->find($value->cargo_id);
            $data[$key]->usuario = $this->UserModel->find($value->user_id);
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
        $data->cargo = $this->CargoModel->find($data->cargo_id);
        $data->usuario = $this->UserModel->find($data->user_id);

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

    public function bulkUpload()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        if (!$input) {
            return $this->fail($this->model->errors());
        }

        $trabajadorModel = new TrabajadorModel();
        $userModel = new UserModel();
        $errors = [];
    
        foreach ($input as $index => $trabajador) {
            // Verificar si el trabajador ya existe
            $existingTrabajador = $trabajadorModel->where('empresa_id', $trabajador['empresa_id'])
                                                 ->where('rut', $trabajador['rut'])
                                                 ->first();
    
            // Verificar si el usuario ya existe
            $existingUser = $userModel->where('userEmail', $trabajador['email'])
                                      ->first();
    
            if ($existingTrabajador) {
                $errors[] = "El trabajador con RUT {$trabajador['rut']} ya existe en la empresa {$trabajador['empresa_id']}.";
            } elseif ($existingUser) {
                $errors[] = "El usuario con email {$trabajador['email']} ya existe.";
            } else {
                // Crear nuevo Trabajador
                $t = new Trabajador();
                $t->empresa_id = $trabajador['empresa_id'];
                $t->rut = $trabajador['rut'];
                $t->dv = $trabajador['dv'];
                $t->apellido_paterno = $trabajador['apellido_paterno'];
                $t->apellido_materno = $trabajador['apellido_materno'];
                $t->nombres = $trabajador['nombres'];
                $t->cargo_id = $trabajador['cargo_id'];
                $t->email = $trabajador['email'];
                $t->estado_id = $trabajador['estado_id'];

                // Crear nuevo Usuario
                $userData = [
                    'role_id' => $trabajador['role_id'],
                    'userDNI' => $trabajador['rut'],
                    'userFullName' => $trabajador['userFullName'],
                    'userEmail' => $trabajador['email'],
                    'userPassword' => password_hash($trabajador['userPassword'], PASSWORD_DEFAULT),
                ];

                $userId = $userModel->insert($userData);

                if ($userId) {
                    $t->user_id = $userId;
                    $trabajadorModel->insert($t);
                } else {
                    $errors[] = "Error al crear el usuario para el trabajador con RUT {$trabajador['rut']}.";
                }
            }
        }
        if (!empty($errors)) {
            return $this->fail($errors);
        }
    
        return $this->respondCreated($input, RESOURCE_CREATED);
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
        $data->foto = '';
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


    
    public function activar($id = null){
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "update trabajadores set estado_id = '1' where id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$id]);
   
        if ($data) {
            // Registrar notificación
            $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
            $mensaje = "trabajador con id {$id} ha sido activada correctamente.";
            $notificacionController->logNotification('1', 'update', 'trabajadores - status', $mensaje);

            return $this->respondUpdated($data, RESOURCE_UPDATED);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    
    public function desactivar($id = null){
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "update trabajadores set estado_id = '0' where id = ?";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [$id]);
   
        if ($data) {
            // Registrar notificación
            $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
            $mensaje = "trabajador con id {$id} ha sido desactivada correctamente.";
            $notificacionController->logNotification('1', 'update', 'trabajadores - status', $mensaje);

            return $this->respondUpdated($data, RESOURCE_UPDATED);
        } else {
            return $this->fail($this->model->errors());
        }
    }
}
