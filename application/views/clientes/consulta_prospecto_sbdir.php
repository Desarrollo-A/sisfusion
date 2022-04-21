<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
	<?php //include 'sidebarParams_prospectsList.php'
/*-------------------------------------------------------*/
	$datos = array();
	$datos = $datos4;
	$datos = $datos2;
	$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
	 ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div id="filterContainer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">GERENTE</label>
                                                <select name="gerente" id="gerente" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona gerente" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">COORDINADOR</label>
                                                <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona coordinador" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">ASESOR</label>
                                                <select name="asesores" id="asesores" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona asesor" data-size="7" required>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
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
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="prospects-datatable_dir"  class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>LP</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
                                                <?php
                                                if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
                                                {?>
                                                    <th class="disabled-sorting text-right">ACCIONES</th>
                                                <?php } ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
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
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="gerente" id="gerente" class="selectpicker"
															data-style="btn " title="GERENTE" data-size="7">
													</select>
												</div>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="coordinador" id="coordinador" class="selectpicker"
															data-style="btn " title="COORDINADOR" data-size="7">
													</select>
												</div>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="asesores" id="asesores" class="selectpicker"
															data-style="btn " title="ASESOR" data-size="7">
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<div id="external_filter_container18"><B> Búsqueda por Fecha </B></div>
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
															<!--                                                                <th class="disabled-sorting text-right"></th>-->
                                                            <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                            <th class="disabled-sorting text-right"><center>Etapa</center></th>
															<th class="disabled-sorting text-right"><center>Prospecto</center></th>
															<th class="disabled-sorting text-right"><center>Asesor</center></th>
															<th class="disabled-sorting text-right"><center>Coordinador</center></th>
                                                            <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                            <th class="disabled-sorting text-right"><center>LP</center></th>
															<th class="disabled-sorting text-right"><center>Creación</center></th>
															<th class="disabled-sorting text-right"><center>Vencimiento</center></th>
															<?php
															if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
															{
															?>
																<th class="disabled-sorting text-right"><center>Acciones</center></th>
															<?php } ?>
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
<!--<script src="--><?php //base_url()?><!--dist/js/jquery.validate.js"></script>-->
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/moment.min.js"></script>

<script>
	userType = <?= $this->session->userdata('id_rol') ?> ;
	typeTransaction = 1;

    $('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
        if(i!=9){
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
                    $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
                }
            });
        }

    });




</script>

<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<?php
if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
{
?>

	<script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js"></script>
<?php
} ?>


