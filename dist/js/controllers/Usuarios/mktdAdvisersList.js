    $(document).ready( function() {
        $(".select-is-empty").removeClass("is-empty");
        $usersTable = $('#users_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado de asesores y coordinadores',
                title:'Listado de asesores MKTD',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosEvidence[columnIdx] + ' ';
                        }
                    }
                }
            }],
            language: {
                url: "../static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columnDefs: [{
                defaultContent: "Sin especificar",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            destroy: true,
            ordering: false,
            columns: [
                { data: function (d) {
                        if (d.estatus == 1) {
                            return '<center><span class="label lbl-green" >Activo</span><center>';
                        } else if (d.estatus == 3) {
                            return '<center><span class="label lbl-orangeYellow">Inactivo comisionando</span><center>';
                        } else {
                            return '<center><span class="label lbl-warning">Inactivo</span><center>';
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
                        if (d.ismktd == 0) { // MJ: NO ES MKTD
                            return '<center><span class="label lbl-gray">SIN ESPECIFICAR</span><center>';
                        } else { // MJ: ES MKTD
                            return '<center><span class="label lbl-oceanGreen">ASESOR MKTD</span><center>';
                        }
                    }
                },
                { data: function (d) {
                    if (d.ismktd == 0) { // MJ: NO ES MKTD
                            return '<center><button  data-toggle="tooltip"  data-placement="top" title="ASESOR MKDT" class="btn-data btn-green change-user-type" data-action="1" value="' + d.id_usuario +'"><i class="fas fa-user-plus"></i></button></center>'; // MJ: ADD
                        } else { // MJ: ES MKTD
                            return '<center><button  data-toggle="tooltip"  data-placement="top" title="REMOVER" class="btn-data btn-orangeYellow change-user-type" data-action="2" value="' + d.id_usuario +'"><i class="fas fa-user-times"></i></button></center>'; // MJ: REMOVE
                        }
                    }
                }
            ],
            "ajax": {
                "url": "getMktdAvisersList",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });
    });

    let titulosEvidence = [];
    $('#users_datatable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosEvidence.push(title);    
        $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function () {
            if ($('#users_datatable').DataTable().column(i).search() !== this.value) {
                $('#users_datatable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    $(document).on('click', '.change-user-type', function() {
        let action = $(this).attr("data-action");
        $.ajax({
            type: 'POST',
            url: 'changeUserType',
            data: {'id_usuario': $(this).val(), 'value_to_modify': action == 1 ? 1 : 0},
            dataType: 'json',
            success: function(data){
                if( data == 1 ){
                    alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                    $usersTable.ajax.reload();
                }else{
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                }
            },error: function( ){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $('#users_datatable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });