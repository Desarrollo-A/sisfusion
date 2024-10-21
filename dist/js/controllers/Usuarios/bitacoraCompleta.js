$(document).ready(function() {
    $('[data-toggle="tooltip"').tooltip();
    let usersTable = $('#users_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado de usuarios',
            title: _("lista-usuarios"),
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
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
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            {
                data: function(d){
                return d.estatus;
                }
            },
            {
                data: function(d) {
                    return d.ID;
                }
            },
            {
                data: function(d) {
                    return d.nombreUsuario;
                }
            },
            {
                data: function(d) {
                    return d.usApellidos
                }
            },
            {
                data: function(d) {
                    return d.correo
                }
            },
            {
                data: function(d) {
                    return d.telefono
                }
            },
            {
                data: function(d) {
                    return d.puesto
                }
            },
            {
                data: function(d) {
                    return d.tipoUsuario
                }
            },
            {
                data: function(d) {
                    return d.sedeNombre
                }
            },
            {
                data: function(d) {
                    return d.coordinador
                }
            },
            {
                data: function(d) {
                    return d.gerente
                }
            },
            {
                data: function(d) {
                    return d.subdirector
                }
            },
            {
                data: function(d) {
                    return d.jefeDirecto
                }
            },
            {
                data: function(d) {
                    return d.sedeNombre
                }
            },
            {
                data: function(d) {
                    return d.sedeNombre
                }
            },
        ],
        ajax: {
            url: "getBitacora",
            type: "POST",
            cache: false
        }
    })
})