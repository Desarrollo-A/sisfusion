// inica subir facttura

$(document).on("click", ".subir_factura_multiple", function() {
    $('#spiner-loader').removeClass('hide');
    let actual=13;
    if(userSede == 8){
        actual=15;
    }
    var hoy = new Date(fechaServer);
    var dia = hoy.getDate();
    var mes = hoy.getMonth() + 1;
    var hora = hoy.getHours();

    if(
        (tipo_usuario == 2 && 
            (mes == 12 && dia == 28) ||(mes == 12 && dia == 29) // DES-HABILITAR EN 2024
                        ||(mes == 1 && dia == 11) || (mes == 1 && dia == 12) // ENE 2024 OOAM QUINCENAL
                        ||(mes == 1 && dia == 25) || (mes == 1 && dia == 26) // ENE 2024 OOAM QUINCENAL
                        ||(mes == 2 && dia == 8) || (mes == 2 && dia == 9) // FEB 2024 OOAM QUINCENAL
                        ||(mes == 2 && dia == 22) || (mes == 2 && dia == 23) // FEB 2024 OOAM QUINCENAL
                        ||(mes == 3 && dia == 7) || (mes == 3 && dia == 8) // MAR 2024 OOAM QUINCENAL
                        ||(mes == 3 && dia == 27) || (mes == 3 && dia == 28) // MAR 2024 OOAM QUINCENAL
                        ||(mes == 4 && dia == 11) || (mes == 4 && dia == 12) // ABR 2024 OOAM QUINCENAL
                        ||(mes == 4 && dia == 25) || (mes == 4 && dia == 26) // ABR 2024 OOAM QUINCENAL
                        ||(mes == 5 && dia == 16) || (mes == 5 && dia == 17) // MAY 2024 OOAM QUINCENAL
                        ||(mes == 5 && dia == 30) || (mes == 5 && dia == 31) // MAY 2024 OOAM QUINCENAL
                        ||(mes == 6 && dia == 13) || (mes == 6 && dia == 14) // JUN 2024 OOAM QUINCENAL
                        ||(mes == 6 && dia == 27) || (mes == 6 && dia == 28) // JUN 2024 OOAM QUINCENAL
                        ||(mes == 7 && dia == 11) || (mes == 7 && dia == 12) // JUL 2024 OOAM QUINCENAL
                        ||(mes == 7 && dia == 25) || (mes == 7 && dia == 26) // JUL 2024 OOAM QUINCENAL
                        ||(mes == 8 && dia == 15) || (mes == 8 && dia == 16) // AGO 2024 OOAM QUINCENAL
                        ||(mes == 8 && dia == 29) || (mes == 8 && dia == 30) // AGO 2024 OOAM QUINCENAL
                        ||(mes == 9 && dia == 11) || (mes == 9 && dia == 12) // SEP 2024 OOAM QUINCENAL
                        ||(mes == 9 && dia == 26) || (mes == 9 && dia == 27) // SEP 2024 OOAM QUINCENAL
                        ||(mes == 10 && dia == 10) || (mes == 10 && dia == 11) // OCT 2024 OOAM QUINCENAL
                        ||(mes == 10 && dia == 24) || (mes == 10 && dia == 25) // OCT 2024 OOAM QUINCENAL
                        ||(mes == 11 && dia == 13) || (mes == 11 && dia == 14) // NOV 2024 OOAM QUINCENAL
                        ||(mes == 11 && dia == 28) || (mes == 11 && dia == 29) // NOV 2024 OOAM QUINCENAL
                        // || (mes == 12 && dia == 10) || (mes == 12 && dia == 24) HABILITAR EN 2024 DIC 2024 OOAM QUINCENAL
            ) 
            || (tipo_usuario == 1 && 
                ((mes == 1 && dia == 24)  ||  (mes == 1 && dia == 25 && hora <= fin)) || // ENE 2024 VENTAS
                ((mes == 2 && dia == 11)  ||  (mes == 2 && dia == 12 && hora <= fin)) || // FEB 2024 VENTAS
                ((mes == 3 && dia == 10)  ||  (mes == 3 && dia == 11 && hora <= fin)) || // MAR 2024 VENTAS
                ((mes == 4 && dia == 7)  ||  (mes == 4 && dia == 8 && hora <= fin)) || // ABR 2024 VENTAS
                ((mes == 5 && dia == 12)  ||  (mes == 5 && dia == 13 && hora <= fin)) || // MAY 2024 VENTAS
                ((mes == 6 && dia == 9)  ||  (mes == 6 && dia == 10 && hora <= fin)) || // JUN 2024 VENTAS
                ((mes == 7 && dia == 7)  ||  (mes == 7 && dia == 8 && hora <= fin)) || // JUL 2024 VENTAS
                ((mes == 8 && dia == 11)  ||  (mes == 8 && dia == 12 && hora <= fin)) || // AGO 2024 VENTAS
                ((mes == 9 && dia == 8)  ||  (mes == 9 && dia == 9 && hora <= fin)) || // SEP 2024 VENTAS
                ((mes == 10 && dia == 6)  ||  (mes == 10 && dia == 7 && hora <= fin)) || // OCT 2024 VENTAS
                ((mes == 11 && dia == 10)  ||  (mes == 11 && dia == 11 && hora <= fin)) || // NOV 2024 VENTAS
                ((mes == 12 && dia == 8)  ||  (mes == 12 && dia == 9 && hora <= fin)) // DIC 2024 VENTAS
                )//VALIDACION VENTAS NORMAL

            || (id_usuario_general == 7689)
        ) {

        $("#modal_multiples .modal-body").html("");
        $("#modal_multiples .modal-header").html("");
        $("#modal_multiples .modal-footer").html("");
        $("#modal_multiples .modal-header").append(`
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size:40px;">&times;</span>
                </button>
            </div>
            <div class="col-md-12">
                <select id="desarrolloSelect" name="desarrolloSelect" 
                    class="selectpicker select-gral desarrolloSelect" 
                    required data-live-search="true">
                </select>
            </div>
        </div>`);
        $.post('getDesarrolloSelect', function (data) {
            if (data == 3) {
                $("#desarrolloSelect").append('<option selected="selected" disabled>YA NO ES POSIBLE ENVIAR FACTURAS, ESPERA AL SIGUIENTE CORTE</option>');
            }
            else {
                if (!data) {
                    $("#desarrolloSelect").append($('NO TIENES PAGOS.'));
                }
                else {
                    $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"));
                    var len = data.length;
                    for (var i = 0; i < len; i++) {
                        var id = data[i]['id_usuario'];
                        var name = data[i]['name_user'];
                        $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                    }
                    if (len <= 0) {
                        $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                    }
                    $("#desarrolloSelect").val(0);
                    $("#desarrolloSelect").selectpicker('refresh');
                }
            }
        }, 'json');
    $('#spiner-loader').addClass('hide');
        $('#desarrolloSelect').change(function () {
            var valorSeleccionado = $(this).val();
            $("#modal_multiples .modal-body").html("");
            $("#modal_multiples .modal-footer").html("");
            $.getJSON(general_base_url + "Comisiones/getDatosProyecto/" + valorSeleccionado).done(function (data) {
                if (!data) {
                    $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
                }
                else {
                    if (data.length > 0) {
                        $("#modal_multiples .modal-body").append(`<div class="row">
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control input-gral" onclick="todos();" id="btn_all">
                        </div>
                        <div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b>
                        </div>`);
                    }
                    $.each(data, function (i, v) {
                        contadorDentroFacturas++;
                        abono_asesor = (v.abono_neodata);
                        $("#modal_multiples .modal-body").append(`
                            <div class="row">
                                <div class="col-md-1">
                                    <input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult${i}" name="comisiones_facura_mult${i}">
                                </div>
                                <div class="col-md-4">
                                    <input id="data1${i}" name="data1${i}" value="${v.nombreLote}" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%">
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" id="idpago-${i}" name="idpago-${i}" value="${v.id_pago_i}">
                                    <input id="data2${i}" name="data2${i}" value="${parseFloat(abono_asesor).toFixed(2)}" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%">
                                </div>
                            </div>`);
                    });
                    $("#modal_multiples .modal-body").append(`
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b>
                        </div>
                        
                        <div class="col-lg-5">
                            <div class="input-group">
                                <label  class="input-group-btn"></label>
                                <span class="btn btn-info btn-file">
                                    <i class="fa fa-upload"></i> Subir archivo
                                    <input id="xmlfile2" name="xmlfile2" required accept="application/xml" type="file"/>
                                </span>
                                <p id="archivo-factura"></p>
                            </div>
                        </div>                        
                    

                        <div class="col-lg-7"><center>
                            <button class="btn btn-warning" type="button" onclick="xml2()" id="cargar_xml2">
                                <i class="fa fa-upload"></i> VERIFICAR Y CARGAR
                            </button></center>
                        </div>
                    </div>
                    <p id="cantidadSeleccionada"></p>
                    <b id="cantidadSeleccionadaMal"></b>
                    
                    <form id="frmnewsol2" method="post">
                        
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="emisor">Emisor:<span class="text-danger">*</span>
                                </label>
                                    <input type="text" class="form-control input-gral" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="rfcemisor">RFC Emisor:<span class="text-danger">*
                                </span></label>
                                <input type="text" class="form-control input-gral" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="receptor">Receptor:<span class="text-danger">*
                                </span></label>
                                <input type="text" class="form-control input-gral" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>
                            <div class="col-lg-3 form-group">
                                <label for="rfcreceptor">RFC Receptor:<span class="text-danger">*
                                </span></label>
                                <input type="text" class="form-control input-gral" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*
                                </span></label>
                                <input type="text" class="form-control input-gral" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="total">Monto:<span class="text-danger">*
                                </span></label>
                                <input type="text" class="form-control input-gral" id="total" name="total" placeholder="Total" value="" required>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="formaPago">Forma Pago:</label>
                                <input type="text" class="form-control input-gral" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>
                            <div class="col-lg-3 form-group">
                                <label for="cfdi">Uso del CFDI:</label>
                                <input type="text" class="form-control input-gral" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>
                            <div class="col-lg-3 form-group">
                                <label for="metodopago">Método de Pago:
                                </label>
                                <input type="text" class="form-control input-gral" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                            </div>
                            <div class="col-lg-3 form-group"><label for="unidad">Unidad:</label>
                                <input type="text" class="form-control input-gral" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> 
                            </div>
                            <div class="col-lg-3 form-group">
                                <label for="clave">Clave Prod/Serv:<span class="text-danger">*
                                </span></label> 
                                <input type="text" class="form-control input-gral" id="clave" name="clave" placeholder="Clave" value="" required> 
                            </div> 
                        </div>
                        <div class="row"> 
                            <div class="col-lg-12 form-group"> 
                                <label for="obse">OBSERVACIONES FACTURA 
                                    <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right">
                                    </i>
                                    </label><br>
                                    <textarea class="form-control input-gral" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones">
                                    </textarea> 
                            </div> 
                        </div> `
                        );
                    $("#modal_multiples .modal-footer").append(`
                            <button class="btn btn-danger btn-simple close_modal_xml" type="button" data-dismiss="modal"  >CANCELAR
                            </button>
                            <button class="btn btn-primary"  id="btng" onclick="saveX();" disabled >
                                GUARDAR
                            </button>
                            </form>
                    
                    `);
                }
            });
        });
        $("#modal_multiples").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    else {

        alerts.showNotification("top", "right", "NO PUEDES SUBIR FACTURAS HASTA EL PRÓXIMO CORTE ", "danger");
    }
});

//finaliza subir factura

// sumCheck  inicio

function sumCheck() {
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < contadorDentroFacturas; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;
        }
    }
    var myCommentsList = document.getElementById('sumacheck');
    myCommentsList.innerHTML = 'Suma seleccionada: ' + formatMoney(suma.toFixed(3));
} 


