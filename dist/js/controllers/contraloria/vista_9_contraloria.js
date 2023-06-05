$('#tabla_ingresar_9 thead tr:eq(0) th').each(function (i) {
    if (i != 0) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tabla_ingresar_9').DataTable().column(i).search() !== this.value) {
                $('#tabla_ingresar_9').DataTable().column(i).search(this.value).draw();
            }
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
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 1:
                                return 'TIPO DE VENTA';
                                break;
                            case 2:
                                return 'PROYECTO'
                            case 3:
                                return 'CONDOMINIO';
                                break;
                            case 4:
                                return 'LOTE';
                                break;
                            case 5:
                                return 'CLIENTE';
                                break;
                            case 6:
                                return 'GERENTE';
                                break;
                            case 7:
                                return 'RESIDENCIA';
                                break;
                            case 8:
                                return 'UBICACIÓN';
                                break;
                        }
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
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        switch (columnIdx) {
                            case 1:
                                return 'TIPO VENTA';
                                break;
                            case 2:
                                return 'PROYECTO'
                            case 3:
                                return 'CONDOMINIO';
                                break;
                            case 4:
                                return 'LOTE';
                                break;
                            case 5:
                                return 'CLIENTE';
                                break;
                            case 6:
                                return 'GERENTE';
                                break;
                            case 7:
                                return 'RESIDENCIA';
                                break;
                            case 8:
                                return 'UBICACIÓN';
                                break;
                        }
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
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [{
            width: "3%",
            className: 'details-control',
            orderable: false,
            data: null,
            defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function (d) {
                return `<span class="label" style="background: #A3E4D7; color: #0E6251">${d.tipo_venta}</span>`;
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
                let respuesta = '';
                if (d.residencia == 0 || d.residencia == null)
                    respuesta = '<p class="m-0">NACIONAL</p>';
                else
                    respuesta = '<p class="m-0">EXTRANJERO</p>';
                return respuesta;
            }
        },
        {
            width: "17%",
            data: function (d) {
                return `<span class="label" style="background: #A9CCE3; color: #154360">${d.nombreSede}</span>`;
            }
        },
        {
            orderable: false,
            data: function (data) {
                var cntActions;
                if (data.vl == '1')
                    cntActions = 'En proceso de Liberación';
                else {
                    if (data.idStatusContratacion == 8 && data.idMovimiento == 38 || data.idStatusContratacion == 8 && data.idMovimiento == 65 || data.idStatusContratacion == 11 && data.idMovimiento == 41) {
                        cntActions = '<button href="#" data-idLote="' + data.idLote + '" data-residencia="' + data.residencia + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '" ' +
                            'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                            '<i class="fas fa-thumbs-up"></i></button>';
                        cntActions += '<button href="#" data-idLote="' + data.idLote + '" data-nomLote="' + data.nombreLote + '" data-idCond="' + data.idCondominio + '"' +
                            'data-idCliente="' + data.id_cliente + '" data-fecVen="' + data.fechaVenc + '" data-ubic="' + data.ubicacion + '" data-code="' + data.cbbtton + '"  ' +
                            'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURIDICO)">' +
                            '<i class="fas fa-thumbs-down"></i></button>';
                    } else
                        cntActions = 'N/A';
                }
                return "<div class='d-flex justify-center'>" + cntActions + "</div>";
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

    $('#tabla_ingresar_9').on('draw.dt', function() {
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
        nombreLote = $(this).data("nomlote");
        let residencia = $(this).attr("data-residencia") != 1 ? 0 : 1;
        console.log(residencia);
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
    //  me quede aqui para guaradar el nuevo dato porfavor que se guarde 
    var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
    var validatn = ($("#totalNeto2").val().length == 0) ? 0 : 1;
    var validaRL = ($("#rl").val().length == 0) ? 0 : 1;
    var validaResidencia = ($("#residencia").val().length == 0) ? 0 : 1;
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
    var cliente = getInfo1[0];
    if (validaComent == 0 || validatn == 0 || validaRL == 0 || validaResidencia == 0)
        alerts.showNotification("top", "right", "Todos los campos son obligatorios.", "danger");
    if (validaComent == 1 && validatn == 1 && validaRL == 1 && validaResidencia == 1) {
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
                    alerts.showNotification("top", "right", "Estatus enviado.", "success");
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
    let info = [];
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
// Jquery Dependency
$("input[data-type='currency']").on({
    keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    },
    click: function () {
        formatCurrency($(this));
    },
});
function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}
function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.
    // get input value
    var input_val = input.val();
    // don't validate empty input
    if (input_val === "") { return; }
    // original length
    var original_len = input_val.length;
    // initial caret position
    var caret_pos = input.prop("selectionStart");
    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");
        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        // add commas to left side of number
        left_side = formatNumber(left_side);
        // validate right side
        right_side = formatNumber(right_side);
        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }
        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);
        // join number by .
        input_val = "$" + left_side + "." + right_side;
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "$" + input_val;
        // final formatting
        if (blur === "blur") {
            input_val += ".00";
        }
    }
    // send updated string to input
    input.val(input_val);
    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}
function fillSelectsForV9() {
    $.getJSON("fillSelectsForV9").done(function (data) {
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 77) // REPRESENTABTE LEGAL SELECT
                $("#rl").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 78) // RESIDENCIA SELECT
                $("#residencia").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $('#rl').selectpicker('refresh');
        $('#residencia').selectpicker('refresh');
    });
}