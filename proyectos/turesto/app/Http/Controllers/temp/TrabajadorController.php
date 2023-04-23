<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Trabajador;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\TipoPerfil as Perfil;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TrabajadorController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $regiones = Region::all();
        $provincias = Provincia::all();
        $comunas = Comuna::all();
        $perfiles = Perfil::all();
        return view('adminlte::rrhh.trabajadores')->with('regiones',$regiones)->with('provincias', $provincias)->with('comunas',$comunas)->with('perfiles',$perfiles);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getlistar()
    {   
        $trabajadores = Trabajador::with('tipoperfiles')->get();
        return Datatables::of($trabajadores)
        
        ->make(true);
    }

    public function getEditar($id){
        $perfiles = Perfil::all();
        $trabajador = Trabajador::get()->where('trabajador_id','=', $id);
        return view('adminlte::rrhh.editartrabajador')->with('trabajadores', $trabajador)->with('perfiles',$perfiles);
    }

    public function getguardar(Request $request){

        $mensajes = array(
            'direccion.required'=> 'Direcion no puede ser nulo',
            'celular.required'=> 'Celular no puede ser nulo',
            'tp_id.required'=> 'Tipo de Perfil no puede ser nulo'
            );

        $validator = \Validator::make(
            
            [
            
            'direccion'  => $request->txtdireccion,
            'celular'  => $request->txtcelular,
            'tp_id' => $request->txtperfil
            ],
            [
            
            'direccion'  => 'required|string',
            'celular'  => 'required|string',
            'tp_id' => 'required'
            ],
            $mensajes
        );

        if ($validator->fails()) {
            return view('adminlte::rrhh.editartrabajador')->with('alert', 'Zona no registrada.')->withErrors($validator);
        }
        
        $trabajador = new Trabajador;
        $trabajador->trabajador_id = $request->txtid;
        $trabajador->trabajador_direccion = $request->txtdireccion;
        $trabajador->trabajador_celular = $request->txtcelular;
        $trabajador->tp_id = $request->txtperfil;
        $trabajador->trabajador_estado = $request->txtestado;
        if ($trabajador->trabajador_estado == "on") {
            $trabajador->trabajador_estado = 1;
        }else{
            $trabajador->trabajador_estado = 0;
        }
        
        Trabajador::where('trabajador_id',$trabajador->trabajador_id)->update(['trabajador_direccion'=> $trabajador->trabajador_direccion,'trabajador_celular'=>$trabajador->trabajador_celular, 'trabajador_estado'=>$trabajador->trabajador_estado, 'tp_id'=>$trabajador->tp_id]);

        return redirect('/trabajadores');
    }

    public function getEliminar ($id){
       
        $trabajador = Trabajador::where('trabajador_id',$id)->update(['trabajador_estado'=> 0]);
        return redirect('/trabajadores');
    }



    public function obtenerprovincias(Request $request){

        $id = $request->region;
        $provincias = Provincia::where('region_id','=', $id)->get();
        return response()->json($provincias);
    }

      public function obtenercomunas(Request $request){

        $id = $request->provincia;
        $comunas = Comuna::where('provincia_id','=', $id)->get();
        return response()->json($comunas);
    }
}
