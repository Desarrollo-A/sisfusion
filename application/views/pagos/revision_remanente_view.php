

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
                <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos lotes</a></li>
                <li><a href="#proceso-1" role="tab" data-toggle="tab">Pagos ooam</a></li>
            </ul>
            <div class="card no-shadow m-0 border-conntent__tabs">
                <div class="card-content p-0">
                    <div class="nav-tabs-custom">
                        <div class="tab-content p-2">
                            <div class="tab-pane active" id="nuevas-1">
                                <div class="card-content">  
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align" >Comisiones nuevas <b>remanente</b></h3>
                                        <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago como ventas remanente)</p>
                                    </div>
                                    <div class="toolbar">
                                        <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarremanente" id="totpagarremanente">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="catalogoRem">Proyecto</label>
                                                    <select name="catalogoRem" id="catalogoRem" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="condominioRem">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="condominioRem" name="condominioRem[]" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_remanente" name="tabla_remanente">
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
                                                                <th>TOTAL DE LA COMPRA</th>
                                                                <th>PAGO DEL CLIENTE</th>
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
                                    <h3 class="card-title center-align" >Comisiones nuevas <b>OOAM</b></h3>
                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de remanente)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <div class="form-group d-flex justify-center align-center">
                                                        <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                        <p class="input-tot pl-1" name="totpagarremanenteOoam" id="totpagarremanenteOoam">$0.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
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
                                                    <label class="control-label" for="catalogoRemOoams">Proyecto</label>
                                                    <select name="catalogoRemOoams" id="catalogoRemOoams" class="selectpicker select-gral m-0" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="condominioRemOoams">Condominio</label>
                                                    <select class="selectpicker select-gral m-0" id="condominioRemOoams" name="condominioRemOoams[]" data-style="btn " data-container="body" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                            <table class="table-striped table-hover" id="tabla_remanente_ooam" name="tabla_remanente_ooam">
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
                                                        <th>TOTAL DE LA COMPRA</th>
                                                        <th>PAGO DEL CLIENTE</th>
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
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_remanente.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ooam/revision_remanente_ooam.js"></script>
</body>
</body>