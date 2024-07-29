var totalPen = 0, fechaInicioCorteGlobal, fechaFinCorteGlobal, horaFinCorteGlobal;
let idTablaGlobal = '';
const  datosTablas = [
    {
        id:"tabla_nuevas_comisiones",
        estatus:1,
        idSelect:'proyectosNueva',
        idSelectCond:'condominioNuevas',
        idTitle : 'total_disponible'
    },
    {
        id:"tabla_resguardo_comisiones",
        estatus:3,
        idSelect:'catalogo_resguardo',
        idSelectCond:'condominio_resguardo',
        idTitle : 'myText_resguardo'
    },
    {
        id:"tabla_revision_comisiones",
        estatus: 4,
        idSelect:'catalogo_revision',
        idSelectCond:'condominio_revision',
        idTitle : 'total_solicitado'
    },
    {
        id:"tabla_pagadas_comisiones",
        estatus: 8,
        idSelect:'catalogo_pagar',
        idSelectCond:'condominio_pagar',
        idTitle : 'total_pagar'
    },
    {
        id:"tabla_otras_comisiones",
        estatus: 6,
        idSelect:'catalogo_otras',
        idSelectCond:'condominio_otras',
        idTitle : 'total_otras'
    },
    {
        id:"tabla_comisiones_sin_pago",
        estatus: 0,
        idSelect:'proyecto_sp',
        idSelectCond:'condominio_sp',
        idTitle : 'total_sin_pago'
    }
];
let titulos = [];
var datosProyectos = [], datosCondominios = [], datosFechaCorte = [], datosSumaPagos = [], datosOpinion = [];
$(document).ready(function() {
    $('#spiner-loader').removeClass('hide');
    $.post(general_base_url + "Casas_comisiones/getDatosFechasProyecCondm",{tipoUsuario:tipoUsuarioGeneral}, function (data) {
        data = JSON.parse(data);
        datosFechaCorte = data.fechasCorte;
        datosSumaPagos = data.sumaPagos;
        console.log(datosSumaPagos);

        datosOpinion = data.opinion;
        //[0]año [1]mes [2]dia
        fechaInicioCorteGlobal = datosFechaCorte[0].fechaInicio.split(' ')[0].split('-');
        fechaFinCorteGlobal = datosFechaCorte[0].fechaFin.split(' ')[0].split('-');
        //[0] hora [1] minutos [2] segundos
        horaFinCorteGlobal = datosFechaCorte[0].fechaFin.split(' ')[1].split(':');
        llenarSumas();
        datosProyectos = data.proyectos;
        datosCondominios = data.condominios;
        var lenProyectos = data.proyectos.length;
        for (var i = 0; i < lenProyectos; i++) {
            var id = datosProyectos[i]['idResidencial'];
            var name = datosProyectos[i]['descripcion'];
            $(`.selectpicker.proyecto`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $(`.selectpicker.proyecto`).selectpicker('refresh');
        if(forma_pago == 2)
        document.getElementById('opinion').innerHTML = 
            datosOpinion.length == 0 
            ? `<a href="${general_base_url}Usuarios/configureProfile"> <span class="label label-danger" style="background:red;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA </span> </a>`    
            : ([1,2].includes(datosOpinion[0].estatus) 
                ? `<button type="button" class="btn btn-info subir_factura_multiple" >SUBIR FACTURAS</button>` 
                :  `<a href="${general_base_url}Usuarios/configureProfile"> <span class="label label-danger" style="background:orange;">  SIN OPINIÓN DE CUMPLIMIENTO, CLIC AQUI PARA SUBIRLA</span> </a>` );
        if(forma_pago == 3)
        document.getElementById('leyendaImpts').innerHTML = `<p style="color:#0a548b;" id="leyendaImpts">
            <i class="fa fa-info-circle" aria-hidden="true"></i> 
            Recuerda que el <b>impuesto estatal</b> sobre tu pago de comisiones es de 
            <b>${datosSumaPagos[0].impuesto}%</b> (PARA USUARIOS ASIMILADOS) y el impuesto varia segun el Estado en que te encuentres laborando.`; 
    });
    $('#spiner-loader').addClass('hide');
});
function llenarSumas(){
    //FUNCIÓN PARA MOSTRAR SALDOS EN CADA TAPS
    
    (datosSumaPagos[0].nuevas == undefined) || (datosSumaPagos[0].nuevas == null) ? document.getElementById('sumPagosNuevas').innerHTML = formatMoney(0) :document.getElementById('sumPagosNuevas').innerHTML = formatMoney(datosSumaPagos[0].nuevas);
    (datosSumaPagos[0].resguardo == undefined) || (datosSumaPagos[0].resguardo == null)? document.getElementById('sumPagosResguardo').innerHTML = formatMoney(0) :document.getElementById('sumPagosResguardo').innerHTML = formatMoney(datosSumaPagos[0].resguardo);
    (datosSumaPagos[0].revision == undefined) || (datosSumaPagos[0].revision == null) ? document.getElementById('sumPagosRevision').innerHTML = formatMoney(0) :document.getElementById('sumPagosRevision').innerHTML = formatMoney(datosSumaPagos[0].revision);
    (datosSumaPagos[0].internomex == undefined) || (datosSumaPagos[0].internomex == null) ? document.getElementById('sumPagosIntmex').innerHTML = formatMoney(0) :document.getElementById('sumPagosIntmex').innerHTML = formatMoney(datosSumaPagos[0].internomex);
    (datosSumaPagos[0].pausadas == undefined) || (datosSumaPagos[0].pausadas == null) ? document.getElementById('sumPagosPausadas').innerHTML = formatMoney(0) :document.getElementById('sumPagosPausadas').innerHTML = formatMoney(datosSumaPagos[0].pausadas);
    
}

function getPagosComisiones(idProyecto,idCondominio,estatus){
    console.log(estatus);

    var datosRespuesta = [];
    $.ajax({
        type: 'POST',
        url: general_base_url + "Casas_comisiones/getDatosComisionesRigel",
        data: {idProyecto:idProyecto,idCondominio:idCondominio,estatus:estatus},
        
        success: function(result) {

            datosRespuesta = JSON.parse(result);
        },
        async:   false
        });
        return datosRespuesta;
}

function getPagosEstatus(idTabla,idProyecto,idCondominio,estatus){
    // console.log(idProyecto);
    // console.log(idCondominio);
    // console.log(estatus);
    $('#spiner-loader').removeClass('hide');
    const data = getPagosComisiones(idProyecto,idCondominio,estatus);
    crearTabla(idTabla,data,estatus);
    $('#spiner-loader').addClass('hide');
}

for (let m = 0; m < datosTablas.length; m++) {
    if(datosTablas[m].estatus != 0)
    $(`#${datosTablas[m].id} thead tr:eq(0) th`).each( function (i) {
        if(i != 0){
            var title = $(this).text();
            titulos.push(title);
            $(this).html(`<input data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function() {

                if ($(`#${datosTablas[m].id}`).DataTable().column(i).search() !== this.value) {
                    $(`#${datosTablas[m].id}`).DataTable().column(i).search(this.value).draw();
                    var total = 0;
                        var index = $(`#${datosTablas[m].id}`).DataTable().rows({ selected: true, search: 'applied'}).indexes();
                        var data = $(`#${datosTablas[m].id}`).DataTable().rows(index).data();

                    $.each(data, function(i, v) {
                        // console.log(v)
                        total += parseFloat(v.impuesto);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById(`${datosTablas[m].idTitle}`).textContent = to1;
                }

            });
        }
        else {
            $(this).html('<input id="all" type="checkbox" style="width:20px; height:20px;" onchange="selectAll(this)"/>');
        }
    });    
}



async function crearTabla(idTabla,data2,estatus){
    // console.log(idTabla)
    console.log(data2);
    // console.log(estatus);
    let datosTbActual = datosTablas.filter(datos => datos.estatus == estatus);
    // console.log(datosTbActual);
    // console.log(datosTbActual[0].id)
    let idProyecto = $(`#${datosTbActual[0].idSelect}`).val() == '' ? 0 : $(`#${datosTbActual[0].idSelect}`).val() ,idCondominio = $(`#${datosTbActual[0].idSelectCond}`).val() == '' ? 0 : $(`#${datosTbActual[0].idSelectCond}`).val();  
    // console.log(idSelect);
    $(`#${idTabla}`).prop("hidden", false);

   $(`#${idTabla}`).DataTable({
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
                    if([1,2,3].includes(datosFechaCorte[0].corteOoam) && ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                                ||  (mes == fechaFinCorteGlobal[1] && dia == fechaFinCorteGlobal[2] && hora <= horaFinCorteGlobal[0])) //VALIDACION VENTAS NORMAL
                        || (id_usuario_general == 7689)
                        ){
                        if ($('input[name="idT[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 
                            $.ajax({
                                url : general_base_url + 'Casas_comisiones/acepto_comisiones_user/',
                                data: com2,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST', 
                                success: function(data){
                                    data = JSON.parse(data);
                                    if(data.respuesta === 1) {
                                        $('#spiner-loader').addClass('hide');
                                        $("#total_solicitar").html(formatMoney(0));
                                        $("#all").prop('checked', false);
                                        datosSumaPagos = data.data;
                                        llenarSumas();
                                        let datosPagos = getPagosComisiones(idProyecto,idCondominio,1);
                                        crearTabla(datosTbActual[0].id,datosPagos,estatus);
                                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Contraloría.", "success");
                                       


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
                        console.log(datosFechaCorte);

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
                if([3].includes(datosFechaCorte[0].corteOoam) && ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                         ||  (mes == fechaFinCorteGlobal[1] && dia == fechaFinCorteGlobal[2] && hora <= horaFinCorteGlobal[0]))
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
                            url : general_base_url + 'Casas_comisiones/acepto_comisiones_resguardo/',
                            data: com2,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST', 
                            success: function(data){
                                data = JSON.parse(data);
                                if(data.respuesta === 1) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#total_solicitar").html(formatMoney(0));
                                    $("#all").prop('checked', false);
                                    datosSumaPagos = data.data;
                                    llenarSumas();
                                    let datosPagos = getPagosComisiones(idProyecto,idCondominio,1);
                                    console.log(datosPagos);
                                        crearTabla(datosTbActual[0].id,datosPagos,estatus);
                                    alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a Resguardo.", "success");

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
                // revisar el uso de las siguientes dos lineas
                        // let td = d.estatus == 1 ? `<br><span class="label ${d.forma_pago.split('/')[2]}">${d.forma_pago.split('/')[3]}  ${d.estatus_actual}</span></p>` : ``;
                        // return `<p class="m-0"><span class="label ${d.forma_pago.split('/')[0]}">${d.forma_pago.split('/')[1]}</span>` + td;

                        // switch (d.forma_pago) {
                        //     case '1': 
                        //     case 1:
                        //         return `<p class="m-0"><span class="label lbl-gray">SIN DEFINIR FORMA DE PAGO</span><br><span class="label lbl-yellow">REVISAR CON RH  ${d.estatus_actual}</span></p>`;
                        //     break;
        
                        //     case '2': 
                        //     case 2: 
                        //         return `<p class="m-0"><span class="label lbl-sky">FACTURA</span></p><p style="font-size: .5em"><span class="label lbl-melon" >SUBIR XML  ${d.estatus_actual}</span></p>`;
                        //     break;
        
                        //     case '3':
                        //     case 3: 
                        //         return `<p class="m-0"><span class="label lbl-blueMaderas">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR  ${d.estatus_actual}</span></p>`;
                        //     break;
        
                        //     case '4': 
                        //     case 4:
                        //         return `<p class="m-0"><span class="label lbl-violetBoots">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label lbl-oceanGreen">LISTA PARA APROBAR  ${d.estatus_actual}</span></p>`;
                        //     break;
        
                        //     default:
                        //         return `<p class="m-0"><span class="label lbl-gray">DOCUMENTACIÓN FALTANTE</span><br><span class="label lbl-yellow">REVISAR CON RH  ${d.estatus_actual}</span></p>`;
                        //     break;
                        // }

                        let valores = d.texto.split('/');
                        var color = valores[0];
                        var texto = valores[1];
                        
                     return `<p class="m-0"><span class="label lbl-${d.color}">${d.pj_name}</span><br><span class="label lbl-${color}">${texto}  ${d.estatus_actual}</span></p>`;

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
                var hoy = new Date();
                var dia = hoy.getDate();
                var mes = hoy.getMonth()+1;
                var hora = hoy.getHours();
                if(     ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
                                ||  (mes == fechaFinCorteGlobal[1] && dia == fechaFinCorteGlobal[2] && hora <= horaFinCorteGlobal[0])) //VALIDACION VENTAS NORMAL
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
			//$('#spiner-loader').addClass('hide'); 
            if(estatus == 1){
                tabla_nuevas = $(`#${idTabla}`).DataTable(); 
            }else if(estatus == 4){
                tabla_revision = $(`#${idTabla}`).DataTable();
            }else if(estatus == 3){
                tabla_resguardo = $(`#${idTabla}`).DataTable();
            }else if(estatus == 8){
                tabla_intmex = $(`#${idTabla}`).DataTable();
            }else if(estatus == 6){
                tabla_pausadas = $(`#${idTabla}`).DataTable();
            }           
            $(`#${idTabla}`).on('xhr.dt', function (e, settings, json, xhr) {
                alert()
                var total = 0;
                $.each(json, function (i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById(`${datosTbActual[0].idTitle}`).textContent = to;
            });
		},fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) { 
            
        },
    });

    $(`#${idTabla}`).on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
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

    $(`#${idTabla}`).on('click', 'input', function () { //PAGOS SELECCIONADOS
        tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr).data();
        // console.log(row)
            if($(`#${row.id_pago_i}`).is(':checked')){
                tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                totalPen += parseFloat(row.impuesto);
            }else{
                totalPen -= parseFloat(row.impuesto);
            }
        $(`#total_solicitar`).html(formatMoney(totalPen));
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
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false);

    });
    $("#total_solicitar").html(formatMoney(totaPen));
});
function saveX() {
    document.getElementById('btng').disabled=true;
    guardar2();
}
function guardar2() {
    var formData = new FormData(document.getElementById("frmnewsol2"));
    formData.append("dato", "valor");
    formData.append("xmlfile", documento_xml);
    formData.append("pagos",pagos);
    $.ajax({
        url: general_base_url + 'Casas_comisiones/guardar_solicitud2',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST',
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
    alert();
    var hoy = new Date();
    var dia = hoy.getDate();
    var mes = hoy.getMonth()+1;
    var hora = hoy.getHours();    
        if( ((mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2])  
            ||  (mes == fechaInicioCorteGlobal[1] && dia == fechaInicioCorteGlobal[2] && hora <= horaFinCorteGlobal[0])) //VALIDACION VENTAS NORMAL
            || (id_usuario_general == 7689)
            ) {
            $("#modal_multiples .modal-body").html("");
            $("#modal_multiples .modal-header").html("");
            $("#modal_multiples .modal-header").append(`<div class="row"><div class="col-md-12 text-right"><button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size:40px;">&times;</span></button></div><div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);
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
            $.getJSON(general_base_url + "Casas_comisiones/getDatosProyecto/" + valorSeleccionado).done(function(data) {
                let sumaComision = 0;

                if (!data) {
                    $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>')
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