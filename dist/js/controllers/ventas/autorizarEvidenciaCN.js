$(document).ready(function () {
    let titulos_intxt = [];
    $('#autorizarEvidencias thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#autorizarEvidencias').DataTable().column(i).search() !== this.value) {
                $('#autorizarEvidencias').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    var table;
    table = $('#autorizarEvidencias').DataTable({
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Autorizaciones de evidencia',
            title:'Autorizaciones de evidencia',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr: 'Autorizaciones de evidencia',
            title: "Autorizaciones de evidencia",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        ordering: false,
        scrollX: true,
        pageLength: 10,
        language: {
            url: general_base_url +  "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columnDefs: [{
            defaultContent: "-",
            targets: "_all"
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        ajax: general_base_url + "Asesor/getAutsForContraloria/",
        columns: [{
        "data": "idLote"},
        {
            "data": function(d){
                return d.fechaApartado.split('.')[0]
            }
        },
        {"data": "plaza"},
        {"data": "nombreLote"},
        {"data": "cliente"},
        {"data": "solicitante"},
        {
            "data": function (d) {
                var labelStatus;
                switch (d.estatus) {
                    case '1':
                        labelStatus = '<span class="label lbl-azure">ENVIADA A COBRANZA</span>';
                        break;
                    case '10':
                        labelStatus = '<span class="label lbl-warning">COBRANZA RECHAZÓ LA EVIDENCIA AL GERENTE</span>';
                        break;
                    case '2':
                        labelStatus = '<span class="label lbl-green">SIN VALIDAR</span>';
                        break;
                    case '20':
                        labelStatus = '<span class="label lbl-orange">CONTRALORÍA RECHAZÓ LA EVIDENCIA</span>';
                        break;
                    case '3':
                        labelStatus = '<span class="label lbl-violetDeep">EVIDENCIA ACEPTADA</span>';
                        break;
                    default:
                        labelStatus = '<span class="label lbl-gray">SIN ESTATUS REGISTRADO</span>';
                        break;
                }
                return labelStatus;
            }
        },
        {
            "data": function (d) {
                if (d.rowType == 11 || d.rowType == 22) // MJ: CONTROVERSIA NORMAL / CONTROVERSIA PARA DESCUENTO
                    return "<small class='label lbl-green'>Normal</small>";
                else if (d.rowType == 33)//Implementación Venta nueva
                    return "<small class='label lbl-gray'>Venta nueva</small>";
                else if (d.rowType == 44)// MJ: CONTROVERSIA MKTD 2022
                    return "<small class='label lbl-violetBoots'>MKTD 2022</small>";
                else if (d.rowType == 55)// MJ: CONTROVERSIA CARGA MASIVA
                    return "<small class='label lbl-azure' >Carga masiva</small>"
                else // MJ: NO ES CONTROVERSIA
                    return "<small class='label lbl-green'>MKTD</small>"
            }
        },
        {
            "data": function(d){
                if(d.fechaValidacionGerente == '' || d.fechaValidacionGerente == null){
                    return 'SIN ESPECIFICAR'
                }else{
                    return d.fechaValidacionGerente.split('.')[0]
                }
            }
        },
        {
            "data": function(d){
                if(d.fechaValidacionCobranza == '' || d.fechaValidacionCobranza == null){
                    return 'SIN ESPECIFICAR'
                }else{
                    return d.fechaValidacionCobranza.split('.')[0]
                }
            }
        },
        {
            "data": function(d){
                if(d.fechaValidacionContraloria == '' || d.fechaValidacionContraloria == null){
                    return 'SIN ESPECIFICAR'
                }else{
                    return d.fechaValidacionContraloria.split('.')[0]
                }
            }
        },
        {
            "data": function(d){
                if(d.fechaRechazoCobranza == '' || d.fechaRechazoCobranza == null){
                    return 'SIN ESPECIFICAR'
                }else{
                    return d.fechaRechazoCobranza.split('.')[0]
                }
            }
        },
        {
            "data": function(d){
                if(d.fechaRechazoContraloria == '' || d.fechaRechazoContraloria == null){
                    return 'SIN ESPECIFICAR'
                }else{
                    return d.fechaRechazoContraloria.split('.')[0]
                }
            }
        },
        {
            "data": function (d) {
                var buttons = '';
                // buttons = '<button href="#" data-toggle="tooltip" data-placement="top" title= "Ver comentarios" data-id_autorizacion="' + d.id_evidencia + '" ' +
                //     'data-idLote="' + d.idLote + '" class="btn-data btn-blueMaderas seeAuts">' +
                //     '<i class="fas fa-comments"></i></button>'
                // if (d.estatus == 2) {
                    buttons += '<button href="#" title= "Validar evidencia" data-evidencia="' + d.evidencia + '" ' +
                        'data-id_evidencia="' + d.id_evidencia + '" data-idCliente="' + d.id_cliente + '" ' +
                        'data-nombrelote="' + d.nombreLote + '" data-rowType="' + d.rowType + '" data-idLote="' + d.idLote + '" ' +
                        'class="btn-data btn-green revisarSolicitud" style="margin-left: 3px;">' +
                        '<i class="fas fa-key"></i></button>';
                // }else{
                    buttons += '';
                // }
                return '<div style="display:inline-flex">' + buttons + '</div>';
            }
        }]
    });

    $('#autorizarEvidencias').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});

$(document).on('click', '.revisarSolicitud', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var id_evidencia = $itself.attr('data-id_evidencia');
    var idCliente = $itself.attr("data-idCliente");
    var nombreLote = $itself.attr("data-nombrelote");
    var idLote = $itself.attr('data-idLote');
    var evidencia = $itself.attr('data-evidencia');
    var rowType = $itself.attr('data-rowType');
    $('#idCliente').val(idCliente);
    $('#idLote').val(idLote);
    $('#id_evidencia').val(id_evidencia);
    $('#nombreLote').val(nombreLote);
    $('#evidencia_file').val(evidencia);
    $('#rowType').val(rowType);
    var cnt;
    var path_evidences = general_base_url + 'documentos/evidencia_mktd/';
    var extension_file = evidencia.split('.').pop();

    $.post(general_base_url + "Asesor/getSolicitudEvidencia/" + id_evidencia, function (data) {
        $('#loadAuts').empty();
        cnt = '<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 20px 0px;">';
        cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align: right">Fecha: ' + data[0]['fecha_creacion'] + '</p></div>';
        cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">';
        if (extension_file == 'png' || extension_file == 'jpg' || extension_file == 'jpeg' || extension_file == 'gif') {
            cnt += '<center><img src="' + path_evidences + data[0]['evidencia'] + '" class="img-responsive zoom"></center>';
        } else {
            cnt += '<iframe class="responsive-iframe" src="' + path_evidences + data[0]['evidencia'] + '" style="width: 100%;height: 400px;"></iframe>';
        }
        cnt += '    </div>';
        cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
        cnt += '    <label>Comentario cobranza</label><br>';
        cnt += '        <p style="text-align: justify;padding: 10px">' + data[0]['comentario_autorizacion'] + '</p>';
        cnt += '    </div>';
        cnt += '    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 10px">';
        cnt += '    <div class="radio-with-icon-autorizacones d-flex justify-center">';
        cnt += '    <div class="boxContent" style="margin-bottom:20px; padding: 10px; background: #f7f7f7; border-radius:15px">';
        cnt += '    <p class="radioOption-Item m-0">';            
        cnt += '            <label><input type="radio" class="d-none" name="accion" id="rechazoGer" value="0" required> Rechazar a cobranza</label>'; 
        cnt += '    </p>';
        cnt += '        <div class="col-md-6">';
        cnt += '            <label><input type="radio" name="accion" id="avanzaContra" value="1" required> Aceptar</label>';
        cnt += '        </div>';
        cnt += '        </div>';
        cnt += '        </div>';
        cnt += '        <div class="col-md-12">';
        cnt += '            <label>Escribe un comentario: </label>';
        cnt += '            <textarea class="text-modal" name="comentario_contra" id="comentariocontra"></textarea>';
        cnt += '        </div>';
        cnt += '    </div>';
        cnt += '</div>';


        $('#loadAuts').append(cnt);
    }, 'json');

    $('#evidenciaModalRev').modal();

});

