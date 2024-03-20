<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="modal_" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subir archivo de expediente.</h4>
                </div>
                <form method="post" id="form_interes">
                    <div class="modal-body">
                    </div>
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
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Historial de pagos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">PROYECTO</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">CONDOMINIO</label>
                                                <select name="condominio" id="condominio"  class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group select-is-empty">
                                                <label class="control-label">LOTE</label>
                                                <select name="lote" id="lote" class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table id="tabla_historialpagos_contraloria" name="tabla_historialpagos_contraloria" class="table-striped table-hover hide" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th>LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>NO. RECIBO</th>
                                            <th>MONTO</th>
                                            <th>CONCEPTO</th>
                                            <th>FORMA PAGO</th>
                                            <th>FECHA</th>
                                            <th>USUARIO</th>
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
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/contraloria/vista_historial_pagos_contraloria.js"></script>

