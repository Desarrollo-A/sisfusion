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
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar proceso al lote', onClick: nextProcess, data})
            let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar proceso del lote', onClick: returnProcess, data})
            return '<div class="d-flex justify-center">' + pass_button + '</div>'
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: `casas/lotesCreditoDirecto`,
    params: { proceso: 23},
    columns,
    // button: buttons
});

returnProcess = function(data){ // funcion para subir el archivo de adeudo

    let form = new Form({
        title: '¿Rechazar lote?', 
        text: `¿Seguro que quiere rechazar el lote - <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            // console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    returnFlag(data);

                    // alerts.showNotification("top", "right", "El lote ha rechazado.", "success");
                    // table.reload();
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
            new HiddenField({ id: 'procesoNuevo', value: 22 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

returnFlag = function(data){
    $.ajax({
        type: 'POST',
        url: `${general_base_url}casas/removerFlagContrato`,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha sido rechazado.", "success");

            table.reload();
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

nextProcess = function(data){ // funcion para el avance del lote
    
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
            new HiddenField({ id: 'procesoNuevo', value: 24 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}