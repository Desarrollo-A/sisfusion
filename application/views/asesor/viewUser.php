<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar', "");  ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Consulta contraseña</h3>
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="all_password_datatable" class="table-striped table-hover"
                                               style="text-align:center;"><!--table table-bordered table-hover -->
                                            <thead>
                                                <tr>
                                                    <th class="disabled-sorting">USUARIO</th>
                                                    <th class="disabled-sorting text-right">CONTRASEÑA</th>
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

            <?php $this->load->view('template/footer_legend'); ?>

        </div>
    </div>
</div>
</body>

<?php $this->load->view('template/footer'); ?>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/js/controllers/datatables/datatables.min.css"/>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/datatables/datatables.min.js"></script>-->

<script>
    $(document).ready( function() {
    $('#all_password_datatable thead tr:eq(0) th').each(function (i) {
        if (i != 8) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#all_password_datatable').DataTable().column(i).search() !== this.value) {
                    $('#all_password_datatable').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    $allUsersTable = $('#all_password_datatable').DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Consulta Contraseña',
                title:'Consulta Contraseña',
                exportOptions: {
                    columns: [0,1],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'USUARIO';
                                    break;

                                case 1:
                                    return 'CONTRASEÑA';
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        ordering: false,
        paging: true,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "./..//static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [
            { data: function (d) {
                    return d.usuario
                }
            },
            { data: function (d) {
                    return d.contrasena
                }
            }
        ],
        "ajax": {
            "url": "getUsersListAsesor",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        }
    });
});
</script>
<!--<script src="<?= base_url() ?>dist/js/controllers/usuarios-1.1.0.js"></script>-->


</html>

