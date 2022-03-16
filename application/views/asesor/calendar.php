<body>
<div class="wrapper">
    <?php
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
    $this->load->view('template/sidebar', $datos);
    /*--------------------------------------------------------*/
    ?>

    <link href="<?= base_url() ?>dist/assets/css/general-styles.css" rel="stylesheet"/>
    <link href='<?=base_url()?>dist/js/fullcalendar/main.css' rel='stylesheet' />
    <style>
        .label-inf {
            color: #333;
        }

    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">list</i>
                        </div>
                        <div class="card-content">
                                <h4 class="card-title">Calendario</h4>

                                <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common_modals.php' ?>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="<?=base_url()?>dist/js/fullcalendar/main.js"></script>
<script src="<?=base_url()?>dist/js/fullcalendar/locales/es.js"></script>
<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?> ;
    typeTransaction = 1;
    base_url = "<?=base_url()?>";
    console.log(idUser);
</script>

<script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src='<?=base_url()?>dist/js/fullcalendar/main.js'></script>
<script src="<?=base_url()?>dist/js/controllers/calendar.js"></script>

</html>
