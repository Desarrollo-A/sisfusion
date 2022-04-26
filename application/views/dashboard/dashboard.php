<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.bootstrap.min.css" rel="stylesheet">
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
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <span class="material-icons">trending_up</span>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" >Dashboard</h3>
                                <div class="container-fluid">
                                    <div class="row" style="height: 210px;">
                                        <div class="col-md-3 h-100" >
                                            <div class="card h-100 m-0">
                                                <div class="row h-40  m-0">
                                                    <div class="col-md-12 h-100 p-0">
                                                        <h4 class="text-center">TOTAL 100</h4>
                                                    </div>
                                                </div>
                                                <div class="row h-60  m-0">
                                                    <div class="col-md-12 pb-0 h-100 p-0">
                                                        <div id="chart"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 h-100">
                                            <div class="card h-100 m-0">
                                                <div class="row h-100">
                                                    <!-- <div class="col-md-3 h-100">
                                                        <h4 class="text-center">INFO</h4>
                                                    </div> -->
                                                    <div class="col-md-12 pb-0 h-100 d-flex align-end">
                                                        <div class="col-md-12 pb-0 h-70">
                                                            <div id="chart2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3">
                                            <div class="row d-flex justify-center">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">TRES</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row d-flex justify-end">
                                                <div class="col-md-12">
                                                    <h4 class="text-center">CUATRO</h4>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/dashboard.js"></script>

