$(document).ready(function () {
//  dani le quite este pedazo de codigo 

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
                    $('#tabla_dispersion_casas').DataTable().ajax.reload();
                    $("#modal_NEODATA_Casas").modal( 'hide' );
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
                    $('#tabla_dispersion_casas').DataTable().ajax.reload();
                    $("#modal_NEODATA_Casas").modal( 'hide' );
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
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});



// Cambiar tabla

let titulos_intxt = [];

$('#tabla_dispersion_casas thead tr:eq(0) th').each(function (i) {
    $(this).css('text-align', 'center');
    var title = $(this).text();
    titulos_intxt.push(title);
    if (i != 0 ) {
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_dispersion_casas').DataTable().column(i).search() !== this.value ) {
                $('#tabla_dispersion_casas').DataTable().column(i).search(this.value).draw();
            }
            var index = $('#tabla_dispersion_casas').DataTable().rows({
            selected: true,
            search: 'applied'
            }).indexes();
            var data = $('#tabla_dispersion_casas').DataTable().rows(index).data();
        });
    }
});
tableDispersionCasas = $('#tabla_dispersion_casas').dataTable({
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
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15,16],
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
            nombreLote = d.nombreLote;
            return nombreLote;
        }},
        {data: 'idLote'},
        {data: 'nombreCliente'},
        { data: function (d) {
                return `<span class="label ${d.claseTipo_venta}">${d.tipo_venta}</span>`;
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
                labelEstatus =`<label class="label lbl-azure btn-dataTable" data-toggle="tooltip"  data-placement="top"  title="VER MÁS DETALLES"><b><span  onclick="showDetailModal(${d.plan_comision_c})" style="cursor: pointer;">${d.plan_descripcion}</span></label>`;
            return labelEstatus;
        }},
        { data: function (d) {
            return formatMoney(d.costoTotalConstruccion);
        }},
        { data: function (d) {
            return d.Comision_total ? `${parseFloat(d.Comision_total)}%`: 'SIN ESPECIFICAR';
        }},
        { data: function (d) {
            return formatMoney(d.Comisiones_Pagadas);
        }},
        { data: function (d) {
            return formatMoney(d.Comisiones_pendientes);
        }},
        { data: function (d) {
            var rescisionLote;
            var reactivo;
            rescisionLote = '';
            reactivo = '';
            

                 reactivo = '<br><span class="label lbl-gray">DISPERSIÓN CASAS</span>';
                
            
            return reactivo;
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

            var Mensaje = 'Verificar en NEODATA';
            varColor2  = 'btn-gray';
            var RegresaActiva = '';

            if(d.fecha_sistema != null && d.registroComision != 8 && d.registroComision != 0) {
                RegresaActiva = '<button href="#" data-idpagoc="' + d.idLote + '" data-nombreLote="' + d.nombreLote + '"  ' +'class="btn-data btn-violetChin update_bandera" data-toggle="tooltip" data-placement="top" title="Enviar a activas">' +'<i class="fas fa-undo-alt"></i></button>';
            }

            
                if(d.compartida==null) {
                    varColor  = 'btn-sky';
                } else{
                    varColor  = 'btn-green';
                }
                    disparador = 0;
                    var precioDestino = d.costoTotalConstruccion;
                   
                        disparador = d.registroComisionCasas == 1 ? 0 : 1;
                        totalLote = d.costoTotalConstruccion;
                        reubicadas = 0;
                        nombreLote = d.nombreLote;
                        id_cliente = d.id_cliente;
                        plan_comision = d.plan_comision_c;
                        descripcion_plan = d.plan_descripcion;
                        ooamDispersion = 0; //VENTAS SIN REESTRUCTURA
                        nombreOtro = '';

                     
                
                        BtnStats += `<button href="#" 
                        value = "${d.idLote}" 
                        data-totalNeto2 = "${totalLote}"
                        data-total8P = "${d.total8P}"
                        data-precioDestino= "${precioDestino}"
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
                        data-procesoReestructura = "${d.proceso}"
                        data-code = "${d.cbbtton}"
                        data-opcionMensualidad = "${d.opcionMensualidad}"
                        data-nombreMensualidad = "${d.nombreMensualidad}"
                        data-abonadoCliente ="${d.montoDepositado}"
                        data-esquemaCreditoCasas=${d.esquemaCreditoCasas}"
                        class = "btn-data ${varColor} verify_neodataCasas" data-prioridad="${d.prioridadComision}" data-toggle="tooltip"  data-placement="top" title="${ Mensaje }"><span class="material-icons">verified_user</span></button> ${RegresaActiva}`;
                        
                        let colorPrioridad = d.prioridadComision == 1 ? 'btn-warning' : 'btn-blueMaderas' ;
                        BtnStats += `<button href="#" value="${d.idLote}" data-prioridad="${d.prioridadComision}" data-idCliente="${id_cliente}" data-nombreLote="${d.nombreLote}" class="btn-data ${colorPrioridad} btn-prioridad" data-toggle="tooltip"  data-placement="top" title="Prioridad"> <i class="material-icons">group</i></button>`;
                        //BtnStats += `<button href="#" value="${d.idLote}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas btn-detener btn-warning" data-toggle="tooltip"  data-placement="top" title="Detener"> <i class="material-icons">block</i> </button>`;
                    
            
            return '<div class="d-flex justify-center">'+BtnStats+'</div>';
        }}
    ],
    columnDefs: [{
        visible: false,
        searchable: false
    }],
    ajax: {
        url: general_base_url+'Casas_Comisiones/getDataDispersionPago',
        type: "POST",
        cache: false,
        data: function( d ){}
    }
    
});

