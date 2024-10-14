$(document).ready(function () {
    construirHead("clients_report_datatable");

    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth('#beginDate','#endDate');
});

sp = { // MJ: SELECT PICKER
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

$('#clients_report_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


function fillDataTable(typeTransaction, beginDate, endDate, where){
    $('#clients_report_datatable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Listado general de clientes marketing digital',
            exportOptions: {
                columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosEvidence[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{ 
            data: function (d) {
                return d.nombreResidencial.toUpperCase();
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
                return d.idLote;
            }
        },
        { 
            data: function (d) {
                return d.nombreCliente;
            }
        },
        { 
            data: function (d) {
                return d.telefono;
            }
        },
        { 
            data: function (d) {
                return d.medioProspeccion;
            }
        },
        { 
            data: function (d) {
                return d.plaza;
            }
        },
        { 
            data: function (d) {
                return d.nombreAsesor;
            }
        },
        { 
            data: function (d) {
                return d.nombreGerente;
            }
        },
        { 
            data: function (d) {
                return formatMoney(d.totalNeto2);
            }
        },
        { 
            data: function (d) {
                return formatMoney(d.enganche);
            }
        },
        { 
            data: function (d) {
                return d.planEnganche;
            }
        },
        { 
            data: function (d) {
                if (d.idStatusLote == 2) { // MJ: CONTRATADO
                    return "<small class='label lbl-green'>CONTRATADO</small>";
                } else if (d.idStatusLote == 3) { // MJ: APARTADO+
                    return "<small class='label lbl-yellow'>APARTADO</small>";
                }
            }
        },
        {
            data: function (d) {
                return d.fechaApartado;
            }
        },
        { 
            data: function (d) {
                return d.fechaEstatusQuince;
            }
        }],
        ajax: {
            url: 'getClientsReportMktd',
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    });
}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(3, finalBeginDate, finalEndDate, 0);
    $('#clients_report_datatable').removeClass('hide');
});


