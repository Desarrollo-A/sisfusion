pass_to_next = function(data) {
    let form = new Form({
        title: 'Enviar a validación', 
        text: `¿Enviar documentación del lote <b>${data.nombreLote}</b> a validación por contraloría?`,
        onSubmit: function(data){
            $.ajax({
                type: 'POST',
                url: `to_validacion_contraloria`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido enviado a validación.", "success");
        
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
        let pass_button = ''
        if(data.documentos >= 6){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a validar documentos', onClick: pass_to_next, data})
        }

        return `<div class="d-flex justify-center">${pass_button}${docu_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_documentacion',
    columns,
})