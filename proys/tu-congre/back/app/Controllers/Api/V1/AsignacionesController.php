<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use \App\Models\HermanosModel;
use \App\Models\PrivilegiosModel;
use \App\Models\DetallesGuiaModel;
use \App\Models\SalasModel;
use \App\Models\AsignacionesModel;

use DateTime;
use CodeIgniter\Database\Query;


class AsignacionesController extends ResourceController
{
    protected $modelName = 'App\Models\AsignacionesModel';
    protected $format = 'json';
    private $datetimeNow;
    private $hermanoModel;
    private $privilegioModel;
    private $acompañanteModel;
    private $detallesGuiaModel;
    private $salaModel;

    public function __construct()
    {
        $this->datetimeNow = new \DateTime('NOW', new \DateTimeZone('America/Santiago'));
        $this->hermanoModel = new \App\Models\HermanosModel();
        $this->privilegioModel = new \App\Models\PrivilegiosModel();
        $this->acompañanteModel = new \App\Models\HermanosModel();
        $this->salaModel = new \App\Models\SalasModel();
        $this->detallesGuiaModel = new \App\Models\DetallesGuiaModel();

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
            $data[$key]->hermano = $this->hermanoModel->find($value->persona_id_1);
            $data[$key]->privilegio = $this->privilegioModel->find($value->privilegio_id);
            $data[$key]->acompañante = $this->acompañanteModel->find($value->persona_id_2);
            $data[$key]->sala = $this->salaModel->find($value->sala_id);
            $data[$key]->detalles_guia = $this->detallesGuiaModel->find($value->detalleguia_id);
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
        $data->hermano = $this->hermanoModel->find($data->persona_id_1);
        $data->privilegio = $this->privilegioModel->find($data->privilegio_id);
        $data->acompañante = $this->acompañanteModel->find($data->persona_id_2);
        $data->sala = $this->salaModel->find($data->sala_id);
        $data->detalles_guia = $this->detallesGuiaModel->find($data->detalleguia_id);

        return $this->respond($data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = new \App\Entities\Asignaciones;
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

    public function calendarizar($mes, $anio)
    {
        // La función recibe un parámetro $tipo (1, 2 o 3) que determina el grupo de privilegios
        // Aquí va la lógica de calendarización y asignación de personas para cada grupo de privilegios
        // Retorna un JSON con la información de las privilegios y las personas asignadas
        $asignaciones = [];
        $db = \Config\Database::connect();

        $array_tipo = ['1','2','3','4','5'];

        foreach($array_tipo as $tipo){
            $privilegios = $db->query("SELECT id, nombre, lecturaBiblica, estudioBiblico FROM privilegios WHERE tipo = '".$tipo."' ")->getResult();
            switch ($tipo) {
                case 1:
                    // Tesoros de la Biblia
                    // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where('sexoHermano', '2');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            if ($privilegio->lecturaBiblica =='0'){
                                if (!empty($detalle) ){
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    if (empty($hermano)){
                                        $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                        $resultado = $personas_adicionales;
                                        $personas = $resultado;
                                        $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    }
                                    $asignacion = [
                                        'sala_id' => '1',
                                        'fecha' => $ft,
                                        'privilegio_id' => $privilegio->id,
                                        'privilegio_nombre' => $privilegio->nombre,
                                        'detalleguia_nombre' => $detalle[0]->nombre,
                                        'detalleguia_id' => $detalle[0]->id,
                                        'persona_id_1' => $hermano['id']
                                    ];
                                    $asignacionesModel->insert($asignacion);
                                    $asignaciones[$ft][] = $asignacion;
                                    $personas = $this->removerPersona($personas, $hermano);
                                }
                            }
                            else{
                                foreach($salas as $sala){
                                    $temp = [];
                                    foreach($detalle as $d){
                                        $temp = (array) $d;
                                    }
                                    if (!empty($temp)){
                                        $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                        if (empty($hermano)){
                                            $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                            $resultado = $personas_adicionales;
                                            $personas = $resultado;
                                            $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                        }
                                        $asignacion = [
                                            'sala_id' => $sala->id,
                                            'fecha' => $ft,
                                            'privilegio_id' => $privilegio->id,
                                            'privilegio_nombre' => $privilegio->nombre,
                                            'detalleguia_nombre' => $detalle[0]->nombre,
                                            'detalleguia_id' => $detalle[0]->id,
                                            'persona_id_1' => $hermano['id']
                                        ];
                                        $asignacionesModel->insert($asignacion);
                                        $asignaciones[$ft][] = $asignacion;
                                        $personas = $this->removerPersona($personas, $hermano);
                                    }
                                }
                            }
                        }
                    }
                    
                    break;
                case 2:
                    //Seamos Mejores Maestros
                    // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            foreach($salas as $sala){
                                $temp = [];
                                foreach($detalle as $d){
                                    $temp = (array) $d;
                                }
                                if (!empty($temp)){
                                    $persona1 = (array) $this->obtenerPersonaNoAsignadaSeamos($personas,   $asignacionesModel,   $privilegio->id);
                                    if (empty($persona1)){
                                        $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                        $resultado = $personas_adicionales;
                                        $personas = $resultado;
                                        $persona1 = (array) $this->obtenerPersonaNoAsignadaSeamos($personas,   $asignacionesModel,   $privilegio->id);
                                    }
                                    $persona2 = $privilegio->id == '27' ? '' : $this->obtenerPersonaNoAsignadaSeamos($personas,  $asignacionesModel, $privilegio->id, $persona1);
                                    if (empty($persona2)){
                                        $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                        $resultado = $personas_adicionales;
                                        $personas = $resultado;
                                        $persona2 = (array) $this->obtenerPersonaNoAsignadaSeamos($personas,   $asignacionesModel,   $privilegio->id, $persona1);
                                    }
                                    $asignacion = [
                                        'sala_id' => $sala->id,
                                        'fecha' => $ft,
                                        'privilegio_id' => $privilegio->id,
                                        'privilegio_nombre' => $privilegio->nombre,
                                        'detalleguia_nombre' => $detalle[0]->nombre,
                                        'detalleguia_id' => $detalle[0]->id,
                                        'persona_id_1' => $persona1['id'],
                                        'persona_id_2' => $persona2['id']
                                    ];
                                    $asignacionesModel->insert($asignacion);
                                    $asignaciones[$ft][] = $asignacion;
                                    $personas = $this->removerPersona($personas, $persona1);
                                    $personas = $this->removerPersona($personas, $persona2);

                                }
                            }
                        }
                    }
                    break;
                case 3:
                    // Nuestra Vida Cristiana
                    // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where('sexoHermano', '2');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            if ($privilegio->estudioBiblico =='0'){
                                if (!empty($detalle) ){
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    if (empty($hermano)){
                                        $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                        $resultado = $personas_adicionales;
                                        $personas = $resultado;
                                        $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    }
                                    $asignacion = [
                                        'sala_id' => '1',
                                        'fecha' => $ft,
                                        'privilegio_id' => $privilegio->id,
                                        'privilegio_nombre' => $privilegio->nombre,
                                        'detalleguia_nombre' => $detalle[0]->nombre,
                                        'detalleguia_id' => $detalle[0]->id,
                                        'persona_id_1' => $hermano['id']
                                    ];
                                    $asignacionesModel->insert($asignacion);
                                    $asignaciones[$ft][] = $asignacion;
                                    $personas = $this->removerPersona($personas, $hermano);

                                }
                            }
                            else{
                                $temp = [];
                                foreach($detalle as $d){
                                    $temp = (array) $d;
                                }
                                if (!empty($temp)){
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    if (empty($hermano)){
                                        $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                        $resultado = $personas_adicionales;
                                        $personas = $resultado;
                                        $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                    }
                                    $asignacion = [
                                        'sala_id' => '1',
                                        'fecha' => $ft,
                                        'privilegio_id' => $privilegio->id,
                                        'privilegio_nombre' => $privilegio->nombre,
                                        'detalleguia_nombre' => $detalle[0]->nombre,
                                        'detalleguia_id' => $detalle[0]->id,
                                        'persona_id_1' => $hermano['id']
                                    ];
                                    $asignacionesModel->insert($asignacion);
                                    $asignaciones[$ft][] = $asignacion;

                                    $personas = $this->removerPersona($personas, $hermano);

                                }
                            }
                        }
                    }
                    
                    break;
                case 4:
                    // Presidencia Vida y Ministerio Cristiano
                    // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where('sexoHermano', '2');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            if (!empty($detalle) ){
                                $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                if (empty($hermano)){
                                    $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                    $resultado = $personas_adicionales;
                                    $personas = $resultado;
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                }
                                $asignacion = [
                                    'sala_id' => '1',
                                    'fecha' => $ft,
                                    'privilegio_id' => $privilegio->id,
                                    'privilegio_nombre' => $privilegio->nombre,
                                    'detalleguia_nombre' => $detalle[0]->nombre,
                                    'detalleguia_id' => $detalle[0]->id,
                                    'persona_id_1' => $hermano['id']
                                ];
                                $asignacionesModel->insert($asignacion);
                                $asignaciones[$ft][] = $asignacion;
                                $personas = $this->removerPersona($personas, $hermano);

                            }
                        }
                    }
                    
                    break;
                case 5:
                    // Presidencia Reunion Publica
                     // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where('sexoHermano', '2');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            if (!empty($detalle) ){
                                $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                if (empty($hermano)){
                                    $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                    $resultado = $personas_adicionales;
                                    $personas = $resultado;
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                }
                                $asignacion = [
                                    'sala_id' => '1',
                                    'fecha' => $ft,
                                    'privilegio_id' => $privilegio->id,
                                    'privilegio_nombre' => $privilegio->nombre,
                                    'detalleguia_nombre' => $detalle[0]->nombre,
                                    'detalleguia_id' => $detalle[0]->id,
                                    'persona_id_1' => $hermano['id']
                                ];
                                $asignacionesModel->insert($asignacion);
                                $asignaciones[$ft][] = $asignacion;
                                $personas = $this->removerPersona($personas, $hermano);

                            }
                        }
                    }
                    
                    break;
                case 6:
                    // Acomodacion, Audio y Video y Pasamicrofonos
                     // Lógica para el primer grupo de privilegios
                    // Cargar modelos
                    $asignacionesModel = new AsignacionesModel();
    
                    $salas = $db->query("SELECT id, nombre FROM salas ")->getResult();
    
                    // Obtener las fechas de los miércoles del mes y año especificados
                    $miercoles = $this->obtenerMiercoles($anio, $mes);
                    foreach ($miercoles as $fecha) {
                        foreach($privilegios as $privilegio){
                            
                            $fecha_temp = new DateTime( $fecha); // Crea un objeto DateTime con la fecha especificada
                            $fecha_temp->modify('-2 days'); // Resta 2 días a la fecha
                            $ft = $fecha_temp->format('Y-m-d'); // Muestra la fecha resultante en el formato 'año-mes-día'
                            
                            // Obtener todas las personas y las asignaciones existentes
                            $builder = $db->table('asignaciones');
                            $builder->select('COUNT(ifnull(id,0)) as total_cursada');
                            $builder->where('privilegio_id', $privilegio->id);
                            $builder->groupBy('persona_id_1');
                            $builder->orderBy('total_cursada', 'desc');
                            $builder->limit(1);
                            
                            $query = $builder->get();
                            $row = $query->getRow();
                            if ($row === null) {
                                $max_cursada = 0;
                            } else {
                                $max_cursada = $row->total_cursada;
                            }
                            
                            $builder = $db->table('hermanos');
                            $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                                                precursorRegularHermano, casadoConHermano, privilegios');
                            $builder->where('sexoHermano', '2');
                            $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
                            $builder->groupBy('hermanos.id');
                            
                            $query = $builder->get();
                            $personas = $query->getResultArray();
                            
                            $temp_array = [];
                            foreach($personas as $persona){
                                $year = date('Y', strtotime($ft)); // Año de la fecha
                                $month = date('m', strtotime($ft)); // Mes de la fecha
                                
                                $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                $builder->where('persona_id_1', $persona['id']);
                                $builder->where('YEAR(fecha)', $year);
                                $builder->where('MONTH(fecha)', $month);
                                $asignacionesRecientes = $builder->countAllResults();
                                if ($asignacionesRecientes=='0'){
                                    $temp_array[] = $persona;
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada -1;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            if (count($temp_array)==0){
                                $num = $max_cursada;
                                foreach($personas as $persona){
                                    $year = date('Y', strtotime($ft)); // Año de la fecha
                                    $month = date('m', strtotime($ft)); // Mes de la fecha
                                    
                                    $builder = $db->table('asignaciones'); // Aquí va el nombre de tu tabla
                                    $builder->where('persona_id_1', $persona['id']);
                                    $builder->where('YEAR(fecha)', $year);
                                    $builder->where('MONTH(fecha)', $month);
                                    $asignacionesRecientes = $builder->countAllResults();
                                    if ($asignacionesRecientes==$num){
                                        $temp_array[] = $persona;
                                    }
                                }
                            }
                            
                            isset($temp_array) ? $personas = $temp_array : null;
    
                            
                            $detalle = $db->query("SELECT `id`, `guia_id`, `fechaInicio`, `nombre`, `informacion`, `tiempo`, `privilegio_id` 
                                                    FROM detallesguias 
                                                    WHERE privilegio_id = '".$privilegio->id."' AND fechaInicio = '".$ft."'")->getResult();
                            
                            if (!empty($detalle) ){
                                $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                if (empty($hermano)){
                                    $personas_adicionales = $this->listadoPersonasReinicio($privilegio);
                                    $resultado = $personas_adicionales;
                                    $personas = $resultado;
                                    $hermano = (array) $this->obtenerPersonaNoAsignada($personas,   $asignacionesModel,   $privilegio->id);
                                }
                                $asignacion = [
                                    'sala_id' => '1',
                                    'fecha' => $ft,
                                    'privilegio_id' => $privilegio->id,
                                    'privilegio_nombre' => $privilegio->nombre,
                                    'detalleguia_nombre' => $detalle[0]->nombre,
                                    'detalleguia_id' => $detalle[0]->id,
                                    'persona_id_1' => $hermano['id']
                                ];
                                $asignacionesModel->insert($asignacion);
                                $asignaciones[$ft][] = $asignacion;
                                $personas = $this->removerPersona($personas, $hermano);

                            }
                        }
                    }
                    
                    break;
                default:
                    // Retorna un error si el tipo no es válido
                    return $this->fail("Tipo de grupo de privilegios no válido");
            }
        }


        // Retorna las privilegios filtradas en formato JSON
        return $this->respond($asignaciones);

    }

    private function obtenerMiercoles($anio, $mes)
    {
        // (Aquí va el código de la función obtenerMiercoles proporcionado anteriormente)
        $primerDiaDelMes = strtotime("{$anio}-{$mes}-01");
        $ultimoDiaDelMes = strtotime("{$anio}-{$mes}-" . date('t', $primerDiaDelMes));
    
        $miercoles = [];
        for ($dia = $primerDiaDelMes; $dia <= $ultimoDiaDelMes; $dia += 86400) {
            if (date('N', $dia) == 3) { // 3 representa miércoles en la función date('N')
                $miercoles[] = date('Y-m-d', $dia);
            }
        }
    
        return $miercoles;
    }
    private function removerPersona($personas, $temp_persona){
        foreach ($personas as $index => $persona) {
            is_array($persona) ? null : $persona = (array) $persona;
            is_array($temp_persona) ? null : $temp_persona = (array) $temp_persona;

            if ($persona['id'] === $temp_persona['id']) {
                unset($personas[$index]);
                break;
            }
        }
        return $persona;
    }
    private function fueAsignadoRecientemente($personaId, $asignacionesModel, $periodo = 'week') {
        $fecha_inicio = ($periodo == 'month') ? date('Y-m-01') : date('Y-m-d', strtotime('-7 days'));
        $asignacionesRecientes = $asignacionesModel->where('persona_id_1', $personaId)->where('fecha >=', $fecha_inicio)->countAllResults();
        return $asignacionesRecientes > 0;
    }
    private function listadoPersonasReinicio($privilegio){
        $db = \Config\Database::connect();

        $builder = $db->table('hermanos');
        $builder->select('hermanos.id, nombreHermano, sexoHermano, fechaNacimientoHermano, fechaBautismoHermano, otrasOvejasUngidoHermano, publicadorSiervoAncianoHermano, 
                            precursorRegularHermano, casadoConHermano, privilegios');
        $builder->where('sexoHermano', '2');
        $builder->where("FIND_IN_SET('".$privilegio->id."', privilegios)");
        $builder->groupBy('hermanos.id');
        
        $query = $builder->get();
        return $query->getResultArray();
    }
    private function obtenerPersonaNoAsignada($personas,  $asignacionesModel, $privilegio)
    {
        // Filtra las personas que tienen el privilegio para la asignación dada y no han sido asignadas recientemente
        $personasConPrivilegios = array_filter($personas, function ($persona) use ($privilegio, $asignacionesModel) {
            is_array($persona) ? null : $persona = (array) $persona;
            if (array_key_exists('privilegios', $persona)) {
                $privilegios = strlen($persona['privilegios']) < 2 ? $persona['privilegios'] : explode(',', $persona['privilegios']);
                return ! $this->fueAsignadoRecientemente($persona['id'], $asignacionesModel);
            }
        });
    
        // Si no hay personas con privilegios disponibles que no hayan sido asignadas recientemente, devuelve null
        if (count($personasConPrivilegios) == 0) {
            return null;
        }
    
        // Ordena las personas por la cantidad de veces que han sido asignadas con este privilegio
        usort($personasConPrivilegios, function ($a, $b) use ($asignacionesModel, $privilegio) {
            is_array($a) ? null : $a = (array) $a;
            is_array($b) ? null : $b = (array) $b;

            $asignacionesA = $asignacionesModel->where(['persona_id_1' => $a['id'], 'privilegio_id' => $privilegio])->countAllResults();
            $asignacionesB = $asignacionesModel->where(['persona_id_1' => $b['id'], 'privilegio_id' => $privilegio])->countAllResults();
    
            if ($asignacionesA == $asignacionesB) {
                // Ambos tienen el mismo número de asignaciones, así que selecciona a la persona que fue asignada hace más tiempo
                $ultimaAsignacionA = $asignacionesModel->where('persona_id_1', $a['id'])->orderBy('fecha', 'DESC')->first();
                $ultimaAsignacionB = $asignacionesModel->where('persona_id_1', $b['id'])->orderBy('fecha', 'DESC')->first();
    
                // Compara las fechas de las últimas asignaciones
                if (empty($ultimaAsignacionA->fecha) && empty($ultimaAsignacionB->fecha)){
                    return 0;
                }
                else{
                    return $ultimaAsignacionA->fecha <=> $ultimaAsignacionB->fecha;
                }
            }
    
            return $asignacionesA - $asignacionesB;
        });
    
        // Toma la persona con menos asignaciones
        $personaSeleccionada = $personasConPrivilegios[array_key_first($personasConPrivilegios)];
        
        // Retorna la persona seleccionada
        return $personaSeleccionada;
        
    }
    
    private function obtenerPersonaNoAsignadaSeamos($personas,  $asignacionesModel, $privilegio, $personasAsignadas = [])
    {
        // Filtra las personas que tienen el privilegio para la asignación dada y no han sido asignadas recientemente
        $personasConPrivilegios = array_filter($personas, function ($persona) use ($privilegio, $asignacionesModel, $personasAsignadas) {
            is_array($persona) ? null : $persona = (array) $persona;
            $privilegios = explode(',', $persona['privilegios']);
            return in_array($privilegio, $privilegios) && !$this->fueAsignadoRecientemente($persona['id'], $asignacionesModel) 
                    && ($persona['id'] != $personasAsignadas['id']) && ($persona['sexoHermano']==$personasAsignadas['sexoHermano']);
        });
        
        if (count($personasConPrivilegios) == 0) {
            return null;
        }
    
        // Ordena las personas por la cantidad de veces que han sido asignadas con este privilegio
        usort($personasConPrivilegios, function ($a, $b) use ($asignacionesModel, $privilegio) {
            is_array($a) ? null : $a = (array) $a;
            is_array($b) ? null : $b = (array) $b;

            $asignacionesA = $asignacionesModel->where(['persona_id_1' => $a['id'], 'privilegio_id' => $privilegio])->countAllResults();
            $asignacionesB = $asignacionesModel->where(['persona_id_1' => $b['id'], 'privilegio_id' => $privilegio])->countAllResults();
    
            if ($asignacionesA == $asignacionesB) {
                // Ambos tienen el mismo número de asignaciones, así que selecciona a la persona que fue asignada hace más tiempo
                $ultimaAsignacionA = $asignacionesModel->where('persona_id_1', $a['id'])->orderBy('fecha', 'DESC')->first();
                $ultimaAsignacionB = $asignacionesModel->where('persona_id_1', $b['id'])->orderBy('fecha', 'DESC')->first();
    
                // Compara las fechas de las últimas asignaciones
                if (empty($ultimaAsignacionA->fecha) && empty($ultimaAsignacionB->fecha)){
                    return 0;
                }
                else{
                    return $ultimaAsignacionA->fecha <=> $ultimaAsignacionB->fecha;
                }
            }
    
            return $asignacionesA - $asignacionesB;
        });
    
        // Toma la persona con menos asignaciones
        $personaSeleccionada = $personasConPrivilegios[array_key_first($personasConPrivilegios)];
        
        // Retorna la persona seleccionada
        return $personaSeleccionada;
    }

}