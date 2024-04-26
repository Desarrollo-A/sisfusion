$(document).ready(function () {

    $.ajax({
        url: 'todos_los_pasos',
        type: 'post',
        dataType: 'json',
        success:function(data){

            let linea = document.getElementById('linea_proceso');
            // let contenedorContenido = document.getElementById('contenedorCoprop');
            linea.innerHTML = ``;
            console.log(data['TODOS']);
            console.log(data['USUARIO']);
            console.log(data['ANTICIPOS']);
            linea_armada = ``;
            valor =1;
            linea_armada += `<br>`;

            data['ANTICIPOS'].forEach(elementANTICIPOS => {
                
                linea_armada += `
                <div class="encabezadoBox">
                
                        <p class=" card-title text-muted pl-1">ID anticipo ${elementANTICIPOS.id_anticipo}.</p>
                        <p class=" card-title text-muted pl-1">Motivo ${elementANTICIPOS.comentario}.</p>
                    </div>
                    <br>
                </div>
                <div class="row ">
                <div class="col " >
                <div class="timeline-steps aos-init aos-animate "  data-aos="fade-up">`;
                data['TODOS'].forEach(elementTODOS => {
                    bandera = 0;
                    
                    data['USUARIO'].forEach((elementoUSUARIO , contador) => {
                        
                        if(elementoUSUARIO.id_anticipo == elementANTICIPOS.id_anticipo && elementoUSUARIO.id_opcion == elementTODOS.id_opcion  ){
                            if(elementoUSUARIO.id_opcion == elementTODOS.id_opcion ){
                                linea_armada += `
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title=""  >
                                            <div class="inner-circle"></div>
                                            <p class="h6 mt-3 mb-1">${elementoUSUARIO.id_opcion}</p>
                                            <p class=" mb-0 mb-lg-0">${elementoUSUARIO.nombre}</p>
                                        </div>
                                    </div>
                                    `;
                                bandera = 1;
                            }
                        }else{
                            
                        }
                        
                    });

                    if(bandera != 1){
                        
                        linea_armada += `
                            <div class="timeline-step mb-0">
                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="">
                                    <div class="inner-circle_n"></div>
                                    <p class="h6 mt-3 mb-1">${elementTODOS.id_opcion}</p>
                                    <p class=" mb-0 mb-lg-0">${elementTODOS.nombre}</p>
                                </div>
                            </div>
                            `;
                    }
                    
                });
                linea_armada += `</div>
                </div>
                </div>`;
                linea_armada += `<br>`;
            });
            linea.innerHTML =  linea_armada;
            // contenedorContenido.innerHTML = contenidoHTML;
            // linea.innerHTML = '';
            // linea.innerHTML = ``;
        }
    });

});


// r
document.getElementById('solicitud_btn').addEventListener('click', function() {
    // Esta función se ejecutará cuando se haga clic en el botón
    console.log('¡Se hizo clic en el botón solicitud_btn!');
    
    $("#preceso_aticipo").addClass("hide");
    $("#cartSolicitar_aticipo").removeClass("hide");
    
    // Puedes agregar aquí cualquier otra acción que desees que ocurra cuando se haga clic en el botón
});

document.getElementById('preceso_btn').addEventListener('click', function() {
    // Esta función se ejecutará cuando se haga clic en el botón
    console.log('¡Se hizo clic en el botón preceso_btn!');
    $("#cartSolicitar_aticipo").addClass("hide");
    $("#preceso_aticipo").removeClass("hide");
    // Puedes agregar aquí cualquier otra acción que desees que ocurra cuando se haga clic en el botón
});
//   $("#save").addClass("hide");
function clickbotonSolicitud(){
    $("#preceso_aticipo").addClass("hide");
    $("#cartSolicitar_aticipo").removeClass("hide");
}
function clickbotonProceso(){
    $("#cartSolicitar_aticipo").addClass("hide");
    $("#preceso_aticipo").removeClass("hide");
}
$("#anticipo_nomina").submit(function (e) { 

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'anticipo_pago_insert/',
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                $('#btn_alta').prop('disabled', true);
                clickbotonProceso();
            },
            error: (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }
        
        })
    }
});
