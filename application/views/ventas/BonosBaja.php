<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <!-- Modals -->
        <div class="modal fade modal-alertas" id="modal_bonos" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modalBonos2" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center>
                            <img src="<?= base_url() ?>static/images/autor.png" width="200" height="200">
                        </center>
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
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas-1" role="tab" data-toggle="tab">
                                    <i class="fas fa-file-alt"></i> NUEVOS
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-1" role="tab" data-toggle="tab">
                                    <i class="fa fa-clipboard" aria-hidden="true"></i> EN REVISIÓN
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-2" role="tab" data-toggle="tab">
                                    <i class="fas fa-coins"></i> POR PAGAR
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-3" role="tab" data-toggle="tab">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> OTROS
                                </a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <h3 class="card-title center-align">Nuevos bonos</h3>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
                                                        <thead>
                                                            <tr>
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
                                                                <th>FECHA DE REGISTRO</th>
                                                                <th>ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ///////////////// -->
                                        <div class="tab-pane" id="proceso-1">
                                            <h3 class="card-title center-align">Bonos en revisión</h3>    
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_bono_revision" name="tabla_bono_revision">
                                                        <thead>
                                                            <tr>
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
                                                                <th>FECHA DE REGISTRO</th>
                                                                <th>ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>    
                                        <!-- /////////////// -->
                                        <div class="tab-pane" id="proceso-2">
                                            <h3 class="card-title center-align">Bonos pagados</h3>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Bonos pagados:</h4>
                                                                <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_bono_pagado" name="tabla_bono_pagado">
                                                        <thead>
                                                            <tr>
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
                                                                <th>FECHA DE REGISTRO</th>
                                                                <th>ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-3">
                                            <h3 class="card-title center-align">Otros</h3>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Bonos:</h4>
                                                                <p class="input-tot pl-1" name="totalo" id="totalo">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_bono_otros" name="tabla_bono_otros">
                                                        <thead>
                                                            <tr>
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
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/bonosBaja.js"></script>
</body>