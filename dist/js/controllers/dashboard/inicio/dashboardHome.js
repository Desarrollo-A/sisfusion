var totalVentasChart, prospectosChart, chartProspClients, chartWeekly, chartFunnel;
var mediaqueryList = window.matchMedia("(min-width: 200px)");

var optionsTotalVentas = {
    series: [],
    chart: {
        height: '100%',
        type: 'radialBar',
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
                name: {
                    fontSize: '14px',
                    offsetY: 120
                },
                value: {
                    fontSize: '18px',
                    offsetY: 76,
                    formatter: function (val) {
                        return val + '%'
                      }
                },
                total: {
                    show: true,
                    label: '',
                    fontSize: '14px',
                    offsetY: 120,
                    formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function

                        let val = w.globals.labels[0];
                        return `${val.toLocaleString('es-MX')}`;
                    }
                }
            },
            track: {
                background: ['#f9f9f9', '#f9f9f9', '#f9f9f9', '#f9f9f9'],
            }
        }
    },
};

var optionsProspectos = {
    series: [],
    chart: {
        type: 'area',
        height: '100%',
        toolbar: { show: false },
        zoom: { enabled: false },
        sparkline: {
            enabled: true
          }
    },
    colors: ["#2C93E7"],
    grid: {
        show: false,
    },
    dataLabels: { enabled: false },
    legend: { show: false },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    xaxis: {
    labels: {show: false},
    axisBorder: {show:false},
    axisTicks: {show:false},
    },
    yaxis: {
        type: 'numeric',
        labels: {show: false},
        axisBorder: {show:false},
        axisTicks: {show:false},
    },
    fill: {
        opacity: 1,
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            gradientToColors:  ['#2C93E7'],
            inverseColors: true,
            opacityFrom: 0.55,
            opacityTo: 0.2,
            stops: [0, 70, 100],
            colorStops: []
        }
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: (value) => value.toLocaleString('es-MX'),
            title: {
                formatter: (seriesName) => seriesName,
            },
        },
    }
};

var optionsProspClients = {
    series: [],
    chart: {
        height: '100%',
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: false,
        },
    },
    colors: ['#22639b', '#00A0FF'],
    grid: {
        show: true,
        borderColor: '#f3f3f3',
        strokeDashArray: 0,
        position: 'back',
        yaxis: {
            lines: {
                show: true
            }
        },
        row: {
            colors: undefined,
            opacity: 0.5
        },
        column: {
            colors: undefined,
            opacity: 0.5
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2,
        curve: 'smooth',
        opacity: 0.7
    },
    fill: {
        opacity: 1,
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            gradientToColors: ['#22639b', '#00A0FF'],
            inverseColors: true,
            opacityFrom: 0.6,
            opacityTo: 0.2,
            stops: [0, 70, 100],
            colorStops: []
        }
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: (value) => value.toLocaleString('es-MX'),
        },
    },
    noData: {
        text: 'No hay informacion para mostrar...'
    }
};

var optionsWeekly = {
    series: [{
        name: 'Cantidad',
        data: []
    }],
    chart: {
        height: '100%',
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    noData: {
        text: 'No hay informacion para mostrar...'
      },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    grid:{
        show: true,
    },
    plotOptions: {
        bar: {
            columnWidth: '45%',
            distributed: true,
        }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        show: false,
    },
    xaxis: {
        show: false,
        labels: {
          show: false
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        categories: ['Prospectos nuevos','Prospectos c/cita','Ventas totales','Ventas contratadas',
        'Ventas apartadas','Cancelados contratados','Cancelados apartados']
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: (value) => value.toLocaleString('es-MX'),
        },
    }
};

var optionsFunnel = {
    series: [],
    chart: {
        height: '100%',
        type: 'polarArea',
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    stroke: {
        colors: ['#fff']
    },
    fill: {
        opacity: 0.8
    },
    yaxis: {
        show: false
    },
    grid: {
        show: false,
        xaxis: {
            lines: {
                show: false //or just here to disable only x axis grids
            }
        },
        yaxis: {
            lines: {
                show: false //or just here to disable only y axis
            }
        },
    },
    legend: {
        show: false
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: (value) => value.toLocaleString('es-MX'),
            title: {
                formatter: (seriesName) => 'Cantidad',
            },
        },
    }
};

function readyHome(){
    userType != 9 ? $('#buttonsCoord').hide():'';
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValuesHome();
    loadInit();
    loadApexChart();
    $('[data-toggle="tooltip"]').tooltip();
}

function loadApexChart(){
    totalVentasChart = new ApexCharts(document.querySelector("#totalVentasChart"), optionsTotalVentas);
    totalVentasChart.render();

    prospectosChart = new ApexCharts(document.querySelector("#prospectosChart"), optionsProspectos);
    prospectosChart.render();

    chartProspClients = new ApexCharts(document.querySelector("#chartProspClients"), optionsProspClients);
    chartProspClients.render();

    chartWeekly = new ApexCharts(document.querySelector("#chartWeekly"), optionsWeekly);
    chartWeekly.render();

    chartFunnel = new ApexCharts(document.querySelector("#chartFunnel"), optionsFunnel);
    chartFunnel.render();
}

$(document).on('click', '.week', function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    weekFilter(id);
});

