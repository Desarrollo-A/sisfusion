<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper ">
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
                                    <h3 class="card-title center-align">Descargar inventario de lotes por sede</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Sedes por proyecto</label>
                                                    <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN"
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
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>PRECIO POR M2</th>
                                                <th>PRECIO DE LISTA</th>
                                                <th>TOTAL CON DESCUENTOS</th>
                                                <th>REFERENCIA</th>
                                                <th>MESES SIN INTERESES</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>ESTATUS</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>COMENTARIO</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>FECHA DE APERTURA</th>
                                                <th>FECHA DE VALIDACIÓN DEL ENGANCHE</th>
                                                <th>CANTIDAD DEL ENGANCHE PAGADO</th>
                                                <th>REUBICACIÓN</th>
                                                <th>FECHA DE REUBICACIÓN</th>
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
    </div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/inventario/inventario.js"></script>

