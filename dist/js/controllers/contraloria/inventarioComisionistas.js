$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['nombreResidencial'] + ' - ' + data[i]['descripcion']));
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
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
        }, 'json');
    });
});

let titulosInventario = [];
$('#tablaInventarioComisionistas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaInventarioComisionistas').DataTable().column(i).search() !== this.value)
            $('#tablaInventarioComisionistas').DataTable().column(i).search(this.value).draw();
    });
});

$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? 0 : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    tabla_inventario = $("#tablaInventarioComisionistas").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>" + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contraloria/getInvientarioComisionista/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MADERAS_CRM_INVENTARIO',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx] + ' ';
                        }
                    }
                }
            }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columnDefs: [{
            defaultContent: "Sin especificar",
            targets: "_all",
            searchable: true,
            orderable: true
        }],
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        fixedColumns: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            {
                data: function (d) {
                    if (d.casa == 1)
                        return `${d.nombreLote} <br><span class="label" style="background:#D7BDE2; color:#512E5F;">${d.nombre_tipo_casa}</span>`
                    else
                        return d.nombreLote;
                }
            },
            { data: 'referencia' },
            { data: 'nombreAsesor1' },
            { data: 'nombreCoordinador1' },
            { data: 'nombreGerente1' },
            { data: 'nombreAsesor2' },
            { data: 'nombreCoordinador2' },
            { data: 'nombreGerente2' },
            { data: 'nombreAsesor3' },
            { data: 'nombreCoordinador3' },
            { data: 'nombreGerente3' },
            {
                data: function (d) {
                    return d.tipo_venta == null ?
                        `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <center>` :
                        `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label" style="background:#A5D6A7; color:#1B5E20;">${d.tipo_venta}</span> <center>`;
                }
            },
            {
                data: function (d) {
                    if (d.fechaApartado == '' || d.fechaApartado == null || d.fechaApartado == 'null')
                        return 'SIN ESPECIFICAR';
                    else
                        return d.fechaApartado;
                }
            }
        ],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});
