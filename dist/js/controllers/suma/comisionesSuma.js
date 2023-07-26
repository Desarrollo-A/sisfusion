let noDia = moment().weekday();
let hora = moment().hour();
const excluir_column = ['MÁS', ''];
let titulos_encabezado = [];
let num_colum_encabezado = [];

let forma_pago = 'forma_pago'
Shadowbox.init();

// Selección de CheckBox
$(document).on("click", ".individualCheck", function() {
    totaPen = 0;
    tabla_nuevas.$('input[type="checkbox"]').each(function () {
        let totalChecados = tabla_nuevas.$('input[type="checkbox"]:checked') ;
        let totalCheckbox = tabla_nuevas.$('input[type="checkbox"]');
        if(this.checked){
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            totaPen += parseFloat(row.impuesto); 
        }
        // Al marcar todos los CheckBox Marca CB total
        if( totalChecados.length == totalCheckbox.length )
            $("#all").prop("checked", true);
        else 
            $("#all").prop("checked", false); // si se desmarca un CB se desmarca CB total
    });
    $("#totpagarPen").html(formatMoney(totaPen));
});
    // Función de selección total
function selectAll(e) {
    tota2 = 0;
    if(e.checked == true){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            tr = this.closest('tr');
            row = tabla_nuevas.row(tr).data();
            tota2 += parseFloat(row.impuesto);
            if(v.checked == false){
                $(v).prop("checked", true);
            }
        }); 
        $("#totpagarPen").html(formatMoney(tota2));
    }
    if(e.checked == false){
        $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
            if(v.checked == true){
                $(v).prop("checked", false);
            }
        }); 
        $("#totpagarPen").html(formatMoney(0));
    }
}

$("#file-upload-extranjero").on('change', function () {
    $('#archivo-extranjero').val('');
    v2 = document.getElementById("file-upload-extranjero").files[0].name;
    document.getElementById("archivo-extranjero").innerHTML = v2;
    const src = URL.createObjectURL(document.getElementById("file-upload-extranjero").files[0]);
    $('#preview-div').html("");
    $('#preview-div').append(`<embed src="${src}" width="500" height="200">`);
});

$(document).on("click", ".subir-archivo", function (e) {
    e.preventDefault();
    $('#archivo-extranjero').val('');
    $.ajax({
        url: 'getTotalComisionAsesor',
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
            $('#total-comision').html("");
            $('#total-comision').append(`Total: ${formatMoney(data.total)}`);
            $('#addFileExtranjero').modal('show');
        }
    });
});

$("#EditarPerfilExtranjeroForm").one('submit', function (e) {
    document.getElementById('sendFileExtranjero').disabled = true;
    $("#sendFileExtranjero").prop("disabled", true);
    e.preventDefault();
    const formData = new FormData(document.getElementById("EditarPerfilExtranjeroForm"));
    formData.append("dato", "valor");
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Suma/SubirPDFExtranjero',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            document.getElementById('sendFileExtranjero').disabled = false;
            $("#sendFileExtranjero").prop("disabled", false);
            if (data == 1) {
                $("#addFileExtranjero").modal('hide');
                setTimeout('document.location.reload()', 100);
            } else {
                $("#addFileExtranjero").modal('hide');
                alerts.showNotification("top", "right", "Error al subir el archivo.", "warning");
            }
        },
        error: function () {
            $("#addFileExtranjero").modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.verPDFExtranjero', function () {
    const $itself = $(this);
    Shadowbox.open({
        content: '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="' + general_base_url + 'static/documentos/extranjero_suma/' + $itself.attr('data-usuario') + '"></iframe></div>',
        player: "html",
        title: "Visualizando documento fiscal: " + $itself.attr('data-usuario'),
        width: 985,
        height: 660
    });
});

$(document).on('click', '.cuestionDelete', function () {
    const idDocumento = $(this).attr('data-idDocumento');
    $('.fileToDelete').val(idDocumento);
});

$("#deleteDocumentoExtranjero").one('submit', function (e) {
    e.preventDefault();
    const idDocumento = $('.fileToDelete').val();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Usuarios/deleteDocumentoExtranjero',
        data: { idDocumento: idDocumento },
        dataType: 'json',
        cache: false,
        beforeSend: function () {
            $('#spiner-loader').removeClass('hide');
        },
        success: function (data) {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
            $("#deleteModal").modal('hide');
        },
        error: function () {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $("#deleteModal").modal('hide');
        }
    });
});

