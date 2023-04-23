<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Trabajadores;
use App\TrabajadoresTienenLaboral;
use App\TrabajadoresTienenPrevision;
use App\Sexo;//
use App\Comuna;//
use App\TipoPerfil;//
use App\Areas;//
use App\Empresas;//
use App\EstadoEmpleado;//
use App\Bancos;//
use App\TiposCuentas;//
use App\Afp;//
use App\Ips;//
use App\Salud;//
use App\IntsAhorroVol;//
use Illuminate\Support\Facades\Auth;

class TrabajadoresController extends Controller
{	
	private  $ruta = "fichaglobal";
	private  $editar = "fichaglobaleditar";

	public function index(){
		//
		$sexo = Sexo::all();
		$comuna = Comuna::all();
		$tipo_perfil = TipoPerfil::all();
		$area = Areas::all();
		$empresa = Empresas::all();
		$estado_empleado = EstadoEmpleado::all();
		$tipo_cuenta = TiposCuentas::all();
		$banco = Bancos::all();
		$afp = Afp::all();
		$ips = Ips::all();
		$salud = Salud::all();
		$ints_ahorro_vol = IntsAhorroVol::all();
		
		return view('adminlte::fichas.'. $this->ruta.'')
			->with('sexo',$sexo)
			->with('comuna',$comuna)
			->with('tipo_perfil',$tipo_perfil)
			->with('area',$area)
			->with('empresa',$empresa)
			->with('estado_empleado',$estado_empleado)
			->with('tipo_cuenta',$tipo_cuenta)
			->with('banco',$banco)
			->with('afp',$afp)
			->with('ips',$ips)
			->with('salud',$salud)
			->with('ints_ahorro_vol',$ints_ahorro_vol);
	}

	public function getTrabajadores(){
		$trabajador = Trabajadores::all();//obtenemos todos los datos de la bd.
		return Datatables::of($trabajador)
		->make(true);
	}

