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
        $('.box1Inicio1').addClass('fadeInAnimation');
        $('.box1Inicio2').addClass('fadeInAnimationDelay2');
        $('.box1Inicio3').addClass('fadeInAnimationDelay3');
        $('.box1Inicio4').addClass('fadeInAnimationDelay3');
        $('.boxNavPills').addClass('fadeInAnimationDelay4');
        $('#inicio').html("");
        $('#inicio').load(`${base_url}Inicio/index`);
    }
    else if(element == 'reporteOption'){
        $('#reporte').html("");
        $('#reporte').load(`${base_url}Reporte/reporte`);
    }
    else if(element == 'agendaOption'){
        $('#agenda').html("");
        $('#agenda').load("Calendar/calendar");
    }
    else if(element == 'rankingOption'){
        $('#ranking').html("");
        $('#ranking').load("Ranking/ranking");
    }
    else if(element == 'metricasOption'){
        $('#metricas').html("");
        $('#metricas').load("Metricas/metricas");
    }
}
