const excluir_column = ['MÁS', ''];
let columnas_datatable = {};
$('#ano_historial').change(function () {
    residencial = $('#ano_historial').val();
    param = $('#param').val();
    condominio = '';
    $("#catalogo_historial").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contratacion/lista_proyecto/',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['idResidencial'];
                var name = response[i]['descripcion'];
                $("#catalogo_historial").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#catalogo_historial").selectpicker('refresh');
        }
    });
});

$('#ano_historial').change(function () {
    $("#tipo_historial").empty().selectpicker('refresh');
    $("#tipo_historial").append($('<option>').val(1).text('NORMAL'));
    $("#tipo_historial").append($('<option>').val(2).text('MADERAS UPGRADE'));
    $("#tipo_historial").append($('<option>').val(3).text('CASAS'));
    $("#tipo_historial").selectpicker('refresh');
});

$('#catalogo_historial, #tipo_historial').change(function () {

    var catalogoSeleccionado = $('#catalogo_historial').val() !== '';
    var tipoSeleccionado = $('#tipo_historial').val() !== '';

    if (catalogoSeleccionado && tipoSeleccionado) {
        proyecto = $('#ano_historial').val();
        condominio = $('#catalogo_historial').val();
        tipo = $('#tipo_historial').val();
         $('#tabla_historialGral').removeClass('hide');

        if (condominio == '' || condominio == null || condominio == undefined) {
            condominio = 0;
        }

        if (tipo == '' || tipo == null || tipo == undefined) {
            tipo = 0;
        }

        if (tabla_historialGral2) {
            tabla_historialGral2.destroy();
        }
        getAssimilatedCommissions(proyecto, condominio, tipo);

    }
});

$('#ano_canceladas').change(function () {
    residencial = $('#ano_canceladas').val();
    param = $('#param').val();
    $("#catalogo_canceladas").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contratacion/lista_proyecto/',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['idResidencial'];
                var name = response[i]['descripcion'];
                $("#catalogo_canceladas").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#catalogo_canceladas").selectpicker('refresh');
        }
    });
});

$('#catalogo_canceladas').change(function () {
    proyecto = $('#ano_canceladas').val();
    condominio = $('#catalogo_canceladas').val();
    $('#tabla_comisiones_canceladas').removeClass('hide');
    if (condominio == '' || condominio == null || condominio == undefined) {
        condominio = 0;
    }
    if (tabla_historialGral3) {
        tabla_historialGral3.destroy();
    }
    getAssimilatedCancelacion(proyecto, condominio);
});

var totalLeon = 0;
var totalQro = 0;
var totalSlp = 0;
var totalMerida = 0;
var totalCdmx = 0;
var totalCancun = 0;
var tr;
var tabla_historialGral2;
var tabla_historialGral3;
var totaPen = 0;

function modalHistorial() {
    changeSizeModal("modal-md");
    appendBodyModal(`<div class="modal-header"></div>
        <div class="modal-body">
            <div role="tabpanel">
                <h6 id="nameLote"></h6>
                <div class="container-fluid" id="changelogTab">
                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                        <ul class="timeline-3" id="comments-list-asimilados"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>${_('cerrar')}</b></button>
        </div>`);
    showModal();
}

// onLoadTranslations(function(){

