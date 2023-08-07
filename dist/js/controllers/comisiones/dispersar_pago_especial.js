
$(document).on('click', '.update_bandera', function(e){
    id_pagoc = $(this).attr("data-idpagoc");
    param = $(this).attr("data-param");
    $("#myUpdateBanderaModal").modal();
    $("#id_pagoc").val(id_pagoc);
    $("#param").val(1);
});


var getInfo1 = new Array(6);
var getInfo3 = new Array(6);


$("#tabla_ingresar_9").ready( function(){
    let titulos = [];
    $('#tabla_ingresar_9 thead tr:eq(0) th').each( function (i) {
        if(i != 0 && i != 11){
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if (tabla_1.column(i).search() !== this.value ) {
                    tabla_1
                    .column(i)
                    .search(this.value)
                    .draw();
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
            title: 'REPORTE DISPERSIÓN DE PAGO',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10],
                format: {
                    header:  function (d, columnIdx) {
                        if(columnIdx == 0){
                            return ' '+d +' ';
                        }else if(columnIdx == 11){
                            return ' '+d +' ';
                        }else if(columnIdx != 11 && columnIdx !=0){
                            if(columnIdx == 12){
                                return 'TIPO'
                            }else{
                                return ' '+titulos[columnIdx-1] +' ';
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
        columns: [{
            "width": "3%",
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
            "width": "11%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        }, 
        {
            "width": "11%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.nombre_cliente+'</b></p>';
            }
        }, 
        {
            "width": "8%",
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
            "width": "8%",
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
            "width": "8%",
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
                } else{

                    if(d.descuento_mdb == 1){

                        lblStats ='<span class="label" style="background:#8069B4;">MARTHA DEBAYLE</span>';
                    }else{

                    switch(d.lugar_prospeccion){        
                        case '6':
                            if(d.registro_comision == 2){
                                lblStats ='<span class="label" style="background:#11DFC6;">SOLICITADO MKT</span>';
                            }else{
                                lblStats ='<span class="label" style="background:#B4A269;">MARKETING DIGÍTAL</span>';
                            }
                        break;

                        case '12':
                            lblStats ='<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
                        break;

                        case '26':
                            lblStats ='<span class="label" style="background:#0860BA;">COREANO VLOGS</span>';
                        break;

                        case '29':
                            lblStats ='<span class="label" style="background:#0891BB;">COREANO VLOGS + MKTD</span>';
                        break;

                        case '32':
                            lblStats ='<span class="label" style="background:#BA0899;">YO AMO SLP</span>';
                        break;
                        default:
                            lblStats ='';
                        break;
                    }
                }
            }
                return lblStats;
            }
        },
        {
            "width": "8%",
            "data": function( d ){
                var lblStats;

                if(d.fecha_modificacion <= '2021-01-01' || d.fecha_modificacion == null ) {
                    lblStats ='<span class="label label-gray" style="color:gray;">No definida</span>';
                }else {
                    lblStats ='<span class="label label-info">'+d.date_final+'</span>';
                }
                return lblStats;
            }
        },
         { 
            "width": "14%",
            "orderable": false,
            "data": function( data ){
                var BtnStats;
                if(data.totalNeto2==null) {
                    BtnStats = '';
                }else {
                    if(data.compartida==null) {
                        if(data.fecha_modificacion <= '2021-01-01' || data.fecha_modificacion == null ) {
                            BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-totalNeto2="'+data.totalNeto2+'" data-compartida="'+0+'" data-tipov="'+data.tipo_venta+'" data-subdirector="'+data.sub+'" data-regis="'+data.registro_comision+'" data-ismktd="'+data.ismktd+'" data-mdb="'+data.descuento_mdb+'" data-lugarP="'+data.lugar_prospeccion+'" data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-sky verify_neodata" data-idCliente="'+data.id_cliente+'" title="Verificar en NEODATA">' +'<span class="material-icons">verified_user</span></button> ';
                        }else {
                            BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'"  data-value="'+data.registro_comision+'"   data-estatus="'+data.idStatusContratacion+'" data-totalNeto2="'+data.totalNeto2+'" data-compartida="'+0+'" data-tipov="'+data.tipo_venta+'" data-subdirector="'+data.sub+'" data-regis="'+data.registro_comision+'" data-ismktd="'+data.ismktd+'" data-mdb="'+data.descuento_mdb+'" data-lugarP="'+data.lugar_prospeccion+'"  data-code="'+data.cbbtton+'" ' +'class="btn-data btn-sky verify_neodata" data-idCliente="'+data.id_cliente+'" title="Verificar en NEODATA">' +'<span class="material-icons">verified_user</span></button> <button href="#" data-param="1" data-idpagoc="' + data.idLote + '" ' +'class="btn-data btn-deepGray update_bandera" title="Regresar a activas">' +'<i class="fas fa-undo-alt"></i></button>'
                            ;


                            // +'<button class="btn-data btn-orangeYellow marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'"><i class="material-icons">how_to_reg</i></button>';
                        }
                    }else {
                            if(data.fecha_modificacion <= '2021-01-01' || data.fecha_modificacion == null ) {
                            BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-totalNeto2="'+data.totalNeto2+'" data-compartida="'+1+'" data-tipov="'+data.tipo_venta+'" data-subdirector="'+data.sub+'" data-regis="'+data.registro_comision+'" data-ismktd="'+data.ismktd+'" data-mdb="'+data.descuento_mdb+'" data-lugarP="'+data.lugar_prospeccion+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-green verify_neodata" data-idCliente="'+data.id_cliente+'" title="Verificar en NEODATA">' +'<span class="material-icons">verified_user</span></button> ';
                        }else {
                            // <button class="btn-data btn-orangeYellow marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'"><i class="material-icons">how_to_reg</i></button>
                            BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'"  data-value="'+data.registro_comision+'" data-estatus="'+data.idStatusContratacion+'" data-totalNeto2="'+data.totalNeto2+'" data-compartida="'+0+'" data-tipov="'+data.tipo_venta+'" data-subdirector="'+data.sub+'" data-regis="'+data.registro_comision+'" data-ismktd="'+data.ismktd+'" data-mdb="'+data.descuento_mdb+'" data-lugarP="'+data.lugar_prospeccion+'" data-idCliente="'+data.id_cliente+'"  data-code="'+data.cbbtton+'" ' +'class="btn-data btn-green verify_neodata" title="Verificar en NEODATA">' +'<span class="material-icons">verified_user</span></button> <button href="#" data-param="1" data-idpagoc="' + data.idLote + '" ' +'class="btn-data btn-deepGray update_bandera" title="Regresar a activas">' +'<i class="fas fa-undo-alt"></i></button>'
                             ;


                            // +'<button class="btn-data btn-orangeYellow marcar_pagada" title="Marcar como liquidada" value="' + data.idLote +'"><i class="material-icons">how_to_reg</i></button>';
                        }
                    }
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        },
        ],
        ajax: {
            "url": url+'/Comisiones/getDataDispersionPagoEspecial',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){}
        }
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
            var status;
            var fechaVenc;
            if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38) {
                status = 'Status 8 listo (Asistentes de Gerentes)';
            } 
            else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65 ) {
                status = 'Status 8 enviado a Revisión (Asistentes de Gerentes)';
            }
            else {
                status='N/A';
            }
            if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
                row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
                fechaVenc = row.data().fechaVenc;
            }else {
                fechaVenc='N/A';
            }

            var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Subdirector: </b>' + row.data().subdirector + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Gerente: </b>' + row.data().gerente + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' + row.data().coordinador + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';

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

    
    $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", async function(){ 

        subdirector = $(this).attr("data-subdirector");
        if(subdirector == 0){
                    alerts.showNotification("top", "right", "SIN SUBDIRECTOR ASIGNADO, FAVOR DE REVISARLO CON SISTEMAS VIA TICKET INDICANDO LOS DATOS DEL USUARIO FALTANTE (NOMBRE Y EL ID)", "warning");
        }else{


            // $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", async function(){ 
        $("#modal_NEODATA .modal-header").html("");
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        var tr = $(this).closest('tr');
        var row = tabla_1.row( tr );
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
        console.log($(this).attr("data-mdb"));
        let martha = $(this).attr("data-mdb");
    
      let mdb = ( martha == 'null' || martha == undefined) ? 0 : martha;

        var bandera_anticipo = 0;


       // let resulq = await VerificarUsers(idLote,compartida,tipo_venta,lugar_prospeccionLote,mdb,ismktd);
       // console.log(resulq);

        if(parseFloat(totalNeto2) > 0){
          /*  if(resulq.data == 0){
                alerts.showNotification("top", "right", "Venta mal capturada", "warning");
            }
            else{*/
                console.log('datos de la consulta ');
                console.log(row.data);
             /*   let gerente = resulq.data[0].id_gerente;
                let asesor = resulq.data[0].id_asesor;
                let idCliente = resulq.data[0].id_cliente;
                let id_sede_cl = resulq.data[0].sede_cl;
                var fecha_inicio = new Date('2021-09-10');  
                var fecha_fin = new Date('2029-12-31'); 
                let VentaTipo = resulq.data[0].esquema;
                let vigencia=resulq.data[0].vigencia;

console.log(resulq.data[0].esquema);
console.log(resulq.data[0].vigencia);

                var fecha_fin_mktd = new Date('2022-01-19'); */
               // console.log('tipo venta:'+VentaTipo)
                $("#modal_NEODATA .modal-body").html("");
                $("#modal_NEODATA .modal-footer").html("");
                $.getJSON( url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
                    //  $("#modal_NEODATA .modal-header").html("");
    
                    console.log('NEO');
                    console.log(data[0]);
                    if(data.length > 0){
                        console.log('ENTRA AL LENGTH');
                        switch (data[0].Marca) {
                            case 0:
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
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

                                    // INICIO BONIFICACION *******************
                                    if(parseFloat(data[0].Bonificado) > 0){
                                        cadena = '<h5>Bonificación: <b style="color:#D84B16;">$'+formatMoney(data[0].Bonificado)+'</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="${parseFloat(data[0].Bonificado)}">`);
                                    }else{
                                        cadena = '<h5>Bonificación: <b>$'+formatMoney(0)+'</b></h4></div></div>';
                                        $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="0">`);
                                    }

                                    // FINAL BONIFICACION *********************************
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-12 text-center"><h3><i>${row.data().nombreLote}</i></h3></div></div><div class="row"><div class="col-md-3 p-0"><h5>Precio lote: <b>$${formatMoney(totalNeto2)}</b></h5></div><div class="col-md-3 p-0"><h5>Apl. neodata: <b style="color:${data[0].Aplicado <= 0 ? 'black' : 'blue'};">$${formatMoney(data[0].Aplicado)}</b></h5></div><div class="col-md-3 p-0"><h5>Disponible: <b style="color:green;">$${formatMoney(total0)}</b></h5></div><div class="col-md-3 p-0">${cadena}</div></div><br>`);

                                    // OPERACION PARA SACAR 5% ***
                                    first_validate = (totalNeto2 * 0.05).toFixed(3);
                                    new_validate = parseFloat(first_validate);
                                    console.log('OP 5%: '+new_validate);
                                    console.log('OP T: '+new_validate);




                                       if(total>(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)){

                                        console.log("SOLO DISPERSA LA MITAD*******");
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo </b> diponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        bandera_anticipo = 1;
                                    }
                                    else if((total<(new_validate-1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)){
                                        console.log("SOLO DISPERSA LO PROPORCIONAL*******");
                                        if( lugar_prospeccionLote == 28 || lugar_prospeccionLote == '28'){
                                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:red;"></i> Venta E-commerce <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        }
                                        bandera_anticipo = 0;
                                    }
                                    else if((  total>(new_validate-1) && total<(new_validate+1) && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)) || (id_estatus == 15)  ){
                                        console.log("SOLO DISPERSA 5% *******");
                                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo 5%</b> disponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');
                                        bandera_anticipo = 2;
                                    }




                                    // FIN BANDERA OPERACION PARA SACAR 5% ************
                                    $("#modal_NEODATA .modal-body").append(`<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>`);
                                    lugar = lugar_prospeccionLote;
                                    var_sum = 0;

                                    let abonado=0;
                                    let porcentaje_abono=0;
                                    let total_comision=0;

                                    $.getJSON( url + "Comisiones/porcentajesEspecial/"+idCliente).done( function( resultArr ){
                                        let parteAsesor=0;
                                        let parteGerente=0;
                                        let parteCoord=0;
                                        let resta=0;
                                     /*   if((tipo_venta == 7 || tipo_venta == 8) && data[0].Aplicado <= 10000){
                                            for (let j = resultArr.length-1; j >= 0 ;j--) {
                                                
                                                if(resultArr[j].id_rol == 7){
                                                    if(data[0].Aplicado > resultArr[j].comision_total){
                                                    parteAsesor= resultArr[j].comision_total;
                                                        resta = data[0].Aplicado - resultArr[j].comision_total;
                                                        if(resta > 500){
                                                            if(resultArr.length == 2){
                                                                parteGerente = resta;
                                                            }else if(resultArr.length == 3){
                                                                parteCoord=resta/2; 
                                                                parteGerente = resta/2;
                                                            }
                                                        }
                                                    }else{
                                                        parteAsesor=data[0].Aplicado;
                                                    }
                                                }
                                            }
                                        }*/
                                        
                                        $.each( resultArr, function( i, v){
                                            let porcentajeAse =  0;
                                            let total_comision1=0;
                                            total_comision1 = totalNeto2 * (porcentajeAse / 100);

                                            let saldo1 = 0;
                                            let total_vo = 0;
                                            total_vo = total;
                                            console.log('TOTAL COMISIÓN'+total_comision1)
                                            console.log('TOTAL_VO'+total_vo)
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
                                                console.log("entra a banderaa 1 "+bandera_anticipo);
                                                saldo1C = (saldo1/2);
                                            } else if(bandera_anticipo == 2){
                                                console.log("entra a banderaa 2 "+bandera_anticipo);
                                                saldo1C = (saldo1/2);
                                            } else{
                                                console.log("entra a banderaa 0 "+bandera_anticipo);
                                                saldo1C = saldo1;
                                            }
                                            total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                            abonado =parseFloat(abonado) +parseFloat(saldo1C);
                                            porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                            console.log('-----');
                                            console.log(saldo1C);

                                            $("#modal_NEODATA .modal-body").append(`<div class="row">
                                            <div class="col-md-3">
                                            <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}">
                                            <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.nombre}" style="font-size:12px;"><b><p style="font-size:12px;">${v.detail_rol}</p></b></div>
                                            <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" name="porcentaje[]" id="porcentaje_${i}" onchange="validarPorcentaje(${i}, ${resultArr.length})" onblur="Editar(${i},${totalNeto2},${v.id_usuario},${resultArr.length})" required  value="${v.porcentaje_decimal % 1 == 0 ? parseInt(v.porcentaje_decimal) : v.porcentaje_decimal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0]}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_total[]" id="comision_total_${i}" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_abonada[]" required readonly="true" value="${formatMoney(0)}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" name="comision_pendiente[]" id="comision_pendiente_${i}" required readonly="true" value="${formatMoney(v.comision_total)}"></div>
                                            <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required decimals" name="comision_dar[]"  data-old="" id="comision_dar_${i}" onblur="DarComision(${i},${resultArr.length},${total0})"   value="0"></div></div>`);
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
                                        
                                        $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
                                    
                                    });

    
                                }
                                else{
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
                                            /*for (let index = 0; index < data.length; index++) {
                                                const element = data[index].id_usuario;
                                                if(data[index].id_usuario == 5855){
                                                    contador +=1;
                                                }
                                            }*/

                                            $.each( data, function( i, v){
                                                saldo =0;
                                                /*if(tipo_venta == 7 && coor == 2){
                                                    total = total - data1[0].abonado;
                                                    console.log(total);

                                                    saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.925*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : ((12.5 *(v.porcentaje_decimal / 100)) * total);

                                                }
                                                else if(tipo_venta == 7 && coor == 3){
                                                    total = total - data1[0].abonado;
                                                    console.log(total);
                                                    saldo = tipo_venta == 7 && v.rol_generado == "3" ? (0.675*total) : tipo_venta == 7 && v.rol_generado == "7" ? (0.075*total) : tipo_venta == 7 && v.rol_generado == "9" ?  (0.25*total) :   ((12.5 *(v.porcentaje_decimal / 100)) * total);
                                                }
                                                else{*/
                                                    saldo =  ((10 *(v.porcentaje_decimal / 100)) * total);
                                               // }

                                                if(v.abono_pagado>0){
                                                    console.log("OPCION 1");
                                                    evaluar = (v.comision_total-v.abono_pagado);
                                                    if(evaluar<1){
                                                        pending = 0;
                                                        saldo = 0;
                                                    }
                                                    else{
                                                        pending = evaluar;
                                                    }

                                                    resta_1 = saldo-v.abono_pagado;
                                                    console.log('resta_1'+resta_1);

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
                                                    console.log("OPCION 2");
                                                    pending = (v.comision_total);
                                                    if(saldo > pending){
                                                        saldo = pending;
                                                    }
                                                    if(pending < 1){
                                                        saldo = 0;
                                                    }
                                                }
                                                saldo=0;

                                                $("#modal_NEODATA .modal-body").append(`<div class="row">
                                                <div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
                                                <input type="hidden" name="pending" id="pending" value="${pending}"><input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                <input id="rol" type="hidden" name="id_comision[]" value="${v.id_comision}"><input id="rol" type="hidden" name="rol[]" value="${v.id_usuario}">
                                                <input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="${v.colaborador}" style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">
                                                <b><p style="font-size:12px;${v.descuento == 1 ? 'color:red;' : ''}">${v.descuento != "1" ?  v.rol : v.rol +' Incorrecto' }</p></b></div>
                                                <div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" id="porcentaje_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${parseFloat(v.porcentaje_decimal)}%"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" id="comision_total_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.comision_total)}"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" id="pagado_${i}" required readonly="true" style="${v.descuento == 1 ? 'color:red;' : ''}" value="${formatMoney(v.abono_pagado)}"></div>
                                                <div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" id="pendiente_${i}" required readonly="true" value="${formatMoney(pending)}"></div>
                                                <div class="col-md-2"><input  class="form-control ng-invalid ng-invalid-required decimals" id="abono_nuevo_${i}" onblur="Abonar(${i},${data1[0].totalNeto2},${total0},${data.length});" name="abono_nuevo[]" value="${saldo}" type="text">
                                                </div></div>`);
                                                counts++
                                            });
                                        });

                                        $("#modal_NEODATA .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
                                        
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
          //  }   result
        } 
        else{
            alerts.showNotification("top", "right", "El lote no tiene precio asignado en inventario", "warning");
        }
    }
    }); //FIN VERIFY_NEODATA
    /**----------------------------------------------------------------------- */

});

function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }

/**-------------------------------FUNCIONES----------------------------- */
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
        /*console.log(i);
        console.log(precioLote);
        console.log(Neodata);*/
        console.log(len);
        let comision_actual = parseFloat(replaceAll($('#abono_nuevo_'+i).val(), ',',''));
        let pagado = parseFloat(replaceAll($('#pagado_'+i).val(), ',',''));
        let total_comision = parseFloat(replaceAll($('#comision_total_'+i).val(), ',',''));
        let abonado = 0;
        let comision_total=0;
        let disponible = 0;

        for (let m = 0; m < len; m++) {
            console.log($('#comision_total_'+m).val());
            console.log($('#pagado_'+m).val());
            console.log($('#abono_nuevo_'+m).val());
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

       

        console.log(comision_total);
        console.log(abonado);
        console.log(disponible);


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
/**--------------------------------------------------------------------- */
$("#form_NEODATA").submit( function(e) {
    $('#dispersar').prop('disabled', true);
    document.getElementById('dispersar').disabled = true;

    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + 'Comisiones/InsertNeo',
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
                    tabla_1.ajax.reload();
                    $("#modal_NEODATA").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
    document.getElementById('dispersar').disabled = false;

                }else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otra persona o es una recisión", "warning");
                    tabla_1.ajax.reload();
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


$("#form_pagadas").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
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
                    $('#spiner-loader').addClass('hidden');
                    $("#modal_pagadas").modal('toggle');
                    tabla_1.ajax.reload();
                    alert("¡Se agregó con éxito!");


                }else{
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    $('#spiner-loader').addClass('hidden');
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

$("#form_NEODATA2").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + 'Comisiones/InsertNeoCompartida',
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
                    tabla_1.ajax.reload();
                    alert("Dispersión guardada con exito.");
                    $("#modal_NEODATA2").modal( 'hide' ); 
                    function_totales();
                }else if (data == 2) {
                    alert("Ya disperso otra persona esta comision");
                    tabla_1.ajax.reload();
                    $("#modal_NEODATA2").modal( 'hide' ); 
                    function_totales();
                    $('#spiner-loader').addClass('hidden');
                }else{
                    $('#spiner-loader').addClass('hidden');
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function(){
                $('#spiner-loader').addClass('hidden');
                alert("ERROR EN EL SISTEMA");
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

    function myFunctionD2(){
        formatCurrency($('#inputEdit'));
    }
})

$('.decimals').on('input', function () {
    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});

function SoloNumeros(evt){
    if(window.event){
        keynum = evt.keyCode; 
    }
    else{
        keynum = evt.which;
    } 

    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
        return true;
    }
    else{
        alerts.showNotification("top", "left", "Solo Numeros.", "danger");
        return false;
    }
}

function function_totales(){
    $.getJSON( url + "Comisiones/getMontoDispersado").done( function( data ){
        $cadena = '<b>$'+formatMoney(data[0].monto)+'</b>';
        document.getElementById("monto_label").innerHTML = $cadena ;
    });
    $.getJSON( url + "Comisiones/getPagosDispersado").done( function( data ){
        $cadena01 = '<b>'+data[0].pagos+'</b>';
        document.getElementById("pagos_label").innerHTML = $cadena01 ;
    });
    $.getJSON( url + "Comisiones/getLotesDispersado").done( function( data ){
        $cadena02 = '<b>'+data[0].lotes+'</b>';
        document.getElementById("lotes_label").innerHTML = $cadena02 ;
    });  
}

$('#fecha1').change( function(){
    fecha1 = $(this).val(); 
    var fecha2 = $('#fecha2').val();
    if(fecha2 == ''){
        alerts.showNotification("top", "right", "Selecciona la segunda fecha", "info");
    }
    else{
        document.getElementById("fecha2").value = "";
    }
});

$('#fecha2').change( function(){  
    $("#myModal .modal-body").html('');
    var fecha2 = $(this).val();  
    var fecha1 = $('#fecha1').val();
    if(fecha1 == ''){
        alerts.showNotification("top", "right", "Selecciona la primer fecha", "info");
    }
    else{
        $.getJSON( url + "Comisiones/getMontoDispersadoDates/"+fecha1+'/'+fecha2).done( function( $datos ){
            $("#myModal .modal-body").append('<div class="row"><div class="col-md-12"><p class="category"><b>Monto</b>: <i><b>$'+formatMoney($datos['datos_monto'][0].monto)+'</b></i></p></div></div>');
            $("#myModal .modal-body").append('<div class="row"><div class="col-md-12"><p class="category"><b>Pagos</b>: <i><b>'+formatMoney($datos['datos_pagos'][0].pagos)+'</b></i></p></div></div>');
            $("#myModal .modal-body").append('<div class="row"><div class="col-md-12"><p class="category"><b>Lotes</b>: <i><b>'+formatMoney($datos['datos_lotes'][0].lotes)+'</b></i></p></div></div>');
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
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
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

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function formatCurrency(input, blur) {
    var input_val = input.val();
    if (input_val === "") { return; }
    var original_len = input_val.length;
    var caret_pos = input.prop("selectionStart");
    if (input_val.indexOf(".") >= 0) {
        var decimal_pos = input_val.indexOf(".");
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        left_side = formatNumber(left_side);
        right_side = formatNumber(right_side);
        if (blur === "blur") {
        right_side += "00";
        }
        right_side = right_side.substring(0, 2);
        input_val = left_side + "." + right_side;
    } else {
        input_val = formatNumber(input_val);
        input_val = input_val;
        if (blur === "blur") {
        input_val += ".00";
        }
    }
    input.val(input_val);
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}
