var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);
var getInfo4 = new Array(7);
var getInfo5 = new Array(7);
var getInfo6 = new Array(7);

$(document).ready(function () {
    construirHead("Jtabla")

    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            filename:'Registro de Estatus 8',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                return `<span class="label lbl-green" data-i18n="${d.tipo_venta}">${d.tipo_venta}</span>`;
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
                return '<p class="m-0">' + d.gerente + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.nombreCliente + '</p>';
            }
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.descripcion + '</p>';
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
                if (id_rol_general != 53 && id_rol_general != 54 && id_rol_general != 63) { // ANALISTA DE COMISIONES Y SUBDIRECTOR CONSULTA (POPEA)

                    var cntActions;
                    if (data.vl == '1') {
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    }
                    else {
                        if (data.idStatusContratacion == 7 && data.idMovimiento == 64 && (data.perfil == 32 || data.perfil == 13 || data.perfil == 17 || data.perfil == 70)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' + ` data-data='${JSON.stringify(data)}'` +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-orangeYellow editReg2" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else if ((data.idStatusContratacion == 7 && data.idMovimiento == 37 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 7 && data.perfil == 15 || data.idStatusContratacion == 7 && data.idMovimiento == 77 && data.perfil == 15)
                            || (data.idStatusContratacion == 11 && data.idMovimiento == 41)) {
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' + ` data-data='${JSON.stringify(data)}'` +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';
                            
                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else if (data.idStatusContratacion == 7 && data.idMovimiento == 66 && data.perfil == 11) { //RECHAZO
                            cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' + ` data-data='${JSON.stringify(data)}'` +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-violetBoots editLoteTo8" data-toggle="tooltip" data-placement="top" data-i18n-tooltip="estatus-8" title="REGISTRAR ESTATUS">' +
                                '<i class="far fa-thumbs-up"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                                'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' + '" data-nombreResidencial="' + data.nombreResidencial + '" ' + '" data-nombreCondominio="' + data.nombreCondominio.toUpperCase() + '" ' +
                                'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                                '<i class="far fa-thumbs-down"></i></button>';

                            cntActions += `${datatableButtons(data, 2)}`;
                        }
                        else {
                            cntActions = 'N/A';
                        }
                    }
                    return '<div class="d-flex justify-center">' + cntActions + '</div>';
                }
                else {
                    return  `<span class="label lbl-warning">N/A</span>`;
                }
            }
        }],
        columnDefs: [{
            searchable: false,
            orderable: false,
            targets: 0
        }],
        ajax: {
            url: `${general_base_url}Asistente_gerente/getStatus8ContratacionAsistentes`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
    });

    $('#Jtabla').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });

        // changeButtonTooltips()
    });

    const idStatusContratacion = [7,11];
    const idMovimiento = [7, 37, 64, 66, 77, 41];

    $('#Jtabla tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        }
        else {
            var status;
            var fechaVenc;

            if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 37) {
                status = "ESTATUS 7 LISTO (JURÍDICO)";
            }
            else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 7) {
                status = "ESTATUS 7 LISTO CON MODIFICACIONES (JURÍDICO)";
            }
            else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 64) {
                status = "ESTATUS 8 RECHAZADO (CONTRALORIA)";
            }
            else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66) {
                status = "ESTATUS 8 RECHAZADO (ADMINISTRACIÓN)";
            }
            else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 77) {
                status = "ESTATUS 2 ENVIADO REVISIÓN (VENTAS)";
            }
            else if (row.data().idStatusContratacion == 11 && row.data().idMovimiento == 41) {
                status = "ESTATUS 11 VALIDACIÓN DE ENGANCHE (ADMINISTRACIÓN)";
            }

            if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 37 ||
                row.data().idStatusContratacion == 7 && row.data().idMovimiento == 7 ||
                row.data().idStatusContratacion == 7 && row.data().idMovimiento == 64 ||
                row.data().idStatusContratacion == 7 && row.data().idMovimiento == 77) {
                fechaVenc = row.data().fechaVenc;
            } else if (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 66) {
                fechaVenc = 'VENCIDO';
            }

            var informacion_adicional = 
            '<div class="container subBoxDetail bottom"><div class="row">'+
                '<div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">'+
                    '<label><b>INFORMACIÓN ADICIONAL</b></label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Estatus: </b>' + status + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Comentario: </b>' + row.data().comentario + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Fecha de vencimiento: </b>' + fechaVenc + '</label>'+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Fecha de realizado: </b>' + row.data().modificado + '</label> '+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Coordinador: </b>' + row.data().coordinador + '</label> '+
                '</div>'+
                '<div class="col-12 col-sm-12 col-md-12 col-lg-12">'+
                    '<label><b>Asesor: </b>' + row.data().asesor + '</label>'+
                '</div>'+
            '</div>'+
            '</div>';

            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });

    $("#Jtabla tbody").on("click", ".editReg", async function (e) {
        e.preventDefault();
        getInfo1[0] = $(this).attr("data-idCliente");
        getInfo1[1] = $(this).attr("data-nombreResidencial");
        getInfo1[2] = $(this).attr("data-nombreCondominio");
        getInfo1[3] = $(this).attr("data-idcond");
        getInfo1[4] = $(this).attr("data-nomlote");
        getInfo1[5] = $(this).attr("data-idLote");
        getInfo1[6] = $(this).attr("data-fecven");
        getInfo1[7] = $(this).attr("data-code");
        getInfo1[10] = 0; // Dato para saber si tiene complemento de pago 
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);

        $("#data-editReg").val($(this).attr("data-data"));
        $('#editReg').modal('show');
    });

    $("#Jtabla tbody").on("click", ".cancelReg", function (e) {
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

    $("#Jtabla tbody").on("click", ".cancelAs", function (e) {
        e.preventDefault();
        getInfo4[0] = $(this).attr("data-idCliente");
        getInfo4[1] = $(this).attr("data-nombreResidencial");
        getInfo4[2] = $(this).attr("data-nombreCondominio");
        getInfo4[3] = $(this).attr("data-idcond");
        getInfo4[4] = $(this).attr("data-nomlote");
        getInfo4[5] = $(this).attr("data-idLote");
        getInfo4[6] = $(this).attr("data-fecven");
        getInfo4[7] = $(this).attr("data-code");
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#rechazoAs').modal('show');
    });

    $("#Jtabla tbody").on("click", ".editLoteTo8", async function (e) {
        e.preventDefault();
        getInfo5[0] = $(this).attr("data-idCliente");
        getInfo5[1] = $(this).attr("data-nombreResidencial");
        getInfo5[2] = $(this).attr("data-nombreCondominio");
        getInfo5[3] = $(this).attr("data-idcond");
        getInfo5[4] = $(this).attr("data-nomlote");
        getInfo5[5] = $(this).attr("data-idLote");
        getInfo5[6] = $(this).attr("data-fecven");
        getInfo5[7] = $(this).attr("data-code");
        getInfo5[10] = 0; // Dato para saber si tiene complemento de pago

        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        
        $("#data-rev8").val($(this).attr("data-data"));
        $('#rev8').modal('show');
    });

    $("#Jtabla tbody").on("click", ".editReg2", async function (e) {
        e.preventDefault();
        getInfo6[0] = $(this).attr("data-idCliente");
        getInfo6[1] = $(this).attr("data-nombreResidencial");
        getInfo6[2] = $(this).attr("data-nombreCondominio");
        getInfo6[3] = $(this).attr("data-idcond");
        getInfo6[4] = $(this).attr("data-nomlote");
        getInfo6[5] = $(this).attr("data-idLote");
        getInfo6[6] = $(this).attr("data-fecven");
        getInfo6[7] = $(this).attr("data-code");
        getInfo6[10] = 0; // Dato para saber si tiene complemento de pago 
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);

        $("#data-rev_2").val($(this).attr("data-data"));
        $('#rev_2').modal('show');
    });
});

