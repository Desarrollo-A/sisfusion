<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/liberaciones-styles.css" rel="stylesheet"/>
<style>
    .bs-searchbox .form-group{
        padding-bottom: 0!important;
        margin: 0!important;
    }
</style>
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center">Selección de archivo a cargar</h5>
                        <div class="file-gph">
                            <input class="d-none" type="file" id="fileElm">
                            <input class="file-name" id="file-name"  type="text" placeholder="No has seleccionada nada aún" readonly="">
                            <label class="upload-btn m-0" for="fileElm">
                                <span>Seleccionar</span>
                                <i class="fas fa-folder-open"></i>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">settings</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title text-center">Liberaciones</h3>
                                <div class="toolbar">
                                    <div class="row align-end">
                                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 pr-0 ">
                                            <label class="control-label">Proyecto (<span class="isRequired">*</span>)</label>
                                            <select class="selectpicker select-gral m-0"  title="SELECCIONA UNA OPCIÓN" data-size="7" id="selectResidenciales" data-live-search="true"></select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 pr-0">
                                            <label class="control-label">Condominio(<span class="isRequired">*</span>)</label>
                                            <select class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" id="selectCondominios" data-live-search="true"></select>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 pt-3">
                                            <button class="btn-rounded btn-s-blueLight" name="uploadFile" id="uploadFile" title="Subir plantilla" data-toggle="modal" data-target="#uploadModal">
                                                <i class="fas fa-upload"></i>
                                            </button> 
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables" id="box-liberacionesTable">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="liberacionesTable" name="liberacionesTable">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID LOTE</th>
                                                <th>NOMBRE</th>
                                                <th>REFERENCIA</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>ESTATUS DE CONTRATACIÓN</th>
                                                <th>ESTATUS DE LIBERACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/dataTables.select.js"></script>
<script src="<?= base_url() ?>dist/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/contraloria/liberacionContraloria.js"></script>