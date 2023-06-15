<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?> 
        <!--Contenido de la página-->
        <div class="modal fade" id="modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title="><center>¿Qué quieres modificar?</center></h4>
                    </div>
                    <form id="form_modificacion" name="form_modificacion" method="post">
                        <input type="text" class="hide" id="idLote" name="idLote">
                        <input type="text" class="hide" id="bandera9" name="bandera9">
                        <input type="text" class="hide" id="registroComision" name="registroComision">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <select id="modificacion" class="selectpicker select-gral m-0" data-style="btn btn-round" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" multiple required>
                                            <option disabled selected value="">Seleccione una opción</option>
                                        </select>
                                    </div>
                                    <div id="selects"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-receipt fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Actualización de lotes apartados</h3>
                                </div>
                                <p class="card-title center-align" id="subtitulo"></p>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">PROYECTO</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un proyecto"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">CONDOMINIO</label>
                                                    <select name="condominio" id="condominio"  class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un condominio"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">LOTE</label>
                                                    <select name="lote" id="lote" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un lote"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="table-responsive">
                                        <table id="tabla_historial" name="tabla_historial"
                                                class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                                <tr>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>TOTAL</th>
                                                    <th>ENGANCHE ADMINISTRACIÓN</th>
                                                    <th>ENGANCHE CONTRALORÍA</th>
                                                    <th>UBICACIÓN</th>
                                                    <th>ESTATUS LOTE</th>
                                                    <th>ESTATUS CONTRATACIÓN</th>
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

        <div class="content hide">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title center-align">Historial</h4>
                                <div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="proyecto">Proyecto: </label>
                                            <select name="proyecto" id="proyecto" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN PROYECTO</option></select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="condominio">Condominio: </label>
                                            <select name="condominio" id="condominio" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN CONDOMINIO</option></select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="lote">Lote: </label>
                                            <select name="lote" id="lote" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN LOTE</option></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content" style="padding: 50px 20px;">
                                <h4 class="card-title"></h4>
                                <div class="toolbar">
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">

                                            <table class="table table-responsive table-bordered table-striped table-hover"
                                                    id="tabla_historial" name="tabla_historial">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: .9em;">LOTE</th>
                                                        <th style="font-size: .9em;">ID LOTE</th>
                                                        <th style="font-size: .9em;">CLIENTE</th>
                                                        <th style="font-size: .9em;">FECHA APARTADO</th>
                                                        <th style="font-size: .9em;">ASESOR</th>
                                                        <th style="font-size: .9em;">COORDINADOR</th>
                                                        <th style="font-size: .9em;">GERENTE</th>
                                                        <th style="font-size: .9em;">TOTAL</th>
                                                        <th style="font-size: .9em;">ENGANCHE</th>
                                                        <th style="font-size: .9em;">UBICACIÓN</th>
                                                        <th style="font-size: .9em;">ESTATUS LOTE</th>
                                                        <th style="font-size: .9em;">ESTATUS CONTRATACIÓN</th>
                                                        <th style="font-size: .9em;">ACCIONES</th>
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
        </div>
    </div>

</div>
<?php $this->load->view('template/footer_legend');?>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php";
    var urlimg = "<?=base_url()?>img/";
</script>
<!-- MODAL WIZARD -->
<script src="<?= base_url() ?>dist/js/modal-steps.min.js"></script>
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?=base_url()?>dist/js/controllers/contraloria/vista_lotes_enganche.js"></script>
