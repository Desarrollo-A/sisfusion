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
                        let val = parseInt((w.globals.labels[0]).split(": ")[1]);
                        return `Gran total: ${val.toLocaleString('es-MX')}`;
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
        formatter: function(w){
            console.lo(w);
        },
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

var totalVentasChart = new ApexCharts(document.querySelector("#totalVentasChart"), optionsTotalVentas);
totalVentasChart.render();

var prospectosChart = new ApexCharts(document.querySelector("#prospectosChart"), optionsProspectos);
prospectosChart.render();

var chartProspClients = new ApexCharts(document.querySelector("#chartProspClients"), optionsProspClients);
chartProspClients.render();

var chartWeekly = new ApexCharts(document.querySelector("#chartWeekly"), optionsWeekly);
chartWeekly.render();

var chartFunnel = new ApexCharts(document.querySelector("#chartFunnel"), optionsFunnel);
chartFunnel.render();

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

// jquery
$(document).ready(function(){
    rol != 9 ? $('#buttonsCoord').hide():'';
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
    loadInit();
});

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
                `Gran total: ${response.totalVentas}`,
                `Contratado: ${response.totalConT}`,
                `Apartado: ${response.totalAT}`,
                `Cancelado: ${response.totalCT}`
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
    $('#pt_card').text((response.prospTotales).toLocaleString('es-MX'));
    $('#np_card').text((response.prospNuevos).toLocaleString('es-MX'));
    $('#va_card').text((response.totalAT).toLocaleString('es-MX'));
    $('#ca_card').text((response.totalCanA).toLocaleString('es-MX'));
    $('#vc_card').text((response.totalConT).toLocaleString('es-MX'));
    $('#cc_card').text((response.totalCanC).toLocaleString('es-MX'));
    $('#ct_card').text((response.totalVentas).toLocaleString('es-MX'));
    $('#pcc_card').text((response.prosCita).toLocaleString('es-MX'));
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
    $('#cita').text((response.totalProspectosCita).toLocaleString('es-MX'));
    $('#cs').text((response.totalProspectosCitaSeguimiento).toLocaleString('es-MX'));
    $('#ap').text((response.totalApartados).toLocaleString('es-MX'));
    $('#ni').text((response.prospectosNoInteresados).toLocaleString('es-MX'));
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
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');

    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('#beginDate2').val(finalBeginDate2);
    $('#endDate2').val(finalEndDate2);
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