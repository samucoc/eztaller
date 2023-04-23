<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Region;
use App\Provincia;
use App\Comuna;
class ComunasController extends Controller
{
    private  $ruta = "comunas";
	private  $editar = "comunaseditar";
	
    public function index(){
    	$provincias = Provincia::all();
		return view('adminlte::mantenedores.'. $this->ruta.'')->with('provincias',$provincias);
	}


	public function getcomuna(){
		$provincias = Provincia::all();
		$comunas = Comuna::all();

		foreach ($comunas as $comuna) {
			foreach ($provincias as $provincia) {
				if ($comuna->provincia_id == $provincia->provincia_id) {
					$comuna->provincia_nombre = $provincia->provincia_nombre;
				}
			}
		}


		return Datatables::of($comunas)->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'comuna_nombre.required'=> 'el Campo Nombre no puede ser nulo',
			'comuna_nombre.required|unique'=> 'El Campo Nombre ya se encuentra en el sistema'
			);

		$validator = \Validator::make(
			[
			'comuna_nombre' 	=> $request->txtnombre
			],
			[
			
			'comuna_nombre' 	=> 'required|string'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/comunas')->with('alert', 'comuna no registrado.')->withErrors($validator);
        }
		$comunas = new Comuna;
		$comunas->comuna_nombre = $request->txtnombre;
		$comunas->provincia_id = $request->txtregion;
		
		$comunas->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$comunas = Comuna::get()->where('comuna_id', '=', $id);
		$provincias = Provincia::get();
		return view('adminlte::mantenedores.'. $this->editar.'')->with('comunas',$comunas)->with('provincias',$provincias);

	}

	public function Guardar(Request $request){
		
		$mensajes = array(
			'comuna_nombre.required'=> 'el Campo Nombre no puede ser nulo',
			'comuna_nombre.required|unique'=> 'El Campo Nombre ya se encuentra en el sistema'
			);

		$nombre = Comuna::select('comuna_nombre')->where('comuna_id','=',$request->txtid)->get();
		foreach ($nombre as $nom ) {
			$n = $nom->comuna_nombre;
		}
		if ($n == $request->txtnombre) {
			
			$validator = \Validator::make(
				 		
				[
				'comuna_nombre' 	=> $request->txtnombre
				],
				[
				
				'comuna_nombre' 	=> 'required|string'
				],
				$mensajes
			);

		}else{
			$validator = \Validator::make(
		 		
				[
				'comuna_nombre' 	=> $request->txtnombre
				],
				[
				
				'comuna_nombre' 	=> 'required|unique:comunas|string'
				],
				$mensajes
			);

		}
		

 		if ($validator->fails()) {
			return redirect('mantenedores/comunas')->with('alert', 'comuna no registrada.')->withErrors($validator);
        }
		$comunas = new Comuna;
		$comunas->comuna_id = $request->txtid;
		$comunas->comuna_nombre = $request->txtnombre;
		$comunas->provincia_id = $request->txtprovincia;
		

		Comuna::where('comuna_id',$comunas->comuna_id)->update(['comuna_nombre'=>$comunas->comuna_nombre,'provincia_id'=>$comunas->provincia_id]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$comunas = Comuna::where('comuna_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
