$(document).ready(function () {
    $("#plan-modal").modal();

    let titulos_intxt = [];

    $('#tabla_planes_comisiones thead tr:eq(0) th').each(function (i) {
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

    dispersionDataTable = $('#tabla_planes_comisiones').dataTable({
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
            {data: 'id_plan'},
            {data: 'nombre'},
            { 
                data: function (d) {
                    return '<span class="label lbl-azure">'+d.fecha_modificacion+'</span>';
                }
            },
            {data: 'prioridad'},
            {data: 'estado'},      
            { 
                data: function (d) {
                    return ''
                }
            }],
            columnDefs: [{
                visible: false,
                searchable: false
            }
        ],
        ajax: {
            url: 'list_planes',
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
})

function addUsuarioPlanComision(){

    let html = '<div class="col-md-12"><div class="col-md-4"><div class="form-group"><input class="form-control input-gral" type="text" placeholder="Numero de usuario"><span class="material-input"></span></div></div><div class="col-md-4"><div class="form-group"><input class="form-control input-gral" type="number" value="Asesor"><span class="material-input"></span></div></div></div>'

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
                    .val('asdf')
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
            )
        )
    )

    // $('#usuarios_plan_comisiones').append(html)
}