function edit_cotizacion(cotizacion) {
    let accept = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']

    let form = new Form({
        title: 'Editar cotización',
    })

    form.onSubmit = function(data){
        //console.log(data)

        $.ajax({
            type: 'POST',
            url: `${general_base_url}casas/save_cotizacion`,
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log(response)
                alerts.showNotification("top", "right", "Cotización guardada correctamente.", "success");
                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'idCotizacion',   value: cotizacion.idCotizacion }),
        new HiddenField({ id: 'idProcesoCasas', value: cotizacion.idProcesoCasas }),
        new TextField({ id: 'nombre',           value: cotizacion.nombre, label: 'Nombre de la cotización', placeholder: 'Ingresa la nombre', width:'12', required:'required' }),
        new FileField({ id: 'archivo',          label: 'Archivo', placeholder: 'Selecciona un archivo', accept }),
    ]

    form.show();
}

backPage = function() {
    window.location.href = `${general_base_url}casas/propuesta_firma`
}

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

let columns = [
    { data: 'idCotizacion' },
    { data: 'nombre' },
    { data: 'archivo' },
    { data: function(data){
        let view_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'file_download', label: `Descargar ${data.nombre}`, onClick: download_file, data})
        }
        let edit_button = new RowButton({icon: 'edit', label: 'Editar cotización', onClick: edit_cotizacion, data})

        return `<div class="d-flex justify-center">${view_button}${edit_button}</div>`
    } },
]

let buttons = [
    {
        text: '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
        action: function() {
            backPage()
        },
        attr: {
            class: 'btn-back',
            style: 'position: relative; float: left',
            title: 'Regresar'
        }
    },
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Propuestas de firma",
        exportOptions: {
            columns: [0, 1, 2, 3],
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
    url: `casas/lista_cotizaciones/${idProcesoCasas}`,
    buttons: buttons,
    columns,
    buttons: buttons,
})