$(document).ready(function () {
//  dani le quite este pedazo de codigo 
});

sp = {
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}


$('#detenidos-form').on('submit', function (e) {
    document.getElementById('detenerLote').disabled = true;
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToStopped',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#detenciones-modal').modal("hide");
                $("#id-lote-detenido").val("");
                document.getElementById('detenerLote').disabled = false;
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                $('#spiner-loader').addClass('hide');
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                $('#spiner-loader').addClass('hide');
            }
        }, error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#penalizacion-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToPenalizacion',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#penalizacion-modal').modal("hide");
                $("#id_lote_penalizacion").val("");
                $("#id_cliente_penalizacion").val("");
                $("#comentario_aceptado").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#penalizacion4-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'changeLoteToPenalizacionCuatro',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#penalizacion4-modal').modal("hide");
                $("#id-lote-penalizacionC").val("");
                $("#id-cliente-penalizacionC").val("");
                $("#asesor").val("");
                $("#coordinador").val("");
                $("#gerente").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$('#Nopenalizacion-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'cancelLoteToPenalizacion',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {
            if (data) {
                $('#Nopenalizacion-modal').modal("hide");
                $("#id_lote_cancelar").val("");
                $("#id_cliente_cancelar").val("");
                $("#comentario_rechazado").val("");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#form_NEODATA").submit( function(e) {
    $('#dispersar').prop('disabled', true);
    document.getElementById('dispersar').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Comisiones/InsertNeo',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data == 1 ){
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Dispersión guardada con éxito", "success");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                    $.ajax({
                        url: general_base_url + 'Comisiones/ultimaDispersion',
                        data: formulario,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST',
                        success:function(data){
                        numerosDispersion();
                        }
                    })
                } else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otro usuario", "warning");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "No se pudo completar tu solicitud", "danger");
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
        jQuery(this).find('#totalNeto').val('');
        jQuery(this).find('#totalNeto2').val('');
    })

    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })

})

$('.decimals').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});

function SoloNumeros(evt){
    if(window.event){
        keynum = evt.keyCode;
    } else{
        keynum = evt.which;
    }
    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
        return true;
    } else{
        alerts.showNotification("top", "left", "Solo Numeros.", "danger");
        return false;
    }
}

$(document).on("click", "#searchByDateRange", function () {
    document.getElementById('mBody').innerHTML = '';
    var fecha2 = $('#endDate').val();
    var fecha1 = $('#beginDate').val();
    if(fecha1 == '' || fecha2 == ''){
        alerts.showNotification("top", "right", "Debes seleccionar ambas fechas", "info");
    }
    else{
        $('#spiner-loader').removeClass('hide');
        $.post(general_base_url + "Comisiones/getMontoDispersadoDates",{
            fecha1: fecha1,
            fecha2: fecha2
        },
        function (datos) {
            if(datos['datos_monto'][0].lotes == null ){
                $("#myModal .modal-body").append('<div class="row" id="divDatos2"><div class="col-md-12 d-flex"><p class="text-center"><p>SIN DATOS POR MOSTRAR</p></div></div>');
            }
            else{
                $("#myModal .modal-body").append('<div class="row" id="divDatos"><div class="col-md-5"><p class="category"><b>Monto</b>:'+formatMoney(datos['datos_monto'][0].monto)+'</p></div><div class="col-md-4"><p class="category"><b>Pagos</b>: '+datos['datos_monto'][0].pagos+'</p></div><div class="col-md-3"><p class="category"><b>Lotes</b>: '+datos['datos_monto'][0].lotes+'</p></div></div>');
            }
            $('#spiner-loader').addClass('hide');

        },"json");
    }
});

function cleanComments(){
    document.getElementById('mBody').innerHTML = '';
}

$("#my_updatebandera_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateBandera',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).attr("data-idpagoc");
        nombreLote = $(this).attr("data-nombreLote");
        $("#myUpdateBanderaModal .modal-body").html('');
        $("#myUpdateBanderaModal .modal-header").html('');
        $("#myUpdateBanderaModal .modal-header").append('<h4 class="modal-title">Enviar a activas: <b>'+nombreLote+'</b></h4>');
        $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">');
        $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(1);
});

