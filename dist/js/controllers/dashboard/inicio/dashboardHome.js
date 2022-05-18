var options = {
    series: [{
    name: 'series1',
    data: [31, 40, 28, 51, 42, 109, 100]
  }],
    chart: {
    width: '100%',
    height:'100%',
    type: 'area',
    toolbar: {
      show: false
    },
    sparkline: {
      enabled: false
    }
  },
  grid:{
    show:true,
    
    xaxis: {
      lines: {
          show: false
      },
      axisBorder: {
        show: false,
      },
    },
    yaxis: {
      lines: {
          show: false
      },
      axisBorder: {
        show: false,
      },
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth'
  },
  yaxis:{
    labels: {
      show: false
    }
  },
  xaxis: {
    labels: {
      show: false
    },
  },
  tooltip: {
    x: {
      format: 'dd/MM/yy HH:mm'
    },
  },
  };

  var options2 = {
    series: [{
      name: 'Ventas apartados',
      data: [0]
    }, {
      name: 'Cancelados apartados',
      data: [0]
    }, {
      name: 'Ventas contratadas',
      data: [0]
    }, {
      name: 'Canceladas contratadas',
      data: [0]
    }],
    chart: {
      type: 'bar',
      height: '80%',
      stacked: true,
      stackType: '100%'
    },
    noData: {
      text: undefined,
      align: 'center',
      verticalAlign: 'middle',
      offsetX: 0,
      offsetY: 0,
      style: {
        color: undefined,
        fontSize: '14px',
        fontFamily: undefined
      }
    },
    plotOptions: {
      bar: {
        horizontal: true,
      },
    },
    stroke: {
      width: 0.5,
      colors: ['#fff']
    },
    yaxis: {
      labels: {
        show: false,
      }
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + "K"
        }
      }
    },
    fill: {
      opacity: 1
    },
    legend: {
      position: 'left',
      horizontalAlign: 'center',
      offsetY: 10
    }
  };

  var options3 = {
    series: [{
      name: 'series1',
      data: [256, 104, 318, 465, 233, 363, 150]
    }],
    chart: {
      width: '100%',
      height:'100%',
      type: 'area',
      toolbar: {
        show: false
      },
      sparkline: {
        enabled: false
      }
    },
    grid:{
      show:true,

      xaxis: {
        lines: {
          show: false
        },
        axisBorder: {
          show: false,
        },
      },
      yaxis: {
        lines: {
          show: false
        },
        axisBorder: {
          show: false,
        },
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth'
    },
    yaxis:{
      labels: {
        show: false
      }
    },
    xaxis: {
      labels: {
        show: false
      },
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy HH:mm'
      },
    },
  };

  var options4 = {
  chart: {
    height: 360,
    type: "bar",
    toolbar: {
      show: !1
    },
    events: {
      click: function(o, a, t) {
        console.log(o, a, t)
      }
    }
  },
  colors : ["#4caf50", "#003d82", "#999999", "#f44336", "#ffa500", "#003d82", "#4caf50", "#f44336"],
  plotOptions: {
    bar: {
      columnWidth: "45%",
      distributed: !0
    }
  },
  dataLabels: {
    enabled: !1
  },
  series: [{
    data: [100560, 156, 25, 52, 2508, 6532, 198360, 1632]
  }],
  xaxis: {
    categories: ["PT", "NP", "VA", "CA", "CT", "PCC", "VC", "CC"],
    labels: {
      style: {
        colors : ["#4caf50", "#003d82", "#999999", "#f44336", "#ffa500", "#003d82", "#4caf50", "#f44336"],
        fontSize: "14px"
      }
    }
  },
  legend: {
    offsetY: 7
  },
  grid: {
    row: {
      colors: ["transparent", "transparent"],
      opacity: .2
    },
    borderColor: "#f1f3fa"
  }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);

chart.render();
chart2.render();
chart3.render();
chart4.render();
  
$(document).ready(function(){
    loadInit();
});
function loadInit(){
    let select1 = document.getElementById('infoMainSelector1').checked;
    let select2 = document.getElementById('infoMainSelector2').checked;
    if(select1 == true){
        loadData();
    }
}

function loadData(){
    let response_vtas;
    $.ajax({
        url: url+"index.php/Dashboard/getProspectsByUserSessioned",
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

                $('#numberGraphic').text(response.prospectos);
                $('#pt_card').text(response.prospectos);
                $('#total_ventas').text(response_vtas.ventas_apartadas);

                chart2.updateSeries([{
                    data: [response_vtas.porcentajeApartado],
                    name: 'Ventas apartados'
                },{
                    data: [response_vtas.porcentajeCanceladoApartado],
                    name: 'Cancelados apartados'
                },{
                    data: [response_vtas.porcentajeContratado],
                    name: 'Ventas contratadas'
                },{
                    data: [response_vtas.porcentajeCanceladoContratado],
                    name: 'Canceladas contratadas'
                }])

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
            url: url+"index.php/Dashboard/getDataFromDates",
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
            url: url+"index.php/Dashboard/getDataFromDates",
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
            url: url+"index.php/Dashboard/getDataFromDates",
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
            url: url+"index.php/Dashboard/getDataFromDates",
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
            url: url+"index.php/Dashboard/getDataFromDates",
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
            url: url+"index.php/Dashboard/getDataFromDates",
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

