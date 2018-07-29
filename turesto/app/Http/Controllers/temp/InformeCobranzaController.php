<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\QueryException;
use App\Abono;
use App\Deposito;
class InformeCobranzaController extends Controller
{
    public function index(){
		return view('adminlte::cobranza.informes.informe_cobranza');
	}

	public function buscarcobranzas(Request $request){
		//verificamos si los datos vienen vacios
		if ($request->txtsector == '') {
			$errors[] = "Debe ingresar un sector";
		}
		if ($request->txtcobrador == '') {
			$errors[] = "Debe ingresar un cobrador";
		}
		if($request->rango_meses == 0){
			$errors[] = "Debe seleccionar un mes para poder realizar la busqueda";
		}
		//verificamos si existen errores
		if(isset($errors)){
			//retornamos los errores
			return \Response::json($errors,400);
		}

		$cobrador = explode('-',$request->txtcobrador);//cobrador
		$sector = explode('-',$request->txtsector);//sector

		$anio = date('Y');// obtenemos el año actual
		$diaini = '25';//seteamos el dia de inicio
		$diafin = '24';//seteamos el dia de fin
		try{
			
				//verificamos si el rango seleccioado fue personalizado o no
			if ($request->rango_meses == 13) {
				//es personalizado por ende se capturan las fechas de inicio y fin
				$fdesde = explode('/',$request->fdesde);
				$fhasta = explode('/',$request->fhasta);
				
				//obtenemos la fecha en formato YYYY-mm-dd
				$fecha_ini = $fdesde[2].'-'.$fdesde[1].'-'.$fdesde[0];
				$fecha_fin = $fhasta[2].'-'.$fhasta[1].'-'.$fhasta[0];
				$abonos = Abono::with('ventas','supervisor','cobrador','ventas.clientes','trabajador.depositos')->whereBetween('abono_fecha_pago',[$fecha_ini,$fecha_fin])->where('abono_cobrador','=',$cobrador[0])->get();


				$abonos[] = ['fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin]; 
				return $abonos;

			}else{
				//se selecciono un mes
				$mes = $request->rango_meses;

				//verificamos si es enero
				if($mes == 1){
					//enero
					//la fecha de inicio es diciembre del año pasado
					$fecha_ini = ($anio -1 ).'-'.($mes.'2').'-'.$diaini;	
				}else{
					$fecha_ini = $anio.'-'.($mes - 1).'-'.$diaini;
				}

				//fecha de fin
				$fecha_fin = $anio.'-'.$mes.'-'.$diafin;

				//realizamos la consulta 
				$abonos = Abono::with('ventas','supervisor','cobrador','ventas.clientes','trabajador.depositos')->whereBetween('abono_fecha_pago',[$fecha_ini,$fecha_fin])->where('abono_cobrador','=',$cobrador[0])->get();

				//$depositos = Deposito::whereBetween('deposito_fecha',[$fecha_ini,$fecha_fin])->where('deposito_sector','=',$sector)->where('trabajador_id','=',$cobrador)->get();
				//agregamos variables a nuestro objeto abonos
				$abonos[] = ['fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin]; 

				return $abonos;
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

	
}
