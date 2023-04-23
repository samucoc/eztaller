<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Salud;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class SaludController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.Salud');
	}
	//obtenemos todos los Salud para luego agregarlos a la tabla datatable
	public function getSalud(){

		$Salud = Salud::all();//obtenemos todos los datos de la bd.
		return Datatables::of($Salud)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$Salud = new Salud;//creamos el objeto Salud
		$user = Auth::user();
		$Salud->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$Salud->creado_por = $user->name;
		$Salud->modificado_por = $user->name;
		$Salud->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/salud');//redireccionamos nuevamente a la vista Salud, esta vez con un mensaje de exito.s
        
	}



	public function editar($id){
		$Salud = Salud::get()->where('salud_ncorr', '=', $id);
		return view('adminlte::mantenedores.saludeditar')->with('salud',$Salud);

	}

	public function Guardar(Request $request){

		$Salud = new Salud;
		$user = Auth::user();
		$Salud->Salud_ncorr = $request->txtid;
		$Salud->nombre = $request->txtdescripcion;
		$Salud->modificado_por = $user->name;
		Salud::where('salud_ncorr',$Salud->Salud_ncorr)->update(['nombre'=>$Salud->nombre,
															'modificado_por'=>$Salud->modificado_por]);
		return redirect('mantenedores/salud');
	}

	public function eliminar($id){
		$Salud = Salud::where('salud_ncorr',$id)->delete();
		return redirect('mantenedores/salud');
	}




}
