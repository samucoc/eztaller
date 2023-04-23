<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\ProductosStock;
class ProductosStockcontroller extends Controller
{
    private  $ruta = "productosstock";
	private  $editar = "productosstockeditar";

	public function index(){
		return view('adminlte::mantenedores.productosstock');
	}

	public function getproductosstock(){
		
	}

	public function crear(Request $request){
		

	}

	public function editar($id){
		
	}

	public function Guardar(Request $request){
		
	}

	public function eliminar($id){
		
	}
}
