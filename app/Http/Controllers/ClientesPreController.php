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
use Twilio\Rest\Client;
use App\Models\seguimiento;

use App\Exports\semiExport;
use Maatwebsite\Excel\Facades\Excel;

date_default_timezone_set("America/New_York");

class ClientesPreController extends Controller
{
    // credenciales de Twilio
    public  $sid = "clave_sid";
    public  $token  = "clave_token";
    public  $from= "numbertel";
        
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
        (SELECT COUNT(*) FROM seguimientos WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id   ) as total_seguimiento , 
        estadoregistros.estado
        FROM wp_wpforms_db
        LEFT JOIN seguimientos on seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
        LEFT JOIN estadoregistros on estadoregistros.id_form = wp_wpforms_db.form_id
        GROUP BY wp_wpforms_db.form_id
        ";

        $datosfomr = DB::select($sql);
        return response()->json($datosfomr);
    }
    /**
     * 
     * 
     * 
     */
    public function datosform_seminarios(){
        $sql = "SELECT  wp_wpforms_db.form_id, wp_wpforms_db.form_value, wp_wpforms_db.form_date,wp_wpforms_db.form_post_id,
        (SELECT COUNT(*) FROM seguimientos WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id   ) as total_seguimiento , 
        estadoregistros.estado
        FROM wp_wpforms_db
        LEFT JOIN seguimientos on seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
        LEFT JOIN estadoregistros on estadoregistros.id_form = wp_wpforms_db.form_id
        WHERE wp_wpforms_db.form_post_id IN(1772,1873,1870)
        GROUP BY wp_wpforms_db.form_id
        ";

        $datosfomr = DB::select($sql);

        return response()->json($datosfomr);
    }

    /**
     * 
     * 
     * 
     * 
     */
    public function Envio_campana(Request $request) {

        $sql = "SELECT  wp_wpforms_db.form_id, wp_wpforms_db.form_value, wp_wpforms_db.form_date,wp_wpforms_db.form_post_id,
        (SELECT COUNT(*) FROM seguimientos WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id   ) as total_seguimiento , 
        estadoregistros.estado
        FROM wp_wpforms_db
        LEFT JOIN seguimientos on seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
        LEFT JOIN estadoregistros on estadoregistros.id_form = wp_wpforms_db.form_id
        GROUP BY wp_wpforms_db.form_id";

        $datosfomr = DB::select($sql);

        $frmnuevos = [];

        foreach ($datosfomr as $item) {
            if($item->form_post_id != 919 && $item->form_post_id != 782 && $item->form_post_id != 7){
                if($item->estado == ''){
                $total_seguimientoform = $item->total_seguimiento;
                $date_time = new DateTime($item->form_date);
                $formatted_date = $date_time->format("D d M Y h:i A");
                array_push($frmnuevos, $item->form_value.";fecha:".$formatted_date.";id_forms:".$item->form_id.";total:".$total_seguimientoform.";vacio");
               }
            }
        }

        $datos_limpios = array_map(function($form) {
            $form = substr($form, 6, -1);
            $elements = explode(";", $form);
            $cleanData = [];
        
            foreach ($elements as $element) {
                $keyValue = explode(":", $element);
                $key = trim(trim($keyValue[count($keyValue) - 1]), '"');
        
                if ($key == "Nombre" || $key == "Teléfono" || $key == "estado" || $key == "Comentario") {
                    $formSiguiente = explode(":", $elements[array_search($element, $elements) + 1]);
                    $valor = trim(trim($formSiguiente[count($formSiguiente) - 1]), '"');
                    $cleanData[$key] = $valor;
                } elseif ($keyValue[0] == "fecha" || $keyValue[0] == "total" || $keyValue[0] == "id_forms") {
                    $dato = $keyValue[0];
                    $valor = $keyValue[1];
                    if ($keyValue[1] == '') {
                        $valor = 0;
                    }
                    $cleanData[$dato] = $valor;
                }
            }
        
            return $cleanData;
        }, $frmnuevos);

        $arrayestados = explode(',', $request->estado_citas);

        foreach ($datos_limpios as $cliente) {

            $tel_cliente = "+". preg_replace("/[^0-9]/", "", $cliente['Teléfono']);

            if (in_array($cliente['estado'], $arrayestados)) {
            
            $res_twlio ;

            try {
                $twilio = new Client($this->sid, $this->token);
                $twilio->messages->create($tel_cliente, ['from' => $this->from,'body' => $request->mensajetext,] );

                $res_twlio = "enviado";
            } catch (\Exception $e) {
                Log::error('Error en el envío de mensaje: ' . $e->getMessage());
                $res_twlio = "fallo envio";
            }

            $seguimiento = new seguimiento;
            $seguimiento->seguimiento       = "Se envio informacion por medio de sms <br> sms enviado:".$res_twlio." <br> ". $request->mensajetext ;
            $seguimiento->id_fomrscontigo   = $cliente['id_forms'];
            $seguimiento->id_usuario        = auth()->user()->id;
            $seguimiento->save();

            }
        }

        return 1;
    }
    /**
     * 
     * 
     */
    public function exportseminario($estado) {
        ob_end_clean();
        ob_start();
        return Excel::download(new semiExport($estado), 'seminario - '.$estado.'.xlsx');
    }
}
