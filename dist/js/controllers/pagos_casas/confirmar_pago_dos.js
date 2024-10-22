back_to_seven = function(data) {
    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Deseas regresar el lote <b>${data.nombreLote}</b> al proceso 7?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `back_to_step_7`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido regresado al paso 7.", "success");
        
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
        title: 'Confirmar pago', 
        text: `¿Confirmar pago del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_carga_complemento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El pago del lote ha sido confirmado.", "success");
        
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
            new HiddenField({ id: 'paso', value: 9 }),
            new HiddenField({ id: 'id_avance', value: data.idAvance }),
            new HiddenField({ id: 'avanceObra', value: data.avanceObra }),
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
        // let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: 'go_to_documentos', data})

        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar depósito', onClick: pass_to_next, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_seven, data})
        
        return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_confirmar_pago_dos',
    columns,
})