$('#tabla_dispersion_casas').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
$("#tabla_dispersion_casas tbody").on("click", ".btn-prioridad", async function(){
    nombreLote = $(this).attr("data-nombreLote");
    prioridad = $(this).attr("data-prioridad");
    idCliente = $(this).attr("data-idCliente");

    $("#modalPrioridad .modal-header").html("");
    $("#modalPrioridad .modal-body").html("");

    let condicionFrase = prioridad == 1 ?  'cancelar' : 'cambiar';

    $("#modalPrioridad .modal-header").append(`
        <h4 class="modal-title">
            ¿Estas seguro ${condicionFrase} la priodad para el asesor y gerente de <b>${nombreLote}</b>?
        </h4>
        <input type="hidden" name="priridadActual" id="priridadActual">
        <input type="hidden" name="idClienteCasas" id="idClienteCasas">`);
    $('#priridadActual').val(prioridad);
    $('#idClienteCasas').val(idCliente);
    $("#modalPrioridad").modal();
});

$("#formPrioridad").submit( function(e) {
    $('#btnSubmit').prop('disabled', true);
    document.getElementById('btnSubmit').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Casas_comisiones/changePrioridad',
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
                    alerts.showNotification("top", "right", "La petición se ha realizado con éxito", "success");
                    $('#tabla_dispersion_casas').DataTable().ajax.reload();
                    $("#modalPrioridad").modal( 'hide' );
                    $('#btnSubmit').prop('disabled', false);
                    document.getElementById('btnSubmit').disabled = false;
                } else if (data == 2) {
                    $('#spiner-loader').addClass('hidden');
                    alerts.showNotification("top", "right", "Ya se dispersó por otro usuario", "warning");
                    $('#tabla_dispersar_comisiones').DataTable().ajax.reload();
                    $("#modal_NEODATA_Casas").modal( 'hide' );
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
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});

