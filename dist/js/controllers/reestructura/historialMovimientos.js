$(document).on('click', '.btn-historial', function () {
    let idLoteOrigen = $(this).attr("data-idLote");
    $('#historialLine').html('');
    $("#spiner-loader").removeClass('hide');
    $.post(`getHistorialPorLote/${idLoteOrigen}`).done(function (data) {
        $("#modal_historial").modal();
        if (JSON.parse(data).length > 0) {
            $.each(JSON.parse(data), function (i, v) {
                fillChangelog(v);
            });
        }
        else{
            emptyLog();
        }
        $("#spiner-loader").addClass('hide');
    });
});

function fillChangelog(v) {
    $("#historialLine").append(`<li>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <a><b>  ${v.nombreUsuario}  </b></a><br>
                </div>
                <div class="float-end text-right">
                    <a> ${v.fechaEstatus} </a>
                </div>
                <div class="col-md-12">
                    <p class="m-0"><small>Estatus: </small><b>  ${v.movimiento} </b></p>
                </div>
            </div>
        </div>
    </li>`);
}

function emptyLog() {
    $("#historialLine").append(`<li>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <a><b>  No Hay historial de preproceso sobre este lote  </b></a><br>
                </div>
            </div>
        </div>
    </li>`);
}
