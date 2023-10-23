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

#intro {
    background-image: linear-gradient(rgba(5,7,12,0.50),rgba(5,7,12,0.50)), url("{{ asset('images/carpenter1.jpg')}}") ;
    background-repeat: no-repeat;
    background-position: center top;
    height: 500px;
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

</style>
    <!--========================================================== -->
                        <!-- INTRODUCCION DE SERVICIOS-->
    <!--========================================================== -->


    <section class="d-flex flex-column justify-content-center align-items-center pt-5  text-center" id="intro" >
        <h1  class="p-3 fs-2  text-white" style="font-size: 30px;" > <span class="text-white">Contigo Mortgage</span>  </h1>
        <h1 class="p-3 fs-2 border-top border-3 text-white" style="font-size: 30px;">¡Obtén tu pre-calificación en tan solo minutos! </h1>
         <p class="p-3  fs-4">
             {{-- <span class="text-primary">ExpertD.</span> es la agencia donde te ayudamos establecer tu presencia online. SEO, paginas WEB, tiendas virtuales, redes sociales         --}}
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
                <br><div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/tipo-casa.png')}}" class="card-img-top border border-primary mx-auto" style="width: 200px;" alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Tipo de vivienda</h5>
                                    <p class="card-text">Estamos aquí para ayudarte a encontrar la vivienda que deseas. Define qué tipo de vivienda quieres o estás buscando con nosotros. </p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/datos.png')}}" class="card-img-top border border-primary mx-auto" style="width: 200px;" alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Tu información personal</h5>
                                    <p class="card-text">Para ofrecerte un servicio más personalizado, nos sería de gran ayuda contar con tus datos personales. <br><br></p>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-sm-3">
                            <div class="card border border-secondary h-90">
                                <img src="{{ asset('images/archivo.png')}}" class="card-img-top border border-primary mx-auto" style="width: 200px;" alt="...">
                                <div class="card-body text-center d-flex flex-column">
                                    <h5 class="card-title">Tu información crediticia</h5>
                                    <p class="card-text">Tu información, historial crediticio, ingresos, pago inicial, etc... <br><br><br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br><br><br>
                <center> <button type="button" onclick="inicioproceso()" id="botonvista" class="btn btn-primary">Iniciar precalificación</button> </center>
            </div>
        </div>
    </div>
</div>

<!-- END MAIN CONTENT-->

@endsection