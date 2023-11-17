
$(document).ready(function () {

    datosforms();
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
    const telefonoValue = telefonoPart.substring(4, telefonoPart.length - 1);

    var ayudaPart='';
    var ayudaValue='';

      if(item.form_post_id == 782){
           ayudaPart = parts[parts.indexOf('s:20:"Comentario o mensaje"') + 1];
           var startIndex = ayudaPart.indexOf(':"');
           if (startIndex !== -1) {
                ayudaValue = ayudaPart.substring(startIndex + 2, ayudaPart.length - 1);
           } else {
               ayudaValue ='';
           }
           
      }else if(item.form_post_id == 7){
         ayudaPart = parts[parts.indexOf('s:21:"Como podemos ayudarte"') + 1];

        var startIndex = ayudaPart.indexOf(':"');
        if (startIndex !== -1) {
             ayudaValue = ayudaPart.substring(startIndex + 2, ayudaPart.length - 1);
        } else {
            ayudaValue ='';
        }

    }

    var fechasformat =   moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A")

    if(telefonoValue.length < 20){
        return {
            Nombre: nombreValue.slice(1), 
            Teléfono: telefonoValue.replace(/[:"]/g, ''), 
            'Como podemos ayudarte': ayudaValue,
            fechaform : fechasformat,
            id_forms: item.form_id ,
            total_segui: item.total_seguimiento
        };
    }
    
    });

    var arrFiltrado = datosFiltrados.filter(function(elemento) {
        return elemento !== undefined;
      });
      
    tblformulario(arrFiltrado);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
          //  location.href = principalUrl + "agradecimiento";
        }
    });
}

function tblformulario(datosFiltrados){
   var tblfomrcontigo = $("#registro_clientes").DataTable();
   tblfomrcontigo.destroy();

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
            { data: 'fechaform',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'Como podemos ayudarte',
            width: "100px" },
            {
                data: "total_segui",
                width: "25px",
                className: "text-center",
                render: function (data, type, row) {
                  //  var id_notacita = row['id'];
                    return `<td>
                    <button type="button" class="btn btn-primary">
                    <i class="bi bi-bell bi-3x icono_notas"></i> <span class="badge badge-light">`+data+`</span>
                    <span class="sr-only">unread messages</span>
                  </button>
                  </td>
                  `;
                },
            },
            { data: "id_forms",
            width: "100px" ,
            render: function (data, type, row) {
                return (
                    '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option></selec>'
                );
            }
        },
        ],
        columnDefs: [
            {
                targets: 0,
                type: 'date-ddmmyyyy' 
            }
        ]
    });

    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        'date-ddmmyyyy-pre': function (a) {
            // Formato: vie. 10 nov. 2023 06:54 PM
            var months = {
                'ene.': 1, 'feb.': 2, 'mar.': 3, 'abr.': 4, 'may.': 5, 'jun.': 6,
                'jul.': 7, 'ago.': 8, 'sep.': 9, 'oct.': 10, 'nov.': 11, 'dic.': 12
            };
            var dateParts = a.split(' ');
            var day = parseInt(dateParts[1]);
            var month = months[dateParts[2].toLowerCase()];
            var year = parseInt(dateParts[3]);
            var timeParts = dateParts[4].split(':');
            var hour = parseInt(timeParts[0]);
            var minutes = parseInt(timeParts[1]);
            var period = dateParts[5].toUpperCase();
    
            if (period === 'PM' && hour < 12) {
                hour += 12;
            }
            var isoDate = new Date(year, month - 1, day, hour, minutes).toISOString();
            return isoDate;
        },
        'date-ddmmyyyy-asc': function (a, b) {
            return a.localeCompare(b);
        },
        'date-ddmmyyyy-desc': function (a, b) {
            return b.localeCompare(a);
        }
    });
}

function vistaregistro(){
    location.href = principalUrl + "vis_usuarios";
}

function opcionesformcontigo(option, id) {
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
