<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\empresa;
use App\Models\vivienda;
use App\Models\prestamo;
use App\Models\codeudor;
use Mail;
use Illuminate\Support\Facades\Log;


use Illuminate\Http\Request;

class ClienteController extends Controller
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

        Log::info("informacion del cliente");
        Log::info($request);

        return $request;

        // $vivienda = new vivienda;
        // $vivienda->estado = $request->estado_vivienda;
        // $vivienda->tiempo_compra = $request->tiempo_compra;
        // $vivienda->tipo_vivienda = $request->tipo_vivienda;
        // $vivienda->agente_inmobiliario = $request->agente_inmobiliario;
        // $vivienda->save();

        // $prestamo = new prestamo;
        // $prestamo->tipo_prestamo = $request->tipo_prestamo;
        // $prestamo->calificacion_crediticia = $request->record_credito;
        // $prestamo->ahorro = $request->ahorro;
        // $prestamo->ingreso_hogar = $request->ingreso_hogar;
        // $prestamo->capacidad_mensual = $request->capacidad_mensual;
        // $prestamo->save();

        // $cliente = new  cliente;
        // $cliente->nombre = $request->nombres;
        // $cliente->apellidos = $request->apellidos;
        // $cliente->correo = $request->correo;
        // $cliente->medio_contacto = $request->Medio;	
        // $cliente->telefono = $request->telefono	;
        // $cliente->estatus_laboral = $request->estatus_laboral;
        // $cliente->estatus_social = $request->Estatus_social;
        // $cliente->horario_contacto = $request->horario;
        // $cliente->comentarios = $request->comentarios;

        // $cliente->id_prestamo  = $prestamo->id;
        // $cliente->id_vivienda  = $vivienda->id;


        // $cliente->save();

        $subject = "Calificacion de Prestamo ";
        $for = "hernanbenitezjosuerodriguez06@gmail.com";  //correo que recibira el mensaje 

        // Mail::send('email',$request->all(), function($msj) use($subject,$for){
        //     $msj->from("benitezhernan820@gmail.com","Teams Acevedo");
        //     $msj->subject($subject);
        //     $msj->to($for);
        // });
        

        return 1 ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view("calificacion");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $cliente)
    {
        //
    }
}
