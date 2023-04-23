<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Zona;
class ZonasController extends Controller
{
    private  $ruta = "zonas";
	private  $editar = "zonaseditar";

    public function index(){
    	
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getzonas(){
		$zonas = Zona::all();
		return Datatables::of($zonas)
		->make(true);
	}

	public function crear(Request $request){
		
		$mensajes = array(
			'zona_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'zona_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'zona_descripcion' 	=> $request->txtdescripcion
			],
			[
			'zona_descripcion' 	=> 'required|unique:zonas'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$zonas = new Zona;
		$zonas->zona_descripcion = $request->txtdescripcion;
		$zonas->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){

		$mensajes = array(
			'zona_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'zona_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'zona_descripcion' 	=> $request->txtdescripcion
			],
			[
			'zona_descripcion' 	=> 'required|unique:zonas'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$zonas = Zona::get()->where('zona_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('zonas',$zonas);

	}

	public function Guardar(Request $request){
		$zonas = new Zona;
		$zonas->zona_id = $request->txtid;
		$zonas->zona_descripcion = $request->txtdescripcion;
		

		Zona::where('zona_id',$zonas->zona_id)->update(['zona_descripcion'=>$zonas->zona_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$zonas = Zona::where('zona_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
