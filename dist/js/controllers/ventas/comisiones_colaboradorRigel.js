$(document).ready(function() {
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            $("#proyecto28").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $("#proyecto28").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

    for (let index = 1; index <= 4; index++) {
            $.post(general_base_url + "Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $('#proyecto'+index).append($('<option>').val(id).text(name.toUpperCase()));
                $('#proyecto28'+index).append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#proyecto'+index).selectpicker('refresh');
            $('#proyecto28'+index).selectpicker('refresh');
        }, 'json');
    }
});

$('#proyecto').change( function(){
    index_proyecto = $(this).val();
    index_condominio = 0
    $("#condominio").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
    if (id_usuario_general != 2 && id_usuario_general != 3 && id_usuario_general != 13 && id_usuario_general != 32 && id_usuario_general != 17) { // SÓLO MANDA LA PETICIÓN SINO ES SUBDIRECTOR O GERENTE
        fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
    }
});

$('#condominio').change( function(){
    index_proyecto = $('#proyecto').val();
    index_condominio = $(this).val();
    fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
});

$('#proyecto28').change( function(){
    $('#spiner-loader').removeClass('hide');
    index_proyecto = $(this).val();
    index_condominio = 0
    $("#condominio28").html("");
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio28").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio28").selectpicker('refresh');
        }, 'json');
            $('#tabla_resguardo_comisiones').removeClass('hide');
    });
    fillCommissionTableRESGUARDO(index_proyecto, index_condominio);
});

$('#condominio28').change( function(){
    index_proyecto = $('#proyecto28').val();
    index_condominio = $(this).val();
    fillCommissionTableRESGUARDO(index_proyecto, index_condominio);
});

$('#proyecto1').change( function(){
    index_proyecto = $(this).val();
    index_condominio = 0
    $('#condominio1').html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $('#condominio1').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#condominio1').selectpicker('refresh');
        }, 'json');
        $('#tabla_nuevas_comisiones').removeClass('hide');
    });
    fillCommissionTableNUEVAS(index_proyecto, 0);
});

$('#condominio1').change( function(){
    index_proyecto = $('#proyecto1').val();
    index_condominio = $(this).val();
    fillCommissionTableNUEVAS(index_proyecto, index_condominio);
});

$('#proyecto2').change( function(){
    index_proyecto = $(this).val();
    index_condominio = 0
    $('#condominio2').html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;

            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $('#condominio2').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#condominio2').selectpicker('refresh');
        }, 'json');
        $('#tabla_revision_comisiones').removeClass('hide');
    });
    fillCommissionTableREVISION(index_proyecto, 0);
});

$('#condominio2').change( function(){
    index_proyecto = $('#proyecto2').val();
    index_condominio = $(this).val();
    fillCommissionTableREVISION(index_proyecto, index_condominio);
});

$('#proyecto3').change( function(){
    index_proyecto = $(this).val();
    index_condominio = 0
    $('#condominio3').html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $('#condominio3').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#condominio3').selectpicker('refresh');
        }, 'json');
        $('#tabla_pagadas_comisiones').removeClass('hide');
    });
    fillCommissionTablePAGADAS(index_proyecto, 0);
});

$('#condominio3').change( function(){
    index_proyecto = $('#proyecto3').val();
    index_condominio = $(this).val();
    // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
    fillCommissionTablePAGADAS(index_proyecto, index_condominio);
});
var totaPen = 0;
var tr;

$('#proyecto4').change( function(){
    index_proyecto = $(this).val();
    index_condominio = 0
    $('#condominio4').html("");
    $('#spiner-loader').removeClass('hide');
    $(document).ready(function(){
        $.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++){
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $('#condominio4').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#condominio4').selectpicker('refresh');
        }, 'json');
        $('#tabla_otras_comisiones').removeClass('hide');
    });
    
    fillCommissionTableOTRAS(index_proyecto, 0);
});

