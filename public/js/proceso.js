
let formdatoscliente = document.getElementById("cliente");

var principalUrl = "http://localhost/precalificacion1/public/";


  function inicioproceso(){
    location.href = principalUrl + "home/vista";  
  }

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
    } 
    return valido;
}



function siguiente(Pregunta){

    /* if(Pregunta == 1){
        $("#carouselExampleControls").carousel(22);
    }*/



    if(validarpreguntas(Pregunta) == false){
        return;
    }


    if(Pregunta == 5){
        var nada =document.querySelector('input[name="preg5"]:checked').value;
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

    }



}

function guardardatos(){
    
    var datoscliente = new FormData(formdatoscliente);

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
        datoscliente.append("tiempo_desembolso", document.querySelector('input[name="preg22"]:checked').value);

        datoscliente.append("estatus_laboral_codeudor", document.querySelector('input[name="preg16"]:checked').value);
        datoscliente.append("tiempo_laboral_codeudor", document.querySelector('input[name="preg17"]:checked').value);
        datoscliente.append("tamaño_empresa_codeudor", document.querySelector('input[name="preg18"]:checked').value);
        datoscliente.append("tiempo_empresa_codeudor", document.querySelector('input[name="preg19"]:checked').value);
        datoscliente.append("politico_codeudor", document.querySelector('input[name="preg20"]:checked').value);
        datoscliente.append("ingresos_deudor", document.querySelector('input[name="preg21"]:checked').value);
        datoscliente.append("tiempo_desembolso", document.querySelector('input[name="preg22"]:checked').value);
    }

    
    axios.post(principalUrl + "home/precalificacion", datoscliente)
    .then((respuesta) => {
        if(respuesta.data == "1"){
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "ya se guardaron los datos",
                showConfirmButton: false,
            });
        }
        location.reload();
        $("#popup_cancelar").modal("hide");
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}