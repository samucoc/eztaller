<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\TiposCuentas;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\Auth;

class TiposCuentasController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.TiposCuentas');
	}
	//obtenemos todos los TiposCuentas para luego agregarlos a la tabla datatable
	public function getTiposCuentas(){

		$TiposCuentas = TiposCuentas::all();//obtenemos todos los datos de la bd.
		return Datatables::of($TiposCuentas)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$TiposCuentas = new TiposCuentas;//creamos el objeto TiposCuentas
		$user = Auth::user();
		$TiposCuentas->nombre = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$TiposCuentas->creado_por = $user->name;
		$TiposCuentas->modificado_por = $user->name;
		$TiposCuentas->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/tiposcuentas');//redireccionamos nuevamente a la vista TiposCuentas, esta vez con un mensaje de exito.
        
	}



	public function editar($id){
		$TiposCuentas = TiposCuentas::get()->where('tc_ncorr', '=', $id);
		return view('adminlte::mantenedores.TiposCuentaseditar')->with('TiposCuentas',$TiposCuentas);

	}

	public function Guardar(Request $request){

		$TiposCuentas = new TiposCuentas;
		$user = Auth::user();
		$TiposCuentas->tc_ncorr = $request->txtid;
		$TiposCuentas->nombre = $request->txtdescripcion;
		$TiposCuentas->modificado_por = $user->name;
		TiposCuentas::where('tc_ncorr',$TiposCuentas->tc_ncorr)->update(['nombre'=>$TiposCuentas->nombre,'modificado_por'=>$TiposCuentas->modificado_por]);
		return redirect('mantenedores/tiposcuentas');
	}

	public function eliminar($id){
		$TiposCuentas = TiposCuentas::where('tc_ncorr',$id)->delete();
		return redirect('mantenedores/tiposcuentas');
	}




}
