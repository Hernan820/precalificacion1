<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log;

class clientesContigoController extends Controller
{
  public function index(Request $request)
    {
 
        // Convierte el string de IDs separados por coma a un array de enteros
        $ids = [];
        if (!empty($request->id_formularios)) {
            // Acepta tanto array como string separado por comas
            if (is_array($request->id_formularios)) {
                $ids = array_map('intval', $request->id_formularios);
            } else {
                $ids = array_filter(array_map('intval', explode(',', $request->id_formularios)));
            }
        }

        // Si no hay IDs, puedes asignar un array vacío o un valor por defecto
        if (empty($ids)) {
            $ids = [0]; // O cualquier valor que nunca coincida
        }

        $rows = DB::connection('mysql')
        ->table('wp_wpforms_db as w')
        ->selectRaw("
            w.form_id, w.form_value, w.form_date, w.form_post_id,
            (SELECT COUNT(*) FROM seguimientos s WHERE s.id_fomrscontigo = w.form_id) AS total_seguimiento,
            (SELECT er.estado FROM estadoregistros er 
            WHERE er.id_form = w.form_id 
            ORDER BY er.id DESC LIMIT 1) AS estado
        ")
        ->whereIn('w.form_post_id',$ids)
        ->groupBy('w.form_id')
        ->get();


        $result = $rows->map(function ($row)  {
            $data = $this->safeUnserialize($row->form_value);

            if (!is_array($data)) {
            return null; // descarta si no se pudo parsear
            }

            // Normaliza claves/valores por si vienen con \u00e9 escapado
            $data = $this->normalizeUnicodeArray($data);

            // Campos que te interesan
            $nombre   = $data['Nombre'] ?? $data['Name'] ?? $data['Nombre completo'] ?? null;

            // Teléfono puede llegar con o sin acento, cubrimos ambos
            $telefono = $data['Teléfono'] ?? $data['Telefono'] ?? $data['Phone'] ?? null;

            // Limpieza básica de teléfono (opcional)
            if ($telefono) {
                $telefono = trim(preg_replace('/\s+/', ' ', $telefono));
            }

            // Validar formato exacto: +1 (890)-898-0989
            if (!$telefono || !preg_match('/^\+1 \(\d{3}\)-\d{3}-\d{4}$/', $telefono)) {
                return null; // descarta si no cumple el formato
            }


            // El campo de “Texto de una sola línea” trae "ciudad*fecha*hora"
            $textoUnaLinea = $data['Texto de una sola línea'] ?? $data['Texto de una sola l\u00ednea'] ?? $data['date'] ?? null;
            $ciudad = $fecha = $hora = null;
            if (is_string($textoUnaLinea)) {
            [$ciudad, $fecha, $hora] = array_pad(explode('*', $textoUnaLinea), 3, null);
            }

            $descripcionFormulario = $data['Como podemos ayudarte'] ?? $data['¿Con cuánto de enganche cuentas actualmente? (aproximado)'] ?? $data['Comentario'] ?? $data['Valor estimado de tu propiedad. (aproximado)']  ?? null;


            // Filtro antispam: si la descripción contiene caracteres cirílicos, descarta
            if ($descripcionFormulario && preg_match('/[\p{Cyrillic}]/u', $descripcionFormulario)) {
                return null;
            }

            // Filtro antispam: si la descripción contiene enlaces o palabras típicas de spam, descarta
            // if ($descripcionFormulario && preg_match('/https?:\/\/|www\.|backlink|seo|toxic links|clean up|hilkom|digital|expert/i', $descripcionFormulario)) {

            if ($descripcionFormulario && preg_match('/https?:\/\/|www\.|\b(?:backlink|seo|toxic\s+links|clean\s+up|hilkom|digital|expert)\b/i',$descripcionFormulario)){

                return null;
            }

            // Filtro antispam: si la descripción contiene muchos saltos de línea o patrones sospechosos, descarta
            if ($descripcionFormulario && preg_match('/(\n|\r|\r\n){2,}/', $descripcionFormulario)) {
                return null;
            }

            // Filtro antispam: si la descripción contiene entidades HTML sospechosas (como &#047;), descarta
            if ($descripcionFormulario && preg_match('/&#\d+;/', $descripcionFormulario)) {
                return null;
            }

            // Filtro antispam: si la descripción contiene URLs con caracteres especiales sospechosos, descarta
            if ($descripcionFormulario && preg_match('/https?:\/\/[^\s]*[\p{Cyrillic}\p{Han}\p{Arabic}\p{Hiragana}\p{Katakana}\p{Common}]+/u', $descripcionFormulario)) {
                return null;
            }

            return [
                'form_id'           => $row->form_id,
                'nombre'            => $nombre,
                'telefono'          => $telefono,
                'descripcion'       => $descripcionFormulario,
                'form_date'         => $row->form_date,
                'form_post_id'      => $row->form_post_id,
                'total_seguimiento' => $row->total_seguimiento,
                'estado'            => $row->estado,
            ];
        })->filter()->values();

        // Dejar solo un registro por teléfono (conserva el primero que encuentre)
        // $result = $result->unique('telefono')->values();

        // Separar registros eliminados (estado = 0) y no eliminados (estado != 0)
        $eliminados = $result->filter(function ($item) {
            return in_array($item['estado'], [0, '0'], true);
        })->unique(function ($item) {
            return preg_replace('/\D+/', '', $item['telefono'] ?? '');
        })->values();

        $noEliminados = $result->filter(function ($item) {
            return !in_array($item['estado'], [0, '0'], true);
        })->unique(function ($item) {
            return preg_replace('/\D+/', '', $item['telefono'] ?? '');
        })->values();

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
            'eliminados' => $eliminados,
            'no_eliminados' => $noEliminados,
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
