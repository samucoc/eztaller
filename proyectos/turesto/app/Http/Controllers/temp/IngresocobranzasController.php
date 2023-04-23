<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Venta;
use App\Clientes;
use App\Abono;
use App\Cuota;
use App\TipoAbono;
use App\Descuentos;
class IngresocobranzasController extends Controller
{	
	//creamos una variable llamada ruta
    private  $ruta = "ingreso_cobranza";

	public function index(){
		$tipoabonos = TipoAbono::all();
		return view('adminlte::cobranza.ingreso_cobranzas')->with('tipoabonos',$tipoabonos);
	}

	public function buscar_folio(Request $request){
		$folio = $request->folio;
		$venta = Venta::with('ventadetalles','sectores','clientes','estadoventas','tipoformaspagos','trabajadores','cuotas','abonos','abonos.cobrador','abonos.supervisor','devoluciones','devoluciones.devoluciondetalles','descuentos')->where('venta_id','=',$folio)->get();
		//validamos la variable $venta para determinar si se obtuvo resultado, de lo contrario devolvera un mensaje error
		if (count($venta) > 0) {
			return \Response::json($venta);
		}else{
			echo $venta=1;
		}
	}

	//funcion para el ingreso de abonos
	public function abono(Request $request){

		//mensajes en caso de errores
		$mensajes = array(
			'abono_monto.required'         => 'El Campo Monto no puede ser nulo.',
			'abono_fecha_pago.required'    => 'El Campo Fecha no puede ser nulo.',
			'abono_fecha_pago.date_format' =>'El formato de la fecha es incorrecto',
			'abono_cobrador.required'      => 'El Campo Cobrador no puede ser nulo.',
			'abono_supervisor.required'    => 'El Campo Supervisor no puede ser nulo.',
			'ta_id.required'               => 'Debe seleccionar el tipo de abono'
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(
			[
			'abono_cobrador'   => $request->txtcobrador,
			'abono_supervisor' => $request->txtsupervisor,
			'abono_monto'      => $request->txtmonto,
			'abono_fecha_pago' => $request->txtfecha,
			'ta_id'			   => $request->txttipoabono
			],
			[
			'abono_cobrador'   => 'required',
			'abono_supervisor' => 'required',
			'abono_monto'      => 'required|numeric',
			'abono_fecha_pago' => 'date_format:"d/m/Y|required',
			'ta_id'			   => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
        }

        if($request->txttipoabono == 0){
        	$errors = ["ta_id"=>"Debe seleccionar el tipo de abono"];
        	return \Response::json($errors,400);
        }
        $correlativo = Abono::max('abono_correlativo');


        $usuario = Auth::user();//obtenemos el usuario que esta ingresando el abono
        $cobrador = explode('-',$request->txtcobrador); //obtenemos el id del cobrador(trabajador)
        $supervisor = explode('-',$request->txtsupervisor); //obtenenos el id del supervisor(trabajador)
        $ventaid = $request->txtventa; //obtenemos el id de la venta
        $totalventa = $request->txttotal; // obtenemos el monto total de la venta
        $cant_cuotas = $request->txtcuotas; //obtenemos la cantidad de cuotas pactadas
        $montocuotafaltante = 0; //seteamos el monto faltante de la cuota en 0
        $montocuotasobrante = 0;
        $totalabonos = 0;
        $fpago = explode('/',$request->txtfecha);

        $abono                   = new Abono;  //nuevo objeto clase abono
        $abono->abono_correlativo = ++$correlativo;
		$abono->abono_monto      = $request->txtmonto;//obtenemos el monto del abono
		$abono->abono_fecha_pago = ($fpago[2].'-'.$fpago[1].'-'.$fpago[0]);//obtenemos la fecha en que se hizo el abono
		$abono->abono_cuota      = 1;//aun no sabemos cual es la cuota que se esta cancelando
		$abono->abono_fecha_venc = 1;//aun no sabemos cual es la fecha de la ultima cuota
		$abono->abono_cobrador   = trim($cobrador[0]);//obtenemos el codigo del trabajador
		$abono->abono_supervisor = trim($supervisor[0]);//obtenemos el codigo del trabajador
		$abono->abono_estado     = 1; //por defecto el abono esta activo
		$abono->ea_id			 = 1; //el estado del abono por defecto es activo = 1
		$abono->ta_id 			 = $request->txttipoabono;
		$abono->venta_id		 = $ventaid; //el id de la venta a la cual se le esta ingresando el abono
		$abono->creado_por       = $usuario->name;//nombre del usuario 
		$abono->modificado_por   = $usuario->name;//nombre del usuario

		//convertimos
		$abono->abono_fecha_pago = date('Y-m-d',strtotime($abono->abono_fecha_pago));
        //buscamos todos los abonos segun la $ventaid
        $abonos = Abono::where('venta_id','=',$ventaid)->get(); //obtenemos los abonos
       	$cuotas = Cuota::where('venta_id','=',$ventaid)->get(); //obtenemos las cuotas
       	$descuentos = Descuentos::where('venta_id','=',$ventaid)->get();//obtenemos los descuentos si es que los hay
        //validamos si existen abonos para el folio
        if(count($abonos) == 0){
        	//como no existen abonos registramos como primer abono
        	$abono->abono_cuota = 1;//como no existen abonos se asume que es la primera cuota
        	$abono->abono_fecha_venc = $cuotas[0]->cuota_fecha_venc; //obtenemos la fecha de vencimiento de la primera cuota
        	//luego de obtener los datos mandamos los datos a la funcion ingresar_abonos() para ingresar el abono
        	//enviaremos 3 variables a la funcion
        	//el objeto abono
        	//la cantidad de cuotas
        	//y el arreglo con todas las cuotas y su respectivo monto, esto ya que no todas pueden ser iguales
        	$resultado = $this->ingreso_abonos($abono,$cant_cuotas,$cuotas,$ventaid);
        	//una vez actualizado la cuota debe
        	//retornamos a la pagina
        	return redirect('cobranza/'. $this->ruta.'');
        }else{
        	//existen abonos
        	foreach ($abonos as $ab ) {
        		//sumamos todos los abonos realizados
        		$totalabonos = $totalabonos + $ab->abono_monto;
        		$ultimacuota = $ab->abono_cuota; //guardamos la ultima cuota que se registro
        	}
        	//verificamos si la ultima cuota tiene faltantes
        	//si no tiene aumentamos en uno la cuota para pasar a la siguiente
        	if ($cuotas[$ultimacuota-1]->cuota_haber ==0) {
        		$ultimacuota++;
        	}
        	//obtenemos el saldo pendiente
        	$saldo = $totalventa - $totalabonos - $descuentos->descuento_monto; //restamos el total de la venta menos el total de abonos
        	//validamos que el abono no sea mayor a el saldo pendiente
        	if($abono->abono_monto > $saldo){
        		//en caso de ser mayor el abono al saldo mandamos un mensaje
        		$error='Abono supera el saldo pendiente';
        		//redireccionamos a ingreso_cobranza.blade.php con el mensaje de error
        		return redirect('cobranza/'. $this->ruta.'')->withErrors($error);
        	}else{
        		
        		$abono->abono_cuota = $ultimacuota;//como no existen abonos se asume que es la primera cuota
        		$abono->abono_fecha_venc = $cuotas[$ultimacuota-1]->cuota_fecha_venc; //obtenemos la fecha de vencimiento de la primera cuota
        		$resultado = $this->ingreso_abonos($abono,$cant_cuotas,$cuotas,$ventaid);
        		return redirect('cobranza/'. $this->ruta.'');
        	}

        }//fin if count($abonos) == 0
	}//fin funcion abono

	public function ingreso_abonos($abono,$cant_cuotas,$cuotas,$ventaid){
		//guardamos el numero de la cuota
		//para poder buscar los datos en el arreglo
		$cuotaposicion = $abono->abono_cuota - 1;
		$sobrante=0;
		$faltante=0;
		//verificamos que la cuota_haber sea distinto de 0
		//esto quiere decir que hubo un faltante en la cuota anterior
		//para cumplir con el monto de la cuota
		if ($cuotas[$cuotaposicion]->cuota_haber > 0 ) {
			$faltante = $cuotas[$cuotaposicion]->cuota_haber; //obtenemos cuanto es lo que falta para completar la cuota
			if ($faltante == $abono->abono_monto) {
				//guardamos el objeto de la clase abono
				$abono->save();
				//actualizamos el haber de las cuotas
					Cuota::where([
	        			['venta_id','=',$ventaid],
	        			['cuota_num_cuota','=',$abono->abono_cuota]
	        			])->update(['cuota_haber'=>0]);
					$faltante =0;
					exit();
			}else{
				if($faltante > $abono->abono_monto){
					$faltante = $cuotas[$cuotaposicion]->cuota_haber - $abono->abono_monto;//restando del abono el valor de la cuota
					
					//guardamos el objeto de la clase abono
					$abono->save();
					//actualizamos el haber de las cuotas
					Cuota::where([
	        			['venta_id','=',$ventaid],
	        			['cuota_num_cuota','=',$abono->abono_cuota]
	        			])->update(['cuota_haber'=>$faltante]);
					$faltante =0;
					exit();
				}else{
					$sobrante = $abono->abono_monto - $faltante;//restando del abono el valor de la cuota
					$abono->abono_monto = $faltante;
					//clonamos el objeto abono antes de ingresarlo
					$abono1 = clone $abono;
					//guardamos el objeto de la clase abono
					$abono->save();
					//actualizamos el haber de las cuotas
					Cuota::where([
	        			['venta_id','=',$ventaid],
	        			['cuota_num_cuota','=',$abono->abono_cuota]
	        			])->update(['cuota_haber'=>0]);
					//una vez guardado el abono se le asigna nuevamente el monto
					// pero esta vez con el sobrante
					$abono1->abono_monto =$sobrante;
					$abono1->abono_cuota = $abono1->abono_cuota + 1;
					$abono1->abono_fecha_venc = $cuotas[$cuotaposicion+1]->cuota_fecha_venc;
					$faltante =0;
					//volvemos a llamar a la funcion con los datos nuevos
					$this->ingreso_abonos($abono1,$cant_cuotas,$cuotas,$ventaid);
				}
			}
		}//fin if >0


		if($abono->abono_monto == $cuotas[$cuotaposicion]->cuota_debe){
			//guardamos el abono
			$abono->save();
			//actualizamos la cuota haber en 0
			Cuota::where([
        			['venta_id','=',$ventaid],
        			['cuota_num_cuota','=',$abono->abono_cuota]
        			])->update(['cuota_haber'=>0]);
			//seteamos nuevamente el faltante en 0
			$faltante =0;
			//nos salimos de la funcion
			exit();
		}else{
			if($abono->abono_monto > $cuotas[$cuotaposicion]->cuota_debe){
				$sobrante = $abono->abono_monto - $cuotas[$cuotaposicion]->cuota_debe;//restando del abono el valor de la cuota
				$abono->abono_monto = $cuotas[$cuotaposicion]->cuota_debe;
				//clonamos el objeto abono antes de ingresarlo
				$abono1 = clone $abono;
				//guardamos el objeto de la clase abono
				$abono->save();
				//actualizamos el haber de las cuotas
				Cuota::where([
        			['venta_id','=',$ventaid],
        			['cuota_num_cuota','=',$abono->abono_cuota]
        			])->update(['cuota_haber'=>0]);
				//una vez guardado el abono se le asigna nuevamente el monto
				// pero esta vez con el sobrante
				$abono1->abono_monto =$sobrante; 
				$abono1->abono_cuota = $abono1->abono_cuota +1; //aumentamos en 1 la cuota
				$abono1->abono_fecha_venc = $cuotas[$cuotaposicion+1]->cuota_fecha_venc;
				//volvemos a llamar a la funcion con los datos nuevos
				$faltante =0;
				$this->ingreso_abonos($abono1,$cant_cuotas,$cuotas,$ventaid);

			}else{
				$faltante = $cuotas[$cuotaposicion]->cuota_debe - $abono->abono_monto;
				//guardamos el abono
				$abono->save();
				
				//actualizamos el haber de las cuotas
				Cuota::where([
        			['venta_id','=',$ventaid],
        			['cuota_num_cuota','=',$abono->abono_cuota]
        			])->update(['cuota_haber'=>$faltante]);
				//seteamos la variable faltante en 0
				$faltante =0;
				//nos salimos de la funcion
				exit();
			}
		}//fin if 
	}//fin funcion ingreso_abonos


	public function eliminarAbono(Request $request){
		//obtenemos los datos
		$idabono = $request->abono;//id abono
		$ventaid = $request->venta;//id venta
		$correlativo = $request->correlativo;
		$abonos = Abono::where('abono_correlativo','=',$correlativo)->get();
		$cuotas = Cuota::where('venta_id','=',$ventaid)->get();
		$cantabonos = count($abonos);
		$rest = $this->actualizarCuotas($abonos,$cuotas,$ventaid,--$cantabonos);
		$cantabonos = count($abonos);

		try {
			$abono = Abono::where('abono_correlativo','=',$correlativo);
			$abono->delete();
			return 1;
			
		} catch (Exception $e) {
			 \Log::info('Error: '.$e);
            return \Response::json(['created' => false], 500);
		}
		
	}

	public function actualizarCuotas($abono,$cuotas,$ventaid,$cantabonos){
		$haber = $cuotas[$abono[$cantabonos]->abono_cuota-1]->cuota_haber;
		$numcuota = $abono[$cantabonos]->abono_cuota-1;
		//deshacemos la modificicacion que hizo el abono anterior
		//return 1 para ok
		//return 2 para error
		if ( $haber == 0 ) {
			//la cuota fue cancelada por ende se le debe agregar el monto del abono a la cuota haber
			if($abono[$cantabonos]->abono_monto == $cuotas[$numcuota]->cuota_debe){
				//calculamos el sobrante
				$haber = $abono[$cantabonos]->abono_monto - $cuotas[$numcuota]->cuota_debe;//restamos el abono menos el debe, esto debe dar cero
				Cuota::where([
	    			['venta_id','=',$ventaid],
	    			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
	    			])->update(['cuota_haber'=>0]);//cero

					if($cantabonos > 0 ){
						$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);
					}else{
						return;
					}

			}else{
				if ($abono[$cantabonos]->abono_monto > $cuotas[$numcuota]->cuota_debe) {
					$sobrante = $abono[$cantabonos]->abono_monto - $cuotas[$numcuota]->cuota_debe;//obtenemos el sobrante del abono
					//actualizamos el haber de la cuota
					Cuota::where([
	    			['venta_id','=',$ventaid],
	    			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
	    			])->update(['cuota_haber'=>0]);//cero
					$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);

				} else {
					$faltante = $abono[$cantabonos]->abono_monto;
					Cuota::where([
	    			['venta_id','=',$ventaid],
	    			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
	    			])->update(['cuota_haber'=>$faltante]);//cero

					if($cantabonos > 0 ){
						$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);
					}else{
						return;
					}
				}
				
			}

		}else{
			//el haber es mayor a --$cantabonos por ende aun queda un faltante por pagar
			
			if (($haber + $abono[$cantabonos]->abono_monto) == $cuotas[$numcuota]->cuota_debe) {
				//la suma da como resultado el mismo valor que la cuota por ende pasa a estar en 0 como sin pagar
				
				Cuota::where([
    			['venta_id','=',$ventaid],
    			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
    			])->update(['cuota_haber'=>0]);//cero

				if($cantabonos > 0 ){
					$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);
				}else{
					return;
				}
			} else {
				if(($haber + $abono[$cantabonos]->abono_monto) > $cuotas[$numcuota]->cuota_debe){
					
				$sobrante = ($haber + $abono[$cantabonos]->abono_monto) - $cuotas[$numcuota]->cuota_debe;
				Cuota::where([
        			['venta_id','=',$ventaid],
        			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
        			])->update(['cuota_haber'=>0]);//cero
					$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);
				}else{
					$faltante = $haber + $abono[$cantabonos]->abono_monto;
					Cuota::where([
	    			['venta_id','=',$ventaid],
	    			['cuota_num_cuota','=',$abono[$cantabonos]->abono_cuota]
	    			])->update(['cuota_haber'=>$faltante]);

					if($cantabonos > 0 ){
						$this->actualizarCuotas($abono,$cuotas,$ventaid,--$cantabonos);
					}else{
						
						return;
					}
				}
			}
		}

	}



}//fin 
