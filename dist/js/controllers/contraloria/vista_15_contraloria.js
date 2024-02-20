jQuery(document).ready(function () {
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
});
var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
let titulosInventario = [];
$("#tabla_ingresar_15").ready(function () {
    $('#tabla_ingresar_15 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulosInventario.push(title);
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_15.column(i).search() !== this.value)
                    tabla_15.column(i).search(this.value).draw();
            });
        }
    });

    tabla_15 = $("#tabla_ingresar_15").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registro estatus 15',
                title: "Registro estatus 15",
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8],
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
                titleAttr: 'Registro estatus 15',
                title: "Registro estatus 15",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx - 1] + ' ';
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
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
            {
                width: "3%",
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
                    return `<span class="label lbl-azure">${d.nombreSede}</span>`;
                }
            },
            {
                orderable: false,
                data: function (d) {
                    var cntActions;
                    if (d.vl == '1')
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    else
                        cntActions = `<button href="#" data-idLote="${d.idLote}" data-nomLote="${d.nombreLote}" data-idCond="${d.idCondominio}" data-idCliente="${d.id_cliente}" data-fecVen="${d.fechaVenc}" data-ubic="${d.ubicacion}" data-code="${d.cbbtton}" data-fechaArcus="${d.fecha_arcus}" data-idProspecto="${d.id_prospecto}" data-idArcus="${d.id_arcus}" data-totalNeto2="${d.totalNeto2}" data-lugarProspeccion="${d.lugar_prospeccion}" data-idResidencial="${d.idResidencial}" class="btn-data btn-green editReg"  data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS"><i class="fas fa-thumbs-up"></i></button>`;
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
            url: `${general_base_url}Contraloria/getregistroStatus15ContratacionContraloria`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });

    $('#tabla_ingresar_15').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_ingresar_15 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_15.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            var status;
            var fechaVenc;
            if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 44)
                status = 'ESTATUS 14 LISTO (ASISTENTES GERENTES)';
            else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 69)
                status = 'ESTATUS 14 ENVIADO A REVICIÓN (ASISTENTES GERENTES)';
            else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 80)
                status = 'ESTATUS 14 (REGRESO CONTRATACIÓN)';
            else
                status = 'N/A';

            if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 44 ||
                row.data().idStatusContratacion == 14 && row.data().idMovimiento == 69 ||
                row.data().idStatusContratacion == 14 && row.data().idMovimiento == 80) {
                fechaVenc = row.data().fechaVenc;
            } else
                fechaVenc = 'N/A';

            var informacion_adicional = '<div class="container subBoxDetail">';
            informacion_adicional += '  <div class="row">';
            informacion_adicional += '      <div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">';
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

    $("#tabla_ingresar_15 tbody").on("click", ".editReg", function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        getInfo1[8] = $(this).attr("data-fechaArcus");
        getInfo1[9] = $(this).attr("data-idProspecto");
        getInfo1[10] = $(this).attr("data-idArcus");
        getInfo1[11] = $(this).attr("data-totalNeto2");
        getInfo1[12] = $(this).attr("data-lugarProspeccion");
        getInfo1[13] = $(this).attr("data-idResidencial");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#editReg').modal('show');
    });

});

$(document).on('click', '#save1', function (e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    let dataArcus = {};
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    dataExp1.append("idResidencial", getInfo1[13]);

    // INFORMACIÓN PARA ENVIAR A ARCUS
    dataExp1.append("id", getInfo1[9]); // idProspecto
    dataExp1.append("propiedadRelacionada", getInfo1[5]); // idLote
    dataExp1.append("montoDelNegocio", parseFloat(getInfo1[11])); // totalNeto2
    dataExp1.append("fechaDeCompra", getInfo1[8]); // fechaArcus
    dataExp1.append("uid", getInfo1[10]); // idArcus
    dataExp1.append("estatus", 1); // SE CONSUME SERVICIO CUANDO SE REGISTRA ESTATUS 15 (15. Acuse entregado (Contraloría)) Y SE ENVÍA LA INFORMACIÓN DE LA VENTA
    dataExp1.append("lugar_prospeccion", parseInt(getInfo1[12])); // lugar_prospeccion

    if (validaComent == 0)
        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
    else {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Contraloria/editar_registro_lote_contraloria_proceceso15/`,
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
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', "Estatus enviado correctamente.", 'success');
                } else if (response.message == 'FALSE') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El estatus ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#tabla_ingresar_15').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});
