
$(document).ready(function () {
    datosforms();
    obtenerDatoPreregistro();
    obtenerDatosGuia();
    obtener_datos_evento_entre_nosotras();

    axios.post(principalUrl + "seminarios")
    .then((respuesta) => {

    let datosformulario = respuesta.data;
    let frmnuevos = [];
    let frmeliminados = [];

    let estadosselect=[];

    datosformulario.map(item => {

        if(item.estado != 0){

            var total_seguimientoform =item.total_seguimiento;
            var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");
            frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg:"+item.estado+";vacio");
        }else{
            frmeliminados.push(item.form_value);
        }

        return;
    });

    frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");

        var keyestado = elements[7].split(":");
        var estadofiltro = keyestado[keyestado.length - 1].trim().replace(/"/g, '');

        if (estadosselect.includes(estadofiltro) == false) {
            estadosselect.push(estadofiltro);  
        }

        return ;
    }); 

    $("#seletc_estados,#seletc_estados_eliminados").html("");
    $("#seletc_estados,#seletc_estados_eliminados").append("<option selected readonly value=''>Seleciona estado</option>");

    let selectEstadosFinalizado = $("#seletc_estados_finalizado");
    selectEstadosFinalizado.html("<option selected readonly value=''>Seleciona estado</option>");

    var fechaactual = moment().format("YYYY-MM-DD");

    console.log(estadosselect);

    estadosselect.forEach(function (element) {

            let displayText = '';
            if (element.includes('*')) {
                let parts = element.split('*');
                var formatfecha = moment(parts[1], "YYYY-MM-DD").format("DD MMM");

                if (fechaactual > parts[1]) {

                    let stateParts = parts[0].split('_');
                    displayText = (stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0]) + ` - ${formatfecha}`; 

                    if (parts.length == 3) {
                        selectEstadosFinalizado.append(`<option readonly value='${element}'>${displayText} (${parts[2]})</option>`);
                    }else{
                        selectEstadosFinalizado.append(`<option readonly value='${element}'>${displayText}</option>`);
                    }
  
                }else{

                    let stateParts = parts[0].split('_');
                    displayText = (stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0]) + ` - ${formatfecha}`;

                    if (parts.length == 3) {
                        $("#seletc_estados").append(`<option  readonly value='${element}'>${displayText} (${parts[2]})</option>`);
                    } else {
                        $("#seletc_estados").append(`<option  readonly value='${element}'>${displayText}</option>`);
                    }
                }

                let stateParts = parts[0].split('_');
                displayText = (stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0]) + ` - ${formatfecha}`;
                $("#seletc_estados_eliminados").append(`<option  readonly value='${element}'>${displayText}</option>`);

            } else {

                if (fechaactual <= '2024-06-15' && element == "new_york" ) {
                    let stateParts = element.split('_');
                    displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                    $("#seletc_estados").append(`<option  readonly value='${element}'>${displayText}</option>`);
                }else{

                let stateParts = element.split('_');
                displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                selectEstadosFinalizado.append(`<option readonly value='${element}'>${displayText}</option>`);
                }

                $("#seletc_estados_eliminados").append(`<option  readonly value='${element}'>${displayText}</option>`);
            }
    });

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

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
        let frmseminarios_eliminado = [];

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
        var tipo_formulario='';

        if(item.form_post_id == 782){
            ayudaPart = parts[parts.indexOf('s:20:"Comentario o mensaje"') + 1];
            var startIndex = ayudaPart.indexOf(':"');
            if (startIndex !== -1) {
                    ayudaValue = ayudaPart.substring(startIndex + 2, ayudaPart.length - 1);
            } else {
                ayudaValue ='';
            }
            tipo_formulario=item.form_post_id;
            
        }else if(item.form_post_id == 7){
            ayudaPart = parts[parts.indexOf('s:21:"Como podemos ayudarte"') + 1];

            var startIndex = ayudaPart.indexOf(':"');
            if (startIndex !== -1) {
                ayudaValue = ayudaPart.substring(startIndex + 2, ayudaPart.length - 1);
            } else {
                ayudaValue ='';
            }
            tipo_formulario=item.form_post_id;

        }else if(item.form_post_id == 2893){
            ayudaPart = parts[parts.indexOf('s:10:"Comentario"') + 1];

            var startIndex = ayudaPart.indexOf(':"');
            if (startIndex !== -1) {
                ayudaValue = ayudaPart.substring(startIndex + 2, ayudaPart.length - 1);
            } else {
                ayudaValue ='';
            }
            tipo_formulario=item.form_post_id;
        }else

        {
            if(item.form_post_id != 919){
                if(item.estado != 0){
                var total_seguimientoform =item.total_seguimiento;
                var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");

                frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";vacio");
               }else{
                var total_seguimientoform =item.total_seguimiento;
                frmseminarios_eliminado.push(item.form_value+";fecha:"+moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A")+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";vacio");
               }
            tipo_formulario=item.form_post_id;

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
                    total_segui: item.total_seguimiento,
                    tipo_form: tipo_formulario
                };
            }else{
                datos_eliminaos.push({
                    Nombre: nombreValue.slice(1),
                    Teléfono: telefonoValue.replace(/[:"]/g, ''),
                    'Como podemos ayudarte': ayudaValue,
                    fechaform: fechasformat,
                    id_forms: item.form_id,
                    total_segui: item.total_seguimiento,
                    tipo_form: tipo_formulario
                });
            }
         }
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
       tblformulario_eliminados(arrFiltrado_elimin);
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}

