<body class="">
<div class="wrapper ">
	<?php
		$dato= array(
		'home' => 0,
		'listaCliente' => 0,
		'corridaF' => 0,
		'documentacion' => 0,
		'autorizacion' => 1,
		'contrato' => 0,
		'inventario' => 0,
		'estatus8' => 0,
		'estatus14' => 0,
		'estatus7' => 0,
		'reportes' => 0,
		'estatus9' => 0,
		'disponibles' => 0,
		'asesores' => 0,
		'nuevasComisiones' => 0,
		'histComisiones' => 0,
        'prospectos' => 0,
        'prospectosAlta' => 0

	);
	//$this->load->view('template/ventas/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);

	?>
	<!--Contenido de la página-->
	<div class="modal fade modal-alertas" id="modal_autorizacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Subir archivo de autorización.</h4>
				</div>
				<form method="post" action="<?= base_url() ?>index.php/registroCliente/alta_autorizacionVentas/"
					  enctype="multipart/form-data" name="status">
					<input type="hidden" name="idCliente" id="idCliente">
					<input type="hidden" name="idClienteHistorial" id="idClienteHistorial">
					<input type="hidden" name="idLoteHistorial" id="idLoteHistorial">
					<input type="hidden" name="idUser" id="idUser">
					<input type="hidden" name="idCondominio" id="idCondominio">

					<input type="hidden" name="nombreResidencial" id="nombreResidencial">
					<input type="hidden" name="nombreLote" id="nombreLote">
					<input type="hidden" name="nombreCondominio" id="nombreCondominio">
<!--					<input type="hidden" name="nombreArchivo" id="nombreArchivo">-->
					<div class="modal-body">

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
						<h4>INGRESAR AUTORIZACIÓN</h4>
					</center>
					<div class="card">
						<div class="container-fluid" style="padding: 50px 50px;">
 								<div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

 									<div class="row">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn  "data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
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
									<div class="table-responsive">

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_autorizaciones_ventas" name="tabla_autorizaciones_ventas">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">AUTORIZACIÓN</th>
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

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";
var urlimg = "<?=base_url()?>img/";
 

$(document).ready(function(){
		$.post(url + "Asistente_gerente/lista_proyecto", function(data) {
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
		$.post(url + "Asistente_gerente/lista_condominio/"+index_proyecto, function(data) {
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
   	$(document).ready(function(){
		$.post(url + "Asistente_gerente/lista_lote/"+index_condominio, function(data) {
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
 
   });

    $('#lote').change( function() {
   	index_lote = $(this).val();
 
   					   // $('#tabla_autorizaciones_ventas').DataTable({
tabla_autorizaciones = $("#tabla_autorizaciones_ventas").DataTable({
				destroy: true,
				"ajax":
					{
						"url": '<?=base_url()?>index.php/Asistente_gerente/get_lote_autorizacion/'+index_lote,
						"dataSrc": ""
					},

				"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"ordering": false,
				"searching": false,
				"paging": false,

				"bAutoWidth": false,
				"bLengthChange": false,
				"scrollX": true,
				"bInfo": false,
				"fixedColumns": true,

				"columns":
				[
					{data: 'nombreLote'},
					{data: 'condominio'},
					{data: 'nombreResidencial'},
					{
						data: null,
						render: function ( data, type, row )
						{
							return data.nombre+' ' +data.apellido_paterno+' '+data.apellido_materno;
						},
					},

					{ 
						"orderable": false,
						"data": function( data ){
							opciones = '<div class="btn-group" role="group">';
							opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-just-icon btn-info agregar_autorizacion" data-id_condominio="'+data.idCondominio+'" data-id_cliente="'+data.id_cliente+'" data-idClienteHistorial="'+data.id_cliente+'" data-idLoteHistorial="'+data.idLote+'" data-id_user="<?php echo $this->session->userdata('id_usuario');?>" data-nomResidencial="'+data.nombreResidencial+'" data-nomLote="'+data.nombreLote+'" data-nomCondominio="'+data.condominio+'"><i class="material-icons">open_in_browser</i></button></div>';
							return opciones + '</div>';
						} 
					}
 
				]

		});


 $("#tabla_autorizaciones_ventas tbody").on("click", ".agregar_autorizacion", function(){

    var tr = $(this).closest('tr');
    var row = tabla_autorizaciones.row( tr );

    idautopago = $(this).val();
 //<form method="post" action="<?//= base_url() ?>//index.php/registroCliente/alta_autorizacionVentas/"
	// enctype="multipart/form-data" name="status">

	 $('#idCliente').val($(this).attr("data-id_cliente"));//data-id_cliente
	 $('#idClienteHistorial').val($(this).attr("data-idclientehistorial"));//data-idclientehistorial
	 $('#idLoteHistorial').val($(this).attr("data-idlotehistorial"));
	 $('#idUser').val($(this).attr("data-id_condominio"));
	 $('#idCondominio').val($(this).attr("data-id_user"));
	 $('#nombreResidencial').val($(this).attr("data-nomResidencial"));
	 $('#nombreLote').val($(this).attr("data-nomLote"));
	 $('#nombreCondominio').val($(this).attr("data-nomCondominio"));

	 // $('#nombreArchivo').val();
	$("#modal_autorizacion .modal-body").html("");
    $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><input type="file" name="expediente" id="expediente"></div></div>');
    $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><br></div><div class="col-lg-4"></div><div class="col-lg-4"><button class="btn btn-social btn-fill btn-info"><i class="fa fa-google-square"></i>SUBIR</button></div></div>');
    $("#modal_autorizacion").modal();
});

});




$(window).resize(function(){
    tabla_autorizaciones.columns.adjust();
});

$(document).ready(function () {
	<?php
	if($this->session->userdata('success') == 1)
	{
		echo "alerts.showNotification('top', 'right', 'Se envió a autorizacion correctamente', 'success');";
		$this->session->unset_userdata('success');
	}
	else if($this->session->userdata('success') == 33)
	{
		echo "alerts.showNotification('top', 'right', 'Ocurrio un error al intentar enviar a autorización, intentalo nuevamente', 'danger');";
		$this->session->unset_userdata('success');
	}
	?>
});

</script>