$(document).on('click', '#searchByDateRangeCP', function(e){
    e.preventDefault();
    var beginDate = $('#beginDate').val();
    var endDate = $('#endDate').val();
    getClientsAndProspectsByYear(2, formatDate(beginDate), formatDate(endDate));
});

$(document).on('click', '#searchByDateRange2', function(e){
    e.preventDefault();
    var beginDate = $('#beginDate2').val();
    var endDate = $('#endDate2').val();
    let typeTransaction = validateMainFilters();

    var com2 = new FormData();
    com2.append("fecha_inicio", formatDate(beginDate));
    com2.append("fecha_fin", formatDate(endDate));
    com2.append("typeTransaction", typeTransaction);
    getDataFromDates(com2);
});

$('.infoMainSelector').unbind().on('click', function(e){
    let c= $('input:checkbox.infoMainSelector:checked').length
    var checkbox = $(this);
    if (!checkbox.is(":checked") && c<1) {
        // do the confirmation thing here
        e.preventDefault();
        return false;
    }
    loadInit();
});

function loadInit(){
        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("typeTransaction", typeTransaction);
        getProspectsByYear(com2);
        getSalesByYear(com2);
        generalMetrics(typeTransaction);
        cicloVenta(com2);
        getClientsAndProspectsByYear();
}

function getSalesByYear(com2){
    $('.loadTotalVentasChart').removeClass('d-none');
    $.ajax({
        url: `${base_url}Dashboard/totalVentasData`,
        data:com2,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            let totalVentasArray = [
                parseFloat(response.porcentajeTotal),
                parseFloat(response.porcentajeTotalCont),
                parseFloat(response.porcentajeTotalAp),
                parseFloat(response.porcentajeTotalC),
            ];
            totalVentasChart.updateSeries(totalVentasArray)

            totalVentasChart.updateOptions({
              labels: [
                `Gran total: ${formatAsThousands(response.totalVentas)}`,
                `Contratado: ${formatAsThousands(response.totalConT)}`,
                `Apartado: ${formatAsThousands(response.totalAT)}`,
                `Cancelado: ${formatAsThousands(response.totalCT)}`
                ]
             });

            totalVentasChart.toggleDataPointSelection (0);
            $('.loadTotalVentasChart').addClass('d-none');
        }
    });
}

function getProspectsByYear(com2) {
    $('.loadProspectosChart').removeClass('d-none');
    $.ajax({
        url: `${base_url}Dashboard/getProspectsByYear`,
        data:com2,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            let months = [];
            let data = [];
            let count = 0;
            response.forEach(element => {
                months.push(element.MONTH);
                data.push(element.counts);
                count = count + parseInt(element.counts);
            });
            prospectosChart.updateSeries([{
                name: 'Prospectos',
                data: data
            }])
            prospectosChart.updateOptions({
                xaxis: {
                    categories: months
                },
                });
            $('#numberGraphic').text(count.toLocaleString('es-MX'));
            document.getElementById('numberGraphic').title = count.toLocaleString('es-MX');
            $('.loadProspectosChart').addClass('d-none');
        }
    });
}

function getClientsAndProspectsByYear(type = 1, beginDate = null, endDate= null) {
    typeTransaction = validateMainFilters();
    var data = new FormData();
    data.append("type", type);
    data.append("beginDate", beginDate);
    data.append("endDate", endDate);
    data.append("typeTransaction", typeTransaction);
    $('.loadChartProspClients').removeClass('d-none');
    $.ajax({
        url: `${base_url}Dashboard/getClientsAndProspectsByYear`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            let monthsP = [];
            let monthsC = [];
            let dataP = [];
            let dataC = [];
            let countC = 0;
            let countP = 0;
            response.Clientes.forEach(element => {
                monthsP.push(`${element.MONTH} ${element.año}`);
                dataC.push(element.counts);
                countC = countC + element.counts;
            });
            response.Prospectos.forEach(element => {
                monthsC.push(`${element.MONTH} ${element.año}`);
                dataP.push(element.counts);
                countP = countP + element.counts;
            });
            chartProspClients.updateSeries([{
                name: 'Prospectos',
                data: dataP
            },{
                name: 'Clientes',
                data: dataC
            }])
            chartProspClients.updateOptions({
                xaxis: {
                    categories: monthsP.length >= monthsC.length ? monthsP:monthsC
                },
            });
            $('.loadChartProspClients').addClass('d-none');
        }
    });
}

