@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
<script src="https://unpkg.com/imask"></script>
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
</style>


<div id="carouselExampleControls" class="carousel slide" data-interval="false">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="card text-center">
                <div class="card-header">
                    DATOS DE CASA
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿El prestamo que deseas adquirir es para tu primera vivienda o refinanciar tu vivienda ?
                            </h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <input type="radio" name="preg1" value="Prestamo para mi primera
                            casa" />Prestamo para mi primera
                            casa<br />
                            <input type="radio" name="preg1" value="Prestamo para
                            refinanciamiento" />Prestamo para
                            refinanciamiento<br />
                        </div>

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(1)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
            <input type="hidden" name="pregunta1" id="pregunta1" value="1" />
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    DATOS DE CASA
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Donde deseas comprar ?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <input type="radio" name="preg2" value="Smithtown New York" />Smithtown New York<br />
                            <input type="radio" name="preg2" value="Hackensack New Jerse" />Hackensack New Jerse<br />
                            <input type="radio" name="preg2" value="Stratford,Connecticut" />Stratford,Connecticut<br />
                            <input type="radio" name="preg2" value="Pensilvania" />Pensilvania<br />
                            <input type="radio" name="preg2" value="Florida" />Florida<br />
                        </div>

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(2)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
            <input type="hidden" name="pregunta2" id="pregunta2" value="2" />

        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    DATOS DE CASA
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿En que tiempo deseas comprar?</h2>
                        </center>
                    </h5>
                    <div class="respuestas text ">
                        <div class="container resp">
                            <input type="radio" name="preg3" value="SI" />SI &nbsp; &nbsp;<br />
                            <input type="radio" name="preg3" value="NO" />NO<br />
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(3)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    DATOS DE CASA
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Tipo de vivienda</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <input type="radio" name="preg4" value="Unifamiliar" />Unifamiliar<br />
                            <input type="radio" name="preg4" value="Duplex" />Duplex<br />
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(4)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    DATOS DE CASA
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Tiene un agente inmobiliario?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <input type="radio" name="preg5" value="SI" />SI<br />
                            <input type="radio" name="preg5" value="NO" />NO<br />
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(5)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    INFORMACION DE CREDITO
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Calificacion crediticia estimada</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <div class="form-group">
                                <input type="text" class="form-control" required="" name="record_credito"
                                    id="record_credito" aria-describedby="helpId"
                                    placeholder="Aproximado de tu record crediticio" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(6)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>
        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    INFORMACION DE CREDITO
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Cuanto tienes ahorrado</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <div class="form-group">
                                <input type="text" class="form-control" required="" name="ahorro" id="ahorro"
                                    aria-describedby="helpId" placeholder="Aproximado" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(7)"
                            id="">Ok,siguiente</button></center>

                </div>
            </div>
        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    INFORMACION DE CREDITO
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Ingreso aproximado del Hogar </h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <div class="form-group">
                                <input type="text" class="form-control" required="" name="ingreso_hogar"
                                    id="ingreso_hogar" aria-describedby="helpId" placeholder="Aproximado"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(8)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    INFORMACION DE CREDITO
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cuanto cree poder pagar al mes?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                            <div class="form-group">
                                <input type="text" class="form-control" required="" name="mensual" id="mensual"
                                    aria-describedby="helpId" placeholder="Aproximado" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(9)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    INFORMACION DE CREDITO
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Comentarios adicionales</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <div class="container resp">
                        <div class="form-group">
                                <input type="text" class="form-control" required="" name="comentarios" id="comentarios"
                                    aria-describedby="helpId" placeholder="Aproximado" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(10)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

       


        <div class="carousel-item">
            <div class="container">
                <div class="abs-center">
                    <form action="#" id="clientedatos" class="border p-3 form">
                        <div class="container text-center" style="border-width:4px;">
                        <label for="">DATOS PERSONALES</label>

                        </div>
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col">

                                <div class="form-group">
                                    <label for="nombre">Nombres</label>
                                    <input type="text" class="form-control" required="" name="nombres" id="nombres"
                                        aria-describedby="helpId" placeholder="Escribe los nombres " required=""
                                        autocomplete="off" onkeyup="mayus(this);">
                                </div>

                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" id="apellidos"
                                        aria-describedby="helpId" placeholder="Escribe los apellidos" required=""
                                        autocomplete="off" onkeyup="mayus(this);">
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo Electronico</label>
                                    <input type="text" class="form-control" required="" name="correo" id="correo"
                                        aria-describedby="helpId" placeholder="Example@gmail.com" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="Medio">Medio por el cual desea ser contactado </label>
                                    <select name="Medio" id="Medio" class="form-control">
                                    <option value="" selected disabled ="true" >Seleccione</option>
                                        <option value="Telefono">Telefono</option>
                                        <option value="Email">Email</option>
                                    </select>
                                </div>


                            </div>
                            <div class="col">

                                <div class="form-group">
                                    <label for="telefono">Telefono </label>
                                    <input type="tel" class="form-control" required="" name="telefono" id="telefono"
                                        aria-describedby="helpId" placeholder="(000) 000-0000" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="estatus_laboral">Estatus laboral </label>
                                    <select name="estatus_laboral" id="estatus_laboral" class="form-control">
                                    <option value="" selected disabled ="true" >Seleccione</option>
                                        <option value="Sales and employmen">Sales and employmen</option>
                                        <option value="Asalariado">Asalariado</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="Estatus_social">Social / Itin </label>
                                    <select name="Estatus_social" id="Estatus_social" class="form-control">
                                    <option value="" selected disabled ="true" >Seleccione</option>
                                        <option value="Social">Social</option>
                                        <option value="Itin">Itin</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="horario">Horario en que desea ser contactado</label>
                                    <select name="horario" id="horario" class="form-control">
                                    <option value="" selected disabled ="true" >Seleccione</option>
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <center> <button type="button" class="btn btn-success next" onclick="guardardatos()"
                                id="precalificacion">Enviar Datos</button></center>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection