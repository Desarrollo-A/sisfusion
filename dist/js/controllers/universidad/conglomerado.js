$(document).ready(function () {

    $.post(general_base_url + "Universidad/get_lista_roles", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#puesto").append($('<option>').val(id).text(name.toUpperCase()));     
        }
        $("#puesto").selectpicker('refresh');

    }, 'json');

    $('#puesto').change(function(ruta){
        rol = $('#puesto').val();
        $("#usuarios").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'Universidad/getUsuariosUM/'+rol,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++){
                    var id = response[i]['id_usuario'];
                    var name = response[i]['nombre'];
                    $("#usuarios").append($('<option>').val(id).text(name));
                }
                $("#usuarios").selectpicker('refresh');
            }
        });
    });

    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    }); 
    checkTypeOfDesc();
    setIniDatesXMonth("#fechaIncial", "#endDate");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    // general();
});

let titulos_intxt = [];
$('#tabla-general thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla-general').DataTable().column(i).search() !== this.value ) {
            $('#tabla-general').DataTable().column(i).search(this.value).draw();
        }
    });
});

function checkTypeOfDesc() {
    const tipoDescuento = $('#tipo_descuento').val();
    loadTable(tipoDescuento);
}

function loadTable(tipoDescuento) {
    $('#tabla-general').ready(function () {

        $('#tabla-general').on('xhr.dt', function (e, settings, json, xhr) {
            var general = 0;
            var recaudado = 0;
            var caja = 0;
            var pendiente = 0;

            $.each(json.data, function (i, v) {
                general += parseFloat(v.monto);
                recaudado += parseFloat(v.total_descontado);
                caja += parseFloat(v.pagado_caja);
             });

             pendiente = (general-recaudado-caja);

             var totalFinal = formatMoney(general);
             var recaudadoFinal = formatMoney(recaudado);
             var cajaFinal = formatMoney(caja);
             var pendienteFinal = formatMoney(pendiente);

            document.getElementById("totalGeneral").textContent = totalFinal;
            document.getElementById("totalRecaudado").textContent = recaudadoFinal;
            document.getElementById("totalPagadoCaja").textContent = cajaFinal;
            document.getElementById("totalPendiente").textContent = pendienteFinal;
        });

        tablaGeneral = $('#tabla-general').DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons:[
            {
                text: '<i class="fa fa-edit" id="btn-nuevo-descuento"></i> NUEVO DESCUENTO',
                action: function () {
                   
                        open_Mb();
             
                },
                attr: {
                    class: ' btn-azure'
                }
            },
            {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Descuentos Universidad',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }, {
            text: '<i class="fa fa-edit" id="btn-nuevo-descuento"></i> NUEVO DESCUENTO',
            action: function () {
                aplicarDescuento();

            },
            attr: {
                class: ' btn-azure'
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        columns:[
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.id_usuario}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.nombre}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.puesto}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em;">${d.sede}</p>`;
                }},
                {"data": function (d) {
                    if (d.saldo_comisiones < 12500) {
                        color = 'color:gray';
                    } else{
                        color = 'color:blue';
                    }
                    return `<p style="font-size: 1em; ${color}">${formatMoney(d.saldo_comisiones)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em"><b>${formatMoney(d.monto)}</b></p>`;
                }},
                {"data": function (d) {
                    descontado = 0;
                    if (d.total_descontado == null || d.total_descontado <= 1) {
                        descontado = d.pagado_caja;
                    } else {
                        descontado = d.total_descontado;
                    }
                    return `<p style="font-size: 1em">${formatMoney(descontado)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em; color:gray">${formatMoney(d.pagado_caja)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em; color:gray">${formatMoney(d.pendiente)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em">${formatMoney(d.pago_individual)}</p>`;
                }},
                {"data": function (d) {
                    reactivado = '';
                    valor = '';

                    if(d.estatus == 5){
                        reactivado = `<span class="label lbl-vividOrange">REACTIVADO ${(d.fecha_modificacion)}</span>`;
                    }
                    if(d.estado_usuario != 1){
                        reactivado = `<span class="label lbl-warning">USUARIO BAJA</span>`;
                    }
                    if (d.saldo_comisiones < 12500 && d.estatus != 5 && d.estatus != 2 && d.estatus != 3 && d.estatus != 4) {
                        valor = '<span class="label lbl-gray">SIN SALDO</span>';
                    } else if (d.estatus == 1 || d.banderaReactivado == 1 ) {
                        valor = '<span class="label lbl-violetChin">DISPONIBLE</span>';
                    } else if (d.estatus == 2) {
                        valor = '<span class="label lbl-blueMaderas">DESCUENTO APLICADO</span>';
                    } else if (d.estatus == 3) {
                        valor = '<span class="label lbl-warning">Detenido</span>';
                    } else if (d.estatus == 4) {
                        valor = '<span class="label lbl-green">LIQUIDADO</span>';
                    } else{
                        valor = '';
                    }
                    return valor+reactivado;
                }},
                {"data": function (d) {
                    pagosDescontar = 0;
                    color = '';
                    valor = 0;
                    pendiente = 0;
                    
                    if (d.saldo_comisiones >= 12500 && (d.estatus == 1 || d.banderaReactivado == 1) && d.pendiente > 1) {//TODAS SEDES
                        color = 'color:purple';
                        valor = Math.round(d.saldo_comisiones/12500);
                        pendiente = Math.round(d.pendiente/d.pago_individual);
                        pagosDescontar = valor>pendiente ? d.pendiente : valor*d.pago_individual;
                    }
                    return `<p style="font-size: 1em; ${color}">${formatMoney(pagosDescontar)}</p>`;
                }},
                {"data": function (d) {
                    return `<p style="font-size: 1em">${(d.primer_descuento) ? d.primer_descuento : 'SIN APLICAR'}</p>`;
                }},
                {"data": function (d) {
                    return '<p style="font-size: 1em">' + d.fecha_creacion + '</p>';
                }},
                {"data": function (d) {
                    if(d.certificacion == 0){
                        return '<p style="font-size: 1em;">SIN ESTATUS</p>';
                    }else {
                        return `<span class='label lbl-${(d.colorCertificacion)}'>${(d.certificacion)}</span>`;
                    }
                }},
                {"data": function (d) {
                    adicionales = '';
                    
                    if(d.total_descontado > 1){//MIENTRAS TENGA SALDO APLICADO PODRA CONSULTAR LA INFO
                        base = '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_descuentos" title="Detalles">' + '<i class="fas fa-info-circle"></i></button>'+ '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-green consultar_fecha_pagos" title="Historial pagos">' + '<i class="fas fa-file"></i></button>';
                    } else{
                        base = '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-green consultar_fecha_pagos" title="Historial pagos">' + '<i class="fas fa-file"></i></button>';
                    }
                    
                    if (d.saldo_comisiones >= 12500 && (d.estatus == 1 || d.banderaReactivado == 1) && d.pendiente > 1 && d.estado_usuario == 1) {//TODAS SEDES
                        valor = Math.round(d.saldo_comisiones/12500);
                        pendiente = Math.round(d.pendiente/d.pago_individual);
                        pagosDescontar = valor>pendiente ? d.pendiente : valor*d.pago_individual;
                                    
                        adicionales = `<button href="#" 
                        value="${d.id_usuario}" 
                        data-value="${pagosDescontar}"
                        data-saldoComisiones="${d.saldo_comisiones}"
                        data-nombre="${d.nombre}" 
                        data-code="${d.cbbtton}"
                        class="btn-data btn-violetDeep aplicarDescuentoMensual" title="Aplicar descuento"><i class="fas fa-plus"></i>
                        </button>
                                
                        <button href="#" 
                        value="${d.id_usuario}" 
                        data-value="${pagosDescontar}"
                        data-saldoComisiones="${d.saldo_comisiones}"
                        data-nombre="${d.nombre}" 
                        data-code="${d.cbbtton}"
                        data-descuento="${d.id_descuento}"
                        data-certificacion="${d.idCertificacion}"
                        class="btn-data btn-gray certificado_op"
                        id="certificado_op" name="certificado_op"
                         title="Cambiar certifiacación"><i class="fas fa-closed-captioning"></i>
                        </button>
                                

                        <button href="#" 
                        value="${d.id_usuario}"
                        data-nombre="${d.nombre}"
                        data-rol="${d.puesto}"
                        data-totalDescuento="${d.monto}"
                        data-abonado="${d.total_descontado+d.pagado_caja}"
                        class="btn-data btn-orangeYellow topar_descuentos" title="Detener descuentos"><i class="fas fa-ban"></i>
                        </button>
                        `;
                    } else if(d.estatus == 3 && d.pendiente > 1 && d.estado_usuario == 1){ //DESCUENTOS DETENIDOS
                        adicionales = `<button value="${d.id_usuario}" 
                        data-value="${d.id_descuento}"
                        data-pendiente="${d.pendiente}"
                        class="btn-data btn-violetDeep activar-prestamo" title="Activar"> <i class="fa fa-rotate-left"></i> 
                        </button>`;
                    }
                    return '<div class="d-flex justify-center">'+base+adicionales+'</div>';
                }}],
            
                "ajax": {
                "url": `getDescuentosUniversidad/`+tipoDescuento,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });

        $("#tabla-general tbody").on("click", ".consultar_logs_descuentos", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $("#nombreUsuario").html('');
            $("#lista-comentarios-descuentos").html('');

            id_user = $(this).val();
            usuario = $(this).attr("data-value");

            $("#historialLogsPagos").modal();
            $("#nombreUsuario").append(usuario);

            $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                let saldo_comisiones;

                if(data.saldo_comisiones == 'NULL' || data.saldo_comisiones=='null' || data.saldo_comisiones==undefined){
                    saldo_comisiones = '';
                } else {
                    saldo_comisiones = '<label style="font-size:small;border-radius: 13px;background: rgb(0, 122, 255);' + 'color: white;padding: 0px 10px;">Monto comisionado: <b>'+data.saldo_comisiones+'</b></label>';
                }

                if (!data) {
                    $("#lista-comentarios-descuentos").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');
                } else {
                    $.each(data, function (i, v) {
                        $("#lista-comentarios-descuentos").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;"><b>Comentario: </b>Se descontó la cantidad de <b>' + formatMoney(v.comentario) +'</b><br>' + v.comentario2 +''+saldo_comisiones+'<br><b style="color:#3982C0;font-size:0.9em;">Movimiento: ' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });
        });

        $('#tabla-general tbody').on('click', '.activar-prestamo', function (e) {

            id_usuario = $(this).val();
            id_descuento = $(this).attr("data-value");

            $('#id-descuento-pago').val(id_descuento);
            $('#activar-pago-form').trigger('reset');
            $('#activar-pago-modal').modal();
            
        });

        $("#tabla-general tbody").on("click", ".aplicarDescuentoMensual", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#listaLotesDisponibles").html('');
            $("#informacionGeneral").html('');
            $("#arrayLotes").val('');
            $("#usuarioId").val('');
            $("#nombre").val('');
            $("#saldoComisiones").val('');
            $("#comentario").val('');

            id_user = $(this).val();
            monto = $(this).attr("data-value");
            sde = $(this).attr("data-sede");
            validar = $(this).attr("data-validate");
            saldoComisiones = $(this).attr("data-saldoComisiones");
            nombreUsuario = $(this).attr("data-nombre");

            $("#modalAplicarDescuento modal-body").html("");
            $("#modalAplicarDescuento").modal();

            var user = $(this).val();
            let datos = user.split(',');
            $("#montoaDescontar").val( formatMoney(monto));
            $("#usuarioId").val(id_user);
            $('#saldoComisiones').val(saldoComisiones);
            $('#informacionGeneral').append('<p>Descuento a <b>'+nombreUsuario+'</b>, saldo en comisiones: <b>'+ formatMoney(saldoComisiones)+'</b></p>');

            $.post('getLotesDescuentosUniversidad/' + id_user + '/' + monto, function (data) {
                var len = data.length;
                let  info = ''; 
                let sumaselected = 0;
                for (var i = 0; i < len; i++) {

                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = parseFloat(data[i]['comision_total']) - parseFloat(data[i]['abono_pagado']);
                    sumaselected = sumaselected + parseFloat(data[i]['comision_total']);
                    info += "<p>"
                    info += (i+1) + ' - ' + name;
                    info += ' - <b>';
                    info += formatMoney(comtotal.toFixed(2));
                    info += '</b></p>';

                    $("#arrayLotes").val(`${comision},${comtotal.toFixed(2)},${pago_neodata},${name}`);
                    $("#comentario").val(`DESCUENTO UNIVERSIDAD MADERAS POR EL MONTO DE ${formatMoney(monto)}`);
                }

                $("#listaLotesDisponibles").append(info);
                $("#totalDisponible").val(formatMoney(sumaselected));
                $("#listaLotesDisponibles").selectpicker('refresh');
            }, 'json'); 
        });
 
   

    $("#tabla-general tbody").on("click", ".consultar_fecha_pagos", function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();
        document.getElementById('nameUser').innerHTML = '';
        document.getElementById('sumaMensualComisiones').innerHTML = '';
        $('#userid').val(0);
        id_user = $(this).val();
        usuario = $(this).attr("data-value");
        $('#userid').val(id_user);
        $("#seeInformationModalP").modal();
        $('#nameUser').append('<p>Usuario: <b>'+usuario+'</b></p>');
        let datos = '';
        let datosA = '';
        for (let index = 0; index < meses.length; index++) {
             datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`;
        }
        for (let index = 0; index < anios.length; index++) {
             datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`;
        }
        $('#mes').html(datos);
        $('#mes').selectpicker('refresh');
        $('#anio').html(datosA);
        $('#anio').selectpicker('refresh');
    });

    $('#mes').change(function() {
        anio = $('#anio').val();
        mes = $('#mes').val();
        let usuario = $('#userid').val();
        if(anio == ''){
            anio=0;
        }else{
    
            getPagosByUser(usuario,mes, anio);
        }
    });
    
    function getPagosByUser(usuario,mes, anio){
        document.getElementById('sumaMensualComisiones').innerHTML = 'Cargando...';
        $.getJSON("getPagosByUser/" + usuario+"/"+mes+"/"+anio).done(function (data) {
            document.getElementById('sumaMensualComisiones').innerHTML = formatMoney(data[0].suma);
        });
    }

    $('#anio').change(function() {
        let usuario = $('#userid').val();
        mes = $('#mes').val();
        anio = $('#anio').val();
    
        if(mes != '' && (anio != '' || anio != null || anio != undefined)){
            getPagosByUser(usuario,mes, anio);
        }
    });

    $("#tabla-general tbody").on("click", ".topar_descuentos", function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();
     
        $('#mensajeConfirmacion').html('');
        $('#comentarioTopar').html('');
        $('#montosDescuento').html('');

        $('#usuarioTopar').val(0);
        id_user = $(this).val();
        nombreUsuario = $(this).attr("data-nombre");
        rolUsuario = $(this).attr("data-rol");
        totalDescuento = $(this).attr("data-totalDescuento");
        abonado = $(this).attr("data-abonado");
        
        $('#mensajeConfirmacion').append('<p>¿Está seguro de detener los pagos al '+rolUsuario+' <b>'+ nombreUsuario+'</b>?</p>');
        $('#montosDescuento').append('<p>Total descuento: <b>'+formatMoney(totalDescuento)+'</b></p><p>Monto descontado: <b>'+formatMoney(abonado)+'</b></p>');
        $('#usuarioTopar').val(id_user);
        $("#modal_nuevas").modal();

    });

    $('#numeroMeses').change(function () {
    const totalDescuento = replaceAll($('#montoDescuento').val(), ',', '');
    const monto = replaceAll(totalDescuento, '$', '');
    const meses = parseFloat($('#numeroMeses').val());
    let resultado = 0;

    if (isNaN(monto)||isNaN(meses)) {
        alerts.showNotification("top", "right", "Revise la información ingresada.", "warning");
        $('#montoMensualidad').val(resultado);
    } else {
        resultado = monto / meses;
        if (resultado > 0) {
            $('#montoMensualidad').val(formatMoney(resultado));
        } else {
            $('#montoMensualidad').val(formatMoney(0));
        }
    }
});

