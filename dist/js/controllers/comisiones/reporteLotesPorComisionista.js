$(document).ready(function () {
    let seeAll = 0;
    if (id_rol_general == 1 || id_rol_general == 4 || id_rol_general == 18 || id_rol_general == 63)
        seeAll = 1;

    $.post('getOpcionesParaReporteComisionistas', { seeAll: seeAll }, function (data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 1) // COMISIONISTAS SELECT
                $("#comisionista").append($('<option>').val(data[i]['id_opcion']).attr({ 'data-estatus': data[i]['atributo_extra'], 'data-rol': data[i]['atributo_extra2'] }).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 2) // TIPO DE USUARIO SELECT
                $("#tipoUsuario").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        if (id_rol_general != 1 && id_rol_general != 4 && id_rol_general != 18 && id_rol_general != 63) {
            $("#comisionista").val(id_usuario_general);
            let estatusComisionista = $('#comisionista option:selected').data('estatus');
            let rolComisionista = $('#comisionista option:selected').data('rol');
            let htmlEstatus = '';
            let htmlRol = `<span>${rolComisionista}</span> )`;
            $(".lblEstatus").html('');
            $(".lblRolActual").html('');
            if (estatusComisionista == '3')
                htmlEstatus = `( <span>Inactivo comisionando</span> / `;
            else
                htmlEstatus = `( <span>Activo</span> / `;
            $(".lblEstatus").append(htmlEstatus);
            $(".lblRolActual").append(htmlRol);
        }
        $('#comisionista').selectpicker('refresh');
        $('#tipoUsuario').selectpicker('refresh');
    }, 'json');

    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(finalBeginDate, finalEndDate, id_usuario_general,id_rol_general );
});


sp = { // MJ: DATE PICKER
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

$("#comisionista").on('change', function () {
    $("#rowTotales").addClass("d-none");
    $('#reporteLotesPorComisionista').DataTable().clear().destroy();
    colocarValoresTotales('0.00', '0.00', '0.00');
    let estatusComisionista = $('#comisionista option:selected').data('estatus');
    let rolComisionista = $('#comisionista option:selected').data('rol');
    let htmlEstatus = '';
    let htmlRol = `<span>${rolComisionista}</span> )`;
    $(".lblEstatus").html('');
    $(".lblRolActual").html('');
    if (estatusComisionista == '3')
        htmlEstatus = `( <span>Inactivo comisionando</span> / `;
    else
        htmlEstatus = `( <span>Activo</span> / `;
    $(".lblEstatus").append(htmlEstatus);
    $(".lblRolActual").append(htmlRol);
    
});

let titulos_intxt = [];
$('#reporteLotesPorComisionista thead tr:eq(0) th').each(function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#reporteLotesPorComisionista').DataTable().column(i).search() !== this.value)
            $('#reporteLotesPorComisionista').DataTable().column(i).search(this.value).draw();
        let total = 0, totalAbonado = 0, totalPagado = 0;
        var index = $('#reporteLotesPorComisionista').DataTable().rows({
            selected: true,
            search: 'applied'
        }).indexes();
        var data = $('#reporteLotesPorComisionista').DataTable().rows(index).data();
        $.each(data, function (i, v) {
            total = total + parseFloat(v.comisionTotal);
            totalAbonado = totalAbonado + parseFloat(v.abonoDispersado);
            totalPagado = totalPagado + parseFloat(v.abonoPagado);
        });
        colocarValoresTotales(total, totalAbonado, totalPagado);
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

$('#reporteLotesPorComisionista').on('xhr.dt', function (e, settings, json, xhr) {
    let total = 0, totalAbonado = 0, totalPagado = 0;
    let jsonObject = JSON.parse(JSON.stringify(json)).data;
    for (let i = 0; i < jsonObject.length; i++) {
        total = total + parseFloat(jsonObject[i].comisionTotal);
        totalAbonado = totalAbonado + parseFloat(jsonObject[i].abonoDispersado);
        totalPagado = totalPagado + parseFloat(jsonObject[i].abonoPagado);
    }
    colocarValoresTotales(total, totalAbonado, totalPagado);
});

function fillTable(beginDate, endDate, comisionista, tipoUsuario) {
    generalDataTable = $('#reporteLotesPorComisionista').dataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Reporte de lostes por comisionista',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
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
        destroy: true,
        ordering: false,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            {
                data: function (d) {
                    if (d.rec == 8)
                        return '-';
                    else
                        return d.fechaApartado;
                }
            },
            {
                data: function (d) {
                    if (d.rec == 8)
                        return '-';
                    else
                        return d.plaza;
                }
            },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            {
                data: function (d) {
                    if (d.rec == 8)
                        return d.ultimoEstatusCanceladas;
                    else
                        return d.idStatusContratacion;
                }
            },
            {
                data: function (d) {
                    let labelStatus;
                    if (d.rec == 8)
                        labelStatus = `<span class="label lbl-warning">VENTA CANCELADA</span>`;
                    else
                        labelStatus = `<span class="label lbl-yellow">${d.nombreEstatusLote}</span>`;
                    return labelStatus;
                }
            },
            {
                data: function (d) {
                    let labelStatus;
                    if (d.rec == 8)
                        labelStatus = `<span class="label lbl-warning">RESCISIÓN DE CONTRATO</span>`;
                    else {
                        if (d.registroComision == 2 || d.registroComision == 8 || d.registroComision == 88 || d.registroComision == 0)
                        labelStatus = `<span class="label lbl-gray">SIN DISPERSAR</span>`;
                        else if (d.registroComision == 7)
                            labelStatus = `<span class="label lbl-green">LIQUIDADA</span>`;
                        else if (d.registroComision == 1)
                            labelStatus = `<span class="label lbl-violetDeep">EN PROCESO DE DISPERSIÓN</span></span>`;
                        else
                            labelStatus = `<span class="label lbl-grayDark">SIN DEFINIR ESTATUS</span>`;
                    }
                    return labelStatus;
                }
            },
            {
                data: function (d) {
                    if (d.rec == 8)
                        return '-';
                    else
                        return d.precioTotalLote;
                }
            },
            {
                data: function (d) {
                    return `${d.porcentaje_decimal}%`;
                }
            },
            {
                data: function (d) {
                    if (d.rec == 8 && d.comisionTotal == '0.0')
                        return '-';
                    else
                        return formatMoney(d.pagoCliente);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.comisionTotal);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.abonoDispersado);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.abonoPagado);
                }
            },
            { data: 'lugar_prospeccion' }
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
                "beginDate": beginDate,
                "endDate": endDate,
                "comisionista": comisionista,
                "tipoUsuario": tipoUsuario
            }
        }
    });
}

