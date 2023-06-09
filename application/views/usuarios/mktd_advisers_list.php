<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Asesores MKTD</h3>
                            <div class="toolbar">
                                <div class="row"></div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="users_datatable" class="table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>ESTATUS</th>
                                                <th>ID</th>
                                                <th>NOMBRE</th>
                                                <th>TELÉFONO</th>
                                                <th>PUESTO</th>
                                                <th>JEFE DIRECTO</th>
                                                <th>TIPO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>

<script>
    $('#users_datatable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#users_datatable').DataTable().column(i).search() !== this.value) {
                $('#users_datatable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });
</script>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready( function() {
        $(".select-is-empty").removeClass("is-empty");

        $usersTable = $('#users_datatable').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
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
                title:'Listado de asesores y coordinadores',
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
                                    return 'NOMBRE';
                                case 3:
                                    return 'TELÉFONO';
                                    break;
                                case 4:
                                    return 'PUESTO';
                                    break;
                                case 5:
                                    return 'JEFE DIRECTO';
                                    break;
                                case 6:
                                    return 'TIPO';
                                    break;
                                case 7:
                                    return 'ACCIONES';
                                    break;
                            }
                        }
                    }
                }
            }],
            language: {
                url: "../../static/spanishLoader_v2.json",
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
                            return '<center><span class="label label-danger" style="background:#566573">SIN ESPECIFICAR</span><center>';
                        } else { // MJ: ES MKTD
                            return '<center><span class="label label-danger" style="background:#2ECC71">ASESOR MKTD</span><center>';
                        }
                    }
                },
                { data: function (d) {
                    if (d.ismktd == 0) { // MJ: NO ES MKTD
                            return '<center><button class="btn-data btn-green change-user-type" data-action="1" value="' + d.id_usuario +'"><i class="fas fa-user-plus"></i></button></center>'; // MJ: ADD
                        } else { // MJ: ES MKTD
                            return '<center><button class="btn-data btn-orangeYellow change-user-type" data-action="2" value="' + d.id_usuario +'"><i class="fas fa-user-times"></i></button></center>'; // MJ: REMOVE
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
</script>
</body>