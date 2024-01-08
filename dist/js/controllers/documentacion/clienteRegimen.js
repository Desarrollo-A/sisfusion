let titulos_intxt = [];
$('#tableClienteRegimen thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tableClienteRegimen').DataTable().column(i).search() !== this.value ) {
                $('#tableClienteRegimen').DataTable().column(i).search(this.value).draw();
            }
    });
});

$(document).ready(function () {
    $("#spiner-loader").removeClass('hide');
    $('#tableClienteRegimen').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        bAutoWidth: true,
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'CLIENTES CON FACTURA',
            exportOptions: {
                columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx]  + ' ';
                        }
                    }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function (d) {
                return `<span class="label lbl-green">${d.tipo_venta}</span>`;
            }
        },
        {
            data: function (d) {
                return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
            }
        },
        { data: 'nombreResidencial' },
        { data: 'nombreCondominio' },
        { data: 'nombreLote' },
        { data: 'gerente' },
        { data: 'nombreCliente' },
        { data: 'rfc' },
        { data: 'cp_fac' },
        { data: 'nombre' },
        {
            data: function (d) {
                return formatMoney(d.totalNeto);
            }
        },
        { data: 'modificado' },
        {
            data: function (d) {
                return `<span class="label lbl-azure">${d.nombreSede}</span>`;
            }
        }],
        columnDefs: [{
            visible: false
        }],
        ajax: {
            url: 'getClienteRegimen',
            type: "POST",
            cache: false,
            dataSrc:""
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        }
    });
});