function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

function show_preview(data) {
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}

function edit_cotizacion(cotizacion) {
    let accept = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']

    let form = new Form({
        title: 'Editar cotización',
    })

    form.onSubmit = function(data){
        //console.log(data)
        form.loading(true)

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

                form.loading(false)
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'idCotizacion',   value: cotizacion.idCotizacion }),
        new HiddenField({ id: 'idProcesoCasas', value: cotizacion.idProcesoCasas }),
        new TextField({ id: 'nombre',           value: cotizacion.nombre, label: 'Nombre de la cotización', placeholder: 'Ingresa la nombre', width:'12', required: true }),
        new FileField({ id: 'archivo',          label: 'Archivo', placeholder: 'Selecciona un archivo', accept, required: true }),
    ]

    form.show();
}

backPage = function() {
    window.location.href = `${general_base_url}casas/propuesta_firma`
}

function show_upload(data) {

    let accept = ['application/pdf']

    let form = new Form({
        title: `Subir ${data.documento}`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo subido con éxito.", "success");

                    table_titulos.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso',     value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',   value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({   id: 'file_uploaded',  label: 'Archivo', placeholder: 'Selecciona un archivo', accept }),
        ],
    })

    form.show()
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
    buttons,
    columns,
})

let titulos_columns = [
    { data: 'idDocumento' },
    { data: 'documento' },
    { data: function(data){
        if(data.archivo){
            return data.archivo
        }else{
            return 'Sin archivo'
        }
    } },
    { data: function(data){
        let view_button = ''

        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
        }

        let upload_button = new RowButton({icon: 'file_upload', color: 'green', label: `Subir ${data.documento}`, onClick: show_upload, data})
        
        return `<div class="d-flex justify-center">${view_button}${upload_button}</div>`
    } },
]

let table_titulos = new Table({
    id: '#tableTitulos',
    url: `casas/lista_archivos_titulos/${idProcesoCasas}`,
    columns: titulos_columns,
})