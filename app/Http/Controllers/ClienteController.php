<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\empresa;
use App\Models\vivienda;
use App\Models\prestamo;
use App\Models\codeudor;
use Mail;


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
        if($request->codeudor == "NO"){

            $empresa = new empresa;
            $empresa->tiempo_empresa = $request->tiempo_empresa;
            $empresa->tamaño_trabajores_planilla = $request->tamaño_empresa;
            $empresa->save();

            $cliente = new  cliente;
            $cliente->nombre = $request->nombre;
            $cliente->apellidos = $request->apellidos;
            $cliente->correo = $request->correo;
            $cliente->N_dui = $request->num_dui;	
            $cliente->telefono = $request->telefono	;
            $cliente->edad = $request->correo;
            $cliente->estatus_laborar = $request->estatus_laboral;
            $cliente->tiempo_trabajo = $request->tiempo_laborar;
            $cliente->politico = $request->politico;
            $cliente->ingresos = $request->ingresos;
            $cliente->codeudor = $request->codeudor;
           // $cliente->viven_juntos = $request->;
            $cliente->id_empresa = $empresa->id ;
            $cliente->save();

            $vivienda = new vivienda;
            $vivienda->identificada =$request->identificada;
            $vivienda->estado = $request->estado;
            $vivienda->destino = $request->destino_vivienda;
            $vivienda->save();

            $prestamo = new prestamo;
            $prestamo->tipo_prestamo = $request->tipo_prestamo;
            $prestamo->cantidad = $request->rango_prestamo;
           // $prestamo->garantia = $request->
            $prestamo->id_cliente =   $cliente->id;
            $prestamo->id_vivienda =  $vivienda->id;
            $prestamo->save();


           $subject = "calificacion de prestamo ";
            $for = $request->correo;
    
            Mail::send('email',$request->all(), function($msj) use($subject,$for){
                $msj->from("benitezhernan820@gmail.com","Teams Acevedo otro mensaje");
                $msj->subject($subject);
                $msj->to($for);
            });

            return 1;

            }else if($request->codeudor == "SI"){
            $empresa = new empresa;
            $empresa->tiempo_empresa = $request->tiempo_empresa;
            $empresa->tamaño_trabajores_planilla = $request->tamaño_empresa;
            $empresa->save();

            $codeudor = new codeudor;
            $codeudor->parentesco = $request->parentesco;
            $codeudor->estatus_laraboral = $request->estatus_laboral_codeudor;	
            $codeudor->tiempo_trabajo = $request->tiempo_laboral_codeudor;
            $codeudor->politico = $request->politico_codeudor;
            $codeudor->ingresos = $request->ingresos_codeudor;
            $codeudor->id_empresa = $empresa->id;
            $codeudor->save();

            $empresa = new empresa;
            $empresa->tiempo_empresa = $request->tiempo_empresa;
            $empresa->tamaño_trabajores_planilla = $request->tamaño_empresa;
            $empresa->save();

            $cliente = new  cliente;
            $cliente->nombre = $request->nombre;
            $cliente->apellidos = $request->apellidos;
            $cliente->correo = $request->correo;
            $cliente->N_dui = $request->num_dui;	
            $cliente->telefono = $request->telefono	;
            $cliente->edad = $request->correo;
            $cliente->estatus_laborar = $request->estatus_laboral;
            $cliente->tiempo_trabajo = $request->tiempo_laborar;
            $cliente->politico = $request->politico;
            $cliente->ingresos = $request->ingresos;
            $cliente->codeudor = $request->codeudor;
            $cliente->viven_juntos = $request->coexistir;
            $cliente->id_empresa = $empresa->id ;
            $cliente->save();

            $vivienda = new vivienda;
            $vivienda->identificada =$request->identificada;
            $vivienda->estado = $request->estado;
            $vivienda->destino = $request->destino_vivienda;
            $vivienda->save();

            $prestamo = new prestamo;
            $prestamo->tipo_prestamo = $request->tipo_prestamo;
            $prestamo->cantidad = $request->rango_prestamo;
           // $prestamo->garantia = $request->
            $prestamo->id_cliente =   $cliente->id;
            $prestamo->id_vivienda =  $vivienda->id;
            $prestamo->save();

            $subject = "calificacion de prestamo ";
            $for = $request->correo;
    
            Mail::send('email',$request->all(), function($msj) use($subject,$for){
                $msj->from("benitezhernan820@gmail.com","Teams Acevedo");
                $msj->subject($subject);
                $msj->to($for);
            });

            return 1;
        }
        //return view("calificacion");

        return 2 ;
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
