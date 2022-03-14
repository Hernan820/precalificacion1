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
</style>


<div id="carouselExampleControls" class="carousel slide" data-interval="false">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="card text">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿El prestamo que deseas adquirir es para tu primera vivienda o refinanciar tu vivienda ?
                            </h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <center>
                            <input type="radio" name="preg1" value="primera compra" />prestamo para mi primera vivienda<br />
                            <input type="radio" name="preg1" value="refinanciamiento de vivienda" /> prestamo para pagar mi vivienda por segunda
                            vez<br />
                        </center>

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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cual seria el destino de su vivienda ha adquirir? </h2>
                        </center>
                    </h5>
                    <input type="radio" name="preg2" value="vivienda propia" />Vivienda propia&nbsp;<br />
                    <input type="radio" name="preg2" value="alquiler" />Rentar o Alquiler<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Ya tienes identificada la vivienda que desea adquirir?</h2>
                        </center>
                    </h5>
                    <div class="respuestas text ">
                        <input type="radio" name="preg3" value="SI" />SI &nbsp; &nbsp;<br />
                        <input type="radio" name="preg3" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(3)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

            <input type="hidden" name="pregunta3" id="pregunta3" value="3" />
        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿En que estado desea adquirir su vivienda ?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg4" value="Hackensack New Jerse" />Hackensack New Jerse<br />
                        <input type="radio" name="preg4" value="Smithtown New York" /> Smithtown New York<br />
                        <input type="radio" name="preg4" value="Stratford, Connecticut" /> Stratford, Connecticut<br />
                        <input type="radio" name="preg4" value="Otros" /> Otros...<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿En cuál de estos rangos se encuentra el crédito que necesitas para comprar tu
                                vivienda?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg5" value="200,000" />Menos de 200,000<br />
                        <input type="radio" name="preg5" value="200,000-300,000" />Entre 200,000 y 300,000<br />
                        <input type="radio" name="preg5" value="300,000-600,000" />Entre 300,000 y 600,000<br />
                        <input type="radio" name="preg5" value="700,000-900,000" />Entre 700,000 y 900,000<br />
                        <input type="radio" name="preg5" value="Mas de 900,000" /> Mas...<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>Selecciona un rango de edad</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg6" value="18-29" />18-29 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="30-39" />30-39 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="40-49" />40-49 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="50-54" />50-54 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="55 años o Mas" />55 años o Mas...<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Vas a aplicar con otra(s) persona(s)?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg7" value="SI" />SI<br />
                        <input type="radio" name="preg7" value="NO" />NO<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿La persona que te va a acompañar en el crédito es?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg8" value="Mi hermano" />Mi hermano<br />
                        <input type="radio" name="preg8" value="Mi hermana" />Mi hermana<br />
                        <input type="radio" name="preg8" value="Mi hijo" />Mi hijo<br />
                        <input type="radio" name="preg8" value="Mi hija" />Mi hija<br />
                        <input type="radio" name="preg8" value="Mi madre" />Mi madre<br />
                        <input type="radio" name="preg8" value="Mi padre" />Mi padre<br />
                        <input type="radio" name="preg8" value="Otro pariente" />Otro pariente<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Esa persona vivira con tigo?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg9" value="SI" />SI<br />
                        <input type="radio" name="preg9" value="NO" />NO<br />
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
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cómo describes tu estatus laboral?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg10" value="Contrato permanente" />Empleado(a) con contrato permanente<br />
                        <input type="radio" name="preg10" value="Contrato anual" />Empleado(a) con contrato anual
                        renovable<br />
                        <input type="radio" name="preg10" value="Profesional independiente" />Profesional independiente<br />
                        <input type="radio" name="preg10" value="Dueño o socio de negocio propio" />Dueño o Socio de negocio propio<br />
                        <input type="radio" name="preg10" value="Pesionado" />Pensionado<br />
                        <input type="radio" name="preg10" value="Otro" />Otro<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(10)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">

            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cuánto tiempo tienes laborando en tu empleo actual?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg11" value="Menos d e3 meses" />Menos de 3 meses<br />
                        <input type="radio" name="preg11" value="Entre 3 meses y 2 años" />Entre 3 meses y 2 años<br />
                        <input type="radio" name="preg11" value="Entre 2 y 3 años" />Entre 2 y 3 años<br />
                        <input type="radio" name="preg11" value="Más de 3 años" />Más de 3 años<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(11)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>

        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿La empresa para la que trabajas posee más de 3 años de operar en el país?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg12" value="Más de 3 años de operar en el país" />SI<br />
                        <input type="radio" name="preg12" value="Menos de 3 años de operar en el país" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(12)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2> ¿La empresa para la que trabajas posee más de 10 empleados cotizados en planilla con
                                descuentos de ley (ISSS - AFP - Impuesto Sobre la Renta)?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg13" value="SI" />SI<br />
                        <input type="radio" name="preg13" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(13)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Eres PEP o relacionado PEP (Persona Expuesta Políticamente)?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg14" value="SI" />SI<br />
                        <input type="radio" name="preg14" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(14)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿De cuánto son tus ingresos mensuales?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg15" value="Menos de $450" />Menos de $450<br />
                        <input type="radio" name="preg15" value="De $1,000 a $1,500" />De $1,000 a $1,500<br />
                        <input type="radio" name="preg15" value="Más de $1,500" />Más de $1,500<br />

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(15)"
                            id="">Ok,siguiente</button></center>

                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cómo describes el estatus laboral de tu codeudor?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg16" value="contrato permanente" />Empleado(a) con contrato permanente<br />
                        <input type="radio" name="preg16" value="contrato anual" />Empleado(a) con contrato anual renovable<br />
                        <input type="radio" name="preg16" value="profesional independiente" />Profesional independiente<br />
                        <input type="radio" name="preg16" value="Dueño o Socio de negocio propio" />Dueño o Socio de negocio propio<br />
                        <input type="radio" name="preg16" value="Pensionado" />Pensionado<br />
                        <input type="radio" name="preg16" value="Otro" />Otro<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(16)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Cúanto tiempo tiene laborando continuamente tu codeudor en su empleo actual?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg17" value="Menos de 3 meses" />Menos de 3 meses<br />
                        <input type="radio" name="preg17" value="Entre 3 meses y 2 años" />Entre 3 meses y 2 años<br />
                        <input type="radio" name="preg17" value="Entre 2 y 3 años" />Entre 2 y 3 años<br />
                        <input type="radio" name="preg17" value="Más de 3 años" />Más de 3 años<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(17)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿La empresa para la que trabaja tu codeudor posee más de 10 empleados cotizados en
                                planilla con descuentos de ley?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg18" value="SI" />SI<br />
                        <input type="radio" name="preg18" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(18)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿La empresa para la que trabaja tu codeudor posee más de 3 años de operar en el país?
                            </h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg19" value="SI" />SI<br />
                        <input type="radio" name="preg19" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(19)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Tu codeudor es PEP o relacionado PEP (Persona Expuesta Políticamente)?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg20" value="SI" />SI<br />
                        <input type="radio" name="preg20" value="NO" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(20)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿De cuánto son los ingresos mensuales de tu codeudor</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg21" value="Menos de $450" />Menos de $450<br />
                        <input type="radio" name="preg21" value="De $1,000 a $1,500" />De $1,000 a $1,500<br />
                        <input type="radio" name="preg21" value="Más de $1,500" />Más de $1,500<br />

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(21)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>

        <div class="carousel-item">
            <div class="card text-center">
                <div class="card-header">
                    Requisitos del prestamo
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <center>
                            <h2>¿Para cuándo estimas que necesitas el desembolso de tu crédito?</h2>
                        </center>
                    </h5>
                    <div class="respuestas">
                        <input type="radio" name="preg22" value="Menos de 1 mes" />Menos de 1 mes<br />
                        <input type="radio" name="preg22" value="Entre 1 a 3 meses" />Entre 1 a 3 meses<br />
                        <input type="radio" name="preg22" value="Entre 3 a 6 meses" />Entre 3 a 6 meses<br />
                        <input type="radio" name="preg22" value="Más de 6 meses" />Más de 6 meses<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(22)"
                            id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>


        <div class="carousel-item">
            <div class="container">
                <div class="abs-center">
                    <form action="#" id="cliente" class="border p-3 form">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col">

                                <div class="form-group">
                                    <label for="nombre">Nombres</label>
                                    <input type="text" class="form-control" required="" name="nombre" id="id_nombre"
                                        aria-describedby="helpId" placeholder="escribe los nombres " required=""
                                        autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" id="apellidos"
                                        aria-describedby="helpId" placeholder="escribe los apleiidos" required=""
                                        autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="num_dui">N° dui</label>
                                    <input type="text" class="form-control" required="" name="num_dui" id="num_dui"
                                        aria-describedby="helpId" placeholder=" "
                                        autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="correo">Correo electronico</label>
                                    <input type="text" class="form-control" required="" name="correo" id="correo"
                                        aria-describedby="helpId" placeholder=" " autocomplete="off">
                                </div>


                            </div>
                            <div class="col">

                                <div class="form-group">
                                    <label for="telefono">Telefono </label>
                                    <input type="tel" class="form-control" required="" name="telefono" id="telefono"
                                        aria-describedby="helpId" placeholder="(000) 000-0000" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="edad">Rango de edad </label>
                                    <input type="text" class="form-control" required="" name="edad" id="edad"
                                        aria-describedby="helpId" placeholder=" " autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="proyecto">Nombre de proyecto </label>
                                    <input type="text" class="form-control" required="" name="proyecto" id="proyecto"
                                        aria-describedby="helpId" placeholder=" " autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <center> <button type="button" class="btn btn-success next" onclick="guardardatos()"
            id="precalificacion">obtener precalificacion</button></center>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection