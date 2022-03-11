var principalUrl = "http://localhost/precalificacion1/public/";


  function inicioproceso(){
    location.href = principalUrl + "home/vista";  
  }


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


    if(Pregunta != 7 && Pregunta != 15 ){
        $('#carouselExampleControls').carousel('next')

    }else if (Pregunta == 7){
        var descrip =document.querySelector('input[name="preg7"]:checked');
        var codeudor = $(descrip).val();
        if(codeudor == 2){
            $("#carouselExampleControls").carousel(9);
        }else{
            $('#carouselExampleControls').carousel('next')
        }
    }else if(Pregunta == 15){
        var descrip =document.querySelector('input[name="preg7"]:checked');
        var codeudor = $(descrip).val();
        if(codeudor == 2){
            $("#carouselExampleControls").carousel(21);
        }else{
            $('#carouselExampleControls').carousel('next')
        }  
    }

}


