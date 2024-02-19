<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <!--Contenido de la página-->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de clientes</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover"
                                                id="tabla_clientes" name="tabla_clientes">
                                                <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>FECHA DE NACIMIENTO</th>
                                                    <th>EDAD</th>
                                                    <th>OCUPACIÓN</th>
                                                    <th>ORIGINARIO DE</th>
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
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="<?=base_url()?>dist/js/controllers/clientes/consulta_clientes_proyecto.js"></script>
</body>