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
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
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
                {data: 'nombreCoordinador'},
                {data: 'nombreGerente'},
                {data: 'fechaApartado'},
                {data: 'nombreSede'},
                {data: 'tipo_venta'},
                {data: 'fechaEstatus9'},
                {
                    data: function(d){
                        return `<center><span class="label lbl-sky" >${d.estatusActual}</span><center>`;
                    }
                },
                {
                    data: function(d){
                        let colorEstatus = (d.colorEstatus=='') ? 'fff' : d.colorEstatus;
                        let fondoEstatus = (d.fondoEstatus=='') ? 'f21100' : d.fondoEstatus;
                            return `<center><span class="label" style="background-color:#${fondoEstatus}75; color:#${colorEstatus}">${d.estatus}</span><center>`;
                    }
                },
                {data: 'cliente'},
                {
                    data: function (n) {
                    return formatMoney(n.enganche);
                    }
                },
                {
                    data: function (n) {
                        let compartida = (n.numeroVC == 0) ? 'NO' : 'SÍ';
                        let classCompartida = (n.numeroVC == 0) ? 'lbl-gray' : 'lbl-sky';
                        return `<center><span class="label ${classCompartida}" >${compartida}</span><center>`;
                    }
                },
                {
                    data: function (n) {
                        return `<center><span class="label ${n.numeroVC == 0 ? 'lbl-gray' : 'lbl-sky'}" >${n.numeroVC}</span><center>`;
                    }
                },
                {
                    data: function (n) {
                        if (n.tipoEnganche == 0 || n.tipoEnganche == null) {
                            return `SIN ESPECIFICAR`;  
                        }
                        return `<center>${n.nombre}<center>`;
                    }
                },
                {
                    data: function (n){
                        return `<div class="d-flex justify-center"><button id="verifyNeodata" class="btn-data btn-violetBoots" data-toggle="tooltip" data-placement="left" title="Verificar montos" data-nombreLote="${n.nombreLote}" data-empresa="${n.empresa}"><i class="fas fa-glasses"></i></button><div>`;
                    }
                },
            ],
            initComplete: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('#spiner-loader').addClass('hide');
            }
    });
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

function formatMoney( n ) {
    const formatter = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        maximumFractionDigits: 4,
        currency: 'MXN'
    });
    return formatter.format(n);
}

$(document).on("click", "#verifyNeodata", function () {
    let empresa = $(this).attr("data-empresa");
    let nombreLote = $(this).attr("data-nombreLote");
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "getMensualidadAbonoNeo",
        data: {empresa: empresa, nombreLote: nombreLote},
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (response) {
            $("#detailPayments .modal-body").empty();
            $("#detailPayments .modal-header").empty();
            $("#detailPayments .modal-header").append('<div class="d-flex align-center titleCustom" style="background: white; border-radius:25px; justify-content: space-around"><h3 class="text-center fw-600"><b>lote</b></h3><h3 class="text-center fw-600">'+nombreLote+'</h3><i class="fas fa-times-circle fa-lg cursor-point" data-dismiss="modal" aria-hidden="true"></i></div>');
            if(response.length != 0){
                $("#detailPayments .modal-body").append('<p class="text-center">Total pagado actualmente</p><h1 class="text-center fw-600">'+formatMoney(response[0]['MontoTotalPagado'])+'</h1><p class="text-center"><i class="fas fa-money-bill-wave m-1" style="color:#6da36f"></i>mensualidades pagadas <b>'+response[0]['MenPagadas']+' pendientes '+response[0]['MenPendientes']+'</b></p>');
            }
            else{
                $("#detailPayments .modal-body").append(`<div class="h-100 text-center pt-4"><img src= '${general_base_url}dist/img/empty.png' alt="Icono vacío" class="w-60"></div><h3 class="titleEmpty">`);
            }
            
            $('#spiner-loader').addClass('hide');
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#btn_change_lp').prop('disabled', false);
        }
    });
    
    $("#detailPayments").modal();
  });