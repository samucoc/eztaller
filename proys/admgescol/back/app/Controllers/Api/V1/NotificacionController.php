<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NotificacionModel;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\BaseConnection;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class NotificacionController extends ResourceController
{
    protected $modelName = 'App\Models\NotificacionModel';
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
    public function index($token=null)
    {
        $authHeader = new \App\Controllers\Api\V1\TokenController();
        $tokenValidation = $this->validateToken( $token);


        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
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

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Notificacion;
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

    public function logNotification($trabajador_rut, $tipo, $controlador, $mensaje)
    {
        $db = \Config\Database::connect();
        // Preparar la consulta SQL
        $query = "insert into notificaciones(fecha, trabajador, tipo, controlador, mensaje, vista) values(?,?,?,?,?,?)";
        // Ejecutar la consulta utilizando Query Builder de CodeIgniter
        $data = $db->query($query, [date('Y-m-d H:i:s'), $trabajador_rut, $tipo, $controlador, $mensaje, 'false']);
        // Responder con los datos encontrados
        //return $this->respondCreated($data, RESOURCE_CREATED);
    }


    public function marcarComoVistas($userDNI = null) {
        if ($userDNI) {
            // Cargar el modelo
            $notificacionesModel = new \App\Models\NotificacionModel();
            
            // Actualizar las notificaciones para el usuario
            $notificacionesModel->where('trabajador', $userDNI)
                                ->whereIn('vista', ['false', null, '']) // Incluye tanto false como null
                                ->set('vista', 'true') // Cambia el campo 'vista' a true
                                ->update();

            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'User DNI is required']);
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
