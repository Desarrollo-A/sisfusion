$(document).ready(function () {
    $.getJSON("getOpcionesParaReporteComisionistas").done(function(data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 1) // COMISIONISTAS SELECT
                $("#comisionista").append($('<option>').val(data[i]['id_opcion']).attr('data-estatus', data[i]['atributo_extra']).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 2) // TIPO DE USUARIO SELECT
                $("#tipoUsuario").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $('#comisionista').selectpicker('refresh');
        $('#tipoUsuario').selectpicker('refresh');
    });

    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    /*
    fillTable(typeTransaction, beginDate, endDate, where) PARAMS;
        typeTransaction:
            1 = ES LA PRIMERA VEZ QUE SE LLENA LA TABLA O NO SE SELECCIONÓ UN RANGO DE FECHA (MUESTRA LO DEL AÑO ACTUAL)
            2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL ID DE LOTE INGRESADO)
            3 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
        beginDate
            FECHA INICIO
        endDate
            FECHA FIN
        where
            ID LOTE (WHEN typeTransaction VALUE IS 2 WE SEND ID LOTE VALUE)
    */
    setInitialValues();
});

$("#comisionista").on('change', function() {
    let estatusComisionista = $('#comisionista option:selected').data('estatus');
    console.log(estatusComisionista);
    let html = '';
    $(".lblEstatus").html('');
    if (estatusComisionista == '3'){
        html = `<span style="background-color: #ffbc421c; padding: 4px 14px; border-radius: 20px; color: #ffbc42; font-weight: 500; font-size: 12px;">Inactivo comisionando</span>
        `;
    }
    else{
        html = `<span style="background-color: #4caf501c; padding: 4px 14px; border-radius: 20px; color: #4caf50; font-weight: 500; font-size: 12px;">Activo</span>
        `;
    }
    $(".lblEstatus").append(html);
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

let titulos_intxt = [];
$('#masterCobranzaTable thead tr:eq(0) th').each( function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_intxt.push(title);
    if (i != 16) {
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#masterCobranzaTable').DataTable().column(i).search() !== this.value ) {
                $('#masterCobranzaTable').DataTable().column(i).search(this.value).draw();
            }

            let total=0, totalAbonado = 0, totalPagado = 0;
            var index = $('#masterCobranzaTable').DataTable().rows({
                selected: true,
                search: 'applied'
            }).indexes();

            var data = $('#masterCobranzaTable').DataTable().rows(index).data();
            $.each(data, function(i, v) {
                total = total + parseFloat(v.comisionTotal);
                totalAbonado = totalAbonado + parseFloat(v.abonoDispersado);
                totalPagado = totalPagado + parseFloat(v.abonoPagado);
            });
            document.getElementById("txt_totalComision").textContent = '$' + formatMoney(total);
            document.getElementById("txt_totalAbonado").textContent = '$' + formatMoney(totalAbonado);
            document.getElementById("txt_totalPagado").textContent = '$' + formatMoney(totalPagado);
        });

        
    }
});

$('#masterCobranzaTable').on('xhr.dt', function(e, settings, json, xhr) {
    let total=0, totalAbonado = 0, totalPagado = 0;
    let jsonObject = JSON.parse(JSON.stringify(json)).data;
    for(let i=0; i < jsonObject.length; i++){
        total = total + parseFloat(jsonObject[i].comisionTotal);
        totalAbonado = totalAbonado + parseFloat(jsonObject[i].abonoDispersado);
        totalPagado = totalPagado + parseFloat(jsonObject[i].abonoPagado);
    }
    
    document.getElementById("txt_totalComision").textContent = '$' + formatMoney(total);
    document.getElementById("txt_totalAbonado").textContent = '$' + formatMoney(totalAbonado);
    document.getElementById("txt_totalPagado").textContent = '$' + formatMoney(totalPagado);
    
});

function fillTable(typeTransaction, beginDate, endDate, where) {
    generalDataTable = $('#masterCobranzaTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                            }
                        }
                }
            },
            {
                text: "<i class='fa fa-refresh' aria-hidden='true'></i>",
                titleAttr: 'Cargar vista inicial',
                className: "btn btn-azure reset-initial-values",
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'idLote'},
            {data: 'nombreCliente'},
            { data: function (d) {
                if(d.rec == 8)
                    return '-';
                else
                    return d.fechaApartado;
            }},
            { data: function (d) {
                if(d.rec == 8)
                    return '-';
                else
                    return d.plaza;
            }},
            { data: function (d) {
                if(d.rec == 8)
                    return '-';
                else
                    return d.idStatusContratacion;
            }},
            { data: function (d) {
                let labelStatus;
                if(d.rec == 8)
                    labelStatus = `<span class="label" style="background:#E6B0AA; color:#641E16">VENTA CANCELADA</span>`;
                else
                    labelStatus = `<span class="label" style="background:#${d.background_sl}; color:#${d.color}">${d.nombreEstatusLote}</span>`;
                return labelStatus;
            }},
            { data: function (d) {
                let labelStatus;
                if(d.rec == 8)
                    labelStatus = `<span class="label" style="background:#E6B0AA; color:#641E16">RECISIÓN DE CONTRATO</span>`;
                else {
                    if (d.registroComision == 2 || d.registroComision == 8 || d.registroComision == 88 || d.registroComision == 0)
                        labelStatus = `<span class="label" style="background:#ABB2B9; color:#17202A">SIN DISPERSAR</span>`;
                    else if (d.registroComision == 7)
                        labelStatus = `<span class="label" style="background:#A9DFBF; color:#145A32">LIQUIDADA</span>`;
                    else if (d.registroComision == 1)
                        labelStatus = `<span class="label" style="background:#D7BDE2; color:#512E5F">ACTIVA</span></span>`;
                }
                return labelStatus;
            }},
            { data: function (d) {
                if(d.rec == 8)
                    return '-';
                else
                    return d.precioTotalLote;
            }},
            {
                data: function (d) {
                    return `${d.porcentaje_decimal}%`;
                }
            },
            {
                data: function(d) {
                    return '$' + formatMoney(d.comisionTotal);
                }
            },
            {
                data: function(d) {
                    return '$' + formatMoney(d.abonoDispersado);
                }
            },
            {
                data: function(d) {
                    return '$' + formatMoney(d.abonoPagado);
                }
            },
            {data: 'lugar_prospeccion'}
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getReporteLotesPorComisionista',
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        }
    });
}

$(document).on("click", "#searchByLote", function () {
    let idLote = $("#idLote").val();
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(2, finalBeginDate, finalEndDate, idLote);
});

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

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
    fillTable(1, finalBeginDate, finalEndDate, 0);
}

$(document).on("click", ".reset-initial-values", function () {
    setInitialValues();
    $(".idLote").val('');
    $(".textoshead").val('');
    $("#beginDate").val('01/01/2022');
    $("#endDate").val('01/01/2022');
});