$(document).on('click', '#save1', async function (e) {
    e.preventDefault();
    const comentario = $("#comentario").val();
    const validaComent = ($("#comentario").val().length == 0) ? 0 : 1;

    const d = JSON.parse($("#data-editReg").val());
    
    if (validaComent == 0) {
        return alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");
    }
    if ( d.movimiento ){ // <--- Debe anexar complemento de pago
        if (!d.expediente) { // <--- No tiene archivo o expediente agregado
          return alerts.showNotification("top", "right", "No has subido el complemento de pago", "warning");
        }
    }

    $('#save1').prop('disabled', true); // Deshabilitamos botón porque si paso validaciones.
    
    const dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);
    dataExp1.append("numContrato", getInfo1[7]);
    $.ajax({
        url: `${general_base_url}Asistente_gerente/editar_registro_lote_asistentes_proceceso8`,
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
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if (response.message == 'MISSING_CARTA_UPLOAD') {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Primero debes subir la Carta de Domicilio CM antes de avanzar el expediente", "danger");
            } else if (response.message == 'FALSE') {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if (response.message == 'ERROR') {
                $('#save1').prop('disabled', false);
                $('#editReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        },
        error: function (data) {
            $('#save1').prop('disabled', false);
            $('#editReg').modal('hide');
            $('#Jtabla').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
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
    dataExp3.append("numContrato", getInfo3[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");

    if (validaComent == 1) {
        $('#save3').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazo_asistentes_proceceso8`,
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
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save3').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save4', function (e) {
    e.preventDefault();
    var comentario = $("#comentario4").val();
    var validaComent = ($("#comentario4").val().length == 0) ? 0 : 1;
    var dataExp4 = new FormData();
    dataExp4.append("idCliente", getInfo4[0]);
    dataExp4.append("nombreResidencial", getInfo4[1]);
    dataExp4.append("nombreCondominio", getInfo4[2]);
    dataExp4.append("idCondominio", getInfo4[3]);
    dataExp4.append("nombreLote", getInfo4[4]);
    dataExp4.append("idLote", getInfo4[5]);
    dataExp4.append("comentario", comentario);
    dataExp4.append("fechaVenc", getInfo4[6]);
    dataExp4.append("numContrato", getInfo4[7]);
    if (validaComent == 0)
        alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");

    if (validaComent == 1) {
        $('#save4').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazoAstatus2_asistentes_proceceso8/`,
            data: dataExp4,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == 'OK') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save4').prop('disabled', false);
                    $('#rechazoAs').modal('hide');
                    $('#Jtabla').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save4').prop('disabled', false);
                $('#rechazoAs').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

$(document).on('click', '#save5', async function (e) {
    e.preventDefault();
    
    const comentario = $("#comentario5").val();
    const validaComent = ($("#comentario5").val().length == 0) ? 0 : 1;

    const d = JSON.parse($("#data-rev8").val());

    if (validaComent == 0) {
        return alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");
    }
    if ( d.movimiento ){ // <--- Debe anexar complemento de pago
        if (!d.expediente) { // <--- No tiene archivo o expediente agregado
          return alerts.showNotification("top", "right", "No has subido el complemento de pago", "warning");
        }
    }

    $('#save5').prop('disabled', true); // Deshabilitamos botón porque pasó validaciones
    
    if (getInfo5[10] == 1 && (getInfo5[11].expediente != $("#archivo_complemento").siblings(".file-name").val())) {
        const accion = await accionesComplementoPago(getInfo5);
        if (accion == false) {
            return;
        }
    }

    const dataExp5 = new FormData();
    dataExp5.append("idCliente", getInfo5[0]);
    dataExp5.append("nombreResidencial", getInfo5[1]);
    dataExp5.append("nombreCondominio", getInfo5[2]);
    dataExp5.append("idCondominio", getInfo5[3]);
    dataExp5.append("nombreLote", getInfo5[4]);
    dataExp5.append("idLote", getInfo5[5]);
    dataExp5.append("comentario", comentario);
    dataExp5.append("fechaVenc", getInfo5[6]);
    dataExp5.append("numContrato", getInfo5[7]);

    $.ajax({
        url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentesAadministracion11_proceceso8/`,
        data: dataExp5,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            response = JSON.parse(data);
            if (response.message == 'OK') {
                $('#save5').prop('disabled', false);
                $('#rev8').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if (response.message == 'FALSE') {
                $('#save5').prop('disabled', false);
                $('#rev8').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if(response.message == 'MISSING_CARTA_UPLOAD'){
                $('#save5').prop('disabled', false);
                $('#rev8').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Primero debes subir la Carta de Domicilio CM antes de avanzar el expediente", "danger");
            }
            else if (response.message == 'ERROR') {
                $('#save5').prop('disabled', false);
                $('#rev8').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        },
        error: function (data) {
            $('#save5').prop('disabled', false);
            $('#rev8').modal('hide');
            $('#Jtabla').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

$(document).on('click', '#save6', async function (e) {
    e.preventDefault();
    const comentario = $("#comentario6").val();
    const validaComent = ($("#comentario6").val().length == 0) ? 0 : 1;
    const d = JSON.parse($("#data-rev_2").val());

    if (validaComent == 0) {
        return alerts.showNotification("top", "right", "Ingresa un comentario.", "warning");
    }
    if ( d.movimiento ){ // <--- Debe anexar complemento de pago
        if (!d.expediente) { // <--- No tiene archivo o expediente agregado
          return alerts.showNotification("top", "right", "No has subido el complemento de pago", "warning");
        }
    }

    $('#save6').prop('disabled', true); // Deshabilitamos botón porque pasó validaciones

    if (getInfo1[10] == 1 ) {
        const accion = await accionesComplementoPago(getInfo6);
        if (accion == false) {
            return;
        }
    }
        
    const dataExp6 = new FormData();
    dataExp6.append("idCliente", getInfo6[0]);
    dataExp6.append("nombreResidencial", getInfo6[1]);
    dataExp6.append("nombreCondominio", getInfo6[2]);
    dataExp6.append("idCondominio", getInfo6[3]);
    dataExp6.append("nombreLote", getInfo6[4]);
    dataExp6.append("idLote", getInfo6[5]);
    dataExp6.append("comentario", comentario);
    dataExp6.append("fechaVenc", getInfo6[6]);
    dataExp6.append("numContrato", getInfo6[7]);
    $.ajax({
        url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso8`,
        data: dataExp6,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            response = JSON.parse(data);
            if (response.message == 'OK') {
                $('#save6').prop('disabled', false);
                $('#rev_2').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Estatus enviado.", "success");
            } else if (response.message == 'FALSE') {
                $('#save6').prop('disabled', false);
                $('#rev_2').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
            } else if (response.message == 'ERROR') {
                $('#save6').prop('disabled', false);
                $('#rev_2').modal('hide');
                $('#Jtabla').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        },
        error: function (data) {
            $('#save6').prop('disabled', false);
            $('#rev_2').modal('hide');
            $('#Jtabla').DataTable().ajax.reload();
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

const accionesComplementoPago = async (d) => {
    // Borramos el complemento de pago en caso de tener uno y actualizamos los registros de historial_documento 
    const docData = new FormData();
    docData.append("idLote", d.idLote);

    if (d.expediente && d.movimiento) {
        const docData = new FormData();
        docData.append("idDocumento", d.idDocumento);
        docData.append("tipoDocumento", 55);
        let rs1 = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Documentacion/eliminarArchivo`,
            data: docData,
            contentType: false,
            cache: false,
            processData: false,
        });
        rs1 = JSON.parse(rs1);
        if (rs1.code == 500) {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            return false;
        }
    }
    // {"idLote":100528,"id_cliente":154634,"nombreCliente":"IRCON AGRICOLA S.A DE C.V ","nombreLote":"CDMMNL-ARBH-039","idStatusContratacion":7,"idMovimiento":37,"modificado":"2024-07-02 13:06:56","rfc":"IAG170918IY7","nombreSede":"Querétaro","comentario":"Prueba paso 3 #TI ","fechaVenc":"2024-07-24 13:06:56","perfil":"15","nombreCondominio":"CDMMNL-PREMIUM ARBOLEDAS-HABITACIONAL","nombreResidencial":"CDMMNL","ubicacion":"2","tipo_venta":"Venta normal","vl":null,"asesor":"ALEJANDRA VALDES CARREON","coordinador":"GABRIEL GUTIERREZ AVIÑA","gerente":"SERGIO IBARRA LLANO","idCondominio":926,"expediente":null,"descripcion":"LISTO JURÍDICO 7","tipo_proceso":"Normal","idDocumento":1624189,"movimiento":"COMPLEMENTO DE PAGO","bucket":0}

    const expediente = generarTituloDocumento(d.nombreResidencial, d.nombreLote, d.idLote, d.id_cliente, 55); // nombreResidencial, nombreLote, idLote, idCliente, tipoDoc.
    const ndata = new FormData();
    ndata.append("expediente", expediente); // Nombre del archivo CCSPQ-15005-PPYUC-ETC.pdf
    ndata.append("idDocumento", d.idDocumento);
    let res = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Contraloria/actualizaRamaComplementoPago`,
        data: ndata,
        contentType: false,
        cache: false,
        processData: false,
    });
    res = JSON.parse(res);
    const xdata = new FormData();
    xdata.append("idLote", d.idLote);
    xdata.append("idDocumento", d.idDocumento);
    xdata.append("tipoDocumento", 55);
    xdata.append("tituloDocumento", expediente);
    xdata.append("uploadedDocument", $("#archivo_complemento")[0].files[0]);
    let rs = await $.ajax({
        type: 'POST',
        url: `${general_base_url}Documentacion/subirArchivo`,
        data: xdata,
        contentType: false,
        cache: false,
        processData: false,
    });
    rs = JSON.parse(rs);
    if (rs.code == 500) {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
        return false;
    } else {
        return true;
    }
    return true;
}

jQuery(document).ready(function () {
    jQuery('#editReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
        jQuery(this).find('#archivo_complemento').val('');
        $("#data-editReg").val('');
        $('#extra-content-accion-modal-1').html('');
    })

    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })

    jQuery('#rechazoAs').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario4').val('');
    })

    jQuery('#rev8').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario5').val('');
        jQuery(this).find('#archivo_complemento').val('');
        $("#data-rev8").val()
        $('#extra-content-accion-modal-5').html('');
    })

    jQuery('#rev_2').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario6').val('');
        jQuery(this).find('#archivo_complemento').val('');
        $("#data-rev_2").val()
        $('#extra-content-accion-modal-6').html('');
    })
});

$(document).on('click', '.btn-archivo', function () {
  $('.btn-archivo').attr('disabled', true);  // Lo vuelvo a activar
  $('#spiner-loader').removeClass('hide'); // Aparece spinner
  Shadowbox.init();
  const d = JSON.parse($(this).attr("data-data"));
  let filePath = `${general_base_url}Documentacion/archivo/${d.expediente}`;
  Shadowbox.open({
      content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${filePath}"></iframe></div>`,
      player: "html",
      title: `Visualizando archivo: ${d.movimiento}`,
      width: 985,
      height: 660
  });

  $('.btn-archivo').attr('disabled', false);  // Lo vuelvo a activar
  $('#spiner-loader').addClass('hide'); // Quito spinner  
});

$(document).on('click', '.btn-subir-archivo', function () {
    $('.btn-subir-archivo').attr('disabled', true);  // Lo vuelvo a activar
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    const d = JSON.parse($(this).attr("data-data"));
    // --------------------------
    content = `
        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
            <label>Compemento de pago:</label>
            <div id="selectFileSection">
                <div class="file-gph">
                    <input type="file" accept=".pdf" id="archivo_complemento">
                    <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                    <label class="upload-btn m-0" for="archivo_complemento">
                      <span>Seleccionar</span>
                      <i class="fas fa-folder-open"></i>
                    </label>
                </div>
            </div>
            <span><label class='pt-1'>NOTA: ${d.expediente ? 'Se reemplazará el archivo actual si adjuntas un nuevo archivo' : 'Si ya existe un complemento de pago, el mismo se reemplazará  con el nuevo'}.</label></span>
        </div>`;
    
    const titulo = `<h4>Anexar complemento de pago <b>${d.nombreLote}</b></h4>`;
    $('#labelHeaderAccionModal').html(titulo);
    // Embebemos el contenido extra
    $('#extra-content-accion-modal').html(content);

    // Mostramos el modal y mostramos la info del lote en el modal
    $('#accion-modal').modal('show');

    // Le agregamos la información que vallamos a usar en caso de confirmar el modal
    const info = '<input type="hidden" id="data"></input>' ;
    $('#data-modal').append(info);
    
    // Asignación de valores a los inputs
    $("#data").val(JSON.stringify(d));
  
    $('.btn-subir-archivo').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
});

// FUNCIONALIDAD DEL BOTÓN DE ACEPTAR DEL MODAL
$(document).on("click", "#btn-accion", async function (e) {
    e.preventDefault();
    const d = JSON.parse($("#data").val());

    const archivo = $("#archivo_complemento");
    // Input sin archivo
    if (archivo.val().length === 0) {
        return alerts.showNotification("top", "right", "Selecciona el archivo a adjuntar.", "warning");
    }
      // Archivo incorrecto
    else if (!validateExtension(archivo[0].files[0].name.split('.').pop(), 'pdf, PDF')) {
        return alerts.showNotification("top", "right", "El tipo de archivo es incorrecto", "warning");
    }

    $('.btn-subir-archivo').attr('disabled', true);  // Lo vuelvo a activar
    $('#spiner-loader').removeClass('hide'); // Aparece spinner

    const accion = await accionesComplementoPago(d);

    $('#spiner-loader').addClass('hide'); // Quito spinner 
    if (accion == false) {
        return alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
    }else if (accion == true) {
        $('#accion-modal').modal('hide');
        $('#Jtabla').DataTable().ajax.reload();
        $('.btn-subir-archivo').attr('disabled', false);  // Lo vuelvo a activar 
        return alerts.showNotification("top", "right", "¡El documento COMPLEMENTO DE PAGO se ha cargado con éxito.!", "success");
    }else {
        return alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
    }
});

const datatableButtons = (d, type) => {
    const BTN_SUBIR_DOC = newButton('btn-data btn-green btn-subir-archivo', 'SUBIR DOCUMENTO', 'VER-ARCHIVO', d, 'fas fa-upload');
    const BTN_VER_DOC = newButton('btn-data btn-sky btn-archivo', 'VISUALIZAR DOCUMENTO', 'VER-ARCHIVO', d, 'fas fa-eye');
    const BTN_REMPLAZAR_DOC = newButton('btn-data btn-green btn-subir-archivo', 'REMPLAZAR DOCUMENTO', 'VER-ARCHIVO', d, 'fas fa-copy');

    let NO_BTN = ''; 

    if (type === 2) { 
        if (!d.expediente && d.movimiento) return BTN_SUBIR_DOC ;
        if (d.expediente && d.movimiento) return BTN_VER_DOC + BTN_REMPLAZAR_DOC;
    }

    return NO_BTN;
}

const newButton = (btnClass, title, action = '', data, icon) => {
  const CUSTOM_BTN = `<button class='${btnClass}'
      data-toggle='tooltip' 
      data-placement='top'
      title='${title.toUpperCase()}'
      data-accion='${action}'
      data-data='${JSON.stringify(data)}'>
          <i class='${icon}'></i>
      </button>`;

  return CUSTOM_BTN;
}

const generarTituloDocumento = (abreviaturaNombreResidencial, nombreLote, idLote, idCliente, tipoDocumento) => {
  let rama = '';
  if (tipoDocumento === 55) rama = 'COMPLEMENTO DE PAGO';

  const DATE = new Date();
  const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
  const TITULO_DOCUMENTO = `${abreviaturaNombreResidencial}_${nombreLote}_${idLote}_${idCliente}_TDOC${tipoDocumento}${rama.slice(0, 4)}_${DATE_STR}`;
  return TITULO_DOCUMENTO;
}

// Función para colocar el nombre del archivo en el input de texto que comparte con el input de archivo
$(document).on("change", "#archivo_complemento", function () {
  const target = $(this);
  const relatedTarget = target.siblings(".file-name");
  const fileName = target[0].files[0].name;
  relatedTarget.val(fileName);
});