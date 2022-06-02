var optionsTotalVentas = {
    series: [],
    chart: {
        height: '100%',
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return 249
                    }
                }
            }
        }
    },
    title:{
        text: 'TOTAL DE VENTAS',
        align: 'center',
        margin: 5
    },
    labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
};

var optionsProspectos = {
    series: [],
    chart: {
        height: '100%',
        type: 'area',
        toolbar: {
            show: false
        },

        sparkline: {
            enabled: true,
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 2,
        curve: 'smooth'
    },
};

var optionsProspClients = {
    series: [{
        name: 'series1',
        data: [31, 40, 28, 51, 42, 109, 100]
    }, {
        name: 'series2',
        data: [11, 32, 45, 32, 34, 52, 41]
    }],
    chart: {
        height: '100%',
        type: 'area',
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: false,
        }
    },
    yaxis:{
        labels: {
            offsetX: -13,
          },
    },
    grid: {
        padding: {
          left: -3,
        },
      },
    dataLabels: {
        enabled: false
    },
    stroke: {
        width: 1,
        curve: 'smooth'
    },
};

var optionsWeekly = {
    series: [{
        data: [21, 22, 10, 28, 16, 21, 13, 30]
    }],
    chart: {
        height: '100%',
        type: 'bar',
        toolbar: {
            show: false
        },
    },
    grid:{
        show: false,
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
        show: false
    },
    xaxis: {
        categories: ['uno','dos','tres','cuatro','cinco','seis','siete','ocho'],
        labels: {
            style: {
                fontSize: '12px'
            }
        }
    }
};

var optionsFunnel = {
    series: [44, 55, 67, 83],
    chart: {
        height: '100%',
        type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '16px',
                },
                total: {
                    show: true,
                    label: 'Total',
                    formatter: function (w) {
                        // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                        return 249
                    }
                }
            }
        }
    },
    title:{
        text: 'CICLO DE VENTA',
        align: 'center',
        margin: 5
    },
    labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
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

  
$(document).ready(function(){
    loadInit();
});
function loadInit(){
    let select1 = document.getElementById('infoMainSelector1').checked;
    let select2 = document.getElementById('infoMainSelector2').checked;
    if(select1 == true){
        loadData();
        getProspectsByYear();
        getSalesByYear();
    }
}

function getSalesByYear(){
    $.ajax({
        url: "Dashboard/totalVentasData",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            let totalVentasArray = [response.totalVentas, (response.ConT + response.totalAT), response.totalCT]
            totalVentasChart.updateSeries([{
                data: totalVentasArray
            }])

            console.log(response);
        }
    });
}

function getProspectsByYear() {
    $.ajax({
        url: "Dashboard/getProspectsByYear",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
            let months = [];
            let data = [];
            let count = 0;
            response.forEach(element => {
                months.push(element.MONTH);
                data.push(element.counts);
                count = count + element.counts;
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
            $('#numberGraphic').text(count);
        }
    });
}

function loadData(){
    let response_vtas;
    $.ajax({
        url:"Dashboard/getProspectsByUserSessioned",
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        beforeSend: function(){
            $('#spiner-loader').removeClass('hide');
        },
        success : function (response) {
            response = JSON.parse(response);
            response_vtas = response['total_ventas'][0];
            response = response[0];
            if(response.prospectos > 0) {


                $('#spiner-loader').addClass('hide');
                $('.numberElement').removeClass('subtitle_skeleton');

                // $('#numberGraphic').text(response.prospectos);
                $('#pt_card').text(response.prospectos);
                $('#total_ventas').text(response_vtas.ventas_apartadas);

                // chart2.updateSeries([{
                //     data: [response_vtas.porcentajeApartado],
                //     name: 'Ventas apartados'
                // },{
                //     data: [response_vtas.porcentajeCanceladoApartado],
                //     name: 'Cancelados apartados'
                // },{
                //     data: [response_vtas.porcentajeContratado],
                //     name: 'Ventas contratadas'
                // },{
                //     data: [response_vtas.porcentajeCanceladoContratado],
                //     name: 'Canceladas contratadas'
                // }])

            }else if(response.message == 'ERROR'){
                alerts.showNotification('top', 'right', 'Ocurrió un error, intentalo nuevamente', 'danger');
                $('#spiner-loader').addClass('hide');
            }
        }
    });
    loadData2();
}


function weekFilter(element){
    let typeTransaction = 0;
    if(element == 'thisWeek'){
        var curr = new Date; // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var last = first + 6; // last day is the first day + 6

        var firstday = new Date(curr.setDate(first));
        let inicio_semana = new Date(firstday.getFullYear(), firstday.getMonth(), firstday.getDate())
        inicio_semana = inicio_semana.toISOString().split('T')[0];

        var lastday = new Date(curr.setDate(last));
        let fin_semana = new Date(lastday.getFullYear(), lastday.getMonth(), lastday.getDate());
        fin_semana = fin_semana.toISOString().split('T')[0];
        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("fecha_inicio", inicio_semana);
        com2.append("fecha_fin", fin_semana);
        com2.append("typeTransaction", typeTransaction);

        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                // chart4.updateSeries([{
                //     data: array_chart_numbers
                // }])

            }
        });
    }
    if(element == 'lastWeek'){
        let semana_pasada =  getLastWeek();
        let start_sp;
        let end_sp;
        semana_pasada.map((element)=>{
            if(element.type==1){
                start_sp = element.date;
            }else{
                end_sp = element.date;
            }
        });

        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("fecha_inicio", start_sp);
        com2.append("fecha_fin", end_sp);
        com2.append("typeTransaction", typeTransaction);
        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                chart4.updateSeries([{
                    data: array_chart_numbers
                }])

            }
        });

    }
    if(element == 'lastMonth'){
        let mes_pasada =  getLastMonth();
        let start_sp;
        let end_sp;
        mes_pasada.map((element)=>{
            if(element.type==1){
                start_sp = element.date;
            }else{
                end_sp = element.date;
            }
        });
        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("fecha_inicio", start_sp);
        com2.append("fecha_fin", end_sp);
        com2.append("typeTransaction", typeTransaction);
        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                chart4.updateSeries([{
                    data: array_chart_numbers
                }])

            }
        });
    }
}
$(document).on('click', '.infoMainSelector', function(){
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

    loadData2();


});

