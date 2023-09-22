<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class DespachosController extends ResourceController
{
    protected $modelName = '\App\Models\DespachosModel';
    protected $format = 'json';
    private $clientesModal;
    private $conductoresModal;
    private $vehiculosModal;
    private $datetimeNow;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        // $this->clientesModal = new \App\Models\ClientesModel();
        // $this->conductoresModal = new \App\Models\ConductoresModel();
        // $this->vehiculosModal = new \App\Models\VehiculosModel();
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
        //$data = $this->model->findAll();
        $db = \Config\Database::connect();
        $despachos = $db->query("SELECT despachos.id, fecha, nombreEmpresa as cliente_id, origenDespacho, destinoDespacho, 
                                        concat(conductores.nombres, '' ,conductores.apellidoPaterno, '' ,conductores.apellidoMaterno) as conductor_id, 
                                        patente as vehiculo_id, 
                                        recogido, entregado 
                                FROM despachos 
                                    inner join clientes on despachos.cliente_id = clientes.id 
                                    inner join conductores on despachos.conductor_id = conductores.id 
                                    inner join vehiculos on despachos.vehiculo_id = vehiculos.id 
                                ")->getResult();
        return $this->respond($despachos);  
        // foreach ($data as $key => $value) {
        //     $data[$key]->cliente = $this->clientesModal->find($value->cliente_id);
        //     $data[$key]->conductor = $this->conductoresModal->find($value->conductor_id);
        //     $data[$key]->vehiculo = $this->vehiculosModal->find($value->vehiculo_id);
        // }
        //return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $db = \Config\Database::connect();
        $despachos = $db->query("SELECT despachos.id, fecha, nombreEmpresa as cliente_id, origenDespacho, destinoDespacho, 
                                        concat(conductores.nombres, '' ,conductores.apellidoPaterno, '' ,conductores.apellidoMaterno) as conductor_id, 
                                        patente as vehiculo_id, 
                                        recogido, entregado 
                                FROM despachos 
                                    left join clientes on despachos.cliente_id = clientes.id 
                                    left join conductores on despachos.conductor_id = conductores.id 
                                    left join vehiculos on despachos.vehiculo_id = vehiculos.id 
                                where despachos.id= '".$id."'
                                ")->getResult();
        return $this->respond($despachos); 
    }

    // public function listByCliente($id = null)
    // {
    //     $data = $this->model->where('cliente_id', $id)->findAll();
    //     if (empty($data)) {
    //         return $this->failNotFound(RESOURCE_NOT_FOUND);
    //     }
    //     $data->cliente = $this->clientesModal->find($data->cliente_id);
    //     $data->conductor = $this->conductoresModal->find($data->conductor_id);
    //     $data->vehiculo = $this->vehiculosModal->find($data->vehiculo_id);
        
    //     return $this->respond($data);
    // }

    // public function listByConductor($id = null)
    // {
    //     $data = $this->model->where('conductor_id', $id)->findAll();
    //     if (empty($data)) {
    //         return $this->failNotFound(RESOURCE_NOT_FOUND);
    //     }
    //     $data->cliente = $this->clientesModal->find($data->cliente_id);
    //     $data->conductor = $this->conductoresModal->find($data->conductor_id);
    //     $data->vehiculo = $this->vehiculosModal->find($data->vehiculo_id);
        
    //     return $this->respond($data);
    // }

    // public function listByVehiculo($id = null)
    // {
    //     $data = $this->model->where('vehiculo_id', $id)->findAll();
    //     if (empty($data)) {
    //         return $this->failNotFound(RESOURCE_NOT_FOUND);
    //     }
    //     $data->cliente = $this->clientesModal->find($data->cliente_id);
    //     $data->conductor = $this->conductoresModal->find($data->conductor_id);
    //     $data->vehiculo = $this->vehiculosModal->find($data->vehiculo_id);
        
    //     return $this->respond($data);
    // }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Despachos;
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
            return $this->respondCreated($data);
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
            return $this->failNotFound();
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
        var_dump($data);

        $data->updated_at = $this->datetimeNow->format('Y-m-d H:i:s');

        if ($this->model->update($id, $data)) {
            $data->id = $id;
            return $this->respondUpdated($data);
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
            return $this->respondDeleted($id);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    public function recoger($id = null){
        $db = \Config\Database::connect();
        $db->query("
                    update despachos
                        set recogido = '".$this->datetimeNow->format('Y-m-d H:i:s')."',
                        updated_at = '".$this->datetimeNow->format('Y-m-d H:i:s')."'
                    where despachos.id= '".$id."'
                    ");

        return $this->respondUpdated($id);
       
    }

    public function entregar($id = null){
        $db = \Config\Database::connect();
        $db->query("
                    update despachos
                        set entregado = '".$this->datetimeNow->format('Y-m-d H:i:s')."',
                        updated_at = '".$this->datetimeNow->format('Y-m-d H:i:s')."'
                    where despachos.id= '".$id."'
                    ");

        return $this->respondUpdated($id);
       
    }
}
