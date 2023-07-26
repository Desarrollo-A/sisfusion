$(document).ready(function () {
    fillTable();
});

let titulos_intxt = [];
$('#registros-datatable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#registros-datatable').DataTable().column(i).search() !== this.value) {
            $('#registros-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillTable() {
    chatsTable = $('#registros-datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width:'100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Registro desde Landing Page',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6],
                format: 
                {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx]  + ' ';
                    }
                }
            },
        }],
        width: 'auto',
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function (d) {
                return d.id_registro;
            }
        },
        { 
            data: function (d) {
                return d.nombre_sede;
            }
        },
        { 
            data: function (d) {
                return d.nombre;
            }
        },
        { 
            data: function (d) {
                if (d.correo != '' || d.correo != null){
                    return d.correo;
                }
                else{
                    return '-';
                }
            }
        },
        { 
            data: function (d) {
                return d.telefono;
            }
        },
        { 
            data: function (d) {
                if (d.origen != '' || d.origen != null){
                    return d.origen;
                }
                else{
                    return '-';
                }
            }
        },
        { 
            data: function (d) {
                return d.fecha_creacion;
            }
        }],
        ajax: {
            url: "registrosLP/",
            type: "POST",
            cache: false,
            data: {}
        }
    });
}

$('#registros-datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});
