<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        
    
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#ventas" role="tab" id="ventas_tabla" data-toggle="tab">VENTAS</a>
                            </li>
                            <li>
                                <a href="#ooam" role="tab" id="ooam_tabla" data-toggle="tab">OOAM</a>
                            </li>
                            <li>
                                <a href="#resguardo" role="tab" id="resguardo_tabla" data-toggle="tab">RESGUARDO</a>
                            </li>
                        </ul>
                    <div class="card no-shadow m-0 border-conntent__tabs pl-2">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="tab-pane active" id="ventas">
                                        <div class="card-content">
                                            <div class="text-center">
                                                <h3 class="card-title center-align"><b>TABLA ASIMILIADOS</b></h3>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid justify-center">
                                                    <div class="fechasAjuste" id="fechasAjuste" >
                                                      <!-- <input type="hidden" id="permisos-edicion" value="<?php echo $permisos_edicion; ?>"> -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="ooam">
                                        <div class="text-center">
                                            <h3 class="card-title center-align"><b>TABLA OOAM</b></h3>
                                        </div>
                                        <div class="toolbar">
                                                <div class="container-fluid ">
                                                    <div class="fechasAjusteOOAM" id="fechasAjusteOOAM" >

                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="resguardo">
                                        <div class="text-center">
                                            <h3 class="card-title center-align"><b>TABLA RESGUARDOS</b></h3>
                                        </div>
                                        <div class="toolbar">
                                                <div class="container-fluid">
                                                    <div class="fechasResguardo" id="fechasResguardo" >

                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ajuste/AjusteFechaCorte.js"></script>
</body>