<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\QueryException;
use App\Descuentos;
use App\Venta;
class AprobacionesController extends Controller
{
    public function index(){
    	return view('adminlte::cobranza.aprobar_descuentos');
    }
    public function buscardescuentos(Request $request){
    	
    	//mensajes en caso de errores
    	$mensajes = array(
			'descuento_fecha.required'    => 'El Campo Fecha del descuento no puede ser nulo.',
			'descuento_fecha.date_format' => 'El Formato de la fecha de descuento no es correcto'	
    		);
    	//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
    	$validator = \Validator::make(
    		[
    		'descuento_fecha' => $request->txtfdesde
    		],
    		[
    		'descuento_fecha' => 'date_format:"d/m/Y|required'
    		],
    		$mensajes
    	);
    	
    		if ($validator->fails()) {
    			$errors = $validator->getMessageBag()->toArray();
    			return \Response::json($errors,400);
    		//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
    	}



        if(is_null($request->txtfdesde) || is_null($request->txtfhasta) ){
        	$errors = "Debe Ingresar un pediodo de fecha para poder realizar la busqueda, Intente Nuevamente";
        	return \Response::json($errors,500);
        }

        $desde = explode('/',$request->txtfdesde);
        $hasta = explode('/',$request->txtfhasta);
        $sector = $request->txtsector;

        $fdesde = $desde[2].'-'.$desde[1].'-'.$desde[0];
        $fhasta = $hasta[2].'-'.$hasta[1].'-'.$hasta[0];

        try{
        	if(is_null($sector)){
	        	$descuentos = Descuentos::with('ventas','ventas.trabajadores','ventas.clientes')->where('descuento_autorizado','=',null)->whereBetween('descuento_fecha',[$fdesde, $fhasta])->get();
	        	return $descuentos;
        	}else{
        		$descuentos = Descuentos::where('descuento_autorizado','=',null)->where('sector_id','=',$sector)->whereBetween('descuento_fecha',[$fdesde, $fhasta])->get();
	        	return $descuentos;
        	}
        	
        }catch(\Illuminate\Database\QueryException $ex) {
            // something went wrong with the transaction, rollback 
            $errors = $ex;
        	return \Response::json($errors,400);
        }catch(\Exception $ex) {
        	$errors = $ex;
         	return \Response::json($errors,400);
        }
       
    }

    public function aprobardescuentos(Request $request){
    	$largo = count($request->seleccion);
    	$usuario = Auth::user();//obtenemos el usuario que esta utilizando la aplicacion
    	$fecha = date('Y').'-'.(date('m')-1).'-'.date('d');//obtenemos la fecha de hoy
		if($largo == 0){
			$errors = ["seleccion"=>"No ha seleccionado ningun descuento"];
    		return \Response::json($errors,400);
		}

    	try{
            //actualizamos el registro del descuento con la autorizacion y fecha de esta
    		$descuentos = Descuentos::whereIn('descuento_id',[$request->seleccion])->update(['descuento_autorizado'=>1,'descuento_fecha_autorizado'=>$fecha,'modificado_por'=>$usuario->name]);
            //ahora actualizamos el estado de la venta dejandola finalizada
            //ya que el descuento se aplica cuando queda un monto minimo en el folio
            for ($i=0; $i < $largo ; $i++) { 
                $descuento = Descuentos::find($request->seleccion[$i]);//buscamos el descuento por el id para obtener el id de la venta asociada
                $venta = Venta::find($descuento->venta_id);//buscamos la venta con el id asociado al descuento que se aprobo
                $venta->ev_id = 2;//asignamos un nuevo estado, 2 
                $venta->save();//actualizamos el estado de la venta
                unset($descuento,$venta);
            }
    	}catch(\Illuminate\Database\QueryException $ex) {
    	    // something went wrong with the transaction, rollback 
    	    $errors = $ex;
    		return \Response::json($errors,400);
    	}catch(\Exception $ex) {
    		$errors = $ex;
    	 	return \Response::json($errors,400);
    	}
    }

    public function rechazardescuentos(Request $request){
    	$largo = count($request->seleccion);
    	$usuario = Auth::user();//obtenemos el usuario que esta utilizando la aplicacion
    	$fecha = date('Y').'-'.(date('m')-1).'-'.date('d');//obtenemos la fecha de hoy
		if($largo == 0){
			$errors = ["seleccion"=>"No ha seleccionado ningun descuento"];
    		return \Response::json($errors,400);
		}
    	try{
    		$descuentos = Descuentos::whereIn('descuento_id',[$request->seleccion])->update(['descuento_autorizado'=>0,'descuento_fecha_autorizado'=>$fecha,'modificado_por'=>$usuario->name]);
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
