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
                                <h3 class="card-title center-align">Asesores y coordinadores</h3>
                                <div class="toolbar">
                                    <div class="row"></div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="users_datatable" class="table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>ESTATUS</th>
                                                <th>ID</th>
                                                <th>NOMBRE</th>
                                                <th>TELÉFONO</th>
                                                <th>PUESTO</th>
                                                <th>JEFE DIRECTO 1</th>
                                                <th>JEFE DIRECTO 2</th>
                                                <th>SEDE</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    
    <script>
        $('#users_datatable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#users_datatable').DataTable().column(i).search() !== this.value ) {
                    $('#users_datatable').DataTable().column(i).search(this.value).draw();
                }
            } );
        });
    </script>
    <script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
</body>