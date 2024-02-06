var tapActual=1;
var totalPen = 0;
let idTablaGlobal = '';
const  datosTablas = [
    {
        id:"tabla_nuevas_comisiones",
        estatus:1,
    },
    {
        id:"tabla_resguardo_comisiones",
        estatus:3,
    },
    {
        id:"tabla_revision_comisiones",
        estatus: 4,
    },
    {
        id:"tabla_pagadas_comisiones",
        estatus: 8,
    }
];
//cambiarTaps(1);
let titulos = [];
var fechaInicioCorteGlobal;
var fechaFinCorteGlobal;
var horaFinCorteGlobal;
var datosProyectos = [];
var datosCondominios = [];
var datosFechaCorte = [];
$(document).ready(function() {
    $.post(general_base_url + "Comisiones/getDatosFechasProyecCondm",{tipoUsuario:tipoUsuarioGeneral}, function (data) {
        data = JSON.parse(data);
        datosFechaCorte = data.fechasCorte;
        //[0]año [1]mes [2]dia
        fechaInicioCorteGlobal = datosFechaCorte[0].fechaInicio.split(' ')[0].split('-');
        fechaFinCorteGlobal = datosFechaCorte[0].fechaFin.split(' ')[0].split('-');
        //[0] hora [1] minutos [2] segundos
        horaFinCorteGlobal = datosFechaCorte[0].fechaFin.split(' ')[1].split(':');
        datosProyectos = data.proyectos;
        datosCondominios = data.condominios;
        var lenProyectos = data.proyectos.length;
        for (var i = 0; i < lenProyectos; i++) {
            var id = datosProyectos[i]['idResidencial'];
            var name = datosProyectos[i]['descripcion'];
            $(`.selectpicker.proyecto`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $(`.selectpicker.proyecto`).selectpicker('refresh');
    });
});


function getPagosEstatus(idTabla,idProyecto,idCondominio,estatus){
    $('#spiner-loader').removeClass('hide');
    //console.log(datosFechaCorte)
    $.post(general_base_url + "Comisiones/getDatosComisionesRigel",{idProyecto:idProyecto,idCondominio:idCondominio,estatus:estatus}, function (data) {
        data = JSON.parse(data);
       // let pagosNuevos = data.filter(pagos => pagos.estatus == 1);
        crearTabla(idTabla,data,estatus);
    });
    $('#spiner-loader').addClass('hide');
}

for (let m = 0; m < datosTablas.length; m++) {
    $(`#${datosTablas[m].id} thead tr:eq(0) th`).each( function (i) {
        if(i != 0){
            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function() {
                if ($(`#${datosTablas[m].id}`).DataTable().column(i).search() !== this.value) {
                    $(`#${datosTablas[m].id}`).DataTable().column(i).search(this.value).draw();
                    var total = 0;
                    var index = $(`#${datosTablas[m].id}`).rows({ selected: true, search: 'applied'}).indexes();
                    var data = $(`#${datosTablas[m].id}`).rows(index).data();
                    $.each(data, function(i, v) {
                        total += parseFloat(v.impuesto);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("total_disponible").textContent = to1;
                }
            });
        }
        else {
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
        }
    });    
}

function crearTabla(idTabla,data2,estatus){
    $(`#${idTabla}`).prop("hidden", false);
    $(`#${idTabla}`).on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(total);
        document.getElementById("total_disponible").textContent = to;
    });
    $(`#${idTabla}`).prop("hidden", false);
    tabla_nuevas = $(`#${idTabla}`).DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100",
        scrollX: true,
        buttons: estatus != 1 ? [] : [{
                text: '<i class="fas fa-paper-plane"></i>SOLICITAR PAGO',
                action: function() {
                    var hoy = new Date();
                    var dia = hoy.getDate();
                    var mes = hoy.getMonth()+1;
                    var hora = hoy.getHours();
                    if([1,2].includes(datosFechaCorte[0].tipoCorte) && ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                                ||  (mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2] && hora <= horaFinCorteGlobal[0])) //VALIDACION VENTAS NORMAL
                        || (id_usuario_general == 7689)
                        ) {
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
                                        $("#total_solicitar").html(formatMoney(0));
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
                var hora = hoy.getHours();

                //PARA RESGUARDO SIEMPRE SON LOS DOS DIAS SIGUIENTES AL CORTE NORMAL DE COMISIONES
                if([3].includes(datosFechaCorte[0].tipoCorte) && ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                         ||  (mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2] && hora <= horaFinCorteGlobal[0]))
                )
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
                                    $("#total_solicitar").html(formatMoney(0));
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
        "data":data2,
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
                    lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 días"><span class="label lbl-orangeYellow">PENALIZACIÓN + 90 días</span></p>';
                }

                if(d.bonificacion >= 1){
                    p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="label lbl-pink">Bon. '+formatMoney(d.bonificacion)+'</span></p>';
                }
                else{
                    p1 = '';
                }

                if(d.lugar_prospeccion == 0){
                    p2 = '<p class="m-0" title="LOTE CON CANCELACIÓN DE CONTRATO"><span class="label lbl-warning">Recisión</span></p>';
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
                    case '1': 
                    case 1:
                        return `<p class="m-0"><span class="label lbl-gray">SIN DEFINIR FORMA DE PAGO</span><br><span class="label lbl-yellow">REVISAR CON RH  ${d.estatus_actual}</span></p>`;
                    break;

                    case '2': 
                    case 2: 
                        return `<p class="m-0"><span class="label lbl-sky">FACTURA</span></p><p style="font-size: .5em"><span class="label lbl-melon" >SUBIR XML  ${d.estatus_actual}</span></p>`;
                    break;

                    case '3':
                    case 3: 
                        return `<p class="m-0"><span class="label lbl-blueMaderas">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR  ${d.estatus_actual}</span></p>`;
                    break;

                    case '4': 
                    case 4:
                        return `<p class="m-0"><span class="label lbl-violetBoots">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR  ${d.estatus_actual}</span></p>`;
                    break;

                    default:
                        return `<p class="m-0"><span class="label lbl-gray">DOCUMENTACIÓN FALTANTE</span><br><span class="label lbl-yellow">REVISAR CON RH  ${d.estatus_actual}</span></p>`;
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
            visible: estatus == 1 ? true : false, 
            searchable: false,
            className: 'dt-body-center',
            render: function(d, type, full, meta) {
                console.log(full);
                var hoy = new Date();
                var dia = hoy.getDate();
                var mes = hoy.getMonth()+1;
                var hora = hoy.getHours();
                if(     ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                                ||  (mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2] && hora <= horaFinCorteGlobal[0])) //VALIDACION VENTAS NORMAL
                        || (id_usuario_general == 7689)
                        ) {
                    switch (full.forma_pago) {
                        case 1: 
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                        break;
                        case 2:
                        case 3: 
                        case 4: 
                        default:
                            return `<input type="checkbox" name="idT[]" id="${full.id_pago_i}" class="individualCheck" style="width:20px;height:20px;" value="${full.id_pago_i}">`;
                        break;
                    }
                } 
                else {
                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                }
            },
        }],
        initComplete: function () {
			$('#spiner-loader').addClass('hide');
		},
    });

    $(`#${idTabla}`).on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    $(`#${idTabla}`).on('click', 'input', function () {
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
            if($(`#${row.id_pago_i}`).is(':checked')){
                tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                row.pa = row.impuesto;
                totalPen += parseFloat(row.pa);
            }else{
                totalPen -= parseFloat(row.impuesto);
                row.pa = 0;
            }
        $("#total_solicitar").html(formatMoney(totalPen));
    });
    $(document).off("click", ".consultar_logs_nuevas").on("click", ".consultar_logs_nuevas", function () {
        id_pago = $(this).val();
        user = $(this).attr("data-usuario");
        $('#spiner-loader').removeClass('hide');
        modalHistorial();
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>NOMBRE DEL USUARIO: </small><b>'+ v.nombre_usuario +' </b></a><br></div><div class="float-end text-right"><a> '+ v.fecha_movimiento +' </a></div><div class="col-md-12"><p class="m-0"><small>COMENTARIO: </small><b>'+ v.comentario+'</b></p></div><h6></h6></div></div></li>');
            });
            $('#spiner-loader').addClass('hide');
        });
    });
}
function modalHistorial(){
    changeSizeModal('modal-md');
        appendBodyModal(`<div class="modal-header">
            <h5><b>BITÁCORA DE CAMBIOS</b></h5>
        </div>
        <div class="modal-body">
            <div role="tabpanel">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="historialTap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" ><b>Cerrar</b></button>
    </div>`);
    showModal();
}
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
        $("#total_solicitar").html(formatMoney(tota2));
    }
    if(e.checked == false){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#total_solicitar").html(formatMoney(0));
    }
}