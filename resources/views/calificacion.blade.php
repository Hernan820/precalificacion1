@extends('layouts.app')
@section('content')
<script src="{{ asset('js/proceso.js') }}" defer></script>

<style>
.sidebar {
    /*  max-width: 100px !important;*/
}

.main-content {
    padding-top: 1px !important;
    min-height: 100vh;
}

#intro-final {
    background: linear-gradient(rgba(5,7,12,0.75),rgba(5,7,12,0.75));
    background-repeat: no-repeat;
    background-position: center top;
    height: 300px;
    background-size: cover;
}

#informacion-usuario ,#telefono-company {
    font-size: 20px; 
}
</style>

    <!--========================================================== -->
                        <!-- INTRODUCCION DE SERVICIOS-->
    <!--========================================================== -->


    <section class="d-flex flex-column justify-content-center align-items-center pt-5 pb-3 text-center" id="intro-final" style="background-image: linear-gradient(rgba(5,7,12,0.60),rgba(5,7,12,0.60)), url({{ asset('images/carpenter1.jpg')}}) ;">
        <h1  class="p-3 fs-2  text-white" > <span class="text-primary">Contigo Mortgage</span>  </h1>
        <h1 class="p-3 fs-2 border-top border-3 text-white">¡Mereces tener tu casa propia! </h1>

         <p class="p-3  fs-3 text-white">
          ¡Queremos ayudarte a que cumplas ese sueño, tenemos todo lo que necesitas!   
         </p>   
    </section>

    <!--========================================================== -->
                        <!-- INTRODUCCION DE SERVICIOS-->
    <!--========================================================== -->


    <section class="d-flex flex-column justify-content-center align-items-center pt-5  text-center " id="intro">
        <h1 class="p-3 fs-2 border-top border-3">¡Gracias por completar tu registro!</h1>
         <p class="p-3" id="informacion-usuario">
             Uno de nuestros asesores se pondrá en contacto contigo pronto. <br>
             Si tienes alguna consulta adicional puedes llamarnos al:      
         </p>
         <p id="telefono-company"><a href="tel:+16316099108"> 631-609-9108</a>
         </p>   
    </section>



@endsection