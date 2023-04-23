<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\trabajador;
use PDF;
class PdftrabajadoresController extends Controller
{

	public function crearpdf(Request $request){
	    //obtenemos todos los trabajadores del sistema
		$trabajadores = trabajador::get();
		//generamos la vista para el pdf
		view()->share('trabajadores',$trabajadores);


		if($request->has('download')){
			$pdf = new PDF();
            $pdf = PDF::loadView('adminlte::pdf.pdf_trabajadores');
            return $pdf->stream('Lista_Trabajadores.pdf');
        }
		//retornamos a la vista
		return view('adminlte::pdf/pdf_trabajadores');
	}

	public function descargar(){
		$pdf = new PDF();
		$pdf = PDF::loadView('adminlte::pdf.pdf_trabajadores');
 		return $pdf->stream('Lista_Trabajadores.pdf');
	}


}
