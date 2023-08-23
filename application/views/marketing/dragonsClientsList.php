<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">

<style>
    #reviewTokenEvidence .close{
        padding: 7px 10px;
        background-color: #333333a1;
        color: #eaeaea;
        border-radius: 20px;
    }
</style>

<body class="">
    <div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade in" id="reviewTokenEvidence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="col-md-12">
                            <div id="img_actual">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="changelog"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-list fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Listado general de clientes Marketing Dragon</h3>
                                </div>
                                <input class="hide" id="generatedToken"/>
                                <table id="dragonsClientsTable" name="dragonsClientsTable" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID LOTE</th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>NOMBRE DEL CLIENTE</th>
                                            <th>NÚMERO DEL RECIBO</th>
                                            <th>REFERENCIA</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>ENGANCHE</th>
                                            <th>FECHA DE ENGANCHE</th>
                                            <th>FECHA DE CREACIÓN DEL PROSPECTO</th>
                                            <th>ID CRM</th>
                                            <th>ID DRAGON</th>
                                            <th>ESTATUS DEL LOTE</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>

    <?php $this->load->view('template/footer'); ?>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/marketing/dragonsClientsList.js"></script>
</body>