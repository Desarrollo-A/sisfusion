<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

	<?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <?php if($this->session->userdata('id_rol') != 19){?>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Subdirector</label>
                                                <select name="subDir" id="subDir"
                                                        class="selectpicker select-gral m-0"
                                                        data-show-subtext="true"
                                                        data-live-search="true"
                                                        data-style="btn"
                                                        title="Selecciona subdirector" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Gerente</label>
                                            <select name="gerente" id="gerente"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn"
                                                    title="Selecciona gerente" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4" id="filter_date">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="prospects-datatable_dir"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>ESTADO</th>
                                            <th>ETAPA</th>
                                            <th>NOMBRE</th>
                                            <th>ASESOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>CREACIÓN</th>
                                            <th>VENCIMIENTO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <?php include 'common_modals.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="content hide">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block full">
						<div class="row">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">list</i>
									</div>
									<div class="card-content">
										<div class="row">
											<h4 class="card-title">Listado general de prospectos</h4>
											<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<?php if($this->session->userdata('id_rol') != 19){?>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="subDir" id="subDir" class="selectpicker"
															data-style="btn " title="SUBDIRECTOR" data-size="7">
													</select>
												</div>
												<?php } ?>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="gerente" id="gerente" class="selectpicker"
															data-style="btn " title="GERENTE" data-size="7">
													</select>
												</div>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<label id="external_filter_container18">Búsqueda por Fecha</label>
													<!--<div id="external_filter_container18"><B> Búsqueda por Fecha </B></div>-->
													<br>
													<div id="external_filter_container7"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="card">
									<!--<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">list</i>
									</div>-->
									<div class="card-content">
										<div class="row">
											<!--<h4 class="card-title">Listado general de prospectos</h4>-->
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="prospects-datatable_dir" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
														<thead>
														<tr>
															<th class="disabled-sorting text-right"><center>Estado</center></th>
															<th class="disabled-sorting text-right"><center>Etapa</center></th>
															<th class="disabled-sorting text-right"><center>Nombre</center></th>
															<th class="disabled-sorting text-right"><center>Asesor</center></th>
															<th class="disabled-sorting text-right"><center>Gerente</center></th>
															<th class="disabled-sorting text-right"><center>Subdirector</center></th>
															<th class="disabled-sorting text-right"><center>Creación</center></th>
															<th class="disabled-sorting text-right"><center>Vencimiento</center></th>
															<th class="disabled-sorting text-right"><center>Acciones</center></th>
														</tr>
														</thead>
														<tbody>
														</tbody>

													</table>

													<?php include 'common_modals.php' ?>

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
<!--<script src="--><?//=base_url()?><!--dist/js/jquery.validate.js"></script>-->
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script>
	userType = <?= $this->session->userdata('id_rol') ?>;
	typeTransaction = 1;
</script>
<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
<script>

    $('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
        if (i != 8) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
                    $('#prospects-datatable_dir').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });


	$(document).ready(function () {

		/*primera carga*/
        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();

		<?php if($this->session->userdata('id_rol') == 18){?>
		$("#subDir").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
		$.post('<?=base_url()?>index.php/Clientes/getSubdirs_mkt/', function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_usuario'];
				var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
				$("#subDir").append($('<option>').val(id).text(name));
			}
			if(len<=0)
			{
				$("#subDir").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
			}
			$("#subDir").selectpicker('refresh');
		}, 'json');

		<?php }
		elseif ($this->session->userdata('id_rol') == 19){?>
			var subdir = '<?=$this->session->userdata("id_usuario")?>';
			console.log(subdir);

			//gerente

			$("#gerente").empty().selectpicker('refresh');
			$("#coordinador").empty().selectpicker('refresh');
			$("#asesores").empty().selectpicker('refresh');
			$.post('<?=base_url()?>index.php/Clientes/getGerentesBySubdir_mkt/'+subdir, function(data) {
				var len = data.length;
				for( var i = 0; i<len; i++)
				{
					var id = data[i]['id_usuario'];
					var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
					$("#gerente").append($('<option>').val(id).text(name));
				}
				if(len<=0)
				{
					$("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
				}
				$("#gerente").selectpicker('refresh');
			}, 'json');


			/*carga la tabla*/
			var url = '<?=base_url()?>index.php/clientes/getProspectsListByGerente/'+subdir;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0)
		<?php }?>

        $('#spiner-loader').addClass('hide');

	});

    sp = { //  SELECT PICKER
        initFormExtendedDatetimepickers: function () {
            $('.datepicker').datetimepicker({
                format: 'MM/DD/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove',
                    inline: true
                }
            });
        }
    }
    function setInitialValues() {
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
        finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
        // console.log('Fecha inicio: ', finalBeginDate);
        // console.log('Fecha final: ', finalEndDate);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        // fillTable(1, finalBeginDate, finalEndDate, 0);
    }

	<?php if($this->session->userdata('id_rol') != 19){?>
		$('#subDir').on('change', function () {
		var subdir = $("#subDir").val();
		//console.log('Elegiste: ' + subdir);

		//gerente

		$("#gerente").empty().selectpicker('refresh');
		$("#coordinador").empty().selectpicker('refresh');
		$("#asesores").empty().selectpicker('refresh');
		$.post('<?=base_url()?>index.php/Clientes/getGerentesBySubdir_mkt/'+subdir, function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_usuario'];
				var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
				$("#gerente").append($('<option>').val(id).text(name));
			}
			if(len<=0)
			{
				$("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
			}
			$("#gerente").selectpicker('refresh');
		}, 'json');


		/*carga la tabla*/
		var url = '<?=base_url()?>index.php/clientes/getProspectsListByGerente/'+subdir;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
		updateTable(url, 1, finalBeginDate, finalEndDate, 0)
	});
	<?php } ?>

	$('#gerente').on('change', function () {

		/**/var gerente = $("#gerente").val();
		//console.log('Elegiste: ' + gerente);

		/**///carga tabla
		var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+gerente;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
	});


    $(document).on("click", "#searchByDateRange", function () {
        var gerente = $("#gerente").val();
        <?php if($this->session->userdata('id_rol') == 19){?>
            if(gerente!=''){
                let finalBeginDate = $("#beginDate").val();
                let finalEndDate = $("#endDate").val();
                var gerente = $("#gerente").val();
                //console.log('Elegiste: ' + gerente);

                /**///carga tabla
                var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+gerente;

                updateTable(url, 3, finalBeginDate, finalEndDate, 0);
            }
            else{
                alerts.showNotification('top', 'right', 'Porfavor selecciona gerente', 'danger');
            }

        <?php }else{ ?>
                        var subdir = $('#subDir').val();
                        if(gerente=='' && subdir != ''){
                            /*carga la tabla*/
                            var url = '<?=base_url()?>index.php/clientes/getProspectsListByGerente/'+subdir;
                            let finalBeginDate = $("#beginDate").val();
                            let finalEndDate = $("#endDate").val();
                            updateTable(url, 1, finalBeginDate, finalEndDate, 0)
                        }else if(gerente!='' && subdir != ''){
                            let finalBeginDate = $("#beginDate").val();
                            let finalEndDate = $("#endDate").val();
                            var gerente = $("#gerente").val();
                            //console.log('Elegiste: ' + gerente);

                            /**///carga tabla
                            var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+gerente;

                            updateTable(url, 3, finalBeginDate, finalEndDate, 0);
                        }
        <?php    }    ?>

    });

	function updateTable(url, typeTransaction, beginDate, endDate, where)
	{
        console.log('url: ', url);
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);
		 prospectsTable = $('#prospects-datatable_dir').dataTable({
             dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
             "pagingType": "full_numbers",
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "Todos"]
			],
             "buttons": [
                 {
                     extend: 'excelHtml5',
                     text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                     className: 'btn buttons-excel',
                     titleAttr: 'Listado general de prospectos',
                     title:"Listado general de prospectos",
                     exportOptions: {
                         columns: [0,1,2,3,4,5,6,7],
                         format: {
                             header: function (d, columnIdx) {
                                 switch (columnIdx) {
                                     case 0:
                                         return 'ESTADO';
                                         break;
                                     case 1:
                                         return 'ETAPA';
                                         break;
                                     case 2:
                                         return 'PROSPECTO';
                                     case 3:
                                         return 'ASESOR';
                                         break;
                                     case 4:
                                         return 'GERENTE';
                                         break;
                                     case 5:
                                         return 'SUBDIRECTOR';
                                         break;
                                     case 6:
                                         return 'CREACIÓN';
                                         break;
                                     case 7:
                                         return 'VENCIMIENTO';
                                         break;
                                 }
                             }
                         }
                     }
                 }
             ],
            language: {
                 url: "<?=base_url()?>/static/spanishLoader_v2.json",
                 paginate: {
                     previous: "<i class='fa fa-angle-left'>",
                     next: "<i class='fa fa-angle-right'>"
                 }
             },
			ordering: false,
			destroy: true,
			columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
			columns: [
				{ data: function (d) {
						 if (d.estatus == 1) {
                    		return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
		                } else {
		                    return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
		                }
					}
				},
				{ data: function (d) {
                    
                        if(d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                    } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3){ // CON CITA
                        b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                    } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                        b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5){ // PAUSADO
                        b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                    } else if (d.estatus_particular == 6){ // PREVENTA
                        b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                    }
                    return b;
                    }    
             	},
				{ data: function (d) {
						return d.nombre;
					}
				},
				{ data: function (d) {
						return d.asesor;
					}
				},
				{ data: function (d) {
						return d.coordinador;
					}
				},
				{ data: function (d) {
						return d.gerente;
					}
				},
				{ data: function (d) {
						return d.fecha_creacion;
					}
				},
				{ data: function (d) {
						return d.fecha_vencimiento;
					}
				},
				{ data: function (d) {
                    if (d.estatus == 1) { // IS ACTIVE
                        var actions = '';
						var group_buttons = '';
						group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="fas fa-comment-alt"></i></button>' +
                                    '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                    '<button class=" btn-data btn-details-grey see-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;" rel="tooltip" data-placement="left" title="Ver información"><i class="fas fa-eye"></i></button>' +
                                    '<button class="btn-data btn-details-violet re-asign" data-id-prospecto="' + d.id_prospecto +'" rel="tooltip" data-placement="left" title="Re - asignar"><i class="fas fa-retweet"></i></button>';

						actions += '<center><button style="margin-right: 3px;" class="desplegable btn-data btn-details-grey" id="btn_'+d.id_prospecto+'" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').removeClass(\'hide\'); "><span class="fas fa-chevron-up"></span></button></center>';
						actions +=	'<center><div class="hide" id="cnt_'+d.id_prospecto+'">'+group_buttons+'<br><br><button style="margin-right: 3px;" onclick="javascript: $(\'#btn_'+d.id_prospecto+'\').removeClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').addClass(\'hide\'); " class="btn-data btn-details-grey" style="background-color: orangered"><i class="fas fa-chevron-down"></i></button></div></center>';
						actions +=	'<center><button class="btn-data btn-blueMaderas update-status" data-id-prospecto="' + d.id_prospecto +'"><i class="fas fa-redo" ></i></button></center>';
						actions += '<center><button class="btn-data btn-warning change-pl" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" rel="tooltip" data-placement="left" title="Remover MKTD de este prospecto"><i class="fas fa-trash"></i></button></center>';
						return actions;
                    } else { // IS NOT ACTIVE
                        var actions = '';
						var group_buttons = '';
						if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
							actions +=	'<button class="btn-data btn-warning update-validity" data-id-prospecto="' + d.id_prospecto +'" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="fas fa-redo"></i></button>';
						}
						return actions;
                    }
                }
            }
			],
			"ajax": {
				"url": url,
                "dataSrc": "",
                cache: false,
                "type": "POST",
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where
                }
			}
		})/*.yadcf(
			[
				{
					column_number: 6,
					filter_container_id: 'external_filter_container7',
					filter_type: 'range_date',
					datepicker_type: 'bootstrap-datetimepicker',
					filter_default_label: ['Desde', 'Hasta'],
					date_format: 'YYYY-MM-DD',
					filter_plugin_options: {
						format: 'YYYY-MM-DD',
						showClear: true,
					}
				},
			]
		)*/
	}


</script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
