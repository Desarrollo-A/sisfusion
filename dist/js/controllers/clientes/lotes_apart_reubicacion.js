let titulosTabla = [];
let tablaReubicaciones;

const sp = {
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

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });

    setIniDatesXYear('#beginDate', '#endDate');

    fillTable(convertDateDDMMYYYYToYYYYMMDD($('#beginDate').val()), convertDateDDMMYYYYToYYYYMMDD($('#endDate').val()));
});

$('#lotesReubicacion thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);

    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#lotesReubicacion').DataTable().column(i).search() !== this.value) {
            $('#lotesReubicacion').DataTable().column(i).search(this.value).draw();
        }
    });

    $('[data-toggle="tooltip"]').tooltip();
});

function fillTable(fechaInicio, fechaFin) {
    tablaReubicaciones = $('#lotesReubicacion').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Lotes apartados reubicación',
                title:"Lotes apartados reubicación",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosTabla[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Lotes apartados reubicación',
                title:"Lotes apartados reubicación",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosTabla[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                visible: false
            }
        ],
        pageLength: 10,
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        order: [[4, "desc"]],
        destroy: true,
        columns: [
            { "data": "nombreResidencial" },
            { "data": "nombreCondominio" },
            { "data": "nombreLote" },
            { "data": "idLote" },
            { "data": "cliente" },
            { "data": "asesor" },
            { "data": "coordinador" },
            { "data": "gerente" },
            { "data": "subdirector" },
            { "data": "regional" },
            { "data": "regional2" },
            { "data": "fechaApartado" }
        ],
        ajax: {
            url: `${general_base_url}clientes/getLotesApartadosReubicacion`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "beginDate": fechaInicio,
                "endDate": fechaFin
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });
}

$(document).on('click', '#filtrarPorFecha', function () {
    const fechaInicio = convertDateDDMMYYYYToYYYYMMDD($('#beginDate').val());
    const fechaFin = convertDateDDMMYYYYToYYYYMMDD($('#endDate').val());
    fillTable(fechaInicio, fechaFin);
});