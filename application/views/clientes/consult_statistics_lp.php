<body class="">
<div class="wrapper ">

    <?php
    $dato= array(
        'home' => 0,
        'usuarios' => 0,
        'statistics' => 0,
        'manual' => 0,
        'aparta' => 0,
        'prospectos' => 0,
        'prospectosMktd' => 0,
        'prospectosAlta' => 0,
        'corridaF' => 0,
        'inventario' => 0,
        'inventarioDisponible' => 0,
        'sharedSales' => 0,
        'coOwners' => 0,
        'references' => 0,
        'bulkload' => 0,
        'statistics1' => 0,
        'statistics2' => 1
    );

    $this->load->view('template/sidebar', $dato);

    ?>

    <div class="content" ng-controller="datos">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">multiline_chart</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Lugar de prospección</h4>
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

	<?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>

<script src="<?=base_url()?>dist/js/controllers/clientes/alasql.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/angular.min.js"></script>

<script src="<?php base_url()?>dist/js/Chart.js"></script>
<script src="<?php base_url()?>dist/js/angular/angular-chart.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/charts-1.1.0.js"></script>

<script>
</script>

</html>
