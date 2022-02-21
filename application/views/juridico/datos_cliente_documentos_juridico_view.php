<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
	<?php
	//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
	if($this->session->userdata('id_rol')=="16")//contratacion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'contrato' => 0,
			'documentacion' => 1,
			'corrida' => 0,
			'inventario' => 0,
			'inventarioDisponible' => 0,
			'status8' => 0,
			'status14' => 0,
			'lotesContratados' => 0,
			'ultimoStatus' => 0,
			'lotes45dias' => 0,
			'consulta9Status' => 0,
			'consulta12Status' => 0,
			'gerentesAsistentes' => 0,
			'documentacion_ds' => 0,
			'expedientesIngresados'	=>	0,
			'corridasElaboradas'	=>	0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/contratacion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else if($this->session->userdata('id_rol')=="6")//ventasAsistentes
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'corridaF' => 0,
			'documentacion' => 1,
			'autorizacion' => 0,
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
			'prospectosAlta' => 0,
			'documentacion_ds' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0



		);
		//$this->load->view('template/ventas/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="11")//administracion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 1,
			'inventario' => 0,
			'status11' => 0,
			'nuevasComisiones'	=>	0,
			'documentacion_ds' => 0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/administracion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="15")//juridico
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 1,
			'contrato' => 0,
			'inventario' => 0,
			'status3' => 0,
			'status7' => 0,
			'lotesContratados' => 0,
			'documentacion_ds' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/juridico/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="13")//contraloria
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'expediente' => 0,
			'corrida' => 0,
			'documentacion' => 1,
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
			'comnuevas' => 0,
			'comhistorial' => 0,
			'tablaPorcentajes' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0,
			'integracionExpediente' => 0,
			'documentacion_ds' => 0,
			'expRevisados' => 0,
			'estatus10Report' => 0,
			'rechazoJuridico' => 0
		);

		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="7")//asesor
	{
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
			'documentacion' => 1,
			'documentacion_ds' => 0,
			'inventarioDisponible'  =>  0,
			'manual'    =>  0,
			'nuevasComisiones'     => 0,
			'histComisiones'       => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'references' => 0,
			'autoriza'	=>	0
		);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="12")//caja
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 1,
			'documentacion_ds' => 0,
			'cambiarAsesor' => 0,
			'historialPagos' => 0,
			'pagosCancelados' => 0,
			'altaCluster' => 0,
			'altaLote' => 0,
			'inventario' => 0,
			'actualizaPrecio' => 0,
			'actualizaReferencia' => 0,
			'liberacion' => 0
		);
		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	}
	?>

    <!--MAIN CONTENT-->
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Documentación</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="filtro3" id="filtro3"  class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" required
                                                    data-live-search="true">
                                                <?php

                                                if($residencial != NULL) :

                                                    foreach($residencial as $fila) : ?>
                                                        <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                                    <?php endforeach;

                                                endif;

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select id="filtro4" name="filtro4" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona condominio" data-size="7" required
                                                    data-live-search="true">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select id="filtro5" name="filtro5"  class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona condominio" data-size="7" required
                                                    data-live-search="true">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="tableDoct">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>DOCUMENTO</th>
                                                <th>HORA/FECHA</th>
                                                <th>ARCHIVO</th>
                                                <th>RESPONSABLE</th>
                                                <th>UBICACIÓN</th>
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


    <!-- modal  INSERT FILE-->
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
									Seleccionar archivo&hellip;<input type="file" name="expediente" id="expediente" style="display: none;">
									</span>
                        </label>
                        <input type="text" class="form-control" id= "txtexp" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="sendFile" class="btn btn-primary"><span
                                class="material-icons" >send</span> Guardar documento </button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal INSERT-->

    <!--modal que pregunta cuando se esta borrando un archivo-->
    <div class="modal fade" id="cuestionDelete" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title">¡Eliminar archivo!</h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row centered center-align">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></h1>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <h4 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h4>
                                <h5 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <br><br>
                    <button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
                </div>
            </div>
        </div>
    </div>
    <!--termina el modal de cuestion-->


    <!-- autorizaciones-->
    <div class="modal fade" id="verAutorizacionesAsesor" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title">Autorizaciones <span class="material-icons">vpn_key</span></h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="auts-loads">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>
    <!-- autorizaciones end-->

    <style>
        .carousel-control.left {
            /* background-image: -webkit-linear-gradient(left, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%); */
            /*background-image: -o-linear-gradient(left, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%);*/
            /* background-image: -webkit-gradient(linear, left top, right top, from(rgba(0, 0, 0, .5)), to(rgba(0, 0, 0, .0001))); */
            /* background-image: linear-gradient(to right, rgba(0, 0, 0, .5) 0, rgba(0, 0, 0, .0001) 100%); */
            /*filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);*/
            /* background-repeat: repeat-x; */
        }
        .carousel-control {
            position: absolute;
            /* top: 0; */
            bottom: 0;
            /* left: 0; */
            width: 15%;
            font-size: 20px;
            color: #333;
            /* text-align: center; */
            /* text-shadow: 0 1px 2px rgba(0, 0, 0, .6); */
            filter: alpha(opacity=50);
            /* opacity: .5; */

        }
        @media screen and (min-width: 768px)
        {
            .carousel-indicators {
                left: 50%;
                bottom: -4.5%;
            }
            .carousel-caption {
                /* right: 20%; */
                /* left: 20%; */
                /* padding-bottom: 30px; */
                z-index: 9999999999999999999999999;
                bottom: -6%;
                color: black;
                position: initial;
                padding: 0px;
                text-shadow: 0 0 black;
            }
        }
        .carousel-indicators li {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 1px;
            text-indent: -999px;
            cursor: pointer;
            background-color: #000\9;
            background-color: #FFF;
            border: 1px solid #96843d;
            border-radius: 10px;
        }
        .carousel-indicators .active {
            width: 12px;
            height: 12px;
            margin: 0;
            background-color: #c5c0b1;
        }

    </style>
    <div class="modal fade" id="modal_archivos">
        <div class="modal-dialog" style="width: 90%">
            <div class="modal-content" >
                <div class="modal-header"  style=" height: 50px;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="material-icons"> close</span>
                    </button>
                    <!--<center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>-->
                </div>
                <div class="modal-body" style="padding: 0px 0px 40px 0px;">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators" id="carousel-indicators">
                            <!--<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>-->
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" id="items_to_show">

                        </div>

                        <!-- Left and right controls -->
                        <a class="left" href="#myCarousel" data-slide="prev" style="float: left;padding:15px 0px 0px 15px;
								position: absolute;top: -0%;font-weight: 800">
                            <!--<span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="sr-only">Previous</span>-->
                            <span class="material-icons">keyboard_arrow_left</span> Anterior
                        </a>
                        <a class="right" href="#myCarousel" data-slide="next" style="float: right;padding:15px 15px 0px 0px;
								position: absolute;top: -0%;right: 0%;font-weight: 800">
                            <!--<span class="glyphicon glyphicon-chevron-right"></span>
                            <span class="sr-only">Next</span>-->
                            Siguiente <span class="material-icons">keyboard_arrow_right</span>
                        </a>
                    </div>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>-->
            </div>
        </div>
    </div>
	<!--Contenido de la página-->
	<div class="content hide">
		<div class="container-fluid">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
				<div class="container">
					<a href="https://source.unsplash.com/c1JxO-uAZd0/1500x1000"  data-fancybox="gallery" data-caption="Danish summer">
						<img src="https://source.unsplash.com/c1JxO-uAZd0/240x160" />
					</a>

					<a href="https://source.unsplash.com/i2KibvLYjqk/1500x1000" data-fancybox="gallery" data-caption="Danish summer" href="javascript:;">
						Example #3 - Sample PDF file (using pdf.js)
						<iframe src="https://mozilla.github.io/pdf.js/web/viewer.html"></iframe>
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content">
							<h4 class="card-title" style="text-align: center">Documentación</h4>
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
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-content" style="padding: 30px 20px;">
							<div class="col col-xs-12 col-sm-12 col-md-2 col-md-offset-10 col-lg-2 col-lg-offset-10">
								<!--<button class="btn btn-group-raised hide" id="btnFilesGral">Ver Archivos</button>-->
								<button class="btn hide" id="btnFilesGral" data-toggle="modal" data-target="#modal_archivos">Ver Archivos</button>


							</div>
							<div class="material-datatables">
								<table id="tableDoct" class="table table-bordered table-hover" width="100%" style="text-align:center;">
									<thead>
									<tr>
										<th style="font-size: .9em;" class="text-center">Proyecto</th>
										<th style="font-size: .9em;" class="text-center">Condominio</th>
										<th style="font-size: .9em;" class="text-center">Lote</th>
										<th style="font-size: .9em;" class="text-center">Cliente</th>
										<th style="font-size: .9em;" class="text-center">Nombre de Documento</th>
										<th style="font-size: .9em;" class="text-center">Hora/Fecha</th>
										<th style="font-size: .9em;" class="text-center">Documento</th>
										<th style="font-size: .9em;" class="text-center">Responsable</th>
										<th style="font-size: .9em;" class="text-center">Ubicación</th>
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


	$("#btnFilesGral").on('click', function() {
		var $itself = $(this);
		var idLote=$itself.attr('data-idLote');

		//console.log('data clickeada: ' + idLote);
		var items_app = '';
		var li_items = '';
		var actived = '';
		$('#carousel-indicators').html('');
		$('#items_to_show').html('');
		$.post( "<?=base_url()?>index.php/registroCliente/expedientesWS/"+idLote, function( data_json ) {
			var data = jQuery.parseJSON(data_json);
			var dataGeneral='';
			var url_base = '<?=base_url()?>static/documentos/cliente/expediente/';
			var url_base_production = 'https://maderascrm.gphsis.com/static/documentos/cliente/expediente/';
			var url_base_corrida = '<?=base_url()?>static/documentos/cliente/corrida/';



			//console.log(data);
			for(let i=0; i<data.length; i++)
			{
				//console.log(i);
				if(i==0)
				{
					if(data[i]['expediente'] ==null || data[i]['expediente'] == "")
					{
						li_items = '';
					}
					else
					{
						actived = 'active';
						li_items = '<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>';
					}

				}
				else
				{
					if(data[i]['expediente'] ==null || data[i]['expediente'] == "")
					{
						li_items = '';
					}
					else
					{
						actived = '';
						li_items = '<li data-target="#myCarousel" data-slide-to="'+i+'"></li>';
					}

				}

				$('#carousel-indicators').append(li_items);
				// console.log(data);
				//items_app  = '<div class="item '+actived+'"><p>'+data[i]['movimiento']+'</p></div>';
				if(getFileExtension(data[i]['expediente']) == "pdf")
				{
						//console.log('Este es un PDF: ' + data[i]['movimiento']);
					//
					var url_pdf = '';
					if(data[i]['movimiento'] == "CONTRATO")
					{
						url_pdf = '<?=base_url()?>static/documentos/cliente/contrato/';
					}
					else
					{
						url_pdf = '<?=base_url()?>static/documentos/cliente/expediente/';
					}
					items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" ' +
							'src="'+url_pdf+data[i]['expediente']+'" ' +
							'title="Déposito Seriedad"></iframe></div>';
					// $('#items_to_show').append(items_app);

				}
				else if(getFileExtension(data[i]['expediente']) == "jpg" || getFileExtension(data[i]['expediente']) == "JPG"
				|| getFileExtension(data[i]['expediente']) == "jpeg" || getFileExtension(data[i]['expediente']) == "JPEG" ||
					getFileExtension(data[i]['expediente']) == "png" || getFileExtension(data[i]['expediente']) == "PNG")
				{
					items_app  = '<div class="item '+actived+'"><div class="col col-sm-12 center-block center-align">' +
							'<div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<center><img src="'+url_base_production+data[i]['expediente']+'" class="img-responsive" alt="'+data[i]['movimiento']+'"></center></div></div>';
				}
				else if(getFileExtension(data[i]['expediente']) == "xlsx")
				{
					items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<center><a href="'+url_base_corrida+data[i]['expediente']+'" target="_blank">' +
							'<img src="https://maderascrm.gphsis.com/static/images/excel.png" ' +
							'class="img-responsive"width="30%"></a></center><br><br></div>';
					// $('#items_to_show').append(items_app);
				}
				else if (getFileExtension(data[i]['expediente']) == "Depósito de seriedad")
				{
					items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" ' +
							'src="<?=base_url()?>asesor/deposito_seriedad/'+data[i]['id_cliente']+'/1/" title="Déposito Seriedad"></iframe>' +
							' </div>';
				}
				else if (getFileExtension(data[i]['expediente']) == "Depósito de seriedad versión anterior") {
					items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" ' +
							'src="<?=base_url()?>asesor/deposito_seriedad_ds/'+data[i]['id_cliente']+'/1/" title="Déposito Seriedad"></iframe>' +
							' </div>';
				}
				else if (getFileExtension(data[i]['expediente']) == "Autorizaciones") {
						/*items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" ' +
							'src="<?=base_url()?>asesor/deposito_seriedad_ds/'+data[i]['expediente']+'/1/" title="Déposito Seriedad"></iframe>' +
							' </div>';*/

							var dataAuts = '';
							$.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data_auts ) {
							var statusProceso='';
							var data2 = jQuery.parseJSON(data_auts);
							/*console.log(data2.length);*/
								items_app  += '<div class="item '+actived+'" onload="getAutorizaciones('+idLote+')">' +
									'<div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>';
								items_app  += '<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4" style="text-align: center">';
							for(var p = 0; p<data2.length; p++)
							{
								if(data2[p]['estatus'] == 0)
								{
									statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
								}
								else if(data2[p]['estatus']== 1)
								{
									statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
								}
								else if(data2[p]['estatus'] == 2)
								{
									statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
								}
								else if(data2[p]['estatus'] == 3)
								{
									statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
								}
								else
								{
									statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
								}
								items_app  += '<br><h4>Solicitud de autorización:  '+statusProceso+'</h4><br>' +
									'<h4>Autoriza: '+data2[p]['nombreAUT']+'</h4><br>' +
									'<p style="text-align: justify;padding: 10px;border: 1px solid #ccc;border-radius: 12px;"><i>'+data2[p]['autorizacion']+'</i></p><br><hr>';
							}
							// console.log(dataAuts);
							// $('#data_autorizaciones').append(dataAuts);
								items_app += '</div>';
								items_app  += '</div>';

								$('#items_to_show').append(items_app);
						});

					}
				else if (getFileExtension(data[i]['expediente']) == "Prospecto") {
					items_app  = '<div class="item '+actived+'"><div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4></div>' +
							'<iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" ' +
							'src="<?=base_url()?>clientes/printProspectInfo/'+data[i]['id_prospeccion']+'" title="Prospeccion"></iframe> ' +
							' </div>';
				}
				else {
					/*items_app  = '<div class="item '+actived+'"><p>'+data[i]['movimiento']+'</p>' +
						'<div class="carousel-caption"> <h4>'+data[i]['movimiento']+'</h4> </div></div>';*/
					items_app  = '';
				}
				/*else if(getFileExtension(data[i]['expediente']) == "xlsx")
				{

						console.log('Este es un excel: ' + data[i]['movimiento']);
					items_app  += '<div class="item '+actived+'">es un excel no se puede ver </div>';
					// $('#items_to_show').append(items_app);

					//
				}
				else if (getFileExtension(data[i]['expediente']) == "NULL" || getFileExtension(data[i]['expediente']) == 'null' || getFileExtension(data[i]['expediente']) == "")
				{
					if(data[i]['tipo_doc']  == 7) {
						console.log('Corrida financiefra: ' + data[i]['movimiento']);
						items_app  += '<div class="item '+actived+'"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad/'+data[i]['expediente']+'/1/" title="Corrida Financiera"> </div>';
						// $('#items_to_show').append(items_app);
					}
				}
				else if (getFileExtension(data[i]['expediente']) == "Depósito de seriedad")
				{
						console.log('Este es un depósito de seriedad: ' + data[i]['movimiento']);
					items_app  += '<div class="item '+actived+'"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad/'+data[i]['id_cliente']+'/1/" title="Déposito Seriedad"> </div>';
					// $('#items_to_show').append(items_app);
				}
				else if (getFileExtension(data[i]['expediente']) == "Depósito de seriedad versión anterior") {
					console.log('Este es un Depósito de seriedad versión anterior: ' + data[i]['movimiento']);
					items_app  += '<div class="item '+actived+'"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+data[i]['id_cliente']+'/1/" title="Déposito Seriedad"> </div>';
					// $('#items_to_show').append(items_app);
				}
				else if (getFileExtension(data[i]['expediente']) == "Autorizaciones") {
					console.log('Este es un Autorizaciones: ' + data[i]['movimiento']);
					items_app  += '<div class="item '+actived+'"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+data[i]['expediente']+'/1/" title="Déposito Seriedad"> </div>';
					$('#items_to_show').append(items_app);
				}
				else if (getFileExtension(data[i]['expediente']) == "Prospecto") {
					console.log('Este es un Prospecto: ' + data[i]['movimiento']);
					items_app  += '<div class="item '+actived+'"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>clientes/printProspectInfo/'+data[i]['id_prospeccion']+'" title="Prospeccion"> </div>';
					// $('#items_to_show').append(items_app);
				}
				else {
					console.log('Esta es una imagen: ' + getFileExtension(data[i]['expediente']) + ' y debe ser: '+ actived);
					items_app  += '<div class="item '+i+'"><img src="'+url_base+data[i]['expediente']+'" alt="Los Angeles"></div>';


				}*/
				$('#items_to_show').append(items_app);
			}

		});


	});/**/
