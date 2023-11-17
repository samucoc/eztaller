<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class ConductoresController extends ResourceController
{
    protected $modelName = 'App\Models\ConductoresModel';
    protected $format = 'json';
    private $datetimeNow;

    public function __construct()
    {
/*        header('Access-Control-Allow-Origin: *');

        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE, PATCH");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
*/      $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
    }

    //request data is raw json

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $despachos = $db->query("SELECT *
                                FROM conductores 
				order by id desc
                                ")->getResult();
        return $this->respond($despachos); 
        //$data = $this->model->findAll();
        //return $this->respond($data);
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
            return $this->failNotFound();
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
        $data = new \App\Entities\Conductores;
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

        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');

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
        $data = $this->request->getJSON();

        $db = \Config\Database::connect();
        $db->query("
                    update conductores
                        set `rut`='".$data->rut."',
				`nombres`='".$data->nombres."',
				`apellidoPaterno`='".$data->apellidoPaterno."',
				`apellidoMaterno`='".$data->apellidoMaterno."',
				`fechaNacimiento`='".$data->fechaNacimiento."',
				`direccion`='".$data->direccion."',
				`email`='".$data->email."',
				`licenciaConducir`='".$data->licenciaConducir."',
	                      	updated_at = '".date("Y-m-d H:i:s")."'
                    where id= '".$id."'
                    ");

        return $this->respondUpdated($id);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $db->query("
                    delete from conductores
                    where id= '".$id."'
                    ");

        return $this->respondDeleted($id);
    }
}
