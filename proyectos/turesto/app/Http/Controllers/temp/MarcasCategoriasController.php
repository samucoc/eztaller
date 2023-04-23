<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Marcas;
class MarcasCategoriasController extends Controller
{
    private  $ruta = "marcas";
	private  $editar = "marcaseditar";

	public function index(){
		return view('adminlte::mantenedores.marcas');
	}

	public function gettipovales(){
		$marcas = Marcas::all();
		return Datatables::of($marcas)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'marca_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'marca_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
			['marca_descripcion' 	=> $request->txtdescripcion],
			['marca_descripcion' 	=> 'required|unique:marcas'],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$marcas = new Marcas;
		$marcas->marca_descripcion = $request->txtdescripcion;
		$marcas->estado_id = 1; //de forma predeterminada se crea con el estado activo de la tabla estados
		$marcas->creado_por= $user->name; //guardamos el nombre de la persona que realizo la creacion de la nueva marca
		
		$marcas->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$marcas = Marcas::get()->where('marca_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('marcas',$marcas);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'marca_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'marca_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'marca_descripcion' 	=> $request->txtdescripcion
			],
			[
			'marca_descripcion' 	=> 'required|unique:marcas'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$marcas = new Marcas;
		$marcas->marca_id = $request->txtid;
		$marcas->marca_descripcion = $request->txtdescripcion;
		$marcas->modificado_por = $user->name;

		Marcas::where('marca_id',$marcas->marca_id)->update(['marca_descripcion'=>$marcas->marca_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$marcas = Marcas::where('marca_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
