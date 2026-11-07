<?php

namespace App\Exports;

use App\User;
use DB;
use App\Models\DetalleCupo;
use App\Models\Cupo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\registronotas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class semiExport implements FromView
{
    protected $estado;
    protected $formularioId;
    protected $seminarioSlug;
    protected $seminarioFecha;

    function __construct($estado, $formularioId = null, $seminarioSlug = null, $seminarioFecha = null)
    {
        $this->estado = $estado;
        $this->formularioId = $formularioId;
        $this->seminarioSlug = $seminarioSlug;
        $this->seminarioFecha = $seminarioFecha;
    }

    public function view(): View
    {
        $selectval= $this->estado;

        $condicion = "wp_wpforms_db.form_post_id IN(1772,1873,1870,2851,3561,3565)";
        $bindings = [];

        if ($this->seminarioSlug !== null && $this->seminarioFecha !== null) {
            $slugSerializado = sprintf(
                '%%s:6:"estado";s:%d:"%s";%%',
                strlen($this->seminarioSlug),
                $this->seminarioSlug
            );
            $fechaSerializada = sprintf(
                '%%s:6:"estado";s:%%:"%%%s%%";%%',
                $this->seminarioFecha
            );
            $condicion = "wp_wpforms_db.form_value LIKE ?";
            $bindings = [$fechaSerializada];
            if ($this->formularioId !== null) {
                $condicion = "(wp_wpforms_db.form_value LIKE ?
                    OR (wp_wpforms_db.form_post_id = ?
                        AND wp_wpforms_db.form_value LIKE ?))";
                $bindings = [$fechaSerializada, $this->formularioId, $slugSerializado];
            }
        }

        $sql = "SELECT
        wp_wpforms_db.form_id, 
        wp_wpforms_db.form_value, 
        wp_wpforms_db.form_date, 
        wp_wpforms_db.form_post_id,
        (SELECT COUNT(*) FROM seguimientos WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id) as total_seguimiento, 
        COALESCE(estadoregistros.estado, 1) as estado
        FROM wp_wpforms_db
        LEFT JOIN seguimientos ON seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
        LEFT JOIN estadoregistros ON estadoregistros.id_form = wp_wpforms_db.form_id
        WHERE {$condicion}
        GROUP BY wp_wpforms_db.form_id
        ";

        $seminario = DB::select($sql, $bindings);

        $frmnuevos = [];
            
        foreach ($seminario as $item) {

            if ($item->estado != 0) {
    
                $total_seguimientoform = $item->total_seguimiento;
                $fecha_formateada = Carbon::parse($item->form_date)->format('D d M Y h:i A');
                $frmnuevos[] = "{$item->form_value};fecha:{$fecha_formateada};id_forms:{$item->form_id};total:{$total_seguimientoform};estado_reg:{$item->estado};vacio";
            }
        }

        $seminarioSlug = $this->seminarioSlug;
        $datos_limpios = array_filter(array_map(function ($form) use ($selectval, $seminarioSlug) {

            $form = substr($form, 6, -1);
            $elements = explode(';', $form);
            $cleanData = [];

            $estadofiltro = trim(str_replace('"', '', explode(':', $elements[7])[2]));

            if ($seminarioSlug !== null || $estadofiltro == $selectval) {
                foreach ($elements as $element) {
                    $keyValue = explode(':', $element);
                    $key = trim(str_replace('"', '', end($keyValue)));

                    if (in_array($key, ['Nombre', 'Teléfono', 'estado', 'Comentario'])) {
                        $valor = trim(str_replace('"', '', explode(':', $elements[array_search($element, $elements) + 1])[2]));
                        $cleanData[$key] = $valor;
                    } elseif ($keyValue[0] == 'fecha') {
                        $valor = explode(' ', $keyValue[1]);
                        array_pop($valor);
                        $ordenado = implode(' ', $valor);
                        $cleanData[$keyValue[0]] = $ordenado;
                    } elseif ($keyValue[0] == 'total') {
                        $cleanData[$keyValue[0]] = $keyValue[1] ?: 0;
                    } elseif ($keyValue[0] == 'id_forms') {
                        $cleanData[$keyValue[0]] = $keyValue[1];
                    } elseif ($keyValue[0] == 'estado_reg') {
                        switch ($keyValue[1]) {
                            case '4':
                                $cleanData[$keyValue[0]] = 'Confirmado';
                                break;
                            case '5':
                                $cleanData[$keyValue[0]] = 'No answer';
                                break;
                            case '6':
                                $cleanData[$keyValue[0]] = 'Cancelado';
                                break;
                            default:
                                $cleanData[$keyValue[0]] = 'sin estado';
                        }
                    }
                }
                return $cleanData;
            } else {
                return null;
            }
        }, $frmnuevos));

        return view('Reporte.excelseminario', ['datos_limpios' => array_values($datos_limpios)]);
    }
}