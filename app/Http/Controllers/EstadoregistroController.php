<?php

namespace App\Http\Controllers;

use App\Models\estadoregistro;
use Illuminate\Http\Request;
use App\Models\bitacora;
use Illuminate\Support\Facades\Log;
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
    public function estadoRegistroForm($id,$estadoreg)
    {
        $mensaje ;
        if ($estadoreg == 0) {
            $mensaje = "Eliminó registro";
        }else if($estadoreg == 4) {
            $mensaje = "Confirmo registro";
        }else if($estadoreg == 5) {
            $mensaje = "No answer registro";
        }else if($estadoreg == 6) {
            $mensaje = "Cancelo registro";
        }

        $registro = estadoregistro::where("estadoregistros.id_form","=",$id)->count();

        if ($registro == 0) {
        $estado = new estadoregistro;
        $estado->estado = $estadoreg;
        $estado->id_form = $id;
        $estado->save();
        }else {
            $estado = estadoregistro::where("estadoregistros.id_form","=",$id)->first();
            $estado->estado = $estadoreg;
            $estado->save();
        }

        $bitacora = new bitacora;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->accion = $mensaje;
        $bitacora->nombre_usuario = auth()->user()->name;
        $bitacora->id_usuario  = auth()->user()->id;
        $bitacora->id_registrocliente   = $id;
        $bitacora-> save();
    }
}
