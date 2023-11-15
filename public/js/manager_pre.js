
$(document).ready(function () {

    datosforms();

   // tblprecalificaciones();
});


function datosforms(){

    axios.post(principalUrl + "formulariodatos")
    .then((respuesta) => {

    let datosformulario = respuesta.data;
 
    var datosFiltrados = datosformulario.map(item => {
    
    const parts = item.form_value.split(';');
    const nombrePart = parts[parts.indexOf('s:6:"Nombre"') + 1];
    const nombreValue = nombrePart.slice(4, -1); 
    const telefonoPart = parts[parts.indexOf('s:9:"Teléfono"') + 1];
    const telefonoValue = telefonoPart.slice(4, -1).replace(/^"+/, ''); 
    const ayudaPart = parts[parts.indexOf('s:21:"Como podemos ayudarte"') + 1];
    const ayudaValue = ayudaPart.slice(4, -1).replace(/^"+/, ''); 

    return {
        Nombre: nombreValue.slice(1, -1), 
        Teléfono: telefonoValue.slice(1, -1), 
        'Como podemos ayudarte': ayudaValue.slice(1, -1),
        id_forms: item.form_id 
    };

    });

    tblformulario(datosFiltrados);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
            location.href = principalUrl + "agradecimiento";
        }
    });
}


function tblformulario(datosFiltrados){
   var tblfomrcontigo = $("#registro_clientes").DataTable();
   tblfomrcontigo.destroy();

//    tblfomrcontigo =   $('#registro_clientes').DataTable({
//         data: datosFiltrados,
//         columns: [
//             { data: 'Nombre' },
//             { data: 'Teléfono' },
//             { data: 'Como podemos ayudarte' }
//         ]
//     });


    tblfomrcontigo = $("#registro_clientes").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        data: datosFiltrados,
        columns: [
            { data: 'Nombre' },
            { data: 'Teléfono' },
            { data: 'Como podemos ayudarte' },
            { data: "id_forms",
            render: function (data, type, row) {
                return (
                    '<select id="usuario_opcion" onchange="opcionesprecalificacion(this,' + data +
                    ')" class="form-control opciones"  placeholder="prubeanomas"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option></selec>'
                );
            }
        },
        ],
    });

}



// function tblprecalificaciones(){

//     var tblpre = $("#registro_clientes").DataTable();
//     tblpre.destroy();

//    tblpre = $("#registro_clientes").DataTable({
//         language: {
//             url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
//         },
//         lengthChange: false,
//         pageLength: 20,
//         bInfo: false,
//         order: [[0, "desc"]],
//         ajax: {
//             url: principalUrl + "lista_cliente",
//             dataSrc: "",
//         },
//         columns: [
//             { data: "nombre_cliente" },
//             { data: "telefono" },
//             { data: "estado" }, 
//             { data: "estatus" }, 
//             { data: "tipo_trabajo" },
//             { data: "hora_precio" },
//             { data: "num_hora" }, 
//             { data: "taxes2021" },
//             { data: "taxes2022" }, 
//             { data: "dowpayment" },
//             { data: "comentarios" }, 
//             { data: "id",
//             render: function (data, type, row) {
//                 return (
//                     '<select id="usuario_opcion" onchange="opcionesprecalificacion(this,' + data +
//                     ')" class="form-control opciones"  placeholder="prubeanomas"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option></selec>'
//                 );
//             }
//         },
//         ],
//     });
// }

function vistaregistro(){
    location.href = principalUrl + "vis_usuarios";
}

function opcionesprecalificacion(option, id) {
    var opt = $(option).val();
    if (opt == 1) {
        lista_seguimientos(id);
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
                axios.post(principalUrl + "registro/eliminar_registro/" + id)
                    .then((respuesta) => {
                        tblprecalificaciones();
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

$('#btnseguimiento').on('click', function() {
    var id = $("#registropre_id").val();
    var datos = new FormData();
    datos.append("id_registro",id); 
    datos.append("txtseguimiento",$("#txtseguimiento").val()); 

    axios.post(principalUrl + "registro/guardar_seguimiento", datos)
    .then((respuesta) => {
        $("#txtseguimiento").val("");
        $("#txtseguimiento").focus();
        lista_seguimientos(id);
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Registro creado exitosamente!",
            showConfirmButton: false,
            timer: 1200,
        });
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});

function lista_seguimientos(id){

    axios.post(principalUrl + "registro/listado/" + id)
    .then((respuesta) => {
        $("#tblseguimientos").html("");
        respuesta.data.forEach(function (element) {
            $("#tblseguimientos").append(
                "<tr><td>" +element.name +"</td><td>" +moment(element.fecha, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY")+"</td><td>" +element.seguimiento +"</td></tr>"
            );
        });
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}


/**
 * 
 * 

const parts = [
    0:"a:4:{s:16:\"WPFormsDB_status\""
    1:"s:6:\"unread\""
    2:"s:6:\"Nombre\""
    3:"s:9:\"hgfhfhgfh\""
    4:"s:9:\"Teléfono\""
    5:"s:17:\"+1 (567)-657-6575\""
    6:"s:21:\"Como podemos ayudarte\""
    7:"s:14:\"jhgjhjghfjhfgj\""
    8:     "}"
    length
    : 
    9
]
 */