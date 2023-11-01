
$(document).ready(function () {

    $("#name,#email,#rol,#password,#password-confirms").val("");
    tblusuarios();
});


function registro_usuario(){

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
