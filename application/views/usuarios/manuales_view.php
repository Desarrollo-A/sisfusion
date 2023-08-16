<body>
<div class="wrapper">

	<?php $this->load->view('template/sidebar'); ?>



	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content">
							<h4 class="card-title">Manuales</h4><br><br>
							<div class="row">
								<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div id="msg"></div>
									<div class="nav-center">
										<ul class="nav nav-tabs" role="tablist" id="navbartabs">
											<!--<li class="active" style="margin-right: 50px;">
												<a href="#nuevas-1" role="tab" data-toggle="tab">
													<strong>1 </strong> Nuevas
												</a>
											</li>
											<li style="margin-right: 50px;">
												<a href="#proceso-1" role="tab" data-toggle="tab">
													<strong>2 </strong> EN REVISIÓN
												</a>
											</li>-->
										</ul>
									</div>
									<div class="tab-content" id="paneles-tabs">

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
	$(document).ready(function () {
		$.post('<?=base_url()?>index.php/asesor/getAllFoldersManual',  function(data) {
			if(data.length > 0)
			{
				for(var i=0; i < data.length; i++)
				{
					var classActive = (data[i]['id_archivo'] == 1) ? 'active' : '';

					//construte las tabs para navegar en tabs
					var html_code = '<li class="'+classActive+' "style="margin-right: 50px;">';
						html_code += '	<a href="#carpeta'+(i+1)+'" role="tab" data-toggle="tab">';
						html_code += '		<strong>'+ (i+1) +'- </strong> '+  data[i]['nombre'];
						html_code += '	</a>';
						html_code += '</li>';
					$('#navbartabs').append(html_code);
					//console.log(html_code);


					//codigo embebido del PDF
					var url_file = '<?=base_url()?>static/documentos/manuales/'+data[i]['archivo'];
					var embebed_code = '<embed src="'+url_file+'#toolbar=0" frameborder="0" width="100%" height="770em">';


					//construye los contenedores de las tabs
					var html_contenedor_tabs = '';
					html_contenedor_tabs += '<div class="tab-pane '+classActive+'" id="carpeta'+(i+1)+'">';
					html_contenedor_tabs += '	<div class="content">';
					html_contenedor_tabs += '		<div class="container-fluid">';
					html_contenedor_tabs += '			<div class="row">';
					html_contenedor_tabs += '				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					html_contenedor_tabs += '					<h3>'+ data[i]['nombre'] +'</h3>';
					html_contenedor_tabs += '					'+embebed_code;
					html_contenedor_tabs += '				</div>';
					html_contenedor_tabs += '			</div>';
					html_contenedor_tabs += '		</div>';
					html_contenedor_tabs += '	</div>';
					html_contenedor_tabs += '</div>';


					$('#paneles-tabs').append(html_contenedor_tabs);

				}
				//console.log(data);
			}
			else
			{
				$('#msg').append('<center><h2 style="color: #a0a0a0;font-weight: 100">No hay Carpetas disponibles</h2></center>');
			}
		}, 'json');
	});
</script>
