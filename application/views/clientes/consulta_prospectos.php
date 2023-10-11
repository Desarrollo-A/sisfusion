<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet" />

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="myReAsignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Asignación de prospecto</h4>
                    </div>

                    <div class="modal-body">
                        <form id="my_reasign_form_ve" name="my_reasign_form_ve" method="post">
                            <div class="col-lg-12">
                                <div class="col-lg-12" name="sedeForm" id="sedeForm">
                                    <label class="control-label">Sede</label>
                                    <select name="sede" id="sede" onchange="changeSede();" class="selectpicker select-gral m-0" data-style="btn"
                                        data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN"
                                        data-size="7" data-container="body" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Asesor">
                                    <label class="control-label">Asesor</label>
                                    <select class="selectpicker select-gral m-0" name="asesor" id="asesor"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Coor">
                                    <label class="control-label">Coordinador</label>
                                    <select class="selectpicker select-gral m-0" name="coordinador" id="coordinador"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Gere">
                                    <label class="control-label">Gerente</label>
                                    <select class="selectpicker select-gral m-0" name="gerente" id="gerente"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Sub">
                                    <label class="control-label">Subdirector</label>
                                    <select class="selectpicker select-gral m-0" name="subdirector" id="subdirector"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Dr">
                                    <label class="control-label">Director regional</label>
                                    <select class="selectpicker select-gral m-0" name="DireRegional" id="DireRegional"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Dr2">
                                    <label class="control-label">Director regional 2</label>
                                    <select class="selectpicker select-gral m-0" name="DireRegional2" id="DireRegional2"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>

                                <input type="hidden" name="id_prospecto" id="id_prospecto">
                                <br>
                                <br>
                            </div>

                            <div class="modal-footer">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end pt-1">
                                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                                        id="close">Cancelar</button>
                                    <button type="button" id="con1" class="btn btn-primary hide">Aceptar</button>
                                    <button type="button" id="con2" class="btn btn-primary hide">Aceptar</button>
                                    <button type="button" id="con3" class="btn btn-primary hide">Aceptar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/pj80dBMw6y4" class="align-center justify-center u2be"
                                    target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial"
                                        style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <div class="material-datatables">
                                    <table id="prospects-datatable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <?php include 'common_modals.php' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');
        ?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <script src="<?=base_url()?>dist/js/moment.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js?v=1.1.14"></script>
    <script src="<?=base_url()?>dist/js/controllers/global_functions.js"></script>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
</body>