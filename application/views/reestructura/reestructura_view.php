<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">Reestructura</a></li>
                            <li><a href="#proceso-1" role="tab" data-toggle="tab">Liberar</a></li>
                        </ul>
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0"> 
                                <div class="nav-tabs-custom">
                                        <div class="tab-content p-2">
                                            <div class="tab-pane active" id="nuevas-1">
                                            <div class="card-content">
                                        <div class="encabezadoBox">
                                            <h3 class="card-title center-align">Reestructuración</h3>
                                        </div>
                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label overflow-hidden" for="proyecto">Proyecto</label>
                                                    <select name="catalogoReestructura" id="catalogoReestructura"  class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"></div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_reestructura" name="tabla_reestructura">
                                                <thead>
                                                    <tr>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>ID LOTE </th>
                                                        <th>SUPERFICIE</th>
                                                        <th>PRECIO M2</th>
                                                        <th>NOMBRE</th>
                                                        <th>ESTATUS</th>
                                                        <th>COMENTARIO</th>
                                                        <th>OBSERVACIÓN EN LIBERACIÓN</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="proceso-1">
                                <div class="text-center">
                                    <h3 class="card-title center-align">Liberar lotes</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label overflow-hidden" for="proyecto">Proyecto</label>
                                                    <select name="catalogoLiberar" id="catalogoLiberar" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table-striped table-hover" id="tabla_liberar" name="tabla_liberar">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE </th>
                                                <th>SUPERFICIE</th>
                                                <th>PRECIO M2</th>
                                                <th>NOMBRE</th>
                                                <th>ESTATUS</th>
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
            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/reestructura.js"></script>
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script>
        Shadowbox.init();
</script>