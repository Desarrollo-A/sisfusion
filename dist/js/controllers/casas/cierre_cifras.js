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

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

function show_upload(data) {
    //console.log(data)

    let form = new Form({
        title: 'Subir cierre de cifras',
        onSubmit: function (data) {
            //console.log(data)
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento`,
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
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento', value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf'], required: true }),
        ],
    })

    form.show()
}

pass_to_vobo_cifras = function (data) {

    let form = new Form({
        title: 'Continuar proceso',
        text: `¿Desea enviar el lote <b>${data.nombreLote}</b> a Vo.Bo. de cifras?`,
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
                    alerts.showNotification("top", "right", "El lote ha pasado al proceso de Vo.Bo. de cifras", "success");

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
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title: "Cierre de cifras",
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
    {
        data: function (data) {
            let inicio = new Date(data.fechaProceso)
            let today = new Date()

            let difference = today.getTime() - inicio.getTime()

            let days = Math.floor(difference / (1000 * 3600 * 24))

            let text = `Lleva ${days} día(s)`

            return text
        }
    },
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
            let upload_button = new RowButton({ icon: 'file_upload', label: 'Subir cierre de cifras', onClick: show_upload, data })

            let view_button = ''
            let pass_button = ''

            if (data.archivo) {

                let parts = data.archivo.split('.');
                let extension = parts.pop();

                if (extension == 'xlsx') {
                    view_button = new RowButton({ icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data })
                } else {
                    view_button = new RowButton({ icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data })
                }

                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Pasar a vo.bo. de cifras', onClick: pass_to_vobo_cifras, data })
            }

            return `<div class="d-flex justify-center">${view_button}${upload_button}${pass_button}</div>`
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_cierre_cifras',
    buttons: buttons,
    columns,
})