function generalMetrics(typeTransaction) {
    let thisWeek = getThisWeek();
    var com2 = new FormData();
    com2.append("fecha_inicio", thisWeek.inicio_semana);
    com2.append("fecha_fin", thisWeek.fin_semana);
    com2.append("typeTransaction", typeTransaction);
    getDataFromDates(com2);
}

function weekFilter(element){
    typeTransaction = validateMainFilters();
    if(element == 'thisWeek'){
        let thisWeek = getThisWeek();
        var com2 = new FormData();
        com2.append("fecha_inicio", thisWeek.inicio_semana);
        com2.append("fecha_fin", thisWeek.fin_semana);
        com2.append("typeTransaction", typeTransaction);
        getDataFromDates(com2);
    }
    if(element == 'lastWeek'){
        let semana_pasada =  getLastWeek();
        var com2 = new FormData();
        com2.append("fecha_inicio", semana_pasada.inicio_semana);
        com2.append("fecha_fin", semana_pasada.fin_semana);
        com2.append("typeTransaction", typeTransaction);
        getDataFromDates(com2);
    }
    if(element == 'lastMonth'){
        let mes_pasada =  getLastMonth();
        var com2 = new FormData();
        com2.append("fecha_inicio", mes_pasada.inicio_mes);
        com2.append("fecha_fin", mes_pasada.fin_mes);
        com2.append("typeTransaction", typeTransaction);
        getDataFromDates(com2);
    }
}

function getDataFromDates(com2){
    $('.loadChartWeekly').removeClass('d-none');
    $.ajax({
        url: `${base_url}Dashboard/getDataFromDates`,
        data:com2,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success : function (response) {
            const sumValues = obj => Object.values(obj).reduce((a, b) => a + b);
            let suma = sumValues(response)-response.prospTotales;
            chartWeekly.updateSeries([{
                data: suma > 0 ? [response.prospNuevos, response.prosCita, response.totalVentas, response.totalConT,
                response.totalAT, response.totalCanC, response.totalCanA] : []
            }]);
            addTextFields(response);
            $('.loadChartWeekly').addClass('d-none');
        }
    });
}

function cicloVenta(com2){
    $('.loadChartFunnel').removeClass('d-none');
    $.ajax({
        url: `${base_url}Dashboard/cicloVenta`,
        data:com2,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        success : function (response) {
            chartFunnel.updateSeries([
                response.totalProspectosCita, response.totalProspectosCitaSeguimiento,
                response.totalApartados, response.prospectosNoInteresados
            ]);

            addTextFields2(response);
            $('.loadChartFunnel').addClass('d-none');
        }
    });
}

function getLastWeek(){
    var curr = new Date; // get current date
    var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
    var last = first + 6; // last day is the first day + 6

    var firstday = new Date(curr.setDate(first));
    let inicio_semana = new Date(firstday.getFullYear(), firstday.getMonth(), firstday.getDate()-7) // can also be a Temporal object
    inicio_semana = inicio_semana.toISOString().split('T')[0];

    var lastday = new Date(curr.setDate(last));
    let fin_semana = new Date(lastday.getFullYear(), lastday.getMonth(), lastday.getDate()-7);
    fin_semana = fin_semana.toISOString().split('T')[0];

    let dates = [];
    dates.push({"date":inicio_semana, type:1});
    dates.push({"date":fin_semana, type:2});
    return {inicio_semana:inicio_semana, fin_semana:fin_semana};
}

function getLastMonth(){
    var now = new Date();
    var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
    var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);

    function formatDateComponent(dateComponent) {
        return (dateComponent < 10 ? '0' : '') + dateComponent;
    };

    var formatDate = function(date) {
        return date.getFullYear() + '-' +formatDateComponent(date.getMonth() + 1) + '-' + formatDateComponent(date.getDate());
    };

    return {inicio_mes:formatDate(prevMonthFirstDate), fin_mes:formatDate(prevMonthLastDate)};
}

