<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
	<div class="wrapper ">
		<?php
		if (in_array($this->session->userdata('id_rol'), array(19,28,50,58,54))){
			$this->load->view('template/sidebar');
		}
		else{
			echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
		}
		?>

		<div class="modal fade" id="verAutorizacionesAsesor" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h3 class="modal-title text-center">Autorizaciones <span class="material-icons">vpn_key</span></h3>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div id="auts-loads"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Aceptar </button>
					</div>
				</div>
			</div>
		</div>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="row">
									<div class="toolbar">
										<h3 class="card-title center-align">Documentación por lote</h3>
										<div class="col-md-5">
											<div class="form-group">
												<label class="control-label label-gral">ID lote</label>
												<input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
											</div>
										</div>
										<div class="col-md-3 mt-3">
											<div class="form-group">
												<button type="submit" class="btn-gral-data find_doc">Buscar</button>
											</div>
										</div>
									</div>
								</div>
								<table id="tableDoct" class="table-striped table-hover hide">
									<thead>
										<tr>
											<th>PROYECTO</th>
											<th>CONDOMINIO</th>
											<th>LOTE</th>
											<th>ID LOTE</th>
											<th>CLIENTE</th>
											<th>NOMBRE DE DOCUMENTO</th>
											<th>HORA/FECHA</th>
											<th>DOCUMENTO</th>
											<th>RESPONSABLE</th>
											<th>UBICACIÓN</th>
										</tr>
									</thead>
								</table>
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
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script type="text/javascript">Shadowbox.init();</script>
	<script src="<?= base_url() ?>dist/js/controllers/contratacion/documentsByLote.js"></script>
</body>