@extends('layouts.app')

@section('content')

<link href="{{ asset('css/tabla_seminarios.css') }}" rel="stylesheet" >

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
                                                    {{ $seminario->descripcion ?: 'Sin descripción' }}
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('buscar-seminarios');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.seminarios-data-row'));
        var countLabel = document.getElementById('seminarios-count');
        var noMatches = document.getElementById('seminarios-sin-coincidencias');

        searchInput.addEventListener('input', function () {
            var query = searchInput.value.trim().toLocaleLowerCase();
            var visibleCount = 0;

            rows.forEach(function (row) {
                var detailButton = row.querySelector('.seminarios-toggle-details');
                var details = document.getElementById(detailButton.dataset.target);
                var matches = row.textContent.toLocaleLowerCase().indexOf(query) !== -1;
                row.hidden = !matches;
                details.hidden = true;
                detailButton.setAttribute('aria-expanded', 'false');
                if (matches) {
                    visibleCount++;
                }
            });

            countLabel.textContent = visibleCount + (visibleCount === 1 ? ' seminario' : ' seminarios');
            noMatches.hidden = rows.length === 0 || visibleCount !== 0;
        });

        document.querySelectorAll('.seminarios-toggle-details').forEach(function (button) {
            button.addEventListener('click', function () {
                var details = document.getElementById(button.dataset.target);
                var shouldOpen = details.hidden;

                document.querySelectorAll('.seminarios-detail-row').forEach(function (row) {
                    row.hidden = true;
                });
                document.querySelectorAll('.seminarios-toggle-details').forEach(function (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                });

                details.hidden = !shouldOpen;
                button.setAttribute('aria-expanded', String(shouldOpen));
            });
        });
    });
</script>

@include('modales.crear-seminario')
@endsection
