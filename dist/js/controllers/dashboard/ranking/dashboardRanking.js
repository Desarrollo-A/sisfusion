var dataApartados, dataContratados, dataConEnganche, dataSinEnganche, dataSedes;

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

$(document).ready(function(){
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
    getRankings(true, 'general');
    getSedes().then( response => { 
        dataSedes = response 
        buildSelectSedes(dataSedes);
    });
});

var options = {
    series: [],
    chart: {
        height: 'auto',
        type: 'bar',
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: true,
            borderRadius: 7,
            barHeight: '50%',
            distributed: false,
            dataLabels: {
                show: true
            },
            
        }
    },
    dataLabels: {
        enabled: true,
    },
    grid: {
        show: false,
    },
    xaxis: {
        categories: [],
        position: 'bottom',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
        labels: {
            show: true,
            formatter: function (val) {
                return val + "%";
            },
            style: {
                colors: ['#FFFFFF','#FFFFFF'],
            },
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
                return val + "%";
            },
            style: {
                colors: ['#FFFFFF','#FFFFFF'],
            },
        }
    },
};

var chartApartados = new ApexCharts(document.querySelector('#chart'), options);
chartApartados.render();
var chartContratados = new ApexCharts(document.querySelector('#chart2'), options);
chartContratados.render();
var chartEnganche = new ApexCharts(document.querySelector('#chart3'), options);
chartEnganche.render();
var chartSinenganche = new ApexCharts(document.querySelector('#chart4'), options);
chartSinenganche.render();

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

