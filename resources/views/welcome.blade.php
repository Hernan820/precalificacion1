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

.card-body {
    background-color: #f4f4f4;
}
.card {
    border: 0;
    background-color: #f4f4f4;

}
.card-title{
    border: 0;
    background-color: #f4f4f4;

}
.text-muted{
    border: 0;
    background-color: #f4f4f4;

}
.card-header{
    border: 0; 
    background-color: #f4f4f4;
 
}
.respuestas {
    border: 0;
    background-color: #f4f4f4;

}
.text{
    border: 0;
    background-color: #f4f4f4;  
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
                    <div class="respuestas" >
                        <center>
                        <input type="radio" name="preg1" value="1" />prestamo para mi primera vivienda<br />
                        <input type="radio" name="preg1" value="2" /> prestamo para pagar mi vivienda por segunda
                        vez<br />
                        </center>

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <center> <button type="button" class="btn btn-success next" onclick="siguiente(1)" id="">Ok,siguiente</button></center>
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
                    <input type="radio" name="preg2" value="1" />Vivienda propia&nbsp;<br />
                    <input type="radio" name="preg2" value="2" />Rentar o Alquiler<br />
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(2)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg3" value="1" />SI &nbsp; &nbsp;<br />
                        <input type="radio" name="preg3" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(3)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg4" value="1" />Hackensack New Jerse<br />
                        <input type="radio" name="preg4" value="2" /> Smithtown New York<br />
                        <input type="radio" name="preg4" value="2" /> Stratford, Connecticut<br />
                        <input type="radio" name="preg4" value="2" /> Otros...<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(4)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg5" value="1" />Menos de 200,000<br />
                        <input type="radio" name="preg5" value="2" />Entre 200,000 y 300,000<br />
                        <input type="radio" name="preg5" value="2" />Entre 300,000 y 600,000<br />
                        <input type="radio" name="preg5" value="2" />Entre 700,000 y 900,000<br />
                        <input type="radio" name="preg5" value="2" /> Mas...<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(5)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg6" value="1" />18-29 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="2" />30-39 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="2" />40-49 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="2" />50-54 &nbsp;&nbsp;<br />
                        <input type="radio" name="preg6" value="2" />55 años o Mas...<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(6)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg7" value="1" />SI<br />
                        <input type="radio" name="preg7" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(7)" id="">Ok,siguiente</button></center>

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
                        <input type="radio" name="preg8" value="1" />Mi hermano<br />
                        <input type="radio" name="preg8" value="2" />Mi hermana<br />
                        <input type="radio" name="preg8" value="1" />Mi hijo<br />
                        <input type="radio" name="preg8" value="2" />Mi hija<br />
                        <input type="radio" name="preg8" value="1" />Mi madre<br />
                        <input type="radio" name="preg8" value="2" />Mi padre<br />
                        <input type="radio" name="preg8" value="2" />Otro pariente<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(8)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg9" value="1" />SI<br />
                        <input type="radio" name="preg9" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(9)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg10" value="1" />Empleado(a) con contrato permanente<br />
                        <input type="radio" name="preg10" value="2" />Empleado(a) con contrato anual
                        renovable<br />
                        <input type="radio" name="preg10" value="1" />Profesional independiente<br />
                        <input type="radio" name="preg10" value="2" />Dueño o Socio de negocio propio<br />
                        <input type="radio" name="preg10" value="1" />Pensionado<br />
                        <input type="radio" name="preg10" value="2" />Otro<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(10)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg11" value="1" />Menos de 3 meses<br />
                        <input type="radio" name="preg11" value="2" />Entre 3 meses y 2 años<br />
                        <input type="radio" name="preg11" value="1" />Entre 2 y 3 años<br />
                        <input type="radio" name="preg11" value="2" />Más de 3 años<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(11)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg12" value="1" />SI<br />
                        <input type="radio" name="preg12" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(12)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg13" value="1" />SI<br />
                        <input type="radio" name="preg13" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(13)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg14" value="1" />SI<br />
                        <input type="radio" name="preg14" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(14)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg15" value="1" />Menos de $450<br />
                        <input type="radio" name="preg15" value="2" />De $1,000 a $1,500<br />
                        <input type="radio" name="preg15" value="2" />Más de $1,500<br />

                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(15)" id="">Ok,siguiente</button></center>

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
                        <input type="radio" name="preg16" value="1" />Empleado(a) con contrato permanente<br />
                        <input type="radio" name="preg16" value="2" />Empleado(a) con contrato anual renovable<br />
                        <input type="radio" name="preg16" value="1" />Profesional independiente<br />
                        <input type="radio" name="preg16" value="2" />Dueño o Socio de negocio propio<br />
                        <input type="radio" name="preg16" value="1" />Pensionado<br />
                        <input type="radio" name="preg16" value="2" />Otro<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(16)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg17" value="1" />Menos de 3 meses<br />
                        <input type="radio" name="preg17" value="2" />Entre 3 meses y 2 años<br />
                        <input type="radio" name="preg17" value="1" />Entre 2 y 3 años<br />
                        <input type="radio" name="preg17" value="2" />Más de 3 años<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(17)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg18" value="1" />SI<br />
                        <input type="radio" name="preg18" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(18)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg19" value="1" />SI<br />
                        <input type="radio" name="preg19" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(19)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg20" value="1" />SI<br />
                        <input type="radio" name="preg20" value="2" />NO<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(20)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg21" value="1" />Menos de $450<br />
                        <input type="radio" name="preg21" value="2" />De $1,000 a $1,500<br />
                        <input type="radio" name="preg21" value="2" />Más de $1,500<br />

                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(21)" id="">Ok,siguiente</button></center>
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
                        <input type="radio" name="preg22" value="1" />Menos de 1 mes<br />
                        <input type="radio" name="preg22" value="2" />Entre 1 a 3 meses<br />
                        <input type="radio" name="preg22" value="2" />Entre 3 a 6 meses<br />
                        <input type="radio" name="preg22" value="2" />Más de 6 meses<br />
                    </div>
                </div>
                <div class="card-footer text-muted">
                <center> <button type="button" class="btn btn-success next" onclick="siguiente(22)" id="">Ok,siguiente</button></center>
                </div>
            </div>
        </div>


        <div class="carousel-item">
            <label for="">PARA PODER DARTE UNA MEJOR EXPERIENCIA PORFAVOR INGRESA TUS DATOS</label>

            <div class="container">
                <div class="container">
                    <form action="" id="popup_cita">
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
                                    <label for="direccion">N° dui</label>
                                    <input type="text" class="form-control" required="" name="direccion" id="direccion"
                                        aria-describedby="helpId" placeholder="AP Sunwest, Tidio CDMS, Tidio Sunwest "
                                        autocomplete="off">
                                </div>


                            </div>
                            <div class="col">

                                <div class="form-group">
                                    <label for="telefono">Telefono </label>
                                    <input type="tel" class="form-control" required="" name="telefono" id="telefono"
                                        aria-describedby="helpId" placeholder="(000) 000-0000" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="hora">Hora Cita </label>
                                    <div style="display: flex;justify-content: space-around;">
                                        <select name="horas" onchange="seteaHora(this,false)" id="horas"
                                            class="form-control col-md-3">
                                        </select>
                                        <select name="minutos" id="minutos" class="form-control col-md-3"
                                            onchange="seteaMinutos(false)">
                                            <option value="00" selected>00</option>
                                            <option value="30">30</option>
                                        </select>
                                        <input type="text" class="form-control col-md-3" required="" name="horarioCita"
                                            id="horarioCita" readonly="readonly" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripcion </label>
                                    <textarea name="descripcion" rows="5" required="" id="descripcion"
                                        style="white-space: pre-wrap;" class="form-control descripcion" cols="50"
                                        autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <center> <button type="button" class="btn btn-success next" onclick="guardardatos()"
                        id="precalificacion">obtener precalificacion</button></center>
            </div>
        </div>

    </div>
</div>
@endsection