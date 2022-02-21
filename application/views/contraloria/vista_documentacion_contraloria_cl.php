
<body class="">
<div class="wrapper ">
	<?php
	//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar

	if($this->session->userdata('id_rol')=="6" || $this->session->userdata('id_rol')=="4" || $this->session->userdata('id_rol')=="9" || $this->session->userdata('id_rol') == 5)//ventasAsistentes
	{
		/*-------------------------------------------------------*/
$datos = array();
	$datos = $datos4;
	$datos = $datos2;
	$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
	
	} else {
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	}

    ?>
	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">

			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<!--						<h3>DOCUMENTACIÓN</h3>-->
					</center>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content">
							<h4 class="card-title" style="text-align: center">Asignación de ventas</h4>
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Proyecto:</label><br>
									<select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
										<?php

										if($residencial != NULL) :

											foreach($residencial as $fila) : ?>
												<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
											<?php endforeach;

										endif;

										?>
									</select>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Condominio:</label><br>
									<select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Lote:</label><br>
									<select id="filtro5" name="filtro5" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Lote" data-size="7"></select>
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
										<table id="tableDoct" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th class="text-center">Proyecto</th>
												<th class="text-center">Condominio</th>
												<th class="text-center">Lote</th>
												<th class="text-center">Cliente</th>
												<th class="text-center">Asesor</th>
												<th class="text-center">Coordinador</th>
												<th class="text-center">Gerente</th>
												<th class="text-center">Acción</th>
											</tr>
											</thead>

										</table>

                                        <div class="modal fade" id="myReAsignModalVentas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                            <i class="material-icons">clear</i>
                                                        </button>
                                                        <h4 class="modal-title">¿A quién asignarás a este prospecto?</h4>
                                                    </div>
                                                    <form id="my_reasign_form_ve" name="my_reasign_form_ve" method="post">
                                                        <div class="col-lg-12 form-group">
                                                            <label>Gerente</label>
                                                            <select class="selectpicker" name="id_gerente" id="myselectgerente2" data-live-search="true" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required></select>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>Coordinador</label>
                                                            <select class="selectpicker" name="id_coordinador" id="myselectcoordinador" data-live-search="true" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required></select>
                                                        </div>
                                                        <div class="col-lg-12 form-group">
                                                            <label>Asesor</label>
                                                            <select class="selectpicker" name="id_asesor" id="myselectasesor3" data-live-search="true" data-style="select-with-transition" title="Seleccione una opción" data-size="7" required></select>
                                                        </div>
                                                        <input type="hidden" name="id_cliente" id="id_cliente">
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Aceptar</button>
                                                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                                        </div>
                                                    </form>
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
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>
<script>
	$(document).ready (function() {
        $("#myselectgerente2").empty().selectpicker('refresh');

        $.post('getManagersVentas', function(data) {
            $("#myselectgerente2").append($('<option disabled>').val("default").text("Seleccione una opción"));
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'];
                var sede = data[i]['id_sede'];
                $("#myselectgerente2").append($('<option>').val(id).attr('data-sede', sede).text(name));
            }
            if(len<=0)
            {
                $("#myselectgerente2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#myselectgerente2").selectpicker('refresh');
        }, 'json');


        $.post('getCoordinatorsVentas', function(data) {
            $("#myselectcoordinador").append($('<option disabled>').val("default").text("Seleccione una opción"));
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'];
                var sede = data[i]['id_sede'];
                $("#myselectcoordinador").append($('<option>').val(id).attr('data-sede', sede).text(name));
            }
            if(len<=0)
            {
                $("#myselectcoordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#myselectcoordinador").selectpicker('refresh');
        }, 'json');


        $.post('getAdvisersVentas', function(data) {
            $("#myselectasesor3").append($('<option disabled>').val("default").text("Seleccione una opción"));
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'];
                var sede = data[i]['id_sede'];
                $("#myselectasesor3").append($('<option>').val(id).attr('data-sede', sede).text(name));
            }
            if(len<=0)
            {
                $("#myselectasesor3").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#myselectasesor3").selectpicker('refresh');
        }, 'json');


        $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
			var input = $(this).closest('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			if (input.length) {
				input.val(log);
			} else {
				if (log) alert(log);
			}
		});


		$(document).on('change', '.btn-file :file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
			console.log('triggered');
		});



		$('#filtro3').change(function(){

			var valorSeleccionado = $(this).val();

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


		$('#filtro4').change(function(){
			var residencial = $('#filtro3').val();
			var valorSeleccionado = $(this).val();
			// console.log(valorSeleccionado);
			//$('#filtro5').load("<?//= site_url('registroCliente/getLotesAll') ?>///"+valorSeleccionado+'/'+residencial);
			$("#filtro5").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroCliente/getLotesAll_CL/'+valorSeleccionado,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idLote'];
						var name = response[i]['nombreLote'];
						$("#filtro5").append($('<option>').val(id).text(name));
					}
					$("#filtro5").selectpicker('refresh');

				}
			});
		});

		$('#filtro5').change(function(){

			var valorSeleccionado = $(this).val();

			console.log(valorSeleccionado);
			$clientsDT = $('#tableDoct').DataTable({
				destroy: true,
				lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
				"ajax":
					{
						"url": '<?=base_url()?>index.php/registroCliente/expedientesWS_CL/'+valorSeleccionado,
						"dataSrc": ""
					},
				"dom": "Bfrtip",
                "ordering": false,
				"buttons": [
					{
						extend: 'copyHtml5',
						text: '<i class="fa fa-files-o"></i>',
						titleAttr: 'Copy'
					},
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'csvHtml5',
						text: '<i class="fa fa-file-text-o"></i>',
						titleAttr: 'CSV'
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="fa fa-file-pdf-o"></i>',
						titleAttr: 'PDF',
						orientation: 'landscape',
						pageSize: 'LEGAL'
					}
				],
				"language":{ "url": "<?=base_url()?>/static/spanishLoader.json"},
				"columns":
					[

						{data: 'nombreResidencial'},
						{data: 'nombre'},
						{data: 'nombreLote'},
						{
							data: null,
							render: function ( data, type, row )
							{
								return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
							},
						},
                        {data: 'asesor'},
                        {data: 'coordinador'},
                        {data: 'gerente'},
						{
							data: null,
							render: function ( data, type, row )
							{
                                file = '<a class="btn btn-primary btn-round btn-fab btn-fab-mini re-asign" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Asignar cliente"><i class="material-icons">supervisor_account</i></a>';
								return file;
							}
						}
					]
			});

		});

	});/*document Ready*/

    $(document).on('click', '.re-asign', function(e){
        id_cliente = $(this).attr("data-idc");
        console.log(id_cliente);
        $("#id_cliente").val(id_cliente);
        $("#myReAsignModalVentas").modal();
    });

    $("#my_reasign_form_ve").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'reasignClient',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    $('#myReAsignModalVentas').modal("hide");
                    $clientsDT.ajax.reload();
                    $("#myselectasesor3").val("");
                    $("#myselectcoordinador").val("");
                    $("#myselectgerente2").val("");
                    $("#myselectasesor3").selectpicker('refresh');
                    $("#myselectcoordinador").selectpicker('refresh');
                    $("#myselectgerente2").selectpicker('refresh');
                    alerts.showNotification("top", "right", "La asignación se ha llevado a cabo correctamente.", "success");
                } else {
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

</script>

