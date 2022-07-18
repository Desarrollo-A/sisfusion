var dataMetros, dataDisponibilidad, dataLugarProspeccion, dataMedio, metrosChart, disponibilidadChart, lugarChart, medioChart;

var optionBarInit = {
    series: [],
    chart: {
        type: 'bar',
        height: 'auto',
        toolbar: {
            show: false
        },
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    stroke: {
        colors: ['transparent'],
        width: 0,
    },
    plotOptions: {
        bar: {
            distributed: true, // this line is mandatory
            borderRadius: 10,
            horizontal: true,
            barHeight: '45%',
        }
    },
    dataLabels: {
        formatter: function (val, opt) {
            const goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex].goals;

            if (goals && goals.length) {
                return `${val.toLocaleString('es-MX')} / ${(goals[0].value).toLocaleString('es-MX')}`
            }
            return val.toLocaleString('es-MX')
        },
    },
    legend: {
        show: false,
    },
    xaxis: {
        show: false,
        labels: {
            show: true
        },
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
    },
    yaxis: {
        show: true,
        labels: {
            show: true
        },
    },
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
    tooltip: { 
        enabled: true,
        y: {
            formatter: (value) =>  value.toLocaleString('es-MX'),
        },
    },
};

var optionsDisponibilidad = {
    series: [],
    chart: {
        height: 'auto',
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    plotOptions: {
        bar: {
            distributed: true,
            horizontal: true,
            barHeight: '70%',
            borderRadius: 10
        }
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    stroke: {
        colors: ['transparent'],
        width: 0,
    },
    dataLabels: {
        formatter: function (val, opt) {
            const goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex].goals;

            if (goals && goals.length) {
                return `${val.toLocaleString('es-MX')} / ${(goals[0].value).toLocaleString('es-MX')}`
            }
            return val.toLocaleString('es-MX')
        },
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
    tooltip: { 
        enabled: true,
        y: {
            formatter: (value) =>  value.toLocaleString('es-MX'),
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
        height: 'auto',
        toolbar: {
            show: false
        },
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    stroke: {
        colors: ['transparent'],
        width: 5,
    },
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 10,
            barHeight: '100%',
            distributed: false,
            dataLabels: {
                show: true
            },
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function (val, opts) {
            return val.toLocaleString('es-MX');
        },
    },
    legend: {
        show: false,
    },
    xaxis: {
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false,
        },
        labels: {
            show: false,
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
            show: true,
            formatter: function (val) {
                return val;
            },
            style: {
                colors: []
            }
        }
    },
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
    tooltip: { 
        enabled: true,
        y: {
            formatter: (value) =>  value.toLocaleString('es-MX'),
        },
    },
};

var optionsMedio = {
    series: [],
    chart: {
        height: 'auto',
        type: 'polarArea',
        toolbar: {
            show: false
        },
    },
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    dataLabels: {
        enabled: false,
        formatter: function (val) {
          return val.toLocaleString('es-MX');
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
    }],
    tooltip: { 
        enabled: true,
        y: {
            formatter: (value) =>  value.toLocaleString('es-MX'),
        },
    },
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
    colors: ['#103F75', '#006A9D', '#0089B7', '#039590', '#008EAB', '#00ACB8', '#16C0B4', '#4BBC8E', '#00CDA3', '#92E784'],
    dataLabels: {
        enabled: false,
        formatter: function (val) {
            return val.toLocaleString('es-MX');
        }
    },
    stroke: {
        width: 2,
        curve: 'smooth',
        opacity: 0.7
    },
    legend: {
        show: false,
    },
    xaxis: {
        show: true,
    },
    tooltip: {
      show: false
    },
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
    tooltip: { 
        enabled: true,
        y: {
            formatter: (value) =>  value.toLocaleString('es-MX'),
        },
    },
};

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    initMetrics();
});

$('#proyecto').off().on('change', function(){
    getCondominios($(this).val());
});

$('#condominio').off().on('change', function(){
    getVentasM2($(this).val());
});

//Funciones
function initMetrics(){
    recreatApexChartMetrics(false);
    getProyectos();
    getSuperficieVendida().then( response => {
        dataMetros = response;
        formatMetrosData( dataMetros );     
    });
    getDisponibilidadProyecto().then( response => {
        dataDisponibilidad = response;
        formatDisponibilidadData(dataDisponibilidad);
    });
    getLugarProspeccion().then( response => {
        dataLugarProspeccion = response;
        formatLugarProspeccion(dataLugarProspeccion);
    });
    getMedioProspeccion().then( response => { 
        dataMedio = response;
        formatMedioProspeccion(dataMedio);
    });
}

