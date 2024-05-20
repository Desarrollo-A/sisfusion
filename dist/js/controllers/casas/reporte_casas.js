go_to_historial = function(data) {
    window.location.href = `historial/${data.idProcesoCasas}`;
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Validacion de documentación",
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
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 2)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} día(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        return text
    } },
    { data: function (data) {
        switch(data.tipoMovimiento){
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
    } },
    { data: function(data){
        let docu_button = new RowButton({icon: 'toc', label: 'Ver historial', onClick: go_to_historial, data})

        // let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a solicitud de contratos', onClick: pass_to_solicitud_contratos, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentración de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_reporte_casas',
    buttons: buttons,
    columns,
})

let filtro_proceso = new SelectFilter({ id: 'opcion', label: 'Proceso',  placeholder: 'Selecciona una opción'})

filtro_proceso.onChange(function(option){
    // console.log(option)

    table.setParams({opcion: option.value})
    table.reload()
})

$.ajax({
    type: 'GET',
    url: 'options_procesos',
    success: function (response) {
        // console.log(response)
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