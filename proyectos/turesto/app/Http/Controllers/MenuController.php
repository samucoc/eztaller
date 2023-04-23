<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Menu;

class MenuController extends Controller
{	
	private  $ruta = "menues";
	private  $editar = "menueseditar";

	//funcion para listar el menu principal
    public function menu(){
    	$menues = Menu::orderby('menu_orden')->where('menu_mostrar', '=', 'SI')->get();
    	return $menues;
    }


    public function index(){
		return view('adminlte::configuracion.'. $this->ruta.'');
	}


	public function getmenues(){
		$menues = Menu::all();
		return Datatables::of($menues)
		->make(true);
	}

	public function crear(Request $request){
		
		$mensajes = array(
			'menu_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'menu_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'menu_icon.required'=> 'El Campo Descripcion no puede ser nulo.'
			);

		$validator = \Validator::make(
	 		
			[
			'menu_descripcion' 	=> $request->txtdescripcion,
			'menu_icon' 	=> $request->txticono
			],
			[
			'menu_descripcion' 	=> 'required|unique:menues',
			'menu_icon' 	=> 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('configuracion/'. $this->ruta.'')->withErrors($validator);
        }

        $orden = Menu::max('menu_orden');
        $orden = $orden + 1;


		$menues = new Menu;
		$menues->menu_descripcion = $request->txtdescripcion;
		$menues->menu_icon = $request->txticono;
		$menues->menu_orden = $orden;
		$menues->menu_mostrar = "SI";
		$menues->save();
		return redirect('configuracion/'. $this->ruta.'');

	}

	public function editar($id){
		$menues = Menu::get()->where('menu_ncorr', '=', $id);
		return view('adminlte::configuracion.'. $this->editar.'')->with('menues',$menues);
	}

	public function Guardar(Request $request){

		$mensajes = array(
			'menu_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'menu_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'menu_icon.required'=> 'El Campo Descripcion no puede ser nulo.'
			);

		$descripcion = Menu::where('menu_ncorr','=',$request->txtid)->select('menu_descripcion')->get();
		foreach ($descripcion as $descrip ) {
			$nombre = $descrip->menu_descripcion;
		}
		if ($request->txtdescripcion == $nombre) {
			$validator = \Validator::make(
				[
				'menu_descripcion' 	=> $request->txtdescripcion,
				'menu_icon' 	=> $request->txticono
				],
				[
				'menu_descripcion' 	=> 'required',
				'menu_icon' 	=> 'required'
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
				[
				'menu_descripcion' 	=> $request->txtdescripcion,
				'menu_icon' 	=> $request->txticono
				],
				[
				'menu_descripcion' 	=> 'required|unique:menues',
				'menu_icon' 	=> 'required'
				],
				$mensajes
			
			);
		}

 		if ($validator->fails()) {
			return redirect('configuracion/'. $this->ruta.'/editar/'.$request->txtid.'')->withErrors($validator);
        }
        
		$menues = new Menu;
		$menues->menu_ncorr = $request->txtid;
		$menues->menu_descripcion = $request->txtdescripcion;
		$menues->menu_icon = $request->txticono;

		Menu::where('menu_ncorr',$menues->menu_ncorr)->update(['menu_descripcion'=>$menues->menu_descripcion,'menu_icon'=>$menues->menu_icon]);
		return redirect('configuracion/'. $this->ruta.'');
	}

	public function eliminar($id){
		$menues = Menu::where('menu_ncorr',$id)->update(['menu_mostrar'=>'NO']);
		return redirect('configuracion/'. $this->ruta.'');
	}


}
