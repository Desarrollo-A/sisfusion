let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 2)
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
        //let pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Pasar a subir documentacion del cliente', onClick: pass_to_docu_cliente, data})

        return `<div class="d-flex justify-center"></div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_documentos_cliente',
    buttons: ['excel'],
    columns,
})