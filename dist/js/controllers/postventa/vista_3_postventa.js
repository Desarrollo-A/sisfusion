let titulos = [];
$('#tabla_estatus3 thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_estatus3').DataTable().column(i).search() !== this.value ) {
            $('#tabla_estatus3').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

var getInfo1 = new Array(6);
var getInfo2 = new Array(6);


$(document).ready(function(){
    $.post( "get_tventa", function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++) {
            var id = data[i]['id_tventa'];
            var name = data[i]['tipo_venta'];
            $("#tipo_ventaenvARevCE").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#tipo_ventaenvARevCE").selectpicker('refresh');
    }, 'json');

    $.post("get_sede", function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#ubicacion").selectpicker('refresh');
    }, 'json');

});

$("#tabla_estatus3").ready( function(){
    tabla_5 = $("#tabla_estatus3").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro estatus 3',
                title:"Registro estatus 3",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Registro estatus 3',
                title: "Registro estatus 3",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data : null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                data: function( d ){
                    var lblStats = d.idMovimiento;
                    if(d.idMovimiento==100 || d.idMovimiento==102 || d.idMovimiento==104 || d.idMovimiento==105 || d.idMovimiento==107 || d.idMovimiento==110 || d.idMovimiento==113 || d.idMovimiento==114)
                        lblStats ='<span class="label lbl-warning">Correción</span>';
                    else
                        lblStats ='<span class="label lbl-green">Nuevo</span>';
                    return lblStats;
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">' + d.nombreResidencial +'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">'+d.referencia+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.gerente+'</p>';
                }
            },
            {
                data: function( d ){
                    return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                }
            },
            
            {
                data: function( d ){
                    return '<p class="m-0">'+d.modificado.split('.')[0]+'</p>';
                }
            },
            {
                data: function( d ){
                    var fechaVenc;
                    if (d.idStatusContratacion == 2 && d.idMovimiento == 4 || d.idStatusContratacion == 2 && d.idMovimiento == 84 || d.idStatusContratacion == 3 && d.idMovimiento == 98 || d.idStatusContratacion == 2 && d.idMovimiento == 105 || d.idStatusContratacion == 2 && d.idMovimiento == 107
                        || d.idStatusContratacion == 2 && d.idMovimiento == 110 || d.idStatusContratacion == 2 && d.idMovimiento == 113 || d.idStatusContratacion == 2 && d.idMovimiento == 114) {
                        fechaVenc = d.fechaVenc.split('.')[0];;
                    } else if (d.idStatusContratacion == 2 && d.idMovimiento == 74 || d.idStatusContratacion == 2 && d.idMovimiento == 93) {
                        fechaVenc = 'Vencido';
                    }
                    else
                    {
                        fechaVenc='NO APLICA';
                    }
                    return '<p class="m-0">'+fechaVenc+'</p>';
                }
            },
            {
                data: function( d ){
                    var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;
                    return '<p class="m-0">'+lastUc+'</p>';
                }
            },
            {
                data: function(d){
                    let respuesta = '';
                    if(d.sede == null || d.sede == '')
                    {
                        respuesta = 'No definido';
                    }else{
                        respuesta = d.sede;
                    }
                    return '<p class="m-0">'+ respuesta +'</p>';
                }
            },
            {
                data : function(d){
                    let respuesta = '';
                    if(d.comentario == null || d.comentario == '' ){
                        respuesta = 'No definido';
                    }else{
                        respuesta = d.comentario;
                    }
                    return '<p class="m-0">'+ respuesta +'</p>';
                }
            },
            {
                orderable: false,
                data: function( data ){
                    var cntActions;
                    if(data.vl == '1') {
                        cntActions = 'En proceso de Liberación';
                    } else {
                        if(data.idStatusContratacion == 3 && data.idMovimiento == 98 || data.idStatusContratacion == 3
                            && data.idMovimiento == 100 || data.idStatusContratacion == 3 && data.idMovimiento == 102 || data.idStatusContratacion == 2 && data.idMovimiento == 113 || data.idStatusContratacion == 2 && data.idMovimiento == 114)
                        {
                            let correccion_mov = (data.idMovimiento == 102) ? 1 : 0;
                            cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'data-tipo-venta="'+data.tipo_venta+'" class="stat5Rev btn-data btn-green" title="Registrar estatus" data-correccion="'+correccion_mov+'">' +
                                '<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';
                            cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'class="rechazarStatus btn-data btn-warning" title="Rechazar estatus">' +
                                '<i class="fas fa-thumbs-down"></i></button>';

                                if (data.expediente == null || data.expediente === "") {
                                    // NO HAY DOCUMENTO CARGADO
                                    const nuevoBotonHTML = crearBotonAccion(AccionDoc.SUBIR_DOC, data);
                                    cntActions += nuevoBotonHTML;
                                
                                } else {
                                    const nuevoBoton3HTML = crearBotonAccion(AccionDoc.DOC_CARGADO, data);
                                    const nuevoBoton2HTML = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                                    cntActions += nuevoBoton3HTML; 
                                    cntActions += nuevoBoton2HTML;  
                                     
                                }
                                
  
                        }
                        else if(data.idStatusContratacion == 3 && data.idMovimiento == 99)
                        {
                            cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'class="revCont6 btn-data btn-warning" title= "Rechazar Status">' +
                                '<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';
                            cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'class="edit2 btn-data btn-warning" title= "RECHAZAR A ESTATUS 2">' +
                                '<i class="fas fa-thumbs-down"></i></button>';
                            
                        }
                        else if(data.idStatusContratacion == 2 && data.idMovimiento == 105 || data.idStatusContratacion == 2 && data.idMovimiento == 107)
                        {
                            cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'data-tipo-venta="'+data.tipo_venta+'" class="avanzarStatus6 btn-data btn-green" title="Registrar estatus 6" >' +
                                '<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';
                            cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'class="rechazarStatusRechazo6 btn-data btn-warning" title="Rechazar estatus 1">' +
                                '<i class="fas fa-thumbs-down"></i></button>';
                            
                        }
                        else if(data.idStatusContratacion == 2 && data.idMovimiento == 110)
                        {
                            cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'data-tipo-venta="'+data.tipo_venta+'" class="avanzarStatus7 btn-data btn-green" title="Registrar estatus" >' +
                                '<i class="fas fa-thumbs-up"></i></button>&nbsp;&nbsp;';
                            cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
                                'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" ' +
                                'class="rechazarStatusRechazo7 btn-data btn-warning" title="Rechazar estatus">' +
                                '<i class="fas fa-thumbs-down"></i></button>';
                            
                        }
                        else
                        {
                            cntActions = 'N/A';
                        }
                    }
                    return '<div class="d-flex justify-center">'+cntActions+'</div>';
                }
            }
        ],
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            },
        ],
        ajax: {
            url: "getStatus3VP",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function( d ){
            }
        },
        order: [[ 1, 'asc' ]]
    });

    $('#tabla_estatus3 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_5.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 4 ||
                row.data().idStatusContratacion == 2 && row.data().idMovimiento == 74 ||
                row.data().idStatusContratacion == 2 && row.data().idMovimiento == 93) {
                status = 'Status 2 enviado a Revisión (Asesor)';
            } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 84 ) {
                status = 'Listo status 2 (Asesor)';
            }
            else
            {
                status='N/A';
            }
            var informacion_adicional2 = '<table class="table text-justify">' +
                '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
                '<td style="font-size: .8em"><strong>ESTATUS: </strong>'+status+'</td>' +
                '<td style="font-size: .8em"><strong>COMENTARIO: </strong>' + row.data().comentario + '</td>' +
                '<td style="font-size: .8em"><strong>COORDINADOR: </strong>'+row.data().coordinador+'</td>' +
                '<td style="font-size: .8em"><strong>ASESOR: </strong>'+row.data().asesor+'</td>' +
                '</tr>' +
                '</table>';
            var informacion_adicional = '<div class="container subBoxDetail">';
            informacion_adicional += '  <div class="row">';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
            informacion_adicional += '          <label><b>Información adicional</b></label>';
            informacion_adicional += '      </div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>'+ status +'</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
            informacion_adicional += '  </div>';
            informacion_adicional += '</div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#tabla_estatus3 tbody").on("click", ".revCont6", function(e){
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#envARev2').modal('show');
    });

    $("#tabla_estatus3 tbody").on("click", ".edit2", function(e){
        e.preventDefault();
        getInfo2[0] = $(this).attr("data-idCliente");
        getInfo2[1] = $(this).attr("data-nombreResidencial");
        getInfo2[2] = $(this).attr("data-nombreCondominio");
        getInfo2[3] = $(this).attr("data-idcond");
        getInfo2[4] = $(this).attr("data-nomlote");
        getInfo2[5] = $(this).attr("data-idLote");
        getInfo2[6] = $(this).attr("data-fecven");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechazarStatus_2').modal('show');
    });
});