</script>
<script>
    var tableDoc;
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



		$('#filtro3').change(function(){

			var valorSeleccionado = $(this).val();

			// console.log(valorSeleccionado);
			//build select condominios
			$("#filtro4").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
				type: 'post',
				dataType: 'json',
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idCondominio'];
						var name = response[i]['nombre'];
						$("#filtro4").append($('<option>').val(id).text(name));
					}
					$("#filtro4").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');

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
				url: '<?=base_url()?>registroCliente/getLotesAll/'+valorSeleccionado+'/'+residencial,
				type: 'post',
				dataType: 'json',
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idLote'];
						var name = response[i]['nombreLote'];
						$("#filtro5").append($('<option>').val(id).text(name));
					}
					$("#filtro5").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
				}
			});
		});


		$('#filtro5').change(function(){

			var valorSeleccionado = $(this).val();

			console.log(valorSeleccionado);
            tableDoc = $('#tableDoct').DataTable({
				destroy: true,
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Registro de clientes',
                        title: 'Registro de cilentes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4,5, 7, 8 ],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'LOTE';
                                            break;
                                        case 3:
                                            return 'CLIENTE';
                                            break;
                                        case 4:
                                            return 'DOCUMENTO';
                                            break;
                                        case 5:
                                            return 'HORA/FECHA';
                                            break;
                                        case 7:
                                            return 'RESPONSABLE';
                                            break;
                                        case 8:
                                            return 'UBICACIÓN';
                                            break;
                                    }
                                }
                            }
                        },
                    }
                ],
                select: {
                    style: 'single'
                },
				lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
				"ajax":
					{
						"url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+valorSeleccionado,
						"dataSrc": ""
					},
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
				"ordering": false,
				"columns":
					[
						{
							"width": "8%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
							}
						},

						{
							"width": "8%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.nombre+'</p>';
							}
						},
						{
							"width": "12%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
							}
						},
						{
							"width": "10%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.nomCliente +' ' +d.apellido_paterno+' '+d.apellido_materno+'</p>';
							}
						},

						{
							"width": "10%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.movimiento+'</p>';
							}
						},
						{
							"width": "10%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+d.modificado+'</p>';
							}
						},

						{
							"width": "10%",
							data: null,
							render: function ( data, type, row )
							{

								if (getFileExtension(data.expediente) == "pdf") {
									if(data.tipo_doc == 8){
										if(data.idMovimiento == 36 || data.idMovimiento == 6 || data.idMovimiento == 23 || data.idMovimiento == 76 || data.idMovimiento == 83 || data.idMovimiento == 95 || data.idMovimiento == 97){
											file = '<center><a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button></center>';
										} else {
											file = '<center><a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
										}
									} else if(data.tipo_doc == 66){
										file = '<center><a class="verEVMKTD btn-data btn-warning" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a></center>';
									}else {
										file = '<center><a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
									}
								}
								else if (getFileExtension(data.expediente) == "xlsx") {
									file = '<center><a href="../../static/documentos/cliente/corrida/' + data.expediente + '" class="btn-data btn-green-excel"><i class="fas fa-file-excel"></i><src="../../static/documentos/cliente/corrida/"' + data.expediente + '"></a></center>';
								}
								else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
									if(data.tipo_doc == 7){
										file = '<button type="button" title= "Corrida inhabilitada" class="btn-data btn-warning" disabled><i class="fa fa-list-alt" aria-hidden="true"></i></button>';
									} else if(data.tipo_doc == 8){
										if(data.idMovimiento == 36 || data.idMovimiento == 6 || data.idMovimiento == 23 || data.idMovimiento == 76 || data.idMovimiento == 83 || data.idMovimiento == 95 || data.idMovimiento == 97){
											file = '<center><button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fa fa-upload" aria-hidden="true"></i></button></center>';
										} else {
											file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fa fa-upload" aria-hidden="true"></i></button></center>';
										}
									} else {
										file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fa fa-upload" aria-hidden="true"></i></button></center>';
									}
								}
								else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
									file = '<center><a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a></center>';
								}
								else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
									file = '<center><a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a></center>';
								}
								else if (getFileExtension(data.expediente) == "Autorizaciones") {
									file = '<center><a href="#" class="btn-data btn-warning seeAuts" title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a></center>';
								}
								else if (getFileExtension(data.expediente) == "Prospecto") {
									file = '<center><a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a></center>';
								}
								else
								{
									if(data.tipo_doc == 66){
										file = '<center><a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a></center>';
										}
										else{
											file = '<center><a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a></center>';
										}
								}
								return file;
							}
						},
						{
							"width": "10%",
							"data": function( d ){
								return '<p style="font-size: .8em">'+ myFunctions.validateEmptyFieldDocs(d.primerNom) +' '+myFunctions.validateEmptyFieldDocs(d.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(d.apellidoMa)+'</p>';
							}
						},

						{
							"width": "10%",
							"data": function( d ){
								var validaub = (d.ubic == null) ? '' : d.ubic;

								return '<p style="font-size: .8em">'+ validaub +'</p>';
							}
						},
					]
			});
			/*$('#btnFilesGral').removeClass('hide');

			$('#btnFilesGral').attr('data-idLote', valorSeleccionado);*/
			$.post( "<?=base_url()?>index.php/registroCliente/expedientesWS/"+valorSeleccionado, function( data_json ) {
				var data = jQuery.parseJSON(data_json);
				console.log("Este expediente tiene la siguiente data: " + data);
				if(data.length>0)
				{
					$('#btnFilesGral').removeClass('hide');
					$('#btnFilesGral').attr('data-idLote', valorSeleccionado);
				}
				else
				{
					$('#btnFilesGral').addClass('hide');
					$('#btnFilesGral').attr('data-idLote', valorSeleccionado);
				}
			});
		});






	});/*document Ready*/

	function getFileExtension(filename) {
		validaFile =  filename == null ? 'null':
			filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
				filename == 'Autorizaciones' ? 'Autorizaciones':
					filename.split('.').pop();
		return validaFile;
	}

	$(document).on('click', '.pdfLink', function () {
		var $itself = $(this);
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" ' +
				'src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
			width:      985,
			height:     660
		});
	});
	$(document).on('click', '.pdfLink2', function () {
		var $itself = $(this);
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
			width:      1600,
			height:     900
		});
	});
	$(document).on('click', '.pdfLink22', function () {
		var $itself = $(this);
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
			width:      1600,
			height:     900
		});
	});
	$(document).on('click', '.pdfLink3', function () {
		var $itself = $(this);
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
			width:      985,
			height:     660
		});
	});

	$(document).on('click', '.verProspectos', function () {
		var $itself = $(this);
		Shadowbox.open({
			/*verProspectos*/
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
			player:     "html",
			title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
			width:      985,
			height:     660

		});
	});

	/*evidencia MKTD PDF*/
	$(document).on('click', '.verEVMKTD', function () {
		var $itself = $(this);
		var cntShow = '';

		if(checaTipo($itself.attr('data-expediente')) == "pdf")
		{
			cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
		}else{
			cntShow = '<div><img src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
		}
		/*content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>',*/
		Shadowbox.open({
			content:    cntShow,
			player:     "html",
			title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
			width:      985,
			height:     660

		});
	});

	function checaTipo(archivo)
	{
		archivo.split('.').pop();
			return validaFile;
	}





	$(document).on('click', '.seeAuts', function (e) {
		e.preventDefault();
		var $itself = $(this);
		var idLote=$itself.attr('data-idLote');
		$.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
			$('#auts-loads').empty();
			var statusProceso;
			$.each(JSON.parse(data), function(i, item) {
				if(item['estatus'] == 0)
				{
					statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
				}
				else if(item['estatus'] == 1)
				{
					statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
				}
				else if(item['estatus'] == 2)
				{
					statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
				}
				else if(item['estatus'] == 3)
				{
					statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
				}
				else
				{
					statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
				}
				$('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
				$('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
				$('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
					'<br><hr>');

			});
			$('#verAutorizacionesAsesor').modal('show');
		});
	});


	var miArrayAddFile = new Array(8);
	var miArrayDeleteFile = new Array(1);

	$(document).on("click", ".update", function(e){

		e.preventDefault();

		var descdoc= $(this).data("descdoc");
		var idCliente = $(this).attr("data-idCliente");
		var nombreResidencial = $(this).attr("data-nombreResidencial");
		var nombreCondominio = $(this).attr("data-nombreCondominio");
		var idCondominio = $(this).attr("data-idCondominio");
		var nombreLote = $(this).attr("data-nombreLote");
		var idLote = $(this).attr("data-idLote");
		var tipodoc = $(this).attr("data-tipodoc");
		var iddoc = $(this).attr("data-iddoc");

		miArrayAddFile[0] = idCliente;
		miArrayAddFile[1] = nombreResidencial;
		miArrayAddFile[2] = nombreCondominio;
		miArrayAddFile[3] = idCondominio;
		miArrayAddFile[4] = nombreLote;
		miArrayAddFile[5] = idLote;
		miArrayAddFile[6] = tipodoc;
		miArrayAddFile[7] = iddoc;

		$(".lote").html(descdoc);
		$('#addFile').modal('show');

	});

	$(document).on('click', '#sendFile', function(e) {
		e.preventDefault();
		var idCliente = miArrayAddFile[0];
		var nombreResidencial = miArrayAddFile[1];
		var nombreCondominio = miArrayAddFile[2];
		var idCondominio = miArrayAddFile[3];
		var nombreLote = miArrayAddFile[4];
		var idLote = miArrayAddFile[5];
		var tipodoc = miArrayAddFile[6];
		var iddoc = miArrayAddFile[7];
		var expediente = $("#expediente")[0].files[0];

		var validaFile = (expediente == undefined) ? 0 : 1;

		var dataFile = new FormData();

		dataFile.append("idCliente", idCliente);
		dataFile.append("nombreResidencial", nombreResidencial);
		dataFile.append("nombreCondominio", nombreCondominio);
		dataFile.append("idCondominio", idCondominio);
		dataFile.append("nombreLote", nombreLote);
		dataFile.append("idLote", idLote);
		dataFile.append("expediente", expediente);
		dataFile.append("tipodoc", tipodoc);
		dataFile.append("idDocumento", iddoc);

		if (validaFile == 0) {
			//toastr.error('Debes seleccionar un archivo.', '¡Alerta!');
			alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
		}

		if (validaFile == 1) {
			$('#sendFile').prop('disabled', true);
			$.ajax({
				url: "addFileContrato",
				data: dataFile,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success : function (response) {
					response = JSON.parse(response);
					if(response.message == 'OK') {
						//toastr.success('Contrato enviado.', '¡Alerta de Éxito!');
						alerts.showNotification('top', 'right', 'Contrato enviada', 'success');
						$('#sendFile').prop('disabled', false);
						$('#addFile').modal('hide');
						$('#tableDoct').DataTable().ajax.reload();
					} else if(response.message == 'ERROR'){
						//toastr.error('Error al enviar contrato y/o formato no válido.', '¡Alerta de error!');
						alerts.showNotification('top', 'right', 'Error al enviar contrato y/o formato no válido', 'danger');
						$('#sendFile').prop('disabled', false);
					}
				}
			});
		}

	});

	$(document).on("click", ".delete", function(e){
		e.preventDefault();
		var iddoc= $(this).data("iddoc");
		var tipodoc= $(this).data("tipodoc");

		miArrayDeleteFile[0] = iddoc;

		$(".tipoA").html(tipodoc);
		$('#cuestionDelete').modal('show');

	});

	$(document).on('click', '#aceptoDelete', function(e) {
		e.preventDefault();
		var id = miArrayDeleteFile[0];
		var dataDelete = new FormData();
		dataDelete.append("idDocumento", id);

		$('#aceptoDelete').prop('disabled', true);
		$.ajax({
			url: "<?=base_url()?>index.php/registroCliente/deleteContrato",
			data: dataDelete,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success : function (response) {
				response = JSON.parse(response);
				if(response.message == 'OK') {
					//toastr.success('Archivo eliminado.', '¡Alerta de Éxito!');
					alerts.showNotification('top', 'right','Archivo Eliminado', 'success');
					$('#aceptoDelete').prop('disabled', false);
					$('#cuestionDelete').modal('hide');
					$('#tableDoct').DataTable().ajax.reload();
				} else if(response.message == 'ERROR'){
					//toastr.error('Error al eliminar el archivo.', '¡Alerta de error!');
					alerts.showNotification('top', 'right','Error al eliminar el archivo', 'danger');
					$('#tableDoct').DataTable().ajax.reload();
				}
			}
		});

	});


	$('.carousel').carousel({
		interval: false,
	});

    $("#tableDoct").ready(function () {
        $('#tableDoct thead tr:eq(0) th').each(function (i) {
            // if ( i != 6) {
                var title = $(this).text();
                $(this).html('<input class="textoshead" type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if (tableDoc.column(i).search() !== this.value) {
                        tableDoc
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            // }
        });

        let titulos = [];
        $('#tableDoct thead tr:eq(0) th').each(function (i) {
            if (i != 0 && i != 13) {
                var title = $(this).text();

                titulos.push(title);
            }
        });
    });
</script>

