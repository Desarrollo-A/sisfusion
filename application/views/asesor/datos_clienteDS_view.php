<body>
<div class="wrapper">
	<?php	$this->load->view('template/asesor/sidebar');	?>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<center>
							<h3>Tus Ventas</h3>
						</center>
						<hr>
						<br>
					</div>
				</div>
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row ">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 hidden">
							<div class="form-group">
								<label>Proyecto</label>
								<select required="required" name="residencial" id="residencial" class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona Proyecto" data-size="7" style="width: 100%;"/>
								<option value="0" disabled selected>-SELECCIONA-</option>
								<?php foreach($residencial as $row):?>
									<option   value="<?=$row['idResidencial']?>"><?=$row['nombreResidencial']?></option>
								<?php endforeach;?>
								</select>
							</div>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 hidden">
							<div class="form-group">
								<label>Condominio</label>
								<select  id="filtro4" name="filtro4" class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona Condominio" data-size="7" required/></select>
							</div>
						</div>

						<style>
							.fileUpload {
								position: relative;
								overflow: hidden;
								margin: 10px;
							}
							.fileUpload input.upload {
								position: absolute;
								top: 0;
								right: 0;
								margin: 0;
								padding: 0;
								font-size: 20px;
								cursor: pointer;
								opacity: 0;
								filter: alpha(opacity=0);
							}  */
						</style>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
								<div class="table-responsive">
									<table id="addExp" class="table table-bordered table-hover" width="100%" style="text-align:center;">
										<thead>
										<tr>
											<th><center>Proyecto</center></th>
											<th><center>Condominio</center></th>
											<th><center>Lote</center></th>
											<th><center>Cliente</center></th>
											<th><center>Adjunta</center></th>
											<th><center>DS</center></th>


										</tr>
										</thead>
										<tbody></tbody>
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
	<!-- modal  INSERT COMENTARIOS-->
	<div class="modal fade" id="addFile" style="padding: 50px;">
		<div class="modal-dialog">
			<div class="modal-content" style="padding: 40px;background-color: rgba(255,255,255,1);color:  #333;">
				<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 8%;top: 8%;color: #333">
					<span class="material-icons">close</span>
					<span class="sr-only">Cerrar</span>
				</button>
				<div class="row text-center white-text">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<center><h3>Adjunta tu archivo</h3></center>
					</div>
					<br>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<form id="formAddFile" enctype="multipart/form-data">
							<div class="form-group col-md-12">

								<input type="hidden" class="form-control" id="idCliente" name="idCliente">
								<input type="hidden" class="form-control" id="nombreResidencial" name="nombreResidencial">
								<input type="hidden" class="form-control" id="nombreCondominio" name="nombreCondominio">
								<input type="hidden" class="form-control" id="idCondominio" name="idCondominio">
								<input type="hidden" class="form-control" id="nombreLote" name="nombreLote">
								<input type="hidden" class="form-control" id="idLote" name="idLote">
								<label>Archivo:</label>


								<div class="input-group">
									<label class="input-group-btn">
						<span class="btn btn-primary">
							Seleccionar archivo&hellip; <input type="file" name="expediente" id="expediente" style="display: none;">
						</span>
									</label>
									<input type="text" class="form-control" readonly>
								</div>
							</div>
							<center>
								<button type="submit" id="save" class="btn btn-primary" style="margin-right: 15px;">Guardar</button>
							</center>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->

	<div id="mensaje"></div>
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
<!--script of the page-->
<script>
	$(function() {
		$(document).on('change', ':file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});

		$(document).ready( function() {
			$(':file').on('fileselect', function(event, numFiles, label) {
				var input = $(this).parents('.input-group').find(':text'),
					log = numFiles > 1 ? numFiles + ' files selected' : label;
				if( input.length ) {
					input.val(log);
				} else {
					if( log ) alert(log);
				}
			});
		});

	});
	$('#residencial').change(function(){
		var valorSeleccionado = $(this).val();
		/*$('#filtro4').load("<?=base_url()?>registroCliente/getCondominioDesc/"+valorSeleccionado, function(){
		});
		var valorSeleccionado = $(this).val();*/

		// console.log(valorSeleccionado);
		//build select condominios
		$("#filtro4").empty().selectpicker('refresh');
		$.ajax({
			url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				for( var i = 0; i<len; i++)
				{
					var id = response[i]['idCondominio'];
					var name = response[i]['nombre'];
					$("#filtro4").append($('<option>').val(id).text(name));
				}
				$("#filtro4").selectpicker('refresh');

			}
		});
	});

	$(document).ready (function() {
		var table;
		table = $('#addExp').DataTable( {
			dom: 'Bfrtip',
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
				}
			],
			"scrollX": true,
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			columns: [
				{ "data": "nombreResidencial" },
				{ "data": "nombreCondominio" },
				{ "data": "nombreLote" },
				{
					"data": function( d ){

						var primerNombre =
							(d.primerNombre == null ? "" : d.primerNombre);

						var segundoNombre =
							(d.segundoNombre == null ? "" : d.segundoNombre);

						var apellidoPaterno =
							(d.apellidoPaterno == null ? "" : d.apellidoPaterno);


						var apellidoMaterno =
							(d.apellidoMaterno == null ? "" : d.apellidoMaterno);

						var razonSocial =
							(d.razonSocial == null ? "" : d.razonSocial);


						return primerNombre + " " + segundoNombre + " " + apellidoPaterno + " " + apellidoMaterno
							+ " " + razonSocial;
					}
				},
				{
					"data": function( d ){
						return '<a href="" class="getInfo" data-idCliente="'+d.idCliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'"><i class="fa fa-file-archive-o fa-2x" aria-hidden="true"></i></a>';
					}
				},
				{
					"data": function( d ){
						return '<a href="<?=base_url()?>index.php/registroCliente/deposito_seriedad/'+d.idCliente+'"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>' ;
					}
				}
			],
			"ajax": {
				"url": "<?=base_url()?>index.php/registroCliente/tableClienteDS/",
				"type": "POST",
				"dataSrc": "",
				cache: false,
				"data": function( d ){
					d.idCondominio = $('#filtro4').val();
				},

			},
		});

		$("#addExp tbody").on("click", ".getInfo", function(e){
			e.preventDefault();
			var idCliente = $(this).attr("data-idCliente");
			var nombreResidencial = $(this).attr("data-nombreResidencial");
			var nombreCondominio = $(this).attr("data-nombreCondominio");
			var idCondominio = $(this).attr("data-idCondominio");
			var nombreLote = $(this).attr("data-nombreLote");
			var idLote = $(this).attr("data-idLote");
			var $form = $('#formAddFile');
			$form.find('#idCliente').val(idCliente);
			$form.find('#nombreResidencial').val(nombreResidencial);
			$form.find('#nombreCondominio').val(nombreCondominio);
			$form.find('#idCondominio').val(idCondominio);
			$form.find('#nombreLote').val(nombreLote);
			$form.find('#idLote').val(idLote);
			$('#addFile').modal('show');
		});
	});
	$(document).on('click', '#save', function(e) {
		e.preventDefault();
		var idCliente = $('#idCliente').val();
		var nombreResidencial = $('#nombreResidencial').val();
		var nombreCondominio = $('#nombreCondominio').val();
		var idCondominio = $('#idCondominio').val();
		var nombreLote = $('#nombreLote').val();
		var idLote = $('#idLote').val();
		var expediente = $("#expediente")[0].files[0];
		var data = new FormData();
		data.append("idCliente", idCliente);
		data.append("nombreResidencial", nombreResidencial);
		data.append("nombreCondominio", nombreCondominio);
		data.append("idCondominio", idCondominio);
		data.append("nombreLote", nombreLote);
		data.append("idLote", idLote);
		data.append("expediente", expediente);
		$.ajax({
			url: "addFileVentas",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(data)
			{
				if(data == 1)
				{
					console.log('before toast success');
					alerts.showNotification('top','right','¡Archivo dado de alta exitosamente!', 'success');

					// console.log('after toast');
					$('#addFile').modal('hide');
				}
				else
				{

				}
			},
			error: function( data ){
				toastr.error('Archivo no dado de alta.', 'Alerta de error');
			}
		});
	});

	jQuery(document).ready(function(){
		jQuery('#addFile').on('hidden.bs.modal', function (e) {
			jQuery(this).removeData('bs.modal');
			jQuery(this).find('#expediente').val('');
		})
	});

	$("#filtro4").on("change", function(){
		$('#addExp').DataTable().ajax.reload();
	});
</script>

</html>
