let contInicio = 0, contReporte = 0, contAgenda = 0, contRanking = 0, contMetricas = 0;

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
};

$(document).ready(function(){
    changePill('inicioOption');
});

$(document).on('click', '.menuTab', function(e){
    e.preventDefault();
    changePill(this.id);
})

//functions
function changePill(element){
    if(element == 'inicioOption'){
        contInicio++;
        $('#inicio').html("");
        $('#inicio').load(`${base_url}Inicio/index`, function(){
            if(contInicio <= 1 )
                $.getScript(base_url+"dist/js/controllers/dashboard/inicio/dashboardHome.js", function(){
                    readyHome();
                });  
            else readyHome();
        });
    }
    else if(element == 'reporteOption'){
        contReporte++;
        $('#reporte').html("");
        $('#reporte').load(`${base_url}Reporte/reporte`, function(){
            if(contReporte <= 1 )
                $.getScript(base_url+"dist/js/controllers/dashboard/reporte/dashboardReport.js", function(){
                    readyReport();
                });  
            else readyReport();
        });
    } else if (element == 'agendaOption') {
        contAgenda++;
        $('#agenda').html("");
        $('#agenda').load(`${base_url}Calendar/calendar`, function(){
            if(contAgenda <= 1 ) {
                $.getScript(base_url+"dist/js/controllers/dashboard/agenda/dashboardCalendar.js", function(){
                    readyAgenda();
                });
            } else {
                readyAgenda();
            }
        });
    }
    else if(element == 'rankingOption'){
        contRanking++;
        $('#ranking').html("");
        $('#ranking').load(`${base_url}Ranking/ranking`, function(){
            if(contRanking <= 1 )
                $.getScript(base_url+"dist/js/controllers/dashboard/ranking/dashboardRanking.js", function(){
                    readyRanking();
                });
            else readyRanking();
        });
    }
    else if(element == 'metricasOption'){
        contMetricas++;
        $('#metricas').html("");
        $('#metricas').load(`${base_url}Metricas/metricas`, function(){
            if( contMetricas <= 1 )
                $.getScript(base_url+"dist/js/controllers/dashboard/metricas/dashboardMetrics.js", function(){
                    readyMetrics();
                });
            else readyMetrics();
        });
    }
}
