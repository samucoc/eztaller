<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Categorias;
class CategoriasController extends Controller
{
    private  $ruta = "categorias";
	private  $editar = "categoriaseditar";

	public function index(){
		return view('adminlte::mantenedores.categorias');
	}

	public function getcategorias(){
		$categorias = Categorias::all();
		return Datatables::of($categorias)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'categoria_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'categoria_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
			['categoria_descripcion' 	=> $request->txtdescripcion],
			['categoria_descripcion' 	=> 'required|unique:categorias'],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$categorias = new Categorias;
		$categorias->categoria_descripcion = $request->txtdescripcion;
		$categorias->estado_id = 1; //de forma predeterminada se crea con el estado activo de la tabla estados
		$categorias->creado_por= $user->name; //guardamos el nombre de la persona que realizo la creacion de la nueva categoria
		
		$categorias->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$categorias = Categorias::get()->where('categoria_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('categorias',$categorias);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'categoria_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'categoria_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'categoria_descripcion' 	=> $request->txtdescripcion
			],
			[
			'categoria_descripcion' 	=> 'required|unique:categorias'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$categorias = new Categorias;
		$categorias->categoria_id = $request->txtid;
		$categorias->categoria_descripcion = $request->txtdescripcion;
		$categorias->modificado_por = $user->name;

		Categorias::where('categoria_id',$categorias->categoria_id)->update(['categoria_descripcion'=>$categorias->categoria_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$categorias = Categorias::where('categoria_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
