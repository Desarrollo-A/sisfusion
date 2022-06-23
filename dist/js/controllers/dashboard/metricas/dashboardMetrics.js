var optionBarInit = {
    series: [],
    chart: {
        type: 'bar',
        height: '100%',
        toolbar: {
            show: false
        },
    },
    colors: ['#0089B7', '#039590', '#00ACB8', '#4BBC8E', '#00CDA3', '#92E784', '#F9F871'],
    stroke: {
        colors: ['transparent'],
        width: 10,
    },
    plotOptions: {
        bar: {
            distributed: true, // this line is mandatory
            borderRadius: 4,
            horizontal: true,
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
            return opts.w.config.xaxis.categories[opts.dataPointIndex];
        },
        textAnchor: 'middle',
        offsetX: 0,
        offsetY: 0,
        style: {
            fontSize: '12px',
            fontFamily: 'Helvetica, Arial, sans-serif',
            fontWeight: 'bold',
        },
    },
    legend: {
        show: false,
    },
    xaxis: {
        categories: [],
    },
    yaxis: {
        show: false,
        labels: {
            show: false
        },
    }
};

var optionsDisponibilidad = {
    series: [],
    chart: {
        height: '100%',
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    plotOptions: {
        bar: {
            distributed: true,
            horizontal: true,
        }
    },
    colors: ['#0089B7', '#039590', '#00ACB8', '#4BBC8E', '#00CDA3', '#92E784', '#F9F871'],
    stroke: {
        colors: ['transparent'],
        width: 10,
    },
    dataLabels: {
        formatter: function (val, opt) {
            const goals =
                opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                .goals

            if (goals && goals.length) {
                return `${val} / ${goals[0].value}`
            }
            return val
        }
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
    },
};

var optionLugar = {
    series: [{
        name: '',
        data: []
    }],
    chart: {
        type: 'bar',
        height: '100%',
        toolbar: {
            show: false
        },
    },
    colors: ['#0089B7', '#039590', '#00ACB8', '#4BBC8E', '#00CDA3', '#92E784', '#F9F871'],
    stroke: {
        colors: ['transparent'],
        width: 5,
    },
    plotOptions: {
        bar: {
            distributed: true, // this line is mandatory
            borderRadius: 4,
            horizontal: true,
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
            return opts.w.config.xaxis.categories[opts.dataPointIndex];
        },
        textAnchor: 'middle',
        offsetX: 0,
        offsetY: 0,
        style: {
            fontSize: '12px',
            fontFamily: 'Helvetica, Arial, sans-serif',
            fontWeight: 'bold',
        },
    },
    legend: {
        show: false,
    },
    xaxis: {
        categories: [],
    },
    yaxis: {
        show: false,
        labels: {
            show: false
        },
    }
};

var optionsMedio = {
    series: [],
    chart: {
        height: '100%',
        type: 'donut',
        toolbar: {
            show: false
        },
    },
    colors: ['#0089B7', '#039590', '#00ACB8', '#4BBC8E', '#00CDA3', '#92E784', '#F9F871'],
    dataLabels: {
        enabled: true,
        formatter: function (val) {
          return ''
        }
      },
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};

var optionsVentasMetros = {
    series: [],
    chart: {
        toolbar: {
            show: false
        },
        height: '100%',
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
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
    },
    tooltip: {
      show: false
    },
};

var optionsDescuentos = {
    series: [{
        name: 'Inflation',
        data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
    }],
    chart: {
        height: '100%',
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    plotOptions: {
        bar: {
            borderRadius: 10,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function (val) {
            return val + "%";
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },

    xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        position: 'top',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        }
    },
    yaxis: {
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false,
        },
        labels: {
            show: false,
            formatter: function (val) {
                return val + "%";
            }
        }

    },
};

var metrosChart = new ApexCharts(document.querySelector("#metrosChart"), optionBarInit);
metrosChart.render();

var disponibilidadChart = new ApexCharts(document.querySelector("#disponibilidadChart"), optionsDisponibilidad);
disponibilidadChart.render();

var lugarChart = new ApexCharts(document.querySelector("#lugarChart"), optionLugar);
lugarChart.render();

var medioChart = new ApexCharts(document.querySelector("#medioChart"), optionsMedio);
medioChart.render();

var ventasMetrosChart = new ApexCharts(document.querySelector("#ventasMetrosChart"), optionsVentasMetros);
ventasMetrosChart.render();

var descuentosChart = new ApexCharts(document.querySelector("#descuentosChart"), optionsDescuentos);
descuentosChart.render();

//Jquery
$(document).ready(function () {
    console.log("JS Metrics");
    init();
});
//Funciones
function init(){
    getSuperficieVendida();
    getDisponibilidadProyecto();
    getLugarProspeccion();
    getMedioProspeccion();
    getVentasM2();
    // getDescuentosChart();
}

function getSuperficieVendida(){
    $.ajax({
        url: "Metricas/getSuperficieVendida",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            formatMetrosData(response);
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getDisponibilidadProyecto(){
    $.ajax({
        url: "Metricas/getDisponibilidadProyecto",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            formatDisponibilidadData(response);
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getLugarProspeccion(){
    $.ajax({
        url: "Metricas/getLugarProspeccion",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            formatLugarProspeccion(response);
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getMedioProspeccion(){
    $.ajax({
        url: "Metricas/getMedioProspeccion",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            formatMedioProspeccion(response);
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getVentasM2(){
    $.ajax({
        url: "Metricas/getVentasM2",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            formatVentasM2(response);
            $('#spiner-loader').addClass('hide');
        }
    });
}

function formatMetrosData(data){
    let series =[] , categories = [];
    let count = 0;
    data.forEach(element => {
        if (count < 6) {
            series.push(element.counts);
            categories.push(`${element.sup} m2`);
            count++;
        }
    });

    metrosChart.updateSeries([{
        name: '#',
        data: series
    }])

    metrosChart.updateOptions({
        xaxis: {
           categories: categories
        },
     });
}

function formatDisponibilidadData(data){
    let series =[];
    let count = 0;
    data.forEach(element => {
        if (count < 10) {
            series.push({
                x: element.nombreResidencial,
                y: element.ocupados,
                goals: [{
                    name: 'Disponible',
                    value: element.totales,
                    strokeWidth: 2,
                    strokeHeight: 10,
                    strokeColor: '#775DD0'
                }]
            });
            count++;
        }
    });

    disponibilidadChart.updateSeries([{
        name: 'Ocupado',
        data: series
    }])
}

function formatLugarProspeccion(data){
    let series =[] ,series2 =[], categories = [];
    let count = 0;
    data.forEach(element => {
        if (count < 6) {
            series.push(element.prospectos);
            series2.push(element.clientes);
            categories.push(`${element.nombre}`);
            count++;
        }
    });

    lugarChart.updateSeries([{
        name: 'Prospectos',
        data: series
    },
    {
        name: 'Clientes',
        data: series2
    }])

    lugarChart.updateOptions({
        xaxis: {
           categories: categories
        },
     });
}

function formatMedioProspeccion(data){
    let series =[] , categories = [];
    let count = 0;
    data.forEach(element => {
        if (count < 6) {
            series.push(
                element.cantidad
            );
            categories.push(`${element.nombre}`);

            count++;
        }
    });
    medioChart.updateOptions({
        series: series,
        labels: categories
     });
}

function formatVentasM2(data){
    let series =[] , categories = [];
    data.forEach(element => {
            series.push(element.cantidad);
            categories.push(`${element.sup} m2`);
    });
    ventasMetrosChart.updateSeries([{
        name: '#',
        data: series
    }])

    ventasMetrosChart.updateOptions({
        xaxis: {
           categories: categories
        },
     });
}