<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>

	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center><h3>Administración de Asesores</h3>
					<div id="showDate"></div>
					<hr>
					</center>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<a href="#" data-toggle="modal" data-target="#add-user" class="btn btn-primary add-user">Agregar usuario <span class="material-icons">person_add</span></a><br><br>
									<div class="table-responsive">
										<table id="Jtabla" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th>
													<center>Asesor</center>
												</th>
												<th>
													<center>Líder</center>
												</th>
												<th>
													<center>Correo</center>
												</th>
												<th>
													<center>Teléfono</center>
												</th>
												<th>
													<center>RFC</center>
												</th>
												<th>
													<center>Usuario</center>
												</th>
												<th>
													<center>Acción</center>
												</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!--modal para añadir usuario-->
			<div class="modal fade" id="add-user" >
				<div class="modal-dialog modal-lg" style="width: 45%">
					<div class="modal-content" >
						<form method="POST"  name="adduser" id="addUser">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 2%;top: 4%;;color: #333">
									<span class="material-icons">close</span>
									<span class="sr-only">Cerrar</span>
								</button>
								<h3 class="modal-title">Agregar usuario</h3>
							</div>
							<div class="modal-body">
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<select required="required" name="tipoUser" id="tipoUser" class="selectpicker" data-style="btn btn-primary" title="TIPO USUARIO" data-size="7">
											<option value="0" disabled>SELECCIONA</option>
											<option value="7">Asesor</option>
											<option value="9">Coordinador</option>
										</select>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<select required="required" name="sede" id="sede" class="selectpicker"
												data-style="btn btn-primary" title="SEDE" data-size="7">
											<option value="2">QRO</option>
											<option value="5">LEÓN</option>
											<option value="1">SLP</option>
											<option value="4">CDMX</option>
											<option value="3">MÉRIDA</option>
											<option value="6">CANCÚN</option>
											<option value="7">US</option>
										</select>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6" >
									<!--<div class="container-fluid" id="txtGerente">
										<div class="form-group label-floating">
											<label class="control-label">
												Gerente
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="gerenteAsesor" id="gerenteAsesor" disabled/>
											<input type="hidden" name="gerenteAsesorID" id="gerenteAsesorID">
										</div>
									</div>-->
									<div class="container-fluid"  id="selectGerenteList">
										<select required="required" name="idGerente" id="idGerente" class="selectpicker" data-style="btn btn-primary" title="GERENTE" data-size="7">
										</select>
									</div>
								</div>

								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid" id="coordinadoralv">
										<select name="nameCoordinador" id="nameCoordinador" class="selectpicker" data-style="btn btn-primary" title="SELECCIONA COORDINADOR" data-size="7">
											<option value="0" disabled>SELECCIONA</option>
										</select>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-lg-12">
									<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="form-group label-floating">
											<label class="control-label">
												Primer Nombre
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="pNombre" id="pNombre"
												   onkeyup="javascript:this.value=this.value.toUpperCase();"/>
										</div>
										<div class="form-group label-floating">
											<label class="control-label">
												Apellido Paterno
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="aPaterno"
												   id="aPaterno"
												   onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>

										<div class="form-group label-floating">
											<label class="control-label">
												Usuario
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="user" id="user"
												   onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>
									</div>
									<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="form-group label-floating">
											<label class="control-label">
												Segundo Nombre
											</label>
											<input type="text" class="form-control" name="sNombre" id="sNombre"
												   onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">
												Apellido Materno
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="aMaterno"
												   id="aMaterno" style="text-transform:uppercase;"
												   onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">
												Contraseña
												<small>*</small>
											</label>
											<div class="input-group">
												<input type="password" required class="form-control" name="pass"
													   id="pass"
													   onkeyup="javascript:this.value=this.value.toUpperCase();">
												<span class="input-group-btn">
														<button id="show_password" class="btn btn-primary" type="button"
																onclick="mostrarPassword2()"> <span
																class="fa fa-eye-slash icon"></span> </button>
											</div>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="container-fluid">
										<div class="form-group label-floating">
											<label class="control-label">
												Correo
												<small>*</small>
											</label>
											<input type="email" required class="form-control" name="correo" id="correo" >
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<div class="form-group label-floating">
											<label class="control-label">
												Teléfono
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="telefono" id="telefono" onkeypress="return SoloNumeros(event)">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<div class="form-group label-floating">
											<label class="control-label">
												RFC
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="rfc" id="rfc" onkeypress="return SoloNumeros(event)">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="container-fluid">
										<style>
											.checkbox
											{
												 margin-top: 0px;
											}
											.center{
												text-align: center;
											}
											.checkBoxDiv
											{
												padding-bottom: 60px;
											}
											.error-field
											{
												background-image: linear-gradient(#34444c, #760689), linear-gradient(#d20e0a, #d20e0a) !important;
											}
										</style>
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 checkBoxDiv">
											<br>
											<label>¿Tiene Hijos?</label>
											<select class="selectpicker" id="hijos" name="hijos" data-style="btn btn-primary" title="¿Tiene hijos?" data-size="7">
												<option selected value="2">SIN ESPECIFICAR</option>
												<option value="1">SI</option>
												<option value="0">NO</option>
											</select>
											<!--
											<div class="checkbox checkbox-inline">
												<label>
													<input type="checkbox" class="matpat" value="0" id="maternidad"> Maternidad
												</label>
											</div>
											<div class="checkbox checkbox-inline">
												<label>
													<input type="checkbox" class="matpat" value="0" id="paternidad"> Paternidad
												</label>
											</div>-->

										</div>
										<br><br>

									</div>
								</div>
							</div>
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="statusMsg"></p>
							</div>
							<div class="modal-footer center-align">
								<br>
								<button class="btn btn-success btn-lg hide" id="btnSubmitEnviar" >
														<span class="btn-label">
															<i class="material-icons">check</i>
														</span>
									¡Entendido!
								</button>
								<a href="#" class="btn btn-success btn-lg" onclick="return validateFields()">
									Enviar <i class="material-icons">send</i></span>
								</a>
							</div>
						</form>
						<!--<form name="myFormTestAlv" method="POST" action="<?=base_url()?>index.php/registroLote/insertAsesor">
							<input name="correo2" id="correo2"/><br>
							<input name="alv" id="alv"/><br>
							<button type="submit" class="btn">enviaralv</button>
						</form>-->
					</div>
				</div>
			</div>
			<!--editaruser-->
			<div class="modal fade" id="edit-user">
				<div class="modal-dialog modal-lg" style="width: 45%">
					<div class="modal-content">
						<form name="editUser" id="editUser">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"
										style="position: absolute;right: 2%;top: 4%;;color: #333">
									<span class="material-icons">close</span>
									<span class="sr-only">Cerrar</span>
								</button>
								<h3 class="modal-title">Editar usuario</h3>
							</div>
							<div class="modal-body">
								<input type="hidden" id="idAsesor" name="idAsesor">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="container-fluid">
										<div class="form-group label-floating" id="pNombreDiv">
											<label class="control-label">
												Nombre
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="primerNombre" id="primerNombre"
												   onkeyup="javascript:this.value=this.value.toUpperCase();"/>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="container-fluid">
									<div class="form-group label-floating" id="aPatDiv">
										<label class="control-label">
										Apellido Paterno
										<small>*</small>
										</label>
										<input type="text" required class="form-control" name="apellidoPaterno" id="apellidoPaterno"
										   onkeyup="javascript:this.value=this.value.toUpperCase();">
									</div>
								</div>
							</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid hide">
										<div class="form-group label-floating" id="sNombreDiv">
											<label class="control-label">
												Segundo Nombre
											</label>
											<input type="text" class="form-control" name="segundoNombre" id="segundoNombre"
												   onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>
									</div>
									<div class="container-fluid">
										<div class="form-group label-floating" id="aMatDiv">
											<label class="control-label">
												Apellido Materno
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="apellidoMaterno" id="apellidoMaterno"
												   style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="container-fluid">
										<div class="form-group label-floating" id="passDiv">
											<label class="control-label">
												Contraseña
												<small>*</small>
											</label>
											<div class="input-group">
												<input type="password" required class="form-control" name="password" id="password"
													   onkeyup="javascript:this.value=this.value.toUpperCase();">
												<span class="input-group-btn">
												<button id="show_passwordEd" class="btn btn-primary" type="button"
														onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
											</div>
										</div>
										<div class="form-group label-floating"  id="correoDiv">
											<label class="control-label">
												Correo
												<small>*</small>
											</label>
											<input type="email" required class="form-control" name="correo" id="correoEd">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<div class="form-group label-floating" id="telDiv">
											<label class="control-label">
												Teléfono
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="telefono" id="telefonoEd"
												   onkeypress="return SoloNumeros(event)">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="container-fluid">
										<div class="form-group label-floating" id="rfcDiv">
											<label class="control-label">
												RFC
												<small>*</small>
											</label>
											<input type="text" required class="form-control" name="rfc" id="rfcEd">
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="container-fluid">
										<br>
										<label>¿Tiene Hijos?</label>
										<select class="selectpicker" id="hijosEd" name="hijos"
												data-style="btn btn-primary" title="¿Tiene hijos?" data-size="7">
										</select>
									</div>
								</div>
							</div>
							<p class="statusMsg"></p>
							<div class="modal-footer center-align">
								<br>
								<button href="#" class="btn btn-success btn-lg" type="submit">
									Actualizar <i class="material-icons">send</i></span>
								</button>
							</div>
						</form>
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

<script>
	function validateFields()
	{
		if($('#tipoUser').val()=="")
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Por favor selecciona el tipo de usuario</span></center>');
			setTimeout(function(){
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if ($('#sede').val()=="" || $('#sede').val()==null) {
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Por favor selecciona una sede</span></center>');

			setTimeout(function () {
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#idGerente').val()=="")
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Por favor selecciona un Gerente</span></center>');
			setTimeout(function(){
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#nameCoordinador').val()=="" && $('#tipoUser').val()== 7)
		{
				if($('#tipoUser').val()== 7) {
					$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Selecciona un coordinador</span></center>');
					// $('#nameCoordinador').addClass('animated shake error-field');
					setTimeout(function () {
						// $('#nameCoordinador').removeClass('animated shake error-field');
						$('.statusMsg').html('');
					}, 2000);
					return false;
				}

		}
		else if($('#pNombre').val()=="" || $('#pNombre').val().length<2)
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Nombre demasiado corto</span></center>');
			$('#pNombre').addClass('animated shake error-field');
			setTimeout(function(){
				$('#pNombre').removeClass('animated shake error-field');
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#aPaterno').val()=="" || $('#aPaterno').val().length<2)
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">Apellido paterno demasiado corto</span></center>');
			$('#aPaterno').addClass('animated shake error-field');
			setTimeout(function(){
				$('#aPaterno').removeClass('animated shake error-field');
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#user').val()=="" || $('#user').val().length<6)
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">El usuario debe tener al menos 6 caracteres</span></center>');
			$('#user').addClass('animated shake error-field');
			setTimeout(function(){
				$('#user').removeClass('animated shake error-field');
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#pass').val()=="" || $('#pass').val().length<6)
		{
			$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335">La contraseña debe tener al menos 6 caracteres</span></center>');
			$('#pass').addClass('animated shake error-field');
			setTimeout(function(){
				$('#pass').removeClass('animated shake error-field');
				$('.statusMsg').html('');
			}, 2000);
			return false;
		}
		else if($('#correo').val()=="")
		{
			$('#correo').addClass('animated shake error-field');
			setTimeout(function(){
				$('#correo').removeClass('animated shake error-field');
			}, 2000);
			return false;
		}
		else if($('#telefono').val()=="")
		{
			$('#telefono').addClass('animated shake error-field');
			setTimeout(function(){
				$('#telefono').removeClass('animated shake error-field');
			}, 2000);
			return false;
		}
		else {
			$('#btnSubmitEnviar').click();
			return true;

		}
	}
	function SoloNumeros(evt){
		if(window.event){
			keynum = evt.keyCode;
		}
		else{
			keynum = evt.which;
		}
		if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 ){
			return true;
		}
		else{

			alerts.showNotification('top', 'right', 'Solo se permiten números', 'danger');
			return false;
		}
	}
	$(document).ready(function()
	{
		var table = $('#Jtabla').dataTable( {
			"ajax":
				{
					"url": '<?=base_url()?>index.php/registroLote/catAsesor',
					"dataSrc": ""
				},


			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			scrollX: true,
			pageLength: '10',
			columnDefs: [{
				defaultContent: "N/A",
				targets: "_all"
			}],
			dom: 'Bfrtip',
			ordering: false,
			buttons: [
				{
					extend:    'copyHtml5',
					text:      '<i class="fa fa-files-o"></i>',
					titleAttr: 'Copy'
				},
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'csvHtml5',
					text:      '<i class="fa fa-file-text-o"></i>',
					titleAttr: 'CSV'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				},
			],
			columns: [

				{
					// data: "gerente"
					data:function(d)
					{
						return d.asesor;
					}
				},
				{
					data:function(d)
					{
						return d.lider;
					}
				},
				{
					data:function(d)
					{
						return d.correo;
					}
				},
				{
					data:function(d)
					{
						return d.telefono;
					}
				},
				{
					data:function(d)
					{
						return d.rfc;
					}
				},
				{
					data:function(d)
					{
						return d.usuario;
					}
				},
				{
					data:function(data)
					{
						var act1 = '<a href="#" data-asesor="' + data.id_usuario + '" class="cambiar-estatus-usuario">' + (data.estatus == 1 ? '<i class="fa fa-user-times" aria-hidden="true"></i>Deshabilitar' : '<i class="fa fa-user-plus" aria-hidden="true"></i>Habilitar') + '</a><br><br>';
						var act2 = '<a  href="#" class="cancela" data-asesor="' + data.id_usuario + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>';
						 return act1 + act2;
					}
				}

			],
		} );


		$("#addUser").on('submit', function(e){
			e.preventDefault();
			var pass_data = $('#addUser').serialize();
			var url = 'insertAsesor/';
			var correo = $('#correo').val();
			var data = JSON.stringify(pass_data);

			$.ajax({
				url: "<?php echo base_url('registroLote/insertAsesor'); ?>",
				data: pass_data,
				cache: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				beforeSend: function(){

					$('#btnSubmitEnviar').attr("disabled","disabled");
					$('#btnSubmitEnviar').css("opacity",".5");

				},
				success: function(respuestaServer) {
					//alert( data );
					$('.statusMsg').html('');
					if (respuestaServer == 1)
					{
						// $('.statusMsg').html('<span style="font-size:18px;color:#34A853">Usuario Añadido correctamente</span>');
						alerts.showNotification('top', 'right', 'Usuario Añadido correctamente', 'success');
						$('#addUser')[0].reset();
						$('#Jtabla').DataTable().ajax.reload();
						$('#btnSubmitEnviar').prop('disabled', false);
						$('#btnSubmitEnviar').css("opacity","1");
						setTimeout(function(){
							$('.statusMsg').html('');
						}, 2000);
					}
					else if(respuestaServer == 0)
					{
						$('.statusMsg').html('<center><span style="font-size:13px;color:#EA4335">Usuario ('+$('#user').val()+') ya esta dado de alta en el sistema</span></center>');
						$('#btnSubmitEnviar').prop('disabled', false);
						$('#btnSubmitEnviar').css("opacity","1");
						$('#userName').addClass('animated shake');
						setTimeout(function(){
							$('.statusMsg').html('');
							$('#userName').removeClass('animated shake');
						}, 2500);
					}
					else
					{
						$('.statusMsg').html('<center><span style="font-size:18px;color:#EA4335"Ha ocurrido un error, intentelo de nuevo</span></center>');
						alerts.showNotification('top', 'right', 'Ha ocurrido un error, intentelo de nuevo', 'danger');
						$('#btnSubmitEnviar').prop('disabled', false);
						$('#btnSubmitEnviar').css("opacity","1");
						setTimeout(function(){
							$('.statusMsg').html('');
						}, 2000);
					}
				},
				error: function(xhr, status, error) {
					console.log(error);
					console.log(status);
					console.log(xhr);
				}

			});
		});


		$('#editUser').on('submit', function(e) {
			var $itself = $(this);
			e.preventDefault();
			if($itself.valid()) {
				$.ajax({
					url:   '<?=base_url()?>index.php/registroLote/updateAsesor/',
					type: 'post',
					dataType: 'json',
					data: $itself.serialize(),
					success: function(data) {
						// console.log(data);
						if(data.status == 'ok') {
							$('#edit-user').modal('hide');
							$itself.trigger('reset');
							$itself.find('#idAsesor').val('0');
							$('#Jtabla').DataTable().ajax.reload();
							alerts.showNotification('top', 'right', 'Asesor editado exitosamente', 'success');
						} else {
							console.log(data.message);
							console.log('fail');
						}
					},
					error: function(xhr, object, message) {
						console.log(message);
						alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado, intentalo nuevamente', 'danger');
					}
				});
			}
		});
	});

	function mostrarPassword(){
		var cambio = document.getElementById("password");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

	function mostrarPassword2(){
		var cambio = document.getElementById("pass");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}
	$(document).on('click', '.cambiar-estatus-usuario', function(e) {
		e.preventDefault();
		var $itself = $(this);
		$.post('<?=base_url()?>index.php/registroLote/cambiarEstatusAsesor', {idAsesor: $itself.attr('data-asesor'), action: $itself.text()}, function(data) {
			if(data.status == 'ok') {
				alerts.showNotification('top', 'right', 'Estatus cambiado exitosamente', 'success');
				$('#Jtabla').DataTable().ajax.reload();
			} else {
				console.log(data.message);
			}
		}, 'json');
	});


	$(document).on('click', '.cancela', function(e) {
		e.preventDefault();
		var $itself = $(this);
		$.post('<?=base_url()?>index.php/registroLote/editaAsesor', {idAsesor: $itself.attr('data-asesor')}, function(data) {
			if(data.status == 'ok') {
				var $form = $('#editUser');
				$form.find('#idAsesor').val($itself.attr('data-asesor'));
				$form.find('#primerNombre').val(data.loteCancela.nombre);
				(data.loteCancela.primerNombre!="") ? $('#pNombreDiv').removeClass('is-empty'):"";
				$form.find('#apellidoPaterno').val(data.loteCancela.apellido_paterno);
				(data.loteCancela.apellido_paterno!="") ? $('#aPatDiv').removeClass('is-empty'):"";
				$form.find('#apellidoMaterno').val(data.loteCancela.apellido_materno);
				(data.loteCancela.apellido_materno!="") ? $('#aMatDiv').removeClass('is-empty'):"";
				$form.find('#correoEd').val(data.loteCancela.correo);
				(data.loteCancela.correo!="") ? $('#correoDiv').removeClass('is-empty'):"";

				$form.find('#telefonoEd').val(data.loteCancela.telefono);
				(data.loteCancela.telefono!="") ? $('#telDiv').removeClass('is-empty'):"";

				$form.find('#rfcEd').val(data.loteCancela.rfc);
				(data.loteCancela.rfc!="") ? $('#rfcDiv').removeClass('is-empty'):"";

				$form.find('#password').val(data.loteCancela.contrasena);
				(data.loteCancela.contrasena!="") ? $('#passDiv').removeClass('is-empty'):"";

				// $form.find('#hijosEd').val(data.loteCancela.tiene_hijos);
				if(data.loteCancela.tiene_hijos == 1)
				{
					$("#hijosEd").empty().selectpicker('refresh');
					$("#hijosEd").append('<option selected="selected" value="'+data.loteCancela.tiene_hijos+'">SI</option>');
					$("#hijosEd").append('<option value="0">NO</option>');
					$("#hijosEd").append('<option value="2">SIN ESPECIFICAR</option>');
					$("#hijosEd").selectpicker('refresh');
				}
				if(data.loteCancela.tiene_hijos == 2)
				{
					$("#hijosEd").empty().selectpicker('refresh');
					$("#hijosEd").append('<option selected="selected" value="'+data.loteCancela.tiene_hijos+'">SIN ESPECIFICAR</option>');
					$("#hijosEd").append('<option value="1">SI</option>');
					$("#hijosEd").append('<option value="0">NO</option>');
					$("#hijosEd").selectpicker('refresh');
				}
				if(data.loteCancela.tiene_hijos == 0)
				{
					$("#hijosEd").empty().selectpicker('refresh');
					$("#hijosEd").append('<option selected="selected" value="'+data.loteCancela.tiene_hijos+'">NO</option>');
					$("#hijosEd").append('<option selected="selected" value="2">SIN ESPECIFICAR</option>');
					$("#hijosEd").append('<option value="1">SI</option>');
					$("#hijosEd").selectpicker('refresh');
				}



				$('#edit-user').modal('show');
			} else {
				console.log(data.message);
			}
		}, 'json');
	});
console.log('<?=$this->session->userdata('nombreGerente');?>');
console.log('<?=$this->session->userdata('idGerente');?>');
$('#gerenteAsesor').val("<?=$this->session->userdata('nombreGerente');?>");
$('#gerenteAsesorID').val("<?=$this->session->userdata('idGerente');?>");
$('#tipoUser').on('change', function()
{
	console.log('ha cambiado tipoUser a: ' + $('#tipoUser').val());
	if($('#tipoUser').val() == 7)
	{
		// $('#selectGerenteList').css('display', 'block');
		$("#sede").val('default');
		$("#sede").selectpicker("refresh");
		$("#idGerente").empty().selectpicker('refresh');
		$("#nameCoordinador").empty().selectpicker('refresh');
		$('#coordinadoralv').removeClass('hide');
	}
	else if($('#tipoUser').val() == 9)
	{
		// $('#selectGerenteList').css('display', 'block');

		$("#sede").val('default');
		$("#sede").selectpicker("refresh");
		$("#idGerente").empty().selectpicker('refresh');
		$("#nameCoordinador").empty().selectpicker('refresh');
		$('#coordinadoralv').addClass('hide');
	}
});

$('#sede').on('change', function()
{
	if($('#selectTipo').val()== 9)
	{
		$("#nameCoordinador").val('default');
		$("#nameCoordinador").selectpicker('refresh');
	}

	$("#idGerente").empty().selectpicker('refresh');
	$.post('<?=base_url()?>index.php/registroLote/getGerentsBySede/'+$('#sede').val(), function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['id_usuario'];
			var name = data[i]['nombreGerente'];
			$("#idGerente").append($('<option>').val(id).text(name));
		}
		if(len<=0)
		{
			$("#idGerente").append('<option selected="selected" disabled>NINGUN GERENTE ENCONTRADO</option>');
		}
		$("#idGerente").selectpicker('refresh');
	}, 'json');
});

	$('#idGerente').on('change', function () {
		$("#nameCoordinador").empty().selectpicker('refresh');
		$.post('<?=base_url()?>index.php/registroLote/getCoordByGerente/' + $('#idGerente').val(), function (data) {
			var len = data.length;
			for (var i = 0; i < len; i++) {
				var id = data[i]['id_usuario'];
				var name = data[i]['nombreCoordinador'];
				$("#nameCoordinador").append($('<option>').val(id).text(name));
			}
			if (len <= 0) {
				$("#nameCoordinador").append('<option selected="selected" disabled>NINGUN COORDINADOR ENCONTRADO</option>');
			}
			$("#nameCoordinador").selectpicker('refresh');
		}, 'json');
	});

</script>