$(document).on('click', '#btnSubmit', function () {
    if (document.getElementById('rechazoGer').checked == false && document.getElementById('avanzaContra').checked == false) {
        alerts.showNotification('top', 'right', 'Ingresa una acción', 'danger');
        $('#avanzaContra').focus();
        $("#btnSubmit").attr("onclick", "validaEnviarAutorizacion()");
    } else {
        $("#button_enviar").click();
    }
});

$("#sendRespFromCB").on('submit', function (e) { // MJ: FUNCIÓN PARA ACTUALIZAR EL ESTATUS DE LA EVIDENCIA / CONTROVERSIA
    let rowType = $("#rowType").val();
    let id_lote = $("#idLote").val();
    let comments = $("#comentariocontra").val();
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Asesor/actualizaSolEviCN',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {},
        success: function (data) {
            if (data == 1) {
                $('#evidenciaModalRev').modal("hide");
                $('#autorizarEvidencias').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "La validación se ha llevado a cabo de manera correcta.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

    if ((rowType == 11 || rowType == 22 || rowType == 33 || rowType == 44  || rowType == 55) && document.getElementById('avanzaContra').checked == true) { // MJ: CUANDO ES UNA CONTROVERSIA SE VA A MANDAR LLAMAR LA FUNCIÓN DE ADDREMOVEMKTD PARA AGREGAR MKTD
        $.ajax({
            type: 'POST',
            url: general_base_url + 'Comisiones/addRemoveMktd',
            data: {
                'type_transaction': 1,
                'comments': comments,
                'id_lote': id_lote
            },
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    alerts.showNotification('top', 'right', 'Se ha agregado MKTD de esta venta de manera exitosa.', 'success');
                } else {
                    alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'warning');
                }
            }, error: function () {
                alerts.showNotification('top', 'right', 'Oops, algo salió mal, inténtalo de nuevo.', 'danger');
            }
        });
    }
});