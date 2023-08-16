<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align " id="showDate"> </h3>
                                <div class="toolbar">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="Jtabla" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>SEDE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>USUARIO</th>
                                                    <th>ASESOR(ES)</th>
                                                    <th>GERENTE</th>
                                                    <th>PROCESO CONTRATACIÓN</th>
                                                    <th>COMENTARIO</th>
                                                    <th>FECHA DE CONTRATADO</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>PRECIO DE FIANZA</th>
                                                    <th>REUBICACIÓN</th>
                                                    <th>FECHA DE REUBICACIÓN</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/contratacion/datos_lotesContratados.js"></script>