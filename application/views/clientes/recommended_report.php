<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <!-- Modals -->
        <div class="modal fade" id="seeCommentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanComments()">clear</i>
                        </button>
                        <h4 class="modal-title">Consulta información</h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active"><a href="#commentsTab" aria-controls="commentsTab" role="tab" data-toggle="tab">Comentarios</a></li>
                                <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="commentsTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="changelog"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Prospectos recomendados</h3>
                                <div class="material-datatables">
                                    <table id="mktdProspectsTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>GERENTE</th>
                                                <th>RECOMENDADO POR</th>
                                                <th>MEDIO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>
	<script src="<?=base_url()?>dist/js/controllers/clientes/recommendedReport.js"></script>
</body>
</html>
