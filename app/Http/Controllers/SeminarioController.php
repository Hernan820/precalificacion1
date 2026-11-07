<?php

namespace App\Http\Controllers;

use App\Models\Seminario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\semiExport;

class SeminarioController extends Controller
{
    private const TIMEZONE_SEMINARIOS = 'America/New_York';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function disponibles()
    {
        return Seminario::query()
            ->withTrashed()
            ->where('activo', true)
            ->where('estatus', 'publicado')
            ->whereDate('fecha', '>=', Carbon::today(self::TIMEZONE_SEMINARIOS))
            ->where(function ($query) {
                $query->whereNull('seminarios.deleted_at')
                    ->orWhereExists(function ($registros) {
                        $registros->selectRaw('1')
                            ->from('wp_wpforms_db as wpforms')
                            ->where(function ($coincidencias) {
                                $coincidencias
                                    ->where(function ($slug) {
                                        $slug->whereColumn(
                                            'wpforms.form_post_id',
                                            'seminarios.formulario_id'
                                        )->whereRaw(
                                                "wpforms.form_value LIKE (CONCAT('%s:6:\"estado\";s:%:\"', seminarios.slug COLLATE utf8mb4_unicode_520_ci, '\";%') COLLATE utf8mb4_unicode_520_ci)"
                                        );
                                    })
                                    ->orWhereRaw(
                                            "wpforms.form_value LIKE (CONCAT('%s:6:\"estado\";s:%:\"%', DATE_FORMAT(seminarios.fecha, '%Y-%m-%d') COLLATE utf8mb4_unicode_520_ci, '%\";%') COLLATE utf8mb4_unicode_520_ci)"
                                    );
                            });
                    });
            })
            ->orderBy('fecha')
            ->get(['id', 'titulo', 'fecha', 'formulario_id', 'deleted_at']);
    }

    public function registros($seminarioId)
    {
        $seminario = Seminario::withTrashed()->findOrFail($seminarioId);
        $this->asegurarSeminarioDisponible($seminario);

        $slugSerializado = sprintf(
            '%%s:6:"estado";s:%d:"%s";%%',
            strlen($seminario->slug),
            $seminario->slug
        );
        $fechaSerializada = sprintf(
            '%%s:6:"estado";s:%%:"%%%s%%";%%',
            $seminario->fecha->format('Y-m-d')
        );

        $sql = "SELECT wp_wpforms_db.form_id, wp_wpforms_db.form_value, wp_wpforms_db.form_date,
            wp_wpforms_db.form_post_id,
            (SELECT COUNT(*) FROM seguimientos
                WHERE seguimientos.id_fomrscontigo = wp_wpforms_db.form_id) as total_seguimiento,
            estadoregistros.estado
            FROM wp_wpforms_db
            LEFT JOIN seguimientos
                ON seguimientos.id_fomrscontigo = wp_wpforms_db.form_id
            LEFT JOIN estadoregistros
                ON estadoregistros.id_form = wp_wpforms_db.form_id
            WHERE wp_wpforms_db.form_value LIKE ?";

        $bindings = [$fechaSerializada];
        if ($seminario->formulario_id) {
            $sql .= " OR (wp_wpforms_db.form_post_id = ?
                AND wp_wpforms_db.form_value LIKE ?)";
            $bindings[] = $seminario->formulario_id;
            $bindings[] = $slugSerializado;
        }

        $sql .= "
            GROUP BY wp_wpforms_db.form_id";

