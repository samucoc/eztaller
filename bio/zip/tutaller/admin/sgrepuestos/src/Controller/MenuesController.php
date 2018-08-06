<?php
namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * Menues Controller
 *
 * @property \App\Model\Table\MenuesTable $Menues
 */
class MenuesController extends AppController
{
//Esto se mantiene exactaamente igual a como fue creado por cakephp ergo no habra descripciones
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('menues', $this->paginate($this->Menues));
        $this->set('_serialize', ['menues']);
    }
    public function generar_menu($id = null) {
        $this->autoRender = false;
        $conn = ConnectionManager::get('default');
        $perfil = $this->request->session()->read('perfil');
        $results_1 = $conn->execute("select * 
                                        from menues 
                                        where tper_ncorr < ".$perfil."
                                            or tper_ncorr = ".$perfil."
                                        order by menu_orden asc");
       
        $VentasObj=$results_1->fetchAll('assoc');
        echo "<ul>";
        foreach($VentasObj as $row_vent) { 
            echo "<li>";
            echo "<a href='' >".$row_vent['menu_desc'].'</a>';
            $results_2 = $conn->execute("select * 
                                        from menues_hijos 
                                        where (menu_ncorr = '".$row_vent['menu_ncorr']."' 
                                            and mhij_mostrar = 'SI' 
                                            and mhij_perfil < ".$perfil."
                                            )
                                            OR
                                            (menu_ncorr = '".$row_vent['menu_ncorr']."' 
                                            and mhij_mostrar = 'SI'
                                            and mhij_perfil = ".$perfil."
                                            )
                                        order by mhij_orden");
            $menu_hijoObj = $results_2->fetchAll('assoc');
            echo "<ul>";
            foreach ($menu_hijoObj as $key) {
                echo "<li>";
                if (substr($key['mhij_link'],0,4)=='http'){
                    echo "<a href='".$key['mhij_link']."' >".$key['mhij_desc'].'</a>';
                    }
                else{
                    echo "<a href='/sgrepuestos/".$key['mhij_link']."' >".$key['mhij_desc'].'</a>';
                    }
                echo '</li>';
                }
            echo "</ul>";
            echo '</li>';
            }
        echo "<li>";
        $nombre_usuario = $this->request->session()->read('nomUsuario');
        echo "<a href='#' style='color:black; background-color:white' >".$nombre_usuario."</a>";
        echo "</li>";
        echo "</ul>";

        }

    /**
     * View method
     *
     * @param string|null $id Menue id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menue = $this->Menues->get($id, [
            'contain' => []
        ]);
        $this->set('menue', $menue);
        $this->set('_serialize', ['menue']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menue = $this->Menues->newEntity();
        if ($this->request->is('post')) {
            $menue = $this->Menues->patchEntity($menue, $this->request->data);
            if ($this->Menues->save($menue)) {
                $this->Flash->success(__('The menue has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menue could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('menue'));
        $this->set('_serialize', ['menue']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menue id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menue = $this->Menues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menue = $this->Menues->patchEntity($menue, $this->request->data);
            if ($this->Menues->save($menue)) {
                $this->Flash->success(__('The menue has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menue could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('menue'));
        $this->set('_serialize', ['menue']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menue id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menue = $this->Menues->get($id);
        if ($this->Menues->delete($menue)) {
            $this->Flash->success(__('The menue has been deleted.'));
        } else {
            $this->Flash->error(__('The menue could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
