function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_finalizar?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al siguiente proceso.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_finalizar = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Enviar el lote ${data.nombreLote} a para finalizar proceso?`,
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

        return text
    } },
    { data: function(data){
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a finalizar proceso', onClick: pass_to_finalizar, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_firma_contrato, data})

        return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_recepcion_contrato',
    columns,
})