let titulosInventario = [];
$('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
    if (i != 0) {
        var title = $(this).text();
        titulosInventario.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tabla_ingresar_9').DataTable().column(i).search() !== this.value)
                $('#tabla_ingresar_9').DataTable().column(i).search(this.value).draw();
        });
    }
});
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
$("#tabla_ingresar_9").ready(function () {
    tabla_9 = $("#tabla_ingresar_9").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Registro estatus 9',
            title: "Registro estatus 9",
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
            titleAttr: 'Registro estatus 9',
            title: "Registro estatus 9",
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosInventario[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [{
            className: 'details-control',
            orderable: false,
            data: null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function (d) {
                return `<span class="label lbl-azure">${d.tipo_venta}</span>`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        { data: 'nombreResidencial' },
        { data: 'nombreCondominio' },
        { data: 'nombreLote' },
        { data: 'nombreCliente' },
        { data: 'gerente' },
        {
            data: function (d) {
                let respuesta = '';
                if (d.residencia == 0 || d.residencia == null)
                    respuesta = '<p class="m-0">NACIONAL</p>';
                else
                    respuesta = '<p class="m-0">EXTRANJERO</p>';
                return respuesta;
            }
        },
        {
            data: function (d) {
                return `<span class="label lbl-azure">${d.nombreSede}</span>`;
            }
        },
        {
            orderable: false,
            data: function (d) {
                var cntActions;
                if (d.vl == '1')
                    cntActions = 'EN PROCESO DE LIBERACIÓN';
                else {
                    /*if (d.tipo_proceso != 'Normal' && d.validacionContratoFirmado == 0)
                        cntActions = `<span class="label lbl-blueMaderas">Pendiente carga de contrato firmado</span>`;
                    else if ((d.tipo_proceso != 'Normal' && d.validacionContratoFirmado == 1) || d.tipo_proceso == 'Normal')*/
                        cntActions = `<button href="#" data-idLote="${d.idLote}" data-residencia="${d.residencia}" data-nomLote="${d.nombreLote}" data-idCond="${d.idCondominio}" data-idCliente="${d.id_cliente}" data-fecVen="${d.fechaVenc}" data-ubic="${d.ubicacion}" data-code="${d.cbbtton}" data-idArcus="${d.id_arcus}" data-lugarProspeccion="${d.lugar_prospeccion}" data-idProspecto="${d.id_prospecto}" class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS"><i class="fas fa-thumbs-up"></i></button>`;
                    if (d.tipo_proceso == 'Normal')
                        cntActions += `<button href="#" data-idLote="${d.idLote}" data-nomLote="${d.nombreLote}" data-idCond="${d.idCondominio}" data-idCliente="${d.id_cliente}" data-fecVen="${d.fechaVenc}" data-ubic="${d.ubicacion}" data-code="${d.cbbtton}" class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO DE ESTATUS"><i class="fas fa-thumbs-down"></i></button>`;
                }
                return `<div class='d-flex justify-center'>${cntActions}</div>`;
            }
        }],
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Contraloria/getregistroStatus9ContratacionContraloria`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
        order: [[1, 'asc']]
    });

    $('#tabla_ingresar_9').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_9.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            var fechaVenc;
            if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38)
                status = 'Status 8 listo (Asistentes de Gerentes)';
            else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65)
                status = 'Status 8 enviado a Revisión (Asistentes de Gerentes)';
            else
                status = 'N/A';
            if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
                row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
                fechaVenc = row.data().fechaVenc;
            }
            else
                fechaVenc = 'N/A';
            var informacion_adicional = '<div class="container subBoxDetail">';
            informacion_adicional += '  <div class="row">';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" margin-bottom: 7px">';
            informacion_adicional += '          <label><b>Información adicional</b></label>';
            informacion_adicional += '      </div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ESTATUS: </b>' + status + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COMENTARIO: </b> ' + row.data().comentario + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA VENCIMIENTO: </b> ' + fechaVenc + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>FECHA REALIZADO: </b> ' + row.data().modificado + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>COORDINADOR: </b> ' + row.data().coordinador + '</label></div>';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>ASESOR: </b> ' + row.data().asesor + '</label></div>';
            informacion_adicional += '  </div>';
            informacion_adicional += '</div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#tabla_ingresar_9 tbody").on("click", ".editReg", function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        getInfo1[8] = $(this).attr("data-idArcus"); // ID DE ARCUS
        getInfo1[9] = $(this).attr("data-lugarProspeccion"); // LUGAR DE PROSPECCIÓN
        getInfo1[10] = $(this).attr("data-idProspecto"); // ID PROSPECTO
        nombreLote = $(this).data("nomlote");
        let residencia = $(this).attr("data-residencia") != 1 ? 0 : 1;
        $(".lote").html(nombreLote);
        $('#editReg').modal('show');
        $("#rl").val("");
        $("#residencia").val(residencia);
        $("#rl").selectpicker('refresh');
        $("#residencia").selectpicker('refresh');
    });

    $("#tabla_ingresar_9 tbody").on("click", ".cancelReg", function (e) {
        e.preventDefault();
        getInfo3[0] = $(this).attr("data-idCliente");
        getInfo3[1] = $(this).attr("data-nombreResidencial");
        getInfo3[2] = $(this).attr("data-nombreCondominio");
        getInfo3[3] = $(this).attr("data-idcond");
        getInfo3[4] = $(this).attr("data-nomlote");
        getInfo3[5] = $(this).attr("data-idLote");
        getInfo3[6] = $(this).attr("data-fecven");
        getInfo3[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechReg').modal('show');
    });
});

$(document).on('click', '#save1', function (e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var totalNeto2 = $("#totalNeto2").val();
    var rl = $("#rl").val();
    var residencia = $("#residencia").val();
    var sedeRecepcion = $("#sedeRecepcion").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var validatn = ($("#totalNeto2").val().length == 0) ? 0 : 1;
    var validaRL = ($("#rl").val().length == 0) ? 0 : 1;
    var validaResidencia = ($("#residencia").val().length == 0) ? 0 : 1;
    var validaSedeRecepcion = ($("#sedeRecepcion").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    dataExp1.append("totalNeto2", totalNeto2);
    dataExp1.append("rl", rl);
    dataExp1.append("residencia", residencia);
    dataExp1.append("sedeRecepcion", sedeRecepcion);
    // INFORMACIÓN PARA ENVIAR A ARCUS
    dataExp1.append("uid", getInfo1[8]); // id_arcus
    dataExp1.append("lugar_prospeccion", getInfo1[9]); // lugar_prospeccion
    dataExp1.append("id_prospecto", getInfo1[10]); // id_prospecto
    if (validaComent == 0 || validatn == 0 || validaRL == 0 || validaResidencia == 0 || validaSedeRecepcion == 0)
        alerts.showNotification("top", "right", "Todos los campos son obligatorios.", "danger");
    if (validaComent == 1 && validatn == 1 && validaRL == 1 && validaResidencia == 1 && validaSedeRecepcion == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Contraloria/editar_registro_lote_contraloria_proceceso9`,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', "Estatus enviado correctamente.", 'success');
                } else if (response.message == 'FALSE') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#tabla_ingresar_9').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save3', function (e) {
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
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Contraloria/editar_registro_loteRechazo_contraloria_proceceso9`,
            data: dataExp3,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_9').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save3').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#tabla_ingresar_9').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function () {
    fillSelectsForV9();
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

function SoloNumeros(evt) {
    if (window.event) {
        keynum = evt.keyCode;
    }
    else {
        keynum = evt.which;
    }
    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46) {
        return true;
    }
    else {
        alerts.showNotification("top", "right", "Recuerda sólo ingresar números.", "danger");
        return false;
    }
}

function fillSelectsForV9() {
    $.getJSON("fillSelectsForV9").done(function (data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 77) // REPRESENTANTE LEGAL SELECT
                $("#rl").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 78) // RESIDENCIA SELECT
                $("#residencia").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            if (data[i]['id_sede'])
                $("#sedeRecepcion").append($('<option>').val(data[i]['id_sede']).text(data[i]['nombre']));
        }
        $('#rl').selectpicker('refresh');
        $('#residencia').selectpicker('refresh');
        $('#sedeRecepcion').selectpicker('refresh');
    });
}