var getInfo1 = new Array(6);
var getInfo3 = new Array(6);
let titulosInventario = [];
$("#tabla_ingresar_15").ready(function () {
    $('#tabla_ingresar_15 thead tr:eq(0) th').each(function (i) {
        if (i != 0) {
            var title = $(this).text();
            titulosInventario.push(title);
            $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if (tabla_15.column(i).search() !== this.value) {
                    tabla_15.column(i).search(this.value).draw();
                }
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
                            return ' ' + titulosInventario[columnIdx -1]  + ' ';
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
                            return ' ' + titulosInventario[columnIdx -1]  + ' ';
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
        scrollX:true,
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
                    return '<p class="m-0">' + (d.nombreCondominio).toUpperCase(); + '</p>';
                }
            },
            {
                data: function (d) {
                    return '<p class="m-0">' + d.nombreLote + '</p>';

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
                    return `<span class="label lbl-azure">${d.nombreSede}</span>`;
                }
            },
            {
                orderable: false,
                data: function (data) {
                    var cntActions;
                    if (data.vl == '1') {
                        cntActions = 'EN PROCESO DE LIBERACIÓN';
                    } else {
                        if (data.idStatusContratacion == 14 && data.idMovimiento == 44 ||
                            data.idStatusContratacion == 14 && data.idMovimiento == 69 ||
                            data.idStatusContratacion == 14 && data.idMovimiento == 80) {

                            cntActions =
                                `<button href="#" data-idLote="${data.idLote}" data-nomLote="${data.nombreLote}" data-idCond="${data.idCondominio}" data-idCliente="${data.id_cliente}" data-fecVen="${data.fechaVenc}" data-ubic="${data.ubicacion}" data-code="${data.cbbtton}" data-fechaArcus="${data.fecha_arcus}" data-idProspecto="${data.id_prospecto}" data-idArcus="${data.id_arcus}" data-totalNeto2="${data.totalNeto2}" class="btn-data btn-green editReg"  data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS"><i class="fas fa-thumbs-up"></i></button>`;
                        }
                        else
                            cntActions = 'N/A';
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
            url: `${general_base_url}Contraloria/getregistroStatus15ContratacionContraloria`,
            dataSrc: "",
            type: "POST",
            cache: false,
        },
        order: [[1, 'asc']]
    });
    
    $('#tabla_ingresar_15').on('draw.dt', function() {
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
                status = 'STATUS 14 LISTO (ASISTENTES GERENTES)';
            else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 69) 
                status = 'STATUS 14 ENVIADO A REVICIÓN (ASISTENTES GERENTES)';
            else if (row.data().idStatusContratacion == 14 && row.data().idMovimiento == 80)
                status = 'STATUS 14 (REGRESO CONTRATACIÓN)';
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
        nombreLote = $(this).data("nomlote");
        $(".lote").html(nombreLote);
        $('#editReg').modal('show');
    });

    $("#tabla_ingresar_15 tbody").on("click", ".cancelReg", function (e) {
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
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var dataExp1 = new FormData();
    var dataArcus = {};
    dataExp1.append("idCliente", getInfo1[0]);
    dataExp1.append("nombreResidencial", getInfo1[1]);
    dataExp1.append("nombreCondominio", getInfo1[2]);
    dataExp1.append("idCondominio", getInfo1[3]);
    dataExp1.append("nombreLote", getInfo1[4]);
    dataExp1.append("idLote", getInfo1[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo1[6]);

    if(getInfo1[10] !== '' && getInfo1[10].trim() !== ''){
        dataArcus = {
            "id": getInfo1[9], // idProspecto
            "propiedadRelacionada": getInfo1[5], // idLote
            "montoDelNegocio": parseFloat(getInfo1[11]), // totalNeto2
            "fechaDeCompra": getInfo1[8], // fechaArcus
            "uid": getInfo1[10] // idArcus
        };
        (async function () {
            try {
                // const res = await sendInfoArcus(dataArcus)
                //if (res.status === 'Accepted' || res.response === 'Accepted'){
                if (true) {
                    if (validaComent == 0)
                        alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')

                    if (validaComent == 1) {
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
                                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                                } else if (response.message == 'FALSE') {
                                    $('#save1').prop('disabled', false);
                                    $('#editReg').modal('hide');
                                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
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
                }else{
                    alerts.showNotification('top', 'right', "Error en proceso de servicio externo: Arcus" , 'danger')
                }
            } catch (error) {
                alerts.showNotification('top', 'right', "Error en servicio externo: Arcus" , 'danger')
            }
        })();
    }else{
        if (validaComent == 0)
            alerts.showNotification('top', 'right', 'Ingresa un comentario.', 'danger')

        if (validaComent == 1) {
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
                        alerts.showNotification("top", "right", "Estatus enviado.", "success");
                    } else if (response.message == 'FALSE') {
                        $('#save1').prop('disabled', false);
                        $('#editReg').modal('hide');
                        $('#tabla_ingresar_15').DataTable().ajax.reload();
                        alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
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
            url: `${general_base_url}Contraloria/editar_registro_loteRechazo_contraloria_proceceso15/`,
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
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
                } else if (response.message == 'FALSE') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
                } else if (response.message == 'ERROR') {
                    $('#save3').prop('disabled', false);
                    $('#rechReg').modal('hide');
                    $('#tabla_ingresar_15').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
                }
            },
            error: function (data) {
                $('#save3').prop('disabled', false);
                $('#rechReg').modal('hide');
                $('#tabla_ingresar_15').DataTable().ajax.reload();
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

    jQuery('#rechReg').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario3').val('');
    })
});

async function sendInfoArcus(dataArcus) {
    try {
        const headers = {
            'Content-Type': 'application/json'
        };
        const requestArcus = {
            method: 'POST',
            headers,
            body: JSON.stringify(dataArcus)
        }
        const response = await fetch(`${general_base_url}Api/sendLeadInfoRecord`, requestArcus);
        if (response.ok) {
            return response.json();
        }else{
            throw new Error('Error en la solicitud: ' + response.statusText);
        }
    } catch (error) {
        throw new Error('Error en la solicitud: ' + error.message);
    }
}
$(window).resize(function(){
    tabla_15.columns.adjust();
});
