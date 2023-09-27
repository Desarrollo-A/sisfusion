let titulosInventario = [];
$('#tabla_ingresar_5 thead tr:eq(0) th').each(function (i) {
    if (i != 0) {
        var title = $(this).text();
        titulosInventario.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tabla_ingresar_5').DataTable().column(i).search() !== this.value) {
                $('#tabla_ingresar_5').DataTable().column(i).search(this.value).draw();
            }
        });
    }
});

var getInfo1 = new Array(6);
var getInfo2 = new Array(6);

$(document).ready(function () {
    $.post("get_tventa", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_tventa'];
            var name = data[i]['tipo_venta'];
            $("#tipo_ventaenvARevCE").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#tipo_ventaenvARevCE").selectpicker('refresh');
    }, 'json');

    $.post("get_sede", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#ubicacion").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#ubicacion").selectpicker('refresh');
    }, 'json');
});

$("#tabla_ingresar_5").ready(function () {
    tabla_5 = $("#tabla_ingresar_5").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro estatus 5',
                title: "Registro estatus 5",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx - 1] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Registro estatus 5',
                title: "Registro estatus 5",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx - 1]  + ' ';
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
        scrollX: true,
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
            },
            {
                data: function (d) {
                    if ([4, 74, 93, 103].includes(d.idMovimiento))
                        return `<span class="label lbl-warning">CORRECIÓN</span>`;
                    else 
                        return `<span class="label lbl-green">NUEVO</span>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreResidencial + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + (d.nombreCondominio).toUpperCase(); +'</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.referencia + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.gerente + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.modificado + '</p>';
                }
            },
            {
                data: function (d) {
                    var fechaVenc;

                    if (d.idStatusContratacion == 2 && d.idMovimiento == 4 || d.idStatusContratacion == 2 && d.idMovimiento == 84)
                        fechaVenc = d.fechaVenc;
                    else if (d.idStatusContratacion == 2 && d.idMovimiento == 74 || d.idStatusContratacion == 2 && d.idMovimiento == 93)
                        fechaVenc = 'VENCIDO';
                    else
                        fechaVenc = 'N/A';

                    return '<p class="m-0">' + fechaVenc + '</p>';
                }
            },
            {
                data: function (d) {
                    var lastUc = (d.lastUc == null) ? 'SIN REGISTRO' : d.lastUc;
                    return '<p class="m-0">' + lastUc + '</p>';
                }
            },
            {
                data: function (d) {
                    if (d.sede == null || d.sede == '')
                        return `<span class="label lbl-gray">NO DEFINIDO</span>`;
                    else
                        return `<span class="label lbl-blueMaderas">${d.sede}</span>`;
                }
            },
            {
                data: function (d) {
                    let respuesta = '';
                    if (d.comentario == null || d.comentario == '')
                        respuesta = 'NO DEFINIDO';
                    else
                        respuesta = d.comentario;
                    return '<p class="m-0">' + respuesta + '</p>';
                }
            },
            {
                orderable: false,
                data: function (data) {

                    var cntActions;

                    if (data.vl == '1') {
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    }
                    else if(![4, 84, 101, 103, 74, 93].includes(data.idMovimiento)){
                        cntActions = 'N/A';
                    } 
                    else {
                            cntActions = 
                            '<button href="#"' + 
                            '" data-idLote="' + data.idLote + 
                            '" data-nomLote="' + data.nombreLote +
                            '" data-idCond="' + data.idCondominio +
                            '" data-idCliente="' + data.id_cliente +
                            '" data-fecVen="' + data.fechaVenc +
                            '" data-ubic="' + data.ubicacion +
                            '" title= "REGISTRAR STATUS" ' +
                            '" data-tipo-venta="' + data.tipo_venta +
                            '" data-proceso="'+ data.proceso +
                            '" data-nomRes="' + data.nombreResidencial +
                            '" data-nomCon="' + data.nombreCondominio +
                            '" data-idMov="' + data.idMovimiento + 
                            '" class="statRev btn-data btn-green" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                            '<i class="fas fa-thumbs-up"></i></button>';

                            cntActions +=
                            '<button href="#"' +
                            '" data-idLote="' + data.idLote +
                            '" data-nomLote="' + data.nombreLote +
                            '" data-idCond="' + data.idCondominio +
                            '" data-idCliente="' + data.id_cliente +
                            '" data-fecVen="' + data.fechaVenc +
                            '" data-ubic="' + data.ubicacion +
                            '" data-nomRes="' + data.nombreResidencial +
                            '" data-nomCon="' + data.nombreCondominio +
                            '" data-idMov="' + data.idMovimiento + 
                            '" class="rechazarEdit btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="RECHAZAR ESTATUS">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                    }
                    return '<div class="d-flex justify-center">' + cntActions + '</div>';
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
            url: "getregistroStatus5ContratacionContraloria",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {}
        },
        order: [[1, 'asc']]
    });

    $('#tabla_ingresar_5 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_5.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            if (
                (row.data().idStatusContratacion == 2 &&
                row.data().idMovimiento == 4) ||
                (row.data().idStatusContratacion == 2 &&
                row.data().idMovimiento == 74) ||
                (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 93)
            ) {
                status = 'Status 2 enviado a Revisión (Asesor)';
            } else if (row.data().idStatusContratacion == 2 && row.data().idMovimiento == 84) {
                status = 'Listo status 2 (Asesor)';
            }
            else {
                status = 'N/A';
            }

            var informacion_adicional = '<div class="container subBoxDetail">';
            informacion_adicional += '  <div class="row">';
            informacion_adicional += 
                '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12 skyOpacity" margin-bottom: 7px">';
            informacion_adicional +=
            '          <label><b>Información adicional</b></label>';
            informacion_adicional += '      </div>';
            informacion_adicional +=
            '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS </b>' +
            status +
            '</label></div>';
            informacion_adicional +=
            '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO </b> ' +
            row.data().comentario +
            '</label></div>';
            informacion_adicional +=
            '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR </b> ' +
            row.data().coordinador +
            '</label></div>';
            informacion_adicional +=
            '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR </b> ' +
            row.data().asesor +
            '</label></div>';
            informacion_adicional += '  </div>';
            informacion_adicional += '</div>';

            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });
});

    $('#tabla_ingresar_5').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

/*modal para enviar a revision corrida elaborada*/
$(document).on('click', '.statRev', function () {
    const tipoVenta = $(this).attr('data-tipo-venta');
    const proceso = $(this).attr('data-proceso');
    const ubicacion = $(this).attr('data-ubic');
    const idMovimiento = parseInt($(this).attr('data-idMov'));

    document.getElementById('tituloLote').innerHTML = $(this).attr('data-nomLote');

    $('#nombreLoteenvARevCE').val($(this).attr('data-nomLote')); 
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
    $('#idCondominioenvARevCE').val($(this).attr('data-idCond'));
    $('#idClienteenvARevCE').val($(this).attr('data-idCliente'));
    $('#fechaVencenvARevCE').val($(this).attr('data-fecVen'));
    $('#nomResidencialARev').val($(this).attr('data-nomRes'));
    $('#nomCondominioARev').val($(this).attr('data-nomCon'));
    $('#idMovARev').val(idMovimiento);
    $('#tvLbl').removeClass('hide');
    $('#ubicacion-options-div').attr('hidden', false);

    if([4, 84, 101, 103].includes(idMovimiento)){

        if (tipoVenta == 1) {
            $('#tipo-venta-options-div').attr('hidden', true);
            $('#tipo-venta-particular-div').attr('hidden', false);
            $('#tipo_ventaenvARevCE').val(tipoVenta);
        } else {
            $('#tipo-venta-options-div').attr('hidden', false);
            $('#tipo-venta-particular-div').attr('hidden', true);
        }
    
        if ([2, 3, 4].includes(proceso)) {
            if (tipoVenta != 0) {
                $('#tipo_ventaenvARevCE').val(tipoVenta).change();
            }
    
            if (ubicacion != 0) {
                $('#ubicacion').val(ubicacion).change();
            }
        } else {
            $('#tipo_ventaenvARevCE').prop('disabled', false);
        }
    }
    else if([74, 93].includes(idMovimiento)){
        $('#tipo-venta-options-div').attr('hidden', true);
        $('#ubicacion-options-div').attr('hidden', true);
    }

    $("#comentarioenvARevCE").val('');
    $('#enviarenvARevCE').disabled = false;
    $('#envARevCE').modal();
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
    var nombreResidencial = $('#nomResidencialARev').val();
    var nombreCondominio = $("#nomCondominioARev").val();
    var idMovimiento = parseInt($("#idMovARev").val());

    var validatventa = ($("#tipo_ventaenvARevCE").val().trim() == '') ? 0 : 1;
    var validaUbicacion = ($("#ubicacion").val().trim() == '') ? 0 : 1;
    var validaComentario = ($("#comentarioenvARevCE").val().trim() == '') ? 0 : 1;
    var validationPass = false;

    if([4, 84, 101, 103].includes(idMovimiento)){
        if(validatventa == 0 || validaUbicacion == 0 ||validaComentario == 0)
            alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger');
        else
            validationPass = true;
    }
    else if([74, 93].includes(idMovimiento)){
        if(validaComentario == 0)
            alerts.showNotification('top', 'right', 'Todos los campos son requeridos', 'danger');
        else
            validationPass = true;
    }

    if(validationPass){
        var parametros = {
            "idLote": idLote,
            "idCondominio": idCondominio,
            "nombreLote": nombreLote,
            "idCliente": idCliente,
            "fechaVenc": fechaVenc,
            "ubicacion": ubicacion,
            "comentario": comentario,
            "tipo_venta": tipo_venta,
            "nombreResidencial" : nombreResidencial,
            "nombreCondominio" : nombreCondominio,
            "idMovimiento" : idMovimiento
        };

        $.ajax({
            url  : 'editar_registro_lote_contraloria_proceceso5',
            data : parametros,
            type : 'POST',
            success : function(data){
                response = JSON.parse(data);

                $('#envARevCE').modal('hide');
                $('#tabla_ingresar_5').DataTable().ajax.reload();

                if(response.status)
                    alerts.showNotification("top", "right", response.message, "success");
                else
                    alerts.showNotification("top", "right", response.message, "danger");
            },
            error : function(){
                alerts.showNotification("top", "right", "No se pueden enviar los datos", "danger");
            }
        });
    }
}

$(document).on("click", ".rechazarEdit", function (){
    const idMovimiento = parseInt($(this).attr('data-idMov'));
    document.getElementById('tituloLote2').innerHTML = $(this).attr('data-nomLote');

    $('#nombreLoteenvARevCE2').val($(this).attr('data-nomLote')); 
    $('#idLoteenvARevCE2').val($(this).attr('data-idLote'));
    $('#idCondominioenvARevCE2').val($(this).attr('data-idCond'));
    $('#idClienteenvARevCE2').val($(this).attr('data-idCliente'));
    $('#fechaVencenvARevCE2').val($(this).attr('data-fecVen'));
    $('#nomResidencialARev2').val($(this).attr('data-nomRes'));
    $('#nomCondominioARev2').val($(this).attr('data-nomCon'));
    $('#idMovARev2').val(idMovimiento);

    $("#motivoRechazo").val('');
    $('#guardar').disabled = false;
    $('#rechazarStatus').modal();
});

function envRechazo(){
    var nombreLote = $("#nombreLoteenvARevCE2").val();
    var idLote = $("#idLoteenvARevCE2").val();
    var idCondominio = $("#idCondominioenvARevCE2").val();
    var idCliente = $("#idClienteenvARevCE2").val();
    var fechaVenc = $("#fechaVencenvARevCE2").val();
    var nombreResidencial = $('#nomResidencialARev2').val();
    var nombreCondominio = $("#nomCondominioARev2").val();
    var idMovimiento = parseInt($("#idMovARev2").val());
    var motivoRechazo = $("#motivoRechazo").val();
    var validationPass = false;

    var validaMotivo = ($("#motivoRechazo").val().trim() == '') ? 0 : 1;

    if(validaMotivo == 0)
        alerts.showNotification("top", "right", "Todos los campos son requeridos", "danger");
    else
        validationPass = true;

    if(validationPass){
        var parametros = {
            "idLote": idLote,
            "nombreLote": nombreLote,
            "motivoRechazo": motivoRechazo,
            "idCliente": idCliente,
            "idCondominio": idCondominio,                        
            "fechaVenc": fechaVenc,            
            "nombreResidencial" : nombreResidencial,
            "nombreCondominio" : nombreCondominio,
            "idMovimiento" : idMovimiento
        };

        $.ajax({   
            url : 'editar_registro_loteRechazo_contraloria_proceso5',
            data : parametros,
            type : 'POST',
            success : function(data){
                console.log(data);
                console.log(response = JSON.parse(data));

                $('#rechazarStatus').modal('hide');
                $('#tabla_ingresar_5').DataTable().ajax.reload();

                if(response.status)
                    alerts.showNotification("top", "right", response.message, "success");
                else
                    alerts.showNotification("top", "right", response.message, "danger");
            },
            error : function(){
                alerts.showNotification("top", "right", "No se pueden enviar los datos", "danger");
            }
        });
    }
    
}


jQuery(document).ready(function () {

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
});