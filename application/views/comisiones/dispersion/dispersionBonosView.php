<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="dispersionComer">
                                            <div class="card-content">
                                                <div class="encabezadoBox">
                                                    <h3 class="h3 card-title center-align" >Dispersión de pagos bonos</h3>
                                                    <p class="card-title pl-1 center-align"></p>
                                                </div>
                                                <div class="toolbar">
                                                        <div class="toolbar">
                                                            <div class="container-fluid p-0">
                                                                <div class="row">
                                                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group text-center">
                                                                            <h4 class="title-tot center-align m-0">Saldo sin impuestos:</h4>
                                                                            <p class="input-tot" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group text-center">
                                                                            <h4 class="title-tot center-align m-0">Solicitar:</h4>
                                                                            <p class="input-tot" id="totpagarPen">$0.00</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="container-fluid p-0">
                                                        <div class="material-datatables">
                                                            <div class="form-group">
                                                                <table class="table-striped table-hover" id="tabla_dispersar_comisiones" name="tabla_dispersar_comisiones">
                                                                    <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                            <th>ID PAGO</th>
                                                                            <th>PROYECTO</th>
                                                                            <th>LOTE</th>
                                                                            <th>COSTO CONSTUCCIÓN</th>
                                                                            <th>TOTAL DE LA COMISIÓN</th>
                                                                            <th>PAGADO DEL CLIENTE</th>
                                                                            <th>DISPERSADO</th>
                                                                            <th>SALDO A COBRAR</th>
                                                                            <th>% COMISIÓN</th>
                                                                            <th>DETALLE</th>
                                                                            <th>ESTATUS</th>
                                                                            <th>ACCIONES</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                <!--  -->
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
        </div>


        <!--MODALS--->
                <div class="modal fade" id="modalDispersion" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <form method="post" class="row" id="formDispersion" autocomplete="off">
                            <div class="modal-header" id="mHeader"></div>
                                <div class="modal-body pb-0 pt-0"></div>
                                <div class="modal-footer">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" id="btnSubmit" class="btn btn-primary">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="modalAsignacion" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <form method="post" class="row" id="formAsignacion" autocomplete="off">
                            <div class="modal-header" id="mHeader"></div>
                                <div class="modal-body pb-0 pt-0"></div>
                                <div class="modal-footer">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" id="btnsubA" class="btn btn-primary">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        <!-------->
    <?php $this->load->view('template/footer_legend');?>
</div>
<?php $this->load->view('template/footer');?>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/dispersion/casas/dispersion_bonos.js"></script>
</body>