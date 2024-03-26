$(document).ready(function () {
    $('#tabla_comisiones_liquidadas').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    let titulos_intxt = [];
    $('#tabla_comisiones_liquidadas thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 0 ) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_comisiones_liquidadas').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_comisiones_liquidadas').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_comisiones_liquidadas').DataTable().rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
            });
        }
    });
    
    liquidadasDataTable = $('#tabla_comisiones_liquidadas').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Reporte Comisiones Liquidadas',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
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
        columns: [
            {
            "className": 'details-control',
            "orderable": false,
            "data" : null,
            "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            { data: function (d) {
                if(d.id_cliente_reubicacion_2 >1 ) {
                    nombreLote =  d.nombreLoteReub;
                } else{
                    nombreLote = d.nombreLote;
                }
                return nombreLote;
            }},
            {data: 'idLote'},
            {data: 'nombreCliente'},
            { data: function (d) {
                    return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span><br><span class="${d.colorProcesoCl}">${d.procesoCl}</span>`;
            }},
            { data: function (d) {
                var labelCompartida;
                if(d.compartida == null) {
                    labelCompartida ='<span class="label lbl-yellow">Individual</span>';
                } else{
                    labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
                }
                return labelCompartida;
            }},
            { data: function (d) {
                var labelStatus;
                if(d.idStatusContratacion == 15) {
                    labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
                }else {
                    labelStatus ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
                }
                return labelStatus;
            }},
            { data: function (d) {
                var labelEstatus;
                if(d.penalizacion == 1 && (d.bandera_penalizacion == 0 || d.bandera_penalizacion == 1) ){
                    labelEstatus =`<p class="m-0"><b>Penalización ${d.dias_atraso} días</b></p><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
                }
                else{
                    if(d.totalNeto2 == null && d.proceso == 0){
                        labelEstatus ='<p class="m-0"><b>Sin Precio Lote</b></p>';
                    }else if(d.registro_comision == 2){
                        labelEstatus ='<span class="label lbl-cerulean">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
                    }else {
                        if(d.plan_descripcion=="-")
                            return '<p>SIN PLAN</p>';
                        else
                            labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span></label>`;
                    }
                }
                return labelEstatus;
            }},
            { data: function (d) {
                // PRECIO TOTAL
                return formatMoney(d.Precio_Total);
            }},
            { data: function (d) {
                // PORCENTAJE
                return d.porcentaje_comisiones ? `${parseFloat(d.porcentaje_comisiones).toFixed(2)}%`: 'SIN ESPECIFICAR';
            }},
            { data: function (d) {
                // importe comision PAGADA
                return formatMoney(d.abono_comisiones);
            }},
            
            { data: function (d) {
                // iMPORTE DE COMISION PENDIENTE
                return formatMoney(d.pendiente);
            }},
            { data: function (d) {
                var rescisionLote;
                var reactivo;
                rescisionLote = '';
                reactivo = '';
                if (d.registro_comision == 8){
                    rescisionLote = '<br><span class="label lbl-warning">Recisión Nueva Venta</span>';
                }
                if(d.id_cliente_reubicacion_2 != 0 ) {
                    if((d.bandera_dispersion == 1 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2  && d.registro_comision != 9) ||
                    (d.bandera_dispersion == 1  && d.registro_comision != 9 && validarLiquidadas == 0 || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0))){
                        reactivo = '<br><span class="label lbl-gray">DISPERSIÓN VENTAS</span>';
                    } else if((d.bandera_dispersion == 3  && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 3 && d.registro_comision != 9) ||
                    ((d.registro_comision == 1 && d.validaLiquidadas == 1 && (d.banderaOOAM == 0 || d.banderaOOAM > 0 )) || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM > 0))){//LIQUIDADA 1°
                        reactivo = '<br><span class="label lbl-lightBlue">DISPERSIÓN EEC</span>';
                    } 
                }
                return rescisionLote+reactivo;
            }},
            { data: function (d) {
                var fechaActualizacion;

                if(d.fecha_sistema == null) {
                    fechaActualizacion ='<span class="label lbl-gray">Sin Definir</span>';
                }else {
                    fechaActualizacion = '<span class="label lbl-azure">'+d.fecha_sistema+'</span>';
                }
                
                return fechaActualizacion;
            }},
            { data: function (d) {
                var BtnStats = '';
                if((d.totalNeto2==null || d.totalNeto2==''|| d.totalNeto2==0) && d.proceso == 0) {
                        BtnStats = 'Asignar Precio';
                    }else if(d.tipo_venta==null || d.tipo_venta==0) {
                        BtnStats = 'Asignar Tipo Venta';
                    }else if((d.id_prospecto==null || d.id_prospecto==''|| d.id_prospecto==0) && d.lugar_prospeccion == 6) {
                        BtnStats = 'Asignar Prospecto';
                    }else if(d.id_subdirector==null || d.id_subdirector==''|| d.id_subdirector==0) {
                        BtnStats = 'Asignar Subdirector';
                    }else if(d.id_sede==null || d.id_sede==''|| d.id_sede==0) {
                        BtnStats = 'Asignar Sede';
                    }else if(d.plan_comision==null || d.plan_comision==''|| d.plan_comision==0) {
                        BtnStats = 'Asignar Plan <br> Sede: '+d.sede;
                    } else{
                        varColor  = 'btn-deepGray';
                            BtnStats += ``;

                            if(d.ooam == 0 && d.ventas == 1){
                                BtnStats += '<button href="#" value="'+d.idLote+'" data-ooam="2" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data btn-yellow verify_neodata" title="VERIFICAR EN NEODATA VENTAS">'+'<span class="material-icons">verified_user</span></button> ';

                            } else if(d.ooam == 1 && d.ventas == 0){
                                BtnStats += '<button href="#" value="'+d.idLote+'" data-ooam="1" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data btn-azure verify_neodata" title="VERIFICAR EN NEODATA OOAM">'+'<span class="material-icons">verified_user</span></button> ';

                            } else if(d.ooam == 1 && d.ventas == 1){
                                BtnStats += '<button href="#" value="'+d.idLote+'" data-ooam="2" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data btn-yellow verify_neodata" title="VERIFICAR EN NEODATA VENTAS">'+'<span class="material-icons">verified_user</span></button>';

                                BtnStats += '<button href="#" value="'+d.idLote+'" data-ooam="1" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data btn-azure verify_neodata" title="VERIFICAR EN NEODATA OOAM">'+'<span class="material-icons">verified_user</span></button> ';

                            } else{
                            
                            BtnStats += '<button href="#" value="'+d.idLote+'" data-ooam="0" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data '+varColor+' verify_neodata" title="VERIFICAR EN NEODATA">'+'<span class="material-icons">verified_user</span></button> ';
                        }
                        }
                        return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }} 
 
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getDataLiquidadasPago',
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    }) 

    $('#tabla_comisiones_liquidadas tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#tabla_comisiones_liquidadas').DataTable().row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Director: </b>` + row.data().director + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Regional: </b>` + row.data().regional + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Subdirector: </b>` + row.data().subdirector + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
            </div></div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });


    $("#tabla_comisiones_liquidadas tbody").on("click", ".verify_neodata", async function(){ 
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        var tr = $(this).closest('tr');
        var row = $('#tabla_comisiones_liquidadas').DataTable().row(tr);
        let cadena = '';
        idLote = $(this).val();
        registro_comision = $(this).attr("data-value");
        penalizacion = $(this).attr("data-penalizacion");
        nombreLote = $(this).attr("data-nombreLote");
        totalNeto2 = $(this).attr("data-totalNeto2");
        id_estatus = $(this).attr("data-estatus");
        idCliente = $(this).attr("data-cliente");
        plan_comision = $(this).attr("data-plan");
        descripcion_plan = $(this).attr("data-descplan");
        tipo_venta = $(this).attr("data-tipov");

        ooamDispersion = $(this).attr("data-ooam");


        bandera_penalizacion = $(this).attr("data-banderaPenalizacion");
        if(parseFloat(totalNeto2) > 0){
            $("#modal_NEODATA .modal-body").html("");
            $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                if(data.length > 0){
                    switch (data[0].Marca) {
                        case 0:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div></div>');
                        break;
                        case 1:
                            let total0 = parseFloat(data[0].Aplicado);
                            let total = 0;
                            if(total0 > 0){
                                total = total0;
                            }else{
                                total = 0; 
                            }
                            var_sum = 0;
                            $.getJSON( general_base_url + "Comisiones/getDatosAbonadoSuma11/"+idLote+"/"+ooamDispersion).done( function( data1 ){
                                let total0 = parseFloat((data[0].Aplicado));
                                let total = 0;
                                if(total0 > 0){
                                    total = total0;
                                }
                                else{
                                    total = 0; 
                                }
                                var counts=0;
                                let labelPenalizacion = '';
                                if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">Lote con Penalización + 90 días</b>';}
                                $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${row.data().nombreLote}</i>: <b>${formatMoney(total0-(data1[0].abonado))}</b><br>${labelPenalizacion}</h3></div></div><br>`);
                                $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div><div class="col-md-4">Total abonado: <b style="color:green">${formatMoney(data1[0].abonado)}</b></div><div class="col-md-4">Total pendiente: <b  style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div></div>`);
                                if(parseFloat(data[0].Bonificado) > 0){
                                    cadena = `<h4>Bonificación: <b style="color:#D84B16;">${formatMoney(data[0].Bonificado)}</b></h4>`;
                                }else{
                                    cadena = `<h4>Bonificación: <b>${formatMoney(0)}</b></h4>`;
                                } 
                                $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio del lote: ${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                <div class="col-md-4"><h4>Aplicado neodata: <b>${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                </div>`);
                                $.getJSON( general_base_url + "Comisiones/getDatosAbonadoDispersion/"+idLote+"/0"+"/"+data1[0].estructura).done( function( data ){
                                    $("#modal_NEODATA .modal-body").append('<div class="row rowTitulos"><div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOTAL DE LA COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');
                                    let contador=0;
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
                                            saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.925*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                        }
                                        else if(tipo_venta == 7 && coor == 3){
                                            total = total - data1[0].abonado;
                                            saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.675*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : tipo_venta == 7 && v.rol_generado == "9" ?  (0.25*total) :   ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                        }
                                        else{
                                            saldo =  ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                        }
                                        if(parseFloat(v.abono_pagado) > 0){
                                            evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                            if(parseFloat(evaluar) < 0){
                                                pending=evaluar;
                                                saldo = 0;
                                            }
                                            else{
                                                pending = evaluar;
                                            }
                                            resta_1 = saldo-v.abono_pagado;
                                            
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
                                        }  
                                        else if(v.abono_pagado <= 0){
                                            pending = (v.comision_total);
                                            if(saldo > pending){
                                                saldo = pending;
                                            }
                                            if(pending < 0){
                                                saldo = 0;
                                            }
                                        }
                                        if( (parseFloat(saldo) + parseFloat(v.abono_pagado)) > (parseFloat(v.comision_total)+0.5 )){
                                            //ENTRA AQUI AL CERO
                                            saldo = 0;
                                        }
                                        $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-3 ">
                                                <label class="control-label labelNombre hide">USUARIO</label>
                                                <input class="form-control input-gral" required readonly="true" value="${v.colaborador}" style=" font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                                <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b>
                                            </div>
                                            <div class="col-md-1">
                                                <label class="control-label labelPorcentaje hide">%</label>
                                                <input class="form-control input-gral" required readonly="true" style="padding:10px ${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="control-label labelTC hide">Total de la comisión</label>
                                                <input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}">
                                            </div>
                                            <div class="col-md-2">
                                                <label id="" class="control-label labelAbonado hide">Abonado</label>
                                                <input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}">
                                            </div>
                                            <div class="col-md-2">
                                                <label id="" class="control-label labelPendiente hide">Pendiente</label>
                                                <input class="form-control input-gral" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}">
                                            </div>
                                            <div class="col-md-2">
                                                <label id="" class="control-label labelDisponible hide">Disponible</label>
                                                <input class="form-control input-gral decimals"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo)}">
                                            </div>
                                        </div>`);
                                        counts++
                                    });
                                    responsive(maxWidth);
                                });
                            });
                        break;
                        case 2:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                        break;
                        case 3:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                        break;
                        case 4:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                        break;
                        case 5:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                        break;
                        default:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                        break;
                        }
                }  
                else{
                    //QUERY SIN RESULTADOS
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12 d-flex justify-center"><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></div> </div>');
                }
            }); //FIN getStatusNeodata
            
            $("#modal_NEODATA").modal();
        }
    }); //FIN VERIFY_NEODATA
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

function showDetailModal(idPlan) {
    cleanElement('detalle-tabla-div');
    $('#spiner-loader').removeClass('hide');
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
            alerts.showNotification("top", "right", "No hay datos por mostrar.", "warning");
            $('#spiner-loader').addClass('hide');
        }        
    });
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
var maxWidth = window.matchMedia("(max-width: 992px)");
responsive(maxWidth);
maxWidth.addListener(responsive);

