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
</style>
<!-- MAIN CONTENT-->
<div class="container">
    <div class="main-content">
        <div class="section__content section__content--p30">
            <center>
                <h2>Gracias por tu tiempo para completar nuestro formulario.
                    En este momento, según nuestras políticas de crédito no aplicas;
                    sin embargo si tu situación varía puedes intentarlo nuevamente.</h2>
            </center>
            <br><br><br>
            <center>
                <h5>Estas son algunas de las viviendas que financiamos,
                    visítalas y haz realidad el sueño de tener un hogar ideal.</h5>
            </center>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection