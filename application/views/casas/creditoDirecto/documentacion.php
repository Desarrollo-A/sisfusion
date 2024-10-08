<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body  class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="contaier-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-card fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Documentacion del lote: <?php echo $lote->nombreLote ?></h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>

                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID DOC</th>
                                            <th>DOCUMENTO</th>
                                            <th> ARCHIVO </th>
                                            <th>FECHA DE CARGA</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <?php $this->load->view('template/modals'); ?>

    <script type="text/javascript">
        let idProceso = <?php echo $lote->idProceso; ?>
    </script>
    <script src="<?= base_url() ?>dist/js/controllers/casas/creditoDirecto/documentacion.js?v=2"></script>
</body>
