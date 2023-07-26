var dataMetros, dataDisponibilidad, dataLugarProspeccion, dataMedio, metrosChart, disponibilidadChart, lugarChart, medioChart, promedioMetrosChart, dataPromedio, dataSedes;

var optionBarInit = {
    series: [],
    chart: {
        type: 'bar',
        height: '100%',
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
        height: '100%',
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
        height: '100%',
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
        breakpoint: 500,
        options: {
            chart: {
                height: '100%'
            },
            legend:{
                show:false
            },
            yaxis: {
                show: false
            },
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

var optionsPromedio = {
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
            formatter: function(value){
                return `$${value.toLocaleString('es-MX')}`
            }
        }
    },
};


function readyMetrics(){
    $('[data-toggle="tooltip"]').tooltip();
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValuesMetrics();
    initMetrics();
}

$('#proyecto').off().on('change', function(){
    getCondominios($(this).val());
});

$('#condominio').off().on('change', function(){
    getVentasM2($(this).val());
});

$('#sedes').off().on('change', function(){
    getProyectos($(this).val());
    getPromedio($(this).val(), null, formatDate($('#tableBegin_promedio').val()),formatDate($('#tableEnd_promedio').val())).then( response => { 
        dataPromedio = response;
        formatPromedio(dataPromedio);
    });
});

$('#proyecto2').off().on('change', function(){
    getPromedio($('#sedes').val(), $(this).val(), formatDate($('#tableBegin_promedio').val()),formatDate($('#tableEnd_promedio').val())).then( response => { 
        dataPromedio = response;
        formatPromedio(dataPromedio);
    });
});
$('#searchByDateRangePromedio').off().on('click', function(){
    getPromedio($('#sedes').val(), $('#proyecto2').val(), formatDate($('#tableBegin_promedio').val()),formatDate($('#tableEnd_promedio').val())).then( response => { 
        dataPromedio = response;
        formatPromedio(dataPromedio);
    });
});


$(document).on('click', '.btnModalDetailsMetricas', function () {
    let dataObj = {
        sede_residencial: $('#sedes').val(),
        idResidencial: $('#proyecto2').val(),
        begin: formatDate($('#tableBegin_promedio').val()), 
        end: formatDate($('#tableEnd_promedio').val())
    }
    fillTableMetrics(dataObj);
    $("#seeLotesDetailModalMetricas").modal();
});



//Funciones
function initMetrics(){
    recreatApexChartMetrics(false);
    getProyectos();
    getSedes();
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

    getPromedio(null, null, formatDate($('#tableBegin_promedio').val()),formatDate($('#tableEnd_promedio').val())).then( response => { 
        dataPromedio = response;
        formatPromedio(dataPromedio);
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
    let dates = getCacheDates();
    let selects = getCacheSelectedOptions();
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
    buildDatePikcer(dates);
    buildSelect(selects, dataSedes);

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
                        buildEstructuraDTMetros(id);
                        buildTableMetros(dataMetros);
                    }
                    else if( id == 'disponibilidad' ){
                        buildEstructuraDTDisponibilidad(id);
                        buildTableDisponibilidad(dataDisponibilidad);
                    }
                    else if( id == 'lugar' ){
                        buildEstructuraDTLP(id);
                        buildTableLugarProspeccion(dataLugarProspeccion);
                    }
                    else if( id == 'medio' ){
                        buildEstructuraDTMedio(id);
                        buildTableMedio(dataMedio);
                    } else if( id == 'promedio' ){
                        buildEstructuraDTMetrics(id, dataPromedio);
                        buildTablePromedio(dataPromedio);
                    }
                }
                $(principalColumns[i-1]).addClass('fadeInAnimationDelay'+i);
            }, 500 * i)
        }(i));
    }
    $('[data-toggle="tooltip"]').tooltip();
}

