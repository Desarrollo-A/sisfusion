<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Lotes cancelados</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate" />
                                                            <input type="text" class="form-control datepicker" id="endDate" />
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="filtrarPorFecha">
                                                                <span class="material-icons update-dataTable"> search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="cancelacionesTabla" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>FECHA DE APARTADO</th>
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
<script src="<?=base_url()?>dist/js/funciones-generales.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/cancelaciones_proceso.js"></script>
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
