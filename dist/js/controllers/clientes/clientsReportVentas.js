$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(1, finalBeginDate, finalEndDate, 0);
});

sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
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
    }
}

let titulos = [];
$('#clients_report_datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $( 'input', this ).on('keyup change', function () {
        if ($('#clients_report_datatable').DataTable().column(i).search() !== this.value ) {
            $('#clients_report_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});


function fillTable(typeTransaction, beginDate, endDate, where) {
    $('#clients_report_datatable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        scrollX: true,
        width:'100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado general de clientes',
                title:'Listado general de clientes',
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' '+titulos[columnIdx] +' ';
                        }
                    }
                },
            }
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: function (d) {
                    return d.nombreResidencial.toUpperCase();
                }
            },
            { data: function (d) {
                    return d.nombreCondominio;
                }
            },
            { data: function (d) {
                    return d.nombreLote;
                }
            },
            { data: function (d) {
                    return d.idLote;
                }
            },
            { data: function (d) {
                    return d.nombreCliente;
                }
            },
            { data: function (d) {
                    return d.lp;
                }
            },
            { data: function (d) {
                    return d.plaza;
                }
            },
            { data: function (d) {
                    return d.nombreAsesor;
                }
            },
            { data: function (d) {
                    return d.nombreCoordinador;
                }
            },
            { data: function (d) {
                    return d.nombreGerente;
                }
            },
            { data: function (d) {
                    return d.nombreSubdirector;
                }
            },
            { data: function (d) {
                    return d.directorRegional;
                }
            },
            { data: function (d) {
                    return d.directorRegional2;
                }
            },
            { data: function (d) {
                    return formatMoney(d.totalNeto2);
                }
            },
            { data: function (d) {
                    return formatMoney(d.enganche);
                }
            },
            { data: function (d) {
                    return d.planEnganche;
                }
            },
            { data: function (d) {
                    return d.fechaApartado;
                }
            },
            { data: function (d) {
                    return d.fechaEstatusQuince;
                }
            }
        ],
        ajax: {
            url: `${general_base_url}clientes/getClientsReportMktd`,
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    })
}


$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

