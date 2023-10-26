var principalUrl = "http://localhost/precalificacion1/public/";

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
        ],
    });

});