let titulosTabla = [];
let getInfoData = new Array(7);

$('#tablaReporteVentas thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaReporteVentas').DataTable().column(i).search() !== this.value)
            $('#tablaReporteVentas').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$('#tablaReporteVentas').DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Reporte de ventas',
        title: "Reporte de ventas",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [{
        searchable: false,
        visible: false
    }],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: true,
    language: {
        url: `${general_base_url}static/spanishLoader_v2.json`,
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        {
            data: function (d) {
                return `<span class="label lbl-green">${d.tipoProceso}</span>`;
            }
        },
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "referenciaDestino" },
        { data: "idLote" },
        { data: "sup" },
        { data: "nombrePvOrigen" },
        { data: "referenciaOrigen" },
        { data: "totalNeto2Sep" },
        { data: "supLoteOrigen" },
        {
            data: function (d) {
                return `$${formatMoney(d.precioM2FinalOrigen)}`;
            }
        },
        { data: "nombreCliente" },
        { visible: (id_rol_general == 15) ? false : true, data: "nombreAsesor" },
        { visible: (id_rol_general == 15) ? false : true, data: "nombreGerente" },
        { visible: (id_rol_general == 15) ? false : true, data: "nombreSubdirector" },
        { data: "fechaApartado" },
        {
            data: function (d) {
                return `<span class="label lbl-violetBoots">${d.estatusLote}</span>`;
            }
        },
        {
            data: function (d) {
                return `<span class="label lbl-blueMaderas">${d.estatusContratacion}</span><br><span class="label lbl-warning">${d.detalleUltimoEstatus}</span>`;
            }
        },
        {
            data: function (d) {
                return `${d.fechaEstatus2 == null ? 'SIN FECHA' : d.fechaEstatus2}`;
            }
        },
        {
            data: function (d) {
                return `${d.ultiModificacion}`;
            }
        },
        {
            data: function (d) {
                if(d.id_cliente_reubicacion_2 != 0 ) {
                    if((d.bandera_dispersion == 1 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2 && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 2  && d.registro_comision != 9) ||
                    (d.bandera_dispersion == 1  && d.registro_comision != 9 && d.validaLiquidadas == 0 || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM == 0))){
                       return '<br><span class="label lbl-gray">DISPERSIÓN VENTAS</span>';
                    } else if((d.bandera_dispersion == 3  && d.registro_comision == 9) ||
                    (d.bandera_dispersion == 3 && d.registro_comision != 9) ||
                    ((d.registro_comision == 1 && d.validaLiquidadas == 1 && (d.banderaOOAM == 0 || d.banderaOOAM > 0 )) || (d.registro_comision == 1 && d.validaLiquidadas == 0 && d.banderaOOAM > 0))){//LIQUIDADA 1°
                        return '<br><span class="label lbl-lightBlue">DISPERSIÓN EEC</span>';
                    }
                }
                return '<br><span class="label lbl-gray">SIN DISPERSIÓN</span>';
            },
        },
        {
            data: function (d) {
                if (d.tipoV == 1) return `<div class="d-flex justify-center"> <button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button>` + 
                                         `<div class="d-flex justify-center"><button id="verifyNeodata" class="btn-data btn-violetBoots" data-toggle="tooltip" data-placement="left" title="Verificar montos" data-nombreLote="${d.nombreLote}" data-empresa="${d.empresa}"><i class="fas fa-glasses"></i></button><div>` +
                                         construiBotonRegreso(d, d.fechaVenc, 'getInfoRe') + construirBotonCambio(d, 'getInfoRe2') + `</div>`;
                if (d.tipoV == 2) return `<div class="d-flex justify-center"> <button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button>` + 
                                         `<div class="d-flex justify-center"><button id="verifyNeodata" class="btn-data btn-violetBoots" data-toggle="tooltip" data-placement="left" title="Verificar montos" data-nombreLote="${d.nombreLote}" data-empresa="${d.empresa}"><i class="fas fa-glasses"></i></button><div>`+
                                         `</div>`;
            }
        },
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getReporteVentas`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    },
});

let titulostablaHistorialContratacion = [];
$('#tablaHistorialContratacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulostablaHistorialContratacion.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaHistorialContratacion').DataTable().column(i).search() !== this.value) {
            $('#tablaHistorialContratacion').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarHistoriaContratacion(idLote) {
    tablaHistorialContratacion = $('#tablaHistorialContratacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL CONTRATACIÓN',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulostablaHistorialContratacion[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        width: '100%',
        scrollX: true,
        pageLength: 10,
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
            { data: "nombreLote" },
            { data: "nombreStatus" },
            { data: "descripcion" },
            {
                data: function (d) {
                    return d.comentario.toUpperCase();
                }
            },
            { data: "modificado" },
            { data: "usuario" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/historialProcesoLoteOp/${idLote}`,
            dataSrc: ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

