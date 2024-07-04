let columns = [
    { data: 'idLote' },
    { data: function(data)
        { return `${data.nombreLote}` } 
    },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: function(data)
        {
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Seleccionar para asignación', onClick: nextProcess, data})
            let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Seleccionar para asignación', onClick: returnProcess, data})
            return '<div class="d-flex justify-center">' + pass_button + return_button + '</div>'
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: `casas/lotesCreditoDirecto`,
    params: { proceso: 19},
    columns,
    // button: buttons
});

returnProcess = function(data){ // funcion para subir el archivo de adeudo

    // Número de proceso a avanzar
    data.proceso = 18;

    let form = new Form({
        title: '¿Rechazar lote?', 
        text: `¿Seguro que quiere rechazar el lote - <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            // console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoProceso`,
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
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

nextProcess = function(data){ // funcion para el avance del lote
    
    // Número de proceso a avanzar
    data.proceso = 20;
    
    let form = new Form({
        title: '¿Avanzar lote?', 
        text: `Se avanzara el proceso del lote  - <b>${data.nombreLote}</b>`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoDirectoProceso`,
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
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}