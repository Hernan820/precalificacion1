@extends('layouts.app')
@section('content')
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/proceso.js') }}" defer></script>

<style>
.sidebar {
    /*  max-width: 100px !important;*/
}

.main-content {
    padding-top: 1px !important;
    min-height: 100vh;
}
</style>
<!-- MAIN CONTENT-->
<div class="container">
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">

                        </div>
                    </div>
                </div>
                <center>
                    <h1>Bienvenidos al precalificador de Team Acevedo </h1>
                </center>
                <br><br>
                <center>
                    <h3>En unos momentos podremos ayudarte con tu sueño de tener vivienda o consolidar tus deudas.
                        En 3 sencillos pasos, determinaremos si calificas para un préstamo hipotecario.</h3>
                </center>
                <br><br><br>
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tipo de vivienda</h5>
                                    <p class="card-text">Define que tipo de vivienda quieres o estas buscando con nosotros. <br></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tu informacion personal</h5>
                                    <p class="card-text">Queremos conocerte mejor, cuéntanos de tí y tus datos personales. <br></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tu informacion crediticia</h5>
                                    <p class="card-text">Tu informacion, record creticio, ingresos, tus ahorros, etc...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br>
                <center> <button type="button" onclick="inicioproceso()" id="botonvista" class="btn btn-success">iniciar
                        precalificacion</button> </center>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection