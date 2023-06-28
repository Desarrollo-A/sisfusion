$(document).ready( function() {
    tableUsers();
})

let titulos = [];
$('#users_datatable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#users_datatable').DataTable().column(i).search() !== this.value) {
            $('#users_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

function tableUsers(){
    usersTable = $('#users_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                filename: 'Plantilla activa',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: function (d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-green">ACTIVO</span><center>';
                } else if (d.estatus == 3) {
                    return '<center><span class="label lbl-orangeYellow">INACTIVO COMISIONADO</span><center>';
                } else {
                    return '<center><span class="label lbl-warning">INACTIVO</span><center>';
                }
            }
            },
            { data: function (d) {
                    return d.id_usuario;
                }
            },
            { data: function (d) {
                    return d.nombre;
                }
            },
            { data: function (d) {
                return d.correo;
                }
             },
            { data: function (d) {
                    return d.telefono;
                }
            },
            { data: function (d) {
                    return d.puesto;
                }
            },
            { data: function (d) {
                    return d.jefe_directo;
                }
            },
            { data: function (d) {
                    return d.sede;
                }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "defaultContent": "-",
            "targets": "_all"
        },

        ],
        ajax: {
            url: 'getUsersListByLeader',
            type: "POST",
            cache: false,
            data: {
            }
        }
    });   
}

$('#users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});