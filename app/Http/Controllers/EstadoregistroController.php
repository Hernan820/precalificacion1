<?php

namespace App\Http\Controllers;

use App\Models\estadoregistro;
use Illuminate\Http\Request;
use App\Models\bitacora;
date_default_timezone_set("America/New_York");


class EstadoregistroController extends Controller
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
    public function create()
    {
        //
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
     * @param  \App\Models\estadoregistro  $estadoregistro
     * @return \Illuminate\Http\Response
     */
    public function show(estadoregistro $estadoregistro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\estadoregistro  $estadoregistro
     * @return \Illuminate\Http\Response
     */
    public function edit(estadoregistro $estadoregistro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\estadoregistro  $estadoregistro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, estadoregistro $estadoregistro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\estadoregistro  $estadoregistro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estado = new estadoregistro;
        $estado->estado = 0;
        $estado->id_form = $id;
        $estado->save();

        
        $bitacora = new bitacora;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->accion = "Eliminó registro";
        $bitacora->nombre_usuario = auth()->user()->name;
        $bitacora->id_usuario  = auth()->user()->id;
        $bitacora->id_registrocliente   = $id;
        $bitacora-> save();
    }
}