/*modal para enviar a revision corrida elaborada*/
$(document).on('click', '.stat5Rev', function () {
    var idLote = $(this).attr("data-idLote");
    var nomLote = $(this).attr("data-nomLote");
    const tipoVenta = $(this).attr('data-tipo-venta');
    $('#nombreLoteenvARevCE').val($(this).attr('data-nomLote'));
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
    $('#idCondominioenvARevCE').val($(this).attr('data-idCond'));
    $('#idClienteenvARevCE').val($(this).attr('data-idCliente'));
    $('#fechaVencenvARevCE').val($(this).attr('data-fecVen'));
    $('#nomLoteFakeenvARevCE').val($(this).attr('data-nomLote'));
    $('#movimientoLote').val($(this).attr('data-correccion'));
    $('#tvLbl').removeClass('hide');
    if (tipoVenta == 1) {
        $('#tipo-venta-options-div').attr('hidden', true);
        $('#tipo-venta-particular-div').attr('hidden', false);
        $('#tipo_ventaenvARevCE').val(tipoVenta);
    } else {
        $('#tipo-venta-options-div').attr('hidden', false);
        $('#tipo-venta-particular-div').attr('hidden', true);
    }
    $('#enviarenvARevCE').removeAttr('onClick', 'preguntaenvARevCE2()');
    $('#enviarenvARevCE').attr('onClick', 'preguntaenvARevCE()');
    $("#comentarioenvARevCE").val('');
    $('#enviarenvARevCE').disabled = false;
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $('#envARevCE').modal();
});

