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

    setIniDatesXMonth("#fechaIncial", "#endDate");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});

    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    }); 
    checkTypeOfDesc();
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
        bAutoWidth:true,
        buttons:[{
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
        destroy: true,
        ordering: false,
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
                    return `<p style="font-size: 1em">${formatMoney(d.total_descontado)}</p>`;
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
                    editar = '';
                    detener = '';      

                    if(d.total_descontado > 1 && d.estado_usuario == 3){//MIENTRAS TENGA SALDO APLICADO PODRA CONSULTAR LA INFO
                        base = `<button href="#" value="${d.id_usuario}" data-value="${d.nombre}" data-code="${d.id_usuario}" class="btn-data btn-blueMaderas consultar_logs_descuentos" title="Historial pagos"><i class="fas fa-info-circle"></i></button><button href="#" value="${d.id_usuario}" data-value="${d.nombre}" data-code="${d.id_usuario}" class="btn-data btn-green consultar_fecha_pagos" title="Consulta de saldos"><i class="fas fa-file"></i></button>
                        
                        <button href="#" 
                        value="${d.id_usuario}" 
                        data-value="${pagosDescontar}"
                        data-saldoComisiones="${d.saldo_comisiones}"
                        data-nombre="${d.nombre}" 
                        data-code="${d.cbbtton}"
                        data-descuento="${d.id_descuento}"
                        data-certificacion="${d.idCertificacion}"
                        class="btn-data btn-gray btn_certificacion"
                        id="btn_certificacion" name="btn_certificacion"
                        title="Asignar certificación"><i class="fas fa-closed-captioning"></i>
                        </button>
                        `;

                    } else{
                        base = `<button href="#" value="${d.id_usuario}" data-value="${d.nombre}" data-code="${d.id_usuario}" class="btn-data btn-green consultar_fecha_pagos" title="Consulta de saldos"><i class="fas fa-file"></i></button>
                        <button href="#" 
                        value="${d.id_usuario}" 
                        data-value="${pagosDescontar}"
                        data-saldoComisiones="${d.saldo_comisiones}"
                        data-nombre="${d.nombre}" 
                        data-code="${d.cbbtton}"
                        data-descuento="${d.id_descuento}"
                        data-certificacion="${d.idCertificacion}"
                        class="btn-data btn-gray btn_certificacion"
                        id="btn_certificacion" name="btn_certificacion"
                        title="Asignar certificación"><i class="fas fa-closed-captioning"></i>
                        </button>
                        `;
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
                                
                        `;
                    } 

                    if(d.estado_usuario == 1){

                        editar = `<button value="${d.id_usuario}"
                        data-nombre="${d.nombre}"
                        data-descuento="${d.id_descuento}"
                        data-monto="${d.monto}"
                        data-descontado="${d.total_descontado}"
                        data-mensualidad="${d.pago_individual}"
                        class="btn-data btn-acidGreen btn_editarDescuento" title="Editar Descuento"><i class="fas fa-money-check-alt"></i>
                        </button>
                        `;
                    }

                    if(d.estatus != 3){

                        detener = `<button href="#" 
                        value="${d.id_usuario}"
                        data-nombre="${d.nombre}"
                        data-rol="${d.puesto}"
                        data-totalDescuento="${d.monto}"
                        data-abonado="${d.total_descontado}"
                        class="btn-data btn-orangeYellow topar_descuentos" title="Detener descuentos"><i class="fas fa-ban"></i>
                        </button>
                        `;
                    }

                    return '<div class="d-flex justify-center">'+base+adicionales+editar+detener+'</div>';
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

        $("#tabla-general tbody").on("click", ".btn_certificacion", function () {
            
            id_descuento = $(this).attr("data-descuento");
            certificacion = $(this).attr("data-certificacion");
            document.getElementById("idDescuento").value = id_descuento;
            document.getElementById("certificaciones").value = certificacion;

            $("#certificaciones").selectpicker('refresh');
            $("#modalCertificacion").modal();
        
        });

        $("#certificaciones").change(function () {
            selectCertificacion = document.getElementById("certificaciones").value;
        
            var comentarioDescrip = document.getElementById('textDescripcion');
            comentarioDescrip.innerHTML = '';
            if(selectCertificacion == 1){
                comentarioDescrip.innerHTML = '';
                comentarioDescrip.innerHTML = 'Persona que obtuvo una calificación favorable y con ello la certificación.';
            }else if(selectCertificacion == 2){
                comentarioDescrip.innerHTML = '';
                comentarioDescrip.innerHTML = 'Persona que obtuvo una ponderación menor a la deseada y por ende no obtiene la certificación.';
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
                comentarioDescrip.innerHTML = 'Sin definir.';
            }
            
        });

        $("#tabla-general tbody").on("click", ".aplicarDescuentoMensual", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#arrayLotes").val('');
            $("#listaLotesDisponibles").html('');
            $("#informacionGeneral").html('');
            // $("#arrayLotes").val('');
            $("#usuarioId").val('');
            $("#nombre").val('');
            $("#saldoComisiones").val('');
            $("#comentario").val('');
            $("#arrayLotes").selectpicker('refresh');
            $('#arrayLotes option').remove();

            id_user = $(this).val();
            monto = $(this).attr("data-value");
            sde = $(this).attr("data-sede");
            validar = $(this).attr("data-validate");
            saldoComisiones = $(this).attr("data-saldoComisiones");
            nombreUsuario = $(this).attr("data-nombre");
            $('#btn_abonar').prop('disabled', false);

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
                // let  datosLotes = []; 
                let sumaselected = 0;
                for (var i = 0; i < len; i++) {

                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comisionTotal = parseFloat(data[i]['comision_total']) - parseFloat(data[i]['abono_pagado']);
                    sumaselected = sumaselected + parseFloat(data[i]['comision_total']);
                    info += "<p>"
                    info += (i+1) + ' - ' + name;
                    info += ' - <b>';
                    info += formatMoney(comisionTotal.toFixed(2));
                    info += '</b></p>';

                    $("#arrayLotes").append(`<option value='${comision},${comisionTotal.toFixed(2)},${pago_neodata},${name}' selected="selected">${name}  -   $${formatMoney(comisionTotal.toFixed(2))}</option>`);
                }
                document.getElementById('arrayLotes').style.display = "block";

                $("#comentario").val(`DESCUENTO UNIVERSIDAD MADERAS POR EL MONTO DE ${formatMoney(monto)}`);

                $("#listaLotesDisponibles").append(info);
                $("#totalDisponible").val(formatMoney(sumaselected));
                $("#listaLotesDisponibles").selectpicker('refresh');
                $("#arrayLotes").selectpicker('refresh');

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



$(document).on("click", ".btn_editarDescuento", function () {
    $("#modalEditarDescuento").modal();

    document.getElementById("fechaIncial").value = '';
    $("#tituloModalEditar").html('');

    let date = new Date()
    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()

    if(month < 10){
        fechaIncial = day+"/0"+month+"/"+year
    } else{
        fechaIncial = day+"/"+month+"/"+year;
    }
   
    id_usuario = $(this).val();
    id_descuento = $(this).attr("data-descuento"); 
    total = $(this).attr("data-monto");    
    descontado = $(this).attr("data-descontado");    
    mensualidad = $(this).attr("data-mensualidad");    
     
    nombre = $(this).attr("data-nombre");    

    document.getElementById("fechaIncial").value = fechaIncial;
    document.getElementById("id_descuento").value = id_descuento;
    document.getElementById("total").value = total;
    document.getElementById("descontado").value = descontado;
    document.getElementById("nuevoMonto").value = formatMoney(total);
    document.getElementById("nuevoMontoMensual").value = formatMoney(mensualidad);
 
    $('#tituloModalEditar').append('<h3>Editar descuento a usuario <b>'+nombre+'</b></h3>');

});  

$(document).on('change', '#numeroMensualidades', function() {
 
    monto = document.getElementById("nuevoMonto").value;
    descontado = document.getElementById("descontado").value ;
    mensualidades = document.getElementById("numeroMensualidades").value;

    const montoFinalSigno = replaceAll(monto, '$', '');
    const montoFinal = replaceAll(montoFinalSigno, ',', '');
    const descontadoFinal = replaceAll(descontado, '$', '');

    totalMonto = parseFloat((montoFinal-descontadoFinal)/mensualidades);
    document.getElementById("nuevoMontoMensual").value = formatMoney(totalMonto);

});
 
function aplicarDescuento() {
    $("#puesto").val('');
    $("#puesto").selectpicker("refresh");
    $("#usuarios").val('');
    $("#usuarios").selectpicker("refresh");
    $("#descripcionAltaDescuento").val('');
    $('#modalAgregarNuevo').modal('show');
}

$("#form_certificado").submit(function (e) {
    $('#btn_abonar').prop('disabled', true);
    document.getElementById('btn_abonar').disabled = true;

    $('#idloteorigen').removeAttr('disabled');

    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data1 = new FormData($(form)[0]);
        $.ajax({
            url: 'updateCertificacion/',
            data: data1,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                // console.log(data)
                alerts.showNotification("top", "right", "Préstamo actualizado", "success");
                $('#tabla-general').DataTable().ajax.reload(null, false);
                $('#modalCertificacion').modal('toggle');
            },
            error: (a, b, c) => {
                alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
            }
        
        })
    }
});

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



$("#formEditarDescuento").submit(function (e) {
    $('#btn_alta').attr('disabled', 'true');
    e.preventDefault();
}).validate({
    submitHandler: function (form) {

        var data = new FormData($(form)[0]);
           $.ajax({
            url: general_base_url+"Universidad/editarDescuentoUM",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data) {
                    $("#modalEditarDescuento").modal('toggle');

                    $("#montoDescuento").val('');
                    $("#numeroMeses").val('');
                    $("#montoMensualidad").val('');
                    $("#descripcionAltaDescuento").val('');

                    alerts.showNotification("top", "right", "Se editó el descuento exitosamente", "success");
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
