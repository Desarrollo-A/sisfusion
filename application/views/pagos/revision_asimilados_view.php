<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
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
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
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

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <!--END MODALS-->

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
                                    <h3 class="card-title center-align" >Comisiones nuevas <b>asimilados</b></h3>
                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de asimilados)</p>
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
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row aligned-row d-flex align-end">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="filtro33">Proyecto</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral m-0" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="filtro44">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="filtro44" name="filtro44[]" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="material-datatables">
                                            <div class="form-group">
                                                <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>ID PAGO</th>
                                                            <th>PROYECTO</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>REFERENCIA</th>
                                                            <th>PRECIO DEL LOTE</th>
                                                            <th>EMPRESA</th>
                                                            <th>TOTAL DE LA COMISIÓN</th>
                                                            <th>PAGO DEL CLIENTE</th>
                                                            <th>SOLICITADO</th>
                                                            <th>IMPUESTO</th>
                                                            <th>DESCUENTO</th>
                                                            <th>TOTAL A PAGAR</th>
                                                            <th>TIPO DE VENTA</th>
                                                            <th>USUARIO</th>
                                                            <th>PUESTO</th>
                                                            <th>CÓDIGO POSTAL</th>
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
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/pagos/revision_asimilados.js"></script>
</body>
