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

function download_file(data) {
    alerts.showNotification("top", "right", "Descargando archivo...", "info");
    window.location.href = `${general_base_url}casas/archivo/${data.archivo}`
}

let filtro_proyectos = new SelectFilter({ id: 'proyecto', label: 'Proyecto',  placeholder: 'Selecciona una opción' })
let filtro_condominios = new SelectFilter({ id: 'condominio', label: 'Condominio',  placeholder: 'Selecciona una opción' })
let filtro_lotes = new SelectFilter({ id: 'lote', label: 'Lotes',  placeholder: 'Selecciona una opción' })

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proyectos,
        filtro_condominios,
        filtro_lotes,
    ],
})

$.ajax({
    type: 'GET',
    url: 'residenciales',
    success: function (response) {
        filtro_proyectos.setOptions(response)
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

filtro_proyectos.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            filtro_condominios.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_condominios.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `lotes_option?condominio=${option.value}`,
        success: function (response) {
            filtro_lotes.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_lotes.onChange(function(option){
    table.setParams({lote: option.value})
    table.reload()
})

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Originación de cartera",
        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    },
    {
        text: '<i class="fas fa-user-plus"></i>',
        className: 'btn-large btn-sky btn-asignar botonEnviar hide',
        titleAttr: 'Asignar lotes',
        title:"Asignar lotes",
    }
]

let columns = [
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: 'nombreLote' },
    { data: 'idLote' },
    { data: 'gerente' },
    { data: 'asesor' },
    { data: 'documento' },
    {data: function(data) {
        let view_button = ''

        if(data.descargar){
            view_button = new RowButton({icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data})
        }else{
            view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
        }
        
        return `<div class="d-flex justify-center">${view_button}</div>`
    }}
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_toda_documentacion',
    buttons,
    columns,
})