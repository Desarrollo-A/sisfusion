<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="<?= base_url() ?>dist/js/controllers/usuarios/mktdAdvisersList.js"></script>



</body>