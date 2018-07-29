<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoSobrante;
class TipoSobrantesController extends Controller
{
    private  $ruta = "tiposobrantes";
	private  $editar = "tiposobranteseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettiposobrante(){
		$tiposobrantes = TipoSobrante::all();
		return Datatables::of($tiposobrantes)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'ts_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'ts_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'ts_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ts_descripcion' 	=> 'required|unique:tipo_sobrantes'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tiposobrantes = new TipoSobrante;
		$tiposobrantes->ts_descripcion = $request->txtdescripcion;
		
		$tiposobrantes->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tiposobrantes = TipoSobrante::get()->where('ts_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tiposobrantes',$tiposobrantes);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'ts_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'ts_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'ts_descripcion' 	=> $request->txtdescripcion
			],
			[
			'ts_descripcion' 	=> 'required|unique:tipo_sobrantes'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tiposobrantes = new TipoSobrante;
		$tiposobrantes->ts_id = $request->txtid;
		$tiposobrantes->ts_descripcion = $request->txtdescripcion;

		TipoSobrante::where('ts_id',$tiposobrantes->ts_id)->update(['ts_descripcion'=>$tiposobrantes->ts_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tiposobrantes = TipoSobrante::where('ts_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