$('#montoDescuento').change(function () {
    const totalDescuento = replaceAll($('#montoDescuento').val(), ',', '');
    const monto = replaceAll(totalDescuento, '$', '');
    const meses = parseFloat($('#numeroMeses').val());
    let resultado = 0;

    if (isNaN(monto)||isNaN(meses)) {
        alerts.showNotification("top", "right", "Revise la información ingresada.", "warning");
        $('#montoMensualidad').val(resultado);
    } else {
        resultado = monto / meses;
        if (resultado > 0) {
            $('#montoMensualidad').val(formatMoney(resultado));
        } else {
            $('#montoMensualidad').val(formatMoney(0));
        }
    }
});


}); //END DATATABLE



$("#tabla-general").on("click", ".certificado_op", function () {
    id_descuento = $(this).attr("data-descuento");
    certificacion = $(this).attr("data-certificacion");
    document.getElementById("idDescuento").value = id_descuento;

    $("#modalcertificado").modal();

});

$("#form_certificado").submit(function (e) {
    $('#btn_abonar').prop('disabled', true);
    document.getElementById('btn_abonar').disabled = true;

    $('#idloteorigen').removeAttr('disabled');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'updatePrestamosUniversidad/',
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data)
                alerts.showNotification("top", "right", "Préstamo actualizado", "success");
                $('#tabla-general').DataTable().ajax.reload(null, false);
                $('#modalcertificado').modal('toggle');
            },
            error: (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }
        
        })
    }


});;