function obtener_datos_evento_entre_nosotras() {

    axios.post(principalUrl + "datos/form_entrenosotras")
        .then((respuesta) => {
        tbl_Evento_Entre_Nosotras(respuesta.data);            
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}

function obtenerDatoPreregistro() {
  
    axios.post(principalUrl + "seminarios-preregistro")
    .then((respuesta) => {

        let datosformulario = respuesta.data;
        let frmnuevos = [];
        let sin_estado=0;
        let confirmado=0;
        let no_answer=0;
        let cancelado=0;

    datosformulario.map(item => {

        if(item.estado != 0){

            var total_seguimientoform =item.total_seguimiento;
            var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");
            frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg:"+item.estado+";vacio");
        }
        return;
    });

    var datosSemiPre = frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");
    
        let cleanData = {};
        
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
                var valor = keyValue[1].split(" ");
                    valor.pop();
                var ordenado = valor[0]+" "+valor[1]+" "+valor[2]+" "+valor[3];   
                cleanData[dato] = ordenado;
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
            else if(keyValue[0] == "estado_reg" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                let valorformat;
                
                if (valor == "null") {
                    valorformat = "";
                    sin_estado=sin_estado+1;
                } else if(valor == "4") {
                    valorformat = "Confirmado";
                    confirmado=confirmado+1;
                }else if (valor == "5") {
                    valorformat = "No answer";
                    no_answer=no_answer+1;
                }else if (valor == "6") {
                    valorformat = "Cancelado";
                    cancelado=cancelado+1;
                }
                cleanData[dato] = valorformat;
            }
        });
        return cleanData;

     
    }).filter(item => item !== null); 

    $("#contador-semi-pre").find('td:eq(0)').text(sin_estado);
    $("#contador-semi-pre").find('td:eq(1)').text(confirmado);
    $("#contador-semi-pre").find('td:eq(2)').text(no_answer);
    $("#contador-semi-pre").find('td:eq(3)').text(cancelado);
    var total = sin_estado+confirmado+cancelado+no_answer;

    $("#contador-semi-pre").find('td:eq(4)').text(total);

    tbl_semPreRegistro(datosSemiPre);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });  
}

