let a = document.getElementById("clientedatos");
var principalUrl = "http://localhost/precalificacion1/public/";
//var principalUrl = "https://miprecalificacion.contigomortgage.com/";

var estados_usa = [
    "Alaska",
    "Arizona",
    "Arkansas",
    "California",
    "Carolina del Norte",
    "Carolina del Sur",
    "Colorado",
    "Connecticut",
    "Dakota del Norte",
    "Dakota del Sur",
    "Delaware",
    "Florida",
    "Georgia",
    "Hawái",
    "Idaho",
    "Illinois",
    "Indiana",
    "Iowa",
    "Kansas",
    "Kentucky",
    "Luisiana",
    "Maine",
    "Maryland",
    "Massachusetts",
    "Míchigan",
    "Minnesota",
    "Misisipi",
    "Misuri",
    "Montana",
    "Nebraska",
    "Nevada",
    "New Jersey",
    "New York",
    "New Hampshire",
    "New México",
    "Ohio",
    "Oklahoma",
    "Oregón",
    "Pensilvania",
    "Rhode Island",
    "Tennessee",
    "Texas",
    "Utah",
    "Vermont",
    "Virginia",
    "Virginia Occidental",
    "Washington",
    "Wisconsin",
    "Wyoming",
];

function muestra_estados(){
    $("#estados_casas").html('');
    $("#estados_casas").append("<option selected readonly value=''>Elije un estado </option>");

    estados_usa.forEach(function (element) {
        if(element.accion != 'Se creo la cita' || element.accion != 'reagendado'  ){
            $("#estados_casas").append("<option value='"+element+"'>"+element+"</option>");

        }
    });  
}

function inicioproceso(){
    location.href = principalUrl + "precalificacion";  
};

$(document).ready(function () {

    $('#clientedatos').trigger("reset");
    limpiar_raiobutton();
    muestra_estados();
});


  $('#carouselExampleControls').carousel({
    interval: false,
  });

function validarpreguntas(numero){

        var valido = true;
    if(numero == 1){
        if($("#nombre_cliente").val() === "") {
            Swal.fire("¡Debes ingresar tu nombre!");
            valido = false;
            }

    }else if(numero == 2){

        if($("#telefonocliente").val().length < 14) {
            Swal.fire("¡Completa tu numero de telefono para poder contactarte!");
            valido = false;
            }

    }else if(numero == 3){
        var estadoseleccionado = $("#estados_casas").val();

        if(estadoseleccionado == "") {
            Swal.fire("¡Selecciona un estado para poder darte una informacion mas precisa!");
            valido = false;
            }

    }else if(numero == 4){
        if(!document.querySelector('input[name="preg4"]:checked')) {
            Swal.fire("¡Selecciona un estatus migratorio !");
            valido = false;
            }
    }else if(numero == 5){
        if(!document.querySelector('input[name="preg5"]:checked')) {
            Swal.fire("¡Selecciona tu forma de trabajo !");
            valido = false;
            }
    }else if(numero == 6){
        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;
        if(formatrabajo == "w2"){
            if($("#precioporhora").val() === "") {
                Swal.fire("¡El precio de tus horas es necesaria para darte una informacion mas precisa!");
                valido = false;
                }
        }

    }else if(numero == 7){
        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;
        if(formatrabajo == "w2"){
            if($("#num_horas").val() === "") {
                Swal.fire("¡Es necesario para darte una informacion mas precisa!");
                valido = false;
                }
        }
    }else if(numero == 8){

        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;
        if(formatrabajo == "1099"){
            var taxuno = $("#taxes2021").val();
            if(taxuno === "") {
                Swal.fire("¡Es necesario para darte una informacion mas precisa!");
                valido = false;
                }
        }
    }else if(numero == 9){
        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;
        if(formatrabajo == "1099"){
            var taxudos = $("#taxes2022").val();

            if(taxudos === "") {
                Swal.fire("¡Es necesario para darte una informacion mas precisa!");
                valido = false;
                }
        }
    }else if(numero == 10){
        if($("#dowpayment").val() === "") {
            Swal.fire("¡Ingresar con cuanto cuentas de dow payment, para darte una informacion mas precisa!");
            valido = false;
            }
    }
    return valido;
}



