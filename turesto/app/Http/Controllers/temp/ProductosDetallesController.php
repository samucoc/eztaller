<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\ProductosDetalles;
class ProductosDetallesController extends Controller
{
    private  $ruta = "productosdetalles";
	private  $editar = "productosdetalleseditar";

	public function index(){
		return view('adminlte::mantenedores.productosdetalles');
	}

	public function getproductosdetalles(){
		$productosdetalles = ProductosDetalles::with('productos');
		return Datatables::of($productosdetalles)
		->make(true);
	}

	public function crear(Request $request){
		$mensajes = array(
			'productod_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'productod_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
			['productod_descripcion' 	=> $request->txtdescripcion],
			['productod_descripcion' 	=> 'required|unique:productos_detalles'],//especificamos que sea unico y le indicamos la tabla
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$productosdetalles = new ProductosDetalles;
		$productosdetalles->productod_descripcion = $request->txtdescripcion;
		$productosdetalles->estado_id = 1; //de forma predeterminada se crea con el estado activo de la tabla estados
		$productosdetalles->creado_por= $user->name; //guardamos el nombre de la persona que realizo la creacion de la nueva categoria
		
		$productosdetalles->save();
		return redirect('mantenedores/'. $this->ruta.'');

	}

	public function editar($id){
		$productosdetalles = ProductosDetalles::get()->where('productod_id', '=', $id);
		return view('adminlte::mantenedores.'. $this->editar.'')->with('productosdetalles',$productosdetalles);
	}

	public function Guardar(Request $request){
		$mensajes = array(
			'productod_descripcion.required'=> 'El Campo Descripcion no puede ser nulo.',
			'productod_descripcion.required|unique'=> 'El Campo Descripcion ya se encuentra en el sistema.'
			);

		$validator = \Validator::make(
	 		
			[
			'productod_descripcion' 	=> $request->txtdescripcion
			],
			[
			'productod_descripcion' 	=> 'required|unique:productos_detalles'
			],
			$mensajes
		);

 		if ($validator->fails()) {
			return redirect('mantenedores/'. $this->ruta.'')->withErrors($validator);
        }
        $user = Auth::user();
		$productosdetalles = new ProductosDetalles;
		$productosdetalles->productod_id = $request->txtid;
		$productosdetalles->productod_descripcion = $request->txtdescripcion;
		$productosdetalles->modificado_por = $user->name;

		productos::where('productod_id',$productosdetalles->productod_id)->update(['productod_descripcion'=>$productosdetalles->productod_descripcion]);
		return redirect('mantenedores/'. $this->ruta.'');
	}

	public function eliminar($id){
		$productosdetalles = ProductosDetalles::where('productod_id',$id)->delete();
		return redirect('mantenedores/'. $this->ruta.'');
	}
}
