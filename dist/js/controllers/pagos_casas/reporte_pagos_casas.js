let valueTab;
let valueTabline;
let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        if(data.finalizado){
            return 'finalizado'
        }

        return data.procesoNombre
    } },
    { data: function(data){
        return `${data.avanceObra} %`
    } },
    { data: function(data){
        return data.fechaCreacion.substring(0, 16)
    } },
    { data: function(data){
        return data.fechaProceso ? data.fechaProceso.substring(0, 16) : ''
    } },
    { data: function(data){
        let inicio = new Date(data.fechaProceso)
        let today = new Date()

        let difference = today.getTime() - inicio.getTime()

        let days = Math.floor(difference / (1000 * 3600 * 24))

        let text = `Lleva ${days} día(s)`

        if(data.finalizado){
            text = 'FINALIZADO'
        }

        return text
    } },
    { data: function(data){
        let button = new RowButton({icon: 'info', label: 'HISTORIAL DE MOVIMIENTOS', onClick: show_historial, data});
        return `<div class="d-flex justify-center">${button}</div>`;
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_reporte_pagos',
    columns,
})

let filtro_proceso = new SelectFilter({ id: 'opcion', label: 'Proceso',  placeholder: 'Selecciona una opción'})

filtro_proceso.onChange(function(option){
    table.setParams({opcion: option.value})
    table.reload()
});

show_historial = function (dt) {
    let esquemaCredito = 2;
    $("#spiner-loader").removeClass('hide');
    $("#timeLineModal").modal();
    $("#historialActual").html("");
    console.log("data: ", dt);

    $.post(`getHistorial/${dt.idProcesoPagos}/${esquemaCredito}`).done(function (data) {
        console.log("data: ", data);
        // Check if data is not empty before parsing
        if (data && data.trim() !== "") {
            let parsedData = JSON.parse(data); // Parse only if data is not empty

            if (parsedData.length > 0) {
                $.each(parsedData, function (i, v) {
                    $("#spiner-loader").addClass('hide');
                    let timeLine = new TimeLine({
                        title: v.nombreUsuario,
                        back: v.procesoAnterior,
                        next: v.procesoNuevo,
                        description: v.descripcion,
                        date: v.fechaMovimiento
                    });
                    lineCredito(timeLine);
                });
            } else {
                emptyLog();
                $("#spiner-loader").addClass('hide');
            }
        } else {
            // Handle empty or invalid data
            emptyLog();
            $("#spiner-loader").addClass('hide');
            console.warn("Empty or invalid JSON data received.");
        }
    }).fail(function () {
        // Handle AJAX request failure
        $("#spiner-loader").addClass('hide');
        console.error("Failed to fetch data.");
    });
}




function lineCredito(timeLine) {
    $("#historialActual").append(`${timeLine}`);
}

$.ajax({
    type: 'GET',
    url: 'options_procesos',
    success: function (response) {
        let status_option = [
            {value: -1, label: 'Todos'},
            ...response,
            {value: -2, label: 'Finalizado'},
        ]
        filtro_proceso.setOptions(status_option)
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proceso,
    ],
})