const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'nombreCliente' },
    { data: 'nombreAsesor' },
    { data: 'nombreGerente' },
    { data: 'tiempoProceso' },
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

            return `<span class="label lbl-${clase}">${data.nombreMovimiento}</span>`
        }
    },
    {
        data: function(data){
            let subir_archivo = new RowButton({icon: 'file_upload', label: 'Cargar documento', onClick: file_upload, data})
            let btn_avance = '';
            // let btn_rechazo = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: file_upload, data});
            let view_button = '';
            let btn_rechazo = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazo_proceso, data});;
        
            if(data.archivo != null){
                btn_avance = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: avanceProcesoBanco, data})
                view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
            }

            if([5, 6].includes(data.proceso) && data.cierreContraloria == 0){
                return `<div class="d-flex justify-center">${btn_avance}${view_button}${subir_archivo}${btn_rechazo}</div>`
            }
            else{
                return ''
            }
        } 
    }
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Ingresar adeudo",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/getLotesProcesoBanco',
    params: { proceso: [5, 6], tipoDocumento: 25, tipoSaldo: 1, campo: "cierreContraloria" },
    buttons: buttons,
    columns,
})

function avanceProcesoBanco(data){
    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/avancePreCierre`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    if(response.result){
                        if(response.avance == 1){
                            avanceProceso(data, form);
                        }
                        else{
                            alerts.showNotification("top", "right", response.message, "success")

                            table.reload()
                            form.hide()  
                        }                        
                    }
                    else{
                        alerts.showNotification("top", "right", response.message, "danger")
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
            new HiddenField({ id: 'procesoNuevo', value: 7 }),
            new HiddenField({ id: 'saldoAdmon', value: data.saldoAdmon }),
            new HiddenField({ id: 'saldoOOAM', value: data.saldoOOAM }),
            new HiddenField({ id: 'saldoGPH', value: data.saldoGPH }),
            new HiddenField({ id: 'saldoPV', value: data.saldoPV }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show();
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

function file_upload(data) {
    let form = new Form({
        title: 'Cargar pre cierre de cifras',
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/uploadDocumentoCreditoBanco`,
                data: data,
                contentType: false,
                processData: false,
                success: function(response){
                    alerts.showNotification("top", "right", "Documento cargado con éxito", "success");
                        
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
            new HiddenField({ id: 'id_documento', value: 25 }),
            new HiddenField({ id: 'nombre_lote', value: data.nombreLote }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true}),
        ]
    })

    form.show()
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

rechazo_proceso = function (data) {
    let form = new Form({
        title: 'Rechazar proceso',
        text: `¿Desea rechazar el lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/rechazoPaso7`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    if(response.result){
                        finalizar_rechazo(data, form)
                    }
                    else{                
                        alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")                           
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
            new HiddenField({ id: 'procesoNuevo', value: 4 }),
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
            alerts.showNotification("top", "right", "Se ha rechazado el proceso correctamente", "success")

            table.reload()
            form.hide()                             
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")

            form.loading(false)
        }
    })
}