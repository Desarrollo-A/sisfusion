let nuevo_proceso = 9

pass_to_propuestas = function(data) {
    if(data.procesoNuevo < data.procesoAnterior){
        nuevo_proceso = data.procesoAnterior;
    }

    let form = new Form({
        title: 'Avanzar proceso', 
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_propuestas`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el lote correctamente", "success");
        
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
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new HiddenField({ id: 'idRol', value: idRol }),
            new HiddenField({ id: 'nuevo_proceso', value: nuevo_proceso }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

rechazar_proceso = function(data) {
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
                    alerts.showNotification("top", "right", "Se ha rechazado el proceso correctamente", "success");
        
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
            new HiddenField({ id: 'idRol', value: idRol }),
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 4}),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function updateItemsNot() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: 'options_notarias',
            success: function(response) {
                itemsNot = response;
                resolve(itemsNot);
            },
            error: function() {
                alerts.showNotification("top", "right", "Oops, algo salió mal al obtener las opciones de notarias.", "danger");
                reject(new Error("Error al obtener las opciones de notarias"));
            }
        });
    });
}

estatusNotaria = function(data) {
    if (!data) {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    } else {
        let form = new FormConfirm({
            title: `¿Estás seguro de ${data.estatus == 0 ? 'habilitar' : 'inhabilitar'} la notaría?`,
            onSubmit: function (data) {
                form.loading(true);

                $.ajax({
                    type: 'POST',
                    url: 'estatusNotaria',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alerts.showNotification("top", "right", "Notaría actualizada.", "success");

                        table.reload();

                        updateItemsNot().then(() => {
                            $.ajax({
                                type: 'GET',
                                url: 'getNotarias',
                                success: function (response) {
                                    items = response;
                                    gestorNotarias({ idProcesoCasas: data.id_opcion });
                                },
                                error: function () {
                                    alerts.showNotification("top", "right", "Oops, algo salió mal al obtener los datos.", "danger");
                                }
                            });
                        }).catch(err => {
                            console.error(err);
                        });

                        form.hide();
                    },
                    error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        form.loading(false);
                    }
                });
            },
            fields: [
                new HiddenField({ id: 'id_opcion', value: data.value }),
                new HiddenField({ id: 'estatus', value: data.estatus }),
            ],
        });

        form.show();
    }
}

selectNotarias = function(data) {
    updateItemsNot().then(() => {
        let form = new Form({
            title: 'Selección de notaria',
            onSubmit: function(data){
                form.loading(true);

                $.ajax({
                    type: 'POST',
                    url: `assignNotaria`,
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alerts.showNotification("top", "right", "Notaría registrada", "success");

                        table.reload();
                        form.hide();
                    },
                    error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        form.loading(false);
                    }
                })
            },
            fields: [
                new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
                
                new SelectField({ id: 'notaria', label: 'Notaria', value: data.notaria, placeholder: 'Selecciona una opción', data: itemsNot, required: true }),
            ],
        });

        form.show();
    }).catch(err => {
        console.error(err);
    });
}

addNotaria = function(data) {

    if(!data){
        alerts.showNotification("top", "right", "El campo esta vacío.", "danger");
    }else{
        let form = new FormConfirm({
            title: '¿Estás seguro de registrar la notaria?',
            onSubmit: function (data) {
                form.loading(true)
    
                $.ajax({
                    type: 'POST',
                    url: `addNotaria`,
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alerts.showNotification("top", "right", "Notaría agregada.", "success");
    
                        table.reload()

                        updateItemsNot().then(() => {
                            $.ajax({
                                type: 'GET',
                                url: 'getNotarias',
                                success: function (response) {
                                    items = response;
                                    gestorNotarias({ idProcesoCasas: data.id_opcion });
                                },
                                error: function () {
                                    alerts.showNotification("top", "right", "Oops, algo salió mal al obtener los datos.", "danger");
                                }
                            });
                        }).catch(err => {
                            console.error(err);
                        });

                        $.ajax({
                            type: 'GET',
                            url: 'getNotarias',
                            success: function (response) {
                                items = response;

                                gestorNotarias({ idProcesoCasas: data.id_opcion }); 
                            },
                            error: function () {
                                alerts.showNotification("top", "right", "Oops, algo salió mal al obtener los datos.", "danger");
                            }
                        });
    
                        form.hide()
                    },
                    error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    
                        form.loading(false)
                    }
                })
            },
            fields: [
                new HiddenField({ id: 'nombre', value: data }),
            ],
        })
    
        form.show()
    }
}

let items = []

$(document).on('click', '.btn-gestion', () => {
    gestorNotarias();
})

function gestorNotarias() {
    let form2 = new Form2({
        title: 'Gestión de notarías',
        fields: [
            new HrTitle({text: 'Registro de notaría'}),
            new CrudInput({ id: 'notaria', placeholder: 'Nombre de la notaría', width: '12', required: 'required', icon: 'add', title: 'Agregar', onClick: addNotaria }),
            new HrTitle({text: 'Lista de notarías'}),
            ...items.map(item => 
                new CrudInput({
                    id: `notaria${item.value}`,
                    placeholder: item.label,
                    width: '12',
                    required: 'required',
                    icon: item.estatus === 0 ? 'close' : 'check',
                    color: item.estatus === 0 ? 'warning' : 'green',
                    title: item.estatus === 0 ? 'Habilitar' : 'Inhabilitar',
                    disabled: true,
                    onClick: () => estatusNotaria(item)
                })
            ),
        ],
    });

    form2.show();
}

$.ajax({
    type: 'GET',
    url: 'getNotarias',
    async: false,
    success: function (response) {
        items = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

go_to_cotizaciones = function(data) {
    window.location.href = `cotizaciones/${data.idProcesoCasas}`;
}

function upload(data ) {

    let form = new Form({
        title: 'Cargar documento',
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
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
        ],
    })

    form.show()
}

function replace_upload(data) {

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
            new HiddenField({ id: 'tipo', value: idRol == 57 ? 17 : 28 }),
            new HiddenField({ id: 'name_documento', value: data.nombreArchivo }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true }),
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
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}

rechazaroProceso = function(data) {
    let form = new Form({
        title: 'Rechazar proceso', 
        text: `¿Deseas realizar el rechazar de proceso del lote ${data.nombreLote}`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_documentos`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ${data.nombreLote} ha sido rechazado.`, "success");
        
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
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function show_propuestas(data) {
    let form = new Form({
        title: `Propuestas de fechas para firma`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/save_propuestas`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Propuestas guardadas con éxito.", "success");

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
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'idPropuesta',    value: data.idPropuesta }),
            new DateDelete({ id: 'fechaFirma1', label: 'Primera propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma1, width:'12', required:'required' }),
            new DateDelete({ id: 'fechaFirma2', label: 'Segunda propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma2, width:'12' }),
            new DateDelete({ id: 'fechaFirma3', label: 'Tercera propuesta de fecha para firma',  placeholder: 'Elige una fecha', value: data.fechaFirma3, width:'12' }),
        ],
    })

    form.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
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

        return `<span class="label lbl-${clase}">${data.movimiento}</span>`
    } },
    { data: function(data){
        let propuestas_button = ''
        let upload_cotizacion = ''
        let upload_button = ''
        let pass_button = '';
        let back_button = '';
        let view_button = '';
        let notarias = '';

        if(idRol == 101){
            if (data.constancia) {
                view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
                upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: upload, data })
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_propuestas, data})
            }else{
                upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: replace_upload, data })
            }
        }

        if(idRol == 57){
            propuestas_button = new RowButton({icon: 'event', label: 'Propuestas de fechas', onClick: show_propuestas, data})
            upload_cotizacion = new RowButton({icon: 'list', label: 'Cargar propuestas de cotizaciones', onClick: go_to_cotizaciones, data})
            notarias = new RowButton({icon: 'gavel', label: 'Selección de notarías', onClick: selectNotarias, data})

            if (data.titulacion) {
                view_button = new RowButton({icon: 'visibility', label: `Visualizar títulos de propiedad`, onClick: show_preview, data})
            }
            upload_button = new RowButton({ icon: 'file_upload', label: `Cargar títulos de propiedad`, onClick: upload, data })
        }
        
        if(data.fechaFirma1 && data.cotizacionCargada >=1 && data.documentos == 1 && data.notarias != 0 && idRol === 57){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_propuestas, data})
        }

        back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazar_proceso, data})

        return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${upload_cotizacion}${propuestas_button}${notarias}${back_button}</div>`
    } },
]

let atributoButton = '';

if(idRol != 57){
    atributoButton = 'hidden'
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Propuesta de firma",
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
    },
    {
        text: '<i class="fas fa-edit"></i>',
        className: `btn-large btn-sky btn-gestion ${atributoButton}`,
        titleAttr: 'Gestionar notarías',
        title:"Gestionar notarías",
        attr: {
            style: 'position: relative; float: left; margin: 5px',
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_propuesta_firma',
    params: { rol: idRol },
    columns,
    buttons:buttons,
})