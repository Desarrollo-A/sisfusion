<link href="<?= base_url() ?>dist/css/evidencias_user.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />
<link rel="stylesheet" href="//unpkg.com/videojs-record/dist/css/videojs.record.min.css">

<body class="">
<div class="wrapper">
    <div class="content recisiones">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Guardar evidencia</h3>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <p class="m-0">Evidencia <span class="evidencia enfatize">cargada</span></p>
                                                    <p class="mb-1">Ver evidencia <i class="fas fa-eye"></i></p>
                                                    <span class="estatus">Sin validar<span>
                                                </div>
                                                <!-- <div class="boxIcon">
                                                    <img src="../dist/img/verify.png" alt="Icono verificación" class="">
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <p class="titleMini m-0">Nombre</p>
                                                    <p class="nombreCl data">ADRIANA AUREA ARGAIZ CABRERA</p>
                                                    <p class="titleMini m-0">Asesor</p>
                                                    <p class="nombreAs data">CHRISTIAN ALFONSO SANCHEZ SANCHEZ</p>
                                                    <p class="titleMini m-0">Fecha</p>
                                                    <p class="fechaApartado data">23/06/2022 09:00</p>
                                                </div>
                                                <!-- <div class="boxIcon">
                                                    <img src="../dist/img/verify.png" alt="Icono verificación" class="">
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <div class="montos d-flex justify-between">
                                                        <div class="w-50">
                                                            <p class="titleMonto m-0">Precio de lote</p>
                                                            <p class="monto w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="$1,051,193.47">$1,051,193.47</p>
                                                        </div>
                                                        <div class="w-50">
                                                            <p class="titleMonto m-0">Enganche validado</p>
                                                            <p class="monto w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="$95,563.04">$95,563.04</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="mb-1 w-50">
                                                            <p class="titleMini m-0 mt-1">Estatus lote</p>
                                                            <p class="estatus2 w-90 overflow-text">Contratado</p>
                                                        </div>
                                                        <div class="mb-1 w-50">
                                                            <p class="titleMini m-0 mt-1">Estatus comisión</p>
                                                            <p class="estatus2 w-90 overflow-text">Recisión anterior (aún no se dispersa)</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <p class="titleMini m-0">Estatus contratación</p>
                                                        <p class="estatus2 w-100 overflow-text">15. Acuse entregado (Contraloría)</p>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row d-flex justify-center">
                                    <div class="w-50">
                                        <div class="action-buttons">
                                            <button>Guardar</button>
                                            <button>Regrabar</button>
                                        </div>
                                        <video id="myVideo" playsinline class="video-js vjs-default-skin"></video>
                                    </div>
                                </div>
                                <input type="file" id="file" name="file"></input>
                                <button id="upload">SUBIR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="//unpkg.com/videojs-record/dist/videojs.record.min.js"></script>

<script>
    let url = "<?=base_url()?>";
    let typeTransaction = 0; // MJ: SELECTS MULTIPLES
</script>

<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<!-- <script src="<?= base_url() ?>dist/js/controllers/general/main_services_dr.js"></script> -->
<script src="<?= base_url() ?>dist/js/controllers/evidencias/user_evidencias.js"></script>
</body>