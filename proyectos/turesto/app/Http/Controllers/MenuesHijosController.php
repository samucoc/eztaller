<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuesHijos;
use App\Menu;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

class MenuesHijosController extends Controller
{
       	public function submenu(){
    		$submenues = MenuesHijos::orderby('mhijo_orden')->where('mhijo_mostrar', '=', 'SI')->get();
    		return $submenues;
    	}
       	public function submenu_1(){
    		$submenues = MenuesHijos::orderby('mhijo_orden')->where('mhijo_mostrar', '=', 'NO')->get();
    		return $submenues;
    	}

    private  $ruta = "menuhijos";
	private  $editar = "menuhijoseditar";

    public function index(){
    	$menues = Menu::orderby('menu_orden')->where('menu_mostrar', '=', 'SI')->get();
    	$subs = MenuesHijos::where('mhijo_descripcion','like','%>%')->get();
    	
		return view('adminlte::configuracion.'. $this->ruta.'')->with('menues',$menues)->with('subs',$subs);
	}


	public function getsubmenues(){
		$submenues = MenuesHijos::all();
		return Datatables::of($submenues)
		->make(true);
	}

	public function crear(Request $request){
		
		if ($request->opcion == 3) {
			//$request->txtdescripcion = $request->txtdescripcion+'>>';
			$mhijo_sub_menu          = 0;
			$mhijo_mostrar           = "SI";
			$mhijo_visible           = "SI";
			
			$mensajes = array(
			'mhijo_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'mhijo_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'mhijo_link.required'=> 'El Campo Link no puede ser nulo.',
			'mhijo_link.required|unique'=> 'El Campo Link ya se encuentra en el sistema.',
			'menu_id.required|unique'=> 'El Campo menu no puede ser nulo.'
			);

			$validator = \Validator::make(
		 		
				[
				'mhijo_descripcion' => $request->txtdescripcion,
				'mhijo_link'        => $request->txtlink,
				'menu_id'           => $request->txtmenu
				],
				[
				'mhijo_descripcion' => 'required|unique:menues_hijos',
				'mhijo_link'        => 'required|unique:menues_hijos',
				'menu_id'           => 'required'
				],
				$mensajes
			);

	 		if ($validator->fails()) {
				return redirect('configuracion/'. $this->ruta.'')->withErrors($validator);
	        }
	        
	        $user = Auth::user();
			$submenues                    = new MenuesHijos;
			$submenues->mhijo_sub_menu    = $mhijo_sub_menu;
			$submenues->mhijo_descripcion = $request->txtdescripcion;
			$submenues->mhijo_link        = $request->txtlink;
			$submenues->mhijo_orden    = 99; 
			$submenues->mhijo_mostrar     = $mhijo_mostrar;
			$submenues->mhijo_visible     = $mhijo_visible;
			$submenues->menu_id           = $request->txtmenu;
			$submenues->creado_por		  = $user->name;
			$submenues->save();
			return redirect('configuracion/'. $this->ruta.'');


		}else{

		if ($request->opcion == 1) {
			//$request->txtdescripcion = $request->txtdescripcion+'>>';
			$mhijo_sub_menu          = 0;
			$mhijo_mostrar           = "SI";
			$mhijo_visible           = "SI";
			
			$mensajes = array(
			'mhijo_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'mhijo_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'mhijo_link.required'=> 'El Campo Link no puede ser nulo.',
			'mhijo_link.required|unique'=> 'El Campo Link ya se encuentra en el sistema.',
			'menu_id.required|unique'=> 'El Campo menu no puede ser nulo.'
			);

			$validator = \Validator::make(
		 		
				[
				'mhijo_descripcion' => $request->txtdescripcion,
				'mhijo_link'        => $request->txtlink,
				'menu_id'           => $request->txtmenu
				],
				[
				'mhijo_descripcion' => 'required|unique:menues_hijos',
				'mhijo_link'        => 'required|unique:menues_hijos',
				'menu_id'           => 'required'
				],
				$mensajes
			);

	 		if ($validator->fails()) {
				return redirect('configuracion/'. $this->ruta.'')->withErrors($validator);
	        }
	        $user = Auth::user();
	        $desc = $request->txtdescripcion;
	        $desc = $desc.'>>';
			$submenues                    = new MenuesHijos;
			$submenues->mhijo_sub_menu    = $mhijo_sub_menu;
			$submenues->mhijo_descripcion = $desc;
			$submenues->mhijo_link        = $request->txtlink;
			$submenues->mhijo_orden    = 99;
			$submenues->mhijo_mostrar     = $mhijo_mostrar;
			$submenues->mhijo_visible     = $mhijo_visible;
			$submenues->menu_id           = $request->txtmenu;
			$submenues->creado_por		  = $user->name;
			$submenues->save();
			return redirect('configuracion/'. $this->ruta.'');




		}else{
			$mhijo_sub_menu = $request->txtsubhijo;
			$mhijo_mostrar = "NO";
			$mhijo_visible = "SI";

			$mensajes = array(
			'mhijo_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'mhijo_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'mhijo_link.required'=> 'El Campo Link no puede ser nulo.',
			'mhijo_link.required|unique'=> 'El Campo Link ya se encuentra en el sistema.',
			'menu_id.required'=> 'El Campo menu no puede ser nulo.',
			'mhijo_sub_menu.required'=> 'El Campo menu no puede ser nulo.'
			);

			$validator = \Validator::make(
		 		
				[
				'mhijo_descripcion' => $request->txtdescripcion,
				'mhijo_link'        => $request->txtlink,
				'menu_id'           => $request->txtmenu,
				'mhijo_sub_menu'    => $request->txtsubhijo
				],
				[
				'mhijo_descripcion' => 'required|unique:menues_hijos',
				'mhijo_link'        => 'required|unique:menues_hijos',
				'menu_id'           => 'required',
				'mhijo_sub_menu'    => 'required'
				],
				$mensajes
			);

	 		if ($validator->fails()) {
				return redirect('configuracion/'. $this->ruta.'')->withErrors($validator);
	        }
	        $user = Auth::user();
			$submenues                    = new MenuesHijos;
			$submenues->mhijo_sub_menu    = $request->txtsubhijo;
			$submenues->mhijo_descripcion = $request->txtdescripcion;
			$submenues->mhijo_link        = $request->txtlink;
			$submenues->mhijo_orden    = 99;
			$submenues->mhijo_mostrar     = $mhijo_mostrar;
			$submenues->mhijo_visible     = $mhijo_visible;
			$submenues->menu_id           = $request->txtmenu;
			$submenues->creado_por		  = $user->name;
			$submenues->save();
			return redirect('configuracion/'. $this->ruta.'');

		}
		}

	}

