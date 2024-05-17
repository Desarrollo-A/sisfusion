let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 3)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} dia(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        return text
    } },
    { data: function(data){
        // let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: 'go_to_documentos', data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar pago', onClick: pass_to_carga_complemento, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentacion, data})
        
        return `<div class="d-flex justify-center">${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_confirmar_pago',
    columns,
})