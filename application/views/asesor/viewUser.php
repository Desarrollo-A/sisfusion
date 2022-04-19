<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div>
    <div class="wrapper">
        <?php
        $this->load->view('template/sidebar', "");
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Consulta Contraseña</h3>
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

<script src="<?= base_url() ?>dist/js/controllers/usuarios-1.1.0.js"></script>


</html>

