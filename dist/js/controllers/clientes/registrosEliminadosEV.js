$(document).ready (function() {
    $('body').tooltip({
        selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
        trigger: 'hover',
        container: 'body'
    }).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
        $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
    });

    let titulos_intxt = [];
    $('#autorizarEvidencias thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
        $( 'input', this ).on('keyup change', function () {
            if ($('#autorizarEvidencias').DataTable().column(i).search() !== this.value ) {
                $('#autorizarEvidencias').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    var table;
    table = $('#autorizarEvidencias').DataTable( {
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Lotes elimidos de la lista de evidenccias',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' '+titulos_intxt[columnIdx] +' ';
                        }
                    }
                }
            },
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        ajax:  general_base_url + "Asesor/getDeletedLotesEV/",
        columns: [
            { "data": "nombreLote" },
            { "data": "idLote" },
            { 
                "data": function( d )
                {
                    return '<p class="m-0"><i> "'+d.observacion+'"</i></p>';
                }
            },
            { "data": "nombreCliente" },
            { "data": "nombreSolicitante" },
            { "data": "fecha_creacion" },
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
    });
});