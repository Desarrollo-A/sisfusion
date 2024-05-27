<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <?php include 'historialMovimientos.php' ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte de reubicaciones</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="tablaReporteReubicaciones" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO ORIGEN</th>
                                                <th>CONDOMINIO ORIGEN</th>
                                                <th>LOTE ORIGEN</th>
                                                <th>ID LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>TOTAL NETO</th>
                                                <th>PRECION M2</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>ESTATUS PROCESO</th> <!-- -->
                                                <th>ESTATUS PROPUESTA</th>
                                                <th>PROYECTO DESTINO</th>
                                                <th>CONDOMINIO DESTINO</th>
                                                <th>LOTE DESTINO</th>
                                                <th>ID DESTINO</th>
                                                <th>SUPERFICIE</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/reporteReubicaciones.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/historialMovimientos.js"></script>