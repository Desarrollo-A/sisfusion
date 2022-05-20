<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;
            $this->load->view('template/sidebar', $datos);
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <ul class="nav nav-pills nav-pills-gray">
                    <li class="active" id="inicioOption" onclick="changePill(this.id)">
                        <a href="#inicio" data-toggle="tab">Inicio</a>
                    </li>
                    <li id="reporteOption" onclick="changePill(this.id)">
                        <a href="#reporte" data-toggle="tab">Reporte</a>
                    </li>
                    <li id="agendaOption" onclick="changePill(this.id)">
                        <a href="#agenda" data-toggle="tab">Agenda</a>
                    </li>
                    <li id="rankingOption" onclick="changePill(this.id)">
                        <a href="#ranking" data-toggle="tab">Ranking</a>
                    </li>
                    <li id="metricasOption" onclick="changePill(this.id)">
                        <a href="#metricas" data-toggle="tab">Metricas</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="inicio">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="reporte">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="agenda">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="ranking">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="metricas">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div><!--main-panel close-->
</body>
<?php $this->load->view('dashboard/agenda/common_modals'); ?>
<script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
<?php $this->load->view('template/footer');?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/base/base.js"></script>

