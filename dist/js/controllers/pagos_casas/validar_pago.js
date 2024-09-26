back_to_previous = function(data) {
    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Regresar proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `back_to_carga_complementos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El proceso del lote ha sido regresado.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoPagos }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

pass_to_next = function(data) {
    let form = new Form({
        title: 'Enviar a solicitar avance', 
        text: `¿Enviar el lote <b>${data.nombreLote}</b> a solicitar avance?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_solicitar_avance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido enviado a solicitar avance.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoPagos }),
            new HiddenField({ id: 'id_avance',  value: data.idAvance }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
            new HiddenField({ id: 'paso', value: 7})
        ],
    })

    form.show()
}

finalizar_proceso = function(data) {
    let form = new Form({
        title: 'Finalizar proceso', 
        text: `¿Finalizar el proceso de pagos del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_finalizar_proceso`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El proceso de pagos del lote ha finalizado.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoPagos }),
            new HiddenField({ id: 'id_avance',  value: data.idAvance }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function show_preview(data) {
    let url = `${general_base_url}pagoscasas/archivo/${data.complementoPDF}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: Complemento de pago`,
        width: 985,
        height: 660
    });
}

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    let url = `${general_base_url}casas/archivo/${data.complementoXML}`

    window.open(url, '_blank').focus()
}

const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        return `${data.avanceObra} %`
    } },
    { data: function(data){
        return `${data.avance} %`
    } },
    { data: function(data) {
        if(data.monto){
            return formatter.format(data.monto)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        let inicio = new Date(data.fechaProceso)
        let today = new Date()

        let difference = today.getTime() - inicio.getTime()

        let days = Math.floor(difference / (1000 * 3600 * 24))

        let text = `Lleva ${days} día(s)`

        return text
    } },
    { data: function(data){
        let view_button = new RowButton({icon: 'visibility', label: `Visualizar complemento de pago PDF`, onClick: show_preview, data})

        let download_button = new RowButton({icon: 'file_download', label: `Descargar complemento de pago XML`, onClick: download_file, data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar pago', onClick: pass_to_next, data})

        if(data.avanceObra >= 100){
            pass_button = new RowButton({icon: 'check', color: 'green', label: 'Validar y finalizar proceso', onClick: finalizar_proceso, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_previous, data})
        
        return `<div class="d-flex justify-center">${view_button}${download_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_validar_pago',
    columns,
})