$("#tabla_nuevas_comisiones").ready(function () {
    $('#tabla_nuevas_comisiones thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        if (title !== '') {
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip_nuevas" data-placement="top" title="${title}" placeholder="${title}"${readOnly}/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_nuevas.column(i).search() !== this.value) {
                    tabla_nuevas.column(i).search(this.value).draw();
                    var total = 0;
                    var index = tabla_nuevas.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = tabla_nuevas.rows(index).data();
                    $.each(data, function (i, v) {
                        total += parseFloat(v.total_comision);
                    });
                    document.getElementById("myText_nuevas").textContent = formatMoney(total);
                }
            });
        }
        else {
            $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)"data-toggle="tooltip_nuevas" data-placement="top" title="SELECCIONAR"/>`);
        }
    });

    $('#tabla_nuevas_comisiones').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        $.each(json, function (i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_nuevas").textContent = to;
    });

    tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            text: '<i class="fa fa-paper-plane"></i> SOLICITAR PAGO',
            action: function () {
                if (noDia == 1 || (noDia == 2 && hora <= 14)) {
                    if ($('input[name="idT[]"]:checked').length > 0) {
                        $('#spiner-loader').removeClass('hide');
                        var idcomision = $('#tabla_nuevas_comisiones input[name="idT[]"]:checked').map(function () {
                            return this.value;
                        }).get();
                        var com2 = new FormData();
                        com2.append("idcomision", idcomision);
                        $.ajax({
                            url: general_base_url + 'Suma/acepto_comisiones_user/',
                            data: com2,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: function (data) {
                                response = JSON.parse(data);
                                if (data == 1) {
                                    $('#spiner-loader').addClass('hide');
                                    $("#totpagarPen").html(formatMoney(0));
                                    $("#all").prop('checked', false);
                                    alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente a revisión.", "success");
                                    tabla_nuevas.ajax.reload();
                                    tabla_revision.ajax.reload();
                                } 
                                else if (data == 2){
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "No ha agregado un documento fiscal antes de solicitar su pago", "warning");
                                }
                                else{
                                    $('#spiner-loader').addClass('hide');
                                    alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                                }
                            },
                            error: function (data) {
                                $('#spiner-loader').addClass('hide');
                                alerts.showNotification("top", "right", "Error al enviar comisiones, intentalo más tarde", "danger");
                            }
                        });
                    }
                }
                else {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "No se pueden enviar comisiones, esperar al siguiente corte", "warning");
                }
            },
            attr: {
                class: 'btn btn-azure',
                style: `${(forma_pago != '2') ? 'position:relative; float:right' : 'display:none'}`
            }
        },
        {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA NUEVAS',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx  -1] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Solicitudes SUMA podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/6W5B97MTOCghttps://youtu.be/6W5B97MTOCg', '_blank');
            }
        }
    ],
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
        },
        {
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
                return '<p class="m-0"> ' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"> ' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "data": function (d) {
                switch (d.id_forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label lbl-dark-blue">SIN DEFINIR FORMA DE PAGO </span><br><span class="label lbl-dark-cyan">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label lbl-dark-blue">FACTURA </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label lbl-dark-blue">ASIMILADOS</span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label lbl-dark-blue">REMANENTE DIST.</span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label lbl-dark-blue">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label lbl-dark-blue">DOCUMENTACIÓN FALTANTE</span><br><span class="label lbl-dark-cyan">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return `<button href="#"
                                value="${data.id_pago_suma}"
                                data-referencia="${data.referencia}"
                                class="btn-data btn-blueMaderas consultar_history m-auto"
                                title="DETALLES"
                                data-toggle="tooltip_nuevas" 
                                data-placement="top">
                            <i class="fas fa-info"></i>
                        </button>`;
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
            searchable: false,
            className: 'dt-body-center',
            render: function (d, type, full, meta) {
                if (noDia == 1 || (noDia == 2 && hora <= 14)) {
                    switch (full.id_forma_pago) {
                        case '1': //SIN DEFINIR
                        case 1: //SIN DEFINIR
                        case '2': //FACTURA
                        case 2: //FACTURA
                            return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                            break;

                        case '5':
                        case 5:
                            if (full.fecha_abono && full.estatus == 1) {
                                const fechaAbono = new Date(full.fecha_abono);
                                const fechaOpinion = new Date(full.fecha_opinion);
                                if (fechaAbono.getTime() > fechaOpinion.getTime()) {
                                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                                }
                            }
                            return '<input type="checkbox" name="idT[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';

                        case '3': //ASIMILADOS
                        case 3: //ASIMILADOS
                        case '4': //RD
                        case 4: //RD
                        default:
                            if (full.id_usuario == 5028 || full.id_usuario == 4773 || full.id_usuario == 5381) {
                                return '<span class="material-icons" style="color: #DCDCDC;">block</span>';

                            } else {
                                return '<input type="checkbox" name="idT[]" class="individualCheck" style="width:20px;height:20px;"  value="' + full.id_pago_suma + '">';
                            }
                            break;
                    }
                } else {
                    return '<span class="material-icons" style="color: #DCDCDC;">block</span>';
                }
            },
        }],
        ajax: {
            url: general_base_url + "Suma/getComisionesByStatus",
            type: "POST",
            data: { estatus: 1 },
            dataType: 'json',
            dataSrc: ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip_nuevas"]').tooltip("destroy");
            $('[data-toggle="tooltip_nuevas"]').tooltip({ trigger: "hover" });
        }
    });

    $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_history", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + referencia + '</b></h5></p>');
        $.getJSON("getHistorial/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">' + v.comentario + '</i><br><b style="color:#39A1C0">' + v.fecha_movimiento + '</b><b style="color:gray;"> - ' + v.modificado_por + '</b></p></div>');
            });
        });
    });
});