function getAssimilatedCommissions(proyecto, condominio, tipo) {
    var Comisiones;
    if (tipo == 1 || tipo == 2 || tipo == 0) {
        tipo = tipo == 0 ? 1 : tipo;
        Comisiones = "Comisiones/getDatosHistorialPago/";
        $('#titulo_precio').text(_('precio-del-lote'));

    } else if (tipo == 4) {

        Comisiones = "SegurosComision/getDatosHistorialPago/";

    } else if (tipo == 3) {
        $('#titulo_precio').text(_('costo-construccion'));
        Comisiones = "Casas_comisiones/getDatosHistorialPago/";
    } else {
        alerts.showNotification("top", "right", _('tipo-no-existe'), "alert");
        return false;
    }


    // asignarValorColumnasDT("tabla_historialGral");
    // $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
    //     var title = $(this).text();
    //     if (!excluir_column.includes(title)) {
    //         columnas_datatable.tabla_historialGral.titulos_encabezados.push(title);
    //         columnas_datatable.tabla_historialGral.num_encabezados.push(columnas_datatable.tabla_historialGral.titulos_encabezados.length-1);
    //     }
    //     let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
    //     if (title !== '') {
    //         $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
    //         $( 'input', this ).on('keyup change', function () {
    //             if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
    //                 $('#tabla_historialGral').DataTable().column(i).search(this.value).draw();
    //             }
    //         });
    //     }
    // });


    // construirHead("tabla_historialGral");

    $('#tabla_historialGral').removeClass('hidden');
    construirHead("tabla_historialGral");
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: `${_('historial-general-activas')}`,
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        deferRender: true,
        columns: [{
            "data": function (d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                return lblStats;
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + formatMoney(d.pago_cliente) + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.pagado) + '</p>';
            }
        },
        {
            "data": function (d) {
                if (d.restante == null || d.restante == '') {
                    return '<p class="m-0">' + formatMoney(d.comision_total) + '</p>';
                }
                else {
                    return '<p class="m-0">' + formatMoney(d.restante) + '</p>';
                }
            }
        },
        {
            "data": function (d) {
                if (d.activo == 0 || d.activo == '0') {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p><p><span class="label lbl-warning">' + _('baja') + ' </span></p>';
                }
                else {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p>';
                }
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.puesto + '</p>';
            }
        },
        {
            "data": function (d) {
                var lblPenalizacion = '';

                if (d.penalizacion == 1) {
                    lblPenalizacion = '<p class="m-0" title="' + _('penalizacion-noventa-dias') + '"><span class="label lbl-vividOrange">' + _('noventa-dias') + '</span></p>';
                }

                if (d.bonificacion >= 1) {
                    p1 = '<p class="m-0" title="' + _('lote-bonificacion-neodata') + '"><span class="label lbl-darkPink"">' + _('bonificacion') + ' ' + formatMoney(d.bonificacion) + '</span></p>';
                }
                else {
                    p1 = '';
                }

                if (d.lugar_prospeccion == 0) {
                    p2 = '<p class="m-0" title="' + _('lote-con-cancelacion') + '"><span class="label lbl-warning">' + _('rescision') + '</span></p>';
                }
                else {
                    p2 = '';
                }

                if (d.id_cliente_reubicacion_2 != 0) {
                    p3 = `<p class="${d.colorProcesoCl}">${d.procesoCl}</p>`;
                } else {
                    p3 = '';
                }

                return p1 + p2 + lblPenalizacion + p3;
            }
        },
        {
            "data": function (d) {
                var etiqueta;
                var descuento = d.descuento_aplicado == 1 ? `<p class="m-0"><span class="label lbl-gray" style=""> ${_('descuento')}</span></p>` : '';
                if (d.pago_neodata < 1) {
                    etiqueta = '<p class="m-1">' + '<span class="label" style="background:' + d.color + '18; color:' + d.color + '">' + d.estatus_actual + '</span>' + '</p>' + '<p class="m-1">' + '<span class="label lbl-green">' + _('importacion') + '</span></p>';
                } else {
                    etiqueta = '<p class="m-0"><span class="label" style="background:' + d.color + '18; color: ' + d.color + '; ">' + d.estatus_actual + '</span></p>';
                }

                return etiqueta + descuento;
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                var BtnStats = '';
                const BTN_DETASI = `<button href="#" value="${data.id_pago_i}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="${_('detalles')}" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;
                const BTN_BONOS = `<button href="#" value="${data.id_pago_i}" data-value="${data.id_pago_i}" data-code="${data.cbbtton}" class="btn-data btn-orangeYellow ver_bonos" data-toggle="tooltip" title="Bonos"><i class="fas fa-clipboard"></i></button>`;

                if (data.cuantos_pagos > 0) {
                    BtnStats += BTN_DETASI;
                    BtnStats += BTN_BONOS;
                }
                else {
                    BtnStats += BTN_DETASI;
                }

                return '<div class="d-flex justify-center">' + BtnStats + '</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': true,
            'className': 'dt-body-center',
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + Comisiones + proyecto + "/" + condominio + "/" + tipo,
            "type": "POST",
            cache: false,
            "data": function (d) { }
        },
        order: [[1, 'asc']],
    });

    $('#tabla_historialGral').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    applySearch(tabla_historialGral2);

}

function getAssimilatedCancelacion(proyecto, condominio) {
    //asignarValorColumnasDT("tabla_comisiones_canceladas");
    // $('#tabla_comisiones_canceladas thead tr:eq(0) th').each( function (i) {
    //     var title = $(this).text();
    //     if (!excluir_column.includes(title)) {
    //         columnas_datatable.tabla_comisiones_canceladas.titulos_encabezados.push(title);
    //         columnas_datatable.tabla_comisiones_canceladas.num_encabezados.push(columnas_datatable.tabla_comisiones_canceladas.titulos_encabezados.length-1);
    //     }
    //     let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
    //     if (title !== '') {
    //         $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
    //         $( 'input', this ).on('keyup change', function () {
    //             if ($('#tabla_comisiones_canceladas').DataTable().column(i).search() !== this.value ) {
    //                 $('#tabla_comisiones_canceladas').DataTable().column(i).search(this.value).draw();
    //             }
    //         });
    //     }
    // });

   
    // $("#tabla_comisiones_canceladas").prop("hidden", false);

    construirHead("tabla_comisiones_canceladas");

    tabla_historialGral3 = $("#tabla_comisiones_canceladas").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: _('historial-general-canceladas'),
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        deferRender: true,
        columns: [{
            "data": function (d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                return lblStats;
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.pago_neodata) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + formatMoney(d.pago_cliente) + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.pagado) + '</p>';
            }
        },
        {
            "data": function (d) {
                if (d.restante == null || d.restante == '') {
                    return '<p class="m-0">' + formatMoney(d.comision_total) + '</p>';
                }
                else {
                    return '<p class="m-0">' + formatMoney(d.restante) + '</p>';
                }
            }
        },
        {
            "data": function (d) {
                if (d.activo == 0 || d.activo == '0') {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                }
                else {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p>';
                }
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.puesto + '</p>';
            }
        },
        {
            "data": function (d) {
                var lblPenalizacion = '';

                if (d.penalizacion == 1) {
                    lblPenalizacion = '<p class="m-0" title="' + _('penalizacion-noventa-dias') + '"><span class="label lbl-vividOrange">' + _('noventa-dias') + '</span></p>';
                }
                if (d.bonificacion >= 1) {
                    p1 = '<p class="m-0" title="' + _('lote-bonificacion-neodata') + '"><span class="label lbl-darkPink"">' + _('bonificacion') + ' ' + formatMoney(d.bonificacion) + '</span></p>';
                }
                else {
                    p1 = '';
                }

                if (d.lugar_prospeccion == 0) {
                    p2 = '<p class="m-0" title="' + _('lote-con-cancelacion') + '"><span class="label lbl-warning">' + _('rescision') + '</span></p>';
                }
                else {
                    p2 = '';
                }

                if (d.id_cliente_reubicacion_2 != 0) {
                    p3 = `<p class="${d.colorProcesoCl}">${d.procesoCl}</p>`;
                } else {
                    p3 = '';
                }

                return p1 + p2 + lblPenalizacion + p3;
            }
        },
        {
            "data": function (d) {
                var etiqueta;
                if (d.pago_neodata < 1) {
                    etiqueta = '<p class="m-0">' +
                        '<span class="label" style="background:' + d.color + '18; color:' + d.color + '">'
                        + d.estatus_actual +
                        '</span>' +
                        '</p>' +
                        '<p class="m-0">' +
                        '<span class="label lbl-green">' +
                        _('importacion') +
                        '</span>' +
                        '</p>';
                } else {
                    etiqueta = '<p class="m-0"><span class="label" style="background:' + d.color + '18; color:' + d.color + '">' + d.estatus_actual + '</span></p>';
                }
                return etiqueta;
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                var BtnStats;
                BtnStats = `<button href="#" value="${data.id_pago_i}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="${_('detalles')}" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;
                return '<div class="d-flex justify-center">' + BtnStats + '</div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center',
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/getDatosHistorialCancelacion/" + proyecto + "/" + condominio,
            "type": "POST",
            cache: false,
            "data": function (d) { }
        },
        order: [[1, 'asc']],
    });

    $('#tabla_comisiones_canceladas').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    applySearch(tabla_historialGral3);

}

