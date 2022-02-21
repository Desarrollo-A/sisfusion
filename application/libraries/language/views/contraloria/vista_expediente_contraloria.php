
<body class="">
<div class="wrapper ">
	<?php
$dato= array(
        'home' => 0,
        'listaCliente' => 0,
        'expediente' => 1,
        'corrida' => 0,
        'documentacion' => 0,
        'historialpagos' => 0,
        'inventario' => 0,
        'estatus20' => 0,
        'estatus2' => 0,
        'estatus5' => 0,
        'estatus6' => 0,
        'estatus9' => 0,
        'estatus10' => 0,
        'estatus13' => 0,
        'estatus15' => 0,
        'enviosRL' => 0,
        'estatus12' => 0,
        'acuserecibidos' => 0,
        'tablaPorcentajes' => 0,
        'comnuevas' => 0,
        'comhistorial' => 0,
		'integracionExpediente' => 0,
		'expRevisados' => 0,
		'estatus10Report' => 0,
		'rechazoJuridico' => 0
    );
	//$this->load->view('template/contraloria/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);

	
	?>
	<!--Contenido de la página-->
	<div class="modal fade modal-alertas" id="modal_autorizacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span class="material-icons">close</span></button>
					<h4 class="modal-title">Subir archivo de expediente.</h4>
				</div>
				<form method="post" id="form_expediente_add" enctype="multipart/form-data">
					<div class="modal-body" style="text-align: center">
						<input type="hidden" name="idCliente" id="idCliente" value="" />
						<input type="hidden" name="idClienteHistorial" id="idClienteHistorial" value="" />
						<input type="hidden" name="idLoteHistorial" id="idLoteHistorial" value="" />
						<input type="hidden" name="idUser" id="idUser" value="<?= $this->session->userdata('id_usuario');?>" />
						<input type="hidden" name="idCondominio" id="idCondominio" value="" />

						<input type="hidden" name="nombreResidencial" id="nombreResidencial" value="" />
						<input type="hidden" name="nombreCondominio" id="nombreCondominio" value="" />
						<input type="hidden" name="nombreLote" id="nombreLote" value="" />

						<legend>Selecciona tu archivo:</legend>
						<div class="fileinput fileinput-new text-center" data-provides="fileinput">
							<div class="fileinput-new thumbnail">

							</div>
							<div class="fileinput-preview fileinput-exists thumbnail"></div>
							<div>
                                                    <span class="btn btn-primary btn-round btn-file">
                                                        <span class="fileinput-new">Selecciona archivo</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="expediente" />
                                                    </span>
								<a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
							</div>
						</div>
						<center>
							<br><br>
							<button class="btn btn-primary"><i class="material-icons">send</i> SUBIR</button>
						</center>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div class="content">
		<div class="container-fluid">
			 
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
<!--						<h4>INGRESAR EXPEDIENTE</h4>-->
					</center>
					<div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title text-center">Ingresar expediente</h4>
 								<div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

 									<div class="row">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn "data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio" id="condominio" class="selectpicker" data-style="btn "data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="lote">Lote: </label>
										<select name="lote" id="lote" class="selectpicker" data-style="btn "data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA LOTE -</option></select>
									</div>
								</div>
 
 						</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
<!--						<div class="card-header card-header-icon" data-background-color="goldMaderas">-->
<!--							<i class="material-icons">reorder</i>-->
<!--						</div>-->
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_expediente_contraloria" name="tabla_expediente_contraloria">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
												<th style="font-size: .9em;">GERENTE</th>
												<th style="font-size: .9em;">ASESOR</th>
                                                <th style="font-size: .9em;">EXPEDIENTE</th>
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

var url = "<?=base_url()?>";/*http://localhost:9081/sisfusion/*/
var url2 = "<?=base_url()?>index.php";/*http://localhost:9081/sisfusion/index.php/*/
var urlimg = "<?=base_url()?>index.php/img/";/*http://localhost:9081/sisfusion/img/*/
 

