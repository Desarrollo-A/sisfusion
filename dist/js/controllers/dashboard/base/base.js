//jquery
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
        $('#inicio').html("");
        $('#inicio').load(`${base_url}Inicio/index`);
    }
    else if(element == 'reporteOption'){
        $('#reporte').html("");
        $('#reporte').load(`${base_url}Reporte/reporte`);
    }
    else if(element == 'agendaOption'){
        $('#agenda').html("");
        $('#agenda').load(`${base_url}Calendar/calendar`);
    }
    else if(element == 'rankingOption'){
        $('#ranking').html("");
        $('#ranking').load(`${base_url}Ranking/ranking`);
    }
    else if(element == 'metricasOption'){
        $('#metricas').html("");
        $('#metricas').load(`${base_url}Metricas/metricas`);
    }
}
