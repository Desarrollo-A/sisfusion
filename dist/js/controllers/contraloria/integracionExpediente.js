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
    scrollX:true,
    stateSave: true,
    "bDestroy": true,
    buttons: [
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo Excel',
            title: "Integración de expediente",
            exportOptions: {
                columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
            className: 'btn buttons-pdf',
            titleAttr: 'Descargar archivo PDF',
            title: "Integración de expediente",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
    bAutoWidth: false,
    fixedColumns: true,
    ordering: false,
    columns: [{
        data: function (data){
            return data.nombreResidencial
        }
    },
    {
        data: function (data){  
            return data.nombreCondominio
        }
    },
    {
        data: function (data){
            return data.nombreLote
        }
    },
    {
        data: function (data){
            return data.gerente
        }
    },
    {
        data: function (data){
            return data.coordinador
        }
    },
    {
        data: function (data){
            return data.asesor
        }
    },
    {
        data: function (data){
            return data.result
        }
    },
    {
        data: function (data){
            return data.modificado
        }
    },
    {
        data: function (data){
            return data.comentario
        }
    },
    {
        data: function (data){
            return data.fechaApartado
        }
    },
    {
        data: function (data){
            return data.fechaVenc
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
        url: `${general_base_url}Contraloria/getRevision2/`,
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
}

$.ajax({
    post: "POST",
    url: `${general_base_url}registroLote/getDateToday`,
}).done(function(data){
    $('#showDate').append('Expedientes integrados al día ' + data +' ');
}).fail(function(){});

