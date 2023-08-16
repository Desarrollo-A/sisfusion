<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul>
                                <div id="nameLote"></div>
                            </ul>
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

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_despausar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_despausar">
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

        <div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row"></div>
                    </div>
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

        <div class="modal fade bd-example-modal-sm" id="myModalTQro" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
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
                                    <h3 class="card-title center-align" >Comisiones solicitadas</h3>
                                    <p class="card-title pl-1">(Comisiones solicitadas para proceder a pago)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="totpagarAsimilados" id="totpagarAsimilados">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_asimilados" name="tabla_asimilados">
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
    <script src="<?= base_url() ?>dist/js/controllers/ventas/general_Intmex.js"></script>
</body>
