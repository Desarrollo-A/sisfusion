let titulosTabla = [];
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 , 15, 16, 17, 18],
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
    ordering: false,
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
        { data: "idLote" },
        { data: "nombrePvOrigen" },
        { data: "totalNeto2Sep" },
        { data: "supLoteOrigen" },
        { data: "precioM2FinalOrigen" },
        { data: "nombreCliente" },
        { data: "nombreSedeRecepcion" },
        { data: "nombreAsesor" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
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
                return `<center><button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-toggle="tooltip" data-placement="left" title="VER MÁS INFORMACIÓN"><i class="fas fa-history"></i></button></center>`;
            }
        }
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

$(document).on("click", ".ver_historial", function () {
    let idLote = $(this).val();
    // LLENA LA TABLA CON EL HISTORIAL DEL PROCESO DE CONTRATACIÓN DEL LOTE X
    consultarHistoriaContratacion(idLote);
    $("#seeInformationModal").modal();
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
