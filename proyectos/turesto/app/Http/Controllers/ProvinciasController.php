<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Region;
use App\Provincia;

class ProvinciasController extends Controller
{
    private  $ruta = "provincias";
	private  $editar = "provinciaseditar";
	
    public function index(){
    	$regiones = Region::all();
		return view('adminlte::mantenedores.'. $this->ruta.'')->with('regiones',$regiones);
	}


	public function getprovincia(){
		$regiones = Region::all();
		$provincias = Provincia::all();

		foreach ($provincias as $provincia) {
			foreach ($regiones as $region) {
				if ($region->region_id == $provincia->region_id) {
					$provincia->region_nombre = $region->region_nombre;
				}
			}
		}

		//dd($provincias);
		return Datatables::of($provincias)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'provincia_nombre.required'=> 'El campo estado no puede ser nulo ',
			'provincia_nombre.required|unique'=> 'La Provincia ingresada ya se encuentra en el sistema',
			'region_id.required'=> 'El campo Region no puede ser nulo ',
			);

		$validator = \Validator::make(
	 		
			[
			'provincia_nombre' 	=> $request->txtnombre,
			'region_id' 	=> $request->txtnombre
			],
			[
			'provincia_nombre' 	=> 'required|unique:provincias',
			'region_id' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$provincias = new Provincia;
		$provincias->provincia_nombre = $request->txtnombre;
		$provincias->region_id = $request->txtregion;
		
		$provincias->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$provincias = Provincia::get()->where('provincia_id', '=', $id);
		$regiones = Region::get();
		return view('adminlte::mantenedores.'. $this->editar.'')->with('provincias',$provincias)->with('regiones',$regiones);

	}

	public function Guardar(Request $request){

		$mensajes = array(
			'provincia_nombre.required'=> 'El campo estado no puede ser nulo ',
			'provincia_nombre.required|unique'=> 'La Provincia ingresada ya se encuentra en el sistema',
			'region_id.required'=> 'El campo Region no puede ser nulo ',
			);

		$descripciones = Provincia::select('provincia_nombre')->where('provincia_id','=',$request->txtid)->get();
		foreach ($descripciones as $descripcion ) {
			$nombre = $descripcion->provincia_nombre;
		}
		if ($nombre == $request->txtnombre) {
			$validator = \Validator::make(
		 		
				[
				'provincia_nombre' 	=> $request->txtnombre,
				'region_id' 	=> $request->txtnombre
				],
				[
				'provincia_nombre' 	=> 'required',
				'region_id' 	=> 'required'
				],
				$mensajes
			);

		}else{
			$validator = \Validator::make(
		 		
				[
				'provincia_nombre' 	=> $request->txtnombre,
				'region_id' 	=> $request->txtnombre
				],
				[
				'provincia_nombre' 	=> 'required|unique:provincias',
				'region_id' 	=> 'required'
				],
				$mensajes
			);

		}



		$validator = \Validator::make(
	 		
			[
			'provincia_nombre' 	=> $request->txtnombre,
			'region_id' 	=> $request->txtnombre
			],
			[
			'provincia_nombre' 	=> 'required|unique:provincias',
			'region_id' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$provincias = new Provincia;
		$provincias->provincia_id = $request->txtid;
		$provincias->provincia_nombre = $request->txtnombre;
		$provincias->region_id = $request->txtregion;
		

		Provincia::where('provincia_id',$provincias->provincia_id)->update(['provincia_nombre'=>$provincias->provincia_nombre,'region_id'=>$provincias->region_id]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$provincias = Provincia::where('provincia_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
