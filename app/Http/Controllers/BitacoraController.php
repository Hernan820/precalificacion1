<?php

namespace App\Http\Controllers;

use App\Models\bitacora;
use Illuminate\Http\Request;
date_default_timezone_set("America/New_York");

class BitacoraController extends Controller
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
     * @param  \App\Models\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bitacora = bitacora::join("users","users.id","=","bitacoras.id_usuario")
                    ->where("bitacoras.id_registrocliente","=",$id)
                    ->get();

      return $bitacora ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function edit(bitacora $bitacora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bitacora $bitacora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bitacora  $bitacora
     * @return \Illuminate\Http\Response
     */
    public function destroy(bitacora $bitacora)
    {
        //
    }
}
