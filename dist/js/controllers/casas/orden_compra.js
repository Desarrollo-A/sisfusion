let columns = [
    { data: 'idLote' },
    { data: function(data)
        { return `${data.nombreLote}` } 
    },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: function(data)
        {
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avance a paso 17', onClick: select_lote, data})
            let upload_button = new RowButton({icon: 'cloud_upload', color: '', label: 'Subir archivo', onClick: upload_archivo, data})
            let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a asignación de cartera', onClick: return_lote, data})
            let reupload_button = new RowButton({icon: 'upload_file', color: '', label: 'Subir archivo', onClick: upload_archivo, data})

            if(data.documento == null){
                return '<div class="d-flex justify-center">' + upload_button + return_button + '</div>'
            }
            else{
                return '<div class="d-flex justify-center">' + pass_button + upload_button + return_button + '</div>'
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

return_lote = function(data){ // funcion para subir el archivo de adeudo
    let form = new Form({
        title: '¿Rechazar lote?', 
        text: `¿Seguro que quiere rechazar el lote - <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            // console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_asignacion`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido enviado a asignación.", "success");
        
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
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
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
        title: '¿Avanzar lote?', 
        text: `Se avanzara el proceso del lote  - <b>${data.nombreLote}</b>`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoAvance`,
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
            new HiddenField({ id: 'procesoNuevo', value: 17 }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}