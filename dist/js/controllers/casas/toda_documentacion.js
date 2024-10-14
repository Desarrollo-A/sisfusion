var valueTab;
var valueTabline;
var table;

document.addEventListener('DOMContentLoaded', function () {
    dataFunction(1);
});
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

let columnsBanco = [
    { data: 'idProcesoCasas'},
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: 'nombreLote' },
    { data: 'idLote' },
    { data: 'gerente' },
    { data: 'asesor' },
    { data: 'documento' },
    {data: function(data) {
        let view_button = '';
        let download_button = '';
        console.log("data: ", data.archivo);

        //if(data.descargar){
            download_button = new RowButton({icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data})
        //}else{
        if(data.visualizarZIP != 1){
            view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
        }
        return `<div class="d-flex justify-center">${view_button}${download_button}</div>`
    }}
]

let columnsDirecto = [
    { data: 'idProceso'},
    { data: 'proyecto'},
    { data: 'condominio'},
    { data: 'nombreLote'},
    { data: 'idLote'},
    { data: 'gerente'},
    { data: 'asesor'},
    { data: 'documento'},
    { data: function (data) {
        let view_button = '';
        let download_button = '';
        download_button = new RowButton({icon: 'file_download', label:`Descargar ${data.documento}`, onClick: download_file, data});
        view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data});
        return `<div class="d-flex justify-center">${view_button}${download_button}</div>`;
    }}
];

let columnsPagos = [
    { data: 'idProcesoCasas'},
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: 'nombreLote' },
    { data: 'idLote' },
    { data: 'gerente' },
    { data: 'asesor' },
    { data: 'documento' },
    {data: function(data) {
        let view_button = '';
        let download_button = '';
        download_button = new RowButton({icon: 'file_download', label: `Descargar ${data.documento}`, onClick: download_file, data})
        view_button = new RowButton({icon: 'visibility', label: `Visualizar documento`, onClick: show_preview, data})
        return `<div class="d-flex justify-center">${view_button}${download_button}</div>`
    }}
]

function cleanTable(tableId) {
    if ($.fn.DataTable.isDataTable(tableId)) {
        let table = $(tableId).DataTable();
        table.clear().draw();
        table.rows().remove().draw();
    }
}

function dataFunction(value) {
    valueTab = value;
    //cleanTable('#tableBanco');
    //cleanTable('#tableDirecto');
    //cleanTable('#tablePagos');

    let tableConfig;

    if (valueTab == 1) {
        tableConfig = {
            id: '#tableBanco',
            url: 'casas/lista_toda_documentacion_casas_banco',
            buttons: buttons,
            columns: columnsBanco
        };
    } else if (valueTab == 2) {
        tableConfig = {
            id: '#tableDirecto',
            url: 'casas/lista_toda_documentacion_casas_directo',
            buttons: buttons,
            columns: columnsDirecto
        };
    } else if (valueTab == 3) {
        tableConfig = {
            id: '#tablePagos',
            url: 'casas/lista_toda_documentacion_casas_pagos',
            buttons: buttons,
            columns: columnsPagos
        };
    }

    if (tableConfig) {
        table = new Table(tableConfig);
    }
}

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

    let url = `${general_base_url}casas/archivo/${data.archivo}`;
    const a = document.createElement('a');
    a.href = url;
    a.download = data.archivo;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

$.ajax({
    type: 'GET',
    url: 'residenciales',
    success: function (response) {
        filtro_proyectos_banco.setOptions(response);
        filtro_proyectos_directo.setOptions(response);
        filtro_proyectos_pagos.setOptions(response);
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

//BANCO
let filtro_proyectos_banco = new SelectFilter({ id: 'proyecto-banco', label: 'Proyecto', placeholder: 'Selecciona una opción' });
let filtro_condominios_banco = new SelectFilter({ id: 'condominio-banco', label: 'Condominio', placeholder: 'Selecciona una opción' });
let filtro_lotes_banco = new SelectFilter({ id: 'lote-banco', label: 'Lotes', placeholder: 'Selecciona una opción' });

let filtros_banco = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proyectos_banco,
        filtro_condominios_banco,
        filtro_lotes_banco,
    ],
});

filtro_proyectos_banco.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            filtro_condominios_banco.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_condominios_banco.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `lotes_option?condominio=${option.value}`,
        success: function (response) {
            filtro_lotes_banco.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_lotes_banco.onChange(function(option){
    table.setParams({lote: option.value})
    table.reload()
})







let filtro_proyectos_directo = new SelectFilter({ id: 'proyecto-directo', label: 'Proyecto', placeholder: 'Selecciona una opción' });
let filtro_condominios_directo = new SelectFilter({ id: 'condominio-directo', label: 'Condominio', placeholder: 'Selecciona una opción' });
let filtro_lotes_directo = new SelectFilter({ id: 'lote-directo', label: 'Lotes', placeholder: 'Selecciona una opción' });

let filtros_directo = new Filters({
    id: 'table-filters-directo',
    filters: [
        filtro_proyectos_directo,
        filtro_condominios_directo,
        filtro_lotes_directo,
    ],
});

let filtro_proyectos_pagos = new SelectFilter({ id: 'proyecto-pagos', label: 'Proyecto', placeholder: 'Selecciona una opción' });
let filtro_condominios_pagos = new SelectFilter({ id: 'condominio-pagos', label: 'Condominio', placeholder: 'Selecciona una opción' });
let filtro_lotes_pagos = new SelectFilter({ id: 'lote-pagos', label: 'Lotes', placeholder: 'Selecciona una opción' });

let filtros_pagos = new Filters({
    id: 'table-filters-pagos',
    filters: [
        filtro_proyectos_pagos,
        filtro_condominios_pagos,
        filtro_lotes_pagos,
    ],
});





filtro_proyectos_directo.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            filtro_condominios_directo.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_condominios_directo.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `lotes_option_directo?condominio=${option.value}`,
        success: function (response) {
            filtro_lotes_directo.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_lotes_directo.onChange(function(option){
    table.setParams({lote: option.value})
    table.reload()
})


filtro_proyectos_pagos.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            filtro_condominios_pagos.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_condominios_pagos.onChange(function(option){
    $.ajax({
        type: 'GET',
        url: `lotes_option?condominio=${option.value}`,
        success: function (response) {
            filtro_lotes_pagos.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_lotes_pagos.onChange(function(option){
    table.setParams({lote: option.value})
    table.reload()
})
