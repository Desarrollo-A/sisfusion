<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_colaboradores">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">EDITAR INFORMACIÓN</h4>
                    </div>
                    <form method="post" id="form_MKTD">
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
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos Solicitados</a></li>
                        </ul>
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="card-content">
                                                <div class="encabezadoBox">
                                                    <h3 class="card-title center-align" >Comisiones nuevas <b>Factura Extranjero</b></h3>
                                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de Factura Extranjero)</p>
                                                </div>
                                                <div class="toolbar">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="totpagarextranjero" id="totpagarextranjero">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0 hide">Autorizar:</h4>
                                                                <p class="input-tot pl-1 hide" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                            <div class="form-group">
                                                                <label class="control-label" for="catalogoFacturaE">Proyecto</label>
                                                                <select name="catalogoFacturaE" id="catalogoFacturaE" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                            <div class="form-group">
                                                                <label class="control-label" for="condominioFacturaEx">Condominio</label>
                                                                <select class="selectpicker select-gral" id="condominioFacturaEx" name="condominioFacturaEx[]" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required/></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover" id="tabla_extranjero" name="tabla_extranjero">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>ID</th>
                                                                    <th>PROYECTO</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>PRECIO DE LOTE</th>
                                                                    <th>EMPRESA</th>
                                                                    <th>TOTAL COMISIÓN</th>
                                                                    <th>PAGO DEL CLIENTE</th>
                                                                    <th>A PAGAR</th>
                                                                    <th>TIPO DE VENTA</th>
                                                                    <th>USUARIO</th>
                                                                    <th>RFC</th>
                                                                    <th>PUESTO</th>
                                                                    <th>FECHA DE ENVÍO</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="text-center">
                                                <h3 class="card-title center-align">Comprobantes fiscales</h3>
                                                <p class="card-title pl-1"> Correspondientes a usuarios con Nacionalidad Extranjera</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total</h4>
                                                                <p class="input-tot pl-1" id="myText_proceso">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>USUARIO</th>
                                                            <th>RFC</th>
                                                            <th>TOTAL</th>
                                                            <th>FORMA DE PAGO</th>
                                                            <th>NACIONALIDAD</th>
                                                            <th>ESTATUS</th>
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
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/pago_extranjero_intmex.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script>
        Shadowbox.init();
    </script>
</body>