$(document).on('click', '.avanzarStatus6', function () {
    var idLote = $(this).attr("data-idLote");
    var nomLote = $(this).attr("data-nomLote");
    const tipoVenta = $(this).attr('data-tipo-venta');
    $('#nombreLoteDirSt6').val($(this).attr('data-nomLote'));
    $('#idLoteDirSt6').val($(this).attr('data-idLote'));
    $('#idCondominioDirSt6').val($(this).attr('data-idCond'));
    $('#idClienteDirSt6').val($(this).attr('data-idCliente'));
    $('#fechaVencDirSt6').val($(this).attr('data-fecVen'));
    $('#tvLbl').removeClass('hide');
    if (tipoVenta == 1) {
        $('#tipo-venta-options-div').attr('hidden', true);
        $('#tipo-venta-particular-div').attr('hidden', false);
        $('#tipo_ventaenvARevCE').val(tipoVenta);
    } else {
        $('#tipo-venta-options-div').attr('hidden', false);
        $('#tipo-venta-particular-div').attr('hidden', true);
    }
    $('#enviarenvARevCE').removeAttr('onClick', 'preguntaenvARevCE2()');
    $('#enviarenvARevCE').attr('onClick', 'preguntaenvARevCE()');
    $("#comentarioenvARevCE").val('');
    $('#enviarenvARevCE').disabled = false;
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $('#backToStatus6').modal();
});

$(document).on('click', '.avanzarStatus7', function () {
    var idLote = $(this).attr("data-idLote");
    var nomLote = $(this).attr("data-nomLote");
    const tipoVenta = $(this).attr('data-tipo-venta');
    $('#nombreLoteDirSt7').val($(this).attr('data-nomLote'));
    $('#idLoteDirSt7').val($(this).attr('data-idLote'));
    $('#idCondominioDirSt7').val($(this).attr('data-idCond'));
    $('#idClienteDirSt7').val($(this).attr('data-idCliente'));
    $('#fechaVencDirSt7').val($(this).attr('data-fecVen'));
    $('#tvLbl').removeClass('hide');
    if (tipoVenta == 1) {
        $('#tipo-venta-options-div').attr('hidden', true);
        $('#tipo-venta-particular-div').attr('hidden', false);
        $('#tipo_ventaenvARevCE').val(tipoVenta);
    } else {
        $('#tipo-venta-options-div').attr('hidden', false);
        $('#tipo-venta-particular-div').attr('hidden', true);
    }
    $('#enviarAStatus7CE').removeAttr('onClick', 'enviarAStatus7CE()');
    $('#enviarAStatus7CE').attr('onClick', 'enviarAStatus7CE()');
    $("#comentarioDirSt7").val('');
    $('#enviarAStatus7CE').disabled = false;
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $('#backToStatus7').modal();
});