$('a[data-toggle="tooltip"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function cancela() {
    $("#modal_nuevas").modal('toggle');
}

$("#form_interes").submit(function (e) {
    e.preventDefault();
}).validate({
    submitHandler: function (form) {
        var data = new FormData($(form)[0]);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: general_base_url + "Comisiones/despausar_solicitud",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST',
            success: function (data) {
                if (data[0]) {
                    $("#modal_nuevas").modal('toggle');
                    alerts.showNotification("top", "right", _('comision-pausada-exitosamente'), "success");
                    setTimeout(function () {
                        tabla_historialGral2.ajax.reload();
                    }, 3000);
                } else {
                    alerts.showNotification("top", "right", _('solicitud-no-procesada'), "danger");
                }
            }, error: function () {
                alert(_('error-en-sistema'));
            }
        });
    }
});

function cleanComments() {
    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';
    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
}

$(document).on('click', '.ver-info-asesor', function () {
    $('#modal_informacion').modal();
    construirHead('tabla_modal');
    $("#tabla_modal").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel ',
            titleAttr: _('descargar-excel'),
            title: _('historial'),
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        ordering: false,
        columns: [{
            "data": function (d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                return lblStats;
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.abono_neodata) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.fecha_modificacion + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.saldo_comisiones) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + _(descuento - universidad) + '</p>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            'searchable': false,
            'className': 'dt-body-center',
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            "url": general_base_url + "Comisiones/inforReporteAsesor",
            "type": "POST",
            cache: false,
            "data": function (d) { }
        },
        order: [[1, 'asc']]
    });
});

