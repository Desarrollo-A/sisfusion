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
                            <h3 data-i18n="registros-terrenos" class="card-title center-align">Registros de Terrenos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group label-floating select-is-empty overflow-hidden">
                                            <label class="control-label" data-i18n="proyecto">Proyecto</label>
                                            <select data-i18n-label="selecciona-proyecto"  name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" data-container="body" required>
                                            <option value= "InventarioCompleto"> Inventario Completo </option>
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
                                            <label class="control-label" data-i18n="condominio-2">Condominio</label>
                                            <select data-i18n-label="selecciona-condominio" id="filtro4" data-i18n="selecciona-proyecto" name="filtro4"class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="Selecciona Condominio" data-size="7" data-container="body" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="tableTerrenos" class="table-striped table-hover">
                                        <thead>
                                                <tr>
                                                <th>proyecto</th>
                                                <th>condominio</th>
                                                <th>lote</th>
                                                <th>superficie</th>
                                                <th>TOTAL</th>
                                                <th>enganche</th>
                                                <th>a-financiar</th>
                                                <th>meses-intereses</th>
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

    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="container-fluid" style="padding: 50px 10px;">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="card-title" style="text-align: center">Registros de Terrenos</h4><br><br>
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Proyecto:</label><br>
                                    <select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn " title="Selecciona Proyecto" data-size="7" required>
                                        <option value= "InventarioCompleto"> Inventario Completo </option>
                                        <?php
                                        if($residencial != NULL) :
                                            foreach($residencial as $fila) : ?>
                                                <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                            <?php endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Condominio:</label><br>
                                    <select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true"
                                            data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
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
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="tableTerrenos" class="table table-bordered table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>proyecto</th>
                                                <th>condominio</th>
                                                <th>lote</th>
                                                <th>superficie</th>
                                                <th>TOTAL</th>
                                                <th>enganche</th>
                                                <th>a-financiar</th>
                                                <th>meses-intereses</th>
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
<script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_inventarioDventas.js"></script>
