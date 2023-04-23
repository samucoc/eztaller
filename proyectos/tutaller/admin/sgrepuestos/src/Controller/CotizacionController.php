<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * Cotizacion Controller
 *
 * @property \App\Model\Table\CotizacionTable $Cotizacion
 */
class CotizacionController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function Home()
    {
    	//solo posee la imagen de la empresa y los links de las funciones
    }
    public function busqueda()
    {
    		// Permite buscar una cotizacion segun el numero de cotizacion
    	if ($this->request->is('ajax')) {
            //recibe el codigo via ajax
    		$this->autoRender=false;
    		$codigo=$_POST['id'];
            //obtiene la cotizacion y la envia a la vista
    		$cotizacion=$this->Cotizacion->get($codigo);
    		//busca el nombre del proveedor en la base de datos sgbodega
    		$conn = ConnectionManager::get('copec');
    		$results = $conn->execute('SELECT PR_RAZON FROM proveedor WHERE PR_NCORR='.$cotizacion->codigoEmpresa);
    		$NombreP=$results->fetch('assoc');
    		$NombreP=$NombreP['PR_RAZON'];
        //asigna el nombre a la cotizacion
    		$cotizacion->codigoEmpresa=$NombreP;
    	//busca el nombre de la empresa comprante en base de datos sgyonley
    		$conn = ConnectionManager::get('copec');
    		$results = $conn->execute('SELECT empe_desc FROM empresas WHERE empe_rut='.$cotizacion->codigoComprador);
    		$Comprante=$results->fetch('assoc');
        //cuando lo obtiene lo asigna a la cotizacion
    		$cotizacion->codigoComprador = $Comprante['empe_desc'];
    		$cotizacion->fechaCotizacion=$cotizacion->fechaCotizacion->i18nFormat('dd-MM-YYYY');
    		echo json_encode($cotizacion);
    	}
    }
    public function index()
    {
    	if ($this->request->is('ajax')) {
    		$this->autoRender = false;
        //obtiene todas las cotizaciones
    		$query=$this->Cotizacion->find('all');
    		$this->response->type('application/json');
    		foreach ($query as $row) {
            //busca el nombre del provedor en la base de datos sg_bodega
    			$conn = ConnectionManager::get('copec');
    			$results = $conn->execute('SELECT PR_RAZON FROM proveedor WHERE PR_NCORR='.$row->codigoEmpresa);
    			$NombreP=$results->fetch('assoc');
            //asigna el nombre a la cotizacion
    			$row->codigoEmpresa=$NombreP['PR_RAZON'];
    			//busca el nombre de la empresa comprante en base de datos sgyonley
    			$conn_1 = ConnectionManager::get('copec');
    			$results_1 = $conn_1->execute('SELECT empe_desc FROM empresas WHERE empe_rut="'.$row->codigoComprador.'"');
    			$Comprante=$results_1->fetch('assoc');
        //cuando lo obtiene lo asigna a la cotizacion
    			$row->codigoComprador = $Comprante['empe_desc'];
            //formatea la fecha
    			$row->fechaCotizacion=$row->fechaCotizacion->i18nFormat('dd-MM-YYYY');
           //agrega el link the opciones
    			$row->Opciones='<A href="/backup/sgrepuestos/cotizacion/view/'.$row->codigoCotizacion.'">Revisar</A>';
    			$output['data'][] = $row;
    		}
        //se envia  a la vista encondado como json
    		echo json_encode($output);
    	}
    }

    /**
     * View method
     *
     * @param string|null $id Cotizacion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
    	$cotizacion = $this->Cotizacion->get($id, [
    		'contain' => []
    		]);

            //formatea la fecha
    	$cotizacion->fechaCotizacion=$cotizacion->fechaCotizacion->i18nFormat('dd-MM-YYYY');
        //busca el nombre del proveedor
    	$conn = ConnectionManager::get('copec');
    	$results = $conn->execute('SELECT PR_RAZON FROM proveedor WHERE PR_NCORR='.$cotizacion->codigoEmpresa);
    	$NombreP=$results->fetch('assoc');
    	$NombreP=$NombreP['PR_RAZON'];
        //asigna el nombre a la cotizacion
    	$cotizacion->codigoEmpresa=$NombreP;
    	//busca el nombre de la empresa comprante en base de datos sgyonley
    	$conn = ConnectionManager::get('copec');
    	$results = $conn->execute('SELECT empe_desc FROM empresas WHERE empe_rut='.$cotizacion->codigoComprador);
    	$Comprante=$results->fetch('assoc');
        //cuando lo obtiene lo asigna a la cotizacion
    	$cotizacion->codigoComprador = $Comprante['empe_desc'];
    	$this->set('cotizacion', $cotizacion);
    	$this->set('_serialize', ['cotizacion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	$cotizacion = $this->Cotizacion->newEntity();
        //invoca las empresas
    	$conn = ConnectionManager::get('copec');
    	$results = $conn->execute('SELECT empe_rut, empe_desc FROM empresas');
    	$Comprante=$results->fetchAll('assoc');
        //cuando lo obtiene lo manda a la vista encondado como json
    	foreach($Comprante as $Comprante) {       
    		$options[$Comprante['empe_rut']] = $Comprante['empe_desc'];
    	}
    	$this->set('options',$options);
    	if ($this->request->is('post')) {
    		$this->loadModel('DetalleCotizacion');
            //agrega los datos a coptizacion
    		$cotizacion = $this->Cotizacion->patchEntity($cotizacion, $this->request->data);
    		$exist=$_POST["cant"];
    		if ($this->Cotizacion->save($cotizacion)) {
                //guarda los datos de la cotizacion
    			for ($i=1;$exist>=$i; $i++) {
                    //agrega la informacion del detalle de la cotizacion
    				$detalle=$this->DetalleCotizacion->newEntity();
    				$detalle->codigoCotizacion=$cotizacion->codigoCotizacion;
    				$detalle->IVA=$_POST["IVA_".$i];
    				$detalle->valorNeto=$_POST["ValorNeto_".$i];
    				$detalle->valorBruto=$_POST["ValorBruto_".$i];
    				$detalle->codigoRepuesto=$_POST["codRepuesto_".$i];
    				if ($this->DetalleCotizacion->save($detalle)) {
                        //y la guarda
    					$this->Flash->success(__('La Cotizacion ha quedado Almacenada'));
    				}
    				else {
    					$this->Flash->error(__('Error, llame a su Informatico mas Cercano'));
    				}
    			}
    			return $this->redirect(['action' => 'add']);
    		}
    		else {
    			$this->Flash->error(__('No se pudo Guardar la Cotizacion'));
    		} 
    	}
    	$this->set(compact('cotizacion'));
    	$this->set('_serialize', ['cotizacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cotizacion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	$cotizacion = $this->Cotizacion->get($id, [
    		'contain' => []
    		]);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$cotizacion = $this->Cotizacion->patchEntity($cotizacion, $this->request->data);
    		if ($this->Cotizacion->save($cotizacion)) {
    			$this->Flash->success(__('The cotizacion has been saved.'));
    			return $this->redirect(['action' => 'index']);
    		} else {
    			$this->Flash->error(__('The cotizacion could not be saved. Please, try again.'));
    		}
    	}
    	$this->set(compact('cotizacion'));
    	$this->set('_serialize', ['cotizacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cotizacion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	$this->request->allowMethod(['post', 'delete']);
    	$cotizacion = $this->Cotizacion->get($id);
    	if ($this->Cotizacion->delete($cotizacion)) {
    		$this->Flash->success(__('The cotizacion has been deleted.'));
    	} else {
    		$this->Flash->error(__('The cotizacion could not be deleted. Please, try again.'));
    	}
    	return $this->redirect(['action' => 'index']);
    }
    public function findProveedor()
    {	//invoca la informacion de los proveedores para el plugin autocompletar
    	$this->autoRender = false;
    	$name = $this->request->query('term');
        //busca el nombre del provedor en la base de datos sg_bodega
    	$conn = ConnectionManager::get('copec');
    	$results = $conn->execute('SELECT PR_RAZON, PR_NCORR FROM proveedor WHERE tipoProv= 1 AND PR_RAZON like "%'.$name.'%"');
    	$resultArr = array();
    	$Proveedor=$results->fetchAll('assoc');
        //cuando lo obtiene lo manda a la vista encondado como json
    	foreach($Proveedor as $Proveedor) {       
    		$resultArr[] = array('label' =>$Proveedor['PR_RAZON'],'mcod'=>$Proveedor['PR_NCORR']);
    	}
    	echo json_encode($resultArr);                                   
    }
 /*
funcion nomP
obtiene la informacion del producto desde la base de datos
solamente se puede llamar via ajax
recibe el codigo del producto
devuelve el objeto producto encodado como json
*/
public function nomP() {
	if ($this->request->is('ajax')) {
        //impide la creacion de vista
		$this->autoRender = false;   
        //recibe el codigo del producto         
		$cod = $_POST['cod'];
        //busca al producto en la base de datos
		$conn = ConnectionManager::get('copec');
		$results = $conn->execute('SELECT TA_BUSQUEDA FROM tallasnew WHERE TA_NCORR='.$cod);
		$repuesto=$results->fetch('assoc');
        //envia al objeco producto encodado como json
		echo json_encode($repuesto);
	} 
}
/*
    funcion find
    solamente se puede llamar via json
    obtiene los nombres de los repuestos y los manda al autocompletar
    recibe como parametros un string con el que busca al nombre del repuesto
    envia una lista que contiene el nombre del repuesto y su id encodados como json  
    */
    public function find() {
    	if ($this->request->is('ajax')) {
        //impide la creacion de vista
    		$this->autoRender = false;   
        //recibe el string con el termino a buscar
    		$name = $this->request->query('term');    
        //busca en la base de datos todos los nombres parecidos        
    		$conn = ConnectionManager::get('copec');
    		$results = $conn->execute('SELECT TA_BUSQUEDA, TA_NCORR FROM tallasnew WHERE TA_BUSQUEDA like "%'.$name.'%"');
    		$resultArr = array();
    		$Repuesto=$results->fetchAll('assoc');
        //cuando lo obtiene lo manda a la vista encondado como json
    		foreach($Repuesto as $Repuesto) {       
    			$resultArr[] = array('label' =>$Repuesto['TA_BUSQUEDA'],'mid'=>$Repuesto['TA_NCORR']);
    		}
        //envia la lsita encodad como json
    		echo json_encode($resultArr);                                   
    	} 
    } 
}
