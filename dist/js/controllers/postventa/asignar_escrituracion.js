let filtro_proyectos = new SelectFilter({id: 'proyecto', label: 'Proyecto', placeholder: 'Selecciona una opción'});
let filtro_condominios = new SelectFilter({id: 'condominio', label: 'Condominio', placeholder: 'Selecciona una opción'});

$.ajax({
    type: 'GET', 
    url: `residenciales`,
    success: function (response) {
        filtro_proyectos.setOptions(response)
    },
    error: function() {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

filtro_proyectos.onChange(function(option) {
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function(response) {
            filtro_condominios.setOptions(response)
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, alog salió mal.", "danger");
        }
    })
});

filtro_condominios.onChange(function(option) {    
    table.setParams({condominio: option.value})
    table.reload();
})

let columns = [
    {data: 'idLote'},
    {
        data: function(d) 
        {
            return d.sup + ' <b>m<sup>2</sup></b>';
        }
    },
    {data: 'nombreResidencial'},
    {data: 'nombreCondominio'},
    {data: 'nombreLote'},
    {data: 'nombreCliente'},
    {data: function(data) 
        {
            if (data.escrituraFinalizada == '0' || data.escrituraFinalizada == 0) {
                return `<span class="label lbl-green">SIN MARCA DE ESCTRITURA</span>`;
            }
        }
    },
    { data: function(data) 
        {
            let asignar_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Asignar', onClick: btn_assign, data})
            return `<div class="d-flex justify-center">${asignar_button}</div>`;
        }
    }
]

let filtros = new Filters({
    id : 'table-filters',
    filters: [
        filtro_proyectos, 
        filtro_condominios,
    ],
})

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Originación de cartera",
        exportOptions: {
            columns: [0, 1, 2, 3, 4],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

btn_assign = function (data) {
    let form = new Form({
        title : 'Agregar marca de titulación',
        text: `¿Deseas agregar la marca de titulación del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (dataForm) {
            form.loading(true);
            let formConfirm = new FormConfirm({
                title: '¿Estás seguro de agregar la marca de titulación?',
                onSubmit: function() {
                    formConfirm.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}/postventa/asignarMarca`,
                        data: dataForm,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alerts.showNotification("top", "right", "Se ha agregado correctamente la marca.", "success");
                            table.reload();
                            formConfirm.hide();
                            formConfirm.loading(false);
                            form.hide();
                        },
                        error: function (resp) {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            formConfirm.loading(false);
                            formConfirm.hide();
                        }
                    })
                }
            });
            formConfirm.show();
            form.loading(false);
        },
        fields: [
            new HiddenField({ id: 'idCliente', value: data.idCliente}),
            new HiddenField({ id: 'accion', value: 1})
        ]
    });
    form.show();
}

let table = new Table({
    id: '#tablaLotes',
    url: 'postventa/escrituraDisponible',
    buttons: buttons,
    columns,
})

