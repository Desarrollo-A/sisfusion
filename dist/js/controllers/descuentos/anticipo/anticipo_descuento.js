$(document).ready(function () {
    
        // Selecciona todos los elementos con la clase "buttons_adelanto"
        let linea = document.getElementById('linea_proceso');
        linea.innerHTML =  '';
        var botones = document.querySelectorAll(".buttons_adelanto");
        
        // Itera sobre cada botón y agrega un evento de clic
        botones.forEach(function(boton) {
        boton.addEventListener("click", function() {
            // Remueve la clase "clicked" de todos los botones
            botones.forEach(function(b) {
                b.classList.remove("clicked");
            });
            
            // Agrega la clase "clicked" al botón actual
            this.classList.add("clicked");
        });
        });
        
        cargaLinea();

});

function cargaLinea(){
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
                                especial =   (elementoUSUARIO.id_opcion == 5 && elementANTICIPOS.estatus ==1) ? `<botton class="epecial boton_confirmar_contraloria" 
                                id="boton_confirmar_contraloria" 
                                onclick="fucntion_paso_5(${elementANTICIPOS.id_anticipo},${elementANTICIPOS.monto},${elementANTICIPOS.id_usuario},${elementANTICIPOS.prioridad})"
                                name="boton_confirmar_contraloria"  data-anticipo="${elementANTICIPOS.id_anticipo}"
                                data-id_usuario="${elementANTICIPOS.id_usuario}" data-name="${elementANTICIPOS.nombre_usuario}" >` : ` `;


                                especialfin =   (elementoUSUARIO.id_opcion == 5 &&  elementANTICIPOS.estatus ==1) ? `</botton>` : ` `;
                                linea_armada += `
                                ${especial} 
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title=""  >
                                            <div class="inner-circle"></div> 
                                                <p class="h6 mt-3 mb-1">${elementoUSUARIO.id_opcion}</p>
                                                <p class=" mb-0 mb-lg-0">${elementoUSUARIO.nombre}</p>
                                            </div>
                                    </div>
                                    ${especialfin}
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
}
$("#form_subir").on('submit', function (e) {
    
    e.preventDefault();
    let formData = new FormData(document.getElementById("form_subir"));

    // let uploadedDocument = $("#"+boton)[0].files[0];
    formData.append("proceso", 6);
    formData.append("estatus", 2);
    $.ajax({
        url: 'anticipo_update_generico',
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function (data) {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
            $('#myModalAceptar_subir').modal('hide')
            document.getElementById("form_aceptar").reset();
            // $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
            $('#form_subir').trigger('reset');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            // document.getElementById("form_aceptar").reset();
            $('#myModalAceptar_subir').modal('hide')
            $('#form_aceptar').trigger('reset');
            // $("#usuarioid").selectpicker('refresh');

            
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
                let linea = document.getElementById('linea_proceso');
                linea.innerHTML =  '';
                cargaLinea();
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
document.getElementById('boton_confirmar_contraloria').addEventListener('click', () => {
    // Esta función se ejecutará cuando se haga clic en el botón
   
    // Puedes agregar aquí cualquier otra acción que desees que ocurra cuando se haga clic en el botón
});


function  fucntion_paso_5(ID,monto,id_usuario,prioridad){
    
    const Modalbody_subir = $('#myModalAceptar_subir .modal-body');
    const Modalfooter_subir = $('#myModalAceptar_subir .modal-footer');
    Modalbody_subir.html('');
    prioridad = prioridad == 1 ? 'URGENTE' : 'NORMAL'; 
    Modalfooter_subir.html('');
    Modalbody_subir.append(`
        <input type="hidden" value="${ID}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 
        <h4 class=" center-align">¿Ésta seguro que desea aceptar el Descuento de ${ID}?</h4>
        <br>
        <p class=" card-title text-muted pl-1  center-align"> Monto autorizado :    ${formatMoney(monto)}     </p>
        <br>
        <p class=" card-title text-muted pl-1  center-align"> Prioridad :    ${ prioridad}     </p>
        
        <div class="form-group">
            <input type="hidden" value="0" name="bandera_a" id="bandera_a">
        </div>
        <div class="form-group">
            <input type="hidden" value="${monto}" name="monto" id="monto">
        </div>
        <div class="form-group">
            <input type="hidden" value="${id_usuario}" name="id_usuario" id="id_usuario">
        </div>
        <div class="form-group">

            <input type="hidden" value="${prioridad}" name="seleccion" id="seleccion">
        </div>
        <div class="form-group col-md-12 ">
            <label class="label control-label">Aceptar comentario</label>
            <textarea id="motivoDescuento_aceptar" name="motivoDescuento_aceptar" class="text-modal" rows="3" required></textarea>
        </div>
        `);
    Modalfooter_subir.append(`
            <button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>
            <button  type="submit" name="Activo_aceptar_confirmar"  id="Activo_aceptar_confirmar" class="btn btn-primary">Aceptar</button>`);
    $("#myModalAceptar_subir").modal();

} 

    $("#tabla_anticipo_revision tbody").on("click", ".consultar_logs", function(e){
        $('#spiner-loader').removeClass('hide');
        const idAnticipo = $(this).val();
        const nombreUsuario = $(this).attr("data-name");
        e.preventDefault();
        e.stopImmediatePropagation();
        // $("#nombreLote").html('');
        // $("#comentariosAsimilados").html('');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-body">
                <div role="tabpanel">
                    <ul>
                        <div id="nombreLote"></div>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="changelogTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comentariosAsimilados"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
            </div>`);
        showModal();

        $("#nombreLote").append('<p><h5">HISTORIAL DEL ANTICIPO DE: <b>'+nombreUsuario+'</b></h5></p>');
        $.getJSON(general_base_url+"Descuentos/getComments/"+idAnticipo).done( function( data ){
            console.log(data)
            $.each( data, function(i, v){
                console.log(i);
                console.log(v.comentario);
                $("#comentariosAsimilados").append('<li>\n' +
                '  <div class="container-fluid">\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-6">\n' +
                '        <a> Proeso : <b> ' +v.nombre+ '</b></a><br>\n' +
                '      </div>\n' +
                '      <div class="float-end text-right">\n' +
                '        <a> Comentario : ' +v.comentario + '</a>\n' +
                '      </div>\n' +

                '    <h6>\n' +
                '    </h6>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
