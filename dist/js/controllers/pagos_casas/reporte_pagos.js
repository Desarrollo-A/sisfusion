go_to_avances = function(data) {
    window.location.href = `avances/${data.idProcesoPagos}`;
}

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
        let docu_button = new RowButton({icon: 'toc', label: 'Ver avances', onClick: go_to_avances, data})

        return `<div class="d-flex justify-center">${docu_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_reporte_pagos',
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
         console.log(response)
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