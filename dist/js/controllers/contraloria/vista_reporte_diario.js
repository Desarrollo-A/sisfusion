var getInfo1 = new Array(6);
var getInfo2 = new Array(6);
var getInfo3 = new Array(6);
var getInfo6 = new Array(1);

let titulos_intxt = [];
$('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#tabla_ingresar_6').DataTable().column(i).search() !== this.value ) {
            $('#tabla_ingresar_6').DataTable().column(i).search(this.value).draw();
        }
    });
});

$("#calendarioDay").change( function (){
    let fecha_inicio = $("#calendarioDay").val();
    if(fecha_inicio ==""){
    
    }else{
    $("#tabla_ingresar_6").ready( function(){
        tabla_6 = $("#tabla_ingresar_6").DataTable({
            "ajax": {
                "url": general_base_url + "contraloria/getRegistroDiarioPorFecha/",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                data: {
                    "fecha_inicio": fecha_inicio
                }
            },
            destroy: true,
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registro diario',
                    title: "Registro diario",
                    exportOptions: {
                        columns: [0,1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header:  function (d, columnIdx) {
                                return ' ' + titulos_intxt[columnIdx]  + ' ';
                                }
                            }
                    }
                }
            ],
            language: {
                url: general_base_url + "/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreResidencial+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+(d.nombreCondominio)+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },  
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.gerente+'</p>';
                    }
                },
                {   
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                    }
                },
                {
                    "data": function( d ){
                    return '<p class="m-0">'+d.modificado+'</p>';
                    }
                },
                {   
                    "data": function( d ){
                        var fechaVenc;
                        
                        if(d.idStatusContratacion == 5 && d.idMovimiento == 22 || d.idStatusContratacion == 5 && d.idMovimiento == 75 || d.idStatusContratacion == 5 && d.idMovimiento == 94) {
                            fechaVenc = 'Vencido';
                        } else if (d.idStatusContratacion == 5 && d.idMovimiento == 35 || d.idStatusContratacion == 2 && d.idMovimiento == 62) {
                            fechaVenc = d.fechaVenc;
                        }

                        return '<p class="m-0">'+fechaVenc+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;

                        return '<p class="m-0">'+lastUc+'</p>';
                    }
                }
            ],
            columnDefs: [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
            ],
            "order": [[ 1, 'asc' ]]
        });
        
        $('#tabla_ingresar_6 tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_6.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
            } else {
                var status;
                if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35) {
                    status = 'Status 5 listo (Contraloría) ';
                } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
                    status = 'Status 2 enviado a Revisión (Asesor)';
                } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22) {
                    status = 'Status 6 Rechazado (Juridico) ';
                } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
                    status = 'Status enviado a revisión (Contraloria)';
                } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 94) {
                    status = 'Status 6 Rechazado (Juridico)';
                }

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

        $('#tabla_ingresar_6').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });

        $("#tabla_ingresar_6 tbody").on("click", ".regRevCorr", function(e){
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

            $('#regRevCorrElab').modal('show');
        });

        $("#tabla_ingresar_6 tbody").on("click", ".revStaCE", function(e){
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

            $('#regRevA7').modal('show');
        });


        $("#tabla_ingresar_6 tbody").on("click", ".return1", function(e){
            e.preventDefault();

            getInfo3[0] = $(this).attr("data-idCliente");
            getInfo3[1] = $(this).attr("data-nombreResidencial");
            getInfo3[2] = $(this).attr("data-nombreCondominio");
            getInfo3[3] = $(this).attr("data-idcond");
            getInfo3[4] = $(this).attr("data-nomlote");
            getInfo3[5] = $(this).attr("data-idLote");
            getInfo3[6] = $(this).attr("data-fecven");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);
            $('#modal_return1').modal('show');
        });
            
        $("#tabla_ingresar_6 tbody").on("click", ".change_sede", function(e){
            e.preventDefault();

            getInfo6[0] = $(this).attr("data-lote");
            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);
            $('#change_s').modal('show');

        });
    });
}
});

