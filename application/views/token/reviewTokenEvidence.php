<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

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
                                <h3 class="card-title center-align">Revisión de evidencias</h3>
                            </div>
                            <div class="table-responsive box-table">
                                <input class="hide" id="generatedToken"/>
                                <table id="evidenceTable" name="evidenceTable"
                                       class="table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>TIPO</th>
                                        <th>ID LOTE</th>
                                        <th>LOTE</th>
                                        <th>CLIENTE</th>
                                        <th>FECHA APARTADO</th>
                                        <th>ASESOR</th>
                                        <th>GERENTE</th>
                                        <th>FECHA ALTA</th>
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
<?php include 'common_modals.php' ?>

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

<script src="<?= base_url() ?>dist/js/controllers/apartado/generateToken.js"></script>

<script>
    $(document).ready(function () {
        fillevidenceTable();
    });
</script>

</body>