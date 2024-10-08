<?php

switch ($idRol) {
    case 99:
        $adeudo = 'OOAM';
        break;
    case 33 || 11:
        $adeudo = 'ADM';
        break;
}

if(in_array($idUsuario, [4512])){
    $adeudo = 'GPH';
}

?>

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
                                <i class="fas fa-money fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Paso 2 - Ingresar adeudo</h3>
                                    <div id="table-filters" class="row mb-1"></div>
                                </div>
                                
                                <table id="tableDoct" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>NOMBRE LOTE</th>
                                            <th>CONDOMINIO</th>
                                            <th>PROYECTO</th>
                                            <th>NOMBRE CLIENTE</th>
                                            <th>ASESOR</th>
                                            <th>GERENTE</th>
                                            <th>ADEUDO <?php echo $adeudo ?></th>
                                            <th>TIEMPO</th>
                                            <th>MOVIMIENTO</th>
                                            <th>ESTATUS ESCRITURACIÓN</th>
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

    <script type="text/javascript">
        const idRol = <?php echo $idRol ?>;
        const idUsuario = <?php echo $idUsuario ?>;
    </script>

    <script src="<?= base_url() ?>dist/js/controllers/casas/creditoBanco/ingresar_adeudos.js?=v1"></script>
</body>