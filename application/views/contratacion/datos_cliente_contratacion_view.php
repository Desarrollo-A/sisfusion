<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b data-i18n="rechazar">Rechazar</b> <span data-i18n="estatus"> estatus. </span></h4>
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
                            <h4 class="card-title text-center" data-i18n="ventas-compartidas">Ventas compartidas</h4>
                        </b>
                        <div class="material-datatables">
                            <div class="form-group">
                                <table id="tabla_clientes_detalles" name="tabla_clientes_detalles" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>asesor</th>
                                            <th>coordinador</th>
                                            <th>gerente</th>
                                            <th>subdirectos</th>
                                            <th>director-regional</th>
                                            <th>director-regional-2</th>
                                            <th>fecha-alta</th>
                                            <th>usuario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-i18n="cerrar">CERRAR</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" data-i18n="registro-cliente">Registro de clientes</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label overflow-hidden" for="proyecto" data-i18n="proyecto">Proyecto</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label" for="proyecto" data-i18n="condominio">Condominio</label>
                                                <select name="condominio" id="condominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="tabla_clientes" name="tabla_clientes">
                                                <thead>
                                                    <tr>
                                                        <th>mas</th>
                                                        <th>id-cliente</th>
                                                        <th>proyecto</th>
                                                        <th>condominio</th>
                                                        <th>lote</th>
                                                        <th>cliente</th>
                                                        <th>correo</th>
                                                        <th>telefono</th>
                                                        <th>num-recibo</th>
                                                        <th>referencia</th>
                                                        <th>tipo-pago</th>
                                                        <th>fecha-apartado</th>
                                                        <th>enganche</th>
                                                        <th>fecha-enganche</th>
                                                        <th>acciones</th>
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
    <script src="<?=base_url()?>dist/js/controllers/contratacion/datos_cliente_contratacion.js"></script>
</body>