<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!--MODALS-->
        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Edición de Representante legal - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3 class="card-title center-align">Selecciona lo que deseas actualizar</h3>
                            <div class="form-group m-0 overflow-hidden">
                                <div class="radio_container w-100">
                                    <input class="d-none" type="radio" name="opcion" id="one">
                                    <label for="one" class="w-50">Representante Legal</label>
                                    <input class="d-none" type="radio" name="opcion" id="two">
                                    <label for="two" class="w-50">Sede</label>
                                    <input class="d-none hide" type="radio" name="opcion" id="three">
                                    <label for="three" class="w-50 hide" id="titEL">Estatus Lote</label>
                                </div>
                            </div>
                            <div class="form-group m-0 overflow-hidden hide" name="Rl_form" id="Rl_form">
                                <label class="control-label " for="proyecto">Representante legal</label>
                                <select name="rl" id="rl" class="selectpicker select-gral m-0 rl" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                            </div>
                            <div class="form-group m-0 overflow-hidden hide" name="Sede_form" id="Sede_form">
                                <label class="control-label " for="proyecto">Sede</label>
                                <select name="sede" id="sede" class="selectpicker select-gral m-0 rl" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                            </div>
                            <div class="form-group m-0 overflow-hidden hide" name="Lote_form" id="Lote_form">
                                <label class="control-label " for="proyecto">Estatus Lote</label>
                                <select name="lote" id="lote" class="selectpicker select-gral m-0 lott" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save" class="btn btn-primary hide">Guardar</button>
                        <button type="button" id="save2" class="btn btn-primary hide">Guardar</button>
                        <button type="button" id="save3" class="btn btn-primary hide">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Contenido de la página-->
        <div class="content boxContent ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Cambio De Representante Legal</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label label-gral">Lote</label>
                                                <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 mt-3">
                                            <div class="form-group">
                                                <button type="button" class="btn-gral-data find_doc"> Buscar </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table class="table-responsive table-hover hide" id="tabla_RL" name="tabla_RL">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE VENTA</th>
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>GERENTE</th>
                                                <th>RESIDENCIA</th>
                                                <th>UBICACIÓN</th>
                                                <th>REPRENSENTANTE LEGAL</th>
                                                <th>ESTATUS LOTE</th>
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

        <?php $this->load->view('template/footer_legend'); ?>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/cambioRL.js?v=1.1.9"></script>