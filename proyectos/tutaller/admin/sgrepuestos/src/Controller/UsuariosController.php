<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\Usuarios $Usuarios
 */
class UsuariosController extends AppController
{

 public function login()
 {

  $this->layout = 'ajax'; 
  if ($this->request->is('post')) {
    $usuario=$this->Usuarios->newEntity();
    $usuario->usu_login=$_POST['usu_login'];
    $usuario->usu_pass=$_POST['usu_pass'];

    $query=$this->Usuarios->find('all',['conditions'=>
      ['usu_login'=>$usuario->usu_login]
      ]);
    if ( $result=$query->first()) {
      if($result->usu_pass!=$usuario->usu_pass){
       $this->Flash->error(__('Contraseña Incorrecta, Intente Nuevamente'));
     }
     else{
      $holi=$this->request->session();
      $this->request->session()->write('perfil',$result->perf_ncorr);
      $this->request->session()->write('nomUsuario',$result->usu_nombre);
      $this->request->session()->write('codUsuario',$result->usu_ncorr);
      return $this->redirect(['controller'=>'cotizacion' ,'action' => 'home']);
    }
  }
  else{
    $this->Flash->error(__('Nombre de Usuario no Existe, Intente Nuevamente'));
  }
}
}

public function logout()
{
$this->request->session()->destroy();
return $this->redirect(['controller'=>'usuarios' ,'action' => 'login']);
}
public function cambiar()/*cambio de contraseña*/
{
if ($this->request->is('post')) {
  $codUsuario=$this->request->session()->read('codUsuario');
  $usuario=$this->Usuarios->newEntity();
  $pass=$this->request->data['usu_pass'];
  $usuario=$this->Usuarios->get($codUsuario);
  if ($usuario->usu_pass==$pass) {
    $usuario->usu_pass=$this->request->data['nuevaPass'];
    $this->Usuarios->save($usuario);
    $this->Flash->success(__('Contraseña Cambiada.'));

    return $this->redirect(['controller'=>'cotizacion' ,'action' => 'home']);
    }
    
  else{
    $this->Flash->error(__('Contraseña No Coincide.'));
    return $this->redirect(['action' => 'cambiar']);
  }
  } 
}
}