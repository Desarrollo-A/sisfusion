$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(1,0, finalBeginDate, finalEndDate);
});
sp = { // MJ: SELECT PICKER
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

let num_colum_encabezado = [];
let titulos_encabezado = [];
$('#cobranzaHistorial thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#cobranzaHistorial').DataTable().column(i).search() !== this.value) {
            $('#cobranzaHistorial').DataTable().column(i).search(this.value).draw();
        }
    });
    titulos_encabezado.push(title);
    num_colum_encabezado.push(i);
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});


function fillTable(idLote, bandera, beginDate, endDate ) {
    generalDataTable = $('#cobranzaHistorial').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip("destroy");
            $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                title: "COBRANZA MASTER V2",
                titleAttr: 'DESCARGAR ARCHIVO EXCEL',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            },
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (data) {
                    return data.id_pago_i;
                
                },
            },{
                data: function (data) {
                    return data.idLote;
                },
            },{
                data: function (data) {
                    return data.nombreLote;
                
                },
            },{
                data: function (data) {
                    return data.referencia;
                },
            },
            {
                data: function(data){
                    return data.precio_lote;
                }
            }, {
                data: function(data){
                    return data.comision_total;
                }
            },
            {
                data: function(data){
                    return data.pago_neodata;
                }
            }, 
            {
                data: function(data){
                let respuesta = '';
                if(data.fecha_apartado != null){
                    respuesta = data.fecha_apartado;
                }else{
                    respuesta = 'NO DEFINIDA'
                }
                    return respuesta;
                }
            }, 
            {
                data: function(data){
                    return data.idStatusContratacion;
                }
            }, {
                data: function (data){
                    labelStatus = '<span class="label" style="color:'+data.color+'; background:'+data.color+'18"> '+data.estatus_actual_comision+'</span>';
                    return labelStatus;
                }
            }, {
                data: function (d) {
                    var labelStatus;
                    if(d.rec == 8){
                            labelStatus = '<span class="label lbl-cerulean">RECISIÓN DE CONTRATO</span>';
                    }else{
                    switch (d.registroComision) {
                        case 0:
                        case '0':
                        case 2:
                        case '2':
                            labelStatus = '<span class="label lbl-oceanGreen">SIN DISPERSAR</span>';
                            break;
                        case 7:
                        case '7':
                            labelStatus = '<span class="label lbl-melon">LIQUIDADA</span>';
                            break;
                        case 8:
                        case '8':
                        case 88:
                        case '88':
                            labelStatus = '<span class="label lbl-cerulean">RECISIÓN DE CONTRATO</span>';
                            break;
                        case 1:
                        case '1':
                        default:
                            labelStatus = '<span class="label lbl-azure">ACTIVA</span>';
                            break;
                    }
                }
                    return labelStatus;
                }
            }, {
                data: function (data){
                    labelStatus = '<span class="label" style="color:#'+data.color_lote+'; background:#'+data.color_lote+'18"> '+data.estatus_lote+'</span>';
                    return labelStatus;
                    
                }
            },{
                data: function  (data){
                    return data.pago_cliente;
                }
            },{
                data: function (data){
                    return data.pagado;
                }
            },
            {
                data: function( data ){
                    labelStatus = '<p class="m-0">'+data.restantes+'</p>';
                    return labelStatus;
                }
            }, 
            {
                data: function (data ){
                    return data.user_names;
                }
            },
            {
                data: function (data ){
                    return  data.puesto;
                }
            }, 
            {
                data: function (data ){
                    let  respuesta = '' ; 
                    if(data.plaza != null){
                        respuesta = data.plaza;
                    }else if(data.plazaB != null) {
                        respuesta = data.plazaB;
                    }else{
                        respuesta = 'NO DEFINIDOS';
                    }
                    return respuesta;
                }
            }, {
                data: function (data ){
                    let respuesta ='';
                    let respuesta2 ='';
                    if(data.source != null && data.source != 0){
                        respuesta2 = "-  DRAGONCEM";
                    }else{
                        respuesta2 = ""
                    }
                    if(data.lugar_prospeccion != null){
                        respuesta  = data.lugar_prospeccion + respuesta2;
                    }else {
                        respuesta  = 'NO DEFINIDO';
                    }
                    return respuesta;
                }
            },
            {
                "data": function( data ){
                    var lblPenalizacion = '';
                    if (data.penalizacion == 1){
                        lblPenalizacion ='<p class="m-0" title="PENALIZACIÓN + 90 DÍAS"><span class="label lbl-orangeYellow">PENALIZACIÓN + 90 DÍAS</span></p>';
                    }
                    if(data.bonificacion >= 1){
                        p1 = '<p class="m-0" title="LOTE CON BONIFICACIÓN EN NEODATA"><span class="labe lbl-pink">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                    }
                    else{
                        p1 = '';
                    }
                    if(data.lugar_prospeccion  != null || data.lugar_prospeccion  == 0 ){
                        p2 = '<p class="m-0" title="LOTE CON CANCELACIÓN DE CONTRATO"><span class="label lbl-warning">Recisión </span></p>';
                    }
                    else{
                        p2 = '';
                    }
                    
                    return p1 + p2 + lblPenalizacion;
                }
            },
            {
                data: function (data){
                    let btns = '';
                    let btns2 = ''; 
                    if(data.rec == 8){
                        btns = '';
                    }
                    btns = '<button class="btn-data btn-green consultar_historys" data-idLote="' + data.idLote + '" data-registroComision="' + data.registroComision + '" id="verifyNeodataStatus" data-toggle="tooltip" data-placement="top" title="VER MÁS"></body><i class="fas fa-money-bill-wave" ></i></button>';
                    btns2 += '<button value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'"  class="btn-data btn-blueMaderas m-auto consultar_history " data-toggle="tooltip" data-placement="top" title="DETALLES">' +'<i class="fas fa-info"></i></button>';
                    return '<div class="d-flex">'+btns+btns2 +'</div>';  
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'informationMasterCobranzaHistorial',
            type: "POST",
            cache: false,
            data: {
                "idLote": idLote,
                "beginDate": beginDate,
                "endDate": endDate,
                "bandera": bandera,
            }
        }
    });
    $('#cobranzaHistorial').removeClass('hide');

    $("#cobranzaHistorial tbody").off('click', '.consultar_history').on('click', '.consultar_history', function () {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
        var clearTitle = document.getElementById('nameLote');
        clearTitle.innerHTML = '';
        $("#comments-list-asimilados").append('');
        $("#nameLote").append();
        $("#seeInformationModalAsimilados").modal();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#nameLote").append('<h5>HISTORIAL DEL PAGO DE <b>'+lote+'</b></h5>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento.split('.')[0]+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' +v.nombre_usuario+ '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });
    
    $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("Comisiones/getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><b>' + v.comentario + '</b></a><br></div><div class="float-end text-right"><a>'+v.fecha_movimiento.split('.')[0]+'</a></div><div class="col-md-12"><p class="m-0"><small>MODIFICADO POR: </small><b> ' +v.nombre_usuario+ '</b></p></div><h6></h6></div></div></li>');
            });
        });
    });
    
    $("#cobranzaHistorial tbody").on("click", "#verifyNeodataStatus", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let tr = $(this).closest('tr');
        let row = $("#cobranzaHistorial").DataTable().row(tr);
        let idLote = $(this).attr("data-idLote");
        let registro_status = $(this).attr("data-registroComision");
        let cadena = '';
        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");
        $.getJSON("./../ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {
            if (data.length > 0) {
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 1:
                        if (registro_status == 0 || registro_status == 8) { //COMISION NUEVA
                            console.log('entra 509');
                            let total0 = parseFloat(data[0].Aplicado);
                            let total = 0;
                            if (total0 > 0) {
                                total = total0;
                            } else {
                                total = 0;
                            }
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4>Monto registrado: <b>$' + formatMoney(data[0].Aplicado) + '</b></h4></div></div>');
                            if (parseFloat(data[0].Bonificado) > 0) {
                                cadena = '<h4>Bonificación: <b style="color:#D84B16;">$' + formatMoney(data[0].Bonificado) + '</b></h4></div></div>';
                                $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="${parseFloat(data[0].Bonificado)}">`);
                            } else {
                                cadena = '<h4>Bonificación: <b>$' + formatMoney(0) + '</b></h4></div></div>';
                                $("#modal_NEODATA .modal-body").append(`<input type="hidden" name="bonificacion" id="bonificacion" value="0">`);
                            }
                        } else if (registro_status == 1) {
                            console.log('entra 526');
                            $.getJSON("./../Comisiones/getDatosAbonadoSuma11/" + idLote).done(function (data1) {
                                let total0 = parseFloat((data[0].Aplicado));
                                let total = 0;
                                if (total0 > 0) {
                                    total = total0;
                                } else {
                                    total = 0;
                                }
                                var counts = 0;
                                if (parseFloat(data[0].Bonificado) > 0) {
                                    cadena = '<h4>Bonificación: <b style="color:#D84B16;">$' + formatMoney(data[0].Bonificado) + '</b></h4>';
                                } else {
                                    cadena = '<h4>Bonificación: <b >$' + formatMoney(0) + '</b></h4>';
                                }
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-6" style="text-align: center;"><h4>Monto registrado: <b>$' + formatMoney(data[0].Aplicado) + '</b></h4></div><div class="col-md-6">' + cadena + '</div></div>');
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para dispersar de <i>' + row.data().nombreLote + '</i>: <b>$' + formatMoney(total0 - (data1[0].abonado)) + '</b></h3></div></div><br>');
                            });
                        }
                        break;
                    case 2:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 3:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No tiene vivienda, sí hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 4:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 5:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                }
            } else {
                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + general_base_url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
        });
        $("#modal_NEODATA").modal();
    });
}

$(document).on("click", "#searchByLote", function () {
    let idLote = $("#idLote").val();
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let bandera = 1 ;
    if (idLote == ''){
        alerts.showNotification("top", "right", "Oops, faltan valores para consultar.", "warning");
    }else {
        fillTable(idLote,bandera, finalBeginDate, finalEndDate);
    }
});

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let bandera = 2;
    let lote = 0;
    if (finalBeginDate == '' || finalBeginDate == '')
    {
        alerts.showNotification("top", "right", "Oops, faltan valores para consultar.", "warning");
    }else{
        fillTable(lote ,bandera, finalBeginDate, finalEndDate);
    }
});

$(document).on("click", ".reset-initial-values", function () {
    $(".idLote").val('');
    $(".textoshead").val('');
    $("#beginDate").val('01/10/2022');
    $("#endDate").val('31/10/2022');
});
$(document).on('click', '#requestCommissionPayment', function () {
    let idLote = $(this).attr("data-idLote");
    $("#idLote").val(idLote);
    $("#modalConfirmRequest").modal();
});
$(document).on('click', '#sendRequestCommissionPayment', function () {
    let idLote = $("#idLote").val();
    $.ajax({
        type: 'POST',
        url: 'sendRequestPayment',
        data: {
            'idLote': idLote
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                $("#modalConfirmRequest").modal("hide");
                alerts.showNotification("top", "right", "El registro ha sido actualizado de manera éxitosa.", "success");
                $("#masterCobranzaTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function cleanCommentsAsimilados() {
    var myCommentsList = document.getElementById('comments-list-asimilados');
    var myCommentsLote = document.getElementById('nameLote');
    myCommentsList.innerHTML = '';
    myCommentsLote.innerHTML = '';
}