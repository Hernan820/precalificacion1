
$(document).ready(function () {

    $("#name,#email,#rol,#password,#password-confirms").val("");

    var repo = $("#tblusuarios").DataTable();


});


function registro_usuario(){

    var datos = new FormData();
    datos.append("nombre",$("#name").val()); 
    datos.append("email",$("#email").val()); 
    datos.append("rol",$("#rol").val()); 
    datos.append("contra",$("#password").val()); 

    axios.post(principalUrl + "registro/guardar", datos)
    .then((respuesta) => {
        
        respuesta.data

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

}