function tblformulario(datosFiltrados){
    var rol_usuario = $("#rol").val();
   var tblfomrcontigo = $("#registro_clientes").DataTable();
   tblfomrcontigo.destroy();

    tblfomrcontigo = $("#registro_clientes").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        data: datosFiltrados,
        columns: [
            { data: 'id_forms',
                width: "100px" },
            { data: 'fechaform',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'Como podemos ayudarte',
            width: "100px" },
            { data: 'tipo_form',
                width: "100px",
                render: function (data, type, row) {
                    if (data == '2893') {
                        return 'Campaña Renta';
                    } else {
                        return '';  
                    }
                },
            },
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
        // columnDefs: [
        //     {
        //         targets: 1,
        //         type: 'date-ddmmyyyy' 
        //     }
        // ]    
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
    var contadorfilas = 1;
   var tblfomrseminario = $("#registro_clientes_seminarios").DataTable();
       tblfomrseminario.destroy();

    tblfomrseminario = $("#registro_clientes_seminarios").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0,"desc"]],
        data: datosFiltrados_seminarios,
        columns: [
            { data: 'id_forms',
            width: "45px",
            render: function (data, type, row) {
                moment.locale('es');
                if (type === 'display') {
                    var total = contadorfilas++;
                    return total;
                } else {
                    return data;
                }
            }
            },
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'estado' ,
            width: "100px",
            render: function (data, type, row) {
              
                if (data.includes('*')){
                  var dataestadofecha = data.split('*');
                  var dataestado = dataestadofecha[0].split('_');

                  if (dataestadofecha.length == 3) {
                    var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]} (${dataestadofecha[2]})`; 
                  }else{
                    var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]}`; 
                  }
                    return displayText;
                }else{

                  var stateParts = data.split('_');
                  var displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                    return displayText;
                }
            },
            },
            { data: 'Comentario', width: "50px" },
           
            {data: 'estado_id',  width: "40px",
                render: function (data, type, row) {

                    var icono = '';
                    if (data == 4 ) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/confirmado.png">';
                    }else if (data == 5) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/telefono.png">';
                    }else if (data == 6) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/botonx.png">';
                    }else if (data == 0) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/reloj.png">';  
                    }
                    return icono ;
                },
            },
            { data: "total",
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
                    `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                    , this.closest('tr'),'tblseminario')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                        , this.closest('tr'),'tblseminario')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                    );
                }
            }
            },
        ],
        columnDefs: [
            {
                target: [0],
                visible: false
            },
            {
                aTargets: [6],
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    if (sData == 4) {
                        $(nTd)
                            .css("background-color", "#00FE1F")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    } else if (sData == 6) {
                        $(nTd)
                            .css("background-color", "#FE2300")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    }  else if (sData == 5) {
                        $(nTd)
                            .css("background-color", "#F88503")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    }else if (sData == 0) {
                        $(nTd)
                            .css("background-color", "#FEE700")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    }
                },
            },
        ]
    });

}


function tblformulario_seminarios_fin(semina_finalizado){
    var rol_usuario = $("#rol").val();
   var tblfomrseminario = $("#tbl_seminarios_finalizados").DataTable();
       tblfomrseminario.destroy();

    tblfomrseminario = $("#tbl_seminarios_finalizados").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0,"desc"]],
        data: semina_finalizado,
        columns: [
            { data: 'id_forms',
            width: "100px"},
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'estado' ,
            width: "100px",
            render: function (data, type, row) {
              
                if (data.includes('*')){
                  var dataestadofecha = data.split('*');
                  var dataestado = dataestadofecha[0].split('_');
                  var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]}`; 
                    return displayText;
                }else{

                  var stateParts = data.split('_');
                  var displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                    return displayText;
                }
            },
            },
            { data: 'Comentario',
            width: "50px" },
            { data: 'estado_reg',
            width: "50px" },
            { data: "total",
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
                    `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                    , this.closest('tr'),'tblsemifinalizado')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                        , this.closest('tr'),'tblsemifinalizado')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                    );
                }
            }
            },
        ],
        columnDefs: [
            {
                target: [0],
                visible: false
            }
        ]
    });
}

function tblformulario_seminarios_eliminado(datosFiltrados_seminarios){
    var rol_usuario = $("#rol").val();
   var tblfomrseminaio_eliminado = $("#registro_clientes_seminarios_eliminados").DataTable();
   tblfomrseminaio_eliminado.destroy();

    tblfomrseminaio_eliminado = $("#registro_clientes_seminarios_eliminados").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0,"desc"]],
        data: datosFiltrados_seminarios,
        columns: [
            { data: 'id_forms',
            width: "100px" },
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'estado' ,
            width: "100px",
            render: function (data, type, row) {
              
                if (data.includes('*')){
                  var dataestadofecha = data.split('*');
                  var dataestado = dataestadofecha[0].split('_');
                  var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]}`; 
                    return displayText;
                }else{

                  var stateParts = data.split('_');
                  var displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                    return displayText;
                }
            },
            },
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
            width: "100px"  ,
            render: function (data, type, row) {

                if(rol_usuario === "administrador"){
                return (
                    '<select id="usuario_opcion" onchange="opcionesformcontigo(this,' + data +
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="3">Bitacora</option></select>'
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

}

function tblformulario_eliminados(datosFiltrados_eliminados){
    var rol_usuario = $("#rol").val();
   var tblfomrcontigoelimin = $("#registro_clientes_eliminados").DataTable();
   tblfomrcontigoelimin.destroy();

    tblfomrcontigoelimin = $("#registro_clientes_eliminados").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0, "desc"]],
        data: datosFiltrados_eliminados,
        columns: [
            { data: 'id_forms',
            width: "100px" },
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
                    ')" class="form-control form-select-sm opciones"  placeholder="" style="width: 50% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="3">Bitacora</option></select>'
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

    });
}

