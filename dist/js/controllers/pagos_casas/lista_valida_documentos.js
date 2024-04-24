function show_preview(data) {
    let url = `${general_base_url}pagoscasas/archivo/${data.archivo}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${data.documento}`,
        width: 985,
        height: 660
    });
}

let columns = [
    { data: 'idDocumento' },
    { data: 'documento' },
    { data: 'archivo' },
    { data: 'fechaModificacion' },
    { data: function(data){
        let view_button = ''
        if(data.archivo){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar ${data.documento}`, onClick: show_preview, data})
        }

        return `<div class="d-flex justify-center">${view_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `pagoscasas/lista_subir_documentos/${idProcesoPagos}`,
    columns,
})