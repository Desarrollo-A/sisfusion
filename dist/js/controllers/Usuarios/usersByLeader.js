$(document).ready( function() {
    tableUsers();
})
$('#users_datatable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
   
    $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#users_datatable').DataTable().column(i).search() !== this.value) {
            $('#users_datatable').DataTable()
                .column(i)
                .search(this.value)
                .draw();
        }
    });
});

function tableUsers(){
    usersTable = $('#users_datatable').DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'ESTATUS';
                                    break;
                                case 1:
                                    return 'ID';
                                    break;
                                case 2:
                                    return 'NOMBRE'
                                case 3:
                                    return 'CORREO';
                                    break;
                                case 4:
                                    return 'TELÉFONO';
                                    break;
                                case 5:
                                    return 'TIPO';
                                    break;
                                case 6:
                                    return 'JEFE DIRECTO';
                                    break;
                                case 7:
                                    return 'SEDE';
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader.json",
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
                    return '<center><span class="label label-danger" style="background:#27AE60">Activo</span><center>';
                } else if (d.estatus == 3) {
                    return '<center><span class="label label-danger" style="background:#FF7C00">Inactivo comisionando</span><center>';
                } else {
                    return '<center><span class="label label-danger" style="background:#E74C3C">Inactivo</span><center>';
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
            "targets": 0
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