$("#formularioAplicarDescuento").submit(function (e) {
    $('#btn_abonar').prop('disabled', true);
    document.getElementById('btn_abonar').disabled = true;

    $('#idloteorigen').removeAttr('disabled');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'aplicarDescuentoUMComisiones/',
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    $('#idloteorigen option').remove();
                    $("#roles").val('');
                    $("#roles").selectpicker("refresh");
                    $('#usuarioid').val('default');
                    $('#usuarioid').val('default');

                    $("#usuarioid").selectpicker("refresh");

                    alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");

                } else if (data == 2) {
                    $('#loaderDiv').addClass('hidden');
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    $(".directorSelect2").empty();

                } else if (data == 3) {
                    $('#tabla-general').DataTable().ajax.reload(null, false);
                    $('#modalAplicarDescuento').modal('hide');
                    alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    $(".directorSelect2").empty();
                }
                $('#idloteorigen').attr('disabled', 'true');

            },
            error: function () {
                $('#loaderDiv').addClass('hidden');
                $('#modalAplicarDescuento').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#idloteorigen').attr('disabled', 'true');
            }
        });
    }
});


// Función para pausar la solicitud
$("#form_interes").submit(function (e) {
    // $('#btn_topar').attr('disabled', 'true');
    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
           $.ajax({
            url: general_base_url+"Universidad/toparDescuentoUniversidad",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data[0]) {
                    $("#modal_nuevas").modal('toggle');
                    alerts.showNotification("top", "right", "Se detuvo el descuento exitosamente", "success");
                    setTimeout(function () {
                        tablaGeneral.ajax.reload();
                    }, 3000);
                } else {
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            }, error: function () {
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA", "danger");
            }
        });
    }
});