/* Table revisión */
$("#tabla_revision_comisiones").ready(function () {
    titulos_encabezado.length = 0;
    num_colum_encabezado.length = 0;
    $('#tabla_revision_comisiones thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length - 1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip_revision"  data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);

        $('input', this).on('keyup change', function () {
            if (tabla_revision.column(i).search() !== this.value) {
                tabla_revision.column(i).search(this.value).draw();

                var total = 0;
                var index = tabla_revision.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_revision.rows(index).data();

                $.each(data, function (i, v) {
                    total += parseFloat(v.total_comision);
                });
                document.getElementById("myText_revision").textContent = formatMoney(total);
            }
        });
    });

    $('#tabla_revision_comisiones').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        $.each(json, function (i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_revision").textContent = to;
    });

    tabla_revision = $("#tabla_revision_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA EN REVISIÓN',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx ] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Solicitudes SUMA podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/6W5B97MTOCghttps://youtu.be/6W5B97MTOCg', '_blank');
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
                return '<p class="m-0"> ' + formatMoney(d.total_comision) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"> ' + formatMoney(d.impuesto) + '</p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
            }
        },
        {
            "data": function (d) {
                return '<p class="mb-0"><span class="label lbl-dark-blue">REVISIÓN CONTRALORÍA</span></p>';
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return `<button href="#"
                                value="${data.id_pago_suma}"
                                data-referencia="${data.referencia}"
                                class="btn-data btn-blueMaderas consultar_history m-auto"
                                title="DETALLES"
                                data-toggle="tooltip_revision" 
                                data-placement="top">
                            <i class="fas fa-info"></i>
                        </button>`;

            }
        }],
        ajax: {
            url: general_base_url + "Suma/getComisionesByStatus",
            type: "POST",
            data: { estatus: 2 },
            dataType: 'json',
            dataSrc: ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip_revision"]').tooltip("destroy");
            $('[data-toggle="tooltip_revision"]').tooltip({ trigger: "hover" });
        }
    });

    $("#tabla_revision_comisiones tbody").on("click", ".consultar_history", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + referencia + '</b></h5></p>');
        $.getJSON("getHistorial/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">' + v.comentario + '</i><br><b style="color:#39A1C0">' + v.fecha_movimiento + '</b><b style="color:gray;"> - ' + v.modificado_por + '</b></p></div>');
            });
        });
    });
});

