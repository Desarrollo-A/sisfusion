let titulos = [];
$('#Jtabla thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value) {
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).ready(function () {
    $.ajax(
        {
            post: "POST",
            url: general_base_url+"registroLote/getDateToday/"
        }).done(function (data) {
        $('#showDate').append('(al día de hoy: ' + data + ")");
    }).fail(function () {
    });
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(finalBeginDate, finalEndDate);
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

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(finalBeginDate, finalEndDate);
});

function fillTable(beginDate, endDate) {
    $('#Jtabla').dataTable({
        ajax:{
            url: general_base_url+'contraloria/getRevision7',
            dataSrc: "",
            type: "POST",
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
            }
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn buttons-excel',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                titleAttr: 'Expedientes rechazados de jurídico',
                title:'Expedientes rechazados de jurídico',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                className: 'btn buttons-pdf',
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                orientation: 'landscape',
                pageSize: 'A3',
                titleAttr: 'Expedientes rechazados de jurídico',
                title:'Expedientes rechazados de jurídico',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pageLength: 10,
        fixedColumns: true,
        ordering: false,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy:true,
        columnDefs: [{
            defaultContent: "-",
            targets: "_all"
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        columns:[
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'nombreSede'},
            {
                data: function (data) {
                    return myFunctions.validateEmptyField(data.gerente);
                }
            },
            {
                data: function (data) {
                    return myFunctions.validateEmptyField(data.coordinador);
                }
            },
            {
                data: function (data) {
                    return myFunctions.validateEmptyField(data.asesor);
                }
            },
            {
                data: function (data) {
                    return myFunctions.validateEmptyField(data.nombreUsuario);
                }
            },
            {
                data: function (data) {
                    return data.fechaApartado;
                }
            },
            {
                data: function (data) {
                    return data.comentario;
                }
            },
            {
                data: function (data) {
                    return data.modificado;
                }
            },
            {
                data: function (data) {
                    return data.fechaVenc;
                }
            },
        ]
    });
}

$('#Jtabla').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});