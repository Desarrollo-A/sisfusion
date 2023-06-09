<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>
	<!--Contenido de la página-->
	<div class="modal fade modal-alertas" id="modal_autorizacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">[SIN DATOS]</h4>
				</div>
				<form method="post" id="form_interes">
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
<!--						<h5>PAGOS CANCELADOS</h5>-->
					</center>
					<div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Paagos cancelados</h4>
 								<div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

 									<div class="row">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto" id="proyecto" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio" id="condominio" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
									</div>

									<div class="col-md-4 form-group">
										<label for="lote">Lote: </label>
										<select name="lote" id="lote" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA LOTE -</option></select>
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

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_historial" name="tabla_historial">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">NO. RECIBO</th>
                                                <th style="font-size: .9em;">MONTO</th>
                                                <th style="font-size: .9em;">CONCEPTO</th>
                                                <th style="font-size: .9em;">FORMA PAGO</th>
                                                <th style="font-size: .9em;">FECHA CANCELACIÓN</th>
                                                <th style="font-size: .9em;">MÓTIVO</th>
                                                <th style="font-size: .9em;">USUARIO</th>
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

var url = "http://localhost:9081/sisfusion/";
var url2 = "http://localhost:9081/sisfusion/index.php/";
var urlimg = "http://localhost:9081/sisfusion/img/";
 

$(document).ready(function(){
		$.post(url + "Caja/lista_proyecto", function(data) {
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
		$.post(url + "Caja/lista_condominio/"+index_proyecto, function(data) {
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
		$.post(url + "VentasAsistentes/lista_lote/"+index_condominio, function(data) {
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
 
   					   // $('#tabla_historial').DataTable({
tabla_historial = $("#tabla_historial").DataTable({
				destroy: true,
				"ajax":
					{
						"url": '<?=base_url()?>index.php/Caja/get_lista_condominio/'+index_lote,
						"dataSrc": ""
					},

				"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"ordering": false,
				"searching": true,
				"paging": true,
				"pageLength": 5,

				"bAutoWidth": false,
				"bLengthChange": false,
				"scrollX": true,
				"bInfo": false,
				"fixedColumns": true,

				"columns":
				[
					{data: 'nombreResidencial'},
					{data: 'condominio'},
					{data: 'nombreLote'},
					{data: 'nombreLote'},
					{data: 'condominio'},
					{data: 'condominio'},
					{data: 'condominio'},
					{
						data: null,
						render: function ( data, type, row )
						{
							return data.primerNombre+' '+data.segundoNombre+' ' +data.apellidoPaterno+' '+data.apellidoMaterno;
						},
					},

					{ 
						"orderable": false,
						"data": function( data ){
							opciones = '<div class="btn-group" role="group">';
							opciones += '<div class="col-md-1 col-sm-1"><button class="btn btn-round btn-just-icon btn-info cambiar_asesor" style="background:#0FC693;" ><i class="material-icons">people</i></button></div>';
							return opciones + '</div>';
						} 
					}
 
				]

		});


 $("#tabla_historial tbody").on("click", ".cambiar_asesor", function(){

    var tr = $(this).closest('tr');
    var row = tabla_historial.row( tr );

    idautopago = $(this).val();

    $("#modal_autorizacion .modal-body").html("");
    // $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><input type="file" name="autorizacion" id="autorizacion"></div></div>');
    // $("#modal_autorizacion .modal-body").append('<div class="row"><div class="col-lg-12"><br></div><div class="col-lg-4"></div><div class="col-lg-4"><button class="btn btn-social btn-fill btn-info"><i class="fa fa-google-square"></i>SUBIR</button></div></div>');
    $("#modal_autorizacion").modal();
});

});




$(window).resize(function(){
    tabla_historial.columns.adjust();
});


  
</script>

