<?php

namespace App\Http\Controllers;

use App\Models\Vaca;
use Illuminate\Http\Request;

class VacaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vaca::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vaca = Vaca::create($request->all());
        return response()->json($vaca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vaca $vaca)
    {
        return Vaca::findOrFail($vaca);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vaca $vaca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    

    public function update(Request $request, Vaca $vaca)
    {
        $vaca = Vaca::findOrFail($vaca);
        $vaca->update($request->all());
        return response()->json($vaca, 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vaca $vaca)
    {
        Vaca::destroy($vaca);
        return response()->json(null, 204);
    }
}
