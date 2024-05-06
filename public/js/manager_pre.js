
$(document).ready(function () {
    datosforms();
});

function mostrarAnimacion(mensaje_noti) {
    let timerInterval;
    Swal.fire({
      title: mensaje_noti,
      //html: "I will close in <b></b> milliseconds.",
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();
        const timer = Swal.getPopup().querySelector("b");
        timerInterval = setInterval(() => {
          timer.textContent = `${Swal.getTimerLeft()}`;
        }, 100);
      },
      willClose: () => {
        clearInterval(timerInterval);
      }
    });
  }

document.getElementById("modalcampanapersonalizada").addEventListener("click", function () {
    $(".estados_citas").prop("checked", false);
    $("#txtmensaje_per").val('');
    $('#modal_campana_perso').modal('show');
});

document.getElementById("btncampana_personalizad").addEventListener("click", function () {
    var mensaje_per = $("#txtmensaje_per").val();

    if (mensaje_per === ""){Swal.fire("¡Agrega un mensaje personalizado antes de enviar la campaña!");return;}
    if ($(".estados_citas:checked").length == 0) {Swal.fire("¡Selecciona a que estados quieres enviar la campaña!");return;}

    Swal.fire({
        text: "¿Estás seguro de enviar un mensaje a todos los clientes registrado a los estados que has seleccionado?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "   Si  ",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {

            var estado_citas_enviar ;
            $(".estados_citas:checked").each(function (i,element) {
                if(i === 0){  
                estado_citas_enviar= $(element).val();
                }else{
                    estado_citas_enviar= estado_citas_enviar+','+ $(element).val(); 
                }
            });

            mostrarAnimacion("Enviando campaña");

            var datosmensaje = new FormData();
               datosmensaje.append("mensajetext",mensaje_per);
               datosmensaje.append("estado_citas",estado_citas_enviar);

            axios.post(principalUrl + "campana/mensajes",datosmensaje)
                .then((respuesta) => {
                    Swal.close();
                  if (respuesta.data == 1) {
                    
                   Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: "Campaña enviada de manera exitosa!",
                    showConfirmButton: false,
                   });
                   location.reload();
                  } 
                })
                .catch((error) => {
                    if (error.response) {
                        Swal.close();
                        console.log(error.response.data);
                    }
                });
        } 
    });
});

function datosforms(){
    axios.post(principalUrl + "formulariodatos")
    .then((respuesta) => {

        let datosformulario = respuesta.data;
        let datos_eliminaos =[] ;
        let frmnuevos = [];

        var datosFiltrados = datosformulario.map(item => {
        
        const parts = item.form_value.split(';');
        const nombrePart = parts[parts.indexOf('s:6:"Nombre"') + 1];
        const nombreValue = nombrePart.slice(4, -1); 

        let telefonoPart ;
        if(parts[4] === 's:0:\"\"'){   
            telefonoPart = parts[parts.indexOf('s:0:\"\"') + 1];
        }else{
            telefonoPart = parts[parts.indexOf('s:9:"Teléfono"') + 1];  
        }

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

        }else{
            if(item.form_post_id != 919){
                if(item.estado != 0){
                var total_seguimientoform =item.total_seguimiento;
                frmnuevos.push(item.form_value+";fecha:"+moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A")+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";vacio");
               }
            }
            return;
        }

        var fechasformat = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");

        if(telefonoValue.length < 20){

            if(item.estado != 0){
                return {
                    Nombre: nombreValue.slice(1), 
                    Teléfono: telefonoValue.replace(/[:"]/g, ''), 
                    'Como podemos ayudarte': ayudaValue,
                    fechaform : fechasformat,
                    id_forms: item.form_id ,
                    total_segui: item.total_seguimiento
                };
            }else{
                datos_eliminaos.push({
                    Nombre: nombreValue.slice(1),
                    Teléfono: telefonoValue.replace(/[:"]/g, ''),
                    'Como podemos ayudarte': ayudaValue,
                    fechaform: fechasformat,
                    id_forms: item.form_id,
                    total_segui: item.total_seguimiento
                });
            }
         }
       });

    var datos_limpios = frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");
    
        var cleanData = {};
        
        elements.forEach(function(element,i) {
            var keyValue = element.split(":");
            var key = keyValue[keyValue.length - 1].trim().replace(/"/g, '');

            if(key == "Nombre"  ){
                var formsiguiente = elements[i+1].split(":");
                var valor = formsiguiente[formsiguiente.length - 1].trim().replace(/"/g, '');
                cleanData[key] = valor;
            }else if(key == "Teléfono" ){
                var formsiguiente = elements[i+1].split(":");
                var valor = formsiguiente[formsiguiente.length - 1].trim().replace(/"/g, '');
                cleanData[key] = valor;
            }else if(key == "estado" ){
                var formsiguiente = elements[i+1].split(":");
                var valor = formsiguiente[formsiguiente.length - 1].trim().replace(/"/g, '');
                cleanData[key] = valor;
            }else if(key == "Comentario" ){
                var formsiguiente = elements[i+1].split(":");
                var valor = formsiguiente[formsiguiente.length - 1].trim().replace(/"/g, '');
                cleanData[key] = valor;
            }else if(keyValue[0] == "fecha" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                cleanData[dato] = valor;
            }else if(keyValue[0] == "total" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                if(keyValue[1] == ''){
                    valor = 0;
                }
                cleanData[dato] = valor;
            }else if(keyValue[0] == "id_forms" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                cleanData[dato] = valor;
            }
        });
    
        return cleanData;
    });


        var arrFiltrado = datosFiltrados.filter(function(elemento,i) {
            const telefonoRegex = /^\+1 \(\d{3}\)-\d{3}-\d{4}$/;
            if( elemento !== undefined   ){    
                if (telefonoRegex.test(elemento.Teléfono)) {
                    return elemento;
                }      
            }
        });

        var arrFiltrado_elimin = datos_eliminaos.filter(function(elemento,i) {
            const telefonoRegex = /^\+1 \(\d{3}\)-\d{3}-\d{4}$/;
            if( elemento !== undefined   ){    
                if (telefonoRegex.test(elemento.Teléfono)) {
                    return elemento;
                }      
            }
        });

       tblformulario(arrFiltrado);
       tblformulario_seminarios(datos_limpios)
       tblformulario_eliminados(arrFiltrado_elimin);
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
          //  location.href = principalUrl + "agradecimiento";
        }
    });
}

function tblformulario(datosFiltrados){
    var rol_usuario = $("#rol").val();
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

                if(rol_usuario === "administrador"){
                return (
                    '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="3">Bitacora</option></select>'
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                        ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option></select>'
                    );
                }
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

function tblformulario_seminarios(datosFiltrados_seminarios){
    var rol_usuario = $("#rol").val();
   var tblfomrseminario = $("#registro_clientes_seminarios").DataTable();
   tblfomrseminario.destroy();

    tblfomrseminario = $("#registro_clientes_seminarios").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        data: datosFiltrados_seminarios,
        columns: [
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'estado' ,
            width: "100px" },
            { data: 'Comentario',
            width: "100px" },
            {
                data: "total",
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

                if(rol_usuario === "administrador"){
                return (
                    '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="3">Bitacora</option></select>'
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                        ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option></select>'
                    );
                }
            }
        },
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

function tblformulario_eliminados(datosFiltrados_eliminados){
    var rol_usuario = $("#rol").val();
   var tblfomrcontigo = $("#registro_clientes_eliminados").DataTable();
   tblfomrcontigo.destroy();

    tblfomrcontigo = $("#registro_clientes_eliminados").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        data: datosFiltrados_eliminados,
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

                if(rol_usuario === "administrador"){
                return (
                    '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="3">Bitacora</option></select>'
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                        ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option></select>'
                    );
                }
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
                        datosforms();
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
    }else if (opt == 3) {

        axios.post(principalUrl + "registro/bitacora/"+id)
        .then((respuesta) => {
            $('#lista_bitacora').html('');

            if(respuesta.data.length === 0){
                Swal.fire({
                    position: "top-center",
                    icon: "info",
                    title: "No tiene bitacoras",
                    showConfirmButton: false,
                });
                return;
            }
            respuesta.data.forEach(function (element) {
                if(element.accion != 'Se creo la cita' || element.accion != 'reagendado'  ){
                    $("#lista_bitacora").append(
                        "<tr class='filas'><td>" +element.name+"</td><td>" + moment(element.fecha, "YYYY-MM-DD hh:mm A").format("DD-MMM-YY")  + "</td><td>" + moment(element.fecha, "YYYY-MM-DD hh:mm A").format("hh:mm A")  + "</td><td>" + element.accion +"</td></tr>"
                    );
                }
            });     
            $("#modal_bitacora_fmr").modal("show");
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
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
                "<tr><td>" +element.name +"</td><td>" +moment(element.fecha, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY  hh:mm A")+"</td><td>" +element.seguimiento +"</td></tr>"
            );
        });
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}