function getSuperficieVendida(){
    return $.ajax({
        url: `${base_url}Metricas/getSuperficieVendida`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getDisponibilidadProyecto(){
    return $.ajax({
        url: `${base_url}Metricas/getDisponibilidadProyecto`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getLugarProspeccion(){
    return $.ajax({
        url: `${base_url}Metricas/getLugarProspeccion`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getMedioProspeccion(){
    return $.ajax({
        url: `${base_url}Metricas/getMedioProspeccion`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getVentasM2(idCond){
    $('.emptyVentasMetrosChart').addClass('d-none');
    $('.loadVentasMetrosChart').removeClass('d-none');
    $.ajax({
        url: `${base_url}Metricas/getVentasM2`,
        data: {condominio: idCond},
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            formatVentasM2(response);
            $('.loadVentasMetrosChart').addClass('d-none');
        }
    });
}

function formatMetrosData(data){
    $('.loadMetrosChart').addClass('d-none');
    let series =[], categories = [];
    let count = 0;
    data.forEach(element => {
        if (count < 6) {
            series.push(element.cantidad);
            categories.push(`${element.superficie} m2`);
            count++;
        }
    });

    metrosChart.updateSeries([{
        name: 'Cantidad',
        data: series
    }])

    metrosChart.updateOptions({
        xaxis: {
           categories: categories
        },
    });
}

function formatDisponibilidadData(data){
    $('.loadDisponibilidadChart').addClass('d-none');
    let series =[];
    let count = 0;
    data.forEach(element => {
        if (count < 10) {
            series.push({
                x: element.nombreResidencial,
                y: element.ocupados,
                goals: [{
                    name: 'Total',
                    value: element.totales,
                    strokeWidth: 2,
                    strokeHeight: 10,
                    strokeColor: '#775DD0'
                },
                {   
                    name: 'Disponible',
                    value: element.restante,
                    strokeWidth: 0,
                    strokeHeight: 0,
                    strokeColor: '#FFFFFF'
                }]
            });
            count++;
        }
    });

    disponibilidadChart.updateSeries([{
        name: 'Vendido',
        data: series
    }])
}

function formatLugarProspeccion(data){
    $('.loadLugarChart').addClass('d-none');
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
    $('.loadMedioChart').addClass('d-none');
    let series =[] , categories = [];
    let count = 0;
    data.forEach(element => {
        if (count < 6) {
            series.push( element.cantidad );
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
        categories.push(`(${element.sup} m2)`);
    });
    ventasMetrosChart.updateSeries([{
        name: 'No. de lotes: ',
        data: series
    }])

    ventasMetrosChart.updateOptions({
        xaxis: {
           categories: categories
        },
    });
}

function toggleDatatableMetrics(e){
    var columnaActiva = e.closest( '.flexibleM' );
    var columnaChart = e.closest( '.col-chart' );
    var columnDatatable = $( e ).closest( '.row' ).find( '.col-datatable' );
    $( columnDatatable ).html('');
    // La columna se expandera
    if( $(columnaActiva).hasClass('inactivo') ){
        columnaActiva.classList.remove('col-lg-6', 'inactivo');
        columnaActiva.classList.add('col-lg-12', 'activo');
        columnaChart.classList.remove('col-lg-12');
        columnaChart.classList.add('col-lg-6');
        columnDatatable.removeClass('hidden');
        reorderColumnsMetrics();
    }
    // La columna se contraera
    else{
        columnaActiva.classList.remove('col-lg-12', 'activo');
        columnaActiva.classList.add('col-lg-6', 'inactivo');
        columnaChart.classList.remove('col-lg-6');
        columnaChart.classList.add('col-lg-12');
        columnDatatable.addClass('hidden');
        reorderColumnsMetrics();
    }
}

function reorderColumnsMetrics(){
    var principalColumns = document.getElementsByClassName("flexibleM");
    var mainRow = document.getElementById('mainRowMetrics');

    let opts = getCacheOptions();
    //Creamos nuevo fragmento en el DOM para insertar las columnas ordenadas
    var elements = document.createDocumentFragment();
    var inactivos = [], activos = [];

    for( var i = 0; i<principalColumns.length; i++){
        (principalColumns[i].classList.contains('inactivo')) ? inactivos.push(i) : activos.push(i);
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

    recreatApexChartMetrics(true, opts);

    for( i = 1; i<=principalColumns.length; i++){
        (function(i){
            setTimeout(function(){
                $(principalColumns[i-1]).removeClass('hidden');
                if($(principalColumns[i-1]).hasClass('activo')){
                    var columnDatatable = $( principalColumns[i-1]).find('.col-datatable');
                    var id = columnDatatable.attr('id');
                    $("#"+id).html('');
                    if( id == 'metros' ){
                        buildEstructuraDTMetrics(id, dataMetros);
                        buildTableMetros(dataMetros);
                    }
                    else if( id == 'disponibilidad' ){
                        buildEstructuraDTMetrics(id, dataDisponibilidad);
                        buildTableDisponibilidad(dataDisponibilidad);
                    }
                    else if( id == 'lugar' ){
                        buildEstructuraDTMetrics(id, dataLugarProspeccion);
                        buildTableLugarProspeccion(dataLugarProspeccion);
                    }
                    else if( id == 'medio' ){
                        buildEstructuraDTMetrics(id, dataMedio);
                        buildTableMedio(dataMedio);
                    }
                }
                $(principalColumns[i-1]).addClass('fadeInAnimationDelay'+i);
            }, 500 * i)
        }(i));
    }
    $('[data-toggle="tooltip"]').tooltip();
}

function buildEstructuraDTMetrics(dataName, dataApartados){
    var tableHeaders = '';
    var arrayHeaders = Object.keys(dataApartados[0]);
    for( i=0; i<arrayHeaders.length; i++ ){
        tableHeaders += '<th>' + arrayHeaders[i] + '</th>';
    }

    var id = 'table'+dataName;
    var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
                        <table class="table-striped table-hover" id="`+id+`" name="table">
                            <thead>
                                <tr>
                                    `+tableHeaders+`
                                </tr>
                            </thead>
                        </table>
                    </div>`;
    $("#"+dataName).html(estructura);
}

function getCondominios(idProyecto){
    $("#condominio").empty();
    $.ajax({
        url: `${base_url}Metricas/getCondominios`,
        data:{proyecto: idProyecto},
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            response.forEach(element => {
                $("#condominio").append($(`<option data-name='${element.idCondominio}'>`).val(element.idCondominio).text(element.nombre_condominio));
            });
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getProyectos(){
    $("#proyecto").empty();
    $.ajax({
        url: `${base_url}Metricas/getProyectos`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            response.forEach(element => {
                $("#proyecto").append($(`<option data-name='${element.nombreResidencial}'>`).val(element.idResidencial).text(element.descripcion));
            });
            $("#proyecto").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
    });
}

function buildTableMetros(data){
    $('#tablemetros thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tablemetros").DataTable().column(i).search() !== this.value) {
                $("#tablemetros").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tablemetros").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'cantidad'
        },
        {
            data: 'superficie'
        },
        {
            data: 'suma'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableDisponibilidad(data){
    $('#tabledisponibilidad thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tabledisponibilidad").DataTable().column(i).search() !== this.value) {
                $("#tabledisponibilidad").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tabledisponibilidad").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'nombreResidencial'
        },
        {
            data: 'descripcion'
        },
        {
            data: 'totales'
        },
        {
            data: 'ocupados'
        },
        {
            data: 'restante'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableLugarProspeccion(data){
    $('#tablelugar thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tablelugar").DataTable().column(i).search() !== this.value) {
                $("#tablelugar").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tablelugar").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'nombre'
        },
        {
            data: 'prospectos'
        },
        {
            data: 'clientes'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableMedio(data){
    $('#tablemedio thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tablemedio").DataTable().column(i).search() !== this.value) {
                $("#tablemedio").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tablemedio").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: `${base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'nombre'
        },
        {
            data: 'lugar_prospeccion'
        },
        {
            data: 'cantidad'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function getCacheOptions(){
    let obj = {
        seriesMetros: metrosChart.w.config.series,
        categoriesMetros: metrosChart.w.config.xaxis.categories,
        
        seriesDisponibilidad: disponibilidadChart.w.config.series,
        categoriesDisponibilidad: disponibilidadChart.w.config.xaxis.categories,
        
        seriesLugar: lugarChart.w.config.series,
        categoriesLugar: lugarChart.w.config.xaxis.categories,
        
        seriesMedio: medioChart.w.config.series,
        categoriesMedio: medioChart.w.config.xaxis.categories,
    }
    return obj;
}

function recreatApexChartMetrics(estado){
    if(estado){
        $(".boxChartMetrics").html('');
        buildChartsIDMetrics();
      
        metrosChart = new ApexCharts(document.querySelector("#metrosChart"), optionBarInit);
        metrosChart.render();
        formatMetrosData( dataMetros );     
    
        disponibilidadChart = new ApexCharts(document.querySelector("#disponibilidadChart"), optionsDisponibilidad);
        disponibilidadChart.render();
        formatDisponibilidadData(dataDisponibilidad);

        lugarChart = new ApexCharts(document.querySelector("#lugarChart"), optionLugar);
        lugarChart.render();
        formatLugarProspeccion(dataLugarProspeccion);

        medioChart = new ApexCharts(document.querySelector("#medioChart"), optionsMedio);
        medioChart.render();
        formatMedioProspeccion(dataMedio);
    }
    else{
        metrosChart = new ApexCharts(document.querySelector("#metrosChart"), optionBarInit);
        metrosChart.render();        
        
        disponibilidadChart = new ApexCharts(document.querySelector("#disponibilidadChart"), optionsDisponibilidad);
        disponibilidadChart.render();

        lugarChart = new ApexCharts(document.querySelector("#lugarChart"), optionLugar);
        lugarChart.render();

        medioChart = new ApexCharts(document.querySelector("#medioChart"), optionsMedio);
        medioChart.render();

        ventasMetrosChart = new ApexCharts(document.querySelector("#ventasMetrosChart"), optionsVentasMetros);
        ventasMetrosChart.render();
    }
}

function buildChartsIDMetrics(){
    var boxCharts = document.getElementsByClassName("boxChartMetrics");
    for ( var i = 0; i<boxCharts.length; i++ ){
        var id = boxCharts[i].id;
        let type = boxCharts[i].getAttribute('data-value');
        let  html = `<div id="`+type+`Chart"></div>`;
        $('#'+id).append(html);
    }
}