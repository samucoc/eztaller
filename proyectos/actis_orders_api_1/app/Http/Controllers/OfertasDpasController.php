<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\OfertasDpas;
use Illuminate\Http\Request;

class OfertasDpasController extends Controller
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
       return $data = OfertasDpas::all();
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
            'oferta_id  ' => 'required',
            'dpa_id' => 'required',
            'oferta_dpa_responsable_comuna' => 'required',
            'oferta_dpa_cupos' => 'required',
            'oferta_dpa_monto' => 'required'

        ]);
    
        $OfertasDpas = new OfertasDpas();
        $OfertasDpas->oferta_id  = $request->oferta_id;
        $OfertasDpas->dpa_id = $request->dpa_id;
        $OfertasDpas->oferta_dpa_responsable_comuna = $request->oferta_dpa_responsable_comuna;
        $OfertasDpas->oferta_dpa_cupos = $request->oferta_dpa_cupos;
        $OfertasDpas->oferta_dpa_monto = $request->oferta_dpa_monto;

        if ($this->save($OfertasDpas))
            return response()->json([
                'success' => true,
                'product' => $OfertasDpas
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, OfertasDpas could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OfertasDpas  $OfertasDpas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $data = OfertasDpas::where('oferta_dpa_id', $id)->get();
    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\OfertasDpass  $OfertasDpass
    //  * @return \Illuminate\Http\Response
     
    // public function edit(OfertasDpass $OfertasDpass)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfertasDpass  $OfertasDpass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $OfertasDpas = $this->find($id);
    
        if (!$OfertasDpas) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, OfertasDpas with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        $updated = $OfertasDpas->fill($request->all())
            ->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, OfertasDpas could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OfertasDpass  $OfertasDpass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $OfertasDpas = $this->find($id);
    
        if (!$OfertasDpas) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, OfertasDpas with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($OfertasDpas->delete()) {
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
