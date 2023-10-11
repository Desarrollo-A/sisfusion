let titulosLotesBloqueados = [];
$('#tablaLotesBloqueados thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosLotesBloqueados.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaLotesBloqueados').DataTable().column(i).search() !== this.value)
            $('#tablaLotesBloqueados').DataTable().column(i).search(this.value).draw();
    });
});

$("#tablaLotesBloqueados").ready(function () {
    tabla_5 = $("#tablaLotesBloqueados").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reporte de lotes bloqueados',
                title: "Reporte de lotes bloqueados",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosLotesBloqueados[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'idLote'},
            {data: 'sup'},
            {data: 'precioM2'},
            {data: 'total'},
            {data: 'referencia'},
            {data: 'motivo_change_status'},
            {data: 'fechaBloqueo'},
            {data: 'bloqueadoPara'}
        ],
        ajax: {
            url: "getReporteLotesBloqueados",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {}
        },
        order: [[1, 'asc']]
    });
});
