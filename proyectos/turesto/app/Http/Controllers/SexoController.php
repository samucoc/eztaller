<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Sexo;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;


use Illuminate\Support\Facades\Auth;


class SexoController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.sexo');
	}
	//obtenemos todos los Sexo para luego agregarlos a la tabla datatable
	public function getSexo(){

		$Sexo = Sexo::all();//obtenemos todos los datos de la bd.
		return Datatables::of($Sexo)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$Sexo = new Sexo;//creamos el objeto Sexo
		$user = Auth::user();
		$Sexo->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$Sexo->creado_por = $user->name;
		$Sexo->modificado_por = $user->name;
		$Sexo->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/sexo');//redireccionamos nuevamente a la vista Sexo, esta vez con un mensaje de exito.
        
	}



	public function editar($id){
		$Sexo = Sexo::get()->where('sexo_ncorr', '=', $id);
		return view('adminlte::mantenedores.sexoeditar')->with('sexo',$Sexo);

	}

	public function Guardar(Request $request){

		$Sexo = new Sexo;
		$Sexo->sexo_ncorr = $request->txtid;
		$Sexo->nombre = $request->txtdescripcion;

		Sexo::where('sexo_ncorr',$Sexo->sexo_ncorr)->update(['nombre'=>$Sexo->nombre]);
		return redirect('mantenedores/sexo');
	}

	public function eliminar($id){
		$Sexo = Sexo::where('sexo_ncorr',$id)->delete();
		return redirect('mantenedores/sexo');
	}




}
