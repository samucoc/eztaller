<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use App\Clientes;
use App\Comuna;
use App\Sector;
use App\Cupos;

class ClientesController extends Controller
{
    private  $ruta = "clientes";
	private  $editar = "clienteseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getclientes(Request $request){
		$termino = explode('-',$request->cliente);
		$clientes = Clientes::where('cliente_rut','=',$termino[0])->get();
		return \Response::json($clientes);
	}

	public function crear(Request $request){

		$mensajes = array(
			'cliente_descripcion.required'=> 'El Campo descripcion no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'cliente_descripcion' 	=> $request->txtdescripcion
			],
			[
			'sector_descripcion' 	=> 'required|unique:sectores'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$clientes                     = new Sector;
		$clientes->sector_codigo      = $request->txtcodigo;
		$clientes->sector_descripcion = $request->txtdescripcion;
		$clientes->sector_estado      = 1;
		$clientes->zona_id            = $request->txtzona;
		$seclientesctores->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$clientes = Sector::get()->where('sector_id', '=', $id);
		$zonas = Zona::all();
		return view('adminlte::mantenedores.'. $this->editar.'')->with('sectores',$sectores)->with('zonas',$zonas);

	}

	public function Guardar(Request $request){
		$descripcion = Sector::select('sector_descripcion')->where('sector_id','=',$request->txtid)->get();

		
		foreach ($descripcion as $descrip ) {
			$nombre = $descrip->sector_descripcion;
		}

		$mensajes = array(
			'sector_descripcion.required'=> 'El Campo descripcion no puede ser nulo.',
			'sector_descripcion.required|required'=> 'La descripcion ya se encuentra en el sistema.'
			);


		if ($nombre == $request->txtdescripcion) {
			$validator = \Validator::make(
	 		
			[
			'sector_descripcion' => $request->txtdescripcion,
			'sector_codigo'      => $request->txtcodigo,
			'zona_id'            => $request->txtzona
			],
			[

			'sector_descripcion' => 'required',
			'sector_codigo'      => 'required',
			'zona_id'            => 'required'
			],
			$mensajes
			);
		}else{

			$validator = \Validator::make(
	 		
			[
			'sector_descripcion' => $request->txtdescripcion,
			'sector_codigo'      => $request->txtcodigo,
			'zona_id'            => $request->txtzona
			],
			[

			'sector_descripcion' => 'required|unique:sectores',
			'sector_codigo'      => 'required',
			'zona_id'            => 'required'
			],
			$mensajes
		);
		}


		

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        
		$clientes = new Sector;
		$clientes->sector_id = $request->txtid;
		$clientes->sector_codigo = $request->txtcodigo;
		$clientes->sector_descripcion = $request->txtdescripcion;
		$clientes->sector_estado = $request->txtestado;
		$clientes->zona_id = $request->txtzona;

		Sector::where('sector_id',$clientes->sector_id)->update(['sector_codigo'=>$clientes->sector_codigo,'sector_descripcion'=>$clientes->sector_descripcion,'sector_estado'=>$clientes->sector_estado,'zona_id'=>$clientes->zona_id]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$clientes = Sector::where('sector_id',$id)->update(['sector_estado'=>0]);
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
