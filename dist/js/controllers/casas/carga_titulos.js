function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_propuestas?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso de aceptacion de propuestas.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_propuestas = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Aceptacion de propuestas"</b>?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

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

function show_upload(data) {
    //console.log(data)

    let form = new Form({
        title: `Subir titulo de propiedad`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}/casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo subido con exito.", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso',      value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',    value: data.idDocumento }),
            new HiddenField({ id: 'name_documento',  value: data.documento }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo' }),
        ],
    })

    form.show()
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

go_to_propuestas = function(data) {
    window.location.href = `propuestas/${data.idProcesoCasas}`;
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
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
        let propuestas_button = new RowButton({icon: 'list', label: 'Propuestas para firma', onClick: go_to_propuestas, data})
        let upload_button = new RowButton({icon: 'file_upload', label: 'Subir titulo de propiedad', onClick: show_upload, data})

        let view_button = ''
        let pass_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: 'Visualizar carta de autorizacion', onClick: show_preview, data})
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a aceptacion de propuestas', onClick: pass_to_propuestas, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${propuestas_button}${view_button}${upload_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_carga_titulos',
    columns,
})