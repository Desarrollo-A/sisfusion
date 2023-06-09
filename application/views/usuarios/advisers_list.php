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
                                        <div class="table-responsive">
                                            <table id="users_datatable" class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ESTATUS</th>
                                                    <th>ID</th>
                                                    <th>NOMBRE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>PUESTO</th>
                                                    <th>JEFE DIRECTO 1</th>
                                                    <th>JEFE DIRECTO  2</th>
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
        </div>


        <div class="content hide">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Asesores y coordinadores</h4>
                                                <div class="table-responsive">
                                                    <table id="users_datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
                                                        <thead>
                                                        <tr>
                                                            <th class="disabled-sorting text-right"><center>Estatus</center></th>
                                                            <th class="disabled-sorting text-right"><center>ID</center></th>
                                                            <th class="disabled-sorting text-right"><center>Nombre</center></th>
                                                            <th class="disabled-sorting text-right"><center>Teléfono</center></th>
                                                            <th class="disabled-sorting text-right"><center>Puesto</center></th>
                                                            <th class="disabled-sorting text-right"><center>Jefe directo 1</center></th>
                                                            <th class="disabled-sorting text-right"><center>Jefe directo 2</center></th>
                                                            <th class="disabled-sorting text-right"><center>Sede</center></th>
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
                    $('#users_datatable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
                }
            } );
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
    <script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
</body>