
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Pruebas de diseño</h3>
                                    <div class="row">

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Proyecto</label>
                                                <select name="idResidencial" id="idResidencial" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required>
                                                    <?php
                                                    if ($residencial != NULL) :
                                                        foreach ($residencial as $fila) : ?>
                                                            <option value=<?= $fila['idResidencial'] ?>>
                                                                <?= $fila['nombreResidencial'] ?> </option>
                                                        <?php endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Condominio</label>
                                                <select id="idCondominio" name="idCondominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>

                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Lote</label>
                                                <select id="idLote" name="idLote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>NOMBRE LOTE</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <?php $this->load->view('template/modals');?>

    <script src="<?= base_url() ?>dist/js/controllers/test/layout.js"></script>
</body>