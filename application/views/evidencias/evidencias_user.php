<link href="<?= base_url() ?>dist/css/evidencias_user.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />
<link rel="stylesheet" href="//unpkg.com/videojs-record/dist/css/videojs.record.min.css">
<link href="https://cdn.bootcdn.net/ajax/libs/intro.js/5.1.0/introjs.min.css" rel="stylesheet" />

<?php if($information == false){ 
    $this->load->view('evidencias/warning_view');
 }else{ ?>
<body class="">
<div class="wrapper h-auto">
    <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                    Este proceso puede demorar algunos segundos
                </div>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content evidencias">
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
                                <div class="row d-flex direction-row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex direction-column">
                                        <div class="miniCard h-50 mt-0 d-flex align-center justify-center">
                                            <div class="boxInfo" data-intro='Por favor verifique que sus datos sean correctos (nombre, fecha de apartado y el nombre del asesor).' data-step='1'>
                                                <div class="row d-flex direction-row mb-1 p-1">
                                                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-center font-size">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 d-flex direction-column">
                                                        <p class="titleMini m-0">Nombre</p>
                                                        <p id="nombreCl" class="nombreCl data"></p>
                                                    </div>
                                                </div>
                                                <div class="row d-flex direction-row mb-1 p-1">
                                                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-center font-size">
                                                        <i class="fas fa-user-friends"></i>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 d-flex direction-column">
                                                        <p class="titleMini m-0">Asesor</p>
                                                        <p id="nombreAs" class="nombreAs data"></p>
                                                    </div>
                                                </div>
                                                <div class="row d-flex direction-row mb-1 p-1">
                                                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-center font-size">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-10 col-lg-10 d-flex direction-column">
                                                        <p class="titleMini m-0">Fecha apartado</p>
                                                    <p id="fechaApartado" class="fechaApartado data"></p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="miniCard h-50 mt-0 d-flex align-center justify-center w-100 mb-0">
                                            <div class="boxInfo h-100 w-100">
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 h-100 d-flex align-center">
                                                    <div class="row d-flex direction-column mb-1 p-1" data-intro='Por favor verifique que los datos del desarrollo, condominio, lote y número de lote sean correctos.' data-step='2'>
                                                        <div class="d-flex direction-row mb-1">
                                                            
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex direction-column pl-0">
                                                                <p class="titleMini m-0">Nombre del desarrollo</p>
                                                                <p id="nombreResidencial" class="nombreCl data"></p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex direction-row mb-1">
                                                            
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex direction-column pl-0">
                                                                <p class="titleMini m-0">Nombre del condominio</p>
                                                                <p id="nombreCondominio" class="nombreCl data"></p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex direction-row">
                                                            
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex direction-column pl-0">
                                                                <p class="titleMini m-0">Nombre del lote</p>
                                                                <p id="nombreLote" class="nombreCl data"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 instructions" data-intro='Lea el siguiente texto frente a su cámara.' data-step='6'>
                                                    <p class="text-center ">Lea el siguiente texto frente a su cámara</p>
                                                    <p class="text-center quote">&ldquo;YO <span id="client_name_text"></span> DECLARO QUE...&rdquo;</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 c    ol-sm-12 col-md-8 col-lg-8 d-flex align-center justify-center">
                                        <div class="w-100 d-flex justify-center" id="player">
                                            <div id="actionButtons" class="action-buttons-active">
                                                <button id="upload" data-intro='Una vez que termine de grabar el vídeo, dar click en guardar.' data-step='7' disabled><i class="fas fa-save"></i> Guardar</button>
                                            </div>
                                            <video id="myVideo" playsinline class="vjs-custom video-js"></video>
                                        </div>
                                        <div class="w-100 d-flex justify-center align-center row fade-video">
                                            <div class="w-50 d-flex condition row" data-intro='He leído y acepto los términos y condiciones de uso, así como el aviso de privacidad.' data-step='3'>
                                                <div class="col-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-end align-start">
                                                    <input id="check" type="checkbox"></input>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                        <p>Acepto que Ciudad Maderas use este material para uso exclusivo...</p>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
                                                        <button id="continue" data-intro='Dar clic para aceptar y continuar.' data-step='4'>CONTINUAR <i class="fas fa-angle-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="w-100" id="success">
                                            <i class="far fa-check-circle"></i>
                                            <h3>¡Tu vídeo ha sido guardado con éxito!</h3>
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
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="//unpkg.com/videojs-record/dist/videojs.record.min.js"></script>

<script>
    let information = {
        idCliente:"<?= $information->data->idCliente?>",
        idLote: "<?= $information->data->idLote?>",
        nombreCl: "<?= $information->data->nombreCl?>",
        nombreAs: "<?= $information->data->nombreAs?>",
        fechaApartado: "<?= $information->data->fechaApartado?>",
        nombreResidencial: "<?= $information->data->nombreResidencial?>",
        nombreCondominio: "<?= $information->data->nombreCondominio?>",
        nombreLote: "<?= $information->data->nombreLote?>"
    };
  
let typeTransaction = 0; // MJ: SELECTS MULTIPLES
</script>

<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/evidencias/user_evidencias.js"></script>
</body>
<script src="https://cdn.bootcdn.net/ajax/libs/intro.js/5.1.0/intro.min.js"></script>
<?php } ?>