// /* Table pagadas */
$("#tabla_pagadas_comisiones").ready(function () {
    titulos_encabezado.length = 0;
    num_colum_encabezado.length = 0;
    $('#tabla_pagadas_comisiones thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length - 1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip_pagadas" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
        $('input', this).on('keyup change', function () {
            if (tabla_pagadas.column(i).search() !== this.value) {
                tabla_pagadas.column(i).search(this.value).draw();

                var total = 0;
                var index = tabla_pagadas.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
                var data = tabla_pagadas.rows(index).data();

                $.each(data, function (i, v) {
                    total += parseFloat(v.total_comision);
                });
                document.getElementById("myText_pagadas").textContent = formatMoney(total);
            }
        });
    });

    $('#tabla_pagadas_comisiones').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        $.each(json, function (i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_pagadas").textContent = to;
    });

    tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA PAGADAS',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx ] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Solicitudes SUMA podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/6W5B97MTOCghttps://youtu.be/6W5B97MTOCg', '_blank');
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
                switch (d.id_forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label lbl-dark-blue">SIN DEFINIR FORMA DE PAGO </span><br><span class="label lbl-dark-cyan">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label lbl-dark-blue">FACTURA </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label lbl-dark-blue">ASIMILADOS </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label lbl-dark-blue">REMANENTE DIST. </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label lbl-dark-blue">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label lbl-dark-blue">DOCUMENTACIÓN FALTANTE </span><br><span class="label lbl-dark-cyan">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return `<button href="#"
                                value="${data.id_pago_suma}"
                                data-referencia="${data.referencia}"
                                class="btn-data btn-blueMaderas consultar_history m-auto"
                                title="DETALLES"
                                data-toggle="tooltip_pagadas" 
                                data-placement="top">
                            <i class="fas fa-info"></i>
                        </button>`;
            }
        }],
        ajax: {
            url: general_base_url + "Suma/getComisionesByStatus",
            type: "POST",
            data: { estatus: 3 },
            dataType: 'json',
            dataSrc: ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip_pagadas"]').tooltip("destroy");
            $('[data-toggle="tooltip_pagadas"]').tooltip({ trigger: "hover" });
        }
    });

    $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_history", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + referencia + '</b></h5></p>');
        $.getJSON("getHistorial/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">' + v.comentario + '</i><br><b style="color:#39A1C0">' + v.fecha_movimiento + '</b><b style="color:gray;"> - ' + v.modificado_por + '</b></p></div>');
            });
        });
    });
});
/* END pagadas */

