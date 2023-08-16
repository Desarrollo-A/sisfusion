<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
    
        <!-- Modals -->

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
        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">EDITAR INFORMACIÓN< /h4>
                    </div>
                    <form method="post" id="form_MKTD">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalExtranjero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanComments()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                                <div id="nameLote"></div>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list-extranjero"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">        
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Pagos Solicitados</a></li>
                            <li><a href="#proceso-1" role="tab" data-toggle="tab">Invoice</a></li>
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
                                                    <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                    <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro33">Proyecto</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required>
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro44">Condominio</label>
                                                    <select class="selectpicker select-gral" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required/></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_extranjero" name="tabla_extranjero">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>ID</th>
                                                            <th>PROY.</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>LOTE</th>
                                                            <th>REFERENCIA</th>
                                                            <th>PRECIO LOTE</th>
                                                            <th>EMP.</th>
                                                            <th>TOT. COM.</th>
                                                            <th>P. CLIENTE</th>
                                                            <th>A PAGAR</th>
                                                            <th>TIPO VENTA</th>
                                                            <th>USUARIO</th>
                                                            <th>PUESTO</th>
                                                            <th>FEC. ENVÍO</th>
                                                            <th>MÁS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
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
                                                <div class="table-responsive">
                                                <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>USUARIO</th>
                                                        <th>TOTAL</th>
                                                        <th>FORMA DE PAGO</th>
                                                        <th>NACIONALIDAD</th>
                                                        <th>ESTATUS</th>
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
        </div>
    <?php $this->load->view('template/footer_legend');?>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="<?= base_url() ?>dist/js/controllers/pagos/pago_extranjero.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script>
        Shadowbox.init();
    </script>
    <script>
                                          
    </script>
</body>