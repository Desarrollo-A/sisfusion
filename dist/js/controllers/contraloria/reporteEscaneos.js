
$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(1, finalBeginDate, finalEndDate, 0);

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

// function setInitialValues() {
//     // BEGIN DATE
//     const fechaInicio = new Date();
//     // Iniciar en este año, este mes, en el día 1
//     const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
//     // END DATE
//     const fechaFin = new Date();
//     // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
//     const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
//     finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
//     finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
//     var finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
//     var finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
//     $("#beginDate").val(finalBeginDate2);
//     $("#endDate").val(finalEndDate2);
//     fillDataTable(1, finalBeginDate, finalEndDate, 0);
// }


let titulos = [];
$('#tablaReporteEscaneos thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function () {
        if ($('#tablaReporteEscaneos').DataTable().column(i).search() !== this.value) {
            $('#tablaReporteEscaneos').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillDataTable(typeTransaction, beginDate, endDate, where) {
    $('#tablaReporteEscaneos').dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'CRM REPORTE DE ESCANEOS CARGADOS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            }
        }],
        ajax:
        {
            url: `${general_base_url}Contraloria/getReporteEscaneos`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        },
        pageLength: 10,
        bAutoWidth: true,
        fixedColumns: true,
        language: {
            url: `../static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columnDefs: [{
            defaultContent: "SIN ESPECIFICAR",
            targets: "_all"
        }],
        columns:
            [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'referencia' },
                { data: 'nombreUsuario' },
                { data: 'nombreReferencia' },
                { data: 'nombreSede' },
                { data: 'fechaCargaContratoFirmado' },
                {
                    data: function (d) {
                        if (d.estatusDocumento == 'CONTRATO CARGADO')
                            return `<span class="label lbl-oceanGreen">${d.estatusDocumento}</span>`;
                        else
                            return `<span class="label lbl-warning">${d.estatusDocumento}</span>`;
                    }
                }
            ]
    });
}


$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillDataTable(3, finalBeginDate, finalEndDate, 0);
});

$('#tablaReporteEscaneos').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
    });