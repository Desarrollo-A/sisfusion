<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar', ""); ?>

    <div class="modal" tabindex="-1" role="dialog" id="generateTokenModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-content">
                        <div class="toolbar">
                            <h3 class="card-title center-align">Selecciona un asesor</h3>
                            <div class="row aligned-row">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group label-floating select-is-empty m-0 p-0">
                                        <select id="asesoresList" name="asesoresList"
                                                class="selectpicker select-gral m-0"
                                                data-style="btn" data-show-subtext="true"
                                                data-live-search="true"
                                                title="Selecciona un asesor" data-size="7" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="generateToken()">Generar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanSelects()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modals -->

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Generar token</h3>
                                <div class="row pt-2 row-load">
                                    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
                                        <div class="form-group d-flex">
                                            <input class="form-control generated-token" id="generatedToken"
                                                   placeholder="Token generado" readonly value="prueba text copy"/>
                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                    id="copyToken" onclick="copyToClipBoard()">
                                                <i class="fas fa-clone"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-evenly">
                                        <button class="btn-rounded btn-s-greenLight" id="generateToken"
                                                title="Generar token">
                                            <i class="fas fa-plus" title="Copiar"></i>
                                        </button> <!-- GENERATE TOKEN -->
                                    </div>
                                </div>
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="table-responsive box-table">
                                <table id="tokensTable" name="tokensTable"
                                       class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>TOKEN</th>
                                        <th>GENERADO PARA</th>
                                        <th>FECHA ALTA</th>
                                        <th>CREADO POR</th>
                                    </tr>
                                    </thead>
                                </table>
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

<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/apartado/generateToken.js"></script>

<script>
    let id_gerente = "<?=$this->session->userdata('id_usuario')?>";
    $(document).ready(function () {
        fillTokensTable();
        getAsesoresList();
    });
</script>


</body>