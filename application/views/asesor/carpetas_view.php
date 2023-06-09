<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<body>
	<div class="wrapper">

		<?php
		if ($this->session->userdata('id_rol') == "7" || $this->session->userdata('id_rol') == "9") //contratacion
		{
		$this->load->view('template/sidebar');
		}
		else {
			echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		}
		?>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-folder-open fa-2x"></i>
							</div>
							<div class="card-content">
								<h4 class="card-title">Carpetas</h4><br><br>
								<div class="row">
									<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div id="msg"></div>
										<div class="toolbar">
											<div role="tablist" id="navbartabs">
												<select id="test" class="selectpicker select-gral" data-container="body" data-style="btn-new" title="CARPETAS" data-size="9">
												</select>
											</div>
										</div>
										<div class="tab-content" id="paneles-tabs"></div>
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


	<script>
		$(document).ready(function () {
			$.post('<?=base_url()?>index.php/asesor/getAllFoldersPDF',  function(data) {
				if(data.length > 0){
					$('#navbartabs').find('#test').empty().selectpicker('refresh');

					for(var i=0; i < data.length; i++){
						var classActive = (data[i]['id_archivo'] == 1) ? 'active' : '';
						var html_code = '';
						html_code += '<option value="'+data[i]['archivo']+'"> <strong>' + data[i]['nombre'] + '</strong></option>'
						$('#navbartabs').find('#test').append(html_code);
					}
					$('#navbartabs').find('#test').selectpicker('refresh');

					$('select').on('change', function() {
						var value = this.value;
						console.log(value);
						//codigo embebido del PDF
						var url_file = '<?=base_url()?>static/documentos/carpetas/'+value;
						var embebed_code = '<embed src="'+url_file+'#toolbar=0" frameborder="0" width="100%" height="770em">';

						//construye los contenedores de las tabs
						var html_contenedor_tabs = '';
						html_contenedor_tabs += '	<div class="content">';
						html_contenedor_tabs += '		<div class="container-fluid">';
						html_contenedor_tabs += '			<div class="row">';
						html_contenedor_tabs += '				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						html_contenedor_tabs += '					'+embebed_code;
						html_contenedor_tabs += '				</div>';
						html_contenedor_tabs += '			</div>';
						html_contenedor_tabs += '		</div>';
						html_contenedor_tabs += '	</div>';

						$('#paneles-tabs').html(html_contenedor_tabs);
						});
				}
				else
				{
					$('#msg').append('<center><h2 style="color: #a0a0a0;font-weight: 100">No hay Carpetas disponibles</h2></center>');
				}
			}, 'json');
		});
	</script>
</body>