$(document).on("click", "#searchByDateRange", function () {
    $('#box-reporteLotesPorComisionista').removeClass('hide');
    if ($("#comisionista").val() != '' && $("#tipoUsuario").val() != '') {
        colocarValoresTotales('0.00', '0.00', '0.00');
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        let comisionista = $("#comisionista").val();
        let tipoUsuario = $("#tipoUsuario").val();
        fillTable(finalBeginDate, finalEndDate, comisionista, tipoUsuario);
        $("#rowTotales").removeClass("d-none");
    }
    else
        alerts.showNotification("top", "right", "No se han seleccionado algunos o ningún campo", "danger");
});

$(document).on("click", "#detailComisionistaBtn", function () {
    $('#spiner-loader').removeClass('hide');
    $(".timelineR").html('');
    var idComisionista = `${$("#comisionista").val() == '' ? id_usuario_general : $("#comisionista").val()}`;
    let orderedArray = [];
    $.post('getDetalleVentasPorComisionista', { comisionista: idComisionista }, function (data) {
        let html = '';
        for (let i = 0; i < data.length; i++) {
            if (data[i].totalVentas != 0) {
                for (let j = 0; j < data[i].datos.length; j++) {
                    let found = orderedArray.find(e => e.anio == data[i].datos[j].anio);
                    if (found == undefined) {
                        orderedArray.push({
                            anio: data[i].datos[j].anio,
                            datos: [{
                                rol: data[i].columna,
                                total: data[i].datos[j].total,
                                activas: data[i].datos[j].activas,
                                canceladas: data[i].datos[j].canceladas
                            }]
                        });
                    }
                    else {
                        found.datos.push({
                            rol: data[i].columna,
                            total: data[i].datos[j].total,
                            activas: data[i].datos[j].activas,
                            canceladas: data[i].datos[j].canceladas
                        })
                    }
                    orderedArray.sort(function(a,b){
                        if(a.anio> b.anio){
                            return 1;
                        }
                        if(a.anio< b.anio){
                            return -1;
                        }
                    });
                }
            }
        }
        
        for (let i = 0; i < orderedArray.length; i++) {
            let htmlRol = '';
            for (let j = 0; j < orderedArray[i].datos.length; j++) {
                htmlRol += `<div class="tl-date mt-1"><b>${orderedArray[i].datos[j].total}</b> comisiones como ${(orderedArray[i].datos[j].rol).replace('id_', '')}<ul class="m-0" style="list-style:none"><li><b>${orderedArray[i].datos[j].activas}</b> activos</li><li><b>${orderedArray[i].datos[j].canceladas}</b> cancelados</li></ul></div>`;
            }
            html += `<div class="tl-item">
                        <div class="tl-dot b-warning"></div>
                        <div class="tl-content">
                            <div><b>${orderedArray[i].anio}</b></div>
                            ${htmlRol}
                        </div>
                    </div>`;
        }
        html += `<div class="tl-item">
                    <div class="b-warning"></div>
                    <div class="tl-content">
                    </div>
                </div>`;
        $(".timelineR").append(html);
        $("#detailComisionistaModal").modal();
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

function colocarValoresTotales(total, totalAbonado, totalPagado) {
    document.getElementById("txt_totalComision").textContent = formatMoney(total);
    document.getElementById("txt_totalAbonado").textContent = formatMoney(totalAbonado);
    document.getElementById("txt_totalPagado").textContent = formatMoney(totalPagado);
}
