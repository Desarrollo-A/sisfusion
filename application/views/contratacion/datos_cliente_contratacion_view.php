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
                            <h4 class="card-title text-center">Ventas compartidas</h4>
                        </b>
                        <div class="material-datatables">
                            <div class="form-group">
                                <table id="tabla_clientes_detalles" name="tabla_clientes_detalles" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>DIRECTOR REGIONAL 2</th>
                                            <th>FECHA DE ALTA</th>
                                            <th>USUARIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
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
                                <h3 class="card-title center-align">Registro de clientes</h3>
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
                                        <table class="table-striped table-hover hide" id="tabla_clientes" name="tabla_clientes">
                                            <thead>
                                                <tr>
                                                    <th>MÁS</th>
                                                    <th>ID CLIENTE</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>NÚMERO DE RECIBO</th>
                                                    <th>REFERENCIA</th>
                                                    <th>TIPO DE PAGO</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>ENGANCHE</th>
                                                    <th>FECHA DE ENGANCHE</th>
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
    <script src="<?=base_url()?>dist/js/controllers/contratacion/datos_cliente_contratacion.js"></script>
</body>