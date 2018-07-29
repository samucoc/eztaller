<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Venta;
use App\Clientes;
use App\Cupos;
class RevisionKardexController extends Controller
{
    public function index(){
    	$cupos = Cupos::all();
    	return view('adminlte::cobranza.revision_kardex')->with('cupos',$cupos);
    }
    
    public function grabarrevision(Request $request){
    	$mensajes = array(
			'venta_fecha_revision.required' => 'El Campo Fecha del descuento no puede ser nulo.',	
			'venta_fecha_revision.date_format' =>'El formato de la fecha es incorrecto',		
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
			'venta_fecha_revision' => $request->txtfecharevision
			],
			[
			'venta_fecha_revision' => 'date_format:"d/m/Y|required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }
        $usuario = Auth::user();
        $ventaid = $request->txtventa;//obtenemos el id de la venta
    	$fecha = explode('/',$request->txtfecharevision);//obtenemos la fecha y la converrtimos a array
    	$venta = Venta::find($ventaid);//buscamos la venta en el sistema a travez de el id
    	$venta->venta_fecha_revision = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];//le asignamos la nueva fecha de revision formateada
    	$venta->modificado_por = $usuario->name;

    	try{
		    $venta->save();//guardamos nuevamente la venta con la nueva fecha de revision
		}catch(\Illuminate\Database\QueryException $ex) {
		    // something went wrong with the transaction, rollback 
		    $errors = $ex;
 			return \Response::json($errors,400);
		}catch(\Exception $ex) {
		     $errors = $ex;
 			return \Response::json($errors,400);
		}

    }

    public function actualizarcupo(Request $request){
    	//mensajes en caso de errores
		$mensajes = array(
			'cliente_linea_credito.required' => 'El Campo Cupo no puede ser nulo.',
			'cliente_fono.required' => 'El Campo Telefono no puede ser nulo.'
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
				'cliente_linea_credito' => $request->cupo,
				'cliente_fono'			=> $request->telefono,
			],
			[
				'cliente_linea_credito' => 'required',
				'cliente_fono'			=> 'required'
			],
			$mensajes
		);
 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }


        $usuario = Auth::user();
        $cliente = Clientes::find($request->cliente);
        $cliente->cliente_linea_credito = $request->cupo;
        $cliente->cliente_fono = $request->telefono;
        $cliente->cliente_bloqueado = $request->bloqueado;

        try{
		    $cliente->save();//guardamos nuevamente la venta con la nueva fecha de revision
		}catch(\Illuminate\Database\QueryException $ex) {
		    // something went wrong with the transaction, rollback 
		    $errors = $ex;
 			return \Response::json($errors,400);
		}catch(\Exception $ex) {
		     $errors = $ex;
 			return \Response::json($errors,400);
		}

    }
}
