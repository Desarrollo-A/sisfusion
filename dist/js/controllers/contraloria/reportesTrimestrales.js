$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTrimestral(finalBeginDate, finalEndDate);
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
$('#lotesTrimestral thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#lotesTrimestral').DataTable().column(i).search() !== this.value ) {
            $('#lotesTrimestral').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTrimestral(beginDate, endDate) {
    var beginDate = moment(beginDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    var endDate = moment(endDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    $('#lotesTrimestral').DataTable({
        destroy: true,
        ajax:
            {
                url: 'getLotesTrimestral',
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    "beginDate": beginDate,
                    "endDate": endDate
                }
            },
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
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title:'Reporte trimestral',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns:
            [
                {data: 'nombreResidencial'},
                {data: 'nombreCondominio'},
                {data: 'nombreLote'},
                {data: 'precioFinal'},
                {data: 'referencia'},
                {data: 'nombreAsesor'},
                {data: 'fechaApartado'},
                {data: 'nombreSede'},
                {data: 'tipo_venta'},
                {data: 'fechaEstatus9'},
                {data: 'estatusActual'},
                {data: 'cliente'},
                {data: function (n) {
                    return formatMoney(n.enganche);
                }},
                {
                    data: function(d){
                        if(d.estatus == 'Contratado')
                            return `<center><span class="label lbl-green">CONTRATADO</span><center>`;
                        else if(d.estatus == 'Apartado')
                            return `<center><span class="label lbl-sky">APARTADO</span><center>`;   
                        else       
                            return `<center><span class="label lbl-warning">CANCELADO</span><center>`;            
                    }         
                }
            ],
            initComplete: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('#spiner-loader').addClass('hide');
            }
    });
}

function formatMoney( n ) {
    const formatter = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        maximumFractionDigits: 4,
        currency: 'MXN'
    });
    return formatter.format(n);
}


$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTrimestral(finalBeginDate, finalEndDate);
    $('#tablaInventario').removeClass('hide');
	$('#spiner-loader').removeClass('hide');
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});