let chart, rolOnReport, idUserOnReport;

document.querySelector(".c-filter__toggle").addEventListener("click", function () {
    this.classList.toggle("c-filter__toggle--active");
    document.querySelector(".c-filter__ul").classList.toggle("c-filter__ul--active");
});

function asDirector(userType){
    // 18: Fabián
    //  4: Asistente dirección administración
    // 63: Control interno
    // 33: Consulta
    // 58: Asistente de dirección general
    // 69: Dirección general
    //  2: Subidrector
    //  72: Dirección biofísica
    if (userType == '1' || userType == '18' || userType == '4' || userType == '63' || userType == '33' || userType == '69' || userType == '2' || userType == '72'){
        rolOnReport = '1';
        idUserOnReport = '2';
    }
    //  5: Asistente subdirector especificamente para los usuarios diferentes de 28 y 30
    else if( userType == '5' && (idUser == '28' || idUser == '30' || idUser == '4888')){
        rolOnReport = '1';
        idUserOnReport = '2';
    }
    
    else{
        rolOnReport = userType;
        idUserOnReport = idUser;
    }
}

var initialOptions = {
    series: [],
    chart: {
        type: 'area',
        height: '100%',
        toolbar: { show: false },
        zoom: { enabled: false },
        sparkline: {
            enabled: true
        }
    },
    colors: [],
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
    dataLabels: { enabled: false },
    legend: { show: false },
    stroke: {
        curve: 'smooth',
        width: `1`,
    },
    xaxis: {
        categories: [],
        labels: {show: false},
        axisBorder: {show:false},
        axisTicks: {show:false},
    },
    yaxis: {
        labels: {
            show: false,
            formatter: function (value) {
                return value;
            }
        },
        axisBorder: {show:false},
        axisTicks: {show:false},
    },
    fill: {
        opacity: 0,
        type: 'gradient',
        gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 1,
            gradientToColors:  [],
            inverseColors: true,
            opacityFrom: 0.60,
            opacityTo: 0.2,
            stops: [0, 70, 100],
            colorStops: []
        }
    },
    tooltip: { enabled: false},
    markers: {
        size: `5`,
        colors: '#143860',
        strokeColors: [],
        strokeWidth: `3`,
        hover: {
            size: `3`
        }
    }
}

function readyReport(){
    $('[data-toggle="tooltip"]').tooltip();
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValuesReporte();
    initReport();
    chart = new ApexCharts(document.querySelector("#boxModalChart"), initialOptions);
    chart.render();
    $('[data-toggle="tooltip"]').tooltip();
    setListEstatus();
}

async function initReport(){
    asDirector(userType);
    filters = validateFilters();
    getLastSales(filters, rolOnReport);
    // let rol = userType == 2 ? await getRolDR(idUser): userType;
    
    let rolString;
    if ( rolOnReport == '1' )
        rolString = 'director_regional';
    else if ( rolOnReport == '2' || (rolOnReport == '5' && (idUserOnReport != '28' || idUserOnReport != '30' || idUserOnReport != '4888')))
        rolString = 'gerente';
    else if ( rolOnReport == '3' || rolOnReport == '6' )
        rolString = 'coordinador';
    else if ( rolOnReport == '59' || (rolOnReport == '5' && (idUserOnReport == '28' || idUserOnReport == '30' || idUserOnReport == '4888')))
        rolString = 'subdirector';
    else 
        rolString = 'asesor';
    
    fillBoxAccordions(rolString, rolOnReport, idUserOnReport, 1, 1, [0, null, null, null, null, null, rolOnReport], filters);
}

function validateFilters(fechaInicio = null, fechaFin = null){
    filters = [];
    //Filtros con enganche / sin enganche
    let selector1 = $('#typeSale1')[0];
    let selector2 = $('#typeSale2')[0];
    //Tipo de lote
    let selector3 = $('#typeLote1')[0];
    let selector4 = $('#typeLote2')[0];
    // Con casa / sin casa
    let selector5 = $('#typeBuild1')[0];
    let selector6 = $('#typeBuild2')[0];
    //Rango de fechas
    let beginDate = (fechaInicio == null) ? $('#tableBegin').val() : fechaInicio;
    let endDate = (fechaFin == null) ? $('#tableEnd').val() : fechaFin;
    //Estauts de contratación
    let estatus = $("#estatusContratacion").val();

    filters.push({
        typeSale: (selector1.checked && !selector2.checked) ? selector1.value : (selector2.checked && !selector1.checked) ? selector2.value : ( selector1.checked && selector2.checked ) ? 3 : 0,
        typeLote: (selector3.checked && !selector4.checked) ? selector3.value : (selector4.checked && !selector3.checked) ? selector4.value : ( selector3.checked && selector4.checked ) ? 3 : 0,
        typeConstruccion: (selector5.checked && !selector6.checked) ? selector5.value : (selector6.checked && !selector5.checked) ? selector6.value : ( selector5.checked && selector6.checked ) ? 3 : 0,
        begin: beginDate,
        end: endDate,
        estatus: estatus
    });

    return filters;
}

/* Función para cambiar icono y cerrar o abrir tabla*/

function changeIcon(anchor) {
    anchor.closest('.wrapper .boxTabla').classList.toggle('active');
    $(document).off('click', '.accordionToggle').on('click', '.accordionToggle', function () {
        $(this).parent().next().slideToggle(200);
        $(this).toggleClass('open', 200);
    });
}

function createAccordions(option, render, rol){
    let tittle = getTitle(option);
    let html = '';
    html = `<div data-rol="${rol}" class="bk ${render == 1 ? 'parentTable': 'childTable'}">
                <div class="d-flex justify-between align-center boxTabla">   
                    <div class="cursor-point accordionToggle">
                        <a class="purple-head hover-black" onclick="changeIcon(this)" id="myBtn">
                        <i class="less fas fa-angle-down "></i>
                        <i class="more fas fa-angle-up "></i>
                        </a>
                    </div>
                    <div>
                        <h4 class="p-0">`+tittle+`</h4>
                    </div>
                    <div>
                        ${render == 1 ? '': '<i class="fas fa-times deleteTable"></i>'}
                    </div>
                </div>
            <div class="accordion-content">
                <table class="table-striped table-hover" id="table`+option+`" name="table`+option+`">
                    <thead>
                        <tr>
                            <th class="detail">MÁS</th>
                            <th class="encabezado">`+option.toUpperCase()+`</th>
                            <th>GRAN TOTAL</th>
                            <th>MONTO</th>
                            <th>NÚMERO DE LOTES APARTADOS</th>
                            <th>APARTADO</th>
                            <th>CANCELADOS</th>
                            <th>PORCENTAJE DE CANCELADOS</th>
                            <th>NÚMERO DE LOTES CONTRATADOS</th>
                            <th>CONTRATADOS</th>
                            <th>CANCELADOS</th>
                            <th>PORCENTAJE DE CANCELADOS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>`;
    $(".boxAccordions").append(html);
}

