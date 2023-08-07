$(document).on('click', '.seeAuts', function () {
    var $itself = $(this);
    var id_evidencia = $itself.attr('data-id_autorizacion');
    $.post(url2+"asesor/getAutsEvidencia/" + id_evidencia, function (data) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function (i, item) {
            let usuario = "<small class='label bg-blue' style='background-color: #fff;border-radius: 15px; border: 1px solid #333;color: black;font-size: 0.9em'>"+item['creado_por']+"</small>";
            if (item['estatus'] == 1) {
                statusProceso = "<small class='label lbl-green'>Enviada a cobranza</small>";
            } else if (item['estatus'] == 10) {
                statusProceso = "<small class='label lbl-orange'>Rechazada en cobranza</small>";
            } else if (item['estatus'] == 2) {
                statusProceso = "<small class='label lbl-goldMaderas'>Enviada a contraloria</small>";
            } else if (item['estatus'] == 20) {
                statusProceso = "<small class='label lbl-warning'>Rechazada de contraloria a cobranza</small>";
            } else if (item['estatus'] == 3) {
                statusProceso = "<small class='label lbl-azure'>Evidencia aceptada</small>";
            } else {
                statusProceso = "<small class='label lbl-gray'>N/A</small>";
            }
            $('#auts-loads').append('<div class="col col-xs-12 col-sm-7 col-md-7 col-lg-7"><label>Solicitud de autorización:  ' + statusProceso + '</label></div><div class="col col-xs-12 col-sm-5 col-md-5 col-lg-5" style="font-size: 0.8em;text-align: right"><small>' + item['fecha_creacion'] + ' ' +  usuario + '</small></div>');
            $('#auts-loads').append('<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align: justify;"><i>' + item['comentario_autorizacion'] + '</i></p>' +
                '</div>');
        });
        $('#verAutorizacionEvidencia').modal('show');
    });
});