function tableComisionesSuma(anio) {
    asignarValorColumnasDT("tabla_comisiones_suma");
    // $('#tabla_comisiones_suma thead tr:eq(0) th').each( function (i) {
    //     var title = $(this).text();
    //     if (!excluir_column.includes(title)) {
    //         columnas_datatable.tabla_comisiones_suma.titulos_encabezados.push(title);
    //         columnas_datatable.tabla_comisiones_suma.num_encabezados.push(columnas_datatable.tabla_comisiones_suma.titulos_encabezados.length-1);
    //     }
    //     let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
    //     if (title !== '') {
    //         $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
    //         $( 'input', this ).on('keyup change', function () {
    //             if ($('#tabla_comisiones_suma').DataTable().column(i).search() !== this.value ) {
    //                 $('#tabla_comisiones_suma').DataTable().column(i).search(this.value).draw();
    //             }
    //         });
    //     }
    // });

    construirHead("tabla_comisiones_suma");

    $('#tabla_comisiones_suma').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        $.each(json, function (i, v) {
            total += parseFloat(v.total_comision);
        });
    });

    tabla_suma = $("#tabla_comisiones_suma").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr:`${_('descargar-excel')}`,
            title: _('reporte-comision-suma-pagadas'),
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
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
        ordering: false,
        destroy: true,
        ordering: false,
        columns: [{
            "data": function (d) {
                return '<p class="m-0">' + d.id_pago_suma + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.referencia + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.sede + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "data": function (d) {
                return `<span padding: 7px 10px; border-radius: 20px;"><label class="m-0 fs-125"><b class="label lbl-dark-blue">${d.estatus}</b></label><span>`;
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<button href="#" value="' + data.id_pago_suma + '"  data-referencia="' + data.referencia + '" ' + 'class="btn-data btn-blueMaderas consultar_history m-auto" data-toggle="tooltip" data-placement="top"title="' + _('detalles') + '">' + '<i class="fas fa-info"></i></button>';
            }
        }],
        ajax: {
            url: general_base_url + "Suma/getAllComisionesByUser",
            type: "POST",
            data: { anio: anio },
            dataType: 'json',
            dataSrc: ""
        },
    });

    $('#tabla_comisiones_suma').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#tabla_comisiones_suma tbody").on("click", ".consultar_history", function (e) {
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");
        modalHistorial();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5>' + _('referencia') + ': <b text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + referencia + '</b></h5></p>');
        $.getJSON(general_base_url + "Suma/getHistorial/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>' + _('modificado-por') + ': </small><b>' + v.modificado_por + ' </b></a><br></div><div class="float-end text-right"><a> ' + v.fecha_movimiento + ' </a></div><div class="col-md-12"><p class="m-0"><small>' + _('comentario') + ': </small><b>' + v.comentario + '</b></p></div><h6></h6></div></div></li>');
                $('#spiner-loader').addClass('hide');
            });
        });
    });

    applySearch(tabla_suma);

}

