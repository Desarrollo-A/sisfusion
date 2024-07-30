$(document).ready(function () {
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
});

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

let titulosInventario = [];
$('#tablaInventario thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaInventario').DataTable().column(i).search() !== this.value) {
            $('#tablaInventario').DataTable().column(i).search(this.value).draw();
        }
    });
});

let roles_excluidos = [1, 2, 3, 4, 5, 6, 7, 9];
$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    let maxPopea = 67;
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? 0 : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    tabla_inventario = $("#tablaInventario").DataTable({
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
            title: 'Inventario lotes',
            exportOptions: {
                columns: coordinador = (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70)   ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33] : ( (id_usuario_general == 2748 || id_usuario_general == 5957) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31]  : ((id_usuario_general==9495) ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 5, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67]: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 26, 27, 28, 29, 30, 31])),
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosInventario[columnIdx] + ' ';
                    }
                }
            }
        },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: (roles_excluidos.includes(id_rol_general)) ? 'hide' : 'btn buttons-pdf',
                titleAttr: 'PDF',
                title: 'Inventario lotes',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 22],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            }],
        columnDefs: [{
            targets: [22, 23, 24, 32],
            visible: coordinador = ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957)) ? true : false
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
                        return 'SIN ESPECIFICAR';
                    else
                        return d.regional2;
                }
            },
            {
                data: function (d) {
                    let libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label lbl-pink">Lib. Contraloría</span> <center><p><p>' : '';
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
                        return 'SIN ESPECIFICAR';
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
                visible: ((id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 63 || id_rol_general == 70) || (id_usuario_general == 2748 || id_usuario_general == 5957)) ? true : false,
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
                        return 'SIN ESPECIFICAR';
                    else
                        return d.fecha_creacion;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return `<center><span class="label lbl-violetBoots">REUBICACIÓN</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d){
                    if(d.apartadoXReubicacion == 1)
                        return d.fechaAlta;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d){
                    if(d.venta_compartida != 0)
                        return `<center><span class="label lbl-green">COMPARTIDA</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                data: function(d) {
                    if(d.ubicacion != null)
                        return `<center><span class="label lbl-oceanGreen">${d.ubicacion}</span> <center>`;
                    else
                        return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                }
            },
            {
                visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70) ? true : false,
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            {
                visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70) ? true : false,
                data: function (d) {
                    return `<span class='label lbl-oceanGreen'>${d.sedeResidencial}</span>`;
                }
            },
            /***********/
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return d.clave; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    let documentacionString = '';
                    if(d.personalidad_juridica == 1){
                        //32
                        //persona moral: ds.actaConstitutiva_pm, ds.poder_pm, ds.idOficialApoderado_pm, ds.idDomicilio_pm
                        if(d.actaConstitutiva_pm==1){
                            documentacionString += '-ACTA CONSTITUTIVA<br>';
                        }
                        if(d.poder_pm==1){
                            documentacionString += '-CARTA PODER<br>';
                        }
                        if(d.idOficialApoderado_pm==1){
                            documentacionString += '-IDENTIFICACIÓN OFICIAL APODERADO<br>';
                        }
                    }
                    else if(d.personalidad_juridica == 2){
                        //31
                        //persona fisica: ds.idOficial_pf, ds.idDomicilio_pf, ds.actaMatrimonio_pf
                        if(d.idOficial_pf==1){
                            documentacionString += '-IDENTIFICACIÓN OFICIAL<br>';
                        }
                        if(d.idDomicilio_pf==1){
                            documentacionString += '-COMPROBANTE DE DOMICILIO<br>';
                        }
                        if(d.actaMatrimonio_pf==1){
                            documentacionString += '-ACTA DE MATRIMONIO<br>';
                        }
                    }
                    return myFunctions.validateEmptyField(documentacionString); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return d.nombreCliente; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono1); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono2); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.correo); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha_nacimiento); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nacionalidad); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.originario_de); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.estado_civil); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nombre_conyugue); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.regimen_matrimonial); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.domicilio_particular); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.ocupacion); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.puesto); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField( d.antiguedad); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.edadFirma); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.domicilio_empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.telefono_empresa); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.tipo_vivienda); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.nombreCopropietario); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.referencia); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.precio); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.costom2f); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.municipio); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.importOferta); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.letraImport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.saldoDeposito); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return '$'+myFunctions.number_format(d.aportMenusalOfer); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha1erAport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fechaLiquidaDepo); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.fecha2daAport); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.referenciasPersonales); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_usuario_general == 9495) ? true : false,
                data: function (d) {
                    return myFunctions.validateEmptyField(d.observacion); // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            /***********/
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-tipo-venta="${d.tipo_venta}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button></center>`;
                }
            }],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
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
                $('#clauses_content').html('SIN DATOS QUE MOSTRAR');
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
                $("#HistorialEstatus").append('<b>NO HAY REGISTROS</b>');
            else
                fillChangelog(data);
        });
        elementHistorialEstatus.classList.remove("hide");
    } else {
        elementHistorialEstatus.classList.add("hide");
        $("#HistorialEstatus").html('');
    }
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
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

