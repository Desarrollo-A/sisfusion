function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_documentacion?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha iniciado el proceso de pagos.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_documentacion = function(data) {
    let ask = new AskDialog({
        title: 'Iniciar proceso', 
        text: `¿Iniciar proceso de pagos del lote ${data.nombreLote}?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data){
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Iniciar proceso', onClick: pass_to_documentacion, data})

        return `<div class="d-flex justify-center">${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_iniciar_proceso',
    columns,
})