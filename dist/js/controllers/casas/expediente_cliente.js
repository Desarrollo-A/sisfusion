function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_envio_a_firma?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al siguiente proceso.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_envio_a_firma = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Marcar como recibido el expediente del cliente ${data.nombreLote}?`,
        onOk: () => sendToNext(data),
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
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Ingreso el expediente', onClick: pass_to_envio_a_firma, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a carga de cierre de cifras', onClick: back_to_cierre_cifras, data})

        return `<div class="d-flex justify-center">${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_expediente_cliente',
    columns,
})