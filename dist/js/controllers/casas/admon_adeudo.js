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
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avance a paso 18', onClick: select_lote, data})
            let edit_button = new RowButton({icon: 'edit', color: '', label: 'Capturar adeudo', onClick: update_adeudo, data})

            if(data.adeudo != 0 && data.voBoAdeudoTerreno == 0){
                return '<div class="d-flex justify-center">' + pass_button + edit_button + '</div>'
            }
            else if(data.adeudo == 0 && data.voBoAdeudoTerreno == 0){
                return '<div class="d-flex justify-center">' + edit_button + '</div>'
            }
            else{
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
            new HiddenField({ id: 'procesoNuevo', value: 16 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

update_adeudo = function(data){ // funcion para subir el archivo de adeudo
    let form = new Form({
        title: `Captura de adeudo de la construcción`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/setAdeudo`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha capturado la información.", "success");
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
            new HiddenField({ id: 'nombre_lote', value: data.nombreLote }),
            new NumberField({ id: 'adeudo', label: 'Adeudo', placeholder: '', required: true})
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
                url: `${general_base_url}casas/avanceAdeudo`,
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
            new HiddenField({ id: 'voBoOrdenCompra', value: data.voBoOrdenCompra }),
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