function validateMainFilters(){
    let selector1 = $('#infoMainSelector1')[0];
    let selector2 = $('#infoMainSelector2')[0];
    let valueOf = this.value;
    let isCheck = this.checked;
    let transaction = '';

    if(valueOf == 1 && isCheck){
        if(selector1.checked && selector2.checked){
            transaction = 3;
        }
        else{
            transaction = 1;
        }
    }
    else if(valueOf == 2 && isCheck){
        if(selector1.checked && selector2.checked){
            transaction = 3;
        }else{
            transaction = 2;
        }
    }else{
        if(selector1.checked && !selector2.checked){
            transaction = 1;
        }
        else if(selector2.checked && !selector1.checked){
            transaction = 2;
        }else if(selector1.checked && selector2.checked){
            transaction = 3;
        }else
        {
            transaction = 0;
        }
    }
    return transaction;
}

function cleanValues() {
    $('#pt_card').text('');
    $('#np_card').text('');
    $('#va_card').text('');
    $('#ca_card').text('');
    $('#vc_card').text('');
    $('#cc_card').text('');
    $('#ct_card').text('');
    $('#pcc_card').text('');
};

function addTextFields(response){
    $('#pt_card').text(`${(response.prospTotales).toLocaleString('es-MX')} (${response.porcentaje_prospectosTotales}%)`);
    $('#np_card').text(`${(response.prospNuevos).toLocaleString('es-MX')} (${response.porcentaje_prospectosNuevos}%)`);
    $('#va_card').text(`${(response.totalAT).toLocaleString('es-MX')} (${response.porcentaje_totalApartado}%)`);
    $('#ca_card').text(`${(response.totalCanA).toLocaleString('es-MX')} (${response.porcentaje_totalCanceladoapartado}%)`);
    $('#vc_card').text(`${(response.totalConT).toLocaleString('es-MX')} (${response.porcentaje_totalContratado}%)`);
    $('#cc_card').text(`${(response.totalCanC).toLocaleString('es-MX')} (${response.porcentaje_totalCanceladoContratado}%)`);
    $('#ct_card').text(`${(response.totalVentas).toLocaleString('es-MX')} (${response.porcentaje_totalVentas}%)`);
    $('#pcc_card').text(`${(response.prosCita).toLocaleString('es-MX')} (${response.porcentaje_prospectosCita}%)`);
};

function cleanValues2() {
    $('#ac').text('');
    $('#cf').text('');
    $('#cita').text('');
    $('#cs').text('');
    $('#ap').text('');
    $('#ni').text('');
};

function addTextFields2(response){
    $('#ac').text((response.totalProspectos).toLocaleString('es-MX'));
    $('#cf').text((response.totalMitadProceso).toLocaleString('es-MX'));
    $('#cita').text(`${(response.totalProspectosCita).toLocaleString('es-MX')} (${response.porcentaje_prospectosCita}%)`);
    $('#cs').text(`${(response.totalProspectosCitaSeguimiento).toLocaleString('es-MX')} (${response.porcentaje_prospectosSeguimiento}%)`);
    $('#ap').text(`${(response.totalApartados).toLocaleString('es-MX')} (${response.porcentaje_prospectosApartados}%)`);
    $('#ni').text(`${(response.prospectosNoInteresados).toLocaleString('es-MX')} (${response.porcentaje_prospectosNoInteresado}%)`);
};

function getThisWeek() {
    var curr = new Date; // get current date
    var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
    var last = first + 6; // last day is the first day + 6

    var firstday = new Date(curr.setDate(first));
    let inicio_semana = new Date(firstday.getFullYear(), firstday.getMonth(), firstday.getDate())
    inicio_semana = inicio_semana.toISOString().split('T')[0];

    var lastday = new Date(curr.setDate(last));
    let fin_semana = new Date(lastday.getFullYear(), lastday.getMonth(), lastday.getDate());
    fin_semana = fin_semana.toISOString().split('T')[0];
    return {fin_semana: fin_semana, inicio_semana: inicio_semana}
}

function setInitialValuesHome() {
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
    finalBeginDate2 = ['01', '01', beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');

    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('#beginDate2').val(finalBeginDate2);
    $('#endDate2').val(finalEndDate2);

}

function setInitialValues2() {
    // BEGIN DATE
    const fechaInicio2 = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio2.getFullYear(), fechaInicio2.getMonth(), 1);
    // END DATE
    const fechaFin2 = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin2.getFullYear(), fechaFin2.getMonth() + 1, 0);
    finalBeginDate3 = ['01', '01', beginDate.getFullYear()].join('/');
    finalEndDate3 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    $('#beginDate3').val(finalBeginDate3);
    $('#endDate3').val(finalEndDate3);
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

