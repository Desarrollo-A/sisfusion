pass_to_validacion = function(data) {
    let form = new Form({
        title: 'Enviar a validacion', 
        text: `¿Enviar documentacion del lote <b>${data.nombreLote}</b> a validacion por contraloria?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validacion`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido enviado a validacion.", "success");
        
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

function edit_montos(data) {
    let form = new Form({
        title: 'Editar montos',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)

        $.ajax({
            type: 'POST',
            url: 'edit_montos',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response)

                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'idProcesoPagos', value: data.idProcesoPagos }),
        new NumberField({ id: 'costoConstruccion', value: data.costoConstruccion, label: 'Costo construccion', placeholder: 'Ingresa la cantidad', required: true, mask: "#,##0.00" }),
        new NumberField({ id: 'montoDepositado', value: data.montoDepositado, label: 'Monto depositado', placeholder: 'Ingresa la cantidad', required: true, mask: "#,##0.00" }),
    ]

    form.show()
}

go_to_documentos = function(data) {
    window.location.href = `subir_documentacion/${data.idProcesoPagos}`;
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
    { data: function(data) {
        if(data.costoConstruccion){
            return formatter.format(data.costoConstruccion)
        }
        return 'Sin ingresar'
    } },
    { data: function(data) {
        if(data.montoDepositado){
            return formatter.format(data.montoDepositado)
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
        let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: go_to_documentos, data})
        let montos_button = new RowButton({icon: 'edit', label: 'Editar montos', onClick: edit_montos, data})

        let pass_button = ''
        if(data.montoDepositado && data.costoConstruccion && data.documentos >= 6){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a validar documentos', onClick: pass_to_validacion, data})
        }

        return `<div class="d-flex justify-center">${docu_button}${montos_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_documentacion',
    columns,
})