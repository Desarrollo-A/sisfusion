<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" data-i18n="tus-autorizaciones">Tus autorizaciones</h3>
                                </div>
                                <div class="material-datatables">
                                    <table id="authorizationsTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>estatus</th>
                                                <th>proyecto</th>
                                                <th>condominio</th>
                                                <th>lote</th>
                                                <th>asesor</th>
                                                <th>cliente</th>
                                                <th>solicitud</th>
                                                <th>comentario</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/clientes/authorizationsReport.js"></script>