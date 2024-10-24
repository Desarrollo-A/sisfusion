function show_preview(data) {
    let url = `${general_base_url}casasDirecto/archivo/${data.archivo}`

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
    window.location.href = `${general_base_url}casasDirecto/archivo/${data.archivo}`
}

function show_upload(data) {

    let accept = ['application/pdf'];

    let form = new Form({
        title: 'Subir ' + data.documento.toLowerCase(),
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casasDirecto/uploadDocumentoPersona`,
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
            new HiddenField({ id: 'idProceso',     value: data.idProceso }),
            new HiddenField({ id: 'idDocumento',   value: data.tipo }),
            new HiddenField({ id: 'nombreDocumento', value: data.documento }),
            new HiddenField({ id: 'archivo', value: data.archivo }),
            new HiddenField({ id: 'nombreLote', value: nombreLote }),
            new FileField({   id: 'file_uploaded',  label: 'Archivo', placeholder: 'Selecciona un archivo', accept, required: true }),
        ],
    })

    form.show()
}

backPage = function() {
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
        if ([2,3,4,10,11,12,7,8,30,22,23,24,25].includes(data.tipo)) {
            return `<span>${data.documento}</span><span class="text-danger">*</span>`
        } else {
            return `<span>${data.documento}</span>`
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

            if(extension == 'xlsx'){
                view_button = new RowButton({icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data})
            }else{
                view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
            }

        }

        if (data.documento != 'Orden de compra') {
            upload_button = new RowButton({icon: 'file_upload', color: 'green', label: `Cargar documento`, onClick: show_upload, data})
        }
        
        return `<div class="d-flex justify-center">${view_button}${upload_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casasDirecto/lista_documentos_cliente_directo/${idProceso}`,
    buttons: buttons,
    columns,
})