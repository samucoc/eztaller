<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * DetalleCotizacion Controller
 *
 * @property \App\Model\Table\DetalleCotizacionTable $DetalleCotizacion
 */
class DetalleCotizacionController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        //invoca las marcas disponibles desde sgcopec
        $conn = ConnectionManager::get('copec');
        $results = $conn->execute('SELECT * FROM marcas');
        foreach ($results as $row) {
            $marcas[$row['marca_ncorr']]=$row['nombre'];
        }
        //invoca las repuestos disponibles desde sgcopec
        $results = $conn->execute('SELECT * FROM tallasnew');
        foreach ($results as $row) {
            $repuestos[$row['TA_NCORR']]=$row['TA_BUSQUEDA'];
        }
        //envia repuestos para ser usado como combobox
        $this->set('repuesto', $repuestos);
        if ($this->request->is('ajax')) {
            //al haber un requerimiento ajax obtiene la marca y el repuesto
            $this->loadModel('Cotizacion');
            $this->autoRender=false;
            $nomRepuesto=$_GET['repuesto'];
            //busca todos los detalles de cotizacion que tengan esa marca y ese repuesto
            $query=$this->DetalleCotizacion->find('all',[
                'conditions'=>[
                'codigoRepuesto'=>$nomRepuesto,
                ]
                ]);
            foreach ($query as $row) {
                //formatea la fecha a formato chile
                $row->fechaCotizacion=$this->Cotizacion->get($row->codigoCotizacion)->fechaCotizacion->i18nFormat('dd-MM-YYYY');
                //reemplaza repuesto por sus nombre correspondientes
                $row->codigoRepuesto=$repuestos[$row->codigoRepuesto];
                //agrega el link de opciones
                $row->Opciones='<A href="/backup/sgrepuestos/cotizacion/view/'.$row->codigoCotizacion.'">Revisar</A>';
                $output['data'][] = $row;
            }
            //lo envia como json para rellenar la tabla
            echo json_encode($output);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Detalle Cotizacion id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $detalleCotizacion = $this->DetalleCotizacion->get($id, [
            'contain' => []
            ]);
        $this->set('detalleCotizacion', $detalleCotizacion);
        $this->set('_serialize', ['detalleCotizacion']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $detalleCotizacion = $this->DetalleCotizacion->newEntity();
        if ($this->request->is('post')) {
            $detalleCotizacion = $this->DetalleCotizacion->patchEntity($detalleCotizacion, $this->request->data);
            if ($this->DetalleCotizacion->save($detalleCotizacion)) {
                $this->Flash->success(__('The detalle cotizacion has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The detalle cotizacion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('detalleCotizacion'));
        $this->set('_serialize', ['detalleCotizacion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Detalle Cotizacion id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $detalleCotizacion = $this->DetalleCotizacion->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $detalleCotizacion = $this->DetalleCotizacion->patchEntity($detalleCotizacion, $this->request->data);
            if ($this->DetalleCotizacion->save($detalleCotizacion)) {
                $this->Flash->success(__('The detalle cotizacion has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The detalle cotizacion could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('detalleCotizacion'));
        $this->set('_serialize', ['detalleCotizacion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Detalle Cotizacion id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $detalleCotizacion = $this->DetalleCotizacion->get($id);
        if ($this->DetalleCotizacion->delete($detalleCotizacion)) {
            $this->Flash->success(__('The detalle cotizacion has been deleted.'));
        } else {
            $this->Flash->error(__('The detalle cotizacion could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    public function relleno()
    {
        $this->autoRender = false;
        $codigo = $_POST['term'];
        //busca todos los detalles de cotizacion que pertenezcan a una cotizacion especifica
        $query=$this->DetalleCotizacion->find('all',[ 
            'conditions' => ['codigoCotizacion' => $codigo]
            ]);
        $this->response->type('application/json');
        foreach ($query as $row) {
        //invoca las repuestos disponibles desde sgcopec
            $conn = ConnectionManager::get('copec');
            $results = $conn->execute('SELECT TA_BUSQUEDA FROM tallasnew WHERE TA_NCORR='.$row->codigoRepuesto);
            $repuesto=$results->fetch('assoc');
            //reemplaza el codigo de repuesto por su nombre correspondiente
            $row->codigoRepuesto=$repuesto['TA_BUSQUEDA'];
            $output['data'][] = $row;
        }
        //envia los datos como json a la vista
        echo json_encode($output);
    }
}