$(document).on("click", ".getInfoRe", function (e) {
    e.preventDefault();
    getInfoData[0] = $(this).attr("data-idCliente");
    getInfoData[1] = $(this).attr("data-nombreResidencial");
    getInfoData[2] = $(this).attr("data-nombreCondominio");
    // getInfoData[3] = $(this).attr("data-idCondominio");
    getInfoData[4] = $(this).attr("data-nombreLote");
    getInfoData[5] = $(this).attr("data-idLote");
    // getInfoData[6] = $(this).attr("data-fechavenc");
    // getInfoData[7] = $(this).attr("data-idMov");
    getInfoData[8] = $(this).attr("data-EstatusRegreso");

    titulo_modal = 'Regresión del lote - ';

    $(".lote").html(getInfoData[4]);
    $(".titulo_modal").html(titulo_modal);
    tipo_comprobante = $(this).attr('data-ticomp');
    $('#modalRegreso').modal('show');
});

$(document).on("click", ".getInfoRe2", function (e) {
    e.preventDefault();
    getInfoData[0] = $(this).attr("data-idCliente");
    getInfoData[1] = $(this).attr("data-nombreResidencial");
    getInfoData[2] = $(this).attr("data-nombreCondominio");
    // getInfoData[3] = $(this).attr("data-idCondominio");
    getInfoData[4] = $(this).attr("data-nombreLote");
    getInfoData[5] = $(this).attr("data-idLote");
    // getInfoData[6] = $(this).attr("data-fechavenc");
    // getInfoData[7] = $(this).attr("data-idMov");
    getInfoData[8] = $(this).attr("data-EstatusRegreso");

    titulo_modal = 'Cambio de plan de comisión del lote - ';

    $(".lote_2").html(getInfoData[4]);
    $(".titulo_modal_2").html(titulo_modal);
    tipo_comprobante = $(this).attr('data-ticomp');
    $('#modalCambio').modal('show');
});

function construiBotonRegreso(data, fechaVenc, classButton, atributoButton = '', titulo = 'REGRESAR A PREPROCESO') {
    return `<button href='#' ${atributoButton} 
                data-tiComp='${data.tipo_comprobanteD}' 
                data-nomLote='${data.nombreLote}' 
                data-idCliente='${data.id_cliente}'
                data-nombreResidencial='${data.nombreResidencial}' 
                data-nombreCondominio='${data.nombreCondominio}' 
                data-nombreLote='${data.nombreLote}' 
                data-idCondominio='${data.idCondominio}' 
                data-idLote='${data.idLote}' 
                data-fechavenc='${fechaVenc}'
                data-idMov='${data.idMovimiento}'
                data-EstatusRegreso='${data.tipo_estatus_regreso}' 
                class="btn-data btn-warning ${classButton}" 
                data-toggle="tooltip" data-placement="top" 
                title="${titulo}"> <i class="fas fa-rotate-left"></i></button>`;
}

function construirBotonCambio(data, classButton, atributoButton = '', titulo = 'ENVIAR ESTATUS') {
    return `<button href='#' ${atributoButton} 
                data-tiComp='${data.tipo_comprobanteD}' 
                data-nomLote='${data.nombreLote}' 
                data-idCliente='${data.id_cliente}'
                data-nombreResidencial='${data.nombreResidencial}' 
                data-nombreCondominio='${data.nombreCondominio}' 
                data-nombreLote='${data.nombreLote}' 
                data-idCondominio='${data.idCondominio}' 
                data-idLote='${data.idLote}' 
                data-idMov='${data.idMovimiento}'
                data-EstatusRegreso='${data.tipo_estatus_regreso}' 
                class="btn-data btn-warning ${classButton}" 
                data-toggle="tooltip" data-placement="top" 
                title="${titulo}"> <i class="fa fa-money-bill-wave"></i></button>`;
}

$(document).on('click', '#saveRegreso', function (e) { // accion para el botón de regreso del procesos y preproceso
    e.preventDefault();
    var comentario = $("#comentarioRe").val();
    var validaComent = (document.getElementById("comentarioRe").value.trim() == '') ? 0 : 1;

    let dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfoData[0]);
    dataExp1.append("nombreResidencial", getInfoData[1]);
    dataExp1.append("nombreCondominio", getInfoData[2]);
    dataExp1.append("idCondominio", getInfoData[3]);
    dataExp1.append("nombreLote", getInfoData[4]);
    dataExp1.append("idLote", getInfoData[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfoData[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);
    dataExp1.append('idMovimiento', getInfoData[7]);
    dataExp1.append('estatusRegreso', getInfoData[8]);
    dataExp1.append('comentario', comentario);
    console.log(dataExp1);

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    else {
        $('#saveRegreso').prop('disabled', true);
        $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: general_base_url + 'Reestructura/regresoProcesoVenta',
            data: dataExp1,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (result) {
                if (result.result) {
                    $('#saveRegreso').prop('disabled', false);
                    $('#modal1').modal('hide');
                    $('#tablaReporteVentas').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", result.message, "success");
                    $('#modalRegreso').modal('hide');
                }
                else {
                    alerts.showNotification("top", "right", result.message, "danger");
                }

                $('#spiner-loader').addClass('hide');
            },
            error: function () {
                $('#spiner-loader').addClass('hide');
                $('#saveRegreso').prop('disabled', false);
                $('#modal1').modal('hide');
                alerts.showNotification("top", "right", "Error al enviar la solicitud de regreso.", "danger");
            }
        });
    }
});

