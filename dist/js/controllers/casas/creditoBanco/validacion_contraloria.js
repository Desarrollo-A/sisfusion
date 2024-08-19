capturaContratos = function(data) {

    console.log(data)

    let form = new Form({
        title: 'Captura de montos de contrato',
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `capturaContratos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se registraron los montos de contrato.", "success");
        
                    table.reload();
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
            new HiddenField({ id: 'idCliente', value: data.id_cliente }),
            new NumberField({  id: 'obra', value: data.obra, label: 'Contrato de obra a mano alzada', width: '12', required:true, mask: "#,##0.00" }),
            new NumberField({  id: 'tesoreria', value: data.tesoreria, label: 'Contrato de tesorería', width: '12', required:true, mask: "#,##0.00" }),
            new NumberField({  id: 'serviciosArquitectonicos', value: data.serviciosArquitectonicos, label: 'Contrato de servicios arquitectónicos', width: '12', required:true, mask: "#,##0.00" }),
            new NumberField({  id: 'costoConstruccion', value: data.costoConstruccion, label: 'Costo total de construcción', width: '12', required:true, mask: "#,##0.00" }),
        ],
    })

    form.show()
}

back_to_adeudos = function(data) {

    let form = new Form({
        title: 'Rechazar proceso', 
        text: `¿Deseas rechazar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `creditoBancoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `Se ha rechazado el proceso correctamente`, "success");
        
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
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 4 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

pass_to_solicitud_contratos = function(data) {

    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Desea avanzar le proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_solicitud_contratos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente.", "success");
        
                    table.reload();
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

go_to_documentos = function(data) {
    window.location.href = `valida_documentacion/${data.idProcesoCasas}`;
}

function replace_upload(data) {

    let form = new Form({
        title: 'Reemplazar archivo',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento`,
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
            new HiddenField({ id: 'name_documento', value: data.nombreArchivo }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept : ['image/png','image/jpeg','application/pdf'], required: true }),
        ],
    })

    form.show()
}

function upload(data) {

    let form = new Form({
        title: 'Cargar documento',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento_new`,
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
            new HiddenField({ id: 'tipo', value: 30 }),
            new HiddenField({ id: 'name_documento', value: data.nombreArchivo }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept : ['image/png','image/jpeg','application/pdf'], required: true }),
        ],
    })

    form.show()
}

function show_preview(data) {
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando documento: ${data.documento}`,
        width: 985,
        height: 660
    });
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Validación de documentación",
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
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: 'tiempoProceso'},
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

        let upload_button = ''
        let view_button = '';
        let pass_button = '';

        if (data.archivo) {
            view_button = new RowButton({icon: 'visibility', label: `Visualizar distribución de pagos`, onClick: show_preview, data})
            upload_button = new RowButton({ icon: 'file_upload', label: `Cargar distribución de pagos`, onClick: replace_upload, data })
            if(data.tesoreria && data.serviciosArquitectonicos && data.obra){
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_solicitud_contratos, data})
            }
        }else{
            upload_button = new RowButton({ icon: 'file_upload', label: `Cargar distribución de pagos`, onClick: upload, data })
        }

        let contratos = new RowButton({icon: 'description', label: 'Captura de montos de contrato', onClick: capturaContratos, data})

        let docu_button = new RowButton({icon: 'toc', label: 'Ver documentos', onClick: go_to_documentos, data})

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: back_to_adeudos, data})

        return `<div class="d-flex justify-center">${pass_button}${docu_button}${view_button}${upload_button}${contratos}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_validacion_contraloria',
    buttons: buttons,
    columns,
})