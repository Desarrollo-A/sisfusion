<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
	<div class="wrapper ">
		<?php
		//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
		switch ($this->session->userdata('id_rol')) {
			case '2': // SUB VENTAS
			case '3': // GERENTE VENTAS
			case '4': // ASISTENTE DIRECCIÓN COMERCIAL
			case '5': // ASISTENTE SUBDIRECCIÓN COMERCIAL
			case '6': // ASISTENTE GERENCIA COMERCIAL
			case '7': // ASESOR
			case '9': // COORDINADOR
			case '11': // ADMINISTRACIÓN
			case '12': // CAJA
			case '13': // CONTRALORÍA
			case '15': // JURÍDICO
			case '16': // CONTRATACIÓN
			case '28': // EJECUTIVO ADMINISTRATIVO MKTD
			case '32': // CONTRALORÍA CORPORATIVA
			case '33': // CONSULTA
			case '34': // FACTURACIÓN
			case '39': // CONTABILIDAD
			case '50': // GENERALISTA MKTD
			case '40': // COBRANZA
			case '53': // analista comisisones
            case '55': // POSTVENTA
			case '58': // ANALISTA DE DATOS
			case '65': // CONTABILIDAD (EXTERNO)
            case '74': //  Ejecutivo Postventa(EXTERNO)
            case '75': //  Supervisor Postventa(EXTERNO)
            case '76': //  Asistente subdirección Postventa(EXTERNO)
            case '77': //  Auxiliar Postventa(EXTERNO)
            case '78': //  Base de Datos Postventa(EXTERNO)
            case '79': //  Coordinador de Postventa(EXTERNO)
            case '80': //  Coordinador de Call Center Postventa(EXTERNO)
            case '81': //  Subdirección Postventa(EXTERNO)
            case '82': //  Agente de asignación(EXTERNO)
            case '83': //  Agente de calidad(EXTERNO)
				$datos = array();
				$datos = $datos4;
				$datos = $datos2;
				$datos = $datos3;  
				$this->load->view('template/sidebar', $datos);
				break;
			
			default:
				echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
				break;
		}
		?>
		<!-- Modals -->
		<!-- modal  INSERT FILE-->
		<div class="modal fade" id="addFile" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="expediente" id="expediente" style="display: none;">
								</span>
							</label>
							<input type="text" class="form-control" id="txtexp" readonly>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" id="sendFile" class="btn btn-primary"><span
								class="material-icons" >send</span> Guardar documento </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal INSERT-->

		<!--modal que pregunta cuando se esta borrando un archivo-->
		<div class="modal fade" id="cuestionDelete" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<center><h3 class="modal-title">¡Eliminar archivo!</h3></center>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row centered center-align">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
									<h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></h1>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
									<h4 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h4>
									<h5 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h5>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<br><br>
						<button type="button" id="aceptoDelete" class="btn btn-primary"> Sí, borrar </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
					</div>
				</div>
			</div>
		</div>
		<!--termina el modal de cuestion-->

		<!-- autorizaciones-->
		<div class="modal fade" id="verAutorizacionesAsesor" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<center><h3 class="modal-title">Autorizaciones <span class="material-icons">vpn_key</span></h3></center>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div id="auts-loads">
									</div>
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
		<!-- autorizaciones end-->
		<!-- END Modals -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="toolbar">
									<h3 class="card-title center-align">Documentación por lote</h3>
									<div class="row">
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating select-is-empty">
												<label class="control-label">Proyecto</label>
												<select name="filtro3" id="filtro3"
														class="selectpicker select-gral m-0"
														data-style="btn" data-show-subtext="true"
														data-live-search="true"
														title="Selecciona un proyecto" data-size="7" required>
													<?php
													if ($residencial != NULL) :
														foreach ($residencial as $fila) : ?>
															<option value=<?= $fila['idResidencial'] ?>> <?= $fila['descripcion'] ?> </option>
														<?php endforeach;
													endif;
													?>
												</select>
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating select-is-empty">
												<label class="control-label">Condominio</label>
												<select id="filtro4" name="filtro4"
														class="selectpicker select-gral m-0"
														data-style="btn" data-show-subtext="true"
														data-live-search="true"
														title="Selecciona un condominio" data-size="7" required>
												</select>
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating select-is-empty">
												<label class="control-label">Lote</label>
												<select id="filtro5" name="filtro5"
														class="selectpicker select-gral m-0"
														data-style="btn" data-show-subtext="true"
														data-live-search="true"
														title="Selecciona un lote" data-size="7" required>
												</select>
											</div>
										</div>
									</div>
									<!--        Here you can write extra buttons/actions for the toolbar              -->
								</div>
								<div class="table-responsive">
									<table id="tableDoct" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>ID LOTE</th>
												<th>LOTE</th>
												<th>CLIENTE</th>
												<th>COORDINADOR</th>
												<th>GERENTE</th>
												<th>SUBDIRECTOR</th>
												<th>REGIONAL</th>
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
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div><!--main-panel close-->

	<?php $this->load->view('template/footer');?>
	<!--DATATABLE BUTTONS DATA EXPORT-->
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_cliente_documentos_contratacion.js"></script>
</body>