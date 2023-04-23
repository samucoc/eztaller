<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Empresas;
use App\Trabajador;
use PDF;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EmpresasController extends Controller
{
    
	
	public function index(){
		return view('adminlte::mantenedores.empresas');
	}


	public function getEmpresas(){
		$empresas = Empresas::all();
		return Datatables::of($empresas)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'empresa_rut.required'=> 'Rut Ya existe o el campo se encuentra vacio ',
			'empresa_nombre.required'=> 'Nombre no puede ser nulo',
			'empresa_mutual.required'=> 'Mutual no puede ser nulo'
			);

		$validator = \Validator::make(
	 		
			[
			'empresa_rut' 	=> $request->txtrut,
			
			'empresa_nombre' 	=> $request->txtnombre,
		
			'empresa_mutual' 	=> $request->txtmutual
			],
			[
			'empresa_rut' 	=> 'required|unique:Empresas',
			
			'empresa_nombre' 	=> 'required|min:5|string',
		
			'empresa_mutual' 	=> 'required|numeric'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/empresas')->withErrors($validator);
        }

	    $empresa = new Empresas;
		$empresa->empresa_rut = $request->txtrut;
		$empresa->empresa_nombre = $request->txtnombre;
		$empresa->empresa_direccion = $request->txtdireccion;
		$empresa->empresa_giro = $request->txtgiro;
		$empresa->empresa_mail = "notiene@notiene.cl";
		$empresa->empresa_mutual = $request->txtmutual;
		$empresa->empresa_estado = 1;
		$empresa->save();
		return redirect('mantenedores/empresas')->with('notice', 'Empresa registrada con exito!');
	}



	public function editar($id){
		$empresa = Empresas::get()->where('empresa_id', '=', $id);
		return view('adminlte::mantenedores.empresaseditar')->with('empresas',$empresa);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			
			'empresa_nombre.required'=> 'Nombre no puede ser nulo',
			'empresa_direccion.required'=> 'Direccion no puede ser nulo',
			'empresa_mutual.required'=> 'Mutual no puede ser nulo'
			);

		$validator = \Validator::make(
	 		
			[
			
			'empresa_direccion' 	=> $request->txtdireccion,
			'empresa_nombre' 	=> $request->txtnombre,
			'empresa_mutual' 	=> $request->txtmutual
			],
			[
			
			'empresa_direccion' 	=> 'required',
			'empresa_nombre' 	=> 'required|min:5|string',
			'empresa_mutual' 	=> 'required|numeric'

			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/empresas/editar/'.$request->txtid.'')->withErrors($validator);
        }
		$empresa = new Empresas;
		$empresa->empresa_id = $request->txtid;
		$empresa->empresa_nombre = $request->txtnombre;
		$empresa->empresa_direccion = $request->txtdireccion;
		$empresa->empresa_giro = $request->txtgiro;
		$empresa->empresa_mutual = $request->txtmutual;
		$empresa->empresa_estado = $request->txtestado;
		if ($empresa->empresa_estado == "on") {
			$empresa->empresa_estado = 1;
		}else{
			$empresa->empresa_estado = 0;
		}
		
		Empresas::where('empresa_id',$empresa->empresa_id)->update(['empresa_nombre'=>$empresa->empresa_nombre,'empresa_direccion'=>$empresa->empresa_direccion,'empresa_giro'=>$empresa->empresa_giro,'empresa_mutual'=>$empresa->empresa_mutual,'empresa_estado'=>$empresa->empresa_estado]);
		return redirect('mantenedores/empresas')->with('notice', 'Empresa modificada con exito!');
	}

	public function eliminar($id){
		$empresa = Empresas::where('empresa_id',$id)->update(['empresa_estado'=>0]);
		return redirect('mantenedores/empresas');
	}

	//pruebas variadas

	public function pdf(){
		$date = date('d-m-Y');
		$invoice = "123";
		 //obtenemos todos los trabajadores del sistema
		$trabajadores = trabajador::get();
		//generamos la vista para el pdf
		view()->share('trabajadores',$trabajadores);
		$pdf = PDF::loadView('adminlte::rrhh.vistas');
  		return $pdf->download('pruebapdf.pdf');
		
	}
	public function vistas(){
		$empresas = Empresas::all();
		$trabajadores = Trabajador::orderby('trabajador_id', 'DESC')->get();
		return view('adminlte::rrhh.vistas')->with('trabajadores',$trabajadores);
	}

	public function autocompletar(Request $request){
		$termino = $request->term;
		$trabajadores = Trabajador::where('nombres', 'like', ''.$termino.'%')->where('estado', '=' ,1)->get();
		return $trabajadores;
	}


}
