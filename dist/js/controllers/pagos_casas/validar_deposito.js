let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data) {
        if(data.costoConstruccion){
            return `$ ${data.costoConstruccion.toFixed(2)}`
        }else{
            return ''
        }
    } },
    { data: function(data) {
        if(data.montoDepositado){
            return `$ ${data.montoDepositado.toFixed(2)}`
        }else{
            return ''
        }
    } },
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
        let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: 'go_to_documentos', data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Iniciar proceso', onClick: 'pass_to_validar_deposito', data})
        
        return `<div class="d-flex justify-center">${docu_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_validar_deposito',
    columns,
})