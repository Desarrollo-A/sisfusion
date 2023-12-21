<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_colaboradores">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_mktd">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Plaza 1</label>
                                    <select name="plaza1" id="plaza1" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Plaza 2</label>
                                    <select name="plaza2" id="plaza2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones nuevas</h3>
                                    <p class="card-title pl-1">(Pagos dispersados por el área de contraloría, disponibles para revisión)</p>
                                </div>
                                <div class="material-datatables">
                                    <div class="container-fluid encabezado-totales">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12 no-shadow"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">DISPONIBLE</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="myText_nuevas" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">ENVIAR A VALIDACIÓN</h4>
                                                        <p class="text-center"><i class="far fa-hand-point-right"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="totpagarPen" style="font-size:30px" value="$0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12 no-shadow"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>ID LOTE</th>
                                                        <th>NOMBRE LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COM. ($)</th>
                                                        <th>PAGO CLIENTE</th>
                                                        <th>ABONO NEO.</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>FEC. APARTADO</th>
                                                        <th>DETALLE</th>
                                                        <th>SEDE</th>
                                                        <th>SEDE COMISIÓN</th>
                                                        <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script <script src="<?=base_url()?>dist/js/controllers/ventas/revision_cobranza_mktd.js"></script>></script>
</body>