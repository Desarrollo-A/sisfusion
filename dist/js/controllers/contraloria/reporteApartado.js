$(document).ready(function () {
	sp.initFormExtendedDatetimepickers();
	$('.datepicker').datetimepicker({locale: 'es'});
	setInitialValues();
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

function setInitialValues(){
	// BEGIN DATE
	const fechaInicio = new Date();
	// Iniciar en este año, este mes, en el día 1
	const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
	// END DATE
	const fechaFin = new Date();
	// Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
	const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
	finalBeginDate = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
	finalEndDate = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
	
	$("#beginDate").val(finalBeginDate);
	$("#endDate").val(finalEndDate);
	fillTable(finalBeginDate, finalEndDate);
}

function fillTable(beginDate, endDate) {
    var beginDate = moment(beginDate, 'DD/MM/YYYY').format('YYYY-MM-DD');
    var endDate = moment(endDate, 'DD/MM/YYYY').format('YYYY-MM-DD');

    $('#lotesApartados thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#lotesApartados').DataTable().column(i).search() !== this.value ) {
                $('#lotesApartados').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $('#lotesApartados').DataTable({
        destroy: true,
        ajax:
            {
                url: 'getLotesApartados',
                dataSrc: "",
                type: "POST",
                cache: false,
                data: {
                    "beginDate": beginDate,
                    "endDate": endDate
                }
            },
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
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
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 0:
                                return 'RESIDENCIAL'
                                break;
                            case 1:
                                return 'CONDOMINIO';
                                break;
                            case 2:
                                return 'LOTE';
                                break;
                            case 3:
                                return 'PRECIO FINAL';
                                break;
                            case 4:
                                return 'REFERENCIA';
                                break;
                            case 5:
                                return 'ASESOR';
                                break;
                            case 6:
                                return 'FECHA APORTADO';
                                break;
                            case 7:
                                return 'SEDE';
                                break;
                            case 8:
                                return 'TIPO VENTA';
                                break;
                            case 9:
                                return 'FECHA CONTRATACIÓN';
                                break;
                        }
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
                {data: 'fechaEstatus9'}
            ]
    });
}

$(document).on("click", "#searchByDateRange", function () {
	let finalBeginDate = $("#beginDate").val();
	let finalEndDate = $("#endDate").val();
	fillTrimestral(finalBeginDate, finalEndDate);
});