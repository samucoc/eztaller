<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Areas;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class AreasController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.areas');
	}
	//obtenemos todos los Areas para luego agregarlos a la tabla datatable
	public function getAreas(){

		$Areas = Areas::all();//obtenemos todos los datos de la bd.
		return Datatables::of($Areas)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$Areas = new Areas;//creamos el objeto Areas
		$user = Auth::user();
		$Areas->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$Areas->creado_por = $user->name;
		$Areas->modificado_por = $user->name;
		$Areas->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/areas');//redireccionamos nuevamente a la vista Areas, esta vez con un mensaje de exito.
        
	}



	public function editar($id){
		$Areas = Areas::get()->where('area_ncorr', '=', $id);
		return view('adminlte::mantenedores.areaseditar')->with('Areas',$Areas);

	}

	public function Guardar(Request $request){

		$Areas = new Areas;
		$user = Auth::user();
		$Areas->area_ncorr = $request->txtid;
		$Areas->nombre = $request->txtdescripcion;
		$Areas->modificado_por = $user->name;
		Areas::where('area_ncorr',$Areas->area_ncorr)->update(['nombre'=>$Areas->nombre,'modificado_por'=>$Areas->modificado_por]);
		return redirect('mantenedores/areas');
	}

	public function eliminar($id){
		$Areas = Areas::where('area_ncorr',$id)->delete();
		return redirect('mantenedores/areas');
	}




}