$("#formAltaDescuento").submit(function (e) {
    $('#btn_alta').attr('disabled', 'true');
    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
           $.ajax({
            url: general_base_url+"Universidad/altaNuevoDescuentoUM",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data) {
                    $("#modalAgregarNuevo").modal('toggle');
                    $("#montoDescuento").val('');
                    $("#numeroMeses").val('');
                    $("#montoMensualidad").val('');
                    $("#descripcionAltaDescuento").val('');
                    alerts.showNotification("top", "right", "Se agregó el descuento exitosamente", "success");
                    setTimeout(function () {
                        tablaGeneral.ajax.reload();
                    }, 3000);
                } else {
                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                }
            }, error: function () {
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA", "danger");
            }
        });
    }
});



let meses = [
      {id:'01', mes:'Enero'},
      {id:'02',mes:'Febrero'},
      {id:'03',mes:'Marzo'},
      {id:'04',mes:'Abril'},
      {id:'05',mes:'Mayo'},
      {id:'06',mes:'Junio'},
      {id:'07',mes:'Julio'},
      {id:'08',mes:'Agosto'},
      {id:'09',mes:'Septiembre'},
      {id:'10',mes:'Octubre'},
      {id:'11',mes:'Noviembre'},
      {id:'12',mes:'Diciembre'}
    ];
    
    let anios = [2019,2020,2021,2022,2023,2024];

}

