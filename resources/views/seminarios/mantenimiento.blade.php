@extends('layouts.app')

@section('content')

<link href="{{ asset('css/tabla_seminarios.css') }}" rel="stylesheet" >
<script src="{{ asset('js/seminarios.js?456454') }}" defer></script>

<div class="container-fluid pt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Mantenimiento de seminarios</h1>
            <p class="text-muted mb-0">Administra la información base de los seminarios.</p>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-crear-seminario">
            <i class="fas fa-plus mr-1" aria-hidden="true"></i> Nuevo seminario
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <section class="seminarios-list" aria-label="Listado de seminarios">
        <div class="seminarios-list__toolbar">
            <label class="seminarios-list__search mb-0" for="buscar-seminarios">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input id="buscar-seminarios" type="search" class="form-control"
                    placeholder="Buscar seminarios..." autocomplete="off">
            </label>
            <span class="seminarios-list__count" id="seminarios-count">
                {{ $seminarios->count() }} {{ $seminarios->count() === 1 ? 'seminario' : 'seminarios' }}
            </span>
        </div>

        <div class="seminarios-list__table-wrap">
            <div class="seminarios-list__scroll">
                <table class="table table-hover seminarios-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Seminario</th>
                            <th scope="col">Fecha y hora</th>
                            <th scope="col">Ubicación</th>
                            <th scope="col">Cupos</th>
                            <th scope="col">Formulario</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($seminarios as $seminario)
                            @php
                                $estadoSeminario = strtolower($seminario->estatus ?? 'borrador');
                                $fechaSeminario = \Carbon\Carbon::parse($seminario->fecha)->locale('es');
                                $estaActivo = (bool) ($seminario->activo ?? true);
                                $estadoLabel = !$estaActivo
                                    ? 'Inactivo'
                                    : ($estadoSeminario === 'publicado' ? 'Activo' : ucfirst($estadoSeminario));
                                $estadoClase = !$estaActivo ? 'inactive' : 'draft';
                                if ($estadoSeminario === 'publicado') {
                                    $estadoClase = 'active';
                                } elseif ($estadoSeminario === 'finalizado') {
                                    $estadoClase = 'finished';
                                } elseif ($estadoSeminario === 'cancelado') {
                                    $estadoClase = 'cancelled';
                                }
                                $ciudadEstado = collect([$seminario->ciudad ?? null, $seminario->estado ?? null])
                                    ->filter()
                                    ->implode(', ');
                                $descripcionSeminario = $seminario->descripcion ?: 'Sin descripción';
                                $descripcionEsLarga = \Illuminate\Support\Str::length($descripcionSeminario) > 180;
                                $datosEdicion = [
                                    'id' => $seminario->id,
                                    'titulo' => $seminario->titulo,
                                    'estatus' => $seminario->estatus,
                                    'resumen' => $seminario->resumen,
                                    'descripcion' => $seminario->descripcion,
                                    'fecha' => \Carbon\Carbon::parse($seminario->fecha)->format('Y-m-d'),
                                    'hora_inicio' => \Carbon\Carbon::parse($seminario->hora_inicio)->format('H:i'),
                                    'hora_fin' => $seminario->hora_fin ? \Carbon\Carbon::parse($seminario->hora_fin)->format('H:i') : '',
                                    'registro_hasta' => $seminario->registro_hasta ? \Carbon\Carbon::parse($seminario->registro_hasta)->format('Y-m-d\TH:i') : '',
                                    'lugar' => $seminario->lugar,
                                    'modalidad' => $seminario->modalidad,
                                    'direccion' => $seminario->direccion,
                                    'ciudad' => $seminario->ciudad,
                                    'estado' => $seminario->estado,
                                    'mapa_url' => $seminario->mapa_url,
                                    'cupos' => $seminario->cupos,
                                    'telefono' => $seminario->telefono,
                                    'formulario_id' => $seminario->formulario_id,
                                    'activo' => $estaActivo,
                                ];
                            @endphp
                            <tr class="seminarios-data-row">
                                <td class="seminarios-table__id">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="seminarios-table__name">{{ $seminario->titulo }}</span>
                                    @if (!empty($seminario->modalidad))
                                        <span class="seminarios-table__secondary">{{ ucfirst($seminario->modalidad) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="seminarios-table__name">{{ ucfirst(rtrim($fechaSeminario->translatedFormat('D'), '.')) }}. {{ $fechaSeminario->format('d') }} {{ rtrim($fechaSeminario->translatedFormat('M'), '.') }} {{ $fechaSeminario->format('y') }}</span>
                                    <span class="seminarios-table__secondary">
                                        {{ \Carbon\Carbon::parse($seminario->hora_inicio)->format('g:i A') }}
                                        @if (!empty($seminario->hora_fin))
                                            – {{ \Carbon\Carbon::parse($seminario->hora_fin)->format('g:i A') }} NY
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="seminarios-table__name">{{ $seminario->lugar ?: '—' }}</span>
                                    @if ($ciudadEstado !== '')
                                        <span class="seminarios-table__secondary">{{ $ciudadEstado }}</span>
                                    @endif
                                </td>
                                <td>{{ $seminario->cupos ?? '—' }}</td>
                                <td>
                                    @if (!empty($seminario->formulario_id))
                                        <span class="seminarios-badge seminarios-badge--form">ID: {{ $seminario->formulario_id }}</span>
                                    @else
                                        <span class="seminarios-badge seminarios-badge--pending">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="seminarios-badge seminarios-badge--{{ $estadoClase }}">{{ $estadoLabel }}</span>
                                </td>
                                <td>
                                    <button type="button" class="seminarios-detail-button seminarios-edit-button"
                                        data-seminario="{{ json_encode($datosEdicion) }}"
                                        data-update-url="{{ route('seminarios.update', $seminario->id) }}"
                                        aria-label="Editar {{ $seminario->titulo }}" title="Editar seminario">
                                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="seminarios-detail-button seminarios-toggle-details"
                                        data-target="seminario-detalle-{{ $seminario->id }}" aria-expanded="false"
                                        aria-label="Ver detalles de {{ $seminario->titulo }}" title="Ver detalles">
                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="seminarios-detail-row" id="seminario-detalle-{{ $seminario->id }}" hidden>
                                <td colspan="8">
                                    <div class="seminarios-detail">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <div class="seminarios-detail__item">
                                                    <span class="seminarios-detail__label">Dirección</span>
                                                    {{ $seminario->direccion ?: 'No especificada' }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="seminarios-detail__item">
                                                    <span class="seminarios-detail__label">Teléfono de contacto</span>
                                                    {{ $seminario->telefono ?: 'No especificado' }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="seminarios-detail__item">
                                                    <span class="seminarios-detail__label">Descripción</span>
                                                    <span class="seminarios-detail__description" id="seminario-descripcion-preview-{{ $seminario->id }}">{{ $descripcionEsLarga ? \Illuminate\Support\Str::limit($descripcionSeminario, 180) : $descripcionSeminario }}</span>
                                                    @if ($descripcionEsLarga)
                                                        <span class="seminarios-detail__description" id="seminario-descripcion-full-{{ $seminario->id }}" hidden>{{ $descripcionSeminario }}</span>
                                                        <button type="button" class="seminarios-description-toggle"
                                                            data-preview="seminario-descripcion-preview-{{ $seminario->id }}"
                                                            data-full="seminario-descripcion-full-{{ $seminario->id }}"
                                                            aria-expanded="false">Leer más...</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="seminarios-empty">No hay seminarios para mostrar.</td>
                            </tr>
                        @endforelse
                        <tr id="seminarios-sin-coincidencias" hidden>
                            <td colspan="8" class="seminarios-empty">No se encontraron seminarios con esa búsqueda.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>



@include('modales.crear-seminario')



@endsection
