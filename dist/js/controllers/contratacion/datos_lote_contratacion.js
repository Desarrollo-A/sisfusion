$(document).ready(function () {
    loadSelectOptions();
});

function loadSelectOptions() {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#idResidencial").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idEstatus").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
        }
        $("#idEstatus").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/sedesPorDesarrollos`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_sede'];
            var name = data[i]['nombre'];
            $("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#sedes").selectpicker('refresh');
    }, 'json');
}

$('#idResidencial').change(function () {
    $('#spiner-loader').removeClass('hide');
    $('#tablaInventario').removeClass('hide');
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    });
});


let roles_excluidos = [1, 2, 3, 4, 5, 6, 7, 9];
$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? 0 : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    construirHead("tablaInventario");
    let tabla_6 = $("#tablaInventario").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contratacion/get_inventario/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: (roles_excluidos.includes(id_rol_general)) ? 'hide' : 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: _('inventario-lotes'),
            exportOptions: {
                columns: coordinador = (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70  || id_usuario_general == 9897)   ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 69] : ( (id_usuario_general == 2748 || id_usuario_general == 5957) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31, 69]  : ((id_usuario_general==9495 || id_usuario_general==14944) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 5, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69]: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 26, 27, 28, 29, 30, 31, 69])),

                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: (roles_excluidos.includes(id_rol_general)) ? 'hide' : 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: _('inventario-lotes'),
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 22],
                    format: {
                        header:  function (d, columnIdx) {
                            return $(d).attr('placeholder').toUpperCase();
                        }
                    }
                }
            }],
        columnDefs: [{
            targets: [22, 23, 24, 32],
            visible: coordinador = ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957   || id_usuario_general == 9897)) ? true : false
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        fixedColumns: true,
        columns: [{
            data: 'nombreResidencial'
        },
            {
                data: 'nombreCondominio'
            },
            {
                data: function (d) {
                    if (d.casa == 1)
                        return `${d.nombreLote} <br><span class="label lbl-violetDeep">${d.nombre_tipo_casa}</span>`
                    else
                        return d.nombreLote;
                }
            },
            { data: 'idLote' },
            {
                data: function (d) {
                    return d.superficie + ' <b>m<sup>2</sup></b>';
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio * d.sup);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.totalNeto2);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio);
                }
            },
            { data: 'referencia' },
            { data: 'msni' },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.asesor2;
                    else
                        return d.asesor;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.coordinador2;
                    else
                        return d.coordinador;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.gerente2;
                    else
                        return d.gerente;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.subdirector2;
                    else
                        return d.subdirector;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.regional22;
                    else
                        return d.regional;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`;
                    else
                        return d.regional2;
                }
            },
            {
                data: function (d) {
                    let libContraloria = (d.observacionContratoUrgente == '1') ? `<center><span class="label lbl-pink" data-i18n="lib-controloria">${_('lib-contraloria')}</span> <center><p><p>` : '';
                    return d.tipo_venta == null ?
                        `<center><span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.descripcion_estatus}</span> ${libContraloria} <center>` :
                        `<center><span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label lbl-green">${d.tipo_venta}</span> ${libContraloria} <center>`;
                }
            },
            { data: 'statusContratacion' },
            {
                data: function (d) { // VALIDAR FECHAS NULL DESDE LA QUERY
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.fecha_modst;
                    else
                        return d.fechaApartado;
                }
            },
            {
                data: function (d) { // VALIDAR FECHAS NULL DESDE LA QUERY
                    if (d.comentario == null || d.comentario == 'NULL' || d.comentario == '')
                        return `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`;
                    else
                        return d.comentario;
                }
            },
            { data: 'lugar_prospeccion' },
            { data: 'fecha_validacion' }, // VALIDAR FECHA NULL DESDE LA QUERY
            {
                data: function (d) {
                    return  formatMoney(d.cantidad_enganche);
                }
            },
            {
                visible: (id_rol_general == 11) ? true : false,
                data: function (d) {
                    return d.idStatusContratacion; // VALIDAR ESTATUS NULL DESDE LA QUERY
                }
            },
            {
                visible: ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957   || id_usuario_general == 9897)) ? true : false,
                data: function (d) {
                    return d.nombreCliente; // VALIDAR CLIENTE NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_rol_general == 11) ? true : false,
                data: function (d) {
                    return d.nombreCopropietario; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            { data: 'comentario_administracion' },
            {
                data: function(d){
                    if(d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null || d.fecha_creacion == '')
                        return `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`
                    else
                        return d.fecha_creacion;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return `<center><span class="label lbl-violetBoots" data-i18n="reubicacion">${_("reubicacion")}</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return d.fechaAlta;
                    else
                        return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                }
            },
            {
                data: function(d){
                  let banderaTexas =   [98851,94330,98896,98889,98816,98845,99531,94380,97928,93716,97811,65997,98772,98773,85297,100658,100481,100427,100522,100717,100765,100816,100041,100283,100545,101059,101567,100120,101323,100199,99978,99968,99937,101377,102005,102006,99964,100780,100340,100339,101377,101911].indexOf(parseInt(d.idLote)) >= 0 ? 1 : 0;
                    if(d.venta_compartida != 0)
                        return `<center><span class="label lbl-green" data-i18n="compartida">${_("compartida")}</span> <center>`;
                    else
                        return (parseInt(banderaTexas) == 1 ? `<center><span class="label lbl-green" data-i18n="compartida-subdirector">${_('compartida-subdirector')}</span> <center>`   : `<center><span class="label lbl-gray" data-i18n="no-aplica" >${_("no-aplica")}</span> <center>`);
                }
            },
            {
                data: function(d) {
                    if(d.ubicacion != null)
                        return `<center><span class="label lbl-oceanGreen">${d.ubicacion}</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray" data-i18n="no-aplica" >${_("no-aplica")}</span> <center>`;
                }
            },
            {
                visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70   || id_usuario_general == 9897) ? true : false,
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            {
                visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70   || id_usuario_general == 9897) ? true : false,
                data: function (d) {
                    return `<span class='label lbl-oceanGreen'>${d.sedeCliente}</span>`;
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return d.clave; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    let documentacionString = '';
                    if(d.personalidad_juridica == 1){
                        //32
                        //persona moral: ds.actaConstitutiva_pm, ds.poder_pm, ds.idOficialApoderado_pm, ds.idDomicilio_pm
                        if(d.actaConstitutiva_pm==1){
                            documentacionString += `-<span data-i18n="acta-constitutiva">${_('acta-constitutiva')}</span><br>`;
                        }
                        if(d.poder_pm==1){
                            documentacionString += `-<span data-i18n="carta-poder">${_('carta-poder')}</span><br>`;
                        }
                        if(d.idOficialApoderado_pm==1){
                            documentacionString += `-<span data-i18n="id-oficial">${_('id-oficial')}</span><br>`;
                        }
                    }
                    else if(d.personalidad_juridica == 2){
                        //31
                        //persona fisica: ds.idOficial_pf, ds.idDomicilio_pf, ds.actaMatrimonio_pf
                        if(d.idOficial_pf==1){
                            documentacionString += `-<span data-i18n="identificacion-oficial">${_('identificacion-oficial')}</span><br>`;
                        }
                        if(d.idDomicilio_pf==1){
                            documentacionString += `-<span data-i18n="comprobante-domicilio">${_('comprobante-domicilio')}</span><br>`;
                        }
                        if(d.actaMatrimonio_pf==1){
                            documentacionString += `-<span data-i18n="acta-matrimonio">${_('acta-matrimonio')}</span><br>`;
                        }
                    }
                    return myFunctions.validateEmptyField(documentacionString); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return d.nombreCliente; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono1); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono2); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.correo); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha_nacimiento); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nacionalidad); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.originario_de); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.estado_civil); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nombre_conyugue); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.regimen_matrimonial); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.domicilio_particular); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.ocupacion); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.puesto); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField( d.antiguedad); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.edadFirma); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.domicilio_empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono_empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.tipo_vivienda); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nombreCopropietario); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.referencia); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.precio); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.costom2f); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.municipio); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.importOferta); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.letraImport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.saldoDeposito); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.aportMenusalOfer); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha1erAport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaLiquidaDepo); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495  || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha2daAport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.referenciasPersonales); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495 || id_usuario_general == 14944) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.observacion); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                data: function (d) {
                    if (d.tipoEnganche == 0 || d.tipoEnganche == null) {
                        return `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`;  
                    }
                    return `<center>${d.nombre}<center>`;
                }
            },
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-tipo-venta="${d.tipo_venta}" data-toggle="tooltip" data-placement="left" title="${_("ver-mas-informacion")}" data-i18n-tooltip="ver-mas-informacion"><i class="fas fa-history"></i></button></center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    applySearch(tabla_6)
});