function open_Mb() {

   
 
    $('#open_Mb').empty();
    $("#FaltaUsuarios").show("slow");
    $("#ListoUsuarios").hide();
    $("#FaltaPuesto").show("slow");
    $("#FaltaMonto").show("slow");
    $("#FaltaDescuento").show("slow");
    $("#FaltaMensualidad").show("slow");
    $("#FaltaMotivo").show("slow");
    
    $("#roles").val('');
    $("#roles").selectpicker("refresh");

    // document.getElementById("users2").innerHTML = '';
   
    $("#usuarioid2").val('');
    $("#usuarioid2").selectpicker("refresh");

    $("#comentario2").val('');

    $('#ModalBonos').modal('show');
}

$('#ModalBonos').on('hidden.bs.modal', function() {
    $('#form_nuevo').trigger('reset');
  

    $("#FaltaPuesto").hide();
    $("#FaltaMonto").hide();
    $("#FaltaDescuento").hide();
    $("#FaltaMensualidad").hide();
    $("#FaltaMotivo").hide();
    $("#FaltaUsuarios").hide();

    $("#ListoPuesto").hide();
    $("#ListoDescuento").hide();
    $("#ListoMensualidad").hide();
    $("#ListoMonto").hide();
    $("#ListoMotivo").hide();
    $("#ListoUsuarios").hide();



    $("#numeroPagos").selectpicker("refresh");
});



