<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- modal  rechazar A CONTRALORIA 7-->
        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal" id="comentario" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" > 
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Registro estatus 14 - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                    <label>Comentario:</label>
                        <textarea class="text-modal" id="comentario1" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save2" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Registro estatus 14</h3>
                                    <p class="card-title pl-1">(Firma Acuse cliente)</p>
                                </div>
                                <div class="material-datatables"> 
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_ingresar_14" name="tabla_ingresar_14">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>TIPO DE PROCESO</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>GERENTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>SEDE</th>
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
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/contratacion/vista_14_contratacion.js"></script>
</body>