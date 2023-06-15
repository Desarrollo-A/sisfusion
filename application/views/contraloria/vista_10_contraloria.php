
<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>
	<!--Contenido de la página-->

	<style type="text/css">
		::-webkit-input-placeholder { /* Chrome/Opera/Safari */
			color: white;
			opacity: 0.4;
			::-moz-placeholder { /* Firefox 19+ */
				color: white;
				opacity: 0.4;
			}
			:-ms-input-placeholder { /* IE 10+ */
				color: white;
				opacity: 0.4;
			}
			:-moz-placeholder { /* Firefox 18- */
				color: white;
				opacity: 0.4;
			}
		}
	</style>

	<!-- modal para registrar corrida elaborada-->
	<div class="modal fade" id="regStats10" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Registro Status (10. Solicitud de validación de enganche y envio de contrato a RL)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeregSt10" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionregSt10"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="10">  10. Solicitud de validación de enganche y envio de contrato a RL (Contraloría) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioregSt10">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteregSt10" >
						<input type="hidden" name="idCliente" id="idClienteregSt10" >
						<input type="hidden" name="idCondominio" id="idCondominioregSt10" >
						<input type="hidden" name="fechaVenc" id="fechaVencregSt10" >
						<input type="hidden" name="nombreLote" id="nombreLoteregSt10"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="RegSt10Enviar" onClick="preguntaRegSt10()" class="btn btn-primary"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal para enviar a revision 10-->
	<div class="modal fade" id="envRev10" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Registro Revisión Status (10. Solicitud de validación de enganche y envio de contrato a RL)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeenvRev10" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionenvRev10"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7" required>
								<option value="10">  10. Solicitud de validación de enganche y envio de contrato a RL (Contraloría) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioenvRev10">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteregenvRev10" >
						<input type="hidden" name="idCliente" id="idClienteregenvRev10" >
						<input type="hidden" name="idCondominio" id="idCondominioregenvRev10" >
						<input type="hidden" name="fechaVenc" id="fechaVencregenvRev10" >
						<input type="hidden" name="nombreLote" id="nombreLoteregenvRev10"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="envRev10Enviar" onClick="preguntaenvRev10()" class="btn btn-primary"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal para mostrar avisos que se cargan por medio del evento donde clickee el ussuaior -->
	<div class="modal fade" id="showMessageStats" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">INFORMACIÓN</h4>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Aceptar</button>
				</div>
			</div>
		</div>
	</div>


	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Registro estatus 10 (envío de contratos a RL)</h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables"> 

								<div class="form-group">


                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive">
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_corrida" name="tabla_ingresar_corrida"> 
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
												<th style="font-size: .9em;">ACCIÓN</th>
                                               <!--  <th style="font-size: .9em;">DETALLES</th>
                                                <th style="font-size: .9em;">COMENTARIO</th>
                                                <th style="font-size: .9em;">TOTAL NETO</th>
                                                <th style="font-size: .9em;">TOTAL VALIDADO</th> -->
                                                <!-- <th style="font-size: .9em;"></th> -->
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
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>
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
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_10_contraloria.js"></script>

