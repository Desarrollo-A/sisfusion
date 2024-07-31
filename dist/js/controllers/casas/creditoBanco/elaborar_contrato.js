let tipo = 0; // este se define a base del rol y nos da a saber de que área viene el voBo
let documento = 0;
let tipoContrato = '';

switch(idRol){
    case 57: // titulacion
        tipo = 1;
        documento = 33
        tipoContrato = 'contrato a mano alzada';
        break;
    
    case 99: // OOAM
        tipo = 2;
        documento = 34
        tipoContrato = 'contrato de tesorería';
        break;

    case 33:
    case 76: 
    case 81:
    case 55: // postventa 
        tipo = 3
        documento = 35
        tipoContrato = 'contrato de servicios arquitectonicos';
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
                    alerts.showNotification("top", "right", "Archivo subido con éxito.", "success");

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

avance_contratos = function (data) {
    let form = new Form({
        title: 'Continuar proceso',
        text: `¿Desea avanzar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `setAvanceContratos`,
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
            new HiddenField({ id: 'procesoNuevo', value: 15 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new HiddenField({ id: 'contratoTitulacion', value: data.contratoTitulacion }),
            new HiddenField({ id: 'contratoOOAM', value: data.contratoOOAM }),
            new HiddenField({ id: 'contratoPV', value: data.contratoPV }),           
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
            let pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar proceso', onClick: avance_contratos, data })
            let decline_button = ''
            let view_button = new RowButton({ icon: 'visibility', color: '', label: 'Ver contrato', onClick: show_preview, data })
            let upload_button = new RowButton({ icon: 'file_upload', color: '', label: `Subir ${tipoContrato}`, onClick: file_upload, data })

            if( tipo == 1 && data.contratoTitulacion == 0){
                if(data.documento != null){
                    return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${decline_button}</div>`
                }
                else{
                    return `<div class="d-flex justify-center">${upload_button}${decline_button}</div>`
                }                 
            }
            if( tipo == 2 && data.contratoOOAM == 0){
                if(data.documento != null){
                    return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${decline_button}</div>`
                }
                else{
                    return `<div class="d-flex justify-center">${upload_button}${decline_button}</div>`
                }  
            }
            if( tipo == 3 && data.contratoPV == 0){
                if(data.documento != null){
                    if(idUsuario == 2896){
                        decline_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar proceso', onClick: rechazo_proceso, data })
                    }

                    return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${decline_button}</div>`
                }
                else{
                    return `<div class="d-flex justify-center">${upload_button}${decline_button}</div>`
                }  
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
    params: { proceso: 14, tipoDocumento: documento },
    buttons: buttons,
    columns,
})


function file_upload(data) {
    let form = new Form({
        title: 'Subir orden de compra firmada',
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/uploadDocumentoCreditoBanco`,
                data: data,
                contentType: false,
                processData: false,
                success: function(response){
                    alerts.showNotification("top", "right", "Se ha subido el contrato", "success");
                        
                    table.reload()
                    form.hide()
                },
                error: function(){
                    alerts.showNotification("top", "right", "Ha ocurrido un error al enviar el archivo", "danger");

                    form.loading(false);
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'tipoDocumento', value: data.tipo }),
            new HiddenField({ id: 'id_documento', value: documento }), // aqui se define con la variable dependiendo el tipo de rol
            new HiddenField({ id: 'nombre_lote', value: data.nombreLote }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true}),
        ]
    })

    form.show()
}

rechazo_proceso = function (data) {
    let form = new Form({
        title: 'Rechazar proceso',
        text: `¿Desea rechazar el lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/rechazoPaso14`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    if(response.result){
                        finalizar_rechazo(data, form)
                    }
                    else{
                        alerts.showNotification("top", "right", "Error al rechazar el proceso", "danger")
        
                        table.reload()
                        form.hide() 
                    }                                                
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
            new HiddenField({ id: 'procesoNuevo', value: 13 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),       
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function finalizar_rechazo(data, form){
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