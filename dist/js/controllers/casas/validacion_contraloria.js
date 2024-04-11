function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_solicitud_contratos?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para solicitar contratos.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_solicitud_contratos = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Solicitud de contratos"</b>?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

function sendToConcentrarAdeudos(data) {
    // console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_documentos?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a concentracion de adeudos.`, "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

back_to_adeudos = function(data) {
    let ask = new AskDialog({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a <b>"Concentracion de adeudos"</b>?`,
        onOk: () => sendToConcentrarAdeudos(data),
        //onCancel: sayNo,
    })

    ask.show()
}

go_to_documentos = function(data) {
    window.location.href = `valida_documentacion/${data.idProcesoCasas}`;
}

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
        let docu_button = new RowButton({icon: 'toc', label: 'Ver documentos', onClick: go_to_documentos, data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a solicitud de contratos', onClick: pass_to_solicitud_contratos, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentracion de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_validacion_contraloria',
    buttons: ['excel'],
    columns,
})