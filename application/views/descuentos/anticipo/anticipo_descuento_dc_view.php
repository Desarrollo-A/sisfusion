<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<body class="">
<div class="wrapper ">

    <?php $this->load->view('template/sidebar'); ?>
    <!--MODALS-->
    <div class="modal fade modal-alertas" id="myModalDelete" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<form method="post" id="form_delete">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>

        <div class="modal fade modal-alertas" id="myModalAceptar" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<form method="post" id="form_aceptar">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>


        <div class="modal fade modal-alertas" id="myModalAceptar_subir" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<form method="post" id="form_subir">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>
    <!--END MODALS-->

    <!--Contenido de la página-->
    <div class="content boxContent ">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Anticipos </h3>
                                <p class="card-title pl-1">(contrato recibido con firma del cliente)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table id="tabla_anticipo_revision_dc" name="tabla_anticipo_revision_dc" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th>ID ANTICIPO</th>
                                            <th>USUARIO</th>

                                            <th>PUESTO</th>
                                            <th>SEDE</th>
                                            <th>MONTO</th>

                                            <th>COMENTARIO</th>
                                            <!-- <th>ESTATUS</th> -->
                                            <th>PROCESO</th>
                                            <th>PRIORIDAD</th>
                                            <th>ACCIONES</th>
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

<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo/solicitudes_dc.js"></script>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script type="text/javascript">
		Shadowbox.init();
	</script>
</body>