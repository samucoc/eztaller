<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoProductos;
use App\Modelos;
use App\productos;
use App\Clientes;
use App\Trabajador;
use App\Sector;
class BusquedasController extends Controller
{
	public function productos(Request $request){
		$termino = $request->term;
		$tproductos = productos::where('producto_id','like','%'.$termino.'%')->orwhere('producto_descripcion','like',''.$termino.'%')->get();
		return $tproductos;
	}

    public function tproductos(Request $request){
		$termino = $request->term;
		$tproductos = TipoProductos::where('tproducto_id','like','%'.$termino.'%')->orwhere('tproducto_descripcion','like',''.$termino.'%')->get();
		return $tproductos;
	}

	public function modelos(Request $request){
		$termino = $request->term;
		$modelos = Modelos::where('modelo_id','like','%'.$termino.'%')->orwhere('modelo_busqueda','like',''.$termino.'%')->get();
		return $modelos;
	}

	public function clientes(Request $request){
		$termino = $request->term;
		$clientes = Clientes::where('cliente_nombres','like',''.$termino.'%')->get();
		return $clientes;
	}
	//funcion para buscar cualquier trabajador activo
	//sin importar el tipo de trabajador
	public function trabajador(Request $request){
		$termino = $request->term;
		if(is_numeric($termino)){
			$trabajador = Trabajador::where('trabajador_id','like',''.$termino.'%')->where('trabajador_estado','=','1')->get();

		}else{
			$trabajador = Trabajador::where('trabajador_nombres','like',''.$termino.'%')->where('trabajador_estado','=','1')->get();
			
		}
		return $trabajador;
	}

	public function sectores(Request $request){
		$termino = $request->term;
		$sector = Sector::where('sector_id','like',''.$termino.'%')->where('sector_estado','=',1)->get();
		return $sector;
	}

	//funcion para buscar al trabajador con el perfil de cobrador y que se encuentre activo
	public function cobrador(Request $request){
		$termino = $request->term;
		if(is_numeric($termino)){
			$trabajador = Trabajador::where('trabajador_id','like',''.$termino.'%')->where('tp_id','=','10')->where('trabajador_estado','=','1')->get();
		}else{	
			$trabajador = Trabajador::where('trabajador_nombres','like',''.$termino.'%')->where('tp_id','=','10')->where('trabajador_estado','=','1')->get();
		}
		return $trabajador;
	}
	//funcion para buscar al trabajador con el perfil de supervisor y que se encuentre activo
	public function supervisor(Request $request){
		$termino = $request->term;
		if(is_numeric($termino)){
			$trabajador = Trabajador::where('trabajador_id','like',''.$termino.'%')->whereIn('tp_id',[11,13])->where('trabajador_estado','=','1')->get();
		}else{
			$trabajador = Trabajador::where('trabajador_nombres','like',''.$termino.'%')->where('tp_id','=','11')->where('trabajador_estado','=','1')->get();
		}
		return $trabajador;
	}
}
