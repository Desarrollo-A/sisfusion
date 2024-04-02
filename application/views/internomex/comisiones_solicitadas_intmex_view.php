<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

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
                                                                    <ul class="timeline-3" id="comments-list-pagos"></ul>
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

                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div class="text-center">
                                        <h3 class="card-title center-align pt-3 pr-2">Comisiones solicitadas</h3>
                                        <p class="card-title pr-2 ">(Comisiones solicitadas para proceder a pago)</p>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot text-center">Disponible:</h4>
                                                    <p class="input-tot pl-4" name="totalDisponible" id="totalDisponible">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="comisiones_solicitadas" name="comisiones_solicitadas">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID PAGO</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>NOMBRE DEL LOTE </th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>EMPRESA</th>
                                                    <th>IMPUESTO</th>
                                                    <th>DESCUENTO</th>
                                                    <th>TOTAL A PAGAR</th>
                                                    <th>COMISIONISTA</th>
                                                    <th>PUESTO</th>
                                                    <th>SEDE</th>
                                                    <th>RFC</th>
                                                    <th>FORMA DE PAGO</th>
                                                    <th>FECHA DE ENVÍO</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/internomex/comisiones_solicitadas_Intmex.js"></script>
</body>
