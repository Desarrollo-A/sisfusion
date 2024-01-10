<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="modal_agregar_mktd" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header text-center">
                        <h4 class="modal-title" id="modal-mktd-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12 mb-1">
                                <label class="control-label">Comentario</label>
                                <textarea class="text-modal" type="text" id="comments" rows="3"></textarea>
                                <br>
                                <input id="id_lote" class="hidden">
                                <input id="type_transaction" class="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CANCELAR</button>
                        <button type="button" id="add-remove-mktd" class="btn btn-primary">ACEPTAR</button>
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
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Agregar o remover <b>MKTD</b></h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID LOTE</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TIPO VENTA</th>
                                                    <th>MODALIDAD</th>
                                                    <th>ESTATS CONTRATACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/cambioComisionAgente.js"></script>
</body>