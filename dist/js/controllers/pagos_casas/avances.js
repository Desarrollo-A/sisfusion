function show_preview(data) {
    let url = `${general_base_url}pagoscasas/archivo/${data.complementoPDF}`

    Shadowbox.init();

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: Complemento de pago`,
        width: 985,
        height: 660
    });
}

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.complementoXML}`
}

const formatter = new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
});

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        if(data.avance){
            return `${data.avance} %`
        }
        
        return 'Inicio de obra'
    } },
    { data: function(data) {
        if(data.monto){
            return formatter.format(data.monto)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        if(data.pagado){
            return 'Si'
        }else{
            return 'No'
        }
    } },
    { data: function(data){
        return data.fechaCreacion ? data.fechaCreacion.substring(0, 16) : ''
    } },
    { data: function(data){
        return data.fechaModificacion ? data.fechaModificacion.substring(0, 16) : ''
    } },
    { data: function(data){
        let view_button = new RowButton({icon: 'visibility', label: `Visualizar complemento de pago PDF`, onClick: show_preview, data})

        let download_button = new RowButton({icon: 'file_download', label: `Descargar complemento de pago XML`, onClick: download_file, data})
        
        return `<div class="d-flex justify-center">${view_button}${download_button}</div>`
    } },
]

let buttons = [
    {
        text: '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
        action: function() {
            window.location.href = `${general_base_url}pagoscasas/reporte_pagos`
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
    url: `pagoscasas/lista_avances/${idProcesoPagos}`,
    columns,
    buttons,
})