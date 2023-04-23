<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoPerfil;
class TipoPerfilesController extends Controller
{	

	private  $ruta = "tipoperfiles";
	private  $editar = "tipoperfileseditar";

    public function index(){
		return view('adminlte::mantenedores.tipoperfiles');
	}


	public function getperfiles(){
		$perfiles = TipoPerfil::all();
		return Datatables::of($perfiles)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tp_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tp_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tp_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tp_descripcion' 	=> 'required|unique:tipo_perfiles'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$perfiles = new TipoPerfil;
		$perfiles->tp_descripcion = $request->txtdescripcion;
		$perfiles->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$perfiles = TipoPerfil::get()->where('tp_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('perfiles',$perfiles);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tp_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tp_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tp_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tp_descripcion' 	=> 'required|unique:tipo_perfiles'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$perfiles = new TipoPerfil;
		$perfiles->tp_id = $request->txtid;
		$perfiles->tp_descripcion = $request->txtdescripcion;
		

		TipoPerfil::where('tp_id',$perfiles->tp_id)->update(['tp_descripcion'=>$perfiles->tp_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$perfiles = TipoPerfil::where('tp_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