$(document).on("click", ".uniAdd", function () {
    let banderaLiquidados = false;
    $("#modalUni").modal();

    document.getElementById("fechaIncial").value = '';

    document.getElementById("descuentoEscrito").value = '';
    // el que modificaremos    
    id_descuento = $(this).attr("data-value");
    //id_usuario perteneciente a ese id_user
    id_user = $(this).attr("data-code");    
    // aqui mero va la bander de saber que info se guardara
    pago_mensual = $(this).attr("data-mensual");
    nombre = $(this).attr("data-nombre")
    descuento = $(this).attr("data-descuento");
    fechaIncial = $(this).attr("data-fecha");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento
    MontoDescontarCerti = $(this).attr("data-value");
    valorCertificacion = $(this).attr("data-idCertificacion");
    // {document.getElementById("certificaciones").value = valorCertificacion;}

    if (descuento == total){
        banderaLiquidados = true;

    }else{

        banderaLiquidados = false;
    }
    descuento = Math.round(descuento);
    pago_mensual = Math.round(pago_mensual);

    cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos

    document.getElementById("fechaIncial").value = fechaIncial;
 
    document.getElementById("banderaLiquidado").value = banderaLiquidados;
    document.getElementById("dineroPagado").value = total;
    document.getElementById("pagoIndiv").value = pago_mensual;
    document.getElementById("idDescuento").value = id_descuento;
    document.getElementById("totalPagos").value = cantidad_de_pagos;
    document.getElementById("pagoDado").value = pagoDado;

    id_user = $(this).attr("data-code");
    pago_mensual = $(this).attr("data-mensual");
    descuento = $(this).attr("data-descuento");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento

    valorPendiente = pendiente;
    // users2
    var titulo  = ' ';
    titulo += '  <h3 id="tituloModalUni" name="tituloModalUni">Editando descuento actual para '+ nombre  +'</h3>';
    // eee
    // var cuerpoModalUni = document.getElementById('cuerpoModalUni');
    // cuerpoModalUni.innerHTML = informacion_adicional;

    document.getElementById("MontoDescontarCerti").value = pendiente;
    var myCommentsLote = document.getElementById('tituloModalUni');
    myCommentsLote.innerHTML = '';

    var Header_modal = document.getElementById('header_modal');
    Header_modal.innerHTML = titulo;
 
    //    mensualidadesFaltantes = total / pago_mensual ;
    //         mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;         
            // if ((mensualidadesFaltantesMostrar % 1)  == 0 ){

            // }else{
            //     if( 0 == Math.trunc(mensualidadesFaltantesMostrar))
            //     {
            //         if((mensualidadesFaltantesMostrar/mensualidadesFaltantesMostrar ) == 1)
            //         {
            //             mensualidadesFaltantesMostrar = 1;
            //         }else{

            //         }           
            //     }else{

            //         mensualidadesFaltantesMostrar =  Math.trunc(mensualidadesFaltantesMostrar);
            //     }
            // }
            // if ((mensualidadesFaltantes % 1)  == 0 ){

            // }else{
            //     if( 0 == Math.trunc(mensualidadesFaltantes))
            //     {
            //         if((mensualidadesFaltantes/mensualidadesFaltantes ) == 1)
            //         {

            //             mensualidadesFaltantes = 1;
            //         }else{
                    
            //         }
            //     }else{
            //             mensualidadesFaltantes =  Math.trunc(mensualidadesFaltantes);
            //     }
            // }
            // if(banderaLiquidados){
            //     document.getElementById("mensualidadesC").value = 1;
            //     mensualidadesFaltantesMostrar = 1;
            //     mensualidadesFaltantes = 1;
            // }else{
            //     mensualidadesFaltantesMostrar = valorPendiente  / pago_mensual ;
            //     document.getElementById("mensualidadesC").value = Math.trunc( mensualidadesFaltantesMostrar);
            // }


            // ultimaMensualidad = document.getElementById("mensualidadesC").value
            // Total_a_pagar = ultimaMensualidad * pago_mensual;

            // sobrante = Total_a_pagar - total;

            // //para agregar llo que ya se pago
            // descuentoEscrito = document.getElementById("MontoDescontarCerti").value;
         
            // NuevasMensualidades= (pendiente)  / ultimaMensualidad ;

            // if(banderaLiquidados){

            //     sobrante = document.getElementById("MontoDescontarCerti").value;
            //     sobrante =  total - sobrante ;
            //     NuevasMensualidades = sobrante  / mensualidadesFaltantes;
            // }
            // document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
            // //faltantes = mensualidadesFaltantes/mensual;
            // document.getElementById("precioOrginal").value =   NuevasMensualidades.toFixed(2);

});  

