let titulos = [];
$('#ofTable thead tr:eq(0) th').each(function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this).on('keyup change', function () {
        if ($('#ofTable').DataTable().column(i).search() !== this.value) {
            $('#ofTable').DataTable().column(i).search(this.value).draw();
        }   
    });
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});


$(document).ready(function () {
    $('#ofTable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Reporte originario',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        columns: [
            { data: function (d) {
                    return d.nombreResidencial;
                }
            },
            { data: function (d) {
                    return d.condominio;
                }
            },
            { data: function (d) {
                    return d.nombreLote;
                }
            },
            { data: function (d) {
                    return d.nombreCliente;
                }
            },
            { data: function (d) {
                    return d.lugar_prospeccion;
                }
            },
            { data: function (d) {
                    return d.edadFirma;
                }
            },
            { data: function (d) {
                    return d.originario_de;
                }
            }
        ],
        ajax: {
            "url": "getOFReport",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });
});