$(document).ready(function(){
    $.post(general_base_url + "Contraloria/get_sede", function(data) {
        var len = data.length;
        for(var i = 0; i<len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#ubicacion").selectpicker('refresh');
    }, 'json');
});

$("#tabla_ingresar_6").ready( function(){
    let titulos = [];

    $('#tabla_ingresar_6 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
    });

    tabla_6 = $("#tabla_ingresar_6").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro diario',
                title:"Registro diario",
                exportOptions: {
                    columns: [0,1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx]  + ' ';
                            }
                        }
                }
            }
        ],
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "pageLength": 10,
        "bAutoWidth": false,
        "fixedColumns": true,
        "ordering": false,
        "columns": [
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreResidencial+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                }
            },
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            }, 
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.gerente+'</p>';
                }
            }, 
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                }
            }, 
            {
                "data": function( d ){
                    return '<p class="m-0">'+d.modificado+'</p>';
                }
            }, 
            {
                "data": function( d ){
                    var fechaVenc;

                    if (d.idStatusContratacion == 5 && d.idMovimiento == 22 || d.idStatusContratacion == 5 && d.idMovimiento == 75 || d.idStatusContratacion == 5 && d.idMovimiento == 94) {
                        fechaVenc = 'Vencido';
                    } else if (d.idStatusContratacion == 5 && d.idMovimiento == 35 || d.idStatusContratacion == 2 && d.idMovimiento == 62) {
                        fechaVenc = d.fechaVenc;
                    }

                    return '<p class="m-0">'+fechaVenc+'</p>';
                }
            }, 
            {
                "data": function( d ){
                    var lastUc = (d.lastUc == null) ? 'Sin registro' : d.lastUc;
                    
                    return '<p class="m-0">'+lastUc+'</p>';
                }
            }
        ],

        columnDefs: [
            {
                "searchable": false,
                "orderable": false,
                "targets": 0
            },
        ],

        "ajax": {
            "url": general_base_url + "contraloria/getRegistroDiario",
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
        "order": [[ 1, 'asc' ]]

    });
    
    $('#tabla_ingresar_6').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_ingresar_6 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 35) {
                status = 'Status 5 listo (Contraloría) ';
            } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 62) {
                status = 'Status 2 enviado a Revisión (Asesor)';
            } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 22) {
                status = 'Status 6 Rechazado (Juridico) ';
            } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 75) {
                status = 'Status enviado a revisión (Contraloria)';
            } else if (row.data().idStatusContratacion == 5 && row.data().idMovimiento == 94) {
                status = 'Status 6 Rechazado (Juridico)';
            }

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

    $("#tabla_ingresar_6 tbody").on("click", ".regRevCorr", function(e){
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

        $('#regRevCorrElab').modal('show');
    });

    $("#tabla_ingresar_6 tbody").on("click", ".revStaCE", function(e){
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

        $('#regRevA7').modal('show');
    });


    $("#tabla_ingresar_6 tbody").on("click", ".return1", function(e){
        e.preventDefault();

        getInfo3[0] = $(this).attr("data-idCliente");
        getInfo3[1] = $(this).attr("data-nombreResidencial");
        getInfo3[2] = $(this).attr("data-nombreCondominio");
        getInfo3[3] = $(this).attr("data-idcond");
        getInfo3[4] = $(this).attr("data-nomlote");
        getInfo3[5] = $(this).attr("data-idLote");
        getInfo3[6] = $(this).attr("data-fecven");

        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);

        $('#modal_return1').modal('show');
    });
        
        
    $("#tabla_ingresar_6 tbody").on("click", ".change_sede", function(e){
        e.preventDefault();

        getInfo6[0] = $(this).attr("data-lote");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#change_s').modal('show');

    });
});

$(document).on('click', '.regCorrElab', function () {
    $('#nombreLoteregCor').val($(this).attr('data-nomLote'));
    $('#idLoteregCor').val($(this).attr('data-idLote'));
    $('#idCondominioregCor').val($(this).attr('data-idCond'));
    $('#idClienteregCor').val($(this).attr('data-idCliente'));
    $('#fechaVencregCor').val($(this).attr('data-fecVen'));
    $('#nomLoteFakeEregCor').val($(this).attr('data-nomLote'));

    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $('#regCorrElab').modal();

});

