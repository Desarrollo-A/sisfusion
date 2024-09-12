let tipo = 0 // este se define a base del rol y nos da a saber de que área viene el voBo
let documento = 0
let tipoContrato = ''
let documentos = []

switch(idRol){
    case 57: // titulacion
        tipo = 1;
        documento = 33
        documentos = [ 33, 34, 35 ]
        campo = "contratoTitulacion"
        break;
    
    case 99: // OOAM
        tipo = 2;
        documento = 49
        tipoContrato = 'solicitud de elaboración de contrato';
        documentos = [ 49 ]
        campo = "contratoOOAM"
        break;

    case 33:
    case 76:
    case 81:
    case 55: // postventa 
        tipo = 3
        documento = 24
        tipoContrato = 'solicitud de medidor';
        documentos = [ 24 ]
        campo = "contratoPV"
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
        title: 'Avanzar proceso',
        text: `¿Deseas avanzar el proceso del lote <b>${data.nombreLote}</b>?`,
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
                        alerts.showNotification("top", "right", response.message, "success")
                        table.reload()
                        form.hide() 
                    }else{
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
            let pass_button = ''
            // let view_button = new RowButton({ icon: 'visibility', color: '', label: 'Ver documento', onClick: show_preview, data })
            // let upload_button = new RowButton({ icon: 'file_upload', color: '', label: `Cargar documento`, onClick: file_upload, data })
            let subir_contratos = new RowButton({icon: 'toc', color: '', label: 'Subir contratos', onClick: go_to_documentos, data});
            let decline_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazo_proceso, data })

            if( (tipo == 1 && data.documentos == 3) || (tipo == 2) || (tipo == 3) ){
                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: avance_contratos, data })
            }

            return `<div class="d-flex justify-center">${pass_button}${subir_contratos}${decline_button}</div>`
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_elaborar_contrato',
    params: { tipo: tipo },
    buttons: buttons,
    columns,
})

function file_upload(data) {
    let form = new Form({
        title: `Subir ${tipoContrato}`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/uploadDocumentoCreditoBanco`,
                data: data,
                contentType: false,
                processData: false,
                success: function(response){
                    alerts.showNotification("top", "right", "Se ha cargado el archivo", "success");
                        
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
        text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoBancoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    alerts.showNotification("top", "right", "Se ha rechazado el proceso correctamente", "success")
        
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
            new HiddenField({ id: 'tipo', value: tipo }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 8 }),
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

go_to_documentos = function(data) {
    window.location.href = `documentacionContratos/${data.idProcesoCasas}`;
}