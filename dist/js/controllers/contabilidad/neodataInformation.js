const excluir_column = ['MÁS', ''];
var columnas_datatable = {};

sp = { //  SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
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

$(document).on('change', "#residenciales", function () {
    getCondominios($(this).val());
});

$(document).on('change', "#condominios", function () {
    getLotes($(this).val());
});

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
});

function toggleSelect2() {
    var isChecked = document.getElementById("dates").checked;
    (isChecked) ? $(".datepicker").removeClass("hide") : $(".datepicker").addClass("hide");
}

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    getEmpresasList();
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
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

$(document).on('click', '#searchInfo', function () {
    let empresa = $("#empresas").val();
    let idProyecto = $("#proyectos").val();
    let idCliente = $("#clientes").val();
    let dates = 0;
    if (document.getElementById("dates").checked)
        dates = 1
    let fechaIni = $("#beginDate").val();
    let fechaFin = $("#endDate").val();

    if (empresa == undefined || empresa == '')
        $('#notificacion').modal('show');
    else
        fillTableLotificacionNeoData(empresa, idProyecto, idCliente, fechaIni, fechaFin, dates);
}
);
const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',

    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});


let titulosInventario = [];
$('#tableLotificacionNeodata thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tableLotificacionNeodata').DataTable().column(i).search() !== this.value) {
            $('#tableLotificacionNeodata').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTableLotificacionNeoData(empresa, idProyecto, idCliente, fechaIni, fechaFin, dates) {
    generalDataTableNeoData = $('#tableLotificacionNeodata').dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        scrollX: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.codcliente);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.Cuenta2170);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.Cuenta1150);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.Vivienda);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.Contrato);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.cliente);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.superficie);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.precioventa);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha_contrato);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.freconocimiento);
                }
            },
            {
                data: function (d) {
                    return d.uuid;
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.intermediariocte);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.monto2170);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.monto1150);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.montoorden);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.escrituraind);
                }
            },
            {
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fescritura);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.totcontrato);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.totcontratoint);
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.pagado_cap)
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.pagado_mor)
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.pagado_int)
                }
            },
            {
                data: function (d) {
                    return '$' + formatMoney(d.totcontratoint)
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "getInformationFromNeoData",
            type: "POST",
            cache: false,
            data: {
                "empresa": empresa,
                "idProyecto": idProyecto,
                "idCliente": idCliente,
                "dates": dates,
                "fechaIni": fechaIni,
                "fechaFin": fechaFin
            }
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
        }
    });
}

$(document).on('change', "#empresas", function () {
    getProyectosList($(this).val());
});

$(document).on('change', "#proyectos", function () {
    getClientesList($("#empresas").val(), $(this).val());
});

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    // console.log('Fecha inicio: ', finalBeginDate);
    // console.log('Fecha final: ', finalEndDate);
    $("#beginDate").val(convertDate(beginDate));
    $("#endDate").val(convertDate(endDate));
    // fillTable(1, finalBeginDate, finalEndDate, 0);
}

