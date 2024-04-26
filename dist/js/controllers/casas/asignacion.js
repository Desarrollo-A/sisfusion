let form = new Form({
    title: 'Asignar asesor',
    //text: 'Descripcion del formulario',
})

form.onSubmit = function (data) {
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: 'asignar',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            alerts.showNotification("top", "right", "Se asigno el asesor correctamente.", "success");

            table.reload()

            form.hide()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

let items = []

$.ajax({
    type: 'GET',
    url: 'options_asesores',
    async: false,
    success: function (response) {
        items = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

function choose_asesor(data) {
    form.fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new SelectField({ id: 'asesor', label: 'Asesor', placeholder: 'Selecciona una opcion', data: items }),
    ]

    form.show()
}

select_asesor = function (data) {

    let form = new Form({
        title: 'Continuar proceso', 
        text: `Desea asignar a ${data.nombreAsesor} al lote ${data.nombreLote}`,
        onSubmit: function (data) {

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_carta_auth`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido puesto para ingresar carta de autorizacion.", "success");

                    table.reload();

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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

cancel_process = function (data) {

    let form = new Form({
        title: 'Cancelar proceso',
        text: `Desea cancelar el proceso del lote ${data.nombreLote}`,
        onSubmit: function (data) {

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

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'nombreAsesor' },
    {
        data: function (data) {
            let asesor_button = new RowButton({ icon: 'assignment_ind', label: 'Asignar asesor', onClick: choose_asesor, data })

            let pass_button = ''
            if (data.idAsesor) {
                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Aceptar asignación', onClick: select_asesor, data })
            }

            let cancel_button = new RowButton({ icon: 'cancel', color: 'warning', label: 'Cancelar proceso', onClick: cancel_process, data })

            return `<div class="d-flex justify-center">${asesor_button}${pass_button}${cancel_button}</div>`
        }
    },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Inventario disponible reubicación',
        title:"Inventario disponible reubicación",
        exportOptions: {
            columns: [0, 1, 2],
            format: {
                header: function (d, columnIdx) {
                    //console.log($(d).attr('placeholder'))
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_asignacion',
    columns,
    buttons,
})