
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="preguntaConfirmacion" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText">¿Desea fusionar los siguientes lotes para proceso de reubicación?</h5>
                        <p id="txtLotes"></p>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="fusionarLotes" class="btn btn-primary">Guardar</button>
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
                                <i class="fas fa-caret-square-o-down fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Originación de cartera</h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>
                                
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>ID LOTE</th>
                                            <th>NOMBRE LOTE</th>
                                            <th>CONDOMINIO</th>
                                            <th>PROYECTO</th>
                                            <th>NOMBRE CLIENTE</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>

    <script src="<?= base_url() ?>dist/js/controllers/casas/cartera.js"></script>
</body>