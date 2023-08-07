<link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
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
        <div class="content" id="bulkload_div">
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
                                            <div class="row">
                                                <h4 class="card-title">Carga masiva de prospectos</h4>
                                                <form method="post" enctype="multipart/form-data" name="my_bulkload_form" id="my_bulkload_form  ">
                                                <div class="">
                                                    <label for="customFile" style="color: #106BA0;font-size: 20px;">Subir archivo CSV</label>
                                                    <input id="customFile" style="width: 100%;" name="customFile" class="form-control-file" type="file" accept=".csv" >
                                                </div>
                                                <div class="table-responsive">
                                                    <div class="material-datatables">
                                                        <table id="table_datos2" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
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
                                                        <div class="col-md-12" id="savingProspect">
                                                                <button type="reset" onclick="limpiar();" class="btn">Limpiar</button>
                                                                <button type="button" name='finish' id="finish" class="btn" style="background-color: #4caf50;" onclick="sendCsvFile()">Insertar</button>
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
                    </div>
                </div>
            </div>
        <?php $this->load->view('template/footer_legend');?>
        </div>
    </div>
</div>
</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
<script src="<?=base_url()?>dist/js/controllers/files/plugins/piexif.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/plugins/sortable.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/locales/es.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/controllers/files/themes/explorer-fas/theme.js" type="text/javascript"></script>
<script src="<?= base_url() ?>dist/js/controllers/clientes/bulkload.js"></script>