function preguntaenvARevCE() {
    var idLote = $("#idLoteenvARevCE").val();
    var idCondominio = $("#idCondominioenvARevCE").val();
    var nombreLote = $("#nombreLoteenvARevCE").val();
    var idCliente = $("#idClienteenvARevCE").val();
    var fechaVenc = $("#fechaVencenvARevCE").val();
    var ubicacion = $("#ubicacion").val();
    var comentario = $("#comentarioenvARevCE").val();
    var tipo_venta = $('#tipo_ventaenvARevCE').val();
    var movimientoLote = $('#movimientoLote').val();
    var parametros = {
        "idLote": idLote,
        "idCondominio": idCondominio,
        "nombreLote": nombreLote,
        "idCliente": idCliente,
        "fechaVenc": fechaVenc,
        "ubicacion" : ubicacion,
        "comentario": comentario,
        "tipo_venta": tipo_venta,
        "movimientoLote": movimientoLote
    };
    if (comentario.length <= 0) {
        alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')
    } else if (comentario.length > 0) {
        var botonEnviar = document.getElementById('enviarenvARevCE');
        botonEnviar.disabled = true;
        $.ajax({
            data: parametros,
            url: 'editar_registro_lote_contraloria_proceceso3/',
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    botonEnviar.disabled = false;
                    $('#envARevCE').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    botonEnviar.disabled = false;
                    $('#envARevCE').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    botonEnviar.disabled = false;
                    $('#envARevCE').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                botonEnviar.disabled = false;
                $('#envARevCE').modal('hide');
                $('#tabla_estatus3').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
}

function enviarAStatus6CE() {
    /*esta funcion envia directo a status 6 despues de un rechazo*/
    var idLote = $("#idLoteDirSt6").val();
    var idCondominio = $("#idCondominioDirSt6").val();
    var nombreLote = $("#nombreLoteDirSt6").val();
    var idCliente = $("#idClienteDirSt6").val();
    var fechaVenc = $("#fechaVencDirSt6").val();
    var ubicacion = $("#ubicacion").val();
    var comentario = $("#comentarioDirSt6").val();
    var tipo_venta = $('#tipo_ventaDirSt6').val();
    var parametros = {
        "idLote": idLote,
        "idCondominio": idCondominio,
        "nombreLote": nombreLote,
        "idCliente": idCliente,
        "fechaVenc": fechaVenc,
        "ubicacion" : ubicacion,
        "comentario": comentario,
        "tipo_venta": tipo_venta,
    };
    
    if (comentario.length <= 0) {
        alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')
    } 
    else if (comentario.length > 0) {
        var botonEnviar = document.getElementById('enviarAStatus6CE');
        botonEnviar.disabled = true;
        $.ajax({
            data: parametros,
            url: 'enviaDirectoStatus6/',
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    botonEnviar.disabled = false;
                    $('#backToStatus6').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    botonEnviar.disabled = false;
                    $('#backToStatus6').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    botonEnviar.disabled = false;
                    $('#backToStatus6').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                botonEnviar.disabled = false;
                $('#backToStatus6').modal('hide');
                $('#tabla_estatus3').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
}

function enviarAStatus7CE() {
    /*esta funcion envia directo a status 6 despues de un rechazo*/
    var idLote = $("#idLoteDirSt7").val();
    var idCondominio = $("#idCondominioDirSt7").val();
    var nombreLote = $("#nombreLoteDirSt7").val();
    var idCliente = $("#idClienteDirSt7").val();
    var fechaVenc = $("#fechaVencDirSt7").val();
    var ubicacion = $("#ubicacion").val();
    var comentario = $("#comentarioDirSt7").val();
    var tipo_venta = $('#tipo_ventaDirSt7').val();
    var parametros = {
        "idLote": idLote,
        "idCondominio": idCondominio,
        "nombreLote": nombreLote,
        "idCliente": idCliente,
        "fechaVenc": fechaVenc,
        "ubicacion" : ubicacion,
        "comentario": comentario,
        "tipo_venta": tipo_venta,
    };
    if (comentario.length <= 0) {
        alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger')
    }
    else if (comentario.length > 0) {
        var botonEnviar = document.getElementById('enviarAStatus7CE');
        botonEnviar.disabled = true;
        $.ajax({
            data: parametros,
            url: 'enviaDirectoStatus7/',
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    botonEnviar.disabled = false;
                    $('#backToStatus7').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    botonEnviar.disabled = false;
                    $('#backToStatus7').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    botonEnviar.disabled = false;
                    $('#backToStatus7').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                botonEnviar.disabled = false;
                $('#backToStatus7').modal('hide');
                $('#tabla_estatus3').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
}

/*rechazar status1*/
$(document).on('click', '.rechazarStatus', function (e) {
    idLote = $(this).data("idlote");
    nombreLote = $(this).data("nomlote");
    $('#idClienterechCor').val($(this).attr('data-idCond'));
    $('#idCondominiorechCor').val($(this).attr('data-idCliente'));
    $('#idStatusContratacion').val(3);
    $('#idMovimiento').val(99);
    $(".lote").html(nombreLote);
    $('#rechazarStatus').modal();
    e.preventDefault();
});

$(document).on('click', '.rechazarStatusRechazo6', function (e) {
    idLote = $(this).data("idlote");
    nombreLote = $(this).data("nomlote");
    $('#idClienterechCor').val($(this).attr('data-idCond'));
    $('#idCondominiorechCor').val($(this).attr('data-idCliente'));
    $('#idStatusContratacion').val(2);
    $('#idMovimiento').val(108);
    $(".lote").html(nombreLote);
    $('#rechazarStatus').modal();
    e.preventDefault();
});

$(document).on('click', '.rechazarStatusRechazo7', function (e) {
    idLote = $(this).data("idlote");
    nombreLote = $(this).data("nomlote");
    $('#idClienterechCor').val($(this).attr('data-idCond'));
    $('#idCondominiorechCor').val($(this).attr('data-idCliente'));
    $('#idStatusContratacion').val(1);
    $('#idMovimiento').val(111);
    $(".lote").html(nombreLote);
    $('#rechazarStatus').modal();
    e.preventDefault();
});

$("#guardar").click(function () {
    var comentario = $("#motivoRechazo").val();
    var idCondominioR = $("#idClienterechCor").val();
    var idClienteR = $("#idCondominiorechCor").val();
    var idStatusContratacion = $("#idStatusContratacion").val();
    var idMovimiento = $("#idMovimiento").val();
    parametros = {
        "idLote": idLote,
        "nombreLote": nombreLote,
        "comentario": comentario,
        "idCliente": idClienteR,
        "idCondominio": idCondominioR,
        "idStatusContratacion": idStatusContratacion,
        "idMovimiento": idMovimiento
    };
    if (comentario.length <= 0) {
        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
    } else if (comentario.length > 0) {
        $('#guardar').prop('disabled', true);
        $.ajax({
            url: 'rechazarStatus',
            type: 'POST',
            data: parametros,
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#guardar').prop('disabled', false);
                    $('#rechazarStatus').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#guardar').prop('disabled', false);
                    $('#rechazarStatus').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#guardar').prop('disabled', false);
                    $('#rechazarStatus').modal('hide');
                    $('#tabla_estatus3').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                botonEnviar.disabled = false;
                $('#rechazarStatus').modal('hide');
                $('#tabla_estatus3').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario1").val();
    var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url : 'editar_registro_loteRevision_contraloria5_Acontraloria6/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save1').prop('disabled', false);
                $('#envARev2').modal('hide');
                $('#tabla_ingresar_5').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save2', function(e) {
    e.preventDefault();
    var comentario = $("#comentario2").val();
    var validaComent = ($("#comentario2").val().length == 0) ? 0 : 1;
    var dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo2[0]);
    dataExp2.append("nombreResidencial", getInfo2[1]);
    dataExp2.append("nombreCondominio", getInfo2[2]);
    dataExp2.append("idCondominio", getInfo2[3]);
    dataExp2.append("nombreLote", getInfo2[4]);
    dataExp2.append("idLote", getInfo2[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url : 'editar_registro_loteRechazo_contraloria_proceceso5_2/',
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#rechazarStatus_2').modal('hide');
                    $('#tabla_ingresar_5').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save2').prop('disabled', false);
                $('#rechazarStatus_2').modal('hide');
                $('#tabla_ingresar_5').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#rechazarStatus').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#motivoRechazo').val('');
    })
    jQuery('#edit2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#motivoRechazo2').val('');
    })
    jQuery('#envARevCE').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentarioenvARevCE').val('');
        jQuery(this).find('#tipo_ventaenvARevCE').val(null).trigger('change');
        jQuery(this).find('#ubicacion').val(null).trigger('change');
    })
    jQuery('#envARev2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario1').val('');
    })
    jQuery('#rechazarStatus_2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
    })
})


const AccionDoc = {
    DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
    DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
    SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
    ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
    ENVIAR_SOLICITUD: 5,
};

Shadowbox.init();

$(document).ready(function () {
    $("#addDeleteFileModal").on("hidden.bs.modal", function () {
      $("#fileElm").val(null);
      $("#file-name").val("");
    });
    $("input:file").on("change", function () {
      const target = $(this);
      const relatedTarget = target.siblings(".file-name");
      const fileName = target[0].files[0].name;
      relatedTarget.val(fileName);
    });
  });

$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    //console.log(idDocumento);
    
    let tipoDocumento = $(this).attr("data-tipoDocumento");
    let accion = parseInt($(this).data("accion"));
    let nombreDocumento = $(this).data("nombre");
    $("#idLoteValue").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#tipoDocumento").val(tipoDocumento);
    $("#nombreDocumento").val(nombreDocumento);
    $("#tituloDocumento").val($(this).attr("data-tituloDocumento"));
    $("#accion").val(accion);
    if (accion === AccionDoc.DOC_NO_CARGADO || accion === AccionDoc.DOC_CARGADO) {
      document.getElementById("mainLabelText").innerHTML =
        accion === AccionDoc.DOC_NO_CARGADO
          ? "Selecciona el archivo que desees asociar a <b>" +
            nombreDocumento +
            "</b>"
          : accion === AccionDoc.DOC_CARGADO
          ? "¿Estás seguro de eliminar el archivo <b>" + nombreDocumento + "</b>?"
          : "Selecciona los motivos de rechazo que asociarás al documento <b>" +
            nombreDocumento +
            "</b>.";
      document.getElementById("secondaryLabelDetail").innerHTML =
        accion === AccionDoc.DOC_NO_CARGADO
          ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>."
          : accion === AccionDoc.DOC_CARGADO
          ? "El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>."
          : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.";
      if (accion === AccionDoc.DOC_NO_CARGADO) {
        // ADD FILE
        $("#selectFileSection").removeClass("hide");
        $("#txtexp").val("");
      }
      if (accion === AccionDoc.DOC_CARGADO) {
        // REMOVE FILE
        $("#selectFileSection").addClass("hide");
      }
      $("#addDeleteFileModal").modal("show");
    }
    if (accion === AccionDoc.SUBIR_DOC) {
      const fileName = $(this).attr("data-file");
      window.location.href = getDocumentPath(tipoDocumento, fileName, 0, 0, 0);
      alerts.showNotification(
        "top",
        "right",
        "El documento <b>" + nombreDocumento + "</b> se ha descargado con éxito.",
        "success"
      );
    }
    if (accion === AccionDoc.ENVIAR_SOLICITUD) {
      $("#sendRequestButton").click();
    }
  });


  $(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const accion = parseInt($("#accion").val());
    if (accion === AccionDoc.DOC_NO_CARGADO) {
      // UPLOAD FILE
      const uploadedDocument = document.getElementById("fileElm").value;
      let validateUploadedDocument = uploadedDocument.length === 0;
      // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVE A CABO EL REQUEST
      if (validateUploadedDocument) {
        alerts.showNotification(
          "top",
          "right",
          "Asegúrate de haber seleccionado un archivo antes de guardar.",
          "warning"
        );
        return;
      }
      const archivo = $("#fileElm")[0].files[0];
      const tipoDocumento = parseInt($("#tipoDocumento").val());
      let extensionDeDocumento = archivo.name.split(".").pop();
      let extensionesPermitidas = getExtensionPorTipoDocumento(tipoDocumento);
      let statusValidateExtension = validateExtension(
        extensionDeDocumento,
        extensionesPermitidas
      );
      if (!statusValidateExtension) {
        // MJ: ARCHIVO VÁLIDO PARA CARGAR
        alerts.showNotification(
          "top",
          "right",
          `El archivo que has intentado cargar con la extensión <b>${extensionDeDocumento}</b> no es válido. ` +
            `Recuerda seleccionar un archivo ${extensionesPermitidas}`,
          "warning"
        );
        return;
      }
      const nombreDocumento = $("#nombreDocumento").val();
      let data = new FormData();
      data.append("idLote", $("#idLoteValue").val());
      data.append("idDocumento", $("#idDocumento").val());
      data.append("tipoDocumento", tipoDocumento);
      data.append("uploadedDocument", archivo);
      data.append("accion", accion);
      data.append("tituloDocumento", $("#tituloDocumento").val());
      $.ajax({
        url: `${general_base_url}Postventa/subirArchivo`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        beforeSend: function () {
          $("#uploadFileButton").prop("disabled", true);
        },
        success: function (response) {
          const res = JSON.parse(response);
          if (res.code === 200) {
            alerts.showNotification(
              "top",
              "right",
              `El documento ${nombreDocumento} se ha cargado con éxito.`,
              "success"
            );
            $('#tabla_estatus3').DataTable().ajax.reload();
            $("#addDeleteFileModal").modal("hide");
          }
          if (res.code === 400) {
            alerts.showNotification("top", "right", res.message, "warning");
          }
          if (res.code === 500) {
            alerts.showNotification(
              "top",
              "right",
              "Oops, algo salió mal.",
              "warning"
            );
          }
        },
        error: function () {
          $("#sendRequestButton").prop("disabled", false);
          alerts.showNotification(
            "top",
            "right",
            "Oops, algo salió mal.",
            "danger"
          );
        },
      });
    }else {
        // VA A ELIMINAR
        const nombreDocumento = $("#nombreDocumento").val();
        let data = new FormData();
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", parseInt($("#tipoDocumento").val()));
        $.ajax({
          url: `${general_base_url}Documentacion/eliminarArchivo`,
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          type: "POST",
          success: function (response) {
            const res = JSON.parse(response);
            $("#sendRequestButton").prop("disabled", false);
            if (res.code === 200) {
              alerts.showNotification(
                "top",
                "right",
                `El documento ${nombreDocumento} se ha eliminado con éxito.`,
                "success"
              );
              $('#tabla_estatus3').DataTable().ajax.reload();
              $("#addDeleteFileModal").modal("hide");
            }
            if (res.code === 400) {
              alerts.showNotification("top", "right", res.message, "warning");
            }
            if (res.code === 500) {
              alerts.showNotification(
                "top",
                "right",
                "Oops, algo salió mal.",
                "warning"
              );
            }
          },
          error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification(
              "top",
              "right",
              "Oops, algo salió mal.",
              "danger"
            );
          },
        });
      }
});

