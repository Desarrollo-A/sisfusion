<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="modal_bonos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <img src="<?=base_url()?>static/images/warning.png" width="300" height="300">
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Bonos activos</h3>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Bonos activos:</h4>
                                                    <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" id="totpagarPen" name="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class=" table-striped table-hover" id="tabla_bono_revision" name="tabla_bono_revision">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>MONTO DEL BONO</th>
                                                    <th>ABONADO</th>
                                                    <th>PENDIENTE</th>
                                                    <th>TOTAL DE PAGOS</th>
                                                    <th>PAGO INDIVIDUAL</th>
                                                    <th>IMPUESTO</th>
                                                    <th>TOTAL A PAGAR</th>
                                                    <th>ESTATUS</th>
                                                    <th>COMENTARIO</th>
                                                    <th>FECHA DE REGISTRO</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/pagos/bonos_solicitados.js"></script>
</body>