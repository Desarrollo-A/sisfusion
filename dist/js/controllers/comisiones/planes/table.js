let comision = {
    idPlan: undefined,
    nombre: undefined,
    estatus: false,
    fechaInicio: new Date(),
    fechaFin: new Date(),
    sede: undefined,
}

let condiciones = [
    { id: 'proceso', label: 'Proceso', type: 'select', url: 'sedes/list' },
    { id: 'compartida', label: 'Venta compartida', type: 'compartida', url: 'sedes/list' },
    { id: 'gerente', label: 'Gerente', type: 'select', url: 'sedes/list' },
    { id: 'asesor', label: 'Asesor', type: 'select', url: 'sedes/list' },
    { id: 'tipo_venta', label: 'Tipo de venta', type: 'select', url: 'sedes/list' },
    { id: 'venta_regional', label: 'Venta regional', type: 'bool', url: 'sedes/list' },
]

//let dispersionDataTable;

$(document).ready(function () {
    getDataSelect('sede', `${general_base_url}planes/sedes`);
    getDataSelect('residencial', `${general_base_url}planes/residenciales`);
    getDataSelect('prospeccion', `${general_base_url}planes/prospecciones`);

    //$("#plan-modal").modal();

    let titulos_intxt = [];

    const tabla_planes_comisiones = $('#tabla_planes_comisiones thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 0) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_planes_comisiones').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_planes_comisiones').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_planes_comisiones').DataTable().rows({
                    selected: true, 
                    search: 'applied' 
                    }).indexes();
                var data = $('#tabla_planes_comisiones').DataTable().rows(index).data();
            });
        }
    });

    const dispersionDataTable = $('#tabla_planes_comisiones').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'Reporte planes de comision',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-check"></i> NUEVO PLAN',
                action: function() {
                    console.log('Nuevo plan click')
                    $("#plan-modal").modal();
                },
                attr: {
                    class: 'btn btn-azure',
                    style: 'position: relative; float: right',
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data : null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {data: 'idPlan'},
            {data: 'nombre'},
            { 
                data: function (d) {
                    const date = new Date(d.fechaActualizado)
                    const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };

                    return `<span class="label lbl-azure">${date.toLocaleDateString('es-MX', options)}</span>`
                }
            },
            {data: 'prioridad'},
            { //STATUS
                data: function (d) {
                    if(d.estatus == 1){
                        return '<span class="label label-success">Activo</span>'
                    }else{
                        return '<span class="label label-default">Inactivo</span>'
                    }
                }
            },
            { //ACTIONS
                data: function (data) {
                    const subir_prioridad = tableButton('subir_prioridad', 'subir prioridad', 'arrow_upward', 'btn-deepGray')
                    const bajar_prioridad = tableButton('bajar_prioridad', 'bajar prioridad', 'arrow_downward', 'btn-deepGray')
                    const editar_plan = tableButton('edit_plan', 'editar plan', 'edit')
                    
                    let toggle_plan = tableButton('enable_plan', 'activar plan', 'play_arrow', 'btn-green', 'enablePlan', data.idPlan)
                    if(data.estatus == 1){
                        toggle_plan = tableButton('disable_plan', 'desactivar plan', 'pause', 'btn-yellow', 'disablePlan', data.idPlan)
                    }

                    return `<div class="d-flex justify-center">${subir_prioridad}${bajar_prioridad}${editar_plan}${toggle_plan}</div>`
                }
            }
        ],
        columnDefs: [
            {
                visible: false,
                searchable: false
            }
        ],
        ajax: {
            url: `${general_base_url}planes/list`,
            type: "GET",
            cache: false,
            data: function( d ){}
        }
    })

    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove',
            inline: true
        }
    });

    $('#btn_add_usuario_comision').on('click', function() {
        let id_usuario = $('#id_usuario').val();

        getUserComisionando(id_usuario);
    });

})

function enablePlan(idPlan){
    $.getJSON( `${general_base_url}planes/enable?plan=${idPlan}` )
    .done(function( data ) {
        //dispersionDataTable.ajax()
    })
}

function disablePlan(idPlan){
    $.getJSON( `${general_base_url}planes/disable?plan=${idPlan}` )
    .done(function( data ) {
        //dispersionDataTable.ajax()
    })
}

function tableButton(id, label='', icon='', color='btn-blueMaderas', method=null, data=[]){
    const button = $('<button />')
        .addClass(`${id} btn-data ${color}`)
        .attr('data-toggle', 'tooltip')
        .attr('data-placement', 'top')
        .attr('title', label.toUpperCase())
        .append(
            $('<i />')
            .addClass('material-icons')
            .text(icon)
        )

    if(method){
        button.attr('onClick', `${method}(${data})`)
    }

    return button.prop('outerHTML')
}

function getUserComisionando(id_usuario){
    $.getJSON( `${general_base_url}planes/usuario?id_usuario=${id_usuario}` )
    .done(function( data ) {
        let id = data.id_usuario
        let nombre = `${data.nombre} ${data.apellido_paterno} ${data.apellido_materno}`

        addUsuarioPlanComision(id, nombre)
    })
}

function getDataSelect(element, url){
    $.getJSON( url )
    .done(function( data ) {
        $.each( data, function( i, item ) {
            $(`#${element}`).append($('<option>').val(item.id).text(item.label.toUpperCase()));
            $(`#${element}`).selectpicker('refresh');
        })
    })
}

function addUsuarioPlanComision(id, nombre){
    $('#usuarios_plan_comisiones').append(
        $('<div />')
        .addClass('col-md-12')
        .append(
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<div />')
                .addClass('form-group')
                .append(
                    $('<input />')
                    .attr('type', 'text')
                    .addClass('form-control input-gral')
                    .val(nombre)
                )
            ),
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<div />')
                .addClass('form-group')
                .append(
                    $('<input />')
                    .attr('type', 'text')
                    .addClass('form-control input-gral')
                    .val(1)
                )
            ),
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<button />')
                .addClass('btn btn-primary')
                .text('Eliminar')
            )
        )
    )
}