$("#anio_suma").ready(function () {
    let yearBegin = 2019;
    let currentYear = moment().year()
    while (yearBegin <= currentYear) {
        $("#anio_suma").append(`<option value="${yearBegin}">${yearBegin}</option>`);
        yearBegin++;
    }
    $("#anio_suma").selectpicker('refresh');
});

$("#anio_suma").on("change", function () {
    tableComisionesSuma(this.value);
    $('#tabla_comisiones_suma').removeClass('hide');
})

$('a[data-toggle="tooltip"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function asignarValorColumnasDT(nombre_datatable) {
    if (!columnas_datatable[`${nombre_datatable}`]) {
        columnas_datatable[`${nombre_datatable}`] = { titulos_encabezados: [], num_encabezados: [] };
    }
}

let titulosHistorialDescuentos = [];
// $('#tablaHistorialDescuentos thead tr:eq(0) th').each(function (i) {
//     var title = $(this).text();
//     titulosHistorialDescuentos.push(title);
//     $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
//     $('input', this).on('keyup change', function () {
//         if ($('#tablaHistorialDescuentos').DataTable().column(i).search() !== this.value) {
//             $('#tablaHistorialDescuentos').DataTable().column(i).search(this.value).draw();
//         }
//     });
// 	$('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
// });



// onLoadTranslations(function(){
    construirHead("tablaHistorialDescuentos");

    
    


    $("#tipo_historial_casas").on("change", function(){
        seleccion = $(this).val();

        if(seleccion == 1) {
            var enlace = 'Comisiones/getHistorialDescuentosPorUsuario';
            $("#tabla_historialGral, #tablaHistorialDescuentos").removeClass('hide');
        } else if(seleccion == 3) {
            var enlace = 'Casas_comisiones/getHistorialDescuentosPorUsuario';
            $("#tabla_historialGral, #tablaHistorialDescuentos").removeClass('hide');
        }

        consultarHistorialDescuentos(enlace)
    });



    function consultarHistorialDescuentos(enlace) {
        
        tablaHistorialDescuentos = $("#tablaHistorialDescuentos").DataTable({
            dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%', 
            scrollX:true,  
            ordering: false,             
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: _('descargar-excel'),
                    title: _('historial-descuentos'),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        format: {
                            header: function (d, columnIdx) {
                                return $(d).attr('placeholder').toUpperCase();
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: `${general_base_url}/static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            ordering: false,
            destroy: true,
            deferRender: true,
            columns: [{
                data: 'id_pago_i'
            },
            {   
                data: 'nombreResidencial'
            },
            {   
                data: 'nombreCondominio'
            },
            {   
                data: 'nombreLote'
            },
            {
                data: 'referencia'
            },
            {   
                data: 'precioLote'
            },
            {   
                data: 'comisionTotal'
            },
            {   
                data: 'montoDescuento'
            },
            {
                data: function(d){
                    TextoMostrar = '';
                    if(d.RelacionMotivo == 'NA'){
                        if(d.evidencia == null ){
                            TextoMostrar += `
                            <p class="m-0">
                            <span  id="textoInformacion" name="textoInformacion" class="label lbl-gray">
                                ${_('prestamo-sin-evidencia')}
                            </span>
                            </p>
                            `;
                        }else{

                        }
                    }else if(d.RelacionMotivo == 'Sin préstamo relacionado'){

                        TextoMostrar += `	
                        <p class="m-0">
                        <span  id="textoInformacion" name="textoInformacion" class="label lbl-gray">
                            ${d.RelacionMotivo} 
                        </span>
                        </p>`;
        
                    }
                    

                    TextoMostrar += `<p class="m-0"><span class="label lbl-green">${d.tipoDescuento}</span></p>`;
                    return TextoMostrar;
                    }
            },
            { 
                data: function(d) {
                    
                    var botonesMostrar = ``;

                if(d.relacion_evidencia != '' && d.relacion_evidencia !== null){
                    if(d.relacion_evidencia != 'true' ){
                        botonesMostrar += `
                        <button href="#" value="${d.id_pago_i}"  id="preview" 
                        data-ruta="UPLOADS/EvidenciaGenericas"
                        data-doc="${d.relacion_evidencia}"   
                        class="btn-data btn-orangeYellow " title="${_('ver-evidencia')}">
                            <i class="fas fa-folder-open">
                            </i>
                        </button>`; 
                        botonesMostrar += 
                        ` <button href="#" value="${d.id_pago_i}"  
                            id="historial_previa"  name="historial_previa"
                            data-ruta="UPLOADS/EvidenciaGenericas"
                            data-opcion="${d.opcion}"   
                            class="btn-data btn-gray " title="${_('ver-historial-evidencia')}">
                            <i class="fas fa-th-list"></i>
                            </i>
                        </button>`; 
                    } else if(d.evidencia != null){
                        botonesMostrar += `
                        <button href="#" value="${d.id_pago_i}"  id="preview" data-doc="${d.evidencia}"  
                        data-ruta="static/documentos/evidencia_prestamo_auto" 
                        class="btn-data btn-violetDeep " title="${_('ver-evidencia')}">
                            <i class="fas fa-folder-open">
                            </i>
                        </button>`; 
                        }else{
                            botonesMostrar += ``; 
                        }
                
                }
                    return `<div class="d-flex justify-center">${botonesMostrar} <button href="#" value="${d.id_pago_i}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="${_('detalles')}" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button><div>`;
                }
            }],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
            },
            ajax: {
                url: `${general_base_url}${enlace}`,
                type: "POST",
                cache: false,
            }
        });

        applySearch(tablaHistorialDescuentos);

    }