function siguiente(Pregunta){
    
     if(validarpreguntas(Pregunta) == false){
         return;
     }

    if(Pregunta == 5){
        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;

        if(formatrabajo == "w2"){
            $('#carouselExampleControls').carousel('next')
            $('#carouselExampleControls').carousel('pause')
        }else if(formatrabajo == "1099"){
            $('#carouselExampleControls').carousel(7);
            $('#carouselExampleControls').carousel('pause')
        }
    }else if(Pregunta == 7){
        var formatrabajo =document.querySelector('input[name="preg5"]:checked').value;
        if(formatrabajo == "w2"){
            $('#carouselExampleControls').carousel(9);
            $('#carouselExampleControls').carousel('pause')
        }
    }else{
        $('#carouselExampleControls').carousel('next')
        $('#carouselExampleControls').carousel('pause')
    }
}

function guardardatos(){

//    if(validacionform() == false){
//         return;
//     }
    var datoscliente = new FormData();

    datoscliente.append("nombre_cliente", $("#nombre_cliente").val());
     datoscliente.append("telefonocliente", $("#telefonocliente").val() );
     datoscliente.append("estados_casas", $("#estados_casas").val()  );
     datoscliente.append("precioporhora", $("#precioporhora").val() );
     datoscliente.append("num_horas", $("#num_horas").val() );
     datoscliente.append("taxes2021", $("#taxes2021").val() );
     datoscliente.append("taxes2022", $("#taxes2022").val()  );
     datoscliente.append("dowpayment", $("#dowpayment").val() );
     datoscliente.append("informacionextra", $("#informacionextra").val()  );
     datoscliente.append("status", document.querySelector('input[name="preg4"]:checked').value);
     datoscliente.append("tipo_trabajo", document.querySelector('input[name="preg5"]:checked').value);

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "guardando datos",
        showConfirmButton: false,
    });

    
   var btndatos = document.getElementById('precalificacion');
   btndatos.disabled = true; 
   
    axios.post(principalUrl + "home/precalificacion",datoscliente)
    .then((respuesta) => {
        if(respuesta.data != ""){

            limpiar_raiobutton();

   location.href = principalUrl + "agradecimiento";
        }
    })
    .catch((error) => {
        if (error.response) {
            location.href = principalUrl + "agradecimiento";

            console.log(error.response.data);
        }
    });
    
    
}

const validateEmail = (correo) => {
    var format =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return format.test(correo);
};

function validacionform(){
    var valido = true;

  var  nombre     = $("#nombres").val();
  var  apellidos = $("#apellidos").val();
  var  correo = $("#correo").val();
  var  medio = $("#Medio").val();
  var  telefono = $("#telefono").val();
  var  laboral = $("#estatus_laboral").val();
  var  social = $("#Estatus_social").val();
  var  horario = $("#horario").val();

  
  if (validateEmail(correo) == false) {
    Swal.fire("¡El formato del correo no es correcto!");
    valido = false;
}
    if (nombre === "" ||
        apellidos === "" ||
        medio === null ||
        correo === "" ||
        telefono === "" ||
        laboral === null ||
        social === null ||
        horario === null

    ) {
        Swal.fire("Complete todos los datos");
        valido = false;
    }

    return valido;
}

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function limpiar_raiobutton(){
    $('input[name=preg1]').prop('checked',false);
    $('input[name=preg2]').prop('checked',false);
    $('input[name=preg3]').prop('checked',false);
    $('input[name=preg4]').prop('checked',false);
    $('input[name=preg5]').prop('checked',false);
}