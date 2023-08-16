<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <!--Contenido de la página-->
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Registros de Terrenos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label">Proyecto</label>
                                            <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" data-container="body" required>
                                                <?php
                                                if($residencial != NULL) :
                                                    foreach($residencial as $fila) : ?>
                                                        <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                                    <?php endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label">Condominio</label>
                                            <select id="filtro4" name="filtro4"class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona Condominio" data-size="7" data-container="body" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="tableTerrenos" class="table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>TOTAL</th>
                                                <th>ENGANCHE</th>
                                                <th>A FINANCIAR</th>
                                                <th>MESES SIN INTERESES</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

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
<script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_inventarioDventas.js"></script>
