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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                <!-- Subdirector -->
                                <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden pl-0">
                                        <label class="label-gral">Gerente</label>
                                        <select class="selectpicker select-gral m-0" id="gerente" name="gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un gerente" data-size="7" data-container="body"></select>
                                    </div>
                                <?php } ?>
                                <!-- Subdirector y Gerente -->
                                <?php if( $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 ) { ?>
                                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
                                    <?php } else  { ?> 
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden pl-0">
                                    <?php } ?>
                                        <label class="label-gral">Coordinador</label>
                                        <select class="selectpicker select-gral m-0" id="coordinador" name="coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un coordinador" data-size="7" data-container="body"></select>
                                    </div>
                                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden pr-0">
                                    <?php } else  { ?> 
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden pr-0">
                                    <?php } ?>
                                        <label class="label-gral">Asesor</label>
                                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un asesor" data-size="7" data-container="body"></select>
                                    </div>
                                <?php } ?>
                                <!-- Coordinador -->
                                <?php if( $this->session->userdata('id_rol') == 9 ) { ?>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden p-0 mb-1">
                                        <label class="label-gral">Asesor</label>
                                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un asesor" data-size="7" data-container="body"></select>
                                    </div>
                                <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                        <div id='calendar'></div>
                                    </div>
                                </div>
                            </div>
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

<?php $this->load->view('template/footer');?>


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