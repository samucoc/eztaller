<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\RangoDescuento;
class RangoDescuentosController extends Controller
{
    private  $ruta = "rangodescuentos";
	private  $editar = "rangodescuentoseditar";
    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function getrangodescuento(){
		$rangodescuentos = RangoDescuento::all();
		return Datatables::of($rangodescuentos)
		->make(true);
	}

	public function crear(Request $request){

		$mensajes = array(
			'rd_desde.required'=> 'El Campo Desde no puede ser nulo',
			'rd_hasta.required'=> 'El Campo Hasta no puede ser nulo',
			'rd_porcentaje.required'=> 'El Campo Porcentaje no puede ser nulo'
			);

		$validator = \Validator::make(
	 		
			[
			'rd_desde' 	=> $request->txtdesde,
			
			'rd_hasta' 	=> $request->txthasta,
		
			'rd_porcentaje' 	=> $request->txtporcentaje
			],
			[
			'rd_desde' 	=> 'required',
			
			'rd_hasta' 	=> 'required',
		
			'rd_porcentaje' 	=> 'required|numeric'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$rangodescuentos = new RangoDescuento;
		$rangodescuentos->rd_desde = $request->txtdesde;
		$rangodescuentos->rd_hasta = $request->txthasta;
		$rangodescuentos->rd_porcentaje = $request->txtporcentaje;
		$rangodescuentos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$rangodescuentos = RangoDescuento::get()->where('rd_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('rangodescuentos',$rangodescuentos);

	}

	public function Guardar(Request $request){

		$mensajes = array(
			'rd_desde.required'=> 'El Campo Desde no puede ser nulo',
			'rd_hasta.required'=> 'El Campo Desde no puede ser nulo',
			'rd_porcentaje.required'=> 'El Campo Desde no puede ser nulo'
			);

		$validator = \Validator::make(
	 		
			[
			'rd_desde' 	=> $request->txtdesde,
			
			'rd_hasta' 	=> $request->txthasta,
		
			'rd_porcentaje' 	=> $request->txtporcentaje
			],
			[
			'rd_desde' 	=> 'required',
			
			'rd_hasta' 	=> 'required',
		
			'rd_porcentaje' 	=> 'required|numeric'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        
		$rangodescuentos = new RangoDescuento;
		$rangodescuentos->rd_id = $request->txtid;
		$rangodescuentos->rd_desde = $request->txtdesde;
		$rangodescuentos->rd_hasta = $request->txthasta;
		$rangodescuentos->rd_porcentaje = $request->txtporcentaje;

		RangoDescuento::where('rd_id',$rangodescuentos->rd_id)->update(['rd_desde'=>$rangodescuentos->rd_desde,'rd_hasta'=>$rangodescuentos->rd_hasta,'rd_porcentaje'=>$rangodescuentos->rd_porcentaje]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$rangodescuentos = RangoDescuento::where('rd_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
