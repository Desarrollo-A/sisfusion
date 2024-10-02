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
        


        document.querySelectorAll('.ag-courses-item_link').forEach(item => {
            item.addEventListener('click', function() {
              // Remover la clase 'clicked' de cualquier otro elemento
                document.querySelectorAll('.ag-courses-item_link.clicked').forEach(clickedItem => {
                clickedItem.classList.remove('clicked');
                });
               
              // Agregar la clase 'clicked' al elemento que fue clickeado
                this.classList.add('clicked');
            });
            });

        cargaLinea();

});


function cambiarColor() {
    var elemento = document.getElementById('miElemento');
    elemento.classList.toggle('gold-background');
}


function cargaLinea(){
    let linea = document.getElementById('linea_proceso');
    linea.innerHTML =  '';
    // onChangeTranslations(cargaLinea());
    
    $.ajax({
        url: 'todos_los_pasos',
        type: 'post',
        dataType: 'json',
        success:function(data){
           let  color = '';
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
                
                       <p class="card-title text-muted pl-1">
                          <span data-i18n="id-anticipo">${_('id-anticipo')}</span> ${elementANTICIPOS.id_anticipo}.
                       </p>
                       <p class="card-title text-muted pl-1">
                          <span data-i18n="motivo">${_('motivo')}</span> ${elementANTICIPOS.comentario}.
                        </p>
                    <br>
                </div>

                <div class="row ">
                <div class="col " >
                <div class="timeline-steps aos-init aos-animate "  data-aos="fade-up">`;
                data['TODOS'].forEach(elementTODOS => {
                    let bandera = 0;

                    data['USUARIO'].forEach(elementoUSUARIO => {
                        if (elementoUSUARIO.id_anticipo === elementANTICIPOS.id_anticipo && elementoUSUARIO.id_opcion === elementTODOS.id_opcion) {
                            color = (elementANTICIPOS.estatus === 0) ? 'inner-circle_negativp' : ((elementANTICIPOS.estatus === 11) ? 'inner-circle_succes' : 'inner-circle');

                            let especial = (elementoUSUARIO.id_opcion === 5 && elementANTICIPOS.estatus === 1) ? 
                                `<button class="especial boton_confirmar_contraloria" 
                                    id="boton_confirmar_contraloria" 
                                    onclick="function_paso_5(${elementANTICIPOS.id_anticipo}, ${elementANTICIPOS.monto}, ${elementANTICIPOS.id_usuario}, ${elementANTICIPOS.prioridad}, ${elementANTICIPOS.forma_pago}, ${elementANTICIPOS.id_parcialidad}, ${elementANTICIPOS.monto_parcialidad}, ${elementANTICIPOS.mensualidades})" 
                                    name="boton_confirmar_contraloria" 
                                    data-anticipo="${elementANTICIPOS.id_anticipo}" 
                                    data-id_usuario="${elementANTICIPOS.id_usuario}" 
                                    data-name="${elementANTICIPOS.nombre_usuario}">` 
                                : ` `;

                            let especialfin = (elementoUSUARIO.id_opcion === 5 && elementANTICIPOS.estatus === 1) ? `</button>` : ` `;
                            let nombre_i18n_key = elementTODOS.nombre.toLowerCase().replace(/ /g, '-');
                            linea_armada += `
                            ${especial}
                                <div class="timeline-step">
                                    <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="">
                                        <div class="${color}"></div> 
                                        <p class="h6 mt-3 mb-1">${elementoUSUARIO.id_opcion}</p>
                                        <div class="info-wrapper">
                                            <p data-i18n="${nombre_i18n_key}" data-tooltip="${elementoUSUARIO.comentdario_ha}" class="mb-0 mb-lg-0">${elementTODOS.nombre}</p>
                                        </div>
                                    </div>
                                </div>
                            ${especialfin}`;
                            bandera = 1;
                        }
                    });

                    if (bandera !== 1 && elementTODOS.id_opcion !== 0) {
                        let nombre_i18n_key = elementTODOS.nombre.toLowerCase().replace(/ /g, '-');
                        linea_armada += `
                        <div class="timeline-step mb-0">
                            <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="">
                                <div class="inner-circle_n"></div>
                                <p class="h6 mt-3 mb-1">${elementTODOS.id_opcion}</p>
                                <div class="info-wrapper">
                                    <p data-i18n="${nombre_i18n_key}" class="mb-0 mb-lg-0">${elementTODOS.nombre} 
                                     <span data-i18n="en-espera" data-tooltip="${_('en-espera')}"></span>
                                    </p>
                                </div>
                            </div>
                        </div>`;
                    }
                });

                linea_armada += `</div></div></div><br>`;
            });
            
            linea.innerHTML = linea_armada;
        }
    });
}
$("#form_subir").on('submit', function (e) {
    
    e.preventDefault();


    let formData = new FormData(document.getElementById("form_subir"));
    
    if(forma_de_pago_general == 2){
        var xml = documento_xml;
        formData.append("evidenciaNueva", documento_xml);
        documento_xml = $("#evidenciaNueva")[0].files[0];
        // var xml = documento_xml;
        formData.append("xmlfile", documento_xml); 
    }
    
    // documento_xml = input[0].files[0];
    
    console.log(formData)

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
                document.getElementById("form_subir").reset();
                // $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
                let linea = document.getElementById('linea_proceso');
                linea.innerHTML =  '';
                cargaLinea();

                $('#form_subir').trigger('reset');
            },
            error: function () {
                alerts.showNotification("top", "right",_("algo-salio-mal"), "danger");
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
        $('#btn_alta').prop('disabled', true);
        
        const totalDescuento = replaceAll($('#montoSolicitado').val(), ',' , '');
        const monto = replaceAll(totalDescuento, '$', '');
        
        var data1 = new FormData($(form)[0]);



        data1.append("limpioMonto", monto);
        $.ajax({
            url: 'anticipo_pago_insert/',
            data: data1,    
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                $('#btn_alta').prop('disabled', false);
                console.log(data);
                let linea = document.getElementById('linea_proceso');
                linea.innerHTML =  '';
                cargaLinea();
                alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                
                clickbotonProceso();
            },
            error: (a, b, c) => {
                alerts.showNotification("top", "right", _("descuento-no-actualizado"), "error");
            }
        
        })
    }
});
// document.getElementById('boton_confirmar_contraloria').addEventListener('click', () => {
//     // Esta función se ejecutará cuando se haga clic en el botón
   
//     // Puedes agregar aquí cualquier otra acción que desees que ocurra cuando se haga clic en el botón
// });


function  fucntion_paso_5(ID,monto,id_usuario,prioridad,id_parcialidad,monto_parcialidad,mensualidades_pra){
    
    const Modalbody_subir = $('#myModalAceptar_subir .modal-body');
    const Modalfooter_subir = $('#myModalAceptar_subir .modal-footer');
    Modalbody_subir.html('');
    prioridad_nombre = prioridad == 1 ? 'URGENTE' : 'NORMAL'; 
    Modalfooter_subir.html('');

    montoMandar =  id_parcialidad == 'null' ? monto  : mensualidades_pra ;

    
    bloquear = forma_de_pago_general == 2 ? 'disabled' : ''; 
    FACTURAS = forma_de_pago_general == 2 ?  `
            <div class="form-group">      
                <div class="col-md-12 " id="evidenciaNuevadiv" name="evidenciaNuevadiv" style="padding-top:30px;" >
                    <label class="label control-label d-flex justify-left">Facturas</label>
                    <div class="file-gph">
                        <input class="d-none" type="file"  name="evidenciaNueva" id="evidenciaNueva" accept="application/xml" onchange="changeName(this)"   >
                        <input class="file-name overflow-text" id="evidenciaNueva" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn w-auto" for="evidenciaNueva"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <center><button class="btn btn-warning" type="button" onclick="xml2(${montoMandar})" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center>
            <p id="cantidadSeleccionada"></p>
            <br>
            <br>
            <div class="row">
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="emisor">Emisor:<span class="text-danger">*</span></label>
                    <input type="text" class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0  input-gral" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                </div>        
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label>
                    <input type="text" class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 input-gral" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label  class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="receptor">Receptor:<span class="text-danger">*</span></label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="receptor" name="receptor" placeholder="Receptor" value="" required>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label  class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label  class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="total">Monto:<span class="text-danger">*</span></label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="total" name="total" placeholder="Total" value="" required>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="formaPago">Forma Pago:</label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" placeholder="Forma Pago" id="formaPago" name="formaPago" value="">
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="cfdi">Uso del CFDI:</label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value="">
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="metodopago">Método de Pago:</label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group">
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="unidad">Unidad:</label>
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> 
                </div>
                <div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0 form-group"> 
                    <label class="col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> 
                    <input type="text" class="input-gral col col-xs-6 col-sm-6 col-md-6 col-lg-6 m-0" id="clave" name="clave" placeholder="Clave" value="" required>
                </div> 
            </div>` :``; 

    // const monto_formateado = $(this).attr("data-monto_formateado");

    console.log(id_parcialidad);
    modalidad =  id_parcialidad == 'null' ? `PRÉSTAMO <br>`  : `APOYO <br>
                                                MENSUALIDADES   : ${mensualidades_pra} <br>
                                                MONTO           : ${formatMoney(monto)} <br>` ;
    

    Modalbody_subir.append(`
        <input type="hidden" value="${ID}" name="idAnticipo_Aceptar" id="idAnticipo_Aceptar"> 
        <h4 class=" center-align">¿Está seguro que desea aceptar el Descuento de ${ID}?</h4>
        <br>
        <p class=" card-title text-muted pl-1 col-md-6  center-align"> Monto autorizado :    ${formatMoney(monto)}     </p>
        <p class=" card-title text-muted pl-1 col-md-6 center-align"> Prioridad :    ${ prioridad_nombre}     </p>
        
        <br>
        ${FACTURAS}
        <div class="form-group">
            <input type="hidden" value="0" name="bandera_a" id="bandera_a">
        </div>

        <div>
        <h2 class="card_title">Detalles</h2>
            <p class="center-align"> 
                Monto solicitado : ${formatMoney(monto)} .<br>
                Mediante la modalidad : ${modalidad}

                
            </p>
        </div>
        <div class="form-group">
            <input type="hidden" value="${monto}" name="monto" id="monto">
        </div>
        <div class="form-group">
            <input type="hidden" value="${id_usuario}" name="id_usuario" id="id_usuario">
        </div>
        <div class="form-group col-md-12">

            <input type="hidden" value="${prioridad}" name="seleccion" id="seleccion">
        </div>
        <div class="prueva">
        </div>
        

        <div class="form-group col-md-12 ">
            <label class="label control-label">Aceptar comentario</label>
            <textarea id="motivoDescuento_aceptar" name="motivoDescuento_aceptar" class="text-modal" rows="3" required></textarea>
        </div>
        `);
    Modalfooter_subir.append(`
            <button type="button"  class="btn btn-danger btn-simple "  data-dismiss="modal" >Cerrar</button>
            <button  type="submit" ${bloquear} name="Activo_aceptar_confirmar"  id="Activo_aceptar_confirmar" class="btn btn-primary">Aceptar</button>`);
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
        
        $("#nombreLote").append(`<p><h5><span data-i18n="historial-anticipo">${_("historial-anticipo")}  </span> <b>${nombreUsuario}</b></h5></p>`);
        $.getJSON(general_base_url+"Descuentos/getComments/"+idAnticipo).done( function( data ){
            console.log(data)
            $.each(data, function(i, v) {
                console.log(i);
                console.log(v.comentario);
                $("#comentariosAsimilados").append(`
                    <li>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-6">
                            <a><span data-i18n="procesos"></span> : <b>${v.nombre}</b></a><br>
                          </div>
                          <div class="float-end text-right">
                            <a><span data-i18n="comentario"></span> : ${v.comentario}</a>
                          </div>
                        </div>
                        <h6></h6>
                      </div>
                    </li>
                `);
            });
            $('#spiner-loader').addClass('hide');
        });
    });





    $("#form_delete").on('submit', function (e) {
    
        e.preventDefault();
        let formData = new FormData(document.getElementById("form_delete"));
    
        // let uploadedDocument = $("#"+boton)[0].files[0];
        formData.append("proceso", 0);
        formData.append("estatus", 0);
        // $.ajax({
        //     url: 'anticipo_update_generico',
        //     data: formData,
        //     method: 'POST',
        //     contentType: false,
        //     cache: false,
        //     processData: false,
        //     dataType: 'JSON',
        //     success: function (data) {
        //         alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
        //         $('#myModalAceptar_subir').modal('hide')
        //         document.getElementById("form_aceptar").reset();
        //         // $('#tabla_anticipo_revision_dc').DataTable().ajax.reload(null, false);
        //         $('#form_subir').trigger('reset');
        //     },
        //     error: function () {
        //         alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        //         // document.getElementById("form_aceptar").reset();
        //         $('#myModalAceptar_subir').modal('hide')
        //         $('#form_aceptar').trigger('reset');
        //         // $("#usuarioid").selectpicker('refresh');
    
                
        //     }
        // });
    }); 

    function changeName(e){
        const fileName = e.files[0].name;
        let relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
        relatedTarget[0].value = fileName;
    }




    function xml2(monto) {
        console.log($("#evidenciaNueva"));
        subir_xml2( $("#evidenciaNueva"),monto);
    }

    

    function subir_xml2(input,monto) {
        var data = new FormData();
        documento_xml = input[0].files[0];
        var xml = documento_xml;
        data.append("xmlfile", documento_xml);
        // resear_formulario();
        $.ajax({
            url: general_base_url + "Descuentos/cargaxml2",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data.respuesta[0]) {
                    documento_xml = xml;
                    var informacion_factura = data.datos_xml;
                    console.log(informacion_factura);
                    
                    cargar_info_xml2(informacion_factura,monto);
                    // $("#solobs").val(justificacion_globla);
                }
                else {
                    input.val('');
                    alert(data.respuesta[1]);
                }
            },
            error: function (data) {
                input.val('');
                alert(_("error-comunicarse-proveedor"));
            }              

        });
    }
    function saveX() {
        // document.getElementById('btng').disabled = true;
        save2();
    }
    
    function save2() {
        let formData = new FormData(document.getElementById("frmnewsol2"));
        const labelSum = $('#sumacheck').text();
        const total = Number(labelSum.split('$')[1].trim().replace(',', ''));
        formData.append("dato", "valor");
        formData.append("xmlfile", documento_xml);
        formData.append("pagos", pagos);
        formData.append('total', total);
        $.ajax({
            url: general_base_url + 'Comisiones/guardar_solicitud2',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                // document.getElementById('btng').disabled = false;
                if (data.resultado) {
                    alert(_("factura-subio-correctamente"));
                    $("#modal_multiples").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    tabla_revision.ajax.reload();
                    $("#modal_multiples .modal-body").html("");
                    $("#modal_multiples .header").html("");
                } else if (data == 3) {
                    alert(_("fuera-de-tiempo"));
                    $('#loader').addClass('hidden');
                    $("#modal_multiples").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    $("#modal_multiples .modal-body").html("");
                    $("#modal_multiples .header").html("");
                } else if (data == 4) {
                    alert(_("total-factura-no-coincide"));
                    $('#loader').addClass('hidden');
                    $("#modal_multiples").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    $("#modal_multiples .modal-body").html("");
                    $("#modal_multiples .header").html("");
                } else {
                    alert(_("solicitud-no-completada"));
                    $('#loader').addClass('hidden');
                    $("#modal_multiples").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    $("#modal_multiples .modal-body").html("");
                    $("#modal_multiples .header").html("");
                }
            },
            error: function () {
                // document.getElementById('btng').disabled = false;
                alert(_("error-sistema"));
            }
        });
    }






    function cargar_info_xml2(informacion_factura,monto) {
        // pagos.length = 0;
        let suma = 0;
        let cantidad = 0;
        console.log(informacion_factura);
        // for (let index = 0; index < c; index++) {
        //     if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
        //         pagos[index] = $("#idpago-" + index).val();
        //         cantidad = Number.parseFloat($("#data2" + index).val());
        //         suma += cantidad;
        //     }
        // }
        // var myCommentsList = document.getElementById('cantidadSeleccionada');
        // myCommentsList.innerHTML = '';
        let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
        // var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
        // myCommentsList.setAttribute('style', 'color:green;');
        // myCommentsList.innerHTML = 'Cantidad correcta';
        var myCommentsList = document.getElementById('cantidadSeleccionada');
        myCommentsList.innerHTML = '';
        if (
            ((monto + .50).toFixed(2) >= cantidadXml.toFixed(2) 
            &&  cantidadXml.toFixed(2) >= (monto - .50).toFixed(2)) 
            ||  (cantidadXml.toFixed(2) == (monto).toFixed(2))
            ) 
            {
            alerts.showNotification("top", "right",_("cantidad-correcta"), "success abc");
            document.getElementById('Activo_aceptar_confirmar').disabled = false;
            // disabled();
        }
        else {
            var elemento = document.querySelector('#total');
            // elemento.setAttribute('color', 'red');
            // document.getElementById('btng').disabled = true;
            var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
            // myCommentsList.setAttribute('style', 'color:red;');
            // myCommentsList.innerHTML = 'Cantidad incorrecta';
            alerts.showNotification("top", "right",_("cantidad-incorrecta"), "warning");
        }


        $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
        $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);
        $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
        $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);
        $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);
        $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
        $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);
        $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);
        $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);
        $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);
        $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);
        $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
    }
     
     


    $('#numeroPagosParcialidad').change(function() {

        const totalDescuento = replaceAll($('#montoSolicitado').val(), ',' , '');
        const monto = replaceAll(totalDescuento, '$', '');
        pagos_parcialidades = document.getElementById("numeroPagosParcialidad").value;
        montoParcialidades = monto/pagos_parcialidades;
        document.getElementById("montoPrestadoParcialidad").value = montoParcialidades;
        
    });

    function actualizarSelectpicker() {
        function traducirSelect(selectorId) {
            $('#' + selectorId + ' option').each(function() {
                var i18nKey = $(this).data('i18n'); 
                if (i18nKey) {
                    $(this).text(_(i18nKey));  
                }
            });
            $('#' + selectorId).selectpicker('refresh');
        }
    traducirSelect('procesoTipo');  
    traducirSelect('tiempo_de_pago');
    traducirSelect('numeroPagosParcialidad'); 
 
}

$(document).ready(function() {
    onLoadTranslations(function() {
        actualizarSelectpicker(); 
    });

    onChangeTranslations(actualizarSelectpicker);
});
    $('#procesoTipo').change(function() {
        
        console.log(this.value);
        const totalDescuento = replaceAll($('#montoSolicitado').val(), ',' , '');
        const monto = replaceAll(totalDescuento, '$', '');

        if(monto != ''){
            if(this.value == 1)
                {
                    // 1 es para apoyo 
                    $("#n_parcialidades").addClass("hide");
                    $("#d_tiempo_de_pago").addClass("hide");
                    $("#monto_pago_parcialidades").addClass("hide");
                    
        
                    // var tiempo_de_pago = document.getElementById('tiempo_de_pago');
                    // tiempo_de_pago.disabled = false;
                    // var numeroPagosParcialidad = document.getElementById('numeroPagosParcialidad');
                    // numeroPagosParcialidad.disabled = false;
                    // var montoPrestadoParcialidad = document.getElementById('montoPrestadoParcialidad');
                    // montoPrestadoParcialidad.disabled = false;
                
                    
                }else{
        
                    $("#n_parcialidades").removeClass("hide");
                    $("#d_tiempo_de_pago").removeClass("hide");
                    $("#monto_pago_parcialidades").removeClass("hide");
                    
                }
        }else{
            alerts.showNotification("top", "right", _("cantidad-no-cero"), "warning");
        }
        
     
            // pagos_parcialidades = document.getElementById("numeroPagosParcialidad").value;
        // $("#preceso_aticipo").addClass("hide");
    
    })