function fillBoxAccordions(option, rol, id_usuario, render, transaction, leadersList, filters){
    if( rol == 5 && (idUser == 28 && idUser == 30 && idUser == 4888))
        rolEspecial = 59;
    else if( rol == 5 && (idUser != 28 && idUser != 30 && idUser != 4888))
        rolEspecial = 2;
    else if( rol == 6 )
        rolEspecial = 3;
    else if( rol == 4 || rol == 33 || rol == 58 || rol == 63 || rol == 69)
        rolEspecial = 2;
    else rolEspecial = rol;

    createAccordions(option, render, rolEspecial);
    let newRol = newRoles(option);
    $(".js-accordion-title").addClass('open');
    $(".accordion-content").css("display", "block");
    if(render == 1){
        $("#chartButton").data('option', option);
    }

    $('#table'+option+' thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}"placeholder="${title}"/>`);    
        if(i > 1 && i <10){
            $('input', this)[0].type = 'number';
            $('input', this).addClass('no-spin');
        }
        $('input', this).on('keyup change', function () {
            if(i != 0){
                if ($("#table"+option+"").DataTable().column(i).search() !== this.value) {
                    $("#table"+option+"").DataTable().column(i)
                        .search(this.value).draw();
                }  
            }
        });
        $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
    });

    generalDataTable = $("#table"+option).DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Reporte de ventas por '+option ,
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 1:
                                    return option;
                                    break;
                                case 2:
                                    return 'GRAN TOTAL'
                                    break;
                                case 3:
                                    return 'MONTO';
                                    break;
                                case 4:
                                    return 'NÚMERO DE LOTES APARTADOS';
                                    break;
                                case 5:
                                    return 'APARTADO';
                                    break;
                                case 6:
                                    return 'CANCELADOS';
                                    break;
                                case 7:
                                    return 'PORCENTAJE DE CANCELADOS';
                                    break;
                                case 8:
                                    return 'NÚMERO DE LOTES CONTRATADOS';
                                    break;
                                case 9:
                                    return 'CONTRATADOS';
                                    break;
                                case 10:
                                    return 'CANCELADOS';
                                    break;
                                case 11:
                                    return 'PORCENTAJE DE CANCELADOS';
                                    break;
                            }
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
                data: function(d){
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button type="btn" data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnSub"  data-toggle="tooltip" data-placement="bottom" title="DESGLOSE A DETALLE"><i class="fas fa-sitemap" ></i></button>`;
                }
            },
            {
                data: function (d) {
                    return d.nombreUsuario;
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="5" data-sede = 0 data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnModalDetails">${(d.totalAT + d.totalConT).toLocaleString('es-MX')}</button>`;
                }
            },
            {
                data: function (d) {
                    return "<b>" + d.gran_total +"</b>"; // MJ: SUMA GRAN TOTAL
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="1" data-sede = 0 data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnModalDetails">${(d.totalAT).toLocaleString('es-MX')}</button>`;
                }
            },
            {
                data: function (d) {
                    return "<b>" + d.sumaAT+"</b>"; //SUMA APARTADOS
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="4" data-sede = 0 data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnModalDetails">${(d.totalCanA).toLocaleString('es-MX')}</button>`; //# CANCELADOS APARTADOS;
                }
            },
            {
                data: function (d) {
                    return d.porcentajeTotalCanA + "%"; //PORCENTAJE CANCELADOS APARTADOS
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="2" data-sede = 0 data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnModalDetails">${(d.totalConT).toLocaleString('es-MX')}</button>`; //# CONTRATADOS;
                }
            },
            {
                data: function (d) {
                    return "<b>" + d.sumaConT +"</b>"; //SUMA CONTRATADOS
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario); 
                    return `<button style="background-color: #d8dde2; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-sede = 0 data-type="3" data-option="${option}" data-transaction="${transaction}" data-rol="${newRol}" data-render="${render}" data-idUser="${d.userID}" id="details-${d.userID}" data-leader="${id_usuario}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" class="btnModalDetails">${(d.totalCanC).toLocaleString('es-MX')}</button>`; //# CANCELADOS CONTRATADOS;
                }
            },
            {
                data: function (d) {
                    return d.porcentajeTotalCanC + "%"; //PORCENTAJE CANCELADOS CONTRATADOS
                }
            },
            {
                data: function (d) {
                    let leaders = getLeadersLine(leadersList, d.userID, id_usuario);                    
                    return  rol == 7 || (rol == 9 && render == 1) ? '' : `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas update-dataTable" data-transaction="${transaction}" data-type="${rol}" data-render="${render}" value="${d.userID}" data-as="${leaders[1]}" data-co="${leaders[2]}" data-ge="${leaders[3]}" data-su="${leaders[4]}" data-dr="${leaders[5]}" data-toggle="tooltip" data-placement="bottom" title = "ACCIONES "><i class="fas fa-sign-in-alt"></i></button></div>`;
                }
            },
        ],
        columnDefs: [{
            className: "delimetter", "targets": [ 3, 7 ],
        },{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: `${base_url}Reporte/getInformation`,
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": transaction,
                "where": '1',
                "type": rol,
                "id_usuario": id_usuario,
                "render": render,
                "asesor": leadersList[1],
                "coordinador": leadersList[2],
                "gerente": leadersList[3],
                "subdirector": leadersList[4],
                "regional": leadersList[5],
                "filters" : filters
            }
        },
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip()
        }
    });
}


