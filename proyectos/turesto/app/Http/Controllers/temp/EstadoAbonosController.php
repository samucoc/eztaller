<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\EstadoAbono;
class EstadoAbonosController extends Controller
{
      private  $ruta = "estadoabonos";
	private  $editar = "estadoabonoseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettipoabono(){
		$estadoabonos = EstadoAbono::all();
		return Datatables::of($estadoabonos)
		->make(true);
	}

	public function crear(Request $request){

		$mensajes = array(
			'ea_descripcion.required'=> 'El campo descripcion no puede ser nulo.',
			'ea_descripcion.required|unique'=> 'El estado ingresado ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'ea_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ea_descripcion' 	=> 'required|unique:estado_abonos',
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$estadoabonos = new EstadoAbono;
		$estadoabonos->ea_descripcion = $request->txtdescripcion;
		$estadoabonos->save();
		return redirect('mantenedores/'. $this->ruta.'')->with('notice', 'Empresa registrada con exito!');
	}



	public function editar($id){
		$estadoabonos = EstadoAbono::get()->where('ea_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('estadoabonos',$estadoabonos);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'ea_descripcion.required'=> 'El campo descripcion no puede ser nulo.',
			'ea_descripcion.required|unique'=> 'El estado ingresado ya se encuentra en el sistema.'
			);


		$estados = EstadoAbono::select('ea_descripcion')->where('ea_id','=',$request->txtid)->get();
		foreach ($estados as $status ) {
			$estado = $status->ea_descripcion;
		}

		if ($estado == $request->txtdescripcion) {
			$validator = \Validator::make(
		 		
				[
				'ea_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ea_descripcion' 	=> 'required',
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
		 		
				[
				'ea_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ea_descripcion' 	=> 'required|unique:estado_abonos',
				],
				$mensajes
			);
		}
		

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$estadoabonos = new EstadoAbono;
		$estadoabonos->ea_id = $request->txtid;
		$estadoabonos->ea_descripcion = $request->txtdescripcion;

		EstadoAbono::where('ea_id',$estadoabonos->ea_id)->update(['ea_descripcion'=>$estadoabonos->ea_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$estadoabonos = EstadoAbono::where('ea_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
