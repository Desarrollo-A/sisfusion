<link href="<?= base_url() ?>dist/css/notFound.css" rel="stylesheet"/>
<body class="m-0">
	<div class="wrapper">
		<div class="container vh-100 w-100 p-0">
			<div class="boxContent h-100 d-flex justify-center align-center">
				<div class="center text-center">
					<div class="box-img d-flex justify-center">
						<img class="w-100" src="<?= base_url() ?>static/images/logo.svg">
					</div>
					<div class="title d-flex justify-center">
						<h2>ERROR</h2>
						<h2 class="enfasis">&nbsp;404</h2>
					</div>
					<h3 class="m-0">No encontramos la página a la que quieres acceder</h3>
					<br>
					<br>
					<br>
					<a href="<?=base_url()?>" class="enfasis"> <i class="fa fa-chevron-left"></i> Regresar </a>
				</div>
			</div>
		</div>
	</div>
	</div><!--main-panel close-->
	
	<?php $this->load->view('template/footer');?>
	</script>
</body>