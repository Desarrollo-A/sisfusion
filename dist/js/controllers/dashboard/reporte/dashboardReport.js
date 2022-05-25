$('[data-toggle="tooltip"]').tooltip();

var optionsMiniChart = {
    series: [{
        name: 'Mayo',
        data: [31, 40, 28, 51, 42, 109, 100]
    },
    {
        name: 'Abril',
        data: [21, 3, 49, 28, 78, 80, 95]
    },
    {
        name: 'Marzo',
        data: [10, 26, 38, 42, 19, 40, 63]
    }],
    chart: {
        height: '100%',
        type: 'line',
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

var ventasContratadasChart = new ApexCharts(document.querySelector("#ventasContratadas"), optionsMiniChart);
ventasContratadasChart.render();

var ventasApartadasChart = new ApexCharts(document.querySelector("#ventasApartadas"), optionsMiniChart);
ventasApartadasChart.render();

var canceladasContratadasChart = new ApexCharts(document.querySelector("#canceladasContratadas"), optionsMiniChart);
canceladasContratadasChart.render();

var canceladasApartadasChart = new ApexCharts(document.querySelector("#canceladasApartadas"), optionsMiniChart);
canceladasApartadasChart.render();

//AA: Carga inicial de datatable y acordión. 
fillBoxAccordions(userType == '1' ? 'subdirector': userType == '2' ? 'gerente' : userType == '3' ? 'coordinador' : 'asesor');

function fillBoxAccordions(option){
    createAccordions(option);
    $(".js-accordion-title").addClass('open');
    $(".accordion-content").css("display", "block");

    $('#table'+option+' thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html('<input type="text" center;" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#table"+option+"").DataTable().column(i).search() !== this.value) {
                $("#table"+option+"").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    generalDataTable = $("#table"+option).dataTable({
        dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
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
                    return "$" + formatMoney(d.total);
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
                    return "$" + formatMoney(d.apartado);
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
                    return "$" + formatMoney(d.contratado);
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
                    return "$" + formatMoney(d.cancelado);
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

$(document).on('click', '.update-dataTable', function () {
    console.log("click");
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

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$(document).on('click', '.js-accordion-title', function () {
    $(this).next().slideToggle(200);
    $(this).toggleClass('open', 200);
});