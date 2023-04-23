<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoFormaPago;
class TipoFormasPagosController extends Controller
{
      private  $ruta = "tipoformaspagos";
	private  $editar = "tipoformaspagoseditar";

    public function index(){
		return view('adminlte::mantenedores.'. $this->ruta.'');
	}


	public function gettipopago(){
		$tipopagos = TipoFormaPago::all();
		return Datatables::of($tipopagos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tfp_codigo.required'=> 'El Campo codigo no puede ser nulo.',
			'tfp_codigo.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'tfp_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tfp_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'tfp_dias.required'=> 'El Campo Dias no puede ser nulo.',
			'tfp_tasa.required|unique'=> 'El Campo Tasa no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'tfp_codigo' 	=> $request->txtcodigo,
			'tfp_descripcion' 	=> $request->txtdescripcion,
			'tfp_dias' 	=> $request->txtdias,
			'tfp_tasa' 	=> $request->txttasa
			],
			[
			'tfp_codigo' 	=> 'required|unique:tipo_formas_pagos',
			'tfp_descripcion' 	=> 'required|unique:tipo_formas_pagos',
			'tfp_dias' 	=> 'required',
			'tfp_tasa' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }

		$tipopagos = new TipoFormaPago;
		$tipopagos->tfp_codigo = $request->txtcodigo;
		$tipopagos->tfp_descripcion = $request->txtdescripcion;
		$tipopagos->tfp_dias = $request->txtdias;
		$tipopagos->tfp_tasa = $request->txttasa;
		$tipopagos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipopagos = TipoFormaPago::get()->where('tfp_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipopagos',$tipopagos);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tfp_codigo.required'=> 'El Campo codigo no puede ser nulo.',
			'tfp_codigo.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'tfp_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tfp_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'tfp_dias.required'=> 'El Campo Dias no puede ser nulo.',
			'tfp_tasa.required|unique'=> 'El Campo Tasa no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'tfp_codigo'      => $request->txtcodigo,
			'tfp_descripcion' => $request->txtdescripcion,
			'tfp_dias'        => $request->txtdias,
			'tfp_tasa'        => $request->txttasa
			],
			[
			'tfp_codigo'      => 'required|unique:tipo_formas_pagos',
			'tfp_descripcion' => 'required|unique:tipo_formas_pagos',
			'tfp_dias'        => 'required',
			'tfp_tasa'        => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
		$tipopagos                  = new TipoFormaPago;
		$tipopagos->tfp_id          = $request->txtid;
		$tipopagos->tfp_codigo      = $request->txtcodigo;
		$tipopagos->tfp_descripcion = $request->txtdescripcion;
		$tipopagos->tfp_dias        = $request->txtdias;
		$tipopagos->tfp_tasa        = $request->txttasa;

		TipoFormaPago::where('tfp_id',$tipopagos->tfp_id)->update(['tfp_codigo'=>$tipopagos->tfp_codigo,'tfp_descripcion'=>$tipopagos->tfp_descripcion,'tfp_dias'=>$tipopagos->tfp_dias,'tfp_tasa'=>$tipopagos->tfp_tasa]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipopagos = TipoFormaPago::where('tfp_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