function tbl_semPreRegistro(datosSemiPre) {

    var rol_usuario = $("#rol").val();
   var tblfomrsemiPre = $("#tbl_semi_pre_registro").DataTable();
       tblfomrsemiPre.destroy();

   var tblfomrsemiPre = $("#tbl_semi_pre_registro").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0,"desc"]],
        data: datosSemiPre,
        columns: [
            { data: 'id_forms',
            width: "100px"},
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            { data: 'estado' ,
            width: "100px",
            render: function (data, type, row) {
              
                if (data.includes('*')){
                  var dataestadofecha = data.split('*');
                  var dataestado = dataestadofecha[0].split('_');
                  var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]}`; 
                    return displayText;
                }else if(data.includes('_')){

                  var stateParts = data.split('_');
                  var displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                    return displayText;
                }else{
                    return data; 
                }
            },
            },
            { data: 'Comentario',
            width: "50px" },
            { data: 'estado_reg',
            width: "50px" },
            { data: "total",
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
                    `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                    , this.closest('tr'),'tblpreregistro')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                        , this.closest('tr'),'tblpreregistro')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                    );
                }
            }
            },
        ],
    });
}


function tbl_Evento_Entre_Nosotras(datosEntreNosotroas) {

    var rol_usuario = $("#rol").val();
   var tblfomrsemiPre = $("#tbl_evento_entre_nosotras").DataTable();
       tblfomrsemiPre.destroy();

   var tblfomrsemiPre = $("#tbl_evento_entre_nosotras").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
            lengthChange: false,
            pageLength: 20,
            bInfo: false,
            order: [[0,"asc"]],
            data: datosEntreNosotroas,
            columns: [
            { data: 'id_forms', width: "100px",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'form_date' ,width: "100px",
                render: function (data, type, row) {
                    moment.locale('es');
                    if (type === 'display') {
                        return moment(data).format("ddd. DD MMM. YYYY");
                    } else {
                        return data;
                    }
                }
            },
            { data: 'nombre'    ,width: "100px" },
            { data: 'telefono'  ,width: "100px"
                ,render: function (data, type, row) {
                    if (data) {
                        return data;
                    } else {
                        return 'No proporcionado';
                    }
                }
             },
            { data: 'ciudad'    ,width: "100px",
                render: function (data, type, row) {
                    if (data.includes('*')){
                        var dataestadofecha = data.split('*');
                        var dataestado = dataestadofecha[0].split('_');
                        var  displayText = (dataestado.length > 1 ? `${dataestado[0]} ${dataestado[1]}` : dataestado[0]) + ` - ${dataestadofecha[1]}`; 
                        return displayText;
                    }else if(data.includes('_')){
                        var stateParts = data.split('_');
                        var displayText = stateParts.length > 1 ? `${stateParts[0]} ${stateParts[1]}` : stateParts[0];
                        return displayText;
                    }else{
                        return data; 
                    }
                },
            },
            { data: 'estado', defaultContent: '',  width: "50px",
                render: function (data, type, row) {

                    if (!data && data !== 0) { return '';}

                    var icono = '';
                    if (data == 4 ) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/confirmado.png">';
                    }else if (data == 5) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/telefono.png">';
                    }else if (data == 6) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/botonx.png">';
                    }else if (data == 0) {
                        icono = '<img class="center-icon" src="' +principalUrl +'iconos/reloj.png">';  
                    }

                    return icono;
                },
            },
            { data: "total_seguimiento", width: "25px", className: "text-center",
                render: function (data, type, row) {
                    var contador = data || 0; // Asegurarse de que data no sea undefined
                  //  var id_notacita = row['id'];
                    return `<td>
                    <button type="button" class="btn btn-primary">
                    <i class="bi bi-bell bi-3x icono_notas"></i> <span class="badge badge-light">${contador}</span>
                    <span class="sr-only">unread messages</span>
                  </button>
                  </td>
                  `;
                },
            },
            { data: "form_id", width: "100px" ,
                render: function (data, type, row) {

                    var estadoOpcion = '';

                    if(rol_usuario === "administrador"){
                        return (
                            `<select id="usuario_opcion" onchange="opcioneseminarios(this,${data}
                            , this.closest('tr'),'tbl_entrenosotras')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;">
                                <option selected="selected" disabled selected>Acciones</option>
                                <option ${estadoOpcion} value="1">Seguimiento</option>
                                <option ${estadoOpcion} value="2">Eliminar</option>
                                <option ${estadoOpcion} value="4">Confirmado</option>
                                <option ${estadoOpcion} value="5">No answer</option>
                                <option ${estadoOpcion} value="6">cancelado</option>
                                <option ${estadoOpcion} value="3">Bitacora</option>
                                </select>`
                        );
                    }else if(rol_usuario === "usuario"){
                        return (
                            `<select id="usuario_opcion" onchange="opcioneseminarios(this,${data}
                            , this.closest('tr'),'tbl_entrenosotras')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;">
                                <option selected="selected" disabled selected>Acciones</option>
                                <option ${estadoOpcion} value="1">Seguimiento</option>
                                <option ${estadoOpcion} value="4">Confirmado</option>
                                <option ${estadoOpcion} value="5">No answer</option>
                                <option ${estadoOpcion} value="6">cancelado</option>
                                <option ${estadoOpcion} value="3">Bitacora</option>
                                </select>`
                        );
                    }
                }
            },
        ],
        columnDefs: [
            {
                aTargets: [5],
                fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    if (sData == 4) {
                        $(nTd)
                            .css("background-color", "#00FE1F")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    } else if (sData == 6) {
                        $(nTd)
                            .css("background-color", "#FE2300")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    }  else if (sData == 5) {
                        $(nTd)
                            .css("background-color", "#F88503")
                            .css("color", "#4F8A10")
                            .css("font-weight", "bold")
                            .css("text-align", "center");
                    }
                },
            },
        ]
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
        var estadoeli = 0;
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
                axios.post(principalUrl + "registro/estado_resgitro/"+id+"/"+estadoeli)
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

