// Obtener fecha inicial y cuatro meses atrás para mini charts.
var endDate = moment().format("YYYY-MM-DD");
var beginDate = moment(endDate).subtract(4, 'months').format("YYYY-MM-DD");

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
});

$('[data-toggle="tooltip"]').tooltip();
//AA: Carga inicial de datatable y acordión. 

$(document).ready( function(){
    init();
   
});

async function init(){
    getLastSales(beginDate, endDate);
    let rol = userType == 2 ? await getRolDR(idUser): userType;
    console.log('rol',rol);
    fillBoxAccordions(rol == '1' ? 'director_regional': rol == '2' ? 'gerente' : rol == '3' ? 'coordinador' : rol == '59' ? 'subdirector':'asesor', rol, idUser, 1);
}

function createAccordions(option, render){
    let html = '';
    html = `<div class="bk ${render == 1 ? 'parentTable': 'childTable'}">
        ${render == 1 ? '': '<i class="far fa-trash-alt deleteTable"></i>'}
        <h4 class="accordion-title js-accordion-title">`+option+`</h4>
            <div class="accordion-content">
                <table class="table-striped table-hover" id="table`+option+`" name="table`+option+`">
                    <thead>
                        <tr>
                            <th class="detail">MÁS</th>
                            <th class="encabezado">`+option.toUpperCase()+`</th>
                            <th>TOTAL</th>
                            <th># LOTES</th>
                            <th>APARTADO</th>
                            <th># LOTES APARTADOS</th>
                            <th>% APARTADOS</th>
                            <th>CONTRATADOS</th>
                            <th># LOTES CONTRATADOS</th>
                            <th>% CONTRATADOS</th>
                            <th>CANCELADOS</th>
                            <th># LOTES CANCELADOS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>`;
    $(".boxAccordions").append(html);
}

function fillBoxAccordions(option, rol, id_usuario, render){
    createAccordions(option, render);
    $(".js-accordion-title").addClass('open');
    $(".accordion-content").css("display", "block");

    $('#table'+option+' thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#table"+option+"").DataTable().column(i).search() !== this.value) {
                $("#table"+option+"").DataTable().column(i)
                    .search(this.value).draw();
            }
        });
    });

    generalDataTable = $("#table"+option).dataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row d-flex align-center'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>>",
        width: '100%',
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
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
        columns: [
            {
                width: "2%",
                data: function(d){
                    return '<button type="btn" class="btnSub"><i class="fas fa-sitemap" data-toggle="tooltip" data-placement="bottom" title="Desglose a detalle"></i></button>';
                }
            },
            {
                width: "10%",
                data: function (d) {
                    return d.nombreUsuario;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>" + d.sumaTotal+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalVentas;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>" + d.sumaAT+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalAT;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.porcentajeTotalAp + "%";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>" + d.sumaConT +"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalConT;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.porcentajeTotalCont + "%";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>" + d.sumaCT+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalCT;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return  rol == 7 || (rol == 9 && render == 1) ? '':'<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas update-dataTable" data-type="' + rol + '" data-render="' + render + '" value="' + d.userID + '"><i class="fas fa-sign-in-alt"></i></button></div>';
                }
            },
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'Reporte/getInformation',
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": '1',
                "beginDate": '01/01/2022',
                "endDate":  '31/01/2022',
                "where": '1',
                "type": rol,
                "id_usuario": id_usuario,
                "render": render
            }
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
}

