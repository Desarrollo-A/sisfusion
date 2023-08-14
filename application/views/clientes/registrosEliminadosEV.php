<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Lotes eliminados en la lista de evidencias</h3>
                                <table id="autorizarEvidencias" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>COMENTARIO</th>
                                            <th>CLIENTE</th>
                                            <th>USUARIO</th>
                                            <th>FECHA DE CREACIÓN</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/controllers/clientes/registrosEliminadosEV.js"></script>
</body>