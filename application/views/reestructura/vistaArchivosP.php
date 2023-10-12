<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php  $this->load->view('template/sidebar'); ?>
    <div class="modal fade" id="archivosReestructura" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <div class="modal-body text-center">
                    <h5>Selecciona los archivos para asociarlos al lote </h5>
                    <b><h5 id="mainLabelText" class="bold"></h5></b><hr>
                    <div id="formularioArchivos"></div>
                </div>
                <div class="modal-footer mt-2">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">SUBIDA DE ARCHIVOS</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="material-datatables">
                                <table id="tablaLotesArchivosReestructura" class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>CLIENTE</th>
                                        <th>ID LOTE</th>
                                        <th>NOMBRE LOTE</th>
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
<!--<script src="--><?//=base_url()?><!--dist/js/core/modal-general.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
<script src="<?=base_url()?>dist/js/controllers/reestructura/subirArchivosReestructura.js"></script>