let titulos_intxt = [];

$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
	$('.datepicker').datetimepicker({locale: 'es'});
	setIniDatesXMonth("#beginDate", "#endDate");
    fillVentas(finalBeginDate, finalEndDate);
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

function fillVentas(beginDate, endDate) {
    $('#ventasRecision thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#ventasRecision').DataTable().column(i).search() !== this.value ) {
                $('#ventasRecision').DataTable().column(i).search(this.value).draw();
            }
        });
    });
    $('#ventasRecision').DataTable({
        destroy: true,
        ajax:
            {
                url: 'getVentasConSinRecision',
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
        bAutoWidth: true,
        ordering: false,
        pagingType: "full_numbers",
        scrollX: true,
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE DE VENTAS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                format:     
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
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
                {data: 'idLote'},
                {data: 'nombreResidencial'},
                {data: 'nombreCondominio'},
                {data: 'nombreLote'},
                {data: 'nombreCliente'},
                {data: 'fechaApartado'},
                {data: 'nombreAsesor'},
                {data: 'nombreCoordinador'},
                {data: 'nombreGerente'},
                {data: 'tipoLote'},
                {data: 'esCasa'},
                {data: 'estatusActualCliente'},
                {data: 'plazaVenta'},
                {data: 'tipoVenta'},
                {data: 'referencia'},
                {data: 'esCompartida'},
                {data: 'precioFinal'},
                { 
                    data: function (d) {
                        return (d.estatus9 == '' || d.estatus9 == null) ? 'SIN ESPECIFICAR' : d.estatus9
                    }
                },
                { 
                    data: function (d) {
                        return (d.estatus11 == '' || d.estatus11 == null) ? 'SIN ESPECIFICAR' : d.estatus11
                    }
                },
            ]
    });
    $('#ventasRecision').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(document).on("click", "#searchByDateRange", function () {
	let finalBeginDate = $("#beginDate").val();
	let finalEndDate = $("#endDate").val();
    var beginDate = moment(finalBeginDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    var endDate = moment(finalEndDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
	fillVentas(beginDate, endDate);
});