	public function crear(Request $request){
		
		$trabajador = new Trabajadores;
		$user = Auth::user();
			
		//ingreso trabajador
		$trabajador->trabajador_nombres = $request->trabajador_nombres;
		$trabajador->trabajador_ap = $request->trabajador_ap;
		$trabajador->trabajador_am = $request->trabajador_am;
		$trabajador->trabajador_rut = $request->trabajador_rut;
		$trabajador->trabajador_sexo = $request->trabajador_sexo;
		$trabajador->trabajador_direccion = $request->trabajador_direccion;
		$trabajador->trabajador_celular = $request->trabajador_celular;
		$trabajador->trabajador_fecha_nace = $request->trabajador_estado;
		$trabajador->comuna_id = $request->comuna_id; 	//comuna
		$trabajador->tp_id = $request->tp_id; 			//tipo perfil
		$trabajador->creado_por = $user->name;
		$trabajador->save();

		$trabajador_id= $trabajador->trabajador_id;

		//ingreso TrabajadoresTienenLaboral
		$ttl = new TrabajadoresTienenLaboral;
		/*
		 `rut_trab`, `cargo`, `area`, `empresa`, `fecha_ingreso`, `fecha_contrato`, `cant_vacaciones_prog`, `trabajador_sexo`, `causa_finiquito`, `estado_empleado`, `fecha_calculo_vacaciones`, `asignacion_materiales`, `tipo_pago_remuneraciones`, `nro_cuenta`, `tipo_cuenta`, `banco`, `celular`, `auto`, `moto`, `asig_caja`, `monto_asig_caja`, `monto_asig_locomocion`, `monto_asig_fxr`, `anticipo`, `gratificacion`, `indefinido`, `mayor_once`, `creado_por`, `modificado_por`, `created_at`, `updated_at` FROM `trabajadores_tiene_laboral`
		 */
		$ttl->rut_trab = $trabajador_id;
		$ttl->cargo = $request->ttl_cargo;
		$ttl->area = $request->ttl_area;
		$ttl->empresa = $request->ttl_empresa;
		$ttl->fecha_ingreso = $request->ttl_fecha_ingreso;
		$ttl->fecha_contrato = $request->ttl_fecha_contrato;
		$ttl->cant_vacaciones_prog = $request->ttl_cant_vacaciones_prog;
		$ttl->fecha_finiquito = $request->ttl_fecha_finiquito;
		$ttl->causa_finiquito = $request->ttl_causa_finiquito;
		$ttl->estado_empleado = $request->ttl_estado_empleado;
		$ttl->asignacion_materiales = $request->ttl_asignacion_materiales;
		$ttl->tipo_pago_remuneraciones = $request->ttl_tipo_pago_remuneraciones;
		$ttl->nro_cuenta = $request->ttl_nro_cuenta;
		$ttl->tipo_cuenta = $request->ttl_tipo_cuenta;
		$ttl->banco = $request->ttl_banco;
		$ttl->celular = $request->ttl_celular;
		$ttl->auto = $request->ttl_auto;
		$ttl->moto = $request->ttl_moto;
		$ttl->asig_caja = $request->ttl_asig_caja;
		$ttl->monto_asig_caja = $request->ttl_monto_asig_caja;
		$ttl->monto_asig_locomocion = $request->ttl_monto_asig_locomocion;
		$ttl->monto_asig_fxr = $request->ttl_monto_asig_fxr;
		$ttl->anticipo = $request->ttl_anticipo;
		$ttl->gratificacion = $request->ttl_gratificacion;
		$ttl->indefinido = $request->ttl_indefinido;
		$ttl->mayor_once = $request->ttl_mayor_once;
		$ttl->creado_por = $user->name;
		$ttl->save();
		

		//ingreso TrabajadoresTienenLaboral
		$ttp = new TrabajadoresTienenPrevision;
		/*
		 `rut_trab`, `afp`, `ips`, `porc_cotizacion`, `porc_adicional`, `porc_cotizacion_ips`, `monto_cotizacion`, `tipo_monto_cotizacion`, `salud`, `ahorro_vol`, `ints_ahorro_vol`, `fecha_ahorro_vol`, `ahorro_full_caja`, `plan_uf`, `plan_pesos`, `seguro_cesantia`, `sueldo_base`, `sueldo_base_1`, `tramo`, `creado_por`, `modificado_por`, `created_at`, `updated_at`
		 */
		$ttp->rut_trab = $trabajador_id;
		$ttp->afp = $request->ttp_afp;
		$ttp->ips = $request->ttp_ips;
		$ttp->porc_cotizacion = $request->ttp_porc_cotizacion;
		$ttp->porc_adicional = $request->ttp_porc_adicional;
		$ttp->porc_cotizacion_ips = $request->ttp_porc_cotizacion_ips;
		$ttp->monto_cotizacion = $request->ttp_monto_cotizacion;
		$ttp->tipo_monto_cotizacion = $request->ttp_tipo_monto_cotizacion;
		$ttp->salud = $request->ttp_salud;
		$ttp->ahorro_vol = $request->ttp_ahorro_vol;
		$ttp->ints_ahorro_vol = $request->ttp_ints_ahorro_vol;
		$ttp->fecha_ahorro_vol = $request->ttp_fecha_ahorro_vol;
		$ttp->ahorro_full_caja = $request->ttp_ahorro_full_caja;
		$ttp->plan_uf = $request->ttp_plan_uf;
		$ttp->plan_pesos = $request->ttp_plan_pesos;
		$ttp->seguro_cesantia = $request->ttp_seguro_cesantia;
		$ttp->sueldo_base = $request->ttp_sueldo_base;
		$ttp->sueldo_base_1 = $request->ttp_sueldo_base_1;
		$ttp->tramo = $request->ttp_tramo;
		$ttp->creado_por = $user->name;
		$ttp->save();
		


		return redirect('fichas/'. $this->ruta.'');

	}