$(document).on('click', '.update-dataTable', function () {
    const type = $(this).attr("data-type");
    const render = $(this).data("render");
    if(render == 1){
        $('.childTable').remove();
    }
    
    // const beginDate = $("#beginDate").val();
    // const endDate = $("#endDate").val();

    // const saleType = $("#saleType").val();
    // const where = $(this).val();
    // let typeTransaction = 0;

    // if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType == null) // APLICA FILTRO AÑO ACTUAL
    //     typeTransaction = 1;
    // else if (beginDate == '01/01/2022' && endDate == '01/01/2022' && saleType != null) // APLICA FILTRO AÑO ACTUAL Y TIPO DE VENTA
    //     typeTransaction = 2;
    // else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType == null) // APLICA FILTRO POR FECHA
    //     typeTransaction = 3;
    // else if ((beginDate != '01/01/2022' || endDate != '01/01/2022') && saleType != null) // APLICA FILTRO POR FECHA Y TIPO DE VENTA
    //     typeTransaction = 4;

    if (type == 2) { // MJ: #sub->ger->coord
        // fillTable(typeTransaction, beginDate, endDate, table, 0, 1);
        // $("#box-managerTable").addClass('d-none');
        if(render == 1){
            const table = "coordinador";
            console.log(table);

            fillBoxAccordions(table, 9, $(this).val(), 2);
        }else{
            const table = "gerente";
        console.log(table);

            fillBoxAccordions(table, 3, $(this).val(), 2);

        }
    } else if (type == 3) { // MJ: #gerente->coord->asesor

        // $("#box-managerTable").removeClass('d-none');
        // $("#box-coordinatorTable").addClass('d-none');
        // $("#box-adviserTable").addClass('d-none');
        // fillTable(typeTransaction, beginDate, endDate, table, where, 2);
        if(render == 1){
            const table = "asesor";
            console.log(table);

            fillBoxAccordions(table, 7, $(this).val(), 2);
        }else{
            const table = "coordinador";
        console.log(table);

            fillBoxAccordions(table, 9, $(this).val(), 2);

        }

    } else if (type == 9) { // MJ: #coordinatorTable -> asesor
        if(render == 1){

        }else{
            const table = "asesor";
            fillBoxAccordions(table, 7, $(this).val(), 2);
        }
        console.log(table);
        // $("#box-coordinatorTable").removeClass('d-none');
        // $("#box-adviserTable").addClass('d-none');
        // fillBoxAccordions(table, 7);

        //aqui ya no debe crear tabla
    } else if (type == 59) { // MJ: #DirRegional->subdir->ger
        const table = "gerente";
        // $("#box-adviserTable").removeClass('d-none');
        fillBoxAccordions(table, 3, $(this).val(), 2);
    }
});

function setOptionsChart(series, categories, miniChart){
    (series.length > 1) ? colors = ["#2C93E7", "#d9c07b"] : colors = ["#2C93E7"];
    var optionsMiniChart = {
        series: series,
        chart: {
            type: 'area',
            height: '100%',
            toolbar: { show: false },
            zoom: { enabled: false },
            sparkline: {
                enabled: true
            }
        },
        colors: colors,
        grid: { show: false},
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: {
            curve: 'smooth',
            width: `${ ( miniChart == 0 ) ? 4 : 2 }`,
        },
        xaxis: {
            categories: categories,
            labels: {show: false},
            axisBorder: {show:false},
            axisTicks: {show:false},
        },
        yaxis: {
            labels: {
                show: false,
                formatter: function (value) {
                    return "$" + formatMoney(value);
                }
            },
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
                gradientToColors:  colors,
                inverseColors: true,
                opacityFrom: 0.55,
                opacityTo: 0.2,
                stops: [0, 70, 100],
                colorStops: []
            }
        },
        tooltip: { enabled: true},
        markers: {
            size: `${ ( miniChart == 0 ) ? 5 : 0 }`,
            colors: '#143860',
            strokeColors: '#2C93E7',
            strokeWidth: `${ ( miniChart == 0 ) ? 3 : 0 }`,
            hover: {
                size: `${ ( miniChart == 0 ) ? 10 : 3 }`
            }
        }
    }
    return optionsMiniChart;
}
  
$(document).on('click', '.js-accordion-title', function () {
    $(this).next().slideToggle(200);
    $(this).toggleClass('open', 200);
});
$(document).on('click', '.deleteTable', function () {
    console.log('remove');
    $(this).parent().remove();
});

function chartDetail(e, tipoChart){
    $("#modalChart").modal();
    var nameChart = (titleCase($(e).data("name").replace(/_/g, " "))).split(" ");
    $(".boxModalTitle").html('');
    $(".total").html('');
    $("#modalChart #type").val('');
    $(".boxModalTitle").append('<p class="title" style="margin-bottom:10px">' + nameChart[0] + '<span class="enfatize"> '+ nameChart[1] +'</span></p>');
    
    $("#modalChart #beginDate").val(moment(beginDate).format('DD/MM/YYYY'));
    $("#modalChart #endDate").val(moment(endDate).format('DD/MM/YYYY'));
    $("#modalChart #type").val(tipoChart);

    getSpecificChart(tipoChart, beginDate, endDate);
}

