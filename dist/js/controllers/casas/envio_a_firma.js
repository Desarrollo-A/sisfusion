pass_to_firma_contrato = function(data) {

    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Marcar contrato como enviado a firma por R.L. del lote ${data.nombreLote}?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_firma_contrato`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha pasado al siguiente proceso.", "success");
        
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

back_to_expediente_cliente = function(data) {

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Regresar el proceso del lote ${data.nombreLote}?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_expediente_cliente`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado.`, "success");
        
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

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Envio a firma de R.L.",
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
        vigencia.setDate(vigencia.getDate() + 1)
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
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a firma', onClick: pass_to_firma_contrato, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_expediente_cliente, data})

        return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_envio_a_firma',
    buttons:buttons,
    columns,
})