// 0: Lo que ve a setear
// 1:  Asesor
// 2: Corrdinador
// 3: Gerente
// 4: Subirector
// 5: DIRECTOR REGIONAL
// 6: Rol
function getLeadersLine (leadersList, id_usuario, id_lider) {  
    if (leadersList[0] == 0 && (leadersList[6] == 1 || leadersList[6] == 4 || leadersList[6] == 33 || leadersList[6] == 58 || leadersList[6] == 63 || leadersList[6] == 69)){ // PRIMER NIVEL: SÓLO TENEMOS EL ID REGIONAL
        leadersList[5] = id_usuario;
    }
    else if (leadersList[0] == 2){ // SEGUNDO NIVEL: TENEMOS EL ID SUBDIRECTOR
        leadersList[4] = id_usuario;
    }
    else if (leadersList[0] == 3){ // TERCER NIVEL: TENEMOS EL ID GERENTE
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 9){ // CUARTO NIVEL: TENEMOS EL ID COORDINADOR
        leadersList[2] = id_usuario;
    }
    else if (leadersList[0] == 7){ // 5 NIVEL: TENEMOS EL ID COORDINADOR
        leadersList[1] = id_usuario;
    }
    else if (leadersList[0] == 0 && (leadersList[6] == 59 || (leadersList[6] == 5 && (idUser == 28 || idUser == 30 || idUser == 4888)))) { // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        if(id_usuario == 3 || id_usuario == 607)
            leadersList[5] = 0;
        else
            leadersList[5] = leadersList[6] == 59 ? id_lider : idLider;
        leadersList[4] = id_usuario;
    }
    else if (leadersList[6] == 5 && (idUser != 28 || idUser != 30 || idUser != 4888)) { 
        // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        if( idLider == 7092 )
            leadersList[5] = 3;
        else if ( idLider == 681 || idLider == 9471 )
            leadersList[5] = 607;
        else leadersList[5] = 0;

        leadersList[4] = idLider;
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 2 ) {
        leadersList[5] = ( idLider == 3 || idLider == 607 ) ? idLider : 0;
        leadersList[4] = id_lider;
        leadersList[3] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 3 ) { // PRIMER NIVEL: TENEMOS ID REGIONAL Y ID SUBDIRECTOR
        leadersList[5] = 0;
        leadersList[4] = 0;
        leadersList[3] = id_lider;
        leadersList[2] = id_usuario;
    }
    else if (leadersList[0] == 0 && leadersList[6] == 6  ){
        //Asistente de gerente
        leadersList[5] = 0;
        leadersList[4] = 0;
        leadersList[3] = idLider;
        leadersList[2] = id_usuario;
    }
    return leadersList;
}

