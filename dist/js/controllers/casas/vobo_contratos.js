function show_preview(data) {
    let url = `${general_base_url}casas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}


backPage = function() {
    window.location.href = `${general_base_url}casas/recepcion_contratos`
}

let buttons = [
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

let columns = [
    { data: 'idDocumento' },
    { data: 'documento' },
    { data: function(data){
        if(data.archivo){
            return data.archivo
        }
        return 'sin archivo'
    } },
    { data: function(data){
        if(data.fechaModificacion){
            return data.fechaModificacion.substring(0, 16)
        }
        return 'no subido'
    } },
    { data: function(data){
        let view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
        if(!data.archivo){
            view_button = new RowButton({icon: 'visibility_off', color: 'yellow',  label: `Archivo no subido`})
        }

        return `<div class="d-flex justify-center">${view_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_contratos/${idProcesoCasas}`,
    buttons:buttons,
    columns,
})