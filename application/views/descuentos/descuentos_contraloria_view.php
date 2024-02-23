<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
            .msj{
                z-index: 9999999;
            }
        </style>
        <?php $this->load->view('descuentos/complementos_contraloria_descuento/panel_contraloria_modal'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                            <?php $this->load->view('descuentos/complementos_contraloria_descuento/dash_contraloria_comple'); ?>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>USUARIO</th>
                                                    <th>DESCUENTO</th>
                                                    <th>LOTE</th>
                                                    <th>MOTIVO</th>
                                                    <th>MOTIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th>CREADO POR</th>
                                                    <th>FECHA DE CAPTURA</th>
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
	<script src="<?=base_url()?>dist/js/controllers/descuentos/descuentos_contraloria.js"></script>
</body>