function disabled() {
    for (let index = 0; index < contadorDentroFacturas; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
            document.getElementById("comisiones_facura_mult" + index).disabled = true;
            document.getElementById("btn_all").disabled = true;
        }
    }
}
// sumCheck fin 
function todos() {
    if ($(".checkdata1:checked").length == 0) {
        $(".checkdata1").prop("checked", true);
        sumCheck();
    } else if ($(".checkdata1:checked").length < $(".checkdata1").length) {
        $(".checkdata1").prop("checked", true);
        sumCheck();
    } else if ($(".checkdata1:checked").length == $(".checkdata1").length) {
        $(".checkdata1").prop("checked", false);
        sumCheck();
    }
}

// PRIMERA FUNCTION XML2 PARA SUBIR LA FACTURA
function xml2() {
    subir_xml2($("#xmlfile2"));
    $('#archivo-factura').val('');
    v2 = document.getElementById("xmlfile2").files[0].name;
    document.getElementById("archivo-factura").innerHTML = v2;
    const src = URL.createObjectURL(document.getElementById("xmlfile2").files[0]);
   
}

// SEGUNDA FUCNTION SUBIR_XML2 PARA SUBIR LA FACTURA
function subir_xml2(input) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    resear_formulario();
    $.ajax({
        url: general_base_url + "Comisiones/cargaxml2",
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
                cargar_info_xml2(informacion_factura);
                $("#solobs").val(justificacion_globla);
            }
            else {
                input.val('');
                alert(data.respuesta[1]);
            }
        },
        error: function (data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}