function loadData2(){
    let typeTransaction = 0;
    let thisWeekS = $('#thisWeek');
    let lastWeekS = $('#lastWeek');
    let lastMonthS = $('#lastMonth');
    if(thisWeekS.hasClass('active')){
        var curr = new Date; // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var last = first + 6; // last day is the first day + 6

        var firstday = new Date(curr.setDate(first));
        let inicio_semana = new Date(firstday.getFullYear(), firstday.getMonth(), firstday.getDate()) // can also be a Temporal object
        inicio_semana = inicio_semana.toISOString().split('T')[0];

        var lastday = new Date(curr.setDate(last));
        let fin_semana = new Date(lastday.getFullYear(), lastday.getMonth(), lastday.getDate());
        fin_semana = fin_semana.toISOString().split('T')[0];
        var com2 = new FormData();
        typeTransaction = validateMainFilters();
        com2.append("fecha_inicio", inicio_semana);
        com2.append("fecha_fin", fin_semana);
        com2.append("typeTransaction", typeTransaction);

        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                // chart4.updateSeries([{
                //     data: array_chart_numbers
                // }])

            }
        });

    }
    else if(lastWeekS.hasClass('active')){
        let semana_pasada =  getLastWeek();
        let start_sp;
        let end_sp;
        semana_pasada.map((element)=>{
            if(element.type==1){
                start_sp = element.date;
            }else{
                end_sp = element.date;
            }
        });
        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("fecha_inicio", start_sp);
        com2.append("fecha_fin", end_sp);
        com2.append("typeTransaction", typeTransaction);



        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                chart4.updateSeries([{
                    data: array_chart_numbers
                }])

            }
        });
    }
    else if(lastMonthS.hasClass('active')){
        let mes_pasada =  getLastMonth();
        let start_sp;
        let end_sp;
        mes_pasada.map((element)=>{
            if(element.type==1){
                start_sp = element.date;
            }else{
                end_sp = element.date;
            }
        });
        typeTransaction = validateMainFilters();
        var com2 = new FormData();
        com2.append("fecha_inicio", start_sp);
        com2.append("fecha_fin", end_sp);
        com2.append("typeTransaction", typeTransaction);
        $.ajax({
            url: "Dashboard/getDataFromDates",
            data:com2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function(){
                // $('#spiner-loader').removeClass('hide');
                $('.numberElement').addClass('subtitle_skeleton');
                cleanValues(true);
            },
            success : function (response) {
                response = JSON.parse(response);
                let array_chart_numbers = [];
                $('.numberElement').removeClass('subtitle_skeleton');
                response.map((element)=>{
                    if(element.queryType == 'prospectos_totales'){
                        $('#pt_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_nuevos'){
                        $('#np_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_apartados'){
                        $('#va_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cancelados_apartados'){
                        $('#ca_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'cierres_totales'){
                        $('#ct_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'prospectos_cita'){
                        $('#pcc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'ventas_contratadas'){
                        $('#vc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                    if(element.queryType == 'contratos_cancelados'){
                        $('#cc_card').text(element.numerosTotales);
                        array_chart_numbers.push(element.numerosTotales);
                    }
                });
                chart4.updateSeries([{
                    data: array_chart_numbers
                }])

            }
        });
    }
}

const formatter = new Intl.DateTimeFormat("en-GB", { // <- re-use me
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
})

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
    return dates;
}

function getLastMonth(){
    var now = new Date();
    var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
    var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);

    function formatDateComponent(dateComponent) {
        return (dateComponent < 10 ? '0' : '') + dateComponent;
    };

    var formatDate = function(date) {
        // return formatDateComponent(date.getMonth() + 1) + '/' + formatDateComponent(date.getDate()) + '/' + date.getFullYear();
        return date.getFullYear() + '-' +formatDateComponent(date.getMonth() + 1) + '-' + formatDateComponent(date.getDate());
    };


    let dates = [];
    dates.push({"date":formatDate(prevMonthFirstDate), type:1});
    dates.push({"date":formatDate(prevMonthLastDate), type:2});
    return dates;
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

function cleanValues(validator){
    if(validator){
        $('#pt_card').text('');
        $('#np_card').text('');
        $('#va_card').text('');
        $('#ca_card').text('');
        $('#ct_card').text('');
        $('#pcc_card').text('');
        $('#vc_card').text('');
        $('#cc_card').text('');
    }

}