$(document).on('click', '#verPreproceso', function (e) {
    $("#proceso").addClass('hide');
    $("#preproceso").removeClass('hide');

    $("#tab-proceso").removeClass('active');
    $("#tab-preProceso").addClass('active');
});

$(document).on('click', '#verProceso', function (e) {
    $("#preproceso").addClass('hide');
    $("#proceso").removeClass('hide');
    $("#tab-proceso").addClass('active');
    $("#tab-preProceso").removeClass('active');
});

$(document).on("click", ".ver_historial", function () {
    let idLote = $(this).val();
    let flagFusion = 0;
    $("#spiner-loader").removeClass('hide');

    $("#preproceso").addClass('hide');
    $("#proceso").removeClass('hide');

    $("#tab-proceso").addClass('active');
    $("#tab-preproceso").removeClass('active');
    $('.btn-historial').attr('data-idLote', idLote); // se asignan los valores por default
    $('.btn-historial').attr('data-flagFusion', flagFusion);

    $.ajax({ //  se hará una consulta para poder obtener el idLote origen y si es fusion, reubicación o reestructura
        url: `${general_base_url}Reestructura/getPreOrigen`,
        type: 'post',
        dataType: 'JSON',
        data: {
            idLote
        },
        success: function (response) {
            if (response.result) {
                $('.btn-historial').attr('data-idLote', response.idLote); // se vuelven a reasignar en caso de que se traigan los datos correctamente
                $('.btn-historial').attr('data-flagFusion', 0);
            }
            else {

            }

            $("#spiner-loader").addClass('hide');
        },
        error: function (response) {
            $("#spiner-loader").addClass('hide');
        }
    });

    // LLENA LA TABLA CON EL HISTORIAL DEL PROCESO DE CONTRATACIÓN DEL LOTE X
    consultarHistoriaContratacion(idLote);
    $("#seeInformationModal").modal();
});

$(document).on("click", "#verifyNeodata", function () {
    let empresa = $(this).attr("data-empresa");
    let nombreLote = $(this).attr("data-nombreLote");
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Reporte/getMensualidadAbonoNeo`,
        data: {empresa: empresa, nombreLote: nombreLote},
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (response) {
            $("#detailPayments .modal-body").empty();
            $("#detailPayments .modal-header").empty();
            $("#detailPayments .modal-header").append('<div class="d-flex align-center titleCustom" style="background: white; border-radius:25px; justify-content: space-around"><h3 class="text-center fw-600"><b>lote</b></h3><h3 class="text-center fw-600">'+nombreLote+'</h3><i class="fas fa-times-circle fa-lg cursor-point" data-dismiss="modal" aria-hidden="true"></i></div>');
            if(response.length != 0){
                $("#detailPayments .modal-body").append(`
                    <div class="d-flex align-center justify-center">
                        <div>
                            <h3 class="text-center fw-600">Detalle de mensualidades</h3>
                            <div class="d-flex align-center justify-center">
                                <i class="fas fa-money-bill-wave-alt fa-lg mr-2" style="color:#6da36f"></i>
                                <p>Pagadas <b>${response[0]['MenPagadas']}</b></p>
                            </div>
                            <div class="d-flex align-center justify-center">
                                <i class="fas fa-hand-holding fa-lg mr-2" style="color:#666"></i></i>
                                <p>Pendientes <b>${response[0]['MenPendientes']}</b></p>
                            </div>
                            <div class="d-flex align-center justify-center">
                                <i class="fas fa-receipt fa-lg mr-2" style="color:#666"></i>
                                <p>Totales  <b>${parseInt(response[0]['MenPagadas']) + parseInt(response[0]['MenPendientes'])}</b></p>
                            </div>
                        </div>
                    </div>`);
            }
            else{
                $("#detailPayments .modal-body").append(`<div class="h-100 text-center pt-4"><img src= '${general_base_url}dist/img/empty.png' alt="Icono vacío" class="w-60"></div><h3 class="titleEmpty">`);
            }
            
            $('#spiner-loader').addClass('hide');
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#btn_change_lp').prop('disabled', false);
        }
    });
    
    $("#detailPayments").modal();
  });