function sendToAdeudos(data) {
    console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_adeudos?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a concentración de adeudos.`, "success");

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
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a concentración de adeudos?`,
        onOk: () => sendToAdeudos(data),
        //onCancel: sayNo,
    })

    ask.show()
}

go_to_documentos = function(data) {
    window.location.href = `documentacion/${data.idProcesoCasas}`;
}

function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_valida_comite?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para ser validado por comite técnico.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_proyecto_ejecutivo = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Validacion por comite tecnico"</b>?`,
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
        vigencia.setDate(vigencia.getDate() + 5)
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
        let docu_button = new RowButton({icon: 'toc', label: 'Editar documentos', onClick: go_to_documentos, data})

        let pass_button = ''
        if(data.documentos >= 13){
             pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a validación de proyecto', onClick: pass_to_proyecto_ejecutivo, data})
        }

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentracion de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_proceso_documentos',
    columns,
})