// });

$(document).on('click', '.consultarDetalleDelPago', function(e) {
    let ruta = $('#tipo_historial').val() == 4 ? 'Seguros' : ($('#tipo_historial').val() == 3 || $('#tipo_historial_casas').val() == 3 ?'Casas_comisiones':'Pagos');
    $("#comments-list-asimilados").html('');
    $("#nameLote").html('');
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    e.stopImmediatePropagation();
    id_pago = $(this).val();
    lote = $(this).attr("data-value");
    modalHistorial();
    $("#nameLote").append(`<p><h5>${_('historial-pago')}: <b>${lote}</b></h5></p>`);
    $.getJSON(`${general_base_url}${ruta}/getComments/${id_pago}`).done(function (data) {
        if (data == '' || data == null || data == undefined) {
            $("#comments-list-asimilados").append(`<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>${_('sin-historial')} </small></a></div><h6></h6></div></div></li>`);
            $('#spiner-loader').addClass('hide');

        }
        $.each(data, function (i, v) {
            $("#comments-list-asimilados").append(`<li><div class="container-fluid"><div class="row"><div class="col-md-6"><a><small>${_('usuario')}: </small><b>${v.nombre_usuario}</b></a><br></div><div class="float-end text-right"><a>${v.fecha_movimiento}</a></div><div class="col-md-12"><p class="m-0"><small>${_('comentario')}: </small><b>${v.comentario}</b></p></div><h6></h6></div></div></li>`);
            $('#spiner-loader').addClass('hide');
        });
    });
});


    function cargartabla(){
        if(usuario_id !=3){
            var enlace = 'Comisiones/getHistorialDescuentosPorUsuario';
            $("#tablaHistorialDescuentos").removeClass('hide');
            consultarHistorialDescuentos(enlace);
        }
    }

