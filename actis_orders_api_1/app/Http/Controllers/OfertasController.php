<?php

namespace App\Http\Controllers;


use JWTAuth;
use App\Ofertas;
use Illuminate\Http\Request;

class OfertasController extends Controller
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
       return $data = Ofertas::all();
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
            'programa_id' => 'required',
            'oferta_anio' => 'required',
            'oferta_monto' => 'required',
            'oferta_monto' => 'required',
            'oferta_sector' => 'required',
            'oferta_periodo_inicio' => 'required',
            'oferta_periodo_fin' => 'required'

        ]);
    
        $Ofertas = new Ofertas();
        $Ofertas->programa_id = $request->programa_id;
        $Ofertas->oferta_anio = $request->oferta_anio;
        $Ofertas->oferta_monto = $request->oferta_monto;
        $Ofertas->oferta_monto = $request->oferta_monto;
        $Ofertas->oferta_sector = $request->oferta_sector;
        $Ofertas->oferta_periodo_inicio = $request->oferta_periodo_inicio;
        $Ofertas->oferta_periodo_fin = $request->oferta_periodo_fin;
    
        if ($this->save($Ofertas))
            return response()->json([
                'success' => true,
                'product' => $Ofertas
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Ofertas could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ofertass  $Ofertass
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $data = Ofertas::where('oferta_id', $id)->get();
    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Ofertass  $Ofertass
    //  * @return \Illuminate\Http\Response
     
    // public function edit(Ofertass $Ofertass)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ofertass  $Ofertass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Ofertas = $this->find($id);
    
        if (!$Ofertas) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Ofertas with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        $updated = $Ofertas->fill($request->all())
            ->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Ofertas could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ofertass  $Ofertass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $Ofertas = $this->find($id);
    
        if (!$Ofertas) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Ofertas with id ' . $id . ' cannot be found'
            ], 400);
        }
    
        if ($Ofertas->delete()) {
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
