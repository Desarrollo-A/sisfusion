<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
            <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Inventario lotes reestructura</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label overflow-hidden" for="estatus_lotes">Estatus</label>
                                                <select name="estatus_lotes" id="estatus_lotes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"></div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="tabla_inventario" name="tabla_inventario" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE VENTA</th>
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>GERENTE</th>
                                                <th>RL</th>
                                                <th>ESTATUS</th>
                                                <th>MOVIMIENTO</th>
                                                <th>UBICACIÓN</th>
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
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/inventarioLote.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script>
    Shadowbox.init();
</script>