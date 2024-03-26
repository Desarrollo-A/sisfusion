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

function clickedAsk(data) {
    let alert = new AskDialog({title: 'Alerta', text: 'Este es un mensaje de alerta'})

    alert.show()
}

let view_button = new TableButton({icon: 'add', onClick: clickedButton})
let alert_button = new TableButton({color: 'yellow', icon: 'train', onClick: clickedAlert})
let ask_button = new TableButton({color: 'warning', icon: 'home', onClick: clickedAsk})

let actions = [
    view_button,
    alert_button,
    ask_button,
]

let table = new Table({
    id: id_table,
    url,
    buttons,
    columns,
    actions
})