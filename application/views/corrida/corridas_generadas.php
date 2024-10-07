
<!--<link href="--><?//= base_url() ?><!--dist/assets/css/datatableNFilters.css" rel="stylesheet"/>-->
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

    <div class="modal fade" id="avisoModal" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h3 class="modal-title" data-i18n="texto-financiera-activa">¡Ya existe una corrida financiera activa!</h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid pdt-50">
                        <div class="row centered center-align">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-1x" aria-hidden="true"></i></h1><br><br>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <h3 class="modal-title" style="font-size: 2em" data-i18n="texto-financiera-lote">Actualmente ya hay una corrida financiera para este lote</h3>
                                <h5 style="font-size: 1.5rem"><i data-i18n="deshabilitar-corrida-financiera"> Puedes deshabilitar la corrida financiera actual, para habilitar la corrida financiera deseada</i></h5>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <br><br>
                    <!--<button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>-->
                    <!--<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>-->
                    <button type="button" class="btn btn-simple" data-dismiss="modal" data-i18n="aceptar"> Aceptar </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="gray"
                             style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content" style="padding: 50px 20px;">
                            <h4 class="card-title"></h4>
                            <div class="toolbar">
                                <h3 class="card-title center-align" data-i18n="corrida-lotes">Corridas financieras por lote</h3>
                                <div class="container-fluid" style="padding: 20px 0px;">
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label" data-i18n="proyecto">Proyecto</label>
                                            <select name="filtro3" id="filtro3"
                                                    class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un proyecto" data-i18n-label="select-proyecto" data-size="7" required>
                                                <?php
                                                if ($residencial != NULL) :
                                                    foreach ($residencial as $fila) : ?>
                                                        <option value=<?= $fila['idResidencial'] ?>> <?= $fila['descripcion'] ?> </option>
                                                    <?php endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label" data-i18n="condominio-2">Condominio</label>
                                            <select id="filtro4" name="filtro4"
                                                    class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un condominio" data-i18n-label="select-condominio" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label" data-i18n="lote">Lote</label>
                                            <select id="filtro5" name="filtro5"
                                                    class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un lote" data-i18n-label="select-lote" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>

                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table id="tableDoct" class="table-striped table-hover" width="100%"
                                           style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th class="text-center">id-corrida</th>
                                            <th class="text-center">estatus</th>
                                            <th class="text-center">proyecto</th>
                                            <th class="text-center">condominio</th>
                                            <th class="text-center">id-lote</th>
                                            <th class="text-center">lote</th>
                                            <th class="text-center">cliente</th>
                                            <th class="text-center">hora-fecha</th>
                                            <th class="text-center">responsable</th>
                                            <!--<th class="text-center">UBICACIÓN</th>-->
                                            <th class="text-center">corrida-financiera</th>
                                            <th class="text-center">acciones</th>

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
</div>
</body>
<?php $this->load->view('template/footer');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>static/js/shadowbox.js"></script>
<script src="<?= base_url() ?>dist/assets/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/assets/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/corrida/corridas_generadas.js"></script>

