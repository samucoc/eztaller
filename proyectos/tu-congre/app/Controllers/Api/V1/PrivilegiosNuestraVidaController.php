<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PrivilegiosNuestraVidaController extends ResourceController
{
    protected $modelName = 'App\Models\PrivilegiosNuestraVidaModel';
    protected $format = 'json';
    private $datetimeNow;
    private $hermanoModel;
    private $privilegioModel;
    private $acompañanteModel;
    private $salaModel;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        $this->hermanoModel = new \App\Models\HermanosModel();
        $this->privilegioModel = new \App\Models\PrivilegiosModel();
        $this->acompañanteModel = new \App\Models\HermanosModel();
        $this->salaModel = new \App\Models\SalasModel();
        
    }

    //request data is raw json

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data =$this->model->findAll();
        foreach ($data as $key => $value) {
            $data[$key]['hermano'] = $this->hermanoModel->find($value['hermano_id']);
            $data[$key]['privilegio'] = $this->privilegioModel->find($value['privilegio_id']);
            $data[$key]['acompañante'] = $this->acompañanteModel->find($value['acompañante_id']);
            $data[$key]['sala'] = $this->salaModel->find($value['sala_id']);
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
        $data->hermano = $this->hermanoModel->find($data->hermano_id);
        $data->privilegio = $this->privilegioModel->find($data->privilegio_id);
        $data->acompañante = $this->acompañanteModel->find($data->acompañante_id);
        $data->sala = $this->salaModel->find($data->sala_id);

        return $this->respond($data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\PrivilegiosNuestraVida;
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
}
