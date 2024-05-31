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

show_upload = function(data) {
    let pdf = ['application/pdf']
    let xml = ['text/xml']

    let form = new Form({
        title: `Subir complemento de pago (PDF y XML)`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}/pagoscasas/upload_complemento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivos subidos con éxito.", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso', value: data.idProcesoPagos }),
            new HiddenField({ id: 'id_avance',  value: data.idAvance }),
            new FileField({   id: 'file_pdf',   label: 'Archivo PDF', placeholder: 'Selecciona un archivo', accept: pdf, required: true }),
            new FileField({   id: 'file_xml',   label: 'Archivo XML', placeholder: 'Selecciona un archivo', accept: xml, required: true }),
        ],
    })

    form.show()
}

pass_to_validar_pago = function(data) {
    let form = new Form({
        title: 'Enviar a validar pago', 
        text: `¿Enviar el lote <b>${data.nombreLote}</b> para validar pago?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validar_pago`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El pago del lote ha sido enviado a validación.", "success");
        
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
            new HiddenField({ id: 'id_avance', value: data.idAvance }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
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
        let docu_button = new RowButton({icon: 'file_upload', label: 'Subir documentos', onClick: show_upload, data})

        let view_button = ''
        if(data.complementoPDF){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar complemento de pago PDF`, onClick: show_preview, data})
        }

        let download_button = ''
        if(data.complementoXML){
            download_button = new RowButton({icon: 'file_download', label: `Descargar complemento de pago XML`, onClick: download_file, data})
        }

        let pass_button = ''
        if(data.complementoPDF && data.complementoXML){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar pago', onClick: pass_to_validar_pago, data})
        }

        return `<div class="d-flex justify-center">${view_button}${download_button}${docu_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_carga_complemento',
    columns,
})