$(document).ready(function () {

    

    let titulosHistorialOOAM = [];
    $('#tablaHistorialOOAM thead tr:eq(0) th').each(function (i) {
        var titleooam = $(this).text();
        titulosHistorialOOAM.push(titleooam);
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${titleooam}" placeholder="${titleooam}"/>`);
        $('input', this).on('keyup change', function () {
            if ($('#tablaHistorialOOAM').DataTable().column(i).search() !== this.value) {
                $('#tablaHistorialOOAM').DataTable().column(i).search(this.value).draw();
            }
        });
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });
    consultarHistorialOOAM();
});

function consultarHistorialOOAM() {
    consultarHistorialOOAM = $("#tablaHistorialOOAM").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ordering: false,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr:`${_('descargar-excel')}`,
            title: _('historial-descuentos'),
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosHistorialOOAM[columnIdx] + ' ';
                        // return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        deferRender: true,
        columns: [{
            data: 'id_pago_i'
        },
        {
            data: 'id_comision'
        },
        {
            data: 'proyecto'
        },
        {
            data: 'precio_lote'
        },
        {
            data: 'comision_total'
        },
        {
            data: 'porcentaje_decimal'
        },
        {
            data: 'estatus'
        },
        {
            data: 'fecha_creacion'
        },
        {
            data: 'id_usuario'
        },
        {
            data: 'lote'
        },
        {
            data: 'pj_name'
        },
        {
            data: 'forma_pago'
        },
        {
            data: function (d) {
                return `<div class="d-flex justify-center"><button href="#" value="${d.id_pago_i}" data-value="${d.nombreLote}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="${_('detalles')}" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button></div>`;
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
        },
        ajax: {
            url: `${general_base_url}Ooam/getDatosHistorialOOAM`,
            type: "POST",
            cache: false,
        }
    });
}

$(document).on("click", "#preview", function () {
    var itself = $(this);
    var ruta = $(this).attr('data-ruta');
    $('#modal_vista_evidencias').modal('hide')
    Shadowbox.open({
        content: `<div>
                    <iframe style="overflow:hidden;width: 100%;height: 100%; position:absolute;z-index:9999!important;" 
                        src="${general_base_url}${itself.attr('data-ruta')}/${itself.attr('data-doc')}">
                    </iframe>
                </div>`,
        player: "html",
        title: _('visualizando-archivo'),
        width: 985,
        height: 660
    });
});

$(document).on("click", "#historial_previa", function () {


    $("#modal_vista_evidencias").modal();
    $("#modal_vista_evidencias .modal-header").html("");
    $("#modal_vista_evidencias .modal-body").html("");
    $("#modal_vista_evidencias .modal-footer").html("");

    const Modalheader = $('#modal_vista_evidencias .modal-body');
    const Modalbody = $('#modal_vista_evidencias .modal-body');
    const Modalfooter = $('#modal_vista_evidencias .modal-footer');
    var dataModal = ``;

    Modalheader.append(`
            
                <h4>${_(evidencias - descuento)}.
                </h4>
        `);
    dataModal += `<div class="col-md-12"><div class="d-flex justify-center "  style="padding-top: 25px;">`;

    var opcion = $(this).attr('data-opcion');

    var com2 = new FormData();
    var conta = 0;
    com2.append("id_opcion", opcion);
    if (opcion != '') {
        $.ajax({
            url: general_base_url + 'Descuentos/historial_evidencia_general',
            data: com2,
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                conta = 1;
                data.forEach(idx => {

                    dataModal += ` <button href="#" value="${idx.id_motivo}"  id="preview" 
                    data-ruta="UPLOADS/EvidenciaGenericas"
                    data-doc="${idx.evidencia}"   
                    class="btn-data btn-orangeYellow " title="${_('ver-evidencia')} ${conta}">
                        <i class="fas fa-folder-open">
                        </i>
                    </button>`;
                    conta++;
                });
                dataModal += `</div"></div>`;
                Modalbody.append(dataModal);
            },
            error: function () {
                alerts.showNotification("top", "right", _('comunicarse-sistemas'), "danger");
            }
        });
    } else {
        alerts.showNotification("top", "right", _('faltan-datos-intentar-mas-tarde-comunicar-sistemas'), "warning");
    }

});

