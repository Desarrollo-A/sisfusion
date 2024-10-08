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

    <div class="modal fade modal-alertas" id="modal_nuevas_seguros" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form_interes_seguros">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_nuevas_casas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form_interes_casas">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_refresh" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="form_refresh">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_multiples" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_multiples">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_multiples_intmexA_seguros" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_multiples_seguros">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade modal-alertas" id="modal_multiples_intmexA_casas" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_multiples_casas">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="documento_preview" role="dialog">
        <div class="modal-dialog" style= "margin-top:20px;"></div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                    <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos lotes</a></li>
                    <!-- <li><a href="#proceso-1" role="tab" data-toggle="tab">Pagos ooam</a></li> -->
                    <li><a href="#intmex_seguros" role="tab" data-toggle="tab">Pagos lotes seguros</a></li>
                    <li><a href="#intmex_casas" role="tab" data-toggle="tab">Pagos Casas</a></li>
                </ul>
                <div class="card no-shadow m-0 border-conntent__tabs">
                    <div class="card-content p-0">
                        <div class="nav-tabs-custom">
                            <div class="tab-content p-2">
                                <div class="tab-pane active" id="nuevas-1">
                                    <div class="card-content" style="justify-content: space-between">  
                                        <div class="text-center">  
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align">Comisiones nuevas <b>asimiliados</b></h3>
                                            </div>
                                            <div>
                                                <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de asimilados)</p>
                                            </div>
                                        </div>
                                        <div class="toolbar">
                                            <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <div class="form-group d-flex justify-center align-center">
                                                        <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                        <p class="input-tot pl-1" name="totpagarAsimilados" id="totpagarAsimilados">$0.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <div class="form-group d-flex justify-center align-center">
                                                        <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                        <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row aligned-row d-flex align-end">
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label" for="puestoAsimilados">Puesto</label>
                                                        <select name="puestoAsimilados" id="puestoAsimilados" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label class="control-label" for="usuarioAsimilados">Usuario</label>
                                                        <select class="selectpicker select-gral" id="usuarioAsimilados" name="usuarioAsimilados[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                                                    <div class="form-group w-100">
                                                        <button type="button" class="btn-gral-data Pagar">Pagar masivamente</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                    <div class="form-group">
                                                        <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>ID</th>
                                                                    <th>PROYECTO</th>
                                                                    <th>CONDOMINIO</th>
                                                                    <th>LOTE</th>
                                                                    <th>REFERENCIA</th>
                                                                    <th>PRECIO DEL LOTE</th>
                                                                    <th>EMPRESA</th>
                                                                    <th>TOTAL COMISIÓN</th>
                                                                    <th>PAGO DEL CLIENTE</th>
                                                                    <th>SOLICITADO</th>
                                                                    <th>IMPUESTO</th>
                                                                    <th>DESCUENTO</th>
                                                                    <th>A PAGAR</th>
                                                                    <th>TIPO DE VENTA</th>
                                                                    <th>USUARIO</th>
                                                                    <th>RFC</th>
                                                                    <th>PUESTO</th>
                                                                    <th>CÓDIGO POSTAL</th>
                                                                    <th>FECHA DE ENVÍO</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view('pagos/seguros_internomex/revision_asimilados_intmex_ooam_view'); ?>
                                <?php $this->load->view('pagos/seguros_internomex/revision_asimilados_intmex_seguros_view'); ?>
                                <?php $this->load->view('pagos/casas_internomex/revision_asimilados_intmex_casas_view'); ?>
                                
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
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_asimilados_intmex.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/seguros_internomex/revision_asimilados_intmex_seguros.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/casas_internomex/revision_asimilados_intmex_casas.js"></script>
</body>