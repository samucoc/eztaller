<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Bancos;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BancosController extends Controller
{
    //function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
	public function index(){
		return view('adminlte::mantenedores.bancos');
	}
	//obtenemos todos los bancos para luego agregarlos a la tabla datatable
	public function getbancos(){

		$bancos = Bancos::all();//obtenemos todos los datos de la bd.
		return Datatables::of($bancos)//retornamos los datos a la datatable de la vista banco
		->make(true);
	}
	//funcion que optiene los datos de un nuevo banco para poder agregarlo al sistema
	public function crear(Request $request){
		//mensajes que mostrara el sistema en caso de que no pase una validadion
		$mensajes = array(
			'banco_descripcion.required'=> 'el Campo Descripcion no puede ser nulo',
			'banco_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema'
			);
		//ahora se generan las validaciones para cada campo
		$validator = \Validator::make(
			[
			'banco_descripcion'=> $request->banco_descripcion //le indicamos de donde obtendra el datoa  validar
			],
			[
			'banco_descripcion'=> 'required|unique:bancos|string'//aqui especificamos la regla que se aplicara en la validacion
			],
			$mensajes//agregamos los mensajes que se mostraran
		);
		//si una validacion no pasa, el sistema redirecciona a la vista anterior con los mensajes anteriormente señalados
 		if ($validator->fails()) {
			return redirect('mantenedores/bancos')->with('alert', 'Banco no registrado.')->withErrors($validator);
        }
        //si las validaciones estan ok pasamos a crear un objeto d ela clase banco
		$bancos = new Bancos;//creamos el objeto bancos
		$bancos->banco_descripcion = $request->txtdescripcion;//le asignamos los valores obtenidos por el formulario
		$bancos->save();//guardamos el objeto banco dentro de la bd
		return redirect('mantenedores/bancos')->with('notice', 'Banco registrado con exito!');//redireccionamos nuevamente a la vista bancos, esta vez con un mensaje de exito.
        
	}



	public function editar($id){
		$bancos = Bancos::get()->where('banco_id', '=', $id);
		return view('adminlte::mantenedores.bancoseditar')->with('bancos',$bancos);

	}

	public function Guardar(Request $request){


		$mensajes = array(
			'banco_descripcion.required'=> 'el Campo Descripcion no puede ser nulo',
			'banco_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema'
			);


		$descripcion = Banco::select('banco_descripcion')->where('banco_id','=',$request->txtid)->get();
		foreach ($descripcion as $descrip ) {
			$nombre = $descrip->sector_descripcion;
		}

		if ($nombre == $request->txtdescripcion) {
			$validator = \Validator::make(
		 		
				[
				'banco_descripcion' 	=> $request->txtdescripcion
				],
				[
				
				'banco_descripcion' 	=> 'required|string'
				],
				$mensajes
			);

		}else{
			$validator = \Validator::make(
		 		
				[
				'banco_descripcion' 	=> $request->txtdescripcion
				],
				[
				
				'banco_descripcion' 	=> 'required|unique:bancos|string'
				],
				$mensajes
			);
		}
		

 		if ($validator->fails()) {
			return redirect('mantenedores/bancos')->with('alert', 'Banco no registrado.')->withErrors($validator);
        }
		$bancos = new bancos;
		$bancos->banco_id = $request->txtid;
		$bancos->banco_descripcion = $request->txtdescripcion;
		

		Bancos::where('banco_id',$bancos->banco_id)->update(['banco_descripcion'=>$bancos->banco_descripcion]);
		return redirect('mantenedores/bancos');
	}

	public function eliminar($id){
		$bancos = Bancos::where('banco_id',$id)->delete();
		return redirect('mantenedores/bancos');
	}




}
