<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TipoSolModel;
use App\Models\EstadoSolModel;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class SolicitudController extends ResourceController
{
    protected $modelName = 'App\Models\SolicitudModel';
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

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Solicitud;
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

            $tp = new TipoSolModel();
            $tp_u = $tp->find($data->tipo_sol_id)->nombre;

            // Registrar notificación
            $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
            $mensaje = "Solicituid del tipo {$tp_u} con trabajador rut {$data->trabajador} ha sido insertado.";
            $notificacionController->logNotification($data->trabajador, 'insert', "solicitud - {$tp_u}", $mensaje);

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
    public function changeStatus($id = null, $newStatus = null)
    {
        $patchData = $this->request->getJSON();
        $comentario = $patchData->comentario;

        // Validar entrada
        if (is_null($id) || is_null($newStatus)) {
            return $this->fail('ID de solicitud o nuevo estado no proporcionado', 400);
        }

        // Encontrar la solicitud
        $solicitud = $this->model->find($id);
        if (!$solicitud) {
            return $this->failNotFound('Solicitud no encontrada');
        }

        // Actualizar el estado de la solicitud
        $updateData = [
            'status' => $newStatus,
            'comentario_status' => $comentario,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->model->update($id, $updateData)) {

            $tp = new EstadoSolModel();
            $tp_u = $tp->find($newStatus)->nombre;

            // Registrar notificación
            $notificacionController = new \App\Controllers\Api\V1\NotificacionController();
            $mensaje = "Solicituid nro {$id} con trabajador rut {$solicitud->trabajador} ha sido modificado estado a {$tp_u}.";
            $notificacionController->logNotification($solicitud->trabajador, 'update', "solicitud - {$tp_u}", $mensaje);

            return $this->respond([
                'status' => 'success',
                'message' => 'Estado de la solicitud actualizado correctamente',
                'data' => $updateData
            ]);
        } else {
            return $this->fail('No se pudo actualizar el estado de la solicitud', 500);
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

    
}
