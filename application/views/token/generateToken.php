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
</style>

<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar', ""); ?>

    <div class="modal" tabindex="-1" role="dialog" id="generateTokenModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content boxContent">
                <div class="modal-body card no-shadow">
                    <div class="card-content">
                        <div class="toolbar">
                            <h3 class="card-title center-align">Selecciona un asesor</h3>
                            <div class="row aligned-row">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                                    <div class="form-group label-floating select-is-empty m-0 p-0">
                                        <select id="asesoresList" name="asesoresList"
                                                class="selectpicker select-gral m-0"
                                                data-style="btn" data-show-subtext="true"
                                                data-live-search="true"
                                                title="Selecciona un asesor" data-size="7" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group label-floating select-is-empty m-0 p-0">
                                        <div class="file-gph">
                                            <input class="d-none" type="file" id="fileElm">
                                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                            <label class="upload-btn m-0" for="fileElm">
                                                <span>Seleccionar</span>
                                                <i class="fas fa-folder-open"></i>
                                            </label>
                                        </div>
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
                                <div class="row pt-2 aligned-row">
                                    <div class="col-12 col-sm-11 col-md-11 col-lg-11">
                                        <div class="form-group d-flex">
                                            <span class="bckSpan w-100">
                                                <span class="subSpan w-100 d-flex">
                                                    <input class="form-control generated-token" id="generatedToken" placeholder="Aún no se ha generado ningún token" readonly/>
                                                    <button id="copyToken" onclick="copyToClipBoard()" data-toggle="popover" data-content="Se ha copiado el contenido">
                                                        <i class="fas fa-clone"></i>
                                                    </button>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col col-xs-1 col-sm-1 col-md-1 col-lg-1 d-flex align-center justify-evenly">
                                        <button class="btn-rounded btn-s-greenLight" id="generateToken" title="Generar token">
                                            <i class="fas fa-plus" title="Generar token"></i>
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
                                        <th>GENERADO PARA</th>
                                        <th>FECHA ALTA</th>
                                        <th>CREADO POR</th>
                                        <th>ESTATUS</th>
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
    let current_rol_user = "<?=$this->session->userdata('id_rol')?>";
    $(document).ready(function () {
        fillTokensTable();
        getAsesoresList();
    });

    $(document).ready(function () {
        $("input:file").on("change", function () {
            var target = $(this);
            var relatedTarget = target.siblings(".file-name");
            var fileName = target[0].files[0].name;
            relatedTarget.val(fileName);
        });
    });

</script>

</body>