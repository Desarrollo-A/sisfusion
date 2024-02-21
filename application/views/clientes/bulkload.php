<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<style type="text/css">
    .progress .progress-bar, .progress .progress-bar.progress-bar-default {
        background-color: #0073c8;
    }
    .progress-bar.indeterminate {
        position: relative;
        animation: progress-indeterminate 1.2s linear infinite;
    }
    @keyframes progress-indeterminate {
        from { left: -25%; width: 25%; }
        to { left: 100%; width: 25%;}
    }
</style>

    <div>
        <div class="wrapper">
            <?php $this->load->view('template/sidebar'); ?>
            <div class="content boxContent" id="bulkload_div">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="block full">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                                <i class="material-icons">list</i>
                                            </div>
                                            <div class="card-content">
                                                <h3 class="card-title center-align">CARGA MASIVA DE PROSPECTOS</h3>
                                                <div class="row">
                                                    <form method="post" enctype="multipart/form-data" name="my_bulkload_form" id="my_bulkload_form">
                                                    <div class="form-group col-lg-6 col-md-6 m-0">
                                                        <label class="control-label" for="proyecto">Subir archivo CSV</label>
                                                        <div class="file-gph">
                                                            <input class="d-none" type="hidden" id="filename" name="filename">
                                                            <input class="file-name" id="file-uploadE" name="file-uploadE" accept=".csv" type="file"/>
                                                            <p id="archivoE" class="m-0 w-80 overflow-text"></p>
                                                            <label for="file-uploadE" class="upload-btn m-0"><i class="fas fa-folder-open"></i>Subir archivo</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3"></div>
                                                    <div class="col-lg-3 col-md-3 d-flex justify-end mt-3" id="savingProspect" style="display: none">
                                                        <button type="reset" onclick="limpiar();" class="btn btn-details-grey">Limpiar</button>
                                                        <button type="button" name='finish' id="finish" class="btn btn-primary" onclick="sendCsvFile()">Insertar</button>
                                                    </div>
                                                </div>    
                                                    <div class="material-datatables">
                                                        <table id="table_datos2" class="table table-striped table-no-bordered table-hover hide" style="text-align:center;"><!--table table-bordered table-hover -->
                                                            <thead>
                                                                <tr>
                                                                    <th>SEDE</th>
                                                                    <th>ASESOR</th>
                                                                    <th>NOMBRE</th>
                                                                    <th>APELLIDO PATERNO</th>
                                                                    <th>APELLIDO MATERNO</th>
                                                                    <th>PERSONALIDAD</th>
                                                                    <th>CORREO</th>
                                                                    <th>TELÉFONO</th>
                                                                    <th>TELÉFONO 2</th>
                                                                    <th>OBSERVACIONES</th>
                                                                    <th>LUGAR DE PROSPECCIÓN</th>
                                                                    <th>OTRO LUGAR</th>
                                                                    <th>PLAZA DE VENTA</th>
                                                                    <th>NACIONALIDAD</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </form>
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
            </div>
        </div>
    </div>
</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/files/plugins/piexif.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/plugins/sortable.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/locales/es.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.js" type="text/javascript"></script>
<script src="<?= base_url() ?>dist/js/controllers/clientes/bulkload.js"></script>

