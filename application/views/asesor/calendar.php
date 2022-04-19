<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/calendar.css" rel="stylesheet"/>

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

    <style>
        .fc-icon-fab, .fc-icon-fas{
            font-family: FontAwesome!important;
        }

        .fc-googleSignIn-button{
            display: none!important;
        }

        .fc-googleLogout-button{
            display: none!important;
        }
    </style>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common_modals.php' ?>
</div>
</div><!--main-panel close-->
</body>

<?php 
$this->load->view('template/footer');?>


<script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};handleClientLoad()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
<script src="<?=base_url()?>dist/js/controllers/calendar.js"></script>
<script src="<?=base_url()?>dist/js/googleCalendarConnection.js"></script>

<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?> ;
    typeTransaction = 1;
    base_url = "<?=base_url()?>";
</script>
</html>