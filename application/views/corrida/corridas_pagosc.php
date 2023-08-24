<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<style>
    .active-pill{
        padding: 3px 20px;
        color: white;
        background-color: #34c759;
        border-radius: 12px;
        font-size: 0.8em;
    }
    .inactive-pill{
        padding: 3px 20px;
        color: white;
        background-color: #ff3b30;
        border-radius: 12px;
        font-size: 0.8em;
    }
</style>
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

        <div class="modal fade" id="avisoModal" >
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header text-center">
                        <h3 class="modal-title">¡Ya existe una corrida financiera activa!</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid pdt-50">
                            <div class="row centered center-align">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                    <h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-1x" aria-hidden="true"></i></h1><br><br>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                    <h3 class="modal-title" style="font-size: 2em">Actualmente ya hay una corrida financiera para este lote</h3>
                                    <h5 style="font-size: 1.5rem"><i> Puedes deshabilitar la corrida financiera actual, para habilitar la corrida financiera deseada</i></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <br><br>
                        <button type="button" class="btn btn-simple" data-dismiss="modal"> Aceptar </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title"></h4>
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Corridas financieras con pago a capital</h3>
                                    <div class="container-fluid">
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label">Proyecto</label>
                                                <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                                    <?php
                                                    if ($residencial != NULL) :
                                                        foreach ($residencial as $fila) : ?>
                                                            <option value=<?= $fila['idResidencial'] ?>> <?= $fila['nombreResidencial'] ?> </option>
                                                        <?php endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label">Condominio</label>
                                                <select id="filtro4" name="filtro4" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group overflow-hidden">
                                                <label class="control-label">Lote</label>
                                                <select id="filtro5" name="filtro5" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <table id="tableDoct" class="table-striped table-hover hide">
                                        <thead>
                                            <tr>
                                                <th>ID CORRIDA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>ID POR LOTE</th>
                                                <th>LOTE</th>
                                                <th>HORA/FECHA DE CREACIÓN</th>
                                                <th>RESPONSABLE</th>
                                                <th>ÚLTIMA MODIFICACIÓN POR</th>
                                                <th>ACCIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script type="text/javascript" src="<?=base_url()?>static/js/shadowbox.js"></script>
<script src="<?= base_url() ?>dist/assets/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/assets/js/dataTables.select.min.js"></script>
<script type="text/javascript">
Shadowbox.init();
</script>
<script src="<?= base_url() ?>dist/js/controllers/corrida/corridas_pagos.js"></script>

