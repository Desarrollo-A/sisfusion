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

$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? 0 : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    tabla_inventario = $("#tablaInventario").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contratacion/get_inventario/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Inventario lotes',
            exportOptions: {
                columns: coordinador = id_rol_general == 11 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 27, 28, 29, 30, 31],
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
            className: 'btn buttons-pdf',
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
            targets: [22, 23, 24],
            visible: coordinador = id_rol_general == 11 ? true : false
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
            visible: (id_rol_general == 11) ? true : false,
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
    let idLote = $(this).val();
    if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
        $.getJSON(`${general_base_url}Contratacion/getClauses/${idLote}`).done(function (data) {
            $('#clauses_content').html(data[0]['nombre']);
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
            { data: "comentario" },
            { data: "modificado" },
            { data: "usuario" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/historialProcesoLoteOp/${idLote}`,
            dataSrc: ""
        },
    });
}

$('#tablaHistoriaLiberacion').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({ trigger: "manual" });
});

// Volver a aplicar tooltips en elementos filtrados
$('#tablaHistoriaLiberacion').on('search.dt', function() {
    $('[data-toggle="tooltip"]').tooltip('dispose'); // Elimina los tooltips actuales
    $('[data-toggle="tooltip"]').tooltip({ trigger: "manual" }); // Vuelve a inicializar los tooltips en todos los elementos
    $('[data-toggle="tooltip"]').tooltip('show'); // Muestra los tooltips en todos los elementos
});

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
