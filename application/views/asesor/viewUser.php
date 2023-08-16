<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar');  ?>
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
                                <div class="material-datatables">
                                    <table id="all_password_datatable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="disabled-sorting">USUARIO</th>
                                                <th class="disabled-sorting">CONTRASEÑA</th>
                                            </tr>
                                        </thead>
                                    </table>
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
<script src="<?=base_url()?>dist/js/controllers/asesores/viewUser.js"></script>
</html>