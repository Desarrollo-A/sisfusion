<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_NEODATA_reubicadas" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA_reubicadas">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>


        <!-- modal verifyNEODATA -->
        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" data-i18n="comisiones-detenidas">Comisiones detenidas</h3>
                                    <p class="card-title pl-1" data-i18n="comisiones-detenidas-info">
                                        Lotes detenidos por alguna controversia presentada durante el proceso de comisiones.
                                    </p>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover"id="comisiones-detenidas-table">
                                            <thead>
                                            <tr>
                                                    <th></th>
                                                    <th>proyecto</th>
                                                    <th>condominio</th>
                                                    <th>lote</th>
                                                    <th>id-lote</th>
                                                    <th>cliente</th>
                                                    <th>tipo-venta</th>
                                                    <th>modalidad</th>
                                                    <th>contratacion</th>
                                                    <th>plan-venta</th>
                                                    <th>detalles</th>
                                                    <th>fecha-actualizacion</th>
                                                    <th>acciones</th>
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
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/comisiones_detenidas.js"></script>
</body>
