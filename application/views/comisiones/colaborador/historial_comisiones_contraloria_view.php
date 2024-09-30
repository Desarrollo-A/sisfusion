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

        <div class="modal fade modal-alertas" id="modal_informacion" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h3 class="text-center" data-i18n="detalles">Detalle</h3>
                    </div>
                    <div class="modal-body">
                        <div class="material-datatables">
                            <div class="form-group">
                                <table class="table-striped table-hover" id="tabla_modal" name="tabla_modal">
                                    <thead>
                                        <tr>
                                            <th>id-pago</th>
                                            <th>lote</th>
                                            <th>monto</th>
                                            <th>fecha-aplicado</th>
                                            <th>monto-anterior</th>
                                            <th>estatus</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <?php if ($this->session->userdata('id_rol') != 66) { ?>
                            <li class="active">
                                <a href="#solicitudesCRM" role="tab" data-toggle="tab" data-i18n="historial-CRM">Historial CRM</a>
                            </li>
                            <li>
                                <a href="#solicitudesCanceladas" role="tab" data-toggle="tab" data-i18n="historial-canceladas">Historial canceladas</a>
                            </li>
                            <?php }?>
                            <?php if(in_array($this->session->userdata('id_rol'), array(1, 2, 3, 7, 9, 66))) { ?>
                                <li>
                                    <a href="#solicitudesSUMA" role="tab" data-toggle="tab" data-i18n="historial-suma">Historial SUMA</a>
                                </li>
                                <li>
                                    <a href="#historialDescuentos" role="tab" data-toggle="tab" data-i18n="historial-descuentos">Historial descuentos</a>
                                </li>

                            <?php } ?>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane <?php if($this->session->userdata('id_rol') != 66){ ?> active <?php } ?>" id="solicitudesCRM">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <h3 class="card-title center-align" data-i18n="historial-activos">Historial activos</h3>
                                                    <p class="card-title pl-1"><span data-i18n="listado-de-pagos-aplicados-contratados-activos">(Listado de todos los pagos aplicados, en proceso de lotes contratados y activos)</span>
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
                                                            <label class="control-label" data-i18n="año">Año:</label>
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
                                                            <label for="proyecto" class="control-label" data-i18n="proyectos">Proyectos</label>
                                                            <select name="catalogo_historial" id="catalogo_historial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hide" id="tabla_historialGral" name="tabla_historialGral">
                                                        <thead>
                                                            <tr>
                                                                <th>id</th>
                                                                <th>proyectos</th>
                                                                <th>condominio</th>
                                                                <th>lote</th>
                                                                <th>referencia</th>
                                                                <th>precio-del-lote</th>
                                                                <th>total-comision</th>
                                                                <th>pago-cliente</th>
                                                                <th>dispersado</th>
                                                                <th>pagado1</th>
                                                                <th>pendiente</th>
                                                                <th>usuario</th>
                                                                <th>position</th>
                                                                <th>detalles</th>
                                                                <th>estatus</th>
                                                                <th>acciones</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="solicitudesCanceladas">
                                            <div class="encabezadoBox">
                                                <div class="row">
                                                    <h3 class="card-title center-align" data-i18n="historial-canceladas">Historial canceladas</h3>
                                                    <p class="card-title pl-1"><span data-i18n="listado-pago-aplicados-lotes-cancelados">(Listado de todos los pagos aplicados, en proceso de lotes cancelados con rescisión)</span>
                                                        <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 m-0">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="proyecto" data-i18n="año">Año:</label>
                                                            <select name="ano_canceladas" id="ano_canceladas" class="selectpicker select-gral" data-container="body" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                                <?php
                                                                setlocale(LC_ALL, 'es_ES');
                                                                for ($i = 2019; $i <= 2025; $i++) {
                                                                    $yearName  = $i;
                                                                    echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                        <div class="form-group">
                                                            <label class="control-label" for="proyecto" data-i18n="proyectos">Proyecto:</label>
                                                            <select name="catalogo_canceladas" id="catalogo_canceladas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required><option value="0">Seleccione todo</option></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover hide" id="tabla_comisiones_canceladas" name="tabla_comisiones_canceladas">
                                                        <thead>
                                                            <tr>
                                                                <th>id</th>
                                                                <th>proyectos</th>
                                                                <th>condominio</th>
                                                                <th>lote</th>
                                                                <th>referencia</th>
                                                                <th>precio-del-lote</th>
                                                                <th>total-comision</th>
                                                                <th>pago-cliente</th>
                                                                <th>dispersado</th>
                                                                <th>pagado</th>
                                                                <th>pendiente</th>
                                                                <th>usuario</th>
                                                                <th>position</th>
                                                                <th>detalles</th>
                                                                <th>estatus</th>
                                                                <th>acciones</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if(in_array($this->session->userdata('id_rol'), array(1, 2, 3, 7, 9, 66))) { ?>
                                        <div class="tab-pane <?php if($this->session->userdata('id_rol') == 66){ ?> active <?php } ?>" id="solicitudesSUMA">
                                                <div class="encabezadoBox">
                                                    <h3 class="card-title center-align"><span data-i18n="historial-suma">Historial general SUMA</span>
                                                    <a href="https://youtu.be/S7HO2QTLaL0" style="color:red" target="_blank">
                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="toolbar">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 overflow-hidden">
                                                            <div class="form-group select-is-empty">
                                                                <label for="anio_suma" class="control-label" data-i18n="año">AÑO</label>
                                                                <select name="anio_suma" id="anio_suma" class="selectpicker select-gral" data-style="btn" data-container="body" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover hide" id="tabla_comisiones_suma" name="tabla_comisiones_suma">
                                                            <thead>
                                                                <tr>
                                                                    <th>id-pago</th>
                                                                    <th>reference</th>
                                                                    <th>nombren</th>
                                                                    <th>sede</th>
                                                                    <th>forma-pago</th>
                                                                    <th>total-comision</th>
                                                                    <th>impuestopan</th>
                                                                    <th>%-comision</th>
                                                                    <th>estatusan</th>
                                                                    <th>accionespan</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="historialDescuentos">
                                                <div class="encabezadoBox">
                                                    <div class="row">
                                                        <h3 class="card-title center-align" data-i18n="historial-descuentos">Historial descuentos</h3>
                                                        <p class="card-title pl-1" data-i18n="este-listado-todos-descuentos-aplicados">Este es un listado de todos los descuentos que te han aplicado.</p>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover" id="tablaHistorialDescuentos" name="tablaHistorialDescuentos">
                                                            <thead>
                                                                <tr>
                                                                    <th>id-pago</th>
                                                                    <th>proyecto</th>
                                                                    <th>condominio</th>
                                                                    <th>lote</th>
                                                                    <th>referencia</th>
                                                                    <th>precio-del-lote</th>
                                                                    <th>total-comision</th>
                                                                    <th>monto-descuento</th>
                                                                    <th>tipo</th>
                                                                    <th>acciones</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
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
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_colaborador.js"></script>

    <script>
        var usuario_id = <?= $this->session->userdata('id_usuario') ?>;
    </script>

    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

	<!-- <script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_prestamos.js"></script> -->
	<script type="text/javascript">
		Shadowbox.init();
	</script>
</body>