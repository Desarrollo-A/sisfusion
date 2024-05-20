pass_to_validar_avance = function(data) {
    let form = new Form({
        title: 'Validar avance', 
        text: `¿Enviar el lote <b>${data.nombreLote}</b> para validar avance?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validar_avance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se envió el lote al proceso para validar avance.", "success");
        
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
            new HiddenField({ id: 'avance', value: data.nuevo_avance }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

show_form = function(data) {
    let form = new Form({
        title: 'Ingresar avance',
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `add_avance`,
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
            new HiddenField({ id: 'id_proceso',     value: data.idProcesoPagos }),
            new HiddenField({ id: 'id_avance',      value: data.idAvance }),
            new NumberField({ id: 'nuevo_avance',   value: data.nuevo_avance,   label: 'Nuevo avance',  placeholder: 'Ingresa la cantidad', width:'12', required:'required' }),
            new NumberField({ id: 'monto',          value: data.monto,          label: 'Monto a pagar', placeholder: 'Ingresa la cantidad', width:'12', required:'required' }),
        ],
    })

    form.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        return `${data.avance} %`
    } },
    { data: function(data){
        if(data.nuevo_avance){
            return `${data.nuevo_avance} %`
        }
        
        return ''
    } },
    { data: function(data){
        return `$ ${data.monto.toFixed(2)}`
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
        let docu_button = new RowButton({icon: 'toc', label: 'Ingresar nuevo avance', onClick: show_form, data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar depósito', onClick: pass_to_validar_avance, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentacion, data})
        
        return `<div class="d-flex justify-center">${docu_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_solicitar_avance',
    columns,
})