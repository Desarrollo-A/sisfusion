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
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
});

filtro_condominios.onChange(function(option) {    
    table.setParams({condominio: option.value})
    table.reload();
});

let optionsEscrituracion = [
    {label: 'NO', value: 2},
    {label: 'SÍ', value: 1}
];

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
                return `<span class="label lbl-orange">SIN MARCA DE ESCTRITURACIÓN</span>`;
            }
            if(data.escrituraFinalizada == '1') {
                return `<span class="label lbl-green">ESCRITURADO</span>`;
            }
            if(data.escrituraFinalizada == '2') {
                return `<span class="label lbl-warning">NO ESCRITURADO</span>`;
            }
        }
    },
    { data: function(data) 
        {
            let vobo_button = '';
            let asignar_button = '';
            if(data.escrituraFinalizada == 0){
                asignar_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Agregar Marca', onClick: btn_assign, data});
            }
            
            
            if(data.revisionEscrituracion == 0 || data.revisionEscrituracion == null) {
                vobo_button = new RowButton({icon: 'check', color: 'green', label: 'Visto bueno', onClick: btn_vistoBueno, data});
            }
            return `<div class="d-flex justify-center">${asignar_button}${vobo_button}</div>`;
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
        title:"Lotes sin marca de escritura",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6],
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
        title : 'Marca de escrituración',
        text: `¿Deseas agregar la marca de escrituración para el lote <b>${data.nombreLote}</b>?`,
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
            new SelectField({ id: 'marcaEscrituracion', label: 'Marca de escrituración', placeholder: 'Selecciona una opción', width: '12', data: optionsEscrituracion, required: true}),
            new HiddenField({ id: 'idCliente', value: data.idCliente}),
            new HiddenField({ id: 'accion', value: 1})
        ]
    });
    form.show();
}

btn_vistoBueno = function (data) {
    let form = new Form({
        title: 'Dar el visto bueno',
        text: `¿Deseas dar el visto bueno para el lote: <b>${data.nombreLote}</b>?`,
        onSubmit: function(dataForm) {
            form.loading(false);
            $.ajax({
                type: 'POST',
                url: `${general_base_url}/postventa/asignarMarca`,
                data: dataForm,
                contentType: false,
                processData: false,
                success: function(response) {
                    alerts.showNotification("top", "right", "Se ha dado el visto bueno.", "success");
                    table.reload(null, false);
                    form.hide();
                }, 
                error: function (resp) {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    form.hide();
                }
            });
        }, 
        fields: [
            new HiddenField({ id: 'idCliente', value: data.idCliente}),
            new HiddenField({ id: 'accion', value: 2}),
            new HiddenField({ id: 'idProceso', value: data.idProcesoCasas})
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

