<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
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

    <div class="content boxContent">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                    <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Facturas lotes</a></li>
                    <li><a href="#proceso-1" role="tab" data-toggle="tab">Facturas ooam</a></li>
                </ul>
            <div class="card no-shadow m-0 border-conntent__tabs">
                <div class="card-content p-0">
                    <div class="nav-tabs-custom">
                        <div class="tab-content p-2">
                            <div class="tab-pane active" id="nuevas-1">
                                <div class="card-content">  
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Comisiones nuevas <b>factura</b></h3>
                                        <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de facturacion)</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarremanente" id="totpagarremanente">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group">
                                                    <label class="control-label" for="catalogoFac">Proyecto</label>
                                                    <select name="catalogoFac" id="catalogoFac" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                                                <div class="form-group">
                                                    <label class="control-label" for="condominioFac">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="condominioFac" name="condominioFac[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
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
                                                            <th>PAGADO POR EL CLIENTE</th>
                                                            <th>TOTAL A PAGAR</th>
                                                            <th>TIPO DE VENTA</th>
                                                            <th>USUARIO</th>
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
                                </div>
                            </div>
                            <div class="tab-pane" id="proceso-1">
                                <div class="text-center">
                                <h3 class="card-title center-align" >Comisiones nuevas <b>factura Ooam</b></h3>
                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de facturacion)</p>
                                </div>
                                    <div class="toolbar">
                                        <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPenOoam" id="totpagarPenOoam">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPenOoam" id="totpagarPenOoam">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row aligned-row d-flex align-end">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="catalogoFacOoam">Proyecto</label>
                                                    <select name="catalogoFacOoam" id="catalogoFacOoam" class="selectpicker select-gral m-0" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="condominioFacOoam">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="condominioFacOoam" name="condominioFacOoam[]" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table-striped table-hover" id="tabla_factura_ooam" name="tabla_factura_ooam">
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
                                                    <th>PAGADO POR EL CLIENTE</th>
                                                    <th>TOTAL A PAGAR</th>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>USUARIO</th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_factura.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ooam/revision_factura_ooam.js"></script>
</body>