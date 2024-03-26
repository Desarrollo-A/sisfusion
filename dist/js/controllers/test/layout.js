let id_table = "#tableDoct"

let url = "test/lotes"

let buttons = ['excel']

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
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
}

let form = new Form({
    title: 'Formulario',
    text: 'Descripcion del formulario',
})



function clickedForm(data){
    form.fields = [
        { id: 'name', label: 'Nombre', type: 'text', placeholder: 'Nombre del plan' },
        { id: 'lote', label: 'Lote', type: 'text', placeholder: 'Nombre del lote' },
    ]

    form.onSubmit = sendData
    
    form.show()
}

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

let table = new Table({
    id: id_table,
    url,
    buttons,
    columns,
    actions
})