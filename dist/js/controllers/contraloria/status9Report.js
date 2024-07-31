$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(1, finalBeginDate, finalEndDate, 0);
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

let titulos = [];
$('#estatusNueveTable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#estatusNueveTable').DataTable().column(i).search() !== this.value ) {
            $('#estatusNueveTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})

function fillTable(typeTransaction, beginDate, endDate) {
    generalDataTable = $('#estatusNueveTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'REPORTE ESTATUS 9',
                title: 'Reporte estatus 9',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        scrollX: true,
        columns: [
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'referencia' },
            { data: 'nombreCliente' },
            { data: 'nombreGerente' },
            { data: 'enganche' },
            { data: 'total' },
            { data: 'modificado' },
            { data: 'nombreUsuario' },
            { data: 'comentario' },
            { data: 'fechaApartado' },
            {
                data: function (d) {
                    if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                        return `<span class="label lbl-green">REUBICADO</span>`;
                    else
                        return `<span class="label lbl-gray">NO APLICA</span>`;
                }
            },
            {
                data: function (d) {
                    if (d.id_cliente_reubicacion != 0 && d.id_cliente_reubicacion != null)
                        return d.fechaAlta;
                    else
                        return '<span class="label lbl-gray">NO APLICA</span>';
                }
            },
            { data: 'nombreSedeRecepcion' },
            {
                data: function (n) {
                    if (n.tipoEnganche == 0 || n.tipoEnganche == null) {
                        return `SIN ESPECIFICAR`;  
                    }
                    return `<center>${n.nombre}<center>`;
                }
            },
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getInformation',
            type: "POST",
            cache: false,
            data: {
                "typeTransaction": typeTransaction,
                "beginDate": beginDate,
                "endDate": endDate
            }
        }
    });

}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(2, finalBeginDate, finalEndDate);
    $('#estatusNueveTable').removeClass('hide');
});
