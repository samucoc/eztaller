<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Ips;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class IpsController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.ips');
	}
	//obtenemos todos los Ips para luego agregarlos a la tabla datatable
	public function getIps(){

		$Ips = Ips::all();//obtenemos todos los datos de la bd.
		return Datatables::of($Ips)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$Ips = new Ips;//creamos el objeto Ips
		$user = Auth::user();
		$Ips->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$Ips->porc_cot	 = $request->txtporc_cot;//le asignamos los valores obtenidos por el formulario
		$Ips->creado_por = $user->name;
		$Ips->modificado_por = $user->name;
		$Ips->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/ips');//redireccionamos nuevamente a la vista Ips, esta vez con un mensaje de exito.s
        
	}



	public function editar($id){
		$Ips = Ips::get()->where('ips_ncorr', '=', $id);
		return view('adminlte::mantenedores.ipseditar')->with('ips',$Ips);

	}

	public function Guardar(Request $request){

		$Ips = new Ips;
		$user = Auth::user();
		$Ips->ips_ncorr = $request->txtid;
		$Ips->nombre = $request->txtdescripcion;
		$Ips->porc_cot	 = $request->txtporc_cot;//le asignamos los valores obtenidos por el formulario
		$Ips->modificado_por = $user->name;
		Ips::where('ips_ncorr',$Ips->ips_ncorr)->update(['nombre'=>$Ips->nombre,
															'porc_cot'=>$Ips->porc_cot,
															'modificado_por'=>$Ips->modificado_por]);
		return redirect('mantenedores/ips');
	}

	public function eliminar($id){
		$Ips = Ips::where('ips_ncorr',$id)->delete();
		return redirect('mantenedores/ips');
	}




}
