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

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

function show_upload(data) {
    let accept = '';
    switch(data.tipo) {
        case 11 :
            accept = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            break;
        case 36 :
            accept = ['application/pdf', 'image/jpeg'];
            break;
        default:
            accept = ['application/pdf'];
            break;
    }

    //let accept = ['application/pdf'];

    let form = new Form({
        title: 'Subir ' + data.documento.toLowerCase(),
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Documento cargado con éxito", "success");

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
            new HiddenField({ id: 'id_proceso',     value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',   value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({   id: 'file_uploaded',  label: 'Archivo', placeholder: 'Selecciona un archivo', accept, required: true }),
            new HiddenField({ id: 'idCliente', value: data.idCliente})
        ],
    })

    form.show()
}

backPage = function() {
    // window.location.href = `${general_base_url}casas/adeudos`
    history.back();
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
        title:"Documentación del lote",
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

let columns = [
    { data: 'idDocumento' },
    { data: function(data){
        if(data.tipo != 11) {
            return data.documento;
        } else {
            return 'ARCHIVO ZIP';
        }
    }},
    { data: 'archivo' },
    { data: function(data){
        if(data.fechaModificacion){
            return data.fechaModificacion.substring(0, 16)
        }
        return 'Sin fecha de carga'
    } },
    { data: function(data){
        let view_button = '';
        let parts = data.archivo.split('.');
        let extension = parts.pop();
        let upload_button = '';

        if(data.archivo != 'Sin archivo'){

            if(extension == 'xlsx' || data.tipo == 11){
                view_button = new RowButton({icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data})
            }else if(data.tipo != 11 && extension != 'xlsx'){
                view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
            }

        }
        if(data.tipo != 11){
            upload_button = new RowButton({icon: 'file_upload', color: 'green', label: `Cargar documento`, onClick: show_upload, data})
        }
        else {
            upload_button = new RowButton({icon: 'file_upload', label: 'Cargar archivo zip', onClick: cargarZip, data});
        }
        
        return `<div class="d-flex justify-center">${view_button}${upload_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_documentos_cliente/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})


function cargarZip (data) {
    console.log("data: ", data.idCliente);
    let accept = ['application/zip', 'application/x-zip-compressed', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/octet-stream'];
    let form = new Form({
        title: 'Carga el archivo zip',
        text: 'Recuerda que el archivo zip no puede ser mayor a 8MB',
        onSubmit: function(data) {
            let file = data.get('file_uploaded');
            form.loading(false);
            $.ajax({
                type: 'POST',
                url: `${general_base_url}/casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Documento cargado con éxito", "success");
                    table.reload();
                    form.hide();
                },
                error: function() {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    form.loading(false);
                }
            })
        }, 
        fields: [
            new HiddenField({id: 'id_proceso', value: data.idProcesoCasas}),
            new HiddenField({id: 'id_documento', value: data.idDocumento}),
            new HiddenField({id: 'name_documento', value: data.documento}),
            new HiddenField({id: 'tipo_documento', value: 17}),
            new FileField({id: 'file_uploaded', label: 'Carga el archivo .zip', placeholder: 'No has seleccionado un archivo', accept: accept, required: true, maxSizeMB: 2}),
            new HiddenField({ id: 'idCliente', value: data.idCliente})  
        ],
    });
    form.show();
}
