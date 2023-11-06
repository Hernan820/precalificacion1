@extends('layouts.app')
@section('content')
<script src="{{ asset('js/proceso.js') }}" defer></script>

<style>
.main-content {
    padding-top: 1px !important;
    min-height: 100vh;
}

#intro {
    background-image: linear-gradient(rgba(5,7,12,0.50),rgba(5,7,12,0.50)), url("{{ asset('images/carpenter1.jpg')}}") ;
    background-repeat: no-repeat;
    background-position: center top;
    height: 350px;
    background-size: cover;
}

@media (max-width: 768px) {
    #intro {
        background-image: linear-gradient(rgba(5,7,12,0.70),rgba(5,7,12,0.70)), url("{{ asset('images/carpenter1.jpg')}}") ;
        background-repeat: no-repeat;
        background-position: center top;
        height: 300px;
        background-size: cover;
    }
}

.col-sm-3 .card img {
        width: 150px; 
        height: 150px; 

    }

@media (max-width: 768px) {

    .col-sm-3 {
        display: flex;
        justify-content: center;
    }
    .col-sm-3 .card {
        width: 160px; 
        height: 200px; 
    }

    .col-sm-3 .card img {
        width: 90px; 
        height: 90px;
    }

    .col-sm-3 .card .card-title,
    .col-sm-3 .card .card-text {
        font-size: 9px; 
    }

    .card{
        margin-bottom: 8px;
    }
}
</style>
    <!--========================================================== -->
                        <!-- INTRODUCCION DE SERVICIOS-->
    <!--========================================================== -->


    <section class="d-flex flex-column justify-content-center align-items-center pt-5  text-center" id="intro" >
        <h1  class="p-3 fs-2  text-white" style="font-size: 30px;" > <span class="text-white">Contigo Mortgage</span>  </h1>
        <h1 class="p-3 fs-2 border-top border-3 text-white" style="font-size: 30px;">¡Obtén tu pre-calificación en tan solo minutos! </h1>
         <p class="p-3  fs-4">
         </p>   
    </section>
    
<!-- MAIN CONTENT-->
<div class="container" style="margin-bottom: 1%;">
    <div class="main-">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap"></div>
                    </div>
                </div>
                <br>
                <center> <button type="button" onclick="inicioproceso()" id="botonvista" class="btn btn-primary">Iniciar precalificación</button> </center>
                <br>
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/archivo.png')}}" class="card-img-top mx-auto"  alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Programas </h5>
                                    <p class="card-text">Especiales sin verificación de ingresos, down payment desde 20%. </p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/tipo-casa.png')}}" class="card-img-top mx-auto"  alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Comprar, reparar y vender.</h5>
                                    <p class="card-text"> Aplica con tan solo 10% Down Payment, no requiere que tengas una LLC. <br></p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/tienda.png')}}" class="card-img-top mx-auto"  alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Prestamos comerciales</h5>
                                    <p class="card-text">Compra una propiedad comercial o de uso mixto fácil y rápido<br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
            </div>
        </div>
    </div>
</div>

<!-- END MAIN CONTENT-->

@endsection