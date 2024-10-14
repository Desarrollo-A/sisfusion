function show_preview(data) {
    console.log("data: ", data);
    let url = `${general_base_url}pagoscasas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.archivo}`,
        width: 985,
        height: 660
    });
}

pass_to_next = function(data) {
    let form = new Form({
        title: 'Iniciar proceso', 
        text: `¿Iniciar proceso de pagos del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validar_deposito`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha iniciado el proceso de pagos.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso', value: data.idProcesoPagos }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

show_upload = function(data) {
    let pdf = ['application/pdf']
    let xml = ['text/xml']

    let form = new Form({
        title: `Subir comprobante de pago`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}/pagoscasas/upload_comprobante`,
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
            new HiddenField({ id: 'id_casas', value: data.idProcesoCasas }),
            // new HiddenField({ id: 'id_avance',  value: data.idAvance }),
            new FileField({   id: 'archivo',   label: 'Archivo PDF o Foto', placeholder: 'Selecciona un archivo', accept: pdf, required: true }),
        ],
    })

    form.show()
}

show_form = function(proceso) {
    let form = new Form({
        title: 'Capturar monto depositado',
        onSubmit: function(data){
            // console.log(data.get('nuevo_avance'))

            $.ajax({
                type: 'POST',
                url: `add_monto_depositado`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha capturado el monto depositado.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso', value: proceso.idProcesoPagos }),
            new HiddenField({ id: 'id_casas',   value: proceso.idProcesoCasas }),
            new NumberField({ id: 'monto',      value: proceso.montoDepositado,          label: '', placeholder: 'Ingresa la cantidad', width:'12', required: true, mask: "#,##0.00" }),
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
        if(data.montoDepositado){
            return formatter.format(data.montoDepositado)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        let pass_button = ''
        if(data.archivo && data.montoDepositado){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Iniciar proceso', onClick: pass_to_next, data})
        }

        let view_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar comprobante de pago`, onClick: show_preview, data})
        }
        let upload_button = new RowButton({icon: 'file_upload', label: 'Subir comprobante de pago', onClick: show_upload, data})
        let amount_button = new RowButton({icon: 'edit', label: 'Capturar monto depositado', onClick: show_form, data})

        return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${amount_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_iniciar_proceso',
    columns,
})