const TipoDoc = {
    CONTRATO: 8,
    CORRIDA: 7,
    CARTA_DOMICILIO: 29,
    CONTRATO_FIRMADO: 30,
    DS_NEW: 'ds_new',
    DS_OLD: 'ds_old',
    EVIDENCIA_MKTD_OLD: 66, // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
    AUTORIZACIONES: 'autorizacion',
    PROSPECTO: 'prospecto',
    APOSTILLDO_CONTRATO: 31,
    CARTA: 32,
    RESCISION_CONTRATO: 33,
    CARTA_PODER: 34,
    RESCISION_CONTRATO_FIRMADO: 35,
    DOCUMENTO_REESTRUCTURA: 36,
    DOCUMENTO_REESTRUCTURA_FIRMADO: 37,
    CONSTANCIA_SITUACION_FISCAL: 38,
    CORRIDA_ANTERIOR: 39,
    CONTRATO_ANTERIOR: 40,
    COMPLEMENTO_ENGANCHE: 45,
    CONTRATO_ELEGIDO_FIRMA_CLIENTE: 41,
    CONTRATO_1_CANCELADO: 42,
    CONTRATO_2_CANCELADO: 43,
    CONTRATO_REUBICACION_FIRMADO: 44,
    AUTORIZACIONES_PARTICULARES: 50,
  };

