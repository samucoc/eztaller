<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoVales;

class TipoValesController extends Controller
{
    private  $ruta = "tipovales";
	private  $editar = "tipovaleseditar";

	public function index(){
		return view('adminlte::mantenedores.tipovales');
	}

	public function gettipovales(){
		$tipovales = TipoVales::all();
		return Datatables::of($tipovales)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tv_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tv_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tv_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tv_descripcion' 	=> 'required|unique:tipo_vales'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$tipovales = new TipoVales;
		$tipovales->tv_estado = 1;
		$tipovales->tv_descripcion = $request->txtdescripcion;
		$tipovales->creado_por= $user->name;
		
		$tipovales->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipovales = TipoVales::get()->where('tv_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipovales',$tipovales);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tv_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tv_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tv_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tv_descripcion' 	=> 'required|unique:tipo_vales'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$tipovales = new TipoVales;
		$tipovales->tv_id = $request->txtid;
		$tipovales->tv_descripcion = $request->txtdescripcion;
		$tipovales->modificado_por = $user->name;

		TipoVales::where('tv_id',$tipovales->tv_id)->update(['tv_descripcion'=>$tipovales->tv_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipovales = TipoVales::where('tv_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