async function prospectsTable(){
    $('.table-dinamic').empty();
    let rol = userType == 2 ? await getRolDR(idUser): userType;
    let rolString;
    if (rol == '1' || rol == '18' || rol == '4' || rol == '63' || rol == '33' || rol == '58' || rol == '69' || rol == '72')
        rolString = 'director_regional';
    else if ( rol == '2' || (rol == '5' && ( idUser != '28' || idUser != '30' )))
        rolString = 'gerente';
    else if ( rol == '3' || rol == '6' )
        rolString = 'coordinador';
    else if ( rol == '59' || (rol == '5' && ( idUser == '28' || idUser == '30' )))
        rolString = 'subdirector';
    else
        rolString = 'asesor';

    const div = document.getElementById('prospects-section');

    if (div.classList.contains('openDiv')) {
        div.classList.remove('openDiv')
    } else {
        div.classList.add('openDiv');
        fillBoxAccordionsPR(rolString, rol == 18 || rol == '18' ? 1 : rol, idUser, 1, 1, null, [0, null, null, null, null, null, rol]);
        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues2();
    }
    $('#tablePR thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}"placeholder="${title}"/>`);
            $( 'input', this ).on('keyup change', function () {
            if ($('#tablePR').DataTable().column(i).search() !== this.value ) {
                $('#tablePR').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });
}

function getRolDR(idUser){
    return new Promise(resolve => {
        $.ajax({
            type: "POST",
            url: `${base_url}Reporte/getRolDR`,
            data: {idUser: idUser},
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#spiner-loader').removeClass('hide');
            },
            success: function(data){
                $('#spiner-loader').addClass('hide');
                resolve (data.length > 0 ? 59:2);
            },
            error: function() {
                $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
}

/* Función para cambiar icono y cerrar o abrir tabla*/

function changeIcon(anchor) {
    anchor.closest('.wrapper .boxTabla').classList.toggle('active');
    $(document).off('click', '.accordionToggle').on('click', '.accordionToggle', function () {
        $(this).parent().next().slideToggle(200);
        $(this).toggleClass('open', 200);
    });
}


function createAccordionsPR(option, render, rol) {
    let tittle = getTitle(option);
    let html = '';
    html = `<div class="bk ${render == 1 ? 'parentTable': 'childTable'}">
                <div class="card p-2 h-auto boxTabla">
                    <div class="d-flex justify-between align-center">
                        <div class="cursor-point accordionToggle">
                            <a class="purple-head hover-black" onclick="changeIcon(this)" id="myBtn">
                            <i class="less fas fa-angle-down"></i>
                            <i class="more fas fa-angle-up "></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="p-0 accordion-title js-accordion-title">`+tittle+`</h4>
                        </div>
                        <div class="cursor-point">
                            <a onClick="prospectsTable()">${render == 1 ? '': '<i class="fas fa-times deleteTable"></i>'}</a>
                        </div>
                    </div>
                    <div class="toolbar">
                        <div class="row">
                            <div id="filterContainer"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                                <div class="w-30">
                                    <div class="form-group d-flex m-0">
                                        <input type="text" class="form-control datepicker beginDates" id="beginDate3"  />
                                        <input type="text" class="form-control datepicker endDates" id="endDate3"  />
                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangePR">
                                            <span class="material-icons">search</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-content">
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover hide" id="tablePR">
                                        <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>TIPO</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>TELÉFONO</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    $(".table-dinamic").append(html);
}

function multirol(){
    //validar que tipo de usuario es el que está actualmente sesionado
    let items_activos = [];
    switch (userType) {
        case 1:
        case 4:
            if(idLider==2 || idLider==0){
                items_activos.push('subdirector');
                items_activos.push('gerente');
                items_activos.push('coordinadors');
                items_activos.push('asesors');
                createFilters(1, items_activos);
                loadSbdir();
            }
            break;
        case 2:
        case 5:
        case 59:
            $.post('../General/multirol', function(data){
                let unique = [...new Set(data.map(item => item.idRol))]; //los roles unicos del usuario
                if(unique.includes(59) || unique.includes(60)){
                    items_activos.push('subdirector');
                    items_activos.push('gerente');
                    items_activos.push('coordinadors');
                    items_activos.push('asesors');
                    loadSbdir();
                    createFilters(59, items_activos);
                    getFirstFilter(59, 2);
                }else{
                    items_activos.push('gerente');
                    items_activos.push('coordinadors');
                    items_activos.push('asesors');
                    createFilters(2, items_activos);
                    getFirstFilter(2, 3);
                }
            },'json');
            break;
        case 3:
        case 6:
            items_activos.push('coordinadors');
            items_activos.push('asesors');
            createFilters(1, items_activos);
            loadCoord();
            break;
        case 9:
            items_activos.push('asesors');
            createFilters(1, items_activos);
            loadAsesores();
            break;
        case 7:
            setInitialValues2();
            var url = "../Clientes/getProspectsListByAsesor/"+idUser;
            let finalBeginDate = $("#beginDate3").val();
            let finalEndDate = $("#endDate3").val();
            $('#tablePR thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}"placeholder="${title}"/>`);
                $( 'input', this).on( 'keyup change', function () {
                    if ($('#tablePR').DataTable().column(i).search() !== this.value ) {
                        $('#tablePR').DataTable().column(i).search(this.value).draw();
                    }
                });
            });
            updateTable(url, 1, finalBeginDate, finalEndDate, 0);
            break;
    }
}

function loadSbdir(){
    $("#subdirector").empty().selectpicker('refresh');
    $.post('../Clientes/getSubdirs/', function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#subdirector").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#subdirector").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#subdirector").selectpicker('refresh');
    }, 'json');
}

function loadCoord(){
    $("#coordinadors").empty().selectpicker('refresh');
    let id_usuario;
    if(userType==6){
        id_usuario = idLider;
    }else{
        id_usuario = idUser;
    }
    $.post('../Clientes/getCoordsByGrs/'+id_usuario, function(data) {
        var len = data.length;
        if(len<=0){
            $("#coordinadors").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }{
            $("#coordinadors").append('<option selected="selected">SELECCIONA UNA OPCIÓN</option>');
        }

        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinadors").append($('<option>').val(id).text(name));
        }
        $("#coordinadors").selectpicker('refresh');
    }, 'json');
}

