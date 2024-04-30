pass_to_confirmar_pago = function(data) {
    let form = new Form({
        title: 'Validar deposito', 
        text: `¿Validar el deposito del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_confirmar_pago`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El deposito del lote ha sido validado.", "success");
        
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
        let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: 'go_to_documentos', data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar deposito', onClick: pass_to_confirmar_pago, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentacion, data})
        
        return `<div class="d-flex justify-center">${docu_button}${pass_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_validar_deposito',
    columns,
})