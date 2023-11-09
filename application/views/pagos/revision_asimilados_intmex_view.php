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

        <div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">            
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones nuevas <b>asimiliados</b></h3>
                                    <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de asimilados)</p>
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
                                                    <select name="puestoAsimilados" id="puestoAsimilados" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required> 
                                                    </select>
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
                                                                <th>TOTAL DE LA COMPRA</th>
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
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label" for="puestoOoam">Puesto</label>
                                                    <select name="puestoOoam" id="puestoOoam" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label" for="UsuarioOoam">Usuario</label>
                                                    <select class="selectpicker select-gral" id="UsuarioOoam" name="UsuarioOoam[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                                                <div class="form-group w-100">
                                                    <button type="button" class="btn-gral-data Pagar">Pagar masivamente</button>
                                                </div>
                                            </div>
                                        </div>
                                      <table class="table-striped table-hover" id="tabla_asimilados_ooam" name="tabla_asimilados_ooam">
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
                                                <th>TOTAL DE LA COMPRA</th>
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
          </div>
        </div>
     </div>
    </div>

        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_asimilados_intmex.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ooam/revision_asimilados_intmex_ooam.js"></script>


</body>