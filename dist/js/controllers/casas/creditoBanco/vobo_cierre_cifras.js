switch(idRol){
    case 33:
    case 76: 
    case 81: 
    case 55: // portventa 
        if(idUsuario == 5107){ // yolanda 
            tipo = 1;
        }
        else if(idUsuario == 4512){
            tipo = 3;
        }
        else{
            tipo = 4;
        }
        break;
    
    case 99: // OOAM
        tipo = 2;
        break;
    
    case 101: // gph
        tipo = 3;
        break;
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

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

function show_upload(data) {
    let form = new Form({
        title: 'Subir cierre de cifras',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Archivo cargado con éxito", "success");

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
            new HiddenField({ id: 'id_proceso', value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento', value: data.idDocumento }),
            new HiddenField({ id: 'name_documento', value: data.documento }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf'], required: true }),
        ],
    })

    form.show()
}

go_to_documentos = function(data) {
    window.location.href = `cierre_cifras_documentacion/${data.idProcesoCasas}`;
}


pass_to_vobo_cifras = function (data) {
    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote<b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `setCierreCifras`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.result){
                        if(response.avance == 1){
                            avanceProceso(data, form);
                        }
                        else{
                            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")
                            table.reload()
                            form.hide() 
                        }
                       
                    }
                    else{
                        alerts.showNotification("top", "right", response.message, "danger");
                        table.reload()
                        form.hide();
                    }                
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'tipo', value: tipo }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 14 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new HiddenField({ id: 'voboADM', value: data.voboADM }),
            new HiddenField({ id: 'voboOOAM', value: data.voboOOAM }),
            new HiddenField({ id: 'voboGPH', value: data.voboGPH }),
            new HiddenField({ id: 'voboPV', value: data.voboPV }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function avanceProceso(data, form){
    $.ajax({
        type: 'POST',
        url: `${general_base_url}casas/creditoBancoAvance`,
        data: data,
        contentType: false,
        processData: false,
        success : function(response){
            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")

            table.reload()
            form.hide()                             
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")

            form.loading(false)
        }
    })
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title: "Cierre de cifras",
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
    { data: 'nombreCliente' },
    { data: 'nombreAsesor' },
    { data: 'nombreGerente' },
    { data: 'tiempoProceso' },
    {
        data: function (data) {
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

            return `<span class="label lbl-${clase}">${data.nombreMovimiento}</span>`
        } 
    },
    {
        data: function (data) {
            let pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar proceso', onClick: pass_to_vobo_cifras, data })
            let decline_button = ''

            if( tipo == 1 && data.voboADM == 0){
                 return `<div class="d-flex justify-center">${pass_button}</div>`
            }
            if( tipo == 2 && data.voboOOAM == 0){
                 return `<div class="d-flex justify-center">${pass_button}</div>`
            }
            if( tipo == 3 && data.voboGPH == 0){
                 return `<div class="d-flex justify-center">${pass_button}</div>`
            }
            if( tipo == 4 && data.voboPV == 0){
                if(idUsuario == 2896){
                    decline_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar proceso', onClick: rechazo_proceso, data })
                }

                 return `<div class="d-flex justify-center">${pass_button}${decline_button}</div>`
            }
            else{
                return ''
            }
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/getLotesProcesoBanco',
    params: { proceso: 13, tipoDocumento: 0 },
    buttons: buttons,
    columns,
})

rechazo_proceso = function (data) {
    let form = new Form({
        title: 'Rechazar proceso',
        text: `¿Deseas rechazar el lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoBancoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")
        
                    table.reload()
                    form.hide()                             
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")
        
                    form.loading(false)
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 12 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),       
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}