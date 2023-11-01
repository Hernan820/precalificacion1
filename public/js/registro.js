
$(document).ready(function () {

    $("#name,#email,#rol,#password,#password-confirms").val("");
    tblusuarios();
});

function registro_usuario(){

    if (validausuario() == false) {return;}

    var datos = new FormData();
    datos.append("nombre",$("#name").val()); 
    datos.append("email",$("#email").val()); 
    datos.append("rol",$("#rol").val()); 
    datos.append("contra",$("#password").val()); 

    axios.post(principalUrl + "registro/guardar", datos)
    .then((respuesta) => {
    
        $("#name,#email,#rol,#password,#password_confirm").val("");
        $("#name").focus();
        tblusuarios();
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Usuario creado exitosamente',
            showConfirmButton: false,
            timer: 1000
          })
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}

const validateEmail = (email) => {
    var format =
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var formato = format.test(email);
    return formato;
};

function validausuario(){
    var valido = true;
    var email = $("#email").val();
    var nombre = $("#name").val();
    var rol = $("#rol").val();
    var password = $("#password").val();
    var passwordconfirm = $("#password_confirm").val();
    
    if (password.length < 8) {
        Swal.fire("¡Error la contraseña debe tener minimo 8 cararteres!");
        valido = false;
    }

    if (password != passwordconfirm) {
        Swal.fire("¡Error la contraseña confirmacion no es la misma!");
        valido = false;
    }

    if (validateEmail(email) == false) {
        Swal.fire("¡Error formato de correo no correcto!");
        valido = false;
    }

    if (password === "") {
        Swal.fire("¡Agrega una contraseña al usuario!");
        valido = false;
    }

    if (rol === "") {
        Swal.fire("¡Agrega un rol al usuario!");
        valido = false;
    }

    if (email === "") {
        Swal.fire("¡Agrega un email al usuario!");
        valido = false;
    }

    if (nombre === "") {
        Swal.fire("¡Agrega un nombre para tu usuario!");
        valido = false;
    }

    return valido;
}

function tblusuarios(){

    var repo = $("#tblusuarios").DataTable();
    repo.destroy();

    repo  =  $("#tblusuarios").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        ajax: {
            url: principalUrl + "usuarios/mostrar",
            dataSrc: "",
        },
        columns: [
            { data: "name"},
            { data: "email" },
            { data: "nombre_rol" },
            { data: "userid",
            render: function (data, type, row) {
                return (
                    '<select id="usuario_accion" onchange="accionesUsuarios(this,' + data +
                    ')" class="form-control opciones"><option selected="selected" disabled selected>Acciones</option><option value="1">Editar</option><option value="2">Eliminar</option></selec>'
                );
            }
        },
        ], 
    });
}
