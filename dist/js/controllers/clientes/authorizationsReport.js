$(document).ready(function () {
    construirHead("authorizationsTable");

    let funcionToGetData = '';
    funcionToGetData = (id_rol_general == 1) ? `${general_base_url}Clientes/getAuthorizationsByDirector` : `${general_base_url}Clientes/getAuthorizationsBySubdirector`

    let tabla_6 = $('#authorizationsTable').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr:  _('descargar-excel'),
            title: "Lista de autorizaciones",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
            className: 'btn buttons-pdf',
            titleAttr:  _('descargar-pdf'),
            title: "Lista de autorizaciones",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
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
                data: function (d) {
                    if (d.estatus == 0) {
                        return '<span class="label lbl-green" data-i18n="autorizada">Autorizada</span>';
                    } else if (d.estatus == 1) {
                        return '<span class="label lbl-grayDark" data-i18n="pendiente">Pendiente</span>';
                    } else if (d.estatus == 2) {
                        return '<span class="label lbl-warning" data-i18n="rechazada">Rechazada</span>';
                    } else {
                        return '<span class="label lbl-azure">En DC</span>';
                    }
                }
            },
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            {
                data: function (d) {
                    var as1 = (d.asesor == null ? "" : d.asesor + '<br>');
                    return as1;
                }
            },
            {
                data: function (d) {
                    var cliente = (d.cliente == null ? "" : d.cliente);
                    return cliente;
                }
            },
            {
                data: function (d) {
                    var cliente = (d.cliente == null ? "" : d.autorizacion);
                    return cliente;
                }
            },
            { "data": "comentario" },
                /*,
                {
                    "data": function( d ){
                        return '<button class="btn btn btn-round btn-fab btn-fab-mini getInfo" data-id_autorizacion="'+d.id_autorizacion+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" ' + 'data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" ' + 'data-idLote="'+d.idLote+'" style="margin-right: 3px;background-color:#2E4053;border-color:#2E4053"><i class="material-icons">remove_red_eye</i></button>';
                    }
                }*/
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: funcionToGetData,
            type: "POST",
            cache: false,
        }
    });

    applySearch(tabla_6);

    $("#authorizationsTable tbody").on("click", ".getInfo", function (e) {
        e.preventDefault();
        var $itself = $(this);
        var idCliente = $itself.attr("data-idCliente");
        var nombreResidencial = $itself.attr('data-nombreresidencial');
        var nombreCondominio = $itself.attr('data-nombrecondominio');
        var idCondominio = $itself.attr("data-idCondominio");
        var nombreLote = $itself.attr("data-nombrelote");
        var idLote = $itself.attr('data-idLote');
        var id_aut = $itself.attr('data-id_autorizacion');
        $('#idCliente').val(idCliente);
        $('#idCondominio').val(idCondominio);
        $('#idLote').val(idLote);
        $('#id_autorizacion').val(id_aut);
        $('#nombreResidencial').val(nombreResidencial);
        $('#nombreCondominio').val(nombreCondominio);
        $('#nombreLote').val(nombreLote);

        $.post("<?=base_url()?>index.php/Clientes/getAuthorizationDetails/" + idLote, function (data) {
            $('#loadAuts').empty();
            var ctn;
            var p = 0;
            var opcionDenegado;
            $.each(JSON.parse(data), function (i, item) {

                if (id_rol_general == 1) {
                    opcionDenegado = '';
                }
                else {
                    opcionDenegado = '<label><input type="radio" name="accion' + i + '" value="3" required> Enviar a DC</label><br>';
                }

                    ctn ='<table width="100%">' +
                        '<tr>' +
                        '<td width="100%">' +
                        '<label>Solicitud asesor <small>(' + item['fecha_creacion'] + ')</small>:</label><br><p><i>' + item['autorizacion'] + '</i></p></td>' +
                        '<tr/>' +
                        '<tr>' +
                        '<td width="100%">' +
                        '<div class="form-group label-floating is-empty">\n' +
                        '                                            <label class="control-label">Comentario</label>\n' +
                        '<input type="text" name="observaciones' + i + '" class="form-control" placeholder="" required><br><br>' +
                        '                                        <span class="material-input"></span></div>' +

                        '<input type="hidden" name="idAutorizacion' + i + '"  value="' + item['id_autorizacion'] + '">' +
                        '</td>' +
                        '<tr/>' +
                        '<tr>' +

                        '<td>' +
                        '<div class="input-group"><label class="input-group-btn"><span class="btn btn-primary btn-file">' +
                        'Seleccionar archivo&hellip;<input type="file" name="docArchivo' + i + '" id="expediente' + i + '" style="display: none;">' +
                        '</span></label><input type="text" class="form-control" id= "txtexp' + i + '" readonly></div><br><br>' +
                        '</td>' +
                        '<tr/>' +
                        '<tr>' +
                        '<div class="input-group" >' +
                        '<td style="text-align:center;">' +
                        '<div class="col-md-4">' +
                        '<label><input type="radio" name="accion' + i + '" value="0" required> Aceptar</label>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        '<label><input type="radio" name="accion' + i + '" value="2" required> Denegar</label>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        opcionDenegado +
                        '</div>' +
                        '</td>' +
                        '</div>' +
                        '</tr></table>' +
                        '<hr style="border:1px solid #eee">';
                $('#loadAuts').append(ctn);

                p++;
            });
            $('#numeroDeRow').val(p);
        });
        $('#addFile').modal('show');
    });
});

$(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
    var input = $(this).closest('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;
    if (input.length) {
        input.val(log);
    } else {
        if (log) alert(log);
    }
});

$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    console.log('triggered');
});

$(document).on('click', '#save', function (e) {
    e.preventDefault();

    var idCliente = miArray[0];
    var nombreResidencial = miArray[1];
    var nombreCondominio = miArray[2];
    var idCondominio = miArray[3];
    var nombreLote = miArray[4];
    var idLote = miArray[5];
    var expediente = $("#expediente")[0].files[0];
    var motivoAut = $("#motivoAut").val();


    var data = new FormData();

    data.append("idCliente", idCliente);
    data.append("nombreResidencial", nombreResidencial);
    data.append("nombreCondominio", nombreCondominio);
    data.append("idCondominio", idCondominio);
    data.append("nombreLote", nombreLote);
    data.append("idLote", idLote);
    data.append("expediente", expediente);
    data.append("motivoAut", motivoAut);

    var file = (expediente == undefined) ? 0 : 1;


    if (motivoAut.length <= 10 || file == 0) {
        //toastr.error('Todos los campos son obligatorios y/o mayores a 10 caracteres.');
        alerts.showNotification('top', 'right', 'Todos los campos son obligatorios y/o mayores a 10 caracteres.', 'danger');
    }

    if (motivoAut.length > 10 && file == 1) {
        $.ajax({
            url: "addFileVentas",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (data) {
                //toastr.success('Autorización enviada.', 'Alerta de éxito');
                alerts.showNotification('top', 'right', 'Autorización enviada', 'success');
                $('#addFile').modal('hide');
                $('#authorizationsTable').DataTable().ajax.reload();
            },
            error: function (data) {
                alerts.showNotification('top', 'right', 'Error al enviar autorización', 'danger');
                //toastr.error('Error al enviar autorización.', 'Alerta de error');
            }
        });
    }
});

jQuery(document).ready(function () {
    jQuery('#addFile').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#expediente').val('');
        jQuery(this).find('#txtexp').val('');
        jQuery(this).find('#motivoAut').val('');

    })
});

$("#filtro4").on("change", function () {
    $('#authorizationsTable').DataTable().ajax.reload();
});