$("#tabla_pausadas_comisiones").ready(function () {
    titulos_encabezado.length = 0;
    num_colum_encabezado.length = 0;
    $('#tabla_pausadas_comisiones thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        var title = $(this).text();
        if (!excluir_column.includes(title)) {
            titulos_encabezado.push(title);
            num_colum_encabezado.push(titulos_encabezado.length - 1);
        }
        let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
        $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip_revision" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
        $('input', this).on('keyup change', function () {
            if (tabla_pausadas.column(i).search() !== this.value) {
                tabla_pausadas.column(i).search(this.value).draw();
                var total = 0;

                var index = tabla_pausadas.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();

                var data = tabla_pausadas.rows(index).data();

                $.each(data, function (i, v) {
                    total += parseFloat(v.total_comision);
                });

                document.getElementById("myText_pausadas").textContent = formatMoney(total);
            }
        });
    });

    $('#tabla_pausadas_comisiones').on('xhr.dt', function (e, settings, json, xhr) {
        var total = 0;
        $.each(json, function (i, v) {
            total += parseFloat(v.total_comision);
        });
        var to = formatMoney(total);
        document.getElementById("myText_pausadas").textContent = to;
    });

    tabla_pausadas = $("#tabla_pausadas_comisiones").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'REPORTE COMISIONES SUMA EN PAUSA',
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_encabezado[columnIdx] + ' ';
                    }
                }
            },
        },
        {
            text: '<i class="fas fa-play"></i>',
            className: `btn btn-dt-youtube buttons-youtube`,
            titleAttr: 'Para consultar más detalles sobre el uso y funcionalidad del apartado de Solicitudes SUMA podrás visualizarlo en el siguiente tutorial',
            action: function (e, dt, button, config) {
                window.open('https://youtu.be/6W5B97MTOCghttps://youtu.be/6W5B97MTOCg', '_blank');
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
                switch (d.id_forma_pago) {
                    case '1': //SIN DEFINIR
                    case 1: //SIN DEFINIr
                        return '<p class="mb-1"><span class="label lbl-dark-blue">SIN DEFINIR FORMA DE PAGO </span><br><span class="label lbl-dark-cyan">REVISAR CON RH</span></p>';

                    case '2': //FACTURA
                    case 2: //FACTURA
                        return '<p class="mb-1"><span class="label lbl-dark-blue">FACTURA </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">SUBIR XML</span></p>';

                    case '3': //ASIMILADOS
                    case 3: //ASIMILADOS
                        return '<p class="mb-1"><span class="label lbl-dark-blue">ASIMILADOS </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '4': //RD
                    case 4: //RD
                        return '<p class="mb-1"><span class="label lbl-dark-blue">REMANENTE DIST. </span></p><p style="font-size: .5em"><span class="label lbl-dark-cyan">LISTA PARA APROBAR</span></p>';

                    case '5':
                    case 5:
                        return `
                            <p class="mb-1">
                                <span class="label lbl-dark-blue">FACTURA EXTRANJERO</span>
                            </p>
                        `;
                    default:
                        return '<p class="mb-1"><span class="label lbl-dark-blue">DOCUMENTACIÓN FALTANTE </span><br><span class="label lbl-dark-blue">REVISAR CON RH</span></p>';
                }
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return `<button href="#"
                                value="${data.id_pago_suma}"
                                data-referencia="${data.referencia}"
                                class="btn-data btn-blueMaderas consultar_history m-auto"
                                title="DETALLES"
                                data-toggle="tooltip_pausadas" 
                                data-placement="top">
                            <i class="fas fa-info"></i>
                        </button>`;
            }
        }],
        ajax: {
            url: general_base_url + "Suma/getComisionesByStatus",
            type: "POST",
            data: { estatus: 4 },
            dataType: 'json',
            dataSrc: ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip_pausadas"]').tooltip("destroy");
            $('[data-toggle="tooltip_pausadas"]').tooltip({ trigger: "hover" });
        }
    });

    $("#tabla_pausadas_comisiones tbody").on("click", ".consultar_history", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        id_pago = $(this).val();
        referencia = $(this).attr("data-referencia");

        $("#seeInformationModalAsimilados").modal();
        $("#nameLote").html("");
        $("#comments-list-asimilados").html("");
        $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">' + referencia + '</b></h5></p>');
        $.getJSON("getHistorial/" + id_pago).done(function (data) {
            $.each(data, function (i, v) {
                $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">' + v.comentario + '</i><br><b style="color:#39A1C0">' + v.fecha_movimiento + '</b><b style="color:gray;"> - ' + v.modificado_por + '</b></p></div>');
            });
        });
    });
});
/* End table pausadas */

function mandarFacturas() {
    document.getElementById('btng').disabled = true;
    guardarSolicitud();
}

function todos() {
    if ($(".checkdata1:checked").length == 0) {
        $(".checkdata1").prop("checked", true);
        sumCheck();

    } else if ($(".checkdata1:checked").length < $(".checkdata1").length) {
        $(".checkdata1").prop("checked", true);
        sumCheck();

    } else if ($(".checkdata1:checked").length == $(".checkdata1").length) {
        $(".checkdata1").prop("checked", false);
        sumCheck();
    }
}

