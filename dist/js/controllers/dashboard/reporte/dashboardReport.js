$('[data-toggle="tooltip"]').tooltip();
//AA: Carga inicial de datatable y acordión. 
getLastSales();
fillBoxAccordions(userType == '1' ? 'subdirector': userType == '2' ? 'gerente' : userType == '3' ? 'coordinador' : 'asesor');


function createAccordions(option){
    let html = '';
    html = `<div class="bk">
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

function fillBoxAccordions(option){
    createAccordions(option);
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
                    return d.nombre;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>$" + formatMoney(d.total)+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalLotes;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>$" + formatMoney(d.apartado)+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalApartados;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.porcentajeApartado + "%";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>$" + formatMoney(d.contratado)+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalContratados;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.porcentajeContratado + "%";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return "<b>$" + formatMoney(d.cancelado)+"</b>";
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return d.totalCancelados;
                }
            },
            {
                width: "8%",
                data: function (d) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas update-dataTable" data-type="' + d.type + '" value="' + d.id + '"><i class="fas fa-sign-in-alt"></i></button></div>';
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
                "endDate":  '01/01/2022',
                "where": '1',
                "type": '2',
                "saleType": '1'
            }
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
}

$(document).on('click', '.update-dataTable', function () {
    const type = $(this).attr("data-type");
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

    if (type == 1) { // MJ: #generalTable
        const table = "#generalTable";
        fillTable(typeTransaction, beginDate, endDate, table, 0, 1);
        $("#box-managerTable").addClass('d-none');
    } else if (type == 2) { // MJ: #managerTable
        const table = "#managerTable";
        $("#box-managerTable").removeClass('d-none');
        $("#box-coordinatorTable").addClass('d-none');
        $("#box-adviserTable").addClass('d-none');
        fillTable(typeTransaction, beginDate, endDate, table, where, 2);
    } else if (type == 3) { // MJ: #coordinatorTable
        const table = "asesor";
        // $("#box-coordinatorTable").removeClass('d-none');
        // $("#box-adviserTable").addClass('d-none');
        fillBoxAccordions(table);
    } else if (type == 4) { // MJ: #adviserTable
        const table = "#adviserTable";
        $("#box-adviserTable").removeClass('d-none');
        fillTable(typeTransaction, beginDate, endDate, table, where, 4);
    }
});

function setOptionsMiniChart(nameChart, dataChart, color, months){
    var optionsMiniChart = {
        series: [{
            name: nameChart,
            data: dataChart
        }],
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
        grid: { show: false},
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
        tooltip: { enabled: true}
    }
    return optionsMiniChart;
}

function setModalChart(){
    var optionsMiniChart = {
        series: [{
            name: "Music",
            data: [1, 15, 26, 20, 33, 27]
          },
          {
            name: "Photos",
            data: [3, 33, 21, 42, 19, 32]
          },
          {
            name: "Files",
            data: [0, 39, 52, 11, 29, 43]
          }
        ],
        chart: {
            type: 'area',
            height: '100%',
            toolbar: { show: false },
            zoom: { enabled: false },
            sparkline: {
                enabled: false
            }
        },
        colors: ["#2C93E7"],
        grid: { show: false},
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: {
            curve: 'smooth',
            width: 2,
        },
        xaxis: {
            show: true,
            labels: {show: false},
            axisBorder: {show:false},
            axisTicks: {show:false},
        },
        yaxis: {
            type: 'numeric',
            show: true,
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
        tooltip: { enabled: true}
    }
      
    var chartLine = new ApexCharts(document.querySelector('#line-adwords'), optionsMiniChart);
    chartLine.render();
}
  
$(document).on('click', '.js-accordion-title', function () {
    $(this).next().slideToggle(200);
    $(this).toggleClass('open', 200);
});

function chartDetail(e){
    console.log(e);
    $("#modalChart").modal();
    setModalChart();
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

function getSpecificChart(type){
    $.ajax({
        type: "POST",
        url: "Reporte/getSpecificChart",
        data: { type: type},
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function(data){
            $('#spiner-loader').addClass('hide');
            
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function getLastSales(){
    $.ajax({
        type: "POST",
        url: "Reporte/ventasCanceladas",
        dataType: 'json',
        cache: false,
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data){
          $('#spiner-loader').addClass('hide');
            for (const [key, value] of Object.entries(data)) {
                var color = ''; var nameChart = key; var total = 0;
                var dataChart = [];
                var objVentasCanceladas = Object.values(value);
                var months = (Object.keys(value)).slice(0, -1);
                
                for ( i = 0; i < objVentasCanceladas.length ; i++ ){
                    if( (objVentasCanceladas.length - 1) == i)
                        color = objVentasCanceladas[i];
                    else{
                        amount = objVentasCanceladas[i];
                        dataChart.push(amount);
                        if (amount == null || amount == .0) amount = 0;
                        total = total + parseInt(amount);
                    }
                }
                $("#tot"+key).text("$ "+formatMoney(total));
                var miniChart = new ApexCharts(document.querySelector("#"+key+""), setOptionsMiniChart(nameChart, dataChart, color, months));
                
                miniChart.render();
            }
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