function loadAsesores(){
    $("#asesor").empty().selectpicker('refresh');
    $.post('../Clientes/getAsesorByCoords/'+idUser, function(data) {
        var len = data.length;
        if(len<=0){
            $("#asesors").append('<option selected="selected" disabled>NINGUN COORDINADOR</option>');
        }
        else{
            $("#asesors").append('<option selected="selected">SELECCIONA UNA OPCIÓN</option>');
        }
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#asesors").append($('<option>').val(id).text(name));
        }

        $("#asesors").selectpicker('refresh');
    }, 'json');
}

function createSelect(dataDinamic){
    let nombreID = "div_"+dataDinamic;
    let dataMaks;
    //se cambiaron de cnombre porque chocaba con otros pickers en los js anidados
    if(dataDinamic=="coordinadors"){
        dataMaks = 'coordinador';
    }else if(dataDinamic=="asesors"){
        dataMaks = 'asesor';
    }else{
        dataMaks = dataDinamic;
    }

    let html_select ='<div class="col-md-3 form-group m-0"><div id="'+nombreID+'" class="form-group overflow-hidden"><label class="control-label">'+dataMaks.toUpperCase()+'</label></div></div>';
    var $selectSub = $('<select/>', {
        'class':"selectpicker select-gral m-0",
        'id': dataDinamic,
        'name': dataDinamic,
        'data-style':"btn",
        'data-show-subtext':"true",
        'data-live-search':"true",
        'data-container':"body",
        'title': 'SELECCIONA UNA OPCIÓN'
    });
        $('#filterContainer').append(html_select);

    return $selectSub;
}

function createFilters(rol, selects){
    selects.map((element, index)=>{
        let options_select = createSelect(element);
        options_select.appendTo("#div_"+element).selectpicker('refresh');
    });
}

function getFirstFilter(rol, secondRol){
    $(`#${rol == 59 ? 'subdirector':'gerente'}`).empty().selectpicker('refresh');
    $.post('../General/getUsersByLeader', {rol: rol, secondRol:secondRol},function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $(`#${rol == 59 ? 'subdirector':'gerente'}`).append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $(`#${rol == 59 ? 'subdirector':'gerente'}`).append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $(`#${rol == 59 ? 'subdirector':'gerente'}`).selectpicker('refresh');
    }, 'json');
}

function fillBoxAccordionsPR(option, rol, render) {
    if (rol == 5 && (idUser == 28 && idUser == 30))
        rolEspecial = 59;
    else if (rol == 5 && (idUser != 28 && idUser != 30))
        rolEspecial = 2;
    else if (rol == 6)
        rolEspecial = 3;
    else if (rol == 4 || rol == 33 || rol == 58 || rol == 63 || rol == 69)
        rolEspecial = 2
    else rolEspecial = rol;

    createAccordionsPR(option, render, rolEspecial);
    multirol();
}