function buildEstructuraDTMetros(dataName){
    var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
        <table class="table-striped table-hover" id="table`+dataName+`" name="table">
            <thead>
                <tr>
                    <th>SUPERFICIE</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                </tr>
            </thead>
        </table>
    </div>`;
    $("#"+dataName).html(estructura);
}

function buildEstructuraDTDisponibilidad(dataName){
    var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
        <table class="table-striped table-hover" id="table`+dataName+`" name="table">
            <thead>
                <tr>
                    <th>NOMBRE RESIDENCIAL</th>
                    <th>DESCRIPCIÓN</th>
                    <th>TOTALES</th>
                    <th>OCUPADOS</th>
                    <th>RESTANTES</th>
                </tr>
            </thead>
        </table>
    </div>`;
    $("#"+dataName).html(estructura);
}

function buildEstructuraDTLP(dataName){
    var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
        <table class="table-striped table-hover" id="table`+dataName+`" name="table">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>PROSPECTOS</th>
                    <th>CLIENTES</th>
                </tr>
            </thead>
        </table>
    </div>`;
    $("#"+dataName).html(estructura);
}

function buildEstructuraDTMedio(dataName){
    var estructura = `<div class="container-fluid p-0" style="padding:15px!important">
        <table class="table-striped table-hover" id="table`+dataName+`" name="table">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>CANTIDAD</th>
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
                $("#condominio").append($(`<option data-name='${element.idCondominio}'>`).val(element.idCondominio).text(element.nombre));
            });
            $("#condominio").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
    });
}

function getProyectos(idSede = null, idProyecto = null){
    idSede == null ? $("#proyecto").empty():'';
    idSede != null ? $("#proyecto2").empty():'';
    $.ajax({
        url: `${base_url}Metricas/getProyectos`,
        data: {idSede: idSede},
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            response.forEach(element => {
                idSede == null ? $("#proyecto").append($(`<option data-name='${element.nombreResidencial}'>`).val(element.idResidencial).text(element.descripcion)):'';
                idSede != null ? $("#proyecto2").append($(`<option data-name='${element.nombreResidencial}'>`).val(element.idResidencial).text(element.descripcion)):'';
            });

            idProyecto != null ? $("#proyecto2").val(idProyecto):'';
            idSede == null ? $("#proyecto").selectpicker('refresh'):'';
            idSede != null ? $("#proyecto2").selectpicker('refresh'):'';
            $('#spiner-loader').addClass('hide');
        }
    });
}

