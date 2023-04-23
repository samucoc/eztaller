<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoMovimiento;
class TipoMovimientosController extends Controller
{	
	private  $ruta = "tipomovimientos";
	private  $editar = "tipomovimientoseditar";
    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getmovimientos(){
		$movimientos = TipoMovimiento::all();
		return Datatables::of($movimientos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tm_codigo.required'=> 'El Campo codigo no puede ser nulo.',
			'tm_codigo.required|unique'=> 'El Campo Codigo ya se encuentra en el sistema.',
			'tm_descripcion.required'=> 'El Campo descripcion no puede ser nulo.',
			'tm_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$validator = \Validator::make(
	 		
			[
			'tm_codigo' 	=> $request->txtcodigo,
			'tm_descripcion'=> $request->txtdescripcion
			],
			[
			'tm_codigo' 	=> 'required|unique:tipo_movimientos',
			'tm_descripcion' 	=> 'required|unique:tipo_movimientos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$movimientos = new TipoMovimiento;
		$movimientos->tm_codigo = $request->txtcodigo;
		$movimientos->tm_descripcion = $request->txtdescripcion;
		$movimientos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$movimientos = TipoMovimiento::get()->where('tm_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('movimientos',$movimientos);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tm_codigo.required'=> 'El Campo codigo no puede ser nulo.',
			'tm_codigo.required|unique'=> 'El Campo Codigo ya se encuentra en el sistema.',
			'tm_descripcion.required'=> 'El Campo descripcion no puede ser nulo.',
			'tm_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			);

		$validator = \Validator::make(
	 		
			[
			'tm_codigo' 	=> $request->txtcodigo,
			'tm_descripcion'=> $request->txtdescripcion
			],
			[
			'tm_codigo' 	=> 'required|unique:tipo_movimientos',
			'tm_descripcion' 	=> 'required|unique:tipo_movimientos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$movimientos = new TipoMovimiento;
		$movimientos->tm_id = $request->txtid;
		$movimientos->tm_codigo = $request->txtcodigo;
		$movimientos->tm_descripcion = $request->txtdescripcion;
		

		TipoMovimiento::where('tm_id',$movimientos->tm_id)->update(['tm_codigo'=>$movimientos->tm_codigo,'tm_descripcion'=>$movimientos->tm_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$movimientos = TipoMovimiento::where('tm_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}

}
