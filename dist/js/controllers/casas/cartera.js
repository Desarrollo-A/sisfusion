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

    tabla.setParams({condominio: option.value})
    tabla.reload()
})

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proyectos,
        filtro_condominios,
    ],
})

function sendToAsignacion(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: `to_asignacion?lote=${data.idLote}`,
        success: function (response) {
            alerts.showNotification("top", "right", "El lote ha sido enviado a asignacion.", "success");
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

select_lote = function(data) {
    let ask = new AskDialog({
        title: 'Iniciar proceso', 
        text: `Iniciar proceso de asignacion del lote ${data.nombreLote}`,
        onOk: () => sendToAsignacion(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let columns = [
    { data: 'idLote' },
    { data: function(data){
        return `Lote: ${data.nombreLote}`
    } },
    { data: function(data){
        let pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Seleccionar para asignacion', onClick: select_lote, data})

        return '<div class="d-flex justify-center">' + pass_button + '</div>'
    } },
]

let tabla = new Table({
    id: '#tableDoct',
    url: 'casas/lotes',
    buttons: ['excel'],
    columns,
})