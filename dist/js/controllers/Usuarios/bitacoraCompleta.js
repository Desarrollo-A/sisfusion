$(document).ready(function() {
    let titulos = [];
    $('[data-toggle="tooltip"').tooltip();
    $('#users_datatable thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function (){
                    if (usersTable.column(i).search() !== this.value ) {
                        usersTable
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            });
     usersTable = $('#users_datatable').DataTable({
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
                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
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
            { data: function (d) {
                if (d.idEstatus == 1) {
                    return '<center><span class="label lbl-green" data-i18n="activo">ACTIVO</span><center>';
                } else if (d.idEstatus == 3) {
                    return '<center><span class="label lbl-orangeYellow" data-i18n="inactivo-comisionado">INACTIVO COMISIONADO</span><center>';
                } else {
                    return '<center><span class="label lbl-warning" data-i18n="inactivo">INACTIVO</span><center>';
                }
            }},
            { data: 'ID' },
            { data: 'nombreUsuario' },
            { data: 'usApellidos' },
            { data: 'correo' },
            { data: 'telefono' },
            { data: 'puesto' },
            { data: 'tipoUsuario' },
            { data: 'sedeNombre' },
            { data: 'coordinador' },
            { data: 'gerente' },
            { data: 'subdirector' },
            { data: 'jefeDirecto' },
            { data: 'fechaUsuario' },
            { data: 'fechaActivacion' },
            { data: 'cambiosRealizados' },
            {
                data: function(d) {
                    let factorEstatus = '';
                    if(d.fac_humano == 1) {
                        console.log("here: ", d.ID);
                        factorEstatus = '<center><span class="label lbl-violetBoots">SI</span><center>'
                    } 
                    else if(d.fac_humano == 0) {
                        factorEstatus = '<center><span class="label lbl-warning" >NO</span><center>'
                    } 
                    else {
                        factorEstatus = '<center><span class="label lbl-orangeYellow" >SIN ESPECIFICAR</span><center>'
                    }
                    return factorEstatus;
                }
            },
        ],
        ajax: {
            url: `${general_base_url}/Usuarios/getBitacoraUsuarios`,
            type: "POST",
            cache: false,
            dataSrc: ''
        }
    });
});