var tabla_bono = [];

$(document).on('click', ".ver_bonos", function (e) {

    var id_pago_i = $(this).val();

    asignarValorColumnasDT("tabla_bono");
    $('#tabla_bono thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            columnas_datatable.tabla_bono.titulos_encabezados.push(title);
            columnas_datatable.tabla_bono.num_encabezados.push(columnas_datatable.tabla_bono.titulos_encabezados.length - 1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        if (title !== '') {
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
            $('input', this).on('keyup change', function () {
                if ($('#tabla_bono').DataTable().column(i).search() !== this.value) {
                    $('#tabla_bono').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });
    $('#boton').prop('disabled', true);

    $("#observar_bonos .modal-footer").html('');

    $("#tabla_bono").prop("hidden", false);
    construirHead('tabla_bono');
    tabla_bono = $("#tabla_bono").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: 'HISTORIAL BONOS',
            exportOptions: {
                columns: columnas_datatable.tabla_bono.num_encabezados,
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + columnas_datatable.tabla_bono.titulos_encabezados[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        ordering: false,
        destroy: true,
        deferRender: true,
        columns: [{
            "data": function (d) {
                var lblStats;
                lblStats = '<p class="m-0"><b>' + d.id_pago_bono + '</b></p>';
                return lblStats;
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.proyecto + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.condominio + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.nombreLote + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.precio_lote) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + formatMoney(d.comision_total) + ' </p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + formatMoney(d.dispersado) + '</b></p>';
            }
        },
        {
            "data": function (d) {
                if (d.activo == 0 || d.activo == '0') {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p><p><span class="label lbl-warning">BAJA</span></p>';
                }
                else {
                    return '<p class="m-0"><b>' + d.user_names + '</b></p>';
                }
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0">' + d.puesto + '</p>';
            }
        },
        {
            "data": function (d) {
                var etiqueta;
                var descuento = d.descuento_aplicado == 1 ? `<p class="m-0"><span class="label lbl-gray" style=""> DESCUENTO</span></p>` : '';
                if (d.pago_neodata < 1) {
                    etiqueta = '<p class="m-1">' + '<span class="label" style="background:' + d.color + '18; color:' + d.color + '">' + d.estatus_actual + '</span>' + '</p>' + '<p class="m-1">' + '<span class="label lbl-green">IMPORTACIÓN</span></p>';
                } else {
                    etiqueta = '<p class="m-0"><span class="label" style="background:' + d.color + '18; color: ' + d.color + '; ">' + d.estatus_actual + '</span></p>';
                }

                return etiqueta + descuento;
            }
        }
            // ,
            // { 
            //     "orderable": false,
            //     "data": function( data ){
            //         var BtnStats = '';
            //         const BTN_DETASI = `<button href="#" value="${data.id_pago_bono}" data-value='"${data.nombreLote}"' data-code="${data.cbbtton}" class="btn-data btn-blueMaderas consultarDetalleDelPago" title="DETALLES" data-toggle="tooltip" data-placement="top"><i class="fas fa-info"></i></button>`;

            //          BtnStats += BTN_DETASI;

            //         return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            //     }
            // }
        ],
        columnDefs: [{
            "orderable": false,

        }],
        ajax: {
            "url": general_base_url + "Casas_comisiones/getBonoHistorialPago/" + id_pago_i,
            "type": "POST",
            cache: false,
            "data": function (d) { }
        },
    });

    $('#tabla_bono').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#observar_bonos .modal-footer").append(`
      
        <button data-toggle="tooltip" data-placement="top"type="button" class="btn btn-danger btn-simple"  data-dismiss="modal" value="CERRAR"> CERRAR</button>
        
    `);
    $("#observar_bonos").modal();

});

