<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Modelos;
class ModelosController extends Controller
{
    private  $ruta = "modelos";
	private  $editar = "modeloseditar";

	public function index(){
		return view('adminlte::mantenedores.modelos');
	}

	public function getmodelos(){
		$modelos = Modelos::all();
		return Datatables::of($modelos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'modelo_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'modelo_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'modelo_busqueda.required' => 'El campo texto busqueda no puede ser nulo',
			'modelo_busqueda.required|unique'=>'El texto de busqueda ya se encuentra en el sistema'
			);

		$validator = \Validator::make(
			['modelo_descripcion' 	=> $request->txtdescripcion,'modelo_busqueda'=>'$request->txtbusqueda'],
			['modelo_descripcion' 	=> 'required|unique:modelos','modelo_busqueda'=>'required|unique:modelos'],//especificamos que sea unico y le indicamos la tabla
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$modelos = new Modelos;
		$modelos->modelo_descripcion = $request->txtdescripcion;
		$modelos->modelo_busqueda = $request->txtbusqueda;
		$modelos->estado_id = 1; //de forma predeterminada se crea con el estado activo de la tabla estados
		$modelos->creado_por= $user->name; //guardamos el nombre de la persona que realizo la creacion de la nueva categoria
		
		$modelos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$modelos = Modelos::get()->where('modelo_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('modelos',$modelos);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'categoria_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'categoria_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'modelo_descripcion' 	=> $request->txtdescripcion
			],
			[
			'modelo_descripcion' 	=> 'required|unique:modelos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$modelos = new Modelos;
		$modelos->modelo_id = $request->txtid;
		$modelos->modelo_descripcion = $request->txtdescripcion;
		$modelos->modelo_busqueda = $request->txtbusqueda;
		$modelos->modificado_por = $user->name;

		Modelos::where('modelo_id',$modelos->modelo_id)->update(['modelo_descripcion'=>$modelos->modelos_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$modelos = Modelos::where('modelos_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
