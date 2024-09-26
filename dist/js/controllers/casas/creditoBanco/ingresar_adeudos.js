function set_adeudo(data) {
    let form = new Form({
        title: 'Ingresar adeudo',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
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
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `rechazoPaso2`,
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
            new HiddenField({ id: 'proceso', value: data.proceso }),
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
        new HiddenField({ id: 'proceso', value: data.proceso }),
        new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
    ]

    let form = new Form({
        title: 'Avanzar proceso', 
        text: `¿Deseas avanzar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `avancePaso2`,
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

go_to_documentos_directo = function(data) {
    window.location.href = `documentacionDirecto/${data.idProceso}`;
}



let columns = [
    {data: 'idLote'},
    {data: 'nombreLote'},
    {data: 'condominio'},
    {data: 'proyecto'},
    {data: 'cliente'},
    {data: 'nombreAsesor'},
    {data: 'gerente'},
    {data: function(data) {
        if(idRol == 99 && data.adeudoOOAM != null) {
            return formatter.format(data.adeudoOOAM);
        }
        else if((idRol === 33 || idRol === 11) && data.adeudoADM != null){
            return formatter.format(data.adeudoADM);
        }
        return 'Sin ingresar';
    }},
    { data: function(data) {
        let inicio = new Date(data.fechaProceso);
        let today = new Date();
        let difference = today.getTime() - inicio.getTime();
        let days = Math.floor(difference / (1000 * 3600 *24));
        let text = `LLeva ${days} dia(s)`;
        return text;
    }},
    { data: function(data) {
        let clase;
        switch(data.tipoMovimiento) {
            case 1: 
                clase = 'warning';
                break;
            case 2:
                clase = 'orange';
                break;
            default:
                clase = 'blueMaderas';
        }
        return `<span class="label lbl-${clase}">${data.movimiento}</span>`;
    }},
    {data: function (data) {
        //ESTATUS ESCRITURACIÓN
        if((data.escrituraFinalizada == 1 || data.id_estatus == 49)) {
            //FINISHED
            return `<span class="label lbl-green">ESCRITURADO</span>`;
        }
        if(data.escrituraFinalizada == 0 || data.escrituraFinalizada == 2) {
            if(data.id_estatus != null)  {
                if(data.revisionEscrituracion == 0 || data.revisionEscrituracion == null){
                    return `<span class="label lbl-orangeYellow">ESPERANDO AUTORIZACIÓN DE TITULACIÓN</span>`;    
                }else {
                    return `<span class="label lbl-blueMaderas">EN PROCESO</span>`;
                }
                
            }
            
            if(data.revisionEscrituracion == 0 || data.revisionEscrituracion == null) {
                return `<span class="label lbl-orangeYellow">ESPERANDO AUTORIZACIÓN DE TITULACIÓN</span>`;
            }

            if(data.revisionEscrituracion == 1) {
                return `<span class="label lbl-blueMaderas">EN PROCESO</span>`;
            }
        }
    }},
    {data: function(data) {
        let adeudo_button = '';
        let upload_button = '';
        let pass_button = '';
        let back_button = '';
        if(data.separator == 1) {
            if(idRol == 11 || idRol == 33) {
                adeudo_button = new RowButton({icon: 'edit', label: 'Ingresar adeudo', onClick: set_adeudo, data});
                if(data.revisionEscrituracion == 1 && data.escrituraFinalizada != 1){
                    upload_button = new RowButton({icon: 'toc', label: 'Cargar documentos', onClick: go_to_documentos, data});
                }
            }
            if(idRol == 99) {
                adeudo_button = new RowButton({icon: 'edit', label: 'Ingresar adeudo', onClick: set_adeudo, data});
                upload_button = new RowButton({icon: 'toc', label: 'Cargar documentos', onClick: go_to_documentos, data});
            }
            back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: back_to_carta_auth, data});

            if(idRol === 99 && data.adeudoOOAM != null){
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
            } else if((idRol == 11 || idRol == 33) && data.adeudoADM != null) {
                //FINISHED 100 %
                if((data.escrituraFinalizada == 1 || data.id_estatus == 49) && data.revisionEscrituracion == 1){
                    pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
                }
                if(data.cuentaDocumentos != 0 && data.revisionEscrituracion == 1) {
                    pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: pass_to_proyecto_ejecutivo, data})
                }
            }
           
        }
        return `<div class="d-flex justify-center">${pass_button}${upload_button}${adeudo_button}${back_button}</div>`;
    }}
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Ingresar adeudo",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
    buttons:buttons,
    columns,
})
