pass_to_solicitud_contratos = function(data) {

    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote <b>${data.nombreLote}</b> a cierre de cifras?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_carga_cifras`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha pasado al proceso de cierre de cifras.", "success");
        
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
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
        ],
    })

    form.show()
}

back_to_adeudos = function(data) {

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote <b>${data.nombreLote}</b> a concentración de adeudos?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_solicitar_contratos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a concentración de adeudos.`, "success");
        
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
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
        ],
    })

    form.show()
}

go_to_documentos = function(data) {
    window.location.href = `vobo_contratos/${data.idProcesoCasas}`;
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Recepción de contratos",
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
        let docu_button = new RowButton({icon: 'toc', label: 'Ver documentos', onClick: go_to_documentos, data})

        let pass_button = ''
        if(data.documentos >= 4){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Enviar a cierre de cifras', onClick: pass_to_solicitud_contratos, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentración de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_recepcion_contratos',
    buttons: buttons,
    columns,
})