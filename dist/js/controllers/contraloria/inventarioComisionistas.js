$(document).ready(function () {
    getResidenciales();
    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idEstatus").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
        }
        $("#idEstatus").selectpicker('refresh');
    }, 'json');
});

$('#residenciales').change(function () {
    let idResidencial = $(this).val();
    getCondominios(idResidencial);
    $('#TableHide').removeClass('hide');
});

let titulosInventario = [];
$('#tablaInventarioComisionistas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaInventarioComisionistas').DataTable().column(i).search() !== this.value)
            $('#tablaInventarioComisionistas').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});

$(document).on('change', '#residenciales, #condominios, #idEstatus', function () {
    ix_idResidencial = ($("#residenciales").val().length <= 0) ? 0 : $("#residenciales").val();
    ix_idCondominio = $("#condominios").val() == '' ? 0 : $("#condominios").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? 0 : $("#idEstatus").val();
    tabla_inventario = $("#tablaInventarioComisionistas").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6 p-0'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>" + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contraloria/getInvientarioComisionista/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [{
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
                    `<center><span class="label lbl-yellow">${d.descripcion_estatus}</span> <center>` :
                    `<center><span class="label label lbl-yellow">${d.descripcion_estatus}</span> <p><p> <span class="label lbl-green">${d.tipo_venta}</span> <center>`;
            }
        },
        {
            data: function (d) {
                if (d.fechaApartado == '' || d.fechaApartado == null || d.fechaApartado == 'null')
                    return 'SIN ESPECIFICAR';
                else
                    return d.fechaApartado;
            }
        }],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});