$('#condominio4').change( function(){
    index_proyecto = $('#proyecto4').val();
    index_condominio = $(this).val();
    // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
    fillCommissionTableOTRAS(index_proyecto, index_condominio);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tableDinamicMKTD2 ;
var totaPen = 0;
let titulos = [];

$('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
    if(i != 0){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if ($('#tabla_nuevas_comisiones').DataTable().column(i).search() !== this.value) {
                $('#tabla_nuevas_comisiones').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_nuevas.rows({ selected: true, search: 'applied'}).indexes();
                var data = tabla_nuevas.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_nuevas").textContent = formatMoney(total);
            }
        });
    }
    else {
        $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
    }
});

function fillCommissionTableNUEVAS(proyecto,condominio){
    $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("myText_nuevas").textContent = to;
    });

    $("#tabla_nuevas_comisiones").prop("hidden", false);
    tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100",
        scrollX: true,
        buttons: [
             {
                text: '<i class="fas fa-paper-plane"></i>SOLICITAR PAGO',
                action: function() {
                    var hoy = new Date();
                    var dia = hoy.getDate();
                    var mes = hoy.getMonth()+1;
                    var hora = hoy.getHours();

                    if(((mes == 1 && dia ==  9) || (mes == 1 && dia == 10 && hora <= 13)) ||
                    ((mes == 2 && dia == 13) || (mes == 2 && dia == 14 && hora <= 13)) ||
                    ((mes == 3 && dia == 13) || (mes == 3 && dia == 14 && hora <= 13)) ||
                    ((mes == 4 && dia == 10) || (mes == 4 && dia == 11 && hora <= 13)) ||
                    ((mes == 5 && dia ==  8) || (mes == 5 && dia ==  9 && hora <= 13)) ||
                    ((mes == 6 && dia == 29) || (mes == 6 && dia == 30 && hora <= 13)) ||
                    ((mes == 7 && dia == 10) || (mes == 7 && dia == 11 && hora <= 13)) ||
                    ((mes == 8 && dia ==  7) || (mes == 8 && dia == 8 && hora <= 13)) ||
                    ((mes == 9 && dia == 11) || (mes == 9 && dia == 12 && hora <= 13)) ||
                    ((mes == 10 && dia == 9) || (mes == 10 && dia == 10 && hora <= 13)) ||
                    ((mes == 11 && dia == 13) || (mes == 11 && dia == 14 && hora <= 13)) ||
                    ((mes == 12 && dia == 11) || (mes == 12 && dia == 12 && hora <= 13)))
                    {

                        if ($('input[name="idT[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 
                            $.ajax({
                                url : general_base_url + 'Comisiones/acepto_comisiones_user/',
                                data: com2,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST', 
                                success: function(data){
                                    response = JSON.parse(data);
                                    if(data == 1) {
                                        $('#spiner-loader').addClass('hide');
                                        $("#totpagarPen").html(formatMoney(0));
                                        $("#all").prop('checked', false);
                                        var fecha = new Date();
                                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");
                                        tabla_nuevas.ajax.reload(null,false);
                                        tabla_revision.ajax.reload();
                                    }
                                    else {
                                        $('#spiner-loader').addClass('hide');
                                        alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                    }
                                },
                                error: function( data ){
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                }
                            });
                        }
                    }
                    else{
                        $('#spiner-loader').addClass('hide');
                        alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al lunes y martes de la semana de corte", "warning");      
                    }
                },
                attr: {
                    class: 'btn btn-azure',
                }
            }, 
            {
            text: '<i class="fa fa-share" aria-hidden="true"></i> ENVIAR A RESGUARDO',
            action: function() {
                var hoy = new Date();
                var dia = hoy.getDate();
                var mes = hoy.getMonth()+1;
                var anio = hoy.getFullYear();
                var hora = hoy.getHours();
                var minuto = hoy.getMinutes();


                if(((mes == 1 && dia ==  11) || (mes == 1 && dia == 12 && hora <= 13)) ||
                ((mes == 2 && dia == 15) || (mes == 2 && dia == 16 && hora <= 13)) ||
                ((mes == 3 && dia == 15) || (mes == 3 && dia == 16 && hora <= 13)) ||
                ((mes == 4 && dia == 12) || (mes == 4 && dia == 13 && hora <= 13)) ||
                ((mes == 5 && dia == 10) || (mes == 5 && dia == 11 && hora <= 13)) ||
                ((mes == 6 && dia == 29) || (mes == 6 && dia == 30 && hora <= 13)) ||
                ((mes == 7 && dia == 12) || (mes == 7 && dia == 13 && hora <= 13)) ||
                ((mes == 8 && dia ==  9) || (mes == 8 && dia == 10 && hora <= 13)) ||
                ((mes == 9 && dia == 13) || (mes == 9 && dia == 14 && hora <= 13)) ||
                ((mes == 10 && dia == 11) || (mes == 10 && dia == 12 && hora <= 13)) ||
                ((mes == 11 && dia == 15)  || (mes == 11 && dia == 16 && hora <= 13)) ||
                ((mes == 12 && dia == 13) || (mes == 12 && dia == 14 && hora <= 13)))
                {

                    if ($('input[name="idT[]"]:checked').length > 0) {
                        $('#spiner-loader').removeClass('hide');
                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                            return this.value;
                        }).get();

                        var com2 = new FormData();
                        com2.append("idcomision", idcomision); 

                        $.ajax({
                            url : general_base_url + 'Comisiones/acepto_comisiones_resguardo/',
                            data: com2,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST', 
                            success: function(data){
                                response = JSON.parse(data);
                                if(data == 1) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#totpagarPen").html(formatMoney(0));
                                    $("#all").prop('checked', false);
                                    var fecha = new Date();

                                    alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Resguardo.", "success");

                                    tabla_nuevas.ajax.reload(null,false);
                                    tabla_revision.ajax.reload();
                                } else {
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                }
                            },
                            error: function( data ){
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                            }
                        });  
                    }
                }
                else {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al miércoles y jueves de la semana de corte", "warning"); 
                }
            },
            attr: {
                class: 'btn buttons-pdf',
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES NUEVAS',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx -1 ] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url  + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
           
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.id_pago_i + '</p>';
            }
        },

        {
            "data": function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
    
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
            }
        },

        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orangeYellow">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "data": function(d) {
                switch (d.forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="m-0"><span class="label lbl-gray">SIN DEFINIR FORMA DE PAGO</span><br><span class="label lbl-yellow">REVISAR CON RH</span></p>';
                    break;

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="m-0"><span class="label lbl-sky">FACTURA</span></p><p style="font-size: .5em"><span class="label lbl-melon" >SUBIR XML</span></p>';
                    break;

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="m-0"><span class="label lbl-blueMaderas">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR</span></p>';
                    break;

                    case '4': //RD
                    case 4: //RD
                        return '<p class="m-0"><span class="label lbl-violetBoots">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR</span></p>';
                    break;

                    default:
                        return '<p class="m-0"><span class="label lbl-gray">DOCUMENTACIÓN FALTANTE</span><br><span class="label lbl-yellow">REVISAR CON RH</span></p>';
                    break;
                }
            }
        },
        {
            "orderable": false,
            "data": function(data) {
                return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_nuevas" data-toggle="tooltip" data-placement="left" title="BITÁCORA DE CAMBIOS">' +'<i class="fas fa-info"></i></button></div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            render: function(d, type, full, meta) {
                var hoy = new Date();
                var dia = hoy.getDate();
                var mes = hoy.getMonth()+1;
                var hora = hoy.getHours();

                if (((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                ((mes == 10 && dia == 12) || (mes == 10 && dia == 13 && hora <= 13)) ||
                ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                ((mes == 11 && dia == 9) || (mes == 11 && dia == 10 && hora <= 13)) ||
                ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)) ||
                ((mes == 12 && dia == 14) || (mes == 12 && dia == 15 && hora <= 13)))
                {
                    switch (full.forma_pago) {
                        case '1': //SIN DEFINIR
                        case 1: //SIN DEFINIR
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        break;
                        case '2': //FACTURA
                        case 2: //FACTURA
                        case '3': //ASIMILADOS
                        case 3: //ASIMILADOS
                        case '4': //RD
                        case 4: //RD
                        default:
                            return '<input type="checkbox" name="idT[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                        break;
                    }
                } 
                else {
                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                }
            },
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+1,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function () {
			$('#spiner-loader').addClass('hide');
		},
    });

    $('#tabla_nuevas_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_nuevas_comisiones').on('click', 'input', function () {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
        if (row.pa == 0) {
            row.pa = row.pago_cliente;
            totaPen += parseFloat(row.pa);
            tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
        }
        else {
            totaPen -= parseFloat(row.pa);
            row.pa = 0;
        }
        $("#totpagarPen").html(formatMoney(totaPen));
    });

    $(document).off("click", ".consultar_logs_nuevas").on("click", ".consultar_logs_nuevas", function () {
        id_pago = $(this).val();
        user = $(this).attr("data-usuario");
        $('#spiner-loader').removeClass('hide');
        $("#seeInformationModalAsimilados").modal();
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIO: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
//FIN TABLA NUEVA

// INICIO TABLA RESGUARDO
$('#tabla_resguardo_comisiones thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if ($('#tabla_resguardo_comisiones').DataTable().column(i).search() !== this.value) {
                $('#tabla_resguardo_comisiones').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_resguardo.rows({selected: true, search: 'applied'}).indexes();
                var data = tabla_resguardo.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_resguardo").textContent = to1;
            }
        });
});

