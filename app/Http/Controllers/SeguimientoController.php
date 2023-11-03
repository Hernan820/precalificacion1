<?php

namespace App\Http\Controllers;

use App\Models\seguimiento;
use Illuminate\Http\Request;
use App\Models\User;

class SeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $seguimiento = new seguimiento;
        $seguimiento->seguimiento         = $request->txtseguimiento;
        $seguimiento->id_precalificacion  = $request->id_registro;
        $seguimiento->id_usuario          = auth()->user()->id;
        $seguimiento->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\seguimiento  $seguimiento
     * @return \Illuminate\Http\Response
     */
    public function show(seguimiento $seguimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\seguimiento  $seguimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(seguimiento $seguimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\seguimiento  $seguimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, seguimiento $seguimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\seguimiento  $seguimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(seguimiento $seguimiento)
    {
        //
    }
}
