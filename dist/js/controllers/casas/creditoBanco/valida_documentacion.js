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
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    window.open(url, '_blank').focus()
}

backPage = function() {
    window.location.href = `${general_base_url}casas/validacion_contraloria`
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
        title:"Documentacion del lote",
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
    { data: 'documento' },
    { data: function(data){
        if(data.archivo){
            return data.archivo
        }
        return 'sin archivo'
    } },
    { data: function(data){
        if(data.fechaModificacion){
            return data.fechaModificacion.substring(0, 16)
        }
        return 'no subido'
    } },
    { data: function(data){
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
            let parts = data.archivo ? data.archivo.split('.') : [];
            let extension = parts.pop();

            if(extension == 'xlsx'){
                view_button = new RowButton({icon: 'file_download', label: `Descargar documento`, onClick: download_file, data})
            }
        }else{
            view_button = new RowButton({icon: 'visibility_off', color: 'yellow',  label: `Archivo no subido`})
        }

        return `<div class="d-flex justify-center">${view_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_valida_documentacion/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})