function fillCommissionTableRESGUARDO(proyecto,condominio){
    $('#tabla_resguardo_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("myText_resguardo").textContent = to;
    });

    $("#tabla_resguardo_comisiones").prop("hidden", false);
    tabla_resguardo = $("#tabla_resguardo_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        widt: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES EN RESGUARDO',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orangeYellow">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                return '<p class="m-0"><span class="label lbl-green">RESGUARDO PERSONAL</span></p>';
            }
        },
        {
            "data": function(data) {
                return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_resguardo" data-toggle="tooltip" data-placement="left" title="BITÁCORA DE CAMBIOS">' +'<i class="fas fa-info"></i></button></div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+3,

            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function () {
			$('#spiner-loader').addClass('hide');
		},
    });

    $('#tabla_resguardo_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_resguardo_comisiones tbody").on("click", ".consultar_logs_resguardo", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#spiner-loader').removeClass('hide');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#22CB99; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIO: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
// FIN TABLA RESFUARDO

// INICIO TABLA EN REVISION
$('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
    if(i != 12 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if ($('#tabla_revision_comisiones').DataTable().column(i).search() !== this.value) {
                $('#tabla_revision_comisiones').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_revision.rows({selected: true, search: 'applied'}).indexes();
                var data = tabla_revision.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                document.getElementById("myText_proceso").textContent = formatMoney(total);
            }
        });
    }
});

