<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                    <h4 class="modal-title">Consulta información</h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alertas" id="modal_confirmPay" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-red">
                </div>
                <form method="post" id="form_enganche">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones pagadas por lote</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                        <table id="tabla_ingresar_9" name="tabla_ingresar_9" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID LOTE</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>REFERENCIA</th>
                                                    <th>PRECIO DEL LOTE</th>
                                                    <th>TOTAL DE LA COMISIÓN</th>
                                                    <th>ABONADO</th>
                                                    <th>PAGADO</th>
                                                    <th>CLIENTE</th>
                                                    <th>ESTATUS</th>
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
        </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/comisiones/historial_postventa.js"></script>