function resear_formulario() {
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');
    var validator = $("#frmnewsol").validate();
    validator.resetForm();
    $("#frmnewsol div").removeClass("has-error");
}



function cargar_info_xml2(informacion_factura) {
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < contadorDentroFacturas; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;
        }
    }
    var myCommentsList = document.getElementById('cantidadSeleccionada');
    myCommentsList.innerHTML = '';
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
    myCommentsList.setAttribute('style', 'color:green;');
    myCommentsList.innerHTML = 'Cantidad correcta';
    if (((suma + .50).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .50).toFixed(2)) || (cantidadXml.toFixed(2) == (suma).toFixed(2))) {
        alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
        document.getElementById('btng').disabled = false;
        disabled();
    }
    else {
        var elemento = document.querySelector('#total');
        elemento.setAttribute('color', 'red');
        document.getElementById('btng').disabled = true;
        var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
        myCommentsList.setAttribute('style', 'color:red;');
        myCommentsList.innerHTML = 'Cantidad incorrecta';
        alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
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


$(document).on('change','xmlfile2', function () {
    $('#archivo-factura').val('');
    v2 = document.getElementById("xmlfile2").files[0].name;
    document.getElementById("archivo-factura").innerHTML = v2;
    const src = URL.createObjectURL(document.getElementById("xmlfile2").files[0]);
    // $('#preview-div').html("");
    // $('#preview-div').append(`<embed src="${src}" width="500" height="600">`);
});

function saveX() {
    document.getElementById('btng').disabled = true;
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
            document.getElementById('btng').disabled = false;
            if (data.resultado) {
                alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                tabla_revision.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else if (data == 3) {
                alert("ESTAS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else if (data == 4) {
                alert("EL TOTAL DE LA FACTURA NO COINCIDE CON EL TOTAL DE COMISIONES SELECCIONADAS");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else {
                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            }
        },
        error: function () {
            document.getElementById('btng').disabled = false;
            alert("ERROR EN EL SISTEMA");
        }
    });
}

