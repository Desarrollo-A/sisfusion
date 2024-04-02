let form = new Form({
    title: 'Asignar asesor',
    //text: 'Descripcion del formulario',
})

form.onSubmit = function(data){
    //console.log(data)

    $.ajax({
        type: 'POST',
        url: 'asignar',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response)

            table.reload()

            form.hide()
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
}

function choose_asesor(data) {
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

    form.fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new SelectField({ id: 'asesor', label: 'Asesor',  placeholder: 'Selecciona una opcion', data: items }),
    ]

    form.show()
}

function sendToNext(data){
    console.log(data)

    /*
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
    */
}

select_asesor = function(data) {
    let ask = new AskDialog({
        title: 'Continuar proceso', 
        text: `Desea asignar a ${data.nombreAsesor} al lote ${data.nombreLote}`,
        onOk: () => sendToNext(data),
        //onCancel: sayNo,
    })

    ask.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'nombreAsesor' },
    { data: function(data){
        let asesor_button = new TableButton({icon: 'assignment_ind', label: 'Asignar asesor', onClick: choose_asesor, data})

        let pass_button = ''
        if(data.idAsesor){
            pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Aceptar asignacion', onClick: select_asesor, data})
        }

        return `<div class="d-flex justify-center">${asesor_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_asignacion',
    buttons: ['excel'],
    columns,
})