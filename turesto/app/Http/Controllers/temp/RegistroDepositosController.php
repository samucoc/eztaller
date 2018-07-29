<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Yajra\Datatables\Datatables;
use App\Bancos;
use App\Deposito;
use App\CuentaCorriente;
class RegistroDepositosController extends Controller
{
	//creamos una variable llamada ruta
    private  $ruta = "registro_depositos";
    public function index(){
    	//obtenemos los bancos para listarlos en el formulario de registro de depositos
    	$bancos = Bancos::all();
		return view('adminlte::cobranza.registro_depositos')->with('bancos',$bancos);
	}
	public function listarDepositos(){
    	//obtenemos los depositos que se han ingresado con fecha de hoy
    	//y que seran estos los que se pueden modificar
    	$hoy = (date('Y').'-'.(date('m')).'-'.date('d'));
    	$depositos = Deposito::with('sectores')->with('bancos')->with('trabajadores')->with('ctacte')->where('created_at','like',$hoy.'%')->get();
    	return Datatables::of($depositos)->make(true);
	}

	public function registrarDepositos(Request $request){
		//mensajes en caso de errores
		$mensajes = array(
			'trabajador_id.required'                => 'El Campo Cobrador no puede ser nulo.',
			'deposito_sector.required'              => 'El Campo Sector no puede ser nulo.',
			'deposito_banco.required'               => 'Debe seleccionar un Banco.',
			'deposito_cta_cte.required'             => 'Debe seleccionar una Cuenta Corriente.',
			'deposito_monto.required'               =>'El Campo Monto no puede ser nulo',
			'deposito_monto.required|max'           =>'El Campo Monto no puede ser superior a 99.999.999',
			'deposito_fecha.required'               =>'El Campo Fecha Cobranza no puede ser nulo',
			'deposito_num_trans.required'           =>'El Campo N° Transaccion no puede ser nulo',
			'deposito_num_trans.required|alpha_num' =>'El Campo N° Transaccion solo puede contener numeros y letras',
			'deposito_fecha_deposito.required'      =>'El Campo Fecha Deposito no puede ser nulo'
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(

			[
				'trabajador_id'           => $request->txtcobrador,
				'deposito_sector'         => $request->txtsector,
				'deposito_banco'          => $request->txtbanco,
				'deposito_cta_cte'        => $request->txtctacte,
				'deposito_monto'          => $request->txtmonto[0],
				'deposito_fecha'          => $request->txtfechacobranza[0],
				'deposito_num_trans'      => $request->txtnumtransaccion[0],
				'deposito_fecha_deposito' => $request->txtfechadeposito[0]
			],
			[
				'trabajador_id'           => 'required',
				'deposito_sector'         => 'required',
				'deposito_banco'          => 'required',
				'deposito_cta_cte'        => 'required',
				'deposito_monto'          => 'required|numeric|max:99999999',
				'deposito_fecha'          => 'required|date',
				'deposito_num_trans'      => 'required|alpha_num',
				'deposito_fecha_deposito' => 'required|date'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }
		//obtenemos el lardo de la variable txtfechacobranza
		//para determinar si se estan registrando mas de un deposito
		
		$largo = count($request->txtfechacobranza);
		//obtenemos el nombre del usuario que registrara el deposito en el sistema
		$usuario = Auth::user();
		//obtenemos el array con el cobrador
		$cobrador = explode('-',$request->txtcobrador);
		//obtenemos el array con el sector
		$sector = explode('-',$request->txtsector);
		
		for ($i=0; $i < $largo ; $i++){ 
			$fcobranza = explode('/',$request->txtfechacobranza[$i]);
			$fdeposito = explode('/',$request->txtfechadeposito[$i]);
			if ($i == 0) {
				//ahora creamos nuestro objeto de la clase deposito
				$deposito = new Deposito;
				$deposito->deposito_monto = $request->txtmonto[$i]; 
				$deposito->deposito_fecha = ($fcobranza[2].'-'.$fcobranza[1].'-'.$fcobranza[0]);
				$deposito->deposito_num_trans = $request->txtnumtransaccion[$i];
				$deposito->deposito_fecha_deposito = ($fdeposito[2].'-'.$fdeposito[1].'-'.$fdeposito[0]);
				$deposito->deposito_sector = trim($sector[0]);
				$deposito->deposito_banco = $request->txtbanco;
				$deposito->deposito_cta_cte = $request->txtctacte;
				$deposito->trabajador_id = trim($cobrador[0]);
				$deposito->creado_por = $usuario->name;			
				//guardamos el deposito
				$resultado = $deposito->save();
				unset($deposito);
			}else{
				$deposito = new Deposito;
				$deposito->deposito_monto = $request->txtmonto[$i];
				$deposito->deposito_fecha = ($fcobranza[2].'-'.$fcobranza[1].'-'.$fcobranza[0]);
				$deposito->deposito_num_trans = $request->txtnumtransaccion[$i];
				$deposito->deposito_fecha_deposito = ($fdeposito[2].'-'.$fdeposito[1].'-'.$fdeposito[0]);
				$deposito->deposito_sector = trim($sector[0]);
				$deposito->deposito_banco = $request->txtbanco;
				$deposito->deposito_cta_cte = $request->txtctacte;
				$deposito->trabajador_id = trim($cobrador[0]);
				$deposito->creado_por = $usuario->name;
				//clonamos el objeto
				//${"deposito".++$i } = Clone $deposito;
				//guardamos el deposito
				$resultado = $deposito->save();
				unset($deposito);
			}

		}//fin for

	}//fin function registrardepositos


	public function editardepositos($id){
		$bancos = Bancos::all();
		$ctacte = CuentaCorriente::all();
		$depositos = Deposito::with('sectores')->with('bancos')->with('trabajadores')->with('ctacte')->where('deposito_id','=',$id)->get();
		return view('adminlte::cobranza.editar_depositos')->with('depositos',$depositos)->with('bancos',$bancos)->with('ctacte',$ctacte);
	}


	public function cuentascorrientes(Request $request){
		$id = $request->banco;
        $ctacte = CuentaCorriente::where('banco_id','=', $id)->get();
        return response()->json($ctacte);
	}


	public function modificardeposito(Request $request){
		//hay que validar que los datos no esten nulos
		//mensajes en caso de errores
		$mensajes = array(
			'trabajador_id.required'                => 'El Campo Cobrador no puede ser nulo.',
			'deposito_sector.required'              => 'El Campo Sector no puede ser nulo.',
			'deposito_banco.required'               => 'Debe seleccionar un Banco.',
			'deposito_cta_cte.required'             => 'Debe seleccionar una Cuenta Corriente.',
			'deposito_monto.required'               =>'El Campo Monto no puede ser nulo',
			'deposito_monto.required|max'           =>'El Campo Monto no puede ser superior a 99.999.999',
			'deposito_fecha.required'               =>'El Campo Fecha Cobranza no puede ser nulo',
			'deposito_num_trans.required'           =>'El Campo N° Transaccion no puede ser nulo',
			'deposito_num_trans.required|alpha_num' =>'El Campo N° Transaccion solo puede contener numeros y letras',
			'deposito_fecha_deposito.required'      =>'El Campo Fecha Deposito no puede ser nulo'
			);
		//validamos los datos que sean ingresados y cuales son los requeridos para el ingreso en el sistema
		$validator = \Validator::make(

			[
				'trabajador_id'           => $request->txtcobrador,
				'deposito_sector'         => $request->txtsector,
				'deposito_banco'          => $request->txtbanco,
				'deposito_cta_cte'        => $request->txtctacte,
				'deposito_monto'          => $request->txtmonto,
				'deposito_fecha'          => $request->txtfechacobranza,
				'deposito_num_trans'      => $request->txtnumtransaccion,
				'deposito_fecha_deposito' => $request->txtfechadeposito
			],
			[
				'trabajador_id'           => 'required',
				'deposito_sector'         => 'required',
				'deposito_banco'          => 'required',
				'deposito_cta_cte'        => 'required',
				'deposito_monto'          => 'required|numeric|max:99999999',
				'deposito_fecha'          => 'required',
				'deposito_num_trans'      => 'required|alpha_num',
				'deposito_fecha_deposito' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
 			$errors = $validator->getMessageBag()->toArray();
 			return \Response::json($errors,400);
			//return redirect('cobranza/'. $this->ruta.'')->withErrors($validator);
        }
        $iddeposito = $request->txtndeposito;
        //obtenemos el nombre del usuario que registrara el deposito en el sistema
		$usuario = Auth::user();
		//obtenemos el array con el cobrador
		$cobrador = explode('-',$request->txtcobrador);
		//obtenemos el array con el sector
		$sector = explode('-',$request->txtsector);
		$fcobranza = explode('/',$request->txtfechacobranza);
		$fdeposito = explode('/',$request->txtfechadeposito);
		//ahora traemos el objeto de la clase deposito alojado en la base de datos
		$deposito = Deposito::findOrFail($iddeposito);
		
		$deposito->deposito_monto = $request->txtmonto; 
		$deposito->deposito_fecha = ($fcobranza[2].'-'.$fcobranza[1].'-'.$fcobranza[0]);
		$deposito->deposito_num_trans = $request->txtnumtransaccion;
		$deposito->deposito_fecha_deposito = ($fdeposito[2].'-'.$fdeposito[1].'-'.$fdeposito[0]);
		$deposito->deposito_sector = trim($sector[0]);
		$deposito->deposito_banco = $request->txtbanco;
		$deposito->deposito_cta_cte = $request->txtctacte;
		$deposito->trabajador_id = trim($cobrador[0]);
		$deposito->creado_por = $usuario->name;			
		//guardamos el deposito
		$resultado = $deposito->save();
		
		if ($resultado == 1) {
			return 1;
		}else{
			return 2;
		}

	}

}// fin clase RegistroDepositosController
