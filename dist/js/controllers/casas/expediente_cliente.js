pass_to_envio_a_firma = function(data) {
    /* let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Marcar como recibido el expediente del cliente ${data.nombreLote}?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show() */
    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Marcar como recibido el expediente del cliente <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_envio_a_firma`,
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

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Ingreso de expediente de cliente",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
        let inicio = new Date(data.fechaProceso)
        let today = new Date()

        let difference = today.getTime() - inicio.getTime()

        let days = Math.floor(difference / (1000 * 3600 * 24))

        let text = `Lleva ${days} día(s)`

        return text
    } },
    { data: function (data) {
        switch(data.tipoMovimiento){
        case 1:
            clase = 'warning'
            break
        case 2:
            clase = 'orange'
            break
        default:
            clase = 'blueMaderas'
        }

        return `<span class="label lbl-${clase}">${data.movimiento}</span>`
    } },
    { data: function(data){
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a envío de firma', onClick: pass_to_envio_a_firma, data})

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a carga de cierre de cifras', onClick: back_to_cierre_cifras, data})

        return `<div class="d-flex justify-center">${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_expediente_cliente',
    buttons:buttons,
    columns,
})