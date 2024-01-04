<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/common_modals_vtas/modals_vtas.css" rel="stylesheet"/>
<body>
    
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">list</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de ventas</h3>
                                <div class="col-md-12">
                                    <div class="boxAccordionsVtas">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');
       
        ?>
    </div>
    </div><!-- main-panel close -->


</body>

<!-- Modals -->
<div class="modal fade" id="seeInfoModalRepoVtas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Lotes Vendidos por Asesor</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
                <div class="row">
                    <div class="col-md-12">
                        <table id = "lotesInfoTableVtas" name = "lotesInfoTableVtas" class="table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Condominio</th>
                                    <th>Lote</th>
                                    <th>ID Lote</th>
                                    <th>Total de Lote</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
			</div>
	    </div>
	</div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>dist/js/controllers/ventas/repoVtasDetalle.js"></script>

