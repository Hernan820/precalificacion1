<?php

namespace App\Http\Controllers;

use App\Models\clientes_pre;
use Illuminate\Http\Request;
use App\Events\MensajeEvents;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientesPreController extends Controller
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
    public function create_user(Request $request)
    {
        $usuario= new User;
        $usuario->name     = $request->nombre; 
        $usuario->email    = $request->email;
        $usuario->password = Hash::make($request->contra);
        $usuario->save();
        $usuario->assignRole($request['rol']); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente_precalificacion = new clientes_pre;
        $cliente_precalificacion->nombre_cliente = $request->nombre_cliente;
        $cliente_precalificacion->telefono       = $request->telefonocliente;
        $cliente_precalificacion->estado         = $request->estados_casas;
        $cliente_precalificacion->tipo_trabajo   = $request->tipo_trabajo;
        $cliente_precalificacion->estatus        = $request->status;
        $cliente_precalificacion->hora_precio    = $request->precioporhora ?? '';
       // $cliente_precalificacion->num_hora       = $request->num_horas ?? '';
        $cliente_precalificacion->taxes2021      = $request->taxes2021 ?? '';
        $cliente_precalificacion->taxes2022      = $request->taxes2022 ?? '';
        $cliente_precalificacion->dowpayment     = $request->dowpayment;
        $cliente_precalificacion->comentarios    = $request->informacionextra;
        $cliente_precalificacion->save();

        event(new MensajeEvents($cliente_precalificacion));

        return 1 ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes_pre  $clientes_pre
     * @return \Illuminate\Http\Response
     */
    public function show(clientes_pre $clientes_pre)
    {
        
        $actualfecha = new DateTime();  
        $actualfecha->sub(new DateInterval('P3M'));  
        $fechahacetresmeses = $actualfecha->format('Y-m-d');
        
        $lista_clientes_pre = clientes_pre::select("clientes_pres.*")
        ->where("clientes_pres.created_at",">",$fechahacetresmeses)
        ->get();

        return response()->json($lista_clientes_pre);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clientes_pre  $clientes_pre
     * @return \Illuminate\Http\Response
     */
    public function edit(clientes_pre $clientes_pre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clientes_pre  $clientes_pre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clientes_pre $clientes_pre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clientes_pre  $clientes_pre
     * @return \Illuminate\Http\Response
     */
    public function destroy(clientes_pre $clientes_pre)
    {
        //
    }
}
