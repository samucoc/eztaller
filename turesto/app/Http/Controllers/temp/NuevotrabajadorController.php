<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nuevotrabajador as trabajador;
//namespace necesarios para validar los form
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;
class NuevotrabajadorController extends Controller
{
    
    public function store(Request $request){
        $mensajes = array(
            'trabajador_nombres.required'=> 'El Campo Nombre no puede ser Nulo.',
            'trabajador_ap.required'=> 'El Campo Apellido Paterno no puede ser Nulo. ',
            'trabajador_am.required'=> 'El Campo Apellido Materno no puede ser Nulo.',
            'trabajador_rut.required'=> 'El Campo Rut no puede ser Nulo.',
            'trabajador_sexo.required'=> 'El Campo Sexo no puede ser Nulo.',
            'trabajador_direccion.required'=> 'El Campo Direccion no puede ser Nulo.',
            'trabajador_fecha_nace.required'=> 'El Campo Fecha Nacimiento no puede ser Nulo.',
            'trabajador_celular.required'=> 'El Campo celular no puede ser Nulo.',
            'comuna_id.required'=> 'El Campo Comuna no puede ser Nulo.',
            'tp_id.required|numeric'=> 'El Campo Perfil, debe seleccionar un campo.'

            );

        $validator = \Validator::make(
            
            [
            'trabajador_nombres'  => $request->txtnombres,
            'trabajador_ap'  => $request->txtapellidopat,
            'trabajador_am'  => $request->txtapellidomat,
            'trabajador_rut'  => $request->txtrut,
            'trabajador_sexo'  => $request->txtsexo,
            'trabajador_direccion'  => $request->txtdireccion,
            'comuna_id'  => $request->txtcomuna,
            'celular'  => $request->txtcelular,
            'trabajador_fecha_nace'  => $request->txtfecha,
            'tp_id' => $request->txtperfil
            ],
            [
            'trabajador_nombres'  => 'required|string',
            'trabajador_ap'  => 'required|string',
            'trabajador_am'  => 'required|string',
            'trabajador_rut'  => 'required|unique:trabajadores',
            'trabajador_sexo'  => 'required|string',
            'trabajador_direccion'  => 'required|string',
            'trabajador_celular'  => 'required|numeric',
            'trabajador_fecha_nace'  => 'required|string',
            'comuna_id'  => 'required|string',
            'tp_id' => 'required'
            ],
            $mensajes
        );

        if ($validator->fails()) {
            return redirect('trabajadores')->withErrors($validator);
        }
        
    	//instanciamos un nuevo modelo trabajador
    	$trabajador = new trabajador;
    	//obtenemos todos los datos por post desde nuestro formulario 
    	$trabajador->trabajador_nombres = $request->txtnombres;
    	$trabajador->trabajador_ap = $request->txtapellidopat;
    	$trabajador->trabajador_am = $request->txtapellidomat;
    	$trabajador->trabajador_rut = $request->txtrut;
    	$trabajador->trabajador_sexo = $request->txtsexo;
    	$trabajador->trabajador_direccion = $request->txtdireccion;
    	$trabajador->comuna_id = $request->txtcomuna;
    	$trabajador->trabajador_celular = $request->txtcelular;
    	$trabajador->trabajador_fecha_nace = $request->txtfecha;
    	$trabajador->trabajador_estado = "1";
        $trabajador->tp_id = $request->txtperfil;
        //estado == 1 =>activo estado ==0 =>inactivo
    	//guardamos nuestro trabajador en la bd
    	$trabajador->save();

        //generamos el nuevo usuario par el trabajador recien ingresado.
        $user = new User;
        $user->name = $trabajador->nombres." ".$trabajador->trabajador_ap;
        $user->email = $request->txtmail;
        $user->password  =  bcrypt(substr($trabajador->trabajador_nombres,0,1).substr($trabajador->trabajador_ap,0,1).substr($trabajador->rut,0,4));//la contraseña se genera con la primera letra del nombre + la primera letra del apellido paterno + los 4 primeros digitos del rut y luego se encripta mediante laravel
        $user->perfil = $trabajador->tp_id; //el perfil que tendra el usuario en el sistema.
        $user->trabajador_id = $trabajador->id;//obtenemos el id del trabajador previamente insertado en la bd
        $user->save();//guardamos el nuevo usuario
    	//retornamos nuevamente a la vista de listado de los trabajadores
    	return redirect('/trabajadores');
    }
}
