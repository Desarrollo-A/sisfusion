var dataApartados, dataContratados, dataConEnganche, dataSinEnganche;

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
    getRankings(true).then( response => { divideRankingArrays(response) }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal", "danger"); });
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
});

var options = {
    series: [{
        name: 'Ventas de apartados',
        data: [92, 70, 66, 64, 50, 48, 36, 30, 27, 2]
    }],
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
        categories: ["Fernando Contreras S.", "Julia Martinez J.", "Roberto Nuñez M.", "Laura Olvera O.", "Cynthia Dominguez F.", "Hugo Torres N.", "Abraham Martinez F.", "Gabriela Castillo D.", "José Fernando Mora C.", "Elias Moya D."],
        position: 'bottom',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
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
        }
    },
};

var chart = new ApexCharts(document.querySelector('#chart'), options);
chart.render();
var chart = new ApexCharts(document.querySelector('#chart2'), options);
chart.render();
var chart = new ApexCharts(document.querySelector('#chart3'), options);
chart.render();
var chart = new ApexCharts(document.querySelector('#chart4'), options);
chart.render();

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
    inactivos = [];
    activos = [];

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

function getRankings(general, typeRanking){
    return $.ajax({
        type: 'POST',
        url: `Ranking/getAllRankings`,
        data: {general: general, typeRanking},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data) {
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
        },
        {
            data: 'correo'
        },
        {
            data: 'usuario'
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
        },
        {
            data: 'correo'
        },
        {
            data: 'usuario'
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