	public function editar($id){
		$trabajador = Trabajadores::get()->where('trabajador_id', '=', $id);
		$ttl = TrabajadoresTienenLaboral::get()->where('rut_trab', '=', $id);
		$ttp = TrabajadoresTienenPrevision::get()->where('rut_trab', '=', $id);
		$sexo = Sexo::all();
		$comuna = Comuna::all();
		$tipo_perfil = TipoPerfil::all();
		$area = Areas::all();
		$empresa = Empresas::all();
		$estado_empleado = EstadoEmpleado::all();
		$tipo_cuenta = TiposCuentas::all();
		$banco = Bancos::all();
		$afp = Afp::all();
		$ips = Ips::all();
		$salud = Salud::all();
		$ints_ahorro_vol = IntsAhorroVol::all();

		return view('adminlte::fichas.'. $this->editar.'')
					->with('trabajador',$trabajador)
					->with('ttl',$ttl)
					->with('ttp',$ttp)
					->with('sexo',$sexo)
					->with('comuna',$comuna)
					->with('tipo_perfil',$tipo_perfil)
					->with('area',$area)
					->with('empresa',$empresa)
					->with('estado_empleado',$estado_empleado)
					->with('tipo_cuenta',$tipo_cuenta)
					->with('banco',$banco)
					->with('afp',$afp)
					->with('ips',$ips)
					->with('salud',$salud)
					->with('ints_ahorro_vol',$ints_ahorro_vol);
	}

