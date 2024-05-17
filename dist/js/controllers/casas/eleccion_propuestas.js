function show_propuestas(proceso) {
    let form = new Form({
        title: 'Seleccionar propuesta',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        // console.log(data)
        form.loading(true)
        
        $.ajax({
            type: 'POST',
            url: `${general_base_url}casas/set_propuesta`,
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
               // console.log(response)
               alerts.showNotification("top", "right", `Propuesta seleccionada correctamente.`, "success");

                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                form.loading(false)
            }
        })
    }

    let cotizaciones = []
    let fechas = [
        { value: 1, title: proceso.fechaFirma1},
        ...proceso.fechaFirma2 ? [{ value: 2, title: proceso.fechaFirma2 }] : [],
        ...proceso.fechaFirma3 ? [{ value: 3, title: proceso.fechaFirma3  }] : [],
    ]

    $.ajax({
        type: 'GET',
        url: `${general_base_url}casas/get_cotizaciones?id=${proceso.idProcesoCasas}`,
        async: false,
        success: function (response) {
            cotizaciones = response
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })


    form.fields = [
        new HiddenField({ id: 'idProcesoCasas', value: proceso.idProcesoCasas }),
        new HiddenField({ id: 'idPropuesta', value: proceso.idPropuesta }),
        new title({ text: 'Cotizaciones' }),
        new OptionFieldAndView({ id: 'cotizacion', label: '', value: proceso.cotizacionElegida, data: cotizaciones, style: 'height: 45px', onClick: download_file, title: 'Descargar cotizaciones' }),
        new title({ text: fechas.length == 1 ? 'Fecha de firma' : 'Fechas de firma' }),
        fechas.length == 1 ? new inputText({ id: 'fecha', label: fechas[0].title, value: fechas[0].value}) : new OptionField({ id: 'fecha', label: '', value: proceso.fechaElegida, data: fechas, style: 'height: 45px' }),
    ]

    form.show()
}

pass_to_validacion_contraloria = function(data) {

    let form = new Form({
        title: 'Continuar proceso', 
        text: `¿Desea enviar el lote ${data.nombreLote} al siguiente proceso: <b>"Validación de contraloria"</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `to_validacion_contraloria`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha pasado al proceso de validación de contraloria.", "success");
        
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

function download_file(archivo) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${archivo}`
}

function show_upload(data) {
    //console.log(data)

    let form = new Form({
        title: `Subir depósito de anticipo`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

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
            new HiddenField({ id: 'id_proceso',      value: data.idProcesoCasas }),
            new HiddenField({ id: 'id_documento',    value: data.idDocumento }),
            new HiddenField({ id: 'name_documento',  value: data.documento }),
            new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['image/png','image/jpeg','application/pdf'] }),
        ],
    })

    form.show()
}

back_to_propuesta_firma = function(data) {

    let form = new Form({
        title: 'Regresar proceso', 
        text: `¿Desea regresar el proceso del lote ${data.nombreLote} a <b>"Propuestas para firma"</b>?`,
        onSubmit: function(data){
            //console.log(data)
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `back_to_propuesta_firma`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido regresado a propuestas para firma.`, "success");
        
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
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Elección de propuestas",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
    { data: 'notaria' },
    { data: function(data){
        let fecha = 'No escogida'

        switch(data.fechaElegida){
        case 1:
            fecha = data.fechaFirma1
            break
        case 2:
            fecha = data.fechaFirma2
            break
        case 3:
            fecha = data.fechaFirma3
            break
        }

        return fecha
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
    { data: function(data){
        let propuestas_button = new RowButton({icon: 'list', label: 'Propuestas para firma', onClick: show_propuestas, data})
        let upload_button = new RowButton({icon: 'file_upload', label: 'Subir deposito de anticipo', onClick: show_upload, data})

        let view_button = ''
        let pass_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: 'Visualizar carta de autorización', onClick: show_preview, data})
            if(data.fechaElegida && data.cotizacionElegida){
                pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Pasar a aceptación de propuestas', onClick: pass_to_validacion_contraloria, data})
            }
        }

        let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_propuesta_firma, data})

        return `<div class="d-flex justify-center">${propuestas_button}${view_button}${upload_button}${pass_button}${back_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_eleccion_propuestas',
    buttons:buttons,
    columns,
})