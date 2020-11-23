<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Programas;
use Illuminate\Http\Request;

class ProgramasController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return $data = Programas::all();
    }

    // *
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
     
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'programa_nombre' => 'required',
            'programa_descripcion' => 'required',
            'programa_presupuesto' => 'required|integer',
            'programa_poblacion_objetivo' => 'required|integer',
            'programa_responsable' => 'required|integer'
        ]);
    
        $programa = new Programas();
        $programa->programa_nombre = $request->programa_nombre;
        $programa->programa_descripcion = $request->programa_descripcion;
        $programa->programa_presupuesto = $request->programa_presupuesto;
        $programa->programa_poblacion_objetivo = $request->programa_poblacion_objetivo;
        $programa->programa_responsable = $request->programa_responsable;
    
        if ($this->save($programa))
            return response()->json([
                'success' => true,
                'product' => $programa
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, programa could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Programas  $programas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $data = Programas::where('programa_id', $id)->get();
    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Programas  $programas
    //  * @return \Illuminate\Http\Response
     
    // public function edit(Programas $programas)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programas  $programas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $programa = $this->find($id);
    
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, programa with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        $updated = $programa->fill($request->all())
            ->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, programa could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Programas  $programas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $programa = $this->find($id);
    
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, programa with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($programa->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted'
            ], 500);
        }
    }
}
