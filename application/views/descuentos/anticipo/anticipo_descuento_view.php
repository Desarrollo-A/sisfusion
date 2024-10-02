<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet" />
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
<style>
            .card_title {
        position: relative;
        margin: 0 0 24px;
        padding-bottom: 10px;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        }

        .card_title::after {
        position: absolute;
        display: block;
        width: 50px;
        height: 2px;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background-color: #c89b3f;
        content: "";
        }
        .card_text p {
        margin: 0 0 24px;
        font-size: 14px;
        line-height: 1.5;
        }

        .card_text p:last-child {
        margin: 0;
        }

    </style>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>
        <?php $this->load->view('descuentos/anticipo/complementos/estilosAdelantos'); ?>
        <div class="content boxContent">
            
        <div class="modal fade modal-alertas" id="myModalAceptar_subir" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<form method="post" id="form_subir">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>
            <div class="container-fluid">
                <div class="row " style="margin-bottom: 2px">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                <h3 class="h3 card-title center-align">
                                    <span data-i18n="adelantos">Adelantos</span></h3>
                                    <p class="card-title pl-1" data-i18n="opcion-proceso-solicitud">
                                        (Seleccionar una opción para iniciar tu proceso de solicitud o mostrar tus procesos)
                                    </p>
                                    <div class="col-lg-2">
                                </div>
                                </div>
                                <?php $this->load->view('descuentos/anticipo/complementos/anticipo_descuento_botones_comple'); ?>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <!-- a -->
                                        <?php $this->load->view('descuentos/anticipo/complementos/solicitud_anticipo_ventas_comple'); ?>
                                        <!-- b -->
                                        <!-- c -->
                                        <?php $this->load->view('descuentos/anticipo/complementos/linea_de_proceso_comple'); ?>
                                        <!-- d -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </div>

    <?php $this->load->view('template/footer'); ?>

    <script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/general/funcionesGeneralesComisiones.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo/anticipo_descuento.js"></script>
    <!-- <script src="<?= base_url() ?>dist/js/controllers/descuentos/complementos/prueba_boton_subida.js"></script> -->

    <script type="text/javascript">
        Shadowbox.init();
    </script>
</body>