<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<style>
      #modal_vista_evidencias{
                position:absolute;
                z-index: 9991!important;
            }
            
</style>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade modal-alertas" id="modal_vista_evidencias" name="modal_vista_evidencias" 
                    role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade modal-alertas" id="modal_informacion" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h3 class="text-center">Detalle</h3>
                    </div>
                    <div class="modal-body">
                        <div class="material-datatables">
                            <div class="form-group">
                                <table class="table-striped table-hover" id="tabla_modal" name="tabla_modal">
                                    <thead>
                                        <tr>
                                            <th>ID PAGO</th>
                                            <th>LOTE</th>
                                            <th>MONTO</th>
                                            <th>FECHA DE APLICADO</th>
                                            <th>MONTO ANTERIOR</th>
                                            <th>ESTATUS</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane <?php if($this->session->userdata('id_rol') != 66){ ?> active <?php } ?>" id="solicitudesCRM">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <h3 class="card-title center-align">Historial activos</h3>
                                                    <p class="card-title pl-1">Listado de todos los pagos aplicados, en proceso de casas 
                                                        <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="toolbar"> 
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0">
                                                        <div class="form-group select-is-empty overflow-hidden">
                                                            <label class="control-label">Año</label>
                                                            <select name="ano_historial" id="ano_historial" class="selectpicker select-gral" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                for ($i = 2019; $i <= 2024; $i++) {
                                                                    $yearName  = $i;
                                                                    echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0 overflow-hidden">
                                                        <div class="form-group select-is-empty">
                                                            <label for="proyecto" class="control-label">Proyecto</label>
                                                            <select name="catalogo_historial" id="catalogo_historial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hidden" id="tabla_historialGral" name="tabla_historialGral">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROYECTO</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>COSTO CONSTRUCCIÓN</th>
                                                                <th>TOTAL DE LA COMISIÓN</th>
                                                                <th>DISPERSADO</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>ESTATUS</th>
                                                                <!-- <th>ACCIONES</th> -->
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
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>   
    <script>
        var usuario_id = <?= $this->session->userdata('id_usuario')?>;
        var tipo_usuario = <?= $this->session->userdata('tipo') ?>;
    </script>
    <script src="<?= base_url() ?>dist/js/controllers/casas_comisiones/historial_bono_casas.js"></script>


    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

	<!-- <script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_prestamos.js"></script> -->
	<script type="text/javascript">
		Shadowbox.init();
	</script>
</body>