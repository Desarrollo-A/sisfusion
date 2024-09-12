back_to_adeudos = function(data) {

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a concentracion de adeudos?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_adeudos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a concentracion de adeudos.`, "success");
        
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

go_to_documentos = function(data) {
    window.location.href = `documentos_proyecto_ejecutivo/${data.idProcesoCasas}`;
}

function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_valida_comite?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para ser validado por comite tecnico.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_proyecto_ejecutivo = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Validacion por comite tecnico"</b>?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
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
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 5)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} día(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        return text
    } },
    { data: function(data){
        let docu_button = new RowButton({icon: 'toc', label: 'Editar documentos', onClick: go_to_documentos, data})

        let pass_button = ''
        if(data.documentos >= 2){
             // pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a validacion de proyecto', onClick: pass_to_proyecto_ejecutivo, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentracion de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}${pass_button}${back_button}</div>`
    } },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Proyecto ejecutivo",
        exportOptions: {
            columns: [0, 1, 2],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_proyecto_ejecutivo_documentos',
    buttons:buttons,
    columns,
})