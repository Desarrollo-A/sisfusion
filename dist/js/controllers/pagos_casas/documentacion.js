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
        new NumberField({ id: 'costoConstruccion', label: 'Costo construccion', placeholder: 'Ingresa la cantidad' }),
        new NumberField({ id: 'montoDepositado', label: 'Monto depositado', placeholder: 'Ingresa la cantidad' }),
    ]

    form.show()
}

go_to_documentos = function(data) {
    window.location.href = `subir_documentacion/${data.idProcesoPagos}`;
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
        let docu_button = new RowButton({icon: 'toc', label: 'Subir documentos', onClick: go_to_documentos, data})
        let montos_button = new RowButton({icon: 'edit', label: 'Editar montos', onClick: edit_montos, data})

        let pass_button = ''
        if(data.montoDepositado && data.costoConstruccion){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Iniciar proceso', onClick: go_to_documentos, data})
        }

        return `<div class="d-flex justify-center">${docu_button}${montos_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_documentacion',
    columns,
})