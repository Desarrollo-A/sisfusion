var getInfo2A = new Array(7);
var getInfo2_2A = new Array(7);
var getInfo5A = new Array(7);
var getInfo6A = new Array(7);
var getInfo2_3A = new Array(7);
var getInfo2_7A = new Array(7);
var getInfo5_2A = new Array(7);
var return1a = new Array(7);

$(document).ready (function() {
    $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
        if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $('#tabla_deposito_seriedad thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);
        $('input', this).on('keyup change', function () {
            if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value) {
                $('#tabla_deposito_seriedad').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('#tabla_deposito_seriedad').DataTable(
        {
        ajax: {
            "url": general_base_url + 'Contraloria/getAllDsByLider',
            "dataSrc": ""
        },
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        columns: [{
            "data": "nombreResidencial"
        },
        {
            "data": "nombreCondominio"
        },
        {
            "data": "nombreLote"
        },
        {
            "data": function( d ){
                return d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno;
            }
        },
        {
            "data": function( d ){ 
                return d.fechaApartado.split('.')[0];
            }
        },
        {
            "data": function ( d ){ 
                return d.fechaVenc.split('.')[0];
            }
        },
        {
            "data": function( d ){
                comentario = d.idMovimiento == 31 ? d.comentario + "<br> <span class='label lbl-green'>Nuevo apartado</span>":
                d.idMovimiento == 85 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloria estatus 2</span>":
                d.idMovimiento == 20 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloria estatus 5</span>":
                d.idMovimiento == 63 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloria estatus 6</span>":
                d.idMovimiento == 73 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Ventas estatus 8</span>":
                d.idMovimiento == 82 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>":
                d.idMovimiento == 92 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Contraloria estatus 5</span>":
                d.idMovimiento == 96 ?  d.comentario + "<br> <span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>":
                d.comentario;
                return comentario;
            }
        },
        {
            "data": function( d ){
                buttonst = d.idMovimiento == 31 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo2" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.idMovimiento == 85 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_2 btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.idMovimiento == 20 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo5" data-toggle="tooltip" data-placement="left" title="Enviar estatus"> <i class="fas fa-check"></i></a>':
                d.idMovimiento == 63 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green getInfo6" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.idMovimiento == 73 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_3 btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.idMovimiento == 82 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="getInfo2_7 btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a':
                d.idMovimiento == 92 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.modificado+'" class="getInfo5_2 btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.idMovimiento == 96 ?  '<a href="#" data-nomLote="'+d.nombreLote+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'" data-fechavenc="'+d.fechaVenc+'" class="btn-data btn-green return1" data-toggle="tooltip" data-placement="left" title="Enviar estatus"><i class="fas fa-check"></i></a>':
                d.comentario;
                return `<div class="d-flex justify-center">${buttonst}</div>`;
            }
        },
        {
            "data": function( d ){
                return `<div class="d-flex justify-center"><a class="btn-data btn-blueMaderas" href="${general_base_url}Asesor/deposito_seriedad/'+d.id_cliente+'/0" data-toggle="tooltip" data-placement="left" title= "Depósito de seriedad"><i class="fas fa-print"></i></a></div>`;
            }
        }],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });

    $(document).on("click", ".getInfo2", function(e){
        e.preventDefault();
        getInfo2A[0] = $(this).attr("data-idCliente");
        getInfo2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2A[3] = $(this).attr("data-idCondominio");
        getInfo2A[4] = $(this).attr("data-nombreLote");
        getInfo2A[5] = $(this).attr("data-idLote");
        getInfo2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal1').modal('show');
    });

    $(document).on("click", ".getInfo2_2", function(e){
        e.preventDefault();
        getInfo2_2A[0] = $(this).attr("data-idCliente");
        getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_2A[3] = $(this).attr("data-idCondominio");
        getInfo2_2A[4] = $(this).attr("data-nombreLote");
        getInfo2_2A[5] = $(this).attr("data-idLote");
        getInfo2_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal2').modal('show');
    });

    $(document).on("click", ".getInfo5", function(e){
        e.preventDefault();
        getInfo5A[0] = $(this).attr("data-idCliente");
        getInfo5A[1] = $(this).attr("data-nombreResidencial");
        getInfo5A[2] = $(this).attr("data-nombreCondominio");
        getInfo5A[3] = $(this).attr("data-idCondominio");
        getInfo5A[4] = $(this).attr("data-nombreLote");
        getInfo5A[5] = $(this).attr("data-idLote");
        getInfo5A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal3').modal('show');
    });

    $(document).on("click", ".getInfo6", function(e){
        e.preventDefault();
        getInfo6A[0] = $(this).attr("data-idCliente");
        getInfo6A[1] = $(this).attr("data-nombreResidencial");
        getInfo6A[2] = $(this).attr("data-nombreCondominio");
        getInfo6A[3] = $(this).attr("data-idCondominio");
        getInfo6A[4] = $(this).attr("data-nombreLote");
        getInfo6A[5] = $(this).attr("data-idLote");
        getInfo6A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal4').modal('show');
    });

    $(document).on("click", ".getInfo2_3", function(e){
        e.preventDefault();
        getInfo2_3A[0] = $(this).attr("data-idCliente");
        getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_3A[3] = $(this).attr("data-idCondominio");
        getInfo2_3A[4] = $(this).attr("data-nombreLote");
        getInfo2_3A[5] = $(this).attr("data-idLote");
        getInfo2_3A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal5').modal('show');
    });

    $(document).on("click", ".getInfo2_7", function(e){
        e.preventDefault();
        getInfo2_7A[0] = $(this).attr("data-idCliente");
        getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
        getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
        getInfo2_7A[3] = $(this).attr("data-idCondominio");
        getInfo2_7A[4] = $(this).attr("data-nombreLote");
        getInfo2_7A[5] = $(this).attr("data-idLote");
        getInfo2_7A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal6').modal('show');
    });

    $(document).on("click", ".getInfo5_2", function(e){
        e.preventDefault();
        getInfo5_2A[0] = $(this).attr("data-idCliente");
        getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
        getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
        getInfo5_2A[3] = $(this).attr("data-idCondominio");
        getInfo5_2A[4] = $(this).attr("data-nombreLote");
        getInfo5_2A[5] = $(this).attr("data-idLote");
        getInfo5_2A[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal7').modal('show');
    });

    $(document).on("click", ".return1", function(e){
        e.preventDefault();
        return1a[0] = $(this).attr("data-idCliente");
        return1a[1] = $(this).attr("data-nombreResidencial");
        return1a[2] = $(this).attr("data-nombreCondominio");
        return1a[3] = $(this).attr("data-idCondominio");
        return1a[4] = $(this).attr("data-nombreLote");
        return1a[5] = $(this).attr("data-idLote");
        return1a[6] = $(this).attr("data-fechavenc");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#modal_return1').modal('show');
    });
});

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/intExpAsesor/',
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'MISSING_DOCUMENTS'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de incluir los documentos; IDENTIFICACIÓN OFICIAL, COMPROBANTE DE DOMICILIO, RECIBOS DE APARTADO Y ENGANCHE y DEPÓSITO DE SERIEDAD antes de llevar a cabo el avance.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save1').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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
    dataExp2.append("idCliente", getInfo2_2A[0]);
    dataExp2.append("nombreResidencial", getInfo2_2A[1]);
    dataExp2.append("nombreCondominio", getInfo2_2A[2]);
    dataExp2.append("idCondominio", getInfo2_2A[3]);
    dataExp2.append("nombreLote", getInfo2_2A[4]);
    dataExp2.append("idLote", getInfo2_2A[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo2_2A[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save2').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/intExpAsesor/',
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
            response = JSON.parse(data);
            if(response.message == 'OK') {
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if(response.message == 'FALSE'){
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if(response.message == 'ERROR'){
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
            },
            error: function( data ){
                $('#save2').prop('disabled', false);
                $('#modal2').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function(e) {
    e.preventDefault();
    var comentario = $("#comentario3").val();
    var validaComent = ($("#comentario3").val().length == 0) ? 0 : 1;
    var dataExp3 = new FormData();
    dataExp3.append("idCliente", getInfo5A[0]);
    dataExp3.append("nombreResidencial", getInfo5A[1]);
    dataExp3.append("nombreCondominio", getInfo5A[2]);
    dataExp3.append("idCondominio", getInfo5A[3]);
    dataExp3.append("nombreLote", getInfo5A[4]);
    dataExp3.append("idLote", getInfo5A[5]);
    dataExp3.append("comentario", comentario);
    dataExp3.append("fechaVenc", getInfo5A[6]);
    
    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
        url : general_base_url + 'asesor/editar_registro_loteRevision_asistentesAContraloria_proceceso2/',
        data: dataExp3,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save3').prop('disabled', false);
                    $('#modal3').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save3').prop('disabled', false);
                $('#modal3').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save4', function(e) {
    e.preventDefault();
    var comentario = $("#comentario4").val();
    var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
    var dataExp4 = new FormData();
    dataExp4.append("idCliente", getInfo6A[0]);
    dataExp4.append("nombreResidencial", getInfo6A[1]);
    dataExp4.append("nombreCondominio", getInfo6A[2]);
    dataExp4.append("idCondominio", getInfo6A[3]);
    dataExp4.append("nombreLote", getInfo6A[4]);
    dataExp4.append("idLote", getInfo6A[5]);
    dataExp4.append("comentario", comentario);
    dataExp4.append("fechaVenc", getInfo6A[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save4').prop('disabled', true);
        $.ajax({
        url : general_base_url + 'asesor/editar_registro_loteRevision_asistentesAContraloria6_proceceso2/',
        data: dataExp4,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save4').prop('disabled', false);
                    $('#modal4').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#save4').prop('disabled', false);
                $('#modal4').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save5', function(e) {
    e.preventDefault();
    var comentario = $("#comentario5").val();
    var validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;
    var dataExp5 = new FormData();
    dataExp5.append("idCliente", getInfo2_3A[0]);
    dataExp5.append("nombreResidencial", getInfo2_3A[1]);
    dataExp5.append("nombreCondominio", getInfo2_3A[2]);
    dataExp5.append("idCondominio", getInfo2_3A[3]);
    dataExp5.append("nombreLote", getInfo2_3A[4]);
    dataExp5.append("idLote", getInfo2_3A[5]);
    dataExp5.append("comentario", comentario);
    dataExp5.append("fechaVenc", getInfo2_3A[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save5').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2/',
            data: dataExp5,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
            response = JSON.parse(data);
            if(response.message == 'OK') {
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if(response.message == 'FALSE'){
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if(response.message == 'ERROR'){
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
            },
            error: function( data ){
                $('#save5').prop('disabled', false);
                $('#modal5').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save6', function(e) {
    e.preventDefault();
    var comentario = $("#comentario6").val();
    var validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
    var dataExp6 = new FormData();
    dataExp6.append("idCliente", getInfo2_7A[0]);
    dataExp6.append("nombreResidencial", getInfo2_7A[1]);
    dataExp6.append("nombreCondominio", getInfo2_7A[2]);
    dataExp6.append("idCondominio", getInfo2_7A[3]);
    dataExp6.append("nombreLote", getInfo2_7A[4]);
    dataExp6.append("idLote", getInfo2_7A[5]);
    dataExp6.append("comentario", comentario);
    dataExp6.append("fechaVenc", getInfo2_7A[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save6').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/envioRevisionAsesor2aJuridico7/',
            data: dataExp6,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
            response = JSON.parse(data);
            if(response.message == 'OK') {
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if(response.message == 'FALSE'){
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if(response.message == 'ERROR'){
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
            },
            error: function( data ){
                $('#save6').prop('disabled', false);
                $('#modal6').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save7', function(e) {
    e.preventDefault();
    var comentario = $("#comentario7").val();
    var validaComent = ($("#comentario7").val().length == 0) ? 0 : 1;
    var dataExp7 = new FormData();
    dataExp7.append("idCliente", getInfo5_2A[0]);
    dataExp7.append("nombreResidencial", getInfo5_2A[1]);
    dataExp7.append("nombreCondominio", getInfo5_2A[2]);
    dataExp7.append("idCondominio", getInfo5_2A[3]);
    dataExp7.append("nombreLote", getInfo5_2A[4]);
    dataExp7.append("idLote", getInfo5_2A[5]);
    dataExp7.append("comentario", comentario);
    dataExp7.append("fechaVenc", getInfo5_2A[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#save7').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2/',
            data: dataExp7,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                    $('#save7').prop('disabled', false);
                    $('#modal7').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#b_return1', function(e) {
    e.preventDefault();
    var comentario = $("#comentario8").val();
    var validaComent = ($("#comentario8").val().length == 0) ? 0 : 1;
    var dataExp8 = new FormData();
    dataExp8.append("idCliente", return1a[0]);
    dataExp8.append("nombreResidencial", return1a[1]);
    dataExp8.append("nombreCondominio", return1a[2]);
    dataExp8.append("idCondominio", return1a[3]);
    dataExp8.append("nombreLote", return1a[4]);
    dataExp8.append("idLote", return1a[5]);
    dataExp8.append("comentario", comentario);
    dataExp8.append("fechaVenc", return1a[6]);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }

    if (validaComent == 1) {
        $('#b_return1').prop('disabled', true);
        $.ajax({
            url : general_base_url + 'asesor/return1aaj/',
            data: dataExp8,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                if(response.message == 'OK') {
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if(response.message == 'FALSE'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if(response.message == 'ERROR'){
                    $('#b_return1').prop('disabled', false);
                    $('#modal_return1').modal('hide');
                    $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function( data ){
                $('#b_return1').prop('disabled', false);
                $('#modal_return1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function(){
    jQuery('#modal1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
    jQuery('#modal2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario2').val('');
    })
    jQuery('#modal3').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
    jQuery('#modal4').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario4').val('');
    })
    jQuery('#modal5').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario5').val('');
    })
    jQuery('#modal6').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario6').val('');
    })
    jQuery('#modal7').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario7').val('');
    })
    jQuery('#modal_return1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario8').val('');
    })
})