function buildTableMetros(data){
    $('#tablemetros thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($("#tablemetros").DataTable().column(i).search() !== this.value) {
                $("#tablemetros").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $('#tablemetros').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
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
            data: 'precio'
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
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($("#tabledisponibilidad").DataTable().column(i).search() !== this.value) {
                $("#tabledisponibilidad").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
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
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($("#tablelugar").DataTable().column(i).search() !== this.value) {
                $("#tablelugar").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
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
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($("#tablemedio").DataTable().column(i).search() !== this.value) {
                $("#tablemedio").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
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
            data: function (d) {
                return '$' + formatMoney(d.cantidad);
            }
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

        promedioMetrosChart = new ApexCharts(document.querySelector("#promedioChart"), optionsPromedio);
        promedioMetrosChart.render();
        formatPromedio(dataPromedio);
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

        promedioMetrosChart = new ApexCharts(document.querySelector("#promedioChart"), optionsPromedio);
        promedioMetrosChart.render();
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

function formatPromedio(data){
    $('.loadPromedioChart').addClass('d-none');
    let months = [];
    let dataPromedio = [];
    data.forEach(element => {
        months.push(`${element.MONTH} ${element.año}`);
        dataPromedio.push(element.promedio);
    });

    promedioMetrosChart.updateSeries([{
        name: 'Promedio',
        data: dataPromedio
    }])

    promedioMetrosChart.updateOptions({
        xaxis: {
            categories: months
        },
    });
}

function getPromedio(sede = null, proyecto = null, beginDate, endDate){
    return $.ajax({
        url: `${base_url}Metricas/getPromedio`,
        data: {sede: sede, proyecto:proyecto, beginDate: beginDate, endDate:endDate},
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

function getSedes(selected=null){
    $("#sedes").empty();
    $.ajax({
        url: `${base_url}Metricas/getSedes`,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            dataSedes = response;
            response.forEach(element => {
                $("#sedes").append($(`<option data-name='${element.nombre}'>`).val(element.id_sede).text(element.nombre));
            });

            selected != null ? $("#sedes").val(selected):'';
            $("#sedes").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
    });
}

function setInitialValuesMetrics() {
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

    $('#tableBegin_promedio').val(finalBeginDate2);
    $('#tableEnd_promedio').val(finalEndDate2);
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


function toggleDatatablePromedio(e){
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

function buildTablePromedio(data){
    $('#tablepromedio thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tablepromedio").DataTable().column(i).search() !== this.value) {
                $("#tablepromedio").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tablepromedio").DataTable({
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
        columns: [
            {
                data: 'MONTH'
            },
            {
                data: 'año'
            },
            {
            data: 'precioSUMA'
        },
        {
            data: 'promedio'
        },
        {
            data: 'superficieSUMA'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function getCacheDates(){
    let obj ={ 
        beginDate_Promedio : $('#tableBegin_promedio').val(),
        endDate_Promedio : $('#tableEnd_promedio').val(),
    }
            
    return obj;
}

function getCacheSelectedOptions(){
    let obj ={ 
        sede_promedio : $('#sedes').val(),
        proyecto_promedio : $('#proyecto2').val(),
    }
            
    return obj;
}

function buildDatePikcer(dates){
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

    $('#tableBegin_promedio').val(dates.beginDate_Promedio);
    $('#tableEnd_promedio').val(dates.endDate_Promedio);
}

function buildSelect(selected, dataSelect){
    $('.sedes_box').html('');
    $('.sedes_box').append(`<select class="selectpicker select-gral m-0 proyecto" id="sedes" name="sedes" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important"></select>`);
    $('.proyecto_box').html('');
    $('.proyecto_box').append(`<select class="selectpicker select-gral m-0 proyecto" id="proyecto2" name="proyecto" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important"></select>`);
    getSedes(selected.sede_promedio);
    $('#sedes').selectpicker('refresh');
    getProyectos(selected.sede_promedio, selected.proyecto_promedio);
    getPromedio(selected.sede_promedio, selected.proyecto_promedio, formatDate($('#tableBegin_promedio').val()),formatDate($('#tableEnd_promedio').val())).then( response => { 
        dataPromedio = response;
        formatPromedio(dataPromedio);
    });

    $('#proyecto2').selectpicker('refresh');
}

let titulosMetricas = [];
$('#lotesDetailTableMetricas thead tr:eq(0) th').each(function (i) {
    let title = $(this).text();
    titulosMetricas.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this).on('keyup change', function () {
        if ($('#lotesDetailTableMetricas').DataTable().column(i).search() !== this.value) {
            $('#lotesDetailTableMetricas').DataTable().column(i).search(this.value).draw();
        }   
    });
});

function fillTableMetrics(dataObject) {
    generalDataTable = $('#lotesDetailTableMetricas').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons:[
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'Desglose de lotes',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosMetricas[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
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
        columns: [
            {
                data: function (d) {
                    return d.nombreResidencial;
                }
            },
            {
                data: function (d) {
                    return d.nombreCondominio;
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return d.nombreCliente;
                }
            },
            {
                data: function (d) {
                    return d.nombreAsesor;
                }
            },
            {
                data: function (d) {
                    return d.nombreCoordinador;
                }
            },
            {
                data: function (d) {
                    return d.nombreGerente;
                }
            },
            {
                data: function (d) {
                    return d.nombreSubdirector;
                }
            },
            {
                data: function (d) {
                    return d.nombreRegional;
                }
            },
            {
                data: function (d) {
                    return d.fechaApartado;
                }
            },
            {
                data: function (d) {
                    return d.sup;
                }
            },
            {
                data: function (d) {
                    return d.totalNeto2;
                }
            }
        ],
        ajax: {
            url: `${base_url}Metricas/getLotesInformation`,
            type: "POST",
            data: {
                "sede_residencial": dataObject.sede_residencial,
                "idResidencial": dataObject.idResidencial,
                "beginDate": dataObject.begin,
                "endDate": dataObject.end
            },
            dataSrc: ""
        }
    });
}