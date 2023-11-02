
$(document).ready(function () {

    $("#name,#email,#rol,#password,#password-confirms").val("");
    tblusuarios();

});

function registro_usuario(){

    if (validausuario() == false) {return;}
    var idusuarioeditar = $("#id_usuario").val();

    var datos = new FormData();
    datos.append("nombre",$("#name").val()); 
    datos.append("email",$("#email").val()); 
    datos.append("rol",$("#rol").val()); 
    datos.append("contra",$("#password").val()); 

    if ($("#cambiar_contra").is(':checked') ) {
        datos.append("cambiarcontra","si"); 
    } else {
        datos.append("cambiarcontra","no"); 
    }
    datos.append("id_usuarioactualizar",idusuarioeditar); 

    if(idusuarioeditar === ""){

    axios.post(principalUrl + "registro/guardar", datos)
    .then((respuesta) => {
    
        limpiarForm();
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

 }else{
    axios.post(principalUrl + "registro/actualizar", datos)
    .then((respuesta) => {
    
        limpiarForm();
        tblusuarios();
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Usuario actualizado exitosamente',
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
                    '<select id="usuario_opcion" onchange="opcionusuarios(this,' + data +
                    ')" class="form-control opciones"><option selected="selected" disabled selected>Acciones</option><option value="1">Editar</option><option value="2">Eliminar</option></selec>'
                );
            }
        },
        ], 
    });
}

function opcionusuarios(option, id) {
    var opt = $(option).val();
    if (opt == 1) {

        axios.post(principalUrl + "usuario/editar/" + id)
            .then((respuesta) => {

                $("#name").val(respuesta.data[0].name);
                $("#email").val(respuesta.data[0].email);
                $("#rol").val(respuesta.data[0].nombre_rol);
                $("#password").val("*********");
                $("#password_confirm").val("*********");
                $("#id_usuario").val(respuesta.data[0].userid);

                $("#bqcontra").show();
                $("#btnnuevo").show();
                $("#btnregistrar").text("Actualizar");

                 document.getElementById("password").readOnly = true;
                 document.getElementById("password_confirm").readOnly = true;
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });

    } else if (opt == 2) {
        Swal.fire({
            title: "Eliminar",
            text: "¿Estas seguro de eliminar usuario?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .post(principalUrl + "registro/eliminar/" + id)
                    .then((respuesta) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Usuario eliminado",
                            showConfirmButton: false,
                            timer: 1200,
                        });
                        limpiarForm();
                        tblusuarios();
                    })
                    .catch((error) => {
                        if (error.response) {
                            console.log(error.response.data);
                        }
                    });
            } else {
            }
        });
    }
    $(option).prop("selectedIndex", 0);
}


$('#cambiar_contra').on('change', function() {
    if ($(this).is(':checked') ) {
        document.getElementById("password").readOnly = false;
        document.getElementById("password_confirm").readOnly = false;
        $("#password").val("");
        $("#password_confirm").val("");
        $("#password").focus();
    } else {
        document.getElementById("password").readOnly = true;
        document.getElementById("password_confirm").readOnly = true; 
        $("#password").val("**********");
        $("#password_confirm").val("**********");
    }
});

function limpiarForm() {

    $("#name,#email,#rol,#password,#password_confirm,#id_usuario").val("");
    document.getElementById("password").readOnly = false;
    document.getElementById("password_confirm").readOnly = false;
    $("#btnregistrar").text("Registrar");
    $("#name").focus();
    $("#bqcontra").hide();
    $("#btnnuevo").hide();
}