<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<style>
    .bckSpan{
        padding: 4px;
        background-color: #ecf5ff;
        border-radius: 41px;
    }
    .subSpan{
        border: 2px dotted #d5d5d5;
        border-radius: 39px;
        padding: 0 10px;
    }
    .subSpan input{
        background-image: none!important;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .subSpan input::-webkit-input-placeholder {
    font-style: italic;
    }
    .subSpan button{
        background-color: transparent;
        border: none;
    }
    .subSpan button:hover i{
        color: #333;
    }
    .subSpan i{
        color: #999999;
    }
    #reviewTokenEvidence .modal-content{
        background-color: #00000087;
        padding: 10px 20px;
    }
</style>

<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align" data-i18n="generar-token">Generar token</h3>
                                <div class="row pt-2 aligned-row">
                                    <div class="col-12 col-sm-11 col-md-11 col-lg-11">
                                        <div class="form-group d-flex">
                                            <span class="bckSpan w-100">
                                                <span class="subSpan w-100 d-flex">
                                                    <input class="form-control generated-token" id="generatedToken" placeholder="Aún no se ha generado ningún token" data-i18n-label="sin-token-generado" readonly/>
                                                    <button id="copyToken" onclick="copyToClipBoard()" data-toggle="tooltip" data-placement="top" title="COPIAR TOKEN" data-i18n-tooltip="copiar-token">
                                                        <i class="fas fa-clone"></i>
                                                    </button>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 d-flex align-center justify-evenly">
                                        <button class="btn-rounded btn-s-greenLight" id="generateToken" data-toggle="tooltip" data-placement="top" title="GENERAR TOKEN" data-i18n-tooltip="generar-token">
                                            <i class="fas fa-plus" ></i>
                                        </button> <!-- GENERATE TOKEN -->
                                    </div>
                                </div>
                            </div>
                            <table id="evidenceTable" name="evidenceTable"class="table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>tipo</th>
                                        <th>id-lote</th>
                                        <th>lote</th>
                                        <th>cliente</th>
                                        <th>fecha-apartado</th>
                                        <th>asesor</th>
                                        <th>gerente</th>
                                        <th>fecha-de-alta</th>
                                        <th>estatus</th>
                                        <th>acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('token/common_modals'); ?>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/apartado/generateToken.js"></script>
</body>