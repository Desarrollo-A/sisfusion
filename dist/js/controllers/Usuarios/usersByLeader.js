$(document).ready( function() {
    construirHead("users_datatable");
    tableUsers();

})

let titulos = [];
// asignarValorColumnasDT("users_datatable");

// $('#users_datatable thead tr:eq(0) th').each(function (i) {
//     var title = $(this).text();
//     if (!excluir_column.includes(title)) {
//         columnas_datatable.users_datatable.titulos_encabezados.push(title);
//         columnas_datatable.users_datatable.num_encabezados.push(columnas_datatable.users_datatable.titulos_encabezados.length - 1);
//     }
//     let readOnly = excluir_column.includes(title) ? 'readOnly' : '';
//     if (title !== '') {
//         $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}" ${readOnly}/>`);
//         $('input', this).on('keyup change', function () {
//             if ($('#users_datatable').DataTable().column(i).search() !== this.value) {
//                 $('#users_datatable').DataTable().column(i).search(this.value).draw();
//             }
//         });
//     }
// })


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
                titleAttr: _('descargar-excel'),
                filename: _('plantilla-activa'),
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return $(d).attr('placeholder').toUpperCase();
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
    applySearch(usersTable);
}

$('#users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});