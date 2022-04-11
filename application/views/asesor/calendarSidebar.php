<div id="wrapper">
    <?php 
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;

        $this->load->view('template/sidebar', $datos);
    ?>
    <link href="<?= base_url() ?>dist/css/colendar.css" rel="stylesheet"/>
    <!--SIDEBAR CALENDAR-->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a>
                    NUMERO DE CITAS
                </a>
            </li>
        </ul>
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
    </div>
    <?php include 'common_modals.php'?>
</div>
<?php $this->load->view('template/footer');?>

<script src="<?= base_url() ?>dist/assets/js/bootstrap-daterimepicker.js"></script>
<script src="<?=base_url()?>dist/js/controllers/calendar.js"></script>
