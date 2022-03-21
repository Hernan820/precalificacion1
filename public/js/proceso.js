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

var mensual = document.getElementById("mensual");
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
    if(!document.querySelector('input[name="preg6"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 7){
    if(!document.querySelector('input[name="preg7"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 8){
    if(!document.querySelector('input[name="preg8"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 9){
    if(!document.querySelector('input[name="preg9"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 10){
    if(!document.querySelector('input[name="preg10"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 11){
    if(!document.querySelector('input[name="preg11"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 12){
    if(!document.querySelector('input[name="preg12"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 13){
    if(!document.querySelector('input[name="preg13"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 14){
    if(!document.querySelector('input[name="preg14"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 15){
    if(!document.querySelector('input[name="preg15"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 16){
    if(!document.querySelector('input[name="preg16"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
}else if(numero == 17){
    if(!document.querySelector('input[name="preg17"]:checked')) {
        Swal.fire("¡Error debe completar todos los datos!");
        valido = false;
        }
    }else if(numero == 18){
        if(!document.querySelector('input[name="preg18"]:checked')) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
            }
    }else if(numero == 19){
        if(!document.querySelector('input[name="preg19"]:checked')) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
            }
    }else if(numero == 20){
        if(!document.querySelector('input[name="preg20"]:checked')) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
            }
    }else if(numero == 21){
        if(!document.querySelector('input[name="preg21"]:checked')) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
            }
    } else if(numero == 22){
        if(!document.querySelector('input[name="preg22"]:checked')) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
            }
    }
    return valido;
}



function siguiente(Pregunta){
    


  
        $('#carouselExampleControls').carousel('next')
        $('#carouselExampleControls').carousel('pause')
    

   /* if(validarpreguntas(Pregunta) == false){
        return;
    }


    if(Pregunta != 7 && Pregunta != 15 && Pregunta != 22){
        $('#carouselExampleControls').carousel('next')
        $('#carouselExampleControls').carousel('pause')

    }else if (Pregunta == 7){
        var codeudor =document.querySelector('input[name="preg7"]:checked').value;
        if(codeudor == "NO"){
            $("#carouselExampleControls").carousel(9);
            $('#carouselExampleControls').carousel('pause')

        }else{
            $('#carouselExampleControls').carousel('next')
            $('#carouselExampleControls').carousel('pause')

        }
    }else if(Pregunta == 15){
        var codeudor =document.querySelector('input[name="preg7"]:checked').value;
        if(codeudor == "NO"){
            $("#carouselExampleControls").carousel(21);
            $('#carouselExampleControls').carousel('pause')

        }else{
            $('#carouselExampleControls').carousel('next')
            $('#carouselExampleControls').carousel('pause')

        }  
    }else if(Pregunta == 22){
        var rango_edad =document.querySelector('input[name="preg6"]:checked').value;

        $("#edad").val(rango_edad);
    $('#carouselExampleControls').carousel('next')
        $('#carouselExampleControls').carousel('pause')
    }*/
}

function guardardatos(){
   if(validacionform() == false){
        return;
    }
    var datoscliente = new FormData(a);

    datoscliente.append("tipo_prestamo", document.querySelector('input[name="preg1"]:checked').value);
    datoscliente.append("destino_vivienda", document.querySelector('input[name="preg2"]:checked').value  );
    datoscliente.append("identificada", document.querySelector('input[name="preg3"]:checked').value );
    datoscliente.append("estado", document.querySelector('input[name="preg4"]:checked').value   );
    datoscliente.append("rango_prestamo", document.querySelector('input[name="preg5"]:checked').value   );
    datoscliente.append("rango_edad", document.querySelector('input[name="preg6"]:checked').value);
    datoscliente.append("codeudor", document.querySelector('input[name="preg7"]:checked').value);
      var codeudor = document.querySelector('input[name="preg7"]:checked').value;
    if(codeudor == "NO"){
        datoscliente.append("estatus_laboral", document.querySelector('input[name="preg10"]:checked').value);
        datoscliente.append("tiempo_laborar", document.querySelector('input[name="preg11"]:checked').value);
        datoscliente.append("tiempo_empresa", document.querySelector('input[name="preg12"]:checked').value);
        datoscliente.append("tamaño_empresa", document.querySelector('input[name="preg13"]:checked').value);
        datoscliente.append("politico", document.querySelector('input[name="preg14"]:checked').value);
        datoscliente.append("ingresos", document.querySelector('input[name="preg15"]:checked').value);
        datoscliente.append("tiempo_desembolso", document.querySelector('input[name="preg22"]:checked').value);

    }else if(codeudor == "SI"){
        datoscliente.append("parentesco", document.querySelector('input[name="preg8"]:checked').value   );
        datoscliente.append("coexistir", document.querySelector('input[name="preg9"]:checked').value);
       
        datoscliente.append("estatus_laboral", document.querySelector('input[name="preg10"]:checked').value);
        datoscliente.append("tiempo_laborar", document.querySelector('input[name="preg11"]:checked').value);
        datoscliente.append("tiempo_empresa", document.querySelector('input[name="preg12"]:checked').value);
        datoscliente.append("tamaño_empresa", document.querySelector('input[name="preg13"]:checked').value);
        datoscliente.append("politico", document.querySelector('input[name="preg14"]:checked').value);
        datoscliente.append("ingresos", document.querySelector('input[name="preg15"]:checked').value);

        datoscliente.append("estatus_laboral_codeudor", document.querySelector('input[name="preg16"]:checked').value);
        datoscliente.append("tiempo_laboral_codeudor", document.querySelector('input[name="preg17"]:checked').value);
        datoscliente.append("tamaño_empresa_codeudor", document.querySelector('input[name="preg18"]:checked').value);
        datoscliente.append("tiempo_empresa_codeudor", document.querySelector('input[name="preg19"]:checked').value);
        datoscliente.append("politico_codeudor", document.querySelector('input[name="preg20"]:checked').value);
        datoscliente.append("ingresos_codeudor", document.querySelector('input[name="preg21"]:checked').value);
        datoscliente.append("tiempo_desembolso", document.querySelector('input[name="preg22"]:checked').value);
    } 

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "guardando datos",
        showConfirmButton: false,
    });
   
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

  var  nombre     = $("#nombre").val();
  var  apellidos = $("#apellidos").val();
  var  num_dui = $("#num_dui").val();
  var  correo = $("#correo").val();
  var  telefono = $("#telefono").val();
  var  edad = $("#edad").val();
  var  proyecto = $("#proyecto").val();

  if (validateEmail(correo) == false) {
    Swal.fire("¡El formato del correo no es correcto!");
    valido = false;
}
    if (nombre === "" ||
        apellidos === "" ||
        num_dui === "" ||
        correo === "" ||
        telefono === "" ||
        edad === "" ||
        proyecto === ""
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
    $('input[name=preg6]').prop('checked',false);
    $('input[name=preg7]').prop('checked',false);
    $('input[name=preg8]').prop('checked',false);
    $('input[name=preg9]').prop('checked',false);
    $('input[name=preg10]').prop('checked',false);
    $('input[name=preg11]').prop('checked',false);
    $('input[name=preg12]').prop('checked',false);
    $('input[name=preg13]').prop('checked',false);
    $('input[name=preg14]').prop('checked',false);
    $('input[name=preg15]').prop('checked',false);
    $('input[name=preg16]').prop('checked',false);
    $('input[name=preg17]').prop('checked',false);
    $('input[name=preg18]').prop('checked',false);
    $('input[name=preg19]').prop('checked',false);
    $('input[name=preg20]').prop('checked',false);
    $('input[name=preg21]').prop('checked',false);
    $('input[name=preg22]').prop('checked',false);

}