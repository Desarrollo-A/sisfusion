<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<a href="https://youtu.be/KhRGywKMQvs" target="_blank">
                                <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                            </a>
						</div>
						<div class="card-content">
							<h4 class="card-title">Manuales</h4><br><br>
							<div class="row">
								<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div id="msg"></div>
									<div class="nav-center">
										<ul class="nav nav-tabs" role="tablist" id="navbartabs"></ul>
									</div>
									<div class="tab-content" id="paneles-tabs">
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/asesores/manuales.js"></script>
