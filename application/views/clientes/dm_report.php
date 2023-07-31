<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="seeCommentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanComments()">clear</i>
                        </button>
                        <h4 class="modal-title">Bitácora de cambios</h4>
                    </div>
                    <div class="modal-body">
                        <div class="conteiner-fluid">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-styles" style="height: 350px; overflow: auto">
                                    <ul class="timeline-3" id="changelog"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/u65XqWYjuK8" class="align-center justify-center" target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de estatus por prospecto</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <table id="mktdProspectsTable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ESTADO</th>
                                                    <th>ETAPA</th>
                                                    <th>PROSPECTO</th>
                                                    <th>MEDIO</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>CREACIÓN</th>
                                                    <th>VENCIMIENTO</th>
                                                    <th>ÚLTIMA MODIFICACIÓN</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/mktd-1.1.0.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/js/controllers/clientes/dm_report.js"></script>
</html>