function buildEstructuraDT(dataName, dataApartados){
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

function reorderColumns(){
    var principalColumns = document.getElementsByClassName("flexible");
    var mainRow = document.getElementById('mainRow');

    //Creamos nuevo fragmento en el DOM para insertar las columnas ordenadas
    var elements = document.createDocumentFragment();
    var inactivos = [], activos = [], selectsSede = [];
    
    for( var i = 0; i<principalColumns.length; i++){
        var select = {};
        (principalColumns[i].classList.contains('inactivo')) ? inactivos.push(i) : activos.push(i)
        var sedes= $(principalColumns[i]).find('#sedes'+(i+1));
        select['name'] = sedes[0].id;
        select['value'] = sedes[0].value
        selectsSede.push(select);
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

    buildSelectSedes(dataSedes, selectsSede);

    for( i = 1; i<=principalColumns.length; i++){
        (function(i){
            setTimeout(function(){
                $(principalColumns[i-1]).removeClass('hidden');
                if($(principalColumns[i-1]).hasClass('activo')){
                    var columnDatatable = $( principalColumns[i-1]).find('.col-datatable');
                    var id = columnDatatable.attr('id');
                    $("#"+id).html('');
                    if( id == 'Apartados' ){
                        buildEstructuraDT(id, dataApartados);
                        buildTableApartados(dataApartados);
                    }
                    else if( id == 'Contratados' ){
                        buildEstructuraDT(id, dataContratados);
                        buildTableContratados(dataContratados);
                    }
                    else if( id == 'ConEnganche' ){
                        buildEstructuraDT(id, dataConEnganche);
                        buildTableConEnganche(dataConEnganche);
                    }
                    else if( id == 'SinEnganche' ){
                        buildEstructuraDT(id, dataConEnganche);
                        buildTableSinEnganche(dataSinEnganche);
                    }
                }
                $(principalColumns[i-1]).addClass('fadeInAnimationDelay'+i);
            }, 500 * i)
        }(i));
    }   
}

function getRankings(general = false, typeRanking = null){
    let dates = getDates(typeRanking);
    $.ajax({
        type: 'POST',
        url: `Ranking/getAllRankings`,
        data: {general: general, typeRanking: typeRanking,beginDate: dates.beginDate, endDate: dates.endDate, sede: 2},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data) {
            updateGraph(typeRanking, data);
            divideRankingArrays(data);
            $('#spiner-loader').addClass('hide');
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function divideRankingArrays(data){
    Object.entries(data).forEach(([key, value]) => {
        if(key == 'Apartados'){
            dataApartados = value;            
        }
        else if(key == 'Contratados'){
            dataContratados = value;
        }
        else if(key == 'ConEnganche'){
            dataConEnganche = value;
        }
        else if(key == 'SinEnganche'){
            dataConEnganche = value;
        }
    });
    return {dataApartados:dataApartados, dataContratados:dataContratados, dataConEnganche:dataConEnganche, dataConEnganche:dataConEnganche}
}

function buildTableApartados(data){
    $('#tableApartados thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tableApartados").DataTable().column(i).search() !== this.value) {
                $("#tableApartados").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tableApartados").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'totalAT'
        },
        {
            data: 'id_asesor'
        },
        {
            data: 'nombreUsuario'
        },
        {
            data: 'id_rol'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableContratados(data){
    $('#tableContratados thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tableContratados").DataTable().column(i).search() !== this.value) {
                $("#tableContratados").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tableContratados").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'totalConT'
        },
        {
            data: 'id_asesor'
        },
        {
            data: 'nombreUsuario'
        },
        {
            data: 'id_rol'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableConEnganche(data){
    $('#tableConEnganche thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tableConEnganche").DataTable().column(i).search() !== this.value) {
                $("#tableConEnganche").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tableConEnganche").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'cuantos'
        },
        {
            data: 'asesor'
        },
        {
            data: 'id_asesor'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function buildTableSinEnganche(data){
    $('#tableSinEnganche thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#tableSinEnganche").DataTable().column(i).search() !== this.value) {
                $("#tableSinEnganche").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    $("#tableSinEnganche").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        pagingType: "full_numbers",
        pageLength : 10,
        width: '100%',
        destroy: true,
        ordering: false,
        scrollX: true,
        language: {
            url: "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        data: data,
        columns: [{
            data: 'id_usuario'
        },
        {
            data: 'nombre'
        },
        {
            data: 'apellido_paterno'
        },
        {
            data: 'apellido_materno'
        },
        {
            data: 'telefono'
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
}

function formatData(data) {
    let
        apartados = [],
        apartadosLabel = [],
        contratados = [],
        contratadosLabel = [],
        enganche = [],
        engancheLabel = [],
        sinEnganche = [],
        sinEngancheLabel = [];

    if (data.Apartados) {
        let count = 0;
        (data.Apartados).forEach(element => {
            if (count < 10) {
                apartados.push(element.totalAT);
                apartadosLabel.push(element.nombreUsuario);
                count++;
            }
        });
    }
    if (data.Contratados) {
        let count = 0;
        (data.Contratados).forEach(element => {
            if (count < 10) {
                contratados.push(element.totalConT);
                contratadosLabel.push(element.nombreUsuario);
                count++;
            }
        });
    }
    if (data.ConEnganche) {
        let count = 0;
        (data.ConEnganche).forEach(element => {
            if (count < 10) {
                enganche.push(element.cuantos);
                engancheLabel.push(element.asesor);
                count++;
            }
        });
    }
    if (data.SinEnganche) {
        let count = 0;
        (data.SinEnganche).forEach(element => {
            if (count < 10) {
                sinEnganche.push(element.cuantos);
                sinEngancheLabel.push(element.asesor);
                count++;
            }
        });
    }

    return {
        apartados: {
            name: 'Apartados',
            data: apartados
        },
        apartadosLabel: apartadosLabel,
        contratados: {
            name: 'Contratados',
            data: contratados
        },
        contratadosLabel: contratadosLabel,
        enganche: {
            name: 'Enganche',
            data: enganche
        },
        engancheLabel: engancheLabel,
        sinEnganche: {
            name: 'Sin enganche',
            data: sinEnganche
        },
        sinEngancheLabel: sinEngancheLabel
    };
}

function updateGraph(typeRanking, data){
    let series = formatData(data);

    switch (typeRanking) {
        case 'general':
            chartApartados.updateOptions(setOptionsChart(series.apartados, series.apartadosLabel));
            chartContratados.updateOptions(setOptionsChart(series.contratados, series.contratadosLabel));
            chartEnganche.updateOptions(setOptionsChart(series.enganche, series.engancheLabel));
            chartSinenganche.updateOptions(setOptionsChart(series.sinEnganche, series.sinEngancheLabel));
            break;
        case 'Apartados':
            chartApartados.updateOptions(ssetOptionsChart(series.apartados, series.apartadosLabel));
            break;
        case 'Contratados':
            chartContratados.updateOptions(setOptionsChart(series.contratados, series.contratadosLabel));
            break;
        case 'ConEnganche':
            chartEnganche.updateOptions(setOptionsChart(series.enganche, series.engancheLabel));
            break;
        case 'SinEnganche':
            chartSinenganche.updateOptions(setOptionsChart(series.sinEnganche, series.sinEngancheLabel));
            break;

        default:
            break;
    }
}

function setOptionsChart(series, categories){
    let options = { 
        series: [series],
        chart: {
            height: 'auto',
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 7,
                barHeight: '50%',
                distributed: false,
                dataLabels: {
                    show: true
                },
            }
        },
        dataLabels: {
            enabled: true,
        },
        grid: {
            show: false,
        },
        xaxis: {
            categories: categories,
            position: 'bottom',
            axisBorder: {
                show: false
            },
            labels: {
                show: true,
                formatter: function (val) {
                    return val;
                }
            },
            style: {
                colors: []
            },
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
        }
    }
    return options;
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
}

function getDates(typeRanking){
    let beginDate, endDate;
    switch (typeRanking) {
        case 'general':
           beginDate = null;
           endDate = null;
            break;
        case 'Apartados':
            beginDate = $('#beginDateApartados').val();
            endDate = $('#endDateApartados').val();
            break;
        case 'Contratados':
            beginDate = $('#beginDateContratados').val();
            endDate = $('#endDateContratados').val();
            break;
        case 'ConEnganche':
            beginDate = $('#beginDateConEnganche').val();
            endDate = $('#endDateConEnganche').val();
            break;
        case 'SinEnganche':
            beginDate = $('#beginDateSinEnganche').val();
            endDate = $('#endDateSinEnganche').val();
            break;

        default:
            break;
    }

    return {beginDate: beginDate, endDate: endDate};
}

function getSedes(){
    return $.ajax({
        type: 'POST',
        url: `Ranking/getSedes`,
        data: {},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data) {
            // response = data;
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function buildSelectSedes(dataSedes, selectsSede){
    console.log(selectsSede);
    $('.boxSedes').html('');
    var boxSedes = document.getElementsByClassName("boxSedes");
    for ( var i = 0; i<boxSedes.length; i++ ){
        var id = boxSedes[i].id;
        var html = `<select id="sedes`+(id.replace(/\D/g, ""))+`" name="sedes" class="selectMini sedes w-100 m-0">Sedes</select>`;
        $('#'+id).append(html);
    }

    $(".sedes").append($('<option disabled>').val("0").text("Seleccione una opción"));
    for( var i =0; i<dataSedes.length; i++ ){
        var id_sede = dataSedes[i]['id_sede'];
        var nombre = dataSedes[i]['nombre'];
        $(".sedes").append($('<option>').val(id_sede).text(nombre));
    }
    $(".sedes").selectpicker('refresh');

    if ( selectsSede != undefined ){
        setOptionsSelected(selectsSede);
    }
}

function setOptionsSelected(selectsSede){
    var boxSedes = document.getElementsByClassName("boxSedes");
    console.log(selectsSede);
    for ( var i = 0; i<boxSedes.length; i++ ){
        var select = $( boxSedes[i] ).find('#sedes'+(i+1));
        var id = select.attr('id');
        let obj = selectsSede.find(o => o.name === id );
        $("#"+id).val(obj.value);
        $("#"+id).selectpicker('refresh');
    }
}