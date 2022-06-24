var dataMetros, dataDisponibilidad, dataLugarProspeccion, dataMedio, metrosChart, disponibilidadChart, lugarChart, medioChart;

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
    init();
});
//Funciones
function init(){
    getSuperficieVendida();
    getDisponibilidadProyecto();
    getLugarProspeccion();
    getMedioProspeccion();
    getVentasM2();

    // getSuperficieVendida().then( response => { dataMetros = response });
    // getDisponibilidadProyecto().then( response => { dataDisponibilidad = response });
    // getLugarProspeccion().then( response => { dataLugarProspeccion = response });
    // getMedioProspeccion().then( response => { dataMedio = response });
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

function toggleDatatable(e){
    var columnaActiva = e.closest( '.flexible' );
    var columnaChart = e.closest( '.col-chart' );
    var columnDatatable = $( e ).closest( '.row' ).find( '.col-datatable' );
    $( columnDatatable ).html('');
    // La columna se expandera
    if( $(columnaActiva).hasClass('inactivo') ){
        columnaActiva.classList.remove('col-sm-6', 'col-md-6', 'col-lg-6', 'inactivo');
        columnaActiva.classList.add('col-sm-12', 'col-md-12', 'col-lg-12', 'activo');
        columnaChart.classList.remove('col-sm-12', 'col-md-12', 'col-lg-12');
        columnaChart.classList.add('col-sm-6', 'col-md-6', 'col-lg-6');
        columnDatatable.removeClass('hidden');
        reorderColumns();
    }
    // La columna se contraera 
    else{
        columnaActiva.classList.remove('col-sm-12', 'col-md-12', 'col-lg-12', 'activo');
        columnaActiva.classList.add('col-sm-6', 'col-md-6', 'col-lg-6', 'inactivo');
        columnaChart.classList.remove('col-sm-12', 'col-md-6', 'col-lg-6');
        columnaChart.classList.add('col-sm-12', 'col-md-12', 'col-lg-12');
        columnDatatable.addClass('hidden');
        reorderColumns();
    }
}
// function toggleDatatable(e){
//     var columnaActiva = e.closest( '.flexible' );
//     var columnaChart = e.closest( '.col-chart' );
//     var columnDatatable = $( e ).closest( '.row' ).find( '.col-datatable' );
//     $( columnDatatable ).html('');
//     if( $(columnaActiva).hasClass('inactivo') ){
//         columnaActiva.classList.remove('inactivo')
//         columnaChart.classList.remove('col-sm-12', 'col-md-12', 'col-lg-12');
        
//         //Función para obtener clases de columna pivote
//         var arrayColumns = nomenclatureBootstrap(columnaActiva);
//         console.log(arrayColumns);
//         arrayColumns.forEach(function(key, index){    
//             columnaActiva.classList.remove(''+key+'');
//             columnaChart.classList.add();
//             columnaChart.classList.add(''+key+'');
//         });
//         columnaActiva.classList.add('col-sm-12', 'col-md-12', 'col-lg-12', 'activo', 'flexible');
//         columnDatatable.removeClass('hidden');
//         reorderColumns();
//     }
//     else{
//         console.log("inactivar");
//         console.log(  e.closest( '.flexible' ) );
//         columnaActiva.classList.remove('col-sm-12', 'col-md-12', 'col-lg-12', 'activo');
//         columnaActiva.classList.add('inactivo')

//         var arrayColumns = nomenclatureBootstrap(columnaChart);
//         console.log(arrayColumns);
//         arrayColumns.forEach(function(key, index){    
//             columnaActiva.classList.add(''+key+'');
//             columnaChart.classList.remove(''+key+'');
//         });

//         columnaChart.classList.add('col-sm-12', 'col-md-12', 'col-lg-12', 'col-chart', 'h-100', 'pb-3');
//         columnDatatable.addClass('hidden');
//         // reorderColumns()
//     }
// }

// function nomenclatureBootstrap(columna){
//     reg = /flexible|inactivo|acivo|col-chart/i; 
//     var classes = ($(columna).attr('class'));
//     console.log(classes);
//     var colBootstrap = classes.replace(reg, ""); 
//     colBootstrap = colBootstrap.replace(/h-100/g,'');
//     colBootstrap = colBootstrap.replace(/pb-3/g,'');
//     colBootstrap = colBootstrap.replace(/col-12/g,'');
//     colBootstrap = colBootstrap.replace(/\s+/g,' ').trim()
//     var arrayColumns = (colBootstrap.rtrim()).split(/[, ]+/);

//     return arrayColumns;
// }



function reorderColumns(){
    var principalColumns = document.getElementsByClassName("flexible");
    var mainRow = document.getElementById('mainRow');

    //Creamos nuevo fragmento en el DOM para insertar las columnas ordenadas
    var elements = document.createDocumentFragment();
    var inactivos = [], activos = [];
    
    for( var i = 0; i<principalColumns.length; i++){
        (principalColumns[i].classList.contains('inactivo')) ? inactivos.push(i) : activos.push(i)
    }

    //Array con orden correcto de columnas primero las activas y después inactivas
    var orden = activos.concat(inactivos);
    orden.forEach(idx => {
        if($(principalColumns[idx]).hasClass('inactivo')){
            principalColumns[idx].classList.add('hidden');
        }
        elements.appendChild(principalColumns[idx].cloneNode(true));
    });
    mainRow.innerHTML = null;
    mainRow.appendChild(elements);
    
    // recreatApexChart(true);

    for( i = 1; i<=principalColumns.length; i++){
        (function(i){
            setTimeout(function(){
                $(principalColumns[i-1]).removeClass('hidden');
                if($(principalColumns[i-1]).hasClass('activo')){
                    var columnDatatable = $( principalColumns[i-1]).find('.col-datatable');
                    var id = columnDatatable.attr('id');
                    $("#"+id).html('');
                    if( id == 'metros' ){
                        buildEstructuraDT(id, dataMetros);
                        buildTableMetros(dataApartados);
                    }
                    else if( id == 'disponibilidad' ){
                        buildEstructuraDT(id, dataDisponibilidad);
                        buildTableDisponibilidad(dataContratados);
                    }
                    else if( id == 'lugar' ){
                        buildEstructuraDT(id, dataLugarProspeccion);
                        buildTableLugarProspeccion(dataConEnganche);
                    }
                    else if( id == 'medio' ){
                        buildEstructuraDT(id, dataMedio);
                        buildTableMedio(dataSinEnganche);
                    }
                }
                $(principalColumns[i-1]).addClass('fadeInAnimationDelay'+i);
            }, 500 * i)
        }(i));
    }   
}

function buildEstructuraDT(dataName, data){
    var tableHeaders = '';
    var arrayHeaders = Object.keys(data[0]);
    console.log(data);
    // for( i=0; i<arrayHeaders.length; i++ ){
    //     tableHeaders += '<th>' + arrayHeaders[i] + '</th>';
    // }

    // var id = 'table'+dataName;
    // var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
    //                     <table class="table-striped table-hover" id="`+id+`" name="table">
    //                         <thead>
    //                             <tr>
    //                                 `+tableHeaders+`
    //                             </tr>
    //                         </thead>
    //                     </table>
    //                 </div>`;
    // $("#"+dataName).html(estructura);
}

// String.prototype.rtrim = function () {
//     return this.replace(/((\s*\S+)*)\s*/, "$1");
// }