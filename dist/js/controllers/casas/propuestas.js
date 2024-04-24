let notarias = []

$.ajax({
    type: 'GET',
    url: `${general_base_url}casas/options_notarias`,
    async: false,
    success: function (response) {
        notarias = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

function show_form(propuesta) {
    let form = new Form({
        title: 'Propuesta de firma',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)

        $.ajax({
            type: 'POST',
            url: `${general_base_url}casas/save_propuesta`,
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log(response)
                alerts.showNotification("top", "right", "Propuesta ingresada correctamente.", "success");
                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'idPropuesta', value: propuesta.idPropuesta }),
        new HiddenField({ id: 'idProcesoCasas', value: idProcesoCasas }),
        new SelectField({ id: 'notaria', label: 'Notaria',  placeholder: 'Selecciona una opcion', data: notarias, value: propuesta.notaria, width:'6' }),
        new DateField({ id: 'fecha', label: 'Fecha de firma',  placeholder: 'Elige una fecha', value: propuesta.fechaFirma, width:'6' }),
        new NumberField({ id: 'costo', label: 'Costo',  placeholder: 'Ingresa el dato', value: propuesta.costo })
    ]

    form.show()
}

function edit_propuesta(data) {
    show_form(data)
}

function new_propuesta() {
    show_form({})
}

backPage = function() {
    window.location.href = `${general_base_url}casas/carga_titulos`
}

let columns = [
    { data: 'idPropuesta' },
    { data: 'notaria' },
    { data: 'fechaFirma' },
    { data: 'costo' },
    { data: function(data){
        let edit_button = new RowButton({icon: 'edit', label: 'Editar prpopuesta', onClick: edit_propuesta, data})

        return `<div class="d-flex justify-center">${edit_button}</div>`
    } },
]

let buttons = [
    {
        text: '<i class="mr-1 fa fa-check"></i>Agregar propuesta',
        action: function() {
            new_propuesta()
        },
        attr: {
            class: 'btn btn-azure',
            style: 'position: relative; float: right',
        }
    },
    {
        text: '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
        action: function() {
            backPage()
        },
        attr: {
            class: 'btn-back',
            style: 'position: relative; float: left',
            title: 'Regresar'
        }
    },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_propuestas/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})