        return response()->json(DB::select($sql, $bindings));
    }

    public function exportarRegistros($seminarioId)
    {
        $seminario = Seminario::withTrashed()->findOrFail($seminarioId);
        $this->asegurarSeminarioDisponible($seminario);

        return Excel::download(
            new semiExport(
                null,
                $seminario->formulario_id,
                $seminario->slug,
                $seminario->fecha->format('Y-m-d')
            ),
            'registros-' . $seminario->slug . '.xlsx'
        );
    }

    private function asegurarSeminarioDisponible(Seminario $seminario)
    {
        abort_unless(
            $seminario->activo
                && $seminario->estatus === 'publicado'
                && $seminario->fecha->toDateString() >= Carbon::today(self::TIMEZONE_SEMINARIOS)->toDateString(),
            404
        );
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
        $slugBase = Str::slug((string) $request->input('titulo'));
        $slug = $slugBase;
        $suffix = 2;

        while (Seminario::withTrashed()->where('slug', $slug)->exists()) {
            $suffixText = '-' . $suffix++;
            $slug = Str::limit($slugBase, 255 - strlen($suffixText), '') . $suffixText;
        }

        $request->merge([
            'slug' => $slug,
        ]);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'tipo_seminario' => ['required', 'in:primeros-compradores,inversion'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:seminarios,slug'],
            'resumen' => ['nullable', 'string', 'max:500'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'formulario_id' => ['nullable', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'registro_hasta' => ['required', 'date_format:Y-m-d\\TH:i'],
            'lugar' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:500'],
            'ciudad' => ['required', 'string', 'max:150'],
            'estado' => ['required', 'string', 'max:150'],
            'mapa_url' => ['nullable', 'url', 'max:500'],
            'modalidad' => ['required', 'in:presencial,virtual,hibrida'],
            'cupos' => ['required', 'integer', 'min:1'],
            // 'tipo_registro' => ['required', 'in:ambos,cliente,codeudor'],
            'telefono' => ['required', 'string', 'regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'estatus' => ['required', 'in:borrador,publicado,finalizado,cancelado'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'slug.unique' => 'No se pudo generar un identificador único para el seminario. Intenta nuevamente.',
            'telefono.regex' => 'Ingresa un teléfono completo con el formato +1 (123) 456-7890.',
        ]);

        if (!empty($datos['registro_hasta'])) {
            $datos['registro_hasta'] = Carbon::createFromFormat(
                'Y-m-d\\TH:i',
                $datos['registro_hasta']
            );
        }

        $datos['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('seminarios', 'public');
        }

        Seminario::create($datos);

        return redirect()
            ->route('seminarios.mantenimiento')
            ->with('success', 'El seminario se creó correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seminario  $seminario
     * @return \Illuminate\Http\Response
     */
    public function show(Seminario $seminario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seminario  $seminario
     * @return \Illuminate\Http\Response
     */
    public function edit(Seminario $seminario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seminario  $seminario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seminario $seminario)
    {
        $slugBase = Str::slug((string) $request->input('titulo'));
        $slug = $slugBase;
        $suffix = 2;

        while (Seminario::withTrashed()->where('slug', $slug)->where('id', '!=', $seminario->id)->exists()) {
            $suffixText = '-' . $suffix++;
            $slug = Str::limit($slugBase, 255 - strlen($suffixText), '') . $suffixText;
        }

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'tipo_seminario' => ['required', 'in:primeros-compradores,inversion'],
            'resumen' => ['nullable', 'string', 'max:500'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            'formulario_id' => ['nullable', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'registro_hasta' => ['required', 'date_format:Y-m-d\\TH:i'],
            'lugar' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:500'],
            'ciudad' => ['required', 'string', 'max:150'],
            'estado' => ['required', 'string', 'max:150'],
            'mapa_url' => ['nullable', 'url', 'max:500'],
            'modalidad' => ['required', 'in:presencial,virtual,hibrida'],
            'cupos' => ['required', 'integer', 'min:1'],
            'telefono' => ['required', 'string', 'regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'estatus' => ['required', 'in:borrador,publicado,finalizado,cancelado'],
            'activo' => ['nullable', 'boolean'],
        ], [
            'telefono.regex' => 'Ingresa un teléfono completo con el formato +1 (123) 456-7890.',
        ]);

        $datos['slug'] = $slug;
        $datos['registro_hasta'] = Carbon::createFromFormat(
            'Y-m-d\\TH:i',
            $datos['registro_hasta']
        );
        $datos['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('seminarios', 'public');
        }

        $seminario->update($datos);

        return redirect()
            ->route('seminarios.mantenimiento')
            ->with('success', 'El seminario se actualizó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seminario  $seminario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Seminario $seminario)
    {
        $datos = $request->validate([
            'justificacion_eliminacion' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($seminario, $datos) {
            $seminario->justificacion_eliminacion = $datos['justificacion_eliminacion'];
            $seminario->save();
            $seminario->delete();
        });

        return redirect()
            ->route('seminarios.mantenimiento')
            ->with('success', 'El seminario se eliminó correctamente.');
    }
}