let titulosTablaHistoriaLiberacion = [];
$('#tablaHistoriaLiberacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosTablaHistoriaLiberacion.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaHistoriaLiberacion').DataTable().column(i).search() !== this.value) {
            $('#tablaHistoriaLiberacion').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarHistoriaLiberacion(idLote) {
    tablaHistoriaLiberacion = $('#tablaHistoriaLiberacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'HISTORIAL LIBERACIÓN',
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosTablaHistoriaLiberacion[columnIdx] + ' ';
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
}

let titulosTablaVentasCompartidas = [];
$('#tablaVentasCompartidas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosTablaVentasCompartidas.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaVentasCompartidas').DataTable().column(i).search() !== this.value) {
            $('#tablaVentasCompartidas').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarVentasCompartidas(idLote) {
    tablaVentasCompartidas = $('#tablaVentasCompartidas').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'VENTAS COMPARTIDAS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosTablaVentasCompartidas[columnIdx] + ' ';
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
            '             <p class="m-0"><small>Usuario: </small><b> ' + v[i].creado_por + '</b></p>\n'+
            '             <p class="m-0"><small>Valor anterior: </small><b> ' + v[i].valorAnterior + '</b></p>\n' +
            '             <p class="m-0"><small>Valor Nuevo: </small><b> ' + v[i].valorNuevo + '</b></p>\n' +
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
        console.log(1);

        selectorInv.removeClass('hide');
        selectorDescInv.addClass('hide');

    }
    else if (this.value == 0) {
        console.log(2);
        selectorInv.addClass('hide');
        selectorDescInv.removeClass('hide');


    }
});


$(document).on('change', "#sedes", function () {
    fillTableInventario($(this).val());
    $('#tabla_inventario_contraloria').removeClass('hide');
    $('#spiner-loader').removeClass('hide');
});


let titulos = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

function fillTableInventario(sede) {
    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: (roles_excluidos.includes(id_rol_general)) ? 'hide' : 'btn buttons-excel',
            titleAttr: 'Inventario Lotes',
            title: "Inventario Lotes",
            exportOptions: {
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
                            return 'SIN ESPECIFICAR';
                        else
                            return d.regional2;
                    }
                },
                {
                    data: function (d) {
                        libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label lbl-warning";">Lib. Contraloría</span> <center><p><p>' : '';
                        valTV = (d.tipo_venta == null) ? '<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <center>' :
                            '<center><span class="label lbl-danger" style="background:#' + d.background_sl + '18; color:#' + d.color + ';">' + d.descripcion_estatus + '</span> <p><p> <span class="label lbl-warning">' + d.tipo_venta + '</span> <center>';
                        return valTV + libContraloria;
                    }
                },
                {
                    data: function (d) {
                        return (d.estatusContratacion == null || d.estatusContratacion=='') ? 'SIN ESPECIFICAR':d.estatusContratacion;
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
                        return (d.fecha_creacion == null || d.fecha_creacion=='') ? '--': d.fecha_creacion;
                    }
                },
                {
                    data: function (d) {
                        return formatMoney(d.cantidad_enganche);
                    }
                },
                {
                    data: function (d) {
                        return (d.nombreCliente == null || d.nombreCliente=='' || d.nombreCliente==' '|| d.nombreCliente=='  ') ? 'SIN EPECIFICAR': d.nombreCliente;
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
                            return 'SIN ESPECIFICAR';
                        else
                            return d.fecha_creacion;
                    }
                },
                {
                    data: function(d){
                        if(d.apartadoXReubicacion == 1)
                            return `<center><span class="label lbl-violetBoots">REUBICACIÓN</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                    }
                },
                {
                    data: function(d){
                        if(d.apartadoXReubicacion == 1)
                            return d.fechaAlta;
                        else
                            return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                    }
                },
                {
                    data: function(d){
                        if(d.venta_compartida != 0)
                            return `<center><span class="label lbl-green">COMPARTIDA</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                    }
                },
                {
                    data: function(d) {
                        if(d.ubicacion != null)
                            return `<center><span class="label lbl-oceanGreen">${d.ubicacion}</span> <center>`;
                        else
                            return `<center><span class="label lbl-gray">NO APLICA</span> <center>`;
                    }
                },
                {
                    visible: (id_rol_general == 11 || id_rol_general == 17 || id_rol_general == 70) ? true : false,
                    data: function (d) {
                        return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                    }
                },
                {
                    data: function (d) {
                        if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                            return `<span class="label lbl-oceanGreen">REUBICADO</span>`;
                        else
                            return `<span class="label lbl-pink">NO APLICA</span>`;
                    }
                },
                {
                    data: function (d) {
                        if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                            return d.fechaAlta;
                        else
                            return 'NO APLICA';
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

    $(window).resize(function () {
        tabla_inventario.columns.adjust();
    });
}