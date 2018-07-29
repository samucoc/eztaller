<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Afp;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class AfpController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.afp');
	}
	//obtenemos todos los Afp para luego agregarlos a la tabla datatable
	public function getAfp(){

		$Afp = Afp::all();//obtenemos todos los datos de la bd.
		return Datatables::of($Afp)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$Afp = new Afp;//creamos el objeto Afp
		$user = Auth::user();
		$Afp->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$Afp->porc_cot	 = $request->txtporc_cot;//le asignamos los valores obtenidos por el formulario
		$Afp->creado_por = $user->name;
		$Afp->modificado_por = $user->name;
		$Afp->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/afp');//redireccionamos nuevamente a la vista Afp, esta vez con un mensaje de exito.s
        
	}



	public function editar($id){
		$Afp = Afp::get()->where('afp_ncorr', '=', $id);
		return view('adminlte::mantenedores.afpeditar')->with('Afp',$Afp);

	}

	public function Guardar(Request $request){

		$Afp = new Afp;
		$user = Auth::user();
		$Afp->afp_ncorr = $request->txtid;
		$Afp->nombre = $request->txtdescripcion;
		$Afp->porc_cot	 = $request->txtporc_cot;//le asignamos los valores obtenidos por el formulario
		$Afp->modificado_por = $user->name;
		Afp::where('afp_ncorr',$Afp->afp_ncorr)->update(['nombre'=>$Afp->nombre,
															'porc_cot'=>$Afp->porc_cot,
															'modificado_por'=>$Afp->modificado_por]);
		return redirect('mantenedores/afp');
	}

	public function eliminar($id){
		$Afp = Afp::where('afp_ncorr',$id)->delete();
		return redirect('mantenedores/afp');
	}




}
