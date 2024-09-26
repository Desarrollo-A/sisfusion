<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<body>
	<div class="wrapper">

		<?php $this->load->view('template/sidebar'); ?>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<a href="https://youtu.be/Am1fwW-vqoE" target="_blank">
									<i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
								</a>
							</div>
							<div class="card-content">
								<h4 class="card-title" data-i18n="files">Carpetas</h4><br><br>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div id="msg"></div>
										<div class="toolbar">
											<div role="tablist" id="navbartabs">
												<select id="test" class="selectpicker select-gral" data-container="body" data-style="btn-new" title="CARPETASs" data-size="9">
												</select>
											</div>
										</div>
										<div class="tab-content" id="paneles-tabs"></div>
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
	</div>
	<?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/asesores/carpetas.js"></script>
</body>