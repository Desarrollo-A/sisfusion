<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>
    <div class="content boxContent ">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-expand fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Contrato firmado </h3>
                                <p class="card-title pl-1">(estatus 12)</p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <?php 
                                    if ($this->session->userdata('id_rol') != "63"){?>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3 pb-5">
                                        <button class="btn-gral-data sendCont">Enviar contratos<i class="fas fa-paper-plane pl-1"></i></button>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_ingresar_12" name="tabla_ingresar_12" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CÓDIGO</th>
                                                <th>CLIENTE</th>
                                                <th>TOTAL NETO</th>
                                                <th>TOTAL VALIDADO</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content" >
                                        <div class="modal-body">
                                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label>Ingresa los códigos de los contratos firmados: </label>
                                                <textarea name="txt" id="contratos" onkeydown="saltoLinea(value); return true;" class="form-control" style="text-transform:uppercase; min-height: 400px;width: 100%"></textarea><br><br>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btn_show" class="btn btn-success"><span class="material-icons">send</span> </i> Enviar Contratos</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                            <br>
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
    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Contrato firmado (estatus 12)</h4>
                            <div class="toolbar"></div>
                            <div class="material-datatables">
                                <div class="form-group">
									<div class="modal fade" id="enviarContratos" data-backdrop="static" data-keyboard="false">
										<div class="modal-dialog modal-md">
											<div class="modal-content" >
												<div class="modal-body">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<label>Ingresa los códigos de los contratos firmados: </label>
														<textarea name="txt" id="contratos" onkeydown="saltoLinea(value); return true;" class="form-control" style="text-transform:uppercase; min-height: 400px;width: 100%"></textarea><br><br>
													</div>
												</div>
                                                <div class="modal-footer">												
                                                    <button type="button" id="btn_show" class="btn btn-success"><span class="material-icons">send</span> </i> Enviar Contratos</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                                                    <br>
                                                </div>
											</div>
										</div>
									</div>
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <button class="btn btn-primary sendCont">Enviar contratos <span class="material-icons">chevron_right</span></button>
                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_12" name="tabla_ingresar_12" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CÓDIGO</th>
                                                        <th>CLIENTE</th>
                                                        <th>TOTAL NETO</th>
                                                        <th>TOTAL VALIDADO</th>
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
    <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_12_contraloria.js"></script>
