<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">

<body>
    <div class="wrapper"> 
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="fechaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" id="aceptarFecha">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="titleFecha" class="modal-title w-100 text-center"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="content boxContent">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="card no-shadow m-0">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control datepicker fechaEntrega" id="fechaEntrega"/> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmarModal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 id="titleConfirmar" class="modal-title w-100 text-center"></h4>
                    </div>

                    <form id="fechaEntrega" name="fechaEntrega" method="post">
                        <div class="modal-body" id="modal-body">
                        </div>
                        <input type="hidden" id="idCliente" name="idCliente"/>
                        <input type="hidden" id="idLote" name="idLote" />
                        <input type="hidden" id="idAccion" name="idAccion" />
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnEntrega">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card card no-shadow m-0" > 
                            <div class="card-content">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="solicitudes">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align">Inventario lotes</h3>
                                            </div>
                                            <div class="toolbar">
                                                <div  class="row">
                                                     <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idResidencial">Proyecto</label>
                                                            <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                            <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <div class="form-group overflow-hidden">
                                                            <label class="control-label" for="idEstatus">Estatus</label>
                                                            <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <table class="table-striped table-hover hide" id="tablaInventario" name="tablaInventario">
                                                    <thead>
                                                        <tr>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>ID LOTE</th>
                                                            <th>SUPERFICIE</th>
                                                            <th>PRECIO DE LISTA</th>
                                                            <th>TOTAL CON DESCUENTOS</th>
                                                            <th>M2</th>
                                                            <th>REFERENCIA</th>
                                                            <th>MSI</th>
                                                            <th>ASESOR</th>
                                                            <th>COORDINADOR</th>
                                                            <th>GERENTE</th>
                                                            <th>SUBDIRECTOR</th>
                                                            <th>DIRECTOR REGIONAL</th>
                                                            <th>DIRECTOR REGIONAL 2</th>
                                                            <th>ESTATUS</th>
                                                            <th>APARTADO</th>
                                                            <th>COMENTARIO</th>
                                                            <th>LUGAR DE PROSPECCIÓN</th>
                                                            <th>FECHA DE VALIDACIÓN ENGANCHE</th>
                                                            <th>CANTIDAD DE ENGANCHE PAGADO</th>
                                                            <th>ESTATUS DE LA CONTRATACIÓN</th>
                                                            <th>CLIENTE</th>
                                                            <th>COPROPIETARIO (S)</th>
                                                            <th>COMENTARIO DE NEODATA</th>
                                                            <th>FECHA DE APERTURA</th>
                                                            <th>APARTADO DE REUBICACIÓN</th>
                                                            <th>FECHA DE ALTA</th>
                                                            <th>VENTA COMPARTIDA</th>
                                                            <th>UBICACIÓN DE LA VENTA</th>
                                                            <th>TIPO DE PROCESO</th>
                                                            <th>SEDE</th>
                                                            <th>FECHA ENTREGA</th>
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
            </div>
        </div>
    <?php $this->load->view('template/footer_legend'); ?>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>

<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contratacion/panelNuevo.js"></script>
</html>