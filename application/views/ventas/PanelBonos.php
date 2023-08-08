<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade modal-alertas" id="modal_bonos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_bonos">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas " id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header"></div>

                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas-1" role="tab" data-toggle="tab">
                                    NUEVOS
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-1" role="tab" data-toggle="tab">
                                    EN REVISIÓN
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-2" role="tab" data-toggle="tab">
                                    POR PAGAR
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-3" role="tab" data-toggle="tab">
                                    OTROS
                                </a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">

                                    <!-- TABLA NUEVOS -->
                                        <div class="tab-pane active" id="nuevas-1">
                                            
                                        <div class="material-datatables">
                                            <div class="form-group">
                                                <div class="toolbar">
                                                    <div class="container-fluid p-0">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="form-group d-flex justify-center align-center">
                                                                    <h4 class="title-tot center-align m-0">Bonos Nuevos
                                                                        <a href="https://youtu.be/wLDdDHQjCrw" target="_blank" style="color:red">
                                                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                                        </a>
                                                                    </h4>
                                                                    <p class="input-tot pl-1" name="totalnuevos" id="totalnuevos">$0.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table-striped table-hover" id="tabla_nuevos" name="tabla_nuevos">
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
                                                                <th>OPCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- TABLA NUEVOS FINAL-->

                                    <!-- TABLA REVISIÓN -->
                                    <div class="tab-pane" id="proceso-1">
                                            
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="toolbar">
                                                        <div class="container-fluid p-0">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="form-group d-flex justify-center align-center">
                                                                        <h4 class="title-tot center-align m-0">Bonos Revisión
                                                                            <a href="https://youtu.be/wLDdDHQjCrw" target="_blank" style="color:red">
                                                                                <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                                            </a>
                                                                        </h4>
                                                                        <p class="input-tot pl-1" name="totalrevision" id="totalrevision">$0.00</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                         
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
                                                                    <th>OPCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- TABLA REVISIÓN FINAL-->

                                        <div class="tab-pane" id="proceso-2">
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Bonos por pagar
                                                                    <a href="https://youtu.be/wLDdDHQjCrw" target="_blank" style="color:red">
                                                                        <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                                    </a>
                                                                </h4>
                                                                <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_bonos_porpagar" name="tabla_bonos_porpagar">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>MONTO DE BONO</th>
                                                                <th>ABONADO</th>
                                                                <th>PENDIENTE</th>
                                                                <th>TOTAL DE PAGOS</th>
                                                                <th>PAGO INDIVIDUAL</th>
                                                                <th>IMPUESTO</th>
                                                                <th>TOTAL A PAGAR</th>
                                                                <th>ESTATUS</th>
                                                                <th>FECHA DE REGISTRO</th>
                                                                <th>OPCIONES</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-3">
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Bonos Otros (Cancelados, pausa)
                                                                    <a href="https://youtu.be/wLDdDHQjCrw" target="_blank" style="color:red">
                                                                        <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                                                    </a>
                                                                </h4>
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
                                                                <th>MONTO DE BONO</th>
                                                                <th>ABONADO</th>
                                                                <th>PENDIENTE</th>
                                                                <th>TOTAL DE PAGOS</th>
                                                                <th>PAGO INDIVIDUAL</th>
                                                                <th>IMPUESTO</th>
                                                                <th>TOTAL A PAGAR</th>
                                                                <th>ESTATUS</th>
                                                                <th>FECHA DE REGISTRO</th>
                                                                <th>OPCIONES</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/ventas/panelBonos.js"></script>
</body>