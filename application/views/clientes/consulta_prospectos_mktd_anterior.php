<body>
<div class="wrapper">

	<?php $this->load->view('template/sidebar'); ?>

	<style>
		.label-inf {
			color: #333;
		}
		/*.modal-body-scroll{
			height: 100px;
			width: 100%;
			overflow-y: auto;
		}*/
		select:invalid {
			border: 2px dashed red;
		}

	</style>

	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block full">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">list</i>
									</div>
									<div class="card-content">
										<div class="row">
											<h4 class="card-title">Listado general de prospectos</h4>
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="prospects-datatable" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
														<thead>
														<tr>
															<th class="disabled-sorting text-right"><center>Estado</center></th>
															<th class="disabled-sorting text-right"><center>Estado</center></th>
															<th class="disabled-sorting text-right"><center>Prospecto</center></th>
															<th class="disabled-sorting text-right"><center>Asesor</center></th>
															<th class="disabled-sorting text-right"><center>Gerente</center></th>
															<th class="disabled-sorting text-right"><center>Subdirector</center></th>
															<th class="disabled-sorting text-right"><center>Creación</center></th>
															<th class="disabled-sorting text-right"><center>Vencimiento</center></th>
															<th class="disabled-sorting text-right"><center>Acciones</center></th>
														</tr>
														</thead>
														<tbody>
														</tbody>

													</table>

													<?php include 'common_modals.php' ?>

												</div>
											</div>
										</div>
									</div>
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
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<script src="--><?//=base_url()?><!--dist/js/jquery.validate.js"></script>-->
<script>
	userType = <?= $this->session->userdata('id_rol') ?>;
	typeTransaction = 0;
</script>
<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>

</html>