function showDetailModal(idPlan) {
    cleanElement('detalle-tabla-div');
    cleanElement("mHeader");
    $('#spiner-loader').removeClass('hide');
    $('#planes-div').hide();
    $.ajax({
        url: `${general_base_url}Comisiones/getDetallePlanesComisiones/${idPlan}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#plan-detalle-tabla-tbody').empty();
            $('#title-plan').text(`Plan: ${data.descripcion}`);
            $('#detalle-plan-modal').modal();
            $('#detalle-tabla-div').hide();
            const roles = data.comisiones;
            $('#detalle-tabla-div').append(`
            <div class="row subBoxDetail" id="modalInformation">
                <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLANES DE COMISIÓN</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>PUESTO</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% COMISIÓN</b></label></div>
                <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% NEODATA</b></label></div>
                <div class="prueba"></div>
            `)
            roles.forEach(rol => {
                if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                    $('#detalle-tabla-div .prueba').append(`
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${(rol.puesto.split(' ')[0]).toUpperCase()}</label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.neo)} %</label></div>
                    `);
                }

            });
            $('#detalle-tabla-div').append(`
            </div>`)
            $('#detalle-tabla-div').show();
            $('#spiner-loader').addClass('hide');
        },
        error: function(){
            alerts.showNotification("top", "right", "No hay datos por mostrar.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

$('#btn-detalle-plan').on('click', function () {
    cleanElement('mHeader');
    $('#planes-div').show();
    $('#planes').empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}Comisiones/getPlanesComisiones`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id = data[i].id_plan;
                const name = data[i].descripcion.toUpperCase();
                $('#planes').append($('<option>').val(id).text(name));
            }
            $("#detalle-plan-modal .modal-header").append('<h4 class="modal-title">Planes de comisión</h4>');
            $('#planes').selectpicker('refresh');
            $('#detalle-plan-modal').modal();
            $('#detalle-tabla-div').hide();
        }
    });
});

