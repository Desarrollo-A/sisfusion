let filtro_proyectos = new SelectFilter({ id: 'proyecto', label: 'Proyecto',  placeholder: 'Selecciona una opcion' })
let filtro_condominios = new SelectFilter({ id: 'condominio', label: 'Condominio',  placeholder: 'Selecciona una opcion' })

$.ajax({
    type: 'GET',
    url: 'residenciales',
    success: function (response) {
        // console.log(response)

        filtro_proyectos.setOptions(response)
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

function cambio(option) {
    console.log(option)
}

filtro_proyectos.onChange(function(option){
    // console.log(option)

    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            // console.log(response)

            filtro_condominios.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
})

filtro_condominios.onChange(function(option){
    // console.log(option)

    table.setParams({condominio: option.value})
    table.reload()
})

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proyectos,
        filtro_condominios,
    ],
})

/* function sendToAsignacion(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_asignacion?lote=${data.idLote}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha sido enviado a asignacion.", "success");

            table.reload()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
} */
let gerentes = []

$.ajax({
    type: 'GET',
    url: 'options_gerentes',
    async: false,
    success: function (response) {
        gerentes = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

select_lote = function(data) {
    /* let ask = new AskDialog({
        title: 'Iniciar proceso', 
        text: `Iniciar proceso de asignación del lote ${data.nombreLote}`,
        onOk: () => sendToAsignacion(data),
        //onCancel: sayNo,
    })

    ask.show() */

    let form = new Form({
        title: 'Iniciar proceso', 
        text: `Iniciar proceso de asignación del lote ${data.nombreLote}`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_asignacion`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "El lote ha sido enviado a asignacion.", "success");
        
                    table.reload();

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new SelectField({   id: 'gerente', label: 'Gerente', placeholder: 'Selecciona una opcion', width: '12', data: gerentes }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
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
        title:"Originación de cartera",
        exportOptions: {
            columns: [0, 1],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let columns = [
    { data: 'idLote' },
    { data: function(data){
        return `${data.nombreLote}`
    } },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'gerente' },
    { data: function(data){
        let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Seleccionar para asignacion', onClick: select_lote, data})

        return '<div class="d-flex justify-center">' + pass_button + '</div>'
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lotes',
    buttons:buttons,
    columns,
})