$(document).on('click', '.btn-historial', function (){
    let idLoteOrigen = $(this).attr("data-idLote");
    $('#historialLine').html('');
    $("#spiner-loader").removeClass('hide');
    $.post(`getHistorialPorLote/${idLoteOrigen}`).done( function( data ){
        $("#modal_historial").modal();
        $.each( JSON.parse(data), function(i, v){
            fillChangelog(v);
        });
        $("#spiner-loader").addClass('hide');
    });
});

function fillChangelog(v) {
    
    const comentario = v.comentario.trim() === "" ? "(Sin comentario)" : v.comentario;

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
        <div class="col-md-12">
            <p class="m-0"><small>Comentario: </small><b>  ${comentario} </b></p>
        </div>
    </li>`);
}