function fillCommissionTableREVISION(proyecto,condominio){
    $('#tabla_revision_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("myText_proceso").textContent = to;
    });

    $("#tabla_revision_comisiones").prop("hidden", false);
    tabla_revision = $("#tabla_revision_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES EN REVISION',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orangeYellow">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                return '<p class="m-0"><span class="label lbl-sky">REVISIÓN CONTRALORÍA</span></p>';
            }
        },
        {

            "data": function(data) {
                return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_revision" data-toggle="tooltip" data-placement="left" title="BITÁCORA DE CAMBIOS">' +'<i class="fas fa-info"></i></button><div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+4,

            "type": "POST",
            cache: false,
            "data": function(d) {}
        },
        initComplete: function () {
			$('#spiner-loader').addClass('hide');
		},
    });

    $('#tabla_revision_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_revision_comisiones tbody").on("click", ".consultar_logs_revision", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#spiner-loader').removeClass('hide');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#2242CB; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>Nombre del usuario: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>Comentario: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
// FIN TABLA PROCESO

// INICIO TABLA EN PAGADAS
$('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
    if(i != 12 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
             if($('#tabla_pagadas_comisiones').DataTable().column(i).search() !== this.value) {
                $('#tabla_pagadas_comisiones').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_pagadas.rows({selected: true, search: 'applied'}).indexes();
                var data = tabla_pagadas.rows(index).data();
                $.each(data, function(i, v) {total += parseFloat(v.impuesto);});
                var to1 = formatMoney(total);
                document.getElementById("myText_pagadas").textContent = to1;
            }
        });
    }
});

