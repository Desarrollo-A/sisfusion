pass_to_propuestas = function(data) {

    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Aceptación de propuestas"</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_propuestas`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha pasado al proceso de aceptación de propuestas.", "success");
        
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
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
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
        title: `Subir título de propiedad`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

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
            new HiddenField({ id: 'id_proceso',      value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',    value: data.idDocumento }),
            new HiddenField({ id: 'name_documento',  value: data.documento }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo',  accept: ['application/pdf'] }),
        ],
    })

    form.show()
}

function show_upload_coti(data) {

    let form = new Form({
        title: `Subir cotización`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_cotizaciones`,
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
            new HiddenField({ id: 'id_proceso',      value: data.idProcesoCasas }),
            new FileField({   id: 'file_cotizacion1',   label: 'Archivo', placeholder: 'Selecciona un archivo',  accept: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'] }),
            data.tipoCredito == 2 ?
            new FileField({   id: 'file_cotizacion2',   label: 'Archivo', placeholder: 'Selecciona un archivo',  accept: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'] })
            : ''
        ],
    })

    form.show()
}

back_to_adeudos = function(data) {
    /* let ask = new AskDialog({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a <b>"Concentración de adeudos"</b>?`,
        onOk: () => sendToConcentrarAdeudos(data),
        //onCancel: sayNo,
    })

    ask.show() */

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a <b>"Concentración de adeudos"</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_documentos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a concentración de adeudos.`, "success");
        
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
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

go_to_propuestas = function(data) {
    window.location.href = `propuestas/${data.idProcesoCasas}`;
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Carga de títulos y cotizaciones",
        exportOptions: {
            columns: [0, 1, 2],
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
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 3)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} dia(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        return text
    } },
    { data: function(data){
        let propuestas_button = new RowButton({icon: 'list', label: 'Propuestas para firma', onClick: go_to_propuestas, data})
        let upload_button = new RowButton({icon: 'file_upload', label: 'Subir título de propiedad', onClick: show_upload, data})
        let upload_cotizacion = new RowButton({icon: 'file_upload', label: 'Subir cotización', onClick: show_upload_coti, data})

        let view_button = ''
        let pass_button = ''
        
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: 'Visualizar carta de autorización', onClick: show_preview, data})
            if(data.propuestas > 0){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a aceptación de propuestas', onClick: pass_to_propuestas, data})
            }
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${propuestas_button}${view_button}${upload_button}${upload_cotizacion}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_carga_titulos',
    columns,
    buttons: buttons,
})