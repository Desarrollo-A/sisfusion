$(document).ready(function () {
    $.ajax({
        post: "POST",           
        url: `${general_base_url}/registroLote/getDateToday/`,
    }).done(function (data) {
        $('#showDate').append('Reporte general de clientes al día de hoy: ' + data);
    }).fail(function () {});
});

let titulos = [];
$('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $( 'input', this ).on('keyup change', function () {
        if ($('#mktdProspectsTable').DataTable().column(i).search() !== this.value ) {
            $('#mktdProspectsTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

var mktdProspectsTable
$(document).ready(function () {
    mktdProspectsTable = $('#mktdProspectsTable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        width:'100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Reporte general de clientes',
            exportOptions: {
                format: {
                    header:  function (d, columnIdx) {
                        return ' '+titulos[columnIdx] +' ';
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            title:'Reporte general de clientes',
            className: 'btn buttons-pdf',
            titleAttr: 'Descargar archivo PDF',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                format: {
                    header:  function (d, columnIdx) {
                        return ' '+titulos[columnIdx] +' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
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
        }],
        columns: [{
            data: function (d) {
                return d.nombreResidencial;
            }
        },
        {
            data: function (d) {
                return d.nombreCondominio;
            }
        },
        {
            data: function (d) {
                return d.nombreLote;
            }
        },
        {
            data: function (d) {
                return d.nombreCliente;
            }
        },
        {
            data: function (d) {
                return d.sup + 'm2';
            }
        },
        {
            data: function (d) {
                return formatMoney(d.precio);
            }
        },
        {
            data: function (d) {
                if (d.totalNeto2 == 'null' || d.totalNeto2 == '' || d.totalNeto2 == '0.00' || d.totalNeto2 == null || d.totalNeto2 == '.00') {
                    return '$0.00';
                } else {
                    return formatMoney(d.totalNeto2);
                }
            }
        },
        {
            data: function (d) {
                return d.referencia;
            }
        },
        {
            data: function (d) {
                return d.asesor;
            }
        },
        {
            data: function (d) {
                return d.coordinador;
            }
        },
        {
            data: function (d) {
                return d.gerente;
            }
        },
        {
            data: function (d) {
                return d.subdirector;
            }
        },
        {
            data: function (d) {
                return d.dRegional;
            }
        },
        {
            data: function (d) {
                return d.dRegional2;
            }
        }
        ],
        ajax: {
            url: `${general_base_url}contraloria/getGeneralClientsReport`,
            type: "POST",
            cache: false,
        },
    });
});
