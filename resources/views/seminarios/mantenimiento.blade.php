@extends('layouts.app')

@section('content')
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

    <div class="table-responsive bg-white p-3">
        <table class="table table-sm table-bordered mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay seminarios para mostrar.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@include('modales.crear-seminario')





@endsection