	public function editar($id){
		$submenues = MenuesHijos::get()->where('mhijo_id', '=', $id);
		$menues = Menu::all();
		return view('adminlte::configuracion.'. $this->editar.'')->with('submenues',$submenues)->with('menues',$menues);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'mhijo_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'mhijo_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);


		$descripciones = MenuesHijos::select('mhijo_descripcion')->where('mhijo_id','=',$request->txtid)->get();
		foreach ($descripciones as $descripcion ) {
			$nombre = $descripcion->mhijo_descripcion;
		}

		if ($nombre == $request->txtdescripcion) {
			$validator = \Validator::make(
		 		
				[
				'mhijo_descripcion' 	=> $request->txtdescripcion,
				'mhijo_link' =>$request->txtlink,
				'menu_id' =>$request->txtmenu
				],
				[
				'mhijo_descripcion' 	=> 'required',
				'mhijo_link' =>'required',
				'menu_id' => 'required'
				],
				$mensajes
			);
		}else{
			$validator = \Validator::make(
		 		
				[
				'mhijo_descripcion' 	=> $request->txtdescripcion,
				'mhijo_link' =>$request->txtlink,
				'menu_id' =>$request->txtmenu
				],
				[
				'mhijo_descripcion' 	=> 'required|unique:menues_hijos',
				'mhijo_link' =>'required',
				'menu_id' => 'required'
				],
				$mensajes
			);
		}


		

 		if ($validator->fails()) {
			return redirect('configuracion/'. $this->ruta.'')->withErrors($validator);
        }


		$submenues = new MenuesHijos;
		$submenues->mhijo_id = $request->txtid;
		$submenues->mhijo_descripcion = $request->txtdescripcion;
		$submenues->mhijo_link = $request->txtlink;
		$submenues->menu_id = $request->txtmenu;
		$submenues->mhijo_mostrar = $request->txtestado;
        if ($submenues->mhijo_mostrar == "on") {
            $submenues->mhijo_mostrar = "SI";
        }else{
            $submenues->mhijo_mostrar = "NO";
        }

		MenuesHijos::where('mhijo_id',$submenues->mhijo_id)->update(['mhijo_descripcion'=>$submenues->mhijo_descripcion,'mhijo_link'=>$submenues->mhijo_link,'menu_id'=>$submenues->menu_id,'mhijo_mostrar'=>$submenues->mhijo_mostrar]);
		return redirect('configuracion/'. $this->ruta.'');
	}

	public function eliminar($id){
		$submenues	 = MenuesHijos::where('mhijo_id',$id)->update(['mhijo_mostrar'=>"NO"]);
		return redirect('configuracion/'. $this->ruta.'');
	}
}
