<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use App\Descuentos;
use App\Venta;
use App\Abono;


class AplicarDescuentosController extends Controller
{
    public function index(){
    	return view('adminlte::cobranza.aplicar_descuentos');
    }

    public function guardar(Request $request){
    	//mensajes en caso de errores
		$mensajes = array(
			'descuento_fecha.required' => 'El Campo Fecha del descuento no puede ser nulo.',
			'descuento_monto.required' => 'El Campo Monto no puede ser nulo.'			
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
				'descuento_fecha' => $request->txtfechadescuento,
				'descuento_monto' => $request->txtmontodescuento,
			],
			[
				'descuento_fecha' => 'required',
				'descuento_monto' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }

        $usuario = Auth::user();//asignamos el user
        $fecha = explode('/',$request->txtfechadescuento);//fecha de ingreso del deposito
        $hoy = date('Y').'-'.(date('m')-1).'-'.date('d');//obtenemos la fecha de hoy

        $descuento = new Descuentos;
        $descuento->descuento_fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
        $descuento->descuento_monto = $request->txtmontodescuento;
        $descuento->descuento_autorizado = 1;//autorizado 1 = SI
        $descuento->descuento_fecha_autorizado = hoy;//con fecha de hoy
        $descuento->venta_id = $request->txtventa;
        $descuento->sector_id = $request->txtsector;
    	$descuento->creado_por = $usuario->name;
		$descuento->modificado_por = $usuario->name;
    	
    	try{
		    $descuento->save();
		}catch(\Illuminate\Database\QueryException $ex) {
		    // something went wrong with the transaction, rollback 
		    $errors = $ex;
 			return \Response::json($errors,400);
		}catch(\Exception $ex) {
		     $errors = $ex;
 			return \Response::json($errors,400);
		}
    }

    public function listarDescuentos(){
    	$hoy = (date('Y').'-'.(date('m')).'-'.date('d'));
    	$descuentos = Descuentos::where('descuento_fecha','=',$hoy)->get();
    	return Datatables::of($descuentos)->make(true);
    }

    public function modificardescuento(Request $request){
    	//mensajes en caso de errores
		$mensajes = array(
			'descuento_monto.required' => 'El Campo Monto no puede ser nulo.'			
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
				'descuento_monto' => $request->txtnuevomonto,
			],
			[
				'descuento_monto' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }

        $descuentoid = $request->txtdescuento;
        $descuento = Descuentos::find($descuentoid);
        $descuento->descuento_monto = $request->txtnuevomonto;
        $descuento->save();
        return 1;
    }
    public function poraprobar(Request $request){
    	//mensajes en caso de errores
		$mensajes = array(
			'descuento_fecha.required' => 'El Campo Fecha del descuento no puede ser nulo.',
			'descuento_monto.required' => 'El Campo Monto no puede ser nulo.'			
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
				'descuento_fecha' => $request->txtfechadescuento,
				'descuento_monto' => $request->txtmontodescuento,
			],
			[
				'descuento_fecha' => 'required',
				'descuento_monto' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }

        $usuario = Auth::user();//asignamos el user
        $fecha = explode('/',$request->txtfechadescuento);//fecha de ingreso del deposito

        $descuento = new Descuentos;
        $descuento->descuento_fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
        $descuento->descuento_monto = $request->txtmontodescuento;
        $descuento->venta_id = $request->txtventa;
        $descuento->sector_id = $request->txtsector;
    	$descuento->creado_por = $usuario->name;
		$descuento->modificado_por = $usuario->name;
    	
    	try{
		    $descuento->save();
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
