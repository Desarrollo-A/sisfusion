function show_preview(data) {
    let url = `${general_base_url}pagoscasas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    window.open(url, '_blank').focus()
}

function show_upload(data) {
    //console.log(data)
    let accept = ['image/png', 'image/jpeg', 'application/pdf']
    
    if(data.tipo === 5){
        accept = ['application/pdf']
    }

    if(data.tipo === 6){
        accept = ['text/xml']
    }

    let form = new Form({
        title: `Subir ${data.documento}`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}/pagoscasas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo cargado con éxito", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso',         value: data.idProcesoPagos }),
            new HiddenField({ id: 'id_documento',       value: data.idDocumento }),
            new HiddenField({ id: 'name_documento',     value: data.documento }),
            new FileField({   id: 'file_uploaded',      label: 'Archivo', placeholder: 'Selecciona un archivo', accept: accept, required: true }),
        ],
    })

    form.show()
}

let columns = [
    { data: 'idDocumento' },
    { data: 'documento' },
    { data: 'archivo' },
    { data: function(data){
        if(data.fechaModificacion){
            return data.fechaModificacion.substring(0, 16)
        }

        return ''
    } },
    { data: function(data){
        let view_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})

            if(data.tipo === 6){
                view_button = new RowButton({icon: 'file_download', label: `Visualizar ${data.documento}`, onClick: download_file, data})
            }
        }

        let upload_button = new RowButton({icon: 'file_upload', color: 'green', label: `Subir ${data.documento}`, onClick: show_upload, data})

        return `<div class="d-flex justify-center">${view_button}${upload_button}</div>`
    } },
]

let buttons = [
    {
        text: '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
        action: function() {
            window.location.href = `${general_base_url}pagoscasas/documentacion`
        },
        attr: {
            class: 'btn-back',
            style: 'position: relative; float: left',
            title: 'Regresar'
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: `pagoscasas/lista_subir_documentos/${idProcesoPagos}`,
    columns,
    buttons,
})