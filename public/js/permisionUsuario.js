

function modalPermisoUsuarios() {
    $("#frmPermisoUsuarios")[0].reset();
    $("#frmPermisoUsuarios .is-invalid").removeClass("is-invalid");
    $("#checkboxGroupError").hide(); // Ocultar el mensaje de error del grupo de checkboxes
    $("#modal-permiso-usuarios").modal("show");
}


function opcionesPermisosUsuarios(selectPermisos, id) {
    var opt = $(selectPermisos).val();

    switch (opt) {
        case "1":   
            quitaPermisosUsuarios(selectPermisos, id);
            break;
        case "2":
            agregarPermisoUsuario(selectPermisos , id, "2"); // Agregar permiso creador de clientes
            break;
        case "3":
            agregarPermisoUsuario(selectPermisos , id, "3"); // Agregar permiso gestionar clientes
            break;
        default:
            console.log("Opción no válida");
    }
    $(selectPermisos).prop("selectedIndex", 0);
}


function quitaPermisosUsuarios(selectThis ,id) {
    Swal.fire({
        title: "¿Estas seguro de quitar los permisos a este usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, quitar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {

            axios.post(principalUrl + "usuarios/permisos/"+id )
            .then((respuesta) => {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "Permisos eliminados con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    $(selectThis).closest('tr').remove(); 
                    $("#selectUsuariosAsignado").append(`<option value="${respuesta.data.id}">${respuesta.data.name}</option>`);
                });
            })
            .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
            });
            
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}


function agregarPermisoUsuario(selectThis, id, permiso) {

    axios.post(principalUrl + "usuarios/permisos/"+id+"/editar", {
        permiso: permiso
    }) 
    .then((respuesta) => {
        Swal.fire({
            title: "¡Éxito!",
            text: "Se ha agregado nuevo permiso a usuario.",
            icon: "success",
            confirmButtonText: "Aceptar"
        }).then(() => {
            if (permiso === "2") {
                $(selectThis).closest('tr').find('td').eq(2)
                    .html('✅');
            } else if (permiso === "3") {
                $(selectThis).closest('tr').find('td').eq(1)
                    .html('✅');
            }
        });
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}



// agrega permisos
const formPermisos = document.getElementById('frmPermisoUsuarios'); 
formPermisos.addEventListener('submit', function (e) {
    e.preventDefault(); 

    const ruta = formPermisos.action; 
    const formData = new FormData(formPermisos); 
    
    axios.post(ruta, formData)
        .then((response) => {

            location.reload();
        })
    .catch(error => {
        console.error(error);
        if (error.response && error.response.status === 422) { 

            const jsonResponse = error.response.data;
            $("#frmPermisoUsuarios .is-invalid").removeClass("is-invalid");
            if (jsonResponse.errors) {
                for (const campo in jsonResponse.errors) {
                    $("#" + campo).addClass("is-invalid");

                    if (campo === 'permisos_usuarios') {
                        // $("#checkboxGroupError").remover estilo css("display", "none");
                        $("#checkboxGroupError").show();
                    }
                }
            }

        } else {
            console.error('Unexpected error:', error);
        }
    }). finally(() => {
        // Aquí puedes realizar cualquier acción adicional después de la solicitud
        // AQUI dejare una funcion que actualice el arbol de carpetas
    } );
});

