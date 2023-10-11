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
};

$(document).ready(function () {
    Shadowbox.init();
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });

    setIniDatesXYear('#beginDate', '#endDate');
    fillTable(convertDateDDMMYYYYToYYYYMMDD('01/04/2023'), convertDateDDMMYYYYToYYYYMMDD($('#endDate').val()));
    $('#spiner-loader').removeClass('hide');
});

$(document).on('click', '#searchByDateRange', function () {
    const fechaInicio = convertDateDDMMYYYYToYYYYMMDD($('#beginDate').val());
    const fechaFin = convertDateDDMMYYYYToYYYYMMDD($('#endDate').val());
    fillTable(fechaInicio, fechaFin);
    $('#spiner-loader').removeClass('hide');
});

let titulos = [];
$('#Jtabla thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value ) {
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

function fillTable(fechaInicio, fechaFin) {

    $("#Jtabla").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        "bDestroy": true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel tooltipButtons',
                titleAttr: 'Descargar archivo Excel',
                title: "Integración de expediente",
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx ]  + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf tooltipButtons',
                titleAttr: 'Descargar archivo PDF',
                title: "Integración de expediente",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx]  + ' ';
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
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        fixedColumns: true,
        ordering: false,
        columns: [{
            data: function (data){
                return data.proyecto
                }
            },
            {
                data: function (data){
                    return data.nombreLote
                }
            },
            {
                data: function (data){
                    return data.referencia
                }
            },
            {
                data: function (data){
                    return data.fechaApartado
                }
            },
            {
                data: function (data){
                    return data.nombreAsesor
                }
            },
            {
                data: function (data){
                    return data.nombreCliente
                }
            },
            {
                data: function (data){
                    return data.nombreSede
                }
            },
            {
                data: function (data){
                    return (data.modificado=='1900-01-01 00:00:00.000') ? '<span class="label lbl-melon">SIN ARCHIVO CONTRATO</span>' : '<span class="label lbl-azure">'+data.modificado+'</span>';
                }
            },
            {
                data: function (data){
                    return (data.expediente=='NA') ? '<span class="label lbl-melon">SIN ARCHIVO CONTRATO</span>' : '<span class="label lbl-azure cursor-point verDocumento" data-expediente="'+data.expediente+'">'+data.expediente+'</span>';
                }
            }],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: `${general_base_url}Reporte/getLotesContrato/`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "beginDate": fechaInicio,
                "endDate": fechaFin
            }
        },
        initComplete: function () {
            $('#spiner-loader').addClass('hide');

        },
        order: [[1, 'asc']]
    });


    $('#Jtabla').on('init.dt', function() {
        $('.tooltipButtons')
            .attr('data-toggle', 'tooltip')
            .attr('data-placement', 'top');

        $('[data-toggle="tooltip"]').tooltip();
    });
}

function setIniDatesXYear(inicioFecha, finFecha) {
    const year = new Date().getFullYear();
    const fechaInicio = new Date(year, 0,1);
    const fechaFin = new Date(year, 11, 31);

    finalBeginDate = [
        ("0" + fechaInicio.getDate()).slice(-2),
        ("0" + (fechaInicio.getMonth() + 1)).slice(-2),
        fechaInicio.getFullYear(),
    ].join("/");
    finalEndDate = [
        ("0" + fechaFin.getDate()).slice(-2),
        ("0" + (fechaFin.getMonth() + 1)).slice(-2),
        fechaFin.getFullYear(),
    ].join("/");

    $("" + inicioFecha + "").val('01/04/2023');
    $("" + finFecha + "").val(finalEndDate);
}

$(document).on('click', '.verDocumento', function () {
    const $itself = $(this);
    let pathUrl = `${general_base_url}static/documentos/cliente/contratoFirmado/`+$itself.attr('data-expediente');

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-expediente')}`,
        width: 985,
        height: 660
    });
});