$(document).on("click", "#cancelarOperation", function () {
$('#editDescuento').modal('hide');
});

$('#editDescuento').on("click", "#editarDescuentos", function (){

});
$(document).on("click", "#editarDescuentos", function () {
    $('#botonesInicio').css('display', 'none');
    $('#updateDescuento').css('display', 'block');
    $('#fomularioEditarDescuento').css('display', 'block');
});
$(document).on("click", "#descuentoCertificaciones", function () {

}); 

// Nueva functionalidad
 //  aqui mero 

$("#certificaciones").change(function () {

   
    selectCertificacion = document.getElementById("certificaciones").value;

    var comentarioDescrip = document.getElementById('textDescripcion');
    comentarioDescrip.innerHTML = '';
    if(selectCertificacion == 1){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que obtuvo una calificación favorable y con ello la certificación.';
    }else if(selectCertificacion == 2){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que obtuvo una ponderación menor a la deseada y por ende no obtiene la certificación';
    }else if(selectCertificacion == 3){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que al no seguir los lineamientos de la institución evaluadora se le suspende su proceso de certificación. ';
    }else if(selectCertificacion == 4){
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'Persona que se encuentra por hacer examen final con el Tecnológico de Monterrey.';
    }else if(selectCertificacion == 5){
        comentarioDescrip.innerHTML = 'Personas que está en valoración el que se certifiquen en este año, así que en sus casos hay que dejar activo el pago, porque dependiendo de cómo se desenvuelva cada caso puede ser que aplique incremento.';
        comentarioDescrip.innerHTML = '';
    }else{
        comentarioDescrip.innerHTML = '';
        comentarioDescrip.innerHTML = 'No definido';
    }
    
});

$(document).on("click", ".editar_descuentos", function () {


});

function subirInfo(){  
    document.getElementById("descuentoEscrito").value = '';
    id_descuento = $(this).attr("data-value");
    id_user = $(this).attr("data-code");    
    // aqui mero va la bander de saber que info se guardara
    pago_mensual = $(this).attr("data-mensual");
    descuento = $(this).attr("data-descuento");
    pendiente = $(this).attr("data-pendiente");//cantidad de dinero que falta
    total = $(this).attr("data-total"); //dinero que ha pagado al momento
    descuento = Math.round(descuento);
    pago_mensual = Ma/th.round(pago_mensual);
    cantidad_de_pagos = descuento / pago_mensual;//para saber en cuanto se dividieron los pagos
    document.getElementById("pagado").value = total;
    document.getElementById("mensualidad").value = pago_mensual;
    document.getElementById("descuento_id").value = id_descuento;
    document.getElementById("pagoDado").value = dineroPagado;
    valor = 0;
    valor1 = 0;
 }
 
$(document).on('input', '.MontoDescontarCerti', function(){

    mensualidadesC = document.getElementById("mensualidadesC").value;
    pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
    loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
    pagos  = document.getElementById("mensualidadesC").value ;
    banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
    if(banderaLiquidado){
     

        NuevasMensualidades = loQueSedebe / pagos;
    }else{

        NuevasMensualidades = loQueSedebe / pagos;   
    }

    document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
});