function getTitle(option){
    var title;
    switch (option) {
        case 'director_regional':
            title = 'Reporte de prospectos por dirección regional';
            break;
        case 'gerente':
            title = 'Reporte de prospectos por gerencia';
            break;
        case 'coordinador':
            title = 'Reporte de prospectos por coordinación';
            break;
        case 'subdirector':
            title = 'Reporte de prospectos por subdirección';
            break;
        case 'asesor':
            title = 'Reporte de prospectos por asesor';
            break;
        default:
            title = 'N/A';
    }
    return title;
};

function newRoles(option) {
    var rol;
    switch (option) {
        case 'director_regional':
            rol = 59;
            break;
        case 'gerente':
            rol = 3;
            break;
        case 'coordinador':
            rol = 9;
            break;
        case 'subdirector':
            rol = 2;
            break;
        case 'asesor':
            rol = 7;
            break;
        default:
            rol = 'N/A';
    }
    return rol;
}

$(document).on('change','#subdirector', function () {
    var subdir = $("#subdirector").val();
    $("#gerente").empty().selectpicker('refresh');
    $("#coordinadors").empty().selectpicker('refresh');
    $("#asesor").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $('#filter_date').addClass('hide');
    $.post('../Clientes/getGerentesBySubdir/'+subdir, function(data) {
        var len = data.length;
        if(len<=0)
        {
            $("#gerente").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#gerente").append($('<option>').val(id).text(name));
        }

        $("#gerente").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

var gerente;
var coordinador;
var asesor;
$(document).on('change', '#gerente', function () {
    $('#filter_date').removeClass('hide');
    gerente = $("#gerente").val();
    $("#coordinadors").empty().selectpicker('refresh');
    $("#asesor").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');
    $.post('../Clientes/getCoordsByGrs/'+gerente, function(data) {
        var len = data.length;
        if(len<=0){
            $("#coordinadors").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#coordinadors").append($('<option>').val(id).text(name));
        }
        $("#coordinadors").selectpicker('refresh');
    }, 'json');
    /**///carga tabla
    var url = general_base_url+"Clientes/getProspectsListByGerente/"+gerente;
    let finalBeginDate = $("#beginDate3").val();
    let finalEndDate = $("#endDate3").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

$(document).on('change', '#coordinadors', function () {
    $('#spiner-loader').removeClass('hide');
    coordinador = $("#coordinadors").val();
    $('#filter_date').removeClass('hide');
    $("#asesor").empty().selectpicker('refresh');

    $.post('../Clientes/getAsesorByCoords/'+coordinador, function(data) {
        var len = data.length;
        if(len<=0)
        {
            $("#asesors").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }

        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
            $("#asesors").append($('<option>').val(id).text(name));
        }

        $("#asesors").selectpicker('refresh');
    }, 'json');


    /**///carga tabla
    var url = "../Clientes/getProspectsListByCoord/"+coordinador;
    let finalBeginDate = $("#beginDate3").val();
    let finalEndDate = $("#endDate3").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});

//asesor
$(document).on('change', '#asesors', function () {
    asesor = $("#asesors").val();

    var url = "../Clientes/getProspectsListByAsesor/"+asesor;
    let finalBeginDate = $("#beginDate3").val();
    let finalEndDate = $("#endDate3").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0);
});


var prospectsTables;
function updateTable(url, typeTransaction, beginDate, endDate, where){
    let oldDate = beginDate.split('/');
    let newDate = new Date(oldDate[1]+'-'+oldDate[0]+'-'+oldDate[2]).toISOString();
    newDate = new Date(newDate);
    let yearP = newDate.getFullYear();
    let monthP = ((newDate.getMonth()+1)<10) ? '0'+(newDate.getMonth()+1) : (newDate.getMonth()+1);
    let dayP = (newDate.getDate()<10) ? '0'+ newDate.getDate() : newDate.getDate();

    beginDate = dayP+'/'+monthP+'/'+yearP;

    let oldDateend = endDate.split('/');
    let newDateEnd = new Date(oldDateend[1]+'-'+oldDateend[0]+'-'+oldDateend[2]).toISOString();
    newDateEnd = new Date(newDateEnd);
    let yearPE = newDateEnd.getFullYear();
    let monthPE = ((newDateEnd.getMonth()+1)<10) ? '0'+(newDateEnd.getMonth()+1) : (newDateEnd.getMonth()+1);
    let dayPE = (newDateEnd.getDate()<10) ? '0'+ newDateEnd.getDate() : newDateEnd.getDate();
    endDate = dayPE+'/'+monthPE+'/'+yearPE;

    prospectsTables = $('#tablePR').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        ordering: false,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado general de prospectos',
                title:"Listado general de prospectos",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'ESTADO';
                                    break;
                                case 1:
                                    return 'ETAPA';
                                    break;
                                case 2:
                                    return 'TIPO';
                                    break;
                                case 3:
                                    return 'PROSPECTO';
                                case 4:
                                    return 'ASESOR';
                                    break;
                                case 5:
                                    return 'COORDINADOR';
                                    break;
                                case 6:
                                    return 'GERENTE';
                                    break;
                                case 7:
                                    return 'LUGAR PROSPECCIÓN';
                                    break;
                                case 8:
                                    return 'TELÉFONO';
                                    break;
                                case 9:
                                    return 'CREACIÓN';
                                    break;
                                case 10:
                                    return 'VENCIMIENTO';
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        autoWidth: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            { data: function (d) {
                if (d.estatus == 1)
                    return '<center><span class="label lbl-green">Vigente</span><center>';
                else
                    return '<center><span class="label lbl-warning">Sin vigencia</span><center>';
            } },
            { data: function (d) {
                if(d.estatus_particular == 1) // DESCARTADO
                    estatus_particular = 'Descartado';
                else if(d.estatus_particular == 2) // INTERESADO SIN CITA
                    estatus_particular = 'Interesado sin cita';
                else if (d.estatus_particular == 3) // CON CITA
                    estatus_particular = 'Con cita';
                else if (d.estatus_particular == 0 || d.estatus_particular == 4) // SIN ESPECIFICAR
                    estatus_particular = 'Sin especificar';
                else if (d.estatus_particular == 5) // PAUSADO
                    estatus_particular = 'Pausado';
                else if (d.estatus_particular == 6) // PREVENTA
                    estatus_particular = 'Preventa';
                else if (d.estatus_particular == 3) // CLIENTE
                    estatus_particular = 'Cliente';
                return `<center><span class="label lbl-violetBoots">${d.estatus_particular}</span><center>`;
            } },
            {   data: function (d) {
                if (d.tipo == 0){
                    return '<center><span class="label lbl-yellow">Prospecto</span></center>';
                } else {
                    return '<center><span class="label lbl-oceanGreen">Cliente</span></center>';
                }
            } },
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                    return d.asesor;
                }
            },
            { data: function (d) {
                    return d.coordinador;
                }
            },
            { data: function (d) {
                    return d.gerente;
                }
            },
            { data: function (d) {
                    return d.nombre_lp;
                }
            },
            {
                data: function (d) {
                    //telefono
                    let telefono = (d.telefono=='' || d.telefono==null)?'':d.telefono;
                    let telefono2 = (d.telefono_2==''||d.telefono_2==null)?'':d.telefono_2;
                    return telefono + '<br>' + telefono2;
                },
                visible: (userType==7) ? false : true
            },
            { data: function (d) {
                    return d.fecha_creacion;
                }
            },
            { data: function (d) {
                    return d.fecha_vencimiento;
                }
            }
        ],
        ajax: {
            url: url,
            dataSrc: "",
            cache: false,
            type: "POST",
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate,
                "where": where
            }
        },
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        drawCallback: function (settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    })
    $('#spiner-loader').addClass('hide');
    $('#tablePR').removeClass('hide');
}