function preguntaRegCorr() {
    var idLote = $("#idLoteregCor").val();
    var idCondominio = $("#idCondominioregCor").val();
    var nombreLote = $("#nombreLoteregCor").val();
    var idStatusContratacion = $("#idStatusContratacionregCor").val();
    var idCliente = $("#idClienteregCor").val();
    var fechaVenc = $("#fechaVencregCor").val();
    var comentario = $("#comentarioregCor").val();

    var parametros = {
        "idLote": idLote,
        "idCondominio": idCondominio,
        "nombreLote": nombreLote,
        "idStatusContratacion": idStatusContratacion,
        "idCliente": idCliente,
        "fechaVenc": fechaVenc,
        "comentario": comentario
    };


    if (comentario.length <= 0 ) {
        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');
    } 
    else if (comentario.length > 0) {
        $('#enviarAContraloriaGuardar').prop('disabled', true);
            $.ajax({
                data: parametros,
                url: general_base_url + 'index.php/Contraloria/editar_registro_lote_contraloria_proceceso6/',
                type: 'POST',
                success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#enviarAContraloriaGuardar').prop('disabled', false);
                    $('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#enviarAContraloriaGuardar').prop('disabled', false);
                    $('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#enviarAContraloriaGuardar').prop('disabled', false);
                    $('#regCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
                },
                error: function( data ){
                    $('#enviarAContraloriaGuardar').prop('disabled', false);
                    $('#rechazregCorrElabarStatus').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
        });
    }
}

$(document).on('click', '.rechazoCorrida', function (e) {
    idLote = $(this).data("idlote");
    nombreLote = $(this).data("nomlote");
    $('#idClienterechCor').val($(this).attr('data-idCond'));
    $('#idCondominiorechCor').val($(this).attr('data-idCliente'));
    $(".lote").html(nombreLote);
    $('#rechazarStatus').modal();
    e.preventDefault();
});

$("#guardar").click(function () {
    var motivoRechazo = $("#motivoRechazo").val();
    var idCondominioR = $("#idClienterechCor").val();
    var idClienteR = $("#idCondominiorechCor").val();

    parametros = {
        "idLote": idLote,
        "nombreLote": nombreLote,
        "motivoRechazo": motivoRechazo,
        "idCliente" : idClienteR,
        "idCondominio" : idCondominioR
    };


    if (motivoRechazo.length <= 0 ) {
        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger');
    } 
    else if (motivoRechazo.length > 0) {
    $('#guardar').prop('disabled', true);
        $.ajax({
        url: general_base_url + 'index.php/Contraloria/editar_registro_loteRechazo_contraloria_proceceso6/',
        type: 'POST',
        data: parametros,
        success: function(data){
            response = JSON.parse(data);
            if(response.message == 'OK') {
                $('#guardar').prop('disabled', false);
                $('#rechazarStatus').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if(response.message == 'FALSE'){
                $('#guardar').prop('disabled', false);
                $('#rechazarStatus').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if(response.message == 'ERROR'){
                $('#guardar').prop('disabled', false);
                $('#rechazarStatus').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        },
        error: function( data ){
            $('#guardar').prop('disabled', false);
            $('#rechazarStatus').modal('hide');
            $('#tabla_ingresar_6').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
    }
});

$(document).on('click', '.noCorrida', function(e){
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $('#infoNoCorrida').modal();
    e.preventDefault();
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
            url : general_base_url + 'index.php/Contraloria/editar_registro_loteRevision_contraloria_proceceso6/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#regRevCorrElab').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save1').prop('disabled', false);
                $('#regRevCorrElab').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
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
            url : general_base_url + 'index.php/Contraloria/editar_registro_loteRevision_contraloria6_AJuridico7/',
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save2').prop('disabled', false);
                    $('#regRevA7').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save2').prop('disabled', false);
                $('#regRevA7').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#b_return1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
    var dataExp3 = new FormData();

    dataExp3.append("idCliente", getInfo3[0]);
    dataExp3.append("nombreResidencial", getInfo3[1]);
    dataExp3.append("nombreCondominio", getInfo3[2]);
    dataExp3.append("idCondominio", getInfo3[3]);
    dataExp3.append("nombreLote", getInfo3[4]);
    dataExp3.append("idLote", getInfo3[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo3[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    if (validaComent == 1) {

        $('#save1').prop('disabled', true);   
        $.ajax({
            url : general_base_url + 'index.php/Contraloria/return1/',
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#b_return1').prop('disabled', false);
                $('#modal_return1').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#savecs', function(e) {
    e.preventDefault();
    var ubicacion = $("#ubicacion").val();
    var validaUbicacion = ($("#ubicacion").val().trim() == '') ? 0 : 1;
    var dataChange = new FormData();

    dataChange.append("idLote", getInfo6[0]);
    dataChange.append("ubicacion", ubicacion);

    if (validaUbicacion == 0) {
        alerts.showNotification("top", "right", "Selecciona una sede.", "danger");
    }

    if (validaUbicacion == 1) {
        $('#savecs').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'index.php/Contraloria/changeUb/',
            data: dataChange,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST', 
            success: function(data){
                response = JSON.parse(data);

                if(response.message == 'OK') {
                    $('#savecs').prop('disabled', false);
                    $('#change_s').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Sede modificada.", "success");
                } else if(response.message == 'ERROR'){
                    $('#savecs').prop('disabled', false);
                    $('#change_s').modal('hide');
                    $('#tabla_ingresar_6').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#savecs').prop('disabled', false);
                $('#change_s').modal('hide');
                $('#tabla_ingresar_6').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#regCorrElab').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#comentarioregCor').val('');
    })
    jQuery('#rechazarStatus').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#motivoRechazo').val('');
    })
    jQuery('#envARevCE').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#comentarioenvARevCE').val('');
        jQuery(this).find('#tipo_ventaenvARevCE').val(null).trigger('change');
        jQuery(this).find('#ubicacion').val(null).trigger('change');
    })
    jQuery('#regRevA7').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#comentario2').val('');
    })
    jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#comentario3').val('');
    })
    jQuery('#change_s').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');    
        jQuery(this).find('#ubicacion').val(null).trigger('change');
    })
});