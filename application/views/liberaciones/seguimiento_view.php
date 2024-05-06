<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php  $this->load->view('documentacion/documentosModales'); ?> <!--Modales para el manejo de los documentos-->
        <?php  $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="modal-proceso-liberacion" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body" id='modal-liberacion'>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h6 class="m-0">Envíar lote <b id="nombreLoteLiberar"></b> a liberación</i></b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 overflow-hidden">
                                    <label class="control-label" for="id_documento_liberacion">Documento a adjuntar (*)</label>
                                    <select id="id_documento_liberacion" name="id_documento_liberacion" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div id="selectFileSection">
                                        <div class="file-gph">
                                            <input type="file" accept="application/pdf" id="archivo_liberacion">
                                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                            <label class="upload-btn m-0" for="archivo_liberacion">
                                                <span>Seleccionar</span>
                                                <i class="fas fa-folder-open"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                                    <label class="control-label" for="id_usuario">Comentario</label>
                                    <input class="text-modal mb-1" name="comentario" id="comentario" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-2" >
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn-proceso-liberacion" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Proceso de liberación de lotes (Particulares)</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="liberacionesDataTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>SUPERFICIE</th>
                                                <th>COSTO M2 FINAL</th>
                                                <th>TOTAL</th>
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

        <div class="spiner-loader hide" id="spiner-loader">
            <div class="backgroundLS">
                <div class="contentLS">
                    <div class="center-align">
                        Este proceso puede demorar algunos segundos
                    </div>
                    <div class="inner">
                        <div class="load-container load1">
                            <div class="loader">
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
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/liberaciones/seguimiento.js"></script>
<!-- <script src="<?=base_url()?>dist/js/controllers/liberaciones/subirArchivosLiberaciones.js"></script> -->