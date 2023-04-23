<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoAbono;
class TipoAbonosController extends Controller
{
	private  $ruta = "tipoabonos";
	private  $editar = "tipoabonoseditar";

    public function index(){
    	
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getabonos(){
		$tabono = TipoAbono::all();
		return Datatables::of($tabono)
		->make(true);
	}

	public function crear(Request $request){

		$mensajes = array(
			'ta_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'ta_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$validator = \Validator::make(
	 		
			[
			'ta_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ta_descripcion' 	=> 'required|unique:tipo_abonos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$tabono = new TipoAbono;
		$tabono->ta_descripcion = $request->txtdescripcion;
		$tabono->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tabono = TipoAbono::get()->where('ta_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('abonos',$tabono);

	}

	public function Guardar(Request $request){


		$mensajes = array(
			'ta_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'ta_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$descripciones = TipoAbono::select('ta_descripcion')->where('ta_id','=',$request->txtid)->get();
		foreach ($descripciones as $descripcion ) {
			$nombre = $descripcion->ta_descripcion;
		}
		if ($nombre == $request->txtdescripcion) {
			$validator = \Validator::make(
		 		
				[
				'ta_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ta_descripcion' 	=> 'required'
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
		 		
				[
				'ta_descripcion' 	=> $request->txtdescripcion
				],
				[
				'ta_descripcion' 	=> 'required|unique:tipo_abonos'
				],
				$mensajes
			);
		}

		

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tabono = new TipoAbono;
		$tabono->ta_id = $request->txtid;
		$tabono->ta_descripcion = $request->txtdescripcion;
		

		TipoAbono::where('ta_id',$tabono->ta_id)->update(['ta_descripcion'=>$tabono->ta_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tabono = TipoAbono::where('ta_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
