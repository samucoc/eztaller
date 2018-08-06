<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MenuesHijos Controller
 *
 * @property \App\Model\Table\MenuesHijosTable $MenuesHijos
 */
class MenuesHijosController extends AppController
{
    //Esto se mantiene exactaamente igual a como fue creado por cakephp ergo no habra descripciones

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('menuesHijos', $this->paginate($this->MenuesHijos));
        $this->set('_serialize', ['menuesHijos']);
    }

    /**
     * View method
     *
     * @param string|null $id Menues Hijo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menuesHijo = $this->MenuesHijos->get($id, [
            'contain' => []
        ]);
        $this->set('menuesHijo', $menuesHijo);
        $this->set('_serialize', ['menuesHijo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menuesHijo = $this->MenuesHijos->newEntity();
        if ($this->request->is('post')) {
            $menuesHijo = $this->MenuesHijos->patchEntity($menuesHijo, $this->request->data);
            if ($this->MenuesHijos->save($menuesHijo)) {
                $this->Flash->success(__('The menues hijo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menues hijo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('menuesHijo'));
        $this->set('_serialize', ['menuesHijo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menues Hijo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menuesHijo = $this->MenuesHijos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menuesHijo = $this->MenuesHijos->patchEntity($menuesHijo, $this->request->data);
            if ($this->MenuesHijos->save($menuesHijo)) {
                $this->Flash->success(__('The menues hijo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menues hijo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('menuesHijo'));
        $this->set('_serialize', ['menuesHijo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menues Hijo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menuesHijo = $this->MenuesHijos->get($id);
        if ($this->MenuesHijos->delete($menuesHijo)) {
            $this->Flash->success(__('The menues hijo has been deleted.'));
        } else {
            $this->Flash->error(__('The menues hijo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
