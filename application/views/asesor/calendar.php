<body>
<div class="wrapper">
    <?php //include 'sidebarParams_prospectsList.php'
/*-------------------------------------------------------*/
$datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
            $this->load->view('template/sidebar', $datos);
 /*--------------------------------------------------------*/
     ?>

    <link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>dist/assets/css/general-styles.css" rel="stylesheet"/>
    <link href='<?=base_url()?>dist/js/fullcalendar/main.css' rel='stylesheet' />
    <style>
        .label-inf {
            color: #333;
        }
        /*.modal-body-scroll{
            height: 100px;
            width: 100%;
            overflow-y: auto;
        }*/

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
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<script src="--><?php //base_url()?><!--dist/js/jquery.validate.js"></script>-->

<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?> ;
    typeTransaction = 1;
    base_url = "<?=base_url()?>";
    console.log(idUser);

</script>

<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/assets/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/assets/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
<!-- <script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script> -->
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src='<?=base_url()?>dist/js/fullcalendar/main.js'></script>
<script src="<?=base_url()?>dist/js/controllers/calendar.js"></script>

</html>