$(document).ready(function(){
		$.post(url + "Contraloria/lista_proyecto", function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idResidencial'];
				var name = data[i]['descripcion'];
				$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#proyecto").selectpicker('refresh');
		}, 'json');
	});

   $('#proyecto').change( function() {
   	index_proyecto = $(this).val();
   	$("#condominio").html("");
   	$(document).ready(function(){
		$.post(url + "Contraloria/lista_condominio/"+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
 
   });


     $('#condominio').change( function() {
   	index_condominio = $(this).val();
   	$("#lote").html("");
		$.post(url + "index.php/registroCliente/getLotesEliteV/"+index_condominio+"/"+$("#proyecto").val(), function(data) {
			var len = data.length;
			$("#lote").append($('<option disabled selected>- SELECCIONA LOTE -</option>'));
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idLote'];
				var name = data[i]['nombreLote'];
				$("#lote").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#lote").selectpicker('refresh');
		}, 'json');


 
   });

    $('#lote').change( function() {
   	index_lote = $(this).val();
 
   					   // $('#tabla_expediente_contraloria').DataTable({
tabla_expediente = $("#tabla_expediente_contraloria").DataTable({
				destroy: true,
				"ajax":
					{
						"url": '<?=base_url()?>index.php/RegistroCliente/getClienteDocumentosElite/'+index_lote,
						"dataSrc": ""
					},

				"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"ordering": true,
				"searching": true,
				"paging": true,

				"bAutoWidth": false,
				"bLengthChange": false,
				"scrollX": true,
				"bInfo": false,
				"fixedColumns": true,

				"columns":
				[
					{data: 'nombreLote'},
					{data: 'nombreCondominio'},
					{data: 'nombreResidencial'},
					{
						data: null,
						render: function ( data, type, row )
						{
							return data.nombre+' ' +data.apellido_paterno+' '+data.apellido_materno;
						},
					},
					{data: 'gerente'},
					{data: 'asesor'},
					{ 
						"orderable": false,
						"data": function( data ){
							opciones = '<div class="btn-group" role="group">';
							opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-just-icon btn-green agregar_expediente" data-id_cliente="'+data.id_cliente+'" data-id_condominio="'+data.idCondominio+'"' +
								' data-idLote="'+data.idLote+'" data-nomResidencial="'+data.nombreResidencial+'"' +
							' data-nomCondominio="'+data.nombreCondominio+'" data-nomLote="'+data.nombreLote+'"><i class="material-icons">open_in_browser</i></button></div>';
							return opciones + '</div>';
						} 
					}
 
				]

		});


 $("#tabla_expediente_contraloria tbody").on("click", ".agregar_expediente", function(){

    var tr = $(this).closest('tr');
    var row = tabla_expediente.row( tr );

    idautopago = $(this).val();
	 var $itself = $(this);
	 $itself.attr('data-asesor');
	 $('#idCliente').val($itself.attr('data-id_cliente'));
	 $('#idClienteHistorial').val($itself.attr('data-id_cliente'));
	 $('#idLoteHistorial').val($itself.attr('data-idLote'));
	 $('#idCondominio').val($itself.attr('data-id_condominio'));

	 $('#nombreResidencial').val($itself.attr('data-nomResidencial'));
	 $('#nombreCondominio').val($itself.attr('data-nomCondominio'));
	 $('#nombreLote').val($itself.attr('data-nomLote'));


    /*$("#modal_autorizacion .modal-body").html("");
    $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><input type="file" name="autorizacion" id="autorizacion"></div></div>');
    $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><br></div><div class="col-lg-4"></div><div class="col-lg-4"><button class="btn btn-primary"><i class="material-icons">send</i> SUBIR</button></div></div>');*/
    $("#modal_autorizacion").modal();
});

});



	$('#form_expediente_add').on('submit', function(e) {
		var $itself = $(this);
		e.preventDefault();
		var formData = new FormData(this);
		if($itself.valid()) {
			$.ajax({
				url:   '<?=base_url()?>index.php/registroCliente/editar_registro_cliente_asistentesGerentes_expediente/',
				type: 'post',
				dataType: 'json',
				// data: $itself.serialize(),
				data:  formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data) {
					if(data == 1) {
						console.log(data);
						$('#modal_autorizacion').modal('hide');
						// $itself.trigger('reset');
						$itself.find('#idAsesor').val('0');
						$('#tabla_expediente_contraloria').DataTable().ajax.reload();
						alerts.showNotification('top', 'right', 'Expediente añadido exitosamenlte', 'success');
					} else {
						console.log(data.message);
						console.log('fail');
					}
				},
				error: function(xhr, object, message) {
					// console.log(formData);
					console.log(message);
					alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado, intentalo nuevamente', 'danger');
				}
			});
		}
	});


$(window).resize(function(){
    tabla_expediente.columns.adjust();
});


  
</script>

