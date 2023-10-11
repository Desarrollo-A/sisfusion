$(document).on('click', '.seeAuts', function () {
    var $itself = $(this);
    var id_evidencia = $itself.attr('data-id_autorizacion');
    $.post(url2+"asesor/getAutsEvidencia/" + id_evidencia, function (data) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function (i, item) {
            let usuario = "<small class='label lbl-gray'>"+item['creado_por']+"</small>";
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
            $('#auts-loads').append('<div class="boxContent" style="margin-bottom:20px; padding: 10px; background: #f7f7f7; border-radius:15px"><div class="row"><div class="col col-xs-12 col-sm-7 col-md-7 col-lg-7"><label class="m-0" style="font-size: 11px; font-weight: 100;">Solicitud de autorización (' + item['fecha_creacion'] + ')  </label></div></div><div class="row"><div class="col col-xs-12 col-sm-6 col-md-6 col-lg-6"><small>' + statusProceso + '</small></div><div class="col col-xs-12 col-sm-6 col-md-6 col-lg-6 d-flex justify-end"><small>' +  usuario + '</small></div></div><div class="row mt-2"><div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align: justify;">' + item['comentario_autorizacion'] + '</p>' +'</div></div></div>');
        });
        $('#verAutorizacionEvidencia').modal('show');
    });
});