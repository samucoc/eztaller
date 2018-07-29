<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Region;
class RegionesController extends Controller
{
    private  $ruta = "regiones";
	private  $editar = "regioneseditar";
	
    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getregion(){
		$regiones = Region::all();
		return Datatables::of($regiones)
		->make(true);
	}

	public function crear(Request $request){

		$mensajes = array(
			'region_nombre.required'=> 'El Campo Nombre no puede ser nulo.',
			'region_ordinal.required'=> 'El Campo Ordinal no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'region_nombre' 	=> $request->txtnombre,
			
			'region_ordinal' 	=> $request->txtordinal
			],
			[
			'region_nombre' 	=> 'required|unique:Empresas',
			
			'region_ordinal' 	=> 'required|min:5|string'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$regiones = new Region;
		$regiones->region_nombre = $request->txtnombre;
		$regiones->region_ordinal = $request->txtordinal;
		
		$regiones->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$regiones = Region::get()->where('region_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('regiones',$regiones);

	}

	public function Guardar(Request $request){

		$mensajes = array(
			'region_nombre.required'=> 'El Campo Nombre no puede ser nulo.',
			'region_ordinal.required'=> 'El Campo Ordinal no puede ser nulo.'
			);

		$descripciones = Region::select('region_nombre')->where('region_id','=',$request->txtid)->get();
		foreach ($descripciones as $descripcion ) {
			$nombre = $descripcion->region_nombre;
		}

		if ($nombre == $request->txtnombre) {
			$validator = \Validator::make(
		 		
				[
				'region_nombre' 	=> $request->txtnombre,
				
				'region_ordinal' 	=> $request->txtordinal
				],
				[
				'region_nombre' 	=> 'required',
				
				'region_ordinal' 	=> 'required|min:5|string'
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
		 		
				[
				'region_nombre' 	=> $request->txtnombre,
				
				'region_ordinal' 	=> $request->txtordinal
				],
				[
				'region_nombre' 	=> 'required|unique:Empresas',
				
				'region_ordinal' 	=> 'required|min:5|string'
				],
				$mensajes
			);
		}

		

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }


		$regiones = new Region;
		$regiones->region_id = $request->txtid;
		$regiones->region_nombre = $request->txtnombre;
		$regiones->region_ordinal = $request->txtordinal;
		

		Region::where('region_id',$regiones->region_id)->update(['region_nombre'=>$regiones->region_nombre,'region_ordinal'=>$regiones->region_ordinal]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$regiones = Region::where('region_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
