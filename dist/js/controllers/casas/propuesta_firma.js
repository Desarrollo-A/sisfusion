pass_to_propuestas = function(data) {
    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote <b>${data.nombreLote}</b> a elección de propuestas?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_propuestas`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha pasado al proceso de elección de propuestas.", "success");
        
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

go_to_cotizaciones = function(data) {
    window.location.href = `cotizaciones/${data.idProcesoCasas}`;
}

back_to_documentos = function(proceso) {
    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote <b>${proceso.nombreLote}</b> a documentación cliente?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_documentos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ${proceso.nombreLote} ha sido regresado a documentación cliente.`, "success");
        
                    table.reload()
                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: proceso.idProcesoCasas }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function show_propuestas(data) {
    let form = new Form({
        title: `Propuestas de fechas para firma`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/save_propuestas`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Propuestas guardadas con éxito.", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'idPropuesta',    value: data.idPropuesta }),
            new DateDelete({ id: 'fechaFirma1', label: 'Primera propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma1, width:'12', required:'required' }),
            new DateDelete({ id: 'fechaFirma2', label: 'Segunda propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma2, width:'12' }),
            new DateDelete({ id: 'fechaFirma3', label: 'Tercera propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma3, width:'12' }),
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
        let propuestas_button = new RowButton({icon: 'list', label: 'Propuestas de fechas', onClick: show_propuestas, data})
        let upload_button = new RowButton({icon: 'file_upload', label: 'Subir archivos', onClick: go_to_cotizaciones, data})

        let pass_button = ''
        
        if(data.fechaFirma1 && data.cotizaciones && data.documentos){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a elección de propuestas', onClick: pass_to_propuestas, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentos, data})

        return `<div class="d-flex justify-center">${propuestas_button}${upload_button}${pass_button}${back_button}</div>`
    } },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Propuesta de firma",
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

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_propuesta_firma',
    columns,
    buttons:buttons,
})