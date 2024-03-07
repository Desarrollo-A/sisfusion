$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).attr("data-idpagoc");
    nombreLote = $(this).attr("data-nombreLote");
    param = $(this).attr("data-param");

    $("#myUpdateBanderaModal .modal-body").html('');

    $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param"><h4 class="modal-title">¿Está seguro de regresar el lote <b>'+nombreLote+'</b> a comisiones por dispersar?</h4><center><img src="../static/images/backaw2.gif" width="100" height="100"></center>');

    $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#nombreLote").val(nombreLote);
    $("#param").val(0);
});

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
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                $("#param").val("");
                alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                tabla_1.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$("#tabla_ingresar_9").ready(function () {
    let titulos = [];

    $('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value) {
                    tabla_1.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_1 = $("#tabla_ingresar_9").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES ACTIVAS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9,10,11],
                format: {
                    header: function (d, columnIdx) {
                        if (columnIdx == 0) {
                            return ' ' + d + ' ';
                        } else if (columnIdx == 10) {
                            return ' ' + d + ' ';
                        } else if (columnIdx != 10 && columnIdx != 0) {
                            if (columnIdx == 12) {
                                return 'SEDE ';
                            }
                            if (columnIdx == 12) {
                                return 'TIPO'
                            } else {
                                return ' ' + titulos[columnIdx - 1] + ' ';
                            }
                        }
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns:   

        [{
        "width": "2%",
        "className": 'details-control',
        "orderable": false,
        "data" : null,
        "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
    },
    {
        "width": "5%",
        "data": function( d ){
            var lblStats;
            lblStats ='<p class="m-0"><b>'+d.idLote+'</b></p>';
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            return '<p class="m-0">'+d.nombreResidencial+'</p>';
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
        }
    },
    {
        "width": "12%",
        "data": function( d ){
            return '<p class="m-0">'+d.nombreLote+'</p>';
        }
    }, 
    {
        "width": "12%",
        "data": function( d ){
            return '<p class="m-0"><b>'+d.nombre_cliente+'</b></p>';
        }
    }, 
    {
        "width": "7%",
        "data": function( d ){
            var lblType;
            if(d.tipo_venta==1) {
                lblType ='<span class="label label-danger">Venta Particular</span>';
            }else if(d.tipo_venta==2) {
                lblType ='<span class="label label-success">Venta normal</span>';
            }
            else if(d.tipo_venta==7) {
                lblType ='<span class="label label-warning">Venta especial</span>';
            }
            return lblType;
        }
    }, 
    {
        "width": "7%",
        "data": function( d ){
            var lblStats;
            if(d.compartida==null) {
                lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
            }else {
                lblStats ='<span class="label label-warning">Compartida</span>';
            }
            return lblStats;
        }
    }, 
    {
        "width": "7%",
        "data": function( d ){
            var lblStats;
            if(d.idStatusContratacion==15) {
                lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';
            }else {
                lblStats ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
            }
            return lblStats;
        }
    },

    {
        "width": "8%",
        "data": function( d ){
            var lblStats;
            if(d.totalNeto2==null) {
                lblStats ='<span class="label label-danger">Sin precio lote</span>';
            }else{
                lblStats = d.plan_descripcion;
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            var lblStats;

            if(d.fecha_modificacion == null ) {
                lblStats ='';
            
                lblStats ='<span class="label label-gray" style="color:gray;">Sin especificar</span>';
            
            }else{

                lblStats ='<span class="label label-info">'+d.date_final +'</span>';
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "data": function( d ){
            var lblStats;

            if(d.fecha_modificacion <= '2021-01-01' || d.fecha_modificacion == null ) {
                lblStats ='';
            }else if (d.registro_comision == 8){
                lblStats ='<span class="label label-gray" style="color:gray;">Recisión Nueva Venta</span>';
            }
            else {
                lblStats ='<span class="label label-info">'+d.date_final+'</span>';
            }
            return lblStats;
        }
    },
    {
        "width": "8%",
        "orderable": false,
        "data": function( data ){
            var BtnStats = '' ;
            var RegresaActiva = '';
            
            if(data.totalNeto2==null || data.totalNeto2==''|| data.totalNeto2==0) {
                BtnStats = 'Asignar Precio';
            }else if((data.id_prospecto==null || data.id_prospecto==''|| data.id_prospecto==0)&&data.lugar_prospeccion == 6) {
                BtnStats = 'Asignar Prospecto';
            }else if(data.id_subdirector==null || data.id_subdirector==''|| data.id_subdirector==0) {
                BtnStats = 'Asignar Subdirector';
            }else if(data.id_sede==null || data.id_sede==''|| data.id_sede==0) {
                BtnStats = 'Asignar Sede';
            }else if(data.plan_comision==null || data.plan_comision==''|| data.plan_comision==0) {
                BtnStats = 'Asignar Plan';
            } else{
                if(data.compartida==null) {
                    varColor  = 'btn-deepGray';
                } else{
                    varColor  = 'btn-deepGray';
                }
                
                if(data.fecha_modificacion != null ) {
                    RegresaActiva = '<button href="#" data-param="1" data-idpagoc="' + data.idLote + '" data-nombreLote="' + data.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" title="Regresar a dispersión ">' +'<i class="fas fa-undo-alt"></i></button>';
                }

                BtnStats += `
                        <button href="#"
                            value="${data.idLote}"
                            data-value="${data.nombreLote}"
                            class="btn-data btn-blueMaderas btn-detener btn-warning"
                            title="Detener">
                            <i class="material-icons">block</i>
                        </button>
                    `;
                BtnStats += '<button href="#" value="'+data.idLote+'" data-value="'+data.registro_comision+'" data-totalNeto2 = "'+data.totalNeto2+'" data-estatus="'+data.idStatusContratacion+'" data-cliente="'+data.id_cliente+'" data-plan="'+data.plan_comision+'"  data-tipov="'+data.tipo_venta+'"data-descplan="'+data.plan_descripcion+'" data-code="'+data.cbbtton+'" ' +'class="btn-data '+varColor+' verify_neodata" title="Verificar en NEODATA">'+'<span class="material-icons">verified_user</span></button> '+RegresaActiva+'';
            }
            return '<div class="d-flex justify-center">'+BtnStats+'</div>';
        }
                          
    } 

    ],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": url+'/Comisiones/getActiveCommissions',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function (d) {
            }
        },
    });

    $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_1.row(tr);
    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
    } 
    else {

        var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Director: </b>` + row.data().director + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Regional: </b>` + row.data().regional + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Subdirector: </b>` + row.data().subdirector + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div><div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
        </div></div>`;

        row.child(informacion_adicional).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
    }
});

    $("#tabla_ingresar_9 tbody").on("click", ".marcar_pagada", function(){
        var tr = $(this).closest('tr');
        var row = tabla_1.row( tr );
        idLote = $(this).val();

        $("#modal_pagadas .modal-body").html("");
        $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Ya se pago completa la comision para el lote <b>'+row.data().nombreLote+'</b>?</h4>');
        $("#modal_pagadas .modal-body").append('<input type="hidden" name="ideLotep" id="ideLotep" value="'+idLote+'"><input type="hidden" name="estatusL" id="estatusL" value="7">');
        $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_pagadas").modal();
    });

    $("#tabla_ingresar_9 tbody").on('click', '.btn-detener', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        $('#id-lote-detenido').val(idLote);

        $("#detenciones-modal .modal-header").html("");
        $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Motivo de controversia para <b>'+nombreLote+'</b></h4>');

        $("#detenciones-modal").modal();
    });

     


    $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", async function(){ 

    $("#modal_NEODATA .modal-header").html("");
    $("#modal_NEODATA .modal-body").html("");
    $("#modal_NEODATA .modal-footer").html("");
    var tr = $(this).closest('tr');
    var row = tabla_1.row( tr );
    
    let cadena = '';
    idLote = $(this).val();
    registro_comision = $(this).attr("data-value");
    totalNeto2 = $(this).attr("data-totalNeto2");
    id_estatus = $(this).attr("data-estatus");
    idCliente = $(this).attr("data-cliente");
    plan_comision = $(this).attr("data-plan");
    descripcion_plan = $(this).attr("data-descplan");

    tipo_venta = $(this).attr("data-tipov");

    if(parseFloat(totalNeto2) > 0){
   
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
               
                if(data.length > 0){
                    switch (data[0].Marca) {
                        case 0:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                        break;
                        case 1:
                            console.log('case 1 ');
                            // else{
                                $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                                    let total0 = parseFloat((data[0].Aplicado));
                                    let total = 0;
                                    if(total0 > 0){
                                        total = total0;
                                    }
                                    else{
                                        total = 0; 
                                    }

                                    var counts=0;

                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-(data1[0].abonado))+'</b></h3></div></div><br>');

                                    $("#modal_NEODATA .modal-body").append('<div class="row">'+
                                    '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                                    '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                                    '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                                    }else{
                                        cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';
                                    }
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: $${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                    <div class="col-md-4"><h4>Aplicado neodata: <b>$${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                    </div><br>`);
                                    
                                    $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');
                                        let contador=0;
                                        console.log('gree:'+data.length);
                                        let coor = data.length;
                                        for (let index = 0; index < data.length; index++) {
                                            const element = data[index].id_usuario;
                                            if(data[index].id_usuario == 5855){
                                                contador +=1;
                                            }
                                        }

                                        $.each( data, function( i, v){
                                            saldo =0;
                                            if(tipo_venta == 7 && coor == 2){
                                                total = total - data1[0].abonado;
                                                console.log(total);

                                                saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.925*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : ((12.5 *(v.porcentaje_decimal / 100)) * total);

                                            }
                                            else if(tipo_venta == 7 && coor == 3){
                                                total = total - data1[0].abonado;
                                                console.log(total);
                                                saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.675*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : tipo_venta == 7 && v.rol_generado == "9" ?  (0.25*total) :   ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                            }
                                            else{
                                                saldo =  ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                            }

                                            if(parseFloat(v.abono_pagado) > 0){
                                                console.log("OPCION 1");
                                                console.log(v.colaborador);
                                                evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                                if(parseFloat(evaluar) < 0){
                                                   // pending = 0;
                                                   pending=evaluar;
                                                    saldo = 0;
                                                }
                                                else{
                                                    pending = evaluar;
                                                }
                                                console.log('EVALUAR: '+evaluar);
                                                console.log('PENDDING: '+pending);

                                                resta_1 = saldo-v.abono_pagado;
                                                
                                                console.log('resta_1: '+resta_1);

                                                if(parseFloat(resta_1) <= 0){
                                                    saldo = 0;
                                                }
                                                else if(parseFloat(resta_1) > 0){
                                                    if(parseFloat(resta_1) > parseFloat(pending)){
                                                        saldo = pending;
                                                    }
                                                    else{
                                                        saldo = saldo-v.abono_pagado;
                                                    }
                                                }

                                                console.log(saldo);
                                            }  
                                            else if(v.abono_pagado <= 0){
                                                console.log("OPCION 2");
                                                pending = (v.comision_total);
                                                if(saldo > pending){
                                                    saldo = pending;
                                                }
                                                if(pending < 0){
                                                    saldo = 0;
                                                }
                                            }
                                            console.log('SALDO'+saldo);

                                            if( (parseFloat(saldo) + parseFloat(v.abono_pagado)) > parseFloat(v.comision_total)){
                                                    saldo = 0;
                                                }
                                            $("#modal_NEODATA .modal-body").append(`<div class="row">
                                            <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                            <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                            <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="rol" type="hidden" name="rol[]" value="${v.id_usuario}">
                                            <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                            <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>
                                            <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}%"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}"></div>
                                            <div class="col-md-2"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control ng-invalid ng-invalid-required abono_nuevo" readonly="true"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                            <input class="form-control ng-invalid ng-invalid-required decimals"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo)}"></div></div>`);
                                            counts++
                                        });
                                    });
                                    
                                });
                            
                        break;
                        case 2:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 3:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 4:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 5:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        default:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento: .</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    }
                }
                else{
                    console.log("QUERY SIN RESULTADOS");
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            }); //FIN getStatusNeodata
            
            $("#modal_NEODATA").modal();
        }

}); //FIN VERIFY_NEODATA

    //INICIO COMPARTIDA
    $("#tabla_ingresar_9 tbody").on("click", ".verify_neodataCompartida", function () {
        var tr = $(this).closest('tr');
        var row = tabla_1.row(tr);
        idLote = $(this).val();
        registro_status = $(this).attr("data-value");

        $("#modal_NEODATA2 .modal-header").html("");
        $("#modal_NEODATA2 .modal-body").html("");
        $("#modal_NEODATA2 .modal-footer").html("");

        $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {
            if (data.length > 0) {
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 1:
                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                        
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                                total = total0;
                            }
                            else{
                                total = 0; 
                            }

                            var counts=0;
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div>');
                            if(parseFloat(data[0].Bonificado) > 0){
                                cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                            }
                            else{
                                cadena = '<h4>Bonificación: <b >$'+formatMoney(0)+'</b></h4>';
                            }

                            $("#modal_NEODATA2 .modal-header").append('<div class="row">'+
                            '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                            '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                            '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-6"><h4>Aplicado neodata: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div><div class="col-md-6">'+cadena+'</div></div>');
                        
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-(data1[0].abonado))+'</b></h3></div></div><br>');

                            $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');
                                let contador=0;

                                for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 5855){
                                        contador +=1;
                                    }
                                }

                                $.each( data, function( i, v){
                                    saldo =0; 
                                    saldo = ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                    
                                    if(v.abono_pagado>0){
                                        evaluar = (v.comision_total-v.abono_pagado);
                                        if(evaluar<1){
                                            pending = 0;
                                            saldo = 0;
                                        }
                                        else{
                                            pending = evaluar;
                                        }
                                
                                        resta_1 = saldo-v.abono_pagado;
                                        if(resta_1<1){
                                            saldo = 0;
                                        }
                                        else if(resta_1 >= 1){
                                            if(resta_1 > pending){
                                            saldo = pending;
                                            }
                                            else{
                                                saldo = saldo-v.abono_pagado;
                                            }
                                        }
                                    }
                                    else if(v.abono_pagado<=0){
                                        pending = (v.comision_total);

                                        if(saldo > pending){
                                            saldo = pending;
                                        }
                                        
                                        if(pending < 1){
                                            saldo = 0;
                                        }
                                    }

                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">
                                    <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                    <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                    <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="rol" type="hidden" name="rol[]" value="${v.id_usuario}">
                                    <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == "1" ? 'color:red;' : ''}"><b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''} ">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>

                                    <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${v.porcentaje_decimal}%"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" style="${v.descuento == 1 ? 'color:red;' : ''}" required readonly="true" value="${formatMoney(v.abono_pagado)}"></div>
                                    <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${formatMoney(pending)}"></div>
                                    <div class="col-md-2"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                    <input class="form-control ng-invalid ng-invalid-required decimals"  data-old="" id="inputEdit"  value="${formatMoney(saldo)}"></div></div>`);
                                    
                                    counts++
                                });
                            });
                    
                        });        
                    break;
                    case 2:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 3:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 4:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 5:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');

                    break;
                }
            } 
            else {
                $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
        });

        $("#modal_NEODATA2").modal();
    });
});