	public function Guardar(Request $request){

		
		$trabajador = new Trabajadores;
		$user = Auth::user();
			
		$trabajador->trabajador_id = $request->trabajador_id;
		$trabajador->trabajador_nombres = $request->trabajador_nombres;
		$trabajador->trabajador_ap = $request->trabajador_ap;
		$trabajador->trabajador_am = $request->trabajador_am;
		$trabajador->trabajador_rut = $request->trabajador_rut;
		$trabajador->trabajador_sexo = $request->trabajador_sexo;
		$trabajador->trabajador_direccion = $request->trabajador_direccion;
		$trabajador->trabajador_celular = $request->trabajador_celular;
		$trabajador->trabajador_fecha_nace = $request->trabajador_estado;
		$trabajador->comuna_id = $request->comuna_id;
		$trabajador->tp_id = $request->tp_id;
		$trabajador->creado_por = $user->name;
		
		Trabajadores::where('trabajador_id',$trabajador->trabajador_id)->update(['trabajador_nombres'=>$trabajador->trabajador_nombres,
																			'trabajador_ap'=>$trabajador->trabajador_ap,
																			'trabajador_am'=>$trabajador->trabajador_am,
																			'trabajador_rut'=>$trabajador->trabajador_rut,
																			'trabajador_sexo'=>$trabajador->trabajador_sexo,
																			'trabajador_direccion'=>$trabajador->trabajador_direccion,
																			'trabajador_celular'=>$trabajador->trabajador_celular,
																			'trabajador_fecha_nace'=>$trabajador->trabajador_fecha_nace,
																			'comuna_id'=>$trabajador->comuna_id,
																			'tp_id'=>$trabajador->tp_id,
																			'modificado_por'=>$user->name]);

		//ingreso TrabajadoresTienenLaboral
		$ttl = new TrabajadoresTienenLaboral;
		/*
		 `rut_trab`, `cargo`, `area`, `empresa`, `fecha_ingreso`, `fecha_contrato`, `cant_vacaciones_prog`, `trabajador_sexo`, `causa_finiquito`, `estado_empleado`, `fecha_calculo_vacaciones`, `asignacion_materiales`, `tipo_pago_remuneraciones`, `nro_cuenta`, `tipo_cuenta`, `banco`, `celular`, `auto`, `moto`, `asig_caja`, `monto_asig_caja`, `monto_asig_locomocion`, `monto_asig_fxr`, `anticipo`, `gratificacion`, `indefinido`, `mayor_once`, `creado_por`, `modificado_por`, `created_at`, `updated_at` FROM `trabajadores_tiene_laboral`
		 */
		$ttl->tl_ncorr = $request->tl_ncorr;
		$ttl->rut_trab = $request->trabajador_id;
		$ttl->cargo = $request->ttl_cargo;
		$ttl->area = $request->ttl_area;
		$ttl->empresa = $request->ttl_empresa;
		$ttl->fecha_ingreso = $request->ttl_fecha_ingreso;
		$ttl->fecha_contrato = $request->ttl_fecha_contrato;
		$ttl->cant_vacaciones_prog = $request->ttl_cant_vacaciones_prog;
		$ttl->fecha_finiquito = $request->ttl_fecha_finiquito;
		$ttl->causa_finiquito = $request->ttl_causa_finiquito;
		$ttl->estado_empleado = $request->ttl_estado_empleado;
		$ttl->asignacion_materiales = $request->ttl_asignacion_materiales;
		$ttl->tipo_pago_remuneraciones = $request->ttl_tipo_pago_remuneraciones;
		$ttl->nro_cuenta = $request->ttl_nro_cuenta;
		$ttl->tipo_cuenta = $request->ttl_tipo_cuenta;
		$ttl->banco = $request->ttl_banco;
		$ttl->celular = $request->ttl_celular;
		$ttl->auto = $request->ttl_auto;
		$ttl->moto = $request->ttl_moto;
		$ttl->asig_caja = $request->ttl_asig_caja;
		$ttl->monto_asig_caja = $request->ttl_monto_asig_caja;
		$ttl->monto_asig_locomocion = $request->ttl_monto_asig_locomocion;
		$ttl->monto_asig_fxr = $request->ttl_monto_asig_fxr;
		$ttl->anticipo = $request->ttl_anticipo;
		$ttl->gratificacion = $request->ttl_gratificacion;
		$ttl->indefinido = $request->ttl_indefinido;
		$ttl->mayor_once = $request->ttl_mayor_once;
		$ttl->creado_por = $user->name;
		TrabajadoresTienenLaboral::where('tl_ncorr',$ttl->tl_ncorr)->update([
																			'rut_trab'=>$ttl->rut_trab,
																			'cargo'=>$ttl->cargo,
																			'area'=>$ttl->area,
																			'empresa'=>$ttl->empresa,
																			'fecha_ingreso'=>$ttl->fecha_ingreso,
																			'fecha_contrato'=>$ttl->fecha_contrato,
																			'cant_vacaciones_prog'=>$ttl->cant_vacaciones_prog,
																			'fecha_finiquito'=>$ttl->fecha_finiquito,
																			'causa_finiquito'=>$ttl->causa_finiquito,
																			'estado_empleado'=>$ttl->estado_empleado,
																			'asignacion_materiales'=>$ttl->asignacion_materiales,
																			'tipo_pago_remuneraciones'=>$ttl->tipo_pago_remuneraciones,
																			'nro_cuenta'=>$ttl->nro_cuenta,
																			'tipo_cuenta'=>$ttl->tipo_cuenta,
																			'banco'=>$ttl->banco,
																			'celular'=>$ttl->celular,
																			'auto'=>$ttl->auto,
																			'moto'=>$ttl->moto,
																			'asig_caja'=>$ttl->asig_caja,
																			'monto_asig_caja'=>$ttl->monto_asig_caja,
																			'monto_asig_locomocion'=>$ttl->monto_asig_locomocion,
																			'monto_asig_fxr'=>$ttl->monto_asig_fxr,
																			'anticipo'=>$ttl->anticipo,
																			'gratificacion'=>$ttl->gratificacion,
																			'indefinido'=>$ttl->indefinido,
																			'mayor_once'=>$ttl->mayor_once,
																			'modificado_por'=>$user->name]);
		

		//ingreso TrabajadoresTienenLaboral
		$ttp = new TrabajadoresTienenPrevision;
		/*
		 `rut_trab`, `afp`, `ips`, `porc_cotizacion`, `porc_adicional`, `porc_cotizacion_ips`, `monto_cotizacion`, `tipo_monto_cotizacion`, `salud`, `ahorro_vol`, `ints_ahorro_vol`, `fecha_ahorro_vol`, `ahorro_full_caja`, `plan_uf`, `plan_pesos`, `seguro_cesantia`, `sueldo_base`, `sueldo_base_1`, `tramo`, `creado_por`, `modificado_por`, `created_at`, `updated_at`
		 */
		$ttp->tp_ncorr = $request->tp_ncorr;
		$ttp->rut_trab = $request->trabajador_id;
		$ttp->afp = $request->ttp_afp;
		$ttp->ips = $request->ttp_ips;
		$ttp->porc_cotizacion = $request->ttp_porc_cotizacion;
		$ttp->porc_adicional = $request->ttp_porc_adicional;
		$ttp->porc_cotizacion_ips = $request->ttp_porc_cotizacion_ips;
		$ttp->monto_cotizacion = $request->ttp_monto_cotizacion;
		$ttp->tipo_monto_cotizacion = $request->ttp_tipo_monto_cotizacion;
		$ttp->salud = $request->ttp_salud;
		$ttp->ahorro_vol = $request->ttp_ahorro_vol;
		$ttp->ints_ahorro_vol = $request->ttp_ints_ahorro_vol;
		$ttp->fecha_ahorro_vol = $request->ttp_fecha_ahorro_vol;
		$ttp->ahorro_full_caja = $request->ttp_ahorro_full_caja;
		$ttp->plan_uf = $request->ttp_plan_uf;
		$ttp->plan_pesos = $request->ttp_plan_pesos;
		$ttp->seguro_cesantia = $request->ttp_seguro_cesantia;
		$ttp->sueldo_base = $request->ttp_sueldo_base;
		$ttp->sueldo_base_1 = $request->ttp_sueldo_base_1;
		$ttp->tramo = $request->ttp_tramo;

		TrabajadoresTienenLaboral::where('tp_ncorr',$ttp->tp_ncorr)->update([
																			'rut_trab'=>$ttp->rut_trab,
																			'afp'=>$ttp->afp,
																			'ips'=>$ttp->ips,
																			'porc_cotizacion'=>$ttp->porc_cotizacion,
																			'porc_adicional'=>$ttp->porc_adicional,
																			'porc_cotizacion_ips'=>$ttp->porc_cotizacion_ips,
																			'monto_cotizacion'=>$ttp->monto_cotizacion,
																			'tipo_monto_cotizacion'=>$ttp->tipo_monto_cotizacion,
																			'salud'=>$ttp->salud,
																			'ahorro_vol'=>$ttp->ahorro_vol,
																			'ints_ahorro_vol'=>$ttp->ints_ahorro_vol,
																			'fecha_ahorro_vol'=>$ttp->fecha_ahorro_vol,
																			'ahorro_full_caja'=>$ttp->ahorro_full_caja,
																			'plan_uf'=>$ttp->plan_uf,
																			'plan_pesos'=>$ttp->plan_pesos,
																			'seguro_cesantia'=>$ttp->seguro_cesantia,
																			'sueldo_base'=>$ttp->sueldo_base,
																			'sueldo_base_1'=>$ttp->sueldo_base_1,
																			'tramo'=>$ttp->tramo,
																			'modificado_por'=>$user->name]);

		return redirect('fichas/'. $this->ruta.'');
	}

	public function eliminar($id){
		$trabajador = Trabajadores::where('trabajador_id',$id)->delete();
		return redirect('fichas/'. $this->ruta.'');
	}


}
