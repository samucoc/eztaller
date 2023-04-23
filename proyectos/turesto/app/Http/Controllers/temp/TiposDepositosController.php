<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoDeposito;
class TiposDepositosController extends Controller
{
    private  $ruta = "tipodepositos";
	private  $editar = "tipodepositoseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettipodepositos(){
		$tipodepositos = TipoDeposito::all();
		return Datatables::of($tipodepositos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'td_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'td_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'td_descripcion' 	=> $request->txtdescripcion
			],
			[
			'td_descripcion' 	=> 'required|unique:tipo_depositos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipodepositos = new TipoDeposito;
		$tipodepositos->td_descripcion = $request->txtdescripcion;
		$tipodepositos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipodepositos = TipoDeposito::get()->where('td_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipodepositos',$tipodepositos);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'td_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'td_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'td_descripcion' 	=> $request->txtdescripcion
			],
			[
			'td_descripcion' 	=> 'required|unique:tipo_depositos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipodepositos = new TipoDeposito;
		$tipodepositos->td_id = $request->txtid;
		$tipodepositos->td_descripcion = $request->txtdescripcion;

		TipoDeposito::where('td_id',$tipodepositos->td_id)->update(['td_descripcion'=>$tipodepositos->td_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipodepositos = TipoDeposito::where('td_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
