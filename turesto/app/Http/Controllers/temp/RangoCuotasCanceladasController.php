<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\RangoCuotaCancelada;

class RangoCuotasCanceladasController extends Controller
{
    private  $ruta = "rangocuotas";
	private  $editar = "rangocuotaseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getrangocuotas(){
		$rangocuotas = RangoCuotaCancelada::all();
		return Datatables::of($rangocuotas)
		->make(true);
	}

	public function crear(Request $request){


		$mensajes = array(
			'rcc_inicio.required'=> 'El campo Inicio no puede ser nulo/vacio.',
			'rcc_fin.required'=> 'El campo Fin no puede ser nulo/vacio.',
			'rcc_dias.required'=> 'El campo Dias no puede ser nulo/vacio.'
			);

		$validator = \Validator::make(
	 		
			[
			'rcc_inicio' 	=> $request->txtinicio,
			
			'rcc_fin' 	=> $request->txtfin,
		
			'rcc_dias' 	=> $request->txtdias
			],
			[
			'rcc_inicio' 	=> 'required',
			
			'rcc_fin' 	=> 'required',
		
			'rcc_dias' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$rangocuotas = new RangoCuotaCancelada;
		$rangocuotas->rcc_inicio = $request->txtinicio;
		$rangocuotas->rcc_fin = $request->txtfin;
		$rangocuotas->rcc_dias = $request->txtdias;
		$rangocuotas->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar ($id){
		$rangocuotas = RangoCuotaCancelada::get()->where('rcc_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('rangocuotas',$rangocuotas);

	}

	public function Guardar(Request $request){


		$mensajes = array(
			'rcc_inicio.required'=> 'El campo Inicio no puede ser nulo/vacio.',
			'rcc_fin.required'=> 'El campo Fin no puede ser nulo/vacio.',
			'rcc_dias.required'=> 'El campo Dias no puede ser nulo/vacio.'
			);

		$validator = \Validator::make(
	 		
			[
			'rcc_inicio' 	=> $request->txtinicio,
			
			'rcc_fin' 	=> $request->txtfin,
		
			'rcc_dias' 	=> $request->txtdias
			],
			[
			'rcc_inicio' 	=> 'required',
			
			'rcc_fin' 	=> 'required',
		
			'rcc_dias' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		
		$rangocuotas = new RangoCuotaCancelada;
		$rangocuotas->rcc_id = $request->txtid;
		$rangocuotas->rcc_inicio = $request->txtinicio;
		$rangocuotas->rcc_fin = $request->txtfin;
		$rangocuotas->rcc_dias = $request->txtdias;

		RangoCuotaCancelada::where('rcc_id',$rangocuotas->rcc_id)->update(['rcc_inicio'=>$rangocuotas->rcc_inicio,'rcc_fin'=>$rangocuotas->rcc_fin,'rcc_dias'=>$rangocuotas->rcc_dias]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$rangocuotas = RangoCuotaCancelada::where('rcc_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