function operacionValidarFun(porcentajeAbonado,cuantosAsesores,cuantosCoor,id_rol,total,pivoteNuevas){

    let nuevoPorcentaje = 0;
    if(porcentajeAbonado < 2){ //ATICIPO MENOR AL 1%
        let porcentajeRestante = 100;
            if([7,3].indexOf(parseInt(id_rol)) >= 0){
                console.log('porcentaje restante'+porcentajeRestante);
                nuevoPorcentaje = id_rol == 7 ? (8 * (((porcentajeRestante / 4) * 3)  / cuantosAsesores) /100): (8 *((porcentajeRestante / 4)  / cuantosCoor) /100);
                console.log('nuevo porcentaje ' + nuevoPorcentaje)
            }else{
                nuevoPorcentaje = 0;
            }
       
    }else if(porcentajeAbonado >= 2 && porcentajeAbonado < 5){ // ABONADO ENTRE EL 5 Y EL 2%
        let porcentajeRestante = 100;
            if([7,3].indexOf(parseInt(id_rol)) >= 0){
                nuevoPorcentaje = id_rol == 7 ? (8 * (((porcentajeRestante / 7) * 2)  / cuantosAsesores) /100): (8 *((porcentajeRestante / 7)  / cuantosCoor) /100);
            }else{
                nuevoPorcentaje = (8 * (porcentajeRestante / 7)  /100);
            }
    }
    operacionValidar = (total*(pivoteNuevas*nuevoPorcentaje));
   return operacionValidar;

}

