
$('#comisiones-detenidas-table').ready(function () {

    let titulos = [];
    $('#comisiones-detenidas-table thead tr:eq(0) th').each(function (i) {
        if (i !== 0) {
            const title = $(this).text();
            titulos.push(title);
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (comisionesDetenidasTabla.column(i).search() !== this.value) {
                    comisionesDetenidasTabla.column(i).search(this.value).draw();
                }
            });
        }
    });

    let comisionesDetenidasTabla = $('#comisiones-detenidas-table').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: "<i class='fa fa-file-excel-o' aria-hidden='true'></i>",
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES DETENIDAS',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        pagingType: 'full_numbers',
        fixedHeader: true,
        scrollX: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + '/static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            'className': 'details-control',
            'orderable': false,
            'data': null,
            'defaultContent': `<div class='toggle-subTable'><i class='animacion fas fa-chevron-down fa-lg'></i></div>`
        },
        {
            data: 'nombreResidencial'
        },
        {
            data: 'nombreCondominio'
        },
        { 
            data: function (d) {

            if(d.id_cliente_reubicacion_2 >1 ) {
                nombreLote = d.nombreLoteReub;
            } else{
                nombreLote = d.nombreLote;
            }
            return nombreLote;
        }},
        {
            data: 'idLote'
        },
        {
            data: 'nombreCliente'
        },
        { 
            data: function (d) {
                return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span><br><span class="${d.colorProcesoCl}">${d.procesoCl}</span>`;
        }},
        { 
            data: function (d) {
            var labelCompartida;

            if(d.compartida == null) {
                labelCompartida ='<span class="label lbl-yellow">Individual</span>';
            } else{
                labelCompartida ='<span class="label lbl-orangeYellow">Compartida</span>';
            }
            return labelCompartida;
        }},
        { 
            data: function (d) {
            var labelStatus;

            if(d.idStatusContratacion == 15) {
                labelStatus ='<span class="label lbl-violetBoots">Contratado</span>';
            }else {
                labelStatus ='<p class="m-0"><b>'+d.idStatusContratacion+'</b></p>';
            }
            return labelStatus;
        }},
        { 
            data: function (d) {
            var labelEstatus;

            if(d.penalizacion == 1 && (d.bandera_penalizacion == 0 || d.bandera_penalizacion == 1) ){
                labelEstatus =`<p class="m-0"><b>Penalización ${d.dias_atraso} días</b></p><span onclick="showDetailModal(${d.plan_comision})" style="cursor: pointer;">${d.plan_descripcion}</span>`;
            }
            else{
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
            }
            return labelEstatus;
        }},
        { 
            data: function (d) {
            let motivo;
            let color;

            if (d.motivo == 4 || d.motivo == 5 || d.motivo == 3 || d.motivo == 6 || d.motivo == 8) {
                motivo = d.motivoOpc;
            } else {
                color = 'lbl-azure';
                motivo = d.motivo;
            }
            return '<span class="label lbl-gray">' + motivo + '</span>';
        }},
        { 
            data: function (d) {
            var fechaActualizacion;

            if(d.fecha_sistema == null) {
                fechaActualizacion ='<span class="label lbl-gray">Sin Definir</span>';
            }else {
                fechaActualizacion = '<span class="label lbl-azure">'+d.fecha_sistema+'</span>';
            }
            
            return fechaActualizacion;
        }},
        {
            data: function (d) {
                let botton = '';
                var Mensaje = 'Verificar en NEODATA';
                varColor2  = 'btn-gray';
                var RegresaActiva = '';

                if(d.compartida==null) {
                    varColor  = 'btn-sky';
                } else{
                    varColor  = 'btn-green';
                }
                
                if (id_rol_general != 63 && id_rol_general != 4) {
                    if (id_usuario_general == 2749 || id_usuario_general == 2807 || id_usuario_general == 2767 || id_usuario_general == 11947) {
                        botton += `<div class="d-flex justify-center"><button value="${d.idLote}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas btn-cambiar-estatus" data-toggle="tooltip" data-placement="top" title="REGRESAR A DISPERSIÓN"><i class="material-icons">undo</i></button></div>`;
                    } else {
                        botton += `NO APLICA`;
                    }

                    disparador = 0;
                    if (d.pass == 1) {
                        disparador = 1;
                        totalLote = d.totalNeto2;
                        reubicadas = 0;
                        nombreLote = d.nombreLote;
                        id_cliente = d.id_cliente;
                        plan_comision = d.plan_comision;
                        descripcion_plan = d.plan_descripcion;
                        ooamDispersion = 2;//NUEVA VENTAS 1°
                        nombreOtro = d.nombreOtro;
                    }

                    if (disparador != 0) {
                        // BtnStats += `${disparador}`; 
                        d.abonadoAnterior = [2, 3, 4, 7].includes(parseInt(d.proceso)) ? parseFloat(d.sumComisionesReu) + parseFloat(d.abonadoAnterior) : d.abonadoAnterior;
                        botton += `<button href="#" 
                        value = "${d.idLote}" 
                        data-totalNeto2 = "${totalLote}"
                        data-totalNeto2Cl = "${d.totalNeto2Cl}" 
                        data-total8P = "${d.total8P}" 
                        data-reubicadas = "${reubicadas}" 
                        data-penalizacion = "${d.penalizacion}"
                        data-nombreLote = "${nombreLote}" 
                        data-nombreOtro = "${nombreOtro}" 
                        data-banderaPenalizacion = "${d.bandera_penalizacion}" 
                        data-cliente = "${id_cliente}" 
                        data-plan = "${plan_comision}" 
                        data-disparador = "${disparador}" 
                        data-tipov = "${d.tipo_venta}"
                        data-descplan = "${descripcion_plan}" 
                        data-ooam = "${ooamDispersion}"
                        data-estatusLote = "${d.idStatusContratacion}"
                        data-abonadoAnterior = "${d.abonadoAnterior}"
                        data-procesoReestructura = "${d.proceso}"
                        data-code = "${d.cbbtton}"
                        data-opcionMensualidad = "${d.opcionMensualidad}"
                        data-nombreMensualidad = "${d.nombreMensualidad}"
                        class = "btn-data ${varColor} verify_neodata" data-toggle="tooltip" data-placement="top" title="${Mensaje}"><span class="material-icons">verified_user</span></button> ${RegresaActiva}`;

                } else {
                        botton += `LOTE FALTA DE DATOS`
                    }

                    return '<div class="d-flex justify-center">' + botton + '</div>';
                } else {
                    return 'NO APLICA ';
                }
            }
        }],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            'url': general_base_url + 'Comisiones/getDataDetenidas',
            'dataSrc': '',
            'type': 'GET',
            cache: false,
            'data': function (d) { }
        },
    });

    $('#comisiones-detenidas-table').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $('#comisiones-detenidas-table tbody').on('click', 'td.details-control', function () {
        const tr = $(this).closest('tr');
        const row = comisionesDetenidasTabla.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            row.child(`<div class="container subBoxDetail">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                            <label><b>Descripción</b></label>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" style="padding: 10px 30px 0 30px;">
                            <label>` + row.data().comentario + `</label>
                        </div>
                    </div>
                </div>`).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $('#comisiones-detenidas-table tbody').on('click', '.btn-cambiar-estatus', function () {
        const idLote = $(this).val();
        let data = new FormData();
        data.append('idLote', idLote);
        $.ajax({
            type: 'POST',
            url: 'updateBanderaDetenida',
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('#estatus-modal').modal("hide");
                    $("#id-lote").val("");
                    alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                    comisionesDetenidasTabla.ajax.reload();
                } else {
                    alerts.showNotification("top", "right", "Ocurrió un problema, vuelva a intentarlo más tarde.", "warning");
                }
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#comisiones-detenidas-table tbody").on("click", ".verify_neodata", async function(){

        
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        var tr = $(this).closest('tr');
        var row = $('#tabla_dispersar_comisiones').DataTable().row(tr);
        let cadena = '';

        idLote = $(this).val();
        totalNeto2 = $(this).attr("data-totalNeto2");
        totalNeto2Cl = $(this).attr("data-totalNeto2Cl");
        total8P = $(this).attr("data-total8P");
        reubicadas = $(this).attr("data-reubicadas");
        penalizacion = $(this).attr("data-penalizacion");
        nombreLote = $(this).attr("data-nombreLote");
        bandera_penalizacion = $(this).attr("data-banderaPenalizacion");
        idCliente = $(this).attr("data-cliente");
        plan_comision = $(this).attr("data-plan");
        disparador = $(this).attr("data-disparador");
        tipo_venta = $(this).attr("data-tipov");
        descripcion_plan = $(this).attr("data-descplan");
        ooamDispersion = $(this).attr("data-ooam");
        nombreOtro = $(this).attr("data-nombreOtro");
        estatusLote = $(this).attr("data-estatusLote");
        abonadoAnterior = $(this).attr("data-abonadoAnterior");
        procesoReestructura = $(this).attr("data-procesoReestructura");

        opcionMensualidad = $(this).attr("data-opcionMensualidad");
        nombreMensualidad = $(this).attr("data-nombreMensualidad");


        totalNeto2 = (plan_comision == 66 || plan_comision == 86) ? total8P : totalNeto2;


        if(parseFloat(totalNeto2) > 0){

            // alert(ooamDispersion);
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                var AplicadoGlobal = data.length > 0 ? data[0].Aplicado : 0;
                console.log(data)
                if(data.length > 0){
                    switch (data[0].Marca) {
                        case 0:
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                        break;
                        case 1:
                            if((disparador == 1 || disparador == 3)){
                                //COMISION NUEVA
                                let total0 = parseFloat(data[0].Aplicado-abonadoAnterior);
                                let total = 0;
                                let totalPivote=0;
                                if(total0 > 0){
                                    total = total0;
                                }else{
                                    total = 0;
                                }
                                // INICIO BONIFICACION y PLAN 66
                                bonificadoTotal = 0;

                                if(parseFloat(data[0].Bonificado) > 0){
                                    bonificadoTotal = data[0].Bonificado;
                                }

                                $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value=">${bonificadoTotal}">`);
                                
                                if(plan_comision == 66 || plan_comision == 86){
                                    cadena = 
                                    `<div class="col-md-3 p-0">
                                        <h5>Bonificación: <b style="color:#D84B16;">${formatMoney(bonificadoTotal)}</b></h5>
                                    </div>
                                    
                                    <div class="col-md-4 p-0">
                                        <h5>Precio Lote Origen: <b>${formatMoney(totalNeto2Cl)}</b></h5>
                                    </div>

                                    <div class="col-md-4 p-0">
                                        <h5>Excedente: <b>${formatMoney(total8P)}</b></h5>
                                    </div>
                                    `;
                                } else{
                                    
                                }
                                // FINAL BONIFICACION y PLAN 66

                                let labelPenalizacion = '';
                                if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">(Penalización + 90 días)</b>';}
                                $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h3>Lote: <b>${nombreLote}${labelPenalizacion}</b></h3>
                                            </div>
                                        </div>
                                    

                                            <div class="col-md-3 p-0">
                                                <h5>Precio Lote: <b>${formatMoney(totalNeto2)}</b></h5>
                                            </div>

                                            <div class="col-md-3 p-0">
                                                <h5>NEODATA: <b style="color:${data[0].Aplicado <= 0 ? 'black' : 'blue'};">${formatMoney(data[0].Aplicado)}</b></h5>
                                            </div>




                                                    ${cadena}
                                        </div>`);

                                        
                                // OPERACION PARA SACAR 5% y 8%
                                operacionA = (totalNeto2 * 0.05).toFixed(3);
                                operacionB = (totalNeto2 * 0.08).toFixed(3);
                                cincoporciento = parseFloat(operacionA);
                                ochoporciento = parseFloat(operacionB);
                                var porcentajeAbonado = ((total * 100) / totalNeto2);
                                console.log('%%%%%%%%%%'+porcentajeAbonado);

                                if(procesoReestructura != 0 && estatusLote < 15 && ooamDispersion == 1 ){
                                // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Dispersión OOAM 50%</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 3; //[2,4,7].includes(parseInt(procesoReestructura)) ? 4 : 3;
                                } else if(procesoReestructura != 0 && estatusLote >= 15 && ooamDispersion == 1){
                                    // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Dispersión OOAM</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                        bandera_anticipo = 4;
                                } else if(total<(cincoporciento-1) && (disparador != 3 || ooamDispersion == 2)){
                                // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                                console.log('Si el monto es menor al 5% ');
                                $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo menor al 5%</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 0;
                                }else if(total>=(ochoporciento) && (disparador != 3 || ooamDispersion == 2) ){
                                // *********Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% / se dispersa la mitad
                                console.log('Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% ');
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo mayor/igual al 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`); 
                                    bandera_anticipo = 1;
                                } else if(total>=(cincoporciento-1) && total<(ochoporciento) && (disparador != 3 || ooamDispersion == 2) ){
                                    console.log('Si el monto el igual o mayor a 5% y menor al 8% ');
                                // *********Si el monto el igual o mayor a 5% y menor al 8% se dispersará la 4° parte de la comisión
                                    $("#modal_NEODATA .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo entre 5% - 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                    bandera_anticipo = 2;
                                } 
                                console.log(bandera_anticipo);

                                // FIN BANDERA OPERACION PARA SACAR 5%
                                $("#modal_NEODATA .modal-body").append(`<div class="row rowTitulos">
                                <div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div>
                                <div class="col-md-1"><b>%</b></div>
                                <div class="col-md-2"><b>TOT. COMISIÓN</b></div>
                                <div class="col-md-2"><b><b>ABONADO</b></div>
                                <div class="col-md-2"><b>PENDIENTE</b></div>
                                <div class="col-md-2"><b>DISPONIBLE</b></div>
                                </div>`);
                                
                                var_sum = 0;
                                let abonado=0;
                                let porcentaje_abono=0;
                                let total_comision=0;

                                const datosPlan8PAnterior =  [
                                    {
                                        idRol:7,
                                        porcentaje:0.50
                                    },
                                    {
                                        idRol:3,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:2,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:1,
                                        porcentaje:0.1
                                    }
                                ];
                                const datosPlan8PNuevo =  [
                                    {
                                        idRol:7,
                                        porcentaje:0.50
                                    },
                                    {
                                        idRol:3,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:2,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:59,
                                        porcentaje:0.2
                                    },
                                    {
                                        idRol:1,
                                        porcentaje:0.1
                                    }
                                ];
                                const datosPlan8P = plan_comision == 66 ? datosPlan8PAnterior : datosPlan8PNuevo;

                                $.post(general_base_url + "Comisiones/porcentajes",{idCliente:idCliente,totalNeto2:totalNeto2,plan_comision:plan_comision,reubicadas:reubicadas,ooamDispersion:ooamDispersion}, function (resultArr) {
                                    resultArr = JSON.parse(resultArr);
                                    //console.log(disparador)
                                    var SumaComisionTotal = 0;
                                    var sumaAsesorCoor = 0;
                                    var cuantosAsesores = 0;
                                    var cuantosCoor = 0;
                                    var comisionTotalRewards = 0;
                                    var porcentajeReferido = 0;
                                    $.each( resultArr, function( i, v){
                                        SumaComisionTotal = SumaComisionTotal + v.comision_total;
                                        if(parseInt(v.id_usuario) == 12841 && plan_comision == 56){ // MADERAS REWORDS
                                            comisionTotalRewards = v.comision_total;
                                            porcentajeReferido = ((comisionTotalRewards * 100) / total);

                                        }
                                        if(v.id_rol == 7){
                                            cuantosAsesores = cuantosAsesores + 1; 
                                        }if(v.id_rol == 9){
                                            cuantosCoor = cuantosCoor + 1; 
                                        }
                                        
                                    });
                                    console.log(SumaComisionTotal);
                                    $.each( resultArr, function( i, v){
                                        let porcentajes = '';
                                        if(plan_comision == 66 || plan_comision == 86){
                                            v.id_rol = plan_comision == 86 && v.id_usuario == 13546 ? 59 : v.id_rol;
                                            const busqueda = datosPlan8P.find((roles) => roles.idRol == v.id_rol);
                                            porcentajes = busqueda != undefined ? `<p style="font-size:12px;">${busqueda.porcentaje}% L.O. + ${v.porcentaje_decimal}% E.</p>` : '' ;
                                            v.porcentaje_decimal = busqueda != undefined ? v.porcentaje_decimal + busqueda.porcentaje : v.porcentaje_decimal;
                                            v.comision_total = busqueda != undefined ? (v.comision_total + ((busqueda.porcentaje/100)) * totalNeto2Cl) : v.comision_total;
                                        }

                                        let porcentajeAse = v.porcentaje_decimal;
                                        let total_comision1 = 0;
                                        total_comision1 = totalNeto2 * (porcentajeAse / 100);
                                        let saldo1 = 0;
                                        let total_vo = 0;
                                        total_vo = total;
                                        saldo1 = total_vo * (v.porcentaje_neodata / 100);
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
                                        let saldo1C = 0;
                                        console.log(total)

                                        total = [2,3,4,7].includes(parseInt(procesoReestructura)) ? total  : total;
                                        total = ([2,3,4,7].includes(parseInt(procesoReestructura)) && (data[0].Aplicado-abonadoAnterior) <= 0) ? 0 : total;
                                        totalPivote = total;
                                        console.log('------------')
                                        console.log(estatusLote)
                                        console.log(procesoReestructura)
                                        console.log(plan_comision)
                                        console.log(data[0].Aplicado-abonadoAnterior)

                                        if((parseInt(estatusLote) === 15 && [2,3,4,7].includes(parseInt(procesoReestructura)) && ((data[0].Aplicado-abonadoAnterior) > 6000) && [64,65,66,84,85,86].includes(parseInt(plan_comision))) || idLote == 63107){
                                            total = SumaComisionTotal < total ? AplicadoGlobal : total;
                                           // total = idLote == 63107 ? AplicadoGlobal : total;
                                            console.log(9);
                                        }else  if(estatusLote < 15 && [2,3,4,7].includes(parseInt(procesoReestructura)) && ((data[0].Aplicado-abonadoAnterior) > (SumaComisionTotal / 2) && [64,65,66,84,85,86].includes(parseInt(plan_comision)) )){
                                            console.log(8);
                                            total = (SumaComisionTotal / 2) < total ? AplicadoGlobal : total;
                                        }else {
                                            console.log(7);
                                            total = SumaComisionTotal < total ? AplicadoGlobal : total;
                                            total = totalPivote;
                                            total = idLote == 52436 ? ((data[0].Aplicado-abonadoAnterior) - 7859.826399999984) : total;
                                            console.log(total);

                                        }

                                        
                                       // console.log('Suma porcentajes: ' +sumaAsesorCoor);
                                        switch(bandera_anticipo){
                                            case 0:// monto < 5% se dispersará solo lo proporcional
                                                    if(plan_comision == 56){
                                                        let nuevoPorcentaje = 0;
                                            let porcentajeMaderas = 0;
                                                        //let porcentajeReferido = 0;
                                                        if(porcentajeAbonado < 2){ //ATICIPO MENOR AL 1%
                                                            let porcentajeRestante = 100 - porcentajeReferido;

                                                            if(parseInt(v.id_usuario) == 12841){
                                                                porcentajeMaderas =  (8 * (porcentajeReferido / 100));
                                                                nuevoPorcentaje = porcentajeMaderas;
                                                               // operacionValidar = (total*(0.125*porcentajeMaderas));

                                                            }else{
                                                                if([7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){
                                                                    console.log('porcentaje restante'+porcentajeRestante);
                                                                    nuevoPorcentaje = v.id_rol == 7 ? (8 * (((porcentajeRestante / 4) * 3)  / cuantosAsesores) /100): (8 *((porcentajeRestante / 4)  / cuantosCoor) /100);
                                                                    console.log('nuevo porcentaje ' + nuevoPorcentaje)
                                                                }else{
                                                                    nuevoPorcentaje = 0;
                                                                }

                                                            } 
                                                        }else{ //

                                                        }
                                                        /*if(plan_comision == 56 && [7,9].indexOf(parseInt(v.id_rol)) >= 0 && parseInt(v.id_usuario) != 12841){ //MADERAS REWORDS
                                                        porcentajeMaderas = 0;
                                                    }
                                                    else if(plan_comision == 56 && parseInt(v.id_usuario) == 12841){
                                                        porcentajeMaderas = v.porcentaje_decimal + sumaAsesorCoor;
                                                        } */
                                                            operacionValidar = (total*(0.125*nuevoPorcentaje));
                                                    }else{
                                                        operacionValidar = (total*(0.125*v.porcentaje_decimal));
                                                    }
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;
                                            case 1:// monto igual o mayor a 8% dispersar 12.5% / la mitad
                                            console.log("del 8 al 12");
                                            operacionValidar = parseInt(v.id_usuario) == 12841 ? total_comision1 : (total_comision1 / 2);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;
                                            case 2: // monto entre 5% y 8% dispersar 4 parte
                                            console.log("del 5 al 8");

                                            //operacionValidar = (total_comision1/4);
                                            operacionValidar = parseInt(v.id_usuario) == 12841 ? total_comision1 : (total_comision1 / 2);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;

                                            case 3: // monto OOAM 50%
                                            operacionValidar = (total*(0.125*v.porcentaje_decimal));
                                            if(operacionValidar > (v.comision_total/2)){
                                                saldo1C = (v.comision_total/2);
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                            break;

                                            case 4: // monto OOAM 100%
                                            operacionValidar = idLote == 63107 ? (total*((2)*v.porcentaje_decimal)) : (total*(0.125*v.porcentaje_decimal));
                                            console.log('total'+total);
                                            console.log('operacionValidar'+operacionValidar);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }

                                            break;

                                        }

                                        total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                        abonado = parseFloat(abonado) +parseFloat(saldo1C);
                                        porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                                $("#modal_NEODATA .modal-body").append(`
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label id="" class="control-label labelNombre hide">Usuarios</label>
                                                            <input type="hidden" name="penalizacion" id="penalizacion" value="${penalizacion}"><input type="hidden" name="nombreLote" id="nombreLote" value="${nombreLote}">
                                                            <input type="hidden" name="plan_c" id="plan_c" value="${plan_comision}">
                                                            <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}"><input id="num_usuarios" type="hidden" name="num_usuarios[]" value="${v.num_usuarios}">
                                                            <input class="form-control input-gral" required readonly="true" value="${v.nombre}" style="font-size:12px;"><b><p style="font-size:12px;margin-bottom:0px !important;">${v.detail_rol}</p></b>${porcentajes}
                                                            
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label id="" class="control-label labelPorcentaje hide">%</label>
                                                            <input class="form-control input-gral" name="porcentaje[]"  required readonly="true" type="hidden" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : parseFloat(v.porcentaje_decimal)}">
                                                            <input class="form-control input-gral" style="padding:10px;" required readonly="true" value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : v.porcentaje_decimal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelTC hide">Total de la comisión</label>
                                                            <input class="form-control input-gral" name="comision_total[]" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelAbonado hide">Abonado</label>
                                                            <input class="form-control input-gral" name="comision_abonada[]" required readonly="true" value="${formatMoney(0)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelPendiente hide">Pendiente</label>
                                                            <input class="form-control input-gral" name="comision_pendiente[]" required readonly="true" value="${formatMoney(v.comision_total)}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label id="" class="control-label labelDisponible hide">Disponible</label>
                                                            <input class="form-control input-gral decimals" name="comision_dar[]"  data-old="" id="inputEdit" readonly="true"  value="${formatMoney(saldo1C)}">
                                                        </div>
                                                    </div>`);
                                                if(i == resultArr.length -1){
                                                    $("#modal_NEODATA .modal-body").append(`
                                                    <input type="hidden" name="pago_neo" id="pago_neo" value="${formatMoney(data[0].Aplicado)}">
                                                    <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                    <input type="hidden" name="porcentaje_abono" id="porcentaje_abono" value="${porcentaje_abono}">
                                                    <input type="hidden" name="abonado" id="abonado" value="${formatMoney(abonado)}">
                                                    <input type="hidden" name="total_comision" id="total_comision" value="${formatMoney(total_comision)}">
                                                    <input type="hidden" name="bonificacion" id="bonificacion" value="${formatMoney(data[0].Bonificado)}">
                                                    <input type="hidden" name="pendiente" id="pendiente" value="${formatMoney(total_comision-abonado)}">
                                                    <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                                                    <input type="hidden" name="id_disparador" id="id_disparador" value="${disparador}">
                                                    <input type="hidden" name="ooamValor" id="ooamValor" value="${ooamDispersion}">
                                                    <input type="hidden" name="totalNeto2" id="totalNeto2" value="${totalNeto2}">
                                                    <input type="hidden" name="nombreOtro" id="nombreOtro" value="${nombreOtro}">
                                                    
                                                    `);
                                                }
                                    });
                                    // responsive(maxWidth);
                                    $("#modal_NEODATA .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersar" value="Dispersar"></div>');
                                });
                            }
                            else{
                                $.getJSON( general_base_url + "Comisiones/getDatosAbonadoSuma11/"+idLote+"/"+ooamDispersion).done( function( data1 ){
                                    
                                    let total0 = [2,3,4,7].includes(parseInt(procesoReestructura)) ? parseFloat((data[0].Aplicado - abonadoAnterior)) : parseFloat((data[0].Aplicado));
                                    let total = 0;
                                    if(total0 > 0){
                                        total = total0;
                                    }
                                    else{
                                        total = 0;
                                    }
                                    var counts=0;
                                    let labelPenalizacion = '';
                                    // data1[0].abonado
                                    if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">Lote con Penalización + 90 días</b>';}
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${row.data().nombreLote}</i>: <b>${formatMoney([2,3,4,7].includes(parseInt(procesoReestructura)) ? total0 : (total0-(data1[0].abonado)))}</b><br>${labelPenalizacion}</h3></div></div><br>`);
                                    $("#modal_NEODATA .modal-body").append(`
                                        <div class="row">
                                            <div class="col-md-4 pl-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div>
                                            <div class="col-md-4">Total abonado: <b style="color:green">${formatMoney(abonadoAnterior)}</b></div>
                                            <div class="col-md-4">Total pendiente: <b style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div>
                                        </div>
                                

                                    `);
                                   let cadenaExcedente = [4,6,7].indexOf(parseInt(procesoReestructura)) >= 0 ? `<h4>Excedente: <b>${formatMoney(total8P)}</b></h4>` : ''; 
                                    console.log([4,6,7].indexOf(parseInt(procesoReestructura)));
                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = `<h4>Bonificación: <b style="color:#D84B16;">$${formatMoney(data[0].Bonificado)}</b></h4>${cadenaExcedente}`;
                                    }else{
                                        cadena = `<h4>Bonificación: <b >${formatMoney(0)}</b></h4>${cadenaExcedente}`;
                                    }
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: ${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                    <div class="col-md-4"><h4>Aplicado neodata: <b>${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                    </div><br>`);

                                    $.getJSON( general_base_url + "Comisiones/getDatosAbonadoDispersion/"+idLote+"/"+ooamDispersion+"/"+data1[0].estructura).done( function( data ){
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
                                                contador += 1;
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
                                                let pendienteGlobal = parseFloat(data1[0].total_comision - data1[0].abonado);
                                                console.log('pendiente: '+pendienteGlobal);
                                                console.log('total: '+total);
                                                //saldo =  ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                v.porcentaje_decimal = idLote == 37629 && v.id_usuario == 13556 ? 2.5 : v.porcentaje_decimal;
                                                saldo = ([2,3,4,7].includes(parseInt(procesoReestructura)) && total > 2262.71 ) ? ( pendienteGlobal > total ? ((12.5 *(v.porcentaje_decimal / 100)) * total)  :  ((12.5 *(v.porcentaje_decimal / 100)) * parseFloat(AplicadoGlobal)) ) : ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                saldo = ([2,3,4,7].includes(parseInt(procesoReestructura)) && total <= 0) ? 0 : saldo;
                                                v.porcentaje_decimal = idLote == 37629 && v.id_usuario == 13556 ? 3.5 : v.porcentaje_decimal;
                                            
                                            }
                                            console.log('saldo'+saldo);

                                            if(parseFloat(v.abono_pagado) > 0){
                                                evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                                if(parseFloat(evaluar) < 0){
                                                    pending=evaluar;
                                                    saldo = 0;
                                                }
                                                else{
                                                    pending = evaluar;
                                                }
                                                console.log('saldo segundo '+saldo);
                                                console.log('saldo tercero '+ ( saldo-v.abono_pagado ));
                                                console.log('total::'+total);
                                                console.log('procesoReestructura::'+procesoReestructura);
                                                console.log('plan_comision::'+plan_comision);
                                                console.log('idLote::'+idLote);
                                                resta_1 = (([2,3,4,7].includes(parseInt(procesoReestructura)) && (total < 5000) ) || ([64,65,66,84,85,86].indexOf(plan_comision) >= 0 || [57154,48216,55933].indexOf(idLote) >= 0)) ? saldo : ( saldo-v.abono_pagado );
                                                console.log('RESTA'+resta_1);
                                                if(parseFloat(resta_1) <= 0){
                                                    saldo = 0;
                                                }
                                                else if(parseFloat(resta_1) > 0){
                                                    if(parseFloat(resta_1) > parseFloat(pending)){
                                                        saldo = pending;
                                                    }
                                                    else{
                                                        saldo = (( [2,3,4,7].includes(parseInt(procesoReestructura))  && total < (5000)) || ([64,65,66,84,85,86].indexOf(plan_comision) >= 0 || [57154,48216,55933].indexOf(idLote)) >= 0) ? saldo : saldo-v.abono_pagado;
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
                                            <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="${disparador}"><input type="hidden" name="penalizacion" id="penalizacion" value="${penalizacion}"><input type="hidden" name="nombreLote" id="nombreLote" value="${nombreLote}"><input type="hidden" name="idCliente" id="idCliente" value="${idCliente}"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
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
                    //QUERY SIN RESULTADOS
                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA  </b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                }
            }); //FIN getStatusNeodata
            // $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA .</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            $("#modal_NEODATA").modal();
        }
    }); //FIN VERIFY_NEODATA
});