<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<body class="">
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-list fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Listado general de clientes Maderas Rewards</h3>
                                </div>
                                <table id="tablaClientesArcus" name="tablaClientesArcus" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>REFERENCIA</th>
                                            <th>PRECIO DE LISTA</th>
                                            <th>PRECIO FINAL</th>
                                            <th>NOMBRE DEL CLIENTE</th>
                                            <th>ID CLIENTE</th>
                                            <th>CORREO</th>
                                            <th>TELÉFONO</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECCIÓN</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>DIRECTOR REGIONAL 2</th>
                                            <th>ESTATUS LOTE</th>
                                            <th>ESTATUS CONTRATACIÓN</th>
                                            <th>ID MADERAS REWARDS</th>
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
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/marketing/listaClientesArcus.js"></script>
</body>