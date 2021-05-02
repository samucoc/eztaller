<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadosCiviles extends Controller
{
    // all EstadosCiviless
    public function index()
    {
        return DB::table('ez_estados_civiles')->get();
    }
 
    // add EstadosCiviles
    public function add(Request $request)
    {
        $EstadosCiviles = new EstadosCiviles([
            'nombre' => $request->input('nombre')
        ]);
        $EstadosCiviles->save();
 
        return response()->json('Estado Civil correcto');
    }
 
    // edit EstadosCiviles
    public function edit($id)
    {
        $EstadosCiviles = EstadosCiviles::find($id);
        return response()->json($EstadosCiviles);
    }
 
    // update EstadosCiviles
    public function update($id, Request $request)
    {
        $EstadosCiviles = EstadosCiviles::find($id);
        $EstadosCiviles->update($request->all());
 
        return response()->json('Estado Civil actualizado');
    }
 
    // delete EstadosCiviles
    public function delete($id)
    {
        $EstadosCiviles = EstadosCiviles::find($id);
        $EstadosCiviles->delete();
 
        return response()->json('Estado Civil borrado');
    }
}
