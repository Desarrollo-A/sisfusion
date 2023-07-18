<link href="<?= base_url() ?>dist/css/notFound.css" rel="stylesheet"/>

<body class="m-0">
    <div class="wrapper">
        <div class="container-fluid vh-100 boxContent">
            <div class="row h-100">
                <div class="col-md-3"></div>
                <div class="col-md-6 h-100 d-flex align-center">
                    <div class="w-100">
                        <div class="text-center">
                            <img class="w-100" src="<?= base_url() ?>static/images/logo.svg">
                            <?php if ($code == 200) { ?>
                                <div class="title d-flex justify-center">
                                    <h2>Información</h2>
                                </div>
                                <h3 class="m-0" id="mensaje-success">
                                    Verifica tu número telefónico a través del siguiente
                                    <a href="#" id="enviar-autorizacion-link" data-idCliente="<?=$idCliente?>">
                                        <u><b>enlace.</b></u>
                                    </a>
                                </h3>
                            <?php } else { ?>

                                <div class="title d-flex justify-center">
                                    <h2><?=$titulo?></h2>
                                </div>
                                <h3 class="m-0"><?=$mensaje?></h3>

                            <?php } ?>
                        </div>
                    </div>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer');?>
</body>

<script src="<?=base_url()?>dist/js/controllers/clientes/autorizacion-cliente-sms.js"></script>