/**
 * @param {number} tipoDocumento
 * @returns {string}
 */

function getExtensionPorTipoDocumento(tipoDocumento) {
    if (tipoDocumento === TipoDoc.CORRIDA) {
      return "xlsx";
    }
    if (
      tipoDocumento === TipoDoc.CONTRATO ||
      tipoDocumento === TipoDoc.CONTRATO_FIRMADO
    ) {
      return "pdf";
    }
    return "jpg, jpeg, png, pdf";
  }

/**
 * Función para crear el botón a partir del tipo de acción
 *
 * @param {number} type
 * @param {any} data
 * @returns {string}
 */


$(document).on("click", ".verDocumento", function () {
   
    const $itself = $(this);

    var expediente = $itself.attr("data-expediente");
    var cadenaSinEspacios = expediente.replace(/\s/g, '');

    let pathUrl = `${general_base_url}static/documentos/cliente/expediente/${cadenaSinEspacios}`;
    console.log(pathUrl);

    if (parseInt($itself.attr("data-tipoDocumento")) === TipoDoc.CORRIDA) {
        descargarArchivo(pathUrl, $itself.attr("data-expediente"));
        alerts.showNotification(
          "top",
          "right",
          "El documento <b>" +
            $itself.attr("data-expediente") +
            "</b> se ha descargado con éxito.",
          "success"
        );
        return;
    }

    if (screen.width > 480 && screen.width < 800) {
      window.location.href = `${pathUrl}`;
    } else {
      Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo:  ${cadenaSinEspacios}  `,
        width: 985,
        height: 660,
      });
    }
  });

//cargar documentos
function crearBotonAccion(type, data) {
    //console.log(data);
    const [
      buttonTitulo,
      buttonEstatus,
      buttonClassColor,
      buttonClassAccion,
      buttonTipoAccion,
      buttonIcono,
    ] = getAtributos(type);
    const d = new Date();
    const dateStr = [d.getMonth() + 1, d.getDate(), d.getFullYear()].join("-");

    const tituloDocumento =
    `${data.nombreResidencial}_${data.nombre.slice(0, 4)}_${data.idLote}_${
      data.id_cliente
    }` + `_TDOC${data.tipo_doc}${data.movimiento.slice(0, 4)}_${dateStr}`;

    return `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${
      data.expediente
    }" data-accion="${buttonTipoAccion}" data-tipoDocumento="${
      data.tipo_doc
    }" ${buttonEstatus} data-toggle="tooltip" data-placement="top" data-nombre="${
      data.movimiento
    }" data-idDocumento="${data.idDocumento}" data-idLote="${
      data.idLote
    }" data-tituloDocumento="${tituloDocumento}" data-idCliente="${
      data.idCliente ?? data.id_cliente
    }" data-lp="${data.lugar_prospeccion}" data-idProspeccion="${
      data.id_prospecto
    }"><i class="${buttonIcono}"></i></button>`;
  }
  
  /**
   * Función para obtener los atributos del botón de acción de la tabla
   *
   * @param {number} type
   * @returns {string[]}
   */
  function getAtributos(type) {
    let buttonTitulo = "";
    let buttonEstatus = "";
    let buttonClassColor = "";
    let buttonClassAccion = "";
    let buttonIcono = "";
    let buttonTipoAccion = "";
    if (type === AccionDoc.DOC_NO_CARGADO) {
      buttonTitulo = "DOCUMENTO NO CARGADO";
      buttonEstatus = "disabled";
      buttonClassColor = "btn-data btn-orangeYellow";
      buttonClassAccion = "";
      buttonIcono = "fas fa-file";
      buttonTipoAccion = "";
    }
    if (type === AccionDoc.DOC_CARGADO) {
      buttonTitulo = "VER DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-blueMaderas";
      buttonClassAccion = "verDocumento";
      buttonIcono = "fas fa-eye";
      buttonTipoAccion = "3";
    }
    if (type === AccionDoc.SUBIR_DOC) {
      buttonTitulo = "SUBIR DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-green";
      buttonClassAccion = "addRemoveFile";
      buttonIcono = "fas fa-upload";
      buttonTipoAccion = "1";
    }
    if (type === AccionDoc.ELIMINAR_DOC) {
      buttonTitulo = "ELIMINAR DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-warning";
      buttonClassAccion = "addRemoveFile";
      buttonIcono = "fas fa-trash";
      buttonTipoAccion = "2";
    }
    
    return [
      buttonTitulo,
      buttonEstatus,
      buttonClassColor,
      buttonClassAccion,
      buttonTipoAccion,
      buttonIcono,
    ];
  }