let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: 'proceso' },
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

        return text
    } },
    { data: function(data){
        // let docu_button = new RowButton({icon: 'toc', label: 'Ver historial', onClick: go_to_historial, data})

        // let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a solicitud de contratos', onClick: pass_to_solicitud_contratos, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentración de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center"></div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_reporte_pagos',
    columns,
})