@extends('layouts.app')
@section('content')
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

<script>
    $('#telefonocliente').mask('(000) 000-0000');    
</script>

<script src="{{ asset('js/proceso.js') }}" defer></script>

<style>
.sidebar {
    /*  max-width: 100px !important;*/
}

.main-content {
    padding-top: 1px !important;
    min-height: 100vh;
}

.card-body {
    background-color: #f4f4f4;
}

.card {
    border: 0;
    background-color: #f4f4f4;

}

.card-title {
    border: 0;
    background-color: #f4f4f4;

}

.text-muted {
    border: 0;
    background-color: #f4f4f4;

}

.card-header {
    border: 0;
    background-color: #f4f4f4;

}

.respuestas {
    border: 0;
    background-color: #f4f4f4;

}

.text {
    border: 0;
    background-color: #f4f4f4;
}

.abs-center {
    display: flex;
    justify-content: center;
    min-height: 100vh;
}

.form {
    width: 900px;
}

.resp {
    text-align: justify;
    width: fit-content;
}

#intro-datos {
    background: linear-gradient(rgba(5,7,12,0.80),rgba(5,7,12,0.80));
    background-repeat: no-repeat;
    background-position: center top;
    height: 200px;
    background-size: cover;
}

#contenedor-carousel{
    margin-bottom: 5%;

}
</style>

<section class="d-flex flex-column justify-content-center align-items-center pt-5  text-center" id="intro-datos" style="background-image: linear-gradient(rgba(5,7,12,0.75),rgba(5,7,12,0.75)), url({{ asset('images/carpenter1.jpg')}}) ;">
    <h1  class="p-3 fs-2  text-white" > <span class="text-white">Contigo Mortgage</span>  </h1>
    <h1 class="p-3 fs-2 border-top border-3 text-white">Registro de tus datos para tu pre-calificación </h1>
     <p class="p-3  fs-4">
         {{-- <span class="text-primary">ExpertD.</span> es la agencia donde te ayudamos establecer tu presencia online. SEO, paginas WEB, tiendas virtuales, redes sociales         --}}
     </p>   
</section>
<br>
<div class="container" id="contenedor-carousel">

<div id="carouselExampleControls" class="carousel slide" data-interval="false">
    <div class="carousel-inner">
        <div class="carousel-item active">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuál es tu nombre?
                                </h2>
                            <div class="form-group col ">
                                <label for="exampleFormControlInput1"></label>
                                <input type="text" class="form-control datos" name="nombre_cliente" id="nombre_cliente" placeholder="Ingresa tu nombre">
                              </div>
                            </center>

                        </div>
                    </div>
                </div>
            </div>
            <center> <button type="button" class="btn btn-primary next" onclick="siguiente(1)"
                id="">Ok,siguiente</button></center>
                <input type="hidden" name="pregunta1" id="pregunta1" value="1" />
        </div>

        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>Ingresa tu número de teléfono.
                                </h2>
                            <div class="form-group col ">
                                <label for="exampleFormControlInput1"></label>
                                <input type="text" class="form-control datos" id="telefonocliente" placeholder="(000)000-0000">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(2)"
                        id="">Ok,siguiente</button></center>
            </div>
            <input type="hidden" name="pregunta2" id="pregunta2" value="2" /> 

        </div>

        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿En qué estado deseas comprar?
                                </h2>
                            <div class="form-group col ">
                                <label for="exampleFormControlInput1"></label>
                                <select class="form-control datos" name="estados_casas" id="estados_casas"></select>
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(3)"
                        id="">Ok,siguiente</button></center>
            </div>

        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuál es tu estatus migratorio?</h2>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preg4" id="flexRadioDefault1"  value="social" >
                                    <label class="form-check-label" for="flexRadioDefault1">
                                      SOCIAL
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preg4" id="flexRadioDefault2" value="tax_id" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                     TAX ID
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preg4" id="flexRadioDefault3" value="ninguno" >
                                    <label class="form-check-label" for="flexRadioDefault3">
                                     NINGUNO
                                    </label>
                                </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(4)"
                        id="">Ok,siguiente</button></center>
            </div>

        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuál es tu tipo de empleo?</h2>

                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preg5" id="radiobuton1"  value="w2" >
                                    <label class="form-check-label" for="radiobuton1">
                                        W2
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="preg5" id="radiobuton2" value="1099" >
                                    <label class="form-check-label" for="radiobuton2">
                                        1099
                                    </label>
                                </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(5)"
                        id="">Ok,siguiente</button></center>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuánto ganas por hora?</h2>

                              <div class="form-group col ">
                                <input type="number" class="form-control datos" required="" name="precioporhora"
                                    id="precioporhora" aria-describedby="helpId"
                                    placeholder="$" mask="$000" autocomplete="off">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(6)"
                        id="">Ok,siguiente</button></center>
            </div>
        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuántas horas trabajas sin contar overtime?</h2>

                              <div class="form-group col ">
                                <input type="number" class="form-control datos" required="" name="num_horas"
                                    id="num_horas" aria-describedby="helpId"
                                    placeholder="" mask="$000" autocomplete="off">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(7)"
                        id="">Ok,siguiente</button></center>
            </div>
        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuánto declaraste en los taxes de 2021?</h2>

                              <div class="form-group col ">
                                <input type="number" class="form-control datos" required="" name="taxes2021"
                                    id="taxes2021" aria-describedby="helpId"
                                    placeholder="" mask="$000" autocomplete="off">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(8)"
                        id="">Ok,siguiente</button></center>
            </div>

        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                                <h2>¿Cuánto declaraste en los taxes de 2022?</h2>

                              <div class="form-group col ">
                                <input type="number" class="form-control datos" required="" name="taxes2022"
                                    id="taxes2022" aria-describedby="helpId"
                                    placeholder="" mask="$000" autocomplete="off">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(9)"
                        id="">Ok,siguiente</button></center>
            </div>
        </div>
        <div class="carousel-item">

            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                              <h2>¿Con cuánto dispones de down payment?</h2>

                              <div class="form-group col ">
                                <input type="number" class="form-control datos" required="" name="dowpayment"
                                    id="dowpayment" aria-describedby="helpId"
                                    placeholder="" mask="$000" autocomplete="off">
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="siguiente(10)"
                        id="">Ok,siguiente</button></center>
            </div>

        </div>
        <div class="carousel-item">
            
            <div class="container">
                <div style="">
                    <div class="card border rounded border-primary " style="" id="tarjetacita">
                        <div class="card-header" style=" text-align: center;"> <strong> DATOS PARA TU PRE-CALIFICAION </strong></div>
                        <div class="card-body text-dark">
            
                            <center>
                              <h2>¿Tienes alguna observación adicional que consideras importante que evaluemos?</h2>

                              <div class="form-group col ">
                                    <textarea class="form-control datos" name="informacionextra" id="informacionextra" cols="5" rows="5"
                                    placeholder="Déjanos tu observación adicional"></textarea>
                              </div>
                            </center>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-primary next" onclick="guardardatos()"
                    id="precalificacion">Enviar Datos</button></center>
            </div>

        </div>

    </div>
</div>

</div>

@endsection