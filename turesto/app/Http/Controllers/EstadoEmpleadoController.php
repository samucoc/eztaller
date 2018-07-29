<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\EstadoEmpleado;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class EstadoEmpleadoController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.estadoempleado');
	}
	//obtenemos todos los EstadoEmpleado para luego agregarlos a la tabla datatable
	public function getEstadoEmpleado(){

		$EstadoEmpleado = EstadoEmpleado::all();//obtenemos todos los datos de la bd.
		return Datatables::of($EstadoEmpleado)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$EstadoEmpleado = new EstadoEmpleado;//creamos el objeto EstadoEmpleado
		$user = Auth::user();
		$EstadoEmpleado->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$EstadoEmpleado->creado_por = $user->name;
		$EstadoEmpleado->modificado_por = $user->name;
		$EstadoEmpleado->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/estadoempleado');//redireccionamos nuevamente a la vista EstadoEmpleado, esta vez con un mensaje de exito.s
        
	}



	public function editar($id){
		$EstadoEmpleado = EstadoEmpleado::get()->where('ee_ncorr', '=', $id);
		return view('adminlte::mantenedores.estadoempleadoeditar')->with('EstadoEmpleado',$EstadoEmpleado);

	}

	public function Guardar(Request $request){

		$EstadoEmpleado = new EstadoEmpleado;
		$user = Auth::user();
		$EstadoEmpleado->ee_ncorr = $request->txtid;
		$EstadoEmpleado->nombre = $request->txtdescripcion;
		$EstadoEmpleado->modificado_por = $user->name;
		EstadoEmpleado::where('ee_ncorr',$EstadoEmpleado->ee_ncorr)->update(['nombre'=>$EstadoEmpleado->nombre,'modificado_por'=>$EstadoEmpleado->modificado_por]);
		return redirect('mantenedores/estadoempleado');
	}

	public function eliminar($id){
		$EstadoEmpleado = EstadoEmpleado::where('ee_ncorr',$id)->delete();
		return redirect('mantenedores/estadoempleado');
	}




}