function fillCommissionTablePAGADAS(proyecto,condominio){
    $('#tabla_pagadas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("myText_pagadas").textContent = to;
    });

    $("#tabla_pagadas_comisiones").prop("hidden", false);
    tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES POR PAGAR',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
    
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
            }
        },
        {
            "data": function( d ){
                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orangeYellow">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "orderable": false,
            "data": function(d) {

                return '<p class="m-0"><span class="label lbl-violetBoots">REVISIÓN INTERNOMEX</span></p>';
                
            }
        },
        {
            "data": function(data) {
                return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pagadas" data-toggle="tooltip" data-placement="left" title="BITÁCORA DE CAMBIOS">' +'<i class="fas fa-info"></i></button></div>&nbsp;&nbsp;';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+8,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function(){
            $('#spiner-loader').addClass('hide');
        }
    });

    $('#tabla_pagadas_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_logs_pagadas", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#spiner-loader').removeClass('hide');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#9321B6; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');

        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIO: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
// FIN TABLA PAGADAS

// INICIO TABLA OTRAS
$('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
    if(i != 12 ){
        var title = $(this).text();
        titulos.push(title);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
        $('input', this).on('keyup change', function() {
            if ($('#tabla_otras_comisiones').DataTable().column(i).search() !== this.value) {
                $('#tabla_otras_comisiones').DataTable().column(i).search(this.value).draw();
                var total = 0;
                var index = tabla_otras.rows({selected: true, search: 'applied'}).indexes();
                var data = tabla_otras.rows(index).data();
                $.each(data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });

                var to1 = formatMoney(total);
                document.getElementById("myText_otras").textContent = to1;
            }
        });
    }
});

function fillCommissionTableOTRAS(proyecto,condominio){
    $('#tabla_otras_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("myText_otras").textContent = to;
    });

    $("#tabla_otras_comisiones").prop("hidden", false);
    tabla_otras = $("#tabla_otras_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE DE COMISIONES PAUSADAS POR CONTRALORÍA',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "data": function(d) {
                return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.lote + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0">' + formatMoney(d.pago_cliente) + '</p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + formatMoney(d.impuesto) + '</b></p>';
            }
        },
        {
            "data": function(d) {
                return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
            }
        },
        {
            "data": function( d ){

                var lblPenalizacion = '';

                if (d.penalizacion == 1){
                    lblPenalizacion ='<p class="m-0" title="Penalización + 90 días"><span class="label lbl-orangeYellow">Penalización + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="Lote con bonificación en NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="Lote con cancelación de CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
                }
                else{
                    p2 = '';
                }
                
                return p1 + p2 + lblPenalizacion;
            }
        },
        {
            "orderable": false,
            "data": function(d) {
                return '<p class="m-0"><span class="label lbl-orangeYellow">EN PAUSA</span></p>';
            }
        },
        {
            "data": function(data) {
                return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pausadas" data-toggle="tooltip" data-placement="left" title="BITÁCORA DE CAMBIOS">' +'<i class="fas fa-info"></i></button></div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "Comisiones/getDatosComisionesRigel/"+proyecto+"/"+condominio+"/"+6,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function(){
            $('#spiner-loader').addClass('hide');
        }
    });

    $('#tabla_otras_comisiones').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $("#tabla_otras_comisiones tbody").on("click", ".consultar_logs_pausadas", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#spiner-loader').removeClass('hide');
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#CB7922; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIO: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
// FIN TABLA OTRAS

//INICIO SIN PAGO EN NEODATA
$('#tabla_comisiones_sin_pago thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $('input', this).on('keyup change', function () {
        if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value) {
            $('#tabla_comisiones_sin_pago').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillCommissionTableWithoutPayment (proyecto, condominio) {
    tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function(d) {
                return '<p class="m-0">' + d.idLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreResidencial + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCondominio + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCliente + ' </p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreAsesor + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreCoordinador + '</p>';
            }
        },
        {
            data: function(d) {
                return '<p class="m-0">' + d.nombreGerente + '</p>';
            }
        },
        {
            data: function(d) {
                switch (d.reason) {
                    case '0':
                        return '<p class="m-0"><b>En espera de próximo abono en NEODATA </b></p>';
                    break;
                    case '1':
                        return '<p class="m-0"><b>No hay saldo a favor. Esperar próxima aplicación de pago. </b></p>';
                    break;
                    case '2':
                        return '<p class="m-0"><b>No se encontró esta referencia </b></p>';
                    break;
                    case '3':
                        return '<p class="m-0"><b>No tiene vivienda, si hay referencia </b></p>';
                    break;
                    case '4':
                        return '<p class="m-0"><b>No hay pagos aplicados a esta referencia </b></p>';
                    break;
                    case '5':
                        return '<p class="m-0"><b>Referencia duplicada </b></p>';
                    break;
                    default:
                        return '<p class="m-0"><b>Sin localizar </b></p>';
                    break;
                }
            }
        }],
        columnDefs: [{
            orderable: false,
            targets: 0,
            searchable: false,
            className: 'dt-body-center'
        }],
        ajax: {
            url: general_base_url + "ComisionesNeo/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
            type: "POST",
            cache: false,
            data: function(d) {}
        },
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
};

