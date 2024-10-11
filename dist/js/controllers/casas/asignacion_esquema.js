let tipoEsquema = [];
let modeloCasa = [];
let requerido = true

$.ajax({
    type: 'GET',
    url: 'options_esquema',
    async: false,
    success: function (response) {
        tipoEsquema = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

$.ajax({
    type: 'GET',
    url: 'options_modelo',
    async: false,
    success: function (response) {
        modeloCasa = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

avanzar_proceso = function(data) {
    let required = true

    let form = new Form({
        title: 'Continuar proceso', 
        text: `Para continuar el proceso del lote <b>${data.nombreLote}</b> se debe asignar un esquema de crédito y seleccionar un modelo de casa`,
        onSubmit: function(data){
            form.loading(true)
            let form2 = new FormConfirm({
                title: '¿Estás seguro de continuar el proceso?',
                onSubmit: function() {
                    form2.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}casas/to_asignacion_esquema`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
                            table.reload();
                            form2.hide();
                            form.hide();
                            form2.loading(false)
                            arrayValores = []
                            arrayIdLotes = []
                        },
                        error: function () {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            form.loading(false);
                            form2.loading(false);
                            form2.hide();
                            arrayValores = []
                            arrayIdLotes = []
                        }
                    })
                }
            });
            form2.show();
            form.loading(false);
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.id_cliente }),
            new HiddenField({ id: 'idGerente', value: data.id_gerente_c}),
            new HiddenField({id: 'idSubdirector', value: data.id_subdirector_c}),
            new SelectField({ id: 'esquemaCredito', label: 'Esquema de crédito', placeholder: 'Selecciona una opción', width: '12', data: tipoEsquema, required: true, value: data.esquemaCreditoCasas}),
            new MultiSelectField({ id: 'modeloCasa', label: 'Propuestas de casas', data: modeloCasa, placeholder: 'Seleccciona una opción', width: '12', required: true, value: data.idPropuestaCasa}),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' })
        ],
    })

    form.show();
    multipleSelect('modeloCasa');
}

rechazo_avance_proceso = function(data) {

    let form = new Form({
        title: 'Continuar proceso',
        text: `Para continuar el proceso del lote <b>${data.nombreLote}</b> se debe asignar  un esquema de crédito y seleccionar un modelo de casa`,
        onSubmit: function (data) {
            form.loading(true);
            let form2 = new FormConfirm({
                title: '¿Estás seguro de continuar el proceso?',
                onSubmit: function(){
                    form2.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}casas/actualizarPreProceso`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function (resp){
                            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success"),
                            table.reload();
                            form2.hide();
                            form.hide();
                            form2.loading(false);
                        },
                        error: function() {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            form.loading(false);
                            form2.loading(false);
                            form2.hide();
                        }
                    })
                }
            });
            form2.show();
            form.loading(false);
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote}),
            new HiddenField({ id: 'idCliente', value: data.id_cliente}),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas}),
            new HiddenField({ id: 'idProcesoDirecto', value: data.idProcesoDirecto}),
            new HiddenField({ id: 'esquemaCreditoActual', value: data.esquemaCreditoCasas}),
            new SelectField({ id: 'esquemaCreditoNuevo', label: 'Esquema de crédito', placeholder: 'Selecciona una opción', width: '12', data: tipoEsquema,required: true}),
            new MultiSelectField({id: 'modeloCasa', label: 'Propuestas de casas', data: modeloCasa, placeholder: 'Selecciona una opción', width: 12, required: true}),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12'})
        ]
    })
    form.show();
    multipleSelect('modeloCasa');
}



cancel_process = function (data) {

    let form = new Form({
        title: 'Cancelar proceso',
        text: `¿Desea cancelar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `cancel_process`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido cancelado.`, "success");

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
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
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
        title:"Asignación de cartera",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    },
    {
        text: '<i class="fas fa-user-plus"></i>',
        className: 'btn-large btn-sky btn-asignar botonEnviar hide',
        titleAttr: 'Asignar lotes',
        title:"Asignar lotes",
    }
]

let columns = [
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: 'nombreLote' },
    { data: 'idLote' },
    { data: 'precioTotalLote' },
    { data: 'sup' },
    { data: 'cliente' },
    { data: function(data)
        {
            if (data.telefono1 == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono1}` 
        } 
    },
    { data: function(data)
        {
            if (data.telefono2 == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono2}` 
        } 
    },
    { data: function(data)
        {
            if (data.telefono3 == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono3}` 
        } 
    },
    { data: 'correo' },
    { data: 'lugar_prospeccion' },
    { data: function (data) {
        let clase = '';

        switch(data.tipoMovimiento){
            case 4 :
                clase = "warning";
                break;
            default :
                clase = "blueMaderas";
                break;
        }

        return `<span class="label lbl-${clase}">${data.nombreMovimiento}</span>`;
    }},
    
    {
        data: function (data) {
            let asesor_button = '';
            let rechazo_avance_button = '';
            if(data.idProcesoCasas == null || data.idProcesoCasas == ''){
                asesor_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: avanzar_proceso, data })            
            }else{
                asesor_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: rechazo_avance_proceso, data })            
            }
            return `<div class="d-flex justify-center">${asesor_button}</div>`
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_asignacion_esquema',
    buttons: buttons,
    columns,
    buttons,
})

function multipleSelect(idSelect) {
    let selectElement = $(`#${idSelect}`);
    
    selectElement.on('change', function() {
        let selectedOptions = $(this).val();

        if(selectedOptions.length > 2) {
            $(this).val(selectedOptions.slice(0,2)).trigger('change');
            return;
        }

        $(this).find('option').each(function() {
            if (!$(this).prop('selected')) {
                $(this).prop('disabled', selectedOptions.length >= 2);
            }
        });

        $(this).find('option').each(function() {
            if ($(this).prop('selected')) {
                $(this).prop('disabled', false);
            }
        });

        selectElement.selectpicker('refresh');

        if(selectedOptions.length === 2) {
            selectElement.selectpicker('toggle');
        }
    })
}