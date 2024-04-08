function sendToCierreCifras(data) {
    // console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_cierre_cifras?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a cierre de cifras.`, "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

back_to_cierre_cifras = function(data) {
    let ask = new AskDialog({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a <b>"Cierre de cifras"</b>?`,
        onOk: () => sendToCierreCifras(data),
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
        //let docu_button = new TableButton({icon: 'toc', label: 'Ver documentos', onClick: go_to_documentos, data})

        //let pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Enviar a solicitud de contratos', onClick: pass_to_solicitud_contratos, data})

        let back_button = new TableButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a carga de cierre de cifras', onClick: back_to_cierre_cifras, data})

        return `<div class="d-flex justify-center">${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_vobo_cifras',
    buttons: ['excel'],
    columns,
})