$(window).resize(function() {
    tabla_nuevas.columns.adjust();
    tabla_revision.columns.adjust();
    tabla_pagadas.columns.adjust();
    tabla_otras.columns.adjust();
});

$(document).on("click", ".subir_factura", function() {
    resear_formulario();
    id_comision = $(this).val();
    total = $(this).attr("data-total");
    link_post = "Comisiones/guardar_solicitud/" + id_comision;
    $("#modal_formulario_solicitud").modal({backdrop: 'static', keyboard: false});
    $("#modal_formulario_solicitud .modal-body #frmnewsol").append(`<div id="inputhidden"><input type="hidden" id="comision_xml" name="comision_xml" value="${ id_comision}">
    <input type="hidden" id="pago_cliente" name="pago_cliente" value="${ parseFloat(total).toFixed(2) }"></div>`);
});

let c = 0;

function saveX() {
    document.getElementById('btng').disabled=true;
    save2();
}

function EnviarDesarrollos() {
    document.getElementById('btn_EnviarM').disabled=true;
    var formData = new FormData(document.getElementById("selectDesa"));
    formData.append("dato", "valor");
    $.ajax({
        url: general_base_url + 'Comisiones/EnviarDesarrollos',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente.", "success");
                document.getElementById('btn_EnviarM').disabled=false;
                location.reload();
                $("#ModalEnviar").modal("hide");
            } else {
                alerts.showNotification("top", "right", "No se ha podido completar la solicitud.", "warning");
            }
        },
        error: function() {
            document.getElementById('btn_EnviarM').disabled=false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}


/** -----------------------------------------*/


function todos(){
    if($(".checkdata1:checked").length == 0){
        $(".checkdata1").prop("checked", true);
        sumCheck();
    }
    else if($(".checkdata1:checked").length < $(".checkdata1").length){
        $(".checkdata1").prop("checked", true);
        sumCheck();
    
    }
    else if($(".checkdata1:checked").length == $(".checkdata1").length){
        $(".checkdata1").prop("checked", false);
        sumCheck();
    }
}


$(document).on("click", ".subir_factura_multiple", function() {  
    var hoy = new Date();
    var dia = hoy.getDate();
    var mes = hoy.getMonth()+1;
    var hora = hoy.getHours();

    if (
                ((mes == 10 && dia == 10) || (mes == 10 && dia == 11 && hora <= 13)) ||
                ((mes == 11 && dia == 7) || (mes == 11 && dia == 8 && hora <= 13)) ||
                ((mes == 12 && dia == 12) || (mes == 12 && dia == 13 && hora <= 13)))
    {
    
            $("#modal_multiples .modal-body").html("");
            $("#modal_multiples .modal-header").html("");
            $("#modal_multiples .modal-header").append(`<div class="row">
            <div class="col-md-12 text-right">
            <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size:40px;">&times;</span>
            </button>
            </div>
            <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);

            $.post('getDesarrolloSelect', function(data) {
                c = 0;
                if(data == 3){
                    $("#desarrolloSelect").append('<option selected="selected" disabled>ESTÁS FUERA DE TIEMPO</option>');
                }
                else{
                    $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
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
                }}, 'json');

        $('#desarrolloSelect').change(function() {
            c=0;

            var valorSeleccionado = $(this).val();
            $("#modal_multiples .modal-body").html("");
            $.getJSON(general_base_url + "Comisiones/getDatosProyecto/" + valorSeleccionado).done(function(data) {
                let sumaComision = 0;
                if (!data) {
                    $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');

                } 
                else {
                    if(data.length > 0){
                        $("#modal_multiples .modal-body").append(`<div class="row">
                        <div class="col-md-1"><input type="checkbox" class="form-control" onclick="todos();" id="btn_all"></div><div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b></div>`);
                    }

                    $.each(data, function(i, v) {
                        c++;
                        abono_asesor = (v.abono_neodata);
                        $("#modal_multiples .modal-body").append('<div class="row">'+
                        '<div class="col-md-1"><input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult' + i + '" name="comisiones_facura_mult"></div><div class="col-md-4"><input id="data1' + i + '" name="data1' + i + '" value="' + v.nombreLote + '" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%"></div><div class="col-md-4"><input type="hidden" id="idpago-' + i + '" name="idpago-' + i + '" value="' + v.id_pago_i + '"><input id="data2' + i + '" name="data2' + i + '" value="' + "" + abono_asesor + '" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%"></div></div>');
                    });

                    $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12 text-left"><b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b></div><div class="col-lg-5"><div class="fileinput fileinput-new text-center" data-provides="fileinput"><div><br><span class="fileinput-new">Selecciona archivo</span><input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml"></div></div></div><div class="col-lg-7"><center><button class="btn btn-warning" type="button" onclick="xml2()" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center></div></div>');
                    $("#modal_multiples .modal-body").append('<p id="cantidadSeleccionada"></p>');
                    $("#modal_multiples .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                    $("#modal_multiples .modal-body").append('<form id="frmnewsol2" method="post">' +
                        '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                        '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                        '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                        '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                        ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"><button type="button" id="btng" onclick="saveX();" disabled class="btn btn-primary btn-block">GUARDAR</button></div><div class="col-md-4"></div><div class="col-md-4"> <button type="button" data-dismiss="modal"  class="btn btn-danger btn-block close_modal_xml">CANCELAR</button></div></div></form>');
                }
            });
        });

        $("#modal_multiples").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    else{
        alert("NO PUEDES SUBIR FACTURAS HASTA EL PRÓXIMO CORTE.");
    }
});

//FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
function resear_formulario() {
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');

    var validator = $("#frmnewsol").validate();
    validator.resetForm();
    $("#frmnewsol div").removeClass("has-error");
}

$("#cargar_xml").click(function() {
    subir_xml($("#xmlfile"));
});

function xml2() {
    subir_xml2($("#xmlfile2"));
}

var justificacion_globla = "";

function subir_xml(input) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;
    data.append("xmlfile", documento_xml);
    resear_formulario();
    $.ajax({
        url: general_base_url + "Comisiones/cargaxml",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function(data) {
            if (data.respuesta[0]) {
                documento_xml = xml;
                var informacion_factura = data.datos_xml;
                cargar_info_xml(informacion_factura);
                $("#solobs").val(justificacion_globla);
            } else {
                input.val('');
                alert(data.respuesta[1]);
            }
        },
        error: function(data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

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
        success: function(data) {
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
        error: function(data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

function closeModalEng(){
    document.getElementById("frmnewsol").reset();
    document.getElementById("xmlfile").value = "";
    document.getElementById("totalxml").innerHTML = '';
    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_formulario_solicitud").modal('toggle');
}

function cargar_info_xml(informacion_factura) {
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    let pago_cliente = $('#pago_cliente').val();
    let pago1 = parseFloat(pago_cliente) + .05;
    let pago2 = parseFloat(pago_cliente ) - .05;
    if (parseFloat(pago1).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= parseFloat(pago2).toFixed(2)) {
        alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
        document.getElementById('btnIndi').disabled = false;
        console.log("Cantidad correcta");
        document.getElementById("totalxml").innerHTML = '';
        disabled();
    } else {
        document.getElementById("totalxml").innerHTML = 'Cantidad incorrecta:'+ cantidadXml;
        let elemento = document.querySelector('#total');
        elemento.setAttribute('color', 'red');
        document.getElementById('btnIndi').disabled = true;
        alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
        console.log("cantidad incorrecta");
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

let pagos = [];
function cargar_info_xml2(informacion_factura) {
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;
        }
    }
    
    var myCommentsList = document.getElementById('cantidadSeleccionada');
    myCommentsList.innerHTML = '';
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    let cantidadXml2 = Number.parseFloat(informacion_factura.total[0]);
    var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
    myCommentsList.setAttribute('style', 'color:green;');
    myCommentsList.innerHTML = 'Cantidad correcta';
    if ((suma + .10).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .10).toFixed(2)) {
        alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
        document.getElementById('btng').disabled = false;
        disabled()
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

function sumCheck(){
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;
        }
    }
    var myCommentsList = document.getElementById('sumacheck');
    myCommentsList.innerHTML = 'Suma seleccionada: ' + formatMoney(suma.toFixed(3));
}

function disabled(){
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
            document.getElementById("comisiones_facura_mult" + index).disabled = true;
            document.getElementById("btn_all").disabled = true;
        }
    }
} 

function save2() {
    var formData = new FormData(document.getElementById("frmnewsol2"));
    formData.append("dato", "valor");
    formData.append("xmlfile", documento_xml);
    formData.append("pagos",pagos);
    $.ajax({
        url: general_base_url + 'Comisiones/guardar_solicitud2',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function(data) {
            document.getElementById('btng').disabled=false;
            if (data.resultado) {
                alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload(null,false);
                tabla_revision.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else if(data.resultado == 3){
                alert("ESTAS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload(null,false);
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");

            }
            else {
                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
            }
        },
        error: function() {
            document.getElementById('btng').disabled=false;
            alert("ERROR EN EL SISTEMA");
        }
    });
}

$("#frmnewsol").submit(function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        var data = new FormData($(form)[0]);
        data.append("xmlfile", documento_xml);
        $.ajax({
            url: general_base_url + link_post,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data) {
                if (data.resultado) {
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_formulario_solicitud").modal('toggle');
                    tabla_nuevas.ajax.reload(null,false);
                } else {
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },
            error: function() {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#frmnewsol2").submit(function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function(form) {
        var data = new FormData($(form)[0]);
        data.append("xmlfile", documento_xml);
        alert(data);
        $.ajax({
            url: general_base_url + link_post,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data) {
                if (data.resultado) {
                    alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                    $("#modal_formulario_solicitud").modal('toggle');
                    tabla_nuevas.ajax.reload(null,false);
                } else {
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },
            error: function() {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function calcularMontoParcialidad() {
    $precioFinal = parseFloat($('#value_pago_cliente').val());
    $precioNuevo = parseFloat($('#new_value_parcial').val());
    if ($precioNuevo >= $precioFinal) {
        $('#label_estado').append('<label>MONTO NO VALIDO</label>');
    } 
    else if ($precioNuevo < $precioFinal) {
        $('#label_estado').append('<label>MONTO VALIDO</label>');
    }
}

function preview_info(archivo) {
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = general_base_url + "dist/documentos/" + archivo + "";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf') {
        elemento += '<iframe src="' + archivo + '" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if (ext == 'jpg' || ext == 'jpeg') {
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="' + archivo + '" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if (ext == 'xlsx') {
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="' + archivo + '"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list-factura');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    myCommentsList.innerHTML = '';
}

$(document).on("click", ".individualCheck", function() {
    var totaPen = 0;
    tabla_nuevas.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_nuevas.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_nuevas.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            totaPen += parseFloat(row.impuesto); 
        }
        // Al marcar todos los CheckBox Marca CB total
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false); // si se desmarca un CB se desmarca CB total

    });
    $("#totpagarPen").html(formatMoney(totaPen));
});

function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            tota2 += parseFloat(row.impuesto);

            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(tota2));
    }

    if(e.checked == false){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}