$("#tabla_dispersion_casas tbody").on("click", ".verify_neodataCasas", async function(){

        
    $("#modal_NEODATA_Casas .modal-header").html("");
    $("#modal_NEODATA_Casas .modal-body").html("");
    $("#modal_NEODATA_Casas .modal-footer").html("");
    var tr = $(this).closest('tr');
    var row = $('#tabla_dispersion_casas').DataTable().row(tr);
    let cadena = '';

    idLote = $(this).val();
    totalNeto2 = $(this).attr("data-totalNeto2");
    totalNeto2Cl = $(this).attr("data-totalNeto2Cl");
    penalizacion = $(this).attr("data-penalizacion");
    nombreLote = $(this).attr("data-nombreLote");
    bandera_penalizacion = $(this).attr("data-banderaPenalizacion");
    idCliente = $(this).attr("data-cliente");
    plan_comision = $(this).attr("data-plan");
    disparador = $(this).attr("data-disparador");
    tipo_venta = $(this).attr("data-tipov");
    descripcion_plan = $(this).attr("data-descplan");
    nombreOtro = $(this).attr("data-nombreOtro");
    estatusLote = $(this).attr("data-estatusLote");    
    prioridadDispersion = $(this).attr("data-prioridad");
    abonadoCliente = $(this).attr("data-abonadoCliente");
    esquemaCreditoCasas = $(this).attr("data-esquemaCreditoCasas");
    //disparador = 1;
    precioDestino = $(this).attr("data-precioDestino");
    if(parseFloat(totalNeto2) > 0){

        $("#modal_NEODATA_Casas .modal-body").html("");
        $("#modal_NEODATA_Casas .modal-footer").html("");
        $.getJSON( general_base_url + "ComisionesNeo/getStatusNeodata/"+idLote).done( function( data ){
            var AplicadoGlobal = data.length > 0 ? data[0].Aplicado : 0;
            
            if(data.length > 0){
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div></div>');
                    break;
                    case 1:
                        if((disparador == 1)){
                            //COMISION NUEVA
                            let total0 = esquemaCreditoCasas == 2 ? parseFloat(data[0].Aplicado) : abonadoCliente;
                            let total = 0;
                            if(total0 > 0){
                                total = total;
                            }else{
                                total = 0;
                            }
                            bonificadoTotal = 0;

                            if(parseFloat(data[0].Bonificado) > 0){
                                bonificadoTotal = data[0].Bonificado;
                            }
                            var porcentajeAbonado = ((total * 100) / totalNeto2);                            
                                cadena = 
                                `<div class="col-12">
                                    <h5>Bonificación: <b style="color:#D84B16;">${formatMoney(bonificadoTotal)}</b></h5>
                                </div>
                                `;
                            
                            // FINAL BONIFICACION y PLAN 66
                            let labelPenalizacion = '';
                            if(penalizacion == 1){labelPenalizacion = ' <b style = "color:orange">(Penalización + 90 días)</b>';}
                            $("#modal_NEODATA_Casas .modal-body").append(`
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

                                        <div class="col-md-3 p-0">
                                            <h5>Pagado: <b style="color:'black;"></b></h5>
                                        </div>

                                        <div class="col-md-3 p-0">
                                            <h5>Disponible: <b style="color:green;">${formatMoney(total0)}</b></h5>
                                        </div>
                                                ${cadena}
                                    </div>`);

                                    
                            // OPERACION PARA SACAR 5% y 8%
                            operacionA = (totalNeto2 * 0.05).toFixed(3);
                            operacionB = (totalNeto2 * 0.08).toFixed(3);
                            cincoporciento = parseFloat(operacionA);
                            ochoporciento = parseFloat(operacionB);

                            if(total<(cincoporciento-1) && (disparador != 3)){
                            // *********Si el monto es menor al 5% se dispersará solo lo proporcional
                            console.log('Si el monto es menor al 5% ');
                            $("#modal_NEODATA_Casas .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo menor al 5%</b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                bandera_anticipo = 0;
                            }else if(total>=(ochoporciento) && (disparador != 3) ){
                            // *********Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% / se dispersa la mitad
                            console.log('Si el monto el igual o mayor a 8% se dispensará lo proporcional al 12.5% ');
                                $("#modal_NEODATA_Casas .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo mayor/igual al 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`); 
                                bandera_anticipo = 1;
                            } else if(total>=(cincoporciento-1) && total<(ochoporciento) && (disparador != 3 ) ){
                                console.log('Si el monto el igual o mayor a 5% y menor al 8% ');
                            // *********Si el monto el igual o mayor a 5% y menor al 8% se dispersará la 4° parte de la comisión
                                $("#modal_NEODATA_Casas .modal-body").append(`<div class="row mb-1"><div class="col-md-6"><h5><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;">Anticipo entre 5% - 8% </b></h5></div><div class="col-md-6"><h5>Plan de venta <i>${descripcion_plan}</i></h5></div></div>`);
                                bandera_anticipo = 2;
                            } 

                            // FIN BANDERA OPERACION PARA SACAR 5%
                            $("#modal_NEODATA_Casas .modal-body").append(`<div class="row rowTitulos">
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

                            $.post(general_base_url + "Casas_comisiones/porcentajes",{idCliente:idCliente,totalNeto2:totalNeto2,plan_comision:plan_comision}, function (resultArr) {
                                resultArr = JSON.parse(resultArr);
                                let numComisionistas = resultArr.length;        
                                const busquedaPivote = pivoteMultiplicador.find((planes) => planes.id_plan == parseInt(plan_comision));
                                let pivoteNuevas = busquedaPivote == undefined ? 0.125 : (busquedaPivote.valor / 100);    
                                var cuantosAsesores = 0;
                                    var cuantosCoor = 0;
                                    $.each( resultArr, function( i, v){
                                        if(v.id_rol == 7){
                                            cuantosAsesores = cuantosAsesores + 1; 
                                        }if(v.id_rol == 3){
                                            cuantosCoor = cuantosCoor + 1; 
                                        }
                                    });

                                $.each( resultArr, function( i, v){
                                    let porcentajes = '';
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
                                
                                    switch(bandera_anticipo){
                                        case 0:// monto < 5% se dispersará solo lo proporcional
                                        
                                             operacionValidar = prioridadDispersion == 1 ? operacionValidarFun(porcentajeAbonado,cuantosAsesores,cuantosCoor,v.id_rol,total,pivoteNuevas) : (total*(pivoteNuevas*v.porcentaje_decimal));
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                        break;
                                            case 1:// monto igual o mayor a 8% dispersar 12.5% / la mitad
                                            operacionValidar = (total_comision1 / 2);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                        break;
                                        case 2: // monto entre 5% y 8% dispersar 4 parte
                                            operacionValidar =  (total_comision1 / 2);
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                        break;
                                        case 3: // monto OOAM 50%
                                            operacionValidar = (total*(pivoteNuevas*v.porcentaje_decimal));
                                            if(operacionValidar > (v.comision_total/2)){
                                                saldo1C = (v.comision_total/2);
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                        break;
                                        case 4: // monto OOAM 100%
                                            operacionValidar = (total*(pivoteNuevas*v.porcentaje_decimal));
                                            if(operacionValidar > v.comision_total){
                                                saldo1C = v.comision_total;
                                            }else{
                                                saldo1C = operacionValidar;
                                            }
                                        break;
                                    }

                                    total_comision = parseFloat(total_comision) + parseFloat(v.comision_total);
                                    abonado = parseFloat(abonado) + parseFloat(saldo1C);
                                    porcentaje_abono = parseFloat(porcentaje_abono) + parseFloat(v.porcentaje_decimal);
                                            $("#modal_NEODATA_Casas .modal-body").append(`
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label id="" class="control-label labelNombre hide">Usuarios</label>
                                                        <input id="id_usuario" type="hidden" name="id_usuario[]" value="${v.id_usuario}"><input id="id_rol" type="hidden" name="id_rol[]" value="${v.id_rol}">
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
                                                $("#modal_NEODATA_Casas .modal-body").append(`
                                                <input type="hidden" name="pago_neo" id="pago_neo" value="${data[0].Aplicado}">
                                                <input type="hidden" name="idLote" id="idLote" value="${idLote}">
                                                <input type="hidden" name="porcentaje_abono" id="porcentaje_abono" value="${porcentaje_abono}">
                                                <input type="hidden" name="abonado" id="abonado" value="${abonado}">
                                                <input type="hidden" name="total_comision" id="total_comision" value="${total_comision}">
                                                <input type="hidden" name="plan_c" id="plan_c" value="${plan_comision}">
                                                <input type="hidden" name="pendiente" id="pendiente" value="${total_comision-abonado}">
                                                <input type="hidden" name="idCliente" id="idCliente" value="${idCliente}">
                                                <input type="hidden" name="id_disparador" id="id_disparador" value="${disparador}">
                                                <input type="hidden" name="numComisionista" id="numComisionista" value="${numComisionistas}">
                                                <input type="hidden" name="totalNeto2" id="totalNeto2" value="${totalNeto2}">
                                                <input type="hidden" name="nombreOtro" id="nombreOtro" value="${nombreOtro}">
                                                `);
                                            }
                                });
                                responsive(maxWidth);
                                $("#modal_NEODATA_Casas .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersarCasas" value="Dispersar"></div>');
                            });
                        }
                        else{
                            $.getJSON( general_base_url + "Casas_comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
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
                                $("#modal_NEODATA_Casas .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${row.data().nombreLote}</i>: <b>${formatMoney(total0)}</b><br>${labelPenalizacion}</h3></div></div><br>`);
                                $("#modal_NEODATA_Casas .modal-body").append(`
                                    <div class="row">
                                        <div class="col-md-4 pl-4">Total pago: <b style="color:blue">${formatMoney(data1[0].total_comision)}</b></div>
                                        <div class="col-md-4">Total abonado: <b style="color:green"></b></div>
                                        <div class="col-md-4">Total pendiente: <b style="color:orange">${formatMoney((data1[0].total_comision)-(data1[0].abonado))}</b></div>
                                    </div>
                                    

                                `);
                                if(parseFloat(data[0].Bonificado) > 0){
                                    cadena = `<h4>Bonificación: <b style="color:#D84B16;">$${formatMoney(data[0].Bonificado)}</b></h4>`;
                                }else{
                                    cadena = `<h4>Bonificación: <b >${formatMoney(0)}</b></h4>`;
                                }
                                $("#modal_NEODATA_Casas .modal-body").append(`<div class="row"><div class="col-md-4"><h4><b>Precio lote: ${formatMoney(data1[0].totalNeto2)}</b></h4></div>
                                <div class="col-md-4"><h4>Aplicado neodata: <b>${formatMoney(data[0].Aplicado)}</b></h4></div><div class="col-md-4">${cadena}</div>
                                </div><br>`);

                                $.getJSON( general_base_url + "Casas_comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                                    $("#modal_NEODATA_Casas .modal-body").append(`
                                                    <div class="row">
                                                        <div class="col-md-3"><p style="font-size:10px;"><b>USUARIOS</b></p></div>
                                                        <div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div>
                                                        <div class="col-md-2"><b><b>ABONADO</b></div>
                                                        <div class="col-md-2"><b>PENDIENTE</b></div>
                                                        <div class="col-md-2"><b>DISPONIBLE</b></div>
                                                    </div>`);

                                    $.each( data, function( i, v){
                                        saldo =0;
                                        const busquedaPivote = pivoteMultiplicador.find((planes) => planes.id_plan == parseInt(plan_comision));
                                        let pivote = busquedaPivote == undefined ? 12.5 : busquedaPivote.valor;
                                        saldo =  ((pivote *(v.porcentaje_decimal / 100)) * total);
                                        if(parseFloat(v.abono_pagado) > 0){
                                            evaluar = (parseFloat(v.comision_total)- parseFloat(v.abono_pagado));
                                            if(parseFloat(evaluar) < 0){
                                                pending=evaluar;
                                                saldo = 0;
                                            }
                                            else{
                                                pending = evaluar;
                                            }
                                            resta_1 = ( saldo-v.abono_pagado );
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
                                        $("#modal_NEODATA_Casas .modal-body").append(`<div class="row">
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
                                $("#modal_NEODATA_Casas .modal-footer").append('<div class="row"><input type="button" class="btn btn-danger btn-simple" data-dismiss="modal" value="CANCELAR"><input type="submit" class="btn btn-primary mr-2" name="disper_btn"  id="dispersar" value="Dispersar"></div>');
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
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 3:
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 4:
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case 5:
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Aviso.</b></h4><br><h5>Sistema en mantenimiento: .</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                }
            }
            else{
                //QUERY SIN RESULTADOS
                $("#modal_NEODATA_Casas .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+general_base_url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
        }); //FIN getStatusNeodata

        $("#modal_NEODATA_Casas").modal();
    }else{
        alerts.showNotification("top", "right", "El registro no tiene costo asignado.", "warning");
    }
}); //FIN VERIFY_NEODATA

$("#form_NEODATA_Casas").submit( function(e) {
    $('#dispersar').prop('disabled', true);
    document.getElementById('dispersarCasas').disabled = true;
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#spiner-loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: general_base_url + 'Casas_comisiones/InsertNeo',
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
                    $("#modal_NEODATA_Casas").modal( 'hide' );
                    function_totales();
                    $('#dispersar').prop('disabled', false);
                    document.getElementById('dispersar').disabled = false;
                    $.ajax({
                        url: general_base_url + 'Casas_comisiones/ultimaDispersion',
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
                    $("#modal_NEODATA_Casas").modal( 'hide' );
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
                alerts.showNotification("top", "right", "EL LOTE NO SE PUEDE DISPERSAR, INTÉNTALO MÁS TARDE", "warning");
            }
        });
    }
});


var maxWidth = window.matchMedia("(max-width: 992px)");
responsive(maxWidth);
maxWidth.addListener(responsive);





