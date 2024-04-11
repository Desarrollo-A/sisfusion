let notarias = []

$.ajax({
    type: 'GET',
    url: `${general_base_url}/casas/options_notarias`,
    async: false,
    success: function (response) {
        notarias = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

function show_new() {
    let form = new Form({
        title: 'Asignar asesor',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)

        $.ajax({
            type: 'POST',
            url: 'add_propuesta',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log(response)

                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'id', value: idProcesoCasas }),
        new SelectField({ id: 'asesor', label: 'Notaria',  placeholder: 'Selecciona una opcion', data: notarias }),
    ]

    form.show()
}

let columns = [
    { data: 'idPropuesta' },
    { data: 'notaria' },
    { data: 'fechaFirma' },
    { data: 'costo' },
    { data: function(data){
        return `<div class="d-flex justify-center"></div>`
    } },
]

let buttons = [
    {
        text: '<i class="mr-1 fa fa-check"></i>Agregar propuesta',
        action: function() {
            show_new()
        },
        attr: {
            class: 'btn btn-azure',
            style: 'position: relative; float: right',
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_propuestas/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})