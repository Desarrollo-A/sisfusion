<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <div class="row" style="text-align: center">
                            <h3>Consulta en NEODATA</h3>
                        </div>
                    </div>
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content"> 
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <h5>¿Estás segura de hacer este movimiento? </h5>
                            <p style="font-size: 0.8em">Marcarás este lote para solicitar que se disperese la comisión.</p>
                        </div>
                        <input id="idLote" class="hide">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="sendRequestCommissionPayment">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <div id="nameLote"></div>                            
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Cobranza master v2</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group d-flex">
                                                <input type="number" class="form-control idLote" id="idLote" placeholder="ID lote"/>
                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByLote"><span class="material-icons">search</span></button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-cobranzaHistorial">
                                    <div class="form-group">
                                        <table  class="table-striped table-hover hide" id="cobranzaHistorial" name="cobranzaHistorial">
                                            <thead>
                                                <tr>
                                                    <th>ID PAGO</th>
                                                    <th>ID LOTE</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA DEL LOTE</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>TOTAL DE LA COMISIÓN</th>
                                                    <th>PAGO DEL CLIENTE </th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>ESTATUS DE CONTRATACIÓN</th>
                                                    <th>ESTATUS DE PAGO COMISIÓN</th>
                                                    <th>ESTATUS DE COMISIÓN</th>
                                                    <th>ESTATUS LOTE/VENTA</th>
                                                    <th>DISPERSADO</th>
                                                    <th>PAGO HISTÓRICO </th>
                                                    <th>PENDIENTE</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>PLAZA</th>
                                                    <th>LUGAR DE PROSPECCIÓN</th>
                                                    <th>DETALLE</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/cobranza/cobranza.js"></script> 
</body>