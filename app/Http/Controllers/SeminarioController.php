<?php

namespace App\Http\Controllers;

use App\Models\Seminario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeminarioController extends Controller
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
        $slugBase = Str::slug((string) $request->input('titulo'));
        $slug = $slugBase;
        $suffix = 2;

        while (Seminario::where('slug', $slug)->exists()) {
            $suffixText = '-' . $suffix++;
            $slug = Str::limit($slugBase, 255 - strlen($suffixText), '') . $suffixText;
        }

        $request->merge([
            'slug' => $slug,
        ]);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
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

        while (Seminario::where('slug', $slug)->where('id', '!=', $seminario->id)->exists()) {
            $suffixText = '-' . $suffix++;
            $slug = Str::limit($slugBase, 255 - strlen($suffixText), '') . $suffixText;
        }

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
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
    public function destroy(Seminario $seminario)
    {
        //
    }
}
