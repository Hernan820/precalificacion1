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
                <h2>Gracias por tu tiempo para completar nuestro formulario. Uno de nuestros agentes se contactará contigo</h2>
            </center>
            <br><br><br>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->

@endsection