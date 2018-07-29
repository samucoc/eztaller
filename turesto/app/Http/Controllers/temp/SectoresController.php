<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Sector;
use App\Zona;
class SectoresController extends Controller
{
    private  $ruta = "sectores";
	private  $editar = "sectoreseditar";

    public function index(){
    	$zonas = Zona::all();
    	$sector= Sector::orderBy('sector_codigo','desc')->take(1)->get();
		return view('adminlte::mantenedores.'. $this->ruta.'')->with('zonas',$zonas)->with('sectores',$sector);
	}


	public function getsectores(){
		$sectores = Sector::all();
		return Datatables::of($sectores)
		->make(true);
	}

	public function crear(Request $request){

		$mensajes = array(
			'sector_descripcion.required'=> 'El Campo descripcion no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'sector_descripcion' 	=> $request->txtdescripcion
			],
			[
			'sector_descripcion' 	=> 'required|unique:sectores'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$sectores                     = new Sector;
		$sectores->sector_codigo      = $request->txtcodigo;
		$sectores->sector_descripcion = $request->txtdescripcion;
		$sectores->sector_estado      = 1;
		$sectores->zona_id            = $request->txtzona;
		$sectores->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$sectores = Sector::get()->where('sector_id', '=', $id);
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
        
		$sectores = new Sector;
		$sectores->sector_id = $request->txtid;
		$sectores->sector_codigo = $request->txtcodigo;
		$sectores->sector_descripcion = $request->txtdescripcion;
		$sectores->sector_estado = $request->txtestado;
		$sectores->zona_id = $request->txtzona;

		Sector::where('sector_id',$sectores->sector_id)->update(['sector_codigo'=>$sectores->sector_codigo,'sector_descripcion'=>$sectores->sector_descripcion,'sector_estado'=>$sectores->sector_estado,'zona_id'=>$sectores->zona_id]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$sectores = Sector::where('sector_id',$id)->update(['sector_estado'=>0]);
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
