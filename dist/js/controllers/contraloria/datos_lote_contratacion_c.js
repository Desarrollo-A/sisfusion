$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idResidencial'];
            var name = data[i]['descripcion'];
            $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
        }

        $("#proyecto").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idStatusLote'];
            var name = data[i]['nombre'];
            $("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#estatus").selectpicker('refresh');
    }, 'json');
});


$('#proyecto').change(function () {
    index_proyecto = $(this).val();
    $("#condominio").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/` + index_proyecto, function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idCondominio'];
                var name = data[i]['nombre'];
                $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
});

//VARIABLES DECLARADAS PARA LA OPTIMIZACION DE COLUMNAS AL MOMENTO DE GENERAR ARCHIVOS DESCARGABLES (XLSX Y PDF)
let titulos_encabezado = [];
let num_colum_encabezado = [];
$('#tabla_inventario_contraloria thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezado.push(title);
    num_colum_encabezado.push(i);
    $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value) {
            $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
        }
    });
});
//Eliminamos la ultima columna que es "Acciones"
num_colum_encabezado.pop();

$(document).on('change', '#proyecto, #condominio, #estatus', function () {
    ix_proyecto = ($("#proyecto").val() == '') ? null : $("#proyecto").val();
    ix_condominio = ($("#condominio").val() == '') ? null : $("#condominio").val();
    ix_estatus = ($("#estatus").val() == '') ? null : $("#estatus").val();
    tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        destroy: true,
        "ajax":
        {
            "url": `${general_base_url}index.php/Contratacion/get_inventario/` + ix_estatus + `/` + ix_condominio + `/` + ix_proyecto,
            "dataSrc": ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Inventario Lotes',
                title: "Inventario Lotes",
                exportOptions: {
                    columns: num_colum_encabezado,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Inventario Lotes',
                title: "Inventario Lotes",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: num_colum_encabezado,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezado[columnIdx] +' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: general_base_url+'static/spanishLoader_v2.json',
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        scrollX: true,
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
            [{
                data: 'nombreResidencial'
            },
            {
                "data": function (d) {
                    return '<p>' + (d.nombreCondominio).toUpperCase() + '</p>';
                }
            },
            {
                data: 'nombreLote'
            },
            {
                "data": function (d) {
                    return '<p>' + d.superficie + '</p>';
                }
            },
            {
                "data": function (d) {
                    var preciom2;

                    if (d.nombreResidencial == 'CCMP') {

                        if (d.idStatusLote != 3) {
                            var stella;
                            var aura;

                            if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                                d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                                d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' ||
                                d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                                d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||

                                d.nombreLote == 'CCMP-LIRIO-010' ||
                                d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                                d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                                d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {

                                stella = ((parseInt(d.total) + parseInt(2029185)) / d.superficie);
                                aura = ((parseInt(d.total) + parseInt(1037340)) / d.superficie);

                                preciom2 = '<p>S:' + formatMoney(stella).replace('$', '$ ') + '</p>' + 'A:' + formatMoney(aura).replace('$', '$ ');


                            } else {

                                stella = ((parseInt(d.total) + parseInt(2104340)) / d.superficie);
                                aura = ((parseInt(d.total) + parseInt(1075760)) / d.superficie);

                                preciom2 = '<p>S:' + formatMoney(stella).replace('$', '$ ') + '</p>' + 'A:' + formatMoney(aura).replace('$', '$ ');

                            }
                        } else if (d.idStatusLote == 3) {

                            preciom2 = '<p>' + formatMoney(d.precio).replace('$', '$ ') + '</p>';

                        }

                    } else {

                        preciom2 = '<p>' + formatMoney(d.precio).replace('$', '$ ') + '</p>';

                    }

                    return preciom2;
                }
            },
            {
                "data": function (d) {
                    var preciot;
                    if (d.nombreResidencial == 'CCMP') {

                        if (d.idStatusLote != 3) {
                            var stella;
                            var aura;

                            if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                                d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                                d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' ||
                                d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                                d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||

                                d.nombreLote == 'CCMP-LIRIO-010' ||
                                d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                                d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                                d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {

                                stella = (parseInt(d.total) + parseInt(2029185));
                                aura = (parseInt(d.total) + parseInt(1037340));

                                preciot = '<p>S:' + formatMoney(stella).replace('$', '$ ') + '</p>' + 'A:' + formatMoney(aura).replace('$', '$ ');


                            } else {

                                stella = (parseInt(d.total) + parseInt(2104340));
                                aura = (parseInt(d.total) + parseInt(1075760));

                                preciot = '<p>S:' + formatMoney(stella).replace('$', '$ ') + '</p>' + 'A:' + formatMoney(aura).replace('$', '$ ');

                            }
                        } else if (d.idStatusLote == 3) {

                            preciot = '<p>' + formatMoney(d.total).replace('$', '$ ') + '</p>';

                        }

                    } else {

                        preciot = '<p>' + formatMoney(d.total).replace('$', '$ ') + '</p>';

                    }

                    return preciot;

                }
            },
            {
                "data": function (d) {
                    if (d.totalNeto2 == null || d.totalNeto2 == '' || d.totalNeto2 == undefined) {
                        return '<p> ' + formatMoney(0).replace('$', '$ ') + '</p>';
                    } else {
                        return '<p> ' + formatMoney(d.totalNeto2).replace('$', '$ ') + '</p>';
                    }
                }
            },
            {
                data: 'referencia'
            },
            {
                data: 'msni'
            },
            {
                data: function (d) {
                    var asesor;
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        asesor = d.asesor2 == '  ' ? 'SIN ESPECIFICAR' : d.asesor2;
                    else
                        asesor = d.asesor == '  ' ? 'SIN ESPECIFICAR' : d.asesor;
                    return asesor;
                }
            },
            {
                data: function (d) {
                    var coordinador;
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        coordinador = d.coordinador2 == '  ' ? 'SIN ESPECIFICAR' : d.coordinador2;
                    else
                        coordinador = d.coordinador == '  ' ? 'SIN ESPECIFICAR' : d.coordinador;
                    return coordinador;
                }
            },
            {
                data: function (d) {
                    var gerente;
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        gerente = d.gerente2 == '  ' ? 'SIN ESPECIFICAR' : d.gerente2;
                    else
                        gerente = d.gerente == '  ' ? 'SIN ESPECIFICAR' : d.gerente;
                    return gerente;
                }
            },
            {
                data: function (d) {
                    var subdirector;
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        subdirector = d.subdirector2 == '  ' ? 'SIN ESPECIFICAR' : d.subdirector2;
                    else
                        subdirector = d.subdirector == '  ' ? 'SIN ESPECIFICAR' : d.subdirector;
                    return subdirector;
                }
            },
            {
                data: function (d) {
                    var regional;
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        regional = d.regional2 == '  ' ? 'SIN ESPECIFICAR' : d.regional2;
                    else
                        regional = d.regional == '  ' ? 'SIN ESPECIFICAR' : d.regional;
                    return regional;
                }
            },
            {
                "data": function (d) {

                    libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label label-warning";">Lib. Contraloría</span> <center><p><p>' : '';
                    valTV = (d.tipo_venta == null) ? '<center><span class="label label-danger" style="background:#' + d.color + ';">' + d.descripcion_estatus + '</span> <center>' :
                        '<center><span class="label label-danger" style="background:#' + d.color + ';">' + d.descripcion_estatus + '</span> <p><p> <span class="label label-warning";">' + d.tipo_venta + '</span> <center>';

                    return valTV + libContraloria;
                }
            },
            {
                "data": function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10) {
                        if (d.fecha_modst == 'null' || d.fecha_modst == 'NULL' || d.fecha_modst == null || d.fecha_modst == '') {
                            return '-';
                        } else {
                            return '<p>' + d.fecha_modst + '</p>';
                        }
                    } else {
                        if (d.fechaApartado == 'null' || d.fechaApartado == 'NULL' || d.fechaApartado == null || d.fechaApartado == '') {
                            return '-';
                        } else {
                            return '<p>' + d.fechaApartado + '</p>';
                        }
                    }
                }
            },
            {
                "data": function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10 || d.idStatusLote == 11 || d.idStatusLote == 4
                        || d.idStatusLote == 6 || d.idStatusLote == 7) {
                        if (d.motivo_change_status == 'NULL' || d.motivo_change_status == 'null' || d.motivo_change_status == null) {
                            return ' - ';
                        }
                        else {
                            return '<p>' + d.motivo_change_status + '</p>';
                        }
                    } else {
                        if (d.comentario == 'NULL' || d.comentario == 'null' || d.comentario == null) {
                            return ' - ';
                        }
                        else {
                            return '<p>' + d.comentario + '</p>';
                        }
                    }
                }
            },
            {
                "data": function (d) {
                    if (d.lugar_prospeccion == 'NULL' || d.lugar_prospeccion == 'null' || d.lugar_prospeccion == null) {
                        return ' - ';
                    }
                    else {
                        return '<p>' + d.lugar_prospeccion + '</p>';
                    }
                }
            },
            {
                "data": function (d) {
                    if (d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null) {
                        return ' - ';
                    }
                    else {
                        return '<p>' + d.fecha_creacion + '</p>';
                    }
                }
            },
            {
                "data": function (d) {
                    if (d.fecha_validacion == 'NULL' || d.fecha_validacion == 'null' || d.fecha_validacion == null || d.fecha_validacion == '') {
                        return '-';
                    } else {
                        return '<p>' + d.fecha_validacion + '</p>';
                    }
                }
            },
            {
                "data": function (d) {
                    return '<p>' + formatMoney(d.cantidad_enganche).replace('$', '$ ') + '</p>';
                }
            },
            {
                "data": function (d) {
                    lugar_ubicacion = (d.ubicacion == null)
                        ? '<center><span class="label lbl-orangeYellow">Sin asignar</span> <center>'
                        : '<center><span class="label lbl-violetBoots"S>' + d.ubicacion + '</span> <center>';
                    return lugar_ubicacion;
                }
            },
            {
                "data": function (d) {
                    return '<center><button class="btn-data btn-green ver_historial" value="' + d.idLote + '" data-nomLote="' + d.nombreLote + '"  data-tipo-venta="' + d.tipo_venta + '" data-toggle="tooltip" data-placement="top" title="Ver detalles generales"><i class="fas fa-history"></i></button></center>';
                }
            }]      
    });
    $(window).resize(function () {
        tabla_inventario.columns.adjust();
    });
    
});

$('#tabla_inventario_contraloria').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    })
});

$(document).on("click", ".ver_historial", function () {
    var tr = $(this).closest('tr');
    var row = tabla_inventario.row(tr);
    idLote = $(this).val();
    var $itself = $(this);
    var element = document.getElementById("li_individual_sales");
    if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
        $.getJSON(`${general_base_url}Contratacion/getClauses/` + idLote).done(function (data) {
            $('#clauses_content').html(data[0]['nombre']);
        });
        element.classList.remove("hide");
    } else {
        element.classList.add("hide");
        $('#clauses_content').html('');
    }
    $("#seeInformationModal").on("hidden.bs.modal", function () {
        $("#changeproces").html("");
        $("#changelog").html("");
        $('#nomLoteHistorial').html("");
    });
    $("#seeInformationModal").modal();
    var urlTableFred = '';
    $.getJSON(`${general_base_url}Contratacion/obtener_liberacion/` + idLote).done(function (data) {
        urlTableFred = `${general_base_url}Contratacion/obtener_liberacion/` + idLote;
        fillFreedom(urlTableFred);
    });
    var urlTableHist = '';
    $.getJSON(`${general_base_url}Contratacion/historialProcesoLoteOp/` + idLote).done(function (data) {
        $('#nomLoteHistorial').html($itself.attr('data-nomLote'));
        urlTableHist = `${general_base_url}Contratacion/historialProcesoLoteOp/` + idLote;
        fillHistory(urlTableHist);
    });
    var urlTableCSA = '';
    $.getJSON(`${general_base_url}Contratacion/getCoSallingAdvisers/` + idLote).done(function (data) {
        urlTableCSA = `${general_base_url}Contratacion/getCoSallingAdvisers/` + idLote;
        fillCoSellingAdvisers(urlTableCSA);
    });
});

function fillLiberacion(v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge success"></div>\n' +
        '<div class="timeline-panel">\n' +
        '<label><h5><b>LIBERACIÓN - </b>' + v.nombreLote + '</h5></label><br>\n' +
        '<b>ID:</b> ' + v.idLiberacion + '\n' +
        '<br>\n' +
        '<b>Estatus:</b> ' + v.estatus_actual + '\n' +
        '<br>\n' +
        '<b>Comentario:</b> ' + v.observacionLiberacion + '\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.nombre + ' ' + v.apellido_paterno + ' ' + v.apellido_materno + ' - ' + v.modificado + '</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
}

function fillProceso(i, v) {
    $("#changeproces").append('<li class="timeline-inverted">\n' +
        '<div class="timeline-badge info">' + (i + 1) + '</div>\n' +
        '<div class="timeline-panel">\n' +
        '<b>' + v.nombreStatus + '</b><br><br>\n' +
        '<b>Comentario:</b> \n<p><i>' + v.comentario + '</i></p>\n' +
        '<br>\n' +
        '<b>Detalle:</b> ' + v.descripcion + '\n' +
        '<br>\n' +
        '<b>Perfil:</b> ' + v.perfil + '\n' +
        '<br>\n' +
        '<b>Usuario:</b> ' + v.usuario + '\n' +
        '<br>\n' +
        '<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.modificado + '</span>\n' +
        '</h6>\n' +
        '</div>\n' +
        '</li>');
    // comentario, perfil, modificado,
}

let titulos_encabezadoh = [];
let num_colum_encabezadoh = [];
$('#verDet thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezadoh.push(title);
    num_colum_encabezadoh .push(i);
    $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#verDet').DataTable().column(i).search() !== this.value) {
            $('#verDet').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillHistory(urlTableHist) {
    tableHistorial = $('#verDet').DataTable({
        dom: "<'container-fluid pb-1 p-0'<'row'<'col-xs-12 col-sm-6 col-md-6 col-lg-6'B><'col-xs-12 col-sm-6 col-md-6 col-lg-6'f>>>" + "rt" + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:"100%",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: num_colum_encabezadoh,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadoh[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: num_colum_encabezadoh,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadoh[columnIdx] +' ';
                        }
                    }
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "ordering": false,
        columns: [
            { "data": "nombreLote" },
            { "data": "nombreStatus" },
            { "data": "descripcion" },
            { "data": "comentario" },
            { "data": "modificado" },
            { "data": "usuario" }
        ],
        "ajax":
        {
            "url": urlTableHist,
            "dataSrc": ""
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover",
            });
        }
    });
}

let titulos_encabezadob = [];
let num_colum_encabezadob = [];
$('#verDetBloqueo thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezadob.push(title);
    num_colum_encabezadob .push(i);
    $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#verDet').DataTable().column(i).search() !== this.value) {
            $('#verDet').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillFreedom(urlTableFred) {
    tableHistorialBloqueo = $('#verDetBloqueo').DataTable({
        responsive: true,
        dom: "<'container-fluid pb-1 p-0'<'row'<'col-xs-12 col-sm-6 col-md-6 col-lg-6'B><'col-xs-12 col-sm-6 col-md-6 col-lg-6'f>>>" + "rt" + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:"100%",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                className: 'btn buttons-excel',
                exportOptions: {
                    columns: num_colum_encabezadob,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadob[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF',
                className: 'btn buttons-pdf',
                exportOptions: {
                    columns: num_colum_encabezadob,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadob[columnIdx] +' ';
                        }
                    }
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "ordering": false,
        columns: [
            { "data": "nombreLote" },
            { "data": "precio" },
            { "data": "modificado" },
            { "data": "observacionLiberacion" },
            { "data": "userLiberacion" }
        ],
        "ajax":
        {
            "url": urlTableFred,
            "dataSrc": ""
        },
    });
}

let titulos_encabezadoc = [];
let num_colum_encabezadoc = [];
$('#seeCoSellingAdvisers thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_encabezadoc.push(title);
    num_colum_encabezadoc .push(i);
    $(this).html(`<input type="text" class="textoshead w-100" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#verDet').DataTable().column(i).search() !== this.value) {
            $('#verDet').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillCoSellingAdvisers(urlTableCSA) {
    tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable({
        responsive: true,
        dom: "<'container-fluid pb-1 p-0'<'row'<'col-xs-12 col-sm-6 col-md-6 col-lg-6'B><'col-xs-12 col-sm-6 col-md-6 col-lg-6'f>>>" + "rt" + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:"100%",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                className: 'btn buttons-excel',
                exportOptions: {
                    columns: num_colum_encabezadoc,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadoc[columnIdx] +' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF',
                className: 'btn buttons-pdf',
                exportOptions: {
                    columns: num_colum_encabezadoc,
                    format: {
                        header: function (d, columnIdx) {
                            return ' '+titulos_encabezadoc[columnIdx] +' ';
                        }
                    }
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        "destroy": true,
        "ordering": false,
        columns: [
            { "data": "asesor" },
            { "data": "coordinador" },
            { "data": "gerente" },
            { "data": "fecha_creacion" },
            { "data": "creado_por" }
        ],
        "ajax":
        {
            "url": urlTableCSA,
            "dataSrc": ""
        },
    });
}