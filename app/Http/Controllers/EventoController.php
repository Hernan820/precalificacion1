<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index($id_forms)
    {
 
        $rows = DB::connection('mysql')
        ->table('wp_wpforms_db as w')
        ->selectRaw("
            w.form_id, w.form_value, w.form_date, w.form_post_id,
            (SELECT COUNT(*) FROM seguimientos s WHERE s.id_fomrscontigo = w.form_id) AS total_seguimiento,
            (SELECT er.estado FROM estadoregistros er 
            WHERE er.id_form = w.form_id 
            ORDER BY er.id DESC LIMIT 1) AS estado
        ")
        ->whereIn('w.form_post_id', [$id_forms])
        ->groupBy('w.form_id')
        ->get();


        $result = $rows->map(function ($row) {
            $data = $this->safeUnserialize($row->form_value);

            if (!is_array($data)) {
            return null; // descarta si no se pudo parsear
            }

            // Normaliza claves/valores por si vienen con \u00e9 escapado
            $data = $this->normalizeUnicodeArray($data);

            // Campos que te interesan
            $nombre   = $data['Nombre'] ?? $data['Name'] ?? null;

            // Teléfono puede llegar con o sin acento, cubrimos ambos
            $telefono = $data['Teléfono'] ?? $data['Telefono'] ?? $data['Phone'] ?? null;

            // El campo de “Texto de una sola línea” trae "ciudad*fecha*hora"
            $textoUnaLinea = $data['Texto de una sola línea'] ?? $data['Texto de una sola l\u00ednea'] ?? $data['date'] ?? null;
            $ciudad = $fecha = $hora = null;
            if (is_string($textoUnaLinea)) {
            [$ciudad, $fecha, $hora] = array_pad(explode('*', $textoUnaLinea), 3, null);
            }

            // Limpieza básica de teléfono (opcional)
            if ($telefono) {
            $telefono = trim(preg_replace('/\s+/', ' ', $telefono));
            }

            return [
            'form_id'           => $row->form_id,
            'nombre'            => $nombre,
            'telefono'          => $telefono,
            'ciudad'            => $ciudad,
            'fecha_evento'      => $fecha,
            'hora_evento'       => $hora,
            'form_date'         => $row->form_date,
            'form_post_id'      => $row->form_post_id,
            'total_seguimiento' => $row->total_seguimiento,
            'estado'            => $row->estado,
            ];
        })->filter()->values();

        // Dejar solo un registro por teléfono (conserva el primero que encuentre)
        // $result = $result->unique('telefono')->values();

        $result = $result
            ->filter(function ($item) {
            return !in_array($item['estado'], [0, '0'], true); // acepta null
            })
            ->unique(function ($item) {
            return preg_replace('/\D+/', '', $item['telefono'] ?? '');
            })
            ->values();

        // Contar registros por estado (incluyendo null/sin estado)
        $estadoCounts = $result->groupBy(function ($item) {
            return $item['estado'] ?? 'sin_estado';
        })->map(function ($items) {
            return count($items);
        });

        // Total de registros
        $totalRegistros = $result->count();
        $estadoCounts['total_registros'] = $totalRegistros;

        return response()->json([
            'data' => $result,
            'estado_counts' => $estadoCounts,
        ]);
    }

    /**
     * Des-serializa de forma segura.
     * - Bloquea clases (security)
     * - Intenta con y sin stripslashes por si el string viene con slashes escapados
     */
    private function safeUnserialize(string $serialized)
    {
        $opts = ['allowed_classes' => false];

        // Primer intento directo
        $data = @unserialize($serialized, $opts);
        if ($data !== false || $serialized === 'b:0;') {
            return $data;
        }

        // Segundo intento por si viene con slashes escapados
        $alt = stripslashes($serialized);
        $data = @unserialize($alt, $opts);
        if ($data !== false || $alt === 'b:0;') {
            return $data;
        }

        return null;
    }

    /**
     * Convierte secuencias \uXXXX a UTF-8 reales tanto en claves como en valores.
     * Útil cuando la serialización trae los acentos como texto escapado.
     */
    private function normalizeUnicodeArray(array $arr): array
    {
        $out = [];
        foreach ($arr as $k => $v) {
            $nk = $this->decodeUnicodeEscapes($k);
            if (is_string($v)) {
                $v = $this->decodeUnicodeEscapes($v);
            }
            $out[$nk] = $v;
        }
        return $out;
    }

    /**
     * Truco: usar json_decode para transformar "\u00e9" -> "é".
     */
    private function decodeUnicodeEscapes(string $str): string
    {
        // Escapa comillas para formar un JSON string válido
        $jsonReady = '"' . str_replace(['\\', '"'], ['\\\\', '\"'], $str) . '"';
        $decoded = json_decode($jsonReady, true);
        return is_string($decoded) ? $decoded : $str;
    }
}
