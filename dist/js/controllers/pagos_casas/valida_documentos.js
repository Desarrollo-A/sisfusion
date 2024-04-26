back_to_documentacion = function(data) {
    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Regresar proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `back_to_documentacion`,
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

pass_to_validar_deposito = function(data) {
    let form = new Form({
        title: 'Validar documentacion', 
        text: `¿Validar la documentación del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validar_deposito`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "La documentación del lote ha sido validada.", "success");
        
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
    window.location.href = `lista_valida_documentos/${data.idProcesoPagos}`;
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: function(data) {
        if(data.costoConstruccion){
            return `$ ${data.costoConstruccion.toFixed(2)}`
        }else{
            return ''
        }
    } },
    { data: function(data) {
        if(data.montoDepositado){
            return `$ ${data.montoDepositado.toFixed(2)}`
        }else{
            return ''
        }
    } },
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
        let docu_button = new RowButton({icon: 'toc', label: 'Ver documentos', onClick: go_to_documentos, data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar documentación', onClick: pass_to_validar_deposito, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentacion, data})
        
        return `<div class="d-flex justify-center">${docu_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_valida_documentacion',
    columns,
})