<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<!-- Modals -->
		<div class="modal fade" id="addFile" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="file_msni" id="file_msni" style="display: none;">
								</span>
							</label>
							<input type="text" class="form-control" id= "txtexp" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="sendFile" class="btn btn-primary"><span
								class="material-icons" >send</span> Actualizar M/S </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END Modals -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-box fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align" >Meses sin intereses</h3>
								<div class="toolbar">
									<div class="container-fluid p-0">
                                        <div class="row aligned-row d-flex align-end">
                                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <label style="font-size: small">Elije el modo para subir los meses sin interés:</label>
                                                </div>
                                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 pb-3">
                                                <div class="radio_container w-100">
                                                    <input class="d-none generate" type="radio" name="modoSubida" id="condominioM" checked value="1">
                                                    <label for="condominioM" class="w-50">Por Condominio</label>
                                                    <input class="d-none find-results" type="radio" name="modoSubida" id="loteM" value="0">
                                                    <label for="loteM" class="w-50">Por lote</label>
                                                </div>
                                            </div>
                                        </div>
										<div class="row aligned-row d-flex align-end">
											<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<label class="m-0" for="filtro3">Proyecto</label>
												<select name="filtro3" id="filtro3" class="selectpicker select-gral mb-0"
                                                        data-show-subtext="true" data-live-search="true"  data-style="btn"
                                                        onchange="changeCondominio()" title="Selecciona Proyecto" data-size="7" required>
													<?php
													if($residencial != NULL) :
														foreach($residencial as $fila) : ?>
															<option value= <?=$fila['idResidencial']?> data-nombre='<?=$fila['nombreResidencial']?>' style="text-transform: uppercase"> <?=$fila['descripcion']?> </option>
														<?php endforeach;
													endif;
													?>
												</select>
											</div>
                                            <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4 hide" id="contenedor-condominio">
                                                <label class="m-0" for="filtro4">Condominio</label>
                                                <select name="filtro4" id="filtro4" class="selectpicker select-gral mb-0"
                                                        data-show-subtext="true" data-live-search="true"  data-style="btn"
                                                        title="Selecciona Proyecto" data-size="7" required onChange="loadLotes()">
                                                </select>
                                            </div>
                                            <input id="typeTransaction" type="hidden" value="1">
											<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4 mt-2">
												<button type="button" id="loadFile" class="btn-data-gral btn-success d-flex justify-center align-center">Cargar información<i class="fas fa-paper-plane pl-1"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="material-datatables">
								<div class="form-group">
                                        <div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_msni" name="tabla_msni_name">
												<thead>
													<tr>
														<th>ID</th>
														<th>NOMBRE</th>
														<th>MSNI</th>
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
	<?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

	<script>

        var tablaMsi;
		$(document).ready (function() {
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

            $('input[type=radio][name=modoSubida]').change(function() {
                if (this.value == 1) {
                    //se queda asi ta cual
                    //se debe mostrar el proyecto nomás
                    $('#contenedor-condominio').addClass('hide');
                    $('#filtro3').attr('onChange', 'changeCondominio()');
                    $('#filtro3').val('default').selectpicker('deselectAll');
                    $('#filtro3').selectpicker('refresh');
                    $('#filtro4').empty();
                    $('#filtro4').selectpicker('refresh');
                    $('#tabla_msni').DataTable().clear().destroy();
                    $('#typeTransaction').val(this.value);
                }
                else if (this.value == 0) {
                    //se debe mostrar el proyecto y condominio nomás
                    $('#contenedor-condominio').removeClass('hide');
                    $('#filtro3').attr('onChange', 'changeLote()');
                    $('#filtro3').val('default').selectpicker('deselectAll');
                    $('#filtro3').selectpicker('refresh');
                    $('#tabla_msni').DataTable().clear().destroy();
                    $('#typeTransaction').val(this.value);

                }
            });






		});

        //cosas del archivo
        async function processFile(selectedFile) {
            try {
                let arrayBuffer = await readFileAsync(selectedFile);
                return arrayBuffer;
            } catch (err) {
                console.log(err);
            }
        }

        function readFileAsync(selectedFile) {
            return new Promise((resolve, reject) => {
                let fileReader = new FileReader();
                fileReader.onload = function (event) {
                    var data = event.target.result;
                    var workbook = XLSX.read(data, {
                        type: "binary",
                        cellDates:true,
                    });
                    workbook.SheetNames.forEach(sheet => {
                        rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet], {defval: '', blankrows: true});
                        jsonProspectos = JSON.stringify(rowObject, null);
                    });
                    resolve(jsonProspectos);
                };
                fileReader.onerror = reject;
                fileReader.readAsArrayBuffer(selectedFile);
            })
        }
        function validateExtension(extension, allowedExtensions) {
            let allowedExtensionsArray = allowedExtensions.split(", ");
            let flag = false;
            for (let i = 0; i < allowedExtensionsArray.length; i++) {
                if (allowedExtensionsArray[i] == extension)
                    flag = true;
            }
            return flag;
        }
		$('#tabla_msni thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			$(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
			$( 'input', this ).on('keyup change', function () {
				if ($('#tabla_msni').DataTable().column(i).search() !== this.value ){
					$('#tabla_msni').DataTable()
					.column(i)
					.search(this.value)
					.draw();
				}
			}); 
        });

		var getInfo3 = new Array(1);
		$(document).on("click", "#loadFile", function(e){

			var res = $('#filtro3').val();
			var validares = ($("#filtro3").val().length == 0) ? 0 : 1;
			if (validares == 0) {
				alerts.showNotification("top", "right", "Seleccione el proyecto.", "danger");
			} else {
				getInfo3[0] = res;
				$('#addFile').modal('show');
			}
		});


		$(document).on('click', '#sendFile', function(e) {
			var idproy = getInfo3[0];

			var file_msni = $("#file_msni")[0].files[0];
            fileElm = document.getElementById("file_msni");
            file = fileElm.value;

            console.log('file:', file);

			var validaFile = (file_msni == undefined) ? 0 : 1;
			var dataFile = new FormData();





			if (validaFile == 0) {
				alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
			}

			if (validaFile == 1) {
                let extension = file.substring(file.lastIndexOf("."));
                let statusValidateExtension = validateExtension(extension, ".xlsx");
                let statusValidateExtension2 = validateExtension(extension, ".csv");
                if (statusValidateExtension == true || statusValidateExtension2==true) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
                    processFile(fileElm.files[0]).then(jsonInfo => {
                        dataFile.append("idResidencial", idproy);
                        dataFile.append("file_msni", jsonInfo);
                        dataFile.append("typeTransaction", $('#typeTransaction').val());
                        console.log('process data: ', jsonInfo);
                        $('#sendFile').prop('disabled', true);
                        $.ajax({
                            url: "<?=base_url()?>index.php/Contraloria/update_msni",
                            data: dataFile,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success : function (response) {
                                response = JSON.parse(response);
                                if(response.message == 'OK') {
                                    alerts.showNotification('top', 'right', '¡Información registrada!', 'success');
                                    $('#sendFile').prop('disabled', false);
                                    $('#addFile').modal('hide');
                                    $("#filtro3").selectpicker('refresh');
                                    $('#tabla_msni').DataTable().ajax.reload();
                                } else if(response.message == 'FALSE'){
                                    alerts.showNotification('top', 'right', '¡Error al enviar la solicitud!', 'danger');
                                    $('#sendFile').prop('disabled', false);
                                    $('#addFile').modal('hide');
                                    $("#filtro3").selectpicker('refresh');
                                    $('#tabla_msni').DataTable().ajax.reload();
                                }
                            }
                        });
                    });
                }


			}
		});

		function changeCondominio(){
            var idProyecto = $('#filtro3').val();
            var data = new Array();
            var nombreProyecto = $('#filtro3 option:selected').attr('data-nombre');
            //1: busqueda por proyecto
            //2: busqueda por lote
            let typeBusqueda = 1;
            data["tb"] = 1;
            data["url"] = '<?=base_url()?>index.php/Contraloria/getMsni/'+typeBusqueda+'/'+idProyecto;
            data["tituloArchivo"] = 'Plantilla del residencial-'+nombreProyecto;
            loadTable(data);
        }
        function changeLote(){
            $('#filtro4').empty();
            $('#filtro4').selectpicker('refresh');
            console.log('se deben cargar los condominios');
            var idProyecto = $('#filtro3').val();
            console.log('idProyecto', idProyecto);
            $.ajax({
                url: '<?=base_url()?>General/getCondominiosList',
                type: 'post',
                dataType: 'json',
                data: {"idResidencial": idProyecto},
                success: function(data) {
                    console.log('success', data);
                    data.map((element, index)=>{
                        $("#filtro4").append($('<option data-nombre="'+element.nombre+'">').val(element.idCondominio).text(element.nombre));
                        $("#filtro4").selectpicker('refresh');
                    });
                },
                error: function() {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
        function loadLotes(){
		    console.log('load lotes');
            var idCondominio = $('#filtro4').val();
            var data = new Array();
            //1: busqueda por proyecto
            //2: busqueda por lote
            var nombreCondominio = $('#filtro4 option:selected').attr('data-nombre');
            let typeBusqueda = 2;
            data["tb"] = 2;
            data["url"] = '<?=base_url()?>index.php/Contraloria/getMsni/'+typeBusqueda+'/'+idCondominio;
            data["tituloArchivo"] = 'Plantilla del condominio-'+nombreCondominio;
            loadTable(data);
        }
        function loadTable(dataVariable){
            tablaMsi = $('#tabla_msni').DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    className: 'btn buttons-excel',
                    text: 'DESCARGAR PLANTILLA',
                    extend: 'csvHtml5',
                    titleAttr: 'CSV',
                    title:dataVariable['tituloArchivo'],
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            header:  function (d, columnIdx) {

                                if(dataVariable['tb']==1){
                                    if(columnIdx == 0) {
                                        return 'ID';
                                    } else if(columnIdx == 1){
                                        return 'CONDOMINIO';
                                    }else if(columnIdx == 2){
                                        return 'MSNI';
                                    }
                                }else if(dataVariable['tb']==2){
                                    if(columnIdx == 0){
                                        return 'ID';
                                    }else if(columnIdx == 1){
                                        return 'LOTE';
                                    }else if(columnIdx == 2){
                                        return 'MSNI';
                                    }
                                }

                            }
                        }
                    },
                }],
                ajax: {
                    "url": dataVariable['url'],
                    "dataSrc": ""
                },
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [
                    {
                        data: 'ID'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'msni'
                    }
                ]
            })

            if(dataVariable['tb']==1){
                tablaMsi.columns([2]).visible(false);
            }
        }

	jQuery(document).ready(function(){
		jQuery('#addFile').on('hidden.bs.modal', function (e) {
			jQuery(this).removeData('bs.modal');
			jQuery(this).find('#file_msni').val('');
			jQuery(this).find('#txtexp').val('');
		})
	})
	</script>
</body>