$(document).on('click', '.update-dataTable', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    let closestChild;
    const asesor = $(this).attr("data-as");
    const coordinador = $(this).attr("data-co");
    const gerente = $(this).attr("data-ge");
    const subdirector = $(this).attr("data-su");
    const regional = $(this).attr("data-dr");
    const type = $(this).attr("data-type");
    const render = $(this).data("render");
    const transaction = $(this).data("transaction");
    closestChild = $(this).closest('.childTable');
    closestChild = closestChild.length == 0 ?  $(this).closest('.parentTable'):$(this).closest('.childTable');
    closestChild.nextAll().remove();
    
    let filters = validateFilters();

    if (type == 2 ) { // MJ: #sub->ger->coord
        if (render == 1) {
            const table = "coordinador";
            fillBoxAccordions(table, 9, $(this).val(), 2, transaction, [9, asesor, coordinador, gerente, subdirector, regional, type], filters); 
        } else {
            const table = "gerente";
            fillBoxAccordions(table, 3, $(this).val(), 2, transaction, [3, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS GERENTES
        }
    } else if (type == 3 || type == 6 ) { // MJ: #gerente->coord->asesor
        if (render == 1) {
            const table = "asesor";
            fillBoxAccordions(table, 7, $(this).val(), 2, transaction, [7, asesor, coordinador, gerente, subdirector, regional, type], filters);
        } else {
            const table = "coordinador";
            fillBoxAccordions(table, 9, $(this).val(), 2, transaction, [9, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS COORDINADORES
        }
    } else if (type == 9) { // MJ: #coordinatorTable -> asesor
        if (render == 1) {
        } else {
            const table = "asesor";
            fillBoxAccordions(table, 7, $(this).val(), 2, transaction, [7, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS ASESORES
        }
    } else if (type == 59) { // MJ: #DirRegional->subdir->ger
        if (render == 1) {
            const table = "gerente";
            fillBoxAccordions(table, 3, $(this).val(), 2, transaction, [3, asesor, coordinador, gerente, subdirector, regional, type], filters);
        } else {
            const table = "subdirector";
            fillBoxAccordions(table, 2, $(this).val(), 2, transaction, [59, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS SUBDIRECTORES: CONSULTA REGIONAL
        }
    } else if (type == 1 || type == 4 || type == 33 || type == 58 || type == 63 || type == 69) {
        if (render == 1) {
            const table = "subdirector";
            fillBoxAccordions(table, 2, $(this).val(), 2, transaction, [2, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS SUBDIRECTORES
        } else {
            const table = "regional";
            fillBoxAccordions(table, 59, $(this).val(), 2, transaction, dates);
        }
    }
    else if (type == 5) { // MJ: #subdirector
        if (render == 1) {
            if(idUser == 28 || idUser == 30 || idUser == 4888){
                const table = "gerente";
                fillBoxAccordions(table, 2, $(this).val(), 2, transaction, [3, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS SUBDIRECTORES: CONSULTA REGIONAL
            }
            else{
                const table = "coordinador";
                fillBoxAccordions(table, 9, $(this).val(), 2, transaction, [9, asesor, coordinador, gerente, subdirector, regional, type], filters); // VA POR LOS COORDINADORES
            }
        } 
    }
});


function setOptionsChartReport(series, categories, miniChart, type= null){
    (series.length > 1 && type == 1) ? colors=  ['#0089B7','#C25E5E', '#00CDA3', '#EB7B90']:(series.length > 1 && (type == 0 || type == null)) ? colors = ["#2C93E7", "#d9c07b"]:colors = ["#2C93E7"]

    var optionsMiniChart = {
        series: series,
        chart: {
            type: 'area',
            height:  type==1 ? '90%': '100%',
            width:   type==1 ? '90%': '100%',
            toolbar: { show: false },
            zoom: { enabled: false },
            sparkline: {
                enabled: type==1 ? false: true
            },
            offsetX: type==1 ? 0: 0
        },
        colors: colors,
        grid: { show: false},
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: {
            curve: 'smooth',
            width: `${ ( miniChart == 0 ) ? 3 : 2 }`,
        },
        xaxis: {
            show: type==1 ? true: false,
            categories: categories,
            labels: {show: false},
            formatter: function (value) {
                return '';
            },
            axisBorder: {show:type==1 ? true: false},
            axisTicks: {show:type==1 ? true: false},
        },
        yaxis: {
            labels: {
                show: type==1 ? true: false,
                formatter: function (value) {
                    let format = type != null ? value: "$" + formatMoney(value);
                    return format;
                },
                style: {
                    colors: '#eaeaea',
                },
                offsetX: -15
            },
            axisBorder: {show:type==1 ? true: false},
            axisTicks: {show:type==1 ? true: false},
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
                opacityFrom: 0.60,
                opacityTo: 0.2,
                stops: [0, 70, 100],
                colorStops: []
            }
        },
        tooltip: { 
            enabled: true,
            y: {
                formatter: function(value, { series, seriesIndex, dataPointIndex, w }){
                    let total = 0;
                    series.forEach(function(element){
                        total = total + element[dataPointIndex];
                    })
                    let percent = value * 100 / total;
                    let ret = type == 1 ? `${value.toLocaleString('es-MX')} (${Math.trunc( percent )}%)`: "$" + formatMoney(value);
                    return ret;
                }  
            },
        },
        markers: {
            size: `${ ( miniChart == 0 ) ? 5 : 0 }`,
            colors: '#143860',
            strokeColors: colors,
            strokeWidth: `${ ( miniChart == 0 ) ? 3 : 0 }`,
            hover: {
                size: `${ ( miniChart == 0 ) ? 8 : 3 }`
            }
        }
    }
    return optionsMiniChart;
}

$(document).off('click', '.js-accordion-title').on('click', '.js-accordion-title', function () {
    $(this).parent().parent().next().slideToggle(200);
    $(this).toggleClass('open', 200);
});

$(document).on('click', '.deleteTable', function () {
    accordionToRemove($(this).parent().parent().parent().data( "rol" ));
});

$(document).on('click', '.btnSub', function () {
    let data = {
        transaction: $(this).data("transaction"),
        render: $(this).data("render"),
        user: $(this).data("iduser"),
        rol: $(this).data("rol"),
        table: $(this).closest('table'),
        thisVar: $(this),
        option: $(this).data("option"),
        leader: $(this).data("leader"),
        asesor: $(this).data("as"),
        coordinador: $(this).data("co"),
        gerente: $(this).data("ge"),
        subdirector: $(this).data("su"),
        regional: $(this).data("dr")
    }
    initDetailRow(data);
});

$(document).on('click', '#filterAction', async function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $(".boxAccordions").html('');
    loaderCharts();

    filters = validateFilters();

    let rolString;
    if ( rolOnReport == '1' )
        rolString = 'director_regional';
    else if ( rolOnReport == '2' || (rolOnReport == '5' && (idUserOnReport != '28' || idUserOnReport != '30' || idUserOnReport != '4888')))
        rolString = 'gerente';
    else if ( rolOnReport == '3' || rolOnReport == '6' )
        rolString = 'coordinador';
    else if ( rolOnReport == '59' || (rolOnReport == '5' && (idUserOnReport == '28' || idUserOnReport == '30' || idUserOnReport == '4888')))
        rolString = 'subdirector';
    else 
        rolString = 'asesor';
    
    getLastSales(filters, rolOnReport);
    fillBoxAccordions(rolString, rolOnReport, idUserOnReport, 1, 2, [0, null, null, null, null, null, rolOnReport], filters);
});

$(document).on('click', '.chartButton', function () {
    $(".datesModal").hide();
    $("#modalChart .boxModalTitle .title").html('');
    $("#modalChart .boxModalTitle .total").html('');
    let option = $('#chartButton').data('option');
    let title = getTitle(option);
    $("#modalChart .boxModalTitle .title").append(`${title}`);
    $('#modalChart').modal();
    let table = $(`#table${option}`);
    var tableData = table.DataTable().rows().data().toArray();
    generalChart(tableData);
});

async function chartDetail(e, tipoChart){
    $(".datesModal").show();
    $("#modalChart").modal();
    $("#modalChart .boxModalTitle .title").html('');
    $("#modalChart .boxModalTitle .total").html('');
    $("#modalChart #type").val('');

    var nameChart = (titleCase($(e).data("name").replace(/_/g, " "))).split(" ");
    $(".boxModalTitle .title").append('<p class="mb-1">' + nameChart[0] + '<span class="enfatize"> '+ nameChart[1] +'</span></p>');
    let fecha_inicio = $('.moreMiniChart ').attr('data-fi');
    let fecha_fin    = $('.moreMiniChart ').attr('data-ft');
    if(fecha_inicio == undefined || fecha_fin==undefined){
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
    }
    else{
        finalBeginDate2 = fecha_inicio;
        finalEndDate2 = fecha_fin;
    }

    $("#modalChart #fechaInicioVentas").val(finalBeginDate2);
    $("#modalChart #fechaFinVentas").val(finalEndDate2);
    $("#modalChart #type").val(tipoChart);
    filters = validateFilters();
    getSpecificChart(tipoChart, formatDate(finalBeginDate2), formatDate(finalEndDate2), filters);
}

function searchByDateRange() {
    const fechaInicio = $('#fechaInicioVentas').val();
    const fechaFin    = $('#fechaFinVentas').val();
    const filters = validateFilters(fechaInicio, fechaFin);
    getSpecificChart($("#modalChart #type").val(), formatDate(fechaInicio), formatDate(fechaFin), filters);
}

function getSpecificChart(type, beginDate, endDate, filters){
    $('.loadChartModal').removeClass('d-none');
    $.ajax({
        type: "POST",
        url: `${base_url}Reporte/getDataChart`,
        data: {
            general: 0, 
            tipoChart: type, 
            beginDate: beginDate, 
            endDate: endDate, 
            filters: filters, 
            type: rolOnReport,
            render: 1
        },
        dataType: 'json',
        cache: false,
        success: function(data){
            $('.loadChartModal').addClass('d-none');
            var miniChart = 0;
            var orderedArray = orderedDataChart(data);
            let { categories, series } = orderedArray[0];
            let total = 0;
            series.forEach(element => {
                total = total + element.data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
            });
            $("#modalChart .boxModalTitle .total").html('');
            $("#modalChart .boxModalTitle .total").append('<p>$'+formatMoney(total)+'</p>');
            if ( total != 0 ){
                chart.updateOptions(setOptionsChartReport(series, categories, miniChart));
            }
            else{
                $("#boxModalChart").html('');
                $("#boxModalChart").addClass('d-flex justify-center');
                $("#boxModalChart").append('<img src="'+base_url+'dist/img/emptyCharts.png" alt="Icono gráfica" class="h-70 w-auto">');
            }
        },
        error: function() {
            $('.loadChartModal').addClass('d-none');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function getLastSales(filters, rol){
    $('.loadChartMini').removeClass('d-none');
    $.ajax({
        type: "POST",
        url: `${base_url}Reporte/getDataChart`,
        data: {
            general: 1, 
            tipoChart:'na',
            filters: filters,
            type: rol,
            render: 1
        },
        dataType: 'json',
        cache: false,
        success: function(data){
            $('.loadChartMini').addClass('d-none');
            $('.money').removeClass('d-none');
            let miniChart = 1, total = 0;
            let orderedArray = orderedDataChart(data);
            for ( i=0; i<orderedArray.length; i++ ){
                let { chart, categories, series } = orderedArray[i];
                total = 0;
                for ( j=0; j < series.length; j++ ){
                    total += series[j].data.reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                }

                $("#tot"+chart).text("$"+formatMoney(total));
                if ( total != 0 ){
                    $("#"+chart+"").html('');
                    $("#"+chart+"").removeClass('d-flex justify-center');
                    var miniChartApex = new ApexCharts(document.querySelector("#"+chart+""), setOptionsChartReport(series, categories, miniChart));
                    miniChartApex.render();
                }
                else {
                    $("#"+chart+"").html('');
                    $("#"+chart+"").addClass('d-flex justify-center');
                    $('#'+chart+"").append( "<img src='"+base_url+"/dist/img/emptyCharts.png' alt='Icono gráfica' class='h-70 w-auto'>");
                }
            }
        },
        error: function() {
          $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}



function loaderCharts(){
    $("#modalChart .boxModalTitle .total").html('');
    $('.appliedFilter').removeAttr('data-toggle');
    $('.appliedFilter').removeAttr('data-original-title');
    let fechaInicio= $('#tableBegin').val();
    let fechaTermino= $('#tableEnd').val();
    $('.appliedFilter .selectMini').html('');
    $('.appliedFilter .selectMini').append('Del: '+fechaInicio+' al: '+fechaTermino+'');
    $('.appliedFilter').attr('data-toggle', 'tooltip');
    $('.appliedFilter').attr('data-placement', 'bottom');
    $('.appliedFilter').attr('data-original-title', 'Del: '+$('#tableBegin').val()+' al: '+$('#tableEnd').val());

    $('.money').addClass('d-none');
    $('.boxMiniCharts').html('');
    let cargador = '<div class="loadChartMini w-100 h-100">'+
                        '<img src="'+base_url+'dist/img/miniChartLoading.gif" alt="Icono gráfica" class="h-100 w-auto">'+
                    '</div>';
    $('.boxMiniCharts').append('<div class="col-xs-12 pdt-20"><center><span class="loader center-align"></span></center></div>');
    $('.boxMiniCharts').append(cargador);

    //add attr al miniboton para que al abrir tenga la fecha seteada
    $('.moreMiniChart').attr('data-fi', fechaInicio);
    $('.moreMiniChart').attr('data-ft', fechaTermino);
};

function orderedDataChart(data){
    let allData = [], totalMes = [], meses = [], series = [];
    for( i=0; i<data.length; i++){
        let { tipo, rol, total, mes, año } = data[i];

        nameTypeChart = `${ (tipo == 'vc') ? 'ventasContratadas' : (tipo == 'va') ? 'ventasApartadas' : (tipo == 'cc') ? 'canceladasContratadas' : (tipo == 'ca') ? 'canceladasApartadas' : 'ventasTotales' }`;

        nameSerie = `${ (rol == '9') ? 'Coordinador' : (rol == '7') ? 'Asesor' : (tipo == 'vc') ? 'ventasContratadas' : (tipo == 'va') ? 'ventasApartadas' : (tipo == 'cc') ? 'canceladasContratadas' : (tipo == 'ca' ) ? 'canceladasApartadas' : 'ventasTotales' }`;

        totalMes.push( (total != null) ? parseFloat(total.replace(/[^0-9.-]+/g,"")) : 0 );
        if( (i+1) < data.length ){
            if(tipo == data[i + 1].tipo){
                if(rol != data[i + 1].rol){
                    buildSeries(series, nameSerie, totalMes);
                    totalMes = [];
                    meses = [];
                }
                else meses.push(monthName(mes) + ' ' + año);         
            }
            else{
                meses.push(monthName(mes) + ' ' + año);
                buildSeries(series, nameSerie, totalMes);
                buildAllDataChart(allData, nameTypeChart, series, meses);
                series = [];
                totalMes = [];
                meses = [];
            }
        }
        else{
            meses.push(monthName(mes) + ' ' + año);
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

function monthName(mon){
    var monthName = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][mon - 1];
    return monthName;
}

function getRolDR(idUser){
    return new Promise(resolve => {      
        $.ajax({
            type: "POST",
            url: `${base_url}Reporte/getRolDR`,
            data: {idUser: idUser},
            dataType: 'json',
            cache: false,
            beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
            },
            success: function(data){
                $('#spiner-loader').addClass('hide');
                if (data.length > 0){
                    resolve (59);
                }
                else{
                    resolve (2);

                }
                // resolve (data.length > 0 ? 59:2);
            },
            error: function() {
            $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });
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

function getTitle(option){
    var title;
    switch (option) {
        case 'director_regional':
          title = 'Reporte de ventas por dirección regional';
          break;
        case 'gerente':
            title = 'Reporte de ventas por gerencia';
            break;
        case 'coordinador':
            title = 'Reporte de ventas por coordinación';
            break;
        case 'subdirector':
            title = 'Reporte de ventas por subdirección';
            break;
        case 'asesor':
            title = 'Reporte de ventas por asesor';
            break;
        default:
            title = 'N/A';
        }
    return title;
};

function accordionToRemove(rol){
    $(".boxAccordions").find(`[data-rol='${rol}']`).remove();
    switch (rol) {
        case 7://asesor
            //solo se borra asesor
            break;
        case 9://coordinador
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 3://gerente
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 6://asistente gerente
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 2://subdir
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 5://asistente subdir
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break; 
        case 1://dir
            $(".boxAccordions").find(`[data-rol='${59}']`).remove();
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break; 
        case 4://asistente dir
            $(".boxAccordions").find(`[data-rol='${1}']`).remove();
            $(".boxAccordions").find(`[data-rol='${59}']`).remove();
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 18: // Dir
        case 33: // Consulta (Yola)
        case 58: // Asistente dirección general
        case 63: // Control interno
        case 69: // Dirección general
        case 72: // Dirección biofísica
            $(".boxAccordions").find(`[data-rol='${59}']`).remove();
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 59://dir regional
        case 5://dir regional
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        case 60://asistente dir regional
            $(".boxAccordions").find(`[data-rol='${59}']`).remove();
            $(".boxAccordions").find(`[data-rol='${2}']`).remove();
            $(".boxAccordions").find(`[data-rol='${3}']`).remove();
            $(".boxAccordions").find(`[data-rol='${9}']`).remove();
            $(".boxAccordions").find(`[data-rol='${7}']`).remove();
            break;
        default:
            break;
    }
}

function initDetailRow(dataObj){
    var detailRows = [];
    var tr = $(`#details-${dataObj.user}`).closest('tr');
    // var table = $(`#details-${dataObj.user}`).closest('table');
    var row = $(`#table${dataObj.option}`).DataTable().row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows);
    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        createDetailRow(row, tr, dataObj);
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
}

function createDetailRow(row, tr, dataObj){
    filters = validateFilters();
    $.post(`${base_url}Reporte/getDetails`, {
        id_usuario: dataObj.user,
        rol: dataObj.rol,
        render:  dataObj.render,
        transaction: dataObj.transaction,
        leader: dataObj.leader,
        asesor: dataObj.asesor,
        coordinador: dataObj.coordinador,
        gerente: dataObj.gerente,
        subdirector: dataObj.subdirector,
        regional: dataObj.regional,
        filters: filters
    }).done(function (response) {
        row.data().sedesData = JSON.parse(response);
        
        $(`#table${dataObj.option}`).DataTable().row(tr).data(row.data());
        row = $(`#table${dataObj.option}`).DataTable().row(tr);
        row.child(buildTableDetail(row.data().sedesData, dataObj)).show();
        tr.addClass('shown');
        dataObj.thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function buildTableDetail(data, dataObj) {
    var sedes = '<table class="table subBoxDetail">';
    sedes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    sedes += '<td>' + '<b>' + '# ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'SEDE ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'GRAN TOTAL ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'MONTO ' + '</b></td>';
    sedes += '<td>' + '<b>' + '# DE LOTES APARTADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'APARTADO ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'CANCELADO APARTADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + '% CANCELADOS APARTADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + '# DE LOTES CONTRATADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'CONTRATADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + 'CANCELADOS CONTRATADOS ' + '</b></td>';
    sedes += '<td>' + '<b>' + '% CANCELADOS CONTRATADOS ' + '</b></td>';
    sedes += '</tr>';
    $.each(data, function (i, v) {
        //i es el indice y v son los valores de cada fila
        sedes += '<tr>';
        sedes += '<td> ' + (i + 1) + ' </td>';
        sedes += '<td> ' + v.sede + ' </td>';
        sedes += `<td><button style="background-color: #cfcdcd; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="55" data-sede="${v.id_sede}" data-rol="${dataObj.rol}" data-render="${dataObj.render}" data-idUser="${dataObj.user}" data-leader="${dataObj.leader}" data-as="${dataObj.asesor}" data-co="${dataObj.coordinador}" data-ge="${dataObj.gerente}" data-su="${dataObj.subdirector}" data-dr="${dataObj.regional}" id="details-${dataObj.user}" class="btnModalDetails">${(v.totalAT + v.totalConT).toLocaleString('es-MX')}</button>`;
        sedes += '<td> ' + v.gran_total + ' </td>';
        sedes += `<td><button style="background-color: #cfcdcd; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="11" data-sede="${v.id_sede}" data-rol="${dataObj.rol}" data-render="${dataObj.render}" data-idUser="${dataObj.user}" id="details-${dataObj.user}" data-as="${dataObj.asesor}" data-co="${dataObj.coordinador}" data-ge="${dataObj.gerente}" data-su="${dataObj.subdirector}" data-dr="${dataObj.regional}" class="btnModalDetails">${(v.totalAT).toLocaleString('es-MX')}</button>`;
        //sedes += '<td> ' + (v.totalAT).toLocaleString('es-MX') + ' </td>';
        sedes += '<td> ' + v.sumaAT + ' </td>';
        sedes += `<td><button style="background-color: #cfcdcd; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="44" data-sede="${v.id_sede}" data-rol="${dataObj.rol}" data-render="${dataObj.render}" data-idUser="${dataObj.user}" id="details-${dataObj.user}" data-as="${dataObj.asesor}" data-co="${dataObj.coordinador}" data-ge="${dataObj.gerente}" data-su="${dataObj.subdirector}" data-dr="${dataObj.regional}" class="btnModalDetails">${(v.totalCanA).toLocaleString('es-MX')}</button>`;
        //sedes += '<td> ' + (v.totalCanA).toLocaleString('es-MX') + ' </td>';
        sedes += '<td> ' + v.porcentajeTotalCanA + '% </td>';
        sedes += `<td><button style="background-color: #cfcdcd; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="22" data-sede="${v.id_sede}" data-rol="${dataObj.rol}" data-render="${dataObj.render}" data-idUser="${dataObj.user}" id="details-${dataObj.user}" data-as="${dataObj.asesor}" data-co="${dataObj.coordinador}" data-ge="${dataObj.gerente}" data-su="${dataObj.subdirector}" data-dr="${dataObj.regional}" class="btnModalDetails">${(v.totalConT).toLocaleString('es-MX')}</button>`;
        //sedes += '<td> ' + (v.totalConT).toLocaleString('es-MX') + ' </td>';
        sedes += '<td> ' + v.sumaConT + ' </td>';
        sedes += `<td><button style="background-color: #cfcdcd; border: none; border-radius: 30px; width: 70px; height: 27px; font-weight: 600;" type="btn" data-type="33" data-sede="${v.id_sede}" data-rol="${dataObj.rol}" data-render="${dataObj.render}" data-idUser="${dataObj.user}" id="details-${dataObj.user}" data-as="${dataObj.asesor}" data-co="${dataObj.coordinador}" data-ge="${dataObj.gerente}" data-su="${dataObj.subdirector}" data-dr="${dataObj.regional}" class="btnModalDetails">${(v.totalCanC).toLocaleString('es-MX')}</button>`;
        //sedes += '<td> ' + (v.totalCanC).toLocaleString('es-MX') + ' </td>';
        sedes += '<td> ' + v.porcentajeTotalCanC + '% </td>';
        sedes += '</tr>';
    });
    return sedes += '</table>';
}

async function setInitialValuesReporte() {
    // BEGIN DATE
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

    $('#tableBegin').val(finalBeginDate2);
    $('#tableEnd').val(finalEndDate2);
}

function titleCase(string){
    return string[0].toUpperCase() + string.slice(1).toLowerCase();
}

function generalChart(data){
    let x = [];
    let apartados = [];
    let apartadosC = [];
    let contratados = [];
    let contratadosC = [];
    data.forEach(element => {
        if(data.length>1){
            x.push(element.nombreUsuario);
            apartados.push(element.totalAT);
            apartadosC.push(element.totalCanA);
            contratados.push(element.totalConT);
            contratadosC.push(element.totalCanC);    
        }else{
            $("#boxModalChart").html('');
            $("#boxModalChart").addClass('d-flex justify-center');
            $("#boxModalChart").append('<img src="'+base_url+'dist/img/emptyCharts.png" alt="Icono gráfica" class="h-70 w-auto">');
            x = ['', element.nombreUsuario, ''];
            apartados=[0,element.totalAT,0];
            apartadosC=[0,element.totalCanA,0];
            contratados=[0,element.totalConT,0];
            contratadosC=[0,element.totalCanC,0];    
        }
    });
    let series = [
        {
            name: 'Apartados',
            data: apartados
        },
        {
            name: 'Cancelados apartados',
            data: apartadosC
        },
        {
            name: 'Contratados',
            data: contratados
        },
        {
            name: 'Cancelados contratados',
            data: contratadosC
        }
    ];
    chart.updateOptions(setOptionsChartReport(series, x, 0, 1));
    $('.loadChartModal').addClass('d-none');
}

function newRoles(option) {
    var rol;
    switch (option) {
        case 'director_regional':
            rol = 59;
            break;
        case 'gerente':
            rol = 3;
            break;
        case 'coordinador':
            rol = 9;
            break;
        case 'subdirector':
            rol = 2;
            break;
        case 'asesor':
            rol = 7;
            break;
        default:
            rol = 'N/A';
    }
    return rol;
}

$(document).on('click', '.btnModalDetails', function () {
    let dataObject = {
        type: $(this).data("type"),
        sede: $(this).data("sede"),
        leader: $(this).data("leader"),
        transaction: $(this).data("transaction"),
        user: $(this).data("iduser"),
        rol: $(this).data("rol"),
        option: $(this).data("option"),
        render: $(this).data("render"),
        asesor: $(this).data("as"),
        coordinador: $(this).data("co"),
        gerente: $(this).data("ge"),
        subdirector: $(this).data("su"),
        regional: $(this).data("dr")
    }
    fillTableReport(dataObject);
    if (dataObject.type != 3 && dataObject.type != 33 && dataObject.type != 4 && dataObject.type != 4)
        $("#seeInformationModalReport").modal();
    else
        $("#seeInformationModalCancelados").modal();
});

function fillTableReport(dataObject) {
    filters = validateFilters();
    if (dataObject.type != 3 && dataObject.type != 33 && dataObject.type != 4 && dataObject.type != 4) {
        $('#lotesInformationTable thead tr:eq(0) th').each(function (i) {
            const title = $(this).text();
            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '" data-toggle="tooltip" data-placement="top" title="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if(i != 0){
                    if ($("#lotesInformationTable").DataTable().column(i).search() !== this.value) {
                        $("#lotesInformationTable").DataTable().column(i).search(this.value).draw();
                    }
                }
            });
            $('[data-toggle="tooltip"]').tooltip();

        });

        generalDataTable = $('#lotesInformationTable').dataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title:'Desglose de lotes',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,20],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE'
                                        break;
                                    case 3:
                                        return 'SUPERFICIE'
                                        break;    
                                    case 4:
                                        return 'PRECIO DE LISTA';
                                        break;
                                    case 5:
                                        return 'PRECIO CON DESCUENTO';
                                        break;
                                    case 6:
                                        return 'CASA';
                                        break;
                                    case 7:
                                        return 'CLIENTE';
                                        break;
                                    case 8:
                                        return 'ASESOR';
                                        break;
                                    case 9:
                                        return 'COORDINADOR';
                                        break;
                                    case 10:
                                        return 'GERENTE';
                                        break;
                                    case 11:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 12:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 13:
                                        return 'FECHA DE APARTADO';
                                        break;
                                    case 14:
                                        return 'FECHA DE ÚLTIMO ESTATUS';
                                        break;
                                    case 15:
                                        return 'DÍAS DE ÚLTIMO ESTATUSs';
                                        break;
                                    case 16:
                                        return 'ESTATUS DE CONTRATACIÓN';
                                        break;
                                    case 17:
                                        return 'FECHA DE ESTATUS 9';
                                        break;
                                    case 18:
                                        return 'DÍAS EN ESTATUS 9';
                                        break;
                                    case 19:
                                        return 'ESTATUS DEL LOTE';
                                        break;
                                    case 20:
                                        return 'APARTADO';
                                        break;
                                }
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
            destroy: true,
            ordering: false,
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
                        return d.sup;
                    }
                },
                {
                    data: function (d) {
                        return d.precioLista;
                    }
                },
                {
                    data: function (d) {
                        return d.precioDescuento;
                    }
                },
                {
                    data: function (d) {
                        return d.casa;
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
                        return d.fechaUltimoStatus;
                    }
                },
                {
                    data: function (d) {
                        return d.diasUltimoStatus;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreStatus;
                    }
                },
                {
                    data: function (d) {
                        if(d.fechaStatus9 == null){
                            return 'NO APLICA';
                        }
                        else
                            return d.fechaStatus9;
                    }
                },
                {
                    data: function (d) {
                        return d.diasStatus9;
                    }
                },
                {
                    data: function (d) {
                        return d.estatusLote;
                    }
                },
                {
                    data: function (d) {
                        if (d.apartadoXReubicacion == 1 || d.apartadoXReubicacion == '1'){
                            return 'APARTADO POR REUBICACIÓN';
                        }
                        else{
                            return 'ESTÁNDAR';
                        }
                    }
                }
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: `${base_url}Reporte/getLotesInformation`,
                type: "POST",
                cache: false,
                data: {
                    "type": dataObject.type,
                    "sede": dataObject.sede,
                    "leader": dataObject.leader,
                    "transaction": dataObject.transaction,
                    "user": dataObject.user,
                    "rol": dataObject.rol,
                    "render": dataObject.render,
                    "option": dataObject.option,
                    "asesor": dataObject.asesor,
                    "coordinador": dataObject.coordinador,
                    "gerente": dataObject.gerente,
                    "subdirector": dataObject.subdirector,
                    "regional": dataObject.regional,
                    "filters" : filters
                }
            }
        });
    } else{

        $('#lotesInformationTableCancelados thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            $(this).html(`<input   data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#lotesInformationTableCancelados').DataTable().column(i).search() !== this.value ) {
                    $('#lotesInformationTableCancelados').DataTable().column(i).search(this.value).draw();
                }
            });
            $('[data-toggle="tooltip"]').tooltip();
        });

        generalDataTable = $('#lotesInformationTableCancelados').dataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title:'Desglose de lotes cancelados',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE'
                                        break;
                                    case 3:
                                        return 'PRECIO DE LISTA';
                                        break;
                                    case 4:
                                        return 'PRECIO CON DESCUENTO';
                                        break;
                                    case 5:
                                        return 'CASA';
                                        break;
                                    case 6:
                                        return 'CLIENTE';
                                        break;
                                    case 7:
                                        return 'ASESOR';
                                        break;
                                    case 8:
                                        return 'COORDINADOR';
                                        break;
                                    case 9:
                                        return 'GERENTE';
                                        break;
                                    case 10:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 11:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 12:
                                        return 'FECHA DE APARTADO';
                                        break;
                                    case 13:
                                        return 'FECHA DE ÚLTIMO ESTATUS';
                                        break;
                                    case 14:
                                        return 'DÍAS EN ÚLTIMO ESTATUS';
                                        break;    
                                    case 15:
                                        return 'ESTATUS DE CONTRATACIÓN';
                                        break;
                                    case 16:
                                        return 'FECHA DE ESTATUS 9';
                                        break;
                                    case 17:
                                        return 'DÍAS EN ESTATUS 9';
                                        break;
                                    case 18:
                                        return 'ESTATUS DEL LOTE';
                                        break;
                                    case 19:
                                        return 'FECHA DE LIBERACIÓN';
                                        break;
                                    case 20:
                                        return 'MOTIVO';
                                        break;
                                    case 21:
                                        return 'APARTADO';
                                        break;
                                }
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
            scrollX: true,
            language: {
                url: `${base_url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
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
                        return d.sup;
                    }
                },
                {
                    data: function (d) {
                        return d.precioLista;
                    }
                },
                {
                    data: function (d) {
                        return d.precioDescuento;
                    }
                },
                {
                    data: function (d) {
                        return d.casa;
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
                        return d.fechaUltimoStatus;
                    }
                },
                {
                    data: function (d) {
                        return d.diasUltimoStatus;
                    }
                },
                {
                    data: function (d) {
                        return d.nombreStatus;
                    }
                },
                {
                    data: function (d) {
                        if(d.fechaStatus9 == null){
                            return 'NO APLICA';
                        }
                        else
                            return d.fechaStatus9;
                    }
                },
                {
                    data: function (d) {
                        return d.diasStatus9;
                    }
                },
                {
                    data: function (d) {
                        return d.estatusLote;
                    }
                },
                {
                    data: function (d) {
                        return d.fechaLiberacion;
                    }
                },
                {
                    data: function (d) {
                        return d.motivoLiberacion;
                    }
                },
                {
                    data: function (d) {
                        if (d.apartadoXReubicacion == 1){
                            return 'APARTADO POR REUBICACIÓN';
                        }
                        else{
                            return 'ESTÁNDAR';
                        }
                    }
                }
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: `${base_url}Reporte/getLotesInformation`,
                type: "POST",
                cache: false,
                data: {
                    "type": dataObject.type,
                    "sede": dataObject.sede,
                    "leader": dataObject.leader,
                    "transaction": dataObject.transaction,
                    "user": dataObject.user,
                    "rol": dataObject.rol,
                    "render": dataObject.render,
                    "option": dataObject.option,
                    "asesor": dataObject.asesor,
                    "coordinador": dataObject.coordinador,
                    "gerente": dataObject.gerente,
                    "subdirector": dataObject.subdirector,
                    "regional": dataObject.regional,
                    "filters" : filters
                }
            }
        });
    }
}

$(".scrollCharts").scroll(function() {
    var scrollDiv = $(".scrollCharts").scrollLeft();

    if (scrollDiv > 0){
        $(".gradientLeft").removeClass("d-none");
        $(".gradientLeft").addClass("fading");
    }
    else{
        $(".gradientLeft").addClass("d-none");
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
}

function setListEstatus(){
    $('#spiner-loader').removeClass('hide');
    $.getJSON( base_url + "Reporte/getEstatusContratacionList").done( function( data ){
        $('#spiner-loader').addClass('hide');
        $.each( data, function( i, v){
            $("#estatusContratacion").append($('<option>').val(data[i]['idStatusContratacion']).text(data[i]['nombreStatus'].toUpperCase()));
        });
        $("#estatusContratacion").selectpicker('refresh');
    });
}