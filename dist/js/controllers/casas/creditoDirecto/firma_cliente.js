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
           let pass_button = '';
           let return_button = '';

            if((data.voBoContrato == null || data.voBoContrato == 0) && (data.voBoValidacionEnganche == 1)){
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: nextProcess, data})
                return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: returnProcess, data})
            }

            return '<div class="d-flex justify-center">' + pass_button + return_button + '</div>'
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: `casas/lotesCreditoDirecto`,
    params: { proceso: [21, 22], tipoDocumento: 0},
    columns,
    // button: buttons
});

returnProcess = function(data){ // funcion para subir el archivo de adeudo

    let form = new Form({
        title: 'Rechazar lote', 
        text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            // console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/firmaClienteAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha rechazado.", "success");
        
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
            new HiddenField({ id: 'procesoNuevo', value: 21 }),
            new HiddenField({ id: 'voBoContrato', value: 0 }),
            new HiddenField({ id: 'voBoValidacionEnganche', value: 0 }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

nextProcess = function(data){ // funcion para el avance del lote
    
    let form = new Form({
        title: '¿Avanzar lote?', 
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/firmaClienteAvance`,
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
            new HiddenField({ id: 'procesoNuevo', value: 23 }),
            new HiddenField({ id: 'voBoContrato', value: 1 }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}
