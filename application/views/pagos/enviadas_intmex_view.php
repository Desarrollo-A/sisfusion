<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <!-- Modals -->
        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <div id="nameLote"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
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
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones enviadas <b>internomex</b></h3>
                                    <p class="card-title pl-1">(Comisiones ya validadas por contraloría, solicitadas a Internomex para proceder a pago)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarAsimilados" id="totpagarAsimilados">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label" for="id_proyecto_ei">Proyecto</label>
                                                    <select name="id_proyecto_ei" id="id_proyecto_ei" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label" for="id_condominio_ei">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="id_condominio_ei" name="id_condominio_ei[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label" for="forma-pago-filtro">Forma de pago</label>
                                                    <select name="forma-pago-filtro" id="forma-pago-filtro" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
                                            <thead>
                                                <tr>
                                                    <th>ID PAGO</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>EMPRESA</th>
                                                    <th>TOTAL DE LA COMISIÓN</th>
                                                    <th>PAGO DEL CLIENTE</th>
                                                    <th>DESCUENTO</th>
                                                    <th>TOTAL A PAGAR</th>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>FORMA DE PAGO</th>
                                                    <th>FECHA DE ENVÍO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/enviadas_internomex.js"></script>
</body>