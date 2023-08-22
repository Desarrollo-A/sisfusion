let titulos_intxt = [];
$(document).ready( function() {
    $('#all_password_datatable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#all_password_datatable').DataTable().column(i).search() !== this.value) {
                $('#all_password_datatable').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $allUsersTable = $('#all_password_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Consulta Contraseña',
            title:'Consulta Contraseña',
            exportOptions: {
                columns: [0,1],
                format:{
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
        ordering: false,
        paging: true,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [{ 
            data: function (d) {
                return d.usuario
            }
        },
        { data: function (d) {
                return d.contrasena
            }
        }],
        "ajax": {
            "url": "getUsersListAsesor",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });

    $('#all_password_datatable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
});