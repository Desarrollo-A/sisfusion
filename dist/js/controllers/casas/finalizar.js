function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `finalizar_proceso?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El proceso del lote ha finzalizado.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

finalizar = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Finalizar proceso del lote ${data.nombreLote}?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

function sendToBack(data) {
    // console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_firma_contrato?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado.`, "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

back_to_firma_contrato = function(data) {
    let ask = new AskDialog({
        title: 'Regresar proceso', 
        text: `¿Regresar el proceso del lote ${data.nombreLote}?`,
        onOk: () => sendToBack(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 1)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} dia(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        if(data.finalizado){
            text = 'Finalizado'
        }

        return text
    } },
    { data: function(data){
        
        let pass_button = ''
        let back_button = ''
        if(!data.finalizado){
            pass_button = new RowButton({icon: 'check', color: 'green', label: 'Finalizar proceso', onClick: finalizar, data})
            back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_firma_contrato, data})
        }

        return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_finalizar',
    columns,
})

let filtro_proceso = new SelectFilter({ id: 'proceso', label: 'Proceso',  placeholder: 'Selecciona una opcion'})

filtro_proceso.onChange(function(option){
    // console.log(option)

    table.setParams({finalizado: option.value})
    table.reload()
})

let status_option = [
    {value: -1, label: 'Todos'},
    {value: 1, label: 'Finalizado'},
    {value: 0, label: 'No finalizado'},
]

filtro_proceso.setOptions(status_option)

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proceso,
    ],
})