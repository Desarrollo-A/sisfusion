<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<style>
    .u2be i{
        color: red;
    }
</style>

<body id="mainDashboard">
    <div class="wrapper ">
        <?php
            if(!ISSET($external))
                $this->load->view('template/sidebar');
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

                    
                    <?php if ( $this->session->userdata('id_rol') == 7 ){
                        $liVideo = '<li class="ml-3 d-flex align-center justify-center u2be">';
                        $liVideo .= '<a href="https://www.youtube.com/watch?v=WcwAguxb0Mo" class="p-0" target="_blank">';
                        $liVideo .= '<i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i></a></li>';

                        echo $liVideo;
                    } ?>
                    <?php if ( $this->session->userdata('id_rol') == 9 ){
                        $liVideo = '<li class="ml-3 d-flex align-center justify-center u2be">';
                        $liVideo .= '<a href="https://www.youtube.com/watch?v=6-JuxuJhsZA" class="p-0" target="_blank">';
                        $liVideo .= '<i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i></a></li>';

                        echo $liVideo;
                    } ?>
                    <?php if ( $this->session->userdata('id_rol') == 3 ){
                        $liVideo = '<li class="ml-3 d-flex align-center justify-center u2be">';
                        $liVideo .= '<a href="https://www.youtube.com/watch?v=to8YvNoyD9g&feature=youtu.be" class="p-0" target="_blank">';
                        $liVideo .= '<i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i></a></li>';

                        echo $liVideo;
                    } ?>
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
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script async defer src="https://accounts.google.com/gsi/client"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/general_calendar.js"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/base/base.js"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/googleCalendarConnection.js"></script>

<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?>;
    var idLider = <?= $this->session->userdata('id_lider') ?>;
    var  base_url = "<?=base_url()?>";
</script>