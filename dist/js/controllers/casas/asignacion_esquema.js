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

    modelo_select = new SelectField({ id: 'modeloCasa', label: 'Modelo de casa', placeholder: 'Selecciona una opción', width: '12', data: modeloCasa, required: required })

    hide_select = function(option){
        if(option.value == 1){
            modelo_select.hide()
        }
        else{
            modelo_select.show()
        }
    }

    let form = new Form({
        title: 'Continuar proceso', 
        text: `Para continuar el proceso del lote <b>${data.nombreLote}</b> se deben asignar un esquema de crédito`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_asignacion_esquema`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
        
                    table.reload();

                    form.hide();
                    arrayValores = []
                    arrayIdLotes = []
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    
                    form.loading(false)
                    arrayValores = []
                    arrayIdLotes = []
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.id_cliente }),
            new SelectField({ id: 'esquemaCredito', label: 'Esquema de crédito', placeholder: 'Selecciona una opción', width: '12', data: tipoEsquema, required: true, onChange: hide_select }),
            modelo_select,            
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: 'gerente' },
    {
        data: function (data) {
            let asesor_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: avanzar_proceso, data })            

            let cancel_button = new RowButton({ icon: 'cancel', color: 'warning', label: 'Cancelar proceso', onClick: cancel_process, data })

            return `<div class="d-flex justify-center">${asesor_button}${cancel_button}</div>`
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

