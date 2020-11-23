<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Dpa;
use Illuminate\Http\Request;



class DpaController extends Controller
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
       return $data = DPA::all();
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
            'dpa_region_nombre' => 'required',
            'dpa_region_codigo' => 'required',
            'dpa_provincia_nombre' => 'required',
            'dpa_provincia_codigo' => 'required',
            'dpa_comuna_nombre' => 'required',
            'dpa_comuna_codigo' => 'required'

        ]);
    
        $DPA = new DPA();
        $DPA->dpa_region_nombre = $request->dpa_region_nombre;
        $DPA->dpa_region_codigo = $request->dpa_region_codigo;
        $DPA->dpa_provincia_nombre = $request->dpa_provincia_nombre;
        $DPA->dpa_provincia_codigo = $request->dpa_provincia_codigo;
        $DPA->dpa_comuna_nombre = $request->dpa_comuna_nombre;
        $DPA->dpa_comuna_codigo = $request->dpa_comuna_codigo;
    
        if ($this->save($DPA))
            return response()->json([
                'success' => true,
                'product' => $DPA
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, DPA could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DPAs  $DPAs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $data = DPA::where('dpa_id', $id)->get();
    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\DPAs  $DPAs
    //  * @return \Illuminate\Http\Response
     
    // public function edit(DPAs $DPAs)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DPAs  $DPAs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $DPA = $this->find($id);
    
        if (!$DPA) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, DPA with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        $updated = $DPA->fill($request->all())
            ->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, DPA could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DPAs  $DPAs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $DPA = $this->find($id);
    
        if (!$DPA) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, DPA with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($DPA->delete()) {
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
