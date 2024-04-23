function sendToNext(data) {
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_documentacion_cliente?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para subir documentación del cliente.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

function sendToCartaAuth(data) {
    console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_carta_auth?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a carta de autorización.`, "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_docu_cliente = function (data) {
    let ask = new AskDialog({
        title: 'Continuar proceso',
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Subir documentación cliente"</b>?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

back_to_carta_auth = function (data) {
    let ask = new AskDialog({
        title: 'Regresar proceso',
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a carta de autorización?`,
        onOk: () => sendToCartaAuth(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'adeudoOOAM' },
    { data: 'adADM' },
    { data: 'adGPH' },
    {
        data: function (data) {
            let vigencia = new Date(data.fechaProceso)
            vigencia.setDate(vigencia.getDate() + 2)
            let today = new Date()

            let difference = vigencia.getTime() - today.getTime()

            let days = Math.round(difference / (1000 * 3600 * 24))

            let text = `Quedan ${days} dia(s)`
            if (days < 0) {
                text = 'El tiempo establecido ha pasado'
            }

            return text
        }
    },
    {
        data: function (data) {
            // console.log(data)

            let pass_button = ''
            if (data.adeudoOOAM) {
                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Pasar a subir documentación del cliente', onClick: pass_to_docu_cliente, data })
            }
            let back_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Regresar a carta de autorización', onClick: back_to_carta_auth, data })

            return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_adeudos',
    columns,
})