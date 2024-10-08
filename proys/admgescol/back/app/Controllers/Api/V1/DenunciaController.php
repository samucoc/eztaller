<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class DenunciaController extends ResourceController
{
    protected $modelName = 'App\Models\DenunciaModel';
    protected $format = 'json';
    private $datetimeNow;
    private $denunImpliModel;
    private $denunImpliArchModel;
    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization");
        $this->denunImpliModel = new \App\Models\DenunciaImpliModel();
        $this->denunImpliArchModel = new \App\Models\DenunciaImpliArchModel();
    }

    //request data is raw json

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($token=null)
    {
        $tokenValidation = $this->validateToken( $token);

        if ($tokenValidation->getStatusCode() !== 200) {
            return $tokenValidation; // Return error response if token is invalid
        }
        $data = $this->model->findAll();

        foreach ($data as $key => $value) {
            $data[$key]->implicados = $this->denunImpliModel->where('denuncia_id', $value->id)->findAll();
            $data[$key]->adjuntos = $this->denunImpliArchModel->where('denun_impli_id', $value->id)->findAll();
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
        $data->implicados = $this->denunImpliModel->where('denuncia_id', $data->id)->findAll();
        $data->adjuntos = $this->denunImpliArchModel->where('denun_impli_id', $data->id)->findAll();

        return $this->respond($data);
    }

    public function showByImplicados($id = null)
    {
        $data = $this->model->find($id);
        if (empty($data)) {
            return $this->failNotFound(RESOURCE_NOT_FOUND);
        }
        $data->implicados = $this->denunImpliModel->where('denuncia_id', $data->id)->findAll();
        $data->adjuntos = $this->denunImpliArchModel->where('denun_impli_id', $data->id)->findAll();

        return $this->respond($data->implicados);
    }

    public function showByAdjuntos($id = null)
    {
        $data = $this->model->find($id);
        if (empty($data)) {
            return $this->failNotFound(RESOURCE_NOT_FOUND);
        }
        $data->implicados = $this->denunImpliModel->where('denuncia_id', $data->id)->findAll();
        $data->adjuntos = $this->denunImpliArchModel->where('denun_impli_id', $data->id)->findAll();

        return $this->respond($data->adjuntos);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Denuncia;
        return $this->respond($data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // Obtener los datos de la denuncia principal
        $data = [];

        $denuncianteNombre = $this->request->getPost('denuncianteNombre');
        $denuncianteRut = $this->request->getPost('denuncianteRut');
        $denuncianteEmail = $this->request->getPost('denuncianteEmail');
        $denuncianteAnonimato = $this->request->getPost('denuncianteAnonimato');
        $denuncia = $this->request->getPost('denuncia');
        $implicados = $this->request->getPost('implicados');
        
        // Insertar la denuncia principal
        $data['created_at'] = $this->datetimeNow->format('Y-m-d H:i:s');
        $data['updated_at'] = $this->datetimeNow->format('Y-m-d H:i:s');
        $data['denuncianteNombre'] = $denuncianteNombre;
        $data['denuncianteRut'] = $denuncianteRut;
        $data['denuncianteEmail'] = $denuncianteEmail;
        $data['denuncianteAnonimato'] = $denuncianteAnonimato;
        $data['denuncia'] = $denuncia;
        $data['implicados'] = $implicados;

        if ($this->model->insert($data)) {
            // Obtener el ID de la denuncia recién insertada
            $denunciaId = $this->model->insertID();
    
            $archivoModel = new \App\Models\DenunciaImpliArchModel();
            // Procesar archivos relacionados con el implicado
            $archivoFiles = $this->request->getFiles();
            if (isset($archivoFiles['archivos'])) {
                foreach ($archivoFiles['archivos'] as $archivo) {
                    // Procesar la subida del archivo
                    $rutaArchivo = $this->procesarSubidaArchivo($archivo, $denunciaId);

                    // Si el archivo fue subido exitosamente, guardar la información en la base de datos
                    if ($rutaArchivo) {
                        $archivoData = [
                            'denun_impli_id' => $denunciaId,
                            'nombre'       => $archivo->getClientName(),
                            'ruta'         => $rutaArchivo,
                            'created_at'   => $this->datetimeNow->format('Y-m-d H:i:s'),
                            'updated_at'   => $this->datetimeNow->format('Y-m-d H:i:s')
                        ];

                        // Insertar el archivo
                        $archivoModel->insert($archivoData);
                    }
                }
            }

            // Procesar los implicados si existen
            if (!empty($data['implicados'])) {
                // Cargar el modelo de Implicados y Archivos
                $implicadoModel = new \App\Models\DenunciaImpliModel();
    
                // Iterar sobre cada implicado
                foreach ($data['implicados'] as $implicado) {
                    // Preparar los datos del implicado
                    $implicadoData = [
                        'denuncia_id' => $denunciaId,
                        'nombre'      => $implicado['nombre'],
                        'cargo'       => $implicado['cargo'],
                        'created_at'  => $this->datetimeNow->format('Y-m-d H:i:s'),
                        'updated_at'  => $this->datetimeNow->format('Y-m-d H:i:s')
                    ];
    
                    // Insertar el implicado y obtener su ID
                    $implicadoModel->insert($implicadoData);
                }
            }
    
            // Responder con éxito si todo se insertó correctamente
            return $this->respondCreated(['denuncia_id' => $denunciaId], RESOURCE_CREATED);
        } else {
            // Si hubo un error al insertar la denuncia, devolver el error
            return $this->fail($this->model->errors());
        }
    }
    

    protected function procesarSubidaArchivo($archivo, $nombreImplicado)
    {
        // Verificar si el archivo es válido
        if (!$archivo->isValid()) {
            return false;
        }
    
        // Obtener la extensión del archivo
        $extension = $archivo->getExtension();
    
        // Crear el nombre del archivo con el formato <nombre_arch>_<tiempounix>.<extension>
        $nombreArchivo = $nombreImplicado . '_' . time() . '.' . $extension;
    
        // Definir la ruta de destino en la carpeta public/denuncias-karin/
        $rutaCarpeta = WRITEPATH . '../public/denuncias-karin/';
    
        // Mover el archivo a la carpeta de destino
        if ($archivo->move($rutaCarpeta, $nombreArchivo)) {
            // Devolver la ruta relativa del archivo para guardarla en la base de datos
            return 'denuncias-karin/' . $nombreArchivo;
        } else {
            return false; // Retorna false si la subida falla
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
