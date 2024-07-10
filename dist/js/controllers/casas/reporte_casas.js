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
            columns: [0, 1, 2],
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
            columns: [0, 1, 2],
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
            let docu_button = new RowButton({ icon: 'toc', label: 'Ver historial', onClick: go_to_historial, data })

            // let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a solicitud de contratos', onClick: pass_to_solicitud_contratos, data})

            // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentración de adeudos', onClick: back_to_adeudos, data})

            return `<div class="d-flex justify-center">${docu_button}</div>`
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
    {
        data: function (data) {
            let button = new RowButton({ icon: 'info', label: 'Historial de movimientos', onClick: modalHistorial, data })
            return '<div class="d-flex justify-center">' + button + '</div>'
        }
    },
]

let filtro_proceso = new SelectFilter({ id: 'opcion', label: 'Proceso', placeholder: 'Selecciona una opción' })

filtro_proceso.onChange(function (option) {
    // console.log(option)

    table.setParams({ opcion: option.value })
    table.reload()
})

$.ajax({
    type: 'GET',
    url: 'options_procesos',
    success: function (response) {
        // console.log(response)
        let status_option = [
            { value: -1, label: 'Todos' },
            ...response,
            { value: -2, label: 'Finalizado' },
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

$(document).on('click', '#verProceso', function (e) {
    $("#venta").addClass('hide');
    $("#proceso").removeClass('hide');

    $("#tab-venta").removeClass('active');
    $("#tab-proceso").addClass('active');

});

$(document).on('click', '#verVenta', function (e) {
    $("#proceso").addClass('hide');
    $("#venta").removeClass('hide');

    $("#tab-venta").addClass('active');
    $("#tab-proceso").removeClass('active');
});

modalHistorial = function (dt) {

    $("#spiner-loader").removeClass('hide');
    $("#timeLineModal").modal();
    $("#historialActual").html("");

    $.post(`getHistorialCreditoActual/${dt.idProceso}`).done(function (data) {

        if (JSON.parse(data).length > 0) {
            $.each(JSON.parse(data), function (i, v) {
                $("#spiner-loader").addClass('hide');
                let timeLine = new TimeLine({
                    title: v.idProcesoCasas,
                    back: v.procesoAnterior,
                    next: v.procesoNuevo,
                    description: v.descripcion,
                    date: v.fechaMovimiento
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