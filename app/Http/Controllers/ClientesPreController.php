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
use DB;

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
    public function create(Request $request)
    {
        //............
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
        $cliente_precalificacion->estado_registro = 1;
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
        ->where("clientes_pres.estado_registro","=",1)
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
    public function destroy($id)
    {
        $segui = clientes_pre::find($id);
        $segui->estado_registro = 0;
        $segui->save();

    }
    /**
     * 
     * 
     */
    public function datosform(){
        $sql = "SELECT  wp_wpforms_db.form_id, wp_wpforms_db.form_value, wp_wpforms_db.form_date,wp_wpforms_db.form_post_id,
        (SELECT COUNT(*) FROM seguimientos WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id   ) as total_seguimiento 
        FROM wp_wpforms_db
        LEFT JOIN seguimientos on seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
        LEFT JOIN estadoregistros on estadoregistros.id_form = wp_wpforms_db.form_id
        WHERE estadoregistros.id_form IS NULL
        GROUP BY wp_wpforms_db.form_id
        ";

        $datosfomr = DB::select($sql);
        return response()->json($datosfomr);
    }
}