// Cambiar tabla
$('#planes').change(function () {
    cleanElement('detalle-tabla-div');
    const idPlan = $(this).val();
    if (idPlan !== '0' || idPlan !== NULL) {
        $.ajax({
            url: `${general_base_url}Comisiones/getDetallePlanesComisiones/${idPlan}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#plan-detalle-tabla-tbody').empty();
                $('#title-plan').text(`Plan: ${data.descripcion}`);
                $('#detalle-plan-modal').modal();
                $('#detalle-tabla-div').hide();
                const roles = data.comisiones;
                $('#detalle-tabla-div').append(`
                <div class="row subBoxDetail" id="modalInformation">
                    <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>PLANES DE COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>PUESTO</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% COMISIÓN</b></label></div>
                    <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label><b>% NEODATA</b></label></div>
                    <div class="prueba"></div>
                `)
                roles.forEach(rol => {
                    if (rol.puesto !== null && (rol.com > 0 && rol.neo > 0)) {
                        $('#detalle-tabla-div .prueba').append(`
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${(rol.puesto.split(' ')[0]).toUpperCase()}</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.com)} %</label></div>
                        <div class="col-2 col-sm-12 col-md-4 col-lg-4 text-center"><label>${convertirPorcentajes(rol.neo)} %</label></div>
                        `);
                    }

                });
                $('#detalle-tabla-div').append(`
                </div>`)
                $('#detalle-tabla-div').show();
            },
        });
    } else {
        $('#plan-detalle-tabla tbody').append('No tiene un plan asignado');
        $('#detalle-tabla-div').hide();
    }
});

function llenado (){
    $.ajax({
        type: 'POST',
        url: 'ultimoLlenado',
        contentType: false,
        cache: false,
        dataType:'json',
        success: function (data) {
            $("#llenadoPlan").modal();
            $('#tiempoRestante').removeClass('hide');
            if(data.date ==  undefined || data.date == false){
                $("#tiempoRestante").html("Disponible para ejecutar ");
                $('#cerradoPlan').removeClass('hide');
                $('#llenadoPlanbtn').removeClass('hide');
                $('#llenadoPlanbtn').removeClass('hide');
            }else{
                $('#llenadoPlanbtn').addClass('hide');
                $('#cerradoPlan').addClass('hide');
                $("#tiempoRestante").html("ultima ejecución : "+data.date[0].fecha_mostrar );
            }
        }
    })
}

$(document).on("click",".llenadoPlanbtn", function (e){
    $('#spiner-loader').removeClass('hide');
    document.getElementById('llenadoPlanbtn').disabled = true;
    let bandera = 0;
    $.ajax({
        type: 'POST',
        url: 'ultimoLlenado',
        contentType: false,
        cache: false,
        dataType:'json',
        success: function (data) {
            let ban ;
            if(data.date ==  undefined || data.date == false){
                bandera = 1;
                var milliseconds = new Date().getTime() + (1 * 60 * 60 * 4000);
                fecha_reinicio = new Date(milliseconds);
            }else{
                fecha_reinicio =  new Date(data.date[0].fecha_reinicio)
                fechaSitema =  new Date();
                if (fechaSitema.getTime() >= fecha_reinicio.getTime())  {
                    bandera = 1;
                }else{
                    bandera = 0;
                    document.getElementById('llenadoPlanbtn').disabled = false;
                }
            }
            if(bandera == 1 ){
                $.ajax({
                    type: 'POST',
                    url: 'nuevoLlenadoPlan',
                    contentType: false,
                    data: {
                        "fecha_reinicio"    : fecha_reinicio
                    },
                    cache: false,
                    dataType:'json',
                    success: function (data) {
                        if(data == true){
                            $.ajax({
                                type: 'POST',
                                url: '../ScheduleTasks_dos/LlenadoPlan',
                                contentType: false,
                                cache: false,
                                success: function (data) {
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Se ha corrido la funcion para llenar los planes de venta.", "success");
                                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload(null, false );
                                    $('#llenadoPlan').modal('toggle');
                                    document.getElementById('llenadoPlan').disabled = false;
                                }
                            });
                        }else{
                            if(data == 300 ){
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Ups, Error  300. aun no se cumple con las 4 horas de espera.", "warning");
                            }else{
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Ups,al guardar la información Error 315.", "warning");
                            }
                            // a; marcar este error es debido a que no se pudo guardar la informacion en la base
                            // al registrar un nuevo valor en historial llenado plan
                        }
                    }
                });
            }else {
                $('#spiner-loader').addClass('hide');
                document.getElementById('llenadoPlan').disabled = false;
                alerts.showNotification("top", "right", "Ups, aún no se cumple el tiempo de espera para volver a ejecutar.", "warning");
            }
        }
    });
});

function numerosDispersion(){
    $('#monto_label').html('');
    $('#pagos_label').html('');
    $('#lotes_label').html('');
    $.post(general_base_url + "/Comisiones/lotes", function (data) {
        let montoLabel = data.monto ;
        $('#monto_label').append(formatMoney(montoLabel));
        $('#pagos_label').append(data.pagos);
        $('#lotes_label').append(data.lotes);
    }, 'json');
}

$('#tabla_dispersar_comisiones').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


const formatMiles = (number) => {
    const exp = /(\d)(?=(\d{3})+(?!\d))/g;
    const rep = '$1,';
    return number.toString().replace(exp,rep);
}

function responsive(maxWidth) {
    if (maxWidth.matches ) { //true mayor 991
        $('.labelNombre').removeClass('hide');
        $('.labelPorcentaje').removeClass('hide');
        $('.labelTC').removeClass('hide');
        $('.labelAbonado').removeClass('hide');
        $('.labelPendiente').removeClass('hide');
        $('.labelDisponible').removeClass('hide');
        $('.rowTitulos').addClass('hide');
    } else { //false menor 991
        $('.labelNombre').addClass('hide');
        $('.labelPorcentaje').addClass('hide');
        $('.labelTC').addClass('hide');
        $('.labelAbonado').addClass('hide');
        $('.labelPendiente').addClass('hide');
        $('.labelDisponible').addClass('hide');
        $('.rowTitulos').removeClass('hide');
    }
}

function function_totales(){
    $.getJSON( general_base_url + "Comisiones/getMontoDispersado").done( function( data ){
        $cadena = '<b>$'+formatMoney(data[0].monto)+'</b>';
        document.getElementById("monto_label").innerHTML = $cadena ;
    });
    $.getJSON( general_base_url + "Comisiones/getPagosDispersado").done( function( data ){
        $cadena01 = '<b>'+data[0].pagos+'</b>';
        document.getElementById("pagos_label").innerHTML = $cadena01 ;
    });
    $.getJSON( general_base_url + "Comisiones/getLotesDispersado").done( function( data ){
        $cadena02 = '<b>'+data[0].lotes+'</b>';
        document.getElementById("lotes_label").innerHTML = $cadena02 ;
    });
}

var maxWidth = window.matchMedia("(max-width: 992px)");
responsive(maxWidth);
maxWidth.addListener(responsive);





