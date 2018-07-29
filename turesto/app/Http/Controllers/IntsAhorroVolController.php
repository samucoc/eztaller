<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\IntsAhorroVol;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class IntsAhorroVolController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.intsahorrovol');
	}
	//obtenemos todos los IntsAhorroVol para luego agregarlos a la tabla datatable
	public function getIntsAhorroVol(){

		$IntsAhorroVol = IntsAhorroVol::all();//obtenemos todos los datos de la bd.
		return Datatables::of($IntsAhorroVol)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$IntsAhorroVol = new IntsAhorroVol;//creamos el objeto IntsAhorroVol
		$user = Auth::user();
		$IntsAhorroVol->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$IntsAhorroVol->creado_por = $user->name;
		$IntsAhorroVol->modificado_por = $user->name;
		$IntsAhorroVol->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/intsahorrovol');//redireccionamos nuevamente a la vista IntsAhorroVol, esta vez con un mensaje de exito.s
        
	}



	public function editar($id){
		$IntsAhorroVol = IntsAhorroVol::get()->where('inst_apv_ncorr', '=', $id);
		return view('adminlte::mantenedores.intsahorrovoleditar')->with('intsahorrovol',$IntsAhorroVol);

	}

	public function Guardar(Request $request){

		$IntsAhorroVol = new IntsAhorroVol;
		$user = Auth::user();
		$IntsAhorroVol->inst_apv_ncorr = $request->txtid;
		$IntsAhorroVol->nombre = $request->txtdescripcion;
		$IntsAhorroVol->modificado_por = $user->name;
		IntsAhorroVol::where('inst_apv_ncorr',$IntsAhorroVol->inst_apv_ncorr)->update(['nombre'=>$IntsAhorroVol->nombre,
															'modificado_por'=>$IntsAhorroVol->modificado_por]);
		return redirect('mantenedores/intsahorrovol');
	}

	public function eliminar($id){
		$IntsAhorroVol = IntsAhorroVol::where('inst_apv_ncorr',$id)->delete();
		return redirect('mantenedores/intsahorrovol');
	}




}
