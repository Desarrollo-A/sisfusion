$(document).ready(function () {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    });

    let titulos_intxt = [];
    $('#tabla_dispersar_especiales thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 0 ) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_dispersar_especiales').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_dispersar_especiales').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_dispersar_especiales').DataTable().rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = $('#tabla_dispersar_especiales').DataTable().rows(index).data();
        });
    }});

    especialesDataTable = $('#tabla_dispersar_especiales').dataTable({
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
                title: 'Reporte Comisiones Especiales',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    format: {
                        header:  function (d, columnIdx) {
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
            className: 'details-control',
            orderable: false,
            data : null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'idLote'},
            {data: 'nombreCliente'},
            { data: function (d) {
                var labelTipoVenta;
                if(d.tipo_venta == 1) {
                    labelTipoVenta ='<span class="label lbl-warning">Particular</span>';
                }else if(d.tipo_venta == 2) {
                    labelTipoVenta ='<span class="label lbl-green">Normal</span>';
                }else if(d.tipo_venta == 7) {
                    labelTipoVenta ='<span class="label lbl-violetBoots">Especial</span>';
                }else{
                    labelTipoVenta ='<span class="label lbl-gray">Sin Definir</span>';
                }
                return labelTipoVenta;
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
                if(d.totalNeto2 == null) {
                    labelEstatus ='<p class="m-0"><b>Sin Precio Lote</b></p>';
                }else if(d.registro_comision == 2){
                    labelEstatus ='<span class="label" style="background:#11DFC6;">SOLICITADO MKT</span>'+' '+d.plan_descripcion;
                }else {
                    if(d.plan_descripcion=="-")
                        return '<p>SIN PLAN</p>'
                    else
                        labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span></label>`;
                }
                return labelEstatus;
            }},
            { data: function (d) {
                var fechaNeodata;
                var rescisionLote;
                fechaNeodata = '<br><span class="label lbl-cerulean">'+d.fecha_neodata+'</span>';
                rescisionLote = '';
                if(d.fecha_neodata <= '01 JAN 21' || d.fecha_neodata == null ) {
                    fechaNeodata = '<span class="label lbl-gray">Sin Definir</span>';
                }
                if (d.registro_comision == 8){
                    rescisionLote = '<br><span class="label lbl-warning">Recisión Nueva Venta</span>';
                }
                return fechaNeodata+rescisionLote;
            }},
            { data: function (d) {
                var BtnStats = '';
                var RegresaActiva = '';
                if(d.totalNeto2==null) {
                    BtnStats = '';
                }else {
                    varColor  = 'btn-sky';
                    if(d.fecha_modificacion != null ) {
                        RegresaActiva = '<button href="#" data-param="1" data-idpagoc="' + d.idLote + '" data-nombreLote="' + d.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" title="Enviar a activas">' +'<i class="fas fa-undo-alt"></i></button>';
                    }
                    BtnStats += `
                            <button href="#"
                                value="${d.idLote}"
                                data-value="${d.nombreLote}"
                                class="btn-data btn-blueMaderas btn-detener btn-warning"
                                title="Detener">
                                <i class="material-icons">block</i>
                            </button>
                        `;
                    BtnStats += '<button href="#" value="'+d.idLote+'" data-value="'+d.registro_comision+'" data-totalNeto2 = "'+d.totalNeto2+'" data-estatus="'+d.idStatusContratacion+'" data-cliente="'+d.id_cliente+'" data-plan="'+d.plan_comision+'"  data-tipov="'+d.tipo_venta+'"data-descplan="'+d.plan_descripcion+'" data-code="'+d.cbbtton+'" ' +'class="btn-data '+varColor+' verify_neodata" title="Verificar en NEODATA">'+'<span class="material-icons">verified_user</span></button> '+RegresaActiva+'';
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getDataDispersionPagoEspecial',
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    })

    $('#tabla_dispersar_especiales tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_especiales').DataTable().row(tr);
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

    $("#tabla_dispersar_especiales tbody").on('click', '.btn-detener', function () {
        $("#motivo").val("");
        $("#motivo").selectpicker('refresh');
        $("#descripcion").val("");
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const statusLote = $(this).attr("data-statusLote");
        $('#id-lote-detenido').val(idLote);
        $('#statusLote').val(statusLote);
        $("#detenciones-modal .modal-header").html("");
        $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Enviar a controversia: <b>'+nombreLote+'</b></h4>');
        $("#detenciones-modal").modal();
    });

    $("#tabla_dispersar_especiales tbody").on('click', '.btn-penalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_penalizacion').val(idLote);
        $('#id_cliente_penalizacion').val(idCliente);
        $("#penalizacion-modal .modal-header").html("");
        $("#penalizacion-modal .modal-header").append('<h4 class="modal-title"> Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes correspondientes.</P>');
        $("#penalizacion-modal").modal();
    });

    $("#tabla_dispersar_especiales tbody").on('click', '.btn-penalizacion4', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id-lote-penalizacion4').val(idLote);
        $('#id-cliente-penalizacion4').val(idCliente);
        $("#penalizacion4-modal .modal-header").html("");
        $("#penalizacion4-modal .modal-header").append('<h4 class="modal-title">Penalización + 160 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al aprobar esta penalización no se podrán revertir los descuentos y se dispersara el pago de comisiones con los porcentajes asignados.</P>');
        $("#penalizacion4-modal").modal();
    });

    $("#tabla_dispersar_especiales tbody").on('click', '.btn-Nopenalizacion', function () {
        const idLote = $(this).val();
        const nombreLote = $(this).attr("data-value");
        const idCliente = $(this).attr("data-cliente");
        $('#id_lote_cancelar').val(idLote);
        $('#id_cliente_cancelar').val(idCliente);
        $("#Nopenalizacion-modal .modal-header").html("");
        $("#Nopenalizacion-modal .modal-header").append('<h4 class="modal-title"> Cancelar Penalización + 90 días, al lote <b>'+nombreLote+'</b></h4><BR><P>Al cancelar esta penalización no se podrán revertir los cambios.</P>');
        $("#Nopenalizacion-modal").modal();
    });

    $("#tabla_dispersar_especiales tbody").on("click", ".verify_neodata", async function(){
        subdirector = $(this).attr("data-subdirector");
        if(subdirector == 0){
            alerts.showNotification("top", "right", "SIN SUBDIRECTOR ASIGNADO, FAVOR DE REVISARLO CON SISTEMAS VIA TICKET INDICANDO LOS DATOS DEL USUARIO FALTANTE (NOMBRE Y EL ID)", "warning");
        }else{
            // $('#spiner-loader').removeClass('hide');
            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            var tr = $(this).closest('tr');
            var row = $('#tabla_dispersar_especiales').DataTable().row(tr);
            idLote = $(this).val();
            let cadena = '';
            registro_status = $(this).attr("data-value");
            compartida = $(this).attr("data-compartida");
            id_estatus = $(this).attr("data-estatus");
            tipo_venta = $(this).attr("data-tipov");
            lugar_prospeccionLote = $(this).attr("data-lugarP");
            totalNeto2 = $(this).attr("data-totalNeto2");
            let idCliente = $(this).attr("data-idCliente");
            ismktd = $(this).attr("data-ismktd");
            let martha = $(this).attr("data-mdb");
            var bandera_anticipo = 0;
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
                                if(registro_status == 0 || registro_status ==8 || registro_status == 2){
                                    //COMISION NUEVA
                                    let total0 = parseFloat(data[0].Aplicado);
                                    let total = 0;
                                    if(total0 > 0){
                                        total = total0;
                                    }else{
                                        total = 0;
                                    }
                                    // INICIO BONIFICACION
                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = '<h5>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="${parseFloat(data[0].Bonificado)}">`);
                                    }else{
                                        cadena = '<h5>Bonificación: <b>$'+formatMoney(0)+'</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="0">`);
                                    }// FINAL BONIFICACION
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12 text-center"><h3><i>${row.data().nombreLote}</i></h3></div></div><div class="row"><div class="col-md-3 p-0"><h5>Precio lote: <b>$${formatMoney(totalNeto2)}</b></h5></div><div class="col-md-3 p-0"><h5>Apl. neodata: <b style="color:${data[0].Aplicado <= 0 ? 'black' : 'blue'};">$${formatMoney(data[0].Aplicado)}</b></h5></div><div class="col-md-3 p-0"><h5>Disponible: <b style="color:green;">$${formatMoney(total0)}</b></h5></div><div class="col-md-3 p-0">${cadena}</div></div><br>`);
                                    // OPERACION PARA SACAR 5%
                                    first_validate = (totalNeto2 * 0.05).toFixed(3);
                                    new_validate = parseFloat(first_validate);
                                    if(total>(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)){
                                        // SOLO DISPERSA LA MITAD
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo </b> diponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        bandera_anticipo = 1;
                                    } else if((total<(new_validate-1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)){
                                        // SOLO DISPERSA LO PROPORCIONAL
                                        if( lugar_prospeccionLote == 28 || lugar_prospeccionLote == '28'){
                                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:red;"></i> Venta E-commerce <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        }
                                        bandera_anticipo = 0;
                                    } else if((total>(new_validate-1) && total<(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)  ){
                                        // SOLO DISPERSA 5%
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo 5%</b> disponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        bandera_anticipo = 2;
                                    }
                                    // FIN BANDERA OPERACION PARA SACAR 5%
                                    $("#modal_NEODATA .modal-body").append(`<div class="row rowTitulos"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>`);
                                    lugar = lugar_prospeccionLote;
                                    var_sum = 0;
                                    let abonado=0;
                                    let porcentaje_abono=0;
                                    let total_comision=0;

                                    $.getJSON( general_base_url + "Comisiones/porcentajesEspecial/"+idCliente).done( function( resultArr ){
                                        $('#spiner-loader').removeClass('hide');
                                        $.each( resultArr, function( i, v){
                                            let porcentajeAse =  0;
                                            let total_comision1=0;
                                            total_comision1 = totalNeto2 * (porcentajeAse / 100);
                                            let saldo1 = 0;
                                            let total_vo = 0;
                                            total_vo = total;
                                            saldo1 = total_vo * (0 / 100);
                                            if(saldo1 > total_comision1){
                                                saldo1 = total_comision1;
                                            }else if(saldo1 < total_comision1){
                                                saldo1 = saldo1;
                                            }else if(saldo1 < 1){
                                                saldo1 = 0;
                                            }
                                            let resto1 = 0;
                                            resto1 = total_comision1 - saldo1;
                                            if(resto1 < 1){
                                                resto1 = 0;
                                            }else{
                                                resto1 = total_comision1 - saldo1;
                                            }
                                            let saldo1C=0;
                                            if(bandera_anticipo == 1){
                                                // entra a bandera 1
                                                saldo1C = (saldo1/2);
                                            } else if(bandera_anticipo == 2){
                                                // entra a bandera 2
                                                saldo1C = (saldo1/2);
                                            } else{
                                                // entra a bandera 0
                                                saldo1C = saldo1;
                                            }
                                            total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                            abonado =parseFloat(abonado) +parseFloat(saldo1C);
                                            porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                            $("#modal_NEODATA .modal-body").append(`
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label id="" class="control-label labelNombre hide">Usuarios</label>
                                                    <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}">
                                                    <input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}">
                                                    <input class="form-control input-gral" required readonly="true" value="${v.nombre}" style="font-size:12px;">
                                                    <b><p style="font-size:12px;">${v.detail_rol}</p></b>
                                                </div>
                                                <div class="col-md-1">
                                                    <label id="" class="control-label labelPorcentaje hide">%</label>
                                                    <input class="form-control input-gral" name="porcentaje[]" id="porcentaje_${i}" onchange="validarPorcentaje(${i}, ${resultArr.length})" onblur="Editar(${i},${totalNeto2},${v.id_usuario},${resultArr.length})" required  value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : v.porcentaje_decimal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label id="" class="control-label labelTC hide">Total de la comisión</label>
                                                    <input class="form-control input-gral" name="comision_total[]" id="comision_total_${i}" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label id="" class="control-label labelAbonado hide">Abonado</label>
                                                    <input class="form-control input-gral" name="comision_abonada[]" required readonly="true" value="${formatMoney(0)}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label id="" class="control-label labelPendiente hide">Pendiente</label>
                                                    <input class="form-control input-gral" name="comision_pendiente[]" id="comision_pendiente_${i}" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                </div>
                                                <div class="col-md-2">
                                                    <label id="" class="control-label labelDisponible hide">Disponible</label>
                                                    <input class="form-control input-gral decimals" name="comision_dar[]"  data-old="" id="comision_dar_${i}" onblur="DarComision(${i},${resultArr.length},${total0})"   value="0">
                                                </div>
                                            </div>`);
                                            responsive(maxWidth);
                                            if(i == resultArr.length -1){
                                                $("#modal_NEODATA .modal-body").append(`
                                                <input type="hidden" name="pago_neo" id="pago_neo" value="${formatMoney(data[0].Aplicado)}">
                                                <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                <input type="hidden" name="porcentaje_abono" id="porcentaje_abono" value="">
                                                <input type="hidden" name="abonado" id="abonado" value="">
                                                <input type="hidden" name="total_comision" id="total_comision" value="">
                                                <input type="hidden" name="bonificacion" id="bonificacion" value="${data[0].Bonificado}">
                                                <input type="hidden" name="pendiente" id="pendiente" value="">
                                                <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                                                <input type="hidden" name="id_disparador" id="id_disparador" value="0">
                                                <input type="hidden" name="lugar_p" id="lugar_p" value="${lugar_prospeccionLote}">
                                                <input type="hidden" name="tipo_venta_insert" id="tipo_venta_insert" value="7">
                                                <input type="hidden" name="totalNeto2" id="totalNeto2" value="${totalNeto2}">
                                                `);
                                            }
                                        });
                                        $("#modal_NEODATA .modal-footer").append('<div class="row pr-2"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary" name="disper_btn"  id="dispersar" value="Dispersar"></div>');
                                    });
                                }
                                else{
                                    $.getJSON( general_base_url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                                        $('#spiner-loader').removeClass('hide');
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
                                        '<div class="col-md-4">Total pago: <b style="color:blue">$'+formatMoney(data1[0].total_comision)+'</b></div>'+
                                        '<div class="col-md-4">Total abonado: <b style="color:green">$'+formatMoney(data1[0].abonado)+'</b></div>'+
                                        '<div class="col-md-4">Total pendiente: <b style="color:orange">$'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');
                                        if(parseFloat(data[0].Bonificado) > 0){
                                            cadena = '<h4>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4>';
                                        }else{
                                            cadena = '<h4>Bonificación: <b>$'+formatMoney(0)+'</b></h4>';
                                        }
                                        $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio del lote: $${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                        <div class="col-md-4"><h4>Aplicado neodata: $<b>$${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                        </div><br>`);
                                        $.getJSON( general_base_url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                            $('#spiner-loader').addClass('hide');
                                            $("#modal_NEODATA .modal-body").append(`
                                                                                    <div class="row rowTitulos">
                                                                                        <div class="col-md-3"><p><b>USUARIOS</b></p></div>
                                                                                        <div class="col-md-1"><b>%</b></div>
                                                                                        <div class="col-md-2 p-0"><b style="font-size: 12px; ">TOTAL DE LA COMISIÓN</b></div>
                                                                                        <div class="col-md-2"><b><b>ABONADO</b></div>
                                                                                        <div class="col-md-2"><b>PENDIENTE</b></div>
                                                                                        <div class="col-md-2"><b>DISPONIBLE</b></div>
                                                                                    </div>`);
                                            $.each( data, function( i, v){
                                                saldo =0;
                                                saldo =  ((10 *(v.porcentaje_decimal / 100)) * total);
                                                if(v.abono_pagado>0){
                                                    // OPCION 1
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
                                                    //OPCION 2
                                                    pending = (v.comision_total);
                                                    if(saldo > pending){
                                                        saldo = pending;
                                                    }
                                                    if(pending < 1){
                                                        saldo = 0;
                                                    }
                                                }
                                                saldo=0;
                                                $("#modal_NEODATA .modal-body").append(`
                                                <div class="row">
                                                    <div class="col-md-3 pl-0">
                                                        <label id="" class="control-label labelNombre hide">Usuarios</label>
                                                        <input id="id_disparador" type="hidden" name="id_disparador" value="1">
                                                        <input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                                        <input type="hidden" name="pending" id="pending" value="${pending}">
                                                        <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                        <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}">
                                                        <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}">
                                                        <input class="form-control input-gral" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                                        <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b>
                                                    </div>
                                                    <div class="col-md-1 pl-0">
                                                        <label id="" class="control-label labelPorcentaje hide">%</label>
                                                        <input class="form-control input-gral" id="porcentaje_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''} padding:8px;" value="${parseFloat(v.porcentaje_decimal)} ">
                                                    </div>
                                                    <div class="col-md-2 pl-0">
                                                        <label id="" class="control-label labelTC hide">Total de la comisión</label>
                                                        <input class="form-control input-gral" id="comision_total_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="$${formatMoney(v.comision_total)}">
                                                    </div>
                                                    <div class="col-md-2 pl-0">
                                                        <label id="" class="control-label labelAbonado hide">Abonado</label>
                                                        <input class="form-control input-gral" id="pagado_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="$${formatMoney(v.abono_pagado)}">
                                                    </div>
                                                    <div class="col-md-2 pl-0">
                                                        <label id="" class="control-label labelPendiente hide">Pendiente</label>
                                                        <input class="form-control input-gral" id="pendiente_${i}" required readonly="true" value="$${formatMoney(pending)}">
                                                    </div>
                                                    <div class="col-md-2 pl-0">
                                                        <label id="" class="control-label labelDisponible hide">Disponible</label>
                                                        <input  class="form-control input-gral decimals" id="abono_nuevo_${i}" onblur="Abonar(${i},${data1[0].totalNeto2},${total0},${data.length});" name="abono_nuevo[]" value="${saldo}" type="text">
                                                    </div>
                                                </div>`);
                                                counts++
                                            });
                                            responsive(maxWidth);
                                        });
                                        $("#modal_NEODATA .modal-footer").append('<div class="row pr-2"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary" name="disper_btn"  id="dispersar" value="Dispersar"></div>');
                                        if(total < 1 ){
                                            $('#dispersar').prop('disabled', true);
                                        }
                                        else{
                                            $('#dispersar').prop('disabled', false);
                                        }
                                    });
                                }
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
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        }
                    }); //FIN getStatusNeodata
                    $("#modal_NEODATA").modal();
              //  }   result
            }
            else{
                alerts.showNotification("top", "right", "El lote no tiene precio asignado en inventario", "warning");
            }
        }
    }); //FIN VERIFY_NEODATA
});

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
                $('#tabla_dispersar_especiales').DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
            }
        }, error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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
                $('#tabla_dispersar_especiales').DataTable().ajax.reload();
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
                $('#tabla_dispersar_especiales').DataTable().ajax.reload();
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
                $('#tabla_dispersar_especiales').DataTable().ajax.reload();
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
                    $('#tabla_dispersar_especiales').DataTable().ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                }else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otra persona o es una recisión", "warning");
                    $('#tabla_dispersar_especiales').DataTable().ajax.reload();
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
                alerts.showNotification("top", "right", "ERROR EN EL SISTEMA, REVISAR CON SISTEMAS", "danger");
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

/**-------------------------------FUNCIONES----------------------------- */

function replaceAll(text, busca, reemplaza) {
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca, reemplaza);
    return text;
}

function Editar(i,precio,id_usuario,lengt){
    //  alert(precio);
    $('#modal_avisos .modal-body').html('');
    let precioLote = parseFloat(precio);
    let nuevoPorce1 = replaceAll($('#porcentaje_'+i).val(), ',','');
    let nuevoPorce = replaceAll(nuevoPorce1, '%','');
    let comision_total =parseFloat(precio) * (nuevoPorce/100);
    $('#comision_total_'+i).val(formatMoney(comision_total));
    let sumaTotalPorcentajes = 0;
    let sumaTotalDispersar = 0;
    let sumaTotalComision = 0;
    for (let m = 0; m < lengt; m++) {
        sumaTotalPorcentajes = sumaTotalPorcentajes + parseFloat($('#porcentaje_'+m).val());
        sumaTotalComision = parseFloat(sumaTotalComision) + parseFloat(replaceAll($('#comision_total_'+m).val(), ',',''));
        sumaTotalDispersar = sumaTotalDispersar + parseFloat(replaceAll($('#comision_dar_'+m).val(), ',',''));
    }
    $('#porcentaje_abono').val(sumaTotalPorcentajes);
    $('#total_comision').val(formatMoney(sumaTotalComision));
    $('#pendiente').val(formatMoney(sumaTotalComision - sumaTotalDispersar));

}

function DarComision(i,lengt,neodata){
    let sumaTotalAbonar = 0;
    let AbonadoNeodata = parseFloat(neodata);
    let sumaTotalPorcentajes = 0;
    let sumaTotalDispersar = 0;
    let sumaTotalComision = 0;
    for (let m = 0; m < lengt; m++) {
        sumaTotalAbonar = sumaTotalAbonar + parseFloat($('#comision_dar_'+m).val());
        sumaTotalPorcentajes = sumaTotalPorcentajes + parseFloat($('#porcentaje_'+m).val());
        sumaTotalComision = parseFloat(sumaTotalComision) + parseFloat(replaceAll($('#comision_total_'+m).val(), ',',''));
        sumaTotalDispersar = sumaTotalDispersar + parseFloat(replaceAll($('#comision_dar_'+m).val(), ',',''));
    }
    //COMPARAMOS SI LA SUMA DE LO DISPONIBLE A DISPERSAR ES MAYOR A LO APLICADO EN NEODATA
    if(parseFloat(sumaTotalAbonar) > parseFloat(AbonadoNeodata)){
        alerts.showNotification("top", "right", "La suma de lo disponible es mayor a lo aplicado en neodata", "warning");
        document.getElementById('dispersar').disabled = true;
        // $('#dispersar').prop('disabled', true);
        //BLOQUER BOTON DE DISPERSAR
    }else{
        //SI LA SUMA ES MENOR A NEODATA, ENTONCES COMPARAR LA COMISION TOTAL CON LO DISPONIBLE A DISPERSAR
        let Comision_Total = parseFloat(replaceAll($('#comision_total_'+i).val(), ',',''));
        let Comision_dar = $('#comision_dar_'+i).val();
        if(parseFloat(Comision_dar) > parseFloat(Comision_Total)){
            alerts.showNotification("top", "right", "El monto a dispersar es mayor a la comisión total", "warning");
            document.getElementById('dispersar').disabled = true;
            // $('#dispersar').prop('disabled', true);
        }else{
            //SI TODO ESTA BIEN CONTINUAMOS CON EL PROCESO
            document.getElementById('dispersar').disabled = false;
            // $('#dispersar').prop('disabled', false);
            $('#comision_pendiente_'+i).val(formatMoney(parseFloat(Comision_Total) - parseFloat(Comision_dar)));
            $('#abonado').val(formatMoney(sumaTotalAbonar));
            $('#porcentaje_abono').val(sumaTotalPorcentajes);
            $('#total_comision').val(formatMoney(sumaTotalComision));
            $('#pendiente').val(formatMoney(sumaTotalComision - sumaTotalDispersar));
        }
    }
}

function Abonar(i,precioLote,Neodata,len){

    let comision_actual = parseFloat(replaceAll($('#abono_nuevo_'+i).val(), ',',''));
    let pagado = parseFloat(replaceAll($('#pagado_'+i).val(), ',',''));
    let total_comision = parseFloat(replaceAll($('#comision_total_'+i).val(), ',',''));
    let abonado = 0;
    let comision_total=0;
    let disponible = 0;

    for (let m = 0; m < len; m++) {

        comision_total =  comision_total + parseFloat(replaceAll($('#comision_total_'+m).val(), ',',''));
    abonado = abonado + parseFloat(replaceAll($('#pagado_'+m).val(), ',',''));
    disponible = disponible + parseFloat(replaceAll($('#abono_nuevo_'+m).val(), ',',''));
    }


    if((abonado + disponible) > parseFloat(Neodata) ){
        alerts.showNotification("top", "right", "La suma de lo disponible mas lo abonado, es mayor  a lo aplicado en neodata", "warning");
        document.getElementById('dispersar').disabled = true;


    }else{

        if((comision_actual + pagado) > total_comision ){
            alerts.showNotification("top", "right", "El monto a dispersar mas lo abonado es mayor a la comisión total", "warning");
            document.getElementById('dispersar').disabled = true;

        }else{
            let pendiente = parseFloat(replaceAll($('#pendiente_'+i).val(), ',',''));

            $('#pendiente_'+i).val(formatMoney(pendiente-comision_actual))
            document.getElementById('dispersar').disabled = false;
        }

    }

}

function validarPorcentaje(index, arrLength) {
    const currentValue = parseFloat($(`#porcentaje_${index}`).val());
    const limit = 20;
    let accumulatedValue = currentValue;
    for (let i = 0; i < arrLength; i++) {
        if (index !== i) {
            accumulatedValue += parseFloat($(`#porcentaje_${i}`).val());
        }
    }
    if (accumulatedValue > limit) {
        $(`#porcentaje_${index}`).val(0);
        alerts.showNotification("top", "right", `El límite del porcentaje sumado debe ser ${limit}%`, "danger");
    }
}

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

$('#fecha1').change( function(){
    fecha1 = $(this).val(); fecha2
    var fecha2 = $('#fecha2').val();
    if(fecha2 == ''){
        alerts.showNotification("top", "right", "Selecciona la segunda fecha", "info");
    } else{
        document.getElementById("fecha2").value = "";
    }
});

$('#fecha2').change( function(){
    $("#myModal .modal-body").html('');
    var fecha2 = $(this).val();
    var fecha1 = $('#fecha1').val();
    if(fecha1 == ''){
        alerts.showNotification("top", "right", "Selecciona la primer fecha", "info");
    } else{
        $.getJSON( general_base_url + "Comisiones/getMontoDispersadoDates/"+fecha1+'/'+fecha2).done( function( $datos ){
            $("#myModal .modal-body").append('<div class="row"><div class="col-md-5"><p class="category"><b>Monto</b>:'+formatMoney($datos['datos_monto'][0].monto)+'</p></div><div class="col-md-4"><p class="category"><b>Pagos</b>: '+formatMiles($datos['datos_monto'][0].pagos)+'</p></div><div class="col-md-3"><p class="category"><b>Lotes</b>: '+formatMiles($datos['datos_monto'][0].lotes)+'</p></div></div>');
        });
    }
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
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateBanderaModal').modal("hide");
                $("#id_pagoc").val("");
                alerts.showNotification("top", "right", "Lote actualizado exitosamente", "success");
                $('#tabla_dispersar_especiales').DataTable().ajax.reload();
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
    // alert($(this).attr("data-idpagoc"));
    id_pagoc = $(this).attr("data-idpagoc");
        nombreLote = $(this).attr("data-nombreLote");
        param = $(this).attr("data-param");
        $("#myUpdateBanderaModal .modal-body").html('');
        $("#myUpdateBanderaModal .modal-header").html('');
        $("#myUpdateBanderaModal .modal-header").append('<h3 class="modal-title">Aviso</b></h3><br><h4 class="modal-title">El lote <b>'+nombreLote+'</b> se enviará al panel de activas.</h4>');
        $("#myUpdateBanderaModal .modal-body").append('<input type="hidden" name="id_pagoc" id="id_pagoc"><input type="hidden" name="param" id="param">');
        $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(1);
});

$("#tabla_dispersar_especiales tbody").on('click', '.btn-detener', function () {
    $("#motivo").val("");
    $("#motivo").selectpicker('refresh');
    $("#descripcion").val("");
    const idLote = $(this).val();
    const nombreLote = $(this).attr("data-value");
    const statusLote = $(this).attr("data-statusLote");
    $('#id-lote-detenido').val(idLote);
    $('#statusLote').val(statusLote);
    $("#detenciones-modal .modal-header").html("");
    $("#detenciones-modal .modal-header").append('<h4 class="modal-title">Enviar a controversia: <b>'+nombreLote+'</b></h4>');
    $("#detenciones-modal").modal();
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

const formatMiles = (number) => {
    const exp = /(\d)(?=(\d{3})+(?!\d))/g;
    const rep = '$1,';
    return number.toString().replace(exp,rep);
}

function responsive(maxWidth) {
    if (maxWidth.matches) { //true mayor 991
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

function function_totales(){
    $.getJSON(`${general_base_url}Comisiones/getMontoDispersado`).done( function( data ){
        $cadena = '<b>$'+formatMoney(data[0].monto)+'</b>';
        document.getElementById("monto_label").innerHTML = $cadena ;
    });
    $.getJSON(`${general_base_url}Comisiones/getPagosDispersado`).done( function( data ){
        $cadena01 = '<b>'+data[0].pagos+'</b>';
        document.getElementById("pagos_label").innerHTML = $cadena01 ;
    });
    $.getJSON(`${general_base_url}Comisiones/getLotesDispersado`).done( function( data ){
        $cadena02 = '<b>'+data[0].lotes+'</b>';
        document.getElementById("lotes_label").innerHTML = $cadena02 ;
    });  
}