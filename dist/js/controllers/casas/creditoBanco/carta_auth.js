back_process = function (data) {

    let form = new Form({
        title: 'Regresar proceso',
        text: `¿Deseas regresar el proceso del lote <b>${data.nombreLote}</b> a asignación de esquema y modelo de casa?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `back_to_asignacion`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a de esquema y modelo de casa.`, "success");
        
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
            new HiddenField({ id: 'idProceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'idCliente', value: data.id_cliente }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
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

function show_upload(data) {
    let form = new Form({
        title: 'Subir carta de autorización',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento`,
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

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento', value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({ id: 'file_uploaded', label: '', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
            new HiddenField({ id: 'idCliente', value: data.idCliente})
        ],
    })

    form.show()
}

let tipos = []

$.ajax({
    type: 'GET',
    url: 'options_tipos_credito',
    async: false,
    success: function (response) {
        tipos = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

pass_to_adeudos = function (data) {
    console.log("ghere");
    let form = new Form({
        title: 'Avanzar proceso', 
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_concentrar_adeudos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");

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
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new SelectField({ id: 'tipo', label: 'Tipo de crédito', placeholder: 'Selecciona una opción', width: '12', data: tipos, required: true }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
            new HiddenField({ id: 'idLote', value: data.idLote}),
            new HiddenField({ id: 'idCliente', value: data.idCliente})
        ],
    })

    form.show()
}

let columns = [
    { data: 'idProcesoCasas' },
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
    {
        data: function (data) {
            let upload_button = new RowButton({ icon: 'file_upload', label: 'Cargar archivo', onClick: show_upload, data })

            let view_button = ''
            let pass_button = ''
            //let cancel_button = '';
            if (data.archivo) {
                view_button = new RowButton({ icon: 'visibility', label: 'Visualizar archivo', onClick: show_preview, data })
                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_adeudos, data })
            }

            let cancel_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: back_process, data })

            return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${cancel_button}</div>`
        }
    },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Ingresar carta de autorización",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_carta_auth',
    buttons: buttons,
    columns,
})