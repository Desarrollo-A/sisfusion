pass_to_vobo_cifras = function (data) {
    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            //console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `to_vobo_cifras`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha avanzado el proceso correctamente", "success");

                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new HiddenField({ id: 'idVobo', value: data.idVobo }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function replace_upload(data ) {

    let form = new Form({
        title: 'Cargar documento',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Documento cargado con éxito", "success");

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
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento', value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.nombreArchivo }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
        ],
    })

    form.show()
}

function upload(data) {

    let form = new Form({
        title: 'Cargar Documento',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento_new`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Documento cargado con éxito", "success");

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
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'tipo', value: 31 }),
            new HiddenField({ id: 'name_documento', value: data.nombreArchivo }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
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
        title: `Visualizando documento: ${data.documento}`,
        width: 985,
        height: 660
    });
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Validación de documentación",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        },
        attr: {
            style: 'position: relative; float: left; margin: 5px',
        }
    }
]

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: 'tiempoProceso' },
    { data: function (data) {
        switch(data.tipoMovimiento){
        case 1:
            clase = 'warning'
            break
        case 2:
            clase = 'orange'
            break
        default:
            clase = 'blueMaderas'
        }

        return `<span class="label lbl-${clase}">${data.movimiento}</span>`
    } },
    { data: function(data){

        let upload_button = ''
        let view_button = ''
        let pass_button = ''
        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazar_proceso, data})

        if (data.kit) {
            view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
            upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: replace_upload, data })
            pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_vobo_cifras, data })
        }else{
            upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: upload, data })
        }

        return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_carga_kit_bancario',
    buttons: buttons,
    columns,
})

function rechazar_proceso(data) {
    let form = new Form({
        title: 'Rechazar proceso', 
        text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){            
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `rechazoPaso11`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    removerBandera(data, form);
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'idVobo', value: data.idVobo }),
            new HiddenField({ id: 'procesoNuevo', value: 10 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function removerBandera(data, form){ // se añade esto en caso de que el paso 12 de el avance y sea el 11 quien rechace
    $.ajax({
        type: 'POST',
        url: `removerBanderPaso12`,
        data: data,
        contentType: false,
        processData: false,
        success: function(response){
            alerts.showNotification("top", "right", `Se ha rechazado el proceso correctamente`, "success");
        
            table.reload()
            form.hide();            
        },
        error: function(){
            alerts.showNotification("top", "right", `Se ha rechazado el proceso correctamente`, "success");
        
            form.loading(form);
        }
    })
}