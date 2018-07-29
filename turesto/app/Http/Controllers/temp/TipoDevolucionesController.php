<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoDevolucion;
class TipoDevolucionesController extends Controller
{
    private  $ruta = "tipodevoluciones";
	private  $editar = "tipodevolucioneseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettipodevolucion(){
		$tipodevoluciones = TipoDevolucion::all();
		return Datatables::of($tipodevoluciones)
		->make(true);
	}

	public function crear(Request $request){


		$mensajes = array(
			'td_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'td_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$validator = \Validator::make(
	 		
			[
			'td_descripcion' 	=> $request->txtdescripcion
			],
			[
			'td_descripcion' 	=> 'required|unique:tipo_devoluciones'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipodevoluciones = new TipoDevolucion;
		$tipodevoluciones->td_descripcion = $request->txtdescripcion;
		
		$tipodevoluciones->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipodevoluciones = TipoDevolucion::get()->where('td_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipodevoluciones',$tipodevoluciones);

	}

	public function Guardar(Request $request){

		$mensajes = array(
			'td_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'td_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$validator = \Validator::make(
	 		
			[
			'td_descripcion' 	=> $request->txtdescripcion
			],
			[
			'td_descripcion' 	=> 'required|unique:tipo_devoluciones'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipodevoluciones = new TipoDevolucion;
		$tipodevoluciones->td_id = $request->txtid;
		$tipodevoluciones->td_descripcion = $request->txtdescripcion;

		TipoDevolucion::where('td_id',$tipodevoluciones->td_id)->update(['td_descripcion'=>$tipodevoluciones->td_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipodevoluciones = TipoDevolucion::where('td_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
