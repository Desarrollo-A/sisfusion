$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(finalBeginDate, finalEndDate);
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

let titulos = [];
$('#lotesApartados thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#lotesApartados').DataTable().column(i).search() !== this.value ) {
            $('#lotesApartados').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTable(beginDate, endDate) {
    var beginDate = moment(beginDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    var endDate = moment(endDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    $('#lotesApartados').DataTable({
        destroy: true,
        ajax:
            {
                url: 'getLotesXStatus',
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    "beginDate": beginDate,
                    "endDate": endDate
                }
            },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Reporte de lotes apartados',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
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
        language: {
            url: `../static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns:
            [
                {data: 'proyecto'},
                {data: 'condominio'},
                {data: 'nombreLote'},
                {data: 'nombreCliente'},
                {data: 'sede'},
                {data: 'nombreGerente'},
                {data: 'nombreCoordinador'},
                {data: 'nombreAsesor'},
                {data: 'estatus'},
                {
                    data: function(d){
                    return d.fechaApartado.split('.')[0];
                    }
                },
                {data: 'estatusContratacion'}
            ]
    });
}

$(document).on("click", "#searchByDateRange", function () {
	let finalBeginDate = $("#beginDate").val();
	let finalEndDate = $("#endDate").val();
	fillTable(finalBeginDate, finalEndDate);
});

$('#lotesApartados').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});