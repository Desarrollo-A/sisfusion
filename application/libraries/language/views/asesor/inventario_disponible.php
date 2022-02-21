<body>
<div class="wrapper">
	<?php
    switch ($this->session->userdata('id_rol')) {
        case "2": // SUBDIRECTOR
            $dato= array(
                'home' => 0,
                'usuarios' => 0,
                'statistics' => 0,
                'manual' => 0,
                'aparta' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'statistics' => 0,
                'corridaF' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 1,
				'autorizaciones' =>	0,
				'nuevasComisiones' => 0,
				'histComisiones' => 0,
				'prospectosMktd' => 0,
				'bulkload'	=>	0,
                'clientsList' => 0
            );
            $this->load->view('template/sidebar', $dato);
        break;
        default:
         $dato= array(
                    'home' => 0,
                    'listaCliente' => 0,
                    'corridaF' => 0,
                    'inventario' => 0,
                    'prospectos' => 0,
                    'prospectosAlta' => 0,
                    'statistic' => 0,
                    'comisiones' => 0,
                    'DS'    => 0,
                    'DSConsult' => 0,
                    'documentacion' => 0,
                    'inventarioDisponible'  =>  1,
                    'manual'    =>  0,
                    'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'references' => 0,
			 		'autoriza'	=>	0,
             'clientsList' => 0
                );
            $this->load->view('template/sidebar', $dato);
        break;
    }

	//$this->load->view('template/asesor/sidebar', $dato);
	//$this->load->view('template/sidebar', $dato);
	?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h3>INVENTARIO DISPONIBLE</h3>
					</center>
					<hr>
					<br>
				</div>
			</div>
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
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
						}
					</style>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" >
						<div class="card">
							<div class="container-fluid" style="padding:20px">
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="row">
										<div class="form-group"  style="padding: 10px">
											<label for="proyecto">Proyecto:</label>
											<select name="filtro3" id="filtro3" class="selectpicker" data-style="btn " data-show-subtext="true" data-live-search="true"  title="--SELECCIONA PROYECTO--" data-size="7" required>
												<option value="0">-SELECCIONA TODO-</option>

											</select>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Condominio</label>
											<select class="selectpicker" id="filtro4" name="filtro4[]"
													data-style="btn " data-show-subtext="true"
													data-live-search="true" title="--SELECCIONA CONDOMINIO--"
													data-size="7" required/></select>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Grupo</label>
											<select name="filtro5" id="filtro5" class="selectpicker" data-style="btn " data-show-subtext="true"
													data-live-search="true" title="--SELECCIONA GRUPO--"
													data-size="7" required/>
											<option disabled selected>-SELECCIONA GRUPO-</option>
											<option value="1"> < 200m2 </option>
											<option value="2"> >= 200 y < 300 </option>
											<option value="3"> >= 300m2 </option>
											</select>
										</div>
									</div>
								</div>

								<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Superficie</label>
											<select  class="selectpicker" id="filtro6" name="filtro6[]"  data-style="btn btn-primary " data-show-subtext="true"
													 data-live-search="true" title="--SELECCIONA SUPERFICIE--"
													 data-size="7" required/></select>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Precio m<sup>2</sup></label>
											<select  class="selectpicker" id="filtro7" name="filtro7[]"  data-style="btn btn-primary " data-show-subtext="true"
													 data-live-search="true" title="--PRECIO POR m2--"
													 data-size="7" required multiple/></select>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Precio total</label>
											<select  class="selectpicker" id="filtro8" name="filtro8[]"  data-style="btn btn-primary " data-show-subtext="true"
													 data-live-search="true" title="--PRECIO TOTAL--"
													 data-size="7" required multiple/></select>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="row">
										<div class="form-group" style="padding: 10px">
											<label>Meses S/N</label>
											<select  class="selectpicker" id="filtro9" name="filtro9[]"   data-style="btn btn-primary " data-show-subtext="true"
													 data-live-search="true" title="--MESES SIN INTERESES--"
													 data-size="7" required multiple/></select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="container-fluid">
								<div class="form-group">
									<div class="table-responsive">
										<table id="addExp" class="table table-bordered table-hover" width="100%" style="text-align:center;">
											<thead>
											<tr>
												<th><center>Proyecto</center></th>
												<th><center>Condominio</center></th>
												<th><center>Lote</center></th>
												<th><center>Sup</center></th>
												<th><center>Precio m<sup>2</sup></center></th>
												<th><center>Precio Total</center></th>
												<th><center>Meses S/N</center></th>
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
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
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
	// $('.select2').select2();
	$(document).ready(function() {
		var url = "<?=base_url()?>/index.php/";
		$.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
			var len = data.length;
			for (var i = 0; i < len; i++) {
				var id = data[i]['idResidencial'];
				var name = data[i]['descripcion'];
				$("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#filtro3").selectpicker('refresh');
		}, 'json');
	});
	var residencial;
	var grupo;
	var clusterSelect;
	var clusterSelect2;

	var supSelect;
	var supSelect2;

	var preciomSelect;
	var preciomSelect2;

	var totalSelect;
	var totalSelect2;

	var mesesSelect;
	var mesesSelect2;


	$('#filtro3').change(function(ruta){
		console.log($('#filtro3').val());
		residencial = $('#filtro3').val();
		grupo = $('#filtro5').val();


		if(residencial == 0){
			ruta = "<?= site_url('Asesor/getLotesInventarioGralTodosc') ?>";
			// $("#filtro4").html( "" ).append( "" );
			$("#filtro4").empty().selectpicker('refresh');
		} else if (residencial > 0){
			// <!--$('#filtro4').load("<?= site_url('Asesor/getCondominioDesc') ?>/"+residencial);-->
			$("#filtro4").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
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
			// <!--$('#filtro6').load("<?= site_url('Asesor/getSupOne') ?>/"+residencial);-->
			$("#filtro6").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>Asesor/getSupOne/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['sup'];
						var name = response[i]['sup'];
						$("#filtro6").append($('<option>').val(id).text(name+" m2"));
					}
					$("#filtro6").selectpicker('refresh');

				}
			});
			//$('#filtro7').load("<?//= site_url('registroLote/getPrecio') ?>///"+residencial);
			$("#filtro7").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>Asesor/getPrecio/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['precio'];
						var name = response[i]['precio'];
						$("#filtro7").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
					}
					$("#filtro7").selectpicker('refresh');

				}
			});
			//$('#filtro8').load("<?//= site_url('registroLote/getTotal') ?>///"+residencial);
			$("#filtro8").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>Asesor/getTotal/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['total'];
						var name = response[i]['total'];
						$("#filtro8").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
					}
					$("#filtro8").selectpicker('refresh');

				}
			});
			//$('#filtro9').load("<?//= site_url('registroLote/getMeses') ?>///"+residencial);
			$("#filtro9").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>Asesor/getMeses/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['msni'];
						var name = response[i]['msni'];
						$("#filtro9").append($('<option>').val(id).text(name + " MSI"));
					}
					$("#filtro9").selectpicker('refresh');

				}
			});

			ruta = "<?= site_url('Asesor/getLotesInventarioXproyectoc') ?>/"+residencial;
		}
		dataTable(ruta);

	});

	$('#filtro4').change(function(ruta){

		clusterSelect = '';
		clusterSelect2 = [];

		preciomSelect = '';
		preciomSelect2 = [];


		totalSelect = '';
		totalSelect2 = [];

		mesesSelect = '';
		mesesSelect2 = [];


		residencial = $('#filtro3').val();
		grupo = $('#filtro5').val();

		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});


		$('#filtro7 option:selected').each(function(){
			preciomSelect = $(this).val();
			preciomSelect2.push(preciomSelect);
		});


		$('#filtro8 option:selected').each(function(){
			totalSelect = $(this).val();
			totalSelect2.push(totalSelect);

		});


		$('#filtro9 option:selected').each(function(){
			mesesSelect = $(this).val();
			mesesSelect2.push(mesesSelect);

		});


		console.log(clusterSelect2);
		if(residencial > 0 && clusterSelect2.length > 0 && grupo <= 0 && preciomSelect2.length == 0 && totalSelect2.length == 0 && mesesSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getLotesInventarioGralc') ?>/"+residencial+'/'+clusterSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && grupo > 0 && preciomSelect2.length == 0 && totalSelect2.length == 0 && mesesSelect2.length == 0) {
			ruta = "<?= site_url('registroLote/getClusterGrupo')?>/"+residencial+'/'+clusterSelect2+'/'+grupo;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && preciomSelect2.length > 0 && totalSelect2.length == 0 && mesesSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getClusterPreciom')?>/"+residencial+'/'+clusterSelect2+'/'+preciomSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && totalSelect2.length > 0 && preciomSelect2.length == 0 && mesesSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getClusterTotal')?>/"+residencial+'/'+clusterSelect2+'/'+totalSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && mesesSelect2.length > 0 && preciomSelect2.length == 0 && totalSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getClusterMeses')?>/"+residencial+'/'+clusterSelect2+'/'+mesesSelect2;
		} else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}



		dataTable(ruta);


	});

	$('#filtro5').change(function(ruta){

		clusterSelect = '';
		clusterSelect2 = [];

		residencial = $('#filtro3').val();
		grupo = $('#filtro5').val();

		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});

		if(residencial > 0 && grupo > 0 && clusterSelect2.length == 0) {
			ruta = "<?= site_url('registroLote/getTwoGroup')?>/"+residencial+'/'+grupo;
		}
		else if (clusterSelect2.length > 0 && grupo > 0){
			ruta = "<?= site_url('registroLote/getOneGroup')?>/"+clusterSelect2+'/'+grupo;
		} else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}

		dataTable(ruta);

	});

	$('#filtro6').change(function(ruta){

		supSelect = '';
		supSelect2 = [];

		clusterSelect = '';
		clusterSelect2 = [];

		residencial = $('#filtro3').val();
		grupo = $('#filtro5').val();

		$('#filtro6 option:selected').each(function(){
			supSelect = $(this).val();
			supSelect2.push(supSelect);

		});


		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});

		if(residencial > 0 && clusterSelect2.length == 0 && supSelect2.length > 0 && grupo == null){
			ruta = "<?= site_url('registroLote/getSup')?>/"+residencial+'/'+supSelect2;
		} else if(residencial > 0 && clusterSelect2.length > 0 && supSelect2.length > 0 && grupo == null){
			ruta = "<?= site_url('registroLote/getSupTwo')?>/"+residencial+'/'+clusterSelect2+'/'+supSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && supSelect2.length > 0 && grupo > 0){
			ruta = "<?= site_url('registroLote/getSupTwo')?>/"+residencial+'/'+clusterSelect2+'/'+supSelect2+'/'+grupo;
		}


		else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}

		dataTable(ruta);

	});

	$('#filtro7').change(function(ruta){

		clusterSelect = '';
		clusterSelect2 = [];

		preciomSelect = '';
		preciomSelect2 = [];


		residencial = $('#filtro3').val();


		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});

		$('#filtro7 option:selected').each(function(){
			preciomSelect = $(this).val();
			preciomSelect2.push(preciomSelect);

		});

		if(residencial > 0 && preciomSelect2.length > 0){
			ruta = "<?= site_url('registroLote/getPreciomResidencial')?>/"+residencial+'/'+preciomSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && preciomSelect2.length > 0){
			ruta = "<?= site_url('registroLote/getPreciomCluster')?>/"+residencial+'/'+clusterSelect2+'/'+preciomSelect2;
		} else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}

		dataTable(ruta);

	});

	$('#filtro8').change(function(ruta){

		clusterSelect = '';
		clusterSelect2 = [];

		totalSelect = '';
		totalSelect2 = [];

		residencial = $('#filtro3').val();


		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});

		$('#filtro8 option:selected').each(function(){
			totalSelect = $(this).val();
			totalSelect2.push(totalSelect);

		});

		if(residencial > 0 && totalSelect2.length > 0 && clusterSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getPreciotResidencial')?>/"+residencial+'/'+totalSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && totalSelect2.length > 0){
			ruta = "<?= site_url('registroLote/getPreciotCluster')?>/"+residencial+'/'+clusterSelect2+'/'+totalSelect2;
		} else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}

		dataTable(ruta);

	});

	$('#filtro9').change(function(ruta){

		clusterSelect = '';
		clusterSelect2 = [];

		mesesSelect = '';
		mesesSelect2 = [];

		residencial = $('#filtro3').val();


		$('#filtro4 option:selected').each(function(){
			clusterSelect = $(this).val();
			clusterSelect2.push(clusterSelect);

		});

		$('#filtro9 option:selected').each(function(){
			mesesSelect = $(this).val();
			mesesSelect2.push(mesesSelect);

		});

		if(residencial > 0 && mesesSelect2.length > 0 && clusterSelect2.length == 0){
			ruta = "<?= site_url('registroLote/getMesesResidencial')?>/"+residencial+'/'+mesesSelect2;
		}
		else if(residencial > 0 && clusterSelect2.length > 0 && mesesSelect2.length > 0){
			ruta = "<?= site_url('registroLote/getMesesCluster')?>/"+residencial+'/'+clusterSelect2+'/'+mesesSelect2;
		} else{
			ruta = "<?= site_url('registroLote/getEmpy')?>/";
		}

		dataTable(ruta);

	});


	function dataTable(ruta) {
		var table = $('#addExp').DataTable({
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			dom: 'Bfrtip',
			"buttons": [
				{extend: 'excel',
					exportOptions: {
						columns: ':visible' } } ,
				{extend: 'pdfHtml5',
					text: 'PDF',
					exportOptions: {
						columns: ':visible'} },
				{extend: 'copyHtml5',
					text: 'Copiar',
					exportOptions: {
						columns: ':visible'}},
			],
			destroy: true,
			columns: [
				{ data: 'nombreResidencial' },
				{ data: 'nombreCondominio' },
				{ data: 'nombreLote' },
				{ data: 'sup' },
				{ data: function(data){return "$ " + alerts.number_format(data.precio, '2', '.', ',')} },
				{ data: function(data){return "$ " + alerts.number_format(data.total, '2', '.', ',')} },
				{ data: 'mesesn' }
			],
			"ajax": {
				"url": ruta,
				"dataSrc": "",
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.proyecto = $('#empresa').val();
					d.idproyecto = $('#proyecto').val();
				}
			},
		});
	}

</script>

</html>
