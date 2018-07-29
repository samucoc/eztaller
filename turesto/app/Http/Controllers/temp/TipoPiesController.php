<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoPie;
class TipoPiesController extends Controller
{
   	private  $ruta = "tipopies";
	private  $editar = "tipopieseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettipopie(){
		$tipopies = TipoPie::all();
		return Datatables::of($tipopies)
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
			'tp_descripcion' 	=> 'required|unique:tipo_pies'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipopies = new TipoPie;
		$tipopies->tp_descripcion = $request->txtdescripcion;
		
		$tipopies->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipopies = TipoPie::get()->where('tp_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipopies',$tipopies);

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
			'tp_descripcion' 	=> 'required|unique:tipo_pies'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipopies = new TipoPie;
		$tipopies->tp_id = $request->txtid;
		$tipopies->tp_descripcion = $request->txtdescripcion;

		TipoPie::where('tp_id',$tipopies->tp_id)->update(['tp_descripcion'=>$tipopies->tp_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipopies = TipoPie::where('tp_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