$(document).on("click", "#searchByDateRangePR", function () {
    let finalBeginDate = $("#beginDate3").val();
    let finalEndDate = $("#endDate3").val();
    var url_inter;

    if(gerente != undefined && coordinador==undefined && asesor==undefined){
        url_inter = "../Clientes/getProspectsListByGerente/"+gerente;
    }else if(gerente != undefined && coordinador!=undefined && asesor==undefined){
        url_inter = "../Clientes/getProspectsListByCoord/"+coordinador;
    }else if(gerente != undefined && coordinador!=undefined && asesor!=undefined){
        url_inter = "../Clientes/getProspectsListByAsesor/"+asesor;
    }else if(gerente == undefined && coordinador==undefined && asesor!=undefined){
        url_inter = "../Clientes/getProspectsListByAsesor/"+asesor;
    }else if(gerente == undefined && coordinador==undefined && asesor==undefined){
        url_inter = "../Clientes/getProspectsListByAsesor/"+idUser;
    }else if(gerente == undefined && coordinador!=undefined && asesor!=undefined){
        url_inter = "../Clientes/getProspectsListByAsesor/"+asesor;
    }else if(gerente == undefined && coordinador!=undefined && asesor==undefined){
        url_inter = "../Clientes/getProspectsListByCoord/"+coordinador;
    }

    updateTable(url_inter, 3, finalBeginDate, finalEndDate, 0);
});