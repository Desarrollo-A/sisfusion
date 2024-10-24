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
            // let upload_button = new RowButton({icon: 'note_add', color: '', label: 'Subir archivo', onClick: upload_archivo, data})
            // let return_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: return_lote, data})
            return '<div class="d-flex justify-center">' + pass_button + '</div>'
        } 
    },
];

let table = new Table({
    id: '#tableAdeudo',
    url: 'casasDirecto/lotesCreditoDirecto',
    params: { proceso: 1 },
    columns
});

// return_lote = function(data){ // funcion para el avance del lote
//     let form = new Form({
//         title: '¿Rechazar lote?', 
//         text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
//         onSubmit: function(data){
//             form.loading(true)

//             $.ajax({
//                 type: 'POST',
//                 url: `${general_base_url}casasDirecto/creditoDirectoAvance`,
//                 data: data,
//                 contentType: false,
//                 processData: false,
//                 success: function (response) {
//                     alerts.showNotification("top", "right", "El lote se ha rechazado correctamente.", "success");
        
//                     table.reload();
//                     form.hide();
//                 },
//                 error: function () {
//                     alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

//                     form.loading(false)
//                 }
//             })
//         },
//         fields: [
//             new HiddenField({ id: 'idLote', value: data.idLote }),
//             new HiddenField({ id: 'idProceso', value: data.idProceso }),
//             new HiddenField({ id: 'proceso', value: data.proceso }),
//             new HiddenField({ id: 'procesoNuevo', value: 0 }),
//             new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
//             new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
//             new HiddenField({ id: 'idCliente', value: data.idCliente }),
//         ],
//     })

//     form.show()
// }

// upload_archivo = function(data){ // funcion para subir el archivo de adeudo
//     let form = new Form({
//         title: '¿Subir archivo?', 
//         text: `¿Se subira un archivo para el proceso con el lote - <b>${data.nombreLote}</b>?`,
//         onSubmit: function(data){
//             // console.log(data)
//             form.loading(true)

//             $.ajax({
//                 type: 'POST',
//                 url: `${general_base_url}casasDirecto/to_asignacion`,
//                 data: data,
//                 contentType: false,
//                 processData: false,
//                 success: function (response) {
//                     alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
        
//                     table.reload();

//                     form.hide();
//                 },
//                 error: function () {
//                     alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

//                     form.loading(false)
//                 }
//             })
//         },
//         fields: [
//             new HiddenField({ id: 'idLote', value: data.idLote }),
//             new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
//         ],
//     })

//     form.show()
// }

select_lote = function(data){ // funcion para el avance del lote
    let form = new Form({
        title: '¿Avanzar lote?', 
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casasDirecto/creditoDirectoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function () {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente.", "success");
        
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
            new HiddenField({ id: 'idProceso', value: data.idProceso }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
        ],
    })
    
    form.show()
}