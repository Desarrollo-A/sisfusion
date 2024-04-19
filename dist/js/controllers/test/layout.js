let id_table = "#tableDoct"

let url = "test/lotes"

let buttons = ['excel']

let items = [
    {value : 0, label: 'Opcion 1'},
    {value : 1, label: 'Occion 2'},
]

let view_button = new TableButton({icon: 'add', onClick: clickedButton})
let alert_button = new TableButton({color: 'yellow', icon: 'train', onClick: clickedAlert})
let ask_button = new TableButton({color: 'warning', icon: 'home', onClick: clickedAsk})
let form_button = new TableButton({color: 'violetChin', icon: 'list', onClick: clickedForm})

let actions = [
    view_button,
    alert_button,
    ask_button,
    form_button,
]

let columns = [
    { data: 'idLote' },
    { data: function(data){
        return `Lote: ${data.nombreLote}`
    } },
    { data: function(data){
        let row = ''

        for (var i = 0; i < actions.length; i++) {
            actions[i].data = data

            row += actions[i]
        }

        return '<div class="d-flex justify-center">' + row + '</div>'
    } },
]

function clickedButton(data) {
    console.log(data)
}

function clickedAlert(data) {
    let alert = new AlertDialog({title: 'Alerta', text: 'Este es un mensaje de alerta'})

    alert.show()
}

function sayYes(data){
    console.log('Dijo si')

    console.log(data)
}

function sayNo(){
    console.log('Dijo no')
}

function clickedAsk(data){
    let alert = new AskDialog({
        title: 'Pregunta', 
        text: 'Esta es una pregunta',
        onOk: () => sayYes(data),
        onCancel: sayNo,
    })

    alert.show()
}

function sendData(data){
    console.log(data)

    $.ajax({
        type: 'POST',
        url: 'form',
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

let form = new Form({
    title: 'Formulario',
    text: 'Descripcion del formulario',
})



function clickedForm(data){
    form.fields = [
        new TextField({   id: 'name',   label: 'Nombre',  placeholder: 'Nombre del plan' }),
        new NumberField({ id: 'number', label: 'Numero',  placeholder: 'Campo de numero' }),
        new FileField({   id: 'file',   label: 'Archivo', placeholder: 'Selecciona un archivo' }),
        new SelectField({ id: 'select', label: 'Opcion',  placeholder: 'Selecciona una opcion', data: items }),
    ]

    form.onSubmit = sendData
    
    form.show()
}

let table = new Table({
    id: id_table,
    url,
    buttons,
    columns,
})

let mi_filtro1 = new SelectFilter({ id: 'select', label: 'Opcion 1',  placeholder: 'Selecciona una opcion', data: items })
let mi_filtro2 = new SelectFilter({ id: 'select', label: 'Opcion 2',  placeholder: 'Selecciona una opcion' })

mi_filtro1.onChange(function(){
    mi_filtro2.setOptions(items)
})

mi_filtro2.onChange(function(){
    table.reload()
})

let filters = new Filters({
    id: 'table-filters',
    filters: [
        mi_filtro1,
        mi_filtro2
    ],
})

filters.add(new SelectFilter({ id: 'select', label: 'Opcion 3',  placeholder: 'Selecciona otra opcion', data: items }))