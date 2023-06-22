$(document).ready (function() {     
    let funcionToGetData = '';
    funcionToGetData = ( id_rol_general == 1 ) ? `${general_base_url}Clientes/getAuthorizationsByDirector` : `${general_base_url}Clientes/getAuthorizationsBySubdirector`

    $('#authorizationsTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Lista de autorizaciones',
                title:"Lista de autorizaciones",
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' '+titulos[columnIdx] +' ';
                        }
                    }
                },
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Lista de autorizaciones',
                title: "Lista de autorizaciones",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7],
                    format: {
                        header:  function ( d, columnIdx) {
                            return ' '+titulos[columnIdx] +' ';
                        }
                    }
                },
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
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
        columns: [
            {
                data: function (d) {
                    if (d.estatus == 0) {
                        return '<span class="label lbl-green">Autorizada</span>';
                    } else if (d.estatus == 1){
                        return '<span class="label lbl-grayDark">Pendiente</span>';
                    } else if (d.estatus == 2){
                        return '<span class="label lbl-warning">Rechazada</span>';
                    } else {
                        return '<span class="label lbl-azure">En DC</span>';
                    }
                }
            },
            { data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            { data: 'nombreLote'},
            {
                data: function( d ){
                    var as1 = (d.asesor == null ? "" : d.asesor + '<br>');
                    return as1 ;
                }
            },
            {
                data: function( d ){
                    var cliente = (d.cliente == null ? "" : d.cliente);
                    return cliente;
                }
            },
            {
                data: function( d ){
                    var cliente = (d.cliente == null ? "" : d.autorizacion);
                    return cliente;
                }
            },
            {data: 'comentario'}
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: funcionToGetData,
            type: "POST",
            cache: false,
        }
    });
});

let titulos = [];
$('#authorizationsTable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#authorizationsTable').DataTable().column(i).search() !== this.value)
            $('#authorizationsTable').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover" });
});



