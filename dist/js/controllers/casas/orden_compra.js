let columns = [
    {
        data: (d) => {
            return `<span class="label" 
                style="color: ${d.color}; background: ${d.color}18;}">
                ${d.nombreMovimiento}
            </span>`;
        }
    },
    { data: 'idLote' },
    { data: function(data)
        { return `${data.nombreLote}` } 
    },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'tiempoProceso' },
    { data: function(data)
        {
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: select_lote, data})
            let upload_button = new RowButton({icon: 'file_upload', color: '', label: 'Cargar archivo', onClick: upload_archivo, data})
            let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: return_process, data})
            let view_button = new RowButton({icon: 'visibility', label: `Visualizar archivo`, onClick: show_preview, data})

            if(data.documento == null && data.voBoOrdenCompra == 0){
                return '<div class="d-flex justify-center">' + upload_button + return_button + '</div>'
            }
            else if (data.documento != null && data.voBoOrdenCompra == 0){
                return '<div class="d-flex justify-center">' + pass_button + upload_button + view_button + return_button + '</div>'
            }
            else {
                return ''
            }
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: 'casas/lotesCreditoDirecto',
    params: { proceso: 17, tipoDocumento: 2 },
    columns,
    // button: buttons
});

return_process = function(data){ // funcion para el avance del lote
    let form = new Form({
        title: '¿Rechazar lote?', 
        text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente.", "success");
                    return_flags(data);
    
                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProceso', value: data.idProceso }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 16 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

return_flags = function (data) { // funcion para el avance del lote
    $.ajax({
        type: 'POST',
        url: `${general_base_url}casas/returnFlagsPaso17`,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            alerts.showNotification("top", "right", "Se ha rechazado el lote correctamente.", "success");

            table.reload();
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");            
        }
    })
}

upload_archivo = function(data){ // funcion para subir el archivo de adeudo
    let form = new Form({
        title: `Subir orden de compra`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/UploadDocumentoCreditoDirecto`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo subido con éxito.", "success");
                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idProceso', value: data.idProceso }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'tipoDocumento', value: data.archivo }),
            new HiddenField({ id: 'id_documento', value: 2 }),
            new HiddenField({ id: 'nombre_lote', value: data.nombreLote }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true}),
        ],
    })

    form.show()
}

select_lote = function(data){ // funcion para el avance del lote
    let form = new Form({
        title: 'Avanzar lote', 
        text:`¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/avanceOrdenCompra`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido avanzdo en su proceso.", "success");
        
                    table.reload();
                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProceso', value: data.idProceso }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 18 }),
            new HiddenField({ id: 'voBoOrdenCompra', value: 1 }),
            new HiddenField({ id: 'voBoAdeudoTerreno', value: data.voBoAdeudoTerreno }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
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