function opcioneseminarios(option, id, row,tbl) {
    var opt = $(option).val();

    if (opt == 1) {
        lista_seguimientos(id);
        $("#registropre_id").val(id);
        $("#modal_seguimiento").modal("show");
    } else if (opt == 2) {
        var estadoeli = 0;
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
                axios.post(principalUrl + "registro/estado_resgitro/"+id+"/"+estadoeli)
                    .then((respuesta) => {
                       // datosforms();
                        $(row).hide();

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

    }else if (opt == 4) {
        var num = 4;
        Swal.fire({
            text: "¿Estas seguro de confirmar este registro?",
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(principalUrl + "registro/estado_resgitro/"+id+"/"+num)
                    .then((respuesta) => {
                        if (tbl == 'tblpdf') {
                            $(row).find('td:eq(4)').text('Confirmado');
                        }else if (tbl == 'tbl_entrenosotras'){                                                       
                            $(row)
                            .find('td:eq(5)')
                            .html(`<img class="center-icon" src="${principalUrl}iconos/confirmado.png">`)
                            .css("background-color", "#00FE1F");
                        }else {
                            $(row).find('td:eq(6)').text('Confirmado');
                        }
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Registro Confirmado",
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
    }else if (opt == 5) {
        var num = 5;
        Swal.fire({
            text: "¿Quieres marcar como no answer el resgitro?",
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(principalUrl + "registro/estado_resgitro/"+id+"/"+num)
                    .then((respuesta) => {
                        if (tbl == 'tblpdf') {
                            $(row).find('td:eq(4)').text('No answer');
                        }else if (tbl == 'tbl_entrenosotras'){
                            $(row)
                            .find('td:eq(5)')
                            .html(`<img class="center-icon" src="${principalUrl}iconos/telefono.png">`)
                            .css("background-color", "#F88503");
                        }else{
                            $(row).find('td:eq(6)').text('No answer');
                        }
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Registro no answer",
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
    }else if (opt == 6) {
        var num = 6;
        Swal.fire({
            text: "¿Quieres marcar como cancelado el resgitro?",
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(principalUrl + "registro/estado_resgitro/"+id+"/"+num)
                    .then((respuesta) => {
                        if (tbl == 'tblpdf') {
                            $(row).find('td:eq(4)').text('Cancelado');
                        }else if (tbl == 'tbl_entrenosotras'){
                            $(row)
                            .find('td:eq(5)')
                            .html(`<img class="center-icon" src="${principalUrl}iconos/botonx.png">`)
                            .css("background-color", "#FE2300");
                        }else{
                            $(row).find('td:eq(6)').text('Cancelado');
                        }
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Registro cancelado",
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

$('#seletc_estados').on('change', function() {

    let selectval = $('#seletc_estados').val(); 

    axios.post(principalUrl + "seminarios")
    .then((respuesta) => {

        let datosformulario = respuesta.data;
        let frmnuevos = [];
        let sin_estado=0;
        let confirmado=0;
        let no_answer=0;
        let cancelado=0;

    datosformulario.map(item => {

        if(item.estado != 0){

            var total_seguimientoform =item.total_seguimiento;
            var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");
            frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg:"+item.estado+";vacio");
        }
        return;
    });

    var datos_limpios = frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");
    
        let cleanData = {};

        var keyestado = elements[7].split(":");
        var estadofiltro = keyestado[keyestado.length - 1].trim().replace(/"/g, '');

        if (estadofiltro == selectval) {
        
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
                var valor = keyValue[1].split(" ");
                    valor.pop();
                var ordenado = valor[0]+" "+valor[1]+" "+valor[2]+" "+valor[3];   
                cleanData[dato] = ordenado;
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
            else if(keyValue[0] == "estado_reg" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                let valorformat;
                var valor_estado_id = valor;

                if (valor == "null") {
                    valorformat = "Pendiente";
                    valor_estado_id = "0";
                    sin_estado=sin_estado+1;
                } else if(valor == "4") {
                    valorformat = "Confirmado";
                    confirmado=confirmado+1;
                }else if (valor == "5") {
                    valorformat = "No answer";
                    no_answer=no_answer+1;
                }else if (valor == "6") {
                    valorformat = "Cancelado";
                    cancelado=cancelado+1;
                }
                cleanData["estado_id"] = valor_estado_id;

                cleanData[dato] = valorformat;
            }
        });
        return cleanData;

     }else {
        return null; 
     }
    }).filter(item => item !== null); 


    $("#conteo_seminario").find('td:eq(0)').text(sin_estado);
    $("#conteo_seminario").find('td:eq(1)').text(confirmado);
    $("#conteo_seminario").find('td:eq(2)').text(no_answer);
    $("#conteo_seminario").find('td:eq(3)').text(cancelado);
    var total = sin_estado+confirmado+cancelado+no_answer;

    $("#conteo_seminario").find('td:eq(4)').text(total);

    tblformulario_seminarios(datos_limpios);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});

$('#seletc_estados_finalizado').on('change', function() {

    let selectval = $('#seletc_estados_finalizado').val(); 

    axios.post(principalUrl + "seminarios")
    .then((respuesta) => {

        let datosformulario = respuesta.data;
        let frmnuevos = [];
        let sin_estado=0;
        let confirmado=0;
        let no_answer=0;
        let cancelado=0;

    datosformulario.map(item => {

        if(item.estado != 0){

            var total_seguimientoform =item.total_seguimiento;
            var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");
            frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg:"+item.estado+";vacio");
        }
        return;
    });

    var datos_limpios = frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");
    
        let cleanData = {};

        var keyestado = elements[7].split(":");
        var estadofiltro = keyestado[keyestado.length - 1].trim().replace(/"/g, '');

        if (estadofiltro == selectval) {
        
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
                var valor = keyValue[1].split(" ");
                    valor.pop();
                var ordenado = valor[0]+" "+valor[1]+" "+valor[2]+" "+valor[3];   
                cleanData[dato] = ordenado;
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
            else if(keyValue[0] == "estado_reg" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                let valorformat;
                
                if (valor == "null") {
                    valorformat = "";
                    sin_estado=sin_estado+1;
                } else if(valor == "4") {
                    valorformat = "Confirmado";
                    confirmado=confirmado+1;
                }else if (valor == "5") {
                    valorformat = "No answer";
                    no_answer=no_answer+1;
                }else if (valor == "6") {
                    valorformat = "Cancelado";
                    cancelado=cancelado+1;
                }
                cleanData[dato] = valorformat;
            }
        });
        return cleanData;

     }else {
        return null; 
     }
    }).filter(item => item !== null); 


    $("#conteo_seminario_finalizado").find('td:eq(0)').text(sin_estado);
    $("#conteo_seminario_finalizado").find('td:eq(1)').text(confirmado);
    $("#conteo_seminario_finalizado").find('td:eq(2)').text(no_answer);
    $("#conteo_seminario_finalizado").find('td:eq(3)').text(cancelado);
    var total = sin_estado+confirmado+cancelado+no_answer;

    $("#conteo_seminario_finalizado").find('td:eq(4)').text(total);

    tblformulario_seminarios_fin(datos_limpios);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});

$('#seletc_estados_eliminados').on('change', function() {

    let selectval = $('#seletc_estados_eliminados').val(); 

    axios.post(principalUrl + "seminarios")
    .then((respuesta) => {

    let datosformulario = respuesta.data;
    let frmseminarios_eliminado = [];

    datosformulario.map(item => {

        if(item.estado == 0){
             var total_seguimientoform =item.total_seguimiento;
            frmseminarios_eliminado.push(item.form_value+";fecha:"+moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A")+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg: eliminado"+";vacio");
        }
        return;
    });


    var datos_seminarios_eliminados = frmseminarios_eliminado.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");

        var keyestado = elements[7].split(":");
        var estadofiltro = keyestado[keyestado.length - 1].trim().replace(/"/g, '');

        if (estadofiltro == selectval) {
    
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

                var valor = keyValue[1].split(" ");
                    valor.pop();
                var ordenado = valor[0]+" "+valor[1]+" "+valor[2]+" "+valor[3];   
                cleanData[dato] = ordenado;
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
            }else if(keyValue[0] == "estado_reg" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                let valorformat;
                
                if (valor == "null") {
                    valorformat = "";
                } else if(valor == "4") {
                    valorformat = "Confirmado";
                }else if (valor == "5") {
                    valorformat = "No answer";
                }else if (valor == "6") {
                    valorformat = "Cancelado";
                }
                cleanData[dato] = valorformat;
            }
        });
    
        return cleanData;
    }else {
        return null; 
     }
    }).filter(item => item !== null);

    tblformulario_seminarios_eliminado(datos_seminarios_eliminados);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});

function exportseminarioexcel(seminario_estado) {
    
    if (seminario_estado == 'finalizados') {
        var estado = $("#seletc_estados_finalizado").val();
    } else if (seminario_estado == 'vigentes') {
        var estado = $("#seletc_estados").val();
    }

    if (estado == "") {
        Swal.fire({
            text: "¡Para exportar la informacion de seminarios, debes seleccionar un estado!",
            showCancelButton: false,
            confirmButtonText: "Entiendo",
            cancelButtonText: "Cancelar",
        });
    }else{
        location.href = principalUrl + "seminario/exportar/"+estado;
    }
}



function obtenerDatosGuia() {
  
    axios.post(principalUrl + "registros-pdf")
    .then((respuesta) => {

        let datosformulario = respuesta.data;
        let frmnuevos = [];
        let sin_estado=0;
        let confirmado=0;
        let no_answer=0;
        let cancelado=0;

    datosformulario.map(item => {

        if(item.estado != 0){

            var total_seguimientoform =item.total_seguimiento;
            var fecha_formateada = moment(item.form_date, "YYYY-MM-DD HH:mm:ss").format("ddd DD MMM YYYY hh:mm A");
            frmnuevos.push(item.form_value+";fecha:"+fecha_formateada+";id_forms:"+item.form_id+";total:"+total_seguimientoform+";estado_reg:"+item.estado+";vacio");
        }
        return;
    });

    var datosGuiapdf = frmnuevos.map(function(form) {
        form = form.slice(6, -1);
    
        var elements = form.split(";");
    
        let cleanData = {};
        
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
            }else if(keyValue[0] == "fecha" ){
                var dato = keyValue[0];
                var valor = keyValue[1].split(" ");
                    valor.pop();
                var ordenado = valor[0]+" "+valor[1]+" "+valor[2]+" "+valor[3];   
                cleanData[dato] = ordenado;
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
            else if(keyValue[0] == "estado_reg" ){
                var dato = keyValue[0];
                var valor = keyValue[1];
                let valorformat;
                
                if (valor == "null") {
                    valorformat = "";
                    sin_estado=sin_estado+1;
                } else if(valor == "4") {
                    valorformat = "Confirmado";
                    confirmado=confirmado+1;
                }else if (valor == "5") {
                    valorformat = "No answer";
                    no_answer=no_answer+1;
                }else if (valor == "6") {
                    valorformat = "Cancelado";  
                    cancelado=cancelado+1;
                }
                cleanData[dato] = valorformat;
            }
        });
        return cleanData;

     
    }).filter(item => item !== null); 

    $("#contador-guiapdf").find('td:eq(0)').text(sin_estado);
    $("#contador-guiapdf").find('td:eq(1)').text(confirmado);
    $("#contador-guiapdf").find('td:eq(2)').text(no_answer);
    $("#contador-guiapdf").find('td:eq(3)').text(cancelado);
    var total = sin_estado+confirmado+cancelado+no_answer;

    $("#contador-guiapdf").find('td:eq(4)').text(total);

    tbl_guiapdf(datosGuiapdf);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });  
}


function tbl_guiapdf(datosSemiPre) {

    var rol_usuario = $("#rol").val();
   var tblfomrguia = $("#tbl_registro_pdf").DataTable();
       tblfomrguia.destroy();

   var tblfomrguia = $("#tbl_registro_pdf").DataTable({
        // language: {
        //     url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        // },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        order: [[0,"desc"]],
        data: datosSemiPre,
        columns: [
            { data: 'id_forms',
            width: "100px"},
            { data: 'fecha',
            width: "100px" },
            { data: 'Nombre' ,
            width: "100px" },
            { data: 'Teléfono' ,
            width: "100px" },
            
            { data: 'estado_reg',
            width: "50px" },
            { data: "total",
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
                    `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                    , this.closest('tr'),'tblpdf')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="2">Eliminar</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                );
                }else if(rol_usuario === "usuario"){
                    return (
                        `<select id="usuario_opcion" onchange="opcioneseminarios(this,` + data +`
                        , this.closest('tr'),'tblpdf')" class="form-control form-select-sm opciones pl-0 pr-0"  placeholder="" style="width: 75% !important;display: initial !important;height: calc(2.05rem + 2px) !important;"><option selected="selected" disabled selected>Acciones</option><option value="1">Seguimiento</option><option value="4">Confirmado</option><option value="5">No answer</option><option value="6">cancelado</option><option value="3">Bitacora</option>  </select>`
                    );
                }
            }
            },
        ],
    });
}

