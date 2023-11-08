$(document).ready(function () {
    numerosDispersion();
    let titulos_intxt = [];
    setIniDatesXMonth("#beginDate", "#endDate");
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    $('#tabla_dispersar_comisiones thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 0 ) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_dispersar_comisiones').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_dispersar_comisiones').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_dispersar_comisiones').DataTable().rows({
                selected: true,
                search: 'applied'
                }).indexes();
                var data = $('#tabla_dispersar_comisiones').DataTable().rows(index).data();
            });
        }
    });

    dispersionDataTable = $('#tabla_dispersar_comisiones').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Comisiones Dispersión',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
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
        columns: [
            {
            className: 'details-control',
            orderable: false,
            data : null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
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
                    return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span>`;
            }},
            // { data: function (d) {
            //     var labelCompartida;
            //     if(d.compartida == null) {
            //         labelCompartida ='<span class="label lbl-yellow">Individual</span>';
            //     } else{
            //         labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
            //     }
            //     return labelCompartida;
            // }},
            { data: function (d) {
                var labelStatus;
                // if(d.idStatusContratacion == 15) {
                //     labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
                // }else {
                    labelStatus ='<p class="m-0"><b>'+d.idStatusOOAM+'</b></p>';
                // }
                return labelStatus;
            }},
            { data: function (d) {
                var labelEstatus;
                // if(d.penalizacion == 1 && (d.bandera_penalizacion == 0 || d.bandera_penalizacion == 1) ){
                //     labelEstatus =`<p class="m-0"><b>Penalización ${d.dias_atraso} días</b></p><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
                // }
                // else{
                    if(d.totalNeto2 == null) {
                        labelEstatus ='<p class="m-0"><b>Sin Precio Lote</b></p>';
                    }else if(d.registro_comision == 2){
                        labelEstatus ='<span class="label lbl-cerulean">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
                    }else {
                        if(d.plan_descripcion=="-")
                            return '<p>SIN PLAN</p>';
                        else
                            labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span></label>`;
                    }
                // }
                return labelEstatus;
            }},
            // { data: function (d) {
            //     var rescisionLote;
            //     var reactivo;
            //     rescisionLote = '';
            //     reactivo = '';
            //     if (d.registro_comision == 8){
            //         rescisionLote = '<br><span class="label lbl-warning">Recisión Nueva Venta</span>';
            //     }
            //     if(d.id_cliente_reubicacion_2 != 0 ) {
            //         if((d.bandera_dispersion == 1 && d.registro_comision == 9) ||
            //         (d.bandera_dispersion == 2 && d.registro_comision == 9) ||
            //         (d.bandera_dispersion == 2  && d.registro_comision != 9) ||
            //         (d.bandera_dispersion == 1  && d.registro_comision != 9 && validarLiquidadas == 0 || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0))){
            //             reactivo = '<br><span class="label lbl-gray">DISPERSIÓN VENTAS</span>';
            //         } else if((d.bandera_dispersion == 3  && d.registro_comision == 9) ||
            //         (d.bandera_dispersion == 3 && d.registro_comision != 9) ||
            //         ((d.registro_comision == 1 && d.validaLiquidadas == 1 && (d.banderaOOAM == 0 || d.banderaOOAM > 0 )) || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM > 0))){//LIQUIDADA 1°
            //             reactivo = '<br><span class="label lbl-lightBlue">DISPERSIÓN EEC</span>';
            //         } 
            //     }
            //     return rescisionLote+reactivo;
            // }},
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

                var Mensaje = 'Verificar en NEODATA';
                varColor2  = 'btn-gray';
                var RegresaActiva = '';

                // if(d.fecha_sistema != null && d.registro_comision != 8 && d.registro_comision != 0) {
                //     RegresaActiva = '<button href="#" data-idpagoc="' + d.idLote + '" data-nombreLote="' + d.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" data-toggle="tooltip" data-placement="top" title="Enviar a activas">' +'<i class="fas fa-undo-alt"></i></button>';
                // }

                 
                    if(d.totalNeto2==null || d.totalNeto2==''|| d.totalNeto2==0) {
                        BtnStats = 'Asignar Precio';
                    }else if(d.tipo_venta==null || d.tipo_venta==0) {
                        BtnStats = 'Asignar Tipo Venta';
                    } else{
                        if(d.compartida==null) {
                            varColor  = 'btn-sky';
                        } else{
                            varColor  = 'btn-green';
                        }

                        disparador = 0;

                        
                        if(d.bandera == 0 && d.numero_dispersion == 0){//VENTA NORMAL 1°
                            disparador = 1;
                            totalLote = d.totalNeto2;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 0;
                            //console.log(d.idLote+" //VENTA NORMAL 1°");

                        } else {// NORMAL 2°
                            disparador = 2;
                            totalLote = d.totalNeto2;
                            reubicadas = 0;
                            nombreLote = d.nombreLote;
                            id_cliente = d.id_cliente;
                            plan_comision = d.plan_comision;
                            descripcion_plan = d.plan_descripcion;
                            ooamDispersion = 0;
                            // console.log(d.idLote+" //NORMAL 2°");
                        } 

                        

                         
                        // || (d.validarLiquidadas == 1 && d.registro_comision == 1)
                        if(disparador != 0){
                            BtnStats += `<button href="#" 
                            value = "${d.idLote}" 
                            data-totalNeto2 = "${totalLote}" 
                            data-reubicadas = "${reubicadas}" 
                            data-nombreLote = "${nombreLote}" 
                            data-banderaPenalizacion = "${d.bandera_penalizacion}" 
                            data-cliente = "${id_cliente}" 
                            data-plan = "${plan_comision}" 
                            data-disparador = "${disparador}" 
                            data-tipov = "${d.tipo_venta}"
                            data-descplan = "${descripcion_plan}" 
                            data-ooam = "${ooamDispersion}" 
                            data-code = "${d.cbbtton}" 
                            class = "btn-data ${varColor} verify_neodata" data-toggle="tooltip" data-placement="top" title="${ Mensaje }"><span class="material-icons">verified_user</span></button> ${RegresaActiva}`;
                            
                            // BtnStats += `<button href="#" value="${d.idLote}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas btn-detener btn-warning" data-toggle="tooltip"  data-placement="top" title="Detener"> <i class="material-icons">block</i> </button>`;
                        }else{
                            BtnStats += ``;
                        
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
            url: 'getDataDispersionOOAM',
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    })

    $('#tabla_dispersar_comisiones tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_comisiones').DataTable().row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><label><b>Director: </b>` + row.data().director + `</label></div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><label><b>Gerente: </b>` + row.data().gerente + `</label></div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><label><b>Coordinador: </b>` + row.data().coordinador + `</label></div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3"><label><b>Asesor: </b>` + row.data().asesor + `</label></div>
            </div></div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-detener', function () {
        $("#motivo").val("");
        $("#motivo").selectpicker('refresh');
        $("#descripcion").val("");
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const statusLote = $(this).attr("data-statusLote");
     
        $('#id-lote-detenido').val(idLote);
        $('#statusLote').val(statusLote);
        $('#anterior').val(0);

        $("#detenciones-modal .modal-header").html("");
                
        $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            if(data.length > 0){
                $('#saldoNeodata').val(data[0].Aplicado);
                $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Enviar a controversia: <b>'+nombreLote+'</b></h4>');

            } else{
                $('#saldoNeodata').val(0);
                $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Sin localizar en NEODATA  <b>'+nombreLote+'</b>, el lote se enviará a controversia sin embargo hay que regresarlo manualmente ya que no detectamos saldo ligado a este lote y es indispensable para regresarlo automáticamente. </h4>');
            }     
        }); 

        $("#detenciones-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-penalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_penalizacion').val(idLote);
        $('#id_cliente_penalizacion').val(idCliente);
        $("#penalizacion-modal .modal-header").html("");
        $("#penalizacion-modal .modal-header").append('<h4 class="modal-title"> Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes correspondientes.</P>');
        $("#penalizacion-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-penalizacion4', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id-lote-penalizacion4').val(idLote);
        $('#id-cliente-penalizacion4').val(idCliente);
        $("#penalizacion4-modal .modal-header").html("");
        $("#penalizacion4-modal .modal-header").append('<h4 class="modal-title">Penalización + 160 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes asignados.</P>');
        $("#penalizacion4-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on('click', '.btn-Nopenalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_cancelar').val(idLote);
        $('#id_cliente_cancelar').val(idCliente);
        $("#Nopenalizacion-modal .modal-header").html("");
        $("#Nopenalizacion-modal .modal-header").append('<h4 class="modal-title"> Cancelar Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al cancelar esta penalización no se podrán revertir los cambios.</P>');
        $("#Nopenalizacion-modal").modal();
    });

    $("#tabla_dispersar_comisiones tbody").on("click", ".verify_neodata", async function(){
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_comisiones').DataTable().row(tr);
        let cadena = '';

        idLote = $(this).val();
        totalNeto2 = $(this).attr("data-totalNeto2");
        reubicadas = $(this).attr("data-reubicadas");
        // penalizacion = $(this).attr("data-penalizacion");
        nombreLote = $(this).attr("data-nombreLote");
        bandera_penalizacion = $(this).attr("data-banderaPenalizacion");
        idCliente = $(this).attr("data-cliente");
        plan_comision = $(this).attr("data-plan");
        disparador = $(this).attr("data-disparador");
        tipo_venta = $(this).attr("data-tipov");
        descripcion_plan = $(this).attr("data-descplan");
        ooamDispersion = $(this).attr("data-ooam");
        

        if(parseFloat(totalNeto2) > 0){
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                if(data.length > 0){
                    switch (data[0].Marca) {
                        case 0:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                        break;
                        case 1:
                                $.getJSON( general_base_url + "Ooam/getDatosAbonadoSuma11/"+idLote+"/"+ooamDispersion).done( function( data1 ){
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
                                    // if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">Lote con Penalización + 90 días</b>';}
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${row.data().nombreLote}</i>: <b>${formatMoney(total0-(data1[0].abonado))}</b><br>${labelPenalizacion}</h3></div></div><br>`);
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div><div class="col-md-4">Total abonado: <b style="color:green">${formatMoney(data1[0].abonado)}</b></div><div class="col-md-4">Total pendiente: <b style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div></div>`);

                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                                    }else{
                                        cadena = '<h4>Bonificación: <b >'+formatMoney(0)+'</b></h4>';
                                    }
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: ${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                    <div class="col-md-4"><h4>Aplicado neodata: <b>${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                    </div><br>`);

                                    $.getJSON( general_base_url + "Ooam/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                        $("#modal_NEODATA .modal-body").append(`
                                                        <div class="row">
                                                            <div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div>
                                                            <div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div>
                                                            <div class="col-md-2"><b><b>ABONADO</b></div>
                                                            <div class="col-md-2"><b>PENDIENTE</b></div>
                                                            <div class="col-md-2"><b>DISPONIBLE</b></div>
                                                        </div>`);
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

                                            $("#modal_NEODATA .modal-body").append(`<div class="row">
                                            <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="${disparador}"><input type="hidden" name="nombreLote" id="nombreLote" value="${nombreLote}"><input type="hidden" name="idCliente" id="idCliente" value="${idCliente}"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                            <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                            <input id="id_comision" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.rol_generado}">
                                            <input class="form-control input-gral" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                            <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>
                                            <div class="col-md-1"><input class="form-control input-gral" required readonly="true" style="padding: 10px; ${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}"></div>
                                            <div class="col-md-2"><input class="form-control input-gral" required style="${pending < 0 ? 'color:red' : ''}" readonly="true" value="${formatMoney(pending)}"></div>
                                            <div class="col-md-2"><input id="abono_nuevo${counts}" onkeyup="nuevo_abono(${counts});" class="form-control input-gral abono_nuevo" readonly="true"  name="abono_nuevo[]" value="${saldo}" type="hidden">
                                            <input class="form-control input-gral decimals"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo)}"></div></div>`);
                                            counts++
                                        });
                                    });
                                    $("#modal_NEODATA .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersar" value="Dispersar"></div>');

                                    if(total < 1 ){
                                        $('#dispersar').prop('disabled', true);
                                    }
                                    else{
                                        $('#dispersar').prop('disabled', false);
                                    }
                                });
                            // }
                        break;
                        case 2:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 3:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 4:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        case 5:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                        default:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento: .</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    }
                }
                else{
                    //QUERY SIN RESULTADOS
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            }); //FIN getStatusNeodata

            $("#modal_NEODATA").modal();
        }
    }); //FIN VERIFY_NEODATA
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
            url: general_base_url + 'Ooam/InsertNeo',
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
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, REVISAR CON SISTEMAS", "warning");
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
        $.post(general_base_url + "Ooam/getMontoDispersadoDates",{
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
    $.post(general_base_url + "/Ooam/lotes", function (data) {
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