$(document).on("click", ".subir_factura_multiple", function () {
    if (noDia == 1 || (noDia == 2 && hora <= 14)) {

        $.ajax({
            type: 'POST',
            url: `${general_base_url}Suma/validateWeek`,
            dataType: 'json',
            beforeSend: function () {
                $('#spiner-loader').removeClass('hide');
            },
            success: function (response) {
                if (response.length == 0) {
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}Suma/getComisionesByStatus`,
                        data: { estatus: 1 },
                        dataType: 'json',
                        success: function (data) {
                            $('#spiner-loader').addClass('hide');
                            $("#modal_multiples .modal-body").html("");
                            let sumaComision = 0;
                            if (!data) {
                                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
                            }
                            else {
                                $("#modal_multiples .modal-body").html("");
                                $("#modal_multiples .modal-header").html("");

                                $("#modal_multiples .modal-header").append(`<div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" style="font-size:40px;">&times;</span>
                                        </button>
                                    </div>
                                </div>`);

                                c = 0;
                                if (data.length > 0) {
                                    $("#modal_multiples .modal-body").append(`<div class="row">
                                    <div class="col-md-1"><input type="checkbox" class="form-control" onclick="todos();" id="btn_all"></div><div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b></div>`);
                                }
                                $.each(data, function (i, v) {
                                    c++;

                                    abono_asesor = (v.total_comision);
                                    $("#modal_multiples .modal-body").append('<div class="row">' +
                                        '<div class="col-md-1"><input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult' + i + '" name="comisiones_facura_mult"></div><div class="col-md-4"><input id="data1' + i + '" name="data1' + i + '" value="' + v.referencia + '" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%"></div><div class="col-md-4"><input type="hidden" id="idpago-' + i + '" name="idpago-' + i + '" value="' + v.id_pago_suma + '"><input id="data2' + i + '" name="data2' + i + '" value="' + "" + parseFloat(abono_asesor).toFixed(2) + '" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%"></div></div>');
                                });

                                $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12 text-left"><b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b></div><div class="col-lg-5"><div class="fileinput fileinput-new text-center" data-provides="fileinput"><div><br><span class="fileinput-new">Selecciona archivo</span><input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml"></div></div></div><div class="col-lg-7"><center><button class="btn btn-warning" type="button" onclick="xml2()" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center></div></div>');

                                $("#modal_multiples .modal-body").append('<p id="cantidadSeleccionada"></p>');
                                $("#modal_multiples .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                                $("#modal_multiples .modal-body").append('<form id="frmnewsol2" method="post">' +
                                    '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                                    '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                                    '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                                    '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                                    '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                                    '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                                    '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                                    '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                                    '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                                    ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"><button type="button" id="btng" onclick="mandarFacturas();" disabled class="btn btn-primary btn-block">GUARDAR</button></div><div class="col-md-4"></div><div class="col-md-4"> <button type="button" data-dismiss="modal"  class="btn btn-danger btn-block close_modal_xml">CANCELAR</button></div></div></form>');
                            }
                            $('#spiner-loader').addClass('hide');
                            $("#modal_multiples").modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        },
                        error: function () {
                            $('#spiner-loader').addClass('hide');
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                        }
                    });
                }
                else {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Ya se ha cargado una factura, esperar al siguiente corte.", "danger");
                }
            },
            error: function () {
                $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal al validar si ya se ha mandado factura.", "danger");
            }
        });
    }
    else {
        alert("NO PUEDES SUBIR FACTURAS HASTA EL PRÓXIMO CORTE.");
    }
});

//FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
function resear_formulario() {
    $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
    $("#modal_formulario_solicitud textarea").html('');
    $("#modal_formulario_solicitud #obse").val('');

    var validator = $("#frmnewsol").validate();
    validator.resetForm();
    $("#frmnewsol div").removeClass("has-error");
}

$("#cargar_xml").click(function () {
    subir_xml($("#xmlfile"));
});

function xml2() {
    subir_xml2($("#xmlfile2"));
}

var justificacion_globla = "";

function subir_xml(input) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;

    data.append("xmlfile", documento_xml);
    resear_formulario();
    $.ajax({
        url: general_base_url + "Suma/cargaxml",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function (data) {
            if (data.respuesta[0]) {
                documento_xml = xml;
                var informacion_factura = data.datos_xml;
                cargar_info_xml(informacion_factura);
                $("#solobs").val(justificacion_globla);
            }
            else {
                input.val('');
                alert(data.respuesta[1]);
            }
        },
        error: function (data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

function subir_xml2(input) {
    var data = new FormData();
    documento_xml = input[0].files[0];
    var xml = documento_xml;

    data.append("xmlfile", documento_xml);
    resear_formulario();
    $.ajax({
        url: general_base_url + "Suma/cargaxml2",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function (data) {
            if (data.respuesta[0]) {
                documento_xml = xml;
                var informacion_factura = data.datos_xml;

                cargar_info_xml2(informacion_factura);
                $("#solobs").val(justificacion_globla);
            }
            else {
                input.val('');
                alert(data.respuesta[1]);
            }
        },
        error: function (data) {
            input.val('');
            alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
        }
    });
}

$("#eliminar_factura").submit(function (e) {
    e.preventDefault();
}).validate({
    submitHandler: function (form) {
        var data = new FormData($(form)[0]);
        $.ajax({
            url: general_base_url + "Comisiones/borrar_factura",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function (data) {
                if (true) {
                    $("#modalQuitarFactura").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    alert("SE ELIMINÓ EL ARCHIVO");
                }
                else {
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },
            error: function () {
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});

function closeModalEng() {
    document.getElementById("frmnewsol").reset();
    document.getElementById("xmlfile").value = "";
    document.getElementById("totalxml").innerHTML = '';

    a = document.getElementById('inputhidden');
    padre = a.parentNode;
    padre.removeChild(a);
    $("#modal_formulario_solicitud").modal('toggle');
}

function cargar_info_xml(informacion_factura) {
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    let pago_cliente = $('#pago_cliente').val();
    let pago1 = parseFloat(pago_cliente) + .05;
    let pago2 = parseFloat(pago_cliente) - .05;

    if (parseFloat(pago1).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= parseFloat(pago2).toFixed(2)) {
        alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
        document.getElementById('btnIndi').disabled = false;
        document.getElementById("totalxml").innerHTML = '';
        disabled();
    }
    else {
        document.getElementById("totalxml").innerHTML = 'Cantidad incorrecta:' + cantidadXml;
        let elemento = document.querySelector('#total');
        elemento.setAttribute('color', 'red');
        document.getElementById('btnIndi').disabled = true;
        alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
    }

    $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
    $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

    $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
    $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

    $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

    $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
    $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

    $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

    $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

    $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

    $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

    $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
}

let pagos = [];

function cargar_info_xml2(informacion_factura) {
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;
        }
    }

    var myCommentsList = document.getElementById('cantidadSeleccionada');
    myCommentsList.innerHTML = '';
    let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
    var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
    myCommentsList.setAttribute('style', 'color:green;');
    myCommentsList.innerHTML = 'Cantidad correcta';

    if (((suma + .50).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .50).toFixed(2)) || (cantidadXml.toFixed(2) == (suma).toFixed(2))) {
        alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
        document.getElementById('btng').disabled = false;
        disabled();
    }
    else {
        var elemento = document.querySelector('#total');
        elemento.setAttribute('color', 'red');
        document.getElementById('btng').disabled = true;
        var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
        myCommentsList.setAttribute('style', 'color:red;');
        myCommentsList.innerHTML = 'Cantidad incorrecta';
        alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
    }

    $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
    $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);
    $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
    $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);
    $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);
    $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
    $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);
    $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);
    $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);
    $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);
    $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);
    $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
}

function sumCheck() {
    pagos.length = 0;
    let suma = 0;
    let cantidad = 0;
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
            pagos[index] = $("#idpago-" + index).val();
            cantidad = Number.parseFloat($("#data2" + index).val());
            suma += cantidad;

        }
    }
    var myCommentsList = document.getElementById('sumacheck');
    myCommentsList.innerHTML = 'Suma seleccionada: ' + formatMoney(suma.toFixed(3));
}

function disabled() {
    for (let index = 0; index < c; index++) {
        if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
            document.getElementById("comisiones_facura_mult" + index).disabled = true;
            document.getElementById("btn_all").disabled = true;
        }
    }
}

function guardarSolicitud() {
    let formData = new FormData(document.getElementById("frmnewsol2"));
    const labelSum = $('#sumacheck').text();
    const total = Number(labelSum.split('$')[1].trim().replace(',', ''));

    formData.append("dato", "valor");
    formData.append("xmlfile", documento_xml);
    formData.append("pagos", pagos);
    formData.append('total', total);

    $.ajax({
        url: general_base_url + 'Suma/guardar_solicitud',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        success: function (data) {
            document.getElementById('btng').disabled = false;
            if (data.resultado) {
                alert("LA FACTURA SE SUBIÓ CORRECTAMENTE");
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                tabla_revision.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else if (data == 3) {
                alert("ESTÁS FUERA DE TIEMPO PARA ENVIAR TUS SOLICITUDES");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");

            } else if (data == 4) {
                alert("EL TOTAL DE LA FACTURA NO COINCIDE CON EL TOTAL DE COMISIONES SELECCIONADAS");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            } else {
                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                $('#loader').addClass('hidden');
                $("#modal_multiples").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#modal_multiples .modal-body").html("");
                $("#modal_multiples .header").html("");
            }
        },
        error: function () {
            document.getElementById('btng').disabled = false;
            alert("ERROR EN EL SISTEMA");
        }
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
});