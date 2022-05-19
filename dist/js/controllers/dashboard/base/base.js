let base_url = "<?=base_url()?>";
function changePill(element){
    if(element == 'inicioOption'){
        $('.box1Inicio1').addClass('fadeInAnimation');
        $('.box1Inicio2').addClass('fadeInAnimationDelay2');
        $('.box1Inicio3').addClass('fadeInAnimationDelay3');
        $('.box1Inicio4').addClass('fadeInAnimationDelay3');
        $('.boxNavPills').addClass('fadeInAnimationDelay4');
        $('#inicio .col-lg-12').html("");
        $('#inicio .col-lg-12').load("Inicio/index");
    }
    else if(element == 'reporteOption'){
        $('#reporte .col-lg-12').html("");
        $('#reporte .col-lg-12').load("Reporte/reporte");
    }
    else if(element == 'agendaOption'){
        $('#agenda .col-lg-12').html("");
        $('#agenda .col-lg-12').load("Calendar/calendar");
    }
    else if(element == 'rankingOption'){
        console.log("ranking opt");
        $('#ranking .col-lg-12').html("");
        $('#ranking .col-lg-12').load("Ranking/ranking");
    }
    else if(element == 'metricasOption'){
        console.log("metricas opt");

        $('#metricas .col-lg-12').html("");
        $('#metricas .col-lg-12').load("Metricas/metricas");
    }
}