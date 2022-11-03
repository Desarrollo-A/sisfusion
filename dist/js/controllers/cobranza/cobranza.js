var url = "<?=base_url()?>";
$(document).ready(function () {

  
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
      

        const fechaFin = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);

    
        $("#beginDate").val('01/10/2022');
      
        $("#endDate").val('01/10/2022');
      
    /*
    fillTable(typeTransaction, beginDate, endDate, where) PARAMS;
        typeTransaction:
            1 = ES LA PRIMERA VEZ QUE SE LLENA LA TABLA O NO SE SELECCIONÓ UN RANGO DE FECHA (MUESTRA LO DEL AÑO ACTUAL)
            2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL ID DE LOTE INGRESADO)
            3 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
        beginDate
            FECHA INICIO
        endDate
            FECHA FIN
        where
            ID LOTE (WHEN typeTransaction VALUE IS 2 WE SEND ID LOTE VALUE)
    */
        //    fillTable();
    setInitialValues();
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
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

$('#cobranzaHistorial thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    if ( i != 20 ){
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#cobranzaHistorial").DataTable().column(i).search() !== this.value) {
                $("#cobranzaHistorial").DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
});

function fillTable(idLote, beginDate, endDate, bandera ) {

     let encabezado = (document.querySelector('#cobranzaHistorial .encabezado .textoshead').placeholder).toUpperCase();
    generalDataTable = $('#cobranzaHistorial').dataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ,5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16,17,18],
                    format: {
                        header: function ( data , columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'ID PAGO';
                                    break;
                                case 1:
                                    return 'ID LOTE';
                                    break;
                                case 2:
                                    return 'LOTE';
                                    break;
                                case 3 :
                                    return 'REFERENCIA LOTE';
                                    break;   
                                 case 4 :
                                    return 'PRECIO LOTE';
                                    break;
                                 case 5 : 
                                    return 'Total comisión';
                                    break;
                                case 6 : 
                                    return 'Total comisión';
                                    break;
                                case 7 :
                                    return 'Fecha de apartado';
                                    break;  
                                case 8 :
                                    return 'Estatus contratacion';
                                break; 
                                case 9 :
                                    return 'Estatus comision';
                                    break;
                                case 10 :
                                    return 'Estatus venta';
                                    break;
                                case 11: 
                                    return 'Pago mes';
                                    break;
                                case 12:
                                    return 'Dispersado del mes';
                                    break;
                                case 13:
                                    return 'Pago historico';
                                    break;
                                case 14:
                                    return 'Pendiente';
                                    break;
                                case 15 :
                                    return 'Usuario';
                                    break;
                                case 16 :
                                    return ' Puesto';
                                    break;
                                case 17 :
                                    return 'Plaza';
                                    break;
                                case 18: 
                                    return 'Lugar de prospección';
                                    break;
                                case 19: 
                                    return 'Lugar de prospección';
                                    break;
                                case 20: 
                                    return 'Lugar de prospección';
                                    break;
                            }
                            
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
            url: "./..//static/spanishLoader_v2.json",
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
                        // id de pago
                    return data.id_pago_i;
                
                },
            },{
                data: function (data) {
                //1 // id lote
                    return data.idLote;
                
                },
            },{
                data: function (data) {
                //2//lote
                    return data.nombreLote;
                
                },
            },{
                data: function (data) {
                ///3/ referencia
                    return data.referencia;
                
                },
            },
            {
                data: function(data){
                    return data.precio_lote;
                //4// id de pago
                }
            }, {
                data: function(data){
                    return data.allComision;
                //5//5
                }
            },
            {
                data: function(data){
                    return data.pago_neodata;
         //6
                }
            }, 
            {
                data: function(data){
                let respuesta = '';
                 if(data.fecha_apartado != null){
                    respuesta = data.fecha_apartado;
                 }else{
                    respuesta = 'No definida'
                 }
                    return respuesta;
         //7
                }
            }, 
        //     {
        //         data: function(data){
        //             return data.fecha_abono;
        //  //8
        //         }
        //     },

            {
                data: function(data){
            //8
                    return data.idStatusContratacion;
                }
            }, {
                data: function (data){
             //9//estatus comision
                    labelStatus = '<span class="label" style="background:'+data.color+';"> '+data.estatus_actual_comision+'</span>';
                    return labelStatus;
                  
                }
            }, {
                //10
                data: function (d) {
                    var labelStatus;
                    if(d.rec == 8){
                            labelStatus = '<span class="label" style="background:#3498DB;">RECISIÓN DE CONTRATO</span>';
                    }else{

                    switch (d.registroComision) {
                        case 0:
                        case '0':
                        case 2:
                        case '2':
                            labelStatus = '<span class="label" style="background:#27AE60;">SIN DISPERSAR</span>';
                            break;
                        case 7:
                        case '7':
                            labelStatus = '<span class="label" style="background:#CD6155;">LIQUIDADA</span>';
                            break;
                        case 8:
                        case '8':
                        case 88:
                        case '88':
                            labelStatus = '<span class="label" style="background:#3498DB;">RECISIÓN DE CONTRATO</span>';
                            break;
                        case 1:
                        case '1':
                        default:
                            labelStatus = '<span class="label" style="background:#AE2798FF;">ACTIVA</span>';
                            break;
                    }
                }
                    return labelStatus;
                }
            }, {
                data: function (data){
                //11
                    labelStatus = '<span class="label" style="background:#'+data.color_lote+';"> '+data.estatus_lote+'</span>';
                    return labelStatus;
                    
                }
            },{
                //12
                data: function  (data){
                    return data.pago_cliente;
                }
            },{
                //13
                data: function (data){
                    return data.pagado;
                }
            },
            {
                //14
                data: function( data ){
                    if(data.restante==null||data.restante==''){
                        return '<p class="m-0">$'+formatMoney(data.comision_total)+'</p>';
                    }
                    else{
                        return '<p class="m-0">$'+formatMoney(data.restante)+'</p>';
                    }
                }

            }, 
            {
                data: function (data ){
                    return data.user_names;
                //15
                }
            },
            {
                data: function (data ){
                    return  data.puesto;
                //16
                }
            }, {
                data: function (data ){
                    let  respuesta = '' ; 
                    if(data.plaza != null){
                        respuesta = data.plaza;
                    }else if(data.plazaB != null) {
                        respuesta = data.plazaB;
                    }else{
                        respuesta = 'No definidos';
                    }
                    return respuesta;
                //17
                }
            }, {
                data: function (data ){
                    let respuesta ='';
                    if(data.lugar_prospeccion != null){
                         
                        respuesta  = data.lugar_prospeccion;

                    }else {
                        respuesta  = 'No definido';
                    }
                    return respuesta;
                //18
                }
            },
            {
                //19
                data: function (data){
                    return '<button value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'"  class="btn-data btn-blueMaderas m-auto consultar_history " title="Detalles">' +'<i class="fas fa-info"></i></button>';
 
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

    $(document).on("click", ".consultar_history", function(){
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
        var clearTitle = document.getElementById('nameLote');
        clearTitle.innerHTML = '';
        
        $("#comments-list-asimilados").append('');

        $("#nameLote").append();
        $("#seeInformationModalAsimilados").modal();
  
        id_pago = $(this).val();
        lote = $(this).attr("data-value");
        
        
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
        $.getJSON("getComments/"+id_pago).done( function( data ){
            $.each( data, function(i, v){
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
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
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
            });
        });
    });


    $("#cobranzaHistorial tbody").on("click", "#verifyNeodataStatus", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let tr = $(this).closest('tr');
        let row = $("#masterCobranzaTable").DataTable().row(tr);
        let idLote = $(this).attr("data-idLote");
        let registro_status = $(this).attr("data-registroComision");
        let cadena = '';

        $("#modal_NEODATA .modal-body").html("");
        $("#modal_NEODATA .modal-footer").html("");

        $.getJSON(url + "ComisionesNeo/getStatusNeodata/" + idLote).done(function (data) {
            if (data.length > 0) {
                switch (data[0].Marca) {
                    case 0:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>En espera de próximo abono en NEODATA de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 1:
                        if (registro_status == 0 || registro_status == 8) { //COMISION NUEVA
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
                            $.getJSON(url + "Comisiones/getDatosAbonadoSuma11/" + idLote).done(function (data1) {
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
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No se encontró esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 3:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No tiene vivienda, sí hay referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 4:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>No hay pagos aplicados a esta referencia de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    case 5:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Referencia duplicada de ' + row.data().nombreLote + '.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: ' + row.data().nombreLote + '.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        break;
                }
            } else {
                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12" style="text-align: center;"><h3><b>No se encontró esta referencia en NEODATA de ' + row.data().nombreLote + '.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="' + url + 'static/images/robot.gif" width="320" height="300"></center></div> </div>');
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
   
    
  
        fillTable(idLote, finalBeginDate, finalEndDate, bandera);
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
    
        fillTable(lote , finalBeginDate, finalEndDate, bandera);
    }
    
 
});

function formatMoney(n) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function setInitialValues() { 
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
  //  fillTable(1, finalBeginDate, finalEndDate, 0);
}

$(document).on("click", ".reset-initial-values", function () {
    setInitialValues();
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