<script>
	$(document).ready(function () {
        var subdir = '<?=$this->session->userdata("id_usuario")?>';

		var url_interna;
		/*primera carga*/
		// <?php
		// 	if($this->session->userdata('id_rol')==2)
		// 	{?>
		// 		var subdir = '<?=$this->session->userdata("id_usuario")?>';
		// 		 url_interna = '<?=base_url()?>index.php/Clientes/getGerentesBySubdir/'+subdir;
		// 	<?php
        // }
		// 	else{?>
		// 		 url_interna = '<?=base_url()?>index.php/Clientes/getGerentesBySubdir_ASB/';
		
        // <?php 
        //}
		?>
        //funcion para validar si tiene multirol
       multirol();
       
		//gerente
		



        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();
	});



    function multirol(){
        $.post('../General/multirol', function(data){
            let unique = [...new Set(data.map(item => item.idRol))]; //los roles unicos del usuario
            if(unique.includes(59) || unique.includes(60)){
                createFilters(59);
                getFirstFilter(59, 2);
            }else{
                createFilters(2);
                getFirstFilter(2, 3);
            }
        },'json');
    }

    function createFilters(rol){
        if(rol == 59){
            let div = '<div class="col-md-3 form-group"><div id="div1" class="form-group label-floating select-is-empty"><label class="control-label">SUBDIRECTOR</label></div></div>';
            div += '<div class="col-md-3 form-group"><div id="div2" class="form-group label-floating select-is-empty"><label class="control-label">GERENTE</label></div></div>';
            div += '<div class="col-md-3 form-group"><div id="div3" class="form-group label-floating select-is-empty"><label class="control-label">COORDINADOR</label></div></div>';
            div += '<div class="col-md-3 form-group"><div id="div4" class="form-group label-floating select-is-empty"><label class="control-label">ASESOR</label></div></div>';
            var $selectSub = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'subdirector',
                'name': 'subdirector',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el subdirector',
            'selected': true,
            'disabled': true
        }));
            var $selectGer = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'gerente',
                'name': 'gerente',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el gerente',
            'selected': true,
            'disabled': true
        }));
            var $selectCoord = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'coordinador',
                'name': 'coordinador',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el coordinador',
            'selected': true,
            'disabled': true
        }));
            var $selectAse = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'asesores',
                'name': 'asesores',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el asesor',
            'selected': true,
            'disabled': true
        }));
            $('#filterContainer').append(div);
            $selectSub.appendTo('#div1').selectpicker('refresh');
            $selectGer.appendTo('#div2').selectpicker('refresh');
            $selectCoord.appendTo('#div3').selectpicker('refresh');
            $selectAse.appendTo('#div4').selectpicker('refresh');
            // $option.appendTo('#asesores');

        }else if(2){ 
            let div = '<div class="col-md-3 form-group"><div id="div2" class="form-group label-floating select-is-empty"><label class="control-label">GERENTE</label></div></div>';
            div += '<div class="col-md-3 form-group"><div id="div3" class="form-group label-floating select-is-empty"><label class="control-label">COORDINADOR</label></div></div>';
            div += '<div class="col-md-3 form-group"><div id="div4" class="form-group label-floating select-is-empty"><label class="control-label">ASESOR</label></div></div>';
            
            var $selectGer = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'gerente',
                'name': 'gerente',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el gerente',
            'selected': true,
            'disabled': true
        }));
            var $selectCoord = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'coordinador',
                'name': 'coordinador',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el coordinador',
            'selected': true,
            'disabled': true
        }));
            var $selectAse = $('<select/>', {
                'class':"selectpicker select-gral m-0",
                'id': 'asesores',
                'name': 'asesores',
                'data-style':"btn",
                'data-show-subtext':"true",
                'data-live-search':"true"
            }).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el asesor',
            'selected': true,
            'disabled': true
        }));
            $('#filterContainer').append(div);
            $selectGer.appendTo('#div2').selectpicker('refresh');
            $selectCoord.appendTo('#div3').selectpicker('refresh');
            $selectAse.appendTo('#div4').selectpicker('refresh');
        }
    }

    function getFirstFilter(rol, secondRol){
        $(`#${rol == 59 ? 'subdirector':'gerente'}`).empty().selectpicker('refresh');
        // rol == 59 ? `Clientes/getGerentesBySubdir/${idUsuario}` : `General`
        var $option = $('<option/>',{
            'value': 'default',
            'text': 'Selecciona el subdirector',
            'selected': true,
            'disabled': true
        });
        $(`#${rol == 59 ? 'subdirector':'gerente'}`).append($option);
		$.post('../General/getUsersByLeader', {rol: rol, secondRol:secondRol},function(data) {
			var len = data.length;
            // console.log('users', data);
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_usuario'];
				var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
				$(`#${rol == 59 ? 'subdirector':'gerente'}`).append($('<option>').val(id).text(name));
			}
			if(len<=0){
				$(`#${rol == 59 ? 'subdirector':'gerente'}`).append('<option selected="selected" disabled>NINGÚN GERENTE</option>');
			}
			$(`#${rol == 59 ? 'subdirector':'gerente'}`).selectpicker('refresh');
		}, 'json');
    }
    
    $(document).on('change', '#subdirector',function () {
        /**/
        var subdirector = $("#subdirector").val();
        console.log('Elegiste: ', subdirector);

        $("#gerente").empty().selectpicker('refresh');
        $("#coordinador").empty().selectpicker('refresh');
       
        $(`#gerente`).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el gerente',
            'selected': true,
            'disabled': true
        }));
        $(`#coordinador`).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el coordinador',
            'selected': true,
            'disabled': true
        }));
        $(`#asesores`).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el asesor',
            'selected': true,
            'disabled': true
        }));
        $("#coordinador").selectpicker('refresh');
        $("#asesores").selectpicker('refresh');

        $.post('<?=base_url()?>index.php/Clientes/getGrsBySub/' + subdirector, function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#gerente").append($('<option>').val(id).text(name));
            }
            if (len <= 0) {
                $("#gerente").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
            }
            $("#gerente").selectpicker('refresh');
        }, 'json');

        /**/ //carga tabla
        var url = "<?=base_url()?>index.php/Clientes/getProspectsListBySubdirector/" + subdirector;
        /*console.log("TypeTRans: " + typeTransaction);
        updateTable(url, typeTransaction);*/
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
    });


	$(document).on('change','#gerente', function () {

		/**/var gerente = $("#gerente").val();
		console.log('Elegiste: ' + gerente);

		$("#coordinador").empty().selectpicker('refresh');
		$("#asesores").empty().selectpicker('refresh');
       
        $(`#coordinador`).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el coordinador',
            'selected': true,
            'disabled': true
        }));
        $(`#asesores`).append($('<option/>',{
            'value': 'default',
            'text': 'Selecciona el asesor',
            'selected': true,
            'disabled': true
        }));
        $("#asesores").selectpicker('refresh');

		$.post('<?=base_url()?>index.php/Clientes/getCoordsByGrs/'+gerente, function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_usuario'];
				var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
				$("#coordinador").append($('<option>').val(id).text(name));
			}
			if(len<=0)
			{
				$("#coordinador").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
			}
			$("#coordinador").selectpicker('refresh');
		}, 'json');



		/**///carga tabla
		var url = "<?=base_url()?>index.php/Clientes/getProspectsListByGerente/"+gerente;
		/*console.log("TypeTRans: " + typeTransaction);
		updateTable(url, typeTransaction);*/
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
	});

	$(document).on('change', '#coordinador', function () {
		var coordinador = $("#coordinador").val();
		console.log('Elegiste: ' + coordinador);

		//gerente
		$("#asesores").empty().selectpicker('refresh');
        var $option = $('<option/>',{
            'value': 'default',
            'text': 'Selecciona el coordinador',
            'selected': true,
            'disabled': true
        });
        $(`#asesores`).append($option);
		$.post('<?=base_url()?>index.php/Clientes/getAsesorByCoords/'+coordinador, function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_usuario'];
				var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
				$("#asesores").append($('<option>').val(id).text(name));
			}
			if(len<=0)
			{
				$("#asesores").append('<option selected="selected" disabled>NINGÚN COORDINADOR</option>');
			}
			$("#asesores").selectpicker('refresh');
		}, 'json');


		/**///carga tabla
		var url = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+coordinador;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
		// updateTable(url, typeTransaction);
	});

	//asesor
	$(document).on('change', '#asesores',function () {
		var asesor = $("#asesores").val();
		console.log('Elegiste: ' + asesor);

		/**///carga tabla
		var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsesor/"+asesor;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
		// updateTable(url, typeTransaction);
	});



    $(document).on("click", "#searchByDateRange", function () {
        var url_interno;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        var gerente = $("#gerente").val();
        var coordinador = $("#coordinador").val();
        var asesor = $("#asesores").val();

        if(gerente != '' && coordinador == '' && asesor==''){
            url_interno = "<?=base_url()?>index.php/Clientes/getProspectsListByGerente/"+gerente;
        }else if(gerente != '' && coordinador != '' && asesor == ''){
            url_interno = "<?=base_url()?>index.php/Clientes/getProspectsListByCoord/"+coordinador;
        }else if(gerente != '' && coordinador != '' && asesor != ''){
            url_interno = "<?=base_url()?>index.php/Clientes/getProspectsListByAsesor/"+asesor;
        }
        // console.log(url_interno);
        updateTable(url_interno, 3, finalBeginDate, finalEndDate, 0);/**/
    });


	function updateTable(url, typeTransaction, beginDate, endDate, where)
	{

        console.log('url: ', url);
        console.log('typeTransaction: ', typeTransaction);
        console.log('beginDate: ', beginDate);
        console.log('endDate: ', endDate);
        console.log('where: ', where);
		var prospectsTable = $('#prospects-datatable_dir').dataTable({
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
                        columns: [0,1,2,3,4,5,6,7,8],
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
                                        return 'COORDINADOR';
                                        break;
                                    case 5:
                                        return 'GERENTE';
                                        break;
                                    case 6:
                                        return 'LP';
                                        break;
                                    case 7:
                                        return 'CREACIÓN';
                                        break;
                                    case 8:
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
            ordering: true,
            destroy: true,
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
                        return d.nombre_lp;
                    }
                },
				{ data: function (d) {
						return d.fecha_creacion;
					}
				},
				{ data: function (d) {
						return d.fecha_vencimiento;
					}
				}
								<?php
				if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
				{
				?>
				,
				{ data: function (d) {
                        if(userType != 7 && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                            return '';
                        } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                            return '<button class="btn-data btn-details-grey see-information" data-id-prospecto="' + d.id_prospecto + '" style="margin-right: 3px;"><i class="material-icons">remove_red_eye</i></button>';
                        }
                    }
				}
				<?php  } ?>
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

    function compareDates(fecha_creacion){
        let date1 = new Date(fecha_creacion);
        let date2 = new Date('2022-01-01');
        var isBefore = moment(fecha_creacion).isBefore('2022-01-20T00:00:00Z');

        console.log('isBefore',isBefore);
        console.log('date2',date2);
        return isBefore;
    }
</script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
