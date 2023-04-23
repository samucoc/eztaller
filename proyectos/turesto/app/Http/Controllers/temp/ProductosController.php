<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\productos;
use App\TipoProductos;
use App\Modelos;
class ProductosController extends Controller
{
    private  $ruta = "productos";
	private  $editar = "productoseditar";

	public function index(){
		$tproductos = TipoProductos::all();
		$modelos = Modelos::all();
		return view('adminlte::mantenedores.productos')->with('tproductos',$tproductos)->with('modelos',$modelos);
	}

	public function getproductos(){
		$productos = productos::with('tipoproductos')->with('modelos');
		return Datatables::of($productos)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'producto_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'productos_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
			['producto_descripcion' 	=> $request->txtdescripcion],
			['producto_descripcion' 	=> 'required|unique:productos'],//especificamos que sea unico y le indicamos la tabla
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $producto = explode('-', $request->txttproducto); //obtenemos el tipo de producto y desglozamos la data para obtener el id del producto
        $modelo= explode('-', $request->txtmodelo);//obtenemos el modelo y desglozamos la data para obtener el id del modelo
        $user = Auth::user();
		$productos = new productos;
		$productos->producto_descripcion = $request->txtdescripcion;
		$productos->tproducto_id = $producto[0];//asignamos el primer valor del arreglo que es nuestro id
		$productos->modelo_id = $modelo[0];//asignamos el primer valor del arreglo que es nuestro id
		$productos->estado_id = 1; //de forma predeterminada se crea con el estado activo de la tabla estados
		$productos->creado_por= $user->name; //guardamos el nombre de la persona que realizo la creacion de la nueva categoria
		$productos->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$productos = productos::get()->where('producto_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('productos',$productos);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'producto_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'producto_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'producto_descripcion' 	=> $request->txtdescripcion
			],
			[
			'producto_descripcion' 	=> 'required|unique:productos'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$productos = new productos;
		$productos->producto_id = $request->txtid;
		$productos->producto_descripcion = $request->txtdescripcion;
		$productos->modificado_por = $user->name;

		productos::where('producto_id',$productos->producto_id)->update(['producto_descripcion'=>$productos->productos_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$productos = productos::where('productos_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}

}
