function sendToNext(data) {
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_documentacion_cliente?id=${data.idProcesoCasas}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha pasado al proceso para subir documentación del cliente.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

pass_to_proyecto_ejecutivo = function(data) {
    let form = new Form({
        title: 'Avanzar proceso', 
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b> ?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_valida_comite`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente.", "success");
        
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
            new HiddenField({ id: 'documentos', value: data.documentos }),
        ],
    })

    form.show()
}

back_to_carta_auth = function (data) {

    let form = new Form({
        title: 'Regresar proceso',
        text: `¿Deseas regresar el proceso del lote <b>${data.nombreLote}</b> a carta de autorización?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_carta_auth`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a carta de autorización.`, "success");
        
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

const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

go_to_documentos = function(data) {
    window.location.href = `documentacion/${data.idProcesoCasas}`;
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
        if(data.adeudoOOAM){
            return formatter.format(data.adeudoOOAM)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        if(data.adeudoADM){
            return formatter.format(data.adeudoADM)
        }
        return 'Sin ingresar'
    } },
    {
        data: function (data) {
            let inicio = new Date(data.fechaProceso)
            let today = new Date()

            let difference = today.getTime() - inicio.getTime()

            let days = Math.floor(difference / (1000 * 3600 * 24))

            let text = `Lleva ${days} día(s)`

            return text
        }
    },
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
    {
        data: function (data) {
            // console.log(data)

            let pass_button = ''
            if(data.documentos == 3){
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
            }

            let docu_button = new RowButton({icon: 'toc', label: 'Cargar documentos', onClick: go_to_documentos, data})
            let back_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: back_to_carta_auth, data })

            return `<div class="d-flex justify-center">${pass_button}${docu_button}${back_button}</div>`
        }
    },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Concentración de adeudos",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
    url: 'casas/concentracion_adeudos',
    params: {documentos: [13,14,15]},
    buttons:buttons,
    columns,
})