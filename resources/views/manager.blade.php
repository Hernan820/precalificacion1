@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="{{ asset('js/manager_pre.js?v=a12127') }}" defer></script>
<script src="{{ asset('js/permisionUsuario.js?v=a12217') }}" defer></script>

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
        Word-wrap: break-Word !important;
    }

    table {
        table-layout: fixed;
    }

    table td {
        /* word-wrap: break-word !important; */
        /* max-width: 400px !important; */
    }

    table td {
        white-space: normal !important;
    }

    table th {
        white-space: normal !important;
        /* font-size: 0.9em !important ; */
    }
    #tbl_semi_pre_registro td {
        white-space: inherit !important;
    }

    #registro_clientes td{
        white-space: inherit !important; 
    }

    #registro_clientes_eliminados td {
        white-space: inherit !important;
    }

    @media only screen and (max-width: 600px) {
        .table td {
            width: 100px;
        }
    }

    .morecontent {
        display: none !important;
    }

    /* Namespace */
    .chips { 
    --chip-h: 30px;            /* alto consistente */
    --chip-px: .6rem;          /* padding X */
    --chip-gap: .5rem;         /* espacio entre etiqueta y botón */
    --chip-radius: 8px;        /* bordes */
    --chip-font: .875rem;      /* tamaño texto */
    --chip-shadow: inset 0 -1px 0 rgba(0,0,0,.08);

    display: flex;
    flex-wrap: wrap;
    gap: .4rem .5rem;          /* separación entre chips */
    align-items: center;
    font-family: inherit;
    }

    /* Reset suave */
    .chips .chip, .chips .chip * { box-sizing: border-box; }

    /* Chip base */
    .chips .chip{
    display: inline-flex;
    align-items: center;
    gap: var(--chip-gap);
    height: var(--chip-h);
    padding: 0 var(--chip-px);
    border-radius: var(--chip-radius);
    font-size: var(--chip-font);
    font-weight: 600;
    /* line-height: 1; */
    color: #fff;
    box-shadow: var(--chip-shadow);
    max-width: 100%;
    }

    /* Colores */
    .chips .chip_azul  { background: #0d6efd; }
    .chips .chip_verde { background: #2bd500; }  /* un poco más oscuro p/contraste */

    /* Label con elipsis */
    .chips .chip-label{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 20ch; /* ajusta si quieres chips más cortos/largos */
    }

    /* Botones de acción (unificados: X y +) */
    .chips .chip-action{
    all: unset;
    display: inline-grid;
    place-items: center;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: rgba(255,255,255,.28);
    cursor: pointer;
    transition: background .15s ease, transform .06s ease;
    }
    .chips .chip-action:hover        { background: rgba(255,255,255,.4); }
    .chips .chip-action:active       { transform: scale(.95); }

    /* Accesibilidad focus */
    .chips .chip-action:focus-visible{
    outline: 2px solid #fff;
    outline-offset: 2px;
    }

    /* Íconos SVG */
    .chips .chip-action svg{
    width: 12px; height: 12px;
    stroke: #fff; stroke-width: 2.2;
    fill: none;
    }

    /* Estados opcionales */
    .chips .chip.is-disabled{ opacity: .6; pointer-events: none; }

    /* Modo compacto (opcional) */
    .chips.chips--compact{
    --chip-h: 26px;
    --chip-px: .5rem;
    --chip-radius: 6px;
    --chip-font: .8125rem;
    }
</style>
<br>



@if(@Auth::user()->id  == 3)
<div class="container">
    <div class="row">
        <div class="col">
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" onclick="modalPermisoUsuarios()" href="#">Permisos Usuarios</a></li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endif

<br>


<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @if( Auth::user()->hasRole('administrador') || Auth::user()->hasPermissionTo('registro_clientes'))
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                aria-controls="nav-home" aria-selected="true">Registros clientes</a>
        @endif

        @if(@Auth::user()->hasRole('administrador'))

        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
            aria-controls="nav-profile" aria-selected="false">Eliminados</a>
        @endif

        <a class="nav-item nav-link" id="tab-seminarios" data-toggle="tab" href="#nav-seminarios" role="tab"
            aria-controls="nav-seminarios" aria-selected="false">Registros Seminarios</a>

        <a class="nav-item nav-link" id="tab-seminarios-finalizados" data-toggle="tab"
            href="#nav-seminarios-finalizados" role="tab" aria-controls="nav-seminarios-finalizados"
            aria-selected="false">Seminarios Finalizados</a>

        @if(@Auth::user()->hasRole('administrador'))
        <a class="nav-item nav-link" id="tab-seminarios-eliminados" data-toggle="tab" href="#nav-seminarios-eliminado"
            role="tab" aria-controls="nav-seminarios-eliminado" aria-selected="false">Seminarios eliminados</a>

        @endif
        
        <a class="nav-item nav-link" id="tab-semin-pre-registro" data-toggle="tab"
            href="#nav-semin-pre-registro" role="tab" aria-controls="nav-semin-pre-registro"
            aria-selected="false">Seminarios pre-registros</a>

        @if( Auth::user()->hasRole('administrador') || Auth::user()->hasPermissionTo('guia_pdf'))

            <a class="nav-item nav-link" id="tab-registro-pdf" data-toggle="tab"
            href="#nav-registro-pdf" role="tab" aria-controls="nav-registro-pdf"
            aria-selected="false">Registros GUIA PDF</a>
        @endif
        @if( Auth::user()->hasRole('administrador') )
            <a class="nav-item nav-link " id="tab-entre-nosotras" data-toggle="tab" href="#nav-entre-nosotras" role="tab" aria-controls="nav-entre-nosotras"
                aria-selected="false">
                Entre Nosotras
            </a>
        @endif

        @if( Auth::user()->hasRole('administrador') )
            <a class="nav-item nav-link " id="tab-tax-deeds" data-toggle="tab" href="#nav-tax-deeds" role="tab" aria-controls="nav-tax-deeds"
                aria-selected="false">
                TAX DEEDS
            </a>
        @endif

    </div>
</nav>

<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="container-fluid pt-5">
            <div class="col-md-12 table-responsive">
                <table id="registro_clientes"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-">Formulario</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-seminarios" role="tabpanel" aria-labelledby="tab-seminarios">
        <div class="container-fluid pt-2">
            <div class="container" style="max-width: 1440px !important;background: white !important;">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row pt-2 pb-2 pl-2 mt-2 border rounded color-controles">
                            <div class="form-group mb-1 mr-3">
                                <input class="btn btn-primary text-center" id="modalcampanapersonalizada" type="button"
                                    value="Campaña Personalizada">
                            </div>
                            <div class="form-group col-md-2 mb-1 ml-3">
                                <select class="form-control" id="seletc_estados">
                                    <option readonly value="">Seleciona estado</option>
                                </select>
                            </div>
                            <div class="form-group mb-1 ml-auto mr-3">
                                <input class="btn btn-primary text-center float-right" onclick="exportseminarioexcel('vigentes')"
                                    id="btnexcel" type="button" value="Reporte Excel">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-sm border rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Sin estado</th>
                                    <th scope="col">Confirmados</th>
                                    <th scope="col">No answer</th>
                                    <th scope="col">Cancelados</th>
                                    <th scope="col">Total Inscritos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="conteo_seminario">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="registro_clientes_seminarios"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">Total Inscritos</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Ubicación</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-">Resultado</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-seminarios-finalizados" role="tabpanel" aria-labelledby="tab-seminarios-finalizados">
        <div class="container-fluid pt-2">
            <div class="container" style="max-width: 1440px !important;background: white !important;">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row pt-2 pb-2 pl-2 mt-2 border rounded color-controles">

                            <div class="form-group col-md-2 mb-1 ml-3">
                                <select class="form-control" id="seletc_estados_finalizado">
                                    
                                </select>
                            </div>
                            <div class="form-group mb-1 ml-auto mr-3">
                                <input class="btn btn-primary text-center float-right" onclick="exportseminarioexcel('finalizados')"
                                    id="btnexcel" type="button" value="Reporte seminarios finalizados">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-sm border rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Sin estado</th>
                                    <th scope="col">Confirmado</th>
                                    <th scope="col">No answer</th>
                                    <th scope="col">Cancelados</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="conteo_seminario_finalizado">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="tbl_seminarios_finalizados"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Estado</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-">Estado resgistro</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-seminarios-eliminado" role="tabpanel" aria-labelledby="tab-seminarios">
        <div class="container-fluid pt-2">

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="row pt-2 pb-2 pl-2 mt-2 border rounded color-controles">
                        <div class="form-group col-md-2 mb-1 ml-3">
                            <select class="form-control" id="seletc_estados_eliminados">

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="registro_clientes_seminarios_eliminados"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Estado</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="tab-pane fade" id="nav-semin-pre-registro" role="tabpanel" aria-labelledby="tab-semin-pre-registro">
        <div class="container-fluid pt-2">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-sm border rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Sin estado</th>
                                    <th scope="col">Confirmado</th>
                                    <th scope="col">No answer</th>
                                    <th scope="col">Cancelados</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="contador-semi-pre">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="tbl_semi_pre_registro"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center display"
                     cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Estado</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-">Estado resgistro</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    {{-- <tbody scope="row">
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-registro-pdf" role="tabpanel" aria-labelledby="tab-registro-pdf">
        <div class="container-fluid pt-2">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-sm border rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                    <th scope="col">Sin estado</th>
                                    <th scope="col">Confirmado</th>
                                    <th scope="col">No answer</th>
                                    <th scope="col">Cancelados</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="contador-guiapdf">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="tbl_registro_pdf"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center display"
                     cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Estado resgistro</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    {{-- <tbody scope="row">
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="container-fluid pt-5">
            <div class="col-md-12 table-responsive">
                <table id="registro_clientes_eliminados"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Comentario</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-entre-nosotras" role="tabpanel" aria-labelledby="nav-entre-nosotras">
        <div class="container-fluid pt-5">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table id="tbl_estados_entrenosotras" class="table table-sm border border-dark rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 table-responsive">
                <table id="tbl_evento_entre_nosotras"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Cuidad</th>
                            <th class="col-md-">estado</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="nav-tax-deeds" role="tabpanel" aria-labelledby="nav-tax-deeds">
        <div class="container-fluid pt-5">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <table id="tbl_estados_tax" class="table table-sm border border-dark rounded mb-1" style="background: white !important;">
                            <thead>
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-md-12 table-responsive">
                <table id="tbl_evento_tax_deeds"
                    class="table table-sm table-striped table-bordered dt-responsive nowrap datatable text-center"
                    class="display" cellspacing="0" cellpadding="3" width="100%"
                    style="background-color: ;color: black;">
                    <thead>
                        <tr>
                            <th class="col-md-">#</th>
                            <th class="col-md-">Fechas</th>
                            <th class="col-md-">Nombre Cliente</th>
                            <th class="col-md-">Numero Telefono</th>
                            <th class="col-md-">Cuidad</th>
                            <th class="col-md-">estado</th>
                            <th class="col-md-"></th>
                            <th class="col-md-"> Opciones</th>
                        </tr>
                    </thead>
                    <tbody scope="row">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Notas-->
<div class="modal fade" id="modal_seguimiento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
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
                        <textarea name="txtseguimiento" rows="2" required="" id="txtseguimiento" class="form-control"
                            cols="50"></textarea>
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
                                    <th scope="col-3">Fecha Hora NY</th>
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

<!-- Modal   bitacoras -->
<div class="modal fade" id="modal_bitacora_fmr" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    BITACORAS
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="idbitacora">

                    {!! csrf_field() !!}
                    <div class="table-responsive">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora NY</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="lista_bitacora" scope="row">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Permisos -->
<div class="modal fade" id="modal-permiso-usuarios" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header ">
                <h5 class="modal-title">
                    Permisos de usuarios
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                            
                {{-- <form  
                    action="{{route('asiganar.permiso.usuario')}}" 
                    class='border border-info rounded p-3 d-none' id="frmPermisoUsuarios">

                    {!! csrf_field() !!}
                    
                    
                    <div class="form-group">
                      <label for="selectUsuariosAsignado">Asiganacion de usuario</label>
                      <select class="form-control" id="selectUsuariosAsignado" name="selectUsuariosAsignado">
                          <option value="" disabled selected>Selecciona un usuario</option>
                          @foreach ($usuarios_permiso as $usuario)
                            @if ($usuario->permiso_cliente == 0 && $usuario->permiso_guipdf == 0)
                              <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endif
                          @endforeach
                      </select>
                      <div class="invalid-feedback">
                        Seleccione el usuario para asiganar permiso.
                      </div>
                    </div>

                    <div class="form-group my-3" id="permisos_usuarios">
                            <label><strong>Permisos a asignar:</strong></label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="perm_gestion" name="permisos_usuarios[]" value="gestion">
                                <label class="form-check-label" for="perm_gestion">Registros guia pdf</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="perm_creador" name="permisos_usuarios[]" value="creador">
                                <label class="form-check-label" for="perm_creador">Registros clientes</label>
                            </div>
                        <div class="invalid-feedback " id="checkboxGroupError" style="display: none;">
                            Debes seleccionar al menos un permiso.
                        </div>
                     </div>


                    <button type="submit" class="btn btn-primary text-white" >Asignar permiso</button>
                </form>  --}}
                
                <br>

                <div class="table-responsive">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-sm ">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 125px;" >Usuarios</th>
                                    <th scope="col" style="width: 125px;" class="text-center" >Permisos asignados</th>
                                    <th scope="col" style="width: 125px;" class="text-center" >Permisos disponibles</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyUserPermiso" >

                              @foreach ($usuarios_permiso as $usuario)

                                <tr class="">
                                    <td>{{ $usuario->nombre_usuario }}</td>

                                    <td>
                                        <div class="chips">
                                            @php
                                            $asignados = collect(explode(',', (string)($usuario->permisos_asignados ?? '')))
                                                ->filter() // quita vacíos
                                                ->map(function ($s) {
                                                [$id, $name] = array_pad(explode('|', trim($s), 2), 2, null);
                                                return (object)['id' => $id, 'name' => $name];
                                                });
                                            @endphp
                                            @foreach ($asignados as $p)
                                                @if ($p->id !== null && $p->name !== null)
                                                    <span class="chip chip_azul" data-id="{{ $p->id }}">
                                                        <span class="chip-label">{{ $p->name }}</span>
                                                        <button type="button"
                                                                class="chip-action chip-x"
                                                                aria-label="Eliminar {{ $p->name }}"
                                                                data-id="{{ $p->id }}">
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M6 6l12 12M18 6L6 18"/>
                                                        </svg>
                                                        </button>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>

                                    <td>
                                        <div class="chips">
                                            @php
                                            $asignados = collect(explode(',', (string)($usuario->permisos_no_asignados ?? '')))
                                                ->filter() // quita vacíos
                                                ->map(function ($s) {
                                                [$id, $name] = array_pad(explode('|', trim($s), 2), 2, null);
                                                return (object)['id' => $id, 'name' => $name];
                                                });
                                            @endphp
                                            @foreach ($asignados as $p)
                                                @if ($p->id !== null && $p->name !== null)
                                                    <span class="chip chip_verde" data-id="{{ $p->id }}">
                                                        <span class="chip-label">{{ $p->name }}</span>
                                                        <button type="button"
                                                                class="chip-action chip-add"
                                                                aria-label="Agregar {{ $p->name }}"
                                                                data-id="{{ $p->id }}">
                                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 5v14M5 12h14"/>
                                                        </svg>
                                                        </button>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal CAMPÀNA DE MENSAJE-->
<div class="modal fade" id="modal_campana_perso" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Campaña Personalizada
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frmmensaje">

                    {!! csrf_field() !!}

                    <div class="form-group ">
                        <div class="row pl-2 pr-2">
                            <div class="col-md-12 border border-primary rounded">
                                <p class="mb-0"> Ten en cuenta que la campaña será enviada únicamente a los clientes
                                    listados en la tabla y
                                    que se encuentren en los estados que selecciones.
                                    Los clientes que hayan sido eliminados no recibirán la campaña. </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="row pl-2 pr-2">
                            <div class="col-md-12 border border-danger rounded text-center">
                                <p class="mb-0"> <span class="text-danger" >ⓘ  </span> Las campañas están inhabilitadas por el momento. </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="start">Agrega mensaje personalizado:</label>
                        <textarea name="txtmensaje_per" rows="5" required="" id="txtmensaje_per" class="form-control"
                            cols="75"></textarea>
                    </div>
                    <div class="text-">
                        <div class="form-check mr-5">
                            <input class="form-check-input estados_citas" type="checkbox" value="new_york"
                                name="seminario_ny" id="seminario_ny">
                            <label class="form-check-label" for="seminario_ny">
                                Seminario New york
                            </label>
                        </div>
                        <div class="form-check mr-5">
                            <input class="form-check-input estados_citas" type="checkbox" value="new_jersey"
                                name="seminario_nj" id="seminario_nj">
                            <label class="form-check-label" for="seminario_nj">
                                Seminario New Jersey
                            </label>
                        </div>
                        <div class="form-check mr-5">
                            <input class="form-check-input estados_citas" type="checkbox" value="connecticut"
                                name="seminario_ct" id="seminario_ct">
                            <label class="form-check-label" for="seminario_ct">
                                Seminario Connecticut
                            </label>
                        </div>
                        <div class="form-check mr-5">
                            <input class="form-check-input estados_citas" type="checkbox" value="pensilvania"
                                name="seminario_pa" id="seminario_pa">
                            <label class="form-check-label" for="seminario_pa">
                                Seminario Pensilvania
                            </label>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" disabled id="btncampana_personalizad">Enviar compaña</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

@endsection