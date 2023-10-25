
@extends('layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="{{ asset('js/manager_pre.js') }}" defer></script>

<div class="container pt-5">
    <div class="col-md-12 table-responsive">
        <table id="registro_clientes"
            class="table table-striped table-bordered dt-responsive nowrap datatable text-center table-sm" class="display"
            cellspacing="0" cellpadding="3" width="100%" style="background-color: ;color: black;">
            <thead>
                <tr>
                    <th class="col-md-">Nombre Cliente</th>
                    <th class="col-md-">Numero Telefono</th>
                    <th class="col-md-">Estado Elegido</th>
                    <th class="col-md-"> Estatus</th>
                    <th class="col-md-"> Tipo Empleo</th>
                    <th class="col-md-"> Precio por Hora</th>
                    <th class="col-md-"> Cantidad Horas</th>
                    <th class="col-md-"> Taxes 2022</th>
                    <th class="col-md-">Taxes 2023</th>
                    <th class="col-md-"> Down Payment</th>
                    <th class="col-md-"> Comentario</th>
                </tr>
            </thead>
            <tbody id="insertadatoshoras" scope="row">
            </tbody>
        </table>
    </div>
</div>

@endsection