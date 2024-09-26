var valueTab;
var valueTabline;
var table;

document.addEventListener('DOMContentLoaded', function () {
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
            url: 'casas/lista_reporte_casas',
            buttons: buttons,
            columns: columns,
        };
    } else if (valueTab == 2) {
        tableConfig = {
            id: '#tableCredito',
            url: 'casas/getReporteProcesoCredito',
            buttons: buttonsCredito,
            columns: columnsCredito,
        };
    }

    if (tableConfig) {
        table = new Table(tableConfig);
    }
}

go_to_historial = function (data) {
    window.location.href = `historial/${data.idProcesoCasas}`;
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

let buttonsCredito = [
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
    { data: 'procesoNombre' },
    {
        data: function (data) {
            if(data.fechaCreacion)
            return data.fechaCreacion.substring(0, 16)
        }
    },
    {
        data: function (data) {
            return data.fechaProceso ? data.fechaProceso.substring(0, 16) : ''
        }
    },
    {
        data: function (data) {
            let inicio = new Date(data.fechaProceso)
            let today = new Date()

            let difference = today.getTime() - inicio.getTime()

            let days = Math.floor(difference / (1000 * 3600 * 24))

            let text = `Lleva ${days} día(s)`

            return text
        }
    },
    {
        data: function (data) {
            switch (data.tipoMovimiento) {
                case 1:
                    clase = 'warning'
                    break
                case 2:
                    clase = 'orange'
                    break
                default:
                    clase = 'blueMaderas'
            }

            return `<span class="label lbl-${clase}">${data.movimiento}</span>`
        }
    },
    {
        data: function (data) {
            let button = new RowButton({ icon: 'info', label: 'HISTORIAL DE MOVIMIENTOS', onClick: modalHistorialBanco, data })
            return `<div class="d-flex justify-center">${button}</div>`
        }
    },
]

let columnsCredito = [
    { data: 'idLote' },
    {
        data: function (data) { return `${data.nombreLote}` }
    },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'nombreCliente' },
    { data: 'nombreAsesor' },
    { data: 'nombreGerente' },
    { data: 'nombreProceso' },
    { data: 'fechaCreacion' },
    { data: 'fechaAvance' },
    { data: 'tiempoProceso' },
    {
        data: (d) => {
            return `<span class="label" 
                style="color: ${d.color}; background: ${d.color}18;}">
                ${d.nombreMovimiento}
            </span>`;
        }
    },
    {
        data: function (data) {
            let button = new RowButton({ icon: 'info', label: 'HISTORIAL DE MOVIMIENTOS', onClick: modalHistorial, data })
            return '<div class="d-flex justify-center">' + button + '</div>'
        }
    }
]

let filtro_proceso_directo = new SelectFilter({ id: 'opcion', label: 'Proceso', placeholder: 'Selecciona una opción' })

filtro_proceso_directo.onChange(function (option) {
    table.setParams({ opcion: option.value })
    table.reload()
})

$.ajax({
    type: 'GET',
    url: 'options_procesos_directo',
    success: function (response) {
        let status_option = [
            { value: -1, label: 'Todos' },
            ...response,
            { value: -2, label: 'Finalizado' },
        ]

        filtro_proceso_directo.setOptions(status_option)
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

let filtrosDirecto = new Filters({
    id: 'table-filters-directo',
    filters: [
        filtro_proceso_directo        
    ],
})


let filtro_proceso = new SelectFilter({ id: 'opcion', label: 'Proceso', placeholder: 'Selecciona una opción' })

filtro_proceso.onChange(function (option) {
    table.setParams({ opcion: option.value })
    table.reload()
})

$.ajax({
    type: 'GET',
    url: 'options_procesos',
    success: function (response) {
        let status_option = [
            { value: -1, label: 'Todos' },
            ...response,
            { value: -2, label: 'Finalizado' },
            { value: -3, label: 'Pre Proceo' },
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

$(document).on('click', '#verPagos', function (e) {
    $("#venta").addClass('hide');
    $("#pagos").removeClass('hide');

    $("#tab-venta").removeClass('active');
    $("#tab-pagos").addClass('active');

});

$(document).on('click', '#verVenta', function (e) {
    $("#pagos").addClass('hide');
    $("#venta").removeClass('hide');

    $("#tab-venta").addClass('active');
    $("#tab-pagos").removeClass('active');
});


modalHistorial = function (dt) {

    let esquemaCredito = 2;
    $("#spiner-loader").removeClass('hide');
    $("#timeLineModal").modal();
    $("#historialActual").html("");

    $.post(`getHistorial/${dt.idProceso}/${esquemaCredito}`).done(function (data) {

        if (JSON.parse(data).length > 0) {
            $.each(JSON.parse(data), function (i, v) {
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
                    description: v.descripcion,
                    date: v.fechaMovimiento,
                    previousText: previousText,
                    newText: newText
                });
                lineCredito(timeLine);
            });
        }
        else {
            emptyLog();
            $("#spiner-loader").addClass('hide');
        }
    });
}

function lineCredito(timeLine) {
    $("#historialActual").append(`${timeLine}`);
}

function linePagos(timeLine) {
    $("#historialPago").append(`${timeLine}`);
}


modalHistorialBanco =  function (dt) {
    let esquemaCredito = 1;
    $("#spiner-loader").removeClass('hide');
    $("#timeLineModal").modal();
    $("#historialActual").html("");
    $("#historialPago").html("");

    $.post(`getHistorial/${dt.idProcesoCasas}/${esquemaCredito}/${dt.idLote}`).done(function (data) {
      if (JSON.parse(data).length > 0)   {
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
                title : v.nombreUsuario,
                back : backProcess, 
                next : nextProcess,
                description : v.descripcionFinal,
                date : v.fechaMovimiento,
                previousText : previousText,
                newText : newText
            });
            lineCredito(timeLine);
        });
      } else {
        emptyLog();
        $("#spiner-loader").addClass('hide');
      }
    });

    $.post(`${general_base_url}/Pagoscasas/getHistorial/${dt.idProcesoPagos}`).done(function (data) {
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

                let timeLinePagos = new TimeLine({
                    title: v.nombreUsuario,
                    back: backProcess,
                    next: nextProcess,
                    description: v.descripcionFinal,
                    date: v.fechaMovimiento,
                    previousText: previousText,
                    newText: newText
                });
                linePagos(timeLinePagos);
            });
        } else {
            emptyLog();
            $("#spiner-loader").addClass('hide');
        }
    });
}
