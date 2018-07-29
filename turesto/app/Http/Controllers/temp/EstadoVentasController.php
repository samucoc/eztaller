<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\EstadoVentas;
class EstadoVentasController extends Controller
{
    private  $ruta = "estadoventas";
	private  $editar = "estadoventaseditar";
	
    public function index(){
    	
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getestados(){
		$estadoventas = EstadoVentas::all();
		return Datatables::of($estadoventas)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'ev_descripcion.required'=> 'El campo estado no puede ser nulo ',
			'ev_descripcion.required|unique'=> 'La descripcion ingresada ya se encuentra en el sistema',
			);

		$validator = \Validator::make(
	 		
			[
			'ev_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ev_descripcion' 	=> 'required|unique:estado_ventas'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$estadoventas = new EstadoVentas;
		$estadoventas->ev_descripcion = $request->txtdescripcion;
		$estadoventas->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$estadoventas = EstadoVentas::get()->where('ev_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('estadoventas',$estadoventas);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'ev_descripcion.required'=> 'El campo estado no puede ser nulo ',
			'ev_descripcion.required|unique'=> 'La descripcion ingresada ya se encuentra en el sistema',
			);


		$descripciones = EstadoVentas::select('ev_descripcion')->where('ev_id','=',$request->txtid)->get();
		foreach ($descripciones as $descripcion ) {
			$descrip = $descripcion->ev_descripcion;
		}
		if ($descrip == $request->txtdescripcion) {
			$validator = \Validator::make(
		 		
				[
				'ev_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ev_descripcion' 	=> 'required'
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
		 		
				[
				'ev_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ev_descripcion' 	=> 'required|unique:estado_ventas'
				],
				$mensajes
			);
		}

		$validator = \Validator::make(
	 		
			[
			'ev_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ev_descripcion' 	=> 'required|unique:estado_ventas'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        
		$estadoventas = new EstadoVentas;
		$estadoventas->ev_id = $request->txtid;
		$estadoventas->ev_descripcion = $request->txtdescripcion;
		

		EstadoVentas::where('ev_id',$estadoventas->ev_id)->update(['ev_descripcion'=>$estadoventas->ev_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$estadoventas = EstadoVentas::where('ev_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
