<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoMovim;
class TipoMovimController extends Controller
{	
	private  $ruta = "tipomovim";
	private  $editar = "tipomovimeditar";
    public function index(){
		return view('adminlte::mantenedores.tipomovim');
	}


	public function getmovim(){
		$movims = TipoMovim::all();
		return Datatables::of($movims)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tm_descripcion.required'=> 'El Campo codigo no puede ser nulo.',
			'tm_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tm_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tm_descripcion' 	=> 'required|unique:tipo_movim'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$movims = new TipoMovim;
		$movims->tm_descripcion = $request->txtdescripcion;
		$movims->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$movims = TipoMovim::get()->where('tm_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('movims',$movims);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tm_descripcion.required'=> 'El Campo codigo no puede ser nulo.',
			'tm_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'tm_descripcion' 	=> $request->txtdescripcion
			],
			[
			'tm_descripcion' 	=> 'required|unique:tipo_movim'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$movims = new TipoMovim;
		$movims->tm_id = $request->txtid;
		$movims->tm_descripcion = $request->txtdescripcion;
		

		TipoMovim::where('tm_id',$movims->tm_id)->update(['tm_descripcion'=>$movims->tm_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$movims = TipoMovim::where('tm_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
