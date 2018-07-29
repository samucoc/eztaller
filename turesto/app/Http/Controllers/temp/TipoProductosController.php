<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\TipoProductos;
use App\Categorias;
class TipoProductosController extends Controller
{
    private  $ruta = "tipoproductos";
	private  $editar = "tipoproductoseditar";

    public function index(){
    	$categorias= Categorias::all();

		return view('adminlte::mantenedores.'. $this->ruta.'')->with('categorias',$categorias);
	}

	public function gettipoproductos(){
		$tipoproductos = TipoProductos::with('categorias');
		return Datatables::of($tipoproductos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'tproducto_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tproducto_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'categoria_id.required'=>'Debe seleccionar una Categoria'
			);

		$validator = \Validator::make(
	 		
			[
			'tproducto_descripcion' 	=> $request->txtdescripcion,
			'categoria_id' =>$request->txtcategoria
			],
			[
			'tproducto_descripcion' 	=> 'required|unique:tipo_productos',
			'categoria_id' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$tipoproductos = new TipoProductos;
		$tipoproductos->tproducto_descripcion = $request->txtdescripcion;
		$tipoproductos->categoria_id = $request->txtcategoria;
		$tipoproductos->estado_id = 1;//activo
		$tipoproductos->creado_por = $user->name;
		$tipoproductos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}



	public function editar($id){
		$tipoproductos = TipoProductos::get()->where('tproducto_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('tipoproductos',$tipoproductos);

	}

	public function Guardar(Request $request){
		$mensajes = array(
			'tproducto_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'tproducto_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.',
			'categoria_id.required'=>'Debe seleccionar una Categoria'
			);

		$validator = \Validator::make(
	 		
			[
			'tproducto_descripcion' 	=> $request->txtdescripcion,
			'categoria_id' =>$request->txtcategoria
			],
			[
			'tproducto_descripcion' 	=> 'required|unique:tipo_depositos',
			'categoria_id' => 'required'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$tipoproductos = new TipoProductos;
		$tipoproductos->tproducto_id = $request->txtid;
		$tipoproductos->tproducto_descripcion = $request->txtdescripcion;
		$tipoproductos->categoria_id = $request->txtcategoria;
		$tipoproductos->modificado_por = $user->name;

		TipoProductos::where('tproducto_id',$tipoproductos->tproducto_id)->update(['tproducto_descripcion'=>$tipoproductos->tproducto_descripcion,'categoria_id'=>$tipoproductos->categoria_id,'modificado_por'=>$tipoproductos->modificado_por]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$tipoproductos = TipoProductos::where('tproducto_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
