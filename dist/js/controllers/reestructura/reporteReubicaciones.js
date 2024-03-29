let titulosTabla = [];
$('#tablaReporteReubicaciones thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#tablaReporteReubicaciones').DataTable().column(i).search() !== this.value) {
            $('#tablaReporteReubicaciones').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$('#tablaReporteReubicaciones').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Reporte de ventas',
        title:"Reporte de ventas",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
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
        url: general_base_url+"static/spanishLoader_v2.json",
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
                return `<span class='label lbl-blueMaderas'>${d.tipo_proceso}</span>`;
            }
        },
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "nombreCliente" },
        { data: "nombreAsesor" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        {
            data: function (d) {
                return `<span class="label lbl-violetBoots">${d.estatusPreproceso}</span>`;
            }
        }, 
        {
            data: function (d) {
                return `<span class="label lbl-green">${d.procesoVenta}</span>`;
            }
        },
        { data: "nombreResidencial2" },
        { data: "nombreCondominio2" },
        { data: "nombreLote2" },
        {
            data: function (d) {
                return `<div class="d-flex justify-center">
                <button class="btn-data btn-blueMaderas btn-historial"
                data-toggle="tooltip" 
                data-placement="left"
                title="Consultar historial de movimientos"
                data-idLote="${d.idLote}">
                <i class="fas fa-info"></i>
                </button></div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getReporteReubicaciones`,
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