// $("#numeroPagos").change(function () {
    $(document).on('change', '#mensualidadesC', function() {

        mensualidadesC = document.getElementById("mensualidadesC").value;
        loQueSedebe = document.getElementById("MontoDescontarCerti").value ;
        pagado = document.getElementById("dineroPagado").value ;  // lo que se ya se ha pagado
        pagos  = document.getElementById("mensualidadesC").value ;
        console.log('mensualidadesC')
        console.log(mensualidadesC)
        console.log('loQueSedebe')
        console.log(loQueSedebe)
        console.log('pagado')
        console.log(pagado)
        console.log('pagos')
        console.log(pagos)

        banderaLiquidado  = document.getElementById("banderaLiquidado").value ;
        if(banderaLiquidado){
          
            NuevasMensualidades = loQueSedebe / mensualidadesC;
  
        }else{
         
            NuevasMensualidades = loQueSedebe / mensualidadesC;
        } 
        document.getElementById("newMensualidades").value =  NuevasMensualidades.toFixed(2);
    
    });
                                                          
    $("#updateDescuentoCertificado").submit(function (e) {


        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

    let tipoDescuento = $('#tipo_descuento').val();
    // let fechaSeleccionada = $('#fechaIncial').val();
    const fecha = new Date()    
    let pagos_activos ;
    let banderaSoloEstatus = false ; 
    let banderaPagosActivos = 0 ;
    // bandera pagos activos
    let fechanoEscrita = false; 
    // 1 fecha usuario < día 5  mismo mes  2: fecha usuario > día 5 y > mes actual  3: no se mueve los movimientos actuales,
    let validacion = false;
    let banderaEditarEstatus = document.getElementById("precioOrginal").value; 
    let escritoPorUsuario = document.getElementById("newMensualidades").value;
    let fechaSeleccionada = '';
    fechaSeleccionada = document.getElementById("fechaIncial").value;

    if(tipoDescuento == 3){
        estatus = 1;
    }else{
        estatus = '';
    }
    
    if(fechaSeleccionada == '' && banderaEditarEstatus == escritoPorUsuario){
        banderaSoloEstatus = true ;    
    }else{
        fechanoEscrita = true
        fechaSeleccionada == ''
    }
    year = fecha.getFullYear()
    month = (fecha.getMonth())
    day = fecha.getDate()
    // const msg = new day;
    const FechaEnArreglo = fechaSeleccionada.split("/");
    // fecha en arreglo es para poder entrar al mes posicion 0 es dia, 1  mes , año
    fechaComparar = (year + '-' + month + '-' + day);
    var f1 = new Date(year,month, day);
    var f2 = new Date(FechaEnArreglo[2],FechaEnArreglo[1],FechaEnArreglo[0] );

    MesSelecionado = parseInt(FechaEnArreglo[1]);
    DiaSeleccionado = parseInt(FechaEnArreglo[0]);
    MesSistemas = parseInt(month+1);
    console.log(FechaEnArreglo)
    console.log('  // fecha FechaEnArreglo ')
    // fecha f2 es para la fecha seleccionada 
    // fecha f1 es para la fecha del sistema 
    // Se compara las fechas son para 
    console.log(f1)
    console.log('  // fecha f1 es para la fecha del sistema ')
    console.log(f2)
    console.log('fecha f2 es para la fecha seleccionada ')
    if(  (f2 > f1 || f2 == f1)){
        // validamos que sea mayor la fecha seleccionada o que sean iguales
      
        if(DiaSeleccionado <= 10 ){
            banderaPagosActivos = 1;
            console.log(1)
            validacion =true;
                        // && MesSelecionado == MesSistemas  
        }else if(DiaSeleccionado  <= 10  ){
            banderaPagosActivos = 2 ;
            console.log(1)
            validacion =true;
        }else {
            alerts.showNotification("top", "right", "Se recomienda una fecha entre el primero al 10 de cada mes ", "info");
            banderaPagosActivos = 0;
        }
    }else if(f2 < f1){
        alerts.showNotification("top", "right", "Upss, La fecha seleccionada es menor que la fecha actual", "warning");
        validacion =false;
    }

    if(validacion ){


        mensualidadesC  = document.getElementById("mensualidadesC").value;
        id_descuento     = document.getElementById("idDescuento").value;
        monto           = document.getElementById("MontoDescontarCerti").value;
        pago_individual = document.getElementById("newMensualidades").value;
        // estatus_certificacion  = document.getElementById("certificaciones").value;
    
            $.ajax({
            url : 'descuentoUpdateCertificaciones',
            type : 'POST',
            dataType: "json",
            data: {
            "banderaSoloEstatus"    : banderaSoloEstatus, 
            "fechaSeleccionada"     : fechaSeleccionada, 
            "pagos_activos"         : pagos_activos,
            "estatus"               : estatus,
            "banderaPagosActivos"   : banderaPagosActivos,
            "id_descuento"          : id_descuento,
            "monto"                 : monto,
            "pago_individual"       : pago_individual,
              }, 
    
              success: function(data) {
               
                alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
                document.getElementById('updateDescuento').disabled = false;
                $('#tabla-general').DataTable().ajax.reload(null, false );
                
                // toastr[response.response_type](response.message);
                $('#modalUni').modal('toggle');
            },              
            error : (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }
    
        });
    }else{
    
    }

  
}});


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
function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const FechaIncial = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    FechaIncial = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
 
 
}

 
