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
        $request->merge([
            'slug' => Str::slug((string) $request->input('slug')),
        ]);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:seminarios,slug'],
            'resumen' => ['nullable', 'string', 'max:500'],
            'descripcion' => ['nullable', 'string'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['nullable', 'date_format:H:i', 'after:hora_inicio'],
            'registro_hasta' => ['nullable', 'date_format:Y-m-d\\TH:i'],
            'lugar' => ['required', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'ciudad' => ['nullable', 'string', 'max:150'],
            'estado' => ['nullable', 'string', 'max:150'],
            'mapa_url' => ['nullable', 'url', 'max:500'],
            'modalidad' => ['required', 'in:presencial,virtual,hibrida'],
            'cupos' => ['nullable', 'integer', 'min:1'],
            'tipo_registro' => ['required', 'in:ambos,cliente,codeudor'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'estatus' => ['required', 'in:borrador,publicado,finalizado,cancelado'],
            'activo' => ['nullable', 'boolean'],
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
        //
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
