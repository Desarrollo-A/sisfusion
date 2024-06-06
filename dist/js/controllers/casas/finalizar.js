finalizar = function(data) {
    
    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Finalizar proceso del lote ${data.nombreLote}?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `finalizar_proceso`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El proceso del lote ha finalizado.", "success");
        
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

back_to_firma_contrato = function(data) {

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Regresar el proceso del lote ${data.nombreLote}?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);
            
            $.ajax({
                type: 'POST',
                url: `back_to_firma_contrato`,
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

        if(data.finalizado){
            text = 'Finalizado'
        }

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
        
        let pass_button = ''
        let back_button = ''
        if(!data.finalizado){
            pass_button = new RowButton({icon: 'check', color: 'green', label: 'Finalizar proceso', onClick: finalizar, data})
            back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_firma_contrato, data})
        }

        return `<div class="d-flex justify-center">${pass_button}${back_button}</div>`
    } },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Finzalizar proceso",
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
    url: 'casas/lista_finalizar',
    columns,
    buttons:buttons
})

let filtro_proceso = new SelectFilter({ id: 'proceso', label: 'Proceso',  placeholder: 'Selecciona una opción'})

filtro_proceso.onChange(function(option){
    // console.log(option)

    table.setParams({finalizado: option.value})
    table.reload()
})

let status_option = [
    {value: -1, label: 'Todos'},
    {value: 1, label: 'Finalizado'},
    {value: 0, label: 'No finalizado'},
]

filtro_proceso.setOptions(status_option)

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proceso,
    ],
})