let valueTab;
let valueTabline;
document.addEventListener('DOMContentLoaded', function() {
    dataFunction(1);
});

function cleanTable(tableId) {
    if ($.fn.DataTable.isDataTable(tableId)) {
        let table = $(tableId).DataTable();
        table.clear().draw(); 
        table.rows().remove().draw();  
    }
}

function dataFunction(value) {
    valueTab = value;

    cleanTable('#tableDoct');
    cleanTable('#tableCredito');

    let tableConfig;

    if (valueTab == 1) {
        tableConfig = {
            id: '#tableDoct',
            url: `pagoscasas/lista_reporte_pagos/0`,
            buttons: buttons,
            columns: columns,
        };
    } else if (valueTab == 2) {
        tableConfig = {
            id: '#tableCredito',
            url: `pagoscasas/lista_reporte_pagos/1`,
            buttons: buttonActivo,
            columns: columnsFinalizado,
        };
    }

    if (tableConfig) {
        table = new Table(tableConfig);
    }
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title: "Validacion de documentación",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        },
        attr: {
            style: 'position: relative; float: left; margin: 5px',
        }
    }
]

let buttonActivo = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title: "Validacion de documentación",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        },
        attr: {
            style: 'position: relative; float: left; margin: 5px',
        }
    }
]


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

let columnsFinalizado = [
    { data: 'idLote'},
    { data: 'nombreLote'},
    { data: 'condominio'},
    { data: 'proyecto'},
    { data: 'cliente'},
    { data: 'nombreAsesor'},
    { data: 'gerente'},
    { data: function(data){
        console.log("Data: ", data);
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

/*let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_reporte_pagos',
    columns,
})*/

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
    $.post(`${general_base_url}/Pagoscasas/getHistorial/${dt.idProcesoPagos}/${esquemaCredito}`).done(function (data) {
        if (JSON.parse(data).length > 0) {
            $.each(JSON.parse(data), function(i, v) {
                $("#spiner-loader").addClass('hide');
                let backProcess = '';
                let previousText = '';
                let newText = '';
                let nextProcess = v.procesoNuevo;

                if (v.cambioStatus == '0') {
                    backProcess = v.procesoAnterior;
                    previousText = 'Proceso anterior: ';
                    newText = 'Proceso nuevo: ';
                }
                else {
                    backProcess = '';
                    newText = 'Proceso actual: ';
                }

                let timeLine = new TimeLine({
                    title: v.nombreUsuario,
                    back: backProcess,
                    next: nextProcess,
                    description: v.descripcionFinal,
                    date: v.fechaMovimiento,
                    previousText: previousText,
                    newText: newText
                });
                lineCredito(timeLine);
            });
        } else {
            emptyLog();
            $("#spiner-loader").addClass('hide');
        }
    });
}

function lineCredito(timeLine) {
    $("#historialActual").append(`${timeLine}`);
}

$.ajax({
    type: 'GET',
    url: valueTab == 1 ? 'options_procesos/0' : 'options_procesos/1',
    success: function (response) {
        let status_option = [
            {value: -1, label: 'Todos'},
            ...response
        ];
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