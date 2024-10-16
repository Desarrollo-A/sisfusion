function sendToAdeudos(data) {
    console.log(data)

    $.ajax({
        type: 'POST',
        url: `back_to_adeudos?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido regresado a concentracion de adeudos.`, "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        },
        fields: [
            new HiddenField({ id: 'idCliente', value: data.idCliente })
        ],
    })
}

back_to_adeudos = function(data) {
    let ask = new AskDialog({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a concentracion de adeudos?`,
        onOk: () => sendToAdeudos(data),
        //onCancel: sayNo,
    })

    ask.show()
}

go_to_documentos = function(data) {
    window.location.href = `contratos/${data.idProcesoCasas}`;
}

function sendToNext(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_confirmar_contratos?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para confirmar contratos.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_confirmar_contratos = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Confirmar recepcion de contratos"</b>?`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Subir contratos",
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
        let docu_button = new RowButton({icon: 'toc', label: 'Editar documentos', onClick: go_to_documentos, data})

        let pass_button = ''
        if(data.documentos >= 4){
             pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a confirmar contratos', onClick: pass_to_confirmar_contratos, data})
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar a concentracion de adeudos', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${docu_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_solicitar_contratos`,
    buttons: buttons,
    columns,
})