
$(document).ready(function () {


    $("#registro_clientes").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        ajax: {
            url: principalUrl + "lista_cliente",
            dataSrc: "",
        },
        columns: [
            { data: "nombre_cliente" },
            { data: "telefono" },
            { data: "estado" }, 
            { data: "estatus" }, 
            { data: "tipo_trabajo" },
            { data: "hora_precio" },
            { data: "num_hora" }, 
            { data: "taxes2021" },
            { data: "taxes2022" }, 
            { data: "dowpayment" },
            { data: "comentarios" }, 
            { data: "id",
            render: function (data, type, row) {
                return (
                    '<select id="usuario_opcion" onchange="opcionesprecalificacion(this,' + data +
                    ')" class="form-control opciones"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option></selec>'
                );
            }
        },
        ],
    });

});

function vistaregistro(){
    location.href = principalUrl + "vis_usuarios";
}

function opcionesprecalificacion(option, id) {
    var opt = $(option).val();
    if (opt == 1) {
        $("#registropre_id").val(id);
        $("#modal_seguimiento").modal("show");

    } else if (opt == 2) {
        Swal.fire({
            title: "Eliminar",
            text: "¿Estas seguro de eliminar el registro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .post(principalUrl + "registro/eliminar_registro/" + id)
                    .then((respuesta) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Registro eliminado",
                            showConfirmButton: false,
                            timer: 1200,
                        });
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