function show_preview(data) {
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}

function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_expediente_cliente?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al siguiente proceso.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_expediente_cliente = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Aprobar el cierre de cifras del lote ${data.nombreLote}?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

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
        let view_button = new TableButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
        if(!data.archivo){
            view_button = new TableButton({icon: 'visibility_off', color: 'yellow',  label: `Archivo no subido`})
        }

        let pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Aprobar cierre de cifras', onClick: pass_to_expediente_cliente, data})

        let back_button = new TableButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a carga de cierre de cifras', onClick: back_to_cierre_cifras, data})

        return `<div class="d-flex justify-center">${view_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_vobo_cifras',
    buttons: ['excel'],
    columns,
})