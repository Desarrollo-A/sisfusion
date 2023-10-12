$(document).ready(function () {
    fillTable();
});

let titulos = [];
$('#reporteLotesEstatus6 thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#reporteLotesEstatus6').DataTable().column(i).search() !== this.value ) {
            $('#reporteLotesEstatus6').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTable() {
    $('#reporteLotesEstatus6').DataTable({
        destroy: true,
        ajax: {
            url: 'getLotesEstatusSeisSinTraspaso',
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {}
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        ordering: false,
        pagingType: "full_numbers",
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Reporte de lotes estatus 6 para traspaso del recurso',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns:
            [
                {
                    data: function (d) {
                        return `<span class="label lbl-green">${d.tipo_venta}</span>`;
                    }
                },
                {
                    data: function (d) {
                        return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                    }
                },
                {data: 'nombreResidencial'},
                {data: 'nombreCondominio'},
                {data: 'nombreLote'},
                {data: 'idLote'},
                {data: 'referencia'},
                {data: 'sup'},
                {data: 'nombreCliente'},
                {data: 'totalATraspasar'}
            ]
    });
}
