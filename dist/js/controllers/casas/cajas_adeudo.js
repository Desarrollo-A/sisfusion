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
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avance a paso 17', onClick: select_lote, data})
            let upload_button = new RowButton({icon: 'note_add', color: '', label: 'Subir archivo', onClick: upload_archivo, data})
            let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a asignación de cartera', onClick: return_lote, data})
            return '<div class="d-flex justify-center">' + pass_button + return_button + '</div>'
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: 'casas/lotesCreditoDirecto',
    params: { proceso: 16 },
    columns
});

return_lote = function(data){ // funcion para el avance del lote
    let form = new Form({
        title: '¿Rechazar lote?', 
        text: `¿Seguro que quiere rechazar el lote - <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote se ha regresado correctamente.", "success");
        
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
            new HiddenField({ id: 'procesoNuevo', value: 0 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

upload_archivo = function(data){ // funcion para subir el archivo de adeudo
    let form = new Form({
        title: '¿Subir archivo?', 
        text: `¿Se subira un archivo para el proceso con el lote - <b>${data.nombreLote}</b>?`,
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
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}