$('#detenidos-form').on('submit', function (e) {
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
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                tabla_1.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).ready(function () {
    $('#detenidos-form').validate({
        rules: {
            motivo: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            descripcion: {
                required: true
            }
        },
        messages: {
            motivo: {
                required: 'El motivo es requerido.',
                minlength: 'El motivo debe contener 3 o más caracteres.',
                maxlength: 'El motivo debe contener 120 caracteres o menos.'
            },
            descripcion: {
                required: 'La descripción es requerida.'
            }
        }
    });
});

$('#detenciones-modal').on('hidden.bs.modal', function() {
    $('#detenidos-form').trigger('reset');
});

$("#form_NEODATA").submit(function (e) {
    e.preventDefault();
}).validate({
    submitHandler: function (form) {
        var data = new FormData($(form)[0]);
        $.ajax({
            url: url + 'Comisiones/InsertNeo',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data == 1) {
                    alert("Dispersión guardada con exito.");
                    tabla_1.ajax.reload();
                    $("#modal_NEODATA").modal('hide');

                } else {
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            }, error: function () {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_pagadas").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/liquidar_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if(true){
                    $('#loader').addClass('hidden');
                    $("#modal_pagadas").modal('toggle');
                    tabla_1.ajax.reload();
                    alert("¡Se agregó con éxito!");
                }
                else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    $('#loader').addClass('hidden');
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_NEODATA2").submit(function (e) {
    e.preventDefault();
}).validate({
    submitHandler: function (form) {
        var data = new FormData($(form)[0]);
        $.ajax({
            url: url + 'Comisiones/InsertNeoCompartida',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (data == 1) {
                    tabla_1.ajax.reload();
                    alert("Dispersión guardada con exito.");
                    $("#modal_NEODATA2").modal('hide');
                } else {
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            }, error: function () {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function closeModalEng() {
    $("#modal_enganche").modal('toggle');
}

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}