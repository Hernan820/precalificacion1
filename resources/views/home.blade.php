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
                    <h1>¡Obtén tu pre-calificación en tan solo minutos!</h1>
                </center>
                <br>
                <center>
                    <h3>Completa los datos siguientes con tu información.</h3>
                </center>
                <br>
                <hr>
                <center>
                    <h4>En los campos siguientes de proporcionar tu información para poder hacer los cálculos de tu pre aprobación</h4>

                </center>
                <br>
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cual es ttu nombre?</h5>
                                    <p class="card-text">Define que tipo de vivienda quieres o estas buscando con nosotros. <br></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tu información personal</h5>
                                    <p class="card-text">Con tu información personal sera más facil brindarte un mejor servicio. <br></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tu información crediticia</h5>
                                    <p class="card-text">Tu información, record creticio, ingresos,down payment, etc...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br>
                <center> <button type="button" onclick="inicioproceso()" id="botonvista" class="btn btn-success">iniciar
                precalificación</button> </center>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection