<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class=""></h5>
                    </div>
                    <form id="my-edit-form" name="my-edit-form" method="post">
                        <div class="modal-body">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <b>
                            <h4 class="card-title text-center">Detalle de enganche</h4>
                        </b>
                        <form class="card-content" id="formEnganches" name="formEnganches" method="POST">
                            <div class="modal-body pt-0">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">
                                                <label class="control-label label-gral">Lote (<small style="color: red;">*</small>)</label>
                                                <input id="txtIdLote" name="txtIdLote" data-idDetEnganche="0" data-idDetEngancheNuevo="0" class="form-control input-gral" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">
                                                <label class="control-label label-gral">Forma de pago (<small style="color: red;">*</small>)</label>
                                                <select class="selectpicker select-gral m-0" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="cmbFormaPago" name="cmbFormaPago" data-live-search="true">
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">

                                                <label class="control-label">Fecha (<small style="color: red;">*</small>)</label>
                                                <input type="text" class="form-control datepicker" id="txtFechaPago" name="txtFechaPago" placeholder="Seleccione una fecha" autocomplete="off" value="01/01/2024"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">
                                                <label class="control-label label-gral">Instrumento monetario (<small style="color: red;">*</small>)</label>
                                                <select class="selectpicker select-gral" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="cmbInsMonetario" name="cmbInsMonetario" data-live-search="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">
                                                <label class="control-label label-gral">Moneda divisa (<small style="color: red;">*</small>)</label>
                                                <select class="selectpicker select-gral" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="cmbMonedaDiv" name="cmbMonedaDiv" data-live-search="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-0">
                                            <div class="form-group text-left m-0">
                                                <label class="control-label label-gral">Monto Enganche (<small style="color: red;">*</small>)</label>
                                                <input id="montoEnganche" name="montoEnganche" class="form-control input-gral"
                                                       data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  step="any" type="text" >
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="idEnganche" name="idEnganche">
                                <input type="hidden" id="idCliente" name="idCliente">
                                <button type="button" id="cerrarModalEnganche" name="cerrarModalEnganche" class="btn btn-danger btn-simple" onclick="cerrarModalDetEnganche()" >Cancelar</button>
                                <button type="submit" id="RequestInformacion" class="btn btn-primary">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Enganches por lote</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label overflow-hidden" for="proyecto">Proyecto</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label" for="proyecto">Condominio</label>
                                                <select name="condominio" id="condominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="table_lotes_enganche" name="table_lotes_enganche">
                                            <thead>
                                                <tr>
                                                    <th>RESIDENCIAL</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE</th>
                                                    <th>NOMBRE CLIENTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>NOMBRE ASESOR</th>
                                                    <th>TIPO VENTA</th>
                                                    <th>UBICACIÓN</th>
                                                    <th>ENANCHE CONTRALORÍA</th>
                                                    <th>ENGANCHE ADMINISTRACIÓN</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?=base_url()?>dist/js/controllers/internomex/detEnganche.js"></script>
</body>