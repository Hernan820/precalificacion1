let a = document.getElementById("clientedatos");
var principalUrl = "http://localhost/precalificacion1/public/";

var t = document.getElementById("telefono");
var maskOptions = {
    mask: "(000) 000-0000",
}; 
IMask(t, maskOptions);


var record = document.getElementById("record_credito");
var maskrecord = {
    mask: "000000000",
}; 
IMask(record, maskrecord);

var ahorro = document.getElementById("ahorro");
var maskahorro = {
    mask: "$000000000",
}; 
IMask(ahorro, maskahorro);

var ingresohogar = document.getElementById("ingreso_hogar");
var maskingresohogar = {
    mask: "$000000000",
}; 
IMask(ingresohogar, maskingresohogar);

var mensual = document.getElementById("capacidad_mensual");
var maskmensual = {
    mask: "$000000000",
}; 
IMask(mensual, maskmensual);



  function inicioproceso(){
    location.href = principalUrl + "home/vista";  
  };

  $(document).ready(function () {
    $('#clientedatos').trigger("reset");
    limpiar_raiobutton();
});


  $('#carouselExampleControls').carousel({
    interval: false,
  });

function validarpreguntas(numero){

    var valido = true;
if(numero == 1){
    if(!document.querySelector('input[name="preg1"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 2){
    if(!document.querySelector('input[name="preg2"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }

}else if(numero == 3){
    if(!document.querySelector('input[name="preg3"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 4){
    if(!document.querySelector('input[name="preg4"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 5){
    if(!document.querySelector('input[name="preg5"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 6){
    if($("#record_credito").val() === "") {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 7){
    if($("#ahorro").val() === "") {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 8){
    if($("#ingreso_hogar").val() === "") {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 9){
    if($("#mensual").val() === "") {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 10){
    if($("#comentarios").val() === "") {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}
    return valido;
}



function siguiente(Pregunta){
    
    if(validarpreguntas(Pregunta) == false){
        return;
    }
        $('#carouselExampleControls').carousel('next')
        $('#carouselExampleControls').carousel('pause')
}

function guardardatos(){

   if(validacionform() == false){
        return;
    }
    var datoscliente = new FormData(a);

    datoscliente.append("tipo_prestamo", document.querySelector('input[name="preg1"]:checked').value);
    datoscliente.append("estado_vivienda", document.querySelector('input[name="preg2"]:checked').value  );
    datoscliente.append("tiempo_compra", document.querySelector('input[name="preg3"]:checked').value );
    datoscliente.append("tipo_vivienda", document.querySelector('input[name="preg4"]:checked').value   );
    datoscliente.append("agente_inmobiliario", document.querySelector('input[name="preg5"]:checked').value   );
   
    datoscliente.append("record_credito", $("#record_credito").val()  );
    datoscliente.append("ahorro", $("#ahorro").val());
    datoscliente.append("ingreso_hogar", $("#ingreso_hogar").val()  );
    datoscliente.append("capacidad_mensual", $("#capacidad_mensual").val()   );
    datoscliente.append("comentarios", $("#comentarios").val()   );

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
        if(respuesta.data == "1"){

            limpiar_raiobutton();

   location.href = principalUrl + "home/vista3";
        }
    })
    .catch((error) => {
        if (error.response) {
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