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

        <div class="content boxContent pt-0">
            <div class="container-fluid">
                <ul class="nav nav-pills nav-pills-gray dashboard-nav-pills d-flex justify-center">
                    <li class="active" id="inicioOption" onclick="changePill(this.id)">
                        <a href="#inicio" data-toggle="tab"><div class="iconBox"><i class="fas fa-home p-0"></i></div><p class="m-0">Inicio</p></a>
                    </li>
                    <li id="reporteOption" onclick="changePill(this.id)">
                        <a href="#reporte" data-toggle="tab"><div class="iconBox"><i class="fas fa-file-alt p-0"></i></div><p class="m-0">Reporte</p></a>
                    </li>
                    <li id="agendaOption" onclick="changePill(this.id)">
                        <a href="#agenda" data-toggle="tab"><div class="iconBox"><i class="far fa-calendar-alt p-0"></i></div><p class="m-0">Agenda</p></a>
                    </li>
                    <li id="rankingOption" onclick="changePill(this.id)">
                        <a href="#ranking" data-toggle="tab"><div class="iconBox"><i class="fas fa-chart-line p-0"></i></i></div><p class="m-0">Ranking</p></a>
                    </li>
                    <li id="metricasOption" onclick="changePill(this.id)">
                        <a href="#metricas" data-toggle="tab"><div class="iconBox"><i class="far fa-chart-bar p-0"></i></div><p class="m-0">Métricas</p></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="inicio"></div>
                    <div class="tab-pane" id="reporte"></div>
                    <div class="tab-pane" id="agenda"></div>
                    <div class="tab-pane" id="ranking"></div>
                    <div class="tab-pane" id="metricas"></div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div><!--main-panel close-->
</body>
<?php $this->load->view('dashboard/agenda/common_modals'); ?>
<?php $this->load->view('dashboard/reporte/common_modals'); ?>
<script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
<?php $this->load->view('template/footer');?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/base/base.js"></script>
<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?>;
    changePill('inicioOption')
</script>