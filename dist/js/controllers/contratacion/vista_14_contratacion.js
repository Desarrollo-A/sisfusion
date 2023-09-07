var getInfo1 = new Array(6);

let titulos = [];
$("#tabla_ingresar_14").ready(function () {
    $('#tabla_ingresar_14 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulos.push(title);
            $(this).html('<input class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_14.column(i).search() !== this.value) {
                    tabla_14.column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_14 = $("#tabla_ingresar_14").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            filename:'Registro Estatus 14',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx - 1] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            className: 'details-control',
            orderable: false,
            data: null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function (d) {
                return `<span class="label lbl-green">${d.tipo_venta}</span>`;
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
                return '<p class="m-0">' + d.nombreCondominio +'</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';

            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.gerente + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.cliente +'</p>';
            }
        },
        {
            data: function (d) {
                return `<span class="label lbl-azure">${d.nombreSede}</span>`;
            }
        },
        {
            orderable: false,
            data: function (data) {
                if (id_rol_global != 53 && id_rol_global != 54 && id_rol_global != 63) { // ANALISTA DE COMISIONES Y SUBDIRECTOR CONSULTA (POPEA)
                    var cntActions;
                    if (data.vl == '1') {
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    }
                    else {
                        if (data.idStatusContratacion == 13 && data.idMovimiento == 43 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17 || data.perfil == 70)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                                'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR STATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';
                        }
                        else if (data.idStatusContratacion == 13 && data.idMovimiento == 68 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17 || data.perfil == 70)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" ' +
                                'class="revCont btn-data btn-orangeYellow" data-toggle="tooltip" data-placement="top" title= "REGISTRAR STATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';
                        }
                        else {
                            cntActions = 'N/A';
                        }
                    }
                    return '<div class="d-flex justify-center">' + cntActions + '</div>';
                }
                return '<span class="label lbl-warning">N/A</span>';
            }
        }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Asistente_gerente/getStatCont14`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {
            }
        },
    });

    $('#tabla_ingresar_14').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

    $('#tabla_ingresar_14 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_14.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        }
        else {
            var status;
            var fechaVenc;
            if (row.data().idStatusContratacion == 13 && row.data().idMovimiento == 43)
                status = "STATUS 13 LISTO (CONTRALORÍA)";
            else if (row.data().idStatusContratacion == 13 && row.data().idMovimiento == 68)
                status = "STATUS 14 RECHAZADO (CONTRALORÍA)";
            else
                status = "N/A";

            if (row.data().idStatusContratacion == 13 && row.data().idMovimiento == 43)
                fechaVenc = row.data().fechaVenc;
            else if (row.data().idStatusContratacion == 13 && row.data().idMovimiento == 68)
                fechaVenc = 'VENCIDO';
            else
                status = "N/A";

            var informacion_adicional = 
            '<div class="container subBoxDetail"><div class="row">'+
                '<div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">'+
                    '<label><b>INFORMACIÓN ADICIONAL</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>' + status + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Comentario: </b>' + row.data().comentario + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Fecha de vencimiento: </b>' + fechaVenc + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Fecha de realizado: </b>' + row.data().modificado + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Coordinador: </b>' + row.data().coordinador + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Asesor: </b>' + row.data().asesor + '</label>'+
                '</div>'+
                '</div></div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#tabla_ingresar_14 tbody").on("click", ".editReg", function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#editReg').modal('show');
    });

    $("#tabla_ingresar_14 tbody").on("click", ".revCont", function (e) {
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
});

$(document).on('click', '#save1', function (e) {
    e.preventDefault();
    var comentario = $("#comentario").val();
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    if (validaComent == 0)
        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')
    
    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_lote_asistentes_proceceso14`,
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
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save1').prop('disabled', false);
                    $('#editReg').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#tabla_ingresar_14').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save2', function (e) {
    e.preventDefault();
    var comentario = $("#comentario1").val();
    var validaComent = ($("#comentario1").val().length == 0) ? 0 : 1;
    var dataExp2 = new FormData();
    dataExp2.append("idCliente", getInfo1[0]);
    dataExp2.append("nombreResidencial", getInfo1[1]);
    dataExp2.append("nombreCondominio", getInfo1[2]);
    dataExp2.append("idCondominio", getInfo1[3]);
    dataExp2.append("nombreLote", getInfo1[4]);
    dataExp2.append("idLote", getInfo1[5]);
    dataExp2.append("comentario", comentario);
    dataExp2.append("fechaVenc", getInfo1[6]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    

    if (validaComent == 1) {
        $('#save1').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso14`,
            data: dataExp2,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save2').prop('disabled', false);
                    $('#envARev2').modal('hide');
                    $('#tabla_ingresar_14').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save2').prop('disabled', false);
                $('#envARev2').modal('hide');
                $('#tabla_ingresar_14').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

jQuery(document).ready(function () {
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })

    jQuery('#envARev2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario1').val('');
    })
});