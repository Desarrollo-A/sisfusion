<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php  $this->load->view('template/sidebar');  ?>
        <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" data-i18n="descarga-inventario-lotes-sede">Descargar inventario de lotes por sede</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label" data-i18n  ="sedes-por-proyectos">Sedes por proyecto</label>
                                                <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true" data-i18n-label="select-predeterminado" title="SELECCIONA UNA OPCIÓN"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table id="tabla_inventario_contraloria" name="tabla_inventario_contraloria" class="table-striped table-hover hide">
                                        <thead>
                                        <tr>
                                            <th>proyecto</th>
                                            <th>condominio</th>
                                            <th>lote</th>
                                            <th>superficie</th>
                                            <th>precio-m2</th>
                                            <th>precio-lista</th>
                                            <th>total-con-descuentos</th>
                                            <th>referencia</th>
                                            <th>meses-sin-intereses</th>
                                            <th>asesor</th>
                                            <th>coordinador</th>
                                            <th>gerente</th>
                                            <th>subdirector</th>
                                            <th>director-regional</th>
                                            <th>director-regional-2</th>
                                            <th>estatus</th>
                                            <th>fecha-de-apartado</th>
                                            <th>comentario</th>
                                            <th>lugar-prospeccion</th>
                                            <th>fecha-apertura</th>
                                            <th>fecha-de-validacion-del-enganche</th>
                                            <th>cantidad-del-enganche-pagado</th>
                                            <th>reubicacion</th>
                                            <th>fecha-de-reubicacion</th>                                            
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
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/inventario/inventario.js"></script>

