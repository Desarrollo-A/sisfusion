<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?> 
        <!--MODAL-->
        <div class="modal fade" id="modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">¿Qué quieres modificar?</h4>
                    </div>
                    <form id="form_modificacion" name="form_modificacion" method="post">
                        <input type="text" class="hide" id="idLote" name="idLote">
                        <input type="text" class="hide" id="bandera9" name="bandera9">
                        <input type="text" class="hide" id="registroComision" name="registroComision">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <select id="modificacion" class="selectpicker select-gral m-0" data-style="btn btn-round" title="SELECCIONA UNA OPCIÓN" 
                                        data-size="7" data-live-search="true" multiple required></select>
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
        <!---END MODAL-->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Proyecto</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Condominio</label>
                                                    <select name="condominio" id="condominio"  class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Lote</label>
                                                    <select name="lote" id="lote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="tabla_historial" name="tabla_historial" class="table-striped table-hover hide" >
                                        <thead>
                                            <tr>
                                                <th>ID LOTE</th>
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>TOTAL</th>
                                                <th>ENGANCHE DE ADMINISTRACIÓN</th>
                                                <th>ENGANCHE DE CONTRALORÍA</th>
                                                <th>UBICACIÓN</th>
                                                <th>ESTATUS DEL LOTE</th>
                                                <th>ESTATUS DE CONTRATACIÓN</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>

<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/controllers/contraloria/vista_lotes_enganche.js"></script>