function getSpecificChart(type, beginDate, endDate){
    $.ajax({
        type: "POST",
        url: "Reporte/getDataChart",
        data: {general: 0, tipoChart: type, beginDate: beginDate, endDate: endDate},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function(data){
            var miniChart = 0;
            $('#spiner-loader').addClass('hide');
            var orderedArray = orderedDataChart(data);
            let { categories, series } = orderedArray[0];
            total = series[0].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
            $(".boxModalTitle").append('<p class="total">$'+formatMoney(total)+'</p>');
            $("#boxModalChart").html('');
            var miniChart = new ApexCharts(document.querySelector("#boxModalChart"), setOptionsChart(series, categories, miniChart));
                
            miniChart.render();
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function getLastSales(beginDate, endDate){
    $.ajax({
        type: "POST",
        url: "Reporte/getDataChart",
        data: {general: 1, tipoChart:'na', beginDate: beginDate, endDate: endDate},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data){
            let miniChart = 1, total = 0;
            $('#spiner-loader').addClass('hide');
            let orderedArray = orderedDataChart(data);
            for ( i=0; i<orderedArray.length; i++ ){
                let { chart, categories, series } = orderedArray[i];
                total = 0;
                for ( j=0; j < series.length; j++ ){
                    total += series[j].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                }
                $("#tot"+chart).text("$"+formatMoney(total));
                if( total != 0 ){
                    var miniChartApex = new ApexCharts(document.querySelector("#"+chart+""), setOptionsChart(series, categories, miniChart));
                
                    miniChartApex.render();
                }
                else{
                    
                }
            }
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

$(document).on("click", "#searchByDateRange", function () {
    var beginDate = $("#modalChart #beginDate").val();
    var endDate = $("#modalChart #endDate").val();
    var type = $("#modalChart #type").val();
    getSpecificChart(type, formatDate(beginDate), formatDate(endDate));
});

function orderedDataChart(data){
    let allData = [], totalMes = [], meses = [], series = [];
    for( i=0; i<data.length; i++){
        let { tipo, rol, total, DateValue } = data[i];

        nameTypeChart = `${ (tipo == 'vc') ? 'ventasContratadas' : (tipo == 'va') ? 'ventasApartadas' : (tipo == 'cc') ? 'canceladasContratadas' : 'canceladasApartadas' }`;

        nameSerie = `${ (rol == '9') ? 'Coordinador' : (rol == '7') ? 'Asesor' : (tipo == 'vc') ? 'ventasContratadas' : (tipo == 'va') ? 'ventasApartadas' : (tipo == 'cc') ? 'canceladasContratadas' : 'canceladasApartadas' }`;
        
        totalMes.push( (total != null) ? parseFloat(total.replace(/[^0-9.-]+/g,"")) : 0 );
        if( (i+1) < data.length ){
            if(tipo == data[i + 1].tipo){
                if(rol != data[i + 1].rol){
                    buildSeries(series, nameSerie, totalMes);
                    totalMes = [];
                    meses = [];
                }
                else{
                    meses.push(monthName(DateValue));
                }             
            }
            else{
                meses.push(monthName(DateValue));
                buildSeries(series, nameSerie, totalMes);
                buildAllDataChart(allData, nameTypeChart, series, meses);
                series = [];
                totalMes = [];
                meses = [];
            }
        }
        else{
            meses.push(monthName(DateValue));
            buildSeries(series, nameSerie, totalMes);
            buildAllDataChart(allData, nameTypeChart, series, meses)
            series = [];
            totalMes = [];
        }
    }
    return allData;
}

function buildSeries(series, nameSerie, totalMes){
    nameSerie = titleCase(nameSerie.split(/(?=[A-Z])/).join(" "));
    series.push({
        name: nameSerie,
        data: totalMes
    });
}

function buildAllDataChart(allData, nameTypeChart, series, meses){
    allData.push({
        chart : nameTypeChart,
        series : series,
        categories : meses
    });
}

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function monthName(mon){
    var monthName = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][mon - 1];
    return monthName;
}

function getRolDR(idUser){
    return new Promise(resolve => {      
    $.ajax({
        type: "POST",
        url: "Reporte/getRolDR",
        data: {idUser: idUser},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data){
            $('#spiner-loader').addClass('hide');
            console.log('datarol',data);
            
            resolve (data.length > 0 ? 59:2);
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
}
function titleCase(string){
    return string[0].toUpperCase() + string.slice(1).toLowerCase();
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
