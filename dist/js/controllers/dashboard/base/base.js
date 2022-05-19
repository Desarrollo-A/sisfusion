let base_url = "<?=base_url()?>";
function changePill(element){
    if(element == 'inicioOption'){
        $('.box1Inicio1').addClass('fadeInAnimation');
        $('.box1Inicio2').addClass('fadeInAnimationDelay2');
        $('.box1Inicio3').addClass('fadeInAnimationDelay3');
        $('.box1Inicio4').addClass('fadeInAnimationDelay3');
        $('.boxNavPills').addClass('fadeInAnimationDelay4');
    }
    else if(element == 'reporteOption'){
        console.log("click reporte");
    }
    else if(element == 'agendaOption'){
        console.log('agenda');
        $('#agenda .col-lg-12').html("");
        $('#agenda .col-lg-12').load("Calendar/calendar");
    }
    else if(element == 'rankingOption'){
        console.log("click ranking");
    }
    else if(element == 'metricasOption'){
        console.log("click metricas");
    }
}