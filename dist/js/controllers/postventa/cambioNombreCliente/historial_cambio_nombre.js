$(document).ready(function () {
    fillTable();
});

let titulos = [];
$('#table_historial thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#table_historial').DataTable().column(i).search() !== this.value)
            $('#table_historial').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

function fillTable() {
    tabla_valores_cliente = $("#table_historial").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Historial',
            title: 'Historial',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            {
                data: function (d) {
                    return `<span class="label lbl-azure">${d.tipoVenta}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-yellow">${d.ubicacion}</span>`;
                },
            },
            {
                data: function (d) {
                    let classStatus = '';
                    if(d.estatusProceso == 'Rechazado'){
                        classStatus = 'lbl-warning';
                    }else if(d.estatusProceso == 'Aceptado'){
                        classStatus = 'lbl-green';
                    }
                    return `<span class="label ${classStatus}">${d.estatusProceso}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-violetBoots">${d.tipoTramite}</span>`;
                },
            },
            {
                data: function (d) {
                    let comentario = (d.comentario == 'NULL' || d.comentario == null || d.comentario=='') ? '--' : d.comentario;
                    return `${comentario}`;
                },
            },
            { data: 'fechaUltimoEstatus' }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Postventa/getHistorialCambioNombre`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {}
        },
        order: [
            [1, 'asc']
        ],
    });
    $('#table_historial').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
