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

backPage = function() {
    window.location.href = `${general_base_url}casas/proyecto_ejecutivo`
}

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
        title:"Ingresar adeudo",
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

function show_upload(data) {
    console.log(data)

    let accept = ['application/pdf']

    if(data.tipo === 14){
        accept = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    }

    let form = new Form({
        title: `Subir ${data.documento}`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo subido con exito.", "success");

                    table.reload()

                    form.hide()
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id_proceso',     value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',   value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept }),
        ],
    })

    form.show()
}

let columns = [
    { data: 'idDocumento' },
    { data: 'documento' },
    { data: 'archivo' },
    { data: 'fechaModificacion' },
    { data: function(data){
        let view_button = ''
        if(data.archivo != 'Sin archivo' || data.archivo == null){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
        }

        let upload_button = new RowButton({icon: 'file_upload', color: 'green', label: `Subir ${data.documento}`, onClick: show_upload, data})

        return `<div class="d-flex justify-center">${view_button}${upload_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_documentos_proyecto_ejecutivo/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})