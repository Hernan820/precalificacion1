
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="{{ asset('js/manager_pre.js?v=abcdefg121387') }}" defer></script>

@if(@Auth::user()->hasRole('administrador'))
<input type="hidden" name="rol" id="rol" value="administrador" />
@elseif (@Auth::user()->hasRole('usuario'))
<input type="hidden" name="rol" id="rol" value="usuario" />
@endif

<style>
    table.dataTable tbody td {
    padding: 3px 5px !important;
}


.datatable {
        Word-wrap: break-Word;
    }

    table {
        table-layout: fixed;
    }

    table td {
        word-wrap: break-word;
        max-width: 400px;
    }

    #registro_clientes td {
        white-space: inherit;
    }

    @media only screen and (max-width: 600px) {
    .table td {
        width: 100px;
    }
}

    .morecontent {
        display: none;
    }
</style>

<div class="container-fluid pt-5">
    <div class="col-md-12 table-responsive">
        <table id="registro_clientes"
            class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center" class="display"
            cellspacing="0" cellpadding="3" width="100%" style="background-color: ;color: black;">
            <thead>
                <tr>
                    <th class="col-md-">Fechas</th>
                    <th class="col-md-">Nombre Cliente</th>
                    <th class="col-md-">Numero Telefono</th>
                    <th class="col-md-">Comentario</th>
                    <th class="col-md-"></th>

                    <th class="col-md-"> Opciones</th>

                </tr>
            </thead>
            <tbody  scope="row">
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Notas-->
<div class="modal fade" id="modal_seguimiento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Agregar Seguimiento
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frmseguimiento">

                    {!! csrf_field() !!}
                    <div class="form-group ">
                        <label for="start">Seguimiento:</label>
                        <textarea name="txtseguimiento" rows="2" required="" id="txtseguimiento" class="form-control" cols="50"></textarea>
                    </div>
                    <input type="hidden" name="registropre_id" id="registropre_id" value="" />
                    
                <button type="button" class="btn btn-success" id="btnseguimiento">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
            <div class="modal-footer">
                <div class="table-responsive">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col-3">Usuario</th>
                                    <th scope="col-3">fecha</th>
                                    <th scope="col-6">Seguimiento</th>
                                </tr>
                            </thead>
                            <tbody id="tblseguimientos" scope="row">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

@endsection