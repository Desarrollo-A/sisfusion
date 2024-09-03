function set_adeudo(data) {
    // console.log(data)
    let form = new Form({
        title: 'Ingresar adeudo',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)
        form.loading(true)

        $.ajax({
            type: 'POST',
            url: 'ingresar_adeudo',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {

                alerts.showNotification("top", "right", "Adeudo ingresado correctamente.", "success");

                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                form.loading(false)
            }
        })
    }

    // console.log(data)

    let adeudo
    let value
    let label
    switch(idRol){
        case 99:
            adeudo = 'adeudoOOAM'
            value = data.adeudoOOAM
            label = 'Adeudo OOAM'
            break
        case 33:
            adeudo = 'adeudoADM'
            value = data.adeudoADM
            label = 'Adeudo administración'
            break
        case 11:
            adeudo = 'adeudoADM'
            value = data.adeudoADM
            label = 'Adeudo administración'
            break

    }

    form.fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new HiddenField({ id: 'adeudo', value: adeudo }),
        new NumberField({ id: 'cantidad', value, label, placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
        // new NumberField({ id: 'adeudoAdm', value: data.adeudoADM, label: 'Adeudo ADM', placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
        // new NumberField({ id: 'adeudoGph', value: data.adeudoGPH, label: 'Adeudo GPH', placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
    ]

    form.show()
}

const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

back_to_carta_auth = function (data) {

    let form = new Form({
        title: 'Regresar proceso',
        text: `¿Deseas regresar el proceso del lote <b>${data.nombreLote}</b> a carta de autorización?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_carta_auth`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a carta de autorización.`, "success");
        
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
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

function replace_upload(data ) {

    let accept = '';

    switch (idRol) {
        case 99:
            accept = ['image/png','image/jpeg','application/pdf']
            break;
        case 33:
            accept = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            break;
        case 11:
            accept = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            break;
    }

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
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: accept, required: true }),
        ],
    })

    form.show()
}

function upload(data) {
    // console.log(data)

    let tipo = 0;
    let nameFile = '';
    let accept = '';

    switch (idRol) {
        case 99:
            tipo = 27;
            nameFile = 'Estado de cuenta'
            accept = ['image/png','image/jpeg','application/pdf']
            break;
        case 33:
            tipo = 26;
            nameFile = 'Formas de pago administración'
            accept = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            break;
        case 11:
            tipo = 26;
            nameFile = 'Formas de pago administración'
            accept = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            break;
    }

    let form = new Form({
        title: 'Subir archivo',
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `upload_documento_new`,
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
            new HiddenField({ id: 'tipo', value: tipo }),
            new HiddenField({ id: 'name_documento', value: nameFile }),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: accept, required: true }),
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

let tipos = [
    {label: 'Persona moral', value: 1},
    {label: 'Persona física', value: 2},
]

pass_to_proyecto_ejecutivo = function(data) {
    let fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
    ]

    /*
    if(idRol == 33){
        let select = new SelectField({ id: 'tipo_proveedor', value: data.tipoProveedor, label: 'Tipo de proveedor', placeholder: 'Selecciona una opción', data: tipos, required: true })
        fields.splice(0, 0, select)
    }
    */

    let form = new Form({
        title: 'Avanzar proceso', 
        text: `¿Deseas avanzar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_valida_comite`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: fields,
    })

    form.show()
}

go_to_documentos = function(data) {
    window.location.href = `documentacion/${data.idProcesoCasas}`;
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        if(idRol === 99 && data.adeudoOOAM != null){
            return formatter.format(data.adeudoOOAM)
        }
        else if((idRol === 33 || idRol === 11) && data.adeudoADM != null){
            return formatter.format(data.adeudoADM)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        let inicio = new Date(data.fechaProceso)
        let today = new Date()

        let difference = today.getTime() - inicio.getTime()

        let days = Math.floor(difference / (1000 * 3600 * 24))

        let text = `Lleva ${days} día(s)`

        return text
    } },
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
    {data : function (data) {
        if(data.id_estatus == null) {
            return `<span class="label lbl-warning">SIN ESTATUS</span>`;;
        }
        if(data.id_estatus == 49) {
            return `<span class="label lbl-green">CONCLUIDO</span>`;
        }
        if(data.id_estatus != 49 && data.id_estatus != null) {
            return `<span class="label lbl-blueMaderas">EN PROCESO</span>`;
        }
    }},
    { data: function(data){
        let formas_pago = '';

        if(data.cargaRequerida == 1 && data.cuentaDocumentos == 0 && (idRol == 33))
        {
            formas_pago = new RowButton({icon: 'file_upload', label: 'Cargar formas de pago', onClick: set_formas_pago,data});
        }
        
        let adeudo_button = new RowButton({icon: 'edit', label: 'Ingresar adeudo', onClick: set_adeudo, data})

        let upload_button = new RowButton({icon: 'toc', label: 'Cargar documentos', onClick: go_to_documentos, data});

        let nameFile = '';

        let view_button = '';

        // switch (idRol) {
        //     case 99:
        //         nameFile = 'Estado de cuenta'
        //         break;
        //     case 33:
        //         nameFile = 'Formas de pago administración'
        //         break;
        //     case 11:
        //         nameFile = 'Formas de pago administración'
        //         break;
        // }

        // if (data.archivo) {
        //     let parts = data.archivo.split('.');
        //     let extension = parts.pop();
        //     if(extension == 'xlsx'){
        //         view_button = new RowButton({icon: 'file_download', label: `Descargar documento`, onClick: show_preview, data})
        //     }else{
        //         view_button = new RowButton({icon: 'visibility', label: `Visualizar ${nameFile}`, onClick: show_preview, data})
        //     }
        //     upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: replace_upload, data })
        // }else{
        //     upload_button = new RowButton({ icon: 'file_upload', label: `Cargar documento`, onClick: upload, data })
        // }

        let pass_button = ''

        if(idRol === 99 && data.adeudoOOAM != null){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
        }else if((idRol === 11 || idRol === 33) && data.adeudoADM != null && (data.cuentaDocumentos != 0 || data.cargaRequerida == 0)){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
        }

        let back_button = new RowButton({ icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: back_to_carta_auth, data })

        return `<div class="d-flex justify-center">${pass_button}${view_button}${upload_button}${adeudo_button}${back_button}${formas_pago}</div>`
    } },
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

var tipoDoc = 0;
if(idRol === 99){
    tipoDoc = 27;
}
if(idRol === 11 || idRol === 33){
    tipoDoc = 26;
}

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_adeudos`,
    columns,
})

set_formas_pago = function(data) {
    let nameFile = 'Formas de pago';
    let form = new Form({
        title: 'Cargar formas de pago',
        onSubmit: function(data) {
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/upload_documento_new`,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    alerts.showNotification("top", "right", "Archivo cargado con éxito.", "success");
                    table.reload();
                    form.hide();
                },
                error: function() {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false);
                }
            });
        }, 
        fields: [
            new HiddenField({id: 'id_proceso', value: data.idProcesoCasas}),
            new HiddenField({ id: 'tipo', value: 11}),
            new HiddenField({ id: 'name_documento', value: nameFile}),
            new FileField({ id: 'file_uploaded', label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'], required: true}),
        ]
    });
    
    form.show();
}
