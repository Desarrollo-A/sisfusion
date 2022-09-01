<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php
            if(!ISSET($external)){
                $datos = array();
                $datos = $datos4;
                $datos = $datos2;
                $datos = $datos3;
                $this->load->view('template/sidebar', $datos);
            }
        ?>

        <div class="content boxContent pt-0">
            <div class="container-fluid">
                <ul class="nav nav-pills nav-pills-gray dashboard-nav-pills d-flex justify-center">
                    <?php 
                    $li = '';
                    foreach($sub_menu as $menu){
                        $activeClass = $menu->active == 1 ? 'active menuTab':'menuTab';
                        $li .= "<li class='$activeClass' id='$menu->id_li'>";
                        $li .= "<a href='#$menu->href' data-toggle='tab'><div class='iconBox'><i class='$menu->icono p-0'></i></div><p class='m-0'>$menu->nombre</p></a>";
                        $li .= "</li>";
                    }      
                    echo $li;

                    ?>
                </ul>
                <div class="tab-content">

                <?php 
                     $div = '';
                     foreach($sub_menu as $menu){
                         $activeClass = $menu->active == 1 ? 'tab-pane active':'tab-pane';
                         $div .= "<div class='$activeClass' id='$menu->id_content'>";
                         $div .= "</div>";
                     }      
                     echo $div;
                ?>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div><!--main-panel close-->
</body>
<?php $this->load->view('dashboard/agenda/common_modals'); ?>
<?php $this->load->view('dashboard/reporte/common_modals'); ?>
<?php $this->load->view('dashboard/ranking/common_modals'); ?>
<?php $this->load->view('dashboard/metricas/common_modals'); ?>

<?php $this->load->view('template/footer');?>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/base/base.js"></script>
<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?>;
    var idLider = <?= $this->session->userdata('id_lider') ?>;
    var  base_url = "<?=base_url()?>";

    if ( userType == 5 && ( idUser == 28 || idUser == 30 ) ){
        userType = 59;
        idUser = idLider;
    }
</script>