$(document).on("click", ".ver_historial", function () {
    let $itself = $(this);
    let element = document.getElementById("divTabClausulas");
    let elementHistorialEstatus = document.getElementById("divTabHistorialEstatus");
    let idLote = $(this).val();
    let rolesContraloria = [17, 70, 71, 73, 12];
    if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
        $.getJSON(`${general_base_url}Contratacion/getClauses/${idLote}`).done(function (data) {
            if (data.length >= 1)
                $('#clauses_content').html(data[0]['nombre']);
            else
                $('#clauses_content').html(_('sin-datos-mostrar'));
        });
        element.classList.remove("hide");
    } else {
        element.classList.add("hide");
        $('#clauses_content').html('');
    }
    $("#seeInformationModal").modal();
    // LLENA LA TABLA CON EL HISTORIAL DEL PROCESO DE CONTRATACIÓN DEL LOTE X
    consultarHistoriaContratacion(idLote);
    // LLENA LA TABLA CON EL HISTORIAL DE LIBERACIÓN DEL LOTE X
    consultarHistoriaLiberacion(idLote);
    // LLENA LA TABLA CON EL LISTADO DE COMISIONISTAS COMO VENTAS COMPARTIDAS DEL LOTE X
    consultarVentasCompartidas(idLote);
    //CONSULTA EL HISTORIAL DE LOS MOVIMIENTOS DEL IDSTTAUSLOTE
    if (rolesContraloria.includes(id_rol_general)) {
        $.getJSON(`${general_base_url}Contratacion/getInformationHistorialEstatus/${idLote}`).done(function (data) {
            $('#HistorialEstatus').empty()
            if (data.length == 0)
                $("#HistorialEstatus").append(`<b data-i18n="sin-registro">${_('sin-registro')}</b>`);
            else
                fillChangelog(data);
        });
        elementHistorialEstatus.classList.remove("hide");
    } else {
        elementHistorialEstatus.classList.add("hide");
        $("#HistorialEstatus").html('');
    }
});


function consultarHistoriaContratacion(idLote) {
    construirHead("tablaHistorialContratacion");
    let tablaHistorialContratacion = $('#tablaHistorialContratacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: _('historial-contratacion'),
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header:  function (d, columnIdx) {
                            return $(d).attr('placeholder').toUpperCase();
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
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    applySearch(tablaHistorialContratacion);
}


function consultarHistoriaLiberacion(idLote) {
    construirHead("tablaHistoriaLiberacion");

    let tablaHistoriaLiberacion = $('#tablaHistoriaLiberacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: _('historial-liberacion'),
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        }],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        width: '100%',
        scrollX: true,
        pageLength: 10,
        destroy: true,
        ordering: false,
        columns: [
            { data: "nombreLote" },
            { data: "precio" },
            { data: "modificado" },
            { data: "observacionLiberacion" },
            { data: "userLiberacion" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/obtener_liberacion/${idLote}`,
            dataSrc: ""
        },
    });

    applySearch(tablaHistoriaLiberacion);
}


function consultarVentasCompartidas(idLote) {
    construirHead("tablaVentasCompartidas");
    let tablaVentasCompartidas = $('#tablaVentasCompartidas').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: _('ventas-compartidas'),
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            },
        }],
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
            { data: "asesor" },
            { data: "coordinador" },
            { data: "gerente" },
            { data: "subdirector" },
            { data: "regional" },
            { data: "regional2" },
            { data: "fecha_creacion" },
            { data: "creado_por" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/getCoSallingAdvisers/${idLote}`,
            dataSrc: ""
        },
    });

    applySearch(tablaVentasCompartidas);
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

function fillChangelog(v) {
    for (var i = 0; i < v.length; i++) {
        $("#HistorialEstatus").append('<li>\n' +
            '    <div class="container-fluid">\n' +
            '       <div class="row">\n' +
            '           <div class="float-end text-right">\n' +
            '               <p>' + v[i].fecha_creacion + '</p>\n' +
            '           </div>\n' +
            '           <div class="col-md-12">\n' +
            `             <p class="m-0"><small><span data-i18n="usuario">${_('usuario')}</span>: </small><b> ` + v[i].creado_por + '</b></p>\n'+
            `             <p class="m-0"><small><span data-i18n="valor-anterior">${_('valor-anterior')}</span>: </small><b> ` + v[i].valorAnterior + '</b></p>\n' +
            `             <p class="m-0"><small><span data-i18n="valor-nuevo">${_('valor-nuevo')}</span>: </small><b> ` + v[i].valorNuevo + '</b></p>\n' +
            '           </div>\n' +
            '        <h6>\n' +
            '        </h6>\n' +
            '       </div>\n' +
            '    </div>\n' +
            '</li>');
    }
}


/*cambio de tab para switcheat*/
$('input[type=radio][name=tipoVista]').change(function(e) {
    let selectorInv = $('#card1');
    let selectorDescInv = $('#card2');
    if (this.value == 1) {

        selectorInv.removeClass('hide');
        selectorDescInv.addClass('hide');

    }
    else if (this.value == 0) {
        selectorInv.addClass('hide');
        selectorDescInv.removeClass('hide');


    }
});


$(document).on('change', "#sedes", function () {
    fillTableInventario($(this).val());
    $('#tabla_inventario_contraloria').removeClass('hide');
    $('#spiner-loader').removeClass('hide');
});



function fillTableInventario(sede) {
    construirHead("tabla_inventario_contraloria");
    let tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: (roles_excluidos.includes(id_rol_general)) ? 'hide' : 'btn buttons-excel',
            titleAttr: 'Inventario Lotes',
            title: _('inventario-lotes'),
            exportOptions: {
                columns: coordinador = ( id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70   || id_usuario_general == 9897)   ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35] : ( (id_usuario_general == 2748 || id_usuario_general == 5957) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31]  : ( (id_rol_general == 11) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31]  : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 26, 27, 28, 29, 30, 31, 32])),
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        searching: true,
        paging: true,
        ordering: false,
        fixedColumns: true,
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        columns:
            [
                {data: 'nombreResidencial'},
                {data: 'nombreCondominio'},
                {data: 'nombreLote'},
                { data: 'idLote' },
                {
                    data: function (d) {
                        return d.sup + ' <b>m<sup>2</sup></b>';
                    }
                },
                {
                    data: function (d) {
                        return formatMoney(d.precio);
                    }
                },
                {
                    data: function (d) {
                        return formatMoney(d.totalNeto2);
                    }
                },



                {
                    data: function (d) {
                        return formatMoney(d.precio * d.sup);
                    }
                },

                {data: 'referencia'},
                {data: 'msni'},
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.asesor2;
                        else
                            return d.asesor;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.coordinador2;
                        else
                            return d.coordinador;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.gerente2;
                        else
                            return d.gerente;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.subdirector2;
                        else
                            return d.subdirector;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.regional22;
                        else
                            return d.regional;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`;
                        else
                            return d.regional2;
                    }
                },
                {
                    data: function (d) {
                        libContraloria = (d.observacionContratoUrgente == '1') ? `<center><span class="label lbl-warning" data-i18n="lib-contraloria">${_('lib-contraloria')}</span> <center><p><p>` : '';
                        valTV = (d.tipo_venta == null) ? '<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <center>' :
                            '<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <p><p> <span class="label lbl-warning">' + d.tipo_venta + '</span> <center>';
                        return valTV + libContraloria;
                    }
                },
                {
                    data: function (d) {
                        return (d.estatusContratacion == null || d.estatusContratacion=='') ? `<span data-i18n="sin-especificar2"> ${_("sin-especificar2")}</span>`:d.estatusContratacion;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                            return d.fecha_modst;
                        else
                            return (d.fechaApartado == null || d.fechaApartado=='') ? '--':d.fechaApartado;
                    }
                },
                {
                    data: function (d) {
                        if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10 || d.idStatusLote == 11 || d.idStatusLote == 4
                            || d.idStatusLote == 6 || d.idStatusLote == 7) {
                            if (d.motivo_change_status == 'NULL' || d.motivo_change_status == 'null' || d.motivo_change_status == null)
                                return ' - ';
                            else
                                return '<p>' + d.motivo_change_status + '</p>';
                        } else {
                            if (d.comentario == 'NULL' || d.comentario == 'null' || d.comentario == null)
                                return ' - ';
                            else
                                return d.comentario;
                        }
                    }
                },
                {data: 'lugar_prospeccion'},
                {
                    data: function (d) {
                        return (d.fecha_validacion == null || d.fecha_validacion=='') ? '--': d.fecha_validacion;
                    }
                },
                {
                    data: function (d) {
                        return formatMoney(d.cantidad_enganche);
                    }
                },
                {
                    visible: (id_rol_general == 11) ? true : false,
                    data: function (d) {
                        return d.idStatusContratacion; // VALIDAR ESTATUS NULL DESDE LA QUERY
                    }
                },
                {
                    data: function (d) {
                        return (d.nombreCliente == null || d.nombreCliente=='' || d.nombreCliente==' '|| d.nombreCliente=='  ') ? `<span data-i18n="sin-especificar2">${_('sin-especificar2')}</span>`: d.nombreCliente;
                    }
                },
                {
                    visible: (id_rol_general == 11) ? true : false,
                    data: function (d) {
                        return d.nombreCopropietario; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                    }
                },
                {
                    data: function (d) {
                        return (d.comentario_administracion == null || d.comentario_administracion=='' || d.comentario_administracion==' '|| d.comentario_administracion=='  ') ? 'SIN EPECIFICAR': d.comentario_administracion;
                    }
                },
                {
                    data: function(d){
                        if(d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null || d.fecha_creacion == '')
                            return `<span data-i18n="sin-especificar2"> ${_("sin-especificar2")}</span>`;
                        else
                            return d.fecha_creacion;
                    }
                },
                {
                    data: function(d){
                        if(d.apartadoXReubicacion == 1)
                            return `<center><span class="label lbl-violetBoots" data-i18n="reubicacion">${_('reubicacion')}</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                    }
                },
                {
                    data: function(d){
                        if(d.apartadoXReubicacion == 1)
                            return d.fechaAlta;
                        else
                            return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                    }
                },
                {
                    data: function(d){
                        if(d.venta_compartida != 0)
                            return `<center><span class="label lbl-green" data-i18n="compartida">${_('compartida')}</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                    }
                },
                {
                    data: function(d) {
                        if(d.ubicacion != null)
                            return `<center><span class="label lbl-oceanGreen">${d.ubicacion}</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray" data-i18n="no-aplica">${_("no-aplica")}</span> <center>`;
                    }
                },
                {
                    visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70  || id_usuario_general == 9897) ? true : false,
                    data: function (d) {
                        return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                    }
                },
                {
                    data: function (d) {
                        if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                            return `<span class="label lbl-oceanGreen" data-i18n="reubicado">${_('reubicado')}</span>`;
                        else
                            return `<span class="label lbl-pink" data-i18n="no-vigente">${_("no-vigente")}</span>`;
                    }
                },
                {
                    data: function (d) {
                        if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                            return d.fechaAlta;
                        else
                            return `<span data-i18n="no-aplica">${_('no-aplica')}</span>`;
                    }
                },
                {
                    data: function (d) {
                        return `<span class="label lbl-oceanGreen">${d.sedeResidencial}</span>`;
                    }
                }
            ],
        ajax: {
            url: `${general_base_url}Contratacion/downloadCompleteInventory`,
            type: "POST",
            cache: false,
            data: {id_sede: sede}
        },
        initComplete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
    applySearch(tabla_inventario